package kr.co.gscaltex.gsnpoint.dao;

import java.util.ArrayList;

import kr.co.gscaltex.gsnpoint.R;
import kr.co.gscaltex.gsnpoint.util.Util;
import android.content.Context;
import android.database.Cursor;
import android.database.SQLException;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;

public class DatabaseAdapter {
	private StringBuffer query = new StringBuffer();
	
	private static final String DATABASE_NAME = "npoint.db";
	private static final int DATABASE_VERSION = 1;
	
	private static final String ADDRESS_TABLE = "address";
	private static final String ADDRESS_SELECT_BY_CITY = "SELECT distinct gu FROM "+ADDRESS_TABLE+" WHERE si = ?";
	private static final String ADDRESS_SELECT_BY_TOWN = "SELECT distinct dong FROM "+ADDRESS_TABLE+" WHERE gu = ?";
	private static final String STORE_TABLE="storeinfo";//test
	
	private Context mContext;
	private DatabaseHelper mDatabaseHelper;
	private SQLiteDatabase mDatabase;
	
	public static final String DATABASE_DIR = "/data/data/kr.co.gscaltex.gsnpoint/databases/npoint.db";
	
	public DatabaseAdapter(Context context) {
		mContext = context;
		
		query = new StringBuffer();
//		query.append("SELECT FRCH_CD ,FRCH_DTL_CD ,BUSI_CD ,FRCH_NM ,TPHN_NO ,CCO_CD  ,ZIP_ADDR  ,DTL_ADDR ,OPEN_YN ,IFNULL(LAT,'') ,IFNULL(LONGI,'')\n");
//	    query.append("FROM "+STORE_TABLE+"\n");
//		query.append("SELECT * FROM (SELECT IFNULL(FRCH_CD,'')AS FRCH_CD, IFNULL(FRCH_DTL_CD,'')AS FRCH_DTL_CD ,IFNULL(BUSI_CD,'')AS BUSI_CD ,IFNULL(FRCH_NM,'')AS FRCH_NM ,IFNULL(TPHN_NO,'')AS TPHN_NO ,IFNULL(CCO_CD,'')AS CCO_CD  ,IFNULL(ZIP_ADDR,'')AS ZIP_ADDR  ,IFNULL(DTL_ADDR,'')AS DTL_ADDR  ,IFNULL(OPEN_YN,'')AS OPEN_YN ,IFNULL(LAT,'0')AS LAT ,IFNULL(LONGI,'0')AS LONGI FROM STOREINFO WHERE OPEN_YN='1') ");
		query.append("SELECT IFNULL(FRCH_CD,'')AS FRCH_CD, IFNULL(FRCH_DTL_CD,'')AS FRCH_DTL_CD, IFNULL(BUSI_CD,'')AS BUSI_CD, IFNULL(FRCH_NM,'')AS FRCH_NM, IFNULL(TPHN_NO,'')AS TPHN_NO, IFNULL(CCO_CD,'')AS CCO_CD , IFNULL(ZIP_ADDR,'')AS ZIP_ADDR , IFNULL(DTL_ADDR,'')AS DTL_ADDR , IFNULL(OPEN_YN,'')AS OPEN_YN, IFNULL(LAT,'0')AS LAT, IFNULL(LONGI,'0')AS LONGI, IFNULL(BUSI_CD_ORD,'')AS BUSI_CD_ORD\n");
		query.append("FROM STOREINFO\n");
	}
	
	public DatabaseAdapter open() throws SQLException {
		mDatabaseHelper = new DatabaseHelper(mContext);
		mDatabase = mDatabaseHelper.getReadableDatabase();
		
		return this;
	}

	public void close(){
		mDatabaseHelper.close();
		mDatabase.close();
	}
	
