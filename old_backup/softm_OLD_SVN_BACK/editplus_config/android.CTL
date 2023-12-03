#TITLE=android
#INFO
New Cliptext library
#SORT=n

#T===============================================
==============================================
#T=안드로이드 리소스 변수 선언 Array 
package arabiannight.tistroy.com;
 
import android.app.Activity;
import android.os.Bundle;
import android.text.Editable;
import android.text.TextWatcher;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;
 
public class TestTextWatcherActivity extends Activity {
     
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.main);
         
        setLayout();
         
        etTexts[EMAIL].addTextChangedListener(emailWatcher);
        etTexts[NAME].addTextChangedListener(nameWatcher);
        etTexts[PHONE].addTextChangedListener(phoneWatcher);
         
        for(Button b : btButtons){
            b.setEnabled(false);
        }
    }
 
    public void onButtonClick(View v){
        switch (v.getId()) {
        case R.id.et_box_01:
 
            break;
        case R.id.et_box_02:
 
            break;
        case R.id.et_box_03:
 
            break;
        case R.id.bt_confirm:
            if(btButtons[CONFIRM].isEnabled()){
                Toast.makeText(getApplicationContext(),
                        "EMAIL = " + etTexts[EMAIL].getText().toString() +
                        " 등록 되었습니다. , "+
                        "NAME = " + etTexts[NAME].getText().toString() +
                        " 등록 되었습니다. , "+
                        "PHONE = " + etTexts[PHONE].getText().toString() +
                        " 등록 되었습니다.",
                        Toast.LENGTH_SHORT).show();
            }else{
                Toast.makeText(getApplicationContext(), "모두 입력해 주십시오.",
                        Toast.LENGTH_SHORT).show();
            }
            break;
        }
    }
     
    private TextWatcher emailWatcher = new TextWatcher() {
        @Override
        public void onTextChanged(CharSequence s, int start, int before, int count) {
            if(s.length() > 0){
                btButtons[EMAIL].setEnabled(true);
            }else{
                btButtons[EMAIL].setEnabled(false);
            }
             
            setEnable(setButtonEnable(etTexts[EMAIL], etTexts[NAME], etTexts[PHONE]));
        }
        @Override
        public void beforeTextChanged(CharSequence s, int start, int count,
                int after) {
        }
        @Override
        public void afterTextChanged(Editable s) {
        }
    };
     
    private TextWatcher nameWatcher = new TextWatcher() {
        @Override
        public void onTextChanged(CharSequence s, int start, int before, int count) {
            if(s.length() > 0){
                btButtons[NAME].setEnabled(true);
            }else{
                btButtons[NAME].setEnabled(false);
            }
             
            setEnable(setButtonEnable(etTexts[EMAIL], etTexts[NAME], etTexts[PHONE]));
        }
        @Override
        public void beforeTextChanged(CharSequence s, int start, int count,
                int after) {
        }
        @Override
        public void afterTextChanged(Editable s) {
        }
    };
     
    private TextWatcher phoneWatcher = new TextWatcher() {
        @Override
        public void onTextChanged(CharSequence s, int start, int before, int count) {
            if(s.length() > 0){
                btButtons[PHONE].setEnabled(true);
            }else{
                btButtons[PHONE].setEnabled(false);
            }
             
            setEnable(setButtonEnable(etTexts[EMAIL], etTexts[NAME], etTexts[PHONE]));
        }
        @Override
        public void beforeTextChanged(CharSequence s, int start, int count,
                int after) {
        }
        @Override
        public void afterTextChanged(Editable s) {
        }
    };
     
    private void setEnable(boolean isEnable){
        btButtons[CONFIRM].setEnabled(isEnable);
    }
     
    private boolean setButtonEnable(EditText email, EditText name, EditText phone ) {
        boolean isAllFull =  false;
 
        if (email != null && name.length() > 0
                && name != null && name.length() > 0
                && phone != null && phone.length() > 0) {
            isAllFull = true;
        }
        return isAllFull;
    }
     
    private static final int EMAIL = 0;
    private static final int NAME = 1;
    private static final int PHONE = 2;
    private static final int CONFIRM = 3;
    private EditText[] etTexts;
    private Button[] btButtons;
     
    public void setLayout(){
        etTexts = new EditText[]{
                (EditText)findViewById(R.id.et_box_01),
                (EditText)findViewById(R.id.et_box_02),
                (EditText)findViewById(R.id.et_box_03)
        };
 
        btButtons = new Button[]{
                (Button)findViewById(R.id.bt_check_01),
                (Button)findViewById(R.id.bt_check_02),
                (Button)findViewById(R.id.bt_check_03),
                (Button) findViewById(R.id.bt_confirm)
        };
    }
}
#T===============================================
==============================================
#T=기본 클래스
package kr.co.gscaltex.gsnpoint.card;

