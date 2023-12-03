package kr.co.gscaltex.gsnpoint.card;

import java.io.ByteArrayInputStream;
import java.io.InputStream;
import java.util.ArrayList;
import java.util.List;

import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.DocumentBuilderFactory;

import kr.co.gscaltex.gsnpoint.BaseActivity;
import kr.co.gscaltex.gsnpoint.DefaultApplication;
import kr.co.gscaltex.gsnpoint.NewMainMenu;
import kr.co.gscaltex.gsnpoint.R;
import kr.co.gscaltex.gsnpoint.TitleView;
import kr.co.gscaltex.gsnpoint.util.Debug;
import kr.co.gscaltex.gsnpoint.util.FileInfo;
import kr.co.gscaltex.gsnpoint.util.SeedAndroidIF;
import kr.co.gscaltex.gsnpoint.util.Util;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.w3c.dom.Document;
import org.w3c.dom.Element;
import org.w3c.dom.Node;
import org.w3c.dom.NodeList;

import android.app.AlertDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.text.Editable;
import android.text.TextWatcher;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.view.inputmethod.InputMethodManager;
import android.widget.CompoundButton;
import android.widget.CompoundButton.OnCheckedChangeListener;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.ListView;
import android.widget.RadioButton;
import android.widget.TextView;
import android.widget.Toast;

public class CardRegView extends BaseActivity implements OnClickListener {
	DefaultApplication mApp ;

	private String URL  = Util.DATA_CONNECT;
	private String KIND = "CARD";	
	private Handler handler = new Handler();
	private boolean NewResult = false;
	private String mCardNum = null;
	/**
	 * LinearLayout 컨테이너 갯수
	 */
	private static final int CONTAINER_COUNT = 4;

	/**
	 * Application 관련 파일정보
	 */	
	private FileInfo fi;
	/**
	 * 카드 목록 리스트뷰
	 */	
	private ListView lstV01;
	/**
	 * 카드 목록 아답터
	 */
	private CardRegListAdapter  mCurrentAdapter = null;

	/**
	 * RDO : GC 제휴카드
	 */	
    private static final int ALLIANCE = 0;
	/**
	 * RDO : GB 보너스
	 */		
    private static final int BONUS    = 1;
	/**
	 * 포인트 카드 종류
	 */
	private String CARD_GUBUN[]  = { "GC", "GB" };
	/**
	 * 포인트 카드 종류 -보너스 카드 라디오 버튼
	 */
	private RadioButton mChkbBonus    ;
	/**
	 * 포인트 카드 종류 - 제휴 카드 라디오 버튼
	 */
	private RadioButton mChkbAlliance ;
	
	/**
	 * 카드번호 입력 에러 보관용.
	 */
	private EditText mCurrentErrorEdtCardObject ;

	/**
	 * 카드번호 입력 필드 - 01
	 */
	private EditText mEdtCardNumber01 ;

	/**
	 * 카드번호 입력 필드 - 02
	 */
	private EditText mEdtCardNumber02 ;

	/**
	 * 카드번호 입력 필드 - 03
	 */
	private EditText mEdtCardNumber03 ;

	/**
	 * 카드번호 입력 필드 - 04
	 */	
	private EditText mEdtCardNumber04 ;

	/**
	 * CVC번호 입력 필드 - 02
	 */
	private EditText mEdtCvcNumber ;
	
	/**
	 * 로그인 여부
	 */
	private boolean m_bLogin = false;
	
	/**
	 * 로그인 여부
	 */
	private boolean mPreBtnPressed = false;
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.cardregister); 

		mApp = ((DefaultApplication)getApplicationContext()) ;
		fi   = new FileInfo();
		
		Bundle extras = getIntent().getExtras();
		if (extras != null) m_bLogin = extras.getBoolean("login");
		
		new TitleView(this, true, true, R.string.TITLE_TYPE_CARD,m_bLogin);
		new NewMainMenu(this);
		
		setEventListener(); // 이벤트 핸들러 등록
		
		lstV01 = (ListView)findViewById(R.id.lstv_card_reg);
		mCurrentAdapter = new CardRegListAdapter(this);
		lstV01.setAdapter(mCurrentAdapter);
