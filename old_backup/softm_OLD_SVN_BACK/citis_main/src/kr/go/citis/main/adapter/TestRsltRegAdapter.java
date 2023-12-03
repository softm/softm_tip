package kr.go.citis.main.adapter;

import java.util.ArrayList;

import kr.go.citis.lib.Util;
import kr.go.citis.lib.type.RsltStatus;
import kr.go.citis.main.R;
import kr.go.citis.main.activity.TestRsltRegActivity;
import kr.go.citis.main.common.WConstant;
import kr.go.citis.main.dto.TestRsltWrtListDTO;
import android.content.Context;
import android.support.v7.widget.RecyclerView;
import android.support.v7.widget.RecyclerView.AdapterDataObserver;
import android.view.KeyEvent;
import android.view.LayoutInflater;
import android.view.MotionEvent;
import android.view.View;
import android.view.View.OnTouchListener;
import android.view.ViewGroup;
import android.view.inputmethod.EditorInfo;
import android.widget.CheckBox;
import android.widget.CompoundButton;
import android.widget.CompoundButton.OnCheckedChangeListener;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.TextView.OnEditorActionListener;
/**
 * TestRsltRegAdapter
 * @author softm
 * 검측결과등록
 */
public class TestRsltRegAdapter extends RecyclerView.Adapter<TestRsltRegAdapter.ViewHolder> implements  RecyclerView.OnItemTouchListener  {		
	Context mContext;
	LayoutInflater mInflater;
	ArrayList<TestRsltWrtListDTO> items;
	private int selectedItem = -1;	
	private int oldSelectedItem = -1;	
	public final static int ITEM_VIEW_TYPE_READ = 0;
	public final static int ITEM_VIEW_TYPE_EDIT = 1;
	private boolean enable = true;
	public EditText editView;
	public int getSelectedItem() {
		return selectedItem;
	}

	public void setSelectedItem(int selectedItem) {
		this.selectedItem = selectedItem;
	}

	public boolean getEnable() {
		return enable;
	}

	public void setEnable(boolean enable) {
		this.enable = enable;
	}

