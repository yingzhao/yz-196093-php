<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Click;
use App\Category;
use App\Setting;
use App\Post;

class DefaultSettingsSeeder extends Seeder {

  public function run()
  {

    //This file seeds the defaults settings defined in .env by using 'php artisan db:seed' from root
    //Warning: This will delete any custom settings and should only be used on a fresh install

    Eloquent::unguard();

    //Clear all tables frist
    DB::table('categories')->delete();
    DB::table('clicks')->delete();
    DB::table('posts')->delete();
    DB::table('settings')->delete();
    DB::table('users')->delete();

    //Create super admin user
    User::create(array(
      'name' => 'John Knutson',
      'email' => "knutson@uk.ibm.com",
      'password' => Hash::make("password")
    ));

//    User::create(array(
//      'name' => 'Kurosh Beckett',
//      'email' => 'kuroshbe@uk.ibm.com',
//      'password' => Hash::make(env('ADMIN_PASSWORD'))
//    ));

    //Set default categories that posts are assigned to (from tipsheet)
    $categories = [
      array('name' => 'cloud', 'colour' => '#008ABF'),
      array('name' => 'analytics', 'colour' => '#B8471B'),
      array('name' => 'mobile', 'colour' => '#006058'),
      array('name' => 'social', 'colour' => '#008A52'),
      array('name' => 'security', 'colour' => '#A91124'),
      array('name' => 'twitter', 'colour' => '#4099FF')
    ];

    foreach ($categories as $category) {
      Category::create($category);
    }

    //Sample settings
    $settings = [
      array('name' => 'The name to use', 'type' => 'text', 'description' => 'Appears across the site', 'key' => 'name', 'value' => 'IBM Cognitive ShareWall'),
      array('name' => 'Twitter account to use', 'type' => 'text', 'description' => 'The twitter account (@ address) to pull tweets from', 'key' => 'twitter_account', 'value' => 'IBM_System_z'),
      array('name' => 'Number of tweets to pull in','type' => 'integer', 'description' => 'The number of tweet cards to create', 'key' => 'tweets_to_pull', 'value' => '5'),
      array('name' => 'Feedback email shown in footer', 'type' => 'text', 'description' => 'The email that is listed for any feedback to be sent to', 'key' => 'feedback_email', 'value' => "knutson@uk.ibm.com"),
      array('name' => 'Should tiles be randomised on load', 'type' => 'boolean','description' => "Should post titles be randomised on each page refresh?", 'key' => 'randomise', 'value' => 'true'),
      array('name' => 'IBM avatar server url', 'type' => 'text','description' => "Grabs avatar images if user is an IBMer", 'key' => 'avatar_url', 'value' => 'http://images.tap.ibm.com:10000/image/'),
    ];
    
    foreach ($settings as $setting) {
      Setting::create($setting);
    }

    //A few sample posts
    $posts = [
      array(
        'text' => 'If you have #Mainframe skills &amp; are #job hunting, check out #IBMz #Jobs', 
        'image' => 'false',
        'category_id' => rand(1,5),
        'active' => 'true',
      ),


    ];

    foreach ($posts as $post) {
      Post::create($post);
    }

    //Dummy random clicks on the above posts
    $socialNetworks = ['f','t','l'];
    for ($i=0; $i<1000; $i++) {
      Click::create([
        'post_id' => rand(1,7),
        'social_network' => $socialNetworks[array_rand($socialNetworks)]
      ]);
    }

  }
}
