package kr.co.gscaltex.gsnpoint.store;

import java.util.ArrayList;
import java.util.List;

import kr.co.gscaltex.gsnpoint.dao.StoreInfoModel;
import android.graphics.drawable.Drawable;

import com.google.android.maps.GeoPoint;
import com.google.android.maps.ItemizedOverlay;
import com.google.android.maps.OverlayItem;


public class FranchisesOverlay extends ItemizedOverlay<FranchiseOverlayItem> implements ItemizedOverlay.OnFocusChangeListener{
	
	protected List<FranchiseOverlayItem> mItems = new ArrayList<FranchiseOverlayItem>();

	public FranchisesOverlay(Drawable defaultMarker) {
    	super( boundCenterBottom(defaultMarker) );
    	this.setOnFocusChangeListener(this);
        this.populate();//�������� ������� ��ġ�ϸ� ������ �߻��ϹǷ� �ѹ� ȣ���Ѵ�.
    }

	
    protected FranchiseOverlayItem createItem(int i) {
    	return mItems.get(i);
    }
    
    
    public int size() {
    	return mItems.size();
    }
    
    public List<FranchiseOverlayItem> getOveryItemArray(){
    	return mItems;
    }
    
    public void clearItems(){
    	mCurrentSelectItem = null;
		mItems.clear();
		setLastFocusedIndex(-1);
    	this.populate();
    }
    
    public void addItems(ArrayList<StoreInfoModel> items, Drawable itemDrawable1, Drawable itemDrawable2, Drawable itemDrawable3, Drawable itemDrawable4){
		setLastFocusedIndex(-1);
		GeoPoint gp = null;
		for( StoreInfoModel item : items ){
			gp = new GeoPoint(
						(int)(Double.valueOf(item.getLat())*1E6), 
						(int)(Double.valueOf(item.getLongi())*1E6));
						
			Drawable itemDrawable = itemDrawable3;
			if(item.getBusi_cd().equals("20000")){
				itemDrawable = itemDrawable2;
			}else if(item.getBusi_cd().equals("10000")){
				itemDrawable = itemDrawable1;
			}else if(item.getBusi_cd().equals("30000")) {
				itemDrawable = itemDrawable3;
			}else if(item.getBusi_cd().equals("90000")) {
				itemDrawable = itemDrawable4;
			}
				
			FranchiseOverlayItem itemOverlay = new FranchiseOverlayItem(gp, item);
			itemOverlay.setMarker(boundCenterBottom(itemDrawable));
			
			mItems.add(itemOverlay);

		}
    	populate();
    }
    
    public void addItems2(Drawable itemDrawable1,GeoPoint gp){
 
		setLastFocusedIndex(-1);
			Drawable itemDrawable = itemDrawable1;
			StoreInfoModel item = new StoreInfoModel();
			item.setFrch_cd("1");
			item.setFrch_dtl_cd("1");
			FranchiseOverlayItem itemOverlay = new FranchiseOverlayItem(gp, item);
			itemOverlay.setMarker(boundCenterBottom(itemDrawable));
			
			mItems.add(itemOverlay);
    	populate();
}

    private FranchiseOverlayItem mCurrentSelectItem = null;
    
    
    public void onFocusChanged(ItemizedOverlay overlay, OverlayItem newFocus) {
    	if( overlay != null && overlay instanceof FranchisesOverlay){
	    	if( newFocus!= null && newFocus instanceof FranchiseOverlayItem ){
	    		mCurrentSelectItem = (FranchiseOverlayItem)newFocus;
	    		
	    		if( mOnSelectedListener != null ){
	    			mOnSelectedListener.onFranchiseSelect((FranchisesOverlay)overlay, mCurrentSelectItem);
	    		}
	    	}else{
	    		mCurrentSelectItem = null;
	    		
	    		if( mOnSelectedListener != null ){
	    			mOnSelectedListener.onFranchiseSelect((FranchisesOverlay)overlay, mCurrentSelectItem);
	    		}
	    	}
    	}else{
    		
    	}
    }
    
    private IFranchiseSelect mOnSelectedListener = null;
    public void setOnSelectedItemListener(IFranchiseSelect listener){
    	mOnSelectedListener = listener;
    }
    
    interface IFranchiseSelect {
    	void onFranchiseSelect(FranchisesOverlay overlay, FranchiseOverlayItem item);
    }
}
