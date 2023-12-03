package com.entropykorea.gas.chk.activity;

import org.apache.commons.lang3.StringUtils;

import android.annotation.SuppressLint;
import android.content.DialogInterface;
import android.content.Intent;
import android.database.Cursor;
import android.os.Bundle;
import android.os.Handler;
import android.telephony.PhoneNumberFormattingTextWatcher;
import android.telephony.PhoneNumberUtils;
import android.text.TextUtils;
import android.view.MenuItem;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup.LayoutParams;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemSelectedListener;
import android.widget.CheckBox;
import android.widget.CompoundButton;
import android.widget.CompoundButton.OnCheckedChangeListener;
import android.widget.EditText;
import android.widget.PopupMenu.OnMenuItemClickListener;
import android.widget.Toast;

import com.dm.zbar.android.scanner.ZBarConstants;
import com.dm.zbar.android.scanner.ZBarScannerActivity;
import com.entropykorea.ewire.database.Sqlite;
import com.entropykorea.gas.chk.R;
import com.entropykorea.gas.chk.WApplication;
import com.entropykorea.gas.chk.adapter.HouseInfAdapter;
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
import com.entropykorea.gas.lib.activity.PicViewerActivity;
import com.mypidion.BI300.BI300Bluetooth;

/**
 * @author softm
 * HouseInfActivity
 * 수용가정보
 */
@SuppressLint({ "ClickableViewAccessibility", "HandlerLeak" })
public class HouseInfActivity extends BaseActivity implements OnClickListener, OnTopClickListner, OnCheckedChangeListener, OnMenuItemClickListener  {
    public static final String TAG = "MPGAS";
    private TitleView tv = null;
    SpinnerCd spnCdVisit = null;
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
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        Intent intent = getIntent();
        bldg_cd       = WUtil.toDefault(intent.getStringExtra("bldg_cd"));

