<!--
if ( MenuGb == "TIP" )
{
            var MAX = '100';
            var MIN = "1";
            var currentpage = "" + document.location;
            var cpage=null, ppage=null, npage=null,url=null;
            var cpnum=0;
            cpage = currentpage.substring(currentpage.lastIndexOf("/") + 1);
            url   = currentpage.substring(0,currentpage.lastIndexOf("/") + 1);
            var c;
            var i;
//            document.write( cpage );
            var exeYN;
            for ( i=0 ; i< cpage.length;i++) {
                c = cpage.substring(i,i+1);
                if ( c=="0" || c=="1" || c=="2" || c=="3" || c=="4" || c=="5" || c=="6" || c=="7" || c=="8" || c=="9") {
                     exeYN = "Y";
                     break;
                } else {
                     exeYN = "N";
                }
            }
            cpnum = cpage.substring(i, cpage.indexOf("."));
            cpnum = parseInt( eval(cpnum) );
//          document.write("다음페이지 : " + cpnum);
                if ( MIN != parseInt( eval(cpnum) ) && exeYN == "Y" ){
                    if ( parseInt( eval(cpnum) ) - 1 >= 10 )
                    {
                        ppage = "javastudyT" + ( parseInt( eval(cpnum) ) - 1 );
                    } else {
                        ppage = "javastudyT0" + ( parseInt( eval(cpnum) ) - 1 );
                    }
                    document.write("<a href='" + url + ppage + ".html'>이전</a>");
                }
                document.write("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
                if ( MAX >= parseInt( eval(cpnum) ) + 1 && exeYN == "Y" ){
                    if ( parseInt( eval(cpnum) ) + 1 >= 10 )
                    {
                        npage = "javastudyT" + ( parseInt( eval(cpnum) ) + 1 );
                    } else {
                        npage = "javastudyT0" + ( parseInt( eval(cpnum) ) + 1 );
                    }
                    document.write("<a href='" + url + npage + ".html'>다음</a>"); 
                }
}
//-->