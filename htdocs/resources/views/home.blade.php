<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="">
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{ asset('/css/normalize.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/main.css') }}">

<!--    <script src="{{ asset('/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js') }}"></script> -->
     <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script>
        window.jQuery || document.write('<script src="{{ asset(' / js / vendor / jquery - 1.11.2. min.js ') }}"><\/script>')
    </script>
    <script src="{{ asset('/js/jquery-ui.js') }}"></script>
    <script src="{{ asset('/js/jquery.elastic.source.js') }}"></script>
    <script src="{{ asset('/js/jquery.shapeshift.min.js') }}"></script>
    <script src="{{ asset('/js/jquery.ui.touch-punch.js') }}"></script>
    <script src="{{ asset('/js/main.js') }}"></script>
    <script src="{{ asset('/js/URI.js') }}"></script>
</head>

<body>
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '198903487114061',
      xfbml      : true,
      version    : 'v2.5'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>

    <div id="container">

        <!-- Text box at the top of the page -->
        <header>
            <div id="selector">
                <h1>IBM z Systems and IBM LinuxONE <b>Cognitive</b> Share Wall</h1>
                <p> Now with Watson Insights for Twitter</p>
                <p><small>Click <italic>Refresh</italic> to see another set of insights</small></p>
                <select id="categoriesDropdown" name="select">
                    <option value="all" selected>Select category</option>
                </select>
                <button id="toggleview_button" class="button" name="Toggle View" title="ToggleView">Refresh Insights</button>
                <button id="helpBoxToggle" class="button secondary">Help</button>
            </div>
        </header>

        <!-- Help panel (hidden on view) -->
        <div id="helpBox">
          <h2>How it works</h2>
          <p>Use the drop-down to select your category. Then click on a post and select the social network to share it on. Update the provided text and then socialize it!</p>
          <p>zSharewall now includes a customised feed from the Watson-enhanced IBM Insights for Twitter service. Refresh the page to see a different selection of tweets. </p>
       
        </div>

        <!-- Grid of panels -->
        <div id="itemContainer" class="itemContainer">
        </div>

    </div>

    <footer>
        &copy; IBM {{ date("Y") }} | <a href="auth/login">Admin login</a>
    </footer>

    <div id="loading">
        <div class="centre">
            <h4>Edit your post</h4>
            <textarea id="tweetContainer"></textarea>
            <a class="button facebook">Share on Facebook</a>
            <a class="button twitter">Tweet on Twitter</a>
            <a class="button linkedin">Share on LinkedIn</a>
            <a id="close"><img src="img/close-icon.png">
            </a>
        </div>
    </div>

   
</body>

</html>