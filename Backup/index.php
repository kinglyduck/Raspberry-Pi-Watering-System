<!DOCTYPE html>
<html>
  <head>
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
         echo '<td><img src="images/off.jpg" alt="off" id="P' . $i . '" /></td>';
       }
       ?>
     </tr>

    <form action="Translation.php" method="post" target="frame">
      <tr>
        <?php
        for ($i = 0; $i < 15; $i++) {
          echo '<td><input type="submit" name="P' . $i . '" value="Toggle on" onclick ="myFunction(this)" /></td>';
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
        <input type="text" name="schedule" />
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
    </p>
    <input type="submit" name="save" value="Save Configuration" onclick="window.location.reload();"/>
  </form>
  </body>
</html>
