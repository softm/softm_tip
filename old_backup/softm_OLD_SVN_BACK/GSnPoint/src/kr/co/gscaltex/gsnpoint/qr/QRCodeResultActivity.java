package kr.co.gscaltex.gsnpoint.qr;

import java.util.HashMap;

import kr.co.gscaltex.gsnpoint.BaseActivity;
import kr.co.gscaltex.gsnpoint.NewMainMenu;
import kr.co.gscaltex.gsnpoint.R;
import kr.co.gscaltex.gsnpoint.TitleView;
import android.content.Intent;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup.LayoutParams;
import android.view.Window;
import android.widget.LinearLayout;
import android.widget.TableLayout;
import android.widget.TableRow;
import android.widget.TextView;

//public class QRCodeResultActivity extends Activity implements OnClickListener {
public class QRCodeResultActivity extends BaseActivity implements OnClickListener {
	//public static final String GS_QRCODE = "GS&";
	public final String[] KEYS = {
		QRCodeParser.KEY_F_NM,
		QRCodeParser.KEY_ADDR,
		QRCodeParser.KEY_TTL,
		QRCodeParser.KEY_TEL,
		QRCodeParser.KEY_P_DT,
		QRCodeParser.KEY_CNTT
	};
	public final String[] VALUES = {
		"��������",
		"�ּ�",
		"����",
		"��ȭ��ȣ",
		"���θ�ǱⰣ",
		"����"
	};

//	private ImageView mImageView;
	private boolean m_bLogin = false;
//	private String value;
	
	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		requestWindowFeature(Window.FEATURE_NO_TITLE);
		setContentView(R.layout.qrcode_result);

//		mImageView = (ImageView)findViewById(R.id.qrcode_result_image);

//		new TitleView(this, R.string.title_qrcode);
//		new TabMenuView(this);
		Bundle extras = getIntent().getExtras();
		if(extras!=null)
			m_bLogin = extras.getBoolean("login");
		
		new TitleView(this, true, false, R.string.TITLE_TYPE_QRSCAN,m_bLogin);
		new NewMainMenu(this);
		
		initLayout();
	}

	@Override
	protected void onDestroy() {
		super.onDestroy();
	}

	public void onClick(View v) {
/*
		Intent intent = new Intent(Intent.ACTION_VIEW,
				Uri.parse(getIntent().getExtras().get("result").toString()));
		intent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_WHEN_TASK_RESET);
		intent.addFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
		startActivity(intent);
*/
		Intent intent = new Intent(/*CaptureActivity.this*/QRCodeResultActivity.this,
				QRCodeListActivity.class);
		intent.putExtra("login", m_bLogin);
		intent.addFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
		startActivity(intent);
	}
	
	private void initLayout() {
		LayoutInflater layoutInflater = getLayoutInflater();
		TableLayout table = (TableLayout)findViewById(R.id.qrcode_result_table);
		LinearLayout layout;
		String result = getIntent().getStringExtra("displayContents");
//sbhong@truemobile.com  receive result value
		String resultValue = getIntent().getStringExtra("result");
		HashMap<String, String> results = QRCodeParser.getList(result);
		String value;

		if (results.size() == 1) {
			//mImageView.setVisibility(View.GONE);

			layout = (LinearLayout)layoutInflater.inflate(R.layout.qrcode_result_text, null);
			//layout.setBackgroundResource(R.drawable.list_bg_off);
			layout.setBackgroundResource(R.drawable.cardlist_bg_off);
	//sbhong@truemobile.com  no need
/*
			layout.setClickable(true);
			layout.setOnClickListener(this);
*/				
			value = results.get(QRCodeParser.KEY_NULL);
				addTableRow(table, layout, value ,resultValue);
			
		}
		else {
			for (int i = 0; i < results.size(); i++) {
				layout = (LinearLayout)layoutInflater.inflate(R.layout.qrcode_result_text, null);
				//layout.setBackgroundResource(R.drawable.list_bg_off);
				layout.setBackgroundResource(R.drawable.cardlist_bg_off);
//sbhong@truemobile.com  no need
/*
				layout.setClickable(true);
				layout.setOnClickListener(this);
*/
				
				value = VALUES[i] + " : " + results.get(KEYS[i]);
//sbhong@truemobile.com value 넘겨주는 부분 추가				
				addTableRow(table, layout, value ,resultValue);
			}
		}
	}

	private void addTableRow(TableLayout table, LinearLayout layout, String text, String text1) {
		
		TableRow tr = new TableRow(this);
		
		tr.setLayoutParams(new TableRow.LayoutParams(LayoutParams.FILL_PARENT,
				LayoutParams.WRAP_CONTENT));

		TextView textview = (TextView)layout.findViewById(R.id.qrcode_result_text);
//sbhong@truemobile.com 결과값을 display해주는 textview		
		TextView textview1 = (TextView)layout.findViewById(R.id.qrcode_result_text1);
		textview.setText(text);
		textview1.setText(text1);

		tr.addView(layout);
		table.addView(tr,
				new TableLayout.LayoutParams(LayoutParams.FILL_PARENT,
						LayoutParams.WRAP_CONTENT));
	}

	@Override
	protected void httpResult(int what, boolean result, String kind) {
		// TODO Auto-generated method stub
		
	}
}
