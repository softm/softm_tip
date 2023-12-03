package com.entropykorea.ewire.spec;


import java.lang.reflect.Method;

import android.util.Log;


public class SpecReflection {
	
	public SpecReflection() {
		
	}
	
	// no parameter
	private static Object getReflection( Object object, String methodName ) {
		Object result = null;
		Class<?> cls = object.getClass();
		
		try {
			Method method = cls.getMethod(methodName);
			//Object t = cls.newInstance();
			result = method.invoke(object);
		} catch (Exception e) {
			e.printStackTrace();
			Log.e("EWIRE", "Error! Reflection" );
		}
						
		return result;
	}

	public static Integer getTotalLength( Object object ) {
		return (Integer) getReflection( object, "getTotalLength" );
	}

	public static String getFileName( Object object ) {
		return (String) getReflection( object, "getFileName" );
	}
	
	public static String getTableName( Object object ) {
		return (String) getReflection( object, "getTableName" );
	}
	
	public static FieldSpec[] getFieldSpecs( Object object ) {
		return (FieldSpec[]) getReflection( object, "getFieldSpecs" );
	}

	public static String getWhereClause( Object object ) {
		return (String) getReflection( object, "getWhereClause" );
	}
	
	public static String getSelectClause( Object object ) {
		return (String) getReflection( object, "getSelectClause" );
	}
		
}
