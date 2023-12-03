package com.entropykorea.gas.chg.adapter;

import java.util.HashMap;

import android.content.Context;
import android.database.Cursor;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.CursorAdapter;
import android.widget.TextView;

import com.entropykorea.gas.chg.R;
/**
 * HouseListAdapter
 * @author softm
 *
 */
public class HouseListAdapter extends CursorAdapter {
	public HouseListAdapter(Context context, Cursor c, int flags) {
		super(context, c, flags);
	}

	@Override
	public View newView(Context context, Cursor cursor, ViewGroup parent) {
        LayoutInflater inflater = LayoutInflater.from(parent.getContext());
        parent.setPadding(0, 0, 0, 0);
        View v = inflater.inflate(R.layout.list_item_house_list, parent, false);
        v.setTag(R.id.tv_bldg_info,(TextView)v.findViewById(R.id.tv_bldg_info));  // 호수 / 상호        
        v.setTag(R.id.tv_end_yn,(TextView)v.findViewById(R.id.tv_end_yn));  // 상태      
        return v;
	}

	@Override
	public void bindView(View view, Context context, Cursor cursor) {
		int p = cursor.getPosition();			
        TextView v1 = (TextView)view.getTag(R.id.tv_bldg_info); // 호수 / 상호        
        String roomNo = cursor.getString(cursor.getColumnIndex("ROOM_NO"));
        String coNm   = cursor.getString(cursor.getColumnIndex("CO_NM"  ));
        roomNo = (roomNo != null )?roomNo:"";
        coNm   = (coNm != null )?coNm:"";
        v1.setText( roomNo + " " + coNm ); 
        TextView v2 = (TextView)view.getTag(R.id.tv_end_yn); // 상태        
        v2.setText(cursor.getString(cursor.getColumnIndex("END_YN")));
        HashMap<String, String> key = new HashMap<String, String>();
        key.put("GM_CHG_YM"  , cursor.getString(cursor.getColumnIndex("GM_CHG_YM"  ))); // 작업년월(PK)
        key.put("HOUSE_NO", cursor.getString(cursor.getColumnIndex("HOUSE_NO"))); // 수용가번호(PK)
        key.put("CUST_NO" , cursor.getString(cursor.getColumnIndex("CUST_NO" ))); // 고객번호(PK)
        view.setTag(key);
//        view.setBackgroundColor(context.getResources().getColor(p%2==0?R.color.listEvenRow:R.color.listOddRow));
        view.setBackgroundResource(p % 2 == 0 ? R.drawable.listview_item_selector_1 : R.drawable.listview_item_selector_2 );
        
	}
}


