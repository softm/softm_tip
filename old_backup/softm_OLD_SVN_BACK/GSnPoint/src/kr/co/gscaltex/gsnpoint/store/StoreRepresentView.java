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
import android.widget.ImageButton;
import android.widget.ImageView;

public class StoreRepresentView extends BaseWebActivity implements OnClickListener{
	String TAG = "GS";
	
	private FileInfo fi = new FileInfo();
	private boolean m_bLogin = false;
	
	private ImageView ivLoadingImage = null ;
	private ImageButton mBtnMapview = null;
	
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.storelist_viewer);
		String URL = fi.getSettingInfo(getBaseContext(),FileInfo.STORE_URL); // 대표가맹점 jsp url

		Bundle extras = getIntent().getExtras();
		if(extras!=null)
			m_bLogin = extras.getBoolean("login");
		
		new TitleView(this,true,true,R.string.TITLE_TYPE_STORE_REPRESENT, m_bLogin); 
		new NewMainMenu(this);

		ivLoadingImage = (ImageView)findViewById(R.id.loading_image) ;
		
		mBtnMapview =(ImageButton)findViewById(R.id.btn_mapview);
		mBtnMapview.setOnClickListener(this);
		
		loadUrl(URL);
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
		switch (v.getId()) {
		case R.id.btn_mapview: 	// present button
			finish();
	         break;
		}
		
	}
}