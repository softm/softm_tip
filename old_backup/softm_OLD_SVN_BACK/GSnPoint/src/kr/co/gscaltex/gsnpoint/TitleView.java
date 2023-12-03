package kr.co.gscaltex.gsnpoint;

import kr.co.gscaltex.gsnpoint.qr.CaptureActivity;
import kr.co.gscaltex.gsnpoint.qr.QRCodeListActivity;
import kr.co.gscaltex.gsnpoint.setting.SettingMainView;
import kr.co.gscaltex.gsnpoint.util.GSActivityManager;
import android.app.Activity;
import android.content.Intent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.FrameLayout;
import android.widget.ImageButton;
import android.widget.RelativeLayout;

public class TitleView {
	private Activity activity;
	private DefaultApplication mApplication;
	private String TAG = "GS" ;
	private boolean m_bLogin = false;

	public TitleView(Activity activity) {
		this.activity = activity;
		ViewGroup group = (ViewGroup)activity.findViewById(R.id.main_viewgroup);
		if ( group == null ) {
			group = (ViewGroup) getContentView(activity.getWindow().getDecorView());
		}
		
		initLayout(activity, group, true, true, false, 0);
	}
	
	public TitleView(Activity activity, boolean bLeftButtonVisible, boolean bRightButtonVisible, int nType, boolean bLogin) {
		//int nType = Integer.valueOf(strType).intValue();
		this.activity = activity;
		this.m_bLogin = bLogin;
		ViewGroup group = (ViewGroup)activity.findViewById(R.id.main_viewgroup);
		if ( group == null ) {
			group = (ViewGroup) getContentView(activity.getWindow().getDecorView());

			if(activity.getString(nType).equals("71")) {
				group = CaptureActivity.mRotateView;
			}	
		}
		
		initLayout(activity, group, bLeftButtonVisible, bRightButtonVisible, false, nType);
	}
	
	
	public TitleView(Activity activity, boolean bLeftButtonVisible, boolean bRightButtonVisible,  boolean bHelpButtonVisible, int nType, boolean bLogin) {
		//int nType = Integer.valueOf(strType).intValue();
		this.activity = activity;
		this.m_bLogin = bLogin;
		ViewGroup group = (ViewGroup)activity.findViewById(R.id.main_viewgroup);
		if ( group == null ) {
			group = (ViewGroup) getContentView(activity.getWindow().getDecorView());
		}
		initLayout(activity, group, bLeftButtonVisible, bHelpButtonVisible, bRightButtonVisible, nType);
	}
	
