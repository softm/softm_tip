package com.entropykorea.gas.as.database;

import java.util.ArrayList;

import android.content.ContentValues;
import android.database.Cursor;
import android.database.DatabaseUtils;
import android.database.SQLException;
import android.database.sqlite.SQLiteDatabase;
import android.os.Handler;
import android.os.Message;

import com.entropykorea.gas.as.AppContext;
import com.entropykorea.gas.as.bean.MinCust;
import com.entropykorea.gas.as.common.object.MLog;
import com.entropykorea.gas.as.constants.Constant;

public class DbManager_MIN_CUST {
  
  private static SQLiteDatabase mSQLiteDB;
  private String dbTable = DBTable_MIN_CUST.Columns._TABLENAME;
  private DBTable_MIN_CUST.Columns columns = new DBTable_MIN_CUST.Columns();
  
  private ArrayList<MinCust> totalList;
  private MinCust bean;
  private Handler handler;
  
  public DbManager_MIN_CUST() {
    mSQLiteDB = AppContext.getSQLiteDatabase();
  }
  
  public void DbHandler(Handler handler) {
    this.handler = handler;
  }
  
  private void HandlerBoolean(boolean result) {
    if (handler == null) return;
    if (result) {
      handler.sendEmptyMessage(Constant.RESULT_SUCCESS);
    } else {
      handler.sendEmptyMessage(Constant.RESULT_FAIL);
    }
  }
  
  private void HandlerLong(Long result) {
    if (handler == null) return;
    if (result == -1) {
      handler.sendMessage(Message.obtain(handler, Constant.RESULT_FAIL, result));
    } else {
      handler.sendMessage(Message.obtain(handler, Constant.RESULT_SUCCESS, result));
    }
  }
  
  public synchronized void close() {
    if (mSQLiteDB != null) mSQLiteDB.close();
  }
  
  // Delete Contact
  public boolean deleteColumn(int key) {
    boolean result = false;
    try {
      result = mSQLiteDB.delete(dbTable, columns.REQUIRE_IDX + "=" + key, null) > 0;
      HandlerBoolean(result);
    } catch (SQLException e) {
      MLog.e("Error writing delete - " + dbTable + e.toString());
      HandlerBoolean(result);
    } finally {
      if (mSQLiteDB != null && mSQLiteDB.inTransaction()) mSQLiteDB.endTransaction();
    }
    return result;
  }
  
  // Delete All
  public boolean deleteAllColumn() {
    boolean result = false;
    try {
      if (getCursorCount() > 0) result = mSQLiteDB.delete(dbTable, null, null) > 0;
      HandlerBoolean(result);
    } catch (SQLException e) {
      MLog.e("Error writing delete - " + dbTable + e.toString());
      HandlerBoolean(result);
    } finally {
      if (mSQLiteDB != null && mSQLiteDB.inTransaction()) mSQLiteDB.endTransaction();
    }
    return result;
  }
  
  // Insert DB
  public long insertColumn(MinCust bean) {
    long insert = 0;
    
    ContentValues values = null;
    values = getValues(bean);
    try {
      mSQLiteDB.beginTransaction();
      insert = mSQLiteDB.insert(dbTable, null, values);
      mSQLiteDB.setTransactionSuccessful();
      HandlerLong(insert);
    } catch (SQLException e) {
      MLog.e("Error writing insert - " + dbTable + e.toString());
      e.printStackTrace();
      HandlerLong(insert);
    } finally {
      if (mSQLiteDB != null && mSQLiteDB.inTransaction()) mSQLiteDB.endTransaction();
    }
    return insert;
  }
  
  // Update DB
  public boolean updateColumn(int alramId, MinCust bean) {
    boolean result = false;
    
    ContentValues values = null;
    values = getValues(bean);
    
    try {
      mSQLiteDB.beginTransaction();
      result = mSQLiteDB.update(dbTable, values, columns.REQUIRE_IDX + "=" + alramId, null) > 0;
      mSQLiteDB.setTransactionSuccessful();
      HandlerBoolean(result);
    } catch (SQLException e) {
      MLog.e("Error writing update - " + dbTable + e.toString());
      HandlerBoolean(result);
    } finally {
      if (mSQLiteDB != null && mSQLiteDB.inTransaction()) mSQLiteDB.endTransaction();
    }
    return result;
  }
  
  private ContentValues getValues(MinCust bean) {
    ContentValues values = new ContentValues();
    values.put(columns.REQUIRE_IDX, bean.REQUIRE_IDX);
    values.put(columns.HOUSE_NO, bean.HOUSE_NO);
    values.put(columns.FAKE_HOUSE_NO, bean.FAKE_HOUSE_NO);
    values.put(columns.CUST_NO, bean.CUST_NO);
    values.put(columns.CUST_NM, bean.CUST_NM);
    values.put(columns.TEL_NO, bean.TEL_NO);
    values.put(columns.WORK_TEL_NO, bean.WORK_TEL_NO);
    values.put(columns.HP_NO, bean.HP_NO);
    values.put(columns.TEL_CD, bean.TEL_CD);
    
    return values;
  }
  
  /**
   * 데이터 리스트
   **/
  public ArrayList<MinCust> getTotalList() {
    
    Cursor cursor = getAllColumns();
    totalList = new ArrayList<MinCust>();
    try {
      while (cursor.moveToNext()) {
        bean = new MinCust();
        bean.REQUIRE_IDX = cursor.getInt(cursor.getColumnIndex(columns.REQUIRE_IDX));
        bean.HOUSE_NO = cursor.getString(cursor.getColumnIndex(columns.HOUSE_NO));
        bean.FAKE_HOUSE_NO = cursor.getString(cursor.getColumnIndex(columns.FAKE_HOUSE_NO));
        bean.CUST_NO = cursor.getString(cursor.getColumnIndex(columns.CUST_NO));
        bean.CUST_NM = cursor.getString(cursor.getColumnIndex(columns.CUST_NM));
        bean.TEL_NO = cursor.getString(cursor.getColumnIndex(columns.TEL_NO));
        bean.WORK_TEL_NO = cursor.getString(cursor.getColumnIndex(columns.WORK_TEL_NO));
        bean.HP_NO = cursor.getString(cursor.getColumnIndex(columns.HP_NO));
        bean.TEL_CD = cursor.getString(cursor.getColumnIndex(columns.TEL_CD));
        totalList.add(bean);
      }
    } catch (SQLException e) {
      MLog.e("Error writing select - " + dbTable + e.toString());
    } finally {
      if (cursor != null) cursor.close();
    }
    return totalList;
  }
  
  // count
  public long getCursorCount() {
    long count = DatabaseUtils.queryNumEntries(mSQLiteDB, dbTable);
    return count;
  }
  
  // Select All
  public Cursor getAllColumns() {
    // String orderBy = columns.Min_TIME_STAMP + " DESC";
    String orderBy = columns.REQUIRE_IDX + " DESC";
    return mSQLiteDB.query(dbTable, null, null, null, null, null, orderBy);
  }
  
  // REQUIRE_IDX를 통해 컬럼 얻어 오기
  public Cursor getColumn(long key) {
    Cursor c = mSQLiteDB.query(dbTable, null, columns.REQUIRE_IDX + "=" + key, null, null, null, null);
    if (c != null && c.getCount() != 0) c.moveToFirst();
    return c;
  }
  
  // 이름 검색 하기 (rawQuery)
  public Cursor getMatchName(String name) {
    Cursor c = mSQLiteDB.rawQuery("select * from " + dbTable + " where CUST_NM =" + "'" + name + "'", null);
    return c;
  }
  
}
