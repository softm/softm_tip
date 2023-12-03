package com.entropykorea.gas.lib;

import java.util.LinkedHashMap;
import java.util.Map.Entry;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.util.AttributeSet;
import android.util.Log;
import android.util.TypedValue;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ResourceCursorAdapter;
import android.widget.SimpleCursorAdapter;
import android.widget.Spinner;
import android.widget.TextView;
/**
 * SpinnerCd
 * @author softm 
 */
public class SpinnerCd extends Spinner {
	public SpinnerCd(Context context, AttributeSet attrs) {
		super(context, attrs);
		initialise();
	}
    private void initialise() {
    	this.setBackgroundResource(R.drawable.dropdown_img);
//    	setPopupBackgroundResource(R.drawable.dropdown_panel);
		setEnabled(true);
	}
    private boolean orderByAsc = true;
    public void setOrderByAsc(boolean v) {
    	orderByAsc = v;
    }
    
    private float fontSize = -1;
    public void setFontSize(float f) {
    	fontSize = f;
    }
    private boolean dialogVisible = true;  
    public boolean getDialogVisible() {
    	return this.dialogVisible;
    }
   	public SpinnerCd setDialogVisible(boolean dialogVisible) {
    	this.dialogVisible = dialogVisible; 
    	return this;
    }
   	
    @Override
    public boolean performClick() {
       if(!getDialogVisible()) {
           return false;
       }
       else {
           return super.performClick();
       }
    }
    
    public void setDropDownViewResource(int resource) {
    	((ResourceCursorAdapter) this.getAdapter()).setDropDownViewResource(resource);
    }
    public boolean setValue(String v) {
//      Cursor c = (Cursor)this.getAdapter().getItem(super.getSelectedItemPosition());        
        boolean found = false;
        if ( c != null) {        
        	int i = -1;
	        c.moveToFirst();
			do {
				i++;
	//			String typeCd = c.getString(c.getColumnIndex("TYPE_CD"));
				String cd = c.getString(c.getColumnIndex("CD"));
	//			String cdNm = c.getString(c.getColumnIndex("CD_NM"));
				if ( cd.equals(v) ) {
					this.setSelection(i);
	                found = true;
					//break;
				}
			} while (c.moveToNext());
	        c.moveToFirst();
        } else {
        	int count = this.getAdapter().getCount();
        	for ( int i=0;i<count;i++) {
        		String cd = (String) this.getAdapter().getItem(i);
				if ( cd.equals(v) ) {
					this.setSelection(i);
	                found = true;
					break;
				}
        	}
        }
        return found;
    }
    
    public void setSelected(int position) {
        if (this.getCount() > position) {
			this.setSelection(position);
        }
    }
    
    public int getSelected() {
    	return this.getSelectedItemPosition();
    }
    
    public CodeDTO getSelectedValue() {
        CodeDTO rtn = new CodeDTO();    	
        if (this.getCount() > 0) {
//            Cursor c = (Cursor)this.getAdapter().getItem(super.getSelectedItemPosition());
            rtn.setCd(c.getString(1)); // cd
            rtn.setCdNm(c.getString(2)); // cdNm
            return rtn;
        } else {
            return rtn;
        }
    }

    public String getValue() {
        String rtn = null;    	
        if (this.getCount() > 0) {
//            Cursor c = (Cursor)this.getAdapter().getItem(super.getSelectedItemPosition());
            rtn = c.getString(1);
            return rtn;
        } else {
            return rtn;
        }
    }

    public String getText() {
        String rtn = null;    	
        if ( c != null) {
        	if (this.getCount() > 0) {
//            Cursor c = (Cursor)this.getAdapter().getItem(super.getSelectedItemPosition());
        		rtn = c.getString(2);
        		return rtn;
        	} else {
        		return rtn;
        	}
        } else {
          rtn = (String) this.getAdapter().getItem(super.getSelectedItemPosition());        	
        }
		return rtn;
    }
    
