<?php
/**
 * Created by PhpStorm.
 * User: AxHarus
 * Date: 7/19/2017
 * Time: 14:54
 */

namespace App\Model\System;


class RootModel extends \Eloquent {
    public $choosen = false;
    public $gallery = [];
    public $int = false;
    protected $dateFormat = 'U';

    public static function fFilter($i){
        $self = new static();
        $out = [];
        foreach ($self->getFillable() as $item) {
            if(array_key_exists($item, $i)){
                if($self->choosen && in_array($item, $self->choosen)){
                    $out[$item] = array_filter(explode(',',$i[$item]));
                }elseif($self->int && in_array($item, $self->int)){
                    $out[$item] = intval($i[$item]);
                }elseif($self->gallery && in_array($item, $self->gallery)){
                    //self::galleryAttach($item, $i['id'], $i[$item]);
                }else{
                    $out[$item] = $i[$item];
                }
            }
        }
        //dd($out);
        return $out;
    }

    public function gallerySync($data){
        foreach ($this->gallery as $gallery) {
            if($data[$gallery]){
                $this->$gallery()->detach();
                foreach (json_decode($data[$gallery]) as $id) {
                    $this->$gallery()->attach($id, ['img_input' => $gallery]);
                }
            }
        }
    }
}