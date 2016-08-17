<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Click extends Model {

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'clicks';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['post_id','social_network'];

  /**
   * The attributes excluded from the model's JSON form.
   *
   * @var array
   */
  protected $hidden = [];

  //Define relationships
  public function post() {
      return $this->hasOne('App\Post', 'id', 'post_id');
  }

}
