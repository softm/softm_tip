package kr.go.citis.main.adapter;

import java.util.ArrayList;

import kr.go.citis.main.R;
import kr.go.citis.main.common.WConstant;
import kr.go.citis.main.common.WUtil;
import kr.go.citis.main.dto.TestChkMainDTO;

import org.apache.commons.lang3.StringUtils;

import android.content.Context;
import android.support.v7.widget.RecyclerView;
import android.support.v7.widget.RecyclerView.AdapterDataObserver;
import android.view.KeyEvent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.TextView;
/**
 * TestChkMainAdapter
 * @author softm
 *
 */
public class TestChkMainAdapter extends RecyclerView.Adapter<TestChkMainAdapter.ViewHolder> {		
	Context mContext;
	LayoutInflater mInflater;
	ArrayList<TestChkMainDTO> items;
    private int selectedItem = 0;	
	public final static int ITEM_VIEW_TYPE_READ = 0;
	public final static int ITEM_VIEW_TYPE_EDIT = 1;
	public TestChkMainAdapter(Context context, LayoutInflater inflater,ArrayList<TestChkMainDTO> data) {
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

	public ArrayList<TestChkMainDTO> getItems() {
		return items;
	}

	public void setItems(ArrayList<TestChkMainDTO> items) {
		this.items = items;
	}

	public void addItem(TestChkMainDTO item) {
		selectedItem = 0;
		this.items.add(0,item);
	}

	public class ViewHolder extends RecyclerView.ViewHolder implements View.OnClickListener {
        public TextView pSiteNo       ; // 현장번호[담당,관할]
        public TextView pCnsttypecd   ; // 공종
        public TextView pChkDtYyyymm  ; // 년월
        public TextView pIspnPrgrs    ; // 진행상태
        public TextView ispnChkMgntSeq; // 검측마스터번호
        public TextView dtlcnsttypecd ; // 세부공종코드
        public TextView dtlcnsttypenm ; // 세부공종명
        public TextView chkDt         ; // 점검일자
        public TextView rqstsDt       ; // 검측요청일
        public TextView ispnDt        ; // 검측일자
        public TextView ispnPrgrs     ; // 진행상태코드
        public TextView ispnPrgrsNm   ; // 진행상태명
        public TextView rsltStatus    ; // 검측결과코드
        public TextView rsltStatusNm  ; // 검측결과명
        public Button btnView1        ; // 버튼 검측요청
        public Button btnView2        ; // 버튼 작성이력
        
		public TextView getpSiteNo() {
			return pSiteNo;
		}

		public TextView getpCnsttypecd() {
			return pCnsttypecd;
		}

		public TextView getpChkDtYyyymm() {
			return pChkDtYyyymm;
		}

		public TextView getpIspnPrgrs() {
			return pIspnPrgrs;
		}

		public TextView getIspnChkMgntSeq() {
			return ispnChkMgntSeq;
		}

		public TextView getDtlcnsttypecd() {
			return dtlcnsttypecd;
		}

		public TextView getDtlcnsttypenm() {
			return dtlcnsttypenm;
		}

		public TextView getChkDt() {
			return chkDt;
		}

		public TextView getRqstsDt() {
			return rqstsDt;
		}

		public TextView getIspnDt() {
			return ispnDt;
		}

		public TextView getIspnPrgrs() {
			return ispnPrgrs;
		}

		public TextView getIspnPrgrsNm() {
			return ispnPrgrsNm;
		}

		public TextView getRsltStatus() {
			return rsltStatus;
		}

		public TextView getRsltStatusNm() {
			return rsltStatusNm;
		}

		public ViewHolder(View itemView) {
            super(itemView);
            dtlcnsttypenm= (TextView) itemView.findViewById(R.id.tv_row_1);
            chkDt        = (TextView) itemView.findViewById(R.id.tv_row_2);
            rqstsDt      = (TextView) itemView.findViewById(R.id.tv_row_3);
            ispnDt       = (TextView) itemView.findViewById(R.id.tv_row_4);
            ispnPrgrsNm  = (TextView) itemView.findViewById(R.id.tv_row_5);
            rsltStatusNm = (TextView) itemView.findViewById(R.id.tv_row_6);
            btnView1 = (Button) itemView.findViewById(R.id.btn_row_3); // 검측요청
            btnView2 = (Button) itemView.findViewById(R.id.btn_row_7); // 작성이력
            
            itemView.setClickable(true);
            itemView.setFocusable(true);
            itemView.setOnClickListener(this);            
            btnView1.setOnClickListener(this);            
            btnView2.setOnClickListener(this);
        }

		@Override
		public void onClick(View v) {
            if (v.getId() == btnView1.getId()) { // 검측요청
            	v = (View) v.getParent().getParent();
            	TestChkMainDTO v1 = (TestChkMainDTO) v.getTag();
            	WUtil.goTestReqDoc(mContext, v1.getIspnChkMgntSeq());
            } else if (v.getId() == btnView2.getId()) { // 작성이력
            	v = (View) v.getParent().getParent();
            	TestChkMainDTO v1 = (TestChkMainDTO) v.getTag();
    			WUtil.goTestChkList(mContext, v1.getIspnChkMgntSeq());
            } else {
            }
            notifyItemChanged(selectedItem);
            selectedItem = getLayoutPosition();
            notifyItemChanged(selectedItem);
		}
    }

	@Override
	public int getItemCount() {
		return items!=null?items.size():0;		
	}
	
	@Override
	public int getItemViewType(int p) {
		TestChkMainDTO item = (TestChkMainDTO)items.get(p);
	    int viewType = WConstant.LIST_DATA_MODE_READ.equals(item.getMode())?ITEM_VIEW_TYPE_READ:ITEM_VIEW_TYPE_EDIT;
	    return viewType; // 0 Or 1 : 0=R, 1=I
	}

	@Override
	public ViewHolder onCreateViewHolder(ViewGroup viewGroup, int viewType) {
        View itemLayoutView = mInflater.inflate(R.layout.list_item_test_chk_main, viewGroup, false);
                
        TestChkMainAdapter.ViewHolder viewHolder = new TestChkMainAdapter.ViewHolder(itemLayoutView);
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
	public void onBindViewHolder(TestChkMainAdapter.ViewHolder viewHodler, int p) {
		viewHodler.itemView.setSelected(selectedItem == p);
		TestChkMainDTO data = items.get(p);
        viewHodler.getDtlcnsttypenm().setText(data.getDtlcnsttypenm());
        viewHodler.getChkDt       ().setText( WUtil.toDateFormat(data.getChkDt())); // 점검일자
        viewHodler.getRqstsDt     ().setText( WUtil.toDateFormat(data.getRqstsDt     ()));
        viewHodler.getIspnDt      ().setText( WUtil.toDateFormat(data.getIspnDt      ())); // 검측일자
        viewHodler.getIspnPrgrsNm ().setText(data.getIspnPrgrsNm ());
        viewHodler.getRsltStatusNm().setText(data.getRsltStatusNm());
        
        if ( StringUtils.isNotEmpty(data.getChkDt       ()) 
        		&& StringUtils.isEmpty(data.getRqstsDt  ()) // 검측요청일
        		&& StringUtils.isEmpty(data.getIspnDt   ()) // 검측일
           ) 
        {
        	viewHodler.btnView1.setVisibility(View.VISIBLE); // 검측요청
        	viewHodler.getRqstsDt().setVisibility(View.GONE); // 검측요청일
        } else {
        	viewHodler.btnView1.setVisibility(View.GONE); // 검측요청
        	viewHodler.getRqstsDt().setVisibility(View.VISIBLE); // 검측요청일
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


