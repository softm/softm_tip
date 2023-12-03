package kr.co.gscaltex.gsnpoint.card;

import kr.co.gscaltex.gsnpoint.R;
import kr.co.gscaltex.gsnpoint.setting.SettingNoticeTextItem;
import android.content.Context;
import android.view.LayoutInflater;
import android.widget.LinearLayout;
import android.widget.TextView;

public class CardNoticeListView extends LinearLayout {
	String TAG = "SettingNoticeTextView" ;
	
	private TextView mText01;
	private TextView mText02;
	private TextView mText03 ;
	
	SettingNoticeTextItem aItem;
	
	public CardNoticeListView(Context context, SettingNoticeTextItem aItem) {
		super(context);

		// Layout Inflation
		LayoutInflater inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);		
		inflater.inflate(R.layout.cardnoticelistitem, this, true);
		
		// Set Text 01
	//	mText01 = (TextView) findViewById(R.id.noticeSubject);
		
	//	mText01.setText(aItem.getmData()[0]);
		
		// Set Text 02
		mText02 = (TextView) findViewById(R.id.noticeSubject);
		mText02.setText(aItem.getmData()[2]);
		
		// Set Text 03
		mText03 = (TextView) findViewById(R.id.noticeDate) ;
		mText03.setText(aItem.getmData()[1]);
		
		this.aItem = aItem ;
		
	}
	
	public void setText(int index, String data) {
		if (index == 0) {
			//mText01.setText(data);
		} else if (index == 2) {
			mText02.setText(data);
		} else if (index == 1) {
			mText03.setText(data);
		}
		else {
			//throw new IllegalArgumentException();
		}
	}

}