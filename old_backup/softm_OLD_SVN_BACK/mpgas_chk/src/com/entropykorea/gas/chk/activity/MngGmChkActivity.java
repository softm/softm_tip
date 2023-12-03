package com.entropykorea.gas.chk.activity;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

import org.apache.commons.lang3.StringUtils;

import android.annotation.SuppressLint;
import android.content.DialogInterface;
import android.content.Intent;
import android.database.Cursor;
import android.os.Bundle;
import android.os.Handler;
import android.text.TextUtils;
import android.view.KeyEvent;
import android.view.MenuItem;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.view.ViewGroup.LayoutParams;
import android.view.inputmethod.EditorInfo;
import android.widget.CheckBox;
import android.widget.CompoundButton;
import android.widget.CompoundButton.OnCheckedChangeListener;
import android.widget.EditText;
import android.widget.PopupMenu.OnMenuItemClickListener;
import android.widget.TextView;
import android.widget.TextView.OnEditorActionListener;
import android.widget.Toast;

import com.dm.zbar.android.scanner.ZBarConstants;
import com.entropykorea.gas.chk.R;
import com.entropykorea.gas.chk.WApplication;
import com.entropykorea.gas.chk.adapter.MngGmChkAdapter;
import com.entropykorea.gas.chk.common.DUtil;
import com.entropykorea.gas.chk.common.WConstant;
import com.entropykorea.gas.chk.common.WUtil;
import com.entropykorea.gas.chk.dto.ChkDTO;
import com.entropykorea.gas.lib.AppContext;
import com.entropykorea.gas.lib.BaseActivity;
import com.entropykorea.gas.lib.Constant;
import com.entropykorea.gas.lib.ListViewMP;
import com.entropykorea.gas.lib.PicCamera;
import com.entropykorea.gas.lib.SpinnerCd;
import com.entropykorea.gas.lib.TitleView;
import com.entropykorea.gas.lib.TitleView.OnTopClickListner;
import com.entropykorea.gas.lib.Util;
import com.entropykorea.gas.lib.activity.PicViewerActivity;
import com.mypidion.BI300.BI300Bluetooth;

/**
 * @author softm
 * MngGmChkActivity
 * 계량기점검
 */
@SuppressLint({ "ClickableViewAccessibility", "HandlerLeak" })
public class MngGmChkActivity extends BaseActivity implements OnClickListener, OnTopClickListner, OnCheckedChangeListener, OnMenuItemClickListener,OnEditorActionListener {
    public static final String TAG = "MPGAS";
    private TitleView tv = null;
    SpinnerCd spnCd = null;
    int visitCount = 0;    
    private ChkDTO v = new ChkDTO(); // 현재값
    
    private PicCamera pc = null;
    private BI300Bluetooth bi300 = null;
	private String bldg_cd;
	private String checkup_ym;
	private String checkup_cd;
	private String house_no;
	private String fake_house_no;
    Cursor c = null;
    
    final String FA_CD = WConstant.CODE_FA_CD_GM; // FA_CD
    
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        Intent intent = getIntent();
        bldg_cd       = WUtil.toDefault(intent.getStringExtra("bldg_cd"));
        
        checkup_ym        = WUtil.toDefault(intent.getStringExtra("checkup_ym"));
        checkup_cd        = WUtil.toDefault(intent.getStringExtra("checkup_cd"));
        house_no      = WUtil.toDefault(intent.getStringExtra("house_no"));
        fake_house_no = WUtil.toDefault(intent.getStringExtra("fake_house_no"));
        
        AppContext.remove("ADAPTER_SAVED");
        if ( !"".equals(checkup_ym) && !"".equals(checkup_cd) && !"".equals(house_no) ) {
            setContentView(R.layout.activity_mng_gm_chk);
            init();
            if ( "".equals(v.getCheckupIdx()) ) {
                alert(R.string.msg_dosenot_exist
                        , new DialogInterface.OnClickListener() {
                            public void onClick(DialogInterface dialog, int whichButton) {
                                finish();
                            }
                        }
                );
            }
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
        tv = new TitleView(this, R.string.title_mng_gm_chk,false);
        tv.setOnTopClickListner(this);
        findViewById(R.id.ib_camera   ).setOnClickListener(this); // 카메라
        findViewById(R.id.ib_photoview).setOnClickListener(this); // 뷰어
        findViewById(R.id.ib_close    ).setOnClickListener(this);
        findViewById(R.id.ib_save     ).setOnClickListener(this);
        findViewById(R.id.ib_b_barcode).setOnClickListener(this);
        ((CheckBox)findViewById(R.id.rd_none	  )).setOnCheckedChangeListener(this);
		setVisibility(R.id.ib_camera,View.GONE);
		((EditText)findViewById(R.id.et_checkup_meter)).setOnEditorActionListener(this);
		((EditText)findViewById(R.id.et_checkup_meter)).setImeOptions(EditorInfo.IME_ACTION_DONE);
				
		retrive();  
    }

