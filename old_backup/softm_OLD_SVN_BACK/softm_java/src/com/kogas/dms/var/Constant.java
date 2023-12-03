package com.kogas.dms.var;

import java.util.HashMap;
import java.util.Map;

import org.codehaus.jettison.json.JSONException;
import org.codehaus.jettison.json.JSONObject;

public class Constant {
//	public final static Map<String,String> DMS_BD_REQUEST_STATUS;
	public static JSONObject DMS_BD_REQUEST_STATUS = null;
	public static JSONObject DMS_BD_REQUEST_REQ_GUBUN = null;

	public static JSONObject DMS_BD_ITEM_STATUS = null;
	
	static {
		try {
			DMS_BD_REQUEST_STATUS = new JSONObject();		
//			DMS_BD_REQUEST_STATUS = new HashMap<String, String>();
			DMS_BD_REQUEST_STATUS.put("0", "요청대기");
			DMS_BD_REQUEST_STATUS.put("1", "등록대기"); // 이사 등록이 가능한 상태. 
			DMS_BD_REQUEST_STATUS.put("2", "등록완료");
			
			DMS_BD_REQUEST_REQ_GUBUN = new JSONObject();		
//			DMS_BD_REQUEST_STATUS = new HashMap<String, String>();
			DMS_BD_REQUEST_REQ_GUBUN.put("1", "구두");
			DMS_BD_REQUEST_REQ_GUBUN.put("2", "서면");
			
			// "{1:\"등록대기\",2:\"접수대기\",3:\"접수완료\"}"
			// 접수대기 : 반려 , 접수완료 : 확정
			DMS_BD_ITEM_STATUS = new JSONObject();
			DMS_BD_ITEM_STATUS.put("1", "등록대기");
			DMS_BD_ITEM_STATUS.put("2", "접수대기");
			DMS_BD_ITEM_STATUS.put("3", "접수완료");
		} catch (JSONException e) {
			e.printStackTrace();
		}
	}
}