package kr.co.gscaltex.gsnpoint.point;

import kr.co.gscaltex.gsnpoint.R;
import android.content.Context;
import android.view.LayoutInflater;
import android.widget.LinearLayout;
import android.widget.TextView;

public class MyFuelListTextView extends LinearLayout {
		
	private TextView mText01;
	private TextView mText02;
	private TextView mText03 ;
		
	MyPointListTextItem aItem;
	
	public MyFuelListTextView(Context context, MyPointListTextItem aItem) {
		super(context);

		// Layout Inflation
		LayoutInflater inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);		
		inflater.inflate(R.layout.pointrefuellistitem, this, true);
		
		// Set Text 01
		mText01 = (TextView) findViewById(R.id.lst_itm_save_date);	
		mText01.setText(aItem.getmData()[0]);
		
		// Set Text 02
		mText02 = (TextView) findViewById(R.id.lst_itm_save_fuel);
		mText02.setText(aItem.getmData()[1]);
		
		// Set Text 03
		mText03 = (TextView) findViewById(R.id.lst_itm_franch_name) ;
		mText03.setText(aItem.getmData()[2]);
		
		this.aItem = aItem ;
		
	}
	
	public void setText(int index, String data) {
		if (index == 0) {
			mText01.setText(data);
		} else if (index == 1) {
			mText02.setText(data);
		} else if (index == 2) {
			mText03.setText(data);
		}
		else {
			
		}
	}
	
	public TextView getText1()
	{
		return mText02;
	}

}