package kr.co.gscaltex.gsnpoint.setting;

import java.util.HashMap;

import kr.co.gscaltex.gsnpoint.BaseWebActivity;
import kr.co.gscaltex.gsnpoint.NewMainMenu;
import kr.co.gscaltex.gsnpoint.R;
import kr.co.gscaltex.gsnpoint.TitleView;
import kr.co.gscaltex.gsnpoint.card.CardMainView;
import kr.co.gscaltex.gsnpoint.util.FileInfo;
import android.content.Intent;
import android.os.Bundle;
import android.widget.ImageView;

public class SettingMemberUpdateView extends BaseWebActivity {
	private ImageView ivLoadingImage = null ;
	private FileInfo fi = new FileInfo();
	TitleView titleView = null;
	
	private boolean m_bLogin = false;
	
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.web_viewer);

		String URL = fi.getSettingInfo(getBaseContext(),FileInfo.MEMBER_UPDATE_URL); // 회원정보수정 jsp url - sso login
		URL += "?id=" + fi.getSettingInfo(this, FileInfo.ID);
		Bundle extras = getIntent().getExtras();
		if(extras!=null)
			m_bLogin = extras.getBoolean("login");
		
		titleView = new TitleView(this,true,false,R.string.TITLE_TYPE_SETTING_JOIN_MODIFY, m_bLogin); 
		new NewMainMenu(this);

		ivLoadingImage = (ImageView)findViewById(R.id.loading_image) ;
		//ivLoadingImage.setBackgroundResource(R.drawable.login_blank) ;
		//ivLoadingImage.setVisibility(ImageView.VISIBLE) ;
		
		loadUrl(URL);
	} 

	protected void webViewEvent(int what, boolean result, HashMap<String,Object> param) {
		// TODO Auto-generated method stub
		switch(what) {
		case 0 : 
			ivLoadingImage.setVisibility(ImageView.GONE) ;
			break ;
			
			
			case 2 : 
				String url = (String) param.get("url");
				// 호출 페이지 URL에 따라 타이틀을 변경한다.
				int titleType = getTitleType(url);
				
				if(titleType>0) {
					titleView.setLayout(true, true, titleType, m_bLogin);
				}
				
				break ;
			case R.string.TITLE_TYPE_CARD: // goHome
				Intent intent = new Intent(this, CardMainView.class);
				intent.putExtra("login", m_bLogin);
				intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
				startActivity(intent);
				break;
		}
	}
	
	
	
	private int getTitleType(String url) {
		
		int titleType = -1;
		
		if(url.indexOf("/gsmobilenpass/memberEdit.do")>0){ // 회원정보수정
			titleType = R.string.TITLE_TYPE_SETTING_JOIN_MODIFY;
			
		}
		
		return titleType;
	}
}