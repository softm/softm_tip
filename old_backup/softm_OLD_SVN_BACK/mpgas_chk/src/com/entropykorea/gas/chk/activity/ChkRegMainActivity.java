package com.entropykorea.gas.chk.activity;

import java.util.LinkedHashMap;

import org.apache.commons.lang3.StringUtils;

import android.annotation.SuppressLint;
import android.content.DialogInterface;
import android.content.Intent;
import android.database.Cursor;
import android.os.Bundle;
import android.view.MenuItem;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup.LayoutParams;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemSelectedListener;
import android.widget.CheckBox;
import android.widget.CompoundButton;
import android.widget.CompoundButton.OnCheckedChangeListener;
import android.widget.PopupMenu.OnMenuItemClickListener;

import com.entropykorea.gas.chk.R;
import com.entropykorea.gas.chk.adapter.ChkRegMainAdapter;
import com.entropykorea.gas.chk.common.DUtil;
import com.entropykorea.gas.chk.common.WConstant;
import com.entropykorea.gas.chk.common.WUtil;
import com.entropykorea.gas.chk.dto.ChkDTO;
import com.entropykorea.gas.lib.BaseActivity;
import com.entropykorea.gas.lib.Constant;
import com.entropykorea.gas.lib.ListViewMP;
import com.entropykorea.gas.lib.PicCamera;
import com.entropykorea.gas.lib.SpinnerCd;
import com.entropykorea.gas.lib.TitleView;
import com.entropykorea.gas.lib.TitleView.OnTopClickListner;
import com.entropykorea.gas.lib.Util;
import com.mypidion.BI300.BI300Bluetooth;

/**
 * @author softm
 * ChkRegMainActivity
 * 점검등록메인
 */
@SuppressLint({ "ClickableViewAccessibility", "HandlerLeak" })
public class ChkRegMainActivity extends BaseActivity implements OnClickListener, OnTopClickListner, OnCheckedChangeListener, OnMenuItemClickListener  {
    public static final String TAG = "MPGAS";
    private TitleView tv = null;
    int visitCount = 0;
    private ChkDTO v = new ChkDTO(); // 현재값

    private PicCamera pc = null;
    private BI300Bluetooth bi300 = null;
    private String bldg_cd;
    private String checkup_ym;
    private String checkup_cd;
    private String house_no;
    private String fake_house_no;
    private int pos;
    private int total_count = 0;
    Cursor c = null;

    private SpinnerCd spnCdBoiler = null; // 보일러점검
    private SpinnerCd spnCdBurner = null; // 연소기점검
    private SpinnerCd spnCdPipe   = null; // 배관점검
    private SpinnerCd spnCdGm     = null; // 계량기점검
    private SpinnerCd spnCdBreaker= null; // 차단기점검

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        Intent intent = getIntent();
        bldg_cd       = WUtil.toDefault(intent.getStringExtra("bldg_cd"));

        checkup_ym        = WUtil.toDefault(intent.getStringExtra("checkup_ym"));
        checkup_cd        = WUtil.toDefault(intent.getStringExtra("checkup_cd"));
        house_no      = WUtil.toDefault(intent.getStringExtra("house_no"));
        fake_house_no = WUtil.toDefault(intent.getStringExtra("fake_house_no"));
        pos = intent.getIntExtra("position",0);
        total_count = intent.getIntExtra("total_count",0);

