<!--
function h_stringlength(string) { 

char_cnt = 0; 
for(var i = 0; i < string.length; i++) { 
    var chr = string.substr(i,1);
    chr = escape(chr);
    key_eg = chr.charAt(1);
// key_eg 가 u 이면 한글 , 공백이면 영문 , 숫자면 특수문자 
    switch (key_eg) { 
        case "u": 
//        alert ( '여기' );
            key_num = chr.substr(2,(chr.length-1)); 
            if((key_num < "AC00") || (key_num > "D7A3")) { 
//                alert("잘못된 입력입니다"); 
                return false; 
            } else { 
                char_cnt = char_cnt + 2; 
            } 
        break; 
        case "B": 
            char_cnt = char_cnt + 2; 
            break; 
        case "A": 
//            alert("잘못된 입력입니다"); 
            return false; 
            break; 
            default: 
            char_cnt = char_cnt + 1; 
    } 
}
return char_cnt;
} 
//-->


