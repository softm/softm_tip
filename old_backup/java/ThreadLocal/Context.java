package test.threadlocal;

import java.util.Date;

public class Context {
    public static ThreadLocal<Date> local = new ThreadLocal<Date>();
    public static ThreadLocal<Integer> localI = new ThreadLocal<Integer>();
}