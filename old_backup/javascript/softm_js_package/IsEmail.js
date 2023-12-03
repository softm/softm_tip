<!--    
/* 이메일 체크 함수 */    
/* 정상적인 이메일인지 체크 후 결과값을 반환한다. */    
function IsEmail (email){    
    myRe=/^[\w-]+@[\w-]+([.][\w-]+){1,3}$/;    
    myArray = myRe.exec(email);    
    if(myArray){    
        return true;    
    }else{    
        return false;    
    }    
}    
//->    
