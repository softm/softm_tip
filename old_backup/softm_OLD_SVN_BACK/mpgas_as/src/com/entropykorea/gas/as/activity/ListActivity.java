package com.entropykorea.gas.as.activity;

import java.util.ArrayList;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.view.LayoutInflater;
import android.view.MenuItem;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.LinearLayout;
import android.widget.ListView;
import android.widget.PopupMenu.OnMenuItemClickListener;
import android.widget.TextView;

import com.entropykorea.gas.as.AppContext;
import com.entropykorea.gas.as.R;
import com.entropykorea.gas.as.bean.Min;
import com.entropykorea.gas.as.common.base.BaseCode;
import com.entropykorea.gas.as.common.base.BasedActivity;
import com.entropykorea.gas.as.common.base.BasedActivity.OnMethod;
import com.entropykorea.gas.as.common.base.TopBar.OnTopClickListner;
import com.entropykorea.gas.as.common.object.Alert;
import com.entropykorea.gas.as.common.object.MLog;
import com.entropykorea.gas.as.common.util.StringUtil;
import com.entropykorea.gas.as.constants.MinCode;
import com.entropykorea.gas.as.database.DbManager_MIN;

public class ListActivity extends BasedActivity implements OnMethod, OnTopClickListner, OnClickListener, OnMenuItemClickListener {
  
  private Activity mActivity;
  private ListAdapter mAdapter;
  private EditText search_menu;
  private TextView END_YN;
  private String END_YN_Type = "C";
  private View footer = null;
  private ListView listView = null;
  
  // private String requireCd = "";
  
  @Override
  protected void onCreate(Bundle savedInstanceState) {
    super.onCreate(savedInstanceState);
    
    View mMainLayout = (View) getLayoutInflater().inflate(R.layout.activity_list_as, null);
    addTopView(mMainLayout);
    setTopBarText("민원목록");
    setTwoBtnVisible(View.VISIBLE);
    setTwoBtnImage(R.drawable.barcode_img);
    setOnTopClickListner(this);
    
    mActivity = this;
    
    init();
    
    arrangeView();
  }
  
  @Override
  protected void onResume() {
    super.onResume();
  }
  
  @Override
  public void init() {
    ImageButton search = (ImageButton) findViewById(R.id.search);
    search.setOnClickListener(this);
    search_menu = (EditText) findViewById(R.id.search_menu);
    END_YN = (TextView) findViewById(R.id.END_YN);
    END_YN.setOnClickListener(this);
    
    mAdapter = new ListAdapter();
    listView = (ListView) findViewById(R.id.min_list);
    listView.setAdapter(mAdapter);
  }
  
  @Override
  public void dbSelector() {
    ArrayList<Min> data = null;
    Handler h = new Handler();
    DbManager_MIN db = new DbManager_MIN();
    data = db.getTotalList(db.getAllColumns());
    if (data.size() == 0) return;
    
    minArray = data;
    
  }
  
  @Override
  public void arrangeView() {
    
    dbSelector();
    
    rowEmpty();
    
    mAdapter.notifyDataSetChanged();
    rowemptyEnable();
  }
  
  private void rowEmpty() {
    footer = ((LayoutInflater) context.getSystemService(context.LAYOUT_INFLATER_SERVICE)).inflate(R.layout.list_empty_row_as, null, false);
    listView.addFooterView(footer);
  }
  
  private void rowemptyEnable() {
    if (minArray.size() == 0) footer.setVisibility(View.VISIBLE);
    else footer.setVisibility(View.GONE);
  }
  
  private void searchEndDb() {
    String search = StringUtil.getString(search_menu);
    ArrayList<Min> data = null;
    Handler h = new Handler();
    DbManager_MIN db = new DbManager_MIN();
    if ("C".equals(END_YN_Type)) {
      data = db.getTotalList(db.getAllColumns());
    } else {
      data = db.getTotalList(db.getSearchColum(search, END_YN_Type));
    }
    
    minArray = data;
    MLog.d("searchEndDb count : " + minArray.size() + ",END_YN_Type :" + END_YN_Type);
    mAdapter.notifyDataSetChanged();
    rowemptyEnable();
  }
  
  private void searchDb() {
    String search = search_menu.getText().toString();
    ArrayList<Min> data = null;
    Handler h = new Handler();
    DbManager_MIN db = new DbManager_MIN();
    data = db.getTotalList(db.getSearchColum(search, END_YN_Type));
    
    minArray = data;
    MLog.d("searchDb count : " + minArray.size() + ",END_YN_Type :" + END_YN_Type);
    mAdapter.notifyDataSetChanged();
    rowemptyEnable();
  }
  