        //TODO 테스트 param 삭제
        if (DEBUG && "".equals(checkup_ym)) {
	        bldg_cd = "1";
	        checkup_ym = "201501";
	        checkup_cd = "1";
	        house_no = "1010002001001";
	        fake_house_no = "0";
        }
        if ( !"".equals(checkup_ym) && !"".equals(checkup_cd) && !"".equals(house_no) ) {
            setContentView(R.layout.activity_chk_reg_main);
            init();
            retrive();
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
        tv = new TitleView(this, R.string.title_chk_reg_main,false);
        tv.setOnTopClickListner(this);
        findViewById(R.id.ib_go_chk_main).setOnClickListener(this);
        findViewById(R.id.ib_go_bolier).setOnClickListener(this);  // 보일러
        findViewById(R.id.ib_go_burner).setOnClickListener(this); // 연소기
        findViewById(R.id.ib_go_pipe).setOnClickListener(this); // 배관
        findViewById(R.id.ib_go_gm).setOnClickListener(this); // 계량기
        findViewById(R.id.ib_go_breaker).setOnClickListener(this); // 차단기
    }
    private boolean spnTriggerEvent = false;
    private void retrive() {
    	spnTriggerEvent = false;
//    	Util.i("test","retrive");
            v = DUtil.getDataByWhere(getApplicationContext()," WHERE CHECKUP_YM = '" + checkup_ym + "'"
                    + " AND CHECKUP_CD   = '" + checkup_cd + "'"
                    + " AND HOUSE_NO = '" + house_no + "'"
                    + " AND IFNULL(FAKE_HOUSE_NO,'') = '" + fake_house_no + "'"
                    + " LIMIT 1");
            checkup_ym        = WUtil.toDefault( v.getCheckupYm());
            checkup_cd        = WUtil.toDefault( v.getCheckupCd());
            house_no      = WUtil.toDefault( v.getHouseNo());
            fake_house_no = WUtil.toDefault( v.getFakeHouseNo());            
            if ( v.getCheckupYm() == null ) return;
            if ( "".equals(checkup_ym) || "".equals(checkup_cd) || "".equals(house_no) ) {
                alert(R.string.msg_not_exec_alert
                      , new DialogInterface.OnClickListener() {
                          public void onClick(DialogInterface dialog, int whichButton) {
                              finish();
                          }
                      }
                );
            } else {
                if ( "".equals(v.getCheckupIdx()) ) {
                    alert(R.string.msg_dosenot_exist
                            , new DialogInterface.OnClickListener() {
                                public void onClick(DialogInterface dialog, int whichButton) {
                                    finish();
                                }
                            }
                    );
                    return;
                }

                Util.i("test","v.getBoilerOkYn() :" + v.getBoilerOkYn());
                Util.i("test","v.getBurnerOkYn() :" + v.getBurnerOkYn());
                spnCdBoiler = (SpinnerCd)findViewById(R.id.spn_cd_boiler);
                LinkedHashMap<String, String> codeBoiler= (LinkedHashMap<String, String>) WConstant.CODE_CHECK_OK.clone();
                if ( WConstant.CODE_CHECK_OK_X.equals(v.getBoilerOkYn())) { // 기기없음
    //              spnCdBoiler.setEnabled(Boolean.FALSE);
                    codeBoiler.remove(WConstant.CODE_CHECK_OK_N); // 부적합                	
                } else if ( !WConstant.CODE_CHECK_OK_N.equals(v.getBoilerOkYn())) { // 부적합이 아니면 부적합 제거.
                    codeBoiler.remove(WConstant.CODE_CHECK_OK_N); // 부적합
                }
                setText(R.id.tv_end_yn,Constant.CODE_END_YN.get(v.getEndYn()));
                spnCdBoiler.setOrderByAsc(false);
                spnCdBoiler.setFontSize(25);
                spnCdBoiler.setPromptId(R.string.label_spn_boiler);
                spnCdBoiler.getCode(codeBoiler);
                spnCdBoiler.setTag(v.getBoilerOkYn());
                spnCdBoiler.setValue(v.getBoilerOkYn());
    //          spnCdBoiler.setDialogVisible(false);
                spnCdBoiler.setOnItemSelectedListener(new OnItemSelectedListener() {
                    public void onItemSelected(AdapterView<?> parent, View view,    int position, long id) {
                        fChgSpn(spnCdBoiler, WConstant.CODE_FA_CD_BOILER,v.getBoilerOkYn());
                    }
                    public void onNothingSelected(AdapterView<?>  parent) {
                    }
                });
                spnCdBurner= (SpinnerCd)findViewById(R.id.spn_cd_burner);
                LinkedHashMap<String, String> codeBurner = (LinkedHashMap<String, String>) WConstant.CODE_CHECK_OK.clone();
                if ( WConstant.CODE_CHECK_OK_X.equals(v.getBurnerOkYn())) { // 기기없음
    //              spnCdBurner.setEnabled(Boolean.FALSE);
                	codeBurner.remove(WConstant.CODE_CHECK_OK_N); // 부적합                	
                }
                if ( !WConstant.CODE_CHECK_OK_N.equals(v.getBurnerOkYn())) { // 부적합이 아니면 부적합 제거.
                    codeBurner.remove(WConstant.CODE_CHECK_OK_N); // 부적합
                }
                spnCdBurner.setOrderByAsc(false);
                spnCdBurner.setFontSize(25);
                spnCdBurner.setPromptId(R.string.label_spn_burner);
                spnCdBurner.getCode(codeBurner);
                spnCdBurner.setTag(v.getBurnerOkYn());
                spnCdBurner.setValue(v.getBurnerOkYn());
    //          spnCdBurner.setDialogVisible(false);
                spnCdBurner.setOnItemSelectedListener(new OnItemSelectedListener() {
                    public void onItemSelected(AdapterView<?> parent, View view,    int position, long id) {
                        fChgSpn(spnCdBurner, WConstant.CODE_FA_CD_BURNER,v.getBurnerOkYn());
                    }
                    public void onNothingSelected(AdapterView<?>  parent) {
                    }
                });
                spnCdPipe= (SpinnerCd)findViewById(R.id.spn_cd_pipe);
                LinkedHashMap<String, String> codePipe= (LinkedHashMap<String, String>) WConstant.CODE_CHECK_OK.clone();
                if ( WConstant.CODE_CHECK_OK_X.equals(v.getPipeOkYn())) { // 기기없음
    //              spnCdPipe.setEnabled(Boolean.FALSE);
                	codePipe.remove(WConstant.CODE_CHECK_OK_N); // 부적합                	
                }
                if ( !WConstant.CODE_CHECK_OK_N.equals(v.getPipeOkYn())) { // 부적합이 아니면 부적합 제거.
                    codePipe.remove(WConstant.CODE_CHECK_OK_N); // 부적합
                }
                spnCdPipe.setOrderByAsc(false);
                spnCdPipe.setFontSize(25);
                spnCdPipe.setPromptId(R.string.label_spn_pipe);
                spnCdPipe.getCode(codePipe);
                spnCdPipe.setTag(v.getPipeOkYn());
                spnCdPipe.setValue(v.getPipeOkYn());
    //          spnCdPipe.setDialogVisible(false);
                spnCdPipe.setOnItemSelectedListener(new OnItemSelectedListener() {
                    public void onItemSelected(AdapterView<?> parent, View view,    int position, long id) {
                        fChgSpn(spnCdPipe, WConstant.CODE_FA_CD_PIPE,v.getPipeOkYn());
                    }
                    public void onNothingSelected(AdapterView<?>  parent) {
                    }
                });

                spnCdGm= (SpinnerCd)findViewById(R.id.spn_cd_gm);
                LinkedHashMap<String, String> codeGm = (LinkedHashMap<String, String>) WConstant.CODE_CHECK_OK.clone();
                if ( WConstant.CODE_CHECK_OK_X.equals(v.getGmOkYn())) { // 기기없음
    //              spnCdGm.setEnabled(Boolean.FALSE);
                	codeGm.remove(WConstant.CODE_CHECK_OK_N); // 부적합                	
                }
                if ( !WConstant.CODE_CHECK_OK_N.equals(v.getGmOkYn())) { // 부적합이 아니면 부적합 제거.
                	codeGm.remove(WConstant.CODE_CHECK_OK_N); // 부적합
                }
                spnCdGm.setOrderByAsc(false);
                spnCdGm.setFontSize(25);
                spnCdGm.setPromptId(R.string.label_spn_gm);
                spnCdGm.getCode(codeGm);
                spnCdGm.setTag(v.getGmOkYn());
                spnCdGm.setValue(v.getGmOkYn());
    //          spnCdGm.setDialogVisible(false);
                spnCdGm.setOnItemSelectedListener(new OnItemSelectedListener() {
                    public void onItemSelected(AdapterView<?> parent, View view,    int position, long id) {
                        fChgSpn(spnCdGm, WConstant.CODE_FA_CD_GM,v.getGmOkYn());
                    }
                    public void onNothingSelected(AdapterView<?>  parent) {
                    }
                });

                spnCdBreaker= (SpinnerCd)findViewById(R.id.spn_cd_breaker);
                LinkedHashMap<String, String> codeBreaker = (LinkedHashMap<String, String>) WConstant.CODE_CHECK_OK.clone();
                if ( WConstant.CODE_CHECK_OK_X.equals(v.getBreakerOkYn())) { // 기기없음
    //              spnCdBreaker.setEnabled(Boolean.FALSE);
                	codeBreaker.remove(WConstant.CODE_CHECK_OK_N); // 부적합                	
                }
                if ( !WConstant.CODE_CHECK_OK_N.equals(v.getBreakerOkYn())) { // 부적합이 아니면 부적합 제거.
                    codeBreaker.remove(WConstant.CODE_CHECK_OK_N); // 부적합
                }
                spnCdBreaker.setOrderByAsc(false);
                spnCdBreaker.setFontSize(25);
                spnCdBreaker.setPromptId(R.string.label_spn_breaker);
                spnCdBreaker.getCode(codeBreaker);
                spnCdBreaker.setTag(v.getBreakerOkYn());
                spnCdBreaker.setValue(v.getBreakerOkYn());
    //          spnCdBreaker.setDialogVisible(false);
                spnCdBreaker.setOnItemSelectedListener(new OnItemSelectedListener() {
                    public void onItemSelected(AdapterView<?> parent, View view,    int position, long id) {
                        fChgSpn(spnCdBreaker, WConstant.CODE_FA_CD_BREAKER,v.getBreakerOkYn());
                    }
                    public void onNothingSelected(AdapterView<?>  parent) {
                    }
                });

                checkup_ym        = WUtil.toDefault( v.getCheckupYm());
                checkup_cd        = WUtil.toDefault( v.getCheckupCd());
                house_no      = WUtil.toDefault( v.getHouseNo());
                fake_house_no = WUtil.toDefault( v.getFakeHouseNo());
                setText(R.id.tv_info  , v.getSectorNm() + " " + v.getBldgNo() + " " + v.getComplexNm() + " " + v.getBldgNm() + " " + v.getRoomNo() + " " + (StringUtils.isNotEmpty(WUtil.toDefault(v.getFakeRoomNo()))?" " + v.getFakeRoomNo():""));

                String sql = "SELECT "
                        + "     JUM_NOIMP._rowid_ as _id "
                        + "   , JUM_NOIMP.FA_CD             AS FA_CD            "
                        + "   , JUM_NOIMP.CHECKUP_REMARK_CD AS CHECKUP_REMARK_CD"
                        + "   , CM.CD_NM                    AS FA_NM            "
                        + "   , CD.CD_NM                    AS CHECKUP_REMARK_NM"
                        + " FROM " + WConstant.TBL_JUM_NOIMP+ " "
                        + " LEFT JOIN " + WConstant.TBL_CODE + " CM "
                        + "   ON CM.TYPE_CD = 'FA010' "
                        + "  AND CM.CD = JUM_NOIMP.FA_CD "
                        + " LEFT JOIN " + WConstant.TBL_CODE + " CD "
                        + "   ON CD.TYPE_CD = 'FA030' "
                        + "  AND CD.CD = JUM_NOIMP.CHECKUP_REMARK_CD "
                        + " WHERE JUM_NOIMP.CHECKUP_IDX   = '" + v.getCheckupIdx() + "'"
//                        + " UNION "
//                        + " SELECT   "
//                        + " 1 as _id "
//                        + " , '01' AS FA_CD "
//                        + " , '010101' AS CHECKUP_REMARK_CD "
//                        + " , '가스차단기' AS FA_NM "
//                        + " , '가스검지기미설치' AS CHECKUP_REMARK_NM "
                ;
                if ( c!= null ) c.close();
                c = db.rawQuery(sql, null);
                ListViewMP lv1 = (ListViewMP)findViewById(R.id.listView1);
                ChkRegMainAdapter adapter = new ChkRegMainAdapter(getApplicationContext(), c, 0);
                int height = (getResources().getDimensionPixelSize(R.dimen.listHeight)+1)*adapter.getCount();
                LayoutParams lp = lv1.getLayoutParams();
                lp.height = height;
    //          lv1.setLayoutParams(lp);
                lv1.setAdapter(adapter);
    //            WUtil.setListViewHeightBasedOnChildren(lv1);
                lv1.requestChildFocus(null,findViewById(R.id.scrollView1));
            }
            spnTriggerEvent = true;
        }
    

