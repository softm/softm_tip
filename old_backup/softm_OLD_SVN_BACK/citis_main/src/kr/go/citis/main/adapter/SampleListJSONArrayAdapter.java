package kr.go.citis.main.adapter;

import kr.go.citis.main.R;

import org.apache.commons.lang3.StringUtils;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.TextView;
/**
 * HouseListAdapter
 * @author softm
 *
 */
public class SampleListJSONArrayAdapter extends BaseAdapter {
	Context mContext;
	LayoutInflater mInflater;
	JSONArray mJsonArray;
 
	public SampleListJSONArrayAdapter(Context context, LayoutInflater inflater,JSONArray jsr) {
		mContext = context;
		mInflater = inflater;
		mJsonArray = jsr;
	}
	
	@Override
	public int getCount() {
		return mJsonArray.length();
	}

	@Override
	public JSONObject getItem(int position) {
		return mJsonArray.optJSONObject(position);
	}

	@Override
	public long getItemId(int position) {
		return position;
	}

	@Override
	public View getView(int p, View v, ViewGroup parent) {
		JSONObject jsonObject = getItem(p);
		
        if (v == null) {
            v = mInflater.inflate(R.layout.list_item_sample_list, parent, false);
            v.setTag(R.id.tv_sample_1,(TextView)v.findViewById(R.id.tv_sample_1));  //        
            v.setTag(R.id.tv_sample_2,(TextView)v.findViewById(R.id.tv_sample_2));  //      
        }
        TextView v1 = (TextView)v.getTag(R.id.tv_sample_1);
        TextView v2 = (TextView)v.getTag(R.id.tv_sample_2);
//        android.support.v7.recyclerview.
        String s1 = null;
        String s2 = null;
		try {
			s1 = StringUtils.defaultString(jsonObject.getString("sample_1"));
			s2 = StringUtils.defaultString(jsonObject.getString("sample_2"));
		} catch (JSONException e) {
			e.printStackTrace();
		}
        v1.setText( s1 );
        v2.setText( s2 );
        v.setBackgroundResource(p % 2 == 0 ? R.drawable.listview_item_selector_1 : R.drawable.listview_item_selector_2 );
        return v;        
	}

}


