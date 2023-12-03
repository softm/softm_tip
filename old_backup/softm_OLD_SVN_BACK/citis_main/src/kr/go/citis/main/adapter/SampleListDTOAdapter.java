package kr.go.citis.main.adapter;

import java.util.ArrayList;

import kr.go.citis.main.R;
import kr.go.citis.main.dto.SampleListDTO;

import org.apache.commons.lang3.StringUtils;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.TextView;
/**
 * SampleListDTOAdapter
 * @author softm
 *
 */
public class SampleListDTOAdapter extends BaseAdapter {
	Context mContext;
	LayoutInflater mInflater;
	ArrayList<SampleListDTO> mData;
 
	public SampleListDTOAdapter(Context context, LayoutInflater inflater,ArrayList<SampleListDTO> data) {
		mContext = context;
		mInflater = inflater;
		mData = data;
	}
	
	@Override
	public int getCount() {
		return mData.size();
	}

	@Override
	public SampleListDTO getItem(int position) {
		return mData.get(position);
	}

	@Override
	public long getItemId(int position) {
		return position;
	}

	@Override
	public View getView(int p, View v, ViewGroup parent) {
		SampleListDTO data = getItem(p);
		
        if (v == null) {
            v = mInflater.inflate(R.layout.list_item_sample_list, parent, false);
            v.setTag(R.id.tv_sample_1,(TextView)v.findViewById(R.id.tv_sample_1));  //        
            v.setTag(R.id.tv_sample_2,(TextView)v.findViewById(R.id.tv_sample_2));  //      
        }
        TextView v1 = (TextView)v.getTag(R.id.tv_sample_1);
        TextView v2 = (TextView)v.getTag(R.id.tv_sample_2);
        
        String s1 = null;
        String s2 = null;
		try {
			s1 = StringUtils.defaultString(data.getSample_1());
			s2 = StringUtils.defaultString(data.getSample_2());
		} catch (Exception e) {
			e.printStackTrace();
		}
        v1.setText( s1 );
        v2.setText( s2 );
        v.setBackgroundResource(p % 2 == 0 ? R.drawable.listview_item_selector_1 : R.drawable.listview_item_selector_2 );
        return v;        
	}

}


