package com.entropykorea.gas.chg.activity;

import org.json.JSONArray;
import org.json.JSONException;

import android.annotation.SuppressLint;
import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.text.TextUtils;
import android.view.KeyEvent;
import android.view.MenuItem;
import android.view.MotionEvent;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.inputmethod.EditorInfo;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.AdapterView.OnItemSelectedListener;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.PopupMenu.OnMenuItemClickListener;
import android.widget.TextView;
import android.widget.TextView.OnEditorActionListener;
import android.widget.Toast;

import com.dm.zbar.android.scanner.ZBarConstants;
import com.entropykorea.ewire.database.Sqlite;
import com.entropykorea.gas.chg.R;
import com.entropykorea.gas.chg.WApplication;
import com.entropykorea.gas.chg.adapter.BldgListAdapter;
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
 * BldgListActivity
 * 건물목록
 */
@SuppressLint({ "HandlerLeak", "ClickableViewAccessibility" })
public class BldgListActivity extends BaseActivity implements OnClickListener, OnTopClickListner, OnMenuItemClickListener,OnEditorActionListener  {
	public static final String TAG = "MPGAS";
	private ImageButton mBtnSearchGb;
	private ImageButton mBtnSearch;
	private SpinnerCd spnCd;
    private BI300Bluetooth bi300 = null;
    Sqlite mSqlite = null;
	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_bldg_list);		
		init();
