package com.entropykorea.gas.chg.adapter;

import android.content.Context;
import android.database.Cursor;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.CursorAdapter;
import android.widget.TextView;

import com.entropykorea.gas.chg.R;
import com.entropykorea.gas.chg.common.WUtil;
/**
 * BldgListAdapter
 * @author softm
 *
 */
public class BldgListAdapter extends CursorAdapter {
	public BldgListAdapter(Context context, Cursor c, int flags) {
		super(context, c, flags);
	}

	@Override
	public View newView(Context context, Cursor cursor, ViewGroup parent) {
        LayoutInflater inflater = LayoutInflater.from(parent.getContext());
        parent.setPadding(0, 0, 0, 0);
        View v = inflater.inflate(R.layout.list_item_bldg_list, parent, false);
        v.setTag(R.id.bld_nm,(TextView)v.findViewById(R.id.bld_nm));
        v.setTag(R.id.tot_cnt,(TextView)v.findViewById(R.id.tot_cnt));          
        v.setTag(R.id.complete_cnt,(TextView)v.findViewById(R.id.complete_cnt));          
        return v;
	}

	@Override
	public void bindView(View view, Context context, Cursor cursor) {
		int p = cursor.getPosition();			
        TextView v1 = (TextView)view.getTag(R.id.bld_nm);
        v1.setText(cursor.getString(cursor.getColumnIndex("BLD_NM")));
        TextView v2 = (TextView)view.getTag(R.id.tot_cnt);
        v2.setText(WUtil.numberFormat("#,###",cursor.getInt(cursor.getColumnIndex("TOT_CNT"))));        
        TextView v3 = (TextView)view.getTag(R.id.complete_cnt);
        v3.setText(WUtil.numberFormat("#,###",cursor.getInt(cursor.getColumnIndex("COMPLETE_CNT"))));
        view.setTag(cursor.getString(cursor.getColumnIndex("KEY")));
//      view.setBackgroundColor(context.getResources().getColor(p%2==0?R.color.listEvenRow:R.color.listOddRow));
        view.setBackgroundResource(p % 2 == 0 ? R.drawable.listview_item_selector_1 : R.drawable.listview_item_selector_2 );
	}
}