<?php
/**
 * @author softm
 * NodeData / NodeData.php
 */
class JSONDocument extends JSONNode {
	public function __construct() {
		// 		parent::__construct();
// 		$this->v=new JSONElement("v");
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
	public function setAttribute ($name, $value) {
		return new JSONElement($name);
	}
}
class JSONNode {
	public function __construct() {
		// 		parent::__construct();
	}

	function appendChild ($jel) {
		list($key, $val) = @each(get_object_vars($jel));
		if($jel instanceof JSONElement ||
		   $jel instanceof JSONDocument
		) {
			list($keyp, $valp) = @each(get_object_vars($this));
			if ( !$keyp ) {
				$this->{$key} = $jel->{$key};
// 				echo '1 : ' . $keyp . ' : ' . $key  . ' / ' . $val . '<BR>';
// 				var_dump($this);echo "<BR>";echo "<BR>";
			} else {
// 				echo '2 : ' . $keyp . ' : ' . $key  . ' / ' . $val . '<BR>';
// 				var_dump($this);echo "<BR>";echo "<BR>";
				if ( $this->{$keyp} ) {
					$jel = $this->{$keyp};
					$jel->{$key} = $val;
				} else {
				}
				$this->{$keyp} = $jel;
			}
		} else {
			list($key, $val) = @each(get_object_vars($this));
			$this->{$key} = $jel;
		}
	}

// 	public function __set($name, $value)
// 	{
// 		echo "Setting '$name' to '$value'\n";
// 		$this->data[$name] = $value;
// 	}
}
?>