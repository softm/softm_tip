<!--
/*============================���� ���Ÿ� ���� Trim�Լ�======================================*/
function Trim(TheString) 
{ 
        var len; 

        len = TheString.length; 
        while(TheString.substring(0,1) == " "){ //trim left 
                TheString = TheString.substring(1, len); 
                len = TheString.length; 
        } 

        while(TheString.substring(len-1, len) == " "){ //trim right 
                TheString = TheString.substring(0, len-1); 
                len = TheString.length; 
        } 
        return TheString; 
} 
/*============================END ���� ���Ÿ� ���� Trim�Լ�==================================*/
//-->