	public ArrayList<StoreInfoModel> selectStoreInfoWhereIam(Context context, String minLat, String minLng, String maxLat, String maxLng, String busi_cd) {
		ArrayList<StoreInfoModel> list = new ArrayList<StoreInfoModel>();
		StoreInfoModel info = new StoreInfoModel();
		try {
			
			StringBuffer sql = new StringBuffer();
			sql.append("WHERE LAT BETWEEN '"+minLat+"' AND '"+maxLat+"'\n");
			sql.append("AND LONGI BETWEEN '"+minLng+"' AND '"+maxLng+"'\n");
			sql.append("AND OPEN_YN = '1'\n");
		
			if(!(busi_cd.equals(Util.BUSI_CD_ALL)))
				sql.append("AND BUSI_CD = '"+busi_cd+"'");

			Cursor results = mDatabase.rawQuery(query.toString()+sql.toString(), null);
			
			if (results.moveToFirst()) {
				for (; !results.isAfterLast(); results.moveToNext()) {
					info = new StoreInfoModel();
					
					info.setFrch_cd(results.getString(0));
					info.setFrch_dtl_cd(results.getString(1));
					info.setBusi_cd(results.getString(2));
					info.setFrch_nm(results.getString(3));
					info.setTphn_no(results.getString(4));
					info.setCco_cd(results.getString(5));
					info.setZip_addr(results.getString(6));
					info.setDtl_addr(results.getString(7));
					info.setOpen_yn(results.getString(8));
					info.setLat(results.getString(9));
					info.setLongi(results.getString(10));
					info.setBusiCdOrd(results.getString(11));
					list.add(info);
				}
			}
			
			/*lhr add*/
			if( results != null ){
				results.close();
				//mDatabase.close();
			}
			/*lhr end*/
			
		}catch (Exception e) {
			
		}
		return list;
	}
		
	public ArrayList<String> selectAddressByCity(Context context, String city) {
		ArrayList<String> list = new ArrayList<String>();
		try {			
			String[] arg = {city};
			Cursor results = mDatabase.rawQuery(ADDRESS_SELECT_BY_CITY, arg);
			if (results.moveToFirst()) {
				list.add(context.getString(R.string.addr_gugun));
				for (; !results.isAfterLast(); results.moveToNext()) {				
					list.add(results.getString(0));
				}
			}
			
			if( results != null ){
				results.close();
				//mDatabase.close();
			}
			
		}catch (Exception e) {
		}
		return list;
	}
	
	
	public ArrayList<String> selectAddressByTown(Context context, String town) {
		ArrayList<String> list = new ArrayList<String>();
		try {
			
			String[] arg = {town};
			Cursor results = mDatabase.rawQuery(ADDRESS_SELECT_BY_TOWN, arg);
			if (results.moveToFirst()) {
				list.add(context.getString(R.string.addr_dong));
				for (; !results.isAfterLast(); results.moveToNext()) {
					list.add(results.getString(0));
				}
			}
			
			/*lhr add*/
			if( results != null ){
				results.close();
				//mDatabase.close();
			}
			/*lhr end*/
			
		}catch (Exception e) {
			
		}
		return list;
	}	 
	
