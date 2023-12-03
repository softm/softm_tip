/*
    var loading = new loadingDisplay('ajax-loader.gif','image');
    loading.show();
    loading.setTarget('tt1');
    loading.setSize('50px','50px');

    var loading = new loadingDisplay('ajax-loader.gif','image');
    loading.show();
    loading.setTarget('tt2');
    loading.setSize('50px','50px');

    var loading = new loadingDisplay("loading_c.swf",'swf');
    loading.show();
    loading.setTarget('tt3');
    loading.setSize('50px','50px');

    var loading = new loadingDisplay("로딩중",'html');
    document.getElementById(loading.id).style.backgroundColor = 'red';
    document.getElementById(loading.id).style.textAlign       = 'center';
    loading.show();
    loading.setTarget('tt4');
    loading.setSize('150px','150px');
*/

    function loadingDisplay(src,ty,tg) {
        this.id         = 'loading_' + (Math.floor(Math.random() * 1000) + 1);
        this.width      = '';
        this.height     = '';
        this.src        = src?src:'';

        this.target     = tg?tg:document.documentElement;
        this.type       = ty?ty:'image';
        var info = this.src.split('.');
        this.file_type  = info.length>0?this.src.split('.')[info.length-1].toLowerCase():'';
        this.print();
    }

    loadingDisplay.prototype.print = function(){
        var attrStr = "id='" + this.id + "' style='position:absolute" + (this.width?';width:'+this.width:'') + "" + (this.height?';height:'+this.height:'') + ";left:0;top:0;display:none;border:0px;z-index:10;'";
        if (this.type == 'swf') {
            if (document.all) {
                document.write( "<OBJECT " + attrStr + ""
                                +" classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0' WIDTH='" + this.width + "' HEIGHT='" + this.height + "'>"
                                +"  <PARAM NAME=movie   VALUE='" + this.src + "'>"
                                +"  <PARAM NAME=quality VALUE=high>"
                                +"  <PARAM NAME=bgcolor VALUE=red>"
                                +"  <PARAM NAME='wmode' value='transparent'>"
                                +"</OBJECT>");
            } else {
                document.write( "<EMBED " + attrStr + " src='" + this.src + "' "
                                +" quality=high bgcolor=#FFFFFF wmode=transparent "
                                +"WIDTH='" + this.width + "' HEIGHT='" + this.height + "' ALIGN='middle' TYPE='application/x-shockwave-flash' PLUGINSPAGE='http://www.macromedia.com/go/getflashplayer'></EMBED>"
                                );
            }
        } else if (this.type == 'image' ) {
            document.write( "<img " + attrStr + " src='" + this.src + "'>");
        } else if (this.type == 'html' ) {
            document.write( "<span " + attrStr + ">" + this.src + "</span>");
        }
    }

    loadingDisplay.prototype.show = function(to){
        var o = typeof(to)=='object'?to:document.getElementById(to)
        if (o) this.setTarget(o);
        //alert( document.getElementById(this.id) );
        document.getElementById(this.id).style.display = '';
        //document.getElementById(this.id).style.VISIBILITY  = 'show';
    }

    loadingDisplay.prototype.hide = function(){
        document.getElementById(this.id).style.display = 'none';
        //document.getElementById(this.id).style.VISIBILITY  = 'hidden';
    }

    loadingDisplay.prototype.setSize = function(w, h){
        this.width  = w;
        this.height = h;
        document.getElementById(this.id).style.width  = w;
        document.getElementById(this.id).style.height = h;
        this.setTarget(this.target);
    }

    loadingDisplay.prototype.setPos = function(x, y){
        if ( x ) document.getElementById(this.id).style.left  = x;
        if ( y ) document.getElementById(this.id).style.top   = y;
    }

    loadingDisplay.prototype.setTarget = function(to){
        var o = typeof(to)=='object'?to:document.getElementById(to);
        this.target = o;
        if ( o.offsetWidth > 0 ) {
            var l = document.getElementById(this.id);

            var d = document.documentElement;
            var _w = d.scrollWidth ;
            var _h = d.scrollHeight>=d.clientHeight?d.scrollHeight:d.clientHeight;

            var _t = o.offsetTop + o.clientTop  ;
            var _l = o.offsetLeft + o.clientLeft;

            //var rT = ((_h - l.scrollHeight) / 2) + o.scrollTop  + o.offsetTop  + document.body.style.borderTop + document.body.style.paddingTop ;
            //var rL = ((_w - l.scrollWidth ) / 2) + o.scrollLeft + o.offsetLeft + document.body.style.borderLeft+ document.body.style.paddingLeft;

            var rT = ((_h - l.offsetHeight) / 2) + o.scrollTop  + o.offsetTop  + document.body.style.borderTop + document.body.style.paddingTop ;
            var rL = ((_w - l.offsetWidth ) / 2) + o.scrollLeft + o.offsetLeft + document.body.style.borderLeft+ document.body.style.paddingLeft;

            l.style.top  = rT+'px';
            l.style.left = rL+'px';
        }
    }