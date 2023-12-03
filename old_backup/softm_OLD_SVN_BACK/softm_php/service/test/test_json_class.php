

<?php
class myData implements IteratorAggregate {
    public $property1 = "Public property one";
    public $property2 = "Public property two";
    public $property3 = "Public property three";

    public function __construct() {
        $this->property4 = "last property";
    }

    public function getIterator() {
        return new ArrayIterator($this);
    }
}

$obj = new myData;

foreach($obj as $key => $value) {
//     var_dump($key, $value);
    echo "\n";
}
$json = json_encode($obj);
// var_dump($json);

$data = new StdClass();
$data->submission = "Aaaaaaaaaaaa";
$json = json_encode($data);
//var_dump($json);
class JSONDocument extends JSONNode {
	public function __construct() {
		// 		parent::__construct();
		$this->v=null;
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
			list($keyp, $valp) = @each(get_object_vars($this));
			if ( !$keyp ) {
				echo '1 : ' . $keyp . ' : ' . $key  . ' / ' . $val . '<BR>';
// 				$this->{$key} = $jel->{$key};
				var_dump($this);echo "<BR>";echo "<BR>";
			} else {
				echo '2 : ' . $keyp . ' : ' . $key  . ' / ' . $val . '<BR>';
				var_dump($this);echo "<BR>";echo "<BR>";
				var_dump($jel);echo "<BR>";echo "<BR>";
// 				var_dump($jel);echo "<BR>";echo "<BR>";
				if ( $this->{$keyp} ) {
					$jel = $this->{$keyp};
					$jel->{$key} = $val;
				} else {
				}
				$this->{$keyp} = $jel;

// 				list($keypp, $valpp) = @each(get_object_vars($this->{$keyp}));
// 				echo '   3 : ' . $keypp . ' : ' . $valpp  . '<BR>';
				var_dump($this);echo "<BR>";echo "<BR>";
			}
		} else {
			list($key, $val) = @each(get_object_vars($this));
			$this->{$key} = $jel;
		}
	}

// 	public function __set($name, $value)
// 	{
// // 		echo "Setting '$name' to '$value'\n<BR>";
// // 		$this->data[$name] = $value;
// 	}
}

/**
 * @param $key string
 * @param $value string
 * @param $appendRoot DOM
 * @return DOMElement
 */
//     private function createNode($key,$value=NULL,DOMNode &$appendRoot=NULL) {
function createNode($key,$value=NULL,&$appendRoot=NULL) {
	global $dom;
   	$root = $dom;

	$rtn = $root->createElement($key);
	if( $value ) $rtn->appendChild($root->createCDATASection($value) );
	if ( RESPONSE_TYPE == DATA_TYPE_XML ) {
		if ( $appendRoot instanceof DOMNode ) $appendRoot->appendChild($rtn);
	} else if ( RESPONSE_TYPE == DATA_TYPE_JSON ) {
		if ( $appendRoot instanceof JSONNode) $appendRoot->appendChild($rtn);
	}
	return $rtn;
}

/**
 * @param string $name
 * @param string $value
 */
function appendNode($name,$value) {
	global $results;
	$newNode = createNode($name, $value, $resluts);
// 	var_dump($newNode);
	//echo sizeof($results);
	$results->appendChild($newNode);
}
define("RESPONSE_TYPE","DATA_TYPE_JSON");
// $dom = new JSONElement("v");
$dom = new JSONDocument();
$results = createNode('results',NULL,$dom);
appendNode('method',"aaaaaaa.aaa");
// appendNode('start_date',date('Y/m/d h:i:s A'));
// // appendNode('start_date1',array(
// //                                 "U"=>"사용",
// //                                 "S"=>"정지",
// //                                 "R"=>"탈퇴"
//                             ));
$pagenavi = createNode("pagenavi",NULL,$results);
createNode("how_many" ,"1",$pagenavi);
// createNode("more_many","2",$pagenavi);
// createNode("page_many","3",$pagenavi);
// createNode("total"    ,"4",$pagenavi);
// createNode("position" ,"5",$pagenavi);

// echo "<BR>";echo "<BR>";echo "<BR>";
// var_dump($pagenavi);
// echo "<BR>";echo "<BR>";echo "<BR>";
// var_dump($dom->v);
// echo "<BR>";echo "<BR>";echo "<BR>";
// var_dump($results);

// echo "<BR>";echo "<BR>";echo "<BR>";
$json = json_encode($dom->v);
var_dump($json);

// // echo "<BR>";
// // echo "<BR>";
// // echo "<BR>";
// // echo "<BR>";
// // echo "<BR>";

// // $myDetails = array();
// // foreach ($dom as $key => $value) {
// // // JSONElement
// // // 	if ($value instanceof StdClass) {
// // // 		$myDetails[$key] = $value->toArray();
// // // // 		echo "Aaaa";
// // // 	} else {
// // 		$myDetails[$key] = $value;
// // // 	}
// // 	echo $key . ' / '.$value . '<br>';
// // }
// // print_r($myDetails);
// // echo "<BR>";
// // echo "<BR>";
// // echo "<BR>";
// // print_r(get_object_vars($dom));
// function objectToArray($d) {
// 	if (is_object($d)) {
// 		// Gets the properties of the given object
// 		// with get_object_vars function
// 		$d = get_object_vars($d);
// 	}

// 	if (is_array($d)) {
// 		/*
// 			* Return array converted to object
// 		* Using __FUNCTION__ (Magic constant)
// 		* for recursive call
// 		*/
// 		return array_map(__FUNCTION__, $d->v);
// 	}
// 	else {
// 		// Return array
// 		return $d;
// 	}
// }
// function arrayToObject($d) {
// 	if ($d instanceof JSONDocument) {
// // 		echo 'ㅇㅇㅇㅇㅇㅇㅇㅇㅇㅇㅇㅇㅇㅇ';
// 		/*
// 			* Return array converted to object
// 		* Using __FUNCTION__ (Magic constant)
// 		* for recursive call
// 		*/
// 		return $d->v ? arrayToObject($d->v):null;
// 	}
// 	else {
// 		// Return object
// 		return $d;
// 	}
// }
// echo "<BR>";echo "<BR>";echo "<BR>";echo "<BR>";
// // $array = objectToArray($dom);
// // print_r($array);
// // var_dump(json_encode($array));

// var_dump($dom);
// echo "<BR>";echo "<BR>";echo "<BR>";echo "<BR>";
// // $object = arrayToObject($dom);
// // var_dump(json_encode($object));
// // print_r($object);
// // var_dump($object);
// var_dump(get_object_vars($dom));

// echo "<BR>";echo "<BR>";echo "<BR>";echo "<BR>";
// $v = new JSONElement("k_name");
// // print_r($v);
// // var_dump(get_object_vars($v));
// list($key, $val) = each(get_object_vars($v));
// echo $key;

// class testClass {
// 	public $aaa1 = "1";
// 	public $aaa2 = "2";
// 	public $aaa3 = "3";
// }
// $dom = new testClass();
// echo "<BR>";echo "<BR>";echo "<BR>";
// $dom->aaa4 = new testClass();
// $json = json_encode($dom);
// var_dump($json);
// echo "<BR>";echo "<BR>";echo "<BR>";
// var_dump($dom);

?>
