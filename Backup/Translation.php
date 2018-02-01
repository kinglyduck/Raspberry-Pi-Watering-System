<?php
  //Update pin states
  $contents = file_get_contents("configuration.txt");
  $button_pushed = "";
  $content = "";
  for ($x = 0; $x < 15; $x++) {
    if (isset($_POST["P" . $x])) {
      $button_pushed = "pin" . $x; //Get button pushed format P0 - P14
      if (strpos($contents, "$button_pushed=off") !== false) {
          $content = str_replace($button_pushed . "=off",$button_pushed . "=on",$contents); //Replace string in contents with on instead of off
      } else {
          $content = str_replace($button_pushed . "=on",$button_pushed . "=off",$contents); //Replace string in contents with on instead of off
      }
    }
  }

  //Update CONFIGURATION
  if (isset($_POST["save"])) {
     $template = file_get_contents("template.txt");
     $content = $template . "SCHEDULE=" . $_POST["schedule"] . "\n" . "WATERING_TIMING=" . $_POST["level"];
  }


  //Write to text file
  file_put_contents("configuration.txt", ""); //clear contents of file

  $txt = "configuration.txt";
  $fh = fopen($txt, 'w+');
  $txt=$content;
  file_put_contents('configuration.txt',$txt."\n",FILE_APPEND); // log to configuration.txt
  exit();
  fwrite($fh,$txt); // Write information to the file
  fclose($fh); // Close the file

  echo $txt;
?>
