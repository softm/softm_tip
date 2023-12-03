package com.entropykorea.gas.chk.activity;

import org.apache.commons.lang3.StringUtils;

import android.app.Activity;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.view.MenuItem;
import android.view.MotionEvent;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.PopupMenu.OnMenuItemClickListener;
import android.widget.Toast;

import com.entropykorea.gas.chk.R;
import com.entropykorea.gas.chk.WApplication;
import com.entropykorea.gas.chk.common.DUtil;
import com.entropykorea.gas.chk.common.WConstant;
import com.entropykorea.gas.chk.common.WUtil;
import com.entropykorea.gas.chk.dto.ChkDTO;
import com.entropykorea.gas.lib.BaseActivity;
import com.entropykorea.gas.lib.Constant;
import com.entropykorea.gas.lib.SimpleGestureFilter;
import com.entropykorea.gas.lib.SimpleGestureFilter.SimpleGestureListener;
import com.entropykorea.gas.lib.TitleView;
import com.entropykorea.gas.lib.TitleView.OnTopClickListner;
import com.mypidion.BI300.BI300Bluetooth;

/**
 * @author softm
 * BatchReadmeterActivit
 * 일괄검침
 */
public class BatchReadmeterActivit extends BaseActivity implements OnClickListener, OnTopClickListner, OnMenuItemClickListener , SimpleGestureListener{
    public static final String TAG = "MPGAS";
    private TitleView tv = null;
    private ChkDTO vCurr = new ChkDTO(); // 현재값
    private ChkDTO vPrev = new ChkDTO(); // 이전값
    private ChkDTO vNext = new ChkDTO(); // 다음값

