<?php
/**
 * Created by IntelliJ IDEA.
 * User: Jek
 * Date: 04.07.2016
 * Time: 15:34
 */

namespace App\Helper;


use App\Model\i18n;
use Illuminate\Http\Request;

class Form extends FormInputs{


    public static function repeaterOpen($name, $desc){
        global $currInput;
        global $thisIsRepeater;

        $thisIsRepeater = $name;

        return view('admin.form.repeaterStart', [
            "name"  => $name,
            "desc"  => $desc,
            'input' => $currInput,
        ]);
    }

    public static function repeaterClose($name, array $args = []){
        global $currInput;
        global $thisIsRepeater;
        $thisIsRepeater = false;

        $args = FormHelpers::defaults($args, [
            'min'   => 0,
            'max'   => 0,
        ]);

        return view('admin.form.repeaterEnd', [
            'input' => $currInput,
            'name'  => $name,
            'min'   => $args['min'],
            'max'   => $args['max'],
        ]);
    }



    public static function o($action){
        return view('admin.form.startForm', [
            "action"  => $action,
        ]);
    }

    public static function c(){
        global $delimiter;

        return view('admin.form.closeForm', ['delimiter'=> $delimiter]);
    }

    public static function langs(){
        return ['Руский' => "_ru", 'Украинский' => "_ua"];
    }



}