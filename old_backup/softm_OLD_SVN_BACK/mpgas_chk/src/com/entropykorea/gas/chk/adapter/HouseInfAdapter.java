package com.entropykorea.gas.chk.adapter;

import java.util.HashMap;

import org.apache.commons.lang3.StringUtils;

import android.content.Context;
import android.database.Cursor;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.CursorAdapter;
import android.widget.TextView;

import com.entropykorea.gas.chk.R;
import com.entropykorea.gas.chk.common.WUtil;
/**
 * HouseInfAdapter
 * @author softm
 *
 */
public class HouseInfAdapter extends CursorAdapter {
	public HouseInfAdapter(Context context, Cursor c, int flags) {
		super(context, c, flags);
	}
	
	@Override
	public View newView(Context context, Cursor cursor, ViewGroup parent) {
        LayoutInflater inflater = LayoutInflater.from(parent.getContext());
        parent.setPadding(0, 0, 0, 0);
        View v = inflater.inflate(R.layout.list_item_house_inf, parent, false);
        v.setTag(R.id.tv_v1,(TextView)v.findViewById(R.id.tv_v1));        
        v.setTag(R.id.tv_v2,(TextView)v.findViewById(R.id.tv_v2));      
        return v;
	}

	@Override
	public void bindView(View view, Context context, Cursor cursor) {
		int p = cursor.getPosition();
        TextView v1 = (TextView)view.getTag(R.id.tv_v1);
        String visitDt     = WUtil.toDefault(cursor.getString(cursor.getColumnIndex("VISIT_DT")));
//        String visitTm     = WUtil.toDefault(cursor.getString(cursor.getColumnIndex("VISIT_TM")));
        String vistResultNm= WUtil.toDefault(cursor.getString(cursor.getColumnIndex("VISIT_RESULT_NM"  )));
        
        v1.setText( visitDt ); 
        TextView v2 = (TextView)view.getTag(R.id.tv_v2);     
        v2.setText(vistResultNm);
//        view.setBackgroundColor(context.getResources().getColor(p%2==0?R.color.listEvenRow:R.color.listOddRow));
        view.setBackgroundResource(p % 2 == 0 ? R.drawable.listview_item_selector_1 : R.drawable.listview_item_selector_2 );
	}
}


