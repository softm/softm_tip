package com.entropykorea.gas.as.database;

import java.util.ArrayList;

import android.content.ContentValues;
import android.database.Cursor;
import android.database.DatabaseUtils;
import android.database.SQLException;
import android.database.sqlite.SQLiteDatabase;
import android.os.Handler;

import com.entropykorea.gas.as.AppContext;
import com.entropykorea.gas.as.bean.MinCurPrice;
import com.entropykorea.gas.as.common.object.MLog;
import com.entropykorea.gas.as.constants.Constant;

public class DbManager_MIN_CUR_PRICE {
  
  private static SQLiteDatabase mSQLiteDB;
  private String dbTable = DBTable_MIN_CUR_PRICE.Columns._TABLENAME;
  private DBTable_MIN_CUR_PRICE.Columns columns = new DBTable_MIN_CUR_PRICE.Columns();
  
  private ArrayList<MinCurPrice> totalList;
  private MinCurPrice bean;
  private Handler handler;
  
  public DbManager_MIN_CUR_PRICE() {
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
  
  public synchronized void close() {
    // if (mDB != null) mDB.close();
  }
  
  // Delete Contact
  public boolean deleteColumn(int key) {
    boolean result = false;
    try {
      result = mSQLiteDB.delete(dbTable, columns.REQUIRE_IDX + "=" + key, null) > 0;
      HandlerBoolean(result);
    } catch (SQLException e) {
      MLog.e(dbTable + "Error writing delete - " + dbTable + e.toString());
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
      MLog.e(dbTable + "Error writing delete - " + dbTable + e.toString());
      HandlerBoolean(result);
    } finally {
      if (mSQLiteDB != null && mSQLiteDB.inTransaction()) mSQLiteDB.endTransaction();
    }
    return result;
  }
  
  // Insert DB
  public long insertColumn(MinCurPrice bean) {
    long insert = 0;
    boolean result = false;
    
    ContentValues values = null;
    values = getValues(bean);
    try {
      mSQLiteDB.beginTransaction();
      insert = mSQLiteDB.insert(dbTable, null, values);
      mSQLiteDB.setTransactionSuccessful();
      HandlerBoolean(result);
    } catch (SQLException e) {
      MLog.e(dbTable + "Error writing insert : " + e.toString());
      e.printStackTrace();
      HandlerBoolean(result);
    } finally {
      if (mSQLiteDB != null && mSQLiteDB.inTransaction()) mSQLiteDB.endTransaction();
    }
    return insert;
  }
  
  // Insert DB
  public void insert(String sql) {
    mSQLiteDB.rawQuery(sql, null);
  }
  
  // Update DB
  public boolean updateColumn(MinCurPrice bean) {
    boolean result = false;
    
    ContentValues values = null;
    values = getValues(bean);
    
    try {
      mSQLiteDB.beginTransaction();
      result = mSQLiteDB.update(dbTable, values, columns.REQUIRE_IDX + "=" + bean.REQUIRE_IDX, null) > 0;
      mSQLiteDB.setTransactionSuccessful();
      HandlerBoolean(result);
    } catch (SQLException e) {
      MLog.e(dbTable + "Error writing update - " + dbTable + e.toString());
      HandlerBoolean(result);
    } finally {
      if (mSQLiteDB != null && mSQLiteDB.inTransaction()) mSQLiteDB.endTransaction();
    }
    return result;
  }
  
  private ContentValues getValues(MinCurPrice bean) {
    ContentValues values = new ContentValues();
    values.put(columns.REQUIRE_IDX, bean.REQUIRE_IDX);
    values.put(columns.BF_METER, bean.BF_METER);
    values.put(columns.USE_AMOUNT, bean.USE_AMOUNT);
    values.put(columns.USE_PRICE, bean.USE_PRICE);
    values.put(columns.BASE_PRICE, bean.BASE_PRICE);
    
    return values;
  }
  
  /**
   * 데이터 리스트
   **/
  public ArrayList<MinCurPrice> getTotalList(Cursor cursor) {
    if (cursor == null) return null;
    totalList = null;
    totalList = new ArrayList<MinCurPrice>();
    try {
      while (cursor.moveToNext()) {
        bean = new MinCurPrice();
        bean.REQUIRE_IDX = cursor.getString(cursor.getColumnIndex(columns.REQUIRE_IDX));
        bean.BF_METER = cursor.getString(cursor.getColumnIndex(columns.BF_METER));
        bean.USE_AMOUNT = cursor.getString(cursor.getColumnIndex(columns.USE_AMOUNT));
        bean.USE_PRICE = cursor.getString(cursor.getColumnIndex(columns.USE_PRICE));
        bean.BASE_PRICE = cursor.getString(cursor.getColumnIndex(columns.BASE_PRICE));
        totalList.add(bean);
      }
    } catch (SQLException e) {
      MLog.e(dbTable + "Error writing select - " + dbTable + e.toString());
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
    String orderBy = null;
    return mSQLiteDB.query(dbTable, null, null, null, null, null, orderBy);
  }
  
  // REQUIRE_IDX를 통해 컬럼 얻어 오기
  public Cursor getColumn(int key) {
    String where = columns.REQUIRE_IDX + " = " + key;
    Cursor c = null;
    MLog.e("sql : " + where);
    try {
      c = mSQLiteDB.query(dbTable, null, where, null, null, null, null);
    } catch (Exception e) {
      MLog.e(e.toString());
    }
    return c;
  }
  
}
