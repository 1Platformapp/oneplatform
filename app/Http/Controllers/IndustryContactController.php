<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\IndustryContact;
use App\Models\IndustryContactCategory;
use App\Models\IndustryContactCategoryGroup;
use App\Models\IndustryContactCity;
use App\Models\IndustryContactRegion;

use DB;
use Auth;
use Hash;

use App\Http\Controllers\CommonMethods;
use Illuminate\Http\Request;

class IndustryContactController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function add(Request $request)
    {

    }

    public function create(Request $request)
    {

    }

    public function edit(Request $request)
    {

    }

    public function read(Request $request)
    {

    }

    public function update(Request $request)
    {

    }

    public function destroy(Request $request)
    {

    }

    public function browse(Request $request)
    {
        $success = 1;
        $error = '';

        $limit = 9;
        $page = 1;
        $where = [];
        $user = Auth::user();

        if($request->has('page') && $request->page != ''){

            $page = $this->encodeDecode('decrypt', $request->page);
        }
        if($request->has('category_filter') && $request->category_filter != ''){

            $where[] = ['category_id' , $request->category_filter];
        }
        if($request->has('city_filter') && $request->city_filter != ''){

            if($request->city_filter == 'alluk'){

                $where[] = ['country_id' , 1];
            }else if($request->city_filter == 'allusa'){

                $where[] = ['country_id' , 2];
            }else if($request->city_filter == 'allcanada'){

                $where[] = ['country_id' , 3];
            }else{

                $where[] = ['city_id' , $request->city_filter];
            }
        }

        $favsOnly = $request->has('is_fav') && $request->is_fav == '1' && is_array($user->favourite_industry_contacts) ? true : false;
        $all = $request->city_filter;

        $allIndustryContacts = $favsOnly ? IndustryContact::where($where)->whereIn('id', $user->favourite_industry_contacts)->get() : IndustryContact::where($where)->get();
        $totalRecords = count($allIndustryContacts);
        $totalPages = ceil($totalRecords/$limit);

        $offset = ($page - 1)  * $limit;
        $nextPage = min(($page + 1), $totalPages);
        $prevPage = max(($page - 1), 1);
        $currentPage = $page;
        $firstPage = '1';
        $lastPage = $totalPages;
        $pageInfoEncrypted = ['first' => $this->encodeDecode('encrypt', $firstPage), 'prev' => $this->encodeDecode('encrypt', $prevPage), 'current' => $this->encodeDecode('encrypt', $currentPage), 'next' => $this->encodeDecode('encrypt', $nextPage), 'last' => $this->encodeDecode('encrypt', $lastPage)];
        $pageInfo = ['first' => $firstPage, 'prev' => $prevPage, 'current' => $currentPage, 'next' => $nextPage, 'last' => $lastPage, 'total_pages' => $totalPages];

        $contacts = $favsOnly ? IndustryContact::where($where)->whereIn('id', $user->favourite_industry_contacts)->skip($offset)->take($limit)->get() : IndustryContact::where($where)->skip($offset)->take($limit)->get();
        $html = \View::make('parts.industry-contacts', ['contacts' => $contacts, 'pageInfo' => $pageInfo, 'pageInfoEncrypted' => $pageInfoEncrypted, 'filters' => $where])->render();

        return json_encode(['success' => $success, 'error' => $error, 'data' => $html, 'next_page' => $nextPage, 'prev_page' => $prevPage, 'current_page' => $currentPage]);
    }

    public function encodeDecode($action, $string){

        $output = false;
        $encryptMethod = "AES-256-CBC";
        $secretKey = 'b7d8f';
        $secretIV = 'd8fft6';
        $key = hash('sha256', $secretKey);
        $iv = substr(hash('sha256', $secretIV), 0, 16);

        if ($action == 'encrypt'){
            $output = openssl_encrypt($string, $encryptMethod, $key, 0, $iv);
            $output = base64_encode($output);
        }else if($action == 'decrypt'){
            $output = openssl_decrypt(base64_decode($string), $encryptMethod, $key, 0, $iv);
        }
        return $output;
    }

    public function togglefavourite(Request $request){

        $error = '';
        $success = 0;
        $response = '';

        if ($request->isMethod('post')) {

            $user = (Auth::check()) ? Auth::user() : 0;

            if ($request->has('id') && $user && $user->hasActivePaidSubscription()) {

                $id = $request->get('id');
                $contact = IndustryContact::findorFail($id);
                if($contact){

                    $userFavouriteContacts = (is_array($user->favourite_industry_contacts)) ? $user->favourite_industry_contacts : array();
                    if (($key = array_search($id, $userFavouriteContacts)) !== false) {
                        unset($userFavouriteContacts[$key]);
                        $response = 'removed';
                    }else{
                        $userFavouriteContacts[] = $id;
                        $response = 'added';
                    }
                    $user->favourite_industry_contacts = $userFavouriteContacts;
                    $success = $user->save();
                }else{
                    $error = 'Entry does not exist';
                }
            }else{
                $error = 'Bad or unauthenticated user';
            }
        }else{
            $error = 'Method not allowed';
        }

        return response()->json(['error' => $error, 'success' => $success, 'action' => $response]);
    }
}