    private void retrive() {
    	v = DUtil.getDataByWhere(getApplicationContext()," WHERE CHECKUP_YM = '" + checkup_ym + "'"
    			+ " AND CHECKUP_CD   = '" + checkup_cd + "'"
    			+ " AND HOUSE_NO = '" + house_no + "'"
    			+ " AND IFNULL(FAKE_HOUSE_NO,'') = '" + fake_house_no + "'"
    			+ " LIMIT 1");
        if ( "".equals(checkup_ym) || "".equals(checkup_cd) || "".equals(house_no) ) {            	
            alert(R.string.msg_not_exec_alert
	              , new DialogInterface.OnClickListener() {
	                  public void onClick(DialogInterface dialog, int whichButton) {
	                      finish();
	                  }
	              }
            );
        } else {
            checkup_ym        = WUtil.toDefault( v.getCheckupYm());
            checkup_cd        = WUtil.toDefault( v.getCheckupCd());
            house_no      = WUtil.toDefault( v.getHouseNo());
            fake_house_no = WUtil.toDefault( v.getFakeHouseNo());
            
        	pc = new PicCamera(this, Constant.PIC_DIR,PicCamera.MODE_PICTURE,checkup_ym + checkup_cd + house_no + fake_house_no
        			                                                        +"_NOCFM_"+FA_CD,".jpg");
        	pc.setSingleMode(Boolean.FALSE);
    		if ( pc.fileCount() > 0 ) {
    			setVisibility(R.id.ib_photoview,View.VISIBLE);
    		} else {
    			setVisibility(R.id.ib_photoview,View.GONE);
    		}
    		
    		if ( !"0".equals(v.getFakeHouseNo()) ) {
    			setVisibility(R.id.tr_1, View.GONE);
    			setVisibility(R.id.tr_2, View.GONE);
    		} else {
    			setVisibility(R.id.tr_1, View.VISIBLE);
    			setVisibility(R.id.tr_2, View.VISIBLE);
    		}
    		if ( Constant.CODE_SEND_Y.equals(v.getFakeHouseNo()) ) {
    			setVisibility(R.id.ib_save, View.INVISIBLE);
    		} else {
    			setVisibility(R.id.ib_save, View.VISIBLE);            	
    		}
    		
            setText(R.id.tv_gm_no         , v.getGmNo());
            setText(R.id.et_gm_no_cfm     , v.getGmNoCfm());
            setText(R.id.et_checkup_meter , v.getCheckupMeter());            
            setText(R.id.tv_info          , v.getSectorNm() + " " + v.getBldgNo() + " " + v.getComplexNm() + " " + v.getBldgNm() + " " + v.getRoomNo() + " " + (StringUtils.isNotEmpty(WUtil.toDefault(v.getFakeRoomNo()))?" " + v.getFakeRoomNo():""));
            
    		if ( WConstant.CODE_CHECK_OK_X.equals(fOkYn()) ) { // 기기없음
    			((CheckBox)findViewById(R.id.rd_none)).setChecked(Boolean.TRUE);
    		} else {
    			((CheckBox)findViewById(R.id.rd_none)).setChecked(Boolean.FALSE);
    		}
            String sql = "SELECT "
                    + "     MCD._rowid_ as _id "
                    + "   , JUM_NOCFM.FA_CD             AS JUM_FA_CD            "
                    + "   , JUM_NOCFM.CHECKUP_REMARK_CD AS JUM_CHECKUP_REMARK_CD"
                    + "   , SUBSTR(MCD.CD,1,2)          AS FA_CD            "
	                + "   , SUBSTR(MCD.CD,1,4)          AS CHECKUP_ITEM_CD  "
	                + "   , MCD.CD                      AS CHECKUP_REMARK_CD"
	                + "   , MCD.CD_NM                   AS CHECKUP_REMARK_NM"
                    + " FROM " + WConstant.TBL_CODE + " MCD"
                    + " LEFT JOIN " + WConstant.TBL_JUM_NOCFM + " "
                    + "    ON JUM_NOCFM.CHECKUP_REMARK_CD = MCD.CD"
                    + "   AND JUM_NOCFM.CHECKUP_IDX   = '" + v.getCheckupIdx() + "'"
                    + " WHERE MCD.TYPE_CD = 'FA030' "
                    + "   AND MCD.CD      LIKE '"+FA_CD+"%' "
//                    + " UNION "
//                    + " SELECT   "
//                    + " 1 as _id "
//                    + " , '01' AS FA_CD "
//                    + " , '010101' AS CHECKUP_REMARK_CD "
//                    + " , '가스차단기' AS FA_NM "
//                    + " , '가스검지기미설치' AS CHECKUP_REMARK_NM "
            ;
    		if ( c!= null ) c.close();
            c = db.rawQuery(sql, null);
    		ListViewMP lv1 = (ListViewMP)findViewById(R.id.listView1);            
    		MngGmChkAdapter adapter = new MngGmChkAdapter(this, c, 0);
//    		toast(c.getCount());
//    		Util.i("test",""+c.getCount());
//    		Util.i("test",sql);
    		int height = (getResources().getDimensionPixelSize(R.dimen.listHeight)+1)*c.getCount();
    		LayoutParams lp = lv1.getLayoutParams();
    		lp.height = height;
    		lv1.setLayoutParams(lp);
            lv1.setAdapter(adapter);
//            WUtil.setListViewHeightBasedOnChildren(lv1);
            lv1.requestChildFocus(null,findViewById(R.id.scrollView1));
//    		fChgBuSpan();
        }
    }
    /**
	 * 점검상태
	 */
	private String fOkYn() {
	    if (WConstant.CODE_FA_CD_BREAKER.equals(FA_CD)) {// 가스차단기
	    	return v.getBreakerOkYn();
	    } else if (WConstant.CODE_FA_CD_GM.equals(FA_CD)) {// 계량기
	    	return v.getGmOkYn();
	    } else if (WConstant.CODE_FA_CD_PIPE.equals(FA_CD)) {// 배관
	    	return v.getPipeOkYn();
	    } else if (WConstant.CODE_FA_CD_BOILER.equals(FA_CD)) {// 보일러
	    	return v.getBoilerOkYn();
	    } else if (WConstant.CODE_FA_CD_BURNER.equals(FA_CD)) {// 연소기
	    	return v.getBurnerOkYn();
	    }
	    return "";
	}
    /**
     * 부적합<>적합 변경시
     */
    public void fChgBuSpan() {
		ListViewMP lv = (ListViewMP) findViewById(R.id.listView1);
		int buCnt = 0;
		int yesCnt = 0;
		int cnt = lv.getCount();
		for( int i=0;i<cnt;i++) {
			ViewGroup v = (ViewGroup) lv.getChildAt(i);
			if ( v != null ) {			
			SpinnerCd spn = (SpinnerCd)v.findViewById(R.id.spn_v2);
				if ( spn.getSelected() == 0 ) { // 적합
					yesCnt++;
				} else { // 부적합.
					buCnt++;
				}
			}
		}
//		if ( yesCnt > 0 || buCnt > 0 ) {
//		}
		Util.i("test","buCnt : "+buCnt);
		boolean rdNone = ((CheckBox)findViewById(R.id.rd_none)).isChecked(); // 기기없음
		if ( !rdNone&&buCnt > 0 ) {
			setVisibility(R.id.ib_camera,View.VISIBLE);
		} else {
			setVisibility(R.id.ib_camera,View.GONE);			
		}
    }

