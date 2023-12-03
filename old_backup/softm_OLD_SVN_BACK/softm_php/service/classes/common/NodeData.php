<?php
/**
 * @author softm
 * NodeData / NodeData.php
 */
class NodeData extends stdClass {
	public function __construct() {
// 		parent::__construct();
	}
	function setAttribute ($k,$v) {
		$this->$k = $v;
	}
	function createElement ($k) {
		$this->$k=new NodeData();
		return $this->$k;
	}
	protected $idx = -1;
	function appendChild ($v) {
		$k = $this->idx++;
		$this->${k} = $v;
// 		if ( $appendRoot instanceof NodeData ) {

// 		} else {

// 		}
// 		$this[] = $v;
	}
	function createCDATASection ($v) {
		return $v;
	}
// 	setAttribute("title", strtolower($k));
}
?>