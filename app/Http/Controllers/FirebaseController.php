<?php

/*namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Area;
use Datatables;*/

namespace App\Http\Controllers;

use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Database;

use Illuminate\Http\Request;
use App\Models\Area;
use Datatables;
class FirebaseController extends Controller
{
    public function index(){
        $serviceAccount = ServiceAccount::fromJsonFile(base_path().'/public/firebase/bungkuskawkaw-ea7fb-firebase-adminsdk-0rxsi-62163c5d27.json');
        $firebase = (new Factory)
        ->withServiceAccount($serviceAccount)
        ->withDatabaseUri('https://bungkuskawkaw-ea7fb.firebaseio.com/')
        ->create();
        $database = $firebase->getDatabase();

        //DELETE DB
        //$database->getReference('qr_codes')->remove();

        $uid = '-Lk_SkNrAojWJ3Q5Gmw2';
        $postData = [
            'qr_code' => 'DSBKHB8987HJg668JHVJGF',
            'type' => 2,
            'user_id' => 3,
            'status' => 2
        ];
        // Create a key for a new post
        /*$newPostKey = $database->getReference('qr_codes')->push()->getKey();
        $updates = [
        'qr_codes/'.$newPostKey => $postData,
        'user-posts/'.$uid.'/'.$newPostKey => $postData,
        ];
        $db->getReference() // this is the root reference
        ->update($updates);*/

        /*$homer = $database->getReference('qr_codes');
        //print_r($homer);
        $homer->set(['status' => 0, 'user_id' => 24]);
        // Ooops, wrong email address
        echo $postKey = $homer->getKey();
        $homer->update(['qr_code' => 'QWERTY']);*/

        $newPost = $database
        ->getReference('qr_codes')
        ->push([
            'qr_code' => 'QWERTY',
            'type' => 1,
            'user_id' => 2,
            'status' => 1
        ]);
        echo $newPost->getKey(); // => -KVr5eu8gcTv7_AHb-3-
        //echo $newPost->getUri(); // => https://my-project.firebaseio.com/blog/posts/-KVr5eu8gcTv7_AHb-3-
        //$newPost->getChild('status')->set(2);
        //$newPost->getValue(); // Fetches the data from the realtime database
        //$newPost->remove();
        echo"<pre>";
        print_r($newPost->getvalue());
    }
    public function insert(){
        $serviceAccount = ServiceAccount::fromJsonFile(base_path().'/public/firebase/bungkuskawkaw-ea7fb-firebase-adminsdk-0rxsi-62163c5d27.json');
        $firebase = (new Factory)
        ->withServiceAccount($serviceAccount)
        ->withDatabaseUri('https://bungkuskawkaw-ea7fb.firebaseio.com/')
        ->create();
        $database = $firebase->getDatabase();

        //DELETE DB
        //$database->getReference('qr_codes')->remove();

        $newPost = $database
        ->getReference('qr_codes')
        ->push([
            'qr_code' => 'QWERTY123',
            'type' => 1,
            'user_id' => 2,
            'status' => 1
        ]);
        echo $newPost->getKey(); // => -KVr5eu8gcTv7_AHb-3-
        //echo $newPost->getUri(); // => https://my-project.firebaseio.com/blog/posts/-KVr5eu8gcTv7_AHb-3-
        //$newPost->getChild('status')->set(2);
        //$newPost->getValue(); // Fetches the data from the realtime database
        //$newPost->remove();
        echo"<pre>";
        print_r($newPost->getvalue());
    }
    public function update(){
        $serviceAccount = ServiceAccount::fromJsonFile(base_path().'/public/firebase/bungkuskawkaw-ea7fb-firebase-adminsdk-0rxsi-62163c5d27.json');
        $firebase = (new Factory)
        ->withServiceAccount($serviceAccount)
        ->withDatabaseUri('https://bungkuskawkaw-ea7fb.firebaseio.com/')
        ->create();
        $database = $firebase->getDatabase();


        //$data = array('users' => array('1' => 'David'));
        //$this->database->getReference()->update($data);
       // $database->getReference('qr_codes')->update(array('qr_code' => 'QWERTY1234'));
        $reference = $database->getReference('qr_codes')->getChild('-Lk_wcvn0P9GnKDB0K6J')->update(array('qr_code' => 'QWERTY123aaaa','type'=>2));
    }
    public function delete(){
        $serviceAccount = ServiceAccount::fromJsonFile(base_path().'/public/firebase/bungkuskawkaw-ea7fb-firebase-adminsdk-0rxsi-62163c5d27.json');
        $firebase = (new Factory)
        ->withServiceAccount($serviceAccount)
        ->withDatabaseUri('https://bungkuskawkaw-ea7fb.firebaseio.com/')
        ->create();
        $database = $firebase->getDatabase();

        $reference = $database->getReference('qr_codes')->getChild('-Lk_wcvn0P9GnKDB0K6J')->remove();
    }
}