<?php
    if (! defined('SIMPLE_TEST')) {
        define('SIMPLE_TEST', 'simpletest/');
    }
    require_once(SIMPLE_TEST . 'reporter.php');

    class ShowPasses extends HtmlReporter {

        function ShowPasses() {
            $this->HtmlReporter();
        }

        function paintPass($message) {
            parent::paintPass($message);
            print "<span class=\"pass\">Pass</span>: ";
         //   $breadcrumb = $this->getTestList();
          //  array_shift($breadcrumb);
        //    print implode("-&gt;", $breadcrumb);
      //      print "XXX"
            print "$message<br />\n";
        }

        function _getCss() {
            return parent::_getCss();
        }

    }
?>