    /**
     * 코드 스피너 변경 시.
     */
    private void fChgSpn(final SpinnerCd spnCd, final String faCd,String okYn) {

        String vv = (String) spnCd.getTag();
        spnCd.setTag(spnCd.getValue());
        
    	if ( spnTriggerEvent ) {
    		if (   WConstant.CODE_CHECK_OK_N.equals(okYn)
    				&& !vv.equals(spnCd.getValue()) && WConstant.CODE_CHECK_OK_X.equals(spnCd.getValue())
    				) { // 부적합에서 --> 기기없음
    			confirm(R.string.msg_nocfm_delete_confirm // 부적합 내역을 모두 삭제하시겠습니까?
    					, new DialogInterface.OnClickListener() {
    				public void onClick(DialogInterface dialog, int whichButton) {
    					fNToX(faCd);
    					retrive();
    				}
    			}
    			, new DialogInterface.OnClickListener() {
    				public void onClick(DialogInterface dialog, int whichButton) {
    			    	spnTriggerEvent = false;
    					spnCd.setValue(WConstant.CODE_CHECK_OK_N);
    			    	spnTriggerEvent = true;
    				}
    			}
    					);
    		} else if (   WConstant.CODE_CHECK_OK_N.equals(okYn)
    				&& !vv.equals(spnCd.getValue()) && WConstant.CODE_CHECK_OK_Y.equals(spnCd.getValue())
    				) { // 부적합에서 --> 적합
    			confirm(R.string.msg_nocfm_delete_confirm // 부적합 내역을 모두 삭제하시겠습니까?
    					, new DialogInterface.OnClickListener() {
    				public void onClick(DialogInterface dialog, int whichButton) {
    					fToY(faCd);
    					retrive();
    				}
    			}
    			, new DialogInterface.OnClickListener() {
    				public void onClick(DialogInterface dialog, int whichButton) {
    			    	spnTriggerEvent = false;    					
    					spnCd.setValue(WConstant.CODE_CHECK_OK_N);
    			    	spnTriggerEvent = true;    					
    				}
    			}
    					);
    		} else if (   WConstant.CODE_CHECK_OK_N.equals(okYn)
    				&& !vv.equals(spnCd.getValue()) && WConstant.CODE_CHECK_OK_NONE.equals(spnCd.getValue())
    				) { // 부적합에서 --> 미점검
    			confirm(R.string.msg_nocfm_delete_confirm // 부적합 내역을 모두 삭제하시겠습니까?
    					, new DialogInterface.OnClickListener() {
    				public void onClick(DialogInterface dialog, int whichButton) {
    					fNToNone(faCd);
    					retrive();
    				}
    			}
    			, new DialogInterface.OnClickListener() {
    				public void onClick(DialogInterface dialog, int whichButton) {
    			    	spnTriggerEvent = false;    					
    					spnCd.setValue(WConstant.CODE_CHECK_OK_NONE);
    			    	spnTriggerEvent = true;    					
    				}
    			}
    					);
    		} else if ( !vv.equals(spnCd.getValue()) && WConstant.CODE_CHECK_OK_Y.equals(spnCd.getValue())) { // 적합
//    			fToOkYn(faCd,WConstant.CODE_CHECK_OK_Y);
				fToY(faCd);    			
    			retrive();
    		} else if ( !vv.equals(spnCd.getValue()) ) {
    			fToClear(faCd);    			
    			fToOkYn(faCd,spnCd.getValue());
    			retrive();    			
    		}
    		Util.i("test","not null : " + "fChgSpn : " + spnCd.getId() + " / " + spnCd.getValue());    		
    	} else {
    		Util.i("test","null : " + "fChgSpn : " + spnCd.getId() + " / " + spnCd.getValue());
    	}
    }

