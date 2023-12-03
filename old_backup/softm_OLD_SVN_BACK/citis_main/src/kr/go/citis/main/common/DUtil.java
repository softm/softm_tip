package kr.go.citis.main.common;

import kr.go.citis.lib.BaseActivity;
import kr.go.citis.lib.Constant;
import kr.go.citis.lib.Util;
import kr.go.citis.lib.common.AsyncHttp;
import kr.go.citis.lib.common.AsyncHttpParam;
import kr.go.citis.lib.common.CallBackEvent;
import kr.go.citis.main.dto.LoginDTO;
import kr.go.citis.main.dto.in.LoginDTOIn;
import kr.go.citis.main.dto.out.LoginDTOOut;
import android.content.Context;

import com.google.gson.Gson;
import com.squareup.okhttp.FormEncodingBuilder;

/**
 * DUtil
 * 데이터베이스 유틸
 * @author softm
 */
public class DUtil {

	public static boolean existUser(Context context,String userId, String passwd, final CallBackEvent cb ) {
    	final BaseActivity activity = (BaseActivity)context;
    	activity.startProgressBar();
    	LoginDTOIn in = new LoginDTOIn();
	    	LoginDTO data = new LoginDTO();
	    	data.setUserid(userId);
	    	data.setPasswd(passwd);
    	in.setData(data);
    	Gson gson = new Gson();
    	String inParams = ""; 
    	inParams = gson.toJson(in);
    	Util.i("in json : " + inParams);
		new AsyncHttp<LoginDTOOut,String>(context) {
			@Override
			public void complete(LoginDTOOut dto) {
				try {				
					if ( Constant.ERR_CODE_SUCCESS.equals(dto.getMsgCode())){
					    cb.success("성공",dto.getData());
					} else if ( Constant.ERR_CODE_NETWORK.equals(dto.getMsgCode())) {
						throw new Exception(dto.getMsg());
					} else {
						throw new Exception(dto.getMsg());						
//						int resId = activity.getResources().getIdentifier("msg_invalid_login", "string", activity.getPackageName());
//						throw new Exception(activity.getString(resId));
					}
				} catch (Exception e) {
					e.printStackTrace();
					LoginDTOOut dto1 = new LoginDTOOut();
	                         dto1.setMsg(e.getMessage());
			    	cb.error("실패",dto1);
				}
			}

			@Override
			public void callback(LoginDTOOut result) {
			}
			
     	}.execute(new AsyncHttpParam(Constant.SERVER_COMMON_URL,
				new FormEncodingBuilder().add("uid", userId)
										 .add("upassword", passwd)
										 .add("p", inParams)
										 ,"login"
										 ));
     	
		return true;
	}
}