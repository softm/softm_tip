package com.entropykorea.gas.chg.adapter;

import android.content.Context;
import android.database.Cursor;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.CursorAdapter;
import android.widget.TextView;

import com.entropykorea.gas.chg.R;
/**
 * TestAdapter
 * @author softm
 *
 */
public class TestAdapter extends CursorAdapter {
	public TestAdapter(Context context, Cursor c, int flags) {
		super(context, c, flags);
	}

	@Override
	public View newView(Context context, Cursor cursor, ViewGroup parent) {
        LayoutInflater inflater = LayoutInflater.from(parent.getContext());
        parent.setPadding(0, 0, 0, 0);
        View v = inflater.inflate(R.layout.list_item_test, parent, false);
        v.setTag(R.id.tv_cd,(TextView)v.findViewById(R.id.tv_cd));
        v.setTag(R.id.tv_cd_nm,(TextView)v.findViewById(R.id.tv_cd_nm));          
        return v;
	}

	@Override
	public void bindView(View view, Context context, Cursor cursor) {
		int p = cursor.getPosition();		
        TextView tvCd = (TextView)view.getTag(R.id.tv_cd);
        tvCd.setText(cursor.getString(cursor.getColumnIndex(cursor.getColumnName(1))));
        TextView tvCdNm = (TextView)view.getTag(R.id.tv_cd_nm);
        tvCdNm.setText(cursor.getString(cursor.getColumnIndex(cursor.getColumnName(2))));
//      view.setBackgroundColor(context.getResources().getColor(p%2==0?R.color.listEvenRow:R.color.listOddRow));
        view.setBackgroundResource(p % 2 == 0 ? R.drawable.listview_item_selector_1 : R.drawable.listview_item_selector_2 );
      
	}
}