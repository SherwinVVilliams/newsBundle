<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\AppController;

use App\Model\News;
use App\Model\NewsCategory;

class NewsController extends AppController
{
	private $paginate = 3;
    public $page_folder = 'news';
    public $page_title = 'Новости';

    public function index($alias = 'all')
    {   
    	$categories = NewsCategory::select()->limit(10)->get();
    	$news = News::select();

    	if($alias != 'all'){
    		$category = NewsCategory::where('alias', $alias)->first();
    		try{
    			$news->where('category_id', $category->id);
    		}
    		catch(\Exception $e){
    			abort(404);
    		}
    	}

    	$news = $news->paginate($this->paginate);

    	if($this->paginate > 5){
    		$news->load('category', 'image');
    	}
    	
        
    		
    	return $this->viewer('site.pages.news', [
    		'categories' => $categories,
    		'news' => $news,
    		'alias' => $alias,
    		]);
    }
    
}
