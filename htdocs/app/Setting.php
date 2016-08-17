<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model {

  public $timestamps = false;

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'settings';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['name', 'description', 'type', 'key', 'value'];

  /**
   * The attributes excluded from the model's JSON form.
   *
   * @var array
   */
  protected $hidden = [];

}
