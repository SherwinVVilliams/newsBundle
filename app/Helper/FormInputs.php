<?php
/**
 * Created by IntelliJ IDEA.
 * User: Jek
 * Date: 21.07.2016
 * Time: 16:14
 */

namespace App\Helper;


use App\Model\System\Img;

class FormInputs extends FormHelpers {
	public static function input($name, $desc, array $args = []) {
		global $currInput;
		global $thisIsRepeater;

		$args = FormHelpers::defaults($args, [
			'require' => false,
			'type'    => 'text',
			'disable' => false,
			'lang'    => false
		]);

		return view('admin.form.input.inp', [
			"name"        => $name,
			"desc"        => $desc,
			"placeholder" => $desc,
			'input'       => $thisIsRepeater ? null : $currInput,
			'type'        => $args['type'],
			'disable'     => $args['disable'],
			'require'     => $args['require'],
			'repeater'    => $thisIsRepeater,
			'lang'        => $args['lang']
		]);
	}

	public static function select($name, $desc, array $args = []) {
		global $currInput;
		global $thisIsRepeater;

		$args = FormHelpers::defaults($args, [
			'require' => false,
			'data'    => [],
			'disable' => false,
			'lang'    => false
		]);

		return view('admin.form.input.select', [
			"name"        => $name,
			"desc"        => $desc,
			"placeholder" => $desc,
			'input'       => $thisIsRepeater ? null : $currInput,
			'data'        => $args['data'],
			'disable'     => $args['disable'],
			'require'     => $args['require'],
			'repeater'    => $thisIsRepeater,
		]);
	}

	public static function date($name, $desc, array $args = []) {
		global $currInput;

		$args = FormHelpers::defaults($args, [
			'require'   => false,
			'format'    => "DD.MM.YYYY",
			'timestamp' => false
		]);

		$value = isset($currInput) && isset($currInput[ $name ]) ? $currInput[ $name ] : "";
		if ($args['timestamp'] && $value) {
			$value = \Date::createFromTimestamp($value)->format($args['timestamp']);
		}

		return view('admin.form.input.date', [
			"name"        => $name,
			"desc"        => $desc,
			"placeholder" => $desc,
			'input'       => $value,
			'format'      => $args['format'],
			'require'     => $args['require']
		]);
	}

	public static function chosen($name, $desc, $table, array $args = []) {
		global $currInput;
		global $thisIsRepeater;

		$args = FormHelpers::defaults($args, [
			'require' => false,
			'var'     => "title",
			'max'     => false,
			'where'   => false,
			'order'   => false
		]);
		
		if (isset($currInput) && isset($currInput[ $name ])) {
			try {
				$currInput[ $name ] = explode(',', $currInput[ $name ]);
			} catch (\Exception $e) {
				dd($currInput, $e);
			}
		}

		if (gettype($table) == 'string') {
			$data = \DB::table($table);
			if ($args['where']) {
				$data = $data->where($args['where'][0], $args['where'][1]);
			}
			//TODO: change to multilanguage

			if ($args['order']) {
				$data->orderBy($args['order']);
			}

			$data = $data->get();
		} else {
			$data = $table;
		}


		return view('admin.form.input.chosen', [
			"name"    => $name,
			"desc"    => $desc,
			'input'   => $thisIsRepeater ? null : $currInput,
			'data'    => $data,
			'var'     => $args['var'],
			'max'     => $args['max'],
			'require' => $args['require'],
			'repeater'    => $thisIsRepeater,
		]);
	}

	public static function image($name, $desc, array $args = []) {
		global $currInput;
		global $thisIsRepeater;

		//dd($thisIsRepeater." ---OTHER---  ".$currInput);
		/*if($thisIsRepeater){
			$currInput[$thisIsRepeater] = json_decode($currInput[$thisIsRepeater], true);
			foreach ($currInput[$thisIsRepeater] as $i => $data) {
				$currInput[$thisIsRepeater][$i][$name] = json_decode($currInput[$thisIsRepeater][$i][$name]);
				foreach ($currInput[$thisIsRepeater][$i][$name] as $key => $item) {
					$currInput[$thisIsRepeater][$i][$name][$key] =
						view('admin.form.input.image_template', ['img' => Img::getImg($item)])->render();
				}
			}
			$currInput[$thisIsRepeater] = json_encode($currInput[$thisIsRepeater]);
		}*/

		if (isset($currInput[ $name ])) {
			$images = [];
			foreach (json_decode($currInput[ $name ]) as $key => $image) {
				$data = Img::getImg($image);
				if ($data) {
					$images[ $key ] = $data;
				}
			}
			$currInput[ $name ] = $images;
		}


		$args = FormHelpers::defaults($args, [
			'size'    => '',
			'folder'  => '',
			'max'     => 1,
			'require' => false
		]);

		return view('admin.form.input.image', [
			"name"    => $name,
			"desc"    => $desc,
			'input'   => $thisIsRepeater ? null : $currInput,
			"size"    => $args['size'],
			"folder"  => $args['folder'],
			"rep"     => $thisIsRepeater,
			"max"     => $args['max'],
			'require' => $args['require']
		]);
	}

	public static function textarea($name, $desc, array $args = []) {
		global $currInput;
		global $thisIsRepeater;

		$args = FormHelpers::defaults($args, [
			'lang'    => false,
			'require' => false
		]);

		return view('admin.form.input.text', [
			"name"        => $name,
			"desc"        => $desc,
			"placeholder" => $desc,
			'input'       => $thisIsRepeater ? null : $currInput,
			'require'     => $args['require'],
			'lang'        => $args['lang']
		]);
	}

	public static function wys($name, $desc, array $args = []) {
		global $currInput;
		global $thisIsRepeater;

		$args = FormHelpers::defaults($args, [
			'require' => false,
			'lang'    => false,
		]);

		return view('admin.form.input.wys', [
			"name"        => $name,
			"desc"        => $desc,
			"placeholder" => $desc,
			'input'       => $thisIsRepeater ? null : $currInput,
			'repeat'      => $thisIsRepeater,
			'require'     => $args['require'],
			'lang'        => $args['lang']
		]);
	}

	public static function hide($name, $val = false) {
		global $currInput;
		global $thisIsRepeater;
		if ($val) {
			$currInput[ $name ] = $val;
		}

		return view('admin.form.input.hidden', [
			"name"  => $name,
			'input' => $thisIsRepeater ? null : $currInput
		]);
	}
}