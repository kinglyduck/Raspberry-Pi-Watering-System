<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Automated Plant Watering System</title>

    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="vendor/simple-line-icons/css/simple-line-icons.css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Muli" rel="stylesheet">
    <link rel="stylesheet" href="device-mockups/device-mockups.min.css">
    <link href="css/new-age.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">

    <script>
    function myFunction(obj) {
      if (obj.value == "Toggle off") {
          obj.value = "Toggle on";
          document.getElementById(obj.name).src="images/off.png";
      } else {
          obj.value = "Toggle off";
          document.getElementById(obj.name).src="images/on.png";
      }
    }
    </script>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
      <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="#page-top">Automatic Plant Watering System</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          Menu
          <i class="fa fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="index.html">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="manual.php">Manual Control / Configuration</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <header class="masthead">
      <div class="container h-100">
        <div class="row h-100">
          <div class="col-lg-7 my-auto">
            <div class="header-content mx-auto">
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
               <table>
                 <tr>
                   <td>
                      <iframe name="frame" style="display:none;"></iframe>
                      <table>
                      <form action="Translation.php" method="post" target="frame">
                        <tr>
                          <?php
                            for ($i = 0; $i < 15; $i++) {
                                if ($i % 6 == 0) {
                                  echo "<tr>";
                                } else {
                                echo "<td><p>Plant $i</p>";
                                echo '<img src="images/' . $conf[$i] . '.png" alt="off" id="P' . $i . '" />';

                                if (strpos($conf[$i], "off") !== false) {
                                  echo '<input type="submit" name="P' . $i . '" value="Toggle on" onclick ="myFunction(this)" />';
                                } else {
                                  echo '<input type="submit" name="P' . $i . '" value="Toggle off" onclick ="myFunction(this)" /></td>';
                                }
                              }
                            }
                          ?>
                        </tr>
                      </form>
                    </table>
                  </td>
                  <td style="padding-left:100px;">
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
                      <p>Warning this will reset all pump power states to off.</p>
                  </form>
                </td>
              </tr>
            </table>
          </div>
        </div>
      </header>

      <script src="vendor/jquery/jquery.min.js"></script>
      <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
      <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
      <script src="js/new-age.min.js"></script>
  </body>
</html>
