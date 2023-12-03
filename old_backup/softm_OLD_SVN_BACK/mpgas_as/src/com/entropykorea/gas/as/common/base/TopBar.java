package com.entropykorea.gas.as.common.base;

import android.content.Context;
import android.util.AttributeSet;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.ImageButton;
import android.widget.LinearLayout;
import android.widget.TextView;

import com.entropykorea.gas.as.R;

public class TopBar extends LinearLayout implements OnClickListener {
  
  private OnTopClickListner l;
  
  private ImageButton btnBack, btnOne, btnTwo;
  private TextView title;
  
  public TopBar(Context context) {
    super(context);
    init(context);
  }
  
  public TopBar(Context context, AttributeSet attrs) {
    super(context, attrs);
    init(context);
  }
  
  private void init(final Context context) {
    setOrientation(HORIZONTAL);
    LayoutInflater.from(context).inflate(R.layout.activity_topbar_as, this, true);
    
    btnBack = (ImageButton) findViewById(R.id.btn_back);
    btnBack.setOnClickListener(this);
    btnOne = (ImageButton) findViewById(R.id.btn_one);
    btnOne.setOnClickListener(this);
    btnTwo = (ImageButton) findViewById(R.id.btn_two);
    btnTwo.setOnClickListener(this);
    title = (TextView) findViewById(R.id.title);
  }
  
  protected void setOnTopBarButtonCollection(OnTopClickListner l) {
    this.l = l;
  }
  
  protected void setTopBarBackground(int resId1, int resId2, int resId3) {
    btnBack.setBackground(getResources().getDrawable(resId1));
    btnOne.setBackground(getResources().getDrawable(resId2));
    btnTwo.setBackground(getResources().getDrawable(resId3));
  }
  
  protected ImageButton getOneBtn() {
    return btnOne;
  }
  
  protected void setTopBarText(String str) {
    title.setText(str);
  }
  
  protected void setTwoBtnVisible(int visibility) {
    btnTwo.setVisibility(visibility);
  }
  
  protected void setTwoBtnImage(int resId) {
    btnTwo.setBackgroundResource(resId);
  }
  
  public interface OnTopClickListner {
    public void onClickBackButton(View v);
    
    public void onClickOneButton(View v);
    
    public void onClickTwoButton(View v);
  }
  
  @Override
  public void onClick(View v) {
    int viewID = v.getId();
    if (l == null) return;
    switch (viewID) {
      case R.id.btn_back:
        l.onClickBackButton(v);
        break;
      case R.id.btn_one:
        l.onClickOneButton(v);
        break;
      case R.id.btn_two:
        l.onClickTwoButton(v);
        break;
    }
  }
}