  private void setEND_YN() {
    String yn = "";
    if ("C".equals(END_YN_Type)) {
      yn = "완료";
      END_YN_Type = "Y";
    } else if ("Y".equals(END_YN_Type)) {
      yn = "미완료";
      END_YN_Type = "N";
    } else {
      yn = "전체";
      END_YN_Type = "C";
    }
    END_YN.setText(yn);
    searchEndDb();
  }
  
  private class ListAdapter extends BaseAdapter {
    private ViewHolder wrapper = null;
    
    @Override
    public int getCount() {
      // TODO Auto-generated method stub
      return minArray.size();
    }
    
    @Override
    public Object getItem(int position) {
      // TODO Auto-generated method stub
      return minArray.get(position);
    }
    
    @Override
    public long getItemId(int position) {
      // TODO Auto-generated method stub
      return position;
    }
    
    @Override
    public View getView(final int pos, View view, ViewGroup parent) {
      LayoutInflater inflater = ((Activity) mActivity).getLayoutInflater();
      if (view == null) {
        view = inflater.inflate(R.layout.activity_list_row_as, null);
        wrapper = new ViewHolder();
        
        wrapper.panel = (LinearLayout) view.findViewById(R.id.row_item_panel);
        wrapper.address = (TextView) view.findViewById(R.id.address);
        wrapper.acceptDt = (TextView) view.findViewById(R.id.acceptDt);
        wrapper.requireCd = (TextView) view.findViewById(R.id.requireCd);
        wrapper.pushYn = (TextView) view.findViewById(R.id.pushYn);
        wrapper.requestBeginDt = (TextView) view.findViewById(R.id.requestBeginDt);
        view.setTag(wrapper);
      } else {
        wrapper = (ViewHolder) view.getTag();
      }
      
      // wrapper.panel.setBackgroundColor(pos % 2 == 0 ? Color.parseColor("#3a4763") : Color.parseColor("#283953"));
      wrapper.panel.setBackgroundResource(pos % 2 == 0 ? R.drawable.listview_item_selector : R.drawable.listview_item2_selector);
      wrapper.address.setText(StringUtil.getAddress(minArray.get(pos)));
      wrapper.acceptDt.setText("접수일시 : " + minArray.get(pos).ACCEPT_DT.replace("-", "/").substring(5, 16));
      BaseCode mBaseCode = new BaseCode(AppContext.getSQLiteDatabase(), "RQ010");
      wrapper.requireCd.setText(mBaseCode.getNameByCode("RQ010",minArray.get(pos).REQUIRE_CD));
      wrapper.pushYn.setText(MinCode.getPushNm(minArray.get(pos).PUSH_REQ_YN));
      mBaseCode = new BaseCode(AppContext.getSQLiteDatabase(), "RQ060");
      wrapper.requestBeginDt.setText("예약 : " + mBaseCode.getNameByCode("RQ060",minArray.get(pos).REQUEST_BEGIN_DT) + " 시");
      view.setOnClickListener(new View.OnClickListener() {
        @Override
        public void onClick(View v) {
          startIntent(minArray.get(pos));
        }
      });
      
      return view;
    }
    
    class ViewHolder {
      public LinearLayout panel = null;
      public TextView address = null;// 주소
      public TextView requireCd = null;// 민원구분
      public TextView pushYn = null;// 독촉여부
      public TextView requestBeginDt = null;// 방문요청시작시각(예약시각)
      public TextView acceptDt = null;// 접수일시
    }
  }
  
  @Override
  public void onClick(View v) {
    Intent i = null;
    switch (v.getId()) {
      case R.id.search:
        searchDb();
        break;
      case R.id.END_YN:
        setEND_YN();
        break;
    
    }
  }
  
  @Override
  public void onClickBackButton(View v) {
    // TODO Auto-generated method stub
    
  }
  
  @Override
  public void onClickOneButton(View v) {
    // TODO Auto-generated method stub
    showMenu();
  }
  
  @Override
  public void onClickTwoButton(View v) {
    lanchScan(v);
  }
  
  public void showMenu() {
    View anchor = (View) findViewById(R.id.btn_one);
    showMenu(anchor, R.menu.main);
  }
  
  @Override
  public boolean onMenuItemClick(MenuItem item) {
    switch (item.getItemId()) {
      case R.id.menu_action_1:
        if (isInstalledApplication("com.entropykorea.gas.main")) {
          Intent intent = new Intent();
          intent.setClassName("com.entropykorea.gas.main", "com.entropykorea.gas.main.activity.AboutActivity");
          startActivity(intent);
        } else {
          Alert.alert(activity, getString(R.string.app_name) + " ver. " + getString(R.string.app_version), null);
        }
        break;
    }
    return false;
  }
}
