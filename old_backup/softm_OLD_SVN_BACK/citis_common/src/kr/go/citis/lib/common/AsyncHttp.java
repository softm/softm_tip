package kr.go.citis.lib.common;    

import java.lang.reflect.Method;
import java.lang.reflect.Type;

import kr.go.citis.lib.BaseActivity;
import kr.go.citis.lib.Constant;
import kr.go.citis.lib.Util;
import android.content.Context;
import android.os.AsyncTask;
import android.os.StrictMode;

import com.google.gson.Gson;
import com.google.gson.JsonElement;
import com.google.gson.JsonParser;
import com.squareup.okhttp.OkHttpClient;
import com.squareup.okhttp.Request;
import com.squareup.okhttp.Response;

/**
 * AsyncHttp
 * @param <R>
 * @param <S>
 * @author softm
 */
public abstract class AsyncHttp<R,S> 
{
	public Context getContext() {
		return context;
	}
	public void setContext(Context context) {
		this.context = context;
	}
	
	  @SuppressWarnings("unused")
	  private R returnValue;	 
	  @SuppressWarnings("unchecked")
	  public Class<R> getReturnClassType () {
//		  <R>.class
		  Type[] parameterizedTypes = ReflectionUtil.getParameterizedTypes(this);
		  Class<R> clazz = null;
			try {
				clazz = (Class<R>)ReflectionUtil.getClass(parameterizedTypes[0]);
			} catch (ClassNotFoundException e) {
				e.printStackTrace();
			}
			R parameter = null;
			try {
				parameter = (R) clazz.newInstance();
			} catch (InstantiationException e) {
				e.printStackTrace();
			} catch (IllegalAccessException e) {
				e.printStackTrace();
			}
			Util.i("init DTO name ~ : " + parameter.getClass().getName());
		  return (Class<R>) parameter.getClass();
//		  return ((Class<R>) returnValue.getClass());
//		  return (Class<R>) ((ParameterizedType) getClass().getGenericSuperclass()).getActualTypeArguments()[0];

//		  return ((Class<R>) returnValue.getClass());
//		  Type[] t = ((ParameterizedType) ((ParameterizedType) getClass().getGenericSuperclass()).getActualTypeArguments()[0]).getActualTypeArguments();
//		  return (Class<R>) t[0];
//		  return (Class) ((ParameterizedType) getClass().getGenericSuperclass()).getActualTypeArguments()[0];		  
	  }
	  
	private Context context;
	private Object object = null; // for param	
	public AsyncHttp( Context context ) {
		this(context,AsyncHttpType.JSONELEMENT);
	}
	public AsyncHttp( Context context, AsyncHttpType a ) {
		this.context = context;
	}

	public AsyncHttp( Context context, String message ) {
		this.context = context;
	}

	public AsyncHttp( Context context, String message, Boolean statusbar ) {
		this.context = context;
	}

	public AsyncHttp( Context context, String message, Boolean statusbar, Object obj ) {
		this.context = context;
		this.object = obj;
	}
	
	public R send(AsyncHttpParam data,boolean async) {
		R rtn = null;		
		String str="";
		OkHttpClient client = new OkHttpClient();
		Util.i("send request url [\"" + data.getSerivce()+ "\"] : " + data.getUrl());
		new Request.Builder().url(data.getUrl())
		.post(data.getFormBody()).build();
		Request request = new Request.Builder().url(data.getUrl())
				.post(data.getFormBody()).build();
		Response response;
		try {
			response = client.newCall(request).execute();
			str = response.body().string();
			Util.i("retrun string data [\"" + data.getSerivce()+ "\"] : " + str);
			JsonElement result = new JsonParser().parse(str).getAsJsonObject();
			Gson gson = new Gson();
			rtn = (R)gson.fromJson(result, getReturnClassType());
		} catch (Exception e) {
			try {
				rtn = (R) getReturnClassType ().newInstance();
				Method method = rtn.getClass().getMethod("setMsg", String.class);
				method.invoke(rtn,e.toString());// "Not connected"
				Method method2 = rtn.getClass().getMethod("setMsgCode", String.class);
				method2.invoke(rtn,Constant.ERR_CODE_NOT_FOUND);
			} catch (Exception e1) {
				e1.printStackTrace();
			}
			
		}
		return rtn;
	}
	
