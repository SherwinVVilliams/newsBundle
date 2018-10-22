<?php
/**
 * Created by IntelliJ IDEA.
 * User: Jek
 * Date: 21.07.2016
 * Time: 11:23
 */

namespace App\Http\Controllers\System;


use App\Http\Controllers\AppController;
use App\Model\System\Img;
use Illuminate\Http\Request;
use App\Helper\Uploader;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadController extends AppController {
    public function gallery($folder = false, $size = ''){
        $images = Img::getFolder($folder);
        return view('admin.gallery.all', ['images' => $images, 'folder' => $folder, 'size' => $size]);
    }

    public function upload($folder, $sizes,Request $r){
    	if(isset($r->simple)){
		    $el = $r->file()['file'];
	    }else{
		    $el = array_first(array_first($r->file()));
	    }

        if($sizes != 0){
            $sizes = array_map(function($a){
                return explode('x', $a);
            }, explode(';', $sizes));
        }

        $file = Uploader::go($el, $sizes, $folder);
        $record = Img::newImg($file, $folder, 'admin',$sizes);

        return json_encode([
            'files'=>[[
            	'id'    => $record->id,
                'url' => \U::pathI($record),
                'thumbnailUrl' => \U::pathI($record),
                'name' => $record->name,
                'type' => $el->getClientMimeType(),
                'deleteUrl' => '/superuser/upload/delete?key='.$record->id,
                'deleteType' => 'DELETE'
            ]]
        ]);
    }

    public function delete(Request $r){
        $key = intval($r->input()["key"]);
        Img::remove($key);
        return json_encode(true);
    }
}