	public boolean updateStore(ArrayList<StoreInfoModel> models){
		if( models == null )
			return false;
		final String column_names = "FRCH_CD,FRCH_DTL_CD,BUSI_CD,FRCH_NM,TPHN_NO,CCO_CD,ZIP_ADDR,DTL_ADDR,OPEN_YN,LAT,LONGI,BUSI_CD_ORD";
		String strQuery = "";
		StringBuilder values = null;
		String open_yn;
		try{
			mDatabase.beginTransaction();
			for (StoreInfoModel model : models) {
				open_yn = model.getOpen_yn();
				if( open_yn == null )
					continue;
				
				if( open_yn.equals("01") || open_yn.equals("1") ){//update or insert
					values = new StringBuilder();
					
					values.append(String.format("'%s'", model.getFrch_cd()));values.append(",");
					values.append(String.format("'%s'", model.getFrch_dtl_cd()));values.append(",");
					values.append(String.format("'%s'", model.getBusi_cd()));values.append(",");
					values.append(String.format("'%s'", model.getFrch_nm()));values.append(",");
					values.append(String.format("'%s'", model.getTphn_no()));values.append(",");
					values.append(String.format("'%s'", model.getCco_cd()));values.append(",");
					values.append(String.format("'%s'", model.getZip_addr()));values.append(",");
					values.append(String.format("'%s'", model.getDtl_addr()));values.append(",");
					values.append(String.format("'%s'", model.getOpen_yn()));values.append(",");
					values.append(String.format("'%s'", model.getLat()));values.append(",");
					values.append(String.format("'%s'", model.getLongi()));values.append(",");
					values.append(String.format("'%s'", model.getBusiCdOrd()));
					strQuery = String.format("INSERT OR REPLACE INTO %s(%s) VALUES(%s);", STORE_TABLE, column_names, values.toString());
					
				}else{//delete
					strQuery = String.format("DELETE FROM %s WHERE FRCH_CD='%s' AND CCO_CD='%s';", STORE_TABLE,
							model.getFrch_cd(), model.getCco_cd());
					
				}
				mDatabase.execSQL(strQuery);
			}
			mDatabase.setTransactionSuccessful();
		}catch(Exception ex){
			return false;
		}finally{
			mDatabase.endTransaction();
		}
		
		return true;
	}
	
	private class DatabaseHelper extends SQLiteOpenHelper {
		public DatabaseHelper(Context context) {
			super(context, DATABASE_NAME, null, DATABASE_VERSION);
		}

		@Override
		public void onCreate(SQLiteDatabase db) {			
		}

		@Override
		public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {		
		}
	}

	public ArrayList<StoreInfoModel> selectStoreInfo(Context context, String[] args) {
		ArrayList<StoreInfoModel> list = new ArrayList<StoreInfoModel>();
		StoreInfoModel info = new StoreInfoModel();
		try {
			String temp = "";
			String queryString = "";
			int count = 0;

			if (args[0].equals("�泲") || args[0].equals("���")) {
				temp = args[0].substring(0, 1) + "��" + args[0].substring(1, 2);
			}
			else if (args[0].equals("��") || args[0].equals("���")) {
				temp = args[0].substring(0, 1) + "��" + args[0].substring(1, 2);
			}
			else if (args[0].equals("�泲") || args[0].equals("���")) {
				temp = args[0].substring(0, 1) + "û" + args[0].substring(1, 2);
			}
			
			if (temp.length() == 0)
				queryString += "WHERE ZIP_ADDR LIKE '%'||REPLACE('"+args[count++]+"', ' ', '')||'%'\n";
			else
				queryString += "WHERE (ZIP_ADDR LIKE '%'||REPLACE('"+args[count++]+"', ' ', '')||'%' OR ZIP_ADDR LIKE '%'||REPLACE('"+temp+"', ' ', '')||'%')\n";

			queryString += "AND REPLACE(ZIP_ADDR||DTL_ADDR, ' ', '') LIKE '%'||REPLACE('"+args[count++]+"', ' ', '')||'%'\n";

			if (args.length == 5)
				queryString += "AND REPLACE(ZIP_ADDR||DTL_ADDR, ' ', '') LIKE '%'||REPLACE('"+args[count++]+"', ' ', '')||'%'\n";

			if (args[count].length() > 0)
				queryString += "AND REPLACE(ZIP_ADDR||DTL_ADDR, ' ', '') LIKE '%'||REPLACE('"+args[count]+"', ' ', '')||'%'\n";

			count++;

			if (args[count].length() > 0) 
				queryString += "AND REPLACE(FRCH_NM, ' ', '') LIKE '%'||REPLACE('"+args[count]+"', ' ', '')||'%'\n";
			   
			queryString += "AND OPEN_YN='1'\n";
			queryString += "ORDER BY BUSI_CD, FRCH_NM";

			Cursor results = mDatabase.rawQuery(query.toString()+queryString, null);

			if (results.moveToFirst()) {
				for (; !results.isAfterLast(); results.moveToNext()) {
					info = new StoreInfoModel();
					
					info.setFrch_cd(results.getString(0));
					info.setFrch_dtl_cd(results.getString(1));
					info.setBusi_cd(results.getString(2));
					info.setFrch_nm(results.getString(3));
					info.setTphn_no(results.getString(4));
					info.setCco_cd(results.getString(5));
					info.setZip_addr(results.getString(6));
					info.setDtl_addr(results.getString(7));
					info.setOpen_yn(results.getString(8));
					info.setLat(results.getString(9));
					info.setLongi(results.getString(10));
					info.setBusiCdOrd(results.getString(11));
					list.add(info);
				}
			}
		
			if( results != null ){
				results.close();
				//mDatabase.close();
			}	
		}
		catch (Exception e) {
		}
		return list;
	}

