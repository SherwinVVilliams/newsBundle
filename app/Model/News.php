<?php

namespace App\Model;

use App\Model\System\BaseModel;

class News extends BaseModel
{
    protected $table = 'news';

    protected $fillable = ['title', 'text', 'desc', 'discount', 'category_id', 'image_id'];

    public function getDateFormat()
    {
         return 'Y-m-d H:i:s';
    }

    public function category(){
    	return $this->belongsTo('App\Model\NewsCategory');
    }

}
