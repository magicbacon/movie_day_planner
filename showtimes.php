<?php

  require_once "movie.cls.php";
  
  session_start();

  if (isset($_SESSION['movies']) && isset($_POST['movie_i']))
  {
    $movies = $_SESSION['movies'];
    $i = $_POST['movie_i'];
    $movie_i = $movies[$i];
    echo $movie_i->length.' min; Showtimes: ';
    $n = count($movie_i->showtimes)    
    foreach ($i = 0; $i < $n; $i++)
    {
      $movie_i->showtimes[$i]->format('H:i');
      if ($i < $n - 1)
        echo ' | ';
    }
  }
  
?>
