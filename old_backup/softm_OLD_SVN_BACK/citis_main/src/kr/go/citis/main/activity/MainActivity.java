package kr.go.citis.main.activity;

import kr.go.citis.lib.Constant;
import kr.go.citis.lib.TitleView.OnTopClickListner;
import kr.go.citis.lib.Util;
import kr.go.citis.main.BasicActivity;
import kr.go.citis.main.R;
import kr.go.citis.main.common.WUtil;
import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.view.View;
import butterknife.OnClick;

/**
 * @author softm
 * MainActivity
 * 메인엑티비티.
 */
public class MainActivity extends BasicActivity implements OnTopClickListner {
	public static final String TAG = Constant.LOG_TAG;
	
	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		init();
	}

	private void init() {
	    setLayout(R.layout.activity_main);
	    setTopTitle(R.string.title_main);
	    getTopTitleBar().setImageResource0(R.drawable.logo_icon);
		
	    loast( var.USER_ID + ":" +  var.USER_ID + " / " + Constant.SERVER_CHECK_URL);
		Util.i(TAG,"var.USER_ID     : " +var.USER_ID    );
		Util.i(TAG,"var.SERVER_IP   : " +var.SERVER_IP  );
		Util.i(TAG,"var.SERVER_PORT : " +var.SERVER_PORT);
		Util.i(TAG,"WConstant.SERVER_CHECK_URL : " +Constant.SERVER_CHECK_URL);
	}
	
	/**
	 * Top상단 메인 버튼 클릭
	 * @param v
	 */
    @Override
    public void onClickMainButton(View v) {
    	WUtil.goMain(this);
    }
    
	/**
	 * Top상단 첫번째 버튼 클릭
	 */
    @Override
    public void onClickOneButton(View v) {
    	onBackPressed();
    }

    /**
     * Top상단 두번째 버튼 클릭
     */
    @Override
    public void onClickTwoButton(View v) {
		View anchor = (View) findViewById( R.id.et_search );	
       	showMenu(anchor, R.menu.main);     	
//       	showMenu(v, R.menu.main);     	
    }
    
	@OnClick({ R.id.btn_test_main,R.id.btn_csr_bsl,R.id.btn_drw_mng,R.id.btn_photo_mng,R.id.v_testing })
	public void onClick(View v) {
		switch (v.getId()) {
		case R.id.btn_test_main:
			Intent sIntent1 = new Intent(MainActivity.this,TestChkMainActivity.class); //검측관리
			startActivity(sIntent1);
			break;
		case R.id.btn_csr_bsl:
			Intent sIntent2 = new Intent(MainActivity.this,CsrBslActivity.class); //공사기준
			startActivity(sIntent2);	
			break;
		case R.id.btn_drw_mng:
			Intent sIntent3 = new Intent(MainActivity.this,DrwMngActivity.class); //도면관리
			startActivity(sIntent3);	
			break;
		case R.id.btn_photo_mng:
			Intent sIntent4 = new Intent(MainActivity.this,PhotoMngActivity.class); //사진관리
			startActivity(sIntent4);
			break;
		case R.id.v_testing:
			Intent sIntent5 = new Intent(MainActivity.this,TestingActivity.class); //사진관리
			startActivity(sIntent5);	
			break;
		}
	}

	private boolean backPressedToExitOnce =false;
	@Override
	public void onBackPressed() {
	    if (backPressedToExitOnce) {
	        super.onBackPressed();
	    } else {
	        this.backPressedToExitOnce = true;
	        toast(R.string.msg_press_again_to_exit); // 다시 눌러 종료하십시요.
	        new Handler().postDelayed(new Runnable() {
	            @Override
	            public void run() {
	                backPressedToExitOnce = false;
	            }
	        }, 2000);
	    }
	}
}
