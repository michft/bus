<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>Michael's bus class implementation.</title>
    <meta name="author" content="Michael Tomkins">
    <meta name="copyright" content="Michael Tomkins">
    <style type="text/css">
        .fail { background-color: red; font-weight: bold; color: white; }.pass { background-color: #00aa00; font-weight: bold; color: white; } div { text-align: center;}
    </style>
</head>
  <body>
    <?php
      require_once('./classes/bus.php');
      $bus = new Bus;
      $temp = 0;
      $tempS = "";
      $map = "AB5, BC4, CD8, DC8, DE6, AD5, CE2, EB3, AE7";
      $bus->makeSect($map);
      switch ((int)$_POST['test']) {
        case 1:
          $testFor = "1. The distance of the route A-B-C. ";
          $result = $bus->distRoute("A-B-C");
          break;
        case 2:
          $testFor = "2. The distance of the route A-D. ";
          $result = $bus->distRoute("A-D");
          break;
        case 3:
          $testFor = "3. The distance of the route A-D-C.";
          $result = $bus->distRoute("A-D-C");
          break;
        case 4:
          $testFor = "4. The distance of the route A-E-B-C-D.";
          $result = $bus->distRoute("A-E-B-C-D");
          break;
        case 5:
          $testFor = "5. The distance of the route A-E-D.";
          $result = $bus->distRoute("A-E-D");
          break;
        case 6:
          $testFor = "6. The number of trips starting at C and ending at C with a maximum of 3 stops.";
          $result = $bus->numRouteLTStop("C", "C", 3);
          break;
        case 7:
          $testFor = "7. The number of trips starting at A and ending at C with exactly 4 stops.";
          $result = $bus->numRouteEQStop("A", "C", 4);
          break;
        case 8:
          $testFor = "8. The length of the shortest route (in terms of distance to travel) from A to C.";
          $result = $bus->shortestRoute("A", "C");
          break;
        case 9:
          $testFor = "9. The length of the shortest route (in terms of distance to travel) from B to B.";
          $result = $bus->shortestRoute( "B", "B") ;
          break;
        case 10:
          $testFor = "10. The number of different routes from C to C with a distance of less than 30.";
          $result = $bus->numRouteLTLength( "C", "C", 30);
          break;
      default:
          $testFor = "Error, not expected test number. ";
          $result = "Therefore we can't test for it!";
      }
    ?>
    <div>
      <form action="buses.php" method="post">
        <p>Test Number: <input type="text" name="test" /></p>
        <p>Expected Output: <input type="text" name="expectResult" /></p>
        <p><input type="submit" /></p>
      </form>
      <?php
        echo "<p>\nTest is : $testFor";
        echo "<br>\nExpected result :" .  htmlspecialchars($_POST['expectResult']);
        echo "<br>\nTest Result :  $result </p>\n";
        if (htmlspecialchars($_POST['expectResult'])==$result) {
          echo "<h1 class=\"pass\" > Pass </h1>";
        } else {
          echo "<h1 class=\"fail\" > Fail </h1>";
        }
      ?>
    </div>
  </body>
</html>