    /**
     * 부적합->기기없음.
     */
    private void fNToX(String faCd) {
        db.execSQL("DELETE FROM " + WConstant.TBL_JUM_NOCFM
                + " WHERE CHECKUP_IDX = '" + v.getCheckupIdx() + "'"
                + "   AND FA_CD  = '" + faCd  + "'"
        );
        db.execSQL("DELETE FROM " + WConstant.TBL_JUM_EXCEPTION
                + " WHERE CHECKUP_IDX = '" + v.getCheckupIdx() + "'"
                + "   AND FA_CD  = '" + faCd  + "'"
            );
        db.execSQL("INSERT INTO " + WConstant.TBL_JUM_EXCEPTION
                + " (   CHECKUP_IDX , FA_CD , CHECKUP_ITEM_CD) "
                + " SELECT  "
                + " '" + v.getCheckupIdx()    + "'"
                + ",'" + faCd + "'"
                + ", CD"
                + " FROM " + WConstant.TBL_CODE
                + " WHERE TYPE_CD = 'FA020'"
        );
        fToOkYn(faCd,WConstant.CODE_CHECK_OK_X);
        try { // 부적합파일
        	Util.deleteFilesWithPrefix(Constant.PIC_DIR, "P_"+checkup_ym+checkup_cd+house_no+fake_house_no+"_NOCFM_"+faCd);            
        } catch ( Exception ex ) {}

    }

