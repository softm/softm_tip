package com.entropykorea.gas.gum.activity;

import android.content.Context;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.MenuItem;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.View.OnLongClickListener;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.AdapterView.OnItemLongClickListener;
import android.widget.PopupMenu.OnMenuItemClickListener;
import android.widget.ArrayAdapter;
import android.widget.BaseAdapter;
import android.widget.LinearLayout;
import android.widget.ListView;
import android.widget.PopupMenu;
import android.widget.TextView;
import android.widget.Toast;
import android.widget.ToggleButton;

import com.entropykorea.ewire.database.Sqlite;
import com.entropykorea.gas.gum.AppContext;
import com.entropykorea.gas.gum.R;
import com.entropykorea.gas.gum.activity.ui.ClickSpinner;
import com.entropykorea.gas.gum.activity.ui.TitleBar;
import com.entropykorea.gas.gum.activity.ui.TitleBar.OnTopClickListner;
import com.entropykorea.gas.gum.common.Clipboard;
import com.entropykorea.gas.gum.common.DLog;
import com.entropykorea.gas.gum.common.Utils;
import com.entropykorea.gas.gum.database.BaseCode;

public class HouseActivity extends BasedActivity implements OnClickListener, OnLongClickListener, OnTopClickListner, OnMenuItemClickListener {

	// buttons
	private ToggleButton mStreetAddress = null;
	// textview
	private TextView mAddress = null; 
	// listview
	private ListView mList = null;
	private ListAdapter listAdapter = null;
	// spinner
	private ClickSpinner mClickSpinner = null;
	// database
	private Sqlite mSqlite = null;
	// basecode
	private BaseCode mBaseCode = null; // 검침근거 (ME010) 
	
	// 당월/전월지침 
	private boolean mIsCurrentMeter = true; // 당월 : true 전월 : false
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		setContentView(R.layout.activity_house_list);
		super.onCreate(savedInstanceState);
		