    private BI300Bluetooth bi300 = null;
	private String bldg_cd;
	private String checkup_ym;
	private String checkup_cd;
	private String house_no;
	private String fake_house_no;
	private String action;
    private int pos;
    private int currPos = 0;
    
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        Intent intent = getIntent();
        bldg_cd = WUtil.toDefault(intent.getStringExtra("bldg_cd"));
        checkup_ym        = WUtil.toDefault(intent.getStringExtra("checkup_ym"));
        checkup_cd        = WUtil.toDefault(intent.getStringExtra("checkup_cd"));
        house_no      = WUtil.toDefault(intent.getStringExtra("house_no"));
        fake_house_no = WUtil.toDefault(intent.getStringExtra("fake_house_no"));
        action = WUtil.toDefault(intent.getStringExtra("action"));
        if ( action.equals("prev") ) {
        	pos = intent.getIntExtra("pos",0);
        	currPos = pos -1;
        } else if ( action.equals("next") ) {
        	pos = intent.getIntExtra("pos",0);
        	currPos = pos +1;
        }
        if ( !"".equals(checkup_ym) && !"".equals(checkup_cd)  && !"".equals(house_no) ) {
    		setContentView(R.layout.activity_batch_readmeter);	
            init();
        } else if ( !"".equals(bldg_cd) ) {
    		setContentView(R.layout.activity_batch_readmeter);	
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
    private void init() {
        tv = new TitleView(this, R.string.title_batch_readmeter,true);
        tv.setOnTopClickListner(this);
        findViewById(R.id.ib_prev).setOnClickListener(this);
        findViewById(R.id.ib_next).setOnClickListener(this);
        findViewById(R.id.ib_save).setOnClickListener(this);
        		
    	// swipe
		setOnSwipe(this, new OnSwipeListner() {
			@Override
			public void onSwipe(int direction) {
				//ScrollView scrollview = (ScrollView) findViewById( R.id.scrollview );
				switch( direction ) {
				case BatchReadmeterActivit.SWIPE_DOWN:
//					if( mScrollview.getScrollY() == 0 ) { 
//						moveCheckUp();
//					}
					break;
				case BatchReadmeterActivit.SWIPE_UP:
					//View view = (View) findViewById( R.id.scrollviewchild );
					//int diff = (view.getBottom()-(scrollview.getHeight()+scrollview.getScrollY()+view.getTop()));// Calculate the scrolldiff
					//if( diff == 0 ){ 
					//	
					//	runActivity(CustomerActivity.class);
					//}
					break;
				case BatchReadmeterActivit.SWIPE_RIGHT :
					getView(R.id.ib_prev).performClick();					
//					Toast.makeText( mApp, "right",Toast.LENGTH_SHORT).show();					
					break;
				case BatchReadmeterActivit.SWIPE_LEFT :
					getView(R.id.ib_next).performClick();
//					Toast.makeText( mApp, "left",Toast.LENGTH_SHORT).show();					
					break;
				}
			}

			@Override
			public void onDoubleTap() {
				//isClaimCust( true );
			}
		});        
    }

    private void retrive() {
//		--select * from jum WHERE IFNULL(FAKE_HOUSE_NO,'') = '';
        if ( !"".equals(checkup_ym) && !"".equals(checkup_cd)  && !"".equals(house_no) ) {
        	vCurr = DUtil.getDataByWhere(getApplicationContext()," WHERE CHECKUP_YM = '" + checkup_ym + "'"
        			+ " AND CHECKUP_CD   = '" + checkup_cd + "'"
        			+ " AND HOUSE_NO = '" + house_no + "'"
        			+ " AND IFNULL(FAKE_HOUSE_NO,'') = '" + fake_house_no + "'"
        			+ " LIMIT 1");
        } else {
        	vCurr = DUtil.getDataByWhere(getApplicationContext()," WHERE BLDG_CD = '" + bldg_cd + "' ORDER BY HOUSE_ORD LIMIT 1");
        	currPos = 1;
        }
        
        checkup_ym        = WUtil.toDefault( vCurr.getCheckupYm());
        checkup_cd        = WUtil.toDefault( vCurr.getCheckupCd());
        house_no      = WUtil.toDefault( vCurr.getHouseNo());
        fake_house_no = WUtil.toDefault( vCurr.getFakeHouseNo());
        bldg_cd       = WUtil.toDefault( vCurr.getBldgCd());

        setText(R.id.tv_info,DUtil.getHouseGroupNmByBldgCd(getApplicationContext(),bldg_cd,Constant.CODE_GUBUN_ADDRESS));
		int cnt = DUtil.getDataCountByWhere(getApplicationContext()," WHERE BLDG_CD = '" + bldg_cd + "'");
		
		tv.setTitle(getResources().getString(R.string.title_batch_readmeter) + " ( " + currPos + " / " + cnt + " )");
		
		vPrev = DUtil.getDataByWhere(getApplicationContext(),
										  " WHERE BLDG_CD = '" + bldg_cd + "' "
//										+ "   AND AREA_CD < ("
										+ "   AND HOUSE_ORD < ("
//										+ "                     SELECT AREA_CD FROM " + WConstant.TBL_JUM
										+ "                     SELECT HOUSE_ORD FROM " + WConstant.TBL_JUM
										+ "                      WHERE BLDG_CD  = '" + bldg_cd + "'" 
										+ "                        AND HOUSE_NO = '" + vCurr.getHouseNo() + "'"
										+ "                    ) ORDER BY HOUSE_ORD DESC "
										+ " LIMIT 1"
				);
//		String sql = "SELECT HOUSE_NO,BLDG_CD FROM GUM "
//				+ "WHERE HOUSE_ORD > (SELECT HOUSE_ORD FROM GUM WHERE HOUSE_NO = '"
//				+ HOUSE_NO + "') ORDER BY HOUSE_ORD LIMIT 1"; 
		vNext= DUtil.getDataByWhere(getApplicationContext(),
				" WHERE BLDG_CD = '" + bldg_cd + "' "
//						+ "   AND AREA_CD > ("
						+ "   AND HOUSE_ORD > ("
//						+ "                     SELECT AREA_CD FROM " + WConstant.TBL_JUM
						+ "                     SELECT HOUSE_ORD FROM " + WConstant.TBL_JUM
						+ "                      WHERE BLDG_CD  = '" + bldg_cd + "'" 
						+ "                        AND HOUSE_NO = '" + vCurr.getHouseNo() + "'"
						+ "                    ) ORDER BY HOUSE_ORD "
						+ " LIMIT 1"
				);
//		Toast.makeText( mApp, vPrev.getHouseNo() + " / " + vCurr.getHouseNo() + " / " + vNext.getHouseNo(),Toast.LENGTH_LONG).show();
		
        setText(R.id.tv_house_no         , vCurr.getHouseNo()); // 수용가번호
        setText(R.id.tv_house_status_nm  , DUtil.getCodeNm(this.getApplicationContext(),"MA090", vCurr.getStatusCd() )); // 수용가상태
        setText(R.id.tv_install_loc_gb_cd, DUtil.getCodeNm(this.getApplicationContext(),"GM060", vCurr.getInstallLocCd())); // 설치장소
        setText(R.id.tv_purpose_cd       , DUtil.getCodeNm(this.getApplicationContext(),"MA040", vCurr.getPurposeCd()     )); // 용도코드
        setText(R.id.tv_gm_no            , vCurr.getGmNo());   
        setText(R.id.tv_bf_meter         , vCurr.getBfMeter());   
        setText(R.id.et_checkup_meter    , vCurr.getCheckupMeter());   
		if ( StringUtils.isEmpty(vPrev.getHouseNo() )) {
			setVisibility(R.id.ib_prev,View.INVISIBLE);
		}
		if ( StringUtils.isEmpty(vNext.getHouseNo() )) {
			setVisibility(R.id.ib_next,View.INVISIBLE);
		}
		if ( Constant.CODE_SEND_Y.equals(vCurr.getSendYn()) ) {
			setVisibility(R.id.ib_save,View.INVISIBLE);
		} else {
	        setFocus(R.id.et_checkup_meter);
		}
    }
    
    /**
     * 고객정보 저장
     */
    private void fSave() {
	    String checkupMeter = WUtil.toDefault(getValue(R.id.et_checkup_meter).toString()).trim();
    	boolean exec = true;

	    if ( StringUtils.isEmpty(vCurr.getFakeHouseNo()) ) {
		    if ( !StringUtils.isNumeric(checkupMeter) ) {
//	        	alert(R.string.msg_do_check_checkup_memter
//		  	              , new DialogInterface.OnClickListener() {
//		        			    public void onClick(DialogInterface dialog, int whichButton) {
//		        			    	setFocus(R.id.et_checkup_meter);        	
//		        			    }}); // 당월 점검지침을 확인하세요.
		    	exec = false;
		    	setError(R.id.et_checkup_meter,R.string.msg_do_check_checkup_memter);
		    } else if ( StringUtils.isEmpty(checkupMeter) ) {
//	        	alert(R.string.msg_do_check_checkup_memter
//	  	              , new DialogInterface.OnClickListener() {
//	        			    public void onClick(DialogInterface dialog, int whichButton) {
//	        			    	setFocus(R.id.et_checkup_meter);        	
//	        			    }}); // 당월 점검지침을 확인하세요.
		    	exec = false;
		    	setError(R.id.et_checkup_meter,R.string.msg_do_check_checkup_memter);
		    } else {
		    	setError(R.id.et_checkup_meter,null);
		    }
	    }
    	if ( exec ) {
			confirm(R.string.msg_save_confirm, // 저장하시겠습니까?
				new DialogInterface.OnClickListener() {
					public void onClick(DialogInterface dialog, int whichButton) {
						db.execSQL("UPDATE " + WConstant.TBL_JUM
								+ " SET CHECKUP_METER  = '" + getValue(R.id.et_checkup_meter)    + "'"
			        		    + " WHERE CHECKUP_YM = '" + vCurr.getCheckupYm()  + "'"
			        			+ " AND CHECKUP_CD   = '" + vCurr.getCheckupCd()  + "'"
			        			+ " AND HOUSE_NO = '" + vCurr.getHouseNo()  + "'"
			        			+ " AND IFNULL(FAKE_HOUSE_NO,'') = '" + vCurr.getFakeHouseNo()  + "'"
						);
						getView(R.id.ib_next).performClick();
						retrive();
						toast(R.string.msg_saved);
				}
				}, new DialogInterface.OnClickListener() {
					public void onClick(DialogInterface dialog, int whichButton) {
						// alert("취소");
					}
				});
    	}
	}

	@Override
	public void onClick(View v) {
	    int viewID = v.getId();
        findViewById(R.id.ib_prev).setOnClickListener(this);
        findViewById(R.id.ib_next).setOnClickListener(this);
        findViewById(R.id.ib_save).setOnClickListener(this);
        
	    if ( viewID == R.id.ib_prev ) { // 이전
			if ( !StringUtils.isEmpty(vPrev.getHouseNo() )) {
				Intent sIntent = new Intent(BatchReadmeterActivit.this,BatchReadmeterActivit.class); // 일괄검침.
	//			sIntent.putExtra("bldg_cd"       , vPrev.getBldgCd());
				sIntent.putExtra("checkup_ym"        , vPrev.getCheckupYm());
				sIntent.putExtra("checkup_cd"        , vPrev.getCheckupCd());
				sIntent.putExtra("house_no"      , vPrev.getHouseNo());
				sIntent.putExtra("fake_house_no" , vPrev.getFakeHouseNo());
				sIntent.putExtra("pos"           , currPos);				
				sIntent.putExtra("action"        , "prev");				
				startActivity(sIntent);
				overridePendingTransition(  R.anim.slide_left_in, R.anim.slide_left_out );			
				finish();
			} else {
				Toast.makeText(this, "처음 입니다.", Toast.LENGTH_SHORT).show();
			}
	    } else if ( viewID == R.id.ib_next ) { // 다음
			if ( !StringUtils.isEmpty(vNext.getHouseNo() )) {
				Intent sIntent = new Intent(BatchReadmeterActivit.this,BatchReadmeterActivit.class); // 일괄검침.
	//			sIntent.putExtra("bldg_cd"       , vNext.getBldgCd());
				sIntent.putExtra("checkup_ym"        , vNext.getCheckupYm());
				sIntent.putExtra("checkup_cd"        , vNext.getCheckupCd());
				sIntent.putExtra("house_no"      , vNext.getHouseNo());
				sIntent.putExtra("fake_house_no" , vNext.getFakeHouseNo());
				sIntent.putExtra("pos"           , currPos);				
				sIntent.putExtra("action"        , "next");				
				startActivity(sIntent);
				overridePendingTransition(  R.anim.slide_right_out, R.anim.slide_right_in );
				finish();
			} else {
				Toast.makeText(this, "마지막 입니다.", Toast.LENGTH_SHORT).show();
			}
	    } else if ( viewID == R.id.ib_save ) { // 저장
	    	fSave();
	    }
	}

	@Override
    public void onBackPressed() {
        finish();
//      confirm(R.string.msg_finish_confirm
//              , new DialogInterface.OnClickListener() {
//                  public void onClick(DialogInterface dialog, int whichButton) {
//                      finish();
//                  }
//              }
//              , new DialogInterface.OnClickListener() {
//                  public void onClick(DialogInterface dialog, int whichButton) {
////                        alert("취소");
//                  }
//              }
//      );
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
//    	                    WUtil.goMterChg(BatchReadmeterActivit.this, bfGmNo);
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
				try {
					Intent intent = new Intent();
					intent.setClassName("com.entropykorea.gas.main", "com.entropykorea.gas.main.activity.AboutActivity");
					startActivity( intent );
				} catch (Exception e) {
					e.printStackTrace();
				}
			} else {
				alert( getString(R.string.app_name) + " ver. " + getString(R.string.app_version) );
			}
			
			break;
		case R.id.menu_action_2:
			if( isInstalledApplication("com.entropykorea.gas.main") ) {
				try {
					Intent intent = new Intent();
					intent.setClassName("com.entropykorea.gas.main", "com.entropykorea.gas.main.activity.SettingActivity");
					startActivityForResult(intent, 100);
				} catch (Exception e) {
					e.printStackTrace();
				}
			} else {
				//alert( "메인화면에서 지원하지 않습니다." );
			}
			
			break;
		}
		return false;
	}

	@Override
	protected void onActivityResult(int requestCode, int resultCode, Intent data) {
//	    if ( requestCode == Constant.ZBAR_SCANNER_REQUEST ) {
//	    	if (resultCode == RESULT_OK) {
//	    		String bfGmNo = WUtil.toDefault(data.getStringExtra(ZBarConstants.SCAN_RESULT));
//	    		WUtil.goMterChg(BatchReadmeterActivit.this, bfGmNo);
////	    		Toast.makeText(this, "Scan Result = " + data.getStringExtra(ZBarConstants.SCAN_RESULT), Toast.LENGTH_SHORT).show();
//	    	} else if(resultCode == RESULT_CANCELED && data != null) {
//	    		String error = data.getStringExtra(ZBarConstants.ERROR_INFO);
//	    		if(!TextUtils.isEmpty(error)) {
//	    			Toast.makeText(this, error, Toast.LENGTH_SHORT).show();
//	    		}
//	    	}
//	    } else if ( requestCode == Constant.ZBAR_QR_SCANNER_REQUEST ) {
//	    } else if ( requestCode == ConstantW.ZBAR_SCANNER_REQUEST2 ) {
//	    	if ( data != null ) {
//	    		String bfGmNo = WUtil.toDefault(data.getStringExtra(ZBarConstants.SCAN_RESULT));	    	
//	    		String houseNo = DUtil.getHouseNoByBfGmNo(this.getApplicationContext(),bfGmNo);
//	    		if ( "".equals(houseNo)) {
//	    			alert(R.string.msg_invalid_house,new DialogInterface.OnClickListener() {
//	    				public void onClick( DialogInterface dialog, int whichButton) {
//	    					Intent sIntent = new Intent(BatchReadmeterActivit.this,MeterChgActivity.class); // 계량기교체
//	    					sIntent.putExtra("checkup_ym"  , checkup_ym);
//	    					sIntent.putExtra("house_no", house_no);
//	    					sIntent.putExtra("cust_no" , cust_no);
//	    					startActivity(sIntent);
//	    				}
//	    			}); // 인식된 세대가 없습니다.\n확인 바랍니다.
//	    		} else {
//	    			if ( houseNo.equals(house_no) ) { // 바코드 인식수용가번호와 현재 수용가 번호가 동일하면. 
//	    				Intent sIntent = new Intent(BatchReadmeterActivit.this,MeterChgActivity.class); // 계량기교체
//	    				sIntent.putExtra("bf_gm_no"  , bfGmNo);
//	    				startActivity(sIntent);
//	    			} else {
//	    				confirm(R.string.msg_meter_code_not_corrent_confirm, // 계량기 번호가 맞지 않습니다. 교체를 시작하시겠습니까?
//	    						new DialogInterface.OnClickListener() {
//	    					public void onClick(DialogInterface dialog,int whichButton) {
//	    						Intent sIntent = new Intent(BatchReadmeterActivit.this,MeterChgActivity.class); // 계량기교체
//	    						sIntent.putExtra("checkup_ym"  , checkup_ym);
//	    						sIntent.putExtra("house_no", house_no);
//	    						sIntent.putExtra("cust_no" , cust_no);
//	    						startActivity(sIntent);
//	    					}
//	    				}, new DialogInterface.OnClickListener() {
//	    					public void onClick( DialogInterface dialog, int whichButton) {
//	    					}
//	    				});
//	    			}
//	    		}
//	    	}
//	    }
	}

	@Override
	protected void onResume() {
		super.onResume();
		retrive();
	}
	
    @Override
    protected void onPause() {
    	super.onPause();
    	if ( bi300 != null ) {
    		bi300.stopBI300();
    	}
    }
    
	
	public final static int SWIPE_UP    = 1;
	public final static int SWIPE_DOWN  = 2;
	public final static int SWIPE_LEFT  = 3;
	public final static int SWIPE_RIGHT = 4;
	
	private SimpleGestureFilter detector = null; // for swipe
	private OnSwipeListner listner = null;
	
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
		if( listner != null ) { 
			listner.onDoubleTap();
		}
	}
}
