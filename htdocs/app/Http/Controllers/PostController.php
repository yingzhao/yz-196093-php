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

use App\Post;
use App\Click;
use App\Category;

class PostController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
    $posts = Post::orderBy('created_at', 'DESC')->get();
    return view('admin.post.index')->with('posts', $posts);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
    $categories = Category::lists('name', 'id');

    //Remove twitter
    foreach ($categories as $key => $value) {
      if ($value == 'twitter') {
        unset($categories[$key]);
      }
    }

    $categories = array_map('ucfirst', $categories);
		return view('admin.post.create')->with('categories', $categories);
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
      'text' => 'required|string|max:140',
      'category_id' => 'required|integer',
    );
    $validator = Validator::make(Input::all(), $rules);

    //Process the login
    if ($validator->fails()) {
      return Redirect::route('admin.post.create')
        ->withErrors($validator)
        ->withInput(Input::except('password'));
    } else {
      //Store the new model
      $post = new Post;
      $post->text = Input::get('text');

      if (Input::get('image') == 'true' && Input::get('imageUrl') != '') {
        $post->image = Input::get('imageUrl');
      } else {
        $post->image = 'false';
      }
      
      $post->category_id = Input::get('category_id');
      
      if(Input::get('active') == '') {
        $post->active = 'false';
      } else {
        $post->active = Input::get('active');
      }
    
      $post->save();

      //Redirect with a message
      Session::flash('message', 'Successfully added post!');
      return Redirect::route('admin.post.index');
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
    $post = Post::find($id);
		return view('admin.post.show')->with('post', $post);
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
      $post = Post::find($id);
      $categories = Category::lists('name', 'id');
      $categories = array_map('ucfirst', $categories);

      if(is_null($post) || is_null($categories)) {
        throw new ModelNotFoundException;
      }

      return View::make('admin.post.edit')->with(compact('post', 'categories'));

    } catch(ModelNotFoundException $e) {
      Session::flash('message', 'Post not found:- ' . $e);
      return Redirect::route('admin.post.index');
      
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
      'text' => 'required|string|max:140',
      'image' => 'required',
      'category_id' => 'required|integer',
      'active' => 'required',
    );
    $validator = Validator::make(Input::all(), $rules);

    //Process the login
    if ($validator->fails()) {
      return Redirect::route('admin.post.edit', $id)
        ->withErrors($validator)
        ->withInput(Input::except('password'));
    } else {
      //Store the new model
      $post = Post::find($id);
      $post->text = Input::get('text');

      if (Input::get('image') == 'true' && Input::get('imageUrl') != '') {
        $post->image = Input::get('imageUrl');
      } else {
        $post->image = 'false';
      }
      
      $post->category_id = Input::get('category_id');
      
      if(Input::get('active') == '') {
        $post->active = 'false';
      } else {
        $post->active = Input::get('active');
      }
    
      $post->save();

      //Redirect with a message
      Session::flash('message', 'Successfully updated post!');
      return Redirect::route('admin.post.index');
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
    $post = Post::find($id);
    $post->delete();

    Session::flash('message', substr($post->text, 0, 50) . '... successfully deleted.');
    return Redirect::route('admin.post.index');
	}

  /**
   * Filter facility to view posts within a certain character
   */
  public function filterByCategory($category) {

    try {
      $category = filter_var($category, FILTER_SANITIZE_STRING);
      $category_id = Category::where('name', '=', $category)->firstOrFail()->id;
      $posts = Post::where('category_id', '=', $category_id)->get();

      return view('admin.post.filter')->with(compact('category','posts'));
    
    } catch (ModelNotFoundException $e) {
      Session::flash('message', 'Category not found.');
      return Redirect::route('admin.post.index');
    
    }
  }

  /**
   * Ajax call that is used by jQuery to update post active column
   */
  public function ajaxSetActive($id, $status) {
    
    //Set the response array
    $jsonResponse = array(
      'state' => '',
      'info' => ''
    );

    //Clean
    $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
    $status = filter_var($status, FILTER_SANITIZE_STRING);

    if($status == 'true' || $status == 'false') {
      $post = Post::find($id);
      $post->active = $status;
      $post->save();
      $jsonResponse['state'] = 'success';
    } else {
      $jsonResponse['state'] = 'error';
      $jsonResponse['info'] = 'The status has to be either true or false.';  
    }

    return Response::json($jsonResponse);
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
    $post = Post::find($id);
    $post->delete();
    $jsonResponse['state'] = 'success';
        
    return Response::json($jsonResponse);
  }

  /**
   * Ajax call that is used by jQuery to delete
   */
  public function ajaxClick($id, $network) {
    
    //Set the response array
    $jsonResponse = array(
      'state' => '',
      'info' => ''
    );

    //Clean
    $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

    if($network == 'facebook' || $network == 'twitter' || $network == 'linkedin') {
      switch ($network) {
        case 'facebook':
          $networkShortcode = 'f';
          break;

        case 'twitter':
          $networkShortcode = 't';
          break;

        case 'linkedin':
          $networkShortcode = 'l';
          break;
      }
      $click = Click::create([
        'post_id' => $id,
        'social_network' => $networkShortcode
      ]);

      $click->save();

      $jsonResponse['state'] = 'success';
      $jsonResponse['info'] = 'Click successfully recorded.';
      return Response::json($jsonResponse);

    } else {
      $jsonResponse['state'] = 'error';
      $jsonResponse['info'] = 'The social network passed is not supported.';
      return Response::json($jsonResponse);
    }

  }

}
