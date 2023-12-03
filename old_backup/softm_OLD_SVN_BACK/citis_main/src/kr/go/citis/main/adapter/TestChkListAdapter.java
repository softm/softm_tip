package kr.go.citis.main.adapter;

import java.util.ArrayList;

import kr.go.citis.lib.type.RprtType;
import kr.go.citis.lib.type.RsltStatus;
import kr.go.citis.lib.type.SiteType;
import kr.go.citis.main.R;
import kr.go.citis.main.activity.TestChkListActivity;
import kr.go.citis.main.common.WConstant;
import kr.go.citis.main.common.WUtil;
import kr.go.citis.main.dto.TestChkListDTO;

import org.apache.commons.lang3.StringUtils;

import android.annotation.SuppressLint;
import android.content.Context;
import android.support.v7.widget.RecyclerView;
import android.view.KeyEvent;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.PopupMenu;
import android.widget.PopupMenu.OnMenuItemClickListener;
import android.widget.TextView;
/**
 * TestChkListAdapter
 * @author softm
 * 검측체크 목록
 */
public class TestChkListAdapter extends RecyclerView.Adapter<TestChkListAdapter.ViewHolder> implements OnMenuItemClickListener {		
	Context mContext;
	LayoutInflater mInflater;
	ArrayList<TestChkListDTO> items;
    private int selectedItem = 0;	
	public final static int ITEM_VIEW_TYPE_READ = 0;
	public final static int ITEM_VIEW_TYPE_EDIT = 1;
	public TestChkListAdapter(Context context, LayoutInflater inflater,ArrayList<TestChkListDTO> data) {
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

	public ArrayList<TestChkListDTO> getItems() {
		return items;
	}

	public void setItems(ArrayList<TestChkListDTO> items) {
		this.items = items;
	}

	public void addItem(TestChkListDTO item) {
		selectedItem = 0;
		this.items.add(0,item);
	}

	public class ViewHolder extends RecyclerView.ViewHolder implements View.OnClickListener {
        public TextView pIspnChkMgntSeq; // 검측마스터번호
        public TextView ispnChkSeq     ; // 검측체크번호
        public TextView chkDt          ; // 점검일자
        public TextView dtlcnsttypecd  ; // 세부공종코드
        public TextView dtlcnsttypeNm  ; // 전체공종명-세부공종명
        public TextView ispnDt         ; // 검측일자
        public TextView rsltStatus     ; // 검측결과코드
        public TextView rsltStatusNm   ; // 검측결과명
        public Button btnView1         ; // 버튼 재작성
        public Button btnView2         ; // 버튼 더보기

		public TextView getpIspnChkMgntSeq() {
			return pIspnChkMgntSeq;
		}

		public TextView getIspnChkSeq() {
			return ispnChkSeq;
		}

		public TextView getChkDt() {
			return chkDt;
		}

		public TextView getDtlcnsttypecd() {
			return dtlcnsttypecd;
		}

		public TextView getDtlcnsttypeNm() {
			return dtlcnsttypeNm;
		}

		public TextView getIspnDt() {
			return ispnDt;
		}

		public TextView getRsltStatus() {
			return rsltStatus;
		}

		public TextView getRsltStatusNm() {
			return rsltStatusNm;
		}

		public ViewHolder(View itemView) {
            super(itemView);
            chkDt        = (TextView) itemView.findViewById(R.id.tv_row_1); // 점검일자    
//            dtlcnsttypecd= (TextView) itemView.findViewById(R.id.tv_row_2); // 세부공종코드
            dtlcnsttypeNm= (TextView) itemView.findViewById(R.id.tv_row_2); // 세부공종명  
            ispnDt       = (TextView) itemView.findViewById(R.id.tv_row_3); // 검측일자    
//            rsltStatus   = (TextView) itemView.findViewById(R.id.tv_row_5); // 검측결과코드
            rsltStatusNm = (TextView) itemView.findViewById(R.id.tv_row_4); // 검측결과명  
            btnView1 = (Button) itemView.findViewById(R.id.btn_row_3); // 재작성
            btnView2 = (Button) itemView.findViewById(R.id.btn_row_5); // 검측결과명  더보기.
            
            itemView.setClickable(true);
            itemView.setFocusable(true);
            itemView.setOnClickListener(this);
            btnView1.setOnClickListener(this);
            btnView2.setOnClickListener(this);
        }

		@SuppressLint("NewApi")
		@Override
		public void onClick(View v) {
			final TestChkListActivity activity = (TestChkListActivity)mContext;
			
            if (v.getId() == btnView1.getId()) { // 검측요청
            	v = (View) v.getParent().getParent();
            	TestChkListDTO v1 = (TestChkListDTO) v.getTag();
            	//Util.i(v1.getpSiteNo() + " / " + v1.getIspnChkMgntSeq());
//                Toast.makeText(v.getContext(), "ITEM PRESSED = " + String.valueOf(getAdapterPosition()), Toast.LENGTH_SHORT).show();
    			WUtil.goBldChkupWrt(activity, WConstant.WRITE_MODE_SECOND, v1.getSiteNo(), activity.pIspnChkMgntSeq, v1.getIspnChkSeq()); // 재작성    			
            } else if (v.getId() == btnView2.getId()) {
            	
//                activity.showMenu(v, R.menu.popup_menu);
                
            	// showmenu
//            	public void showMenu(View anchor, int menuRes) {
	        		PopupMenu popup = new PopupMenu(activity, v);
	        	    popup.setOnMenuItemClickListener((OnMenuItemClickListener) TestChkListAdapter.this);
	        	    popup.inflate(R.menu.popup_menu);
	        	    
	        	    v = (View) v.getParent().getParent();
	        	    TestChkListDTO v1 = (TestChkListDTO) v.getTag();
	        	    Menu menu = popup.getMenu();
	            
	        	    if ( StringUtils.isEmpty(v1.getChkDt())) { // 검측요청 : 점검일자가 있을경우만 표시 : 검측요청서 화면으로 이동
	        	        menu.removeItem(R.id.menu_action_2);	
	        	    }
	        	    if ( StringUtils.isEmpty(v1.getRqstsDt()) 
                        || "99991231".equals(v1.getRqstsDt()) ) { // 검측결과 : 검측요청일이 있을경우만 표시 :  검측결과 화면으로 이동
	        	    	menu.removeItem(R.id.menu_action_3);
	        	    }
	        	    if ( StringUtils.isEmpty(v1.getIspnDt())) {  // 검측결과통보 : 검측일자가 있을경우만 표시 :  검측결과통보 화면으로 이동
	        	    	menu.removeItem(R.id.menu_action_4);
	        	    }
	        	    
	        	    if ( StringUtils.isEmpty(v1.getRprtSeq())) {  // 부적합 보고서, 시정조치 보고서
	        	    	menu.removeItem(R.id.menu_action_5);
	        	    	menu.removeItem(R.id.menu_action_6);
	        	    } else {
		        	    if ( RprtType.NCR.getTypeCd().equals(v1.getRprtType())) { // 부적합 보고서.
		        	    	menu.removeItem(R.id.menu_action_6); // 시정조치 보고서.		        	    	
		        	    } else if ( RprtType.CAR.getTypeCd().equals(v1.getRprtType())) { // 시정조치 보고서.
		        	    	menu.removeItem(R.id.menu_action_5); // 부적합 보고서.		        	    	
		        	    }
	        	    }
	        	    popup.show();
//            	}
            } else {
//                Toast.makeText(v.getContext(), "ROW PRESSED = " + String.valueOf(getAdapterPosition()), Toast.LENGTH_SHORT).show();
//            	TestChkListDTO v1 = (TestChkListDTO) v.getTag();
            	//Util.i(v1.getpSiteNo() + " / " + v1.getIspnChkMgntSeq());
            }
            
            if (v.getId() == btnView2.getId()) {
//                Toast.makeText(v.getContext(), "ITEM PRESSED = " + String.valueOf(getAdapterPosition()), Toast.LENGTH_SHORT).show();
            } else {
//                Toast.makeText(v.getContext(), "ROW PRESSED = " + String.valueOf(getAdapterPosition()), Toast.LENGTH_SHORT).show();
            }
//            TestChkListDTO v1 = (TestChkListDTO) v.getTag();
//    	    	activity.alert(v1.getSample_1() + " / " + v1.getSample_2());
            //Util.i(v1.getIspnChkSeq() );                
            notifyItemChanged(selectedItem);
            selectedItem = getLayoutPosition();
            notifyItemChanged(selectedItem);
//            v.setSelected(true);
		}
    }

	@Override
	public int getItemCount() {
		return items!=null?items.size():0;		
	}
	
	@Override
	public int getItemViewType(int p) {
		TestChkListDTO item = (TestChkListDTO)items.get(p);
	    int viewType = WConstant.LIST_DATA_MODE_READ.equals(item.getMode())?ITEM_VIEW_TYPE_READ:ITEM_VIEW_TYPE_EDIT;
	    return viewType; // 0 Or 1 : 0=R, 1=I
	}

	@Override
	public ViewHolder onCreateViewHolder(ViewGroup viewGroup, int viewType) {
        View itemLayoutView = mInflater.inflate(R.layout.list_item_test_chk_list, viewGroup, false);
        TestChkListAdapter.ViewHolder viewHolder = new TestChkListAdapter.ViewHolder(itemLayoutView);
        if ( viewType==ITEM_VIEW_TYPE_READ ) { // I
        }
        //Util.i("onCreateViewHolder" );
        return viewHolder;
	}

	@Override
	public void onBindViewHolder(TestChkListAdapter.ViewHolder viewHodler, int p) {
		viewHodler.itemView.setSelected(selectedItem == p);
		TestChkListDTO data = items.get(p);
        viewHodler.getChkDt        ().setText(WUtil.toDateFormat(data.getChkDt        ())); // 점검일자         
//        viewHodler.getDtlcnsttypecd().setText(data.getDtlcnsttypecd()); // 세부공종코드       
        viewHodler.getDtlcnsttypeNm().setText(data.getDtlcnsttypeNm()); // 전체공종명-세부공종명
        viewHodler.getIspnDt       ().setText(WUtil.toDateFormat(data.getIspnDt       ())); // 검측일자         
//        viewHodler.getRsltStatus   ().setText(data.getRsltStatus   ()); // 검측결과코드       
        viewHodler.getRsltStatusNm ().setText(RsltStatus.NONE.getTypeCd().equals(data.getRsltStatus())?RsltStatus.NONE.getTypeNm():data.getRsltStatusNm ()); // 검측결과명        
        
//        public enum ProgressType {
//        	START("시공사작성중"   ,"01"),
//        	ING1("감리단검측요청  ","02"),
//        	ING2("감리단검측"    ,"03"),
//        	END("검측통보완료"   ,"04");
		final TestChkListActivity activity = (TestChkListActivity)mContext;
        // 재작성 버튼은 체크리스트 이력이 마지막 레코드가 부적합일 때 디스플레이되고 그외의 경우는 적합, 부적합 텍스트를 디스플레이한다.
        if ( p == 0 && RsltStatus.FALSE.getTypeCd().equals(data.getRsltStatus()) && activity.var.SITE_TYPE != SiteType.GAMRI ) {
        	viewHodler.btnView1.setVisibility(View.VISIBLE); // 재작성
        	viewHodler.getIspnDt().setVisibility(View.GONE); // 검측일자
        } else {
        	viewHodler.btnView1.setVisibility(View.GONE); // 재작성
        	viewHodler.getIspnDt().setVisibility(View.VISIBLE); // 검측일자
        }

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

    @Override  
	public boolean onMenuItemClick(MenuItem item) {
		final TestChkListActivity activity = (TestChkListActivity)mContext;    	
		TestChkListDTO v1 = (TestChkListDTO) items.get(this.selectedItem);
		switch( item.getItemId() ) {
		case R.id.menu_action_1: // 상세보기
			WUtil.goBldChkupWrt(mContext, WConstant.WRITE_MODE_UPDATE, v1.getSiteNo(), activity.pIspnChkMgntSeq, v1.getIspnChkSeq());
			break;
		case R.id.menu_action_2: // 검측요청
			WUtil.goTestReqDoc(mContext, activity.pIspnChkMgntSeq);
			break;
		case R.id.menu_action_3: // 검측결과
			WUtil.goTestRsltReg(mContext, v1.getSiteNo(), activity.pIspnChkMgntSeq, v1.getIspnChkSeq());			
			break;
		case R.id.menu_action_4: // 검측결과통보
			WUtil.goTestRsltNoti(mContext, activity.pIspnChkMgntSeq, v1.getIspnChkSeq());			
			break;
		case R.id.menu_action_5: // 부적합 보고서
			WUtil.goNcrRprt(mContext, v1.getRprtSeq());
			break;
		case R.id.menu_action_6: // 시정조치 보고서
			WUtil.goCarRprt(mContext, v1.getRprtSeq());
			break;
		}
		return false;
	}
	
}