import kr.co.gscaltex.gsnpoint.BaseActivity;
import kr.co.gscaltex.gsnpoint.DefaultApplication;
import kr.co.gscaltex.gsnpoint.NewMainMenu;
import kr.co.gscaltex.gsnpoint.R;
import kr.co.gscaltex.gsnpoint.TitleView;
import kr.co.gscaltex.gsnpoint.util.Debug;
import kr.co.gscaltex.gsnpoint.util.Util;
import android.os.Bundle;
import android.os.Handler;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;

public class CardRegView extends BaseActivity implements OnClickListener {
	String TAG = "GS";
	
	DefaultApplication mApp ;

	private String URL  = Util.DATA_CONNECT;
	private String KIND = "CARD";	
	private Handler handler = new Handler();

	/**
	 * LinearLayout 컨테이너 갯수
	 */
	public static final int CONTAINER_COUNT = 4;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.cardregister); 

		new TitleView(this, true, true, R.string.TITLE_TYPE_CARD,false);
		new NewMainMenu(this);

		setEventListener(); // 이벤트 핸들러 등록
		
        setContainerIndex(0); // 스텝0 이동		
	}
	
	/**
	 * 
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
		Debug.trace(TAG, "id :  "+ v.getId());
		switch (v.getId()) {

		case R.id.img_btn_newcard:
			Debug.trace(TAG, "img_btn_newcard - click");
            setContainerIndex(1); // 스텝1 이동
			break;
		case R.id.img_btn_step1_pre:
			Debug.trace(TAG, "img_btn_step1_pre - click");
            setContainerIndex(0); // 스텝0 이동
			break;
		case R.id.img_btn_step1_next:
			Debug.trace(TAG, "img_btn_step1_next - click");
            setContainerIndex(2); // 스텝2 선택
			break;

		case R.id.img_btn_step2_pre:
			Debug.trace(TAG, "img_btn_step2_pre - click");
            setContainerIndex(1); // 스텝1 이동
			break;
		case R.id.img_btn_step2_next:
			Debug.trace(TAG, "img_btn_step2_next - click");
            setContainerIndex(3); // 스텝3 선택
			break;
		case R.id.img_btn_step3_pre:
			Debug.trace(TAG, "img_btn_step3_pre - click");
            setContainerIndex(2); // 스텝3 이동
			break;
		case R.id.img_btn_step3_next:
			Debug.trace(TAG, "img_btn_step3_next - click");
//			Intent intent = new Intent(this, kr.co.gscaltex.gsnpoint.store.StoreRepresentView.class);
//			startActivity(intent);			
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
	    	Debug.trace(TAG, "uri+(i) : " + uri+(i));
	    	vContainer = ( ViewGroup ) findViewById(getResoureByStrId(uri+(i)));
	    	vContainer.setVisibility(View.GONE);
	    }
    	vContainer = ( ViewGroup ) findViewById(getResoureByStrId(uri+(selectIdx)));
    	vContainer.setVisibility(View.VISIBLE);
	}

	
	@Override
	protected void onDestroy() {
		super.onDestroy();
	}

	@Override
	protected void httpResult(int what, boolean result, String kind) {
		// TODO Auto-generated method stub
	}
}


#T=불투명 배경 Activity
^# AndroidManifest.xml
          <activity android:name=".card.CardRegView" android:theme="@android:style/Theme.Translucent.NoTitleBar"
        			android:screenOrientation="portrait"/>
^# JAVA
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        WindowManager.LayoutParams IpWindow = new WindowManager.LayoutParams();
        IpWindow.flags = WindowManager.LayoutParams.FLAG_DIM_BEHIND;
        IpWindow.dimAmount= 0.75f;
        getWindow().setAttributes(IpWindow);
        //requestWindowFeature(Window.FEATURE_NO_TITLE);
        setContentView(R.layout.cardregister);

#T=키보드 관련
FAQ : 프로그래밍적으로 키보드 숨김/감춤/보기. 액티비티 시작시 키보드 숨김/감춤/보기, EditText선택시 키보드 안뜨게하기 등 소프트 키보드 동작 관련 질문에 대한 답변

1. 키보드 감추기
EditText editText = (EditText) findViewById(R.id.myEdit);
InputMethodManager imm = (InputMethodManager)getSystemService(Context.INPUT_METHOD_SERVICE);
imm.hideSoftInputFromWindow(editText.getWindowToken(), 0);

2. 키보드 보여주기
EditText editText = (EditText) findViewById(R.id.myEdit);
InputMethodManager imm = (InputMethodManager) getSystemService(Context.INPUT_METHOD_SERVICE);
imm.showSoftInput(editText, InputMethodManager.SHOW_FORCED);

위 코드로 안보이는 경우 아래코드도 시도해보세요
- imm.showSoftInputFromInputMethod (editText .getApplicationWindowToken(),InputMethodManager.SHOW_FORCED);

onCreate등에서 제대로 동작하지 않는다면 
Handler로 post를 해서 위 코드를 실행시켜보세요.

3. 키보드 토글 - 위 두가지 방법으로 안되는 경우 다음과 같은 코드로 동작하는 경우가 있습니다.
imm.toggleSoftInputFromWindow(editText.getApplicationWindowToken(),  InputMethodManager.SHOW_FORCED, 0); 

4. 액티비티 시작시 자동으로 키보드 보여주기
AndroidManifest.xml의 activity 태그의 속성에 android:windowSoftInputMode="stateVisible" 혹은 "stateAlwaysVisible"삽입

5. 액티비티 시작시 자동으로 키보드 보여주지 않기
AndroidManifest.xml의 activity 태그의 속성에 android:windowSoftInputMode="stateHidden" 혹은 "stateAlwaysHidden" 삽입

6. 에디트 텍스트 선택해도 키보드 안뜨게 하기
EditText xml 속성에서 inputType 을 0으로 주면 안뜹니다.

반복되는 질문을 정리하는 FAQ 작업 진행중입니다. 키보드 동작 관련해서 정리할 글입니다. 
잘못된 부분이나 추가할 부분있으면 알려주세요.

=================================================== 

숫자만 입력해야 하는경우 숫자 키패드를 사용할 경우가 있습니다.

view source
print?
1.<edittext android:id="@+id/editTextAccountWriteActivityMoney" android:layout_width="240dip" android:layout_height="30dip" android:inputtype="number|phone" android:digits="1234567890"></edittext>
inputType의 number는 숫자만 입력하는 qwerty키보드이고, phone은 전화사용시 사용하는 키패드 입니다.

두개의 속성을 혼합하고, 아래의 digits속성으로 "0123456789"을 주면 숫자만입력되는 키패드를 사용하실 수 있습니
#T=Toast.makeText(this, "?????? ?????? ??????? ??????.\n??? ?Ŀ? ??? ?o??? ???y?.", Toast.LENGTH_SHORT).show();
				Toast.makeText(this, "?????? ?????? ??????? ??????.\n??? ?Ŀ? ??? ?o??? ???y?.", Toast.LENGTH_SHORT).show();
#T=implements OnClickListener {
	public class StoreMapView extends BaseMapActivity implements OnClickListener {
	public void onClick(View v) {
		// TODO Auto-generated method stub
		clickEvent(v);
	}
	
	private void clickEvent(View v) {
		AlertDialog.Builder alt_bld = new AlertDialog.Builder(this);  

		Debug.trace(TAG, "id :  "+ v.getId());
		switch (v.getId()) {
		case R.id.img_btn_allview: // 전체내용확인 - 버튼
			Debug.trace(TAG, "id : img_btn_allview "+ v.getId() );
			//Intent intent = new Intent(this, AgreementTermView.class);
			//startActivity(intent);			
			break;
		case R.id.img_btn_ok:      // 약관동의 확인 - 버튼
			Debug.trace(TAG, "id : img_btn_ok "+ v.getId() + " / checked : " + chkBoxAgreement.isChecked() );
	 		// 이용약관 동의 CheckBox
			if ( chkBoxAgreement.isChecked() ) {
				//AgreementView.this.activity.finish();
				callAgreement();
			} else {
				alt_bld.setMessage(R.string.alert_str_mobile_agreement)  
				.setCancelable(false) 
				.setPositiveButton("확인", new DialogInterface.OnClickListener() {					
					public void onClick(DialogInterface dialog, int which) {
					}
				});  				
				showAlertDialog(alt_bld);				 
			}
			break;
		case R.id.img_btn_cancel:  // 약관동의 취소 - 버튼
			finish();
			break;
		default:
			break;
		}
	}
#T=ImageButton - setOnClickListener
		// 약관동의 취소 - 버튼
		ImageButton imgBtnCancel = (ImageButton)view.findViewById(R.id.img_btn_cancel);
		imgBtnPointPresent.setOnClickListener(new View.OnClickListener() {
			public void onClick(View v) {
				Debug.trace(TAG,"Agreement Ok - onClick - "  + v) ;
				AgreementView.this.activity.finish();
				//Intent intent = new Intent(PointMineView.this.activity, Login.class);
				//PointMineView.this.activity.startActivity(intent);
			}
		});	
#T=배경 불투명 처리
Paint paint1 = new Paint();
paint1.setColor(Color.BLACK);
paint1.setAlpha(50);
findViewById(R.id.map_preventer).setBackgroundColor(paint1.getColor());

#T=Image Tab버튼 - select 처리
    private int mTabSelect = 0; // 상단 탭 인덱스
    public static final int TAB_BUTTON_COUNT = 5;
    private ImageButton[] mTabButtons = new ImageButton[TAB_BUTTON_COUNT];

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.cardregister);

        new TitleView(this, true, true, R.string.TITLE_TYPE_CARD,false);
        new NewMainMenu(this);

        setEventListener(); // 이벤트 핸들러 등록
    }

    /**
     * 상단 탭 - 이벤트 처리
     */
    private OnClickListener mTabMenuClick = new OnClickListener() {
        public void onClick(View v) {
            mTabSelect = v.getId();
            setTabpageIndex();
        }
    };

    /**
     * 이벤트 리스너를 설정합니다.
     */
    private void setEventListener() {
        // 상단탭 메뉴
        for (int i = 0; i < TAB_BUTTON_COUNT; i++) {
            String uri = "tab_store0";
            int imageResource = getResources().getIdentifier(uri+(i+1), "id", getPackageName());
            //Debug.trace(TAG, "img res id : " + imageResource);
            mTabButtons[i] = (ImageButton)findViewById(imageResource);
            mTabButtons[i].setId(i);
            mTabButtons[i].setOnClickListener(mTabMenuClick);
        }
        setTabpageIndex();

        // 이벤트 정의
        // ImageButton imgBtnPiOpen = (ImageButton)findViewById(R.id.img_btn_searcher_open );
        // imgBtnPiOpen.setOnClickListener(this);

    }

    /**
     * 상단 탭을 선택된 상태로 만듭니다.
     */
    private void setTabpageIndex() {
        for (int i = 0; i < TAB_BUTTON_COUNT; i++) {
            mTabButtons[i].setSelected(false);
        }
        mTabButtons[mTabSelect].setSelected(true);
    }
