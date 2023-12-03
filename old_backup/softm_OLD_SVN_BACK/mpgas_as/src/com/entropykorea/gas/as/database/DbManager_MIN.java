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
import com.entropykorea.gas.as.bean.Min;
import com.entropykorea.gas.as.common.object.MLog;
import com.entropykorea.gas.as.constants.Constant;

public class DbManager_MIN {
  
  private static SQLiteDatabase mSQLiteDB;
  private String dbTable = DBTable_MIN.Columns._TABLENAME;
  private DBTable_MIN.Columns columns = new DBTable_MIN.Columns();
  
  private ArrayList<Min> totalList;
  private Min bean;
  private Handler handler;
  
  public final int TYPE_CUST = 10001;
  public final int TYPE_RESULT = 10002;
  // public final int TYPE_MIN = 10003;
  public final int TYPE_CUR = 10004;
  public final int TYPE_CARD = 10005;
  
  public DbManager_MIN() {
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
      MLog.e(dbTable + "Error writing delete : " + e.toString());
      HandlerBoolean(result);
    } finally {
      if (mSQLiteDB != null && mSQLiteDB.inTransaction()) mSQLiteDB.endTransaction();
    }
    return result;
  }
  
  // Delete Contact
  public boolean deleteFileColumn(Min min) {
    boolean result = false;
    String where = columns.REQUIRE_IDX + "=" + min.REQUIRE_IDX;
    where += " "+ columns.PHOTO_FILE_NM;
    try {
      result = mSQLiteDB.delete(dbTable, where, null) > 0;
      HandlerBoolean(result);
    } catch (SQLException e) {
      MLog.e(dbTable + "Error writing delete : " + e.toString());
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
      MLog.e(dbTable + "Error writing delete DbManager_MIN- " + e.toString());
      HandlerBoolean(result);
    } finally {
      if (mSQLiteDB != null && mSQLiteDB.inTransaction()) mSQLiteDB.endTransaction();
    }
    return result;
  }
  
  // Insert DB
  public long insertColumn(Min bean) {
    long result = 0;
    
    ContentValues values = null;
    values = getMinValues(bean);
    try {
      mSQLiteDB.beginTransaction();
      result = mSQLiteDB.insert(dbTable, null, values);
      mSQLiteDB.setTransactionSuccessful();
      HandlerLong(result);
    } catch (SQLException e) {
      MLog.e(dbTable + "Error writing insert : " + e.toString());
      e.printStackTrace();
      HandlerLong(result);
    } finally {
      if (mSQLiteDB != null && mSQLiteDB.inTransaction()) mSQLiteDB.endTransaction();
    }
    return result;
  }
  
  // Update DB
  public boolean updateColumn(int type, Min bean) {
    boolean result = false;
    
    ContentValues values = null;
    // 고객정보 (전입)
    if (type == TYPE_CUST) {
      values = getCustValues(bean);
    }
    // 민원 업데이트
    else if (type == TYPE_RESULT) {
      values = getResultValues(bean);
    }
    // 민원
    // else if (type == TYPE_MIN) {
    // values = getMinValues(bean);
    // }
    // 민원요금계산
    else if (type == TYPE_CUR) {
      values = getCurValues(bean);
    }
    // 카드결재후
    else if (type == TYPE_CARD) {
      values = getCardValues(bean);
    }
    
    try {
      mSQLiteDB.beginTransaction();
      result = mSQLiteDB.update(dbTable, values, columns.REQUIRE_IDX + "=" + bean.REQUIRE_IDX, null) > 0;
      mSQLiteDB.setTransactionSuccessful();
      HandlerBoolean(result);
    } catch (SQLException e) {
      MLog.e(dbTable + "Error writing update DbManager_MIN : " + e.toString());
      HandlerBoolean(result);
    } finally {
      if (mSQLiteDB != null && mSQLiteDB.inTransaction()) mSQLiteDB.endTransaction();
      
    }
    return result;
  }
  
  /**
   * Update DB SEND_YN = Y
   * 
   * @param bean
   * @return
   */
  public boolean updateYnColumn(String sendYn) {
    boolean result = false;
    
    ContentValues values = new ContentValues();
    values.put(columns.SEND_YN, sendYn);
    
    String where = columns.END_YN + "='Y'";
    
    try {
      mSQLiteDB.beginTransaction();
      result = mSQLiteDB.update(dbTable, values, where, null) > 0;
      HandlerBoolean(result);
      mSQLiteDB.setTransactionSuccessful();
    } catch (SQLException e) {
      MLog.e(dbTable + "Error writing updateYnColumn : " + e.toString());
      HandlerBoolean(result);
    } finally {
      if (mSQLiteDB != null && mSQLiteDB.inTransaction()) mSQLiteDB.endTransaction();
    }
    return result;
  }
  
  // min
  private ContentValues getMinValues(Min bean) {
    ContentValues values = new ContentValues();
    // values.put(columns.REQUIRE_IDX, bean.REQUIRE_IDX);
    values.put(columns.REQUIRE_CD, bean.REQUIRE_CD);
    values.put(columns.HOUSE_NO, bean.HOUSE_NO);
    values.put(columns.FAKE_HOUSE_NO, bean.FAKE_HOUSE_NO);
    values.put(columns.AREA_CD, bean.AREA_CD);
    values.put(columns.SECTOR_CD, bean.SECTOR_CD);
    values.put(columns.COMPLEX_CD, bean.COMPLEX_CD);
    values.put(columns.BLDG_CD, bean.BLDG_CD);
    values.put(columns.AREA_NM, bean.AREA_NM);
    values.put(columns.SECTOR_NM, bean.SECTOR_NM);
    values.put(columns.COMPLEX_NM, bean.COMPLEX_NM);
    values.put(columns.BLDG_NM, bean.BLDG_NM);
    values.put(columns.BLDG_NO, bean.BLDG_NO);
    values.put(columns.ROOM_NO, bean.ROOM_NO);
    values.put(columns.ROAD_NM, bean.ROAD_NM);
    values.put(columns.CUST_NM, bean.CUST_NM);
    values.put(columns.CO_NM, bean.CO_NM);
    values.put(columns.PURPOSE_CD, bean.PURPOSE_CD);
    values.put(columns.TEL_NO, bean.TEL_NO);
    values.put(columns.HOUSE_STATUS_CD, bean.HOUSE_STATUS_CD);
    values.put(columns.HOUSE_LIVING_CD, bean.HOUSE_LIVING_CD);
    values.put(columns.CUST_NO, bean.CUST_NO);
    values.put(columns.CUST_NM, bean.CUST_NM);
    values.put(columns.WORK_TEL_NO, bean.WORK_TEL_NO);
    values.put(columns.HP_NO, bean.HP_NO);
    values.put(columns.TEL_CD, bean.TEL_CD);
    values.put(columns.GM_NO, bean.GM_NO);
    values.put(columns.ACCEPT_DT, bean.ACCEPT_DT);
    values.put(columns.REQUEST_REQUIRE_DT, bean.REQUEST_REQUIRE_DT);
    values.put(columns.REQUEST_BEGIN_DT, bean.REQUEST_BEGIN_DT);
    values.put(columns.REQUEST_REMARK, bean.REQUEST_REMARK);
    values.put(columns.PUSH_REQ_YN, bean.PUSH_REQ_YN);
    values.put(columns.VIR_ACC_NO_IBK, bean.VIR_ACC_NO_IBK);
    values.put(columns.VIR_ACC_NO_NH, bean.VIR_ACC_NO_NH);
    values.put(columns.PROC_RESULT_CD, bean.PROC_RESULT_CD);
    values.put(columns.PROC_USER_CD, bean.PROC_USER_CD);
    values.put(columns.PROC_DT, bean.PROC_DT);
    values.put(columns.PROC_REMARK, bean.PROC_REMARK);
    values.put(columns.PAID_GAS_PRICE, bean.PAID_GAS_PRICE);
    values.put(columns.PAID_FEE_PRICE, bean.PAID_FEE_PRICE);
    values.put(columns.BASE_PRICE, bean.BASE_PRICE);
    values.put(columns.USE_AMOUNT, bean.USE_AMOUNT);
    values.put(columns.USE_PRICE, bean.USE_PRICE);
    values.put(columns.PENALTY_PRICE, bean.PENALTY_PRICE);
    values.put(columns.UNSEAL_PRICE, bean.UNSEAL_PRICE);
    values.put(columns.BF_METER, bean.BF_METER);
    values.put(columns.METER, bean.METER);
    values.put(columns.MV_IN_CUST_NM, bean.MV_IN_CUST_NM);
    values.put(columns.MV_IN_TEL_NO, bean.MV_IN_TEL_NO);
    values.put(columns.MV_IN_WORK_TEL_NO, bean.MV_IN_WORK_TEL_NO);
    values.put(columns.MV_IN_HP_NO, bean.MV_IN_HP_NO);
    values.put(columns.MV_IN_TEL_CD, bean.MV_IN_TEL_CD);
    values.put(columns.CARD_COMPANY, bean.CARD_COMPANY);
    values.put(columns.CARD_NUM, bean.CARD_NUM);
    values.put(columns.CARD_YM, bean.CARD_YM);
    values.put(columns.CARD_AMT, bean.CARD_AMT);
    values.put(columns.CARD_MONTHS, bean.CARD_MONTHS);
    values.put(columns.CARD_TRANS_NUM, bean.CARD_TRANS_NUM);
    values.put(columns.CARD_TRANS_DATE, bean.CARD_TRANS_DATE);
    values.put(columns.CARD_STATUS, bean.CARD_STATUS);
    values.put(columns.CARD_CANCEL_TRANS_NUM, bean.CARD_CANCEL_TRANS_NUM);
    values.put(columns.CARD_CANCEL_TRANS_DATE, bean.CARD_CANCEL_TRANS_DATE);
    values.put(columns.CASH_AMT, bean.CASH_AMT);
    values.put(columns.SEAL_CD, bean.SEAL_CD);
    values.put(columns.LAST_CALC_TIME, bean.LAST_CALC_TIME);
    values.put(columns.PAY_INFO_SMS_REQ_YN, bean.PAY_INFO_SMS_REQ_YN);
    values.put(columns.READ_SMS_RECV_YN, bean.READ_SMS_RECV_YN);
    values.put(columns.CHG_SMS_RECV_YN, bean.CHG_SMS_RECV_YN);
    values.put(columns.CHECKUP_SMS_RECV_YN, bean.CHECKUP_SMS_RECV_YN);
    values.put(columns.BILL_SMS_RECV_YN, bean.BILL_SMS_RECV_YN);
    values.put(columns.UNPAID_SMS_RECV_YN, bean.UNPAID_SMS_RECV_YN);
    values.put(columns.SIGN_FILE_NM, bean.SIGN_FILE_NM);
    values.put(columns.PHOTO_FILE_NM, bean.PHOTO_FILE_NM);
    values.put(columns.PHOTO_FILE_NM2, bean.PHOTO_FILE_NM2);
    values.put(columns.END_YN, bean.END_YN);
    values.put(columns.SEND_YN, bean.SEND_YN);
    
    return values;
  }
  
  // min_result update
  private ContentValues getResultValues(Min bean) {
    ContentValues values = new ContentValues();
    values.put(columns.PROC_RESULT_CD, bean.PROC_RESULT_CD);
    values.put(columns.PROC_USER_CD, bean.PROC_USER_CD);
    values.put(columns.PROC_DT, bean.PROC_DT);
    values.put(columns.PROC_REMARK, bean.PROC_REMARK);
    values.put(columns.PAID_GAS_PRICE, bean.PAID_GAS_PRICE);
    values.put(columns.PAID_FEE_PRICE, bean.PAID_FEE_PRICE);
    values.put(columns.BASE_PRICE, bean.BASE_PRICE);
    values.put(columns.USE_AMOUNT, bean.USE_AMOUNT);
    values.put(columns.USE_PRICE, bean.USE_PRICE);
    values.put(columns.PENALTY_PRICE, bean.PENALTY_PRICE);
    values.put(columns.UNSEAL_PRICE, bean.UNSEAL_PRICE);
    values.put(columns.BF_METER, bean.BF_METER);
    values.put(columns.METER, bean.METER);
    values.put(columns.MV_IN_CUST_NM, bean.MV_IN_CUST_NM);
    values.put(columns.MV_IN_TEL_NO, bean.MV_IN_TEL_NO);
    values.put(columns.MV_IN_WORK_TEL_NO, bean.MV_IN_WORK_TEL_NO);
    values.put(columns.MV_IN_HP_NO, bean.MV_IN_HP_NO);
    values.put(columns.MV_IN_TEL_CD, bean.MV_IN_TEL_CD);
    values.put(columns.CARD_COMPANY, bean.CARD_COMPANY);
    values.put(columns.CARD_NUM, bean.CARD_NUM);
    values.put(columns.CARD_YM, bean.CARD_YM);
    values.put(columns.CARD_AMT, bean.CARD_AMT);
    values.put(columns.CARD_MONTHS, bean.CARD_MONTHS);
    values.put(columns.CARD_TRANS_NUM, bean.CARD_TRANS_NUM);
    values.put(columns.CARD_TRANS_DATE, bean.CARD_TRANS_DATE);
    values.put(columns.CASH_AMT, bean.CASH_AMT);
    values.put(columns.SEAL_CD, bean.SEAL_CD);
    values.put(columns.LAST_CALC_TIME, bean.LAST_CALC_TIME);
    values.put(columns.PAY_INFO_SMS_REQ_YN, bean.PAY_INFO_SMS_REQ_YN);
    values.put(columns.READ_SMS_RECV_YN, bean.READ_SMS_RECV_YN);
    values.put(columns.CHG_SMS_RECV_YN, bean.CHG_SMS_RECV_YN);
    values.put(columns.CHECKUP_SMS_RECV_YN, bean.CHECKUP_SMS_RECV_YN);
    values.put(columns.BILL_SMS_RECV_YN, bean.BILL_SMS_RECV_YN);
    values.put(columns.UNPAID_SMS_RECV_YN, bean.UNPAID_SMS_RECV_YN);
    values.put(columns.SIGN_FILE_NM, bean.SIGN_FILE_NM);
    values.put(columns.PHOTO_FILE_NM, bean.PHOTO_FILE_NM);
    values.put(columns.PHOTO_FILE_NM2, bean.PHOTO_FILE_NM2);
    values.put(columns.END_YN, bean.END_YN);
    return values;
  }
  
  // cust update
  private ContentValues getCustValues(Min bean) {
    ContentValues values = new ContentValues();
    values.put(columns.CUST_NM, bean.CUST_NM);
    values.put(columns.TEL_NO, bean.TEL_NO);
    values.put(columns.WORK_TEL_NO, bean.WORK_TEL_NO);
    values.put(columns.HP_NO, bean.HP_NO);
    values.put(columns.TEL_CD, bean.TEL_CD);
    
    values.put(columns.MV_IN_CUST_NM, bean.MV_IN_CUST_NM);
    values.put(columns.MV_IN_TEL_NO, bean.MV_IN_TEL_NO);
    values.put(columns.MV_IN_WORK_TEL_NO, bean.MV_IN_WORK_TEL_NO);
    values.put(columns.MV_IN_HP_NO, bean.MV_IN_HP_NO);
    values.put(columns.MV_IN_TEL_CD, bean.MV_IN_TEL_CD);
    
    return values;
  }
  
  // cur_price update
  private ContentValues getCurValues(Min bean) {
    
    ContentValues values = new ContentValues();
    values.put(columns.LAST_CALC_TIME, bean.LAST_CALC_TIME);
    values.put(columns.METER, bean.METER);
    
    values.put(columns.BF_METER, bean.BF_METER);
    values.put(columns.USE_AMOUNT, bean.USE_AMOUNT);
    values.put(columns.USE_PRICE, bean.USE_PRICE);
    values.put(columns.BASE_PRICE, bean.BASE_PRICE);
    
    return values;
  }
  
  // card update
  private ContentValues getCardValues(Min bean) {
    ContentValues values = new ContentValues();
    values.put(columns.CARD_COMPANY, bean.CARD_COMPANY);
    values.put(columns.CARD_NUM, bean.CARD_NUM);
    values.put(columns.CARD_YM, bean.CARD_YM);
    values.put(columns.CARD_AMT, bean.CARD_AMT);
    values.put(columns.CARD_MONTHS, bean.CARD_MONTHS);
    values.put(columns.CARD_TRANS_NUM, bean.CARD_TRANS_NUM);
    values.put(columns.CARD_TRANS_DATE, bean.CARD_TRANS_DATE);
    values.put(columns.CARD_STATUS, bean.CARD_STATUS);
    values.put(columns.CARD_CANCEL_TRANS_NUM, bean.CARD_CANCEL_TRANS_NUM);
    values.put(columns.CARD_CANCEL_TRANS_DATE, bean.CARD_CANCEL_TRANS_DATE);
    values.put(columns.SIGN_FILE_NM, bean.SIGN_FILE_NM);
    
    return values;
  }
  
  // count
  public long getCursorCount() {
    long count = 0;
    try {
      count = DatabaseUtils.queryNumEntries(mSQLiteDB, dbTable);
    } catch (SQLException e) {
      MLog.e(dbTable + "Error writing coutn : " + e.toString());
    }
    return count;
  }
  
  /**
   * 데이터 리스트
   **/
  public ArrayList<Min> getTotalList(Cursor cursor) {
    if (cursor == null) return null;
    // Cursor cursor = getAllColumns();
    totalList = null;
    totalList = new ArrayList<Min>();
    try {
      while (cursor.moveToNext()) {
        bean = new Min();
        bean.REQUIRE_IDX = cursor.getInt(cursor.getColumnIndex(columns.REQUIRE_IDX));
        bean.REQUIRE_CD = cursor.getString(cursor.getColumnIndex(columns.REQUIRE_CD));
        bean.HOUSE_NO = cursor.getString(cursor.getColumnIndex(columns.HOUSE_NO));
        bean.FAKE_HOUSE_NO = cursor.getString(cursor.getColumnIndex(columns.FAKE_HOUSE_NO));
        bean.AREA_CD = cursor.getString(cursor.getColumnIndex(columns.AREA_CD));
        bean.SECTOR_CD = cursor.getString(cursor.getColumnIndex(columns.SECTOR_CD));
        bean.COMPLEX_CD = cursor.getString(cursor.getColumnIndex(columns.COMPLEX_CD));
        bean.BLDG_CD = cursor.getString(cursor.getColumnIndex(columns.BLDG_CD));
        bean.AREA_NM = cursor.getString(cursor.getColumnIndex(columns.AREA_NM));
        bean.SECTOR_NM = cursor.getString(cursor.getColumnIndex(columns.SECTOR_NM));
        bean.COMPLEX_NM = cursor.getString(cursor.getColumnIndex(columns.COMPLEX_NM));
        bean.BLDG_NM = cursor.getString(cursor.getColumnIndex(columns.BLDG_NM));
        bean.BLDG_NO = cursor.getString(cursor.getColumnIndex(columns.BLDG_NO));
        bean.ROOM_NO = cursor.getString(cursor.getColumnIndex(columns.ROOM_NO));
        bean.ROAD_NM = cursor.getString(cursor.getColumnIndex(columns.ROAD_NM));
        bean.CUST_NM = cursor.getString(cursor.getColumnIndex(columns.CUST_NM));
        bean.CO_NM = cursor.getString(cursor.getColumnIndex(columns.CO_NM));
        bean.PURPOSE_CD = cursor.getString(cursor.getColumnIndex(columns.PURPOSE_CD));
        bean.HOUSE_STATUS_CD = cursor.getString(cursor.getColumnIndex(columns.HOUSE_STATUS_CD));
        bean.HOUSE_LIVING_CD = cursor.getString(cursor.getColumnIndex(columns.HOUSE_LIVING_CD));
        bean.CUST_NO = cursor.getString(cursor.getColumnIndex(columns.CUST_NO));
        bean.CUST_NM = cursor.getString(cursor.getColumnIndex(columns.CUST_NM));
        bean.TEL_NO = cursor.getString(cursor.getColumnIndex(columns.TEL_NO));
        bean.WORK_TEL_NO = cursor.getString(cursor.getColumnIndex(columns.WORK_TEL_NO));
        bean.HP_NO = cursor.getString(cursor.getColumnIndex(columns.HP_NO));
        bean.TEL_CD = cursor.getString(cursor.getColumnIndex(columns.TEL_CD));
        bean.GM_NO = cursor.getString(cursor.getColumnIndex(columns.GM_NO));
        bean.ACCEPT_DT = cursor.getString(cursor.getColumnIndex(columns.ACCEPT_DT));
        bean.REQUEST_REQUIRE_DT = cursor.getString(cursor.getColumnIndex(columns.REQUEST_REQUIRE_DT));
        bean.REQUEST_BEGIN_DT = cursor.getString(cursor.getColumnIndex(columns.REQUEST_BEGIN_DT));
        bean.REQUEST_REMARK = cursor.getString(cursor.getColumnIndex(columns.REQUEST_REMARK));
        bean.PUSH_REQ_YN = cursor.getString(cursor.getColumnIndex(columns.PUSH_REQ_YN));
        bean.VIR_ACC_NO_IBK = cursor.getString(cursor.getColumnIndex(columns.VIR_ACC_NO_IBK));
        bean.VIR_ACC_NO_NH = cursor.getString(cursor.getColumnIndex(columns.VIR_ACC_NO_NH));
        bean.PROC_RESULT_CD = cursor.getString(cursor.getColumnIndex(columns.PROC_RESULT_CD));
        bean.PROC_USER_CD = cursor.getString(cursor.getColumnIndex(columns.PROC_USER_CD));
        bean.PROC_DT = cursor.getString(cursor.getColumnIndex(columns.PROC_DT));
        bean.PROC_REMARK = cursor.getString(cursor.getColumnIndex(columns.PROC_REMARK));
        bean.PAID_GAS_PRICE = cursor.getString(cursor.getColumnIndex(columns.PAID_GAS_PRICE));
        bean.PAID_FEE_PRICE = cursor.getString(cursor.getColumnIndex(columns.PAID_FEE_PRICE));
        bean.BASE_PRICE = cursor.getString(cursor.getColumnIndex(columns.BASE_PRICE));
        bean.USE_AMOUNT = cursor.getString(cursor.getColumnIndex(columns.USE_AMOUNT));
        bean.USE_PRICE = cursor.getString(cursor.getColumnIndex(columns.USE_PRICE));
        bean.BF_METER = cursor.getString(cursor.getColumnIndex(columns.BF_METER));
        bean.METER = cursor.getString(cursor.getColumnIndex(columns.METER));
        bean.MV_IN_CUST_NM = cursor.getString(cursor.getColumnIndex(columns.MV_IN_CUST_NM));
        bean.MV_IN_TEL_NO = cursor.getString(cursor.getColumnIndex(columns.MV_IN_TEL_NO));
        bean.MV_IN_WORK_TEL_NO = cursor.getString(cursor.getColumnIndex(columns.MV_IN_WORK_TEL_NO));
        bean.MV_IN_HP_NO = cursor.getString(cursor.getColumnIndex(columns.MV_IN_HP_NO));
        bean.MV_IN_TEL_CD = cursor.getString(cursor.getColumnIndex(columns.MV_IN_TEL_CD));
        bean.CARD_COMPANY = cursor.getString(cursor.getColumnIndex(columns.CARD_COMPANY));
        bean.CARD_NUM = cursor.getString(cursor.getColumnIndex(columns.CARD_NUM));
        bean.CARD_YM = cursor.getString(cursor.getColumnIndex(columns.CARD_YM));
        bean.CARD_AMT = cursor.getString(cursor.getColumnIndex(columns.CARD_AMT));
        bean.CARD_MONTHS = cursor.getString(cursor.getColumnIndex(columns.CARD_MONTHS));
        bean.CARD_TRANS_NUM = cursor.getString(cursor.getColumnIndex(columns.CARD_TRANS_NUM));
        bean.CARD_TRANS_DATE = cursor.getString(cursor.getColumnIndex(columns.CARD_TRANS_DATE));
        bean.CARD_STATUS = cursor.getString(cursor.getColumnIndex(columns.CARD_STATUS));
        bean.CARD_CANCEL_TRANS_NUM = cursor.getString(cursor.getColumnIndex(columns.CARD_CANCEL_TRANS_NUM));
        bean.CARD_CANCEL_TRANS_DATE = cursor.getString(cursor.getColumnIndex(columns.CARD_CANCEL_TRANS_DATE));
        bean.CASH_AMT = cursor.getString(cursor.getColumnIndex(columns.CASH_AMT));
        bean.SEAL_CD = cursor.getString(cursor.getColumnIndex(columns.SEAL_CD));
        bean.LAST_CALC_TIME = cursor.getString(cursor.getColumnIndex(columns.LAST_CALC_TIME));
        bean.PAY_INFO_SMS_REQ_YN = cursor.getString(cursor.getColumnIndex(columns.PAY_INFO_SMS_REQ_YN));
        bean.READ_SMS_RECV_YN = cursor.getString(cursor.getColumnIndex(columns.READ_SMS_RECV_YN));
        bean.CHG_SMS_RECV_YN = cursor.getString(cursor.getColumnIndex(columns.CHG_SMS_RECV_YN));
        bean.CHECKUP_SMS_RECV_YN = cursor.getString(cursor.getColumnIndex(columns.CHECKUP_SMS_RECV_YN));
        bean.BILL_SMS_RECV_YN = cursor.getString(cursor.getColumnIndex(columns.BILL_SMS_RECV_YN));
        bean.UNPAID_SMS_RECV_YN = cursor.getString(cursor.getColumnIndex(columns.UNPAID_SMS_RECV_YN));
        bean.SIGN_FILE_NM = cursor.getString(cursor.getColumnIndex(columns.SIGN_FILE_NM));
        bean.PHOTO_FILE_NM = cursor.getString(cursor.getColumnIndex(columns.PHOTO_FILE_NM));
        bean.PHOTO_FILE_NM2 = cursor.getString(cursor.getColumnIndex(columns.PHOTO_FILE_NM2));
        bean.END_YN = cursor.getString(cursor.getColumnIndex(columns.END_YN));
        bean.SEND_YN = cursor.getString(cursor.getColumnIndex(columns.SEND_YN));
        totalList.add(bean);
      }
    } catch (SQLException e) {
      MLog.e(dbTable + "Error writing select : " + e.toString());
    } finally {
      if (cursor != null) cursor.close();
    }
    return totalList;
  }
  
  // Select All
  public Cursor getAllColumns() {
    String orderBy = "REQUEST_REQUIRE_DT,REQUEST_BEGIN_DT";
    return mSQLiteDB.query(dbTable, null, null, null, null, null, orderBy);
  }
  
  // REQUIRE_IDX를 통해 컬럼 얻어 오기
  public Cursor getReqIdColumn(String key) {
    Cursor c = mSQLiteDB.query(dbTable, null, columns.REQUIRE_IDX + "= " + key, null, null, null, null);
    return c;
  }
  
  // GM_NO를 통해 컬럼 얻어 오기
  public Cursor geGmNoColumn(String key) {
    Cursor c = mSQLiteDB.query(dbTable, null, columns.GM_NO + "=" + key, null, null, null, null);
    return c;
  }
  
  // 건물로 검색 하기 (rawQuery)
  public Cursor getSearchColum(String name, String endYn) {
    // Cursor c = mSQLiteDB.rawQuery("select * from " + dbTable + " where BLDG_NM LIKE " + "'%" + name + "%'", null);
    
    String where = "(" + columns.BLDG_NO + " LIKE '%" + name + "%'";
    where += " OR " + columns.SECTOR_NM + " LIKE '%" + name + "%'";
    where += " OR " + columns.COMPLEX_NM + " LIKE '%" + name + "%'";
    where += " OR " + columns.BLDG_NM + " LIKE '%" + name + "%'";
    where += " OR " + columns.ROOM_NO + " LIKE '%" + name + "%'";
    where += " OR " + columns.CO_NM + " LIKE '%" + name + "%')";
    if (!"C".equals(endYn)) where += " AND " + columns.END_YN + "=" + ("Y".equals(endYn) ? "'Y'" : "'N'");
    
    MLog.e("sql : " + where);
    Cursor c = mSQLiteDB.query(dbTable, null, where, null, null, null, null);
    return c;
  }
  
  public Cursor getEndColum() {
    // Cursor c = mSQLiteDB.rawQuery("select * from " + dbTable + " where BLDG_NM LIKE " + "'%" + name + "%'", null);
    
    String where = "END_YN = 'Y' AND SEND_YN='N'";
    
    MLog.e("sql : " + where);
    Cursor c = mSQLiteDB.query(dbTable, null, where, null, null, null, null);
    return c;
  }
}
