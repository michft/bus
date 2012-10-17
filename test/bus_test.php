<?php
    if (! defined('SIMPLE_TEST')) {
        define('SIMPLE_TEST', '../../simpletest/');
    }
    require_once(SIMPLE_TEST . 'unit_tester.php');
    require_once('../classes/bus.php');

    class TestOfBus extends UnitTestCase {

    function testBus() {
	echo "<h3>Starting Bus Tests</h3>\n<p>";

	$bus = new Bus;
	$temp = 0;
	$tempS = "";
	$map = "AB5, BC4, CD8, DC8, DE6, AD5, CE2, EB3, AE7";
	$bus->makeSect($map);
//	echo "Graph string is $map <br>\nSection array is " ;
//	print_r($bus->sectionArr);
//	echo "</p>\n<p>" ;
        echo "1. Test the distance of the route A-B-C = " . $temp=$bus->distRoute("A-B-C"). " <br>\nTest result : ";
	$this->assertEqual( 9 , $temp );
        echo "</p>\n<p>2. Test the distance of the route A-D = " . $temp=$bus->distRoute("A-D") . " <br>\nTest result : ";
        $this->assertEqual( 5 , $temp );
        echo "</p>\n<p>3. Test the distance of the route A-D-C = " . $temp=$bus->distRoute("A-D-C") . " <br>\nTest result : ";
        $this->assertEqual( 13 , $temp );
        echo "</p>\n<p>4. Test the distance of the route A-E-B-C-D = " . $temp=$bus->distRoute("A-E-B-C-D") . " <br>\nTest result : ";
        $this->assertEqual( 22 , $temp );
        echo "</p>\n<p>5. Test the distance of the route A-E-D = " . $temp=$bus->distRoute("A-E-D") ;
	echo " <br>\nTest result : ";
        $this->assertEqual( "NO SUCH ROUTE" ,  $temp );
        echo "</p>\n<p>6. Test the number of trips starting at C and ending at C with a maximum of 3 stops. <br>\nTest result : ";
	$this->assertEqual( 2 , $bus->numRouteLTStop("C", "C", 3) );
        echo "</p>\n<p>7. The number of trips starting at A and ending at C with exactly 4 stops. <br>\nTest result : ";
	$this->assertEqual( 3 , $bus->numRouteEQStop("A", "C", 4) );
        echo "</p>\n<p>8. Test the length of the shortest route (in terms of distance to travel) from A to C. <br>\nTest result : ";
        $this->assertEqual( 9 , $bus->shortestRoute("A", "C") );
        echo "</p>\n<p>9. Test the length of the shortest route (in terms of distance to travel) from B to B. <br>\nTest result : ";
        $this->assertEqual( 9 , $bus->shortestRoute( "B", "B") );
        echo "</p>\n<p>10. Test the number of different routes from C to C with a distance of less than 30. <br>\nTest result : ";
        $this->assertEqual( 7 , $bus->numRouteLTLength( "C", "C", 30));

	echo "</p>\n<p>Stoping Bus Tests</p>\n";

	unset($bus);
}


    }

?>

