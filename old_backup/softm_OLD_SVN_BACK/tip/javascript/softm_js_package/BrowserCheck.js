    // browser Check
    var is             = null;

    function BrowserCheck() {
        this.ie  = ( document.all     ) ? 1 : 0;
        this.ns  = document.getElementById && !document.all ? 1 : 0;
    }
    // Browser  üũ
    is = new BrowserCheck();
