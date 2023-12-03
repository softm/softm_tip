package kr.go.citis.main.adapter;

import java.util.ArrayList;

import kr.go.citis.lib.Util;
import kr.go.citis.lib.type.RsltStatus;
import kr.go.citis.main.R;
import kr.go.citis.main.common.WConstant;
import kr.go.citis.main.dto.BldChkupWrtItemListDTO;
import android.content.Context;
import android.support.v7.widget.RecyclerView;
import android.support.v7.widget.RecyclerView.AdapterDataObserver;
import android.text.Html;
import android.view.KeyEvent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.CheckBox;
import android.widget.CompoundButton;
import android.widget.CompoundButton.OnCheckedChangeListener;
import android.widget.TextView;
/**
 * BldChkupWrtAdapter
 * @author softm
 * 시공사점검 작성
 */
public class BldChkupWrtAdapter extends RecyclerView.Adapter<BldChkupWrtAdapter.ViewHolder> {		
	Context mContext;
	LayoutInflater mInflater;
	ArrayList<BldChkupWrtItemListDTO> items;
    private int selectedItem = 0;	
	public final static int ITEM_VIEW_TYPE_READ = 0;
	public final static int ITEM_VIEW_TYPE_EDIT = 1;
    protected boolean enable = true;

	public boolean getEnable() {
		return enable;
	}

	public void setEnable(boolean enable) {
		this.enable = enable;
	}

