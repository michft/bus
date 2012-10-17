<?php
    if (! defined('SIMPLE_TEST')) {
        define('SIMPLE_TEST', '../../simpletest/');
    }
    require_once(SIMPLE_TEST . 'unit_tester.php');
//    require_once(SIMPLE_TEST . 'reporter.php');
    require_once('show_pass.php');
    $test = &new GroupTest('All tests');
    $test->addTestFile('bus_test.php');
//   $test->addTestFile('gst_test.php');
//    $test->addTestFile('rover_test.php');
$test->run(new ShowPasses());
//    $test->run(new HtmlReporter());
?>