#T=public OnClickListener mTabMenuClick = new OnClickListener() {
	public OnClickListener mTabMenuClick = new OnClickListener() {
		@Override
		public void onClick(View v) {
			nSelectTab = v.getId();
			setTabpageIndex();
		}
	};
#T=Image Tab버튼 - select 처리
    private int mTabSelect = 0; // 상단 탭 인덱스
    public static final int TAB_BUTTON_COUNT = 5;
    private ImageButton[] mTabButtons = new ImageButton[TAB_BUTTON_COUNT];

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.cardregister);

        new TitleView(this, true, true, R.string.TITLE_TYPE_CARD,false);
        new NewMainMenu(this);

        setEventListener(); // 이벤트 핸들러 등록
    }

    /**
     * 상단 탭 - 이벤트 처리
     */
    private OnClickListener mTabMenuClick = new OnClickListener() {
        public void onClick(View v) {
            mTabSelect = v.getId();
            setTabpageIndex();
        }
    };

    /**
     * 이벤트 리스너를 설정합니다.
     */
    private void setEventListener() {
        // 상단탭 메뉴
        for (int i = 0; i < TAB_BUTTON_COUNT; i++) {
            String uri = "tab_store0";
            int imageResource = getResources().getIdentifier(uri+(i+1), "id", getPackageName());
            //Debug.trace(TAG, "img res id : " + imageResource);
            mTabButtons[i] = (ImageButton)findViewById(imageResource);
            mTabButtons[i].setId(i);
            mTabButtons[i].setOnClickListener(mTabMenuClick);
        }
        setTabpageIndex();

        // 이벤트 정의
        // ImageButton imgBtnPiOpen = (ImageButton)findViewById(R.id.img_btn_searcher_open );
        // imgBtnPiOpen.setOnClickListener(this);

    }

    /**
     * 상단 탭을 선택된 상태로 만듭니다.
     */
    private void setTabpageIndex() {
        for (int i = 0; i < TAB_BUTTON_COUNT; i++) {
            mTabButtons[i].setSelected(false);
        }
        mTabButtons[mTabSelect].setSelected(true);
    }
