package kr.co.gscaltex.gsnpoint.setting;

import kr.co.gscaltex.gsnpoint.R;
import android.content.Context;
import android.view.LayoutInflater;
import android.widget.LinearLayout;
import android.widget.TextView;

public class SettingNoticeTextView extends LinearLayout {
	String TAG = "SettingNoticeTextView" ;
	
	private TextView mText01;
	private TextView mText02;
	private TextView mText03 ;
	
	SettingNoticeTextItem aItem;
	public SettingNoticeTextView(Context context, SettingNoticeTextItem aItem) {
		super(context);

		// Layout Inflation
		LayoutInflater inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);		
		inflater.inflate(R.layout.settingnoticelistitem, this, true);
		
		// Set Text 01
		mText01 = (TextView) findViewById(R.id.noticedataItem01);
		
		mText01.setText(aItem.getmData()[0]);
		
		// Set Text 02
		mText02 = (TextView) findViewById(R.id.noticedataItem02);
		mText02.setText(aItem.getmData()[2]);
		
		// Set Text 03
		mText03 = (TextView) findViewById(R.id.noticedataItem03) ;
		mText03.setText(aItem.getmData()[1]);
		
		this.aItem = aItem ;
		
//		DisplayMetrics displayMetrics = new DisplayMetrics();
//		WindowManager wm = (WindowManager)context.getSystemService(Context.WINDOW_SERVICE);
//		wm.getDefaultDisplay().getMetrics(displayMetrics);
		  	 
	/*
		
		final int SUBJECT_LENGTH = (int)(pixel * 0.70) ;//354 ; // ���� ǥ�� ���� ����
		Debug.trace(TAG, "++++ LCD Width:" + pixel + ":" + SUBJECT_LENGTH) ;
		
		String subj = aItem.getmData()[0] ;
		int subjLen = subj.length() ;
		mText01.setText(subj) ;
		boolean flag = false ;
		float len = 0 ;
		while( (len = mText01.getPaint().measureText(subj)) > SUBJECT_LENGTH ) {
			subjLen = subjLen - 2 ;
			subj = subj.substring(0, subjLen ) ;
			mText01.setText(subj) ;
			flag = true ;
		}
		//mText01.setWidth((int)len) ;
		
		if( flag )
		{			
			mText03.setText("...") ;
			//mText03.setPaintFlags(mText01.getPaintFlags()|Paint.FAKE_BOLD_TEXT_FLAG) ;
			mText03.setVisibility(View.VISIBLE) ;			
		} else {
			mText03.setVisibility(View.INVISIBLE) ;
		}
		 
		*/			
	}
	
	public void setText(int index, String data) {
		if (index == 0) {
			mText01.setText(data);
		} else if (index == 2) {
			mText02.setText(data);
		} else if (index == 1) {
			mText03.setText(data);
		}
		else {
			//throw new IllegalArgumentException();
		}
	}
	
	public TextView getText1()
	{
		return mText02;
	}

}