	public void sync(AsyncHttpParam data) {
		if (android.os.Build.VERSION.SDK_INT > 9) {
			   StrictMode.ThreadPolicy policy = new StrictMode.ThreadPolicy.Builder().permitAll().build();
			   StrictMode.setThreadPolicy(policy);
			}
		if( mThreadRunning == true )
			return;
		R rtn;		
		rtn = (R) send(data,false);
		complete(rtn);
		callback(rtn);
	}
	public R syncAs(AsyncHttpParam data) {
		if (android.os.Build.VERSION.SDK_INT > 9) {
		   StrictMode.ThreadPolicy policy = new StrictMode.ThreadPolicy.Builder().permitAll().build();
		   StrictMode.setThreadPolicy(policy);
		}
		if( mThreadRunning == true )
			return null;
		return send(data,false);		
	}
	
	public void execute(AsyncHttpParam data) {
		if( !Connectivity.isConnected( this.context ) ) {
	    	BaseActivity activity = (BaseActivity)context;			
			activity.toast(kr.go.citis.lib.R.string.msg_network_not_connected);
			R rtn;
			try {
				rtn = (R) getReturnClassType ().newInstance();
				Method method = rtn.getClass().getMethod("setMsg", String.class);
				method.invoke(rtn,activity.getString(kr.go.citis.lib.R.string.msg_network_not_connected));// "Not connected"
				Method method2 = rtn.getClass().getMethod("setMsgCode", String.class);
				method2.invoke(rtn,Constant.ERR_CODE_NETWORK);
//				complete((R)rtn);
//				activity.alert(kr.go.citis.lib.R.string.msg_network_not_connected);
				activity.stopProgressBar();				
			} catch (Exception e) {
				e.printStackTrace();
			}
			return;
		}		
		if( mThreadRunning == true )
			return;
//		if (getReturnClassType ().equals(ArrayList.class)) {
			new AsyncHttpTask<R,S>().execute(data);
//		}
	}
	
	// require
	public abstract void complete(R result);
	
	public abstract void callback(R result);
	// thread
	boolean mThreadRunning = false;
	
	class AsyncHttpTask<RR,SS> extends AsyncTask<AsyncHttpParam, Integer, R> {
		@Override
		protected void onPreExecute() {
			super.onPreExecute();
		}
		@Override
    	protected R doInBackground(AsyncHttpParam... data) {
			try {
				return send(data[0],true);
			} catch (Exception e) {
				e.printStackTrace();
			}
    		return null;
    	}
    	
    	@Override
    	protected void onProgressUpdate(Integer... progress) {
//    		progressBar.setProgress(progress[0]);
    	}
    	
    	protected void onPostExecute(R result) {
			mThreadRunning = true;
//			hideDialog();
			BaseActivity activity = (BaseActivity)context;			
			if ( result == null ) {
				R rtn;
				try {
			    	activity.toast(kr.go.citis.lib.R.string.msg_network_sockettimeout);				
					rtn = (R) getReturnClassType ().newInstance();
					Method method1 = rtn.getClass().getMethod("setMsgCode", String.class);
					method1.invoke(rtn,Constant.ERR_CODE_SOCKETTIMEOUT);
					Method method2 = rtn.getClass().getMethod("setMsg", String.class);
					method2.invoke(rtn,activity.getString(kr.go.citis.lib.R.string.msg_network_sockettimeout)); // "소켓타임아웃에러.."
//					complete((R) rtn);
//					activity.alert(kr.go.citis.lib.R.string.msg_network_sockettimeout);
					activity.stopProgressBar();
				} catch (Exception e1) {
					e1.printStackTrace();
				}
			} else {
				R rtn = (R) result;
				try {
					Method method1 = rtn.getClass().getMethod("getMsgCode");
					Method method2 = rtn.getClass().getMethod("getMsg");
					String msgCode = (String)method1.invoke(rtn);
					String msg     = (String)method2.invoke(rtn);
					if ( Constant.ERR_CODE_SUCCESS.equals(msgCode)){
						complete(rtn);
						callback(rtn);
//					} else {
//						activity.alert(msg);						
					} else {
						if (Constant.ERR_CODE_NOT_FOUND.equals(msgCode)) {
							activity.toast(kr.go.citis.lib.R.string.msg_server_error_file_not_found);
						} else {
							complete(rtn);
						}
					}
				} catch (Exception e) {
					e.printStackTrace();
				}
				activity.stopProgressBar();				
				
			}
			super.onPostExecute(result);    		
    	}
    	
    	@Override
		protected void onCancelled() {
			super.onCancelled();
		}
    }
}