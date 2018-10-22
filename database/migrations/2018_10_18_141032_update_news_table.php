<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        Schema::table('news', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->default(1);
            //$table->foreign('user_id')->references('id')->on('user')->onDelete('cascade');
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('news_categories');
            $table->string('image_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropForeign('news_category_id_foreign');
            $table->dropColumn('category_id');
            //$table->dropForeign('news_user_id_foreign');
            $table->dropColumn('user_id');
            $table->dropColumn('image_id');
        });
    }
}
