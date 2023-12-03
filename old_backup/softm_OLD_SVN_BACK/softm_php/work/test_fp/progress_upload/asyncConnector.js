    function asyncConnector(method, callBack) {
        this.method = (method==null)?'downloader':method;
        this.xmlhttp = null;
        this.dataArea= null;
        if ( this.method == 'xmlhttp' ) { // xmlhttp
            if ( document.all) {
                this.xmlHttp = new ActiveXObject('MSXML2.XMLHTTP.3.0'); // XMLHttpRequest Object
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
    asyncConnector.prototype.httpOpen= function(sMethod, sUrl , bAsync ,body, dataA) {
        this.dataArea = dataA;
        this.xmlHttp.open(sMethod, sUrl , bAsync);
        this.xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=EUC-KR");
        body = body?body:null;
        //try
        //{
          if ( typeof(this.openCallBack) == 'function' ) {
            var thisObj = this;
            this.xmlHttp.onreadystatechange = function() {thisObj.openCallBack();};
            /*
              this.xmlHttp.onreadystatechange = function() {
                if ( thisObj.method == 'xmlhttp' ) { // xmlhttp
                    if ( document.all) {
                        thisObj.openCallBack();
                    } else {
                            //alert ( thisObj.openCallBack );
                        //if(thisObj.xmlHttp.status == 200) {
                            thisObj.openCallBack();
                        //}
                    }
                } else { // downloader
                    thisObj.openCallBack();
                }
              }*/
          }
          this.xmlHttp.send(body);
        //}
        //catch (e)
        //{
        //    alert ( e );
        //}
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
                alert ( e );
            }
            //thisObj.startDownloadCallBack();
        }
    }

    asyncConnector.prototype.responseText= function() { return this.xmlHttp.responseText; }
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
