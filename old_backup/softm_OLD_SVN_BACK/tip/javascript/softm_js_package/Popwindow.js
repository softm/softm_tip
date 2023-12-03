<!--
var example  = null;
var example1 = null;

/***************************************************/
/*** 함수 명   | f_winpop   ************************/
/**************|************************************/
/*** Argument1 | Page 주소   ***********************/
/*** Argument2 | Window 이름 ***********************/
/*** Argument3 | Properties  ***********************/
/*** Argument4 | 가로 높이   ***********************/
/*** Argument5 | 세로 높이   ***********************/
/*** Argument6 | X 좌표      ***********************/
/*** Argument7 | Y 좌표      ***********************/
/***************************************************/

function f_winpop(url){
  var args = f_winpop.arguments;
  var window_name, window_properties, window_width, window_height, window_left, window_top ;

    window_name       = args[1];
    window_properties = args[2];
    window_width      = args[3];
    window_height     = args[4];
    window_left       = args[5];
    window_top        = args[6];

    if ( window_left == "" || window_left == null ) { window_left = ( screen.width - window_width  ) / 2; }
    if ( window_top  == "" || window_top  == null ) { window_top  = ( screen.height- window_height ) / 2; }
    
    var properties;
    if ( window_properties == null || window_properties == "" ) {
        properties = "toolbar=no,menubar=no,resizable=no,scrollbars=no,top=" + window_top + ",left=" + window_left;
    } else {
        properties = window_properties + ",top=" + window_top + ",left=" + window_left;
    }
    properties = properties + ", width=" + window_width + " ,height=" + window_height;

//    alert ( properties );
    var name;
    if ( window_name == null || window_name == "" ) {
        name = "example";
    } else {
        name = window_name;
    }
    if ( example == null ) {
        example = window.open(url,name,properties);
    } else {
        example.close();
        example = window.open(url,name,properties);
    }
    return example;
}
/***************************************************/
/*** 함수 명   | f_ModalDialog *********************/
/**************|************************************/
/*** Argument0 | Page 주소   ***********************/
/*** Argument1 | Window 이름 ***********************/
/*** Argument2 | Properties  ***********************/
/*** Argument3 | 가로 높이   ***********************/
/*** Argument4 | 세로 높이   ***********************/
/*** Argument5 | X 좌표      ***********************/
/*** Argument6 | Y 좌표      ***********************/
/*** Argument7 | 구분 ( Modal, Modeless ) **********/
/***************************************************/

function f_ModalDialog(url) {
  var args = f_ModalDialog.arguments;
  var window_width,window_height, window_left, window_top ;
    url = args[0];
    window_name       = args[1];
    window_properties = args[2];
    window_width      = args[3];
    window_height     = args[4];
    window_left       = args[5];
    window_top        = args[6];
    gubun             = args[7];

//alert ( "window_left : " + window_left ); 
//alert ( "window_top : " + window_top );
    if ( window_left == "" ) { window_left = ( screen.width - window_width  ) / 2; }
    if ( window_top  == "" ) { window_top  = ( screen.height- window_height ) / 2; }
//alert ( "window_left : " + window_left );
//alert ( "window_top : " + window_top );

    var properties;
    if ( window_properties == null || window_properties == "" ) {
        properties = "dialogTop:" + window_top + ";dialogleft:" + window_left + ";status:true;px;dialogresizable=yes;";
    } else {
        properties = "dialogTop:" + window_top + ";dialogleft:" + window_left + ";" + window_properties;
    }
    properties = properties + "dialogWidth:" + window_width + "px;dialogHeight:" + window_height + "px";
//    alert ( properties );
    var name;
    if ( window_name == null || window_name == "" ) { name = "example"; } else { name = window_name; }
    window.name = name;
    if ( gubun == 'Modal' ) {
        showModalDialog(url,window,properties);
    } else if( gubun == 'Modeless' ) {
        if ( example1 == null ) {
            example1 = showModelessDialog(url,window,properties);
        } else {
            example1.close();
            example1 = showModelessDialog(url,window,properties);
        }
    }
}
//-->