	public TestRsltRegAdapter(Context context, LayoutInflater inflater,ArrayList<TestRsltWrtListDTO> data) {
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

	public ArrayList<TestRsltWrtListDTO> getItems() {
		return items;
	}

	public void setItems(ArrayList<TestRsltWrtListDTO> items) {
		this.items = items;
	}

	public void addItem(TestRsltWrtListDTO item) {
		selectedItem = 0;
		this.items.add(0,item);
	}

	public class ViewHolder extends RecyclerView.ViewHolder implements View.OnClickListener, OnTouchListener{
    	public TextView pIspnChkMgntSeq; // 검측마스터번호    
    	public TextView pIspnChkSeq    ; // 검측체크번호     
    	public TextView ispnChkItemSeq ; // 검측체크항목번호   
    	public TextView ispnItem       ; // 검사항목       
    	public TextView ispnStd        ; // 검사기준       
    	public CheckBox cntrChk        ; // 시공사점검
    	public CheckBox ispnRslt1      ; // 검사결과-합격	
    	public CheckBox ispnRslt2      ; // 검사결과-불합격  	
    	public EditText msrDtls       ; // 조치사항
    	public TextView tvMsrDtls     ; // 조치사항

		public TextView getpIspnChkMgntSeq() {
			return pIspnChkMgntSeq;
		}

		public TextView getpIspnChkSeq() {
			return pIspnChkSeq;
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

		public void setpIspnChkMgntSeq(TextView pIspnChkMgntSeq) {
			this.pIspnChkMgntSeq = pIspnChkMgntSeq;
		}

		public void setpIspnChkSeq(TextView pIspnChkSeq) {
			this.pIspnChkSeq = pIspnChkSeq;
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

		public CheckBox getIspnRslt1() {
			return ispnRslt1;
		}

		public CheckBox getIspnRslt2() {
			return ispnRslt2;
		}

		public void setIspnRslt1(CheckBox ispnRslt1) {
			this.ispnRslt1 = ispnRslt1;
		}

		public void setIspnRslt2(CheckBox ispnRslt2) {
			this.ispnRslt2 = ispnRslt2;
		}

		public EditText getMsrDtls() {
			return msrDtls;
		}

		public void setMsrDtls(EditText msrDtls) {
			this.msrDtls = msrDtls;
		}

		
		public TextView getTvMsrDtls() {
			return tvMsrDtls;
		}

		public void setTvMsrDtls(TextView tvMsrDtls) {
			this.tvMsrDtls = tvMsrDtls;
		}

		public ViewHolder(View itemView) {
            super(itemView);
        	
        	ispnItem = (TextView) itemView.findViewById(R.id.tv_row_1); // 검사항목
        	ispnStd  = (TextView) itemView.findViewById(R.id.tv_row_2); // 검사기준
        	cntrChk  = (CheckBox) itemView.findViewById(R.id.chk_row_3); // 시공사점검
        	ispnRslt1  = (CheckBox) itemView.findViewById(R.id.chk_row_4); // 검사결과-합격	
        	ispnRslt2  = (CheckBox) itemView.findViewById(R.id.chk_row_5); // 검사결과-불합격  	
        	msrDtls   = (EditText) itemView.findViewById(R.id.et_row_6); // 조치사항
        	tvMsrDtls   = (TextView) itemView.findViewById(R.id.tv_row_6); // 조치사항
        	
        	itemView.setClickable(true);
        	itemView.setFocusable(true);
        	itemView.setOnClickListener(this);            
            if ( getEnable() ) {
            }
            ispnRslt1.setOnClickListener(this);
            ispnRslt2.setOnClickListener(this);
            cntrChk.setOnClickListener(this);
            
        	msrDtls.setClickable(true);
        	msrDtls.setFocusable(true);
        	msrDtls.setOnTouchListener(this);
        }

		@Override
		public void onClick(View v) {
//			final TestRsltRegActivity activity = (TestRsltRegActivity)mContext;
//	    	activity.alert(v1.getSample_1() + " / " + v1.getSample_2());
			oldSelectedItem = selectedItem;
            notifyItemChanged(selectedItem);
            selectedItem = getLayoutPosition();
            notifyItemChanged(selectedItem);
//            v.setSelected(true);
			if ( v.getId() == R.id.et_row_6) {
//				msrDtls.setFocusable(true);				
//				activity.setFocus(R.id.et_row_6, true);
//				msrDtls.requestFocus();				
//				activity.showKeyboard();				
			}
		}
		
		@Override
		public boolean onTouch(View v, MotionEvent event) {
			boolean rtn = false;
			if ( event.getAction() == MotionEvent.ACTION_DOWN) {
				if ( v.getId() == R.id.et_row_6) {
					editView = (EditText)v;
					this.itemView.setTag(R.id.et_row_6,true);
				} else {
					this.itemView.setTag(R.id.et_row_6,false);
				}
//				((View) v.getParent().getParent()).performClick();	
				return false;
			} else if ( event.getAction() == MotionEvent.ACTION_UP) {
				rtn = false;
			
//				final EditText ev = (EditText)v;
//				Handler mHandler = new Handler();
//				mHandler.postDelayed(new Runnable()
//				{
//				  @Override     public void run()
//				  {
//					  ev.requestFocus();
//				  }
//				}, 2000);					
//				rtn = false;
			}
			return rtn;
		}
    }

	@Override
	public int getItemCount() {
		return items!=null?items.size():0;		
	}
	
	@Override
	public int getItemViewType(int p) {
		TestRsltWrtListDTO item = (TestRsltWrtListDTO)items.get(p);
	    int viewType = WConstant.LIST_DATA_MODE_READ.equals(item.getMode())?ITEM_VIEW_TYPE_READ:ITEM_VIEW_TYPE_EDIT;
//	    //Util.i("item.getMode() : " + item.getMode() + "/" + p);
        //Util.i("getItemViewType : " + ("item.getMode() : " + item.getMode() + "/" + p) );	    
	    return viewType; // 0 Or 1 : 0=R, 1=I
	}

	@Override
	public ViewHolder onCreateViewHolder(ViewGroup viewGroup, int viewType) {
//        View itemLayoutView = mInflater.inflate(viewType==0?R.layout.list_item_sample_list:R.layout.list_item_sample_list_input, viewGroup, false);
        View itemLayoutView = mInflater.inflate(R.layout.list_item_test_rslt_reg, viewGroup, false);
                
//      View itemLayoutView = LayoutInflater.from(viewGroup.getContext()).inflate(R.layout.list_item_sample_list, viewGroup, false);
        TestRsltRegAdapter.ViewHolder viewHolder = new TestRsltRegAdapter.ViewHolder(itemLayoutView);
        if ( viewType==ITEM_VIEW_TYPE_READ ) { // I
//        	viewHolder.getMvSample1().setId(INSERT_ITEM_ID);
//        	itemLayoutView.setVisibility(View.GONE);
        }
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
	public void onBindViewHolder(final TestRsltRegAdapter.ViewHolder viewHodler, final int p) {
		viewHodler.itemView.setSelected(selectedItem == p);
		final TestRsltWrtListDTO data = items.get(p);
        viewHodler.getIspnItem().setText(data.getIspnItem()); // 검사항목 
        viewHodler.getIspnStd ().setText(data.getIspnStd ()); // 검사기준 
//        viewHodler.getCntrChk ().setText(data.getCntrChk ()); // 시공사점검
        viewHodler.getMsrDtls().setText(data.getMsrDtls()); // 조치사항
        viewHodler.getTvMsrDtls().setText(data.getMsrDtls()); // 조치사항
        
        //in some cases, it will prevent unwanted situations
        viewHodler.getIspnRslt1().setOnCheckedChangeListener(null);
        viewHodler.getIspnRslt2().setOnCheckedChangeListener(null);
//    	v.getPosition();
        viewHodler.getMsrDtls().setOnFocusChangeListener(null); 
        viewHodler.getMsrDtls().setOnEditorActionListener(null);
    	viewHodler.getCntrChk ().setEnabled(Boolean.FALSE);        	
        if ( getEnable() == Boolean.FALSE) {
    		viewHodler.getIspnRslt1 ().setEnabled(Boolean.FALSE);
    		viewHodler.getIspnRslt2 ().setEnabled(Boolean.FALSE);
        } else {
        	if ( RsltStatus.TRUE.getTypeCd().equals(data.getCntrChk()) ) {
        		viewHodler.getCntrChk ().setChecked(Boolean.TRUE); 
        	} else {
        		viewHodler.getCntrChk ().setChecked(Boolean.FALSE);    		
        	}        
        	
        	if ( RsltStatus.TRUE.getTypeCd().equals(data.getIspnRslt()) ) {
        		viewHodler.getIspnRslt1().setChecked(Boolean.TRUE); 
        		viewHodler.getIspnRslt2().setChecked(Boolean.FALSE); 
        	} else if ( RsltStatus.FALSE.getTypeCd().equals(data.getIspnRslt()) ) {
        		viewHodler.getIspnRslt1().setChecked(Boolean.FALSE); 
        		viewHodler.getIspnRslt2().setChecked(Boolean.TRUE);    		
        	} else {
        		viewHodler.getIspnRslt1().setChecked(Boolean.FALSE); 
        		viewHodler.getIspnRslt2().setChecked(Boolean.FALSE); 
        	}
        	
        	viewHodler.getIspnRslt1().setOnCheckedChangeListener(new OnCheckedChangeListener() {
                @Override
                public void onCheckedChanged(CompoundButton buttonView, boolean isChecked) {
            		if ( isChecked )
            			data.setIspnRslt(RsltStatus.TRUE.getTypeCd());          	
                }
            });
        	viewHodler.getIspnRslt2().setOnCheckedChangeListener(new OnCheckedChangeListener() {
        		@Override
        		public void onCheckedChanged(CompoundButton buttonView, boolean isChecked) {
            		if ( isChecked )    			
        				data.setIspnRslt(RsltStatus.FALSE.getTypeCd());          	
        		}
        	});
        }
    	
//        viewHodler.itemView.setLayoutParams(new LinearLayout.LayoutParams(LayoutParams.MATCH_PARENT,LayoutParams.MATCH_PARENT));
	    if ( selectedItem == p ) {
	    	viewHodler.itemView.setBackgroundResource(R.drawable.listview_item_selector);
	        if ( getEnable() ) {	    	
	        	viewHodler.getMsrDtls().setVisibility(View.VISIBLE);
	        	viewHodler.getTvMsrDtls().setVisibility(View.GONE);
	        } else {
				viewHodler.getTvMsrDtls().setVisibility(View.VISIBLE);			
	        	viewHodler.getMsrDtls().setVisibility(View.GONE);
	        }
//	    	viewHodler.getMsrDtls().setImeOptions(EditorInfo.IME_ACTION_DONE | EditorInfo.IME_ACTION_);
	    	viewHodler.getMsrDtls().setOnEditorActionListener(new OnEditorActionListener() {
				@Override
				public boolean onEditorAction(TextView v, int actionId, KeyEvent event) {
					if ((actionId == EditorInfo.IME_ACTION_DONE) ||
							(event != null && event.getKeyCode() == KeyEvent.KEYCODE_ENTER)) {
			    		data.setMsrDtls(String.valueOf(v.getText()));
						TestRsltRegActivity activity = (TestRsltRegActivity)mContext;
						activity.hideKeyboard();
					}
					return false;
				}
			});
	    	// onblur
	    	viewHodler.getMsrDtls().setOnFocusChangeListener(new View.OnFocusChangeListener() {
	            @Override
	            public void onFocusChange(View v, boolean hasFocus) {
	                if (!hasFocus){
		    			EditText et = (EditText)v;
			    			TestRsltRegActivity activity = (TestRsltRegActivity)mContext;
			    			activity.hideKeyboard(et);
		        			data.setMsrDtls(String.valueOf(et.getText()));
//		        			items.get(selectedItem);
//		        			((View) v.getParent()).requestFocus();
		                    notifyItemChanged(oldSelectedItem);
		                    Util.i("selectedItem / oldSelectedItem : " + selectedItem + " / " + oldSelectedItem );
	                }
	            }
	        });
	    	boolean editTouched = (Boolean) (viewHodler.itemView.getTag(R.id.et_row_6)!=null?viewHodler.itemView.getTag(R.id.et_row_6):false);
	    	if ( editTouched ) {
//	    		final EditText et = viewHodler.getMsrDtls();
//				et.requestFocus();	    		
//	    		Handler mHandler = new Handler();
//	    		mHandler.postDelayed(new Runnable()
//	    		{
//	    			@Override public void run()
//	    			{
//	    				et.requestFocus();
//	    			}
//	    		}, 1000);
	    	}
		} else {
			viewHodler.getTvMsrDtls().setVisibility(View.VISIBLE);			
        	viewHodler.getMsrDtls().setVisibility(View.GONE);
        	viewHodler.itemView.setBackgroundResource(p % 2 == 0 ? R.drawable.listview_item_selector_1 : R.drawable.listview_item_selector_2 );
        }
//    	viewHodler.itemView.setBackgroundResource(R.drawable.listview_item_selector);        
//        viewHodler.itemView.setClickable(true);
        viewHodler.itemView.setTag(data);
//	    lv1.addItemDecoration(new DividerItemDecoration(TestChkMainRecyclerViewActivity.this, R.color.listDivColor));
        Util.i("onBindViewHolder : " + p + " / " + data.getIspnRslt());
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
		EditText et = holder.getMsrDtls();
		TextView tv = holder.getTvMsrDtls();
		tv.setText(String.valueOf(et.getText()) );
//		et.requestFocus();            	
//        new Handler().postDelayed(new Runnable() {
//            @Override
//            public void run() {
//				et.requestFocus();            	
//            }
//        }, 1000);
        Util.i("onViewRecycled : " + holder.getAdapterPosition() + " / " + String.valueOf(et.getText()) );		
	}

	public void acceptData(int position) {
		if ( selectedItem > -1 && editView != null) {
			TestRsltWrtListDTO data = items.get(position);
			data.setMsrDtls(String.valueOf(editView.getText()));
		}
	}
	
	@Override
	public boolean onInterceptTouchEvent(RecyclerView arg0, MotionEvent arg1) {
		return false;
	}

	@Override
	public void onRequestDisallowInterceptTouchEvent(boolean arg0) {
		
	}

	@Override
	public void onTouchEvent(RecyclerView arg0, MotionEvent arg1) {
		
	}
	
}


