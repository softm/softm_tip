<?
@header("Content-type: text/html; charset=euc-kr");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv='Content-Type' content='text/html;charset=euc-kr'>
<title>���ͳ� ������ Ŀ�´����̼� ä�� �����κ���</title>
</head>
<body>
<?
$baseDir = "../";
include $baseDir.'common/lib.inc'       ; // ���� ���̺귯��

include $baseDir.'common/board_lib.inc' ; // �Խ��� ���̺귯��
include $baseDir.'common/poll_lib.inc'  ; // ���� ���̺귯��
include $baseDir.'common/event_lib.inc' ; // �̺�Ʈ ���̺귯��
include $baseDir.'common/member_lib.inc'; // ��� ���̺귯��

include $baseDir.'common/message.inc'   ; // ���� ������ ó��
include $baseDir.'common/db_connect.inc'; // Data Base ���� Ŭ����

$doc = new DOMDocument();
$doc->loadHTML('&lt;!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"><body onload="alert(0);"><?echo "xxxxxx";?>');
$content = preg_replace('/^<!DOCTYPE.+?>/', '', str_replace( array('<html>', '</html>', '<body>', '</body>'), array('', '', '', ''), $doc->saveHTML()));
echo $content;
$content = str_replace( '<', '&lt;', $content);
$content = str_replace( '>', '&gt;', $content);
echo $content;

$title = '<input>aaaaaaaaaaa <input>aaaaaaaaaaa';
echo '<xmp>'.$title. "</xmp><BR/>";
//echo preg_replace("/^<(\/)?(.*)(\/)?(>)?/i",'$2',$title  ) . "<BR/>";
//echo preg_replace("/(<\/?)(\w+)([^>]*>)/i",'$2',$title  ) . "<BR/>";
//echo preg_replace("/(<\/?)(.*)([^>]*>)/i",'$2',$title  ) . "<BR/>";
echo 'input : ' . preg_replace("/<([A-Z][A-Z0-9]*)\b[^>]*>(.*?)</\1>/i",'$2',$title  ) . "<BR/>";

/*
echo preg_replace('/(<(\w+)[^>]*>)(.*?)(<\/(\w+)>)/i','$1$3',$title  ) . "<BR/>";
echo "<BR/>";
echo "<BR/>";
echo "<BR/>";
echo '3: ' . preg_replace("/^<(\/)?(.*)(\/)?(>)?/i",'$3',$title  ) . "<BR/>";
echo '3: ' . preg_replace("/(<\/?)(\w+)([^>]*>)/i",'$3',$title  ) . "<BR/>";
echo '3: ' . preg_replace("/(<\/?)(.*)([^>]*>)/i",'$3',$title  ) . "<BR/>";
*/
$string = 'April 15, 2003';
$pattern = '/(\w+) (\d+), (\d+)/i';
$replacement = '${1}   1,$3';
echo preg_replace($pattern, $replacement, $string);

	$content = "\n11111111111<xmp >����..\n<b>test</b></xmpbaaaaaaaaaaaaaaaaaaaa";
	$content .= "\n2222222222<xmp><b>test</b></xmp>";
	$content .= "\n3333333<XMP ><b>test</b></XMPbaaaaaaaaaaaaaaaaaaaa";
	$content .= "\n4444444444<XMP><b>test</b></XMP>";
	$content .= "\n5555555555555<MPX><b>test</b></XMP>";
	//echo $content;
	print("<div style='width:800px;height:100px;background-color:blue'>${content}</div><BR>����������������������������������������������������������<BR>\n<div style='width:800px;height:100px;background-color:red'>" . preg_replace("/<(\/)?xmp(\/)?(>)?/i", "", $content) . "</div><BR><BR>\n");
	print("<textarea style='width:800px;height:100px'>${content}</textarea><BR>����������������������������������������������������������<BR>\n<textarea style='width:800px;height:100px'>" . preg_replace("/<(\/)?xmp(\/)?(>)?/i", "", $content) . "</textarea>\n");
	$name = "��ԤԤԤԤԤԤԤԤԤԤԤԤԤԤԤԤԤ� �� ������������������������������";
	$name    = preg_replace("(��|��)","",$name  ); // �������1, �������2

	set_time_limit ( 0 );
	$db = initDBConnection ();
	$id= "test";
	$no= "2165";
	include "../common/lib/MYSQL/bbs_one_row_retrive.php";

	$html_yn = $data["html_yn"];
	$mode = "update";
	$mode = "view";
    function f(&$v) {
         $v=$v . 'aaa';
    	return $v . 'aaa';
    }
	if ( $mode == "view" ) {
			$filterPattern = "/<(\/)?xmp(\/)?(>)?/i";
			$name    = preg_replace($filterPattern, "", $name   );
			$title   = preg_replace($filterPattern, "", $title  );
			$content = preg_replace($filterPattern, "", $content);
			$link1   = preg_replace($filterPattern, "", $link1  );
			$link2   = preg_replace($filterPattern, "", $link2  );
            if ( $html_yn == 'B' ) { // HTML <BR>  [B]
            	$content = autoLink ($content); // �ڵ� ��ũ
            	$content = nl2br ( $content );   /* ���� */
            } else if ( $html_yn == 'Y' ) { // HTML [Y]
            	$content = autoLink ($content); // �ڵ� ��ũ
            } else { // PLAN TEXT [N]
            	$content = str_replace("<","&lt;",$content);
            	$content = autoLink ($content); // �ڵ� ��ũ
            	$content = str_replace("  ", "&nbsp;&nbsp;", $content );
            	$content = str_replace("\t", "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",$content );
            	$content = nl2br ( $content );   /* ���� */
            }
            f($name);
		    echo 'name : ' .$name.'<br/>';
	} else {
		$filterPattern = "/<(\/)?(xmp|textarea)(\/)?(>)?/i";
		$name    = preg_replace($filterPattern, "", $name   );
		$title   = preg_replace($filterPattern, "", $title  );
		$content = preg_replace($filterPattern, "", $content);
		$link1   = preg_replace($filterPattern, "", $link1  );
		$link2   = preg_replace($filterPattern, "", $link2  );
		echo "<textarea style='width:70%;height:400px'>" . $content . "</textarea>";
	}
	closeDBConnection (); // �����ͺ��̽� ���� ���� ����
?>
</body>
</html>