    // browser Check
    var DP_is             = null;

    function DP_BrowserCheck() {
        this.ie  = ( document.all     ) ? 1 : 0;
        this.ns  = document.getElementById && !document.all ? 1 : 0;
    }
    // Browser  üũ
    DP_is = new DP_BrowserCheck();
