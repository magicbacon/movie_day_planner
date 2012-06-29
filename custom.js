$(document).ready(function() {
  $("#schedule_frame").hide();
    
  $("#get_schedule").click(function(e) {
    e.preventDefault();
        
    var movies = new Array();
    $.each($('input[name="selected_movies\\[\\]"]:checked'), function() {
      movies.push($(this).val());
    });
        
    $.post("schedule.php", {selected_movies: movies}, function(data){
      if ($("#schedule_frame").is(":hidden"))
      {
        $("#schedule_content").html(data);
        $("#schedule_frame").slideToggle();
      }
      else
      {
        $("#schedule_frame").slideToggle('fast',function(){
          $("#schedule_content").html(data);
        });
        $("#schedule_frame").slideToggle();
      }
    });
  });
});