        checkup_ym    = WUtil.toDefault(intent.getStringExtra("checkup_ym"));
        checkup_cd    = WUtil.toDefault(intent.getStringExtra("checkup_cd"));
        house_no      = WUtil.toDefault(intent.getStringExtra("house_no"));
        fake_house_no = WUtil.toDefault(intent.getStringExtra("fake_house_no"));
        pos = intent.getIntExtra("position",0);
        total_count = intent.getIntExtra("total_count",0);
        if ( !"".equals(checkup_ym) && !"".equals(checkup_cd) && !"".equals(house_no) ) {
            setContentView(R.layout.activity_house_inf);
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
        tv = new TitleView(this, R.string.title_house_inf,false);
        tv.setOnTopClickListner(this);
        findViewById(R.id.ib_customer_info_save).setOnClickListener(this);

        findViewById(R.id.ib_b_barcode  ).setOnClickListener(this); // 건물내부QR코드 확인

        findViewById(R.id.ib_uncheck    ).setOnClickListener(this); // 미점검
        findViewById(R.id.ib_reject     ).setOnClickListener(this); // 거부
        findViewById(R.id.ib_check      ).setOnClickListener(this); // 점검시작
        findViewById(R.id.ib_checkcancel).setOnClickListener(this); // 점검취소
        findViewById(R.id.ib_checkmodify).setOnClickListener(this); // 점검수정

        findViewById(R.id.ib_camera   ).setOnClickListener(this); // 카메라
        findViewById(R.id.ib_photoview).setOnClickListener(this); // 뷰어

        ((EditText) findViewById(R.id.et_tel_no)).setInputType(android.text.InputType.TYPE_CLASS_PHONE);
        ((EditText) findViewById(R.id.et_tel_no)).addTextChangedListener(new PhoneNumberFormattingTextWatcher());
        ((EditText) findViewById(R.id.et_hp_no)).setInputType(android.text.InputType.TYPE_CLASS_PHONE);
        ((EditText) findViewById(R.id.et_hp_no)).addTextChangedListener(new PhoneNumberFormattingTextWatcher());
        ((EditText) findViewById(R.id.et_work_tel_no)).setInputType(android.text.InputType.TYPE_CLASS_PHONE);
        ((EditText) findViewById(R.id.et_work_tel_no)).addTextChangedListener(new PhoneNumberFormattingTextWatcher());

        ((CheckBox) findViewById(R.id.rd_tel_no)).setOnCheckedChangeListener(this);
        ((CheckBox) findViewById(R.id.rd_hp_no)).setOnCheckedChangeListener(this);
        ((CheckBox) findViewById(R.id.rd_work_tel_no)).setOnCheckedChangeListener(this);

        spnCdVisit = (SpinnerCd)findViewById(R.id.spn_cd_visit);
        spnCdVisit.getCode("FA120",R.string.label_spn_non_select2); // 미점검사유 : 방문결과코드
//      spnCdVisit.setDialogVisible(false);
        spnCdVisit.setOnItemSelectedListener(new OnItemSelectedListener() {
            public void onItemSelected(AdapterView<?> parent, View view,    int position, long id) {
                runOnUiThread(new Runnable() {
                    public void run() {
                    }
                });
            }
            public void onNothingSelected(AdapterView<?>  parent) {
            }
        });
    }
    private void retrive() {
        v = DUtil.getDataByWhere(getApplicationContext()," WHERE CHECKUP_YM = '" + checkup_ym + "'"
                + " AND CHECKUP_CD   = '" + checkup_cd + "'"
                + " AND HOUSE_NO = '" + house_no + "'"
                + " AND IFNULL(FAKE_HOUSE_NO,'') = '" + fake_house_no + "'"
                + " LIMIT 1");
        if ( pos == 0 || total_count == 0 ) {
            total_count = DUtil.getDataCountByWhere(getApplicationContext()," WHERE BLDG_CD = '" + v.getBldgCd() + "'");
            pos = Integer.parseInt(v.getHouseOrd(),10);
        }
        tv.setTitle(getResources().getString(R.string.title_house_inf) + " ( " + pos + " / " + total_count + " )");

        checkup_ym    = WUtil.toDefault( v.getCheckupYm()  );
        checkup_cd    = WUtil.toDefault( v.getCheckupCd()  );
        house_no      = WUtil.toDefault( v.getHouseNo()    );
        fake_house_no = WUtil.toDefault( v.getFakeHouseNo());

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
            setText(R.id.tv_house_no,  v.getHouseNo()); // 수용가번호
            setText(R.id.tv_house_status_nm  , DUtil.getCodeNm(this.getApplicationContext(),"MA090", v.getStatusCd() )); // 수용가상태
            setText(R.id.tv_cust_no ,  v.getCustNo() ); // 고객번호
            setText(R.id.et_cust_nm ,  v.getCustNm() ); // 고객명

            setText(R.id.tv_gm_no   ,  v.getGmNo()   ); // 계량기번호
            setText(R.id.tv_purpose_cd       , DUtil.getCodeNm(this.getApplicationContext(),"MA040", v.getPurposeCd()   )); // 용도코드
            setText(R.id.tv_install_loc_gb_cd, DUtil.getCodeNm(this.getApplicationContext(),"GM060", v.getInstallLocCd())); // 설치장소
            setText(R.id.tv_last_checkup_dt  , StringUtils.left(WUtil.toDefault(v.getLastCheckupDt()),10)); // 전점검일자
            setText(R.id.tv_last_checkup_cd  , v.getLastCheckupCd()); // 전점검결과
            setText(R.id.tv_qr_yn            , WConstant.CODE_QR_YN.get(v.getQrReadYn())); // 건물내부QR코드인식여부

            setVisibility(R.id.ib_uncheck,View.VISIBLE); // 미점검
            if ( Constant.CODE_END_Y.equals(v.getEndYn()) ) { // 완료
                setVisibility(R.id.ib_reject,View.GONE); // 거부
                setVisibility(R.id.ib_check,View.GONE);  // 점검시작
                setVisibility(R.id.ib_checkcancel,View.VISIBLE); // 점검취소
                setVisibility(R.id.ib_checkmodify,View.VISIBLE); // 점검수정
                setVisibility(R.id.ib_customer_info_save,View.GONE);
                setVisibility(R.id.ib_uncheck,View.INVISIBLE); // 미점검                
            } else { // 미완료
                setVisibility(R.id.ib_reject,View.VISIBLE); // 거부
                setVisibility(R.id.ib_check,View.VISIBLE);  // 점검시작
                setVisibility(R.id.ib_checkcancel,View.GONE); // 점검취소
                setVisibility(R.id.ib_checkmodify,View.GONE); // 점검수정
                setVisibility(R.id.ib_customer_info_save,View.VISIBLE);
            }
            
            if ( Constant.CODE_SEND_Y.equals(v.getSendYn()) ) {
                setVisibility(R.id.ib_checkcancel,View.INVISIBLE); // 점검취소
            }

            if ( Constant.CODE_TEL_CD_HOME.equals(v.getTelCd()) ) { // 자택
                ((CheckBox) findViewById(R.id.rd_tel_no)).setChecked(Boolean.TRUE);
            } else if ( Constant.CODE_TEL_CD_HP.equals(v.getTelCd()) ) { // 이동
                ((CheckBox) findViewById(R.id.rd_hp_no)).setChecked(Boolean.TRUE);
            } else if ( Constant.CODE_TEL_CD_WORK.equals(v.getTelCd()) ) { // 회사
                ((CheckBox) findViewById(R.id.rd_work_tel_no)).setChecked(Boolean.TRUE);
            }

            setText(R.id.et_tel_no,  PhoneNumberUtils.formatNumber(v.getTelNo().replaceAll("-", "")));
            setText(R.id.et_hp_no ,  PhoneNumberUtils.formatNumber(v.getHpNo().replaceAll("-", "")));
            setText(R.id.et_work_tel_no,  PhoneNumberUtils.formatNumber(v.getWorkTelNo().replaceAll("-", "")));
            setText(R.id.tv_info  , v.getRoomNo() + " " + (StringUtils.isNotEmpty(WUtil.toDefault(v.getFakeRoomNo()))?" " + v.getFakeRoomNo()+"":""));
//                CHE_YN    체납여부
//                GM_ERROR_YN   불회확인여부
//                LONG_NO_CHECKUP_YN    장기미점검여부
//                LONG_ACCEPT_YN    장기인정고지세대여부
//                CHECKUP_YM(PK)(FK)    작업년월(PK)(FK)
//                CHECKUP_CD(PK)(FK)    업무코드(PK)(FK)
//                HOUSE_NO(PK)(FK)  수용가번호(PK)(FK)
//                FAKE_HOUSE_NO(PK) 가수용가번호(PK)
            
            visitCount = DUtil.getVisitDataCount(this.getApplicationContext(), checkup_ym, checkup_cd, house_no, fake_house_no);
            String stateInfo = "";
            if ( visitCount > 0 ) {
                stateInfo = "방문" +visitCount;
            }
            if (!"".equals(stateInfo)) {
                stateInfo += "/";
            }
//              if ( Constant.CODE_END_Y.equals(v.getEndYn() )) {
            stateInfo += Constant.CODE_END_YN.get(v.getEndYn());
//              }
            String checkupResultCd = DUtil.getCodeNm(this.getApplicationContext(),"FA040", v.getCheckupResultCd());
            if ( StringUtils.isNotEmpty(checkupResultCd) ) {
            	stateInfo += "/";
            	stateInfo += "(" + checkupResultCd + ")";
            }
            stateInfo += "/";
            stateInfo += Constant.CODE_SEND_YN.get(v.getSendYn());
            // 방문3/완료(적합)/미송신
            setText(R.id.tv_state_info,  stateInfo);

            String etcInfo = "";
            etcInfo += (Constant.CODE_Y.equals(v.getCheYn())?(!"".equals(etcInfo)?",":"")+"체납":"");
            etcInfo += (Constant.CODE_Y.equals(v.getGmErrorYn())?(!"".equals(etcInfo)?",":"")+"불회확인":"");
            etcInfo += (Constant.CODE_Y.equals(v.getLongNoCheckupYn())?(!"".equals(etcInfo)?",":"")+"장기미점검":"");
            etcInfo += (Constant.CODE_Y.equals(v.getLongAcceptYn())?(!"".equals(etcInfo)?",":"")+"장기인정고지세대":"");

            pc = new PicCamera(this, Constant.PIC_DIR,PicCamera.MODE_PICTURE,checkup_ym + checkup_cd + house_no + fake_house_no +"_VISIT",".jpg");

            pc.setSingleMode(Boolean.TRUE);
            if ( pc.fileCount() > 0 ) {
                setVisibility(R.id.ib_photoview,View.VISIBLE);
            } else {
                setVisibility(R.id.ib_photoview,View.GONE);
            }

            if ( visitCount > 2 ) { // 2회이상 미점검시 표시.
                etcInfo += (Constant.CODE_Y.equals(v.getLongAcceptYn())?(!"".equals(etcInfo)?",":"")+"\n3회차 방문세대. 현관문, 새주소표시판 등 사진촬영필요 ":"");
            }

            if (visitCount==2) {
                setVisibility(R.id.ib_camera);
            } else {
                setVisibility(R.id.ib_camera   ,View.GONE);
            }
            if (visitCount>2) {
                setVisibility(R.id.ib_uncheck,View.GONE);
            }

            if ( Constant.CODE_SEND_Y.equals(v.getSendYn()) ) {
            	setVisibility(R.id.ib_camera   ,View.GONE);
                setVisibility(R.id.ib_customer_info_save,View.GONE);
            }

            setText(R.id.tv_etc_info,  etcInfo);
            if ( !"".equals(etcInfo) ) {
                setVisibility(R.id.tv_etc_info,View.VISIBLE);
            } else {
                setVisibility(R.id.tv_etc_info,View.GONE);
            }

            if ( !"".equals(v.getCustNm())) { // 한번 입력이 발생하면 수정 불가.
                ((EditText) findViewById(R.id.et_cust_nm)).setEnabled(Boolean.FALSE);
                ((EditText) findViewById(R.id.et_cust_nm)).setClickable(Boolean.FALSE);
                ((EditText) findViewById(R.id.et_cust_nm)).setFocusable(Boolean.FALSE);
            }

            String sql = "SELECT "
                    + "   JUM_VISIT._rowid_ as _id "
                    + " , JUM_VISIT.CHECKUP_IDX               AS CHECKUP_IDX         " // 작업년월(PK)
                    + " , JUM_VISIT.VISIT_SEQ                 AS VISIT_SEQ      " // 방문순번(PK)
//                    + " , JUM_VISIT.VISIT_DT                  AS VISIT_DT       " // 방문일자
                    + " , substr(JUM_VISIT.VISIT_DT ,1,4) ||'-'||substr(JUM_VISIT.VISIT_DT ,5,2)||'-'||substr(JUM_VISIT.VISIT_DT ,7,2) AS VISIT_DT " // 방문일자
                    + " , JUM_VISIT.VISIT_TM                  AS VISIT_TM       " // 방문시각
                    + " , JUM_VISIT.VISIT_RESULT_CD           AS VISIT_RESULT_CD" // 방문결과코드
                    + " , JUM_VISIT.SEND_YN                   AS SEND_YN        " // 송신여부
                    + " , CODE.CD_NM                          AS VISIT_RESULT_NM" // 방문결과
                    + "  FROM " + WConstant.TBL_JUM_VISIT + " JUM_VISIT "
                    + "  LEFT JOIN " + WConstant.TBL_CODE + " CODE "
                    + "         ON CODE.TYPE_CD = 'FA120' "
                    + "        AND CODE.CD = JUM_VISIT.VISIT_RESULT_CD"
                    + " WHERE JUM_VISIT.CHECKUP_IDX   = '" + v.getCheckupIdx()  + "'"
                    + " ORDER BY VISIT_SEQ DESC"
            ;
            if ( c!= null ) c.close();
            c = db.rawQuery(sql, null);
            ListViewMP lv1 = (ListViewMP)findViewById(R.id.listView1);
            HouseInfAdapter adapter = new HouseInfAdapter(getApplicationContext(), c, 0);
            int height = (getResources().getDimensionPixelSize(R.dimen.listHeight)+1)*adapter.getCount();
            LayoutParams lp = lv1.getLayoutParams();
            lp.height = height;
//          lv1.setLayoutParams(lp);
            lv1.setAdapter(adapter);
//            WUtil.setListViewHeightBasedOnChildren(lv1);
            lv1.requestChildFocus(null,findViewById(R.id.scrollView1));
        }
    }

    /**
     * 고객정보 저장
     */
    private void fSaveCustInfo() {
        String custNm    = getValue(R.id.et_cust_nm).trim();
        String telNo     = getValue(R.id.et_tel_no).trim();
        String hpNo      = getValue(R.id.et_hp_no).trim();
        String workTelNo = getValue(R.id.et_work_tel_no).trim();
        setError(R.id.et_cust_nm,null);        
        setError(R.id.et_tel_no,null);        
        setError(R.id.et_hp_no,null);        
        setError(R.id.et_work_tel_no,null);        
        if (custNm.equals("")) {
//            alert(R.string.msg_do_input_cust_nm); // 고객명을 입력해주세요
            setError(R.id.et_cust_nm,R.string.msg_do_input_cust_nm); // 고객명을 입력해주세요
            setFocus(R.id.et_cust_nm);
        } else if ( !"".equals(telNo) && !WUtil.isValidPhoneNumber(telNo)) {
//            alert(R.string.msg_incorrect_tel_no); // 자택전화번호가 올바르지 않습니다.
            setError(R.id.et_tel_no,R.string.msg_incorrect_tel_no); // 자택전화번호가 올바르지 않습니다.
            setFocus(R.id.et_tel_no);
        } else if ( !"".equals(hpNo) && !WUtil.isValidCellPhoneNumber(hpNo)) {
//            alert(R.string.msg_incorrect_hp_no); // 이동전화번호가 올바르지 않습니다.
            setError(R.id.et_hp_no,R.string.msg_incorrect_hp_no); // 이동전화번호가 올바르지 않습니다.
            setFocus(R.id.et_hp_no);
        } else if ( !"".equals(workTelNo) && !WUtil.isValidPhoneNumber(workTelNo)) {
//            alert(R.string.msg_incorrect_work_tel_no); // 직장전화번호가 올바르지 않습니다.
            setError(R.id.et_work_tel_no,R.string.msg_incorrect_work_tel_no); // 직장전화번호가 올바르지 않습니다.
            setFocus(R.id.et_work_tel_no);
        } else if ( !((CheckBox) findViewById(R.id.rd_tel_no)).isChecked()
              && !((CheckBox) findViewById(R.id.rd_hp_no)).isChecked()
              && !((CheckBox) findViewById(R.id.rd_work_tel_no)).isChecked()
        ) {
            alert(R.string.msg_must_selected_one_tel_no); // 주사용 전화번호를 하나 선택하세요.
        } else {
            boolean exec = true;
            if ( ((CheckBox) findViewById(R.id.rd_tel_no)).isChecked() ) {
                if ( "".equals(telNo) ) {
//                    alert(R.string.msg_do_input_tel_no); // 자택전화번호를 입력해주세요.
                    setError(R.id.et_tel_no,R.string.msg_do_input_tel_no); // 자택전화번호를 입력해주세요.
                    setFocus(R.id.et_tel_no);
//                    setFocus(R.id.rd_tel_no);
                    exec = false;
                }
            } else if ( ((CheckBox) findViewById(R.id.rd_hp_no)).isChecked() ) {
                if ( "".equals(hpNo) ) {
//                    alert(R.string.msg_do_input_hp_no); // 이동전화번호를 입력해주세요.
                    setError(R.id.et_hp_no,R.string.msg_do_input_hp_no); // 이동전화번호를 입력해주세요.               	
                    setFocus(R.id.et_hp_no);
//                    setFocus(R.id.rd_hp_no);
                    exec = false;
                }
            } else if ( ((CheckBox) findViewById(R.id.rd_work_tel_no)).isChecked() ) {
                if ( "".equals(workTelNo) ) {
//                    alert(R.string.msg_do_input_work_tel_no); // 직장전화번호를 입력해주세요.
                    setError(R.id.et_work_tel_no,R.string.msg_do_input_work_tel_no); // 직장전화번호를 입력해주세요.                    
                    setFocus(R.id.et_work_tel_no);
//                    setFocus(R.id.rd_work_tel_no);
                    exec = false;
                }
            }

            if ( exec ) {
                confirm(R.string.msg_update_confirm, // 수정하시겠습니까?
                    new DialogInterface.OnClickListener() {
                        public void onClick(DialogInterface dialog, int whichButton) {
                            String custNm    = getValue(R.id.et_cust_nm).trim();
                            String telNo     = getValue(R.id.et_tel_no).trim();
                            String hpNo      = getValue(R.id.et_hp_no).trim();
                            String workTelNo = getValue(R.id.et_work_tel_no).trim();
                            String telCd = "";
                            if ( ((CheckBox) findViewById(R.id.rd_tel_no)).isChecked() ) {
                                telCd = Constant.CODE_TEL_CD_HOME;
                            } else if ( ((CheckBox) findViewById(R.id.rd_hp_no)).isChecked() ) {
                                telCd = Constant.CODE_TEL_CD_HP;
                            } else if ( ((CheckBox) findViewById(R.id.rd_work_tel_no)).isChecked() ) {
                                telCd = Constant.CODE_TEL_CD_WORK;
                            }
                            db.execSQL("UPDATE " + WConstant.TBL_JUM
                                    + " SET CUST_NM    = '" + custNm    + "'"
                                    + "   , TEL_NO     = '" + telNo     + "'"
                                    + "   , HP_NO      = '" + hpNo      + "'"
                                    + "   , WORK_TEL_NO= '" + workTelNo + "'"
                                    + "   , TEL_CD     = '" + telCd     + "'"
                                    + " WHERE CHECKUP_YM   = '" + checkup_ym   + "'"
                                    + "   AND CHECKUP_CD   = '" + checkup_cd   + "'"
                                    + "   AND HOUSE_NO = '" + house_no + "'"
                                    + "   AND IFNULL(FAKE_HOUSE_NO,'')  = '" + fake_house_no  + "'"
                                    );
                            
                            db.execSQL("INSERT OR REPLACE INTO " + WConstant.TBL_JUM_CUST
                                    + " (   CHECKUP_IDX , CUST_NM ,TEL_NO ,WORK_TEL_NO ,HP_NO ,TEL_CD ) VALUES "
                                    + " ( "
                                    + " '" + v.getCheckupIdx()    + "'"
                                    + ",'" + custNm    + "'"
                                    + ",'" + telNo     + "'"
                                    + ",'" + workTelNo + "'"
                                    + ",'" + hpNo      + "'"
                                    + ",'" + telCd     + "'"
                                    + " ) "
                            );
                            hideKeyboard();
                            retrive();
                            toast(R.string.msg_updated);
                    }
                    }, new DialogInterface.OnClickListener() {
                        public void onClick(DialogInterface dialog, int whichButton) {
                            // alert("취소");
                        }
                    });
            }
        }
    }

    private void fUpdateCheckStart() {
        String sql = "UPDATE " + WConstant.TBL_JUM
//                + "   SET CHECKUP_DT       = date()" // 점검일자
//                + "     , CHECKUP_BEGIN_DT = time()" // 점검시작시간
                + "   SET CHECKUP_DT       = strftime('%Y%m%d','now','localtime')" // 점검일자
                + "     , CHECKUP_BEGIN_DT = strftime('%H%M%S','now','localtime')" // 점검시작시간
                + "     , CHECKUP_USER_CD  = '" + ((WApplication)mApp).getUserId() + "'" // 점검작업자
                + " WHERE CHECKUP_YM   = '" + checkup_ym   + "'"
                + "   AND CHECKUP_CD   = '" + checkup_cd   + "'"
                + "   AND HOUSE_NO = '" + house_no + "'"
                + "   AND IFNULL(FAKE_HOUSE_NO,'')  = '" + fake_house_no  + "'"
        ;
        Sqlite sqlite =  new Sqlite(db);
        sqlite.execSql(sql);
    }

    private void fGoChkRegMain() {
        fUpdateCheckStart();
        Intent sIntent = new Intent(HouseInfActivity.this,ChkRegMainActivity.class); // 점검등록메인
        sIntent.putExtra("bldg_cd"       , bldg_cd); // 건물그룹번호
        sIntent.putExtra("checkup_ym"        , checkup_ym ); // 작업년월(PK)
        sIntent.putExtra("checkup_cd"        , checkup_cd ); // 업무코드(PK)
        sIntent.putExtra("house_no"      , house_no ); // 수용가번호(PK)
        sIntent.putExtra("fake_house_no" , fake_house_no ); // 가수용가번호(PK)
        startActivity(sIntent);
    }
    /**
     * 점검메인 이동.
     * @param gmNo
     * @param houseNo
     */
    private void fGoChkRegMain(String gmNo, String houseNo) {
        if ( "".equals(houseNo)) {
            alert(R.string.msg_invalid_house,new DialogInterface.OnClickListener() {
                public void onClick( DialogInterface dialog, int whichButton) {
                    fUpdateCheckStart();
                    Intent sIntent = new Intent(HouseInfActivity.this,ChkRegMainActivity.class); // 점검등록메인
                    sIntent.putExtra("bldg_cd"       , bldg_cd); // 건물그룹번호
                    sIntent.putExtra("checkup_ym"        , checkup_ym ); // 작업년월(PK)
                    sIntent.putExtra("checkup_cd"        , checkup_cd ); // 업무코드(PK)
                    sIntent.putExtra("house_no"      , house_no ); // 수용가번호(PK)
                    sIntent.putExtra("fake_house_no" , fake_house_no ); // 가수용가번호(PK)
                    startActivity(sIntent);
                }
            }); // 인식된 세대가 없습니다.\n확인 바랍니다.
        } else {
            if ( houseNo.equals(house_no) ) { // 바코드 인식수용가번호와 현재 수용가 번호가 동일하면.
                fUpdateCheckStart();
                Intent sIntent = new Intent(HouseInfActivity.this,ChkRegMainActivity.class); // 점검등록메인
                sIntent.putExtra("bldg_cd"       , bldg_cd); // 건물그룹번호
                sIntent.putExtra("checkup_ym"        , checkup_ym ); // 작업년월(PK)
                sIntent.putExtra("checkup_cd"        , checkup_cd ); // 업무코드(PK)
                sIntent.putExtra("house_no"      , house_no ); // 수용가번호(PK)
                sIntent.putExtra("fake_house_no" , fake_house_no ); // 가수용가번호(PK)
                startActivity(sIntent);
            } else {
                confirm(R.string.msg_meter_code_not_corrent_confirm, // 계량기 번호가 맞지 않습니다. 교체를 시작하시겠습니까?
                        new DialogInterface.OnClickListener() {
                    public void onClick(DialogInterface dialog,int whichButton) {
                        fUpdateCheckStart();
                        Intent sIntent = new Intent(HouseInfActivity.this,ChkRegMainActivity.class); // 점검등록메인
                        sIntent.putExtra("bldg_cd"       , bldg_cd); // 건물그룹번호
                        sIntent.putExtra("checkup_ym"        , checkup_ym ); // 작업년월(PK)
                        sIntent.putExtra("checkup_cd"        , checkup_cd ); // 업무코드(PK)
                        sIntent.putExtra("house_no"      , house_no ); // 수용가번호(PK)
                        sIntent.putExtra("fake_house_no" , fake_house_no ); // 가수용가번호(PK)
                    }
                }, new DialogInterface.OnClickListener() {
                    public void onClick( DialogInterface dialog, int whichButton) {
                    }
                });
            }
        }
    }

    /**
     * 거부
     *
     */
    private void fClearReject() {
        db.execSQL("DELETE FROM " + WConstant.TBL_JUM_NOCFM
                + " WHERE CHECKUP_IDX   = '" + v.getCheckupIdx()+ "'"
        );
        db.execSQL("DELETE FROM " + WConstant.TBL_JUM_EXCEPTION
                + " WHERE CHECKUP_IDX   = '" + v.getCheckupIdx()+ "'"
        );

//      FA040   0   미점검
//      FA040   1   적합
//      FA040   2   부적합
//      FA040   3   거부
        DUtil.clearChKDataByKey(HouseInfActivity.this.getApplicationContext(),WConstant.CODE_CHECKUP_RESULT_CD_3,checkup_ym,checkup_cd,house_no,fake_house_no);
        try { // 사진 삭제
            Util.deleteFilesWithPrefix(Constant.PIC_DIR, "P_"+checkup_ym+checkup_cd+house_no+fake_house_no);
        } catch ( Exception ex ) {}
        try { // 서명삭제
            Util.deleteFilesWithPrefix(Constant.SIGN_DIR, "S_"+checkup_ym+checkup_cd+house_no+fake_house_no);
        } catch ( Exception ex ) {}
    }

    /**
     * 점검취소
     */
    private void fClearJum() {
        db.execSQL("DELETE FROM " + WConstant.TBL_JUM_VISIT
                + " WHERE CHECKUP_IDX   = '" + v.getCheckupIdx()+ "'"
                + "   AND VISIT_DT      = strftime('%Y%m%d','now','localtime')"
                );
        db.execSQL("DELETE FROM " + WConstant.TBL_JUM_NOCFM
                + " WHERE CHECKUP_IDX   = '" + v.getCheckupIdx()+ "'"
                );
        db.execSQL("DELETE FROM " + WConstant.TBL_JUM_EXCEPTION
                + " WHERE CHECKUP_IDX   = '" + v.getCheckupIdx()+ "'"
                );
        // 필드 클리어 ...
        DUtil.clearChKDataByKey(HouseInfActivity.this.getApplicationContext(),WConstant.CODE_CHECKUP_RESULT_CD_0,checkup_ym,checkup_cd,house_no,fake_house_no);
        
        try { // 사진 삭제
        	// 부적합
        	// 방문 (3회시촬영)
            Util.deleteFilesWithPrefix(Constant.PIC_DIR, "P_"+checkup_ym+checkup_cd+house_no+fake_house_no);
        } catch ( Exception ex ) {}
        try { // 서명삭제
            Util.deleteFilesWithPrefix(Constant.SIGN_DIR, "S_"+checkup_ym+checkup_cd+house_no+fake_house_no);
        } catch ( Exception ex ) {}
    }

    @Override
    public void onClick(View v) {
        int viewID = v.getId();
        if ( viewID == R.id.ib_customer_info_save ) { // 고객정보 저장
            fSaveCustInfo();
        } else if ( viewID == R.id.ib_b_barcode ) { // 건물내부QR코드 확인
            launchQRScanner(null);
        } else if ( viewID == R.id.ib_uncheck ) { // 미점검
            if ( !"".equals(spnCdVisit.getValue()) ) {
                if ( visitCount == 2 && pc.fileCount() == 0 ) {
                    alert(R.string.msg_do_take_picture); // 사진촬영을 해주세요.
                } else {
                    confirm(R.string.msg_not_chk_confirm, // 미점검으로 처리하시겠습니까?
                            new DialogInterface.OnClickListener() {
                                public void onClick(DialogInterface dialog, int whichButton) {
                                    db.execSQL("INSERT INTO " + WConstant.TBL_JUM_VISIT
                                            + " (   CHECKUP_IDX , VISIT_SEQ ,VISIT_DT ,VISIT_TM ,VISIT_RESULT_CD ,SEND_YN ) "
                                            + " SELECT  "
                                            + " '" + HouseInfActivity.this.v.getCheckupIdx()    + "'"
                                            + ",IFNULL(MAX(JUM_VISIT.VISIT_SEQ),0) + 1"
                                            + ",strftime('%Y%m%d','now','localtime')" // 점검일자
                                            + ",strftime('%H%M%S','now','localtime')" // 점검시작시간
                                            + ",'" + spnCdVisit.getValue() + "'"
                                            + ",'"+ Constant.CODE_SEND_N+ "'"
                                            + " FROM " + WConstant.TBL_JUM_VISIT
                                            + " WHERE CHECKUP_IDX   = '" + HouseInfActivity.this.v.getCheckupIdx()   + "'"
                                    );
                                    retrive();
//                                    alert(R.string.msg_not_chked); //미점검처리 되었습니다.
                                    toast(R.string.msg_not_chked); //미점검처리 되었습니다.
                            }
                            }, new DialogInterface.OnClickListener() {
                                public void onClick(DialogInterface dialog, int whichButton) {
                                }
                            });
                }
            } else {
                alert(R.string.msg_do_input_not_chk); // 미점검사유를 선택하세요.
            }

        } else if ( viewID == R.id.ib_reject      ) { // 거부
            confirm(R.string.msg_reject_confirm, // 거부처리하시겠습니까?
                    new DialogInterface.OnClickListener() {
                        public void onClick(DialogInterface dialog, int whichButton) {
                            fClearReject();
//                          retrive();
                            alert(R.string.msg_do_reject // 거부되었습니다.
                            ,new DialogInterface.OnClickListener() {
                                public void onClick( DialogInterface dialog, int whichButton) {
                                    Intent sIntent = new Intent(HouseInfActivity.this,ChkCplActivity.class); // 점검완료
                                    sIntent.putExtra("bldg_cd"       , bldg_cd); // 건물그룹번호
                                    sIntent.putExtra("checkup_ym"    , checkup_ym ); // 작업년월(PK)
                                    sIntent.putExtra("checkup_cd"    , checkup_cd ); // 업무코드(PK)
                                    sIntent.putExtra("house_no"      , house_no ); // 수용가번호(PK)
                                    sIntent.putExtra("fake_house_no" , fake_house_no ); // 가수용가번호(PK)
                                    startActivity(sIntent);
                                }
                            });
                    }
                    }, new DialogInterface.OnClickListener() {
                        public void onClick(DialogInterface dialog, int whichButton) {
                        }
                    });
        } else if ( viewID == R.id.ib_check       ) { // 점검시작
            confirm(R.string.msg_meter_barcode_confirm // 계량기 바코드를 인식하시겠습니까?
                    , R.string.alert_yes_str
                    , new DialogInterface.OnClickListener() { // 예
                        public void onClick(DialogInterface dialog,int whichButton) {
                            String barCodeType = ((WApplication)mApp).getBarCodeType();
                            if ( Constant.CODE_BARCODE_SELF.equals(barCodeType) ) {
                                if (isCameraAvailable()) {
                                    Intent intent = new Intent(HouseInfActivity.this, ZBarScannerActivity.class);
                                    startActivityForResult(intent, WConstant.ZBAR_SCANNER_REQUEST2);
                                } else {
                                    Toast.makeText(HouseInfActivity.this, "Rear Facing Camera Unavailable", Toast.LENGTH_SHORT).show();
                                }
                            } else {
                                try {
                                    //바코드 블루투스 리더기 연동
                                    bi300 = new BI300Bluetooth(HouseInfActivity.this,  new Handler() {
                                        @Override
                                        public void handleMessage(android.os.Message msg) {
                                            String message = (String) msg.obj;
                                            switch (msg.what) {
                                            case 1:
                                                String gmNo = WUtil.toDefault(message).trim();
                                                ChkDTO key = DUtil.getKeyByGmNo(HouseInfActivity.this.getApplicationContext(),gmNo);
                                                fGoChkRegMain(gmNo, key.getHouseNo());
                                                break;
                                            }
                                        };
                                    });
                                    bi300.startBI300();
                                } catch (Exception e) {
//                                  alert("바코드스캐너 블루투스 연결하세요.");
                                }
                            }
                        }
                    }
                    , R.string.alert_no_str
                    , new DialogInterface.OnClickListener() { // 아니오
                        public void onClick(DialogInterface dialog,int whichButton) {
                            fGoChkRegMain();
                        }
                    }
                    , R.string.alert_cancel_str
                    , new DialogInterface.OnClickListener() { // 취소
                        public void onClick(DialogInterface dialog,int whichButton) {
                        }
                    }
            );

        } else if ( viewID == R.id.ib_checkcancel ) { // 점검취소
            confirm(R.string.msg_cancel_chk_confirm, // 미점검처리 또는 점검 내역을 취소하시겠습니까?
                    new DialogInterface.OnClickListener() {
                        public void onClick(DialogInterface dialog, int whichButton) {
                            fClearJum();
                            alert(R.string.msg_do_cancel_chk // 점검취소되었습니다.
                            ,new DialogInterface.OnClickListener() {
                                public void onClick( DialogInterface dialog, int whichButton) {
                                    retrive();
                                }
                            });
                    }
                    }, new DialogInterface.OnClickListener() {
                        public void onClick(DialogInterface dialog, int whichButton) {
                        }
                    });
        } else if ( viewID == R.id.ib_checkmodify ) { // 점검수정
            getView(R.id.ib_check).performClick(); // 점검시작
        } else if ( viewID == R.id.ib_camera ) { // camera
            pc.start();
        } else if ( viewID == R.id.ib_photoview ) { // picture
            Intent intentPic = new Intent(HouseInfActivity.this, PicViewerActivity.class);
            intentPic.putExtra("imgRoot", Constant.PIC_DIR);
            intentPic.putExtra("mode"  , PicCamera.MODE_PICTURE);
            intentPic.putExtra("prefix" , checkup_ym + checkup_cd + house_no + fake_house_no +"_VISIT");
            intentPic.putExtra("suffix" , ".jpg");
            if ( HouseInfActivity.this.v.getSendYn().equals(Constant.CODE_SEND_Y) ) { // 송신완료.
                intentPic.putExtra("delAble" , false);
            }
            startActivityForResult(intentPic, Constant.PROC_ID_PIC_VIWER);

        } else if ( viewID == R.id.ib_save ) { // 수정
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
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        if ( requestCode == Constant.ZBAR_SCANNER_REQUEST ) {
        } else if ( requestCode == Constant.ZBAR_QR_SCANNER_REQUEST ) { // 건물내부QR코드 확인.
            if (resultCode == RESULT_OK) {
                String msg = WUtil.toDefault(data.getStringExtra(ZBarConstants.SCAN_RESULT));
                String houseNo = StringUtils.left(msg,13);
                String fakeHouseNo = "0";
                if ( msg.length() == 23 ) {
                    fakeHouseNo = StringUtils.right(WUtil.toDefault(data.getStringExtra(ZBarConstants.SCAN_RESULT)),10);
                }
                Util.i("test",v.getHouseNo() + " / " + v.getFakeHouseNo());
                Util.i("test",houseNo + " / " + fakeHouseNo);
                if ( houseNo.equals(v.getHouseNo()) && fakeHouseNo.equals(v.getFakeHouseNo()) ) {
                    // 인식된 세대번호가 일치합니다.
                    Toast.makeText(this, R.string.msg_recognize_correct_house_no, Toast.LENGTH_SHORT).show();
                    try {
                        String sql = "UPDATE " + WConstant.TBL_JUM
                                + " SET QR_YN = '" + WConstant.CODE_QR_Y + "'" // 건물내부QR코드인식여부
                                + " WHERE CHECKUP_YM   = '" + checkup_ym   + "'"
                                + "   AND CHECKUP_CD   = '" + checkup_cd   + "'"
                                + "   AND HOUSE_NO = '" + houseNo + "'"
                                + "   AND IFNULL(FAKE_HOUSE_NO,'')  = '" + fakeHouseNo  + "'"
                        ;
                        db.execSQL(sql);
                    } catch( Exception ex ) {
                        alert(R.string.msg_db_error); // 저장중 오류가 발생하였습니다.
                    } finally {                    
                    }                        
                } else {
                	alert(R.string.msg_recognize_correct_house_info); // 수용가정보가 일치하지 않습니다.
                }
//                    Intent sIntent = new Intent(HouseInfActivity.this,ChkRegMainActivity.class); // 점검등록메인
//                    sIntent.putExtra("bldg_cd"       , bldg_cd       ); // 건물그룹번호
//                    sIntent.putExtra("checkup_ym"    , checkup_ym    ); // 작업년월(PK)
//                    sIntent.putExtra("checkup_cd"    , checkup_cd    ); // 업무코드(PK)
//                    sIntent.putExtra("house_no"      , house_no      ); // 수용가번호(PK)
//                    sIntent.putExtra("fake_house_no" , fake_house_no ); // 가수용가번호(PK)
//                    startActivity(sIntent);


            } else if(resultCode == RESULT_CANCELED && data != null) {
                String error = data.getStringExtra(ZBarConstants.ERROR_INFO);
                if(!TextUtils.isEmpty(error)) {
                    Toast.makeText(this, error, Toast.LENGTH_SHORT).show();
                }
            }
        } else if ( requestCode == WConstant.ZBAR_SCANNER_REQUEST2 ) {
            if ( data != null ) {
                String gmNo = WUtil.toDefault(data.getStringExtra(ZBarConstants.SCAN_RESULT));
                ChkDTO key = DUtil.getKeyByGmNo(HouseInfActivity.this.getApplicationContext(),gmNo);
                fGoChkRegMain(gmNo, key.getHouseNo());
            }

        } else if ( requestCode == Constant.PROC_ID_TAKE_CAMERA ) {
            if ( resultCode != 0 ) {
                pc.save();
                if ( pc.fileCount() > 0 ) {
                    String[] files = pc.getFiles();
                    if ( files.length > 0 ) {
                        try {
                            String sql = "UPDATE " + WConstant.TBL_JUM
                                    + " SET PHOTO_FILE_NM = '" + files[0] + "'" // 3회방문시 촬영돈 사진.
                                    + " WHERE CHECKUP_YM   = '" + checkup_ym   + "'"
                                    + "   AND CHECKUP_CD   = '" + checkup_cd   + "'"
                                    + "   AND HOUSE_NO = '" + house_no + "'"
                                    + "   AND IFNULL(FAKE_HOUSE_NO,'')  = '" + fake_house_no  + "'"
                            ;
                            db.execSQL(sql);
                        } catch( Exception ex ) {
                            alert(R.string.msg_db_error); // 저장중 오류가 발생하였습니다.
                        } finally {
                        }
                    }
                    setVisibility(R.id.ib_photoview,View.VISIBLE);
                }
            } else {
                pc.tempDelete();
            }
        } else if ( requestCode == Constant.PROC_ID_PIC_VIWER ) {
            boolean rtn = data.getBooleanExtra("FILE_DELETED",false);
            if ( rtn ) {
                if ( pc.fileCount() > 0 ) {
                    setVisibility(R.id.ib_photoview,View.VISIBLE);
                } else {
                    setVisibility(R.id.ib_photoview,View.INVISIBLE);
                }
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
