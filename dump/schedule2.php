<?php
  require_once "movie.cls.php";

  session_start();

#  include "movie.cls.php";
  
  $movies = $_SESSION['movies'];
  
#  foreach ($movies as $m)
#    echo $m.' ';
  
  $selected_movies = $_POST['selected_movies'];
  
  var_dump($selected_movies);
  
#  $source = array();
#  foreach ($selected_movies as $sm)
#    array_push($source, $movies[$sm]);
#    
#  var_dump(count($source));
#    
#  foreach ($source as $s)
#    echo $s.' ';
    
?>
