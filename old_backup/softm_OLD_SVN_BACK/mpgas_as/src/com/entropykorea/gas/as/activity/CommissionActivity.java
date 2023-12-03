package com.entropykorea.gas.as.activity;

import java.util.ArrayList;
import java.util.List;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.view.LayoutInflater;
import android.view.MenuItem;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemSelectedListener;
import android.widget.ArrayAdapter;
import android.widget.BaseAdapter;
import android.widget.ListView;
import android.widget.PopupMenu.OnMenuItemClickListener;
import android.widget.Spinner;
import android.widget.TextView;

import com.entropykorea.gas.as.R;
import com.entropykorea.gas.as.bean.Min;
import com.entropykorea.gas.as.bean.MinFee;
import com.entropykorea.gas.as.bean.MinFeePay;
import com.entropykorea.gas.as.common.base.BasedActivity;
import com.entropykorea.gas.as.common.base.BasedActivity.OnMethod;
import com.entropykorea.gas.as.common.base.TopBar.OnTopClickListner;
import com.entropykorea.gas.as.common.object.Alert;
import com.entropykorea.gas.as.common.object.MLog;
import com.entropykorea.gas.as.common.util.StringUtil;
import com.entropykorea.gas.as.constants.Constant;
import com.entropykorea.gas.as.database.DbManager_MIN_FEE;
import com.entropykorea.gas.as.database.DbManager_MIN_FEE_PAY;

public class CommissionActivity extends BasedActivity implements OnMethod, OnTopClickListner, OnClickListener, OnMenuItemClickListener {
  
  private FeeAdapter mAdapter = null;
  private TextView ADDRESS = null;
  
  private View sumFooter = null;
  private ListView listView = null;
  
  private ArrayList<MinFee> mFeeArray = null; // 수수료 데이터
  private ArrayList<MinFeePay> mFeepayArray = null; // 수수료 선택한 데이터
  // private ArrayList<MinFeePay> mFpArray = new ArrayList<MinFeePay>();
  private List<String> categories = null;
  
  private int totalPrice = 0;
  private int spinnerCnt = 10;
  
  private boolean spinnerSelected = false;
  
  @Override
  protected void onCreate(Bundle savedInstanceState) {
    super.onCreate(savedInstanceState);
    
    View mMainLayout = (View) getLayoutInflater().inflate(R.layout.activity_commission_as, null);
    addTopView(mMainLayout);
    setTopBarText("수수료");
    setOnTopClickListner(this);
    
    activity = this;
    
    init();
    arrangeView();
    spinner();
    footerSum();
  }
  
  @Override
  public void init() {
    // -----------------------
    ADDRESS = (TextView) findViewById(R.id.ADDRESS); // 주소
    findViewById(R.id.btn_close).setOnClickListener(this);
    findViewById(R.id.b_commit).setOnClickListener(this);
    sumFooter = getLayoutInflater().inflate(R.layout.activity_commsion_footer_as, null);
  }
  
  @Override
  public void dbSelector() {
    Handler h = new Handler();
    DbManager_MIN_FEE db = new DbManager_MIN_FEE();
    mFeeArray = db.getTotalList(db.getItemCdColumn(minD.AREA_CD));
    
    DbManager_MIN_FEE_PAY db2 = new DbManager_MIN_FEE_PAY();
    mFeepayArray = db2.getTotalList(db2.getColumn(minD));
    
    if (mFeepayArray.size() > 0) {
      try {
        for (int i = 0, k = 0; i < mFeeArray.size(); i++) {
          if (mFeepayArray.get(k).ITEM_CD.equals(mFeeArray.get(i).ITEM_CD)) {
            mFeeArray.get(i).PROC_QTY = mFeepayArray.get(k++).PROC_QTY;
          }
        }
      } catch (Exception e) {
      }
      spinnerSelected = true;
      // mFpArray = mFpArray;
    }
  }
  
  @Override
  public void arrangeView() {
    minD = (Min) getExtra();
    if (minD == null) return;
    
    if (mFeeArray == null) dbSelector();
    
    ADDRESS.setText(StringUtil.getAddress(minD));
    
    if (mAdapter == null) {
      mAdapter = new FeeAdapter();
      listView = (ListView) findViewById(R.id.fee_list);
      listView.setAdapter(mAdapter);
    }
  }
  
  @Override
  public void onBackPressed() {
    onfinish();
    super.onBackPressed();
  }
  
  public void onfinish() {
    minD.PAID_FEE_PRICE = totalPrice + "";
    onFinish(minD, RESULT_OK);
  }
  
  public void updateFeePayDb() {
    Handler h = new Handler() {
      @Override
      public void handleMessage(Message msg) {
        super.handleMessage(msg);
        MLog.e("Code result: " + msg.hashCode() + ",what:" + msg.what);
        if (msg.what == Constant.RESULT_SUCCESS) {
          MLog.e("Code db: RESULT_SUCCESS");
          Alert.alert(activity, getString(R.string.msg_saved), "onfinish");
        } else {
          MLog.e("Code db: RESULT_FAILL");
        }
      }
    };
    
    DbManager_MIN_FEE_PAY db = new DbManager_MIN_FEE_PAY();
    db.DbHandler(h);
    MinFeePay mfp = new MinFeePay();
    for (int i = 0; i <= mFeeArray.size(); i++) {
      try {
        mfp.REQUIRE_IDX = minD.REQUIRE_IDX + "";
        mfp.AREA_CD = mFeeArray.get(i).AREA_CD;
        mfp.ITEM_CD = mFeeArray.get(i).ITEM_CD;
        mfp.PROC_UNIT_PRICE = mFeeArray.get(i).PROC_UNIT_PRICE + "";
        mfp.PROC_QTY = mFeeArray.get(i).PROC_QTY;
        db.deleteColumn(mfp);
        
        db.insertColumn(mfp);
      } catch (Exception e) {
      }
    }
  }
  
