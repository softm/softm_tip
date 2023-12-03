package kr.go.citis.main.adapter;

import java.util.ArrayList;

import kr.go.citis.lib.BaseActivity;
import kr.go.citis.main.R;
import kr.go.citis.main.common.WConstant;
import kr.go.citis.main.dto.SampleListDTO;
import android.content.Context;
import android.support.v7.widget.RecyclerView;
import android.view.KeyEvent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;
/**
 * SampleListRecyclerViewAdapter
 * @author softm
 *
 */
public class SampleListRecyclerViewAdapter extends RecyclerView.Adapter<SampleListRecyclerViewAdapter.ViewHolder> {		
	Context mContext;
	LayoutInflater mInflater;
	ArrayList<SampleListDTO> items;
    private int selectedItem = 0;	
	public final static int ITEM_VIEW_TYPE_READ = 0;
	public final static int ITEM_VIEW_TYPE_EDIT = 1;
	public SampleListRecyclerViewAdapter(Context context, LayoutInflater inflater,ArrayList<SampleListDTO> data) {
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

	public ArrayList<SampleListDTO> getItems() {
		return items;
	}

	public void setItems(ArrayList<SampleListDTO> items) {
		this.items = items;
	}

	public void addItem(SampleListDTO item) {
		selectedItem = 0;
		this.items.add(0,item);
	}

	public class ViewHolder extends RecyclerView.ViewHolder implements View.OnClickListener {
        TextView mtvSample1;
        TextView mtvSample2;

        public TextView getMvSample1() {
            return mtvSample1;
        }
        
        public TextView getMvSample2() {
        	return mtvSample2;
        }

        public ViewHolder(View itemView) {
            super(itemView);
            itemView.setOnClickListener(this);            
            mtvSample1 = (TextView) itemView.findViewById(R.id.tv_sample_1);
            mtvSample2 = (TextView) itemView.findViewById(R.id.tv_sample_2);
            itemView.setClickable(true);
            itemView.setFocusable(true);
        }

		@Override
		public void onClick(View v) {
	    	final BaseActivity activity = (BaseActivity)mContext;
        	SampleListDTO v1 = (SampleListDTO) v.getTag();
//	    	activity.alert(v1.getSample_1() + " / " + v1.getSample_2());
	    	//Util.i(v1.getSample_1() + " / " + v1.getSample_2());
	    	
            notifyItemChanged(selectedItem);
            selectedItem = getLayoutPosition();
            notifyItemChanged(selectedItem);
//            v.setSelected(true);
		}
    }

	@Override
	public int getItemCount() {
		return items.size();		
	}
	
	@Override
	public int getItemViewType(int p) {
		SampleListDTO item = (SampleListDTO)items.get(p);
	    int viewType = WConstant.LIST_DATA_MODE_READ.equals(item.getMode())?ITEM_VIEW_TYPE_READ:ITEM_VIEW_TYPE_EDIT;
//	    //Util.i("item.getMode() : " + item.getMode() + "/" + p);
        //Util.i("getItemViewType : " + ("item.getMode() : " + item.getMode() + "/" + p) );	    
	    return viewType; // 0 Or 1 : 0=R, 1=I
	}

	@Override
	public ViewHolder onCreateViewHolder(ViewGroup viewGroup, int viewType) {
        View itemLayoutView = mInflater.inflate(viewType==0?R.layout.list_item_sample_list:R.layout.list_item_sample_list_input, viewGroup, false);
//      View itemLayoutView = LayoutInflater.from(viewGroup.getContext()).inflate(R.layout.list_item_sample_list, viewGroup, false);
        SampleListRecyclerViewAdapter.ViewHolder viewHolder = new SampleListRecyclerViewAdapter.ViewHolder(itemLayoutView);
        if ( viewType==ITEM_VIEW_TYPE_READ ) { // I
//        	viewHolder.getMvSample1().setId(INSERT_ITEM_ID);
//        	itemLayoutView.setVisibility(View.GONE);
        }
        //Util.i("onCreateViewHolder" );
        return viewHolder;
	}

	@Override
	public void onBindViewHolder(SampleListRecyclerViewAdapter.ViewHolder viewHodler, int p) {
		viewHodler.itemView.setSelected(selectedItem == p);
		SampleListDTO data = items.get(p);
        viewHodler.getMvSample1().setText(data.getSample_1() + "/" + data.getMode());
        viewHodler.getMvSample2().setText(data.getSample_2());
//        viewHodler.itemView.setLayoutParams(new LinearLayout.LayoutParams(LayoutParams.MATCH_PARENT,LayoutParams.MATCH_PARENT));
	    if ( selectedItem == p ) {
	    	viewHodler.itemView.setBackgroundResource(R.drawable.listview_item_selector);
		} else {
        	viewHodler.itemView.setBackgroundResource(p % 2 == 0 ? R.drawable.listview_item_selector_1 : R.drawable.listview_item_selector_2 );
        }
//    	viewHodler.itemView.setBackgroundResource(R.drawable.listview_item_selector);        
//        viewHodler.itemView.setClickable(true);
        viewHodler.itemView.setTag(data);
//	    lv1.addItemDecoration(new DividerItemDecoration(SampleListRecyclerViewActivity.this, R.color.listDivColor));
        //Util.i("onBindViewHolder : " + p);
        
	}

	@Override
	public void onViewAttachedToWindow(ViewHolder holder) {
		super.onViewAttachedToWindow(holder);
    	if ( ITEM_VIEW_TYPE_EDIT == holder.getItemViewType() ) {
    		holder.getMvSample1().requestFocus();
    		final BaseActivity activity = (BaseActivity)getmContext();
    		activity.showKeyboard();
//        	if ( selectedItem == holder.getLayoutPosition() ) {
//        		holder.itemView.setBackgroundResource(R.drawable.listview_item_selector);
//        	}
//    		InputMethodManager imm = (InputMethodManager) activity.getSystemService(Context.INPUT_METHOD_SERVICE);
//    		imm.showSoftInput(holder.getMvSample1(), InputMethodManager.SHOW_IMPLICIT);
    	}
        //Util.i("onViewAttachedToWindow" );
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


