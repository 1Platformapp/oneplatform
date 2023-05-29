<?php
    namespace App\Http\Controllers;


    use App\Models\Studio;
    use App\Models\UserAlbum;
    use App\Models\UserProduct;
    use App\Models\UserMusic;
    use DB;
    use Auth;
    use App\Models\User;
    use App\Models\UserCampaign;
    use App\Models\Genre;
    use Image;
    use Mail;
    use Illuminate\Http\Request;
    use App\Models\CompetitionVideo;
    use Illuminate\Support\Facades\Redirect;
    use Illuminate\Support\Facades\Validator;
    use Session;


    use App\Http\Controllers\CommonMethods;

    /**

     * Class SearchController

     * @package App\Http\Controllers

     */

    class SearchController extends Controller
    {

        public function __construct(){

            $this->middleware('user.update.activity');
        }

        public function index(Request $request)
        {
            $commonMethods = new CommonMethods();

            if(Auth::check()){

                $user = Auth::user();
                $userCampaign = $user->campaigns()->where('status', 'active')->orderBy('id', 'desc')->first();
                $userCampaignDetails = $commonMethods::getUserRealCampaignDetails($user->id, $userCampaign->id);
                $allPastProjects = userCampaign::where('user_id', $user->id)->where('status', 'inactive')->orderBy('id', 'desc')->get();
            }

            $showSearchResults = $showArtistSearchResults = 0;

            if($request->isMethod('post') && isset($request->bpm)) {

                $showSearchResults = 1;

                $searchFilters['genres'] = $request->genre;
                $searchFilters['moods'] = $request->mood;
                $searchFilters['bpm_range'] = explode(';', $request->bpm);
                $searchFilters['instruments'] = $request->instrument;

                if(is_array($searchFilters['bpm_range']) && count($searchFilters['bpm_range']) == 2 && $searchFilters['bpm_range'][0] == 0 && $searchFilters['bpm_range'][1] == 250){
                    $searchFilters['bpm_range'] = array();
                }

                $musicResults = SearchController::getResults('music', $searchFilters);

                if(is_array($searchFilters['genres']) && count($searchFilters['genres'])){
                    foreach ($searchFilters['genres'] as $key4 => $searchGenre) {
                        $genre = Genre::find($searchGenre);
                        if($genre){
                            $searchFilters['genres'][$key4] = $genre->name;
                        }
                    }
                }

            }

            if($request->isMethod('post') && isset($request->artists_search)) {

                $showArtistSearchResults = 1;
                $searchFilters['artist'] = $request->artists_search;

                $artistResults = SearchController::getResults('artist', $searchFilters);
            }

            if ($request->session()->has('remember_music_search_filters')) {

                $showSearchResults = 1;
                $searchFilters = json_decode($request->session()->get('remember_music_search_filters'), True);
                $request->session()->forget('remember_music_search_filters');
                $musicResults = SearchController::getResults('music', $searchFilters);
            }

            $genres = Genre::all();
            $instruments = DB::table('music_instrument')->orderBy('id', 'asc')->get();
            
            $data = [

                'show_search_results' => $showSearchResults,
                'show_artist_search_results' => $showArtistSearchResults,
                'music_search_results' => isset($musicResults) ? $musicResults : null, 
                'artist_search_results' => isset($artistResults) ? $artistResults : null, 
                'search_filters' => isset($searchFilters) ? $searchFilters : null,
                'commonMethods' => $commonMethods,
                'genres' => $genres,
                'instruments' => $instruments,
                'userCampaignDetails' => (isset($userCampaignDetails)) ? $userCampaignDetails : null,
                'allPastProjects' => (isset($allPastProjects)) ? $allPastProjects : null,
            ];

            return view( 'pages.search', $data );
        }

        public function getResults($searchType, $searchFilters)
        {

            if($searchType == 'music'){

                $genres = $searchFilters['genres'];
                $moods = $searchFilters['moods'];
                $bpmRange = $searchFilters['bpm_range'];
                $instruments = $searchFilters['instruments'];

                $musicQuery = UserMusic::orderBy('id', 'desc');

                if(is_array($genres) && count($genres)){
                    $musicQuery = $musicQuery->whereHas('genre', function ($musicQuery) use ($genres) {
                        foreach ($genres as $key => $genreId) {
                            if($key == 0)
                                $musicQuery->where('name', Genre::find($genreId)->name);
                            else
                                $musicQuery->orWhere('name', Genre::find($genreId)->name);
                        }
                    });
                }
                if(is_array($moods) && count($moods)){
                    $musicQuery = $musicQuery->where(function ($musicQuery) use ($moods) {
                        foreach ($moods as $key => $mood) {
                            if($key == 0){
                                $musicQuery->where('dropdown_two', $mood);
                                $musicQuery->orWhere('more_moods', 'like', '%'.$mood.'%');
                            }
                            else{
                                $musicQuery->orWhere('dropdown_two', $mood);
                                $musicQuery->orWhere('more_moods', 'like', '%'.$mood.'%');
                            }
                        }
                    });
                }
                if(is_array($bpmRange) && count($bpmRange) == 2){

                    if($bpmRange[1] == 250){
                        $musicQuery = $musicQuery->where('bpm' , '>=', $bpmRange[0]);
                    }else{
                        $musicQuery = $musicQuery->where('bpm' , '>=', $bpmRange[0])->where('bpm' , '<=', $bpmRange[1]);
                    }
                }
                if(is_array($instruments) && count($instruments)){

                    $musicQuery = $musicQuery->where(function ($musicQuery) use ($instruments) {
                        foreach ($instruments as $key => $instrument) {
                            if($key == 0)
                                $musicQuery->where('instruments', 'like', '%'.$instrument.'%');
                            else
                                $musicQuery->orWhere('instruments', 'like', '%'.$instrument.'%');
                        }
                    });
                }

                $resGet = $musicQuery->get()->filter(function ($music) {
                    return (!$music->privacy || count($music->privacy) == 0 || !isset($music->privacy['status']) || $music->privacy['status'] == 0) && $music->user && $music->user->isSearchable() == 1;
                });

                return $resGet;
            }
            if($searchType == 'artist'){

                $artist = $searchFilters['artist'];

                $artistQuery = User::where('name', 'like', '%'.$artist.'%')->orWhere('email', 'like', '%'.$artist.'%')->orderBy('name', 'asc')->get()->filter(function ($user) {
                    return $user->isSearchable() == 1;
                });

                return $artistQuery;
            }
        }

    }

    



