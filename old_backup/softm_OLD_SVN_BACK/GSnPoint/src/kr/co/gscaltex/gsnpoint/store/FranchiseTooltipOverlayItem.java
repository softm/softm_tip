package kr.co.gscaltex.gsnpoint.store;

import kr.co.gscaltex.gsnpoint.dao.StoreInfoModel;

import com.google.android.maps.GeoPoint;
import com.google.android.maps.OverlayItem;

public class FranchiseTooltipOverlayItem extends OverlayItem {
	private StoreInfoModel mModel;
	public FranchiseTooltipOverlayItem(GeoPoint point, StoreInfoModel model){
        super(point, model.getFrch_cd() + model.getFrch_dtl_cd(), "");
        mModel = model;
    }
	
	public StoreInfoModel getModel(){
		return mModel;
	}
}