#T=SideDown,Up Animation
	public static void setLayoutAnim_slidedown(ViewGroup panel, Context ctx){
		AnimationSet set = new AnimationSet(true);
		Animation animation	= new AlphaAnimation(0.0f, 1.0f);
		animation.setDuration(1000);
		//set.addAnimation(animation);
		animation = new TranslateAnimation(
				Animation.RELATIVE_TO_SELF, 0.0f, Animation.RELATIVE_TO_SELF, 0.0f,
				Animation.RELATIVE_TO_SELF, -1.0f, Animation.RELATIVE_TO_SELF, 0.0f
				);
		animation.setDuration(500);
		set.addAnimation(animation);
		panel.startAnimation(set);
	}

	public static void setLayoutAnim_slideup(ViewGroup panel, Context ctx){
		AnimationSet set = new AnimationSet(true);
		Animation animation	= new AlphaAnimation(0.0f, 1.0f);
		animation.setDuration(1000);
		//set.addAnimation(animation);
		animation = new TranslateAnimation(
				Animation.RELATIVE_TO_SELF, 0.0f, Animation.RELATIVE_TO_SELF, 0.0f,
				Animation.RELATIVE_TO_SELF, 0.0f, Animation.RELATIVE_TO_SELF, -1.0f
				);

		animation.setDuration(500);
		set.addAnimation(animation);
		panel.startAnimation(set);
		//		  LayoutAnimationController controller =
		//	      new LayoutAnimationController(set, 0.0f);
		//		  panel.setLayoutAnimation(controller);    	
	}  
