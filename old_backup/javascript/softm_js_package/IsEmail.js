<!--    
/* �̸��� üũ �Լ� */    
/* �������� �̸������� üũ �� ������� ��ȯ�Ѵ�. */    
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
