<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Session;
use Redirect;
use Validator;
use Input;

use App\Setting;

class SettingController extends Controller {

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    $settings = Setting::all();
    return view('admin.settings')->with('settings', $settings);
  }

  public function update()
  {

    //Validate
    $rules = array(
      'name' => 'required|string',
      'twitter_account' => 'required|string',
      'tweets_to_pull' => 'required|integer',
      'feedback_email' => 'required|string',
      'randomise' => 'required|string',
      'avatar_url' => 'required|string',
    );
    $validator = Validator::make(Input::all(), $rules);

    //Process the login
    if ($validator->fails()) {
      return Redirect::route('admin.settings.index')
        ->withErrors($validator)
        ->withInput(Input::except('password'));
    } else {

      //Store the new model
      foreach ($rules as $key => $value) {
        $setting = Setting::where('key' , '=', $key)->first();
        $setting->value = Input::get($key);
        $setting->save();        
      }

      //Redirect with a message
      Session::flash('message', 'Successfully updated settings!');
      return Redirect::route('admin.settings.index');
    }

  }


}
