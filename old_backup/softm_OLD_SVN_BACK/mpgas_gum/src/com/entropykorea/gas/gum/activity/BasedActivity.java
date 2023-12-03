package com.entropykorea.gas.gum.activity;

import java.util.Timer;
import java.util.TimerTask;

import android.app.Activity;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.media.Ringtone;
import android.media.RingtoneManager;
import android.net.Uri;
import android.os.Bundle;
import android.os.Handler;
import android.text.TextUtils;
import android.view.MotionEvent;
import android.view.View;
import android.view.inputmethod.InputMethodManager;
import android.widget.CheckBox;
import android.widget.EditText;
import android.widget.PopupMenu;
import android.widget.PopupMenu.OnMenuItemClickListener;
import android.widget.RadioButton;
import android.widget.TextView;
import android.widget.Toast;

import com.dm.zbar.android.scanner.ZBarConstants;
import com.entropykorea.ewire.eWireSound;
import com.entropykorea.gas.gum.AppContext;
import com.entropykorea.gas.gum.R;
import com.entropykorea.gas.gum.activity.ui.InfoPopupWindow;
import com.entropykorea.gas.gum.activity.ui.SimpleGestureFilter;
import com.entropykorea.gas.gum.activity.ui.SimpleGestureFilter.SimpleGestureListener;
import com.entropykorea.gas.gum.activity.ui.TitleBar;
import com.entropykorea.gas.gum.activity.ui.TitleBar.OnTopClickListner;
import com.entropykorea.gas.gum.activity.view.ViewMapper;
import com.entropykorea.gas.gum.common.DLog;
import com.entropykorea.gas.gum.database.DataUtil;
import com.entropykorea.gas.gum.database.Var;
import com.entropykorea.gas.lib.BaseActivity;
import com.entropykorea.gas.lib.Constant;
import com.mypidion.BI300.BI300Bluetooth;



public class BasedActivity extends BaseActivity implements SimpleGestureListener, OnTopClickListner {
	
	public final static int SWIPE_UP    = 1;
	public final static int SWIPE_DOWN  = 2;
	public final static int SWIPE_LEFT  = 3;
	public final static int SWIPE_RIGHT = 4;
	
	private SimpleGestureFilter detector = null; // for swipe
	private OnSwipeListner listner = null;
	
	public Var var; // 사용변수

	TitleBar mTitleBar;
	
	private BI300Bluetooth bi300 = null;

	// keyboard
	private InputMethodManager imm;
	private static final Boolean bUseImm = true;
	
	public void saveVar() {
		AppContext.putValue("VAR", var);
	}
	
	public void readVar() {
		this.var = AppContext.getValue("VAR");
	}

	@Override
	protected void onCreate(Bundle savedInstanceState) {

		// annotation
		ViewMapper.mappingViews( this );
		
		// var
		readVar();
		
		// title
		mTitleBar = (TitleBar) findViewById( R.id.titlebar );
		mTitleBar.setOnTopClickListner(this);

		// keyboard
		this.imm = (InputMethodManager) getSystemService(Context.INPUT_METHOD_SERVICE);
		
		super.onCreate(savedInstanceState);
	}
	
	@Override
	public void onClickBackButton(View v) {
		
	}

	@Override
	public void onClickOneButton(View v) {
		
	}

	@Override
	public void onClickTwoButton(View v) {
		
	}

	
	// interface
	public void setOnSwipe(Activity context,OnSwipeListner listner) {
		// Detect touched area 
		detector = new SimpleGestureFilter(context,this);
		this.listner = listner;
	}
	
	public interface OnSwipeListner {
		public void onSwipe(int direction);
		public void onDoubleTap();
	}

	// for swipe
	@Override
	public boolean dispatchTouchEvent(MotionEvent me){
		if( detector != null ) {
			// Call onTouchEvent of SimpleGestureFilter class
			this.detector.onTouchEvent(me);
		}
		return super.dispatchTouchEvent(me);
	}
	
	@Override
	public void onSwipe(int direction) {
		if( listner != null ) { 
			listner.onSwipe(direction);
		}
	}

	@Override
	public void onDoubleTap() {
		DLog.d("DOUBLE TAP");
		if( listner != null ) { 
			listner.onDoubleTap();
		}
	}
	
	// showmenu
	public void showMenu(View anchor, int menuRes) {
		//Context wrapper = new ContextThemeWrapper(getBaseContext(), R.style.PopupMenu);
		PopupMenu popup = new PopupMenu(this, anchor);
	    popup.setOnMenuItemClickListener((OnMenuItemClickListener) this);
	    popup.inflate(menuRes);
	    popup.show();
	}	

