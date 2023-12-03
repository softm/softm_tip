package com.entropykorea.gas.gum.activity.view;

import java.lang.reflect.Field;

import android.app.Activity;
import android.view.View;

public class ViewMapper {
	
    public static void mappingViews(Object object) {
        
        if( !(object instanceof Activity) )
            return;
         
        Activity activity = (Activity)object;
         
        Field[] fields = activity.getClass().getDeclaredFields();
        for(Field field : fields) {
             
            ViewById param = field.getAnnotation(ViewById.class);
            if( param == null )
                continue;
             
            int identifier = param.id();
            if( identifier == 0 ) {
                String identifierString = field.getName();
                identifier = activity.getResources().getIdentifier(identifierString, "id", activity.getPackageName());
            }
             
            if( identifier == 0 )
                continue;
             
            View view = activity.findViewById(identifier);
            if( view == null)
                continue;
             
            if(view.getClass() == field.getType()) {
                try {
                    field.setAccessible(true);
                    field.set(object, view);
                } catch (IllegalArgumentException e) {
                    e.printStackTrace();
                } catch (IllegalAccessException e) {
                    e.printStackTrace();
                }
            }
            
			//Click Listener
			String click = param.click().trim();
			if (click.length() > 0 ) {
				if (click.equals("this") == true) {
					view.setOnClickListener((View.OnClickListener)object);
				} else {
					try {
						Field fld = object.getClass().getField(click);
						view.setOnClickListener((View.OnClickListener)fld.get(object));
					} catch (Exception e) {
						e.printStackTrace();
					}
				}
			}

            //DLog.d("VIEWMAPPING:" + field.getName()  + "," + identifier + "," + view);
        }
    }
    
}
