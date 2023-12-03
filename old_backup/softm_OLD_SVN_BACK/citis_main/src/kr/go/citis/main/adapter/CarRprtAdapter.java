package kr.go.citis.main.adapter;

import java.text.DecimalFormat;
import java.util.ArrayList;

import kr.go.citis.main.R;
import kr.go.citis.main.activity.CarRprtActivity;
import kr.go.citis.main.common.WConstant;
import kr.go.citis.main.dto.CarRprtFileItemListDTO;

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
 * CarRprtAdapter
 * @author softm
 *
 */
public class CarRprtAdapter extends RecyclerView.Adapter<CarRprtAdapter.ViewHolder> {		
	Context mContext;
	LayoutInflater mInflater;
	ArrayList<CarRprtFileItemListDTO> items;
    private int selectedItem = 0;	
	public final static int ITEM_VIEW_TYPE_READ = 0;
	public final static int ITEM_VIEW_TYPE_EDIT = 1;
	public CarRprtAdapter(Context context, LayoutInflater inflater,ArrayList<CarRprtFileItemListDTO> data) {
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

	public ArrayList<CarRprtFileItemListDTO> getItems() {
		return items;
	}

	public void setItems(ArrayList<CarRprtFileItemListDTO> items) {
		this.items = items;
	}

	public void addItem(CarRprtFileItemListDTO item) {
		selectedItem = 0;
		this.items.add(0,item);
	}

	public class ViewHolder extends RecyclerView.ViewHolder implements View.OnClickListener {
        public TextView atchSeq   ; // No
        public TextView fileName ; // 파일명
        public TextView fileSize ; // 파일크기
        
        public ImageButton btnView1; // 파일다운로드


		public TextView getAtchSeq() {
			return atchSeq;
		}

		public void setAtchSeq(TextView atchSeq) {
			this.atchSeq = atchSeq;
		}

		public TextView getFileName() {
			return fileName;
		}

		public TextView getFileSize() {
			return fileSize;
		}

		public ImageButton getBtnView1() {
			return btnView1;
		}

		public void setFileName(TextView fileName) {
			this.fileName = fileName;
		}

		public void setFileSize(TextView fileSize) {
			this.fileSize = fileSize;
		}

		public void setBtnView1(ImageButton btnView1) {
			this.btnView1 = btnView1;
		}

		public ViewHolder(View itemView) {
            super(itemView);
            atchSeq  = (TextView) itemView.findViewById(R.id.tv_row_1);
            fileName = (TextView) itemView.findViewById(R.id.tv_row_2);
            fileSize = (TextView) itemView.findViewById(R.id.tv_row_3);
            btnView1 = (ImageButton) itemView.findViewById(R.id.btn_row_3); // 파일다운로드 버튼
            itemView.setClickable(true);
            itemView.setFocusable(true);
            itemView.setOnClickListener(this);            
            btnView1.setOnClickListener(this);            
        }

		@Override
		public void onClick(View v) {
	    	final CarRprtActivity activity = (CarRprtActivity)mContext;
            if (v.getId() == btnView1.getId()) { // 파일다운로드.
            	v = (View) v.getParent().getParent();
            	CarRprtFileItemListDTO v1 = (CarRprtFileItemListDTO) v.getTag();
//            	v1.setFileUrl("http://118.220.189.69:8011/citis/citis.inspection.MobileCheckCMD.cals?service=carRprtFileDownload&pAtchSeq=1&pFileAsr=RSLT");
//            	v1.setFileUrl("http://118.220.189.69:8011/citis/citis.inspection.MobileCheckCMD.cals?service=ncrRprtFileDownload&pRprtSeq=1&pFileAsr=RQSTS");            	
//            	v1.setFileName("한들.jpg");
            	//------------------------------------------------
//            	activity.toast(v1.getFileUrl() + " / " + v1.getFileName() + " / " +  v1.getFileSize() );
            	activity.viewDownloadFile(v1.getFileUrl(), v1.getFileName(), v1.getFileName(), v1.getFileSize());
            } else {
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
		CarRprtFileItemListDTO item = (CarRprtFileItemListDTO)items.get(p);
	    int viewType = WConstant.LIST_DATA_MODE_READ.equals(item.getMode())?ITEM_VIEW_TYPE_READ:ITEM_VIEW_TYPE_EDIT;
	    return viewType; // 0 Or 1 : 0=R, 1=I
	}

	@Override
	public ViewHolder onCreateViewHolder(ViewGroup viewGroup, int viewType) {
        View itemLayoutView = mInflater.inflate(R.layout.list_item_car_rprt, viewGroup, false);
                
        CarRprtAdapter.ViewHolder viewHolder = new CarRprtAdapter.ViewHolder(itemLayoutView);
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
	public void onBindViewHolder(CarRprtAdapter.ViewHolder viewHodler, int p) {
		viewHodler.itemView.setSelected(selectedItem == p);
		CarRprtFileItemListDTO data = items.get(p);
//        viewHodler.getFileNo()     .setText(String.valueOf(p + 1));// No
        viewHodler.getAtchSeq()     .setText(String.valueOf(data.getAtchSeq()));// No
        viewHodler.getFileName   ().setText(data.getFileName   ());// 파일명
        viewHodler.getFileSize().setText(bytesToHuman (Long.valueOf("10000")));// No
//        viewHodler.getFileSize().setText(bytesToHuman (NumberUtils.toLong(data.getFileSize())));// No
        
        if ( StringUtils.isNotEmpty(data.getFileName       ()) ) { // 파일다운로드 버튼
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
    
    public static String floatForm (double d)
    {
       return new DecimalFormat("#.##").format(d);
    }


    public static String bytesToHuman (long size)
    {
        long Kb = 1  * 1024;
        long Mb = Kb * 1024;
        long Gb = Mb * 1024;
        long Tb = Gb * 1024;
        long Pb = Tb * 1024;
        long Eb = Pb * 1024;

        if (size <  Kb)                 return floatForm(        size     ) + " byte";
        if (size >= Kb && size < Mb)    return floatForm((double)size / Kb) + " Kb";
        if (size >= Mb && size < Gb)    return floatForm((double)size / Mb) + " Mb";
        if (size >= Gb && size < Tb)    return floatForm((double)size / Gb) + " Gb";
        if (size >= Tb && size < Pb)    return floatForm((double)size / Tb) + " Tb";
        if (size >= Pb && size < Eb)    return floatForm((double)size / Pb) + " Pb";
        if (size >= Eb)                 return floatForm((double)size / Eb) + " Eb";

        return "???";
    }    
	
}