#T=SpinnerGS 
//	private String[] sidoItems = {"도/시", "서울","부산","대구","인천","광주","대전","울산","강원","경기","경남","경북","전남","전북","제주","충남","충북"};
//	private SpinnerGS mSpnSido = null;


-----------------------------
		mSpnSido= (SpinnerGS)findViewById(R.id.spn_sido);
		mSpnSido.addItems(sidoItems);
#T=Alert
	private void showAlert(int msg) {
		showAlert(msg, -1, null );
	}

	private void showAlert(String msg) {
		showAlert(msg, null, null );
	}
	private void showAlert(int msg, int buttonText) {
		showAlert(msg, buttonText, null );
	}

	private void showAlert(int msg, String buttonText) {
		showAlert(msg, buttonText, null );
	}

	private void showAlert(String msg, String buttonText) {
		showAlert(msg, buttonText, null );
	}

	private void showAlert(String msg, int buttonText) {
		showAlert(msg, buttonText, null );
	}
	private void showAlert(int msg, DialogInterface.OnClickListener onClick ){
		showAlert(msg, -1, onClick );
	}

	private void showAlert(String msg, DialogInterface.OnClickListener onClick ){
		showAlert(msg, -1, onClick );
	}

	private void showAlert(int msg, String buttonText, DialogInterface.OnClickListener onClick ){
		String strMsg    = getString(msg);
		showAlert(strMsg, buttonText, onClick );
	}

	private void showAlert(String msg, int buttonText, DialogInterface.OnClickListener onClick ){
		String strBtnTxt = buttonText!=-1?getString(buttonText):null;
		showAlert(msg, strBtnTxt, onClick );
	}

	private void showAlert(int msg, int buttonText, DialogInterface.OnClickListener onClick ){
		String strMsg    = getString(msg);
		String strBtnTxt = buttonText!=-1?getString(buttonText):null;
		showAlert(strMsg, strBtnTxt, onClick );
	}

	private void showAlert(String msg, String btnText, DialogInterface.OnClickListener onClick ) {
		String strBtnTxt = btnText != null?btnText:"확인";
		AlertDialog.Builder alt_bld = new AlertDialog.Builder(this);
		alt_bld.setTitle(R.string.alert_str);
		alt_bld.setMessage(msg);
		alt_bld.setCancelable(false).setPositiveButton(
				strBtnTxt,
				onClick != null ? onClick
						: new DialogInterface.OnClickListener() {
							public void onClick(DialogInterface dialog,
									int which) {
							}
						});
        alt_bld.show();
    }
