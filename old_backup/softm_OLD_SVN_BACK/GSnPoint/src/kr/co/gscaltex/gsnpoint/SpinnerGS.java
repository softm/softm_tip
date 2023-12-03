package kr.co.gscaltex.gsnpoint;

import java.util.Comparator;

import android.content.Context;
import android.util.AttributeSet;
import android.widget.ArrayAdapter;
import android.widget.Spinner;
import android.widget.SpinnerAdapter;

public class SpinnerGS extends Spinner {
    // declare object to hold data values
    private ArrayAdapter<String> arrayAdapter;
	
	public SpinnerGS(Context context, AttributeSet attrs) {
		super(context, attrs);
		initialise();
	}
	
    // internal routine to set up the array adapter, bind it to the spinner and disable it as it is empty
    private void initialise() {
    	this.setBackgroundResource(R.drawable.gs_spinner_img);
		arrayAdapter = new ArrayAdapter<String>(this.getContext(),R.layout.spinner_item);
		arrayAdapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
		setAdapter(arrayAdapter);
		setEnabled(true);
	}
   
    // allow the caller to use a different DropDownView, defaults to android.R.layout.simple_dropdown_item_1line
    public void setDropDownViewResource(int resource) {
        arrayAdapter.setDropDownViewResource(resource);
    }
    
    public void addItems(String[] items) {
    	String sItem = null;
    	for (int i = 0; i < items.length; i++)  {
    		this.addItem(items[i]);
    		if ( i == 0 ) sItem = items[i];
    	}
    	selectItem(sItem);
    }
    
    // add the selected item to the end of the list
    public void addItem(String item) {
        this.addItem(item, true);
    }
    
    public void addItem(String item, boolean select) {
        arrayAdapter.add(item);
        this.setEnabled(true);
        if (select) this.selectItem(item);
//        arrayAdapter.sort(new Comparator<String>() {
//            public int compare(String object1, String object2) {
//                return object1.compareTo(object2);
//            };
//        });
    }

    // remove all items from the list and disable it
    public void clearItems() {
        arrayAdapter.clear();
        this.setEnabled(false);
    }

    // make the specified item selected (returns false if item not in the list)
    public boolean selectItem(String item) {
        boolean found = false;
        for (int i = 0; i < this.getCount(); i++) {
            if (arrayAdapter.getItem(i) == item) {
                this.setSelection(i);
                found = true;
                break;
            }
        }
        return found;
    }

    // return the current selected item
    public String getSelected() {
        if (this.getCount() > 0) {
            return arrayAdapter.getItem(super.getSelectedItemPosition());
        } else {
            return "";
        }
    }

}
