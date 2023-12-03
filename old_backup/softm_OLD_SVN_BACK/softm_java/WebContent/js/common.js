var Common = {
    logout:function(f){
        if (confirm ('로그아웃하시겠습니까?') ) {
			call('JSON',"member/logout",
			    {
				},
			    function(json) {
			        if ( json['return'] == '200' ) { // success      
			//                        	alert(json.message);
			            document.location.href = document.location.href.replace(/#/g,'');
			        } else {
			            alert(json.message); // error
			        }
			    }
			);
        }	
    },	
	/**
	 * # using
	    Util.Load.script({src:"/service/js/common.js",type:'js',callback:function(){
	        var L = new createArrangeElement("select","s_l_cat","-검색-").make({"1":"1값","2":"2값","3":"3값"},"1").append($S("area_tech_l_cat"));
	        var M = new Common.createELTechCat("select","M","s_m_cat","2차카테고리").make("43","50").append($S("area_tech_m_cat"));
	        var S = new Common.createELTechCat("select","S","s_s_cat","3차카테고리").make("43","50","06").append($S("area_tech_s_cat"));
	        L.setNextObject(M);
	        M.setNextObject(S);
	    }});
	 */
    createArrangeElement:function (type,elName,elTitle) {
        this.type   = type.toLowerCase();
        this.lang = "KR" ;
        this.elName = elName;
        this.elTitle= elTitle;
        this.element = null;
        this.elements= Array();

        this.selectValue = "";
        this.nextObject  = null;
        this.prevObject  = null;
        	
        this.appendArea = null;
        
        this.append=function (areaEl){
            //console.debug(areaEl,this.element);
            if ( areaEl ) this.appendArea = areaEl;
            var lAreaEl = this.appendArea;
            if ( lAreaEl ) {
                if ( lAreaEl.firstChild ) {
                   // console.debug("append",this.element, lAreaEl.firstChild);
                    lAreaEl.replaceChild( this.element, lAreaEl.firstChild );
                } else {
                    lAreaEl.appendChild( this.element );
                }
            }
            return this;
        }
        this.setNextObject=function (instance){
            this.nextObject = instance;
            this.nextObject.prevObject = this;
            return this;
        }
        this.change=function() {
        }
        
        this.make=function(data,sValue) {
            var sValue = sValue?sValue:"";
            var dbCall = false;
            this.selectValue = sValue;
            var me = this;
            //this = me;
                if ( me.type == "select" ) {
                    me.element = Create.listBox({name:me.elName,value:me.elTitle?json_merge({'':me.elTitle},data):data,selected:me.selectValue});
                    me.element.onchange = (function(me){
                        return function(){
//                                console.debug("onchange",me);
                            me.change();
                        };
                    })(me);
                } else if ( me.type == "radio" ) {
                    //console.debug("radio data ", data);
                    me.element = Create.radio({name:me.elName,value:json_merge(data),checked:me.selectValue});
                    var l = me.element.childNodes.length;
                    //console.debug(me.element.childNodes);
                    for(var i=0;i<=l; i++ ) {
                        if ( me.element.childNodes[i] && me.element.childNodes[i].type == 'radio' ) {
                            me.element.childNodes[i].onclick = (function(me){
                                return function(){
    //                                console.debug("onchange",me);
                                    me.change();
                                };
                            })(me);
                            me.elements.push(me.element.childNodes[i]);
                        }
                    }
                }
//                if ( this.type == "select" ) {
//                    this.element = Create.listBox({name:this.elName,value:{'':this.elTitle}});
//                } else if ( this.type == "radio" ) {
//                    this.element = Create.radio({name:this.elName});
//                }
            return this;
        }

        return this;
    },    
    getCode:function (k,c,l,m,s) {
        var xhr = new asyncConnector('xmlhttp');
        var params = "p_mode=cat_code&p_kind=" + k +"&p_cat=" + c;
            params += l?"&p_lcd="+l:'';
            params += m?"&p_mcd="+m:'';
            params += s?"&p_scd="+s:'';
        //console.debug(params);
        xhr.httpOpen("GET", "/service/common/common.jsp?"+params, false);
        return xhr.responseText();
    },
    createSelectBox:function(t,aId,id,k,c,l,m,s) {
        c = c?c:'L';
        var jS = common.getCode(k,c,l,m,s);
        eval('var j = ' + jS.trim());
      //alert(j);
        var d = j.data;
        var l = j.data.length;
        var o = $(aId);
        var onChange = null;
        var cssText = null;
        if ($(id)) {
            onChange = $(id).onchange;
            cssText  = $(id).style.cssText;
            o.removeChild($(id));
        }
        var s = $C('SELECT');
            s.id = id;
            s.name = id;
            s.onchange = onChange ;
            s.style.cssText = cssText;
            o.appendChild(s);
        if (t) s.options[0] = new Option(t,'');
        var il = s.options.length;
        for (var i=0; i<l;i++ ) {
            s.options[i+il] = new Option(d[i].CODE_NAME,d[i][c+'CD']);
        }
        return s;
    }
}

var ROW_SELECTED_COLOR = "#c4e1ff";