    /**
     * To 적합.
     */
    private void fToY(String faCd) {
        db.execSQL("DELETE FROM " + WConstant.TBL_JUM_NOCFM
                + " WHERE CHECKUP_IDX = '" + v.getCheckupIdx() + "'"
                + "   AND FA_CD  = '" + faCd  + "'"
                );
        db.execSQL("DELETE FROM " + WConstant.TBL_JUM_EXCEPTION
                + " WHERE CHECKUP_IDX = '" + v.getCheckupIdx() + "'"
                + "   AND FA_CD  = '" + faCd  + "'"
                );
        fToOkYn(faCd,WConstant.CODE_CHECK_OK_Y);
        try { // 부적합파일
        	Util.deleteFilesWithPrefix(Constant.PIC_DIR, "P_"+checkup_ym+checkup_cd+house_no+fake_house_no+"_NOCFM_"+faCd);            
        } catch ( Exception ex ) {}
    }
    /**
     * 부적합->미점검.
     */
    private void fNToNone(String faCd) {
    	db.execSQL("DELETE FROM " + WConstant.TBL_JUM_NOCFM
                + " WHERE CHECKUP_IDX = '" + v.getCheckupIdx() + "'"
    			+ "   AND FA_CD  = '" + faCd  + "'"
    			);
    	db.execSQL("DELETE FROM " + WConstant.TBL_JUM_EXCEPTION
                + " WHERE CHECKUP_IDX = '" + v.getCheckupIdx() + "'"
    			+ "   AND FA_CD  = '" + faCd  + "'"
    			);
    	fToOkYn(faCd,WConstant.CODE_CHECK_OK_NONE);
    	try { // 부적합파일
        	Util.deleteFilesWithPrefix(Constant.PIC_DIR, "P_"+checkup_ym+checkup_cd+house_no+fake_house_no+"_NOCFM_"+faCd);    		
    	} catch ( Exception ex ) {}
    }
    