#T=getResoureByStrId - 리소스 id String으로 리소스 int 얻기
	/**
	 * @param id resource id string
	 * @return int
	 * string id 로 Resource를 얻어옴.
	 */
	private int getResoureByStrId(String id) {
    	int containerResource = getResources().getIdentifier(id, "id", getPackageName());
    	return containerResource;
	}
#T=HashTable
						String itemNames[] = { "pk", "cardName", "cardNo", "cvc", "stopYn" };
						Hashtable<String, NodeList> items = new Hashtable<String, NodeList>();
						for (String nm : itemNames ) items.put(nm, order.getElementsByTagName(nm));
						if( items.get(itemNames[0]).getLength() > 0 )
						{
							int size = items.get(itemNames[0]).getLength();
						    for(int i = 0; i < size;i++ )
						    {
						        for (String nm : itemNames ) {
									Node item   = items.get(nm).item(i);						        	
						            String value= item.getFirstChild().getNodeValue();
						        }
						        //JSONObject
						        
							    mCurrentAdapter.addItem(new CardRegTextItem(String.valueOf((i+1)+(mCurrentAdapter.getPage()-1)*5),
	                                    Date ,Title , PK));
						    }
						    mCurrentAdapter.notifyDataSetChanged();

						}
#T=overridePendingTransition(R.anim.push_right_in, R.anim.push_right_out);
overridePendingTransition(R.anim.push_right_in, R.anim.push_right_out);

#T=향상된 for (NameValuePair i : nParams) {


import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.UnsupportedEncodingException;
import java.net.URLDecoder;
import java.util.ArrayList;
import java.util.List;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.HttpClient;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.apache.http.params.BasicHttpParams;
import org.apache.http.params.CoreProtocolPNames;
import org.apache.http.params.HttpParams;

public class testEncode {

