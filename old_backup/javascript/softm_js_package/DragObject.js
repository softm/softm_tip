    var dragScript  = null;
    var dragStyle   = null;

    /* DRAG     OBJECT */
    var dragObj    = null;
    /* 현재     OBJECT */
    var currentObj = null;
    /* 포커스   OBJECT */
    var currentFocusObj = null;
    /* 과거     OBJECT */
    var currentOldObj   = null;
    /* Add 된 객체 수 */
    var itemCnt       = 0;


    var xleft= 0;
    var ytop = 0;
    var dragtier   = null;
    var dragWindow = null;
    function DragObject( tier, dScript, dStyle ){
        dragtier   = tier;
        dragWindow = eval( dragtier );
        dragWindow.document.onmousemove = MouseMove;
        dragWindow.document.onmousedown = MouseDown;
        dragWindow.document.onmouseup   = MouseUp;
	    if (is.ns) dragWindow.document.captureEvents(Event.MOUSEDOWN | Event.MOUSEMOVE | Event.MOUSEUP );
        dragElementConstruct( dScript, dStyle );
    }

    function dragElementConstruct( dScript, dStyle ) {
        // 스크립트 초기화
        dragScript  = dScript;
        dragStyle   = dStyle ;

        var objStr = "";
        if ( p_mode == "update" ) {
            itemCnt = 7;
        }

        for (var k=1;k<=itemCnt; k++) {
            objStr  = addString( getTagStrById( "item" + k + "_t", designtier), dragScript );
//          alert ( ' k : ' + k + " objStr : " + objStr );
            replaceTagStrWriteById("item" + k + "_t",objStr, designtier);
        }
    }

    function clearCurrent(obj) {
        if ( obj != null) {
            obj = getObject(obj.id, dragtier);
            document.Panel_MainForm.p_tpl.value += "clearCurrent('" + obj.id + "')\n";
            obj.style.borderStyle ="none";
            obj.style.borderWidth ="0";
            obj.style.borderColor ="white";
            obj.style.cursor      ="hand";
        }
    }

    function clearCurrentObj(obj,zIndex) {
        if ( obj != null) {
            if (currentObj != null ) {
                currentObj = getObject(currentObj.id, dragtier);
                document.Panel_MainForm.p_tpl.value += "clearCurrentObj('" + currentObj.id + "')\n";
                currentObj.style.borderStyle ="none";
                currentObj.style.borderWidth ="0";
                currentObj.style.borderColor ="white";
                currentObj.style.cursor      ="hand";
//              currentObj.style.zIndex      =zIndex;
            }
        }
    }

    /* 영역 초기화 */
    function clearCurrentFocusObj (obj) {
        if ( obj != null) {
            if ( currentObj == null && ( currentFocusObj != null && obj.id != currentFocusObj.id ) ||
               ( currentObj != null && currentFocusObj != null && currentObj.id != currentFocusObj.id ) ) {
                document.Panel_MainForm.p_tpl.value += "clearCurrentFocusObj ('" + obj.id + "')\n";
                currentFocusObj.style.borderStyle ="dashed";
                currentFocusObj.style.borderWidth ='0';
                currentFocusObj.style.borderColor ="white";
            }
        }
    }

    function setDragElement( obj, eventName, data ) {
//      clearCurrentObj ( obj );
        currentOldObj = currentObj;
        currentObj = obj;
    }

    function MouseDown(e){
        if ( dragObj != null ) {
            currentObj = dragObj;
            xleft = dragObj.style.left;
            ytop  = dragObj.style.top;
            dragObj.style.cursor="move";
        }

        if (is.ie) {
            xleft = dragWindow.event.clientX - parseInt(xleft);
            ytop  = dragWindow.event.clientY - parseInt(ytop );
//                dragObj.style.zIndex += 1;
        } else if ( is.ns ) {
//	            if (e.target!=dragObj) routeEvent(e)
            xleft = e.pageX - parseInt(xleft);
            ytop  = e.pageY - parseInt(ytop );
//                dragObj.style.zIndex += 1;
        }

        if ( dragObj != null ) {
            if ( typeof ( objectGB ) != "undefined" ) {
                objectGB = "1";
            }
        }
    }

    function MouseMove(e){
        if (dragObj == null) { return; }
        if (is.ie) {
            if ( dragObj != null ) {
                objectMoveTo(dragObj,dragWindow.event.clientX - xleft,dragWindow.event.clientY - ytop, dragtier)
            }
            dragWindow.event.returnValue = false;
        } else if ( is.ns ) {
            if ( typeof ( dragObj.style.left ) == 'string') { 
                if ( dragObj != null ) {
                    objectMoveTo(dragObj,e.pageX - xleft,e.pageY - ytop, dragtier);
                }
            }
            e.returnValue = false;
        }
        if ( dragObj != null ) {
            dragObj.style.cursor      ="move";
//            dragObj.style.zIndex += 1;
        }
//	    return true;
    }

    function MouseUp (){
        if ( dragObj != null ) {
            dragObj.style.cursor="hand";
        }
	    dragObj    = null;
//	    currentObj = null;
        currentOldObj    = dragObj; // 이전 객체를 보관
	    if (is.ns) dragWindow.document.releaseEvents(Event.MOUSEDOWN | Event.MOUSEMOVE | Event.MOUSEUP);

    }
