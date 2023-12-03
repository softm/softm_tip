package kr.go.citis.main.adapter;

import java.util.ArrayList;

import kr.go.citis.main.R;
import kr.go.citis.main.activity.PhotoMngActivity;
import kr.go.citis.main.common.WConstant;
import kr.go.citis.main.common.WUtil;
import kr.go.citis.main.dto.PicMngListDTO;
import android.content.Context;
import android.support.v7.widget.RecyclerView;
import android.support.v7.widget.RecyclerView.AdapterDataObserver;
import android.text.Html;
import android.view.KeyEvent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.TextView;
/**
 * PhotoMngAdapter
 * @author softm
 *
 */
public class PhotoMngAdapter extends RecyclerView.Adapter<PhotoMngAdapter.ViewHolder> {		
	Context mContext;
	LayoutInflater mInflater;
	ArrayList<PicMngListDTO> items;
    private int selectedItem = 0;	
	public final static int ITEM_VIEW_TYPE_READ = 0;
	public final static int ITEM_VIEW_TYPE_EDIT = 1;
	public PhotoMngAdapter(Context context, LayoutInflater inflater,ArrayList<PicMngListDTO> data) {
		mContext = context;
		mInflater = inflater;
		items = data;
	}

	public Context getmContext() {
		return mContext;
	}

	public void setmContext(Context mContext) {
		this.mContext = mContext;
	}

	public ArrayList<PicMngListDTO> getItems() {
		return items;
	}

	public void setItems(ArrayList<PicMngListDTO> items) {
		this.items = items;
	}

	public void addItem(PicMngListDTO item) {
		selectedItem = 0;
		this.items.add(0,item);
	}

	public class ViewHolder extends RecyclerView.ViewHolder implements View.OnClickListener {
        public TextView sysRegDt     ; // 날짜       
        public TextView dtlcnsttypecd; // 세부공종코드   
        public TextView dtlcnsttypenm; // 세부공종명    
        public TextView prt          ; // 위치       
        
        public Button btnView1; // 버튼 보기

		public TextView getSysRegDt() {
			return sysRegDt;
		}

		public TextView getDtlcnsttypecd() {
			return dtlcnsttypecd;
		}

		public TextView getDtlcnsttypenm() {
			return dtlcnsttypenm;
		}

		public TextView getPrt() {
			return prt;
		}

		public Button getBtnView1() {
			return btnView1;
		}

		public void setSysRegDt(TextView sysRegDt) {
			this.sysRegDt = sysRegDt;
		}

		public void setDtlcnsttypecd(TextView dtlcnsttypecd) {
			this.dtlcnsttypecd = dtlcnsttypecd;
		}

		public void setDtlcnsttypenm(TextView dtlcnsttypenm) {
			this.dtlcnsttypenm = dtlcnsttypenm;
		}

		public void setPrt(TextView prt) {
			this.prt = prt;
		}

		public void setBtnView1(Button btnView1) {
			this.btnView1 = btnView1;
		}

		public ViewHolder(View itemView) {
            super(itemView);
            sysRegDt     = (TextView) itemView.findViewById(R.id.tv_row_1);
            dtlcnsttypenm= (TextView) itemView.findViewById(R.id.tv_row_2);
            prt          = (TextView) itemView.findViewById(R.id.tv_row_3);
            
            btnView1 = (Button) itemView.findViewById(R.id.btn_row_4); // 보기
            
            itemView.setClickable(true);
            itemView.setFocusable(true);
            itemView.setOnClickListener(this);            
            dtlcnsttypenm.setOnClickListener(this);            
            btnView1.setOnClickListener(this);            
        }

		@Override
		public void onClick(View v) {
	    	final PhotoMngActivity activity = (PhotoMngActivity)mContext;
            if (v.getId() == btnView1.getId()) { // 보기
            	v = (View) v.getParent().getParent();
            	PicMngListDTO v1 = (PicMngListDTO) v.getTag();
            	WUtil.goPhotoMngDtl(activity, WConstant.WRITE_MODE_UPDATE,activity.spnSiteNo.getValue(),v1.getCnstrphtSeq());            	
            } else if (v.getId() == dtlcnsttypenm.getId()) { // 세부공종명 링크.
            	v = (View) v.getParent();
            	PicMngListDTO v1 = (PicMngListDTO) v.getTag();
    			WUtil.goPhotoMngDtl(activity, WConstant.WRITE_MODE_UPDATE,activity.spnSiteNo.getValue(),v1.getCnstrphtSeq());            	
            } else {
//            	PicMngListDTO v1 = (PicMngListDTO) v.getTag();
            	//Util.i(v1.getpSiteNo() + " / " + v1.getIspnChkMgntSeq());
            }
            notifyItemChanged(selectedItem);
            selectedItem = getLayoutPosition();
            notifyItemChanged(selectedItem);
//	            v.setSelected(true);
		}
    }

