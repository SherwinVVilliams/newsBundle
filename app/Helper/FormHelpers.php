<?php
/**
 * Created by IntelliJ IDEA.
 * User: Jek
 * Date: 21.07.2016
 * Time: 15:57
 */

namespace App\Helper;


class FormHelpers{
    public static function delimiter($text){
        global $delimiter;
        $close = true;
        if(!$delimiter){
            $close = false;
            $delimiter = [1];
        }else{
            $delimiter[] = $delimiter[count($delimiter)-1] + 1;
        }



        return view('admin.form.input.delimiter', [
            'close' => $close,
            'delimiter'=> $delimiter[count($delimiter)-1],
            'text'  => $text
        ]);
    }

    public static function defaults($args, $def){
        foreach ($def as $key => $item)
            if(isset($args[$key]))
                $def[$key] = $args[$key];

        return $def;
    }
}
