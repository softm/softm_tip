package kr.co.gscaltex.gsnpoint.setting;

import kr.co.gscaltex.gsnpoint.BaseActivity;
import kr.co.gscaltex.gsnpoint.NewMainMenu;
import kr.co.gscaltex.gsnpoint.R;
import kr.co.gscaltex.gsnpoint.TitleView;
import kr.co.gscaltex.gsnpoint.util.Debug;
import kr.co.gscaltex.gsnpoint.util.FileInfo;
import android.app.AlertDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.os.Bundle;
import android.text.Editable;
import android.text.TextWatcher;
import android.view.KeyEvent;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.View.OnKeyListener;
import android.view.inputmethod.InputMethodManager;
import android.widget.EditText;
import android.widget.ImageButton;

public class SettingPwsetAgainView extends BaseActivity implements OnClickListener, OnKeyListener {
	private String TAG = "GS";
	private FileInfo fi = new FileInfo();
	
	private boolean m_bLogin = false;
	
	private EditText num1,num2,num3,num4= null;
	private ImageButton mOkBtn = null;
	private String serialNum=null;
	
	private InputMethodManager imm;
	
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.settingpwsetagain);
		Bundle extras = getIntent().getExtras();
		if(extras!=null){
			m_bLogin = extras.getBoolean("login");
			serialNum = extras.getString("serialNum");
		}
		
		new TitleView(this,true,false,R.string.TITLE_TYPE_SETTING_PASSWORD,m_bLogin); 
		new NewMainMenu(this);
		
		imm = (InputMethodManager)getSystemService(Context.INPUT_METHOD_SERVICE);
		
		num1 = (EditText)findViewById(R.id.edit1);
		num2 = (EditText)findViewById(R.id.edit2);
		num3 = (EditText)findViewById(R.id.edit3);
		num4 = (EditText)findViewById(R.id.edit4);
		
		num1.addTextChangedListener(edit_one);
		num2.addTextChangedListener(edit_two);
		num3.addTextChangedListener(edit_three);
		num4.addTextChangedListener(edit_four);
		
		num2.setOnKeyListener(this);
		num3.setOnKeyListener(this);
		num4.setOnKeyListener(this);
		
		mOkBtn = (ImageButton)findViewById(R.id.pwset_ok_btn);
		mOkBtn.setId(0);
		mOkBtn.setOnClickListener(this);
		
	}
	
	public void onClick(View v) {
		AlertDialog.Builder alt_bld = new AlertDialog.Builder(this);  
		
		switch (v.getId()) {
		case 0 : 
			String num_one = num1.getText().toString();
			String num_two = num2.getText().toString();
			String num_three = num3.getText().toString();
			String num_four = num4.getText().toString();
			final String serialAgainNum= num_one+num_two+num_three+num_four;
			
			if((serialAgainNum.length())==4){
				if(serialAgainNum.equals(serialNum)){
					alt_bld.setMessage(R.string.alert_str_passwordset_ok)  
			    	.setCancelable(false)  
			    	.setPositiveButton("확인", new DialogInterface.OnClickListener() {					
						public void onClick(DialogInterface dialog, int which) {
							fi.setSettingInfo(getBaseContext(), serialAgainNum, FileInfo.PASSWORD_MYAPP);
							setResult(RESULT_OK);
							finish();
						}
			    	});  				
					showAlertDialog(alt_bld);
				}else{
					clearPassword();
		
					alt_bld.setMessage(R.string.alert_str_password_error)  
			    	.setCancelable(false)  
			    	.setPositiveButton("확인", new DialogInterface.OnClickListener() {					
						public void onClick(DialogInterface dialog, int which) {
						}
			    	}); 
					showAlertDialog(alt_bld);
				}
			}else{
				
				alt_bld.setMessage(R.string.alert_str_password_error2)  
		    	.setCancelable(false)  
		    	.setPositiveButton("확인", new DialogInterface.OnClickListener() {					
					public void onClick(DialogInterface dialog, int which) {
					}
		    	});
				showAlertDialog(alt_bld);
			}		
			break;
		
		}
	}
	
	private void showAlertDialog(AlertDialog.Builder bld ){
    	AlertDialog alert = bld.create();  
    	alert.setTitle(R.string.alert_str);
    	alert.show(); 
    }
	
	private void clearPassword(){
		num1.setText(null);
		num2.setText(null);
		num3.setText(null);
		num4.setText(null);
		num1.requestFocus();
	}
	
	private TextWatcher edit_one = new TextWatcher(){
		public void afterTextChanged(Editable s) {
			String str_0 = num1.getText().toString();
			int num=str_0.length();
			if(num==1){
				num2.requestFocus();
			}		
		}
		public void beforeTextChanged(CharSequence s, int start, int count,
				int after) {
			// TODO Auto-generated method stub		
		}
		public void onTextChanged(CharSequence s, int start, int before,
				int count) {
			// TODO Auto-generated method stub			
		}		
	};
	
	private TextWatcher edit_two = new TextWatcher(){
		public void afterTextChanged(Editable s) {
			String str_0 = num2.getText().toString();
			int num=str_0.length();
			if(num==1){
				num3.requestFocus();
			}		
		}
		public void beforeTextChanged(CharSequence s, int start, int count,		
				int after) {
			// TODO Auto-generated method stub		
		}
		public void onTextChanged(CharSequence s, int start, int before,
				int count) {
			// TODO Auto-generated method stub			
		}		
	};
	
	private TextWatcher edit_three = new TextWatcher(){
		public void afterTextChanged(Editable s) {
			String str_0 = num3.getText().toString();
			int num=str_0.length();
			if(num==1){
				num4.requestFocus();
			}		
		}
		public void beforeTextChanged(CharSequence s, int start, int count,
				int after) {
			// TODO Auto-generated method stub		
		}
		public void onTextChanged(CharSequence s, int start, int before,
				int count) {
			// TODO Auto-generated method stub			
		}		
	};
	
	private TextWatcher edit_four = new TextWatcher(){
		public void afterTextChanged(Editable s) {
			String str_0 = num4.getText().toString();
			int num=str_0.length();
			if(num==1){
				imm.hideSoftInputFromWindow(num4.getWindowToken(), 0);
			}		
		}
		public void beforeTextChanged(CharSequence s, int start, int count,
			
				int after) {
			// TODO Auto-generated method stub		
		}

		public void onTextChanged(CharSequence s, int start, int before,
				int count) {
			// TODO Auto-generated method stub			
		}		
	};
	
	@Override
	protected void httpResult(int what, boolean result, String kind) {
		// TODO Auto-generated method stub
		//Debug.trace(TAG, "httpResult" + "[" + what + "](" + result + ")") ;	
	}
	
	@Override
	public boolean onKey(View v, int arg1, KeyEvent event) {
		// TODO Auto-generated method stub
				
		String str= "";
		switch(v.getId()){
			
		case R.id.edit2:
			if(event.getKeyCode()==KeyEvent.KEYCODE_DEL){
				
				str = num2.getText().toString();
				int num=str.length();
				if(num==0){
					num1.requestFocus();
				}
			}
				
			break;
		case R.id.edit3:
			if(event.getKeyCode()==KeyEvent.KEYCODE_DEL){
				
				str = num3.getText().toString();
				int num=str.length();
				if(num==0){
					num2.requestFocus();
				}
			}
			break;
		case R.id.edit4:
			if(event.getKeyCode()==KeyEvent.KEYCODE_DEL){
				
				str = num4.getText().toString();
				int num=str.length();
				if(num==0){
					num3.requestFocus();
				}
			}
			break;	
		}
		return false;
	}
}
