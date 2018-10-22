<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\System\BREAD;

use App\Model\News;


class NewsController extends BREAD
{
    public $folder = 'news';
    public $page_name = 'Новости';
    public $checkbox = [];
    public $choosen = ['category_id'];

    function __construct() {
        parent::__construct(new News());
    }
}