    /**
     * To Clear.
     */
    private void fToClear(String faCd) {
        db.execSQL("DELETE FROM " + WConstant.TBL_JUM_NOCFM
                + " WHERE CHECKUP_IDX = '" + v.getCheckupIdx() + "'"
                + "   AND FA_CD  = '" + faCd  + "'"
                );
        db.execSQL("DELETE FROM " + WConstant.TBL_JUM_EXCEPTION
                + " WHERE CHECKUP_IDX = '" + v.getCheckupIdx() + "'"
                + "   AND FA_CD  = '" + faCd  + "'"
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
//        Util.i("test",sql);
        db.execSQL(sql);
    }

    /**
     * 점검  activity 실행.
     * @param cls
     */
    private void runChkMngActivity( Class<?> cls ) {
        Intent intent = new Intent( this, cls );
        intent.putExtra("bldg_cd"       , bldg_cd); // 건물그룹번호
        intent.putExtra("checkup_ym"    , checkup_ym ); // 작업년월(PK)
        intent.putExtra("checkup_cd"    , checkup_cd ); // 업무코드(PK)
        intent.putExtra("house_no"      , house_no ); // 수용가번호(PK)
        intent.putExtra("fake_house_no" , fake_house_no ); // 가수용가번호(PK)
        startActivity( intent );
    }

    @Override
    public void onClick(View vv) {
        int viewID = vv.getId();
        if ( viewID == R.id.ib_go_chk_main ) {
            if (
                   WConstant.CODE_CHECK_OK_NONE.equals(v.getBoilerOkYn())
                || WConstant.CODE_CHECK_OK_NONE.equals(v.getBurnerOkYn())
                || WConstant.CODE_CHECK_OK_NONE.equals(v.getPipeOkYn())
                || WConstant.CODE_CHECK_OK_NONE.equals(v.getGmOkYn())
                || WConstant.CODE_CHECK_OK_NONE.equals(v.getBreakerOkYn()) )
            { // 미점검 포함.
                alert(R.string.msg_do_check_not_chked); // 미점검 대상이 있습니다
            } else if ( // 모두 기기없음
                    WConstant.CODE_CHECK_OK_X.equals(v.getBoilerOkYn())
                 && WConstant.CODE_CHECK_OK_X.equals(v.getBurnerOkYn())
                 && WConstant.CODE_CHECK_OK_X.equals(v.getPipeOkYn())
                 && WConstant.CODE_CHECK_OK_X.equals(v.getGmOkYn())
                 && WConstant.CODE_CHECK_OK_X.equals(v.getBreakerOkYn()) )
            {
                alert(R.string.msg_do_input_chk_result); // 점검결과를 입력바랍니다.
            } else {
                Intent sIntent = new Intent(ChkRegMainActivity.this,ChkCplActivity.class); // 점검완료
                sIntent.putExtra("bldg_cd"       , bldg_cd); // 건물그룹번호
                sIntent.putExtra("checkup_ym"        , checkup_ym ); // 작업년월(PK)
                sIntent.putExtra("checkup_cd"        , checkup_cd ); // 업무코드(PK)
                sIntent.putExtra("house_no"      , house_no ); // 수용가번호(PK)
                sIntent.putExtra("fake_house_no" , fake_house_no ); // 가수용가번호(PK)
                startActivity(sIntent);
            }
        } else if ( viewID == R.id.ib_go_bolier ) { // 보일러
            if ( WConstant.CODE_CHECK_OK_X.equals(v.getBoilerOkYn()) ) {
                toast(R.string.msg_non_acessable_because_x); // 기기없음을 선택하여 점검화면으로 이동이 불가능합니다.
//            } else if ( WConstant.CODE_CHECK_OK_NONE.equals(v.getBoilerOkYn()) ) {
//                toast(R.string.msg_non_acessable_because_none); // 미점검상태이므로 점검하면으로 이동이 불가능합니다.
            } else {
                runChkMngActivity( MngBoilerChkActivity.class); // 보일러점검
            }
        } else if ( viewID == R.id.ib_go_burner ) { // 연소기
            if ( WConstant.CODE_CHECK_OK_X.equals(v.getBurnerOkYn()) ) {
                toast(R.string.msg_non_acessable_because_x); // 기기없음을 선택하여 점검하면으로 이동이 불가능합니다.
//            } else if ( WConstant.CODE_CHECK_OK_NONE.equals(v.getBurnerOkYn()) ) {
//                toast(R.string.msg_non_acessable_because_none); // 미점검상태이므로 점검하면으로 이동이 불가능합니다.
            } else {
                runChkMngActivity( MngBurnerChkActivity.class); // 연소기점검
            }
        } else if ( viewID == R.id.ib_go_pipe ) { // 배관
            if ( WConstant.CODE_CHECK_OK_X.equals(v.getPipeOkYn()) ) {
                toast(R.string.msg_non_acessable_because_x); // 기기없음을 선택하여 점검하면으로 이동이 불가능합니다.
//            } else if ( WConstant.CODE_CHECK_OK_NONE.equals(v.getPipeOkYn()) ) {
//                toast(R.string.msg_non_acessable_because_none); // 미점검상태이므로 점검하면으로 이동이 불가능합니다.                
            } else {
                runChkMngActivity( MngPipeChkActivity.class); // 배관점검
            }
        } else if ( viewID == R.id.ib_go_gm ) { // 계량기
            if ( WConstant.CODE_CHECK_OK_X.equals(v.getGmOkYn()) ) {
                toast(R.string.msg_non_acessable_because_x); // 기기없음을 선택하여 점검하면으로 이동이 불가능합니다.
//            } else if ( WConstant.CODE_CHECK_OK_NONE.equals(v.getGmOkYn()) ) {
//                toast(R.string.msg_non_acessable_because_none); // 미점검상태이므로 점검하면으로 이동이 불가능합니다.                
            } else {
                runChkMngActivity( MngGmChkActivity.class); // 계량기점검
            }
        } else if ( viewID == R.id.ib_go_breaker ) { // 차단기
            if ( WConstant.CODE_CHECK_OK_X.equals(v.getBreakerOkYn()) ) {
                toast(R.string.msg_non_acessable_because_x); // 기기없음을 선택하여 점검하면으로 이동이 불가능합니다.
//            } else if ( WConstant.CODE_CHECK_OK_NONE.equals(v.getBreakerOkYn()) ) {
//                toast(R.string.msg_non_acessable_because_none); // 미점검상태이므로 점검하면으로 이동이 불가능합니다.                
            } else {
                runChkMngActivity( MngBreakerChkActivity.class); // 차딘기점검
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
        if ( isChecked ) {
            ((CheckBox) findViewById(R.id.rd_tel_no)).setChecked(Boolean.FALSE); // rd_tel_no
            ((CheckBox) findViewById(R.id.rd_hp_no)).setChecked(Boolean.FALSE); // rd_hp_no
            ((CheckBox) findViewById(R.id.rd_work_tel_no)).setChecked(Boolean.FALSE); // rd_work_tel_no
            if(buttonView.getId() == R.id.rd_tel_no ) {
                ((CheckBox) findViewById(R.id.rd_tel_no)).setChecked(Boolean.TRUE); // rd_tel_no
            } else if(buttonView.getId() == R.id.rd_hp_no ) {
                ((CheckBox) findViewById(R.id.rd_hp_no)).setChecked(Boolean.TRUE); // rd_hp_no
            } else if(buttonView.getId() == R.id.rd_work_tel_no ) {
                ((CheckBox) findViewById(R.id.rd_work_tel_no)).setChecked(Boolean.TRUE); // rd_work_tel_no
            }
        }
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
}
