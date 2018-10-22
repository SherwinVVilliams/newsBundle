<?php
/**
 * Created by PhpStorm.
 * User: AxHarus
 * Date: 7/19/2017
 * Time: 12:00
 */

namespace App\Http\Controllers\System;


use App\Http\Controllers\Controller as BaseController;
use App\Model\System\BaseModel_i18n;
use App\Model\System\RootModel;
use Illuminate\Http\Request;
use Session;

class BREAD extends BaseController {
	private $model;
	public $folder;
	public $checkbox = [];
	public $choosen = [];
	public $page_name = 'Новая страница';

	function __construct(RootModel $m) {
		$this->model = $m;
	}

	/**
	 * @param bool $data
	 * @param array $args
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function All($data = false, array $args = []) {
		if ( ! $data) {
			$data = $this->model->getAll();
		}

		return view('admin.'.$this->folder.'.list', self::extend([
			'data'      => $data,
			'folder'    => $this->folder,
			'page_name' => $this->page_name
		], $args));
	}

	public function Edit($id, array $args = []) {
		global $currInput;
		if ($id != 0) {
			$currInput = $this->model->getRecord($id)->toArray();
		}

		//$id = $this->model->orderBy('id', 'desc')->first()->id + 1;

		return view('admin.'.$this->folder.'.edit', self::extend([
			'folder'    => $this->folder,
			'page_name' => $this->page_name,
			'id' => $id,
		], $args));
	}

	public function Save($redirect = true,Request $r) {

		$i = $r->input();
		foreach ($this->checkbox as $check) {
			if ( ! isset($i[ $check ])) {
				$i[ $check ] = 0;
			} else {
				$i[ $check ] = 1;
			}
		}

		foreach ($this->choosen as $coos) {
			if (isset($i[ $coos ])) {
				$i[ $coos ] = intval($i[ $coos]);
			}
		}

		$r = $this->model->setRecord($i['id'], $i);


		if ($redirect)
		return redirect('/superuser/'.$this->folder.'/');

		return $r;
	}


	public function Delete($id) {
		$this->model->remove($id);
		return redirect()->back();
	}

	public static function extend($default, $args) {
		foreach ($args as $name => $arg) {
			$default[ $name ] = $arg;
		}

		return $default;
	}
}