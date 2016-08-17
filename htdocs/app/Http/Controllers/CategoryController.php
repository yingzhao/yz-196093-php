<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use View;
use Session;
use Response;
use Redirect;
use Validator;
use Input;

use App\Category;

class CategoryController extends Controller {

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    $categories = Category::with('postCount')->get();

    //Remove twitter from showing up in the table
    foreach ($categories as $key => $value) {
      if ($value->name == 'twitter') {
        unset($categories[$key]);
      }
    }

    return view('admin.category.index')->with('categories', $categories);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    return view('admin.category.create');
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
      'name' => 'required',
      'colour' => 'required',
    );
    $validator = Validator::make(Input::all(), $rules);

    //Process the login
    if ($validator->fails()) {
      return Redirect::route('admin.category.create')
        ->withErrors($validator)
        ->withInput(Input::except('password'));
    } else {
      //Store the new model
      $category = new Category;
      $category->name = strtolower(Input::get('name'));
      $category->colour = Input::get('colour');
      $category->save();

      //Redirect with a message
      Session::flash('message', 'Successfully added category!');
      return Redirect::route('admin.category.index');
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
    return Redirect::route('admin.category.index');
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
    try {
      $category = Category::find($id);

      if(is_null($category)) {
        throw new ModelNotFoundException;
      }

      //Prevent if twitter
      if ($category->name == 'twitter') {
        Session::flash('message', 'The twitter category can\'t be changed.');
        return Redirect::route('admin.category.index');
      }

      return View::make('admin.category.edit')->with('category', $category);

    } catch (ModelNotFoundException $e) {
      return Redirect::route('admin.category.index');

    }

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
      'name' => 'required',
      'colour' => 'required',
    );
    $validator = Validator::make(Input::all(), $rules);

    //Process the login
    if ($validator->fails()) {
      return Redirect::to('admin.category.edit')
        ->withErrors($validator)
        ->withInput(Input::except('password'));
    } else {
      //Store the new model
      $category = Category::find($id);
      $category->name = strtolower(Input::get('name'));
      $category->colour = Input::get('colour');
      $category->save();

      //Redirect with a message
      Session::flash('message', 'Category successfully updated!');
      return Redirect::route('admin.category.index');
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
    $category = Category::find($id);

    //Prevent if twitter
    if ($category->name == 'twitter') {
      Session::flash('message', 'The twitter category can\'t be changed.');
      return Redirect::route('admin.category.index');
    }

    $category->delete();

    Session::flash('message', ucfirst($category->name) . ' category successfully deleted!');
    return Redirect::route('admin.category.index');
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
    $category = Category::find($id);
    $category->delete();
    $jsonResponse['state'] = 'success';
        
    return Response::json($jsonResponse);
  }

  /**
   * Ajax call that is used by jQuery to delete
   */
  public function ajaxList() {
    
    //Set the response array
    $jsonResponse = array(
      'state' => '',
      'info' => ''
    );

    $categories = Category::lists('name');

    //Remove twitter
    foreach ($categories as $key => $value) {
      if ($value == 'twitter') {
        unset($categories[$key]);
      }
    }

    $jsonResponse['state'] = 'success';
    $jsonResponse['data'] = $categories;
        
    return Response::json($jsonResponse);
  }

}
