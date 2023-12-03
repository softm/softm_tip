package kr.co.gscaltex.gsnpoint.card;

import kr.co.gscaltex.gsnpoint.BaseActivity;
import kr.co.gscaltex.gsnpoint.R;
import kr.co.gscaltex.gsnpoint.setting.SettingMainView;
import kr.co.gscaltex.gsnpoint.util.Debug;
import kr.co.gscaltex.gsnpoint.util.FileInfo;
import kr.co.gscaltex.gsnpoint.util.Util;
import android.app.Activity;
import android.app.AlertDialog;
import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.os.Environment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.widget.FrameLayout;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.TextView;

public class CardUserInfoTopView extends BaseActivity implements OnClickListener {

	private Activity activity;
	
	String TAG = "GS" ;

	private static String outFilePath = Environment.getExternalStorageDirectory().getAbsolutePath() + "/" + Util.DIR + "/"+ "myphoto.jpg"; 
	
	public CardUserInfoTopView(Activity activity) {
		this.activity = activity;
		ViewGroup group = getContentView(activity.getWindow().getDecorView());
		initLayout(activity, group);
	}

	private void initLayout(Activity activity, ViewGroup group) {
		LayoutInflater layout = activity.getLayoutInflater();
		View view = layout.inflate(R.layout.carduserinfotop, null);

		TextView login_name = (TextView)view.findViewById(R.id.login_name);
		ImageView my_picture = (ImageView)view.findViewById(R.id.my_picture);
		my_picture.setOnClickListener(this);
		
		FileInfo fi = new FileInfo();
        String userName = fi.getSettingInfo(activity, FileInfo.USER_NAME);
        
        String myphoto_set = fi.getSettingInfo(activity, FileInfo.MYPHOTO_SET);
		
		if(myphoto_set==null||myphoto_set.equals("")){
			Debug.trace("test","have been not auto save");
		}else if(myphoto_set.equals("TRUE")){
			Debug.trace("test","set my photo image");
			my_picture.setImageDrawable(null);
			Bitmap bm = BitmapFactory.decodeFile(outFilePath);
			my_picture.setImageBitmap(bm);
		}
		
        login_name.setText(userName);
		
		group.addView(view, 0);
		
		ImageButton imgBtnAllView = (ImageButton)activity.findViewById(R.id.newcard_button); // 새카드.
		imgBtnAllView.setOnClickListener(this);		
	}

	private ViewGroup getContentView(View parent) {
		ViewGroup view = null;

		if (parent instanceof ViewGroup) {
			ViewGroup group = (ViewGroup)parent;
			if (group.getClass().equals(FrameLayout.class)) {
				return (ViewGroup)group.getChildAt(0);
			}
			else {
				for (int i = 0; i < group.getChildCount(); i++) {
					view = getContentView(group.getChildAt(i));
				}
			}
		}

		return view;
	}

	
	public void onClick(View v) {
		// TODO Auto-generated method stub
//		AlertDialog.Builder alt_bld = new AlertDialog.Builder(activity);  				
//		alt_bld.setMessage("test")  
//		.setCancelable(false) 
//		.setPositiveButton("확인", new DialogInterface.OnClickListener() {					
//			public void onClick(DialogInterface dialog, int which) {
//			}
//		});  				
//		showAlertDialog(alt_bld);
		/*
		Debug.trace(TAG, "id : newcard_button "+ v.getId() );
		Intent intent = new Intent(activity, CardRegView.class);
		activity.startActivity(intent);		
		*/
		Intent intent ;
		switch (v.getId()) {
		case R.id.my_picture : 	// present button
			//intent = new Intent(activity, SettingMainView.class);
			intent = new Intent(activity, CardMainView.class);
			intent.putExtra("login", true);
			activity.startActivity(intent);
//			activity.overridePendingTransition(R.anim.slide_up, 0);
			
	         break;		
			
		case R.id.btn_open:
			intent  = new Intent(activity, SettingMainView.class);
			
			activity.startActivity(intent);
	         break;
		}
		
	}
	
	private void showAlertDialog(AlertDialog.Builder bld ){
		AlertDialog alert = bld.create();  
		alert.setTitle(R.string.alert_str);
		alert.show(); 
	}

	@Override
	protected void httpResult(int what, boolean result, String kind) {
		// TODO Auto-generated method stub
		
	}	
}
