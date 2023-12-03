package kr.co.gscaltex.gsnpoint.point;

import java.util.ArrayList;
import java.util.List;

import android.content.Context;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;

public class PointAffiliateListAdapter extends BaseAdapter {
	
	private Context mContext;
	
	private boolean mIsReadAll = false;
	private int mPage = 0;
	private boolean mIsProcessing = false;
	
	//private ArrayList<NoticeModel> mList = new ArrayList<NoticeModel>();
	
//	public ArrayList<NoticeModel> getNoticeList(){
//		return mList;
//	}
	
	public void startProcessing(){
		mIsProcessing = true;
	}
	
	public void endProcessing(){
		mIsProcessing = false;
	}
	
	public boolean isProcessing(){
		return mIsProcessing;
	}
	
	public boolean isReadAll(){
		return mIsReadAll;
	}
	
	public void setReadAll(boolean readAll){
		mIsReadAll = readAll;
	}
	
	public void setNextPage(){
		mPage++;
	}
	
	public void setPrevPage(){
		mPage--;
	}

	public void setPage(int page){
		this.mPage= page;
	}
	
	public int getPage(){
		return mPage;
	}

	private List<PointAffiliateListTextItem> mItems = new ArrayList<PointAffiliateListTextItem>();

	public PointAffiliateListAdapter(Context context) {
		mContext = context;
	}
	
	public void addItem(PointAffiliateListTextItem it) {
		mItems.add(it);
	}

	public void clearItem(){
		mItems.clear();
	}
	public void setListItems(List<PointAffiliateListTextItem> lit) {
		mItems = lit;
	}

	public int getCount() {
		return mItems.size();
	}

	public Object getItem(int position) {
		return mItems.get(position);
	}

	public boolean areAllItemsSelectable() {
		return false;
	}

	public boolean isSelectable(int position) {
		try {
			return mItems.get(position).ismSelectable();
		} catch (IndexOutOfBoundsException ex) {
			return false;
		}
	}

	public long getItemId(int position) {
		return position;
	}

	public View getView(int position, View convertView, ViewGroup parent) {
		PointAffiliateListTextView itemView;
		
		if (convertView == null) {
			itemView = new PointAffiliateListTextView(mContext, mItems.get(position));
		} else {
			itemView = (PointAffiliateListTextView) convertView;			
	
			itemView.setText(0, mItems.get(position).getmData()[0]);
			itemView.setText(1, mItems.get(position).getmData()[1]);
			itemView.setText(2, mItems.get(position).getmData()[2]);
			itemView.setText(3, mItems.get(position).getmData()[3]);
		}
		return itemView;
	}
	
}


