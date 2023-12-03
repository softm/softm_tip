package kr.co.gscaltex.gsnpoint.store;

import com.google.android.maps.GeoPoint;
import com.google.android.maps.OverlayItem;
import kr.co.gscaltex.gsnpoint.dao.StoreInfoModel;

public class FranchiseOverlayItem extends OverlayItem {
	private StoreInfoModel mModel;
	public FranchiseOverlayItem(GeoPoint point, StoreInfoModel model){
        super(point, model.getFrch_cd() + model.getFrch_dtl_cd(), "");
        mModel = model;
    }
	
	public StoreInfoModel getModel(){
		return mModel;
	}
	
	
}
