<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
    Schema::create('posts', function(Blueprint $table)
    {
      $table->increments('id');
      $table->string('text');
      $table->string('image')->nullable();
      $table->integer('category_id')->unsigned();
      $table->string('active');
      $table->timestamps();
    });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('posts');
	}

}
