<?php

namespace App\Http\Controllers;

use App\Models\CrowdfundBasket;
use App\Models\CustomerBasket;
use App\Models\CampaignPerks as CampaignPerk;
use App\Models\EmbedCode;
use App\Models\UserCampaign as UserCampaign;
use App\Models\Profile;
use App\Models\UserAlbum;
use App\Models\UserMusic;
use App\Models\UserProduct;
use App\Models\StripeCheckout;
use App\Models\StripeSubscription;
use App\Models\City;
use App\Models\Country;
use App\Models\Competition;
use App\Models\CompetitionVideo;
use App\Models\VideoStream;
use App\Models\User;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CommonMethods;

use DB;
use Auth;
use Session;
use Storage;

class GoogleDriveStorage extends Controller

{
    protected $firebase;

    public function __construct(FirebaseController $firebase)
    {
        $this->firebase = $firebase;
    }

    public function listFiles(Request $request)
    {

        $dir = '/';
        $recursive = false; // Get subdirectories also?
        $contents = collect(Storage::cloud()->listContents($dir, $recursive));

        return $contents->where('type', '=', 'file'); // files
    }

    public function uploadFileAsStream(Request $request)
    {

        $success = 0;
        $error = '';
        $decFName = '';

        if(Auth::check() && $request->hasFile('mu_down_file') && $request->has('mu_down_id') && $request->has('type')){

        	$extension = $this->getFileExtension($_FILES["mu_down_file"]['name']);

        	if($extension == 'wav'){

        		$musicId = $request->get('mu_down_id');
        		$itemType = $request->get('type');
        		$music = UserMusic::find($musicId);

        		if($music && $music->user->id == Auth::user()->id){

                    $decFName = 'user-music-'.uniqid().'.mp3';
                    if(strpos($itemType, 'loop') !== false){
                        $decFDir = 'loops/';
                    }else if(strpos($itemType, 'stem') !== false){
                        $decFDir = 'stems/';
                    }else{
                        $decFDir = '';
                    }

                    $mp3 = shell_exec(Config('constants.ffmpeg_path').' -i '.$_FILES['mu_down_file']['tmp_name'].' '.Config('constants.ffmpeg_decoded_path').$decFDir.$decFName.' 2>&1');

        		    $dir = $request->has('dir') ? $request->get('dir') : '/';
        		    $recursive = false;
        		    $filename = 'cloud_'.$itemType.'_'.$music->id.'_'.str_slug($music->user->name, '_');

        		    $file = $request->file('mu_down_file');
        		    $filePath = $file;


                    $contents = $this->firebase->uploadFile($file);

        		    // Storage::cloud()->put($filename, fopen($filePath, 'r+'));


        		    // $contents = collect(Storage::cloud()->listContents($dir, $recursive));

        		    $fileData['size'] = $contents['size'];
                    $fileData['filename'] = $decFName;
                    $fileData['mimetype'] = $contents['contentType'];
                    $fileData['type'] = 'file';
                    $fileData['path'] = $contents['mediaLink'];

                    $music->addDownloadItem($fileData, $itemType, 'firebase', $decFName);

        		    $success = 1;
        		}else{
        		    $error = 'No music found';
        		}
        	}else{
        		$error = 'Only wav file is allowed';
        	}
        }else{
            $error = 'Request missing required data or authentication';
        }

        return json_encode(['success' => $success, 'error' => $error, 'music_mp3' => $decFName]);
    }

    public function downloadFileAsStream($filePath, $musicId = null)
    {
        if($filePath && $musicId){

            $music = UserMusic::find($musicId);
            $dir = '/';
            $recursive = false;
            $contents = collect(Storage::cloud()->listContents($dir, $recursive));

            $file = $contents
                ->where('type', '=', 'file')
                ->where('path', '=', $filePath)
                ->first();

            //return $file; exit;

            $extensions = [
                'application/x-rar'            => 'rar',
                'application/rar'              => 'rar',
                'application/x-rar-compressed' => 'rar',
                'application/zip'              => 'zip',
                'application/x-compressed'     => '7zip',
                'audio/x-wav'                  => 'wav',
                'audio/wav'                    => 'wav',
                'audio/mp3'                    => 'mp3',
                'text/plain'                   => 'txt',
                'audio/mpeg'                   => 'mp3',
                'image/png'                    => 'png',
                'image/jpeg'                   => 'jpg',
                'image/jpg'                    => 'jpg',
            ];

            $type = '';
            $musicArray = $music->downloads;
            foreach ($musicArray as $key => $item) {
                if($item['filename'] == $file['filename']){
                    $type = $item['itemtype'];
                }
            }

            if($type != ''){

                $explode = explode('_', $type);
                $explode[0] = $explode[0] == 'main' ? '' : ucfirst(str_replace('_', ' ', $type)).' - ';

                $readStream = Storage::cloud()->getDriver()->readStream($file['path']);
                $filename = $explode[0].trim($music->song_name).' - '.trim($music->user->name).' - 1Platform TV.'.$extensions[$file['mimetype']];

                return response()->stream(function () use ($readStream) {
                    fpassthru($readStream);
                }, 200, [
                    'Content-Type' => $file['mimetype'],
                    'Content-disposition' => 'attachment; filename="'.$filename.'"',
                ]);
            }else{
                $error = 'File not found';
            }
        }else{
            $error = 'Missing required data';
        }

        return $error;
    }

