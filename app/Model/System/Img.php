<?php

namespace App\Model\System;
use App\Helper\Uploader;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Img extends BaseModel{
    protected $table = 'images';
    public $timestamps = false;
    protected $fillable = 	['name'	,'folder', 'sizes', 'user_id',  'type'];
    protected $dateFormat = 'U';


    public static function getFolder($folder = false){
        try{
            $r = self::query();

            if($folder)
                $r = $r->where('folder', $folder);
            if(!\H::isAdmin())
                $r = $r->where('user_id', \Auth::user()->id);

            return $r->get();
        }catch (\Exception $e){
            dd('Img -> get', $e);
        }
    }

    public static function getImg($id){
    	try{
    		return self::where('id', $id)->firstOrFail();
	    }catch (\Exception $e){
		    return null;
	    }
    }

    public static function newImg($name, $folder, $type,  $sizes){
        $user_id = \Auth::user()->id;
        return self::create([
            'name' => $name,
            'folder' => $folder,
            'sizes' => json_encode($sizes),
            'user_id' => $user_id,
	        'type'  => $type
        ]);
    }

    public static function remove($id){
        try{
            $r = self::where("id", $id);
            if(!\H::isAdmin()){
                $r = $r->where('user_id', \Auth::user()->id);
            }
            $r = $r->firstOrFail();
            Uploader::del($r);
            $r->delete();
        }catch (ModelNotFoundException $e){
            dd('Img -> Delete', $e);
        }
    }
    public static function updateByArray($data, $folder){
    	if(!$data) $data = [];
    	try{

    		$gallery = self::where('user_id', \Auth::user()->id)
			    ->where('folder', $folder)
			    ->whereNotIn('id', $data)->get();

		    foreach ( $gallery as $img ) {
			    Uploader::del($img);
			    $img->delete();
    		}
	    }catch (\Exception $p){
    		dd('Error: updateByArray');
	    }
    }

    public static function validName($fullName, $extention){
        $name = \H::rus2translit(str_replace('.'.$extention, '', $fullName));
        $t_name = $name; $i = 2;
        while(self::where('name', $name.'.'.$extention)->count() > 0){
            $name = $t_name.'_'.$i++;
        }
        return $name.'.'.$extention;
    }


}