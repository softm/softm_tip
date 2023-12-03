package kr.co.gscaltex.gsnpoint.card;

import kr.co.gscaltex.gsnpoint.R;
import kr.co.gscaltex.gsnpoint.util.Debug;
import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

public class CardRegTextView extends LinearLayout implements OnClickListener {
	String TAG = "SettingNoticeTextView" ;
	private Context mContext;
	private TextView mText01, mText02;
	private ImageView mImage01;
	
	CardRegTextItem aItem;
	public CardRegTextView(Context context, CardRegTextItem aItem) {
		super(context);

		mContext = context;
		
		// Layout Inflation
		LayoutInflater inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);		
		inflater.inflate(R.layout.cardregister_item, this, true);
		
		// Set Text 01
		mText01 = (TextView) findViewById(R.id.txt_issueName);
		mText01.setText(aItem.getCardName());
		
		// Set Text 01
		mText02 = (TextView) findViewById(R.id.edt_cardnumber);
		mText02.setText(aItem.getCardNo());
				
//		txt_issueName
		mImage01 = (ImageView) findViewById(R.id.img_btn_stop);
		//mText02.setFocusable(true);
		mImage01.setId(1);
		mImage01.setOnClickListener(this);		
		
		if(aItem.getStopYn().equals("N")){
			mImage01.setVisibility(View.INVISIBLE);
		}else if(aItem.getStopYn().equals("Y")){
			mImage01.setVisibility(View.VISIBLE);
		}
 		this.aItem = aItem ;
	}
	
	public void setText(int index, String data) {
		if (index == 0) {
			mText01.setText(data);
		}else if(index == 1){
			mText02.setText(data);
		}
	}
	
	public void setStopYN(String data){
		if(data.equals("N")){
			mImage01.setVisibility(View.INVISIBLE);
		}else if(data.equals("Y")){
			mImage01.setVisibility(View.VISIBLE);
		}
	}
	
	public TextView getText1()
	{
		return mText01;
	}

	public void onClick(View v) {
		switch (v.getId()) {
		case 1: 	// 정지
			//aItem.getCardNo();
			//String cardNo = String.valueOf(getText1().getText());
			String cardNo = String.valueOf(aItem.getCardNo());
			       cardNo = cardNo.replaceAll("-", "");
			((CardRegView) mContext).execCardStop(cardNo);
	        break;
		}
	}

}