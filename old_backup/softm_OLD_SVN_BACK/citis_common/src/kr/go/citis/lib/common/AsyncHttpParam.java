package kr.go.citis.lib.common;    

import java.io.UnsupportedEncodingException;

import kr.go.citis.lib.Constant;
import kr.go.citis.lib.Util;

import org.apache.commons.lang3.builder.ToStringBuilder;

import com.squareup.okhttp.FormEncodingBuilder;
import com.squareup.okhttp.RequestBody;

/**
 * AsyncHttpParam
 * @author softm
 */
public class AsyncHttpParam {
	private String serivce = "";
	private String url = "";
	private RequestBody formBody;
	public AsyncHttpParam(String url) {
		this(url,new FormEncodingBuilder().build());
	}
	
	public AsyncHttpParam(String url, RequestBody formBody) {
		super();
		this.url = url;
		this.formBody = formBody;
	}
	public AsyncHttpParam(String url, RequestBody formBody,String s) {
		super();
		this.serivce= s;
		this.url = (!Constant.SERVER?url+"/"+s:url);
		this.formBody = formBody;
		Util.i("url : " + this.url );
		Util.i("serivce : " + this.serivce );
	}
	public AsyncHttpParam(String url, FormEncodingBuilder fBuilder,String s) {
		super();
		this.serivce= s;
		this.url = (!Constant.SERVER?url+"/"+s:url);
		this.formBody = fBuilder.add("service",s).build();
//		MediaType JSON = MediaType.parse("application/json; charset=utf-8");
//		this.formBody = this.formBody.create(JSON, "{}");
		
		Util.i("url : " + this.url );
		Util.i("serivce : " + this.serivce );
	}
	
//	public AsyncHttpParam(String url, String p, String s) {
//		super();
//		MediaType JSON = MediaType.parse("application/json; charset=utf-8");
//		this.serivce= s;
//		this.url = (!Constant.SERVER?url+"/"+s:url);
//		this.formBody = RequestBody.create(JSON, "{p:'" + p+"',service:'" + s + "'}");
//		Util.i("url : " + this.url );
//		Util.i("serivce : " + this.serivce );
//		Util.i("formBody : " + this.formBody );
//	}
	
	public AsyncHttpParam(String url, String p, String s) {
		super();
		this.serivce= s;
		this.url = (!Constant.SERVER?url+"/"+s:url);
		FormEncodingBuilder fBuilder = new FormEncodingBuilder();
		try {
			this.formBody = fBuilder.add("p",java.net.URLEncoder.encode(p, "UTF-8")).add("service",s).build();
		} catch (UnsupportedEncodingException e) {
			e.printStackTrace();
		}
		Util.i("url : " + this.url );
		Util.i("serivce : " + this.serivce );
	}
	
	public String getUrl() {
		return url;
	}
	public void setUrl(String url) {
		this.url = url;
	}
	
	public String getSerivce() {
		return serivce;
	}

	public void setSerivce(String serivce) {
		this.serivce = serivce;
	}

	public RequestBody getFormBody() {
		return formBody;
	}
	public void setFormBody(RequestBody formBody) {
		this.formBody = formBody;
	}

	@Override
	public String toString() {
		return ToStringBuilder.reflectionToString(this).toString();		
	}

	
}	