package com.entropykorea.gas.chg.activity;

import java.util.HashMap;

import android.annotation.SuppressLint;
import android.content.ClipData;
import android.content.ClipboardManager;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.text.TextUtils;
import android.view.MenuItem;
import android.view.MotionEvent;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.View.OnLongClickListener;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.AdapterView.OnItemSelectedListener;
import android.widget.ImageButton;
import android.widget.PopupMenu.OnMenuItemClickListener;
import android.widget.TextView;
import android.widget.Toast;

import com.dm.zbar.android.scanner.ZBarConstants;
import com.entropykorea.ewire.database.Sqlite;
import com.entropykorea.gas.chg.R;
import com.entropykorea.gas.chg.WApplication;
import com.entropykorea.gas.chg.adapter.HouseListAdapter;
import com.entropykorea.gas.chg.common.DUtil;
import com.entropykorea.gas.chg.common.WConstant;
import com.entropykorea.gas.chg.common.WUtil;
import com.entropykorea.gas.lib.BaseActivity;
import com.entropykorea.gas.lib.Constant;
import com.entropykorea.gas.lib.ListViewMP;
import com.entropykorea.gas.lib.SpinnerCd;
import com.entropykorea.gas.lib.TitleView;
import com.entropykorea.gas.lib.TitleView.OnTopClickListner;
import com.entropykorea.gas.lib.Util;
import com.mypidion.BI300.BI300Bluetooth;

/**
 * @author softm
 * HouseListActivity
 * 수용가목록
 */
@SuppressLint({ "ClickableViewAccessibility", "HandlerLeak" })
public class HouseListActivity extends BaseActivity implements OnClickListener, OnTopClickListner, OnLongClickListener, OnMenuItemClickListener  {
	public static final String TAG = "MPGAS";
	private ImageButton mBtnSearchGb;
	private ImageButton mBtnBatchSign;
	TextView mTvHouseGroupNm;
	
	private SpinnerCd spnCd;
	private String bldg_cd = null;
//	Cursor c;
    private BI300Bluetooth bi300 = null;
    Sqlite mSqlite = null;
	private boolean loaded = false;

	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		Intent intent = getIntent();
		bldg_cd = WUtil.toDefault(intent.getStringExtra("bldg_cd"));
		