	private void initLayout(Activity activity, ViewGroup group, boolean bLeft,boolean bRight,  boolean bHelp, int nType) {
		LayoutInflater layout = activity.getLayoutInflater();
		View view = layout.inflate(R.layout.title, null);
		mApplication = (DefaultApplication)activity.getApplicationContext();
		
		RelativeLayout relativeTitle_bg = (RelativeLayout)view.findViewById(R.id.title_bg);
		ImageButton imgBtnLeft  = (ImageButton)view.findViewById(R.id.left_button);
		ImageButton imgBtnRight = (ImageButton)view.findViewById(R.id.right_button);
		ImageButton imgBtnHelp  = (ImageButton)view.findViewById(R.id.help_button);
		boolean bDefaultType = true;
		
		int resId = 0;
		
		if(nType == R.string.TITLE_TYPE_LOG_IN)
			resId = R.drawable.title_set_login;
		else if(nType == R.string.TITLE_TYPE_SETTING)
			resId = R.drawable.title_set_set;
		else if(nType == R.string.TITLE_TYPE_SETTING_AUTOLOGIN)
			resId = R.drawable.title_set_set;
		else if(nType == R.string.TITLE_TYPE_CARD)
			resId = R.drawable.title_card;
		else if(nType == R.string.TITLE_TYPE_POINT)
			resId = R.drawable.title_point;
		else if(nType == R.string.TITLE_TYPE_POINT_PRESENT)
			resId = R.drawable.title_point;
		else if(nType == R.string.TITLE_TYPE_STORE)
			resId = R.drawable.title_store_store;
		else if(nType == R.string.TITLE_TYPE_SETTING_PASSWORD)
			resId = R.drawable.title_set_pwset;
		else if(nType == R.string.TITLE_TYPE_SETTING_PASSWORD_CHECK)
			resId = R.drawable.title_set_pwset_confirm;
		else if(nType == R.string.TITLE_TYPE_SETTING_MAIN_IMAGE)
			resId = R.drawable.title_set_mainimg;
		else if(nType == R.string.TITLE_TYPE_SETTING_JOIN)
			resId = R.drawable.title_set_join;
		else if(nType == R.string.TITLE_TYPE_SETTING_NOTICE)
			resId = R.drawable.title_set_notice;
		else if(nType ==R.string.TITLE_TYPE_GUIDE_POINT_CARD)
			resId = R.drawable.title_guide_pointcard;
		else if(nType == R.string.TITLE_TYPE_GUIDE)
			resId = R.drawable.title_guide_infomation;
		else if(nType == R.string.TITLE_TYPE_BARCORD)
			resId = R.drawable.title_card_barcode;
		else if(nType == R.string.TITLE_TYPE_QRSCAN || nType == R.string.TITLE_TYPE_QRSCAN_ROTATE)
			resId = R.drawable.title_guide_qrscan;
		else if(nType == R.string.TITLE_TYPE_SETTING_JOIN_MODIFY)
			resId = R.drawable.title_set_joinmodify;
		
		relativeTitle_bg.setBackgroundResource(resId);
		
		switch(nType) {
		
		case R.string.TITLE_TYPE_SETTING_PASSWORD :
		case R.string.TITLE_TYPE_SETTING_MAIN_IMAGE :
		case R.string.TITLE_TYPE_SETTING_NOTICE :
		case R.string.TITLE_TYPE_GUIDE_POINT_CARD : 
		case R.string.TITLE_TYPE_SETTING_AUTOLOGIN : 
		case R.string.TITLE_TYPE_SETTING_JOIN_MODIFY:
			
			imgBtnLeft.setImageResource(R.drawable.btn_set_prev_img);
			imgBtnRight.setImageResource(R.drawable.btn_set_set_img);
			
			imgBtnLeft.setOnClickListener(new View.OnClickListener() {
				public void onClick(View v) {
					TitleView.this.activity.finish();
				}
			});
			
			imgBtnRight.setOnClickListener(new View.OnClickListener() {
				public void onClick(View v) {
					Intent intent = new Intent(TitleView.this.activity, SettingMainView.class);
					intent.putExtra("login", m_bLogin) ;
					intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
					mApplication.selectedIndex=99;
					TitleView.this.activity.startActivity(intent);
					TitleView.this.activity.finish();
				}
			});
			break;
			
				
		case R.string.TITLE_TYPE_QRSCAN_ROTATE :
		case R.string.TITLE_TYPE_QRSCAN :
			imgBtnLeft.setImageResource(R.drawable.btn_set_prev_img);
			imgBtnRight.setImageResource(R.drawable.btn_set_reset_img);
			
			imgBtnLeft.setOnClickListener(new View.OnClickListener() {
				public void onClick(View v) {
					TitleView.this.activity.finish();
				}
			});
			
			imgBtnRight.setOnClickListener(new View.OnClickListener() {
				public void onClick(View v) {
				}
			});
			break;
			
		case R.string.TITLE_TYPE_LOG_IN :
		case R.string.TITLE_TYPE_SETTING :
		case R.string.TITLE_TYPE_SETTING_JOIN :
		case R.string.TITLE_TYPE_GUIDE : 
				
			imgBtnLeft.setImageResource(R.drawable.btn_set_home_img);
			imgBtnRight.setImageResource(R.drawable.btn_set_set_img);
			
			imgBtnLeft.setOnClickListener(new View.OnClickListener() {
				public void onClick(View v) {
					Intent intent = new Intent(TitleView.this.activity, kr.co.gscaltex.gsnpoint.card.CardMainView.class);
					intent.putExtra("login", m_bLogin) ;
					intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
					mApplication.selectedIndex=0;
					GSActivityManager.getActivityManager().finishAllActivity(null);
					TitleView.this.activity.startActivity(intent);
				}
			});
			
			imgBtnRight.setOnClickListener(new View.OnClickListener() {
				public void onClick(View v) {
					Intent intent = new Intent(TitleView.this.activity, SettingMainView.class);
					intent.putExtra("login", m_bLogin) ;
					intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
					mApplication.selectedIndex=99;
					TitleView.this.activity.startActivity(intent);
					TitleView.this.activity.finish();
				}
			});
			break;
		case R.string.TITLE_TYPE_CARD : // softm
			imgBtnLeft.setImageResource(R.drawable.btn_card_prev_img);
			imgBtnRight.setImageResource(R.drawable.btn_card_set_img);
			imgBtnHelp.setImageResource(R.drawable.btn_card_help_img);
			
			imgBtnLeft.setOnClickListener(new View.OnClickListener() {
				public void onClick(View v) {
					if(TitleView.this.activity instanceof BaseActivity){
						TitleView.this.activity.finish();
					}
				}
			});
			
			imgBtnRight.setOnClickListener(new View.OnClickListener() {
				public void onClick(View v) {
					Intent intent = new Intent(TitleView.this.activity, SettingMainView.class);
					intent.putExtra("login", m_bLogin) ;
					intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
					mApplication.selectedIndex=99;
					TitleView.this.activity.startActivity(intent);
					TitleView.this.activity.finish();
				}
			});
			
			break;	
		case R.string.TITLE_TYPE_POINT : // softm
			imgBtnLeft.setImageResource(R.drawable.btn_point_home_img);
			imgBtnRight.setImageResource(R.drawable.btn_point_set_img);
			imgBtnHelp.setImageResource(R.drawable.btn_point_help_img);
			imgBtnLeft.setOnClickListener(new View.OnClickListener() {
				public void onClick(View v) {
					Intent intent = new Intent(TitleView.this.activity, kr.co.gscaltex.gsnpoint.card.CardMainView.class);
					intent.putExtra("login", true) ;
					intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
					mApplication.selectedIndex=0;
					GSActivityManager.getActivityManager().finishAllActivity(null);
					TitleView.this.activity.startActivity(intent);
					
				}
			});
			
			imgBtnRight.setOnClickListener(new View.OnClickListener() {
				public void onClick(View v) {
					Intent intent = new Intent(TitleView.this.activity, SettingMainView.class);
					intent.putExtra("login", m_bLogin) ;
					intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
					mApplication.selectedIndex=99;
					TitleView.this.activity.startActivity(intent);
					TitleView.this.activity.finish();
				}
			});
			
			break;	
			
		case R.string.TITLE_TYPE_POINT_PRESENT : // softm
				imgBtnLeft.setImageResource(R.drawable.btn_point_prev_img);
				imgBtnRight.setImageResource(R.drawable.btn_point_set_img);
				
				imgBtnLeft.setOnClickListener(new View.OnClickListener() {
					public void onClick(View v) {
						TitleView.this.activity.finish();
					}
				});
				
				imgBtnRight.setOnClickListener(new View.OnClickListener() {
					public void onClick(View v) {
						Intent intent = new Intent(TitleView.this.activity, SettingMainView.class);
						intent.putExtra("login", m_bLogin) ;
						intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
						mApplication.selectedIndex=99;
						TitleView.this.activity.startActivity(intent);
						TitleView.this.activity.finish();
					}
				});
				
				break;		
			
		case R.string.TITLE_TYPE_STORE: 
			imgBtnLeft.setImageResource(R.drawable.btn_store_home_img);
			imgBtnRight.setImageResource(R.drawable.btn_store_set_img);
			imgBtnHelp.setImageResource(R.drawable.btn_store_help_img);
			imgBtnLeft.setOnClickListener(new View.OnClickListener() {
				public void onClick(View v) {
					Intent intent = new Intent(TitleView.this.activity, kr.co.gscaltex.gsnpoint.card.CardMainView.class);
					intent.putExtra("login", m_bLogin) ;
					intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
					mApplication.selectedIndex=0;
					GSActivityManager.getActivityManager().finishAllActivity(null);
					TitleView.this.activity.startActivity(intent);
				}
			});
			
			imgBtnRight.setOnClickListener(new View.OnClickListener() {
				public void onClick(View v) {
					Intent intent = new Intent(TitleView.this.activity, SettingMainView.class);
					intent.putExtra("login", m_bLogin) ;
					intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
					mApplication.selectedIndex=99;
					TitleView.this.activity.startActivity(intent);
					TitleView.this.activity.finish();
				}
			});
			break;	
			
		case R.string.TITLE_TYPE_SETTING_PASSWORD_CHECK:
			break;
		case R.string.TITLE_TYPE_BARCORD : 
			imgBtnLeft.setImageResource(R.drawable.btn_card_prev_img);
			imgBtnRight.setImageResource(R.drawable.btn_card_set_img);
						
			imgBtnLeft.setOnClickListener(new View.OnClickListener() {
				public void onClick(View v) {
					TitleView.this.activity.finish();
				}
			});
			
			imgBtnRight.setOnClickListener(new View.OnClickListener() {
				public void onClick(View v) {
					Intent intent = new Intent(TitleView.this.activity, SettingMainView.class);
					intent.putExtra("login", m_bLogin) ;
					intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
					mApplication.selectedIndex=99;
					TitleView.this.activity.startActivity(intent);
					TitleView.this.activity.finish();
				}
			});
			break;
		default:
			bDefaultType = false;
			break;
		}
		if( !bLeft) {
			imgBtnLeft.setVisibility(ImageButton.INVISIBLE);
		}
		if( !bRight) {
			imgBtnRight.setVisibility(ImageButton.INVISIBLE);
		}
		if( !bHelp ) {
			imgBtnHelp.setVisibility(ImageButton.INVISIBLE);
		}

		group.addView(view, 0);
		if( bHelp ) {
			
			imgBtnHelp.setOnClickListener(new View.OnClickListener() {
				public void onClick(View v) {
					if ( TitleView.this.activity instanceof BaseActivity ) {
						BaseActivity a = (BaseActivity) TitleView.this.activity;					
						a.getAppHelper().showHelp();
					} else if ( TitleView.this.activity instanceof BaseMapActivity ) {
						BaseMapActivity a = (BaseMapActivity) TitleView.this.activity;					
						a.getAppHelper().showHelp();						
					}
				}
			});
		}	
		// switch default를 안타면
		if ( !bDefaultType ) setLayout(bLeft, bRight, nType, m_bLogin);			
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
	
	public void setLayout(boolean bLeftButtonVisible, boolean bRightButtonVisible, int nType, boolean bLogin){
		setLayout(bLeftButtonVisible,bRightButtonVisible,false, nType, bLogin);
	}

	public void setLayout(boolean bLeftButtonVisible, boolean bRightButtonVisible,  boolean bHelpButtonVisible, int nType, boolean bLogin){
		
		RelativeLayout relativeTitle_bg = (RelativeLayout)activity.findViewById(R.id.title_bg);
		ImageButton imgBtnLeft = (ImageButton)activity.findViewById(R.id.left_button);
		ImageButton imgBtnRight = (ImageButton)activity.findViewById(R.id.right_button);
		
		int resId = 0;
		
		if(nType == R.string.TITLE_TYPE_STORE)
			resId = R.drawable.title_store_store;
		else if(nType == R.string.TITLE_TYPE_STORE_REPRESENT)
			resId = R.drawable.title_store_store;
		else if(nType == R.string.TITLE_TYPE_GUIDE)
			resId = R.drawable.title_guide_infomation;
		else if(nType == R.string.TITLE_TYPE_GUIDE_APP)
			resId = R.drawable.title_guide_app;
		else if(nType == R.string.TITLE_TYPE_GUIDE_BENEFIT)
			resId = R.drawable.title_guide_benefit;
		else if(nType == R.string.TITLE_TYPE_GUIDE_FAQ)
			resId = R.drawable.title_guide_faq;
		else if(nType == R.string.TITLE_TYPE_GUIDE_GIFT_CARD01)
			resId = R.drawable.title_guide_giftcard;
		else if(nType == R.string.TITLE_TYPE_GUIDE_GIFT_CARD02)
			resId = R.drawable.title_guide_uselist;
		else if(nType == R.string.TITLE_TYPE_GUIDE_GIFT_CARD03)
			resId = R.drawable.title_guide_buylist;
		else if(nType == R.string.TITLE_TYPE_GUIDE_ALLIANCE_CARD)
			resId = R.drawable.title_guide_alliance;
		else if(nType == R.string.TITLE_TYPE_SETTING_JOIN_MODIFY)
			resId = R.drawable.title_set_joinmodify;
		
		relativeTitle_bg.setBackgroundResource(resId);
		
		switch(nType) {
			case R.string.TITLE_TYPE_STORE: 
				imgBtnLeft.setImageResource(R.drawable.btn_store_home_img);
				imgBtnRight.setImageResource(R.drawable.btn_store_set_img);
				
				imgBtnLeft.setOnClickListener(new View.OnClickListener() {
					public void onClick(View v) {
						Intent intent = new Intent(TitleView.this.activity, kr.co.gscaltex.gsnpoint.card.CardMainView.class);
						intent.putExtra("login", m_bLogin) ;
						intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
						mApplication.selectedIndex=0;
						GSActivityManager.getActivityManager().finishAllActivity(null);
						TitleView.this.activity.startActivity(intent);
					}
				});
				
				imgBtnRight.setOnClickListener(new View.OnClickListener() {
					public void onClick(View v) {
						Intent intent = new Intent(TitleView.this.activity, SettingMainView.class);
						intent.putExtra("login", m_bLogin) ;
						intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
						mApplication.selectedIndex=99;
						TitleView.this.activity.startActivity(intent);
						TitleView.this.activity.finish();
					}
				});
				break;	
			case R.string.TITLE_TYPE_STORE_REPRESENT: 
				imgBtnLeft.setImageResource(R.drawable.btn_store_prev_img);
				imgBtnRight.setImageResource(R.drawable.btn_store_set_img);
				
				imgBtnLeft.setOnClickListener(new View.OnClickListener() {
					public void onClick(View v) {						
						if(TitleView.this.activity instanceof BaseWebActivity){
							BaseWebActivity view = (BaseWebActivity) TitleView.this.activity;
							view.goBack();
						}	
					}
				});
				
				imgBtnRight.setOnClickListener(new View.OnClickListener() {
					public void onClick(View v) {
						Intent intent = new Intent(TitleView.this.activity, SettingMainView.class);
						intent.putExtra("login", m_bLogin) ;
						intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
						mApplication.selectedIndex=99;
						TitleView.this.activity.startActivity(intent);
						TitleView.this.activity.finish();
					}
				});
				break;
			
		case R.string.TITLE_TYPE_GUIDE : 			
			imgBtnLeft.setImageResource(R.drawable.btn_set_home_img);
			imgBtnRight.setImageResource(R.drawable.btn_set_set_img);
			
			imgBtnLeft.setOnClickListener(new View.OnClickListener() {
				public void onClick(View v) {
					Intent intent = new Intent(TitleView.this.activity, kr.co.gscaltex.gsnpoint.card.CardMainView.class);
					intent.putExtra("login", m_bLogin) ;
					intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
					mApplication.selectedIndex=0;
					GSActivityManager.getActivityManager().finishAllActivity(null);
					TitleView.this.activity.startActivity(intent);
				}
			});
			
			imgBtnRight.setOnClickListener(new View.OnClickListener() {
				public void onClick(View v) {
					Intent intent = new Intent(TitleView.this.activity, SettingMainView.class);
					intent.putExtra("login", m_bLogin) ;
					intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
					mApplication.selectedIndex=99;
					TitleView.this.activity.startActivity(intent);
					TitleView.this.activity.finish();
				}
			});
			break;	
			
		case R.string.TITLE_TYPE_SETTING_JOIN_MODIFY:
			
			imgBtnLeft.setImageResource(R.drawable.btn_set_prev_img);
			imgBtnRight.setImageResource(R.drawable.btn_set_set_img);
			
			imgBtnLeft.setOnClickListener(new View.OnClickListener() {
				public void onClick(View v) {
					
					TitleView.this.activity.finish();
					/*
					if(TitleView.this.activity instanceof BaseWebActivity){
						BaseWebActivity view = (BaseWebActivity) TitleView.this.activity;
						view.goBack();
					}	
					*/
				}
			});
			
			imgBtnRight.setOnClickListener(new View.OnClickListener() {
				public void onClick(View v) {
					Intent intent = new Intent(TitleView.this.activity, SettingMainView.class);
					intent.putExtra("login", m_bLogin) ;
					intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
					mApplication.selectedIndex=99;
					TitleView.this.activity.startActivity(intent);
					TitleView.this.activity.finish();
				}
			});
			break;		
	
		case R.string.TITLE_TYPE_GUIDE_APP :
		case R.string.TITLE_TYPE_GUIDE_BENEFIT :
		case R.string.TITLE_TYPE_GUIDE_FAQ :
		case R.string.TITLE_TYPE_GUIDE_GIFT_CARD01 :
		case R.string.TITLE_TYPE_GUIDE_GIFT_CARD02 :
		case R.string.TITLE_TYPE_GUIDE_GIFT_CARD03 :
		case R.string.TITLE_TYPE_GUIDE_ALLIANCE_CARD :
			imgBtnLeft.setImageResource(R.drawable.btn_set_prev_img);
			imgBtnRight.setImageResource(R.drawable.btn_set_set_img);
			
			imgBtnLeft.setOnClickListener(new View.OnClickListener() {
				public void onClick(View v) {
					
					if(TitleView.this.activity instanceof BaseWebActivity){
						BaseWebActivity view = (BaseWebActivity) TitleView.this.activity;
						view.goBack();
					}
				}
			});
			
			imgBtnRight.setOnClickListener(new View.OnClickListener() {
				public void onClick(View v) {
					Intent intent = new Intent(TitleView.this.activity, SettingMainView.class);
					intent.putExtra("login", m_bLogin) ;
					intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
					mApplication.selectedIndex=99;
					TitleView.this.activity.startActivity(intent);
					TitleView.this.activity.finish();
				}
			});
			break;
						
		}
	}
	
}
