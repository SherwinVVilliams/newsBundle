<?php
/**
 * Created by IntelliJ IDEA.
 * User: Jek
 * Date: 04.07.2016
 * Time: 13:52
 */

namespace App\Model\System;


use Illuminate\Database\Eloquent\ModelNotFoundException;

class BaseModel extends RootModel {

    public static function getRecord($id, $with = [], $select = ['*']){
        try{
            $self = new static();
            $data = self::where('id', $id)->select($select)->with($with)->firstOrFail();
            if($self->choosen){
                foreach ($self->choosen as $choosen) {
                    try{
                        $data->{$choosen} = implode(',', $data->{$choosen});
                    }catch (\Exception $e){}
                }
            }
            return $data;
        }catch(ModelNotFoundException $e){dd($e, 'BaseModel');}
    }

    public static function setRecord($id, $data){
        return self::updateOrCreate(['id'=>$id], self::fFilter($data));
    }

    public static function getAll($with = false){
        try{
        	$b = self::query();
        	if($with){
		        $b->with($with);
	        }
            return $b->get();
        }catch (ModelNotFoundException $e){dd($e, 'BaseModel');}
    }

    public static function remove($id){
        self::where('id', $id)->delete();
    }
}