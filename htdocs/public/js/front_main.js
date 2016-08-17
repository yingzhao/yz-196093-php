$(document).ready(function() {

  $(".overlay, .itemContainer div img").click(function() {
    $("#loading").toggleClass('displayTable');
    $("#loading").fadeTo("slow", 0.95);
  });

  $("#close").click(function() {
    $("#loading").fadeTo("slow", 0);
    $("#loading").delay("slow").toggleClass('displayTable');
  });

  $("#tweetContainer").elastic();

  $("select").change(function() {
    $(".all").parent().fadeTo("fast", 0.2);
    $("." + $(this).val()).parent().fadeTo("slow", 1);
  });

  $(".itemContainer").shapeshift({
    minColumns: 1,
    enableDrag: false,
  });

});