	public BldChkupWrtAdapter(Context context, LayoutInflater inflater,ArrayList<BldChkupWrtItemListDTO> data) {
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

	public ArrayList<BldChkupWrtItemListDTO> getItems() {
		return items;
	}

	public void setItems(ArrayList<BldChkupWrtItemListDTO> items) {
		this.items = items;
	}

	public void addItem(BldChkupWrtItemListDTO item) {
		selectedItem = 0;
		this.items.add(0,item);
	}

	public class ViewHolder extends RecyclerView.ViewHolder implements View.OnClickListener {
    	public TextView pIspnChkMgntSeq; // 검측마스터번호    
    	public TextView pIspnChkSeq    ; // 검측체크번호     
    	public TextView pDtlcnsttypecd ; // 세부공종코드     
    	public TextView pSiteNo        ; // 현장번호[담당,관할]
    	public TextView ispnChkItemSeq ; // 검측체크항목번호   
    	public TextView ispnItem       ; // 검사항목       
    	public TextView ispnStd        ; // 검사기준       
    	public CheckBox cntrChk        ; // 시공사점검      
    	public TextView siteChkSeq     ; // 현장검측체크번호   

		public TextView getpIspnChkMgntSeq() {
			return pIspnChkMgntSeq;
		}

		public TextView getpIspnChkSeq() {
			return pIspnChkSeq;
		}

		public TextView getpDtlcnsttypecd() {
			return pDtlcnsttypecd;
		}

		public TextView getpSiteNo() {
			return pSiteNo;
		}

		public TextView getIspnChkItemSeq() {
			return ispnChkItemSeq;
		}

		public TextView getIspnItem() {
			return ispnItem;
		}

		public TextView getIspnStd() {
			return ispnStd;
		}

		public CheckBox getCntrChk() {
			return cntrChk;
		}

		public TextView getSiteChkSeq() {
			return siteChkSeq;
		}

		public void setpIspnChkMgntSeq(TextView pIspnChkMgntSeq) {
			this.pIspnChkMgntSeq = pIspnChkMgntSeq;
		}

		public void setpIspnChkSeq(TextView pIspnChkSeq) {
			this.pIspnChkSeq = pIspnChkSeq;
		}

		public void setpDtlcnsttypecd(TextView pDtlcnsttypecd) {
			this.pDtlcnsttypecd = pDtlcnsttypecd;
		}

		public void setpSiteNo(TextView pSiteNo) {
			this.pSiteNo = pSiteNo;
		}

		public void setIspnChkItemSeq(TextView ispnChkItemSeq) {
			this.ispnChkItemSeq = ispnChkItemSeq;
		}

		public void setIspnItem(TextView ispnItem) {
			this.ispnItem = ispnItem;
		}

		public void setIspnStd(TextView ispnStd) {
			this.ispnStd = ispnStd;
		}

		public void setCntrChk(CheckBox cntrChk) {
			this.cntrChk = cntrChk;
		}

		public void setSiteChkSeq(TextView siteChkSeq) {
			this.siteChkSeq = siteChkSeq;
		}
			
		public ViewHolder(View itemView) {
            super(itemView);
        	
        	ispnItem = (TextView) itemView.findViewById(R.id.tv_row_1); // 검사항목
        	ispnStd  = (TextView) itemView.findViewById(R.id.tv_row_2); // 검사기준
        	cntrChk  = (CheckBox) itemView.findViewById(R.id.chk_row_3); // 시공사점검
        	itemView.setClickable(true);
        	itemView.setFocusable(true);
        	itemView.setOnClickListener(this);            
            if ( getEnable() ) {
            	cntrChk.setOnClickListener(this);
            }
        }

		@Override
		public void onClick(View v) {
            notifyItemChanged(selectedItem);
            selectedItem = getLayoutPosition();
            notifyItemChanged(selectedItem);
		}
    }

	@Override
	public int getItemCount() {
		return items.size();		
	}
	
	@Override
	public int getItemViewType(int p) {
		BldChkupWrtItemListDTO item = (BldChkupWrtItemListDTO)items.get(p);
	    int viewType = WConstant.LIST_DATA_MODE_READ.equals(item.getMode())?ITEM_VIEW_TYPE_READ:ITEM_VIEW_TYPE_EDIT;
	    return viewType; // 0 Or 1 : 0=R, 1=I
	}

	@Override
	public ViewHolder onCreateViewHolder(ViewGroup viewGroup, int viewType) {
        View itemLayoutView = mInflater.inflate(R.layout.list_item_bld_chkup_wrt, viewGroup, false);
                
        BldChkupWrtAdapter.ViewHolder viewHolder = new BldChkupWrtAdapter.ViewHolder(itemLayoutView);
        Util.i("onCreateViewHolder" );
        return viewHolder;
	}
	
	@Override
	public void registerAdapterDataObserver(AdapterDataObserver observer) {
		super.registerAdapterDataObserver(observer);
        Util.i("registerAdapterDataObserver" );
//        observer.onChanged();
	}
	
	@Override
	public void onBindViewHolder(BldChkupWrtAdapter.ViewHolder viewHodler, int p) {
		viewHodler.itemView.setSelected(selectedItem == p);
		final BldChkupWrtItemListDTO data = items.get(p);
        viewHodler.getIspnItem().setText(data.getIspnItem()); // 검사항목 
//        viewHodler.getIspnStd ().setText(data.getIspnStd ()); // 검사기준
        viewHodler.getIspnStd().setText(Html.fromHtml(data.getIspnStd())); // 검사기준        
//        viewHodler.getCntrChk ().setText(data.getCntrChk ()); // 시공사점검
        
        //in some cases, it will prevent unwanted situations
        viewHodler.getCntrChk ().setOnCheckedChangeListener(null);
//    	v.getPosition();
        if ( getEnable() == Boolean.FALSE) {
    		viewHodler.getCntrChk ().setEnabled(Boolean.FALSE);        	
        }
    	if ( RsltStatus.TRUE.getTypeCd().equals(data.getCntrChk()) ) {
    		viewHodler.getCntrChk ().setChecked(Boolean.TRUE); 
    	} else {
    		viewHodler.getCntrChk ().setChecked(Boolean.FALSE);    		
    	}
    	viewHodler.getCntrChk ().setOnCheckedChangeListener(new OnCheckedChangeListener() {
            @Override
            public void onCheckedChanged(CompoundButton buttonView, boolean isChecked) {
            	data.setCntrChk(isChecked?RsltStatus.TRUE.getTypeCd():RsltStatus.FALSE.getTypeCd());          	
            }
        });
        
//        viewHodler.itemView.setLayoutParams(new LinearLayout.LayoutParams(LayoutParams.MATCH_PARENT,LayoutParams.MATCH_PARENT));
	    if ( selectedItem == p ) {
	    	viewHodler.itemView.setBackgroundResource(R.drawable.listview_item_selector);
		} else {
        	viewHodler.itemView.setBackgroundResource(p % 2 == 0 ? R.drawable.listview_item_selector_1 : R.drawable.listview_item_selector_2 );
        }
//    	viewHodler.itemView.setBackgroundResource(R.drawable.listview_item_selector);        
//        viewHodler.itemView.setClickable(true);
        viewHodler.itemView.setTag(data);
//	    lv1.addItemDecoration(new DividerItemDecoration(TestChkMainRecyclerViewActivity.this, R.color.listDivColor));
        Util.i("onBindViewHolder : " + p);
	}

	@Override
	public void onViewAttachedToWindow(ViewHolder holder) {
		super.onViewAttachedToWindow(holder);
//    	if ( ITEM_VIEW_TYPE_EDIT == holder.getItemViewType() ) {
//    		holder.getMvSample1().requestFocus();
//    		final BaseActivity activity = (BaseActivity)getmContext();
//    		activity.showKeyboard();
////        	if ( selectedItem == holder.getLayoutPosition() ) {
////        		holder.itemView.setBackgroundResource(R.drawable.listview_item_selector);
////        	}
////    		InputMethodManager imm = (InputMethodManager) activity.getSystemService(Context.INPUT_METHOD_SERVICE);
////    		imm.showSoftInput(holder.getMvSample1(), InputMethodManager.SHOW_IMPLICIT);
//    	}
        Util.i("onViewAttachedToWindow" );
	}

    @Override
    public void onAttachedToRecyclerView(final RecyclerView recyclerView) {
        super.onAttachedToRecyclerView(recyclerView);
        //Util.i("onAttachedToRecyclerView" );
        // Handle key up and key down and attempt to move selection
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
        
        Util.i("onAttachedToRecyclerView" );        
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

	@Override
	public void onViewRecycled(ViewHolder holder) {
		super.onViewRecycled(holder);
        Util.i("onViewRecycled" );		
	}
}