	/**
	 * @param args
	 */
	public static void main(String[] args) {
		String a = "abcdefg";
		try {
			System.out.println("a : " + a );	
			System.out.println("a : " + URLDecoder.decode(a,"UTF-8") );
			HttpClient httpclient = new DefaultHttpClient();
			httpclient.getParams().setParameter("http.socket.timeout", new Integer(10000));
			 
//			HttpPost httppost = new HttpPost("http://http://203.245.106.144:8240/renewal/ServerStart");
			HttpPost httppost = new HttpPost("http://203.245.106.146:8240/renewal/ServerStart");
			HttpResponse response;
			
			try {
				List<NameValuePair> nParams = new ArrayList<NameValuePair>(2);
				
				//rdo=GB&in_crd_no=0190610009890875&cvc=ucACYsYcAF1PJkKwFqEOvg==&cuskey2=Qi7W40U+FgPZhOdhXxrKMQ==&cuskey1=xGd+2owoTrMV2FeZxr3pTg==&userid=npt81
				nParams.add(new BasicNameValuePair("process_code", "startUp"));
//				nParams.add(new BasicNameValuePair("cuskey1", "1"));
//				nParams.add(new BasicNameValuePair("cuskey2", "2"));
				
				httppost.setHeader("Content-Type", "application/x-www-form-urlencoded");
				HttpParams httpParams = new BasicHttpParams();
				httpParams.setParameter("title", "message");

				
				httpclient.getParams().setParameter(CoreProtocolPNames.USER_AGENT, "Client1");
			    ArrayList<Integer> list = new ArrayList<Integer>();

				for (NameValuePair i : nParams) {
					httpParams.setParameter("title", "message");
					httpParams.setParameter(i.getName(), i.getValue());
					System.out.println("NameValuePair : " + i.getName() + " / " + i.getValue());
			    }
			    httppost.setParams(httpParams);
				
				response = httpclient.execute(httppost);	
				HttpEntity entity = response.getEntity();			
				if (entity == null) {
				}else{
					if(entity != null){
						InputStream inputStream = entity.getContent();		
						String xml_string = convertStreamToString(inputStream);
						System.out.println(xml_string) ;
						
						httpclient.getConnectionManager().shutdown();
					}
				}
			} catch (Exception e) {

			}
			

		    
		} catch (UnsupportedEncodingException e) {
			e.printStackTrace();
		}
	}
	private static String convertStreamToString(InputStream is) {
		StringBuilder stringBuilder = new StringBuilder();
		
		try {			 
			 BufferedReader reader = new BufferedReader(new InputStreamReader(is,"UTF-8"));			 
			 String line = null;
		  
			 while ((line = reader.readLine()) != null) {
				 stringBuilder.append(line+"\n");
			 }
			 is.close();
			 return stringBuilder.toString();
		 }catch (IOException e) {
			 e.printStackTrace();
			 return "";
		 }
	}	
}

#T=List<String> list = new ArrayList<String>();
package com.mkyong.core;
 
import java.util.ArrayList;
import java.util.Iterator;
import java.util.List;
 
public class ArrayListLoopingExample {
	public static void main(String[] args) {
 
		List<String> list = new ArrayList<String>();
		list.add("Text 1");
		list.add("Text 2");
		list.add("Text 3");
 
		System.out.println("#1 normal for loop");
		for (int i = 0; i < list.size(); i++) {
			System.out.println(list.get(i));
		}
 
		System.out.println("#2 advance for loop");
		for (String temp : list) {
			System.out.println(temp);
		}
 
		System.out.println("#3 while loop");
		int j = 0;
		while (list.size() > j) {
			System.out.println(list.get(j));
			j++;
		}
 
		System.out.println("#4 iterator");
		Iterator<String> iterator = list.iterator();
		while (iterator.hasNext()) {
			System.out.println(iterator.next());
		}
	}
}
#T=외부에서 list의 하위아이템 얻기
						View itemView=(View)PointListview.getChildAt(0);
						if ( helpBtnEval != null ) appHelper.remove(helpBtnEval);
						if ( itemView != null ) {
							helpBtnEval = itemView.findViewById(0);
							if ( helpBtnEval != null ) appHelper.add(helpBtnEval,R.drawable.guide_guide03_ex03,GSAppHelper.POSITION_LEFT_TOP);
						}	
#T===============================================
==============================================
#T=<?xml version="1.0" encoding="utf-8"?>
<?xml version="1.0" encoding="utf-8"?>
#T=== LAYOUT ====================================
========= LAYOUT ====================================
#T=<FrameLayout
<FrameLayout
    android:id="@+id/main_container"
    android:layout_width="fill_parent"
    android:layout_height="0dp"
    android:layout_weight="1" 
>
^!
</FrameLayout>
#T=<LinearLayout
<LinearLayout
    android:layout_width="fill_parent"
    android:layout_height="wrap_content"
    android:gravity="center_horizontal"
    android:orientation="vertical"
>
^!
</LinearLayout>
#T=<RelativeLayout
<RelativeLayout
    android:layout_width="fill_parent"
    android:layout_height="wrap_content" >
^!
</RelativeLayout?>
#T=<ScrollView 
<ScrollView 
    android:layout_width="fill_parent"
    android:layout_height="fill_parent"
    android:background="#FFFFFFFF">
^!
</ScrollView>
#T=<ViewFlipper
<ViewFlipper
    android:id="@+id/viewFlipper"
    android:layout_width="wrap_content" 
    android:layout_height="wrap_content"
    android:layout_centerHorizontal="true">