//		lstV01.invalidate();
//		lstV01.setOnItemClickListener(mItemClickListener);
        setContainerIndex(0); // 스텝0 화면 이동 ( 초기화면 )
        findViewById(R.id.step_container0).setVisibility(View.GONE);
		getList()			; // 카드목록 조회 
	}
	
	/**
	 * 
	 * View Object에 값을 할당합니다.
	 */
	private void setValueInLayout() {
		TextView tvUserName = (TextView)findViewById(R.id.tv_user_name);
		tvUserName.setText(fi.getSettingInfo(this, FileInfo.USER_NAME));	
        
		TextView tvCardCount = (TextView)findViewById(R.id.tv_card_count);
		//tvCardCount.setText(""+mCurrentAdapter.getCount());	mCardNum
		tvCardCount.setText(String.valueOf(mCurrentAdapter.getCount()));
		lstV01.setVerticalScrollBarEnabled(true);
	}
	
	/**
	 * 이전 - 다음
	 * 이벤트 리스너를 설정합니다.
	 */
	private void setEventListener() {
	    findViewById(R.id.img_btn_newcard    ).setOnClickListener(this); // 스텝0 - 카드등록
	    findViewById(R.id.img_btn_step1_pre  ).setOnClickListener(this); // 스텝1 - 이전
	    findViewById(R.id.img_btn_step1_next ).setOnClickListener(this); // 스텝1 - 다음
	    findViewById(R.id.img_btn_step2_pre  ).setOnClickListener(this); // 스텝2 - 이전
	    findViewById(R.id.img_btn_step2_next ).setOnClickListener(this); // 스텝2 - 다음
	    findViewById(R.id.img_btn_step3_pre  ).setOnClickListener(this); // 스텝3 - 이전
	    findViewById(R.id.img_btn_step3_next ).setOnClickListener(this); // 스텝3 - 다음
	}
	
	/* (non-Javadoc)
	 * @see android.view.View.OnClickListener#onClick(android.view.View)
	 */
	public void onClick(View v) {
		mPreBtnPressed = false;		
		switch (v.getId()) {

		case R.id.img_btn_newcard:
		
            setContainerIndex(1); // 스텝1 이동
			break;
		case R.id.img_btn_step1_pre:
			
			mPreBtnPressed = true;
            setContainerIndex(0); // 스텝0 이동
			break;
		case R.id.img_btn_step1_next:
			
    		if ( !mChkbBonus.isChecked() && !mChkbAlliance.isChecked() ) {
				showAlert(R.string.alert_str_card_step1_kind_select, R.string.alert_str,
						new DialogInterface.OnClickListener() {
							public void onClick(DialogInterface dialog,
									int which) {
								mChkbBonus.requestFocus();
								mChkbBonus.setCursorVisible(true);

							}
						});
    		} else {
    			setContainerIndex(2); // 스텝2 선택
    		}
    		break;

		case R.id.img_btn_step2_pre:
			
			mPreBtnPressed = true;
            setContainerIndex(1); // 스텝1 이동
			break;
		case R.id.img_btn_step2_next:
			
			final String cNum01 = String.valueOf( mEdtCardNumber01.getText());
			final String cNum02 = String.valueOf( mEdtCardNumber02.getText());
			final String cNum03 = String.valueOf( mEdtCardNumber03.getText());
			final String cNum04 = String.valueOf( mEdtCardNumber04.getText());
		    mCurrentErrorEdtCardObject = null; // 초기화

    		if ( cNum01.equals("") || cNum01.length() < 4 ) {
    			mCurrentErrorEdtCardObject = mEdtCardNumber01;
            } else if ( cNum02.equals("") || cNum02.length() < 4 ) {
    			mCurrentErrorEdtCardObject = mEdtCardNumber02;
            } else if ( cNum03.equals("") || cNum03.length() < 4 ) {
    			mCurrentErrorEdtCardObject = mEdtCardNumber03;
            } else if ( cNum04.equals("") || cNum04.length() < 4 ) {
    			mCurrentErrorEdtCardObject = mEdtCardNumber04;
            }
            if ( mCurrentErrorEdtCardObject != null ) {
            	
				showAlert(R.string.alert_str_card_step2_cardnumber_input_error, R.string.alert_str,
						new DialogInterface.OnClickListener() {
							public void onClick(DialogInterface dialog,
									int which) {
		                        mCurrentErrorEdtCardObject.requestFocus();
		                        new Thread() {
		                            @Override
		                            public void run() {
		                                try {
		                                    sleep(100);
		                                    InputMethodManager mgr = (InputMethodManager) getSystemService(Context.INPUT_METHOD_SERVICE);
		                                    mgr.showSoftInput(mCurrentErrorEdtCardObject, InputMethodManager.SHOW_FORCED);
		                                } catch (InterruptedException e) {
		                                    e.printStackTrace();
		                                }
		                            }
		                        }.start();
							}
						});
            } else {
            	setContainerIndex(3); // 스텝3 선택
    		}
			break;
		case R.id.img_btn_step3_pre:
			
			mPreBtnPressed = true;
            setContainerIndex(2); // 스텝3 이동
			break;
		case R.id.img_btn_step3_next:
			
			mEdtCvcNumber    = (EditText) findViewById(R.id.edt_cvcnumber    );
			final String cvcNum = String.valueOf( mEdtCvcNumber.getText());
    		if ( cvcNum.equals("") || cvcNum.length() < 3 ) {
				showAlert(R.string.alert_str_card_step3_cvc_input_error,
						R.string.alert_str,
						new DialogInterface.OnClickListener() {
							public void onClick(DialogInterface dialog,
									int which) {
								if (cvcNum.equals("")) {
									mEdtCvcNumber.requestFocus();
									new Thread() {
										@Override
										public void run() {
											try {
												sleep(100);
												InputMethodManager mgr = (InputMethodManager) getSystemService(Context.INPUT_METHOD_SERVICE);
												mgr.showSoftInput(
														mEdtCvcNumber,
														InputMethodManager.SHOW_FORCED);
											} catch (InterruptedException e) {
												e.printStackTrace();
											}
										}
									}.start();
								}
							}
						});
    		} else {
    			execCardReg();    			
    		}
			break;
		default:
			break;
		}
	}
	
	/**
	 * @param id resource id string
	 * @return int
	 * string id 로 Resource를 얻어옴.
	 */
	private int getResoureByStrId(String id) {
    	int containerResource = getResources().getIdentifier(id, "id", getPackageName());
    	return containerResource;
	}
	
	/**
	 * @param selectIdx 선택할 화면의 인덱스 ( step_container0 ~ step_container4 )
	 * 상단 탭을 선택된 상태로 만듭니다.
	 * @see CardRegView#clickEvent
	 * clickEvent에서 호출됨.
	 */
	private void setContainerIndex(int selectIdx) 
    {
		ViewGroup vContainer;
	    String uri = "step_container";
	    for (int i = 0; i < CONTAINER_COUNT; i++) {
	    	vContainer = ( ViewGroup ) findViewById(getResoureByStrId(uri+(i)));
	    	vContainer.setVisibility(View.GONE);
	    }
    	vContainer = ( ViewGroup ) findViewById(getResoureByStrId(uri+(selectIdx)));
    	vContainer.setVisibility(View.VISIBLE);
		ImageButton imgBtnLeft  = (ImageButton)findViewById(R.id.left_button);	
    	if ( selectIdx == 0 ) { // 첫화면
	 		imgBtnLeft.setOnClickListener(null);
			imgBtnLeft.setOnClickListener(new OnClickListener() {
				@Override
				public void onClick(View v) {
					finish();
				}
			});  
    	} if ( selectIdx == 1 ) { // 포인트카드 종류 선택
    		mChkbBonus    = (RadioButton) findViewById(R.id.chkb_bonus_card    );
    		mChkbAlliance = (RadioButton) findViewById(R.id.chkb_alliance_card );
    		boolean eventAdded = Boolean.valueOf(mChkbBonus.getTag()==null?"false":mChkbBonus.getTag().toString());
    		
    		if ( !eventAdded ) {
	    		mChkbBonus.setOnCheckedChangeListener(new OnCheckedChangeListener() {
					@Override
					public void onCheckedChanged(CompoundButton buttonView, boolean isChecked) {
						if (buttonView.isChecked()) { 
							mChkbAlliance.setChecked(false);
						}
					}
				});
	    		mChkbAlliance.setOnCheckedChangeListener(new OnCheckedChangeListener() {
					@Override
					public void onCheckedChanged(CompoundButton buttonView, boolean isChecked) {
						if (buttonView.isChecked()) { 
							mChkbBonus.setChecked(false);
						}
					}
				}); 	    		
	    		mChkbBonus.setTag(true);
    		} else {
    		}
    		imgBtnLeft.setOnClickListener(null);
    		imgBtnLeft.setOnClickListener(new OnClickListener() {
				@Override
				public void onClick(View v) {
					mPreBtnPressed=true;	
		            setContainerIndex(0); // 스텝0 이동	
				}
			});      		
    	} else if ( selectIdx == 2 ) { // 카드번호 입력
	    	mEdtCardNumber01 = (EditText) findViewById(R.id.edt_cardnumber01    );
	    	mEdtCardNumber02 = (EditText) findViewById(R.id.edt_cardnumber02    );
	    	mEdtCardNumber03 = (EditText) findViewById(R.id.edt_cardnumber03    );
	    	mEdtCardNumber04 = (EditText) findViewById(R.id.edt_cardnumber04    );
    		boolean eventAdded = Boolean.valueOf(mEdtCardNumber01.getTag()==null?"false":mEdtCardNumber01.getTag().toString());
    	    
			if ( !mPreBtnPressed && mEdtCardNumber01.getText().length() < 4 ) {
	            mEdtCardNumber01.requestFocus();
	            mEdtCardNumber01.selectAll();
	            InputMethodManager imm = (InputMethodManager) getSystemService(Context.INPUT_METHOD_SERVICE);
	            imm.showSoftInput(mEdtCardNumber01, InputMethodManager.SHOW_FORCED);
			}
			
    		if ( !eventAdded ) {
    			
		        TextWatcher cNum1watcher = new TextWatcher()
		        {
		            @Override
		            public void onTextChanged(CharSequence s, int start, int before, int count)
		            {
		                 if (mEdtCardNumber01.isFocusable()) {
		                     if ( mEdtCardNumber01.getText().length() == 4 ) {
		                         mEdtCardNumber02.requestFocus();
		                         mEdtCardNumber02.selectAll();
		                     }
		                 }
		            }
	
		            @Override
		            public void afterTextChanged(Editable s) { }
		            @Override
		            public void beforeTextChanged(CharSequence s, int start,int count, int after) { }
		        };
		        TextWatcher cNum2watcher = new TextWatcher()
		        {
		            @Override
		            public void onTextChanged(CharSequence s, int start, int before, int count)
		            {
		                  if (mEdtCardNumber02.isFocusable()) {
		                     if ( mEdtCardNumber02.getText().length() == 4 ) {
		                         mEdtCardNumber03.requestFocus();
		                         mEdtCardNumber03.selectAll();		                         
		                     }
		                 }
		            }
	
		            @Override
		            public void afterTextChanged(Editable s) { }
		            @Override
		            public void beforeTextChanged(CharSequence s, int start,int count, int after) { }
		        };
	
		        TextWatcher cNum3watcher = new TextWatcher()
		        {
		            @Override
		            public void onTextChanged(CharSequence s, int start, int before, int count)
		            {
		                 if (mEdtCardNumber03.isFocusable()) {
		                     if ( mEdtCardNumber03.getText().length() == 4 ) {
		                         mEdtCardNumber04.requestFocus();
		                         mEdtCardNumber04.selectAll();			                         
		                     }
		                 }
		            }
	
		            @Override
		            public void afterTextChanged(Editable s) { }
		            @Override
		            public void beforeTextChanged(CharSequence s, int start,int count, int after) { }
		        };
		        TextWatcher cNum4watcher = new TextWatcher()
		        {
		            @Override
		            public void onTextChanged(CharSequence s, int start, int before, int count)
		            {
		                if (mEdtCardNumber04.isFocusable()) {
		                     if ( mEdtCardNumber04.getText().length() == 4 ) {
//		                         mEdtCardNumber04.requestFocus();
		                         InputMethodManager imm = (InputMethodManager)getSystemService(Context.INPUT_METHOD_SERVICE);
		                         imm.hideSoftInputFromWindow(mEdtCardNumber04.getWindowToken(), 0);		                         
		                     }
		                 }
		            }
	
		            @Override
		            public void afterTextChanged(Editable s) { }
		            @Override
		            public void beforeTextChanged(CharSequence s, int start,int count, int after) { }
		        };
		        mEdtCardNumber01.setTag(true);
		    	mEdtCardNumber01.addTextChangedListener(cNum1watcher);
		    	mEdtCardNumber02.addTextChangedListener(cNum2watcher);
		    	mEdtCardNumber03.addTextChangedListener(cNum3watcher);
		    	mEdtCardNumber04.addTextChangedListener(cNum4watcher);
    		} else {
    		}
    		imgBtnLeft.setOnClickListener(null);
    		imgBtnLeft.setOnClickListener(new OnClickListener() {
				@Override
				public void onClick(View v) {
					mPreBtnPressed=true;
		            setContainerIndex(1); // 스텝1 이동	
				}
			});    		
    	} else  if ( selectIdx == 3 ) { // CVC 입력
        	mEdtCvcNumber = (EditText) findViewById(R.id.edt_cvcnumber    );
			if ( !mPreBtnPressed && mEdtCvcNumber.getText().length() < 3 ) {        	
	        	mEdtCvcNumber.requestFocus();
	        	mEdtCvcNumber.selectAll();
	        	InputMethodManager imm = (InputMethodManager) getSystemService(Context.INPUT_METHOD_SERVICE);
	        	imm.showSoftInput(mEdtCvcNumber, InputMethodManager.SHOW_FORCED);
			}
        	boolean eventAdded = Boolean.valueOf(mEdtCvcNumber.getTag()==null?"false":mEdtCvcNumber.getTag().toString());
			
    		if ( !eventAdded ) {	    	
		        TextWatcher cvcWatcher = new TextWatcher()
		        {
		            @Override
		            public void onTextChanged(CharSequence s, int start, int before, int count)
		            {
		                 if (mEdtCvcNumber.isFocusable()) {
		                     if ( mEdtCvcNumber.getText().length() == 3 ) {
		                         InputMethodManager imm = (InputMethodManager)getSystemService(Context.INPUT_METHOD_SERVICE);
		                         imm.hideSoftInputFromWindow(mEdtCvcNumber.getWindowToken(), 0);
		                     }
		                 }
		            }
	
		            @Override
		            public void afterTextChanged(Editable s) { }
		            @Override
		            public void beforeTextChanged(CharSequence s, int start,int count, int after) { }
		        };
		        mEdtCvcNumber.setTag(true);
		        mEdtCvcNumber.addTextChangedListener(cvcWatcher);
    		} else {
    		}
    		imgBtnLeft.setOnClickListener(null);
    		imgBtnLeft.setOnClickListener(new OnClickListener() {
				@Override
				public void onClick(View v) {
					mPreBtnPressed=true;
		            setContainerIndex(2); // 스텝2 이동	
				}
			});         		
    	}
	}

	/**
	 * 카드목록 조회합니다 (ServerStart 호출)
	 */
	private void getList() {
		if(  mCurrentAdapter.isProcessing() ) return;
		
		mCurrentAdapter.clearItem();
		showCenterProgress();
		
		mCurrentAdapter.startProcessing();
		new Thread(new Runnable() {
			public void run() {
				String cuskey1 = fi.getSettingInfo(getBaseContext(), FileInfo.CUSKEY_1);
				String cuskey2 = fi.getSettingInfo(getBaseContext(), FileInfo.CUSKEY_2);
				String userid  = fi.getSettingInfo(getBaseContext(), FileInfo.ID);
				
				List<NameValuePair> params = new ArrayList<NameValuePair>(2);
				params.add(new BasicNameValuePair("process_code", "cardList"));
				params.add(new BasicNameValuePair("cuskey1", cuskey1));
				params.add(new BasicNameValuePair("cuskey2", cuskey2));
				params.add(new BasicNameValuePair("userid", userid));
				params.add(new BasicNameValuePair("page", String.valueOf(mCurrentAdapter.getPage())));
				setParams(params);
				loadUrl(R.string.PROC_TYPE_INIT_DATA, URL, KIND ) ;
			}
		}).start();
	}
	
	/**
	 * 카드를 정지합니다. (ServerStart 호출)
	 * CardRegTextView에서 호출됨.
	 * @see CardRegTextView#onClick
	 * @param cardNo
	 */
	public void execCardStop(final String cardNo) {
		if ( cardNo != null && !cardNo.equals("") ) {	
	        AlertDialog.Builder alt_bld = new AlertDialog.Builder(this);  
		        alt_bld
		        .setTitle(R.string.alert_str)
		        .setMessage(R.string.alert_str_card_stop)  
		        .setCancelable(false) 
		        .setPositiveButton("확인", new DialogInterface.OnClickListener() {                  
		            public void onClick(DialogInterface dialog, int which) {
						showCenterProgress();
						new Thread(new Runnable() {
							public void run() {
								String userid  = fi.getSettingInfo(getBaseContext(), FileInfo.ID);
								List<NameValuePair> params = new ArrayList<NameValuePair>(2);
								params.add(new BasicNameValuePair("process_code", "cardStop"));
								params.add(new BasicNameValuePair("cno", cardNo));
								params.add(new BasicNameValuePair("userid", userid));
								setParams(params);
								loadUrl(R.string.CARD_STOP, URL, KIND ) ;
							}
						}).start();
		            }
		        })
		        .setNegativeButton("취소", new DialogInterface.OnClickListener() {                  
		            public void onClick(DialogInterface dialog, int which) {
		            }
		        })                
		        .create().show();
		} else {
			Toast.makeText(this, "정지처리를 위한 카드번호가 올바르지 않습니다.", Toast.LENGTH_SHORT).show();
		}
	}
	
	/**
	 * 카드를 등록합니다. (ServerStart 호출)
	 * @param cardNo
	 */
	private void execCardReg() {
		showCenterProgress();
		/*
		new Thread(new Runnable() {
			public void run() {
				String cNum01 = String.valueOf( mEdtCardNumber01.getText());
				String cNum02 = String.valueOf( mEdtCardNumber02.getText());
				String cNum03 = String.valueOf( mEdtCardNumber03.getText());
				String cNum04 = String.valueOf( mEdtCardNumber04.getText());
				String cvcNum = String.valueOf( mEdtCvcNumber.getText());
				
				String inCrdNo   = cNum01 + cNum02 + cNum03 + cNum04;
				String key       = fi.getSettingInfo(getBaseContext(), FileInfo.SEED);
				SeedAndroidIF si = new SeedAndroidIF();
				String cvc       =  si.encodeBase64(cvcNum,key);
				

				String cuskey1 = fi.getSettingInfo(getBaseContext(), FileInfo.CUSKEY_1);
				String cuskey2 = fi.getSettingInfo(getBaseContext(), FileInfo.CUSKEY_2);
				String userid  = fi.getSettingInfo(getBaseContext(), FileInfo.ID);
				List<NameValuePair> params = new ArrayList<NameValuePair>(7);
				params.add(new BasicNameValuePair("process_code", "cardRegister"));					
				params.add(new BasicNameValuePair("rdo"         , mChkbBonus.isChecked()?CARD_GUBUN[BONUS]:CARD_GUBUN[ALLIANCE]));
				params.add(new BasicNameValuePair("in_crd_no"   , inCrdNo   ));
				params.add(new BasicNameValuePair("cvc"         , cvc       ));
				params.add(new BasicNameValuePair("cuskey1"     , cuskey1   ));
				params.add(new BasicNameValuePair("cuskey2"     , cuskey2   ));
				params.add(new BasicNameValuePair("userid"      , userid    ));
				setParams(params);
				
				loadUrl(R.string.CARD_REGISTER, URL, KIND ) ;
			}
		}).start();
		*/
		Thread r = new Thread(new Runnable()  {
			public void run() {
				String cNum01 = String.valueOf( mEdtCardNumber01.getText());
				String cNum02 = String.valueOf( mEdtCardNumber02.getText());
				String cNum03 = String.valueOf( mEdtCardNumber03.getText());
				String cNum04 = String.valueOf( mEdtCardNumber04.getText());
				String cvcNum = String.valueOf( mEdtCvcNumber.getText());
				
				String inCrdNo   = cNum01 + cNum02 + cNum03 + cNum04;
				String key       = fi.getSettingInfo(getBaseContext(), FileInfo.SEED);
				SeedAndroidIF si = new SeedAndroidIF();
				String cvc       =  si.encodeBase64(cvcNum,key);
				

				String cuskey1 = fi.getSettingInfo(getBaseContext(), FileInfo.CUSKEY_1);
				String cuskey2 = fi.getSettingInfo(getBaseContext(), FileInfo.CUSKEY_2);
				String userid  = fi.getSettingInfo(getBaseContext(), FileInfo.ID);
				List<NameValuePair> params = new ArrayList<NameValuePair>(7);
				params.add(new BasicNameValuePair("process_code", "cardRegister"));					
				params.add(new BasicNameValuePair("rdo"         , mChkbBonus.isChecked()?CARD_GUBUN[BONUS]:CARD_GUBUN[ALLIANCE]));
				params.add(new BasicNameValuePair("in_crd_no"   , inCrdNo   ));
				params.add(new BasicNameValuePair("cvc"         , cvc       ));
				params.add(new BasicNameValuePair("cuskey1"     , cuskey1   ));
				params.add(new BasicNameValuePair("cuskey2"     , cuskey2   ));
				params.add(new BasicNameValuePair("userid"      , userid    ));
				setParams(params);
				
				loadUrl(R.string.CARD_REGISTER, URL, KIND ) ;
			}
		});
		r.start();
	}
	
	@Override
	protected void httpResult(int what, boolean result, String kind) {
		//Debug.trace(LOG_TAG, "httpResult" + "[" + what + "](" + result + ")") ;
		
		switch(what) {
		case R.string.CARD_LIST : // 카드 목록 조회
		
			NewResult = result ;
			if(NewResult) {			
				String str = getString();
				str = str.trim();
				try {
					DocumentBuilderFactory factory = DocumentBuilderFactory.newInstance();
					DocumentBuilder builder = factory.newDocumentBuilder();
					InputStream istream = new ByteArrayInputStream(str.getBytes("utf-8"));
					Document doc = builder.parse(istream);

					Element resulNode = doc.getDocumentElement();
					NodeList result_items = resulNode.getElementsByTagName("result");
					Node result_item = result_items.item(0);
					Node result_text = result_item.getFirstChild();
					
					NodeList error_items = resulNode.getElementsByTagName("err");
					Node error_item;
					Node error_text=null;

					result_tag = result_text.getNodeValue();
									
					if(result_tag.equals(Util.SERVER_ALERT_STATUS)){
						handler.post(viewToastRunnable);
						finish();
					}else if(result_tag.equals(Util.SERVER_GO_STATUS)){					
						goErrorUrl();						
						mCurrentAdapter.setReadAll(false);
						mCurrentAdapter.setPrevPage();
					}else if(result_tag.equals("0")){
						error_item = error_items.item(0);
						error_text = error_item.getFirstChild();
						String msg;
						
						if( error_text.getNodeValue() == null ){
							msg = Util.NOT_FOUND_RESULT;
							Toast.makeText(this, msg, Toast.LENGTH_SHORT).show();
						}else{
							msg = error_text.getNodeValue();
							Toast.makeText(this, msg, Toast.LENGTH_SHORT).show();
						}								
						//mCurrentAdapter.setReadAll(true);						
					}else if(result_tag.equals("1")){

						//String itemNames[] = { "pk", "cardName", "cardNo", "cvc", "stopYn" };
						String itemNames[] = { "pk", "issueName", "cardNo", "cvc", "stopYn" };
						NodeList items1 = resulNode.getElementsByTagName(itemNames[0]);
						NodeList items2 = resulNode.getElementsByTagName(itemNames[1]);
						NodeList items3 = resulNode.getElementsByTagName(itemNames[2]);
						NodeList items4 = resulNode.getElementsByTagName(itemNames[3]);
						NodeList items5 = resulNode.getElementsByTagName(itemNames[4]);
						
						if( items1.getLength() > 0)
						{
							for(int i = 0; i < items1.getLength();i++ )
							{
								Node item1 = items1.item(i);
								Node item2 = items2.item(i);
								Node item3 = items3.item(i);
								Node item4 = items4.item(i);
								Node item5 = items5.item(i);
								
								String pk       = item1.getFirstChild().getNodeValue();
								//String cardName = item2.getFirstChild().getNodeValue();
								String issueName = item2.getFirstChild().getNodeValue();
								String cardNo   = item3.getFirstChild().getNodeValue();
								String cvc      = item4.getFirstChild().getNodeValue();
								String stopYn   = item5.getFirstChild().getNodeValue();
								
								mCardNum= cardNo;
						
								mCurrentAdapter.addItem(new CardRegTextItem((i+1)+(mCurrentAdapter.getPage()-1)*5, pk, issueName ,cardNo , cvc, stopYn));
							}
							mCurrentAdapter.notifyDataSetChanged();
						}
					}
				}
				catch (Exception e) {
					e.printStackTrace();
				}			
			}
			else{
				Toast.makeText(this, "에러", Toast.LENGTH_SHORT).show();
		    }		
			hideCenterProgress();
			
			mCurrentAdapter.endProcessing();
			
	        setValueInLayout()	; // 화면에 값을 적용합니다.			
	        findViewById(R.id.step_container0).setVisibility(View.VISIBLE);

	        break ;
		case R.string.CARD_STOP: // 카드 정지
			AlertDialog.Builder alt_bld = new AlertDialog.Builder(this);  
			NewResult = result ;
			if(NewResult) {			
				String str = getString();
				str = str.trim();

				try {
					DocumentBuilderFactory factory = DocumentBuilderFactory.newInstance();
					DocumentBuilder builder = factory.newDocumentBuilder();
					InputStream istream = new ByteArrayInputStream(str.getBytes("utf-8"));
					Document doc = builder.parse(istream);

					Element resulNode = doc.getDocumentElement();
					NodeList result_items = resulNode.getElementsByTagName("result");
					Node result_item = result_items.item(0);
					Node result_text = result_item.getFirstChild();
					
					NodeList error_items = resulNode.getElementsByTagName("err");
					Node error_item;
					Node error_text=null;

					result_tag = result_text.getNodeValue();
										
					if(result_tag.equals(Util.SERVER_ALERT_STATUS)){
						handler.post(viewToastRunnable);
						finish();
					}else if(result_tag.equals(Util.SERVER_GO_STATUS)){					
						goErrorUrl();						
					}else if(result_tag.equals("0")){
						error_item = error_items.item(0);
						error_text = error_item.getFirstChild();
						String msg;
						
						if( error_text.getNodeValue() == null ){
							msg = Util.NOT_FOUND_RESULT;
							showAlert(msg);
							//Toast.makeText(this, msg, Toast.LENGTH_SHORT).show();
						}else{
							msg = error_text.getNodeValue();
					        showAlert(msg);
							//Toast.makeText(this, msg, Toast.LENGTH_SHORT).show();
						}								
						//mCurrentAdapter.setReadAll(true);						
					} else if(result_tag.equals("1")){
						//getList(); // ServerStart 
						alt_bld.setMessage(R.string.alert_str_card_stop_ok)  
				    	.setCancelable(false)  
				    	.setPositiveButton("확인", new DialogInterface.OnClickListener() {					
							public void onClick(DialogInterface dialog, int which) {
								getList();
							}
				    	});
						showAlertDialog(alt_bld);
						
					}
				}
				catch (Exception e) {
					e.printStackTrace();
				}			
			}
			else{
				Toast.makeText(this, "에러", Toast.LENGTH_SHORT).show();
		    }		
			hideCenterProgress();
	        break ;	
		case R.string.CARD_REGISTER: // 카드 등록
		
			NewResult = result ;
			if(NewResult) {			
				String str = getString();
				str = str.trim();
				try {
					DocumentBuilderFactory factory = DocumentBuilderFactory.newInstance();
					DocumentBuilder builder = factory.newDocumentBuilder();
					InputStream istream = new ByteArrayInputStream(str.getBytes("utf-8"));
					Document doc = builder.parse(istream);

					Element resulNode = doc.getDocumentElement();
					NodeList result_items = resulNode.getElementsByTagName("result");
					Node result_item = result_items.item(0);
					Node result_text = result_item.getFirstChild();
					
					NodeList error_items = resulNode.getElementsByTagName("err");
					Node error_item;
					Node error_text=null;

					result_tag = result_text.getNodeValue();
										
					if(result_tag.equals(Util.SERVER_ALERT_STATUS)){
						handler.post(viewToastRunnable);
						finish();
					}else if(result_tag.equals(Util.SERVER_GO_STATUS)){					
						goErrorUrl();						
					}else if(result_tag.equals("0")){
						error_item = error_items.item(0);
						error_text = error_item.getFirstChild();
						String msg;
						if( error_text.getNodeValue() == null ){
							msg = Util.NOT_FOUND_RESULT;
							showAlert(msg);							
//							Toast.makeText(this, msg, Toast.LENGTH_SHORT).show();
						}else{
							msg = error_text.getNodeValue();
							showAlert(msg);
//							Toast.makeText(this, msg, Toast.LENGTH_SHORT).show();
						}								
						//mCurrentAdapter.setReadAll(true);						
					} else if(result_tag.equals("1")){
						showAlert(R.string.alert_str_card_step3_success);
						Intent intent = new Intent(this, CardMainView.class);
						intent.putExtra("login", m_bLogin) ;
						intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
				        startActivity(intent);								
				        finish();	
					}
				}
				catch (Exception e) {
					e.printStackTrace();
				}			
			}
			else{
				Toast.makeText(this, "에러", Toast.LENGTH_SHORT).show();
		    }		
			hideCenterProgress();
	        break ;		        
		}		
	}
	
	private void showAlertDialog(AlertDialog.Builder bld ){
    	AlertDialog alert = bld.create();  
    	alert.setTitle(R.string.alert_str);
    	alert.show(); 
    }
	
	@Override
	protected void onDestroy() {
		super.onDestroy();
	}
	
}

