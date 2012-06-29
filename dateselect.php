<select>
  <?php
    for ($i = 0; $i < 7; $i++)
    {
      $d = new DateTime();
      $d->add(new DateInterval('P'.$i.'D'));
      echo '<option value="'.$d->format('mmddYY').'">'
        .$d->format('m/d/Y').'</option>';             
    }
    ?>
</select><br />