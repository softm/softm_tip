package com.entropykorea.gas.as.common.util;

import java.lang.reflect.Constructor;
import java.lang.reflect.InvocationTargetException;

public class ClassUtil {
	@SuppressWarnings("rawtypes")
	public static Constructor getConstructor(Class clazzName, Class[] methodName) {
		try {
			return clazzName.getConstructor(methodName);
		} catch (SecurityException e) {
			return null;
		} catch (NoSuchMethodException e) {
			return null;
		}
	}

	@SuppressWarnings("rawtypes")
	public static Object getInstance(Constructor constructor, Object... object) {
		try {
			return constructor.newInstance(object);
		} catch (IllegalArgumentException e) {
			return null;
		} catch (InstantiationException e) {
			return null;
		} catch (IllegalAccessException e) {
			return null;
		} catch (InvocationTargetException e) {
			return null;
		}
	}
}
