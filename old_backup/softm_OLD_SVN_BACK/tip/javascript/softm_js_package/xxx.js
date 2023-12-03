<!--
    function f_retrive(selected) {
        switch (selected) {
            case '01' :
                document.open();
                document.write("");
                document.close();
                document.writeln("<FORM name='MyForm' action='/Merchandiser/catalog/templates/MyMusic/Music_PWS_Result.jhtml'>");
                document.writeln("<FONT size=2>");
                document.writeln("<SELECT name='siteGB' size='1' onchange='return f_retrive(this.value);'>");
                document.writeln("<OPTION value='01'>Music</OPTION>");
                document.writeln("<OPTION value='02'>Gifts</OPTION>");
                document.writeln("<OPTION value='03'>DVD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</OPTION>");
                document.writeln("</SELECT>");
                document.writeln("</FONT>");

                document.writeln("<FONT size=2>");
                document.writeln("<SELECT name='SelectGBMusic' size='1'>");
                document.writeln("<OPTION value='Artist'>Artist</OPTION>");
                document.writeln("<OPTION value='Album'>Album</OPTION>");
                document.writeln("<OPTION value='Song'>Song</OPTION>");
                document.writeln("<OPTION value='ALL'>ALL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</OPTION>");
                document.writeln("</SELECT>");
                document.writeln("</FONT>");

                document.writeln("<INPUT type='text' name='SearchString' size='10' value='param:SearchString' class='input' style='width:78;'>");
                document.writeln("<INPUT type='image' src='/MusicImage/index/go.gif' width='20' height='20' border='0'>");
                document.writeln("</FORM>");
                document.writeln("<SCRIPT LANGUAGE=\"JavaScript\" src=\"/common/xxx.js\"></SCRIPT>");
                break;
            case '02' :
                document.open();
                document.write("");
                document.close();
                document.writeln("<FORM name='MyForm' action='/Merchandiser/catalog/templates/MyMusic/Music_PWS_Result.jhtml'>");
                document.writeln("<FONT size=2>");
                document.writeln("<SELECT name='siteGB' size='1' onchange='return f_retrive(this.value);'>");
                document.writeln("<OPTION value='01'>Music</OPTION>");
                document.writeln("<OPTION value='02'>Gifts</OPTION>");
                document.writeln("<OPTION value='03'>DVD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</OPTION>");
                document.writeln("</SELECT>");
                document.writeln("</FONT>");

                document.writeln("<FONT size=2>");
                document.writeln("<SELECT name='SelectGBDVD' size='1'>");
                document.writeln("<OPTION value='ALL' >ALL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</OPTION>");
                document.writeln("</SELECT>");
                document.writeln("</FONT>");

                document.writeln("<INPUT type='text' name='SearchString' size='10' value='param:SearchString' class='input' style='width:78;'>");
                document.writeln("<INPUT type='image' src='/MusicImage/index/go.gif' width='20' height='20' border='0'>");
                document.writeln("</FORM>");
                document.writeln("<SCRIPT LANGUAGE=\"JavaScript\" src=\"/common/xxx.js\"></SCRIPT>");
                break;
            case '03' :
                document.open();
                document.write("");
                document.close();
                document.writeln("<FORM name='MyForm' action='/Merchandiser/catalog/templates/MyMusic/Music_PWS_Result.jhtml'>");
                document.writeln("<FONT size=2>");
                document.writeln("<SELECT name='siteGB' size='1' onchange='return f_retrive(this.value);'>");
                document.writeln("<OPTION value='01'>Music</OPTION>");
                document.writeln("<OPTION value='02'>Gifts</OPTION>");
                document.writeln("<OPTION value='03'>DVD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</OPTION>");
                document.writeln("</SELECT>");
                document.writeln("</FONT>");

                document.writeln("<FONT size=2>");
                document.writeln("<SELECT name='SelectGBMusic' size='1'>");
                document.writeln("<OPTION value='Title' selected>Title</OPTION>");
                document.writeln("<OPTION value='Artist' >Artist</OPTION>");
                document.writeln("<OPTION value='Director' >Director</OPTION>");
                document.writeln("<OPTION value='Actor' >Actor</OPTION>");
                document.writeln("<OPTION value='ALL' >ALL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</OPTION>");
                document.writeln("</SELECT>");
                document.writeln("</FONT>");

                document.writeln("<INPUT type='text' name='SearchString' size='10' value='param:SearchString' class='input' style='width:78;'>");
                document.writeln("<INPUT type='image' src='/MusicImage/index/go.gif' width='20' height='20' border='0'>");
                document.writeln("</FORM>");
                document.writeln("<SCRIPT LANGUAGE=\"JavaScript\" src=\"/common/xxx.js\"></SCRIPT>");
                break;

        }
    }
// default ½ÇÇà 
    f_retrive(1);
//-->