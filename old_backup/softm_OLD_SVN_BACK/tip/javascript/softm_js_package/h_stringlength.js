<!--
function h_stringlength(string) { 

char_cnt = 0; 
for(var i = 0; i < string.length; i++) { 
    var chr = string.substr(i,1);
    chr = escape(chr);
    key_eg = chr.charAt(1);
// key_eg �� u �̸� �ѱ� , �����̸� ���� , ���ڸ� Ư������ 
    switch (key_eg) { 
        case "u": 
//        alert ( '����' );
            key_num = chr.substr(2,(chr.length-1)); 
            if((key_num < "AC00") || (key_num > "D7A3")) { 
//                alert("�߸��� �Է��Դϴ�"); 
                return false; 
            } else { 
                char_cnt = char_cnt + 2; 
            } 
        break; 
        case "B": 
            char_cnt = char_cnt + 2; 
            break; 
        case "A": 
//            alert("�߸��� �Է��Դϴ�"); 
            return false; 
            break; 
            default: 
            char_cnt = char_cnt + 1; 
    } 
}
return char_cnt;
} 
//-->


