<?php

  # include 'pgen.php';
  
  include 'movie.cls.php';
  
  #/* test
  
  $t1 = new DateTime();
  $t1->setTime(9, 20);
  $t2 = new DateTime();
  $t2->setTime(12, 20);
  $t3 = new DateTime();
  $t3->setTime(14, 40);
  $t4 = new DateTime();
  $t4->setTime(9, 30);
  $t5 = new DateTime();
  $t5->setTime(12, 30);
  $t6 = new DateTime();
  $t6->setTime(15, 40);
  $t7 = new DateTime();
  $t7->setTime(8, 20);
  $t8 = new DateTime();
  $t8->setTime(11, 20);
  $t9 = new DateTime();
  $t9->setTime(14, 40);
  $m1 = new Movie('m1',186,array($t1, $t2, $t3));
  $m2 = new Movie('m2',120,array($t4, $t5, $t6));
  $m3 = new Movie('m3',90,array($t7, $t8, $t9));
  
  $o1 = array($m1, $m2, $m3);
  $o2 = array($m1, $m3, $m2);
  $o3 = array($m2, $m1, $m3);
  $o4 = array($m2, $m3, $m1);
  $o5 = array($m3, $m1, $m2);
  $o6 = array($m3, $m2, $m1);
  
  $orders = array($o1, $o2, $o3, $o4, $o5, $o6);
  $c = 1;
  
  #*/
  
  $timeline = new DateTime();
  $fail_flag = false;
  $useful_times = array();
  $timespan = new DateInterval('PT0M');
  
  
  foreach ($orders as $o)
  {
    $c1 = count($o);
    echo '<br><br>try for '.$c.' time'; $c++;
    # $timeline_t = clone $timeline;
    # $useful_times_t = $useful_times;
    # echo '<br>See if changed: '.$o[0]->showtimes[0]->format('H:i');
    $useful_times_t = array();
    $timeline_t = clone $o[0]->showtimes[0];
    echo '<br>start at '.$timeline_t->format('H:i').' with '.$o[0];
    array_push($useful_times_t, $o[0]->showtimes[0]);
    for ($i = 1; $i < sizeof($o); $i++)
    {
      echo '<br>this is '.$o[$i].' we are trying.';
      # echo '<br />before='.$timeline_t->format('H:i');
      $last_movie_length = is_int($o[$i-1]->length) ? $o[$i-1]->length : 90;
      # echo '|l='.$last_movie_length.' ';
      $timeline_t->add(new DateInterval('PT'.$last_movie_length.'M'));
      # echo '|current='.$timeline_t->format('H:i');
      $showtimes_l = $o[$i]->showtimes;
      $mk = count($useful_times_t);
      for ($j = 0; $j < sizeof($showtimes_l); $j++)
      {
        if ($timeline_t < $showtimes_l[$j])
        {
          echo '<br/>best time for '.$o[$i].' is '.$showtimes_l[$j]->format('H:i').'|';
          array_push($useful_times_t, $showtimes_l[$j]);
          $timeline_t = clone $showtimes_l[$j];
          $s = true;
          break;
        }
      }
      echo '<br>these are the "useful times temp": ';
      foreach ($useful_times_t as $ut1)
        echo $ut1->format('H:i').'|';
      if ($mk == count($useful_times_t))
        break;
    }
    if (count($useful_times_t) == count($o))
    {
      $last_movie_length_1 = is_int($o[$c1-1]->length) ? $o[$c1-1]->length : 90;
      $timeline_t->add(new DateInterval('PT'.$last_movie_length_1.'M'));
      $timespan_t = $o[0]->showtimes[0]->diff($timeline_t);
      echo '<br>timespan of this time: '.$timespan_t->format('%H:%i');
      # $better = ($timeline_t < $timeline) && ($useful_times_t[0] > $useful_times[0]);
      if (isset($useful_order)) 
      {
#        echo '<br>old timespan'.$timespan->format('%H:%i');
#        echo '<br>new timespan'.$timespan_t->format('%H:%i');
#        var_dump($timespan_t < $timespan);
        $oh = $timespan->format('%H');
        $oi = $timespan->format('%i');
        $nh = $timespan_t->format('%H');
        $ni = $timespan_t->format('%i');
        echo '<br>old and new hours: '.$oh.' and '.$nh.'<br>';
        var_dump($oh > $nh);
        echo '<br>old and new mins: '.$oi.' and '.$ni;
        $jud = false;
        if ($oh > $nh)
        {
          echo '<br>new hour less than old hour';
          $jud = true;
        }
        elseif ($oh == $nh)
        {
          echo '<br>new hour equals old hour';
          if ($oi > $ni)
            $jud = true;
        }
        if ($jud)
        {
          echo "<br>changed!!";
          $timespan = $timespan_t;
          $timeline = clone $timeline_t;
          unset($useful_times);
          $useful_times = $useful_times_t;
          $useful_order = $o;
        }
      }
      else
      {
        echo '<br>set first time';
        $timespan = $timespan_t;
        $timeline = clone $timeline_t;
        unset($useful_times);
        $useful_times = $useful_times_t;
        $useful_order = $o;
      }
    }
#    unset($useful_times_t);
    echo '<br>these are the "useful times": ';
    foreach ($useful_times as $ut1)
      echo $ut1->format('H:i').'|';
  }
  
  #/* test output
  echo '<br>'.implode('|', $useful_order).'<br />';
  foreach ($useful_times as $ut)
    echo $ut->format('H:i').'|';
  #*/

?>
