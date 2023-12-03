package com.entropykorea.gas.chg.common;

import java.io.File;
import java.io.FileFilter;
import java.text.DecimalFormat;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

import org.apache.commons.io.filefilter.WildcardFileFilter;
import org.apache.commons.lang3.StringUtils;

import android.content.Context;
import android.content.Intent;

import com.entropykorea.gas.chg.R;
import com.entropykorea.gas.chg.activity.HouseInfActivity;
import com.entropykorea.gas.chg.dto.ChgDTO;
import com.entropykorea.gas.lib.BaseActivity;
import com.entropykorea.gas.lib.Util;

/**
 * WUtil
 * 
 * @author softm
 */
public class WUtil {
	public static String numberFormat(String pattern, String value) {
		int v = Integer.parseInt(StringUtils.defaultString(value, "0"), 10);
		return numberFormat(pattern, v);
	}

	public static String numberFormat(String pattern, int value) {
		DecimalFormat myFormatter = new DecimalFormat(pattern);
		String output = myFormatter.format(value);
		return output;
	}

	public static boolean isValidPhoneNumber(String phoneNumber) {
		boolean returnValue = false;
		String regex = "^\\s*(02|031|032|033|041|042|043|051|052|053|054|055|061|062|063|064|070)?(-|\\)|\\s)*(\\d{3,4})(-|\\s)*(\\d{4})\\s*$";
		Pattern p = Pattern.compile(regex);
		Matcher m = p.matcher(phoneNumber);
		if (m.matches()) {
			returnValue = true;
		}
		return returnValue;
	}

	public static boolean isValidCellPhoneNumber(String cellphoneNumber) {
		boolean returnValue = false;
		String regex = "^\\s*(010|011|012|013|014|015|016|017|018|019)(-|\\)|\\s)*(\\d{3,4})(-|\\s)*(\\d{4})\\s*$";
		Pattern p = Pattern.compile(regex);
		Matcher m = p.matcher(cellphoneNumber);
		if (m.matches()) {
			returnValue = true;
		}
		return returnValue;

	}

	public static String toDefault(String v) {
		return StringUtils.isEmpty(v)?"":v;
	}
	
	public static String toDefault(String v,String dv) {
		return StringUtils.isEmpty(v)?dv:v;
	}
	
	public static void goMterChg(Context context, String bfGmNo) {
        if (bfGmNo.length() != 12) { // 자리수 체크로직 제거.
        	BaseActivity activity = (BaseActivity)context;
        	activity.alert(R.string.msg_invalid_barcode);        	
        } else {
//            String houseNo = DUtil.getHouseNoByBfGmNo(context.getApplicationContext(),bfGmNo);
        	ChgDTO v = DUtil.getDataByWhere(context.getApplicationContext()," WHERE BF_GM_NO = '" + bfGmNo + "'");
//          if ( "".equals(houseNo)) {
            if ( "".equals(v.getHouseNo())) {            	
            	BaseActivity activity = (BaseActivity)context;
            	activity.alert(R.string.msg_invalid_house);            	
            } else {
//                Intent sIntent = new Intent(context,MeterChgActivity.class); // 계량기교체
//                sIntent.putExtra("bf_gm_no", bfGmNo);
                Intent sIntent = new Intent(context,HouseInfActivity.class); // 수용가정보
                sIntent.addFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
                sIntent.putExtra("bldg_cd"  , v.getBldgCd()                  ); // 건물그룹번호  
                sIntent.putExtra("gm_chg_ym", WUtil.toDefault(v.getJobYm()  )); // 작업년월(PK)  
                sIntent.putExtra("house_no" , WUtil.toDefault(v.getHouseNo())); // 수용가번호(PK)
                sIntent.putExtra("cust_no"  , WUtil.toDefault(v.getCustNo() )); // 고객번호(PK)
                context.startActivity(sIntent);                
                
            }
        }
	}
	
	public static void deleteFiles(final String directoryName, final String wildCard) {
		 File dir = new File(directoryName);
//		 FileFilter fileFilter = new WildcardFileFilter("*test*.java~*~");
		 FileFilter fileFilter = new WildcardFileFilter(wildCard);
		 File[] files = dir.listFiles(fileFilter);
		 
		 for (int i = 0; i < files.length; i++) {
			new File(""+files[i]).delete();		   
		 }
	}
}