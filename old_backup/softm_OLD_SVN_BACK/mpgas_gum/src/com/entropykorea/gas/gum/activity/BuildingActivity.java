package com.entropykorea.gas.gum.activity;

import android.content.Context;
import android.os.Bundle;
import android.view.KeyEvent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.view.inputmethod.EditorInfo;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.AdapterView.OnItemLongClickListener;
import android.widget.ArrayAdapter;
import android.widget.BaseAdapter;
import android.widget.EditText;
import android.widget.LinearLayout;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.TextView.OnEditorActionListener;
import android.widget.ToggleButton;

import com.entropykorea.ewire.database.Sqlite;
import com.entropykorea.gas.gum.AppContext;
import com.entropykorea.gas.gum.R;
import com.entropykorea.gas.gum.activity.ui.ClearableEditText;
import com.entropykorea.gas.gum.activity.ui.ClickSpinner;
import com.entropykorea.gas.gum.activity.ui.TitleBar;
import com.entropykorea.gas.gum.activity.ui.TitleBar.OnTopClickListner;
import com.entropykorea.gas.gum.activity.view.ViewById;
import com.entropykorea.gas.gum.common.DLog;
import com.entropykorea.gas.gum.database.Var;

public class BuildingActivity extends BasedActivity implements OnClickListener, OnTopClickListner, OnEditorActionListener {

	// buttons
	@ViewById(id=R.id.btn_street_address, click="this")
	ToggleButton btnStreetAddress;
	
	// editview
	ClearableEditText mSearchText;
	// listview
	ListView mList = null;
	ListAdapter listAdapter = null;
	// spinner
	ClickSpinner mClickSpinner = null;
	// database
	Sqlite mSqlite = null;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		setContentView(R.layout.activity_building_list);
		super.onCreate(savedInstanceState);

		init();
	}

	private void init() {
		// title
		TitleBar mTitleBar = (TitleBar) findViewById( R.id.titlebar );
	    mTitleBar.setTitle("건물목록");
	    mTitleBar.setOnTopClickListner(this);
	    mTitleBar.setButtonEnable(TitleBar.BUTTON_ONE, false);

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
		findViewById(R.id.btn_search).setOnClickListener(this);;

		// edittext
		mSearchText = (ClearableEditText) findViewById(R.id.et_search);
		mSearchText.setOnEditorActionListener(this);

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
	}

	@Override
	protected void onResume() {
		showList();
		super.onResume();
	}

	@Override
	public void onClickBackButton(View v) {
	}

	@Override
	public void onClickOneButton(View v) {
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
			mList.invalidateViews();
			break;
		}
	}

	boolean mInitSpinner = true;
	private void setSpinner() {
		String[] sa = { "전체", "완료", "미완료" };

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
		// TODO thread
		mSqlite.rawQuery( genSql() );
		this.listAdapter.setSqlite(mSqlite);

	}

	private String genSql() {

		String LIST_SQL_1_1 = ""
				+ "SELECT BLDG_CD,SECTOR_NM,BLDG_NO,COMPLEX_NM,BLDG_NM,ROAD_ADDR,"
				+ "       COUNT(BLDG_CD) AS TCOUNT,SUM(CASE WHEN END_YN='Y' THEN 1 ELSE 0 END) AS ECOUNT"
				+ "  FROM GUM";
		// WHERE
		String LIST_SQL_2_1 = " WHERE COMPLEX_NM LIKE '%";
		String LIST_SQL_2_2 = "%'";
		// GROUP BY
		String LIST_SQL_3_1 = " GROUP BY BLDG_CD";
		String LIST_SQL_3_2 = " GROUP BY BLDG_CD HAVING COUNT(BLDG_CD) = SUM(CASE WHEN END_YN='Y' THEN 1 ELSE 0 END)";
		String LIST_SQL_3_3 = " GROUP BY BLDG_CD HAVING COUNT(BLDG_CD) > SUM(CASE WHEN END_YN='Y' THEN 1 ELSE 0 END)";
		String lIST_SQL_4_1 = " ORDER BY MIN(HOUSE_ORD)";
		
		String sql = new String();
		String search = mSearchText.getText().toString().trim();
		// spinner 선택
		int selected = mClickSpinner.getSelectedItemPosition();

		// SELECT fields FROM table
		sql = LIST_SQL_1_1;
		// WHERE fields LINK '%searchText%'
		if( search.length() > 0 ) {
			sql += LIST_SQL_2_1 + search + LIST_SQL_2_2; 
		}
		// GROUP BY
		switch( selected ) {
		case 0:
			sql += LIST_SQL_3_1;
			break;
		case 1:
			sql += LIST_SQL_3_2;
			break;
		case 2:
			sql += LIST_SQL_3_3;
			break;
		}
		// ORDER BY
		sql += lIST_SQL_4_1;

		DLog.d(sql);

		return sql;
	}

	//	private void runActivity( Class<?> cls ) {
	//		Intent intent = new Intent( this, cls );
	//		startActivity( intent );
	//	}

	private void goList( int position ) {

		// 건물코드
		String BLDG_CD = mSqlite.getValue("BLDG_CD", position);
		// 지번
		String address_1 = "";
		address_1 += mSqlite.getValue("SECTOR_NM", position) + " ";
		address_1 += mSqlite.getValue("BLDG_NO", position) + " ";
		address_1 += mSqlite.getValue("COMPLEX_NM", position) + " ";
		address_1 += mSqlite.getValue("BLDG_NO", position);
		// 도로명
		String address_2 = "";
		address_2 += mSqlite.getValue("ROAD_ADDR", position) + " ";
		address_2 += mSqlite.getValue("COMPLEX_NM", position) + " ";
		address_2 += mSqlite.getValue("BLDG_NO", position) + " ";

		var.BLDG_CD = BLDG_CD;
		var.ADDRESS_1 = address_1;
		var.ADDRESS_2 = address_2;
		saveVar();

		runActivity( HouseActivity.class );
	}

	private void setList(ListView list, ListAdapter Adapter, Sqlite sqlite) {

		try {
			list.setAdapter(Adapter);
			list.setDividerHeight(1);

			list.setOnItemClickListener(new OnItemClickListener() {

				@Override
				public void onItemClick(AdapterView<?> parent, View view, int position, long id) {

					goList( position );
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
				convertView = inflater.inflate(R.layout.activity_building_row, parent, false);

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
			if( btnStreetAddress.isChecked() ) {
				// 지번
				str = Var.getAddress( Var.ADDRESSTYPE_1, sqlite, position);
			} else {
				// 도로명 
				str = Var.getAddress( Var.ADDRESSTYPE_2, sqlite, position);
			}
			viewholder.text1.setText( str );
			// 전체
			viewholder.text2.setText( sqlite.getValue("TCOUNT", position) );
			// 완료
			viewholder.text3.setText( sqlite.getValue("ECOUNT", position) );

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
	public boolean onEditorAction(TextView v, int actionId, KeyEvent event) {
		if ((actionId == EditorInfo.IME_ACTION_DONE) ||
				(event != null && event.getKeyCode() == KeyEvent.KEYCODE_ENTER)) {
			showList();
		}		
		return false;
	}

}
