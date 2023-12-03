package kr.co.gscaltex.gsnpoint.store;

import java.util.HashMap;

import kr.co.gscaltex.gsnpoint.BaseWebActivity;
import kr.co.gscaltex.gsnpoint.NewMainMenu;
import kr.co.gscaltex.gsnpoint.R;
import kr.co.gscaltex.gsnpoint.TitleView;
import kr.co.gscaltex.gsnpoint.util.FileInfo;
import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.ImageView;

public class StoreMapDetail extends BaseWebActivity implements OnClickListener{
	String TAG = "GS";
	
	private FileInfo fi = new FileInfo();
	private boolean m_bLogin = false;
	private String Frch_cd, Cco_cd= null;
	
	private ImageView ivLoadingImage = null ;
	
	
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.web_viewer);
		String URL = fi.getSettingInfo(getBaseContext(),FileInfo.STORE_DETAIL_URL); // 대표가맹점 jsp url

		Bundle extras = getIntent().getExtras();
		if(extras!=null){
			m_bLogin = extras.getBoolean("login");
			Frch_cd = extras.getString("Frch_cd");
			Cco_cd = extras.getString("Cco_cd");
		}
		
		new TitleView(this,true,true,R.string.TITLE_TYPE_STORE_REPRESENT, m_bLogin); 
		new NewMainMenu(this);

		ivLoadingImage = (ImageView)findViewById(R.id.loading_image) ;
		//String URL = fi.getSettingInfo(this, FileInfo.STORE_DETAIL_URL);
		//if(URL.equals("")) URL = f.STORE_DETAIL_URL ;
		
		if (URL == null || URL.equals("")) {
			AlertDialogMsg(R.string.network_error);
		}
		else {
			
			String url = URL + "?fcd=" + Frch_cd + "&cco_cd=" + Cco_cd;
			loadUrl(url);
		}		
	} 

	protected void webViewEvent(int what, boolean result, HashMap<String,Object> param) {
		// TODO Auto-generated method stub
		switch(what) {
		case 0 : 
			ivLoadingImage.setVisibility(ImageView.GONE) ;
			break ;
			
		case 1 :
			
			break ;  
			
		case 900 : 
			
			 break ;
		}
		
	}

	public void onClick(View v) {
		// TODO Auto-generated method stub
				
	}
}