  private void getPriceSum() {
    int price = 0;
    int qty = 0;
    totalPrice = 0;
    
    if (mFeeArray.size() == 0) return;
    for (int i = 0; i < mFeeArray.size(); i++) {
      if (mFeeArray.get(i).PROC_QTY > 0) {
        MLog.d("totalPrice : " + totalPrice);
        totalPrice += (mFeeArray.get(i).PROC_UNIT_PRICE * mFeeArray.get(i).PROC_QTY);
      }
    }
  }
  
  private void footerSum() {
    
    if (listView.getFooterViewsCount() != 0) listView.removeFooterView(sumFooter);
    TextView column1 = (TextView) sumFooter.findViewById(R.id.column1);
    TextView column3 = (TextView) sumFooter.findViewById(R.id.column3);
    
    if (mFeeArray.size() > 0) {
      // TOT_FEE_PRICE = PayUtil.getFeePriceSum(minFeeArray) + spinnerChecP;
      // feeP = checKSum;
      column3.setText(StringUtil.formatWonEn(totalPrice + "") + " 원");
    } else {
      column3.setText("0");
    }
    column1.setText("수수료 합계");
    
    listView.removeFooterView(sumFooter);
    if (listView.getFooterViewsCount() == 0) listView.addFooterView(sumFooter);
    
    mAdapter.notifyDataSetChanged();
    listView.invalidateViews();
    rowAddHeight();
  }
  
  /**
   * 리스트 셀 단위 높이 생성
   * 
   * @param listView
   */
  private void rowAddHeight() {
    if (listView.getCount() == 0) return;
    int totalHeight = 0;
    View listItem = null;
    for (int i = 0; i <= mAdapter.getCount(); i++) {
      try {
        listItem = mAdapter.getView(i, null, listView);
        listItem.measure(0, 0);
      } catch (Exception e) {
      }
      totalHeight += listItem.getMeasuredHeight();
    }
    
    ViewGroup.LayoutParams params = listView.getLayoutParams();
    params.height = totalHeight + (listView.getDividerHeight() * (listView.getCount()));
    listView.setLayoutParams(params);
    listView.requestLayout();
  }
  
  private void spinner() {
    categories = new ArrayList<String>();
    for (int i = 0; i <= spinnerCnt; i++) {
      categories.add("" + i);
    }
  }
  
  class FeeAdapter extends BaseAdapter {
    private ViewHolder wrapper = null;
    private ArrayAdapter<String> dataAdapter = null;
    private MinFee mf = null;
    
    @Override
    public int getCount() {
      return mFeeArray.size();
    }
    
    @Override
    public Object getItem(int position) {
      return mFeeArray.get(position);
    }
    
    @Override
    public long getItemId(int position) {
      return position;
    }
    
    @Override
    public View getView(final int position, View view, ViewGroup parent) {
      LayoutInflater inflater = ((Activity) activity).getLayoutInflater();
      if (view == null) {
        view = inflater.inflate(R.layout.activity_commsion_row_as, null);
        wrapper = new ViewHolder();
        
        wrapper.column1 = (TextView) view.findViewById(R.id.column1);
        wrapper.column2 = (TextView) view.findViewById(R.id.column2);
        wrapper.spinner = (Spinner) view.findViewById(R.id.spinner);
        
        // dataAdapter = new ArrayAdapter<String>(mActivity, android.R.layout.simple_spinner_item, categories);
        dataAdapter = new ArrayAdapter<String>(activity, android.R.layout.simple_spinner_item, categories);
        dataAdapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        
        wrapper.spinner.setAdapter(dataAdapter);
        view.setTag(wrapper);
      } else {
        wrapper = (ViewHolder) view.getTag();
      }
      mf = mFeeArray.get(position);
      
      wrapper.column1.setText(mf.ITEM_NM);
      wrapper.column2.setText(StringUtil.formatWonEn(mf.PROC_UNIT_PRICE + ""));
      
      if (spinnerSelected) {
        wrapper.spinner.setSelection(mFeeArray.get(position).PROC_QTY);
        // try {
        // if (mFArray.get(position).ITEM_CD.equals(mf.ITEM_CD)) {
        // wrapper.spinner.setSelection(StringUtil.getInteger(mFArray.get(position).PROC_QTY));
        // }
        // } catch (Exception e) {
        // }
      }
      
      wrapper.spinner.setOnItemSelectedListener(new OnItemSelectedListener() {
        
        @Override
        public void onItemSelected(AdapterView<?> parent, View view, int poi, long id) {
          
          String item = parent.getItemAtPosition(poi).toString();
          
          int qty = StringUtil.getInteger(item);
          mFeeArray.get(position).PROC_QTY = qty;
          getPriceSum();
          
          if (!"".equals(item)) {
            spinnerSelected = false;
            footerSum();
          }
          // Toast.makeText(parent.getContext(), "Selected: " + item, Toast.LENGTH_LONG).show();
        }
        
        @Override
        public void onNothingSelected(AdapterView<?> arg0) {
          // TODO Auto-generated method stub
        }
      });
      return view;
    }
    
    class ViewHolder {
      public TextView column1 = null;
      public TextView column2 = null;
      public Spinner spinner = null;
    }
  }
  
  @Override
  public void onClick(View v) {
    switch (v.getId()) {
      case R.id.btn_close:
        onfinish();
        break;
      case R.id.b_commit:
        updateFeePayDb();
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
    // TODO Auto-generated method stub
    onResultActivity(CustomActivity.class, minD);
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
