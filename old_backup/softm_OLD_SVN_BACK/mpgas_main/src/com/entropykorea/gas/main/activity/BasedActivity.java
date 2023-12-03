package com.entropykorea.gas.main.activity;

import java.util.Timer;
import java.util.TimerTask;

import android.app.Activity;
import android.app.AlertDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.media.Ringtone;
import android.media.RingtoneManager;
import android.net.Uri;
import android.os.Bundle;
import android.os.Handler;
import android.text.TextUtils;
import android.view.ContextThemeWrapper;
import android.view.Gravity;
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
import com.entropykorea.gas.lib.BaseActivity;
import com.entropykorea.gas.lib.Constant;
import com.entropykorea.gas.main.AppContext;
import com.entropykorea.gas.main.R;
import com.entropykorea.gas.main.activity.ui.InfoPopupWindow;
import com.entropykorea.gas.main.activity.ui.SimpleGestureFilter;
import com.entropykorea.gas.main.activity.ui.SimpleGestureFilter.SimpleGestureListener;
import com.entropykorea.gas.main.activity.ui.TitleBar;
import com.entropykorea.gas.main.activity.ui.TitleBar.OnTopClickListner;
import com.entropykorea.gas.main.activity.view.ViewMapper;
import com.entropykorea.gas.main.common.DLog;
import com.entropykorea.gas.main.database.Var;



public class BasedActivity extends BaseActivity implements SimpleGestureListener, OnTopClickListner {
	
	public final static int SWIPE_UP    = 1;
	public final static int SWIPE_DOWN  = 2;
	public final static int SWIPE_LEFT  = 3;
	public final static int SWIPE_RIGHT = 4;
	
	private SimpleGestureFilter detector = null; // for swipe
	private OnSwipeListner listner = null;
	
	public Var var; // 사용변수

	TitleBar mTitleBar;
	
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
		if( mTitleBar != null ) {
			mTitleBar.setOnTopClickListner(this);
		}

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
	
	public void confirmNoCancelable(String message, String methodNameOk ) {
		confirmMethodNameOk = methodNameOk;
		confirmObject = this;

		AlertDialog.Builder alt_bld = new AlertDialog.Builder(new ContextThemeWrapper(this, R.style.DialogTheme));
		alt_bld.setMessage( "\n" + message + "\n" );
		alt_bld.setPositiveButton(
				"확인",
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
		alt_bld.setCancelable(false);
		AlertDialog dialog = alt_bld.show();

		TextView messageText = (TextView)dialog.findViewById(android.R.id.message);
		messageText.setGravity(Gravity.CENTER);

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
	
	


}
