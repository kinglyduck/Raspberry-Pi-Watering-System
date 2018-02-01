<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Watering Automation</title>
    <script>
    function myFunction(obj) {
      if (obj.value == "Toggle off") {
          obj.value = "Toggle on";
          document.getElementById(obj.name).src="images/off.jpg";
      } else {
          obj.value = "Toggle off";
          document.getElementById(obj.name).src="images/on.jpg";
      }
    }
    </script>
  </head>
  <body>
    <?php
        $file_handle = fopen("configuration.txt", "rb");
        $conf;
        $COUNTER = 0;

        while (!feof($file_handle) ) {
        $line_of_text = fgets($file_handle);

          if (strpos($line_of_text, "=") !== false) {
            $parts = explode('=', $line_of_text);
            $conf[$COUNTER] = $parts[1];
            $COUNTER++;
          }
        }
        fclose($file_handle);
     ?>

    <H1>Automated Plant Watering System</H1>

    <iframe name="frame" style="display:none;"></iframe>
    <table border="1">
     <tr>
       <?php
        for ($i = 1; $i < 16; $i++) {
          echo "<th>Plant $i</th>";
        }
       ?>
     </tr>
     <tr>
       <?php
       for ($i = 0; $i < 15; $i++) {
         echo '<td><img src="images/' . $conf[$i] . '.jpg" alt="off" id="P' . $i . '" /></td>';
       }
       ?>
     </tr>

    <form action="Translation.php" method="post" target="frame">
      <tr>
        <?php
        for ($i = 0; $i < 15; $i++) {
          if (strpos($conf[$i], "off") !== false) {
            echo '<td><input type="submit" name="P' . $i . '" value="Toggle on" onclick ="myFunction(this)" /></td>';
          } else {
            echo '<td><input type="submit" name="P' . $i . '" value="Toggle off" onclick ="myFunction(this)" /></td>';
          }
        }
        ?>
      </tr>
    </form>
  </table>
  <br><br>
  <form action="Translation.php" method="post" target="frame">
  <H1>Scheduling/Timing</H1>
    <p>Scheduling:
      <span>
        <?php
          echo '<input type="text" name="schedule" value="' . $conf[16] . '" />';
        ?>
        <a href="http://www.nncron.ru/help/EN/working/cron-format.htm">cronjob formatting</a>
      </span>
    </p>

    <p>Watering level:
    <span>
      <select name="level">
         <option value="Light">Light</option>
         <option value="Moderate">Moderate</option>
         <option value="Heavy">Heavy</option>
        </select>
      </span>
      <?php
        echo "Current level: " . $conf[17];
      ?>
    </p>
    <input type="submit" name="save" value="Save Configuration" onclick="window.location.reload();"/>
    <p>Warning this will reset any pump power states above.</p>
  </form>

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>
