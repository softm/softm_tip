    var xmlSendCheck = false;
    var sT = null;
    var eT = null;

    function asyncConnector(method, callBack) {
        this.method = (method==null)?'downloader':method;
        this.xmlHttp = null;
        this.updating = false;
        this.dataArea= null;
        this.form    = null;
        this.contentType = null;

        this.abort    = function()
        {
          if(this.updating)
          {
            this.updating   = false;
            this.xmlHttp.abort();
            this.xmlHttp    = null;
          }
        };
        if ( this.method == 'xmlhttp' ) { // xmlhttp
            if (typeof(XMLHttpRequest) === "undefined") {
                try { this.xmlHttp = new ActiveXObject("MSXML2.XMLHTTP.6.0" ); } catch(e) {}
                try { this.xmlHttp = new ActiveXObject("MSXML2.XMLHTTP.3.0" ); } catch(e) {}
                try { this.xmlHttp = new ActiveXObject("MSXML2.XMLHTTP"     ); } catch(e) {}
                try { this.xmlHttp = new ActiveXObject("Microsoft.XMLHTTP"  ); } catch(e) {}
                //throw new Error("This browser does not support XMLHttpRequest.");
                //alert('this.xmlHttp : ' + this.xmlHttp);
            } else {
                this.xmlHttp = new XMLHttpRequest(); // XMLHttpRequest Object
            }
            this.dataArea = null;
        } else { // downloader
        }
    }

    asyncConnector.prototype.open= function(sUrl , dataA, sMethod, bAsync, body ) {
        if ( this.method == 'xmlhttp' ) { // xmlhttp
        /* xmlHTTP    이용시 */
            this.httpOpen(sMethod, sUrl , bAsync ,body, dataA);
        } else { // downloader
        /* downloader 이용시 */
            this.startDownload(sUrl, dataA);
        }
    }

    /* xmlHTTP    이용시 */
    // sMethod, sUrl [, bAsync] [, sUser] [, sPassword]
    asyncConnector.prototype.httpOpen= function(sMethod, sUrl , bAsync ,body, dataA,callBack) {
        if(this.updating) return false;
        try
        {
            this.dataArea = dataA;
            this.xmlHttp.open(sMethod, sUrl , bAsync);
            if ( !this.contentType ) {
              this.xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
            } else {
              this.xmlHttp.setRequestHeader("Content-Type", this.contentType);
            }

          //this.xmlHttp.setRequestHeader("Modified", "Thu, 1 Jan 1970 00:00:00 GMT");
            this.xmlHttp.setRequestHeader("If-Modified-Since", "Thu, 1 Jan 1970 00:00:00 GMT");
            this.xmlHttp.setRequestHeader("Cache-Control", "no-store, no-cache, must-revalidate");

            if ( this.xmlHttp.overrideMimeType ) this.xmlHttp.setRequestHeader("Connection", "close");
          //this.xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
          //this.xmlHttp.setRequestHeader("Content-type", "text/plain");
            body = body?body:'';

            this.xmlHttp.setRequestHeader("Content-Length", body.length);

            if ( typeof(callBack) == 'function' ) this.openCallBack= callBack;

            if ( typeof(this.openCallBack) == 'function' ) {
              var thisObj = this;
              //this.xmlHttp.onreadystatechange = function() {thisObj.openCallBack();};

                this.xmlHttp.onreadystatechange = function() {
                  if ( thisObj.method == 'xmlhttp' ) { // xmlhttp
                        if (thisObj.xmlHttp.readyState == 4 ) {
                            if (thisObj.xmlHttp.status == 200 ) {
                                //alert( thisObj.xmlHttp.readyState );
                                try {
                                    thisObj.updating = false;
                                    if ( thisObj && typeof(thisObj.openCallBack) == 'function' ) thisObj.openCallBack();
                                    thisObj.xmlHttp = null;
                                    thisObj.onreadystatechange = null;
                                } catch (e) {
                                    //alert(e.toString() );
                                    //$('msg').value += ' thisObj : ' + thisObj.openCallBack;
                                }
                                finally {
                                    thisObj.updating = false;
                                    thisObj.xmlHttp = null;
                                    thisObj.onreadystatechange = null;
                                }
                            }
                        }
/*
                      if ( document.all) {
                          thisObj.openCallBack();
                      } else {
                              //alert ( thisObj.openCallBack );
                          //if(thisObj.xmlHttp.status == 200) {
                              thisObj.openCallBack();
                          //}
                      }
*/
                  } else { // downloader
                      thisObj.openCallBack();
                  }

                }/**/
            }
            this.xmlHttp.send(body);
        }
        catch (e)
        {
            alert(e + "|" + e.name + "|" + e.message + "|" + e.number + "|" + e.description);
        }
    }

    asyncConnector.prototype.httpOpenSimple= function(sMethod, sUrl , bAsync ,body, dataA,callBack) {
        if ( typeof (loadSwf) == 'object' ) loadSwf.showSwf();
        this.openCallBack= function (str) {
            //var xmlDoc=ajaxR.responseXml();
            var rtn = this.responseText();
            var info = rtn.split('|');
            if ( info[0] == 'SUCCESS' ) {
                callBack();
            } else if ( info[0] == 'ERROR' ) {
                alert('처리중 에러가 발생하였습니다.\n[' + info[1] + ']');
            }
            if ( typeof (loadSwf) == 'object' ) loadSwf.hideSwf();
            this.dataArea.innerHTML = this.responseText();
        }
        this.httpOpen(sMethod, sUrl , bAsync ,body, dataA);
    }

    asyncConnector.prototype.httpOpenDirect= function(sMethod, sUrl , bAsync ,body, dataA, callBack) {
        this.openCallBack= function (str) {
            this.dataArea.innerHTML = this.responseText();
            if ( typeof(callBack) == 'function' ) {
                callBack();
            }
        }
        this.httpOpen(sMethod, sUrl , bAsync ,body, dataA);
    }


    /* downloader 이용시 */
    asyncConnector.prototype.startDownload= function(sUrl, dataA) {
        this.dataArea = dataA;
        if ( typeof(this.openCallBack) == 'function' ) {
            //alert ( 'sUrl : ' + sUrl  + ' / ' + this.dataArea.id + ' / ' + this.openCallBack);
            var thisObj = this;//alert('푸할할.');
            try
            {
                if ( typeof(this.openCallBack) == 'function' ) {
                  this.dataArea.startDownload( sUrl, this.openCallBack);
                  //this.dataArea.startDownload( 'http://192.168.10.16:86/index.php', this.openCallBack );
                }
            }
            catch (e)
            {
                alert(e);
            }
            //thisObj.startDownloadCallBack();
        }
    }

    asyncConnector.prototype.responseText= function() { return this.xmlHttp.responseText; }
    asyncConnector.prototype.responseXML= function() { return this.xmlHttp.responseXML; }
    asyncConnector.prototype.readyState  = function() {
        try
        {
            if ( this.method == 'xmlhttp' ) { // xmlhttp
                if ( document.all) {
                    return this.xmlHttp.readyState; // xmlHTTP    이용시
                } else {
                    if(this.xmlHttp.status == 200) {
                        return 4;
                    } else {
                        return this.xmlHttp.status;
                    }
                }
            } else { // downloader
                return 4                      ; // downloader 이용시
            }
        }
        catch (e) {}
    }

    asyncConnector.prototype.getQueryString = function () {
        var q = '';
        var c = this.form.elements.length;
        var q = '';
        var lastEName = '';
        for (var i = 0; i < c; i++) {
            var fe = this.form.elements[i];
            if ( fe.type == 'radio' || fe.type == 'checkbox' ) {
                if(fe.checked) {
                //alert( fe.type );
                    if(fe.name == lastEName) {
                        if(q.lastIndexOf('&') == q.length - 1) {
                            q = q.substring(0, q.length - 1);
                        }
                        q += ',' + encodeURIComponent(fe.value);
                    }
                    else {
                        q += fe.name + '=' + encodeURIComponent(fe.value);
                    }
                    q += '&';
                    lastEName = fe.name;
                }
            } else if ( fe.type == 'text' || fe.type == 'select-one' || fe.type == 'hidden' || fe.type == 'password' || fe.type == 'textarea' ) {
                q += fe.name + '=' + encodeURIComponent(fe.value) + '&';
            }
        }
        return q;
    }