	/**
     * 부적합->기기없음.
     */
    private void fNToX(String faCd) {
  		db.execSQL("DELETE FROM " + WConstant.TBL_JUM_NOCFM
				+ " WHERE CHECKUP_IDX   = '" + v.getCheckupIdx()   + "'"
				+ "   AND FA_CD  = '" + faCd  + "'"
		);
  		db.execSQL("DELETE FROM " + WConstant.TBL_JUM_EXCEPTION
				+ " WHERE CHECKUP_IDX   = '" + v.getCheckupIdx()   + "'"
  				+ "   AND FA_CD  = '" + faCd  + "'"	    	              				
			);
		db.execSQL("INSERT INTO " + WConstant.TBL_JUM_EXCEPTION
				+ " (   CHECKUP_IDX, FA_CD , CHECKUP_ITEM_CD) "
				+ " SELECT  " 
				+ " '" + v.getCheckupIdx()    + "'"
				+ ",'" + faCd + "'"
				+ ", CD"
				+ " FROM " + WConstant.TBL_CODE
				+ " WHERE TYPE_CD = 'FA020'"
		);
        try { // 부적합파일
        	Util.deleteFilesWithPrefix(Constant.PIC_DIR, "P_"+checkup_ym+checkup_cd+house_no+fake_house_no+"_NOCFM_"+faCd);        	
        } catch ( Exception ex ) {}
        
    }

