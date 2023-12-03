package kr.co.gscaltex.gsnpoint.card;

import kr.co.gscaltex.gsnpoint.BaseActivity;
import kr.co.gscaltex.gsnpoint.R;
import kr.co.gscaltex.gsnpoint.TitleView;
import kr.co.gscaltex.gsnpoint.util.BarcodeString;
import android.content.Intent;
import android.os.Bundle;
import android.widget.TextView;

//public class BarcodeActivity extends Activity {
public class BarcodeActivity extends BaseActivity {
	private boolean m_bLogin = false;
	
	private Barcode barcode;
	private String cvcString="";
	private String barcodeString="";
	private TextView cvc_txt;
	private TextView barcode_txt;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.bacodelandview);
		
		Bundle extras = getIntent().getExtras();
		if(extras!=null)
		m_bLogin = extras.getBoolean("login");
		
		//new TitleView(this, R.string.barcode_name);
		new TitleView(this, true, true, R.string.TITLE_TYPE_BARCORD,m_bLogin);	
		
		cvc_txt = (TextView)findViewById(R.id.cvc_txt);
		barcode_txt = (TextView)findViewById(R.id.barcode_txt);
		//barcode = new BarcodeView(this,151,233,376,4);
		barcode = (Barcode)findViewById(R.id.land_barcode_view);
		barcode.setStyle(Barcode.STYLE_LANDSCAPE);

		Intent intent = new Intent(getIntent());		
		barcodeString = intent.getStringExtra("barcodeString");
		cvcString = intent.getStringExtra("cvcString");
		
		if(cvcString.equals("") || cvcString.equals("0")) {
			cvcString = "" ;
		}
		cvc_txt.setText(cvcString);
		barcode_txt.setText(barcodeString.substring(0, 4)+" "+barcodeString.substring(4, 8)+" "+barcodeString.substring(8, 12)+" "+barcodeString.substring(12, 16));
		
		makePng(barcodeString);
	}
	
	/**
	 * makePng: ���ڵ� ��
	 * 
	 * @param str
	 */
	private void makePng(String str) {
    	BarcodeString bs = new BarcodeString();
    	barcode.set16Digit(bs.makePng(str));
    	//addContentView(barcode, new LayoutParams(LayoutParams.FILL_PARENT,LayoutParams.WRAP_CONTENT));
    }

	@Override
	protected void httpResult(int what, boolean result, String kind) {
		// TODO Auto-generated method stub
		
	}
}
