<%@ page language="java" contentType="text/html; charset=EUC-KR" pageEncoding="EUC-KR"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- <!doctype html>
<html> -->
<head>
<title>test</title>
<script src="http://code.jquery.com/jquery.js" type="text/javascript"></script>
<script src="/jquery-tmpl-master/jquery.tmpl.js" type="text/javascript"></script>

<link href="/jquery-tmpl-master/demos/resources/demos.css" rel="stylesheet" type="text/css" />
<link href="/jquery-tmpl-master/demos/resources/movielist.css" rel="stylesheet" type="text/css" />

<script src="/common/js/common.js" type="text/javascript"></script>
<script src="/common/js/json_test_data.js" type="text/javascript"></script>
	
<script>
$( document ).ready(function() {
	$( "body" ).on( "click", "#btnClose", function() {
		window.opener.closePopup("´Ý±â.");
		self.close();
	});
});
</script>
</head>
<body>
<button id="btnClose">close</button>
</body>
</html>