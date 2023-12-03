package com.entropykorea.gas.chk.adapter;

import java.util.HashMap;

import android.annotation.SuppressLint;
import android.content.Context;
import android.database.Cursor;
import android.view.LayoutInflater;
import android.view.MotionEvent;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemSelectedListener;
import android.widget.ArrayAdapter;
import android.widget.CheckBox;
import android.widget.CursorAdapter;
import android.widget.TextView;

import com.entropykorea.gas.chk.R;
import com.entropykorea.gas.chk.activity.MngBoilerChkActivity;
import com.entropykorea.gas.chk.common.WUtil;
import com.entropykorea.gas.lib.AppContext;
import com.entropykorea.gas.lib.SpinnerCd;
/**
 * MngBoilerChkAdapter
 * @author softm
 *
 */
@SuppressLint("ResourceAsColor")
public class MngBoilerChkAdapter extends CursorAdapter {
	private Context context = null;
	public MngBoilerChkAdapter(Context context, Cursor c, int flags) {
		super(context, c, flags);
		this.context = context;
	}
	@Override
	public View newView(Context context, Cursor cursor, ViewGroup parent) {
        LayoutInflater inflater = LayoutInflater.from(parent.getContext());
        parent.setPadding(0, 0, 0, 0);
        View v = inflater.inflate(R.layout.list_item_mng_nocfm, parent, false);
        v.setTag(R.id.tv_v1,(TextView)v.findViewById(R.id.tv_v1));        
        
        SpinnerCd spnCd = (SpinnerCd)v.findViewById(R.id.spn_v2);
		ArrayAdapter<CharSequence> adapter = ArrayAdapter.createFromResource(context, R.array.array_nocfm_list,
                android.R.layout.simple_spinner_item);
	    adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
	    spnCd.setFontSize(25);
	    spnCd.setAdapter(adapter);
	    spnCd.setDialogVisible(false);
	    final int position = cursor.getPosition();	    
	    spnCd.setOnTouchListener(new View.OnTouchListener() {
			@Override
			public boolean onTouch(View v, MotionEvent event) {
				SpinnerCd spnCd = (SpinnerCd)v;
				if ( event.getAction() == MotionEvent.ACTION_UP ) {
	                int idx = spnCd.getSelected();
	                spnCd.setSelected(idx^1);
	                setSaved(position,idx^1);	                
	                MngBoilerChkActivity activity = (MngBoilerChkActivity)MngBoilerChkAdapter.this.context;
	                activity.fChgBuSpan();
				}
//			      activity.onCheckedChanged(((CheckBox)(activity.findViewById(R.id.rd_none))), Boolean.FALSE);
//			      ((CheckBox)(activity.findViewById(R.id.rd_none))).setChecked(Boolean.TRUE);
//			      ((CheckBox)(activity.findViewById(R.id.rd_none))).setChecked(Boolean.FALSE);
				return false;
			}
		});
	    spnCd.setOnItemSelectedListener(new OnItemSelectedListener() {
			public void onItemSelected(AdapterView<?> parent, View view,	int position, long id) {
				  ((TextView) parent.getChildAt(0)).setTextColor(R.color.spnFontColor);				
			      ((TextView) parent.getChildAt(0)).setTextSize(15);
			}
			public void onNothingSelected(AdapterView<?>  parent) {
	//				if ( "".equals(spnCd.getValue()) ) {
	//					spnCd.setValue(ConstantChg.CODE_END_Y);
	//				}				
			}
		});        
	    v.setTag(R.id.spn_v2,spnCd);
        return v;
	}

	@Override
	public void bindView(View view, Context context, Cursor cursor) {
		int p = cursor.getPosition();
        TextView v1 = (TextView)view.getTag(R.id.tv_v1);
        String s1     = WUtil.toDefault(cursor.getString(cursor.getColumnIndex("CHECKUP_REMARK_NM")));
        String s2 = WUtil.toDefault(cursor.getString(cursor.getColumnIndex("CHECKUP_REMARK_CD"  )));
        String s3 = WUtil.toDefault(cursor.getString(cursor.getColumnIndex("FA_CD"  )));
        
        String jumCheckupRemarkCd = WUtil.toDefault(cursor.getString(cursor.getColumnIndex("JUM_CHECKUP_REMARK_CD"  )));
        v1.setText( s1 ); 
        SpinnerCd v2 = (SpinnerCd)view.getTag(R.id.spn_v2);     
        v2.setSelected(!"".equals(jumCheckupRemarkCd)?1:0);
        MngBoilerChkActivity activity = (MngBoilerChkActivity)MngBoilerChkAdapter.this.context;
        if ( ((CheckBox)activity.findViewById(R.id.rd_none)).isChecked() ) {
            v2.setSelected(2); // 기기없음.
            v2.setEnabled(Boolean.FALSE);
        } else {
        	if (getSaved(p) > -1) {
        		v2.setSelected(getSaved(p));
        	}
        }
//        view.setBackgroundColor(context.getResources().getColor(p%2==0?R.color.listEvenRow:R.color.listOddRow));
        HashMap<String, String> key = new HashMap<String, String>();
        key.put("CHECKUP_REMARK_NM"  , s1);
        key.put("CHECKUP_REMARK_CD"  , s2);
        key.put("FA_CD"              , s3);
        view.setTag(key);
//        Util.i("test",s1+"/"+s2+"/"+s3);
        view.setBackgroundResource(p % 2 == 0 ? R.drawable.listview_item_selector_1 : R.drawable.listview_item_selector_2 );
        
    	if ( !"".equals(jumCheckupRemarkCd) ) {
    		activity.findViewById(R.id.ib_camera).setVisibility(View.VISIBLE);
    	}
//		      activity.fChgBuSpan();
//		      activity.onCheckedChanged((CheckBox)activity.findViewById(R.id.rd_none), ((CheckBox)activity.findViewById(R.id.rd_none)).isChecked());
	}
	private void setSaved(int position,int value) {
        HashMap<Integer,Integer> saved = null;
		if ( AppContext.getValue("ADAPTER_SAVED") == null ) {
			AppContext.putValue("ADAPTER_SAVED", new HashMap<Integer,Integer>());
			saved = AppContext.getValue("ADAPTER_SAVED");
		} else {
			saved = AppContext.getValue("ADAPTER_SAVED");
		}
		saved.put(position,value);
		AppContext.putValue("ADAPTER_SAVED", saved);
	}

	@SuppressLint("UseSparseArrays")
	private int getSaved(int position) {
        HashMap<Integer,Integer> saved = null;
		if ( AppContext.getValue("ADAPTER_SAVED") == null ) {
			AppContext.putValue("ADAPTER_SAVED", new HashMap<Integer,Integer>());
			saved = AppContext.getValue("ADAPTER_SAVED");			
		} else {
			saved = AppContext.getValue("ADAPTER_SAVED");
		}
        return saved.get(position)==null?-1:saved.get(position);
	}
	
}


