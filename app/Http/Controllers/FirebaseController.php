<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Illuminate\Http\UploadedFile;

class FirebaseController extends Controller
{
    protected $database;

    public function __construct()
    {
        //$this->database = app('firebase.database');
    }

    public function test()
    {
        return view('pages.firebase');
    }

    public function uploadFile(UploadedFile $uploadedFile)
    {
        try {
            // $firebase = app('firebase.storage');
            // $storage = $firebase->getBucket();

            // $storagePath = 'audios/';
            // $filename = $uploadedFile->getClientOriginalName();

            // $upload = $storage->upload(
            //     fopen($uploadedFile->getRealPath(), 'r'),
            //     [
            //         'predefinedAcl' => 'publicRead',
            //         'name' => $storagePath . $filename,
            //     ]
            // );

            // // $publicUrl = $upload->info()['mediaLink'];

            // return $upload->info();

            $factory = (new Factory)->withServiceAccount(public_path('firebase.json'))->withDatabaseUri('https://platformrepo-3683c.firebaseio.com');
            $cloudStorage = $factory->createStorage();

            return '';

        } catch (\Exception $e) {
            dd($e->getMessage());
            // return redirect()->back()->with('error', 'error uploading. ' . $e->getMessage());
        }
    }


//     public function uploadFile(Request $request)
//     {
//         try {
//             $uploadedFile = $request->file('image');
//             // dd($uploadedFile->getClientOriginalName());
//             $firebase = app('firebase.storage');
//             $storage = $firebase->getBucket();

//             $storagePath = 'audios/';
//             $filename = $uploadedFile->getClientOriginalName();

// // dd($storage->upload(
// //     fopen($uploadedFile->getRealPath(), 'r'),
// //     [
// //         'predefinedAcl' => 'publicRead',
// //         'name' => $storagePath . $filename,
// //     ]
// // ));
//             $upload = $storage->upload(
//                 fopen($uploadedFile->getRealPath(), 'r'),
//                 [
//                     'predefinedAcl' => 'publicRead',
//                     'name' => $storagePath . $filename,
//                 ]
//             );

//             // $publicUrl = $upload->info()['mediaLink'];
// dd($upload->info());
//             // return $upload->info();
//         } catch (\Exception $e) {
//             dd($e->getMessage());
//             // return redirect()->back()->with('error', 'error uploading. ' . $e->getMessage());
//         }
//     }
}