		init();
	}

	private void init() {
		// title
	    mTitleBar.setTitle("수용가목록");
	    mTitleBar.setOnTopClickListner(this);
	    //mTitleBar.setButtonEnable(TitleBar.BUTTON_ONE, false);
	    mTitleBar.setOnClickTitleText(new TitleBar.OnClickTitleText() {

	    	@Override
	    	public void OnClickTitleText(View v) {
	    		mTitleBar.setTitle( "수용가목록:" + var.BLDG_CD );
	    	}
	    });
		
	    // swipe
	    setOnSwipe(this, new OnSwipeListner() {
			@Override
			public void onSwipe(int direction) {
				if( direction == BasedActivity.SWIPE_DOWN ) {
					ListView listview = (ListView) findViewById( R.id.lv_list );
					if( listview.getCount() == 0 ) {
						finish();
					} else if( listview.getChildAt(0).getTop() == 0 ) { 
						finish();
					}
				}
			}
			
			@Override
			public void onDoubleTap() {
			}
		});

	    // button
		findViewById(R.id.btn_search).setOnClickListener(this);
		mStreetAddress = (ToggleButton) findViewById(R.id.btn_street_address);
		mStreetAddress.setOnClickListener(this);

		// textview
		mAddress = (TextView) findViewById(R.id.tv_address);
		mAddress.setOnLongClickListener(this);
		
		// listview
		mList = (ListView) findViewById(R.id.lv_list);

		// Sqlite
		mSqlite = new Sqlite(AppContext.getSQLiteDatabase());
		
		// adoptor
		listAdapter = new ListAdapter(this, mSqlite);
		setList( mList, listAdapter, mSqlite );

		// spinner
		mClickSpinner = (ClickSpinner) findViewById(R.id.sp_type);
		setSpinner();
		
		// basecode
		mBaseCode = new BaseCode(AppContext.getSQLiteDatabase(), "ME010"); 
	}

	public void setCurrentMeter( boolean value ) {
		
		this.mIsCurrentMeter = value;
		
		// header title 
		TextView tv = (TextView) findViewById( R.id.tv_header2 );
		
		if( value ) {
			// 당월지침
			tv.setText( "당월지침" );
		} else {
			// 전월지침
			tv.setText( "전월지침" );
		}
		
		// list refresh
		mList.invalidateViews();
		
	}

	public void showMenu() {
		View anchor = (View) findViewById( R.id.btn_one );
		showMenu(anchor, R.menu.house);
	}

	@Override
	protected void onResume() {
		// address
		setAddress();
		// list
		showList();
		super.onResume();
	}

	@Override
	public void onClickBackButton(View v) {
	}

	@Override
	public void onClickOneButton(View v) {
		showMenu();
	}

	@Override
	public void onClickTwoButton(View v) {
		lanchScan(v);
	}

	@Override
	public void onClick(View v) {
		switch( v.getId() ) {
		// 검색
		case R.id.btn_search:
			showList();
			break;
		// 지번/도로명
		case R.id.btn_street_address:
			setAddress();
			break;
		}
	}
	
	@Override
	public boolean onLongClick(View v) {
		switch( v.getId() ) {
		// 
		case R.id.tv_address:
			copyAddress();
			break;
		}
		return false;
	}	
	
	private void copyAddress() {
		
		String address;
		
		if( mStreetAddress.isChecked() ) {
			address = var.ADDRESS_1;
		} else {
			address = var.ADDRESS_2;
		}
		
		Clipboard.copyToClipboard(this, address);
		
		Toast.makeText(this, "주소를 클립보드에 복사하였습니다.", Toast.LENGTH_SHORT).show();
		goMap(address);
		
//		new AlertDialog.Builder(this)
//		.setMessage("지도를 검색하시겠습니까?")
//		.setPositiveButton("예", new DialogInterface.OnClickListener() {
//			public void onClick(DialogInterface dialog, int whichButton) {
//				new Thread(new Runnable() {
//					public void run() {
//						goMap( _ADDRESS);
//					}
//				}).start();
//			}
//		})
//		.setNegativeButton("아니요", new DialogInterface.OnClickListener() {
//			public void onClick(DialogInterface dialog, int whichButton) {
//
//			}
//		})
//		.create()
//		.show();
	}
	
	private void setAddress() {

		TextView textView = (TextView) findViewById(R.id.tv_address);
		String address;
		
		if( mStreetAddress.isChecked() ) {
			address = var.ADDRESS_1;
		} else {
			address = var.ADDRESS_2;
		}
		textView.setText(address);
	}
	
	boolean mInitSpinner = true; 
	private void setSpinner() {
		String[] sa = { "미완료", "완료", "전체" };

		// adapter
		ArrayAdapter<String> mAdapter;
		mAdapter = new ArrayAdapter<String>(this, android.R.layout.simple_spinner_item, sa);
		mClickSpinner.setAdapter(mAdapter);
		mClickSpinner.setOnPerformClickListener(new ClickSpinner.OnPerformClick() {

			@Override
			public boolean performCick() {
				showList();
				return false;
			}

		});
		
	}
	
	private void showList() {
		
		if( mSqlite == null ) {
			return;
		}
		
		// TODO thread
		mSqlite.rawQuery( genSql() );
		this.listAdapter.setSqlite(mSqlite);
		
	}

	private String genSql() {

		// SELECT
		String LIST_SQL_1_1 = ""
				+ "SELECT READ_IDX,BILL_YM,BLDG_CD,HOUSE_NO,SECTOR_NM,BLDG_NO,COMPLEX_NM,BLDG_NM,ROAD_ADDR,"
				+ "       ROOM_NO,CO_NM,CUST_NM,METER,METER_CD,BF_MM_METER,BF_MM_METER_CD "
				+ "  FROM GUM";
		// WHERE
		String LIST_SQL_2_1 = " WHERE BLDG_CD = '";
		String LIST_SQL_2_2 = "'";
		// WHERE
		String LIST_SQL_3_1 = " AND END_YN = 'Y'";
		String LIST_SQL_3_2 = " AND END_YN = 'N'";
		// ORDER BY
		String LIST_SQL_4_1 = " ORDER BY HOUSE_ORD";
		
		String sql = new String();
		//String search = mSearchText.getText().toString().trim();
		// spinner 선택
		int selected = mClickSpinner.getSelectedItemPosition();;
		
		// SELECT fields FROM table
		sql = LIST_SQL_1_1;
		// WHERE BLDG_CD = '_BLDG_CD'
		sql += LIST_SQL_2_1 + var.BLDG_CD + LIST_SQL_2_2;
		switch( selected ) {
		case 0: // 미완료
			sql += LIST_SQL_3_2;
			break;
		case 1: // 완료
			sql += LIST_SQL_3_1;
			break;
		case 2: // 전체
		}
		// ORDER BY
		sql += LIST_SQL_4_1;
		
		DLog.d(sql);

		return sql;
	}
	
	private void goList( int position ) {
		
		var.READ_IDX = mSqlite.getValue("READ_IDX", position);
		var.HOUSE_NO = mSqlite.getValue("HOUSE_NO", position);
		saveVar();
		
		runActivity( ProcessActivity.class );
	}

	private void setList(ListView list, ListAdapter Adapter, Sqlite sqlite) {

		try {
			list.setAdapter(Adapter);
			list.setDividerHeight(1);

			list.setOnItemClickListener(new OnItemClickListener() {

				@Override
				public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
					
					goList(position);
				}
			});
			
			list.setOnItemLongClickListener(new OnItemLongClickListener() {

				@Override
				public boolean onItemLongClick(AdapterView<?> parent,
						View view, int position, long id) {
					
					return false;
				}
			});

		} catch (Exception e) {
			e.printStackTrace();
		}

	}

	// 어댑터 클래스
	class ListAdapter extends BaseAdapter {
		//private Context context;
		private LayoutInflater inflater;
		private Sqlite sqlite;
		//private Boolean typeStreetAddress = true;

		public ListAdapter(Context context, Sqlite sqlite) {
			//this.context = context;
			this.sqlite = sqlite;
			inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
		}

		public void setSqlite(Sqlite sqlite) {
			this.sqlite = sqlite;
			notifyDataSetChanged();
		}

		public int getCount() {
			if (this.sqlite == null)
				return 0;
			return this.sqlite.getCount();
		}

		public Object getItem(int position) {
			return position;
		}

		public long getItemId(int position) {
			return position;
		}

		// 각 항목의 뷰 생성
		public View getView(int position, View convertView, ViewGroup parent) {

			ViewHolder viewholder;

			if (convertView == null) {
				convertView = inflater.inflate(R.layout.activity_house_row, parent, false);

				viewholder = new ViewHolder();
				viewholder.panel = (LinearLayout) convertView.findViewById(R.id.listPanel);
				viewholder.text1 = (TextView) convertView.findViewById(R.id.listCell1);
				viewholder.text2 = (TextView) convertView.findViewById(R.id.listCell2);
				viewholder.text3 = (TextView) convertView.findViewById(R.id.listCell3);

				convertView.setTag(viewholder);
			} else {
				viewholder = (ViewHolder) convertView.getTag();
			}

			// 주소 
			String str = "";
			String ROOM_NO = sqlite.getValue("ROOM_NO", position);
			String CO_NM = sqlite.getValue("CO_NM", position);
			str += ROOM_NO + "\n";
			if( CO_NM.trim().length() == 0 ) {
				str += sqlite.getValue("CUST_NM", position);
			} else {
				str += CO_NM;
			}
			
			viewholder.text1.setText( str );
			// 당월지침
			if( mIsCurrentMeter ) {
				// 당월지침
				viewholder.text2.setText( Utils.getCommaString( sqlite.getValue("METER", position) ) );
				// 근거
				viewholder.text3.setText( mBaseCode.getName( sqlite.getValue("METER_CD", position) ) );
			} else {
				// 전월지침
				viewholder.text2.setText( Utils.getCommaString( sqlite.getValue("BF_MM_METER", position) ) );
				// 근거
				viewholder.text3.setText( mBaseCode.getName( sqlite.getValue("BF_MM_METER_CD", position) ) );
			}
			

			// back color pressed color
			viewholder.panel.setBackgroundResource( position % 2 == 0 ? R.drawable.listview_item_selector_1
					: R.drawable.listview_item_selector_2);

			return convertView;
		}

		public class ViewHolder {
			public LinearLayout panel = null;
			public TextView text1 = null;
			public TextView text2 = null;
			public TextView text3 = null;
		}
	}

	@Override
	public boolean onMenuItemClick(MenuItem item) {
		switch( item.getItemId() ) {
		case R.id.action_settings1:
			setCurrentMeter( true );
			break;
		case R.id.action_settings2:
			setCurrentMeter( false );
			break;
		}
		return false;
	}
	
}
