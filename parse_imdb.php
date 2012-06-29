<?php
  
#  session_start();

  include "movie.cls.php";  
  
  $info = file_get_contents('http://www.imdb.com/showtimes/cinema/US/ci0001901/');
  
  $pattern = '/<div\sclass=\"list_item.*<div\sclass=\"clear\">&nbsp;<\/div>\s*<\/div>/msU';
  
  preg_match_all($pattern, $info, $keyinfos);
  
  $movies = array();
  
  foreach ($keyinfos[0] as $value)
  {
    preg_match('/<h3>.*<\/h3>/msU', $value, $r);
    $movie_name = strip_tags($r[0]);
    if (preg_match('/(\d{2,3})\smin/mU', $value, $r)) # caution
      $movie_length = $r[1];
    else
      $movie_length = 'N/A';
    preg_match('/<div\sclass=\"showtimes\">.*<\/div>/msU', $value, $r);
    $showtimes = array();
    $pm = false;
    $times = explode('|', $r[0]);
    foreach ($times as $time)
    {
      if (strpos($time, 'pm'))
        $pm = true;
      $t = new DateTime;
      preg_match('/(\d+):(\d+)/', $time, $hm);
      $h = $hm[1];
      $m = $hm[2];
      if ($pm && $h != 12)
        $t->setTime($h+12, $m);
      else
        $t->setTime($h, $m);
      array_push($showtimes, $t);
    }
    $movie = new Movie($movie_name, $movie_length, $showtimes);
    array_push($movies, $movie);
    $_SESSION['movies'] = $movies;
  }
  
?>
