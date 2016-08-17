<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use View;
use Session;
use Response;
use Redirect;
use Validator;
use Input;
use Hash;

use App\App;
use App\Setting;
use App\User;

class UserController extends Controller {

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    $users = User::all();
    return view('admin.user.index')->with('users', $users);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    return view('admin.user.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store()
  {
    //Validate
    $rules = array(
      'name' => 'required:string',
      'email' => 'required:email',
    );
    $validator = Validator::make(Input::all(), $rules);

    //Process the login
    if ($validator->fails()) {
      return Redirect::route('admin.user.create')
        ->withErrors($validator)
        ->withInput(Input::except('password'));
    } else {
      //Store the new model
      $user = new User;
      $user->name = Input::get('name');
      $user->email = Input::get('email');
      $user->avatar = $this->grabAvatar(Input::get('email'));
      $user->password = Hash::make(Input::get('password'));
      $user->save();

      //Redirect with a message
      Session::flash('message', 'Successfully added user!');
      return Redirect::route('admin.user.index');
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {
    return view('admin.user.show');
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
    $user = User::find($id);
    return View::make('admin.user.edit')->with('user', $user);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id)
  {
    //Validate
    $rules = array(
      'name' => 'required:string',
      'email' => 'required:email',
    );
    $validator = Validator::make(Input::all(), $rules);

    //Process the login
    if ($validator->fails()) {
      return Redirect::route('admin.user.edit')
        ->withErrors($validator)
        ->withInput(Input::except('password'));
    } else {
      //Store the new model
      $user = User::find($id);
      $user->name = Input::get('name');
      $user->email = Input::get('email');
      $user->avatar = $this->grabAvatar(Input::get('email'));
      $user->password = Hash::make(Input::get('password'));
      $user->save();

      //Redirect with a message
      Session::flash('message', 'Successfully edited user!');
      return Redirect::route('admin.user.index');
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
    $user = User::find($id);
    $user->delete();

    Session::flash('message', ucfirst($user->name) . ' (user) successfully deleted!');
    return Redirect::route('admin.user.index');
  }

  /**
   * Grabs the avatar if IBMer
   * Returns base64 image. Not efficient but <10 users therefore fine.
   */
  public function grabAvatar($email) 
  {  
    //Check the email is an IBM email
    if (strpos($email,'ibm') !== false) {
      $server_url = Setting::where('key', '=', 'avatar_url')->first()->value;
      $avatar = @base64_encode(file_get_contents($server_url . strtolower($email) . '.jpg?s=100'));

      if(isset($avatar)) {
        return $avatar;
      }
    }

    //Return a blank avatar if one was not found from the sever
    return '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'; 
  } 


  /**
   * Ajax call that is used by jQuery to delete
   */
  public function ajaxDelete($id) {
    
    //Set the response array
    $jsonResponse = array(
      'state' => '',
      'info' => ''
    );

    //Clean
    $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

    //Delete
    $user = User::find($id);
    $user->delete();
    $jsonResponse['state'] = 'success';
        
    return Response::json($jsonResponse);
  }

}
