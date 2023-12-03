package kr.co.gscaltex.gsnpoint.qr;

import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.HashMap;
import java.util.List;

import kr.co.gscaltex.gsnpoint.BaseActivity;
import kr.co.gscaltex.gsnpoint.NewMainMenu;
import kr.co.gscaltex.gsnpoint.R;
import kr.co.gscaltex.gsnpoint.TitleView;
import kr.co.gscaltex.gsnpoint.qr.history.HistoryManager;
import kr.co.gscaltex.gsnpoint.qr.result.ResultHandlerFactory;
import android.content.Context;
import android.content.Intent;
import android.net.Uri;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.Window;
import android.widget.BaseExpandableListAdapter;
import android.widget.ExpandableListView;
import android.widget.ExpandableListView.OnChildClickListener;
import android.widget.ExpandableListView.OnGroupClickListener;
import android.widget.TextView;

import com.google.zxing.Result;
import com.google.zxing.client.result.ParsedResult;


public class QRCodeGroupActivity extends BaseActivity {
	
	// private
	private HistoryManager historyManager;
	private String GROUPS = "groups";
	private String ITEMS = "items";
	private boolean m_bLogin = false;
	
	// public
	public String[] mGroups;
	public String[] mItems;
	public ExpandableListView mListView;

	// onCreate()
	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		requestWindowFeature(Window.FEATURE_NO_TITLE);
		setContentView(R.layout.qrcode_group_truemobile);
		
		Bundle extras = getIntent().getExtras();
		if(extras!=null)
			m_bLogin = extras.getBoolean("login");
		
		new TitleView(this, true, false, R.string.TITLE_TYPE_QRSCAN, m_bLogin);
		new NewMainMenu(this);		
		
		// HistoryManager ??u??
		historyManager = new HistoryManager(this);

		// ?????? ????
		initialize();
		
		// ??????? ????
		settingExpandableListView();
		
		// ??? ??????
	    mListView.setOnGroupClickListener(new OnGroupClickListener() {
	        @Override
	        public boolean onGroupClick(ExpandableListView parent, View v, int groupPosition, long id) {
	        	return false;
	        }
	    });

	    // ?????? ??????
	    mListView.setOnChildClickListener(new OnChildClickListener() {
	        @Override
	        public boolean onChildClick(ExpandableListView parent, View v, int groupPosition, int childPosition, long id) {
	        	
	        	ArrayList<ArrayList<HashMap<String, String>>> itemslist;
	        	itemslist =  getItemsList();
	        	String groupName = mGroups[groupPosition];
        		String itemName = itemslist.get(groupPosition).get(childPosition).get("items").toString();
        			     
        		if(!checktype(itemName))	
        		{
	        	   if(groupName.equals("URI")){ 
			    			Intent intent = new Intent(Intent.ACTION_VIEW,
			    					Uri.parse(itemName.toString()));
			    			intent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_WHEN_TASK_RESET);
			    			startActivity(intent);
			        	 }
        		}	
	        	return false;
	        }      
	    });
	}
