$("#selectImage").click(function() {

  //Create flash effect to show the image selection
  $($(".liveurl .active").parent()).delay(100).fadeOut(100).fadeIn(100);

  var src = $('img.active').attr('src');
  $("#liveurl-selected").text(src);

});

$("#imageUrlButton").click(function() {

  alert('TO DO: Force search function')

});

var curImages = new Array();

$('#imageUrlInput').liveUrl({
    loadStart : function(){
        $('.liveurl-loader').show();
    },
    loadEnd : function(){
        $('.liveurl-loader').hide();
    },
    success : function(data) 
    {                        
        var output = $('.liveurl');
        output.find('.title').text(data.title);
        output.find('.description').text(data.description);
        output.find('.url').text(data.url);
        output.find('.image').empty();
        
        output.find('.close').one('click', function() 
        {
            var liveUrl     = $(this).parent();
            liveUrl.slideUp();
            liveUrl.find('.image').html('');
            liveUrl.find('.controls .prev').addClass('inactive');
            liveUrl.find('.controls .next').addClass('inactive');
            liveUrl.find('.live-thumbnail').slideUp();
            liveUrl.find('.image').slideUp();

            $('textarea').trigger('clear'); 
            curImages = new Array();
        });
        
        output.slideDown();
        
    },
    addImage : function(image)
    {   
        var output  = $('.liveurl');
        var jqImage = $(image);
        jqImage.attr('alt', 'Preview');
        
        if ((image.width / image.height)  > 7 
        ||  (image.height / image.width)  > 4 ) {
            // we dont want extra large images...
            return false;
        } 

        curImages.push(jqImage.attr('src'));
        output.find('.image').append(jqImage);
        
        
        if (curImages.length == 1) {
            // first image...
            
            output.find('.live-thumbnail .current').text('1');
            output.find('.live-thumbnail').show();
            output.find('.image').show();
            jqImage.addClass('active');
            
        }
        
        if (curImages.length == 2) {
            output.find('.controls .next').removeClass('inactive');
        }
        
        output.find('.live-thumbnail .max').text(curImages.length);
    }
});              

$('.liveurl').on('click', '.controls .button', function() 
{
    var self        = $(this);
    var liveUrl     = $(this).parents('.liveurl');
    var content     = liveUrl.find('.image');
    var images      = $('img', content);
    var activeImage = $('img.active', content);

    if (self.hasClass('next')) 
         var elem = activeImage.next("img");
    else var elem = activeImage.prev("img");

    if (elem.length > 0) {
        activeImage.removeClass('active');
        elem.addClass('active');  
        liveUrl.find('.live-thumbnail .current').text(elem.index() +1);
        
        if (elem.index() +1 == images.length || elem.index()+1 == 1) {
            self.addClass('inactive');
        }
    }

    if (self.hasClass('next')) 
         var other = elem.prev("img");
    else var other = elem.next("img");
    
    if (other.length > 0) {
        if (self.hasClass('next')) 
               self.prev().removeClass('inactive');
        else   self.next().removeClass('inactive');
   } else {
        if (self.hasClass('next')) 
               self.prev().addClass('inactive');
        else   self.next().addClass('inactive');
   }
   
});