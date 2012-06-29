<?php

  class Movie {
    public $name;
    public $length;
    public $showtimes = array();
    
    function Movie($name, $length, $showtimes) {
      $this->name = $name;
      $this->length = $length;
      $this->showtimes = $showtimes;
    }
    
    function __toString() {
      return $this->name;
    }
  }

?>
