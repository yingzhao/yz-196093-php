var serverUrl = window.location.protocol + '//' + window.location.hostname + '/sharewall/htdocs/';

//Used on post forms for the optional image dropdown
function slideImagePanel() {

  //If exists on page
  if ($("[name=image]").length) {
    var image = $("[name=image]").val();

    if(image != 'false' && image.length > 0) {
      $("#imgPanel").slideDown();
    }

    if(image == 'false') {
      $("#imgPanel").slideUp();
    }
  }
}

function capitalise(string) {
  return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
}

function calculatePostCount() {
  var text_max = 140;

  //Check to see if on a post form page
  if($('#postText').length) {
    var text_length = $('#postText').val().length;
    var text_remaining = text_max - text_length;
    $("#postCount").text(text_remaining + ' characters remaining.');     
  }

}

$(document).ready(function() {

  slideImagePanel();
  calculatePostCount();

  //Switch buttons
  $.fn.bootstrapSwitch.defaults.onText = 'Yes';
  $.fn.bootstrapSwitch.defaults.offText = 'No';
  $("[name='randomiseSwitch'], [name='activeSwitch'], [name='imageSwitch']").bootstrapSwitch({
    onSwitchChange: function(event, state) {
      var selector = $(this).attr('name').replace('Switch','');
      $("[name='" + selector + "']").val(state);

      //Check to see if image panel needs sliding out
      slideImagePanel(this);
    }
  });

  //Ajax switch button
  $("[data-ajax='update-active']").bootstrapSwitch({
    onSwitchChange: function(event, state) {
      var dataId = $(this).parents('tr').eq(0).attr('data-id');
      var redirect = $.getJSON(serverUrl + 'public/admin/ajax/post/' + dataId + '/active/' + state);
    }
  });

  //Are you sure you wish to delete modal
  $("[data-ajax='delete']").click(function() {
    var dataText = $(this).parents('tr').eq(0).attr('data-text');
    var dataType = $(this).parents('tr').eq(0).attr('data-type');
    var dataId = $(this).parents('tr').eq(0).attr('data-id');
    bootbox.confirm({ 
      message: "<h4>Are you sure you wish to delete the following " + dataType + "?</h4>" + dataText + "...", 
      callback: function(result){ 
        if(result == true) {
          var redirect = $.getJSON(serverUrl + 'public/admin/ajax/' + dataType + '/' + dataId + '/delete', function() {
            location.reload();
          });
        }
      }
    })
  });

  //Used for modal pop-up box to search by category
  $("[data-ajax='filter']").click(function() {

    //Get category list
    var optionString = '';
    $.getJSON(serverUrl + 'public/admin/ajax/category/get/list', function(data) {
      $.each(data.data, function(key, value) {
        optionString += '<option>' + capitalise(value) + '</option>';
      });
    
      bootbox.dialog({
        title: "Please select a category to view?",
        message: '<div class="row">  ' +
        '<div class="col-md-12"> ' +
        '<form class="form-horizontal"> ' +
        '<div class="input-group"> ' +
        '<select name="category-filter" class="form-control"> ' +
        optionString +
        '</select> ' +
        '</div> ' +
        '</div> </div>' +
        '</form></div></div>',
        buttons: {
          success: {
            label: "View posts",
            className: "btn-success",
            callback: function () {
              var category = $("[name='category-filter']").val()
              window.location = serverUrl + 'public/admin/post/filter/' + encodeURIComponent(category.toLowerCase());
            }
          }
        }
      });
    });

  });

  //Twitter count limit
  $('#postText').keyup(function() {
    calculatePostCount();
  });

  //Colour picker
  $("[name='colour']").spectrum({
    color: $("[name='colour']").val(),
    showInput: true,
    className: "colour-picker",
    showInitial: false,
    showPaletteOnly: false,
    showPalette: true,
    showSelectionPalette: true,
    preferredFormat: "hex",
    localStorageKey: "category.colour",
    palette: [  ]
  });

});
