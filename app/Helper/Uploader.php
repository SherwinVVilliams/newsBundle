<?php
namespace App\Helper;
use App\Model\System\Img;
use Image;

class Uploader{
	public static function go($file, $sizes, $dir = ""){
	    $base_dir = $dir;
        $dir = self::dir(true).($dir?$dir.'/':'');
		if ($file->isValid() &&
            (strtolower($file->getClientOriginalExtension()) == "jpg" ||
                strtolower($file->getClientOriginalExtension()) == "png" ||
                strtolower($file->getClientOriginalExtension()) == "jpeg")) {

            $name = Img::validName($file->getClientOriginalName(), $file->getClientOriginalExtension());

			$file->move(base_path().$dir, $name);

            if($sizes){
                for($i = 0; $i < count($sizes); $i++){
                    $img = Image::make(base_path().$dir.$name);
                    if($sizes[$i][0] || $sizes[$i][1]){
                        $img->fit($sizes[$i][0] == 0 ? null : $sizes[$i][0], $sizes[$i][1] == 0 ? null : $sizes[$i][1], function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    }
                    if (!file_exists(base_path().$dir.$sizes[$i][0]."x".$sizes[$i][1])) {
                        mkdir(base_path().$dir.$sizes[$i][0]."x".$sizes[$i][1], 0777, true);
                    }
                    $img->save(base_path().$dir.$sizes[$i][0]."x".$sizes[$i][1].'/'.$name, 90);
                }
            }else{
                $img = Image::make(base_path().$dir.$name);
                $img->save(base_path().$dir.$name, 90);
            }
            return $name;
		}else{
			return false;
		}
	}


    public static function del(Img $file, $dir = false){
        $dir = $dir ? $dir : base_path().self::dir(true).($file->folder ? $file->folder.'/' : '');
        //dd($dir);
        foreach( glob( $dir."*" ) as $filename )
            if(is_dir($filename))
                self::del($file, $filename.'/');

        foreach( glob( $dir.$file->name ) as $filename ){
	        unlink($filename);
        }

    }

    public static function dir($php = false){
        return  ($php ? '/public' : '')."/image/";
    }

    public static function path($v, $pre = ""){
        $pre = $pre ? $pre.'/' : "";
        if($a = json_decode($v))
            return url(self::dir().$pre.$a[0]);
        return url(self::dir().$pre.$v);
    }

    public static function pathI(Img $obj, $size = ''){
	    $pre = $obj->folder ? $obj->folder.($size ? '/'.$size : '').'/' : "";

	    return url(self::dir().$pre.$obj->name);
    }

	public static function pathID($id, $size = ''){
    	$obj = Img::getRecord($id);
		$pre = $obj->folder ? $obj->folder.($size ? '/'.$size : '').'/' : "";

		return url(self::dir().$pre.$obj->name);
	}

}