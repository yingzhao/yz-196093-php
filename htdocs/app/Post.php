<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model {

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'posts';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['text', 'image', 'category_id', 'active'];

  /**
   * The attributes excluded from the model's JSON form.
   *
   * @var array
   */
  protected $hidden = [];

  //Define relationships
  public function category() {
      return $this->hasOne('App\Category', 'id', 'category_id');
  }

  public function click() {
      return $this->hasMany('App\Click', 'id', 'post_id');  
  }

}
