<?php namespace App\Http\Controllers;
// require 'vendor/autoload.php';
use View;
use Cache;
use Response;
use App\Category;
use App\Post;
use App\Setting;
use Twitter;
use GuzzleHttp\Client;
use Carbon\Carbon;

class HomeController extends Controller {
	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	*/

	/**
	 * Show the application to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
    Cache::add('name', Setting::where('key', '=', 'name')->first()->value, 1000);
		return View::make('home');
	}
  /**
   * Spit out in json to be used by the front-end
   */
  public function outputJson() {

    function UniqueRandomNumbersWithinRange($min, $max, $quantity) {
    $numbers = range($min, $max);
    shuffle($numbers);
    return array_slice($numbers, 0, $quantity);
}
   //  This is the homepage of the home controller
    $mydebug = false;
    if ($mydebug) echo ' Point 1 '.time();
    $name_record = Setting::where('key', '=', 'name')->first();
    $name = $name_record->value;
    $feedback_record = Setting::where('key', '=', 'feedback_email')->first();
    $feedback_email = $feedback_record->value;
    $tweets_to_pull = Setting::where('key', '=', 'tweets_to_pull')->first()->value;
//  $twitter_account now used to old the query string
    $twitter_account = Setting::where('key', '=', 'twitter_account')->first()->value; 
    $twitter_account = str_replace(" ", "+", $twitter_account);
//  $screen_name = Setting::where('key', '=', 'screen_name')->first()->value;
//
//  If setting = 0 or the cache doesn't exist we'll clear and then rebuild the cache
//
    if ($tweets_to_pull == 0 || apcu_fetch('tweetCountKey') == null) {
        if ($mydebug) echo ' Point 2 '.time();
    	apcu_clear_cache();
    	apcu_store ('tweetCountKey', 0);
//    	Cache::flush();
//      Cache::forever('tweetCountKey', 0);
// Create and initialize the guzzle client
        $client = new Client([
// Base URI is used with relative requests
        'base_url' => 'https://7e3b7d2a-e3cf-4940-8c36-b96557f4b683:adVHSwkIlZ@cdeservice.eu-gb.mybluemix.net',
// You can set any number of default request options.
        'timeout'  => 10.0,
        ]);
// Use guzzle to send a GET request to Watson Twitter Insights
// Guzzle 6 
//     $guzzleResponse = $client->request('GET', '/api/v1/messages/search', ['query' => 'q='.$twitter_account.'&size=200']); 	
//  Guzzle 5
        $request = $client->createRequest('GET', '/api/v1/messages/search');
        //while () {
        $request->getQuery()->set('q', $twitter_account.'&size=500');
        $request->getQuery()->setEncodingType(false);
//    echo $request->getUrl();
        $guzzleResponse = $client->send($request);
	    $insightList = json_decode($guzzleResponse ->getBody(), true);  
//
// Now build the cache of tweets
//
// Find out how many tweets there are
        $tweetsCurrent = $insightList['search'] ['current'];
        $tweetsAvailable = $insightList['search'] ['results'];
//    echo '$tweetsAvailable = ';
//    echo $tweetsAvailable;
	    $i = 0;
//        var_dump($insightList);  	
    	foreach($insightList['tweets'] as $tweet) {
    		//print_r ($tweet);
    		$pos = strpos($tweet['message']['body'], 'http');
    		if (!$pos) { continue;}
    		$pos = strpos($tweet['message']['body'], '…');
    		if ($pos) { continue;}
        	$insight["body"] = str_replace("&amp;", "&", $tweet['message']['body']);
        	$insight["date"] = $tweet['message']['postedTime'];
        	if( isset($tweet['cde']["content"]) ) {$insight["sentiment"] = $tweet['cde']['content']['sentiment']['polarity'];} 
        	$insight["posterimage"] = $tweet['message']['actor']['image'];
        	$insight["posterlink"] = $tweet['message']['actor']['link'];
        	$insight["displayName"] = $tweet['message']['actor']['displayName'];
        	$tweetStoreKey = 'tweetStoreKey'.$i;
    	    apcu_store ($tweetStoreKey, $insight);
    		$i++;
        }    // end foreach
        //}
  	    apcu_store ('tweetCountKey', $i);
        $tweetCountKey = apcu_fetch('tweetCountKey');
//
// Now pull in the posts and add them to a different cache
//        
// Get the posts latest first - descending order, i.e. latest first
        $postList = Post::where('active', 'true')
        ->orderBy('id', 'desc')
        ->get();
	    $i = 0;
        foreach ($postList as $post) {
        //var_dump($post);   
        $myupdated_at = $post->updated_at;
        $temp = print_r ($myupdated_at, true);	 // Needed for a side-effect
        $category = [
            'name' => $post->category->name,
            'colour' => $post->category->colour,
        ];
        $postTemp = array(
            'id' => $post->id,
            'text' => $post->text,
            'category' => $category,
            'image' => $post->image,
            'date' => $myupdated_at->date
        );
        $postStoreKey = 'postStoreKey'.$i;
    	$i++;
   		apcu_store($postStoreKey, $postTemp);
        //var_dump($postList);  	
        }
  	    apcu_store ('postCountKey', $i);

        //var_dump($posts);   
	}
	else {

//
//  Now add some random tweets to the output stream
//	
//    echo 'Now add some random tweets to the output stream';
    //if ($mydebug) echo ' Point 5 '.time();
         $tweetcount = apcu_fetch('tweetCountKey');
         $numbers = range(0, $tweetcount);
         shuffle($numbers);
//    for ($i = 0; $i < $tweets_to_pull; $i++) {
    	 $numbers = UniqueRandomNumbersWithinRange(0,$tweetcount,$tweets_to_pull); 
//    	$cacheIndexes[$i] = 'tweetStoreKey' . rand(0, Cache::get('tweetCountKey'));  
//        echo '$cacheIndexes = ';
//        var_dump($cacheIndexes);  	
//    }
//
//  Now add the random posts to the array
//
//  First set the insight category 
    //if ($mydebug) echo ' Point 6 '.time();
        $insightCategory = [
        'name' => 'twitter_insights',
        'colour' => '#4099FF'
        ];
        for ($i = 0; $i < $tweets_to_pull; $i++) {    
//	foreach ($cacheIndexes as $tweetStoreKey) {
//        echo '$numbers = ';
//        var_dump($numbers[$i]);  	
    	$insight = apcu_fetch('tweetStoreKey' . $numbers[$i]);
//        echo '$insight = ';
//        var_dump($insight);  	
		$posts[] = array(
        'id' => 99999999,
        'text' => $insight["body"],
        'category' => $insightCategory,
        'image' => 'false',
        'date' => $insight["date"],
        'posterimage' => $insight["posterimage"],
        'posterlink' => $insight["posterlink"],
        'displayName' => $insight["displayName"],
        'sentiment' => $insight["sentiment"]
         );
//		$i++;
    } // end foreach
    if ($mydebug) echo ' Point 7 '.time();
	} // end else  	

//
//  Now add the posts from the cache
//
//    $postList = Cache::get('postList');
    //if ($mydebug) echo ' Point 8 '.time();  
    //Get just the title and category from object
    //var_dump($postList);
    $postCount = apcu_fetch('postCountKey');  	
    for ($i=0;$i<$postCount; $i++) {
        $postStoreKey = 'postStoreKey'.$i; 
        $posts[] = apcu_fetch($postStoreKey);  
        //var_dump(apcu_fetch($postStoreKey));    
    }
    //if ($mydebug) echo ' Point 9 '.time();
// Now set up the return parameters    
    $jsonResponse['posts'] = $posts;
    $jsonResponse['name'] = 'IBM Cognitive ShareWall';
    $jsonResponse['feedback_email'] = 'knutson@uk.ibm.com'; 
    return Response::json($jsonResponse);  

}

  /**
   * This is the homepage of the admin controller
   */
  public function dashboard() 
  {
    return view('admin.index');
  }

  /**
   * Used on the users page
   *
   * @return Response
   */
  public function users()
  {
    return view('admin.users');
  }

}
       