	@Override
	public int getItemCount() {
		return items!=null?items.size():0;
	}
	
	@Override
	public int getItemViewType(int p) {
		PicMngListDTO item = (PicMngListDTO)items.get(p);
	    int viewType = WConstant.LIST_DATA_MODE_READ.equals(item.getMode())?ITEM_VIEW_TYPE_READ:ITEM_VIEW_TYPE_EDIT;
	    return viewType; // 0 Or 1 : 0=R, 1=I
	}

	@Override
	public ViewHolder onCreateViewHolder(ViewGroup viewGroup, int viewType) {
        View itemLayoutView = mInflater.inflate(R.layout.list_item_photo_mng, viewGroup, false);
                
        PhotoMngAdapter.ViewHolder viewHolder = new PhotoMngAdapter.ViewHolder(itemLayoutView);
        if ( viewType==ITEM_VIEW_TYPE_READ ) { // I
        }
        //Util.i("onCreateViewHolder" );
        return viewHolder;
	}

	
	
	@Override
	public void registerAdapterDataObserver(AdapterDataObserver observer) {
		super.registerAdapterDataObserver(observer);
        //Util.i("registerAdapterDataObserver" );
	}
	
	@Override
	public void onBindViewHolder(PhotoMngAdapter.ViewHolder viewHodler, int p) {
		viewHodler.itemView.setSelected(selectedItem == p);
		PicMngListDTO data = items.get(p);
        viewHodler.getSysRegDt().setText( WUtil.toDateFormat(data.getSysRegDt())); // 날짜
        
        viewHodler.getDtlcnsttypenm().setText(Html.fromHtml("<a href='#'><b>"+data.getDtlcnsttypenm()+"</b></a>"));
        
        viewHodler.getPrt().setText(data.getPrt());
        
	    if ( selectedItem == p ) {
	    	viewHodler.itemView.setBackgroundResource(R.drawable.listview_item_selector);
		} else {
        	viewHodler.itemView.setBackgroundResource(p % 2 == 0 ? R.drawable.listview_item_selector_1 : R.drawable.listview_item_selector_2 );
        }
        viewHodler.itemView.setTag(data);
        //Util.i("onBindViewHolder : " + p);
	}

	@Override
	public void onViewAttachedToWindow(ViewHolder holder) {
		super.onViewAttachedToWindow(holder);
        //Util.i("onViewAttachedToWindow" );
	}

    @Override
    public void onAttachedToRecyclerView(final RecyclerView recyclerView) {
        super.onAttachedToRecyclerView(recyclerView);
        //Util.i("onAttachedToRecyclerView" );
        recyclerView.setOnKeyListener(new View.OnKeyListener() {
            @Override
            public boolean onKey(View v, int keyCode, KeyEvent event) {
                //Util.i("onKey : " + keyCode );            	
                RecyclerView.LayoutManager lm = recyclerView.getLayoutManager();

                // Return false if scrolled to the bounds and allow focus to move off the list
                if (event.getAction() == KeyEvent.ACTION_DOWN) {
                    if (keyCode == KeyEvent.KEYCODE_DPAD_DOWN) {
                        return tryMoveSelection(lm, 1);
                    } else if (keyCode == KeyEvent.KEYCODE_DPAD_UP) {
                        return tryMoveSelection(lm, -1);
                    }
                }

                return false;
            }
        });
        //Util.i("onAttachedToRecyclerView" );        
    }
    
    private boolean tryMoveSelection(RecyclerView.LayoutManager lm, int direction) {
        int nextSelectItem = selectedItem + direction;
        nextSelectItem = selectedItem<=0?1:selectedItem;
        // If still within valid bounds, move the selection, notify to redraw, and scroll
        if (nextSelectItem >= 0 && nextSelectItem < getItemCount()) {
            notifyItemChanged(selectedItem);
            selectedItem = nextSelectItem;
            notifyItemChanged(selectedItem);
            lm.scrollToPosition(selectedItem);
            return true;
        }

        return false;
    }    
	
}