	public ArrayList<StoreInfoModel> selectStoreInfo(Context context, String[] args, String busi_cd) {
		ArrayList<StoreInfoModel> list = new ArrayList<StoreInfoModel>();
		StoreInfoModel info = new StoreInfoModel();
		try {
			String temp = "";
			String queryString = "";
			int count = 0;

			if (args[0].equals("�泲") || args[0].equals("���")) {
				temp = args[0].substring(0, 1) + "��" + args[0].substring(1, 2);
			}
			else if (args[0].equals("��") || args[0].equals("���")) {
				temp = args[0].substring(0, 1) + "��" + args[0].substring(1, 2);
			}
			else if (args[0].equals("�泲") || args[0].equals("���")) {
				temp = args[0].substring(0, 1) + "û" + args[0].substring(1, 2);
			}
			
			if (temp.length() == 0)
				queryString += "WHERE ZIP_ADDR LIKE '%'||REPLACE('"+args[count++]+"', ' ', '')||'%'\n";
			else
				queryString += "WHERE (ZIP_ADDR LIKE '%'||REPLACE('"+args[count++]+"', ' ', '')||'%' OR ZIP_ADDR LIKE '%'||REPLACE('"+temp+"', ' ', '')||'%')\n";

			queryString += "AND REPLACE(ZIP_ADDR||DTL_ADDR, ' ', '') LIKE '%'||REPLACE('"+args[count++]+"', ' ', '')||'%'\n";

			if (args.length == 5)
				queryString += "AND REPLACE(ZIP_ADDR||DTL_ADDR, ' ', '') LIKE '%'||REPLACE('"+args[count++]+"', ' ', '')||'%'\n";

			if (args[count].length() > 0)
				queryString += "AND REPLACE(ZIP_ADDR||DTL_ADDR, ' ', '') LIKE '%'||REPLACE('"+args[count]+"', ' ', '')||'%'\n";

			count++;

			if (args[count].length() > 0) 
				queryString += "AND REPLACE(FRCH_NM, ' ', '') LIKE '%'||REPLACE('"+args[count]+"', ' ', '')||'%'\n";
			   
			queryString += "AND OPEN_YN='1'\n";

			if(!(busi_cd.equals(Util.BUSI_CD_ALL)))
				queryString +="AND BUSI_CD = '"+busi_cd+"'\n";
			
			queryString += "ORDER BY BUSI_CD, FRCH_NM";
			
			Cursor results = mDatabase.rawQuery(query.toString()+queryString, null);

			if (results.moveToFirst()) {
				for (; !results.isAfterLast(); results.moveToNext()) {
					info = new StoreInfoModel();
					
					info.setFrch_cd(results.getString(0));
					info.setFrch_dtl_cd(results.getString(1));
					info.setBusi_cd(results.getString(2));
					info.setFrch_nm(results.getString(3));
					info.setTphn_no(results.getString(4));
					info.setCco_cd(results.getString(5));
					info.setZip_addr(results.getString(6));
					info.setDtl_addr(results.getString(7));
					info.setOpen_yn(results.getString(8));
					info.setLat(results.getString(9));
					info.setLongi(results.getString(10));
					info.setBusiCdOrd(results.getString(11));
					list.add(info);
				}
			}
	
			if( results != null ){
				results.close();
				//mDatabase.close();
			}		
		}
		catch (Exception e) {
		}
		return list;
	}
}
