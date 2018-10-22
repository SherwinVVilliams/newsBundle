<?php
/**
 * Created by IntelliJ IDEA.
 * User: Jek
 * Date: 21.07.2016
 * Time: 15:42
 */

namespace App\Helper;


use App\Model\BaseModel;
use Carbon\Carbon;
use Jenssegers\Date\Date;

class Helper {

	/*--------Admin----------*/
	public static function rus2translit($text) {
		// Русский алфавит
		$rus_alphabet = ['А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й',
			'К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ц','Ч',
			'Ш','Щ','Ъ','Ы','Ь','Э','Ю','Я','а','б','в','г','д','е',
			'ё','ж','з','и','й','к','л','м','н','о','п','р','с','т',
			'у','ф','х','ц','ч','ш','щ','ъ','ы','ь','э','ю','я',' '
		];

		// Английская транслитерация
		$rus_alphabet_translit = array(
			'A','B','V','G','D','E','IO','ZH','Z','I','I','K','L','M',
			'N','O','P','R','S','T','U','F','H','C','CH','SH','SH','`',
			'Y','`','E','IU','IA','a','b','v','g','d','e','io','zh','z',
			'i','i','k','l','m','n','o','p','r','s','t','u','f','h',
			'c','ch','sh','sh','`','y','`','e','iu','ia','_'
		);

		return preg_replace("/([^A-Za-z0-9\_]+)/", '', str_replace($rus_alphabet, $rus_alphabet_translit, $text));
	}

	public static function admin() {
		return [1];
	}


	public static function isAdmin() {
		return \Auth::check() ? in_array(\Auth::user()->id, self::admin()) : false;
	}
	/*--------Admin----------*/


	/*--------Lang----------*/
	public static function i18n() {
		return ['ru', 'en'];
	}

	public static function i18n_($enable = true) {
		if ( ! $enable) {
			return [''];
		}
		$out = [];
		foreach (self::i18n() as $lang) {
			$out[] = '_'.$lang;
		}

		return $out;
	}

	public static function l($var) {
		return $var.'_'.app()->getLocale();
	}

	public static function Link($str) {
		return '/'.app()->getLocale().$str;
	}
	/*--------Lang----------*/


	/*--------Form----------*/
	public static function formFields($name, $val) {
		if (isset(self::fields()[ $name ])) {
			return self::fields()[ $name ][ $val ];
		}

		return $val;
	}

	public static function formFieldsPrint($name, $s = - 1) {
		$out = '';
		foreach (self::fields()[ $name ] as $key => $item) {
			$out .= '<option '.($s == $key ? 'selected' : '').' value="'.$key.'">'.$item.'';
		}

		return $out;
	}
	/*--------Form----------*/

	public static function active_menu($current, $need){
		if($current == $need)
		return " class=\"active_link\"";
		return '';
	}


}