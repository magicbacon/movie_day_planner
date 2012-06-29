<?php
  
  require_once "movie.cls.php";
  
  session_start();
  
  $movies = $_SESSION['movies'];
  
  if (isset($_POST['selected_movies']))
    $selected_movies = $_POST['selected_movies'];
  else
  {
    echo 'error_1';
    exit();
  }
  
  $source = array();
  foreach ($selected_movies as $sm)
    array_push($source, $movies[$sm]);

  $orders = array();
  permutation(array(), $source, $orders);
  
  function permutation($r, $s, &$orders) 
  {
    if (count($s)) 
    {
      foreach ($s as $i => $value) 
      {
        $t1 = $s;
        $t2 = $r;
        array_push($t2, $value);
        unset($t1[$i]);
        permutation($t2, $t1, $orders);
      }
    }
    else
      array_push($orders, $r);
  }

  $schedule = array();
  $time_span = new DateInterval('PT0M');
  
  function get_movie_length ($movie)
  {
    return is_int($movie->length) ? $movie->length : 90;
  }
  
  function DateInterval_gt ($di1, $di2)
  {
    $s1 = $di1->format('%H:%i');
    $s2 = $di2->format('%H:%i');
    return (strcmp($s1, $s2) > 0) ? true : false;
  }
  
  foreach ($orders as $o)
  {
    $schedule_t = array();
    $time_p = clone $o[0]->showtimes[0];
    $time_p->add(new DateInterval('PT'.get_movie_length($o[0]).'M'));
    array_push($schedule_t, $o[0]->showtimes[0]);
    $next_movie_available = false;
    for ($i = 1; $i < count($o); $i++)
    {
      $showtimes_l = $o[$i]->showtimes;
      for ($j = 0; $j < count($showtimes_l); $j++)
      {
        if ($time_p < $showtimes_l[$j])
        {
          $time_p = clone $showtimes_l[$j];
          $time_p->add(new DateInterval('PT'.get_movie_length($o[$i]).'M'));
          array_push($schedule_t, $showtimes_l[$j]);
          $next_movie_available = true;
          break;
        }
      }
      if ($next_movie_available === false)
        break;
    }
    if (count($schedule_t) == count($o))
    {
      $time_span_t = $o[0]->showtimes[0]->diff($time_p);
      $better = DateInterval_gt($time_span, $time_span_t);
      if ((isset($useful_order) && $better) || !isset($useful_order))
      {
        $time_span = $time_span_t;
        $schedule = $schedule_t;
        $useful_order = $o;
      }
    }
  }
  
  for ($i = 0; $i < count($schedule); $i++)
  {
    echo ($i + 1).'. '.$useful_order[$i].' at '
      .$schedule[$i]->format('H:i').'<br />';  
  }

?>
