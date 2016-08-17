<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {

  public $timestamps = false;

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'categories';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['name', 'colour'];

  /**
   * The attributes excluded from the model's JSON form.
   *
   * @var array
   */
  protected $hidden = [];

  //Define relationships
  public function post() {
      return $this->hasMany('App\Post');
  }

  public function postCount()
  {
    return $this->hasOne('App\Post')
      ->selectRaw('category_id, count(*) as aggregate')
      ->groupBy('category_id');
  }

}