    /**
	 * 적합여부 변경
	 */
	private void fToOkYn(String faCd,String okYn) {
	    String sql = "";
	    sql = "UPDATE " + WConstant.TBL_JUM;
	    if (WConstant.CODE_FA_CD_BREAKER.equals(faCd)) {// 가스차단기
	        sql += "   SET BREAKER_OK_YN = '" + okYn   + "'";
	    } else if (WConstant.CODE_FA_CD_GM.equals(faCd)) {// 계량기
	        sql += "   SET GM_OK_YN = '" + okYn   + "'";
	    } else if (WConstant.CODE_FA_CD_PIPE.equals(faCd)) {// 배관
	        sql += "   SET PIPE_OK_YN = '" + okYn   + "'";
	    } else if (WConstant.CODE_FA_CD_BOILER.equals(faCd)) {// 보일러
	        sql += "   SET BOILER_OK_YN = '" + okYn   + "'";
	    } else if (WConstant.CODE_FA_CD_BURNER.equals(faCd)) {// 연소기
	        sql += "   SET BURNER_OK_YN = '" + okYn   + "'";
	    }
	    sql += " WHERE CHECKUP_YM   = '" + checkup_ym   + "'"
	        + "   AND CHECKUP_CD   = '" + checkup_cd   + "'"
	        + "   AND HOUSE_NO = '" + house_no + "'"
	        + "   AND IFNULL(FAKE_HOUSE_NO,'')  = '" + fake_house_no  + "'"
	        ;
	    db.execSQL(sql);
	}