	public void setGravity(int i) {
		this.setGravity(i);
	}
	public SpinnerCd getCode(JSONArray code) {
		return getCode(code,"");
	}
	public SpinnerCd getCode(JSONArray code,int resourceId) {
		return getCode(code,getResources().getString(resourceId));		
	}
	private Cursor c = null;
	public SpinnerCd getCode(JSONArray code,String prompt) {
		String sql = "";
		JSONObject resultObject;
		try {
			resultObject = code.getJSONObject(0);
			
			if ( !"".equals(prompt) ) {
				sql += "select "
					    + " 1 as _id ,"
					    + "'' as CD   ,"
					    + "'" + prompt + "' as CD_NM "
                ;
			}
			for (int idx = 0; idx < resultObject.length(); idx++) {
				if ( !"".equals(sql) || idx > 0 )
					sql += " UNION ";
				
				sql += "select "
				    + " " + (idx +2 )+ " as _id ,"
				    + "'" + resultObject.names().getString(idx)   + "' as CD   ,"
				    + "'" + resultObject.getString(resultObject.names().getString(idx)) + "' as CD_NM "
				;
			}
		} catch (JSONException e) {
			e.printStackTrace();
		}
		DefaultApplication mApp = (DefaultApplication) this.getContext().getApplicationContext();
		SQLiteDatabase db = mApp.getDatabase();
		if ( c!= null ) c.close();
        c = db.rawQuery(sql, null);		
		String[] from = new String[] { "CD_NM" }; // 가져올 DB의 필드 이름
		int[] to = new int[] { android.R.id.text1 }; // 각각 대응되는 xml의 TextView의
		SpinnerAdapter adapter = new SpinnerAdapter(
				this.getContext(), // ListView의 context
				android.R.layout.simple_list_item_1, // ListView의 Custom layout
				c, // Item으로 사용할 DB의 Cursor
				from, // DB 필드 이름
				to // DB필드에 대응되는 xml TextView의 id
			   , 0
			   ,this.fontSize);
		adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);		
		setAdapter(adapter);
		return this;
	}

	public SpinnerCd getCode(LinkedHashMap<String, String> map) {
		return getCode(map,"");
	}
	public SpinnerCd getCode(LinkedHashMap<String, String> map,int resourceId) {
		return getCode(map,getResources().getString(resourceId));		
	}
	public SpinnerCd getCode(LinkedHashMap<String, String> map,String prompt) {
		String sql = "";
		int idx = -1;
		if ( !"".equals(prompt) ) {
			sql += "select "
				    + " 1 as _id ,"
				    + "'' as CD   ,"
				    + "'" + prompt + "' as CD_NM "
            ;
			idx = 1;
		}

		for(Entry<String, String> item:map.entrySet()) {
			if ( idx > -1 )
				sql += " UNION ";
			
			idx++;
			sql += "select "
			    + " " + (idx )+ " as _id ,"
			    + "'" + item.getKey()   + "' as CD   ,"
			    + "'" + item.getValue() + "' as CD_NM "
			;
		}
		if ( orderByAsc ) {
			sql += " ORDER BY CD ASC";
		}
		Log.d("MPGAS",sql);
		DefaultApplication mApp = (DefaultApplication) this.getContext().getApplicationContext();
		SQLiteDatabase db = mApp.getDatabase();
		if ( c!= null ) c.close();
        c = db.rawQuery(sql, null);		
//		adapter.setDropDownViewResource(android.R.layout.select_dialog_item);
		String[] from = new String[] { "CD_NM" }; // 가져올 DB의 필드 이름
		int[] to = new int[] { android.R.id.text1 }; // 각각 대응되는 xml의 TextView의
		SpinnerAdapter adapter = new SpinnerAdapter(
				this.getContext(), // ListView의 context
				android.R.layout.simple_list_item_1, // ListView의 Custom layout
				c, // Item으로 사용할 DB의 Cursor
				from, // DB 필드 이름
				to // DB필드에 대응되는 xml TextView의 id
				   , 0
				   ,this.fontSize);
		adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);		
		setAdapter(adapter);
		return this;
	}
	public SpinnerCd getCode(String code) {
		return getCode(code,"");
	}
	
	public SpinnerCd getCode(String code,int resourceId) {
		return getCode(code,getResources().getString(resourceId));
	}
	
	public SpinnerCd getCode(String code,String prompt) {
		DefaultApplication mApp = (DefaultApplication) this.getContext().getApplicationContext();
		SQLiteDatabase db = mApp.getDatabase();
		
		String sql = "";
		if ( !"".equals(prompt) ) {
			sql = "select "
				    + " 0 as _id ,"
				    + "'' as CD   ,"
				    + "'" + prompt + "' as CD_NM "
            ;
		}
		if ( !"".equals(sql) ) {
			sql += " UNION ";
		}
		sql += " SELECT _rowid_ as _id, CD,CD_NM FROM " + DBHelper.TBL_CODE
		    + " WHERE TYPE_CD = '" + code + "'"
		;
		c = db.rawQuery(sql, null);
//      while (c.moveToNext()) {
//          String typeCd = c.getString(c.getColumnIndex("TYPE_CD"));
//          String cd     = c.getString(c.getColumnIndex("CD"     ));
//          String cdNm   = c.getString(c.getColumnIndex("CD_NM"  ));
//      }
		 
//		adapter.setDropDownViewResource(android.R.layout.select_dialog_item);
		String[] from = new String[] { "CD_NM" }; // 가져올 DB의 필드 이름
		int[] to = new int[] { android.R.id.text1 }; // 각각 대응되는 xml의 TextView의
		SpinnerAdapter adapter = new SpinnerAdapter(
				this.getContext(), // ListView의 context
				android.R.layout.simple_list_item_1, // ListView의 Custom layout
				c, // Item으로 사용할 DB의 Cursor
				from, // DB 필드 이름
				to // DB필드에 대응되는 xml TextView의 id
				   , 0
				   ,this.fontSize);
		adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);		
		setAdapter(adapter);
		return this;
	}
	public SpinnerCd getArrange(int fromV,int toV,String prompt) {
			String sql = "";
			int idx = -1;
			if ( !"".equals(prompt) ) {
				sql += "select "
					    + " 1 as _id ,"
					    + "'' as CD   ,"
					    + "'" + prompt + "' as CD_NM "
	            ;
				idx = 1;
			}
	
			for(int seq=fromV;seq<=toV; seq++) {
				if ( idx > -1 )
					sql += " UNION ";
				
				idx++;
				sql += "select "
				    + " " + (idx )+ " as _id ,"
				    + "'" + seq   + "' as CD   ,"
				    + "'" + seq + "' as CD_NM "
				;
			}
			Log.d("MPGAS",sql);
			DefaultApplication mApp = (DefaultApplication) this.getContext().getApplicationContext();
			SQLiteDatabase db = mApp.getDatabase();
			if ( c!= null ) c.close();
	        c = db.rawQuery(sql, null);		
	//		adapter.setDropDownViewResource(android.R.layout.select_dialog_item);
			String[] from = new String[] { "CD_NM" }; // 가져올 DB의 필드 이름
			int[] to = new int[] { android.R.id.text1 }; // 각각 대응되는 xml의 TextView의
			SpinnerAdapter adapter = new SpinnerAdapter(
					this.getContext(), // ListView의 context
					android.R.layout.simple_list_item_1, // ListView의 Custom layout
					c, // Item으로 사용할 DB의 Cursor
					from, // DB 필드 이름
					to // DB필드에 대응되는 xml TextView의 id
					   , 0
					   ,this.fontSize);
			adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);		
			setAdapter(adapter);
			return this;
		}
	public SpinnerCd getArrange(int fromV,int toV) {
		return getArrange(fromV,toV,"");
	}
	public SpinnerCd getArrange(int fromV,int toV,int resourceId) {
		return getArrange(fromV,toV,getResources().getString(resourceId));		
	}
	public class SpinnerAdapter extends SimpleCursorAdapter {
	    private float fontSize = -1;
	    public SpinnerAdapter(Context context, int layout, Cursor c,
				String[] from, int[] to, int flags,float fontSize) {
			super(context, layout, c, from, to, flags);
			this.fontSize = fontSize;
		}

	    /**
	     * 기본 스피너 View 정의
	     */
	    @Override
	    public View getView(int position, View convertView, ViewGroup parent) {
	        if (convertView == null) {
	            LayoutInflater inflater = LayoutInflater.from(getContext());
	            convertView = inflater.inflate(
	                    android.R.layout.simple_spinner_item, parent, false);
	        }
            Cursor c = (Cursor)this.getItem(position);

            	TextView tv = (TextView) convertView
            			.findViewById(android.R.id.text1);
                if ( position == 0 && "".equals(c.getString(1))  && "-선택-".equals(c.getString(2)) ) {
                	tv.setText("");
                } else {
                	tv.setText(c.getString(2));
                }
            	tv.setTextColor(getResources().getColor(R.color.spnFontColor));
            	tv.setTextSize(TypedValue.COMPLEX_UNIT_PX, this.fontSize==-1?getResources().getDimension(R.dimen.spnFontSize):this.fontSize);
            	return convertView;
	        
	    }

	    /**
	     * 스피너 클릭시 보여지는 View의 정의
	     */
	    @Override
	    public View getDropDownView(int position, View convertView,
	            ViewGroup parent) {
	 
	        if (convertView == null) {
	            LayoutInflater inflater = LayoutInflater.from(getContext());
	            convertView = inflater.inflate(
	                    android.R.layout.simple_spinner_dropdown_item, parent, false);
	        }
	 
	        TextView tv = (TextView) convertView
	                .findViewById(android.R.id.text1);
            Cursor c = (Cursor)this.getItem(position);
	        tv.setText(c.getString(2));
	        tv.setTextColor(getResources().getColor(R.color.spnFontColor));
//	        tv.setTextSize(TypedValue.COMPLEX_UNIT_PX, this.fontSize==-1?getResources().getDimension(R.dimen.spnFontSize):this.fontSize);
        	tv.setTextSize(TypedValue.COMPLEX_UNIT_PX, getResources().getDimension(R.dimen.spnFontSize));	        
	        return convertView;
	    }
	}
}
