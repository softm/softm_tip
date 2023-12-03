package kr.go.citis.main;

import kr.go.citis.lib.BaseActivity;
import kr.go.citis.lib.TitleView.OnTopClickListner;
import kr.go.citis.lib.common.SimpleProgressDialog;
import kr.go.citis.main.activity.SetupActivity;
import kr.go.citis.main.common.WUtil;
import android.annotation.SuppressLint;
import android.content.Context;
import android.content.DialogInterface;
import android.content.DialogInterface.OnCancelListener;
import android.content.Intent;
import android.graphics.Color;
import android.graphics.Paint;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.ViewGroup.LayoutParams;
import android.widget.Toast;
import butterknife.ButterKnife;
import butterknife.OnLongClick;

/**
 * BasicActivity
 * 기초엑티비티
 * @author softm  
 */ 
public abstract class BasicActivity extends BaseActivity implements OnTopClickListner {
	public static final String LOG_TAG = "CITIS";
	protected TopTitleView topTitleBar = null;
	protected ViewGroup body     = null;
	protected ViewGroup loading  = null;	
	
	public TopTitleView getTopTitleBar() {
		return topTitleBar;
	}

	public void setBody(ViewGroup body) {
		this.body = body;
	}
	
	public void setTopTitle(int id) {
		setTopTitle(getString(id));
	}
	
	public void setTopTitle(String title) {
		getTopTitleBar().setTitle(title);
	}
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		WUtil.setEnvironMent(this);
	}
	public void setLayout(int id,boolean showBackButton) {
		setContentView(id);
		topTitleBar = new TopTitleView(this, kr.go.citis.main.R.string.title_main,showBackButton,false);
		topTitleBar.setOnTopClickListner(this);
        LayoutInflater vi = (LayoutInflater) getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        View v  = vi.inflate(R.layout.loading, null);
        this.addContentView(v, new LayoutParams(LayoutParams.MATCH_PARENT, LayoutParams.MATCH_PARENT));
        ButterKnife.bind(this);
        loading = (ViewGroup) findViewById(R.id.loading);
	}
	
	public void setLayout(int id) {
		this.setLayout(id,true);		
	}

	@SuppressLint("ResourceAsColor")
	@Override
	public void startProgressBar() {
		stopProgressBar();
//		Paint paint = new Paint();
//		 paint.setColor(Color.BLACK);
//		 paint.setAlpha(70);
//		 ((RelativeLayout)findViewById(R.id.layout)).setBackgroundColor(paint.getColor());
		 Paint paint = new Paint();
		 paint.setColor(Color.GRAY);
		 paint.setAlpha(70);
		loading.setBackgroundColor(paint.getColor());
		loading.setAlpha(10);
		loading.setVisibility(View.VISIBLE);		
//		progressDialog = SimpleProgressDialog.show(this, "", "", true, true, null);
		progressDialog = SimpleProgressDialog.show(this, "", "", true, true, new OnCancelListener() {
			@Override
			public void onCancel(DialogInterface dialog) {
//				loading.setBackgroundColor(R.color.transparent);
//				loading.setAlpha(100);
				loading.setVisibility(View.GONE);
			}
		});
	}

	@Override
	public void stopProgressBar() {
		super.stopProgressBar();
//		loading.setBackgroundResource(R.color.Gray);
//		loading.setAlpha(100);	
		loading.setVisibility(View.GONE);		
	}

	@OnLongClick({ R.id.title_text })
	public boolean onLongClick(View v) {
		switch (v.getId()) {
		case R.id.title_text:
			Intent sIntent5 = new Intent(BasicActivity.this,SetupActivity.class); //설정
//			sIntent.putExtra("proc_id", proc_id);
			startActivity(sIntent5);	
			break;
		}
		return false;
	}
	
	// loast
	public void loast( int msg) {
		String strMsg    = getString(msg);		
		loast(strMsg);
	}
	// loast
	public void loast( String value ) {
//		Toast.makeText(this, value, Toast.LENGTH_LONG).show();
	}
	
//TODO 확인[로그아웃]
//	@Override
//	public boolean onCreateOptionsMenu(Menu menu) {
//		super.onCreateOptionsMenu(menu);
//		int seq = 0;
//		if ( this.getClass().getName().indexOf("LoginActivity") == -1 && this.getClass().getName().indexOf("MainActivity") == -1 ) {
//			MenuItem itemHome = menu.add(0, 1, 0, "홈");
//			itemHome.setIcon(android.R.drawable.ic_menu_myplaces);
//		}
//		if ( this.getClass().getName().indexOf("LoginActivity") == -1 ) {
//			MenuItem itemLogout = menu.add(0, 2, 0, "로그아웃");			
//			itemLogout.setIcon(android.R.drawable.ic_menu_more);
//		}
//		return true;
//	}
//
//	@Override
//	public boolean onOptionsItemSelected(MenuItem item) {
//		switch (item.getItemId()) {
//		case 1:
//			WUtil.goMain(this);
//			return true;
//		case 2:
//			WUtil.logout(this);
//			return true;
//		case 3:
//			return true;
//		}
//		return false;
//	}
//--------------------------------------------------	 	  
}