//		list(); // 제거 이유 spinnerint시 list함수 호출됨.
	}
	
	private void init() {
		TitleView tv = new TitleView(this, R.string.title_building_list,true);
		tv.setOnTopClickListner(this);
		spnCd = (SpinnerCd)findViewById(R.id.spn_cd);
		mBtnSearchGb = (ImageButton) findViewById(R.id.ib_search_gb);
		mBtnSearchGb.setOnClickListener(this);
		mBtnSearchGb.setTag(Constant.CODE_GUBUN_STREET); // 도로명
		
		mBtnSearch = (ImageButton) findViewById(R.id.ib_search);
		mBtnSearch.setOnClickListener(this);
		
		((EditText)findViewById(R.id.et_search)).setOnEditorActionListener(this);
		((EditText)findViewById(R.id.et_search)).setImeOptions(EditorInfo.IME_ACTION_DONE);

// 소트웨어 키보드 제어 참고
// http://stackoverflow.com/questions/1109022/close-hide-the-android-soft-keyboard
//		final EditText etSearch = (EditText)findViewById(R.id.et_search);
//		getWindow().setSoftInputMode(
//				WindowManager.LayoutParams.SOFT_INPUT_STATE_ALWAYS_HIDDEN
//		);

//		InputMethodManager imm = (InputMethodManager) getSystemService(Context.INPUT_METHOD_SERVICE);
//		imm.hideSoftInputFromWindow(etSearch.getWindowToken(), 0);
//		etSearch.requestFocus();
//		etSearch.postDelayed(new Runnable() {
//            @Override
//            public void run() {
//                InputMethodManager keyboard = (InputMethodManager)
//                getSystemService(Context.INPUT_METHOD_SERVICE);
//                keyboard.showSoftInput(etSearch, 0);
//            }
//		 }, 500);
//		SpinnerCd spnCd1 = (SpinnerCd)findViewById(R.id.spn_cd);
//		spnCd1.getCode("BC111");
		try {
			spnCd.getCode(new JSONArray(Constant.CODE_JSON_COM01),R.string.label_all);
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
					    }
					});
				}
				public void onNothingSelected(AdapterView<?>  parent) {
//					if ( "".equals(spnCd.getValue()) ) {
//						spnCd.setValue(ConstantChg.CODE_END_Y);
//					}					
				}
			});
		} catch (JSONException e) {
			e.printStackTrace();
		}
	}
	
	@Override
	public void onClick(View v) {
		int viewID = v.getId();
		if ( viewID == R.id.ib_search_gb ) {
			String gb= WUtil.toDefault((String) mBtnSearchGb.getTag());
			if ( gb.equals(Constant.CODE_GUBUN_ADDRESS) ) {
				mBtnSearchGb.setImageDrawable(getResources().getDrawable(R.drawable.street_img));
				mBtnSearchGb.setTag(Constant.CODE_GUBUN_STREET);
			} else {
				mBtnSearchGb.setImageDrawable(getResources().getDrawable(R.drawable.address_img));
				mBtnSearchGb.setTag(Constant.CODE_GUBUN_ADDRESS);				
			}
	
			runOnUiThread(new Runnable() {
			    public void run() {
					startProgressBar();
					list();
			    }
			});
    		
		} else if ( viewID == R.id.ib_search ) {
			runOnUiThread(new Runnable() {
			    public void run() {
					startProgressBar();
					list();
			    }
			});
		}
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
		EditText etSearch = (EditText)findViewById(R.id.et_search);
		String gb= WUtil.toDefault((String) mBtnSearchGb.getTag());
		String completeYN = WUtil.toDefault(spnCd.getValue());
		String sql = "SELECT "
        		+              " _rowid_ as _id, " 
        		+
        		(
        				gb.equals(Constant.CODE_GUBUN_ADDRESS)
        				? " CHG.SECTOR_NM || ' ' || CHG.BLDG_NO || ' ' || CHG.COMPLEX_NM || ' ' || CHG.BLDG_NM AS BLD_NM"  // 지번
     					: " CHG.ROAD_NM || ' ' || CHG.COMPLEX_NM || ' ' || CHG.BLDG_NM AS BLD_NM "  // 도로명
        		)
                + "  , COUNT(*) TOT_CNT"
                + "  , SUM(CASE WHEN END_YN='Y' then 1 ELSE 0 END) COMPLETE_CNT"
                + "  , CHG.BLDG_CD AS KEY "	                
                + "  FROM " + WConstant.TBL_CHG + " CHG "
                + (!"".equals(etSearch.getText().toString())
                		?" WHERE COMPLEX_NM LIKE '%" + etSearch.getText().toString() + "%'"
                		:""
                )
                +
        		(
        				gb.equals(Constant.CODE_GUBUN_ADDRESS) 
        				? " GROUP BY  BLDG_CD, SECTOR_NM, BLDG_NO, COMPLEX_NM, BLDG_NM " //--구역명 + 번지 + 단지명 + 건물명 
     					: " GROUP BY  BLDG_CD, ROAD_NM, COMPLEX_NM, BLDG_NM " // 도로명 + 단지명 + 건물명 
        		)
        		+
        		(
        		!"".equals(completeYN)? 
        		(
        				completeYN.equals(Constant.CODE_END_Y) 
        				? " HAVING COUNT(*) = SUM(CASE WHEN END_YN='Y' then 1 ELSE 0 END) " // 완료 
    	        		: " HAVING COUNT(*) <> SUM(CASE WHEN END_YN='Y' then 1 ELSE 0 END) " // 미완료 
        		):""
        		)
        		+ " ORDER BY MIN(HOUSE_ORD)"
        ;
		mSqlite = new Sqlite(db);
		mSqlite.rawQuery(sql);
        BldgListAdapter adapter = new BldgListAdapter(getApplicationContext(), mSqlite.getCursor(), 0);
        lv1.setAdapter(adapter);

        lv1.setOnItemClickListener( new OnItemClickListener() {
			@Override
			public void onItemClick(AdapterView<?> parent, View view,
					int position, long id) {
				String key = (String) view.getTag();
				if ( key != null ) {
	                Intent sIntent = new Intent(BldgListActivity.this,HouseListActivity.class); // 수용가목록
	                sIntent.putExtra("bldg_cd", key);
	                startActivity(sIntent);
				}
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

	@Override
	protected void onActivityResult(int requestCode, int resultCode, Intent data) {
		if ( requestCode == Constant.ZBAR_SCANNER_REQUEST ) {
			if (resultCode == RESULT_OK) {
				String bfGmNo = WUtil.toDefault(data.getStringExtra(ZBarConstants.SCAN_RESULT));
				WUtil.goMterChg(BldgListActivity.this, bfGmNo);
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
    	                    WUtil.goMterChg(BldgListActivity.this, bfGmNo);
    						break;
    					}
    				};
    			});
    			bi300.startBI300();
			} catch (Exception e) {
				//alert("바코드스캐너 블루투스 연결하세요.");
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
	public boolean onEditorAction(TextView v, int actionId, KeyEvent event) {
		if (actionId == EditorInfo.IME_ACTION_DONE ) {
			findViewById(R.id.ib_search).performClick();
		}
		return false;
	}
    
    @Override
    protected void onPause() {
    	super.onPause();
    	if ( bi300 != null ) {
    		bi300.stopBI300();
    	}
//    	AppContext.putValue("et_search", getValue(R.id.et_search));
    }
 
	@Override
	protected void onResume() {
		super.onResume();
//    	setText(R.id.et_search,AppContext.getValue("et_search").toString());    	
	}
}