	// intent
	public void goMap( String address ) {
		Uri uri = Uri.parse("geo:0,0?q=" + address );
		Intent intent = new Intent(Intent.ACTION_VIEW, uri);
		//intent.setClassName("com.google.android.apps.maps", "com.google.android.maps.MapsActivity");
		startActivity(intent);
	}
	
	public void goDial( String number ) {
		Uri uri = Uri.parse("tel:"+number);
		
		//Intent intent = new Intent(Intent.ACTION_CALL, urinumber);
    	Intent intent = new Intent(Intent.ACTION_DIAL, uri);
    	startActivity(intent);        		
	}
	
	// util
	public boolean isEditFilled( EditText et ) {
		String string = et.getText().toString().trim();
		if( string.length() > 0 ) {
			return true;
		}
		return false;
	}
	
	public boolean isRadioChecked( RadioButton... radios ) {
		for( RadioButton radio : radios) {
			if( radio.isChecked() ) {
				return true;
			}
		}
		return false;
	}
	
	public void setTextString( TextView tv, String value ) {
		tv.setText(value);
	}
	
	public void setTextString( int resId, String value ) {
		TextView tv = (TextView) findViewById( resId );
		tv.setText(value);
	}
	
	public String getTextString( int resId ) {
		TextView tv = (TextView) findViewById( resId );
		return tv.getText().toString().trim();
	}
	
	public String getString( TextView editText ) {
		return editText.getText().toString().trim();
	}
	
	public String getChecked( CheckBox checkBox ) {
		if( checkBox.isChecked() ) {
			return "Y";
		} 
		return "N";
	}
	
	public void setVisible( View viewVisible, View viewGone ) {
		viewVisible.setVisibility(View.VISIBLE);
		viewGone.setVisibility(View.GONE);
	}
	
	public void setEnabled( View view, boolean enabled ) {
		view.setEnabled(enabled);
		view.setClickable(enabled);
		
		view.clearFocus();
	}
	
	// toast
	public void toast( String value ) {
		Toast.makeText(this, value, Toast.LENGTH_LONG).show();
	}
	
	// log
	public void log( String value ) {
		DLog.d( value );
	}
	
	// popup window
	private View popupAnchor;
	private String popupMessage;
	private int popupXOffset;
	private int popupYOffset;
	public void showInfoPopup( String message, View anchor, int xOffset, int yOffset ) {

		popupAnchor = anchor;
		popupMessage = message;
		popupXOffset = xOffset;
		popupYOffset = yOffset;
		
		// onResume 등에서 실행할경우 run delay 
		new Handler().postDelayed(new Runnable() {
			public void run() {
				//View a = (View) findViewById(R.id.title);
				InfoPopupWindow popup = new InfoPopupWindow(popupAnchor, popupMessage);
				popup.showLikePopDownMenu( popupXOffset, popupYOffset );
				soundNotification();
			}
		},100);

	}
	
	public void showInfoPopup( String message ) {
		showInfoPopup( message, (View) findViewById(R.id.title), -50, 0 );
		hideKeyboard();
	}

	// sound 
	public void soundNotification() {
		new Handler().post( new Runnable() {
			public void run() {
				try {
				    Uri notification = RingtoneManager.getDefaultUri(RingtoneManager.TYPE_NOTIFICATION);
				    Ringtone r = RingtoneManager.getRingtone(getApplicationContext(), notification);
				    r.play();
				} catch (Exception e) {
				    e.printStackTrace();
				}		
			}
		});
	}
	
	public void beep() {
		eWireSound.playBeep(this);
	}

	// keyboard
	public boolean isShowKeyboard() {
		boolean rtn = false;
		if( bUseImm && imm != null )
		{
			return imm.isActive();
		}
		return rtn;
	}
	
	public void showKeyboard() {

		if( bUseImm )
		{
			TimerTask myTask = new TimerTask(){
				public void run(){
					if( imm != null )
						try {
							imm.showSoftInput(getCurrentFocus(), InputMethodManager.SHOW_FORCED);
						} catch (Exception e) {
							e.printStackTrace();
						}
				}	
			};
	
			Timer timer = new Timer();
			timer.schedule(myTask, 500);
		}
		
	}

	public void hideKeyboard() {
		
		if( !isShowKeyboard() ) {
			return;
		}
		
		if( bUseImm && imm != null )
		{
			try {
				// focus 가 edittext 가 아닐 경우 Exception 
				imm.hideSoftInputFromWindow(getCurrentFocus().getWindowToken(), 0);
			} catch (Exception e) {
				e.printStackTrace();
			}
		}
		
	}
	
