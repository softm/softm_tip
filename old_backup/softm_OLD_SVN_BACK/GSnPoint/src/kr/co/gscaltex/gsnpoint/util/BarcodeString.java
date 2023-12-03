package kr.co.gscaltex.gsnpoint.util;

import android.util.Log;

public class BarcodeString {
	
	public String makePng(String str){  
   
    	String[] VALUES ={"","","","","","","",""};
    	int[] INT_VALUES ={0,0,0,0,0,0,0,0};
    	
    	String bar_str = "";
    	String START = "11010011100";//��������C
		String STOP = "11000111010";
		String TERMINATE_BAR = "11";
		
		INT_VALUES[0] = Integer.parseInt(str.substring(0, 2));
		INT_VALUES[1] = Integer.parseInt(str.substring(2, 4));
		INT_VALUES[2] = Integer.parseInt(str.substring(4, 6));
		INT_VALUES[3] = Integer.parseInt(str.substring(6, 8));
		INT_VALUES[4] = Integer.parseInt(str.substring(8, 10));
		INT_VALUES[5] = Integer.parseInt(str.substring(10, 12));
		INT_VALUES[6] = Integer.parseInt(str.substring(12, 14));
		INT_VALUES[7] = Integer.parseInt(str.substring(14, 16));
		
		VALUES[0] =selectCode(INT_VALUES[0]);
		VALUES[1] =selectCode(INT_VALUES[1]);
		VALUES[2] =selectCode(INT_VALUES[2]);
		VALUES[3] =selectCode(INT_VALUES[3]);
		VALUES[4] =selectCode(INT_VALUES[4]);
		VALUES[5] =selectCode(INT_VALUES[5]);
		VALUES[6] =selectCode(INT_VALUES[6]);
		VALUES[7] =selectCode(INT_VALUES[7]);
		
		bar_str = bar_str+START;
		
		for(int i=0;i<VALUES.length;i++){
			bar_str = bar_str+VALUES[i];
			//Log.i("test","hello");
		}
		
		bar_str = bar_str+selectCode(checkDigit(INT_VALUES));
		bar_str = bar_str+STOP;
		bar_str = bar_str+TERMINATE_BAR;
		
    	return bar_str;
    }
	
	private String selectCode(int vl){
		
    	switch(vl){
    	case 0:return "11011001100";case 53:return "11011101110";     	
    	case 1:return "11001101100";case 54:return "11101011000";     	
    	case 2:return "11001100110"; case 55:return "11101000110"; 
    	case 3:return "10010011000"; case 56:return "11100010110";
    	case 4:return "10010001100"; case 57:return "11101101000";
    	case 5:return "10001001100"; case 58:return "11101100010"; 
    	case 6:return "10011001000"; case 59:return "11100011010"; 
    	case 7:return "10011000100"; case 60:return "11101111010"; 
    	case 8:return "10001100100"; case 61:return "11001000010"; 
    	case 9:return "11001001000"; case 62:return "11110001010";
    	case 10:return "11001000100"; case 63:return "10100110000"; 
    	case 11:return "11000100100"; case 64:return "10100001100"; 
    	case 12:return "10110011100"; case 65:return "10010110000"; 
    	case 13:return "10011011100"; case 66:return "10010000110";
    	case 14:return "10011001110"; case 67:return "10000101100";
    	case 15:return "10111001100"; case 68:return "10000100110"; 
    	case 16:return "10011101100"; case 69:return "10110010000"; 
    	case 17:return "10011100110"; case 70:return "10110000100";
    	case 18:return "11001110010"; case 71:return "10011010000";
    	case 19:return "11001011100"; case 72:return "10011000010"; 
    	case 20:return "11001001110"; case 73:return "10000110100"; 
    	case 21:return "11011100100"; case 74:return "10000110010"; 
    	case 22:return "11001110100"; case 75:return "11000010010"; 
    	case 23:return "11101101110"; case 76:return "11001010000"; 
    	case 24:return "11101001100"; case 77:return "11110111010"; 
    	case 25:return "11100101100"; case 78:return "11000010100"; 
    	case 26:return "11100100110"; case 79:return "10001111010"; 
    	case 27:return "11101100100"; case 80:return "10100111100"; 
    	case 28:return "11100110100"; case 81:return "10010111100"; 
    	case 29:return "11100110010"; case 82:return "10010011110"; 
    	case 30:return "11011011000"; case 83:return "10111100100";
    	case 31:return "11011000110"; case 84:return "10011110100";
    	case 32:return "11000110110"; case 85:return "10011110010";
    	case 33:return "10100011000"; case 86:return "11110100100";
    	case 34:return "10001011000"; case 87:return "11110010100";
    	case 35:return "10001000110"; case 88:return "11110010010";
    	case 36:return "10110001000"; case 89:return "11011011110";
    	case 37:return "10001101000"; case 90:return "11011110110";
    	case 38:return "10001100010"; case 91:return "11110110110";
    	case 39:return "11010001000"; case 92:return "10101111000";
    	case 40:return "11000101000"; case 93:return "10100011110";
    	case 41:return "11000100010"; case 94:return "10001011110";
    	case 42:return "10110111000"; case 95:return "10111101000"; 
    	case 43:return "10110001110"; case 96:return "10111100010"; 
    	case 44:return "10001101110"; case 97:return "11110101000"; 
    	case 45:return "10111011000"; case 98:return "11110100010"; 
    	case 46:return "10111000110"; case 99:return "10111011110";
    	case 47:return "10001110110";
    	case 48:return "11101110110"; 
    	case 49:return "11010001110"; 
    	case 50:return "11000101110"; 
    	case 51:return "11011101000"; 
    	case 52:return "11011100010";
    	default:return"";
    	}
    }
    
	private int checkDigit(int[] digit){
    	int start = 105;
    	int tmp = 0;
    	
    	for(int i=0;i<digit.length;i++){
    		tmp = i+1;
    		start+=digit[i]*tmp;
    	}
    	int retun_value = 0;
    	
    	retun_value = start%103;
    	
    	return retun_value;
    }
}