		if ( !"".equals(bldg_cd) ) {
			setContentView(R.layout.activity_house_list);		
			init();
		} else {
			alert(R.string.msg_not_exec_alert
					, new DialogInterface.OnClickListener() {
						public void onClick(DialogInterface dialog, int whichButton) {
							finish();
						}
					}
			);
		}
	}

	@SuppressLint("ClickableViewAccessibility")
	private void init() {
		TitleView tv = new TitleView(this, R.string.title_house_list,true);
		tv.setOnTopClickListner(this);
		
		mTvHouseGroupNm = (TextView) findViewById(R.id.tv_house_group_nm);
		
		spnCd = (SpinnerCd)findViewById(R.id.spn_cd);
		mBtnSearchGb = (ImageButton) findViewById(R.id.ib_search_gb);
		mBtnSearchGb.setOnClickListener(this);
		mBtnSearchGb.setTag(Constant.CODE_GUBUN_STREET); // 도로명
		setHouseGroupNm(Constant.CODE_GUBUN_STREET);
		mBtnBatchSign = (ImageButton) findViewById(R.id.ib_batch_sign);
		mBtnBatchSign.setOnClickListener(this);
		
		mTvHouseGroupNm.setOnLongClickListener(this);
		
		spnCd.getCode(Constant.CODE_END_YN,R.string.label_all);
//		spnCd.getCode(new JSONArray(Constant.CODE_JSON_COM01),R.string.label_all);
		spnCd.setValue(Constant.CODE_END_N);
		spnCd.setDialogVisible(false);
		spnCd.setOnTouchListener(new View.OnTouchListener() {
			@Override
			public boolean onTouch(View v, MotionEvent event) {
				if ( event.getAction() == MotionEvent.ACTION_UP ) {				
					if ( "".equals(spnCd.getValue()) ) {
						spnCd.setValue(Constant.CODE_END_N);
					} else if ( Constant.CODE_END_Y.equals(spnCd.getValue()) ) {
						spnCd.setValue("");						
					} else if ( Constant.CODE_END_N.equals(spnCd.getValue()) ) {
						spnCd.setValue(Constant.CODE_END_Y);						
					}
				}
				return false;
			}
		});
		spnCd.setOnItemSelectedListener(new OnItemSelectedListener() {
			public void onItemSelected(AdapterView<?> parent, View view,	int position, long id) {
				runOnUiThread(new Runnable() {
				    public void run() {
						startProgressBar();
						list();
						loaded = true;						
				    }
				});
			}
			public void onNothingSelected(AdapterView<?>  parent) {
//					if ( "".equals(spnCd.getValue()) ) {
//						spnCd.setValue(ConstantChg.CODE_END_Y);
//					}					
			}
		});
	}
	
	final Handler handler = new Handler() {
		public void handleMessage(Message msg) {
			int procId      = msg.getData().getInt("proc_id") ;
			String procCode = msg.getData().getString("proc_code") ;
			int successChk = msg.what;
			String dataString = (String)msg.obj;
			Util.d(LOG_TAG,"handler message" + "[" + procId + " / " + procCode + " / " + successChk + "] dataString:" + dataString) ;			
			stopProgressBar();			
		}
	};
	private void sendMessage(int procId, String procCode, boolean successChk, String dataString) {
		int what = 1;
		Message msg = handler.obtainMessage(successChk?what:what,dataString);
		Bundle bundle = new Bundle() ;
		bundle.putInt   ("proc_id"  , procId  );
		bundle.putString("proc_code", procCode);
		msg.setData(bundle);
		handler.sendMessage(msg);
	}
	
	private void list() {
		ListViewMP lv1 = (ListViewMP)findViewById(R.id.listView1);
//		EditText etSearch = (EditText)findViewById(R.id.et_search);
//		String gb= WUtil.toDefault((String) mBtnSearchGb.getTag());
		String completeYN = WUtil.toDefault(spnCd.getValue());
		String sql = "SELECT "
        		+ " _rowid_ as _id " 
        		+ " , IFNULL(CHG.ROOM_NO,'') AS ROOM_NO " // 호수 
        		+ " , CASE CHG.CO_NM WHEN null THEN CHG.CUST_NM WHEN '' THEN CHG.CUST_NM ELSE CHG.CO_NM END AS CO_NM   " // 상호
        		+ " , CASE CHG.END_YN WHEN 'Y' THEN '" + Constant.CODE_END_YN.get("Y")+ "' WHEN 'N' THEN '" + Constant.CODE_END_YN.get("N")+ "' END  AS END_YN  " // 상태
                + " , CHG.GM_CHG_YM   AS GM_CHG_YM  " // 작업년월(PK)
                + " , CHG.HOUSE_NO AS HOUSE_NO" // 수용가번호(PK)
                + " , CHG.CUST_NO  AS CUST_NO " // 고객번호(PK)
                + "  FROM " + WConstant.TBL_CHG + " CHG "
                + " WHERE BLDG_CD = '" + bldg_cd + "'"
                +
        		(
        		!"".equals(completeYN)? 
        		(
    				completeYN.equals(Constant.CODE_END_Y) 
    				? " AND END_YN='Y' " // 완료 
	        		: " AND END_YN='N' " // 미완료 
        		):""
        		)
        		+ " ORDER BY HOUSE_ORD"        		
        ;
		
		mSqlite = new Sqlite(db);
		mSqlite.rawQuery(sql);
        HouseListAdapter adapter = new HouseListAdapter(getApplicationContext(), mSqlite.getCursor(), 0);
        lv1.setAdapter(adapter);
        
        lv1.setOnItemClickListener( new OnItemClickListener() {
			@Override
			public void onItemClick(AdapterView<?> parent, View view,
					int position, long id) {
				@SuppressWarnings("unchecked")
				HashMap<String, String> key = ((HashMap<String, String>) view.getTag());
                Intent sIntent = new Intent(HouseListActivity.this,HouseInfActivity.class); // 수용가정보
                sIntent.putExtra("bldg_cd"  , bldg_cd                                       ); // 건물그룹번호  
                sIntent.putExtra("gm_chg_ym"   , WUtil.toDefault(key.get("GM_CHG_YM"  ))); // 작업년월(PK)  
                sIntent.putExtra("house_no" , WUtil.toDefault(key.get("HOUSE_NO"))); // 수용가번호(PK)
                sIntent.putExtra("cust_no"  , WUtil.toDefault(key.get("CUST_NO" ))); // 고객번호(PK)
                startActivity(sIntent);
			}
		} );
        
		new Thread(new Runnable() {
			public void run() {
				try {
					Thread.sleep(100);
				} catch (InterruptedException e) {
					e.printStackTrace();
				}					
				sendMessage(Constant.PROC_ID_SELECT_SQLITE, "1", true, "USER_DATA");
			}
		}).start();        
	}


	private void setHouseGroupNm(String gb) {
		mTvHouseGroupNm.setText(DUtil.getHouseGroupNmByBldgCd(this.getApplicationContext(),bldg_cd,gb));
	}

	@Override
	public void onClick(View v) {
		int viewID = v.getId();
		if ( viewID == R.id.ib_search_gb ) { // 도로명 / 지번 버튼 토글.
			String gb= WUtil.toDefault((String) mBtnSearchGb.getTag());
			if ( gb.equals(Constant.CODE_GUBUN_ADDRESS) ) {
				mBtnSearchGb.setImageDrawable(getResources().getDrawable(R.drawable.street_img));
				mBtnSearchGb.setTag(Constant.CODE_GUBUN_STREET);
				setHouseGroupNm(Constant.CODE_GUBUN_STREET);				
			} else {
				mBtnSearchGb.setImageDrawable(getResources().getDrawable(R.drawable.address_img));
				mBtnSearchGb.setTag(Constant.CODE_GUBUN_ADDRESS);
				setHouseGroupNm(Constant.CODE_GUBUN_ADDRESS);				
			}
			
		} else if ( viewID == R.id.ib_batch_sign ) { // 일괄서명
			int notRegCount = DUtil.getChgInfoNotRegCountByBldgCd(this.getApplicationContext(),bldg_cd);
			if ( notRegCount > 0 ) { // 교제정보 미등록수
				alert(R.string.msg_not_register_chg_info); // 교체정보가 없는 세대가 있습니다. 교체정보를 먼저 등록하시기 바랍니다.
			} else {
				int sendedCount = DUtil.getChgInfoSendYCountByBldgCd(this.getApplicationContext(),bldg_cd);
				if ( sendedCount > 0 ) { // 송신한 자료 존재시 일괄서명 화면 접근 불가.
					alert(R.string.msg_not_signable_send_exist); // 송신완료된 자료가 있어 일괄 서명이 불가능합니다.
				} else {
					Intent sIntent = new Intent(this,BatchSignActivity.class); // 일괄서명
					sIntent.putExtra("bldg_cd", bldg_cd);
					startActivity(sIntent);
				}
				
			}
		}
	}

	
	@Override
	public boolean onLongClick(View v) {
		switch( v.getId() ) {
		// 
		case R.id.tv_house_group_nm:
			copyAddress();
			break;
		}
		return false;
	}	
	
	private void copyAddress() {
		
		ClipboardManager clipboard = (ClipboardManager) getSystemService(Context.CLIPBOARD_SERVICE);
		ClipData clip = ClipData.newPlainText("label",mTvHouseGroupNm.getText().toString());
		clipboard.setPrimaryClip(clip);
//		Toast.makeText(HouseListActivity.this.getApplicationContext(), mTvHouseGroupNm.getText().toString() + " " + getResources().getString(R.string.msg_address_copy_end), Toast.LENGTH_SHORT).show();
		Toast.makeText(this, "주소를 클립보드에 복사하였습니다.", Toast.LENGTH_SHORT).show();
		goMap(mTvHouseGroupNm.getText().toString());
		
//		new AlertDialog.Builder(this)
//		.setMessage("지도를 검색하시겠습니까?")
//		.setPositiveButton("예", new DialogInterface.OnClickListener() {
//			public void onClick(DialogInterface dialog, int whichButton) {
//				new Thread(new Runnable() {
//					public void run() {
//						goMap( _ADDRESS);
//					}
//				}).start();
//			}
//		})
//		.setNegativeButton("아니요", new DialogInterface.OnClickListener() {
//			public void onClick(DialogInterface dialog, int whichButton) {
//
//			}
//		})
//		.create()
//		.show();
	}
	
	@Override
	public void onBackPressed() {
		finish();		
//		confirm(R.string.msg_finish_confirm
//				, new DialogInterface.OnClickListener() {
//					public void onClick(DialogInterface dialog, int whichButton) {
//                    	finish();
//					}
//				}
//				, new DialogInterface.OnClickListener() {
//					public void onClick(DialogInterface dialog, int whichButton) {
////						alert("취소");						
//					}
//				}
//		);
	}
	
	/**
	 * Top상단 백 버튼 클릭
	 * @param v
	 */
    @Override
    public void onClickBackButton(View v) {
    	onBackPressed();
    }
    
	/**
	 * Top상단 첫번째 버튼 클릭
	 */
    @Override
    public void onClickOneButton(View v) {
    	String barCodeType = ((WApplication)mApp).getBarCodeType();
    	if ( Constant.CODE_BARCODE_SELF.equals(barCodeType) ) {
    		launchScanner(v);
    	} else {
    		try {
    			//바코드 블루투스 리더기 연동 
    			bi300 = new BI300Bluetooth(this,  new Handler() {
    				@Override
    				public void handleMessage(android.os.Message msg) {
    					String message = (String) msg.obj;
    					switch (msg.what) {
    					case 1:
    	                    String bfGmNo = WUtil.toDefault(message).trim();
    	                    WUtil.goMterChg(HouseListActivity.this, bfGmNo);
    						break;
    					}
    				};
    			});
    			bi300.startBI300();
			} catch (Exception e) {
//				alert("바코드스캐너 블루투스 연결하세요.");
			}
    	}    	
    }
    

    /**
     * Top상단 두번째 버튼 클릭
     */
    @Override
    public void onClickTwoButton(View v) {
       	showMenu(v, R.menu.main);     	
    }
    
	@Override
	public boolean onMenuItemClick(MenuItem item) {
		switch( item.getItemId() ) {
		case R.id.menu_action_1:
			if( isInstalledApplication("com.entropykorea.gas.main") ) {
				Intent intent = new Intent();
				intent.setClassName("com.entropykorea.gas.main", "com.entropykorea.gas.main.activity.AboutActivity");
				startActivity( intent );
			} else {
				alert( getString(R.string.app_name) + " ver. " + getString(R.string.app_version) );
			}
			
			break;
		}
		return false;
	}
	
	@Override
	protected void onActivityResult(int requestCode, int resultCode, Intent data) {
		if ( requestCode == Constant.ZBAR_SCANNER_REQUEST ) {
			if (resultCode == RESULT_OK) {
				String bfGmNo = WUtil.toDefault(data.getStringExtra(ZBarConstants.SCAN_RESULT));
				WUtil.goMterChg(HouseListActivity.this, bfGmNo);                
//	                Toast.makeText(this, "Scan Result = " + data.getStringExtra(ZBarConstants.SCAN_RESULT), Toast.LENGTH_SHORT).show();
			} else if(resultCode == RESULT_CANCELED && data != null) {
				String error = data.getStringExtra(ZBarConstants.ERROR_INFO);
				if(!TextUtils.isEmpty(error)) {
					Toast.makeText(this, error, Toast.LENGTH_SHORT).show();
				}
			}
		} else if ( requestCode == Constant.ZBAR_QR_SCANNER_REQUEST ) {			
	    }
	}

    @Override
    protected void onPause() {
    	super.onPause();
    	if ( bi300 != null ) {
    		bi300.stopBI300();
    	}
    }
    
	@Override
    protected void onResume() {
        super.onResume();
        if ( loaded ) { 
        	runOnUiThread(new Runnable() {
        		public void run() {
        			startProgressBar();
        			list();
        		}
        	});
        }
    }
}