	public void toggleKeyboard( Boolean bshow ) {
		
		try {
			if( bshow )
				imm.showSoftInput(getCurrentFocus(), InputMethodManager.SHOW_FORCED);
			else
				imm.hideSoftInputFromWindow(getCurrentFocus().getWindowToken(), 0);
		} catch (Exception e) {
			e.printStackTrace();
		}
							
	}

	// confirm dialog
	// for Reflection
	String confirmMethodNameOk;
	String confirmMethodNameCancel;
	Object confirmObject;
//	public void confirm(String message, String methodNameOk ) {
//		confirm( message, methodNameOk, "" );
//	}
	public void confirm(String message, String methodNameOk ) {
		confirmMethodNameOk = methodNameOk;
		confirmObject = this;

		alert(message, 
				new DialogInterface.OnClickListener() {
					@Override
					public void onClick(DialogInterface dialog, int which) {
						if( confirmMethodNameOk != null && confirmMethodNameOk.length() > 0 ) {
							try {
								confirmObject.getClass().getMethod(confirmMethodNameOk).invoke(confirmObject);
							} catch (Exception e) {
								e.printStackTrace();
								log( confirmMethodNameOk + " call error!");
							}
						}
					}
				}); 
		beep();

	}
	
	public void confirm(String message, String methodNameOk, String methodNameCancel) {
		confirmMethodNameOk = methodNameOk;
		confirmMethodNameCancel = methodNameCancel;
		confirmObject = this;

		confirm(message, 
				new DialogInterface.OnClickListener() {
					@Override
					public void onClick(DialogInterface dialog, int which) {
						if( confirmMethodNameOk != null && confirmMethodNameOk.length() > 0 ) {
							try {
								confirmObject.getClass().getMethod(confirmMethodNameOk).invoke(confirmObject);
							} catch (Exception e) {
								e.printStackTrace();
								log( confirmMethodNameOk + " call error!");
							}
						}
					}
				}, 
				new DialogInterface.OnClickListener() {
					@Override
					public void onClick(DialogInterface dialog, int which) {
						if( confirmMethodNameCancel != null && confirmMethodNameCancel.length() > 0 ) {
							try {
								confirmObject.getClass().getMethod(confirmMethodNameCancel).invoke(confirmObject);
							} catch (Exception e) {
								e.printStackTrace();
								log( confirmMethodNameCancel + " call error!");
							}
						}
					}
				});
		beep();
	}

	// scnner
	public boolean goProcessActivity( String gm_no ) {
		String read_idx = DataUtil.findReadIdxByGmNo( gm_no );
		if( read_idx.length() > 0 ) {
			var.READ_IDX = read_idx;
			saveVar();
			runActivity(ProcessActivity.class);
			return true;
		} else {
			alert("인식된 세대가 없습니다.\n확인 바랍니다.");
		}
		return false;
	}

	public void stopBi300() {
		if( bi300 != null ) {
			new Runnable() {
				@Override
				public void run() {
					bi300.stopBI300();
					bi300 = null;
				}
			}.run();
		}
	}
	
	public void lanchScan(View v) {
		if( var.BARCD_EQUIP_USE_YN.equals("Y") ) {
    		try {
    			//바코드 블루투스 리더기 연동 
    			if( bi300 == null ) {
    				bi300 = new BI300Bluetooth(this,  new Handler() {
    					@Override
    					public void handleMessage(android.os.Message msg) {
    						String message = (String) msg.obj;
    						switch (msg.what) {
    						case 1:
    							bi300.setDialogText("세대를 검색중입니다.");
    							goProcessActivity( message.trim() );
    							stopBi300();
    							break;
    						}
    					};
    				});
    			} else {

    			}
    			
    			new Runnable() {
					@Override
					public void run() {
						bi300.startBI300();
					}
				}.run();
    			
    			//alert("바코드 스캐너를 ")
			} catch (Exception e) {
				//toast("바코드스캐너 블루투스 연결하세요.");
			}
		} else {
			launchScanner(v);
		}
	}

	
    @Override
	protected void onActivityResult(int requestCode, int resultCode, Intent data) {
	    switch (requestCode) {
	        case Constant.ZBAR_SCANNER_REQUEST:
	        	
	        	if (resultCode == RESULT_OK) {
	        		String number = data.getStringExtra(ZBarConstants.SCAN_RESULT);
	        		if( number.length() > 0 ) {
								goProcessActivity( number );
	        		} 
	        		//toast( number );
	        	} else if(resultCode == RESULT_CANCELED && data != null) {
	        		String error = data.getStringExtra(ZBarConstants.ERROR_INFO);
	        		if(!TextUtils.isEmpty(error)) {
	        			Toast.makeText(this, error, Toast.LENGTH_SHORT).show();
	        		}
	        	}
	            break;
	        case Constant.ZBAR_QR_SCANNER_REQUEST:
	            break;
	    }
	}

}