	/**
	 * 저장
	 */
	@SuppressWarnings("unchecked")
	private boolean fSave(String faCd) {
		boolean rdNone = ((CheckBox)findViewById(R.id.rd_none)).isChecked();
		boolean rtn = true;
    	boolean exec = true;
    	String etGmCfm = ((String) getValue(R.id.et_gm_no_cfm    )).trim();
    	String etChkM  = ((String) getValue(R.id.et_checkup_meter)).trim();    	
        if ( "0".equals(v.getFakeHouseNo()) ) {
        	if ( etGmCfm.length() !=0 && etGmCfm.length() != 12 ) { // 점검계량기지침
        		alert(R.string.msg_do_input_12_gm_no_cfm, new DialogInterface.OnClickListener() {
        			public void onClick(DialogInterface dialog, int whichButton) {
        				setFocus(R.id.et_gm_no_cfm);
        			}
        		});	
        		rtn = exec = false;
        	} else if ( StringUtils.isEmpty(etChkM) ) {
 	        	alert(R.string.msg_do_check_checkup_memter2
 	  	              , new DialogInterface.OnClickListener() {
 	        			    public void onClick(DialogInterface dialog, int whichButton) {
 	        			    	setFocus(R.id.et_checkup_meter);        	
 	        			    }}); // 점검계량기지침을 확인하세요.
 	        	rtn = exec = false;
        	}
        }
        
        if ( exec ) {
        	if ( rdNone ) { // 기기없음
        		fNToX(FA_CD);
        		fToOkYn(faCd,WConstant.CODE_CHECK_OK_X);    		
        	} else {
        		ListViewMP lv = (ListViewMP) findViewById(R.id.listView1);
        		int buCnt = 0;
        		int yesCnt = 0;
        		int cnt = lv.getCount();
//			LinkedHashMap<String, String> noCfmInfo = new LinkedHashMap<String, String>();
        		List<String> noCfmInfo = new ArrayList<String>();
        		
        		for( int i=0;i<cnt;i++) {
        			ViewGroup v = (ViewGroup) lv.getChildAt(i);
        			SpinnerCd spn = (SpinnerCd)v.findViewById(R.id.spn_v2);
        			HashMap<String, String> key = (HashMap<String, String>) v.getTag();
        			
        			if ( spn.getSelected() == 0 ) { // 적합
        				yesCnt++;
        			} else { // 부적합.
        				buCnt++;
//					noCfmInfo.put(CODE_JOB_CD_1, "정기정검");
        				Util.i("test",key.get("CHECKUP_REMARK_CD") + " / " + spn.getSelectedItemPosition());
        				if ( spn.getSelectedItemPosition()==1) {
        					noCfmInfo.add("'"+key.get("CHECKUP_REMARK_CD")+"'");
        				}
        			}
        		}
        		if ( buCnt != pc.fileCount() ) {
        			alert(R.string.msg_missmatch_pic_count_to_nocfm); // 부적합 개수와 사진촬영 개수가 맞지 않습니다.
        			rtn = false;
        		} else {
        			if ( yesCnt == cnt ) { // 모두적합
        				db.execSQL("DELETE FROM " + WConstant.TBL_JUM_NOCFM
        						+ " WHERE CHECKUP_IDX   = '" + v.getCheckupIdx()   + "'"        						
        						+ "   AND FA_CD  = '" + faCd  + "'"
        						);
        				db.execSQL("DELETE FROM " + WConstant.TBL_JUM_NOCFM_PHOTO
        						+ " WHERE CHECKUP_IDX   = '" + v.getCheckupIdx()   + "'"        						
        						+ "   AND FA_CD  = '" + faCd  + "'"
        						);
        				try { // 부적합파일
        					Util.deleteFilesWithPrefix(Constant.PIC_DIR, "P_"+checkup_ym+checkup_cd+house_no+fake_house_no+"_NOCFM_"+faCd);        	
        				} catch ( Exception ex ) {}
        				
        				fToOkYn(faCd,WConstant.CODE_CHECK_OK_Y);
        			} else { // 부적합
        				db.execSQL("DELETE FROM " + WConstant.TBL_JUM_NOCFM
        						+ " WHERE CHECKUP_IDX   = '" + v.getCheckupIdx()   + "'"        						
        						+ "   AND FA_CD  = '" + faCd  + "'"
        						);
        				if ( noCfmInfo.size() > 0 ) {
        					String sql = "INSERT INTO " + WConstant.TBL_JUM_NOCFM
        							+ " (   CHECKUP_IDX, FA_CD, CHECKUP_ITEM_CD, CHECKUP_REMARK_CD) "
        							+ " SELECT  "
        							+ " '" + v.getCheckupIdx()    + "'"
        							+ " , SUBSTR(MCD.CD,1,2)    AS FA_CD"
        							+ " , SUBSTR(MCD.CD,1,4)    AS CHECKUP_ITEM_CD"
        							+ " , MCD.CD                AS CHECKUP_REMARK_CD"
        							//			                + " , MCD.CD_NM"
        							+ " FROM " + WConstant.TBL_CODE + " MCD"
        							+ " WHERE CD IN("+StringUtils.join(noCfmInfo,",")+")"
        							+ " AND TYPE_CD = 'FA030'";
        					db.execSQL(sql);
        				}
        				fToOkYn(faCd,WConstant.CODE_CHECK_OK_N);
        				
        				db.execSQL("DELETE FROM " + WConstant.TBL_JUM_NOCFM_PHOTO
        						+ " WHERE CHECKUP_IDX   = '" + v.getCheckupIdx()   + "'"        						
        						+ "   AND FA_CD  = '" + faCd  + "'"
        						);
        				
        				String[] files = pc.getFiles();
        				if ( files.length > 0 ) {
        					for( int i =0;i<files.length;i++) {
        						try {
        							String sqlInsert = "INSERT INTO " + WConstant.TBL_JUM_NOCFM_PHOTO
        									+ " (   CHECKUP_IDX, FA_CD , PHOTO_FILE_NM) "
        									+ " VALUES (  " 
        									+ " '" + v.getCheckupIdx()    + "'"
        									+ ",'" + FA_CD + "'"
        									+ ",'" + files[i]  + "'"
        									+ " )  " 
        									;
        							Util.i("test",sqlInsert);
        							db.execSQL(sqlInsert);
        						} catch( Exception ex ) {
        							alert(R.string.msg_db_error); // 저장중 오류가 발생하였습니다.
        						} finally {
        						}
        					}
        				}
        				
        			}
        			db.execSQL("UPDATE " + WConstant.TBL_JUM
        					+ " SET GM_NO_CFM   = '" + etGmCfm   + "'" // GM_NO_CFM	확인계량기번호
        					+ "   , CHECKUP_METER   = '" + etChkM   + "'" // CHECKUP_METER	점검지침
        					+ " WHERE CHECKUP_YM   = '" + checkup_ym   + "'"
        					+ "   AND CHECKUP_CD   = '" + checkup_cd   + "'"
        					+ "   AND HOUSE_NO = '" + house_no + "'"
        					+ "   AND IFNULL(FAKE_HOUSE_NO,'')  = '" + fake_house_no  + "'"
        					);	
        		}
        	}
        }
        return rtn;
	}

