<?php

namespace App\Model;
use App\Model\System\BaseModel;
use App\Model\System\Img;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Config extends BaseModel{
    protected $table = 'config';
    public $timestamps = false;
    protected $fillable = 	[	'name'	,'value'];
//    protected $dateFormat = 'U';
    public $gallery = ['gallery'];


    public static function val($configName, $lang = false){
        global $allConfig;

        if($lang) $configName .= "_".app()->getLocale();
        if(!$allConfig){
            $allConfig = self::getAll()->toArray();
        }
        $key = array_search($configName, array_column($allConfig, 'name'));
        if($key || $key === 0){
            return $allConfig[$key]["value"];
        }
        return false;
    }

    public static function setVal($val){
        foreach ($val as $name =>  $item) {
            try{
                $data = self::where('name', $name)->firstOrFail();
                    $data->value = $item;
                $data->save();
            }catch(ModelNotFoundException $e){
                $data = self::create([
                    'name'  => $name,
                    'value' => $item
                ]);
            }
        }
    }


}