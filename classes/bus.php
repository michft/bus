<?php

  class Bus {

    public $sectionArr = array(); // Array of sections.
    public $treeArr = array(); // Tree array of possible routes.
    public $cityArr = array(); // City array.
    public $depth = 0 ; // Depth in stops.
    public $length = 0 ; // Lenght in section units.

    /**
    *  makeSect (String)
    *  Sets $this->sectionArr
    *  Expect City letter, Different City Letter, 
    *    Distance [1-9] sepparated by ", "
    *  No duplicate sections, eg. "AB5, AB3" not allowed.
    *  @param string $mapStr    The incoming section graph.
    */

    function makeSect($mapStr) {
      $this->sectionArr = str_split(str_replace ( ", " , "" , $mapStr), 3);
      return 1;
    }

    /**
    *  distSection(String, String)
    *  Finds the length of supplied section.
    *  $sectionArr most be set
    *  @param string $from    The start City value.
    *  @param string $to    The finish city value
    *  Returns length [1-9] or 0 if not found
    */

    function distSection($from, $to) {
      for ($i=0; $i<count($this->sectionArr); $i++) {
        if (substr($this->sectionArr[$i],0,1) == $from &&
          substr($this->sectionArr[$i],1,1) == $to)
        return substr($this->sectionArr[$i],2,1);
      }
      return 0;
    }

    /**
    *  distRoute(String)
    *  Finds the length of supplied route.
    *  $sectionArr most be set
    *  @param string $routeStr    The route string [A-B(-C)*]
    *  Returns length or NO SUCH ROUTE if not a valid route
    */

    function distRoute($routeStr) {
      $length = 0;
      $i = 1;
      $sect = 0;
      $len = strlen($routeStr);
      while ($i < $len) {
        $sect = $this->distSection($routeStr[$i-1], $routeStr[$i+1]);
        if ($sect == 0) {
          return "NO SUCH ROUTE";
        } else {
          $length += $sect;
        }
        $i+=2;
      }
      return $length;
    }

    /**
    *  uniqueCity ()
    *  Finds the number of unique cities.
    *  $sectionArr most be set
    *  Returns number of different letters in $sectionArr as integer
    */

    function uniqueCity () {
      unset($this->cityArr);
      $this->cityArr[0] = substr($this->sectionArr[0],0,1);
      $this->cityArr[1] = substr($this->sectionArr[0],1,1);
      for ($i=1; $i<count($this->sectionArr); $i++) {
        $temp = 2*$i;
        $this->cityArr[$temp] = substr($this->sectionArr[$i],0,1);
        $temp++;
        $this->cityArr[$temp] = substr($this->sectionArr[$i],1,1);
      }
      return count(array_unique($this->cityArr, SORT_STRING));
    }

    /**
    *  shortestRoute(String, String)
    *  Finds the shortest route between supplied city letters.
    *  $sectionArr most be set, assumes route is possible.
    *  @param string $from    The start City value.
    *  @param string $to    The finish city value
    *  Returns length as integer.
    */

    function shortestRoute($from, $to) {
      $this->treeArr = array();
      $this->count = 0;
      $length = ($this->uniqueCity()-1)*9 ;
      $this->buildTreeLength("", $from, $to, $length, 0);
      for ($i=0; $i < count($this->treeArr); $i++) {
        if ($this->treeArr[$i]['dist'] < $length) {
          $length = $this->treeArr[$i]['dist'];
        }
      }
      return $length;
    }

    /**
    *  numRouteEQStop(String, String, Integer)
    *  Finds the number of routes of $num stops between
    *    supplied city letters.
    *  $sectionArr most be set, assumes route of length is possible.
    *  @param string $from    The start City value.
    *  @param string $to    The finish city value
    *  @param integer $num    The number of stops.
    *  Returns number of stops as integer. Can be 0.
    */

    function numRouteEQStop($from, $to, $num) {
      unset($treeArr);
      $this->count = 0;
      $this->buildTreeStop("", $from, $to, $num, 0);
      $numEQ = count($this->treeArr);
      for ($i=0; $i < $numEQ; $i++) {
        if ($this->treeArr[$i]['dist'] != $num) {
          unset($this->treeArr[$i]);
        }
      }
      return count($this->treeArr);
    }

    /**
    *  numRouteLTLength(String, String, Integer)
    *  Finds the number of routes less than length
    *    between supplied city letters.
    *  $sectionArr most be set.
    *  @param string $from    The start City value.
    *  @param string $to    The finish city value
    *  @param integer $length    The number of stops.
    *  Returns number of stops as integer. Can be 0.
    */

    function numRouteLTLength($from, $to, $length) {
      unset($this->treeArr);
      $this->count = 0;
      $this->buildTreeLength("", $from, $to, $length, 0);
      return count($this->treeArr);
    }

    /**
    *  numRouteLTStop(String, String, Integer)
    *  Finds the number of routes less than $maxStop stops
    *    between supplied city letters.
    *  $sectionArr most be set.
    *  @param string $from    The start City value.
    *  @param string $to    The finish city value
    *  @param integer $maxStop    The maximum number of stops.
    *  Returns number of stops as integer. Can be 0.
    */

    function numRouteLTStop($from, $to, $maxStop) {
      unset($this->treeArr);
      $this->count = 0;
      $this->buildTreeStop("", $from, $to, $maxStop, 0);
      return count($this->treeArr);
    }

    /**
    *  buildTreeStop(String, String, String, Integer, Integer)
    *  Finds the tree for number of routes less than $maxStop stops
    *    between supplied city letters.
    *  $sectionArr most be set.
    *  @param string $str    The route string (initally "").
    *  @param string $from    The start City value.
    *  @param string $to    The finish city value
    *  @param integer $maxStop    The maximum number of stops.
    *  @param integer $i    The position in the parent call for loop.
    *  Returns 1 for successful completion. Sets $treeArr.
    */

    function buildTreeStop($str, $from, $to, $maxStop, $i) {
      $str .= $from;
      for ($i; $i<count($this->sectionArr); $i++) {
        if (substr($this->sectionArr[$i],0,1) == $from) {
          $this->depth++;
          if ( $this->depth > $maxStop ) {
            $this->depth--;
            return 1 ;
          }
          if (substr($this->sectionArr[$i],1,1)  == $to ) {
            $this->treeArr[$this->count] = array('route'=>$str.$to,'dist'=>$this->depth);
            $this->count++;
// All sub-trees of finishing city eg. C to C of A to C tree.
            $this->buildTreeStop( $str , $to ,$to, $maxStop, 0);
            $this->depth--;
            $i++;
            $str=substr($str,0 ,-1);
// All next branches, keep tree depth and continue.
            $this->buildTreeStop($str ,  $from ,$to, $maxStop, $i);
            return 1;
          }
// First branch from a node.
          $this->buildTreeStop( $str , substr($this->sectionArr[$i],1,1) ,$to, $maxStop, 0);
          $this->depth--;
        }
      }
      return 1 ;
    }

    /**
    *  buildTreeLength(String, String, String, Integer, Integer)
    *  Finds the tree for number of routes less than $maxDist length 
    *    between supplied city letters.
    *  $sectionArr most be set.
    *  @param string $str    The route string (initally "").
    *  @param string $from    The start City value.
    *  @param string $to    The finish city value
    *  @param integer $maxDist    The maximum length of routes.
    *  @param integer $i    The position in the parent call for loop.
    *  Returns 1 for successful completion. Sets $treeArr.
    */

    function buildTreeLength($str, $from, $to, $maxDist, $i) {
      $str .= $from;
      for ($i; $i<count($this->sectionArr); $i++) {
        if (substr($this->sectionArr[$i],0,1) == $from) {
          $this->length += $this->distSection($from, substr($this->sectionArr[$i],1,1));
          if ( $this->length >= $maxDist ) {
            $this->length -= $this->distSection($from, substr($this->sectionArr[$i],1,1)) ;
            return 1 ;
          }
          if (substr($this->sectionArr[$i],1,1)  == $to ) {
            $this->treeArr[$this->count] = array('route'=>$str.$to,'dist'=>$this->length);
            $this->count++;
// All sub-trees of finishing city eg. C to C of A to C tree.
            $this->buildTreeLength($str, $to, $to, $maxDist, 0);
            $this->length -= $this->distSection($from, $to);
            $i++;
            $str=substr($str,0 ,-1);
// All next branches, keep tree depth and continue.
            $this->buildTreeLength($str,  $from, $to, $maxDist, $i);
            return 1;
          }
// First branch from a node.
          $this->buildTreeLength($str, substr($this->sectionArr[$i],1,1) ,$to, $maxDist, 0);
          $this->length -= $this->distSection($from, substr($this->sectionArr[$i],1,1));
        }
      }
      return 1 ;
    }

  }
?>
