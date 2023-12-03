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
import com.entropykorea.gas.lib.Util;
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
        String roomNo = WUtil.toDefault(cursor.getString(cursor.getColumnIndex("ROOM_NO")));
        String fakeRoomNo = WUtil.toDefault(cursor.getString(cursor.getColumnIndex("FAKE_ROOM_NO")));
        String coNm   = WUtil.toDefault(cursor.getString(cursor.getColumnIndex("CO_NM"  )));
        
        v1.setText( roomNo + " " + (StringUtils.isNotEmpty(fakeRoomNo)?" " + fakeRoomNo:"") + coNm ); 
        TextView v2 = (TextView)view.getTag(R.id.tv_end_yn); // 상태     
        v2.setText(cursor.getString(cursor.getColumnIndex("END_YN")));
        HashMap<String, String> key = new HashMap<String, String>();
        key.put("CHECKUP_YM"  , cursor.getString(cursor.getColumnIndex("CHECKUP_YM"  ))); // 작업년월(PK)
        key.put("CHECKUP_CD"  , cursor.getString(cursor.getColumnIndex("CHECKUP_CD"  ))); // 업무코드(PK)
        key.put("HOUSE_NO", cursor.getString(cursor.getColumnIndex("HOUSE_NO"))); // 수용가번호(PK)
        key.put("FAKE_HOUSE_NO" , cursor.getString(cursor.getColumnIndex("FAKE_HOUSE_NO" ))); // 가수용가번호(PK)
        view.setTag(key);
        Util.i(key.toString());
//        view.setBackgroundColor(context.getResources().getColor(p%2==0?R.color.listEvenRow:R.color.listOddRow));
        view.setBackgroundResource(p % 2 == 0 ? R.drawable.listview_item_selector_1 : R.drawable.listview_item_selector_2 );
	}
}


