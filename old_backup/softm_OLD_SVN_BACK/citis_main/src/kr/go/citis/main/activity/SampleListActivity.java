package kr.go.citis.main.activity;

import kr.go.citis.lib.BaseActivity;
import kr.go.citis.lib.Constant;
import kr.go.citis.lib.ListViewMP;
import kr.go.citis.lib.SpinnerCd;
import kr.go.citis.lib.TitleView;
import kr.go.citis.lib.TitleView.OnTopClickListner;
import kr.go.citis.lib.Util;
import kr.go.citis.lib.common.AsyncHttp;
import kr.go.citis.lib.common.AsyncHttpParam;
import kr.go.citis.main.R;
import kr.go.citis.main.WApplication;
import kr.go.citis.main.adapter.SampleListDTOAdapter;
import kr.go.citis.main.dto.out.SampleListDTOOut;

import org.json.JSONArray;
import org.json.JSONException;

import android.annotation.SuppressLint;
import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.view.KeyEvent;
import android.view.MenuItem;
import android.view.MotionEvent;
import android.view.View;
import android.view.inputmethod.EditorInfo;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.AdapterView.OnItemSelectedListener;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.PopupMenu.OnMenuItemClickListener;
import android.widget.TextView;
import butterknife.Bind;
import butterknife.ButterKnife;
import butterknife.OnClick;
import butterknife.OnEditorAction;

/**
 * @author softm
 * SampleListActivity
 * 샘플목록
 */
@SuppressLint({ "HandlerLeak", "ClickableViewAccessibility" })
public class SampleListActivity extends BaseActivity implements OnTopClickListner, OnMenuItemClickListener  {
	public static final String TAG = Constant.LOG_TAG;
	
	@Bind(R.id.b_search)	
	ImageButton mBtnSearch;
	@Bind(R.id.spn_cd)	
	SpinnerCd spnCd;
	
	@Bind(R.id.listView1)
	ListViewMP lv1;
	
//    Sqlite mSqlite = null;
	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_sample_list);		
		ButterKnife.bind(this);
		init();
//		list(); // 제거 이유 spinnerint시 list함수 호출됨.
	}
	
	private void init() {
		TitleView tv = new TitleView(this, R.string.title_sample_list,true,true);
		tv.setOnTopClickListner(this);
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
	
	@OnClick({R.id.b_search})
	public void onClick(View v) {
		int viewID = v.getId();
//		if ( viewID == R.id.ib_search_gb ) {
//			String gb= WUtil.toDefault((String) mBtnSearchGb.getTag());
//			if ( gb.equals(Constant.CODE_GUBUN_ADDRESS) ) {
//				mBtnSearchGb.setImageDrawable(getResources().getDrawable(R.drawable.street_img));
//				mBtnSearchGb.setTag(Constant.CODE_GUBUN_STREET);
//			} else {
//				mBtnSearchGb.setImageDrawable(getResources().getDrawable(R.drawable.address_img));
//				mBtnSearchGb.setTag(Constant.CODE_GUBUN_ADDRESS);				
//			}
//	
//			runOnUiThread(new Runnable() {
//			    public void run() {
//					startProgressBar();
//					list();
//			    }
//			});
//    		
//		} else
			if ( viewID == R.id.b_search ) {
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
		new AsyncHttp<SampleListDTOOut,SampleListDTOOut>(this) {
			@Override
			public void complete(SampleListDTOOut result) {
					Util.i("return str : " + result);		
//					JSONObject result;
//					JSONArray  data;
					try {
						lv1.setAdapter(new SampleListDTOAdapter(SampleListActivity.this, getLayoutInflater(),result.getData()));
//						EditText etSearch = (EditText)findViewById(R.id.et_search);
//						String gb= WUtil.toDefault((String) mBtnSearchGb.getTag());
//						String completeYN = WUtil.toDefault(spnCd.getValue());
				        lv1.setOnItemClickListener( new OnItemClickListener() {
							@Override
							public void onItemClick(AdapterView<?> parent, View view,
									int position, long id) {
								String key = (String) view.getTag();
								if ( key != null ) {
//					                Intent sIntent = new Intent(SampleListActivity.this,HouseListActivity.class); // 수용가목록
//					                sIntent.putExtra("bldg_cd", key);
//					                startActivity(sIntent);
								}
							}
						} );
				        
				        SampleListActivity.this.stopProgressBar();				

					} catch (Exception e) {
						e.printStackTrace();
//				    	LoginDTO dto = new LoginDTO("","");
//	                           dto.setMsg(e.toString());
//				    	cb.error("실패",dto);
					}
				}

			@Override
			public void callback(SampleListDTOOut result) {
				
			}
	
//		}.execute("http://118.220.189.89:8011/citis/mobile/data/UserData.jsp");
//		}.execute(Constant.SERVER_CHECK_URL + "UserData.jsp");
	    }.execute(new AsyncHttpParam(Constant.SERVER_CHECK_URL + "/list"));
	}

	@Override
	protected void onActivityResult(int requestCode, int resultCode, Intent data) {
//		if ( requestCode == Constant.ZBAR_SCANNER_REQUEST ) {
//			if (resultCode == RESULT_OK) {
//				String bfGmNo = WUtil.toDefault(data.getStringExtra(ZBarConstants.SCAN_RESULT));
//				WUtil.goMterChg(BldgListActivity.this, bfGmNo);
////	                Toast.makeText(this, "Scan Result = " + data.getStringExtra(ZBarConstants.SCAN_RESULT), Toast.LENGTH_SHORT).show();
//			} else if(resultCode == RESULT_CANCELED && data != null) {
//				String error = data.getStringExtra(ZBarConstants.ERROR_INFO);
//				if(!TextUtils.isEmpty(error)) {
//					Toast.makeText(this, error, Toast.LENGTH_SHORT).show();
//				}
//			}
//		} else if ( requestCode == Constant.ZBAR_QR_SCANNER_REQUEST ) {			
//
//	    }
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
    public void onClickMainButton(View v) {
    	onBackPressed();
    }
    
	/**
	 * Top상단 첫번째 버튼 클릭
	 */
    @Override
    public void onClickOneButton(View v) {
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
    
	@OnEditorAction({R.id.et_search})
	public boolean onEditorAction(TextView v, int actionId, KeyEvent event) {
		if (actionId == EditorInfo.IME_ACTION_DONE ) {
			findViewById(R.id.b_search).performClick();
		}
		return false;
	}
    
    @Override
    protected void onPause() {
    	super.onPause();
//    	AppContext.putValue("et_search", getValue(R.id.et_search));
    }
 
	@Override
	protected void onResume() {
		super.onResume();
//    	setText(R.id.et_search,AppContext.getValue("et_search").toString());    	
	}
}
