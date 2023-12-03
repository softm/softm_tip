<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<%@include file="/inc/common.jsp" %>
<%@include file="/inc/header.jsp" %>
<script src="/js/json_test_data.js" type="text/javascript"></script>
<script>
$( document ).ready(function() {
	$( "body" ).on( "click", "#btnList", function() {
		//debugger;
		//TODO SOFTM
		var jsonStrData = JSON.stringify(movies);		
		  exec("/testods.do", "data="+jsonStrData,function(data) {
			  console.info(data);
              showLoading();
			  $( "#movieList" ).empty();
			  $( "#movieTemplate" ).tmpl( movies ).appendTo( "#movieList" );
              hideLoading();
		  });
	});
	$( "body" ).on( "click", "#btnAlert", function() {
		alert("test");
	});
	$( "body" ).on( "click", "#btnConfirm", function() {
		confirm("test");
	});
	$( "body" ).on( "click", "#btnToast", function() {
		toast("test",function(){alert("callback")});
	});
	$( "body" ).on( "click", "#btnWindowOpen", function() {
		window.open("new_window.jsp");
	});
	$( "body" ).on( "click", "#btnDialogMessage", function() {
	    $( "#dialog-message" ).dialog({
	        modal: true,
	        buttons: {
	          Ok: function() {
	            $( this ).dialog( "close" );
	          }
	        }
	      });
	});
	$( "body" ).on( "click", "#btnDialog", function() {
	    $("#dialog").dialog({
	        autoOpen: true,
	        modal: true,
	        resizable: true,
	        height: 'auto',
	        width: 'auto',
	        show: "fade",
	        hide: "fade",	        
	        open: function(ev, ui){
	           $('#myIframe').attr('src','popup.jsp');
	        }
	    });
	});
	
	$( "body" ).on( "click", "#nextPage", function() {
//		
	    var options = {};		
		$( "#page2" ).show( "slide", options, 500, function() {
			$("#page1").hide();
		} );		
	});
	
	$( "body" ).on( "click", "#prevPage", function() {
	    var options = {direction:"left"};
		$("#page1").show();	    
		$( "#page2" ).hide( "slide", options, 500, function() {

		} );		
	});
	$( "body" ).on( "click", "#btnSnakBar", function() {
		snakBar("test");
	});
	$( "body" ).on( "click", "#getBasicInformation", function() {
		loadBasicInformation();
		alert(INFO.MAC_ADDRESS);
	});
});

function closePopup(rtn) {
	//alert("close : " + rtn);
	$("#dialog").dialog("close");
}
</script>
<style>

</style>
</head>
<body>
<div class='main' id="page1">
	<button id="getBasicInformation">getBasicInformation(String v)</button>
	<button id="btnList">list</button>
	<button id="btnAlert">alert</button>
	<button id="btnConfirm">confirm</button>
	<button id="btnToast">toast</button>
	<button id="btnWindowOpen">window.open</button>
	<button id="btnDialogMessage">dialogMessage</button>
	<button id="btnDialog">dialog</button>
	<button id="nextPage">nextPage</button>
	<button id="btnSnakBar">snakBar</button>
	
	<script id="movieTemplate" type="text/x-jquery-tmpl">
	<tr>
		<td>\${Title}</td>
		<td>Languages:
			<em>
				{{each Languages}}
					\${$value.Name}
				{{/each}}
			</em>
		</td>
	</tr>
	</script>
	
	<table><tbody class="header"><tr><th>Synopsis</th><th>Title</th></tr></tbody>
		<tbody id="movieList"></tbody>
	</table>
	</div>
	
<div class='main hide' id="page2">
	<button id="prevPage">prevPage</button> 
 두번째페이지.
<div>

<div id="dialog" title="Download complete" style="display:none">
    <iframe id="myIframe" src="" frameborder="0" marginwidth="0" marginheight="0" allowfullscreen></iframe>
</div>


	<div id="dialog-message" title="Download complete" style="display:none">
	  <p>
	    <span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
	    Your files have downloaded successfully into the My Downloads folder.
	  </p>
	  <p>
	    Currently using <b>36% of your storage space</b>.
	  </p>
	</div>
<div class="mo-ui-snackbar" style="display: none; z-index: 1000;"><p>수신처를 입력하세요.</p></div>

<%@include file="/inc/footer.jsp" %>