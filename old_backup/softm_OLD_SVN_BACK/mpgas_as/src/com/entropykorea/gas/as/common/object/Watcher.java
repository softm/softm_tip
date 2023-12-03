package com.entropykorea.gas.as.common.object;

import java.math.BigDecimal;
import java.text.DecimalFormat;

import com.entropykorea.gas.as.common.util.StringUtil;

import android.text.Editable;
import android.text.TextWatcher;
import android.widget.EditText;
import android.widget.TextView;

public class Watcher implements TextWatcher {
  private DecimalFormat df = new DecimalFormat("###,###.####");
  private String result = "";
  private EditText edit;
  private TextView text1;
  private TextView text2;
  
  private long price = 0;
  
  public Watcher() {
  }
  
  public Watcher(EditText edit) {
    this.edit = edit;
  }
  
  public void setEditText(EditText edit) {
    this.edit = edit;
  }
  
  public void setText(TextView text1, TextView text2) {
    this.text1 = text1;
    this.text2 = text2;
  }
  
  public void setPrice(int price) {
    this.price = (long) price;
  }
  
  @Override
  public void afterTextChanged(Editable s) {
    // TODO Auto-generated method stub
  }
  
  @Override
  public void beforeTextChanged(CharSequence s, int start, int count, int after) {
    // TODO Auto-generated method stub
    
  }
  
  @Override
  public void onTextChanged(CharSequence s, int start, int before, int count) {
    try {
      if (!s.toString().equals(result)) { // StackOverflow를 막기위해,
        String sumPrice = "";
        String st = "";
        st = s.toString();
        long l = Long.valueOf(StringUtil.getFormatWonDe(st));
        BigDecimal b = BigDecimal.valueOf(l);
        BigDecimal b2 = BigDecimal.valueOf(price);
        BigDecimal sum = b.add(b2);
        
        sumPrice = String.valueOf(sum + "");
        
        result = df.format(Long.parseLong(s.toString().replaceAll(",", ""))); // 에딧텍스트의 값을 변환하여, result에 저장.
        edit.setText(result); // 결과 텍스트 셋팅.
        edit.setSelection(result.length()); // 커서를 제일 끝으로 보냄.
        
        sumPrice = df.format(Long.parseLong(sumPrice.replaceAll(",", "")));
        if (text1 != null) text1.setText(result);
        if (text2 != null) text2.setText(result);
      }
    } catch (NumberFormatException e) {
      result = "0";
      if (text1 != null) text1.setText(result);
      if (text2 != null) text2.setText(result);
    }
  }
}