//sbhong@truemobile.com  email check code	
	public boolean checktype (String string)
	{		
		if(string.length() > 5){
			if (string.substring(0,6).equals("email:"))
			{
				return true;
			}
		}		
		return false;
	}
	private void initialize() {
		List<Result> items = historyManager.getHistoryItems();
		
		mListView = (ExpandableListView)findViewById(R.id.qrcode_group_expandable_truemobile);	
		mListView.setGroupIndicator(null);
		
		mGroups = new String[items.size()];
		mItems = new String[items.size()];
			
		for(int i = 0; i < items.size(); i++) {
			ParsedResult result = ResultHandlerFactory.parseResult(items.get(i));
			mGroups[i] = result.getType().toString();
			mItems[i] = result.getDisplayResult();
			
		}
	
		mGroups = getUniqueStringArray(mGroups);
		mItems = getUniqueStringArray(mItems);
	}


	public void settingExpandableListView() {
		
		
		customExpandableAdapter customAdapter = new customExpandableAdapter(this, getGroupsList(), getItemsList());
		mListView.setAdapter(customAdapter);
		mListView.setDivider(null);
		
		/*
	    SimpleExpandableListAdapter adapter= new SimpleExpandableListAdapter (
	    		this,
	    		getGroupsList(), 	    									// ??? ????? ???
	    		R.layout.qrcode_group_truemobile_row,	// ??? ????? ?????? ????
	    		new String[]{GROUPS},	    						// ??? key?? ????
	    		new int[]{R.id.qrcode_group_group},	    	// ??? ???? ????? ????
	    		getItemsList(), 											// ?????? ????? ???
	    		R.layout.qrcode_group_truemobile_row,	// ?????? ????? ?????? ????
	    		new String[]{ITEMS}, 									// ?????? key?? ????
	    		new int[]{R.id.qrcode_group_item} 			// ?????? ???? ????? ????
	    ); 
	    mListView.setAdapter(adapter);
	    */
	}


    public ArrayList<HashMap<String, String>> getGroupsList(){
    	ArrayList<HashMap<String, String>> groupsList = new ArrayList<HashMap<String, String>>();
    	for(int i = 0; i < mGroups.length; i++){
    		HashMap<String, String> map = new HashMap<String, String>();
    		map.put(GROUPS, mGroups[i]);
    		groupsList.add(map);
    	}
    	return groupsList;
    }
    

    public ArrayList<ArrayList<HashMap<String, String>>> getItemsList(){
    	ArrayList<ArrayList<HashMap<String, String>>> itemsList = new ArrayList<ArrayList<HashMap<String, String>>>();
    	List<Result> items = historyManager.getHistoryItems();
    	for(int i = 0; i < mGroups.length; i++){  //sbhong@truemobile.com mItems.length -> mGroups.length
    		ArrayList<HashMap<String, String>> mapList = new ArrayList<HashMap<String, String>>();
    		for(int j = 0; j < mItems.length; j++) {  //sbhong@truemobile.com  group별 item을 넣는다..
    			HashMap<String, String> map = new HashMap<String, String>();
    			ParsedResult result = ResultHandlerFactory.parseResult(items.get(j));
    			if( result.getDisplayResult().equals(mItems[j]) && result.getType().toString().equals(mGroups[i].toString()))
    			{
    			   map.put(ITEMS, mItems[j]);
    			   mapList.add(map);
    			}
    		}
    		itemsList.add(mapList);		
    	}
    	return itemsList;
    }
    

    public String[] getUniqueStringArray(String[] strArray) {
    	  ArrayList list = new ArrayList();
    	  for ( int i=0; i<strArray.length; i++ ) {
    	    if ( ! list.contains(strArray[i]) )
    	    	list.add(strArray[i]);
    	  }
    	  String uniqueArray[] = new String[list.size()];
    	  list.toArray(uniqueArray);
    	  return uniqueArray;
    }
    

    public class customExpandableAdapter extends BaseExpandableListAdapter {
    	public Context context;
    	public ArrayList<HashMap<String, String>> groups;
    	public ArrayList<ArrayList<HashMap<String, String>>> items;
    	
		public customExpandableAdapter(QRCodeGroupActivity qrCodeGroupActivity,
																ArrayList<HashMap<String, String>> groupsList,
																ArrayList<ArrayList<HashMap<String, String>>> itemsList) {
			this.context = qrCodeGroupActivity;
			this.groups = groupsList;
			this.items = itemsList;
		}

		@Override
		public String getChild(int groupPosition, int itemPosition) {	
			//return mItems;
			return items.get(groupPosition).get(itemPosition).get("items");
		}

		@Override
		public long getChildId(int groupPosition, int itemPosition) {
			return itemPosition;
		}
		
		@Override
		// ?????? ????
		public int getChildrenCount(int groupPosition) {
			//return mItems.length;
			return items.get(groupPosition).size();
		}

		@Override
		// ?????? ?? ????
		public View getChildView(int groupPosition, int itemPosition, boolean isLastItem, View convertView, ViewGroup parent) {
		//	String itemName = mItems[itemPosition];
			List<Result> items1 = historyManager.getHistoryItems();
			SimpleDateFormat dateFormat = new SimpleDateFormat("yyyy-MM-dd");
			String itemDate = dateFormat.format(new Date(items1.get(itemPosition).getTimestamp()));
					
			
			if (convertView == null) {
                LayoutInflater infalInflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
                convertView = infalInflater.inflate(R.layout.qrcode_group_item_row_truemobile, null);
                convertView.setBackgroundResource(R.drawable.guide_qrhistory_listbg_mid);
/*                convertView.setClickable(true);
                convertView.setOnClickListener(this);*/
            }
			TextView itemDateText = (TextView) convertView.findViewById(R.id.qrcode_items_date);
            TextView itemNameText = (TextView) convertView.findViewById(R.id.qrcode_items_name);
            
            itemDateText.setText(itemDate);
            itemNameText.setText(items.get(groupPosition).get(itemPosition).get("items"));
            return convertView;
		}

		@Override
		// View?? ????? mGroups
		public String[] getGroup(int groupPosition) {
			return mGroups;
		}
		
		@Override
		// ??? position
		public long getGroupId(int groupPosition) {
			return groupPosition;
		}

		@Override
		// ??? ????
		public int getGroupCount() {
			return mGroups.length;
		}

		@Override
		// ??? ?? ????
		public View getGroupView(int groupPosition, boolean isExpanded, View convertView, ViewGroup parent) {
			String groupName = mGroups[groupPosition];
			int groupCount = items.get(groupPosition).size(); //String.valueOf(mItems.length)
			 
        	if (convertView == null) {
                LayoutInflater infalInflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
                convertView = infalInflater.inflate(R.layout.qrcode_group_group_row_truemobile, null);
               convertView.setBackgroundResource(R.drawable.guide_qrhistory_btn_off);

            }
 
            TextView groupNameText = (TextView) convertView.findViewById(R.id.qrcode_groups_name);
            TextView groupCountText = (TextView) convertView.findViewById(R.id.qrcode_groups_count);
            
			if(groupName.equals("URI")){
				groupName = "URL";
			}
            groupNameText.setText(groupName);
            groupCountText.setText("(" + groupCount + ")");
            return convertView;
		}

		@Override
		public boolean hasStableIds() {
			return false;
		}

		@Override
		public boolean isChildSelectable(int arg0, int arg1) {
			return true;
		}
    }



	
	// onDestroy()
	@Override
	protected void onDestroy() {
		super.onDestroy();
	}
	@Override
	protected void httpResult(int what, boolean result, String kind) {
		// TODO Auto-generated method stub
		
	}	
}
/*
public class QRCodeGroupActivity extends Activity implements OnClickListener {
	private HistoryManager historyManager;
	private ArrayList<Group> groups;
	private boolean m_bLogin = false;

	class Group {
		ParsedResultType type;
		int count;
	}

	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		requestWindowFeature(Window.FEATURE_NO_TITLE);
		setContentView(R.layout.qrcode_group);
		
		historyManager = new HistoryManager(this);
		groups = new ArrayList<Group>();
		initGroup();
		initLayout();

		Bundle extras = getIntent().getExtras();
		if(extras!=null)
			m_bLogin = extras.getBoolean("login");
		
		new TitleView(this, true, true, R.string.TITLE_TYPE_QRSCAN,m_bLogin);
		new NewMainMenu(this);		

	}

	@Override
	protected void onDestroy() {
		super.onDestroy();
	}

	public void onClick(View v) {
		Group group = groups.get(v.getId());
		Intent intent = new Intent(QRCodeGroupActivity.this, QRCodeListActivity.class);
		intent.putExtra(QRCodeListActivity.EXTRA_NAME, group.type.toString());
		startActivity(intent);
	}

	private void initGroup() {
		List<Result> items = historyManager.getHistoryItems();
		if (items.size() > 0) {
			int j = 0;
			ParsedResult result = ResultHandlerFactory.parseResult(items.get(0));
			Group group = new Group();
			group.type = result.getType();
			group.count = 1;
			groups.add(group);

			for (int i = 1; i < items.size(); i++) {
				result = ResultHandlerFactory.parseResult(items.get(i));
				ParsedResultType type = result.getType();
				for (j = 0; j < groups.size(); j++) {
					group = groups.get(j);
					if (group.type.equals(type)) {
						group.count++;
						break;
					}
				}
				if (j == groups.size()) {
					group = new Group();
					group.type = result.getType();
					group.count = 1;
					groups.add(group);
				}
			}
		}
	}

	private void initLayout() {
		LayoutInflater layoutInflater = getLayoutInflater();
		TableLayout table = (TableLayout)findViewById(R.id.qrcode_group_table);
		TableRow tr;
		View view;
		LinearLayout ll;
		TextView t1;
		TextView t2;
		Group group;

		for (int i = 0; i < groups.size(); i++) {
			tr = new TableRow(this);
			tr.setLayoutParams(new TableRow.LayoutParams(LayoutParams.FILL_PARENT, LayoutParams.WRAP_CONTENT));

			group = groups.get(i);

			view = layoutInflater.inflate(R.layout.qrcode_group_row, null);

			ll = (LinearLayout)view.findViewById(R.id.qrcode_group_row_layout);
			ll.setBackgroundResource(R.drawable.list_bg_off);
			ll.setId(i);
			ll.setClickable(true);
			ll.setOnClickListener(this);
			t1 = (TextView)view.findViewById(R.id.qrcode_group_row_name);
			t2 = (TextView)view.findViewById(R.id.qrcode_group_row_count);
			t1.setText(group.type.toString());
			t2.setText("(" + String.valueOf(group.count) + ")");

			tr.addView(view);
			table.addView(tr, new TableLayout.LayoutParams(LayoutParams.FILL_PARENT, LayoutParams.WRAP_CONTENT));
		}
	}
}
*/
