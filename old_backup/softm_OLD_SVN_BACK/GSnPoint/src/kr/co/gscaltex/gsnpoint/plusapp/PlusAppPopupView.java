package kr.co.gscaltex.gsnpoint.plusapp;

import java.net.URL;
import java.net.URLConnection;

import kr.co.gscaltex.gsnpoint.BaseActivity;
import kr.co.gscaltex.gsnpoint.DefaultApplication;
import kr.co.gscaltex.gsnpoint.NewMainMenu;
import kr.co.gscaltex.gsnpoint.R;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.net.Uri;
import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.WindowManager;
import android.widget.ImageButton;

public class PlusAppPopupView extends BaseActivity implements OnClickListener {

	DefaultApplication mApp ;
	private ImageButton mBtnClose  = null;
	private ImageButton mBtnPlusapp  = null;
	
	private String mCate, mCode = null;
	
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		
		WindowManager.LayoutParams IpWindow = new WindowManager.LayoutParams();
		IpWindow.flags = WindowManager.LayoutParams.FLAG_DIM_BEHIND;
		IpWindow.dimAmount= 0.75f;
		getWindow().setAttributes(IpWindow);
		
		setContentView(R.layout.plusapppopup);	
		
		Bundle extras = getIntent().getExtras();
		if(extras!=null){
			mCate = extras.getString("cate");
			mCode = extras.getString("code");
		}
		new NewMainMenu(this);
		
		mApp = (DefaultApplication)this.getApplicationContext();
		
		mBtnClose= (ImageButton)findViewById(R.id.popup_close_button);
		mBtnClose.setOnClickListener(this);
		
		mBtnPlusapp = (ImageButton)findViewById(R.id.plusapp_button);
		mBtnPlusapp.setOnClickListener(this);
	}
	
	@SuppressWarnings("static-access")
	public void onClick(View v) {
		// TODO Auto-generated method stub
		switch (v.getId()) {
		case R.id.popup_close_button : 
			mApp.selectedIndex=99;
        	finish();
	         break;
	         
		case R.id.plusapp_button :
			
			PackageManager pm = getPackageManager();
			
			Intent in = new Intent(); 
			in.setAction( Intent.ACTION_MAIN );
			in.addCategory( Intent.CATEGORY_LAUNCHER ); 
			in = pm.getLaunchIntentForPackage("com.gsmpp.GSnPo");
				
			if(in==null){
				Uri uri= Uri.parse("market://details?id=com.gsmpp.GSnPo");
				Intent intent = new Intent(Intent.ACTION_VIEW, uri);
				intent.addCategory(intent.CATEGORY_BROWSABLE);
				intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
				startActivity(intent);
				
				return;
			}
			
			in.putExtra("URLSchema", "kr.co.gscaltex.gsnpoint");
			in.putExtra("menu1", "");
			in.putExtra("menu2", "");
			in.putExtra("cate", mCate);
			in.putExtra("code", mCode);
			in.setFlags(in.FLAG_ACTIVITY_NO_USER_ACTION);		
			startActivity(in);

			
			break;
		}
	}

	@Override
	protected void httpResult(int what, boolean result, String kind) {
		// TODO Auto-generated method stub
		
	}

}