^!
</ViewFlipper>
#T=<ListView
<ListView
    android:id="@id/android:list"
    style="?android:attr/listViewStyle"
    android:background="#ffffff"
    android:drawSelectorOnTop="false"
    android:scrollingCache="false"
    android:divider="#d8d9d8"
    android:dividerHeight="1px"
    android:cacheColorHint="#00000000"
    android:layout_width="fill_parent" 
    android:layout_height="70dp" />
^!
</ListView>
#T=<WebView
<WebView
    android:id="@+id/webview_browser" 
    android:layout_width="fill_parent"
    android:layout_height="fill_parent" /> 
#T=<include
<include
    android:layout_width="fill_parent"
    android:layout_height="wrap_content"
    layout="@layout/n_main_menu" />

#T=== View ====================================
== View ====================================
#T=<ImageButton
<ImageButton
    android:id="@+id/img_btn_stop"
    android:layout_width="wrap_content"
    android:layout_height="wrap_content"
    android:layout_gravity="center_vertical"
    android:background="@drawable/btn_stop" />

#T=<ImageView
<ImageView
    android:layout_width="wrap_content"
    android:layout_height="wrap_content"
    android:layout_gravity="center_vertical"
    android:src="@drawable/icon_star_gray"/>

#T=<EditText
<EditText
    android:id="@+id/edt_search_name"
    android:layout_width="wrap_content"
    android:layout_height="wrap_content"
    android:layout_gravity="center_vertical"
    android:layout_marginLeft="8px"
    android:layout_weight="0.8"
    android:background="@drawable/gs_editbox_img"
    android:hint="@string/addr_search_keyword_hint"
    android:textSize="12sp" />
#T=<TextView
<TextView
    android:layout_width="wrap_content"
    android:layout_height="wrap_content"
    android:layout_gravity="center_vertical"
    android:layout_marginTop="6dip"
    android:text="총 "
    android:textSize="13dip"/>

#T=<CheckBox
<CheckBox
    android:id="@+id/chk_agreement"                
    android:layout_width="wrap_content"
    android:layout_height="wrap_content"
    android:layout_gravity="center_vertical"
    android:button="@drawable/gs_checkbox_img"
    android:paddingLeft="30dp"/>
#T=<ProgressBar
<ProgressBar
    android:id="@+id/progress_bar"
    style="?android:attr/progressBarStyleInverse"
    android:layout_width="wrap_content"
    android:layout_height="wrap_content"
    android:layout_gravity="center_vertical|center_horizontal"
    android:visibility="gone" />

#T=<kr.co.gscaltex.gsnpoint.SpinnerGS
<kr.co.gscaltex.gsnpoint.SpinnerGS
    android:id="@+id/spn_sido"
    android:layout_width="wrap_content"
    android:layout_height="wrap_content"
    android:layout_weight="1"
    android:prompt="@string/addr_sido" />

#T=== 속성 ====================================
== 속성 ====================================
#T=    android:id="@+id/title_bg"
    android:id="@+id/title_bg"

#T=    android:layout_width="wrap_content"
    android:layout_width="wrap_content"

#T=    android:layout_height="wrap_content"
    android:layout_height="wrap_content"

#T=    android:layout_weight="1"
    android:layout_weight="1"

#T=    android:gravity="center_horizontal"
    android:gravity="center_horizontal"
#T=    android:orientation="vertical"
    android:orientation="vertical"

#T=    android:orientation="horizontal"
    android:orientation="horizontal"

#T=    android:background="#FF0000"
    android:background="#FF0000"

#T=    android:layout_marginTop="20px"
    android:layout_marginTop="20^!px"
#T=    android:layout_marginLeft="20px"
    android:layout_marginLeft="20^!px"
#T=    android:layout_marginRight="20px"
    android:layout_marginRight="20^!px"
#T=    android:layout_marginBottom="20px"
    android:layout_marginBottom="20^!px"

#T=== 속성 - 텍스트 ====================================
== 속성 - 텍스트 ====================================
#T=    android:text="1"
    android:text="1"

#T=    android:textColor="#FF7200"
    android:textColor="#FF7200"

#T=    android:textSize="18dip" 
    android:textSize="18dip" 

#