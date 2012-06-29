<?php
  session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title>3 Movies a Day</title>
  <link rel="stylesheet" type="text/css" href="style.css" />
  <script type="text/javascript" src="jquery.js"></script>
  <script type="text/javascript" src="custom.js"></script>
</head>
<body>
  <div id="banner">Pragmatic Movie Plan</div>
  <div id="schedule_frame" class="outer_box">
    <div id="schedule_title" class="box_title">My Schedule</div>
    <div id="schedule_content" class="box_content">
    </div>
  </div>
  <div id="main_frame" class="outer_box">
    <div id="movies_title" class="box_title">Select Date and Movies</div>
    <div id="movies_content" class="box_content">
      <form id="movies_form" method="POST" action="schedule.php">
        <span>I'm gonna catch a movie, or 3. Here's the list of movies today in Newport AMC Theater:</span>

        <hr />
        <?php
          include 'parse_imdb.php';
          foreach ($movies as $i => $m)
          {
            echo '<input type="checkbox" name="selected_movies[]" value="'.$i
              .'">'.$m.'</input><br />';
          }
        ?>
        <hr />
        <span>All set, </span>
        <input id="get_schedule" type="button" value="Get me a schedule" />
      </form>
    </div>
  </div>
</body>
</html> 
