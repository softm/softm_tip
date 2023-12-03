package kr.co.gscaltex.gsnpoint.qr;

import java.util.List;

import kr.co.gscaltex.gsnpoint.NewMainMenu;
import kr.co.gscaltex.gsnpoint.R;
//import kr.co.gscaltex.gsnpoint.TabMenuView;
import kr.co.gscaltex.gsnpoint.TitleView;
import kr.co.gscaltex.gsnpoint.qr.history.HistoryManager;
import kr.co.gscaltex.gsnpoint.qr.result.ResultHandlerFactory;
import kr.co.gscaltex.gsnpoint.util.Debug;
import kr.co.gscaltex.gsnpoint.util.FileInfo;
import android.app.ListActivity;
import android.content.Intent;
import android.net.Uri;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.view.Window;
import android.widget.AdapterView;
import android.widget.ListView;

import com.google.zxing.Result;
import com.google.zxing.client.result.ParsedResult;
import com.google.zxing.client.result.ParsedResultType;

public class QRCodeListActivity extends ListActivity {
	public static final String EXTRA_NAME = "QRCODE_TYPE";
	private QRCodeListAdapter mListAdapter;
	private HistoryManager historyManager;
	private String type;
	private boolean m_bLogin = false;	

	private FileInfo fi = new FileInfo();
	private Boolean bPressHomekey = false;
	
	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		requestWindowFeature(Window.FEATURE_NO_TITLE);
		setContentView(R.layout.qrcode_list);

		type = getIntent().getStringExtra(EXTRA_NAME);
		historyManager = new HistoryManager(this);
		getListView().setOnItemLongClickListener(mItemLongClickListener);
		setListAdapter();

//		new TitleView(this, R.string.title_qrcode);
//		new TabMenuView(this);
		
		Bundle extras = getIntent().getExtras();
		if(extras!=null)
			m_bLogin = extras.getBoolean("login");
		
		new TitleView(this, true, false, R.string.TITLE_TYPE_QRSCAN,m_bLogin);
		new NewMainMenu(this);		
	}

	@Override
	protected void onDestroy() {
		super.onDestroy();
	}

	private void setListAdapter() {
		mListAdapter = new QRCodeListAdapter(this);
		List<Result> items = historyManager.getHistoryItems();
		SectionAdapter listAdapter = null;

		if (type == null || type.length() == 0) {
			listAdapter = new SectionAdapter(this, items);
			//mListAdapter.addSection("ALL", listAdapter);
			mListAdapter.addSection("", listAdapter);
		}
		else {
			for (int i = 0; i < items.size(); i++) {
				ParsedResult result = ResultHandlerFactory.parseResult(items.get(i));
				if (!result.getType().toString().equals(type)) {
					items.remove(i);
					i--;
				}
			}
			listAdapter = new SectionAdapter(this, items);
			mListAdapter.addSection(type, listAdapter);
		}

		setListAdapter(mListAdapter);
	}

	public void onListItemClick(ListView l, View v, int position, long id) {
		/*Debug.trace(Log.WARN, "> DemoList onListItemClick");
		Debug.trace(Log.VERBOSE, "	ListView = "+l.toString());
		Debug.trace(Log.VERBOSE, "	View = "+v.toString());
		Debug.trace(Log.VERBOSE, "	position = "+position);
		Debug.trace(Log.VERBOSE, "	id = "+id);*/

		ParsedResult result = ResultHandlerFactory.parseResult((Result)mListAdapter.getItem(position));
		if (result.getType().equals(ParsedResultType.URI)) {
			Intent intent = new Intent(Intent.ACTION_VIEW,
					Uri.parse(result.toString()));
			intent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_WHEN_TASK_RESET);
			intent.addFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
			intent.putExtra("login", m_bLogin);
			startActivity(intent);
		}
		else {
			Intent intent = new Intent(this, QRCodeResultActivity.class);
			intent.putExtra("result", result.toString());
			intent.putExtra("login", m_bLogin);
			intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
			startActivity(intent);
		}

	}

	private final AdapterView.OnItemLongClickListener mItemLongClickListener =
		new AdapterView.OnItemLongClickListener() {
		public boolean onItemLongClick(AdapterView<?> parent, View view, int position, long id) {
			/*mLongClickItem = (AppItem)mListAdapter.getItem(position);
			if (!mLongClickItem.installed)
				return false;

			if (mLongClickItem.system.equals("ALL") ||
				mLongClickItem.system.equals("Manual")) {
				if (mLongClickItem.installed) {
					showDocumentDialog();
					return true;
				}
			}*/

			return false;
		}
	};
	
	@Override
	protected void onPause() {
		// TODO Auto-generated method stub
		super.onPause();
		
		Boolean blogin=false;
		Bundle extras = getIntent().getExtras();
		if(extras!=null)
			blogin = extras.getBoolean("login");
		
		if(bPressHomekey){
			bPressHomekey=false;
			String set_pwd = this.fi.getSettingInfo(this, FileInfo.PASSWORD_SET);
			String app_pwd = this.fi.getSettingInfo(this, FileInfo.PASSWORD_MYAPP);
			
			boolean bSetPwd = false;
			if(set_pwd.equals("TRUE")){
				bSetPwd = true;
			}
			
			if(bSetPwd && !(app_pwd.equals(""))){
				Intent intent = new Intent(this, kr.co.gscaltex.gsnpoint.setting.SettingPwsetCheckView.class);
				intent.putExtra("login", blogin) ;
				intent.putExtra("homekey", true) ;
				intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
				startActivity(intent);					
			}else{
				
			}
		}
		
	}

	@Override
	protected void onUserLeaveHint() {
		// TODO Auto-generated method stub
		super.onUserLeaveHint();
		
		Debug.trace("test", "this.getLocalClassName()is.."+ this.getLocalClassName());
		
		if(this.getLocalClassName().equals("setting.SettingPwsetCheckView"))
			bPressHomekey=false;
		else
			bPressHomekey=true;
		
	}
}
