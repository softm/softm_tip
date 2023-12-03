    function loadingSwf(w,h,cMode) {
        this.areaWidth = w;
        this.areaHeight= h;
        this.areaLeft  = 0;
        this.areaTop   = 0;
        //this.swfWidth  = 400;
        //this.swfHeight = 400;
        this.swfType = 'c'; // bar, circle
        this.completeMode = cMode == null?true:cMode;
    }

    loadingSwf.prototype.print = function(){
        if ( !this.swfWidth ) {
            if ( this.areaWidth.indexOf('%') > 0 ) {
                if ( this.swfType == 'b' ) {
                    this.swfWidth  = 250;
                } else {
                    this.swfWidth  = 350;
                }
            } else {
                this.swfWidth = this.areaWidth;
            }
        }
        if ( !this.swfHeight ) {
            if ( this.areaHeight.indexOf('%') > 0 ) {

                if ( this.swfType == 'b' ) {
                    this.swfHeight  = 180;
                } else {
                    this.swfHeight  = 280;
                }
            } else {
                this.swfHeight = this.areaHeight;
            }
        }

        document.write("<span id=loading_swf style='position:absolute;width:" + this.areaWidth + ";height:" + this.areaHeight + ";left:" + this.areaLeft + ";top:" + this.areaTop + ";display:block;border:0px;z-index:10;'>");
        document.write("    <table width=100% height=100% border='0' cellpadding='0' cellspacing='0'>");
        document.write("        <tr>");
        document.write("        <td align=center height='100%'>");
        document.write( "<OBJECT classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0' WIDTH='" + this.swfWidth + "' HEIGHT='" + this.swfHeight + "'>"
                        +"  <PARAM NAME=movie   VALUE='./lib_inc/js/loading_" + this.swfType + ".swf'>"
                        +"  <PARAM NAME=quality VALUE=high>"
                        +"  <PARAM NAME=bgcolor VALUE=red>"
                        +"  <PARAM NAME='wmode' value='transparent'>"
                        +"  <EMBED src='./lib_inc/js/loading_" + this.swfType + ".swf' "
                        +" quality=high bgcolor=#FFFFFF wmode=transparent "
                        +"WIDTH='" + this.swfWidth + "' HEIGHT='" + this.swfHeight + "' ALIGN='middle' TYPE='application/x-shockwave-flash' PLUGINSPAGE='http://www.macromedia.com/go/getflashplayer'></EMBED>"
                        +"</OBJECT>");
        document.write("        </td>");
        document.write("        </tr>");
        document.write("    </table>");
        document.write("</span>");
        if ( this.completeMode ) {
            document.onreadystatechange= function () {
                if (document.readyState == 'complete') {
                    document.getElementById('loading_swf').style.display = 'none';
                }
            }
        } else {
            document.getElementById('loading_swf').style.display = 'none';
        }
    }

    loadingSwf.prototype.showSwf = function(){
        document.getElementById('loading_swf').style.display = '';
        //document.getElementById('loading_swf').style.VISIBILITY  = 'show';
    }

    loadingSwf.prototype.hideSwf = function(){
        document.getElementById('loading_swf').style.display = 'none';
        //document.getElementById('loading_swf').style.VISIBILITY  = 'hidden';
    }

    loadingSwf.prototype.setSwfSize = function(w, h){
        this.swfWidth  = w;
        this.swfHeight = h;
    }

    loadingSwf.prototype.setSwfPos = function(l, t){
        this.areaLeft = l;
        this.areaTop  = t;
    }

    loadingSwf.prototype.setSwfType = function(type){
        if ( type ) this.swfType = type.toLowerCase();
    }

    // 기본
    //var loadSwf = new loadingSwf('100%','100%',false);
    //loadSwf.setSwfSize (355,355);
    //loadSwf.setSwfPos  (200,100);
    //loadSwf.setSwfType ('B'); // circle
    //loadSwf.print();
    //alert ();
    //loadSwf.hideSwf();
    //loadSwf.hideSwf();

    // 구석탱이
    //var loadSwf = new loadingSwf('355','355');
    //loadSwf.setSwfSize (355,355);
    //loadSwf.setSwfPos  (0,468);
    //loadSwf.setSwfType ('B'); // circle
    //loadSwf.print();