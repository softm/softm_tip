package com.entropykorea.gas.chk.activity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;

import com.entropykorea.gas.chk.R;
import com.entropykorea.gas.lib.BaseActivity;
import com.entropykorea.gas.lib.TitleView.OnTopClickListner;
import com.entropykorea.gas.lib.Util;

/**
 * @author softm
 * MainActivity
 * 메인엑티비티.
 */
public class MainActivity extends BaseActivity implements OnClickListener, OnTopClickListner {
	public static final String TAG = "MPGAS";
	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		String userId = getIntent().getStringExtra("USER_ID");
		String equipCd = getIntent().getStringExtra("EQUIP_CD");
		String barCdEqipUseYn = getIntent().getStringExtra("BARCD_EQUIP_USE_YN");
		String eWireServerIp = getIntent().getStringExtra("EWIRE_SERVER_IP");
		String eWireServerPort = getIntent().getStringExtra("EWIRE_SERVER_PORT");
		String updateServerUrl = getIntent().getStringExtra("UPDATE_SERVER_URL");
		if( DEBUG ) {
			// for test
			var.USER_ID             = "test";
			var.EQUIP_CD            = "01";
			var.BARCD_EQUIP_USE_YN  = "N";
			var.EWIRE_SERVER_IP     = "110.8.124.30";
			var.EWIRE_SERVER_PORT   = "4000";
			var.UPDATE_SERVER_URL   = "http://110.8.124.30:4001/mobile/setup.xml";
			toast( var.USER_ID + ":" + var.EQUIP_CD + ":" + var.BARCD_EQUIP_USE_YN );
		} else {
			if( userId == null || equipCd == null || barCdEqipUseYn == null || 
					eWireServerIp == null || eWireServerPort == null || updateServerUrl == null ) {
//					toast("사용할 수 없는 액세스 입니다");
					toast(R.string.msg_not_exec_alert);
//					alert(R.string.msg_not_exec_alert
//							, new DialogInterface.OnClickListener() {
//								public void onClick(DialogInterface dialog, int whichButton) {
//									finish();
//								}
//							}
//					);				
					finish();
					return;
				}
				var.USER_ID = userId;
				var.EQUIP_CD = equipCd;
				var.BARCD_EQUIP_USE_YN = barCdEqipUseYn;
				var.EWIRE_SERVER_IP = eWireServerIp;
				var.EWIRE_SERVER_PORT = eWireServerPort;
				var.UPDATE_SERVER_URL = updateServerUrl;
		}

		Util.i(TAG,"var.USER_ID            : " +var.USER_ID           );
		Util.i(TAG,"var.EQUIP_CD           : " +var.EQUIP_CD          );
		Util.i(TAG,"var.BARCD_EQUIP_USE_YN : " +var.BARCD_EQUIP_USE_YN);
		Util.i(TAG,"var.EWIRE_SERVER_IP    : " +var.EWIRE_SERVER_IP   );
		Util.i(TAG,"var.EWIRE_SERVER_PORT  : " +var.EWIRE_SERVER_PORT );
		Util.i(TAG,"var.UPDATE_SERVER_URL  : " +var.UPDATE_SERVER_URL );
		
		Intent sIntent = new Intent(this,ChkMainActivity       .class); // 점검메인
//		Intent sIntent = new Intent(this,ChkTargetRcvActivity  .class); // 점검대상수신
//		Intent sIntent = new Intent(this,BldgListActivity      .class); // 건물목록
//		Intent sIntent = new Intent(this,HouseListActivity     .class); // 수용가목록
//		Intent sIntent = new Intent(this,BatchReadmeterActivit .class); // 일괄검침
//		Intent sIntent = new Intent(this,HouseInfActivity      .class); // 수용가정보
//		Intent sIntent = new Intent(this,ChkRegMainActivity    .class); // 점검등록메인
//		Intent sIntent = new Intent(this,MngBoilerChkActivity  .class); // 관리보일러점검
//		Intent sIntent = new Intent(this,MngBurnerChkActivity  .class); // 관리연소기점검
//		Intent sIntent = new Intent(this,MngPipeChkActivity    .class); // 관리배관점검
//		Intent sIntent = new Intent(this,MngGmChkActivity      .class); // 관리계량기점검
//		Intent sIntent = new Intent(this,MngBreakerChkActivity .class); // 관리차단기점검
//		Intent sIntent = new Intent(this,ChkCplActivity        .class); // 점검완료
//		sIntent.putExtra("proc_id", proc_id);
		startActivity(sIntent);	
		finish();	
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

	@Override
	public void onClick(View v) {
	}
}