    public function uploadFile(Request $request)
    {
        $filename = 'finalimage.zip';
        $filePath = public_path($filename);
        $fileData = File::get($filePath);

        Storage::cloud()->put($filename, $fileData);
        return 'File was saved to Google Drive';
    }

    public function downloadFile(Request $request)
    {
        $filename = 'test.txt';

        $dir = '/';
        $recursive = false; // Get subdirectories also?
        $contents = collect(Storage::cloud()->listContents($dir, $recursive));

        $file = $contents
            ->where('type', '=', 'file')
            ->where('filename', '=', pathinfo($filename, PATHINFO_FILENAME))
            ->where('extension', '=', pathinfo($filename, PATHINFO_EXTENSION))
            ->first(); // there can be duplicate file names!

        //return $file; // array with file info

        $rawData = Storage::cloud()->get($file['path']);

        return response($rawData, 200)
            ->header('ContentType', $file['mimetype'])
            ->header('Content-Disposition', "attachment; filename=$filename");
    }

    public function deleteFile(Request $request)
    {
        $filename = 'Capture.JPG';

        // Now find that file and use its ID (path) to delete it
        $dir = '/';
        $recursive = false; // Get subdirectories also?
        $contents = collect(Storage::cloud()->listContents($dir, $recursive));

        $file = $contents
            ->where('type', '=', 'file')
            ->where('filename', '=', pathinfo($filename, PATHINFO_FILENAME))
            ->where('extension', '=', pathinfo($filename, PATHINFO_EXTENSION))
            ->first(); // there can be duplicate file names!

        Storage::cloud()->delete($file['path']);

        return 'File was deleted from Google Drive';
    }

    public function listFolders()
    {
        $dir = '/';
        $recursive = false; // Get subdirectories also?
        $contents = collect(Storage::cloud()->listContents($dir, $recursive));

        //return $contents->where('type', '=', 'dir'); // directories
        return $contents->where('type', '=', 'dir'); // files
    }

    public function createFolder($dir)
    {
        try{
            Storage::cloud()->makeDirectory($dir);
            return true;
        }catch (Exception $e) {
            return false;
        }
    }

    public function deleteFolder(Request $request)
    {
        $directoryName = 'Test';

        // Now find that directory and use its ID (path) to delete it
        $dir = '/';
        $recursive = false; // Get subdirectories also?
        $contents = collect(Storage::cloud()->listContents($dir, $recursive));

        $directory = $contents
            ->where('type', '=', 'dir')
            ->where('filename', '=', $directoryName)
            ->first(); // there can be duplicate file names!

        Storage::cloud()->deleteDirectory($directory['path']);

        return 'Directory was deleted from Google Drive';
    }

    public function renameFolder(Request $request)
    {
        $directoryName = 'Test';

        // Now find that directory and use its ID (path) to rename it
        $dir = '/';
        $recursive = false; // Get subdirectories also?
        $contents = collect(Storage::cloud()->listContents($dir, $recursive));

        $directory = $contents
            ->where('type', '=', 'dir')
            ->where('filename', '=', $directoryName)
            ->first(); // there can be duplicate file names!

        Storage::cloud()->move($directory['path'], 'new-test');

        return 'Directory was renamed in Google Drive';
    }

    public function listFolderContents(Request $request)
    {
        $folder = 'Test';

        // Get root directory contents...
        $contents = collect(Storage::cloud()->listContents('/', false));

        // Find the folder you are looking for...
        $dir = $contents->where('type', '=', 'dir')
            ->where('filename', '=', $folder)
            ->first(); // There could be duplicate directory names!

        if ( ! $dir) {
            return 'No such folder!';
        }

        // Get the files inside the folder...
        $files = collect(Storage::cloud()->listContents($dir['path'], false))
            ->where('type', '=', 'file');

        return $files->mapWithKeys(function($file) {
            $filename = $file['filename'].'.'.$file['extension'];
            $path = $file['path'];

            // Use the path to download each file via a generated link..
            // Storage::cloud()->get($file['path']);

            return [$filename => $path];
        });
    }

    public function getFileExtension($fileName){

        $fileDetails = explode('.',$fileName);
        return end($fileDetails);
    }

}

