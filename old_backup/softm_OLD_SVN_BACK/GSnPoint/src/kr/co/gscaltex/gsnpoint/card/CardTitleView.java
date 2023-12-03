package kr.co.gscaltex.gsnpoint.card;

import kr.co.gscaltex.gsnpoint.R;
import kr.co.gscaltex.gsnpoint.setting.SettingMainView;
import android.app.Activity;
import android.content.Intent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.FrameLayout;
import android.widget.ImageButton;

public class CardTitleView {
	private Activity activity;
	String TAG = "GS" ;
	
	private boolean m_bLogin = false;

	public CardTitleView(Activity activity) {
		this.activity = activity;
		ViewGroup group = (ViewGroup)activity.findViewById(R.id.main_viewgroup);
		if ( group == null ) {
			group = (ViewGroup) getContentView(activity.getWindow().getDecorView());
		}
		initLayout(activity, group, true, true, false, true);
	}
	
	public CardTitleView(Activity activity, boolean bSetBtn, boolean bResetBtn, boolean bHelpBtn, boolean bLogoBtn, boolean bLogin) {
		this.activity = activity;
		this.m_bLogin = bLogin;
		ViewGroup group = (ViewGroup)activity.findViewById(R.id.main_viewgroup);
		if ( group == null ) {
			group = (ViewGroup) getContentView(activity.getWindow().getDecorView());
		}
		initLayout(activity, group, bSetBtn, bResetBtn, bHelpBtn, bLogoBtn );
	}

	private void initLayout(Activity activity, ViewGroup group, boolean bSetBtn, boolean bResetBtn, boolean bHelpBtn, boolean bLogoBtn) {
		LayoutInflater layout = activity.getLayoutInflater();
		View view = layout.inflate(R.layout.cardtitle, null);
		
		ImageButton imgBtnSet = (ImageButton)view.findViewById(R.id.set_button);
		ImageButton imgBtnReset = (ImageButton)view.findViewById(R.id.reset_button);
		ImageButton imgBtnHelp = (ImageButton)view.findViewById(R.id.help_button);
		ImageButton imgBtnLogo = (ImageButton)view.findViewById(R.id.logo_button);
		
		
		imgBtnSet.setOnClickListener(new View.OnClickListener() {
			public void onClick(View v) {
				Intent intent = new Intent(CardTitleView.this.activity, SettingMainView.class);
				intent.putExtra("login", m_bLogin) ;
				intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
				CardTitleView.this.activity.startActivity(intent);
			}
		});
		imgBtnHelp.setOnClickListener(new View.OnClickListener() {
			public void onClick(View v) {
			}
		});
		if ( !bHelpBtn ) imgBtnHelp.setVisibility(Button.INVISIBLE);
		
		//group.addView(view, 0);
	}

	private ViewGroup getContentView(View parent) {
		ViewGroup view = null;

		if (parent instanceof ViewGroup) {
			ViewGroup group = (ViewGroup)parent;
			if (group.getClass().equals(FrameLayout.class)) {
				return (ViewGroup)group.getChildAt(0);
			}
			else {
				for (int i = 0; i < group.getChildCount(); i++) {
					view = getContentView(group.getChildAt(i));
				}
			}
		}

		return view;
	}
}
