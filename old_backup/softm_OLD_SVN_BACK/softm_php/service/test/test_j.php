<?php
class JSONDocument extends JSONNode {
	public function __construct() {
		// 		parent::__construct();
// 		$this->v=null;
	}

	function createElement ($name, $value = null) {
		return new JSONElement($name);
	}

	function createCDATASection ($v) {
		return $v;
	}
}

class JSONElement extends JSONNode{
	public function __construct($k) {
		// 		parent::__construct();
		$this->$k=null;
	}
}

class JSONNode {
	public function __construct() {
		// 		parent::__construct();
	}

	function appendChild (&$jel) {
		list($key, $val) = @each(get_object_vars($jel));
		if($jel instanceof JSONElement ||
		   $jel instanceof JSONDocument
		) {
// 			list($keyp, $valp) = @each(get_object_vars($this));
// 				$this->{$keyp} = $jel;
// 			var_dump($jel);
			echo '1 : ' . $key  . ' / ' . $val . '<BR>';
			$this->{$key} = &$jel;
		}
	}

// 	public function __set($name, $value)
// 	{
// 		echo "Setting '$name' to '$value'\n<BR>";
// // 		$this->data[$name] = $value;
// 	}
}
function createNode($key,$value=NULL,&$appendRoot=NULL) {
	global $dom;
	$root = $dom;

	$rtn = $root->createElement($key);
	if( $value ) $rtn->appendChild($root->createCDATASection($value) );
	if ( $appendRoot instanceof JSONNode) $appendRoot->appendChild($rtn);
	return $rtn;
}

function appendNode($name,$value) {
	global $results;
	$newNode = createNode($name, $value, $resluts);
	// 	var_dump($newNode);
	//echo sizeof($results);
	$results->appendChild($newNode);
}

$dom = new JSONDocument();
$results = createNode('results',NULL,$dom);
// var_dump($results);
appendNode('method1',"aaaaaaa.aaa");
// appendNode('pagenavi',null);
$pagenavi = createNode("pagenavi",null,$results);
createNode("how_many" ,"1",$pagenavi);

$json = json_encode($dom->v);
var_dump($json);
?>
