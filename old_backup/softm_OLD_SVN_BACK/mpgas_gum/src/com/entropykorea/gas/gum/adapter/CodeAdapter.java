package com.entropykorea.gas.gum.adapter;

import android.content.Context;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;

import com.entropykorea.gas.gum.database.BaseCode;

public class CodeAdapter extends ArrayAdapter<String> {

	private Context context;

	public CodeAdapter(Context context, BaseCode baseCode ) {
		super(context, android.R.layout.simple_spinner_item);
		setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
		
		this.context = context;
		BaseCode mBaseCode = baseCode;
		super.addAll( mBaseCode.getArrayList() );
	}
	
	public CodeAdapter(Context context, String[] strings ) {
		super(context, android.R.layout.simple_spinner_item, strings );
		setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
		
		this.context = context;
	}
	
	boolean firsttime = true;
	@Override
	public View getView(int position, View convertView, ViewGroup parent) { 
		if(firsttime){
			firsttime = false;
			//just return some empty view
			//return new ImageView(context);
			//return super.getView(position, convertView, parent);
		}
		//let the array adapter takecare this time      
		return super.getView(position, convertView, parent);
	}
	
	
}
