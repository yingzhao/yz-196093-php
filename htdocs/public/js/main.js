/*globals URI FB*/
/*eslint-env browser */
/* Test */
$(document).ready(function() {

    $("#helpBoxToggle").click(function() {
      $("#helpBox").slideToggle();
    });
    
    var postContainer = $("#itemContainer");
    var posts, name, email, listViewFlag;
    var categories = [];
    // Get the JSON posts
    $.getJSON("ajax/index", function(data){
        posts = data.posts;
        name = data.name;
        email = data.feedback_email;
        populateContainer(); 
        populateCatagories();
    });
    
    function capitalizeFirstLetter(string) {
      return string.charAt(0).toUpperCase() + string.slice(1);
    }

    // Adds the dom elements for each post to the container.
    function populateContainer(){
        postContainer.empty();
        posts.forEach(function(post){
// First see if we have a valid URL - ignore post if we don't
   		    var myurl = null;
            var link  = URI.withinString(post.text, function(url)  {
                myurl = url;
    	        return url;
            });  
		    //alert ("myurl: " + myurl + "   post.text" + post.text); 
            if (myurl == null){
                var validurl = false; 
            }else {
                if (myurl.includes("…")){
                	post.text = post.text.replace(myurl, "");                	
   		            var myurl = null;
                    var link  = URI.withinString(post.text, function(url)  {
                        myurl = url;
    	                return url;
                    });  
		    	    //alert ("myurl: " + myurl + "   post.text" + post.text); 
                    if (myurl == null){
                        var validurl = false;              
                    }else {
                        var validurl = true; 
                    }
                }
                else {
                        var validurl = true;  
                }
            }


//                $( "</tr>").appendTo(lastTable);
                
          // alert ("post.text: " + post.text);
          // $("#itemContainer").val($(this).text()) = text;
          // alert ("$(\"#itemContainer\").val(): " + $("#itemContainer").val());
          // alert ("$(\"#itemContainer\").val($(this).text() " + $("#itemContainer").val($(this).text()));
// End of new stuff              
          //addOnClick($("#itemContainer .listview_tile:last"));
          $("#itemContainer .listview_tile:last").click(function(){
          $('#tweetContainer').text(post.text);
          //$("#tweetContainer").val($(this).text());
          $("#loading").toggleClass('displayTable');
          $("#loading").fadeTo("fast", 0.95);
        });               
            //addOnClick(post.text);
          
            // if category is not already in list
            if($.inArray(post.category.name, categories)==-1){
                categories.push(post.category.name);
            }
        if (validurl){   
            $("<div/>", { 
                class: 'listview_tile tile_'+post.category.name,
                text: post.text,
                style: "background-color: "+post.category.colour+";"
            }).appendTo(postContainer);  
            // get the div element that was just added 
            var lastDiv = $("#itemContainer div:last");
            $("<table/>", {
                class: 'listview_tile_table tile_table',
                width: '100%'
            }).appendTo(lastDiv);
            var lastTable = $("#itemContainer table:last");
            $( "<tr>").appendTo(lastTable);
            var lastTr = $("#itemContainer tr:last");
            $( "<td><small> category: " + post.category.name + "</small></td>").appendTo(lastTr);
            $( "<td><small> posted: " + post.date + "</small></td>").appendTo(lastTr);
            $( "<td><small> <u><a href='" + myurl + "' target='_blank'>" + myurl + "</u></small></a>").appendTo(lastTr); 
            if (post.category.name == 'twitter_insights') {
            $( "<td><small> <u><a href='" +  post.posterlink + "' target='_blank'>" + post.displayName + " <img size=100% src=\x22" + post.posterimage + "\x22/></u></small></a>").appendTo(lastTr);
            } else {
                $( "<td></td>").appendTo(lastTr);            	
            }
            var bgsentiment = ''; 
            switch (post.sentiment) {
                case 'POSITIVE':
                  bgsentiment = 'green';
                  break;
                case 'NEGATIVE':
                  bgsentiment = 'red';
                  break;
                case 'NEUTRAL':
                  bgsentiment = 'gray';
                 break;
               case 'AMBIVALENT':
                 bgsentiment = 'darkgray';
                 break;
               default:
                 bgsentiment = 'lightgray';
            }
            $( "<td style=\x22 background-color: " + bgsentiment + "\x22><small> sentiment: " + post.sentiment + "</small></td>").appendTo(lastTr);     
            $( "</tr>").appendTo(lastTr);	
        }    
        });
    }
    
    function addOnClick(element){
        element.click(function(){
          //$(postText);          
          $("#tweetContainer").val($(this).text());
          $("#loading").toggleClass('displayTable');
          $("#loading").fadeTo("fast", 0.95);
        });
    }
    
    function populateCatagories(){
        for(var i = 0; i<categories.length; i++){
            $("#categoriesDropdown").append("<option>"+ categories[i] +"</option>");
        }
    }
    
    // called on button click to toggle the view
    function toggleView(){
        var items = $("#itemContainer div");
        var classList = items.attr('class').split(/\s+/);
        listViewFlag = false;
        for(var i = 0; i< classList.length; i++){ 
            if(classList[i] === "listview_tile"){
                listViewFlag = true;
                break;
            }
        }
        
        if(listViewFlag){ // If we are on listview already
            $("#itemContainer div").toggleClass("listview_tile gridview_tile");
            arrueGrid();
        }else{ // if we are on gridview 
            $("#itemContainer div").toggleClass("gridview_tile listview_tile");
            $("#itemContainer").css("height", "auto");

            arrangeList();
        }
    }
    
    function arrangeList(){
        listViewFlag = false;
        populateContainer();
    }
    
    function arrangeGrid(){
        listViewFlag = true;
        postContainer.empty();
        posts.forEach(function(post){
            // if there is no image - TODO JSON needs to be cleansed of 'image' 'img' inconsistency.
            if(post.image == "false" || post.img===""){
                $("<div/>", {
                    class: 'all imageless_tile gridview_tile tile_'+post.category.name,
                    text: post.text,
                    style: "background-color: "+post.category.colour+";"
                }).appendTo(postContainer);              
            }else{
                $("<div/>", {
                    class: 'all gridview_tile tile_'+post.category.name,
                    style: "background-color: "+post.category.colour+";"
                }).appendTo(postContainer);  
                // get the div element that was just added 
                var lastDiv = $("#itemContainer div:last");
                //...and give it a colspan of 2
                lastDiv.attr("data-ss-colspan",2);
                //... append img to it.
                $("<img/>", {
                    class: 'tileImg',
                    src: post.image
                }).appendTo(lastDiv);  
                //.. and add text below it
                $("<h2/>", {
                    class: 'imageTileText',
                    text: post.text
                }).appendTo(lastDiv);  
                
            }
            addOnClick($("#itemContainer div:last"));
        });
        
      $("#itemContainer").shapeshift({
          minColumns: 1,
          enableDrag: false
      });

    }

    $("#loading .button").click(function() {
        var width  = 575,
            height = 400,
            left   = ($(window).width()  - width)  / 2,
            top    = ($(window).height() - height) / 2,
            text   = $("#tweetContainer").val(),
            opts   = 'status=1' +
                     ',width='  + width  +
                     ',height=' + height +
                     ',top='    + top    +
                     ',left='   + left;
    //alert ("text: " + text);
	text = text.replace(/category:.*/, "");
    //alert ("text: " + text);
    text   = encodeURIComponent(text);    
    //alert ("text: " + text);                 
// Initialise Facebook api
    FB.init({
    appId      : '{"198903487114061"}',
    status     : true,
    xfbml      : true,
    version    : 'v2.6' // or v2.0, v2.1, v2.2, v2.3
    });
        //See if post has a link, if not set to ibm.com
        //TO DO: Get the link from the post
//         var link = 'http%3A%2F%2Fwww.ibm.com%2F&t';
		var contents = $("#tweetContainer").val();
        //(contents.indexOf("http") >= 0 || contents.indexOf("www") >= 0) {
   		var myurl = null;
        var link  = URI.withinString(contents, function(url)  {
        // alert ("url" + url);
        myurl = url;
    	return "<a>" + url + "</a>";
});

//    } else {
//        var link = 'http%3A%2F%2Fwww.ibm.com%2F&t';
//  }

        //Check which share url to use for the popup
        //  Removed this deprecated API call  var url = 'https://www.facebook.com/sharer/sharer.php?u=' + link + '&t=' + text;
			var uuencodeurl = encodeURIComponent(myurl);
		//	alert ("uuencodeurl: " + uuencodeurl);
			text = text.replace(uuencodeurl, "");
        	//alert ("text: " + text);
            //alert ("uuencodeurl " + uuencodeurl + " myurl " + myurl);
        if($(this).hasClass("facebook")) {
        FB.ui({
        	method: 'feed', 
        	link: myurl, 
        	caption: 
        	text, }, 
        	function(response)
        		{
        		if (response && !response.error_message) {
     			// alert('Posting completed.');
			    } 
			    else {
		      	// alert('Error while posting.');
		      	}
		     	}
		     );
        // alert ("Response from FB.ui function call = ", response);
        // var url = 'https://www.facebook.com/dialog/feed?app_id=1700547330200570&display=popup&caption=' + text + '&link=' + uuencodeurl + '&redirect_uri=' + myurl;
        } else if($(this).hasClass("twitter")) {
        	url = 'http://twitter.com/share?text=' + text + "&url=" + myurl + "&original_referer=" + myurl;
        } else if($(this).hasClass("linkedin")) {
          url = 'http://www.linkedin.com/shareArticle?mini=true&url=' + uuencodeurl + '&title=' + text +'&summary=' + text;

        //	alert ("text: " + text);
        } 

        window.open(url, 'zShareWall Sharer', opts);
        return false;
    });

    $("#close").click(function() {
        $("#loading").fadeTo("fast", 0);
        $("#loading").delay("fast").toggleClass('displayTable');
    });

    $("#tweetContainer").elastic();

    $("select").change(function() {
        repopulate();
        var chosenCategory = $(this).val();
        filterBy(chosenCategory);

    });
    
    function filterBy(category){
        if(category==="all"){ 
            repopulate();
        }else{      
            $("#itemContainer div:not(.tile_"+category).remove(); 
            if(listViewFlag){
                $("#itemContainer").shapeshift();
            }
        }
    }
    
    function repopulate(){
        // repopulate 
            if(listViewFlag){
                arrangeGrid();
            }else{
                arrangeList();
            }
    }
    
    function toggleOverlay(){
//        console.log("CLICK");

       
//        $("#loading").toggleClass('displayTable');
//        $("#loading").fadeTo("slow", 0.95);
    }
    
//    $('#activate_listview_button').click(function(){
//        $(".itemContainer div").attr("data-ss-colspan",  1);
//        $(".itemContainer").shapeshift({
//            minColumns: 1,
//            columns:1,
//            enableDrag: false,
//            align: "left"
//        });
//        $(".itemContainer div").css("width",  "100%");
//    });
    
    $('#toggleview_button').click(function(){        
       location.reload();
        
        //TODO need to filterBy here ggg

    });
    


});
