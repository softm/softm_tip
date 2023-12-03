<?php
function appendNode($name,$value) {
    global $results;
    $newNode = createNode($name, $value, $resluts);
    $results->appendChild($newNode);
}
function createNode($key,$value=NULL,DOMNode $appendRoot=NULL) {
    global $dom;
    $rtn = $dom->createElement($key);
    if( $value ) $rtn->appendChild($dom->createCDATASection($value) );
    if ( $appendRoot instanceof DOMNode ) $appendRoot->appendChild($rtn);
    return $rtn;
}
//phpinfo();
$data = new StdClass();
//$data->result = "result";
$result = $data->{"result"} = new StdClass();
//$result = new StdClass();
$result->{"data"} = "data";

//$json = json_encode($data);
//var_dump($json);

class JSONNode  {
    public function __construct() {
        // parent::__construct();
        $this->v=null;
    }
}

class JSONElement extends JSONNode{
    public function __construct($k) {
        //      parent::__construct();
        $this->$k=null;
    }

    function appendChild() {
        var_dump(self);
    }
}
//new StdClass()
class JSONDocument implements JsonSerializable {
    public $v = null;
    function createElement ($name, $value = null) {
        return new JSONElement($name);
    }
    public function jsonSerialize() {
        return $this->v;
    }
}

$dom = new JSONDocument();
//$dom = new DOMDocument('1.0', 'UTF-8');

$results = createNode('results',"test",$dom);

$dom->appendChild($rtn);

$rtn = $root->createElement($key);
if( $value ) $rtn->appendChild($root->createCDATASection($value) );
if ( $appendRoot instanceof DOMNode ) $appendRoot->appendChild($rtn);

//$results2 = createNode('results2',"test2",$dom);
//appendNode('method',"aaaaaaa.aaa");

$json = json_encode($dom);
var_dump($json);

?>


