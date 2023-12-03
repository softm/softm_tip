package kr.co.gscaltex.gsnpoint.card;

import kr.co.gscaltex.gsnpoint.R;
import kr.co.gscaltex.gsnpoint.util.BarcodeString;
import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.util.AttributeSet;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.LinearLayout;
import android.widget.TextView;

public class BarcodeView extends LinearLayout{
	String TAG = "BarcodeView" ;
	
	private LinearLayout linear = null;
	private TextView cardNumber = null;
	private TextView cvcCode = null;
	private Barcode barcode = null;
	private Activity activity;
	
	private Boolean mlogin=false;
		
	public BarcodeView(Context context, Boolean login) {
		super(context);
		init(context);
		mlogin= login;
	}

	public BarcodeView(Context context, AttributeSet attrs) {
		super(context,attrs);
		init(context);
	}

	private void init(Context context) {
		activity= (Activity)context;
		
		String infService = Context.LAYOUT_INFLATER_SERVICE;
        LayoutInflater li = (LayoutInflater) getContext().getSystemService(infService);
        View v = (View)li.inflate(R.layout.bacodeview, null);
        addView(v); 
		
        linear = (LinearLayout)findViewById(R.id.linear);
		barcode = (Barcode)findViewById(R.id.barcode);
				
		cardNumber = (TextView)findViewById(R.id.cardNumber);
		cvcCode = (TextView)findViewById(R.id.cvcCode); 
	}

	public void requestBigBarcode(String card_number, String cvc_code){
		Intent intent;
		
		 intent = new Intent(BarcodeView.this.activity, BarcodeActivity.class);
		 intent.putExtra("login", mlogin);
		 intent.putExtra("barcodeString", card_number);
		 intent.putExtra("cvcString", cvc_code);
		 intent.addFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
		 BarcodeView.this.activity.startActivity(intent);
		 
	}
	
	public void setCardNumber( String card_number, String cvc_code, String pk ) {	
		cardNumber.setText(card_number.substring(0, 4)+" "+card_number.substring(4, 8)+" "+card_number.substring(8, 12)+" "+card_number.substring(12, 16));
		//cardNumber.setText(card_number);
		cvcCode.setText(cvc_code);
		
		BarcodeString bs = new BarcodeString();
		barcode.set16Digit(bs.makePng(card_number));
		
		setCardImage(pk);
	}
	
	private void setCardImage(String pk){
		if(pk.equals("1004")){
			linear.setBackgroundResource(R.drawable.registration_card_list02);
		}else if(pk.equals("1600")){
			linear.setBackgroundResource(R.drawable.registration_card_list10);
		}else if(pk.equals("3200")){
			linear.setBackgroundResource(R.drawable.registration_card_list05);
		}else if(pk.equals("3300")){
			linear.setBackgroundResource(R.drawable.registration_card_list03);
		}else if(pk.equals("3400")){
			linear.setBackgroundResource(R.drawable.registration_card_list06);
		}else if(pk.equals("5263")){
			linear.setBackgroundResource(R.drawable.registration_card_list13);
		}else if(pk.equals("5264")){
			linear.setBackgroundResource(R.drawable.registration_card_list13);
		}else if(pk.equals("6400")){
			linear.setBackgroundResource(R.drawable.registration_card_list13);
		}else if(pk.equals("7100")){
			linear.setBackgroundResource(R.drawable.registration_card_list07);
		}else if(pk.equals("9150")){
			linear.setBackgroundResource(R.drawable.registration_card_list08);
		}else if(pk.equals("9330")){
			linear.setBackgroundResource(R.drawable.registration_card_list09);
		}else if(pk.equals("9580")){
			linear.setBackgroundResource(R.drawable.registration_card_list11);
		}else {
			linear.setBackgroundResource(R.drawable.registration_card_list01);
		}
		
	}

}