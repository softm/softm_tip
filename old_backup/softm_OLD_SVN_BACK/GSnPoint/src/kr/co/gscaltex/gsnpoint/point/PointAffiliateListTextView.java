package kr.co.gscaltex.gsnpoint.point;

import kr.co.gscaltex.gsnpoint.R;
import android.content.Context;
import android.view.LayoutInflater;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

public class PointAffiliateListTextView extends LinearLayout {
	String TAG = "SettingNoticeTextView" ;
	
	private TextView mText01;
	private TextView mText02;
	private TextView mText03 ;
		
	private ImageView[] mStar = new ImageView[5];
	PointAffiliateListTextItem aItem;
	
	public PointAffiliateListTextView(Context context, PointAffiliateListTextItem aItem) {
		super(context);

		// Layout Inflation
		LayoutInflater inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);		
		inflater.inflate(R.layout.pointaffiliatelistitem, this, true);
		
		mText01 = (TextView) findViewById(R.id.txt_id);	
		mText01.setText(aItem.getmData()[0]);
		
		// Set Text 01
		mText02 = (TextView) findViewById(R.id.lst_itm_save_date);	
		mText02.setText(aItem.getmData()[1]);
		
		// Set Text 02
		mText03 = (TextView) findViewById(R.id.lst_itm_comment);
		mText03.setText(aItem.getmData()[2]);
		
		int i = 0;
		mStar[i] = (ImageView)findViewById(R.id.img_star1);i++;
		mStar[i] = (ImageView)findViewById(R.id.img_star2);i++;
		mStar[i] = (ImageView)findViewById(R.id.img_star3);i++;
		mStar[i] = (ImageView)findViewById(R.id.img_star4);i++;
		mStar[i] = (ImageView)findViewById(R.id.img_star5);i++;
		
		changeStarImage(aItem.getmData()[3]);
		
		this.aItem = aItem ;
		
	}
	
	private void changeStarImage(String data){
		int evl= Integer.valueOf(data);
		
		if(evl <=0)
			return;
		
		for ( int i = 0; i < evl; i++) {
			mStar[i].setBackgroundResource(R.drawable.icon_star_orange);
		}
		
	}
	public void setText(int index, String data) {
		if (index == 0) {
			mText01.setText(data);
		} else if (index == 1) {
			mText02.setText(data);
		} else if (index == 2) {
			mText03.setText(data);
		} else if (index == 3){
			changeStarImage(data);
		}
		else {
		}
	}
	
}