	@Override
	public void onClick(View vv) {
	    int viewID = vv.getId();
	    if ( viewID == R.id.ib_camera ) { // camera
	    	pc.start();
	    } else if ( viewID == R.id.ib_photoview ) { // picture        	
			Intent intentPic = new Intent(MngGmChkActivity.this, PicViewerActivity.class);
			intentPic.putExtra("imgRoot", Constant.PIC_DIR);
			intentPic.putExtra("mode"  , PicCamera.MODE_PICTURE);
			intentPic.putExtra("prefix" , checkup_ym + checkup_cd + house_no + fake_house_no + "_NOCFM_" + FA_CD);
			intentPic.putExtra("suffix" , ".jpg");
	    	if ( MngGmChkActivity.this.v.getSendYn().equals(Constant.CODE_SEND_Y) ) { // 송신완료.
	    		intentPic.putExtra("delAble" , false);
	    	}
			startActivityForResult(intentPic, Constant.PROC_ID_PIC_VIWER);
	    } else if ( viewID == R.id.ib_save) {
	    	confirm(R.string.msg_save_confirm
		          , new DialogInterface.OnClickListener() {
		              public void onClick(DialogInterface dialog, int whichButton) {
		                  if ( fSave(FA_CD) ) {
//		                	  retrive();
		                	  toast(R.string.msg_saved);
		                	  Intent sIntent = new Intent( MngGmChkActivity.this, ChkRegMainActivity.class );
		                      sIntent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
		                      sIntent.putExtra("bldg_cd"       , bldg_cd); // 건물그룹번호
		                      sIntent.putExtra("checkup_ym"        , checkup_ym ); // 작업년월(PK)
		                      sIntent.putExtra("checkup_cd"        , checkup_cd ); // 업무코드(PK)
		                      sIntent.putExtra("house_no"      , house_no ); // 수용가번호(PK)
		                      sIntent.putExtra("fake_house_no" , fake_house_no ); // 가수용가번호(PK)
		                      startActivity( sIntent );
		                      finish();
		                  }
		              }
		          }
		          , new DialogInterface.OnClickListener() {
		              public void onClick(DialogInterface dialog, int whichButton) {
		              }
		          }
	    	);
	    	
	    } else if ( viewID == R.id.ib_close) {
	    	finish();
	    } else if ( viewID == R.id.ib_b_barcode) {
	    	String barCodeType = ((WApplication)mApp).getBarCodeType();
	    	if ( Constant.CODE_BARCODE_SELF.equals(barCodeType) ) {
	    		launchScanner(vv);
	    	} else {
	    		try {
	    			//바코드 블루투스 리더기 연동 
	    			bi300 = new BI300Bluetooth(this,  new Handler() {
	    				@Override
	    				public void handleMessage(android.os.Message msg) {
	    					String message = (String) msg.obj;
	    					switch (msg.what) {
	    					case 1:
	    	                    String barCodeNo = WUtil.toDefault(message).trim();
	    	                    setText(R.id.et_gm_no_cfm,barCodeNo);
	    	                    if ( barCodeNo.length() != 12 ) {
	    	                    	alert(R.string.msg_do_input_12_gm_no_cfm, new DialogInterface.OnClickListener() {
	    	                            public void onClick(DialogInterface dialog, int whichButton) {
	    	                                setFocus(R.id.et_gm_no_cfm);
	    	                            }
	    	                        });
	    	                    }
	    						break;
	    					}
	    				};
	    			});
	    			bi300.startBI300();
				} catch (Exception e) {
//					alert("바코드스캐너 블루투스 연결하세요.");
				}
	    	}	    	
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
	public void onCheckedChanged(CompoundButton buttonView, boolean isChecked) {
		if(buttonView.getId() == R.id.rd_none ) {
			ListViewMP lv = (ListViewMP) findViewById(R.id.listView1);
			for( int i=0;i<lv.getCount();i++) {
				ViewGroup v = (ViewGroup) lv.getChildAt(i);
				SpinnerCd spn = (SpinnerCd)v.findViewById(R.id.spn_v2);
				if ( isChecked ) { // 기기없음					
					spn.setSelected(2);						
					spn.setEnabled(Boolean.FALSE);
				} else {
					spn.setSelected(0);					
					spn.setEnabled(Boolean.TRUE);
				}
			}
			fChgBuSpan();
		}
	}
    @Override
	public boolean onEditorAction(TextView v, int actionId, KeyEvent event) {
    	Util.i("test","actionId : " + actionId);
		if ((actionId == EditorInfo.IME_ACTION_DONE) ||
				(event != null && event.getKeyCode() == KeyEvent.KEYCODE_ENTER)) {
			getView(R.id.ib_save).performClick();
		}		
		return false;
	}

	@Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        if ( requestCode == Constant.PROC_ID_TAKE_CAMERA ) {
    		if ( resultCode != 0 ) {
    			pc.save();
    			if ( pc.fileCount() > 0 ) {
//    				String[] files = pc.getFiles();
//    				if ( files.length > 0 ) {
//	                    try {
//	                    	String sql = "INSERT INTO " + WConstant.TBL_JUM_NOCFM_PHOTO
//	                				+ " (   CHECKUP_YM ,CHECKUP_CD, HOUSE_NO ,FAKE_HOUSE_NO, FA_CD , PHOTO_FILE_NM) "
//	                				+ " VALUES (  " 
//	                				+ " '" + checkup_ym    + "'"
//	                				+ ",'" + checkup_cd    + "'"
//	                				+ ",'" + house_no  + "'"
//	                				+ ",'" + fake_house_no + "'"
//	                				+ ",'" + FA_CD + "'"
//	                				+ ",'" + pc.getFileName()  + "'"
//	                				+ " )  " 
//	                				;
//	                    	Util.i("test",sql);
//	                		db.execSQL(sql);
//	                    } catch( Exception ex ) {
//	                        alert(R.string.msg_db_error); // 저장중 오류가 발생하였습니다.
//	                    } finally {
//	                    }
//    				}
    				setVisibility(R.id.ib_photoview,View.VISIBLE);
    			}
    		} else {
    			pc.tempDelete();
    			if (pc.fileCount()==0)
    				setVisibility(R.id.ib_photoview,View.GONE);
    				
    		}
        } else if ( requestCode == Constant.PROC_ID_PIC_VIWER ) {
        	boolean rtn = data.getBooleanExtra("FILE_DELETED",false);
        	String fileName = data.getStringExtra("FILE_DELETED_NAME");
        	if ( rtn ) {
    			if ( pc.fileCount() > 0 ) {
    				setVisibility(R.id.ib_photoview,View.VISIBLE);
    			} else {
    				setVisibility(R.id.ib_photoview,View.GONE);
    			}
                try {
            		db.execSQL("DELETE FROM " + WConstant.TBL_JUM_NOCFM_PHOTO
            				+ " WHERE CHECKUP_IDX   = '" + v.getCheckupIdx()   + "'"            				
            				+ "   AND PHOTO_FILE_NM  = '" + fileName  + "'"
            		);
                } catch( Exception ex ) {
                    alert(R.string.msg_db_error); // 저장중 오류가 발생하였습니다.
                } finally {
                }  
        	}
        	
        } else if ( requestCode == Constant.ZBAR_SCANNER_REQUEST ) {
                if (resultCode == RESULT_OK) {
                    String barCodeNo = WUtil.toDefault(data.getStringExtra(ZBarConstants.SCAN_RESULT));
//                    if (barCodeNo.length() != 12) { // 자리수 체크로직 제거.
//                    	alert(R.string.msg_invalid_barcode);        	
//                    } else {
                    	setText(R.id.et_gm_no_cfm,barCodeNo);                    
//                    }
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
	protected void onResume() {
		super.onResume();
	}
	
    @Override
    protected void onPause() {
    	super.onPause();
    	if ( bi300 != null ) {
    		bi300.stopBI300();
    	}
    }

}
