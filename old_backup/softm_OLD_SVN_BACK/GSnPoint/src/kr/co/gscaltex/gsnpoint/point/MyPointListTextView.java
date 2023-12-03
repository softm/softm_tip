package kr.co.gscaltex.gsnpoint.point;

import kr.co.gscaltex.gsnpoint.R;
import kr.co.gscaltex.gsnpoint.util.Debug;
import android.content.Context;
import android.content.Intent;
import android.graphics.Color;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

public class MyPointListTextView extends LinearLayout implements OnClickListener {
	String TAG = "MyPointListTextView" ;
	
	private Context mContext;
	
	private TextView mText01;
	private TextView mText02;
	private TextView mText03 ;
	private TextView mText04 ;
		
	private ImageView mPointSign;
	private ImageButton btnEval;
	MyPointListTextItem aItem=null;
	
	public MyPointListTextView(Context context, MyPointListTextItem aItem) {
		super(context);

		mContext = context;
		// Layout Inflation
		LayoutInflater inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);		
		inflater.inflate(R.layout.pointmypointlistitem, this, true);
		
		// Set Text 01
		mText01 = (TextView) findViewById(R.id.lst_itm_save_date);
		
		mText01.setText(aItem.getmData()[0]);
		
		// Set Text 02
		mText02 = (TextView) findViewById(R.id.lst_itm_price);
		mText02.setText(aItem.getmData()[1]);
		
		// Set Text 03
		mText03 = (TextView) findViewById(R.id.lst_itm_point_value) ;
		mText03.setText(aItem.getmData()[2]);
		
		// Set Text 04
		mText04 = (TextView) findViewById(R.id.lst_itm_franch_name) ;
		mText04.setText(aItem.getmData()[3]);
		
				
		mPointSign= (ImageView) findViewById(R.id.lst_itm_point_sign);
		setPointSignImage(aItem.getmData()[4]);
	
		this.aItem = aItem ;
		
		btnEval= (ImageButton) findViewById(R.id.lst_itm_eval_btn);
		btnEval.setId(0);
		btnEval.setOnClickListener(this);
		
	}
	
	private void setPointSignImage(String data){	
		
		if(data.equals("01")){
			mPointSign.setBackgroundResource(R.drawable.bullet_plus);
			mText03.setTextColor(Color.rgb(81, 156, 221));
		}else if(data.equals("02")){
			mPointSign.setBackgroundResource(R.drawable.bullet_minus);
			mText03.setTextColor(Color.rgb(255, 114, 0));
			
		}else{			
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
			mText04.setText(data);
		} else if (index == 4){
			setPointSignImage(data);
		}
		else {
			
		}
	}
	public void setItem(MyPointListTextItem aItem){
		this.aItem = aItem ;
	}

	public void onClick(View v) {
		// TODO Auto-generated method stub
		switch (v.getId()) {
		case 0 : 	// 평가하기 버튼
			//Debug.trace("test", "orderNo is.."+aItem.getmData()[5] +"frchCd is.."+aItem.getmData()[6]+"ccoCd is.."+aItem.getmData()[7]);
			Intent intent = new Intent(mContext, PointAffiliate.class);
			intent.putExtra("orderNo", aItem.getmData()[5]) ;
			intent.putExtra("frchCd", aItem.getmData()[6]) ;
			intent.putExtra("ccoCd", aItem.getmData()[7]) ;
			intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
  			mContext.startActivity(intent);
	         break;	
		}
	}

}