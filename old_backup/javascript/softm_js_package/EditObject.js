    var editScript  = null;
    var editStyle   = null;

    /* Edit     OBJECT */
    var editObj     = null;
    /* 현재     OBJECT */
    var currentObj = null;
    /* 포커스   OBJECT */
    var currentFocusObj = null;
    /* 과거     OBJECT */
    var currentOldObj   = null;

    /* 0 : nonSelected, 1 : selected */
    var contentSelected = 0; 

    var xleft= 0;
    var ytop = 0;
    var editTier   = null;
    var editWindow = null;
    function EditObject ( tier, eScript, eStyle ){
        editTier   = tier;
        editWindow = eval( editTier );
        editWindow.document.onmousemove = MouseMove;
        editWindow.document.onmousedown = MouseDown;
        editWindow.document.onmouseup   = MouseUp;
        editWindow.document.onselectstart = DocumentSelect;
        editWindow.document.onkeydown     = keyCheck;
	    if (is.ns) editWindow.document.captureEvents(Event.MOUSEDOWN | Event.MOUSEMOVE | Event.MOUSEUP | Event.KEYDOWN);
        editElementConstruct( eScript, eStyle );
//      FrameResize( 1, 0, 'designPannel',"YES" );
    }

    function editElementConstruct( eScript, eStyle ) {
        // 스크립트 초기화
        editScript  = eScript;
        editStyle   = eStyle ;

        var inner = designDocument.body.innerHTML;
        var objStr = "";
        if ( p_mode == "insert" || p_mode == "temp_update") {
        alert ( p_mode );
           ReGeTemplate (designtier);
        } else if ( p_mode == "update" ) {
           ReGeTemplate (designtier);
        }

        for (var k=1;k<=itemCnt; k++) {
            var addID    = "" + k;

            if ( addID.length < 2 ) {
                addID = "KPLi0" + k;
            } else {
                addID = "KPLi" + k;
            }
            addID = addID + "_t";

            objStr  = addString( getTagStrById( addID, designtier, inner), editScript );
//          alert ( ' k : ' + k + " objStr : " + objStr );
            inner = replaceTagStrById(addID, objStr, designtier, inner);
        }
        designDocument.body.innerHTML = inner;
    }

    function setEditElement( obj ) {
        currentOldObj = currentObj;
        currentObj = editObj = obj;
    }

    function MouseDown(e){
        if ( editObj != null ) {
            currentObj = editObj;
        }

        if ( editObj != null ) {
            if ( typeof ( objectGB ) != "undefined" ) {
                objectGB = "1";
            }
        }
        if ( contentSelected != 0 ) {
            contentSelected = 0;
//          document.all["test"].innerHTML += "DocumentClick () : " + contentSelected + "<BR>"; 
        }
//      document.Panel_MainForm.p_tpl.value += "0/ objectGB : '" + objectGB + "')\n";
    }

    function MouseMove(e){
//	    return true;
    }

    function MouseUp () {
	    editObj    = null;
//	    currentObj = null;
        currentOldObj    = editObj; // 이전 객체를 보관
    }

    function DocumentSelect () {
        if ( contentSelected != 1 ) {
            contentSelected = 1;
//          document.all["test"].innerHTML += "DocumentSelect() : " + contentSelected + "<BR>"; 
        }
    }

    function clearCurrent(obj) {
        if ( obj != null) {
            obj = getObject(obj.id, editTier);
//          document.Panel_MainForm.p_tpl.value += "clearCurrent('" + obj.id + "')\n";
            obj.style.borderStyle ="none";
            obj.style.borderWidth ="0";
            obj.style.borderColor ="white";
            obj.style.cursor      ="hand";
        }
    }

    function clearCurrentObj(obj,zIndex) {
        if ( obj != null) {
            if (currentObj != null ) {
                currentObj = getObject(currentObj.id, editTier);
//              document.Panel_MainForm.p_tpl.value += "clearCurrentObj('" + currentObj.id + "')\n";
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
//              document.Panel_MainForm.p_tpl.value += "clearCurrentFocusObj ('" + obj.id + "')\n";
                currentFocusObj.style.borderStyle ="dashed";
                currentFocusObj.style.borderWidth ='0';
                currentFocusObj.style.borderColor ="white";
            }
        }
    }

    function keyCheck(event) {
        if ( typeof( event ) == 'undefined' ) {
            event = editWindow.event;
        }

        if ( currentObj != null && typeof ( currentObj.copytype ) != "undefined" && 
             currentObj.copytype == "none" &&
             event.ctrlKey && event.keyCode == 67 ) {
//            alert ( typeof ( currentObj.name ) );
//            alert ( "Ctrl-C"  ) ;
            return false;
        }
    }