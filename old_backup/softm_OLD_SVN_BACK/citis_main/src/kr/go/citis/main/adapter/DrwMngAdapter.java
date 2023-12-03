package kr.go.citis.main.adapter;

import java.util.ArrayList;

import kr.go.citis.main.R;
import kr.go.citis.main.activity.DrwMngActivity;
import kr.go.citis.main.common.WConstant;
import kr.go.citis.main.common.WUtil;
import kr.go.citis.main.dto.CsrBslListDTO;
import kr.go.citis.main.dto.DrwListDTO;

import org.apache.commons.lang3.StringUtils;

import android.content.Context;
import android.support.v7.widget.RecyclerView;
import android.support.v7.widget.RecyclerView.AdapterDataObserver;
import android.view.KeyEvent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageButton;
import android.widget.TextView;
/**
 * DrwMngAdapter
 * @author softm
 *
 */
public class DrwMngAdapter extends RecyclerView.Adapter<DrwMngAdapter.ViewHolder> {		
	Context mContext;
	LayoutInflater mInflater;
	ArrayList<DrwListDTO> items;
    private int selectedItem = 0;	
	public final static int ITEM_VIEW_TYPE_READ = 0;
	public final static int ITEM_VIEW_TYPE_EDIT = 1;
	public DrwMngAdapter(Context context, LayoutInflater inflater,ArrayList<DrwListDTO> data) {
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

	public ArrayList<DrwListDTO> getItems() {
		return items;
	}

	public void setItems(ArrayList<DrwListDTO> items) {
		this.items = items;
	}

	public void addItem(DrwListDTO item) {
		selectedItem = 0;
		this.items.add(0,item);
	}

	public class ViewHolder extends RecyclerView.ViewHolder implements View.OnClickListener {
        public TextView pPlnClsSeq ; // 도면분류구분
        public TextView pPlnNm     ; // 도면명
        public TextView plnSeq     ; // 도면번호
        public TextView plnNm      ; // 도면명
        public TextView sysRegDate ; // 등록일
        public TextView plnFileName; // 파일명
        
        public ImageButton btnView1; // 파일다운로드

		public TextView getpPlnClsSeq() {
			return pPlnClsSeq;
		}

		public TextView getpPlnNm() {
			return pPlnNm;
		}

		public TextView getPlnSeq() {
			return plnSeq;
		}

		public TextView getPlnNm() {
			return plnNm;
		}

		public TextView getSysRegDate() {
			return sysRegDate;
		}

		public TextView getPlnFileName() {
			return plnFileName;
		}

		public void setpPlnClsSeq(TextView pPlnClsSeq) {
			this.pPlnClsSeq = pPlnClsSeq;
		}

		public void setpPlnNm(TextView pPlnNm) {
			this.pPlnNm = pPlnNm;
		}

		public void setPlnSeq(TextView plnSeq) {
			this.plnSeq = plnSeq;
		}

		public void setPlnNm(TextView plnNm) {
			this.plnNm = plnNm;
		}

		public void setSysRegDate(TextView sysRegDate) {
			this.sysRegDate = sysRegDate;
		}

		public void setPlnFileName(TextView plnFileName) {
			this.plnFileName = plnFileName;
		}

		public ImageButton getBtnView1() {
			return btnView1;
		}

		public void setBtnView1(ImageButton btnView1) {
			this.btnView1 = btnView1;
		}

		public ViewHolder(View itemView) {
            super(itemView);
            plnSeq      = (TextView) itemView.findViewById(R.id.tv_row_1);
            plnNm       = (TextView) itemView.findViewById(R.id.tv_row_2);
            sysRegDate  = (TextView) itemView.findViewById(R.id.tv_row_3);
            plnFileName = (TextView) itemView.findViewById(R.id.tv_row_4);
            btnView1 = (ImageButton) itemView.findViewById(R.id.btn_row_4); // 파일다운로드 버튼
            itemView.setClickable(true);
            itemView.setFocusable(true);
            itemView.setOnClickListener(this);            
            btnView1.setOnClickListener(this);            
        }

		@Override
		public void onClick(View v) {
	    	final DrwMngActivity activity = (DrwMngActivity)mContext;
//	    	activity.alert(v1.getSample_1() + " / " + v1.getSample_2());
        if (v.getId() == btnView1.getId()) { // 파일다운로드.
        	v = (View) v.getParent().getParent();
        	DrwListDTO v1 = (DrwListDTO) v.getTag();
//        	v1.setFileUrl("http://118.220.189.69:8011/citis/citis.inspection.MobileCheckCMD.cals?service=ncrRprtFileDownload&pRprtSeq=1&pFileAsr=RQSTS");
//        	v1.setFileName("한들.jpg");
//        	activity.toast(v1.getFileUrl() + " / " + v1.getPlnFileName() );        	
        	activity.viewDownloadFile(v1.getFileUrl(), v1.getPlnFileName(), v1.getPlnNm(), v1.getPlnNm());
            } else {
//            	DrwListDTO v1 = (DrwListDTO) v.getTag();
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
		DrwListDTO item = (DrwListDTO)items.get(p);
	    int viewType = WConstant.LIST_DATA_MODE_READ.equals(item.getMode())?ITEM_VIEW_TYPE_READ:ITEM_VIEW_TYPE_EDIT;
	    return viewType; // 0 Or 1 : 0=R, 1=I
	}

	@Override
	public ViewHolder onCreateViewHolder(ViewGroup viewGroup, int viewType) {
        View itemLayoutView = mInflater.inflate(R.layout.list_item_drw_mng, viewGroup, false);
                
        DrwMngAdapter.ViewHolder viewHolder = new DrwMngAdapter.ViewHolder(itemLayoutView);
        if ( viewType==ITEM_VIEW_TYPE_READ ) { // I
        }
        //Util.i("onCreateViewHolder" );
        return viewHolder;
	}

	
	
	@Override
	public void registerAdapterDataObserver(AdapterDataObserver observer) {
		super.registerAdapterDataObserver(observer);
        //Util.i("registerAdapterDataObserver" );
//	        observer.onChanged();
	}
	
	@Override
	public void onBindViewHolder(DrwMngAdapter.ViewHolder viewHodler, int p) {
		viewHodler.itemView.setSelected(selectedItem == p);
		DrwListDTO data = items.get(p);
        viewHodler.getPlnSeq().setText(data.getPlnSeq()    );// 도면번호	
        viewHodler.getPlnNm().setText(data.getPlnNm()      );// 도면명	
        viewHodler.getSysRegDate().setText(WUtil.toDateFormat(data.getSysRegDate()));// 등록일
        viewHodler.getPlnFileName().setText(data.getPlnFileName());// 파일명
        
        if ( StringUtils.isNotEmpty(data.getPlnFileName  ()) ) { // 파일다운로드 버튼
        	viewHodler.getBtnView1().setVisibility(View.VISIBLE); 
        } else {
        	viewHodler.getBtnView1().setVisibility(View.GONE);
        }
        
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