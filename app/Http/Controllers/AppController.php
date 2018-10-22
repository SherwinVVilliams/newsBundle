<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use Illuminate\Http\Request;

class AppController extends Controller {

	public $page_title = 'Title';
	public $page_folder = 'index';


	public function viewer( $template, array $args = [] ) {
		return view( $template, $this->extender( [
			'page_title'  => $this->page_title,
			'page_folder' => $this->page_folder
		], $args ) );
	}

	public function extender( $def, $args ) {
		foreach ( $args as $name => $arg ) {
			$def[ $name ] = $arg;
		}
		return $def;
	}



}
