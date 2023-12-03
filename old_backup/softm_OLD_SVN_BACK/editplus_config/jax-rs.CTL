#TITLE=jax_rs
#INFO
New Cliptext library
#SORT=n

#T=put code json
                jsr.put("data", jsa); // data
                    JSONObject jso_i_1 = new JSONObject();
                    // ����
                    sql.setLength(0);
                    sql.append(" SELECT ")
                       .append(" T_ID    , ")
                       .append(" T_TITLE , ")
                       .append(" USE_YN  , ")
                       .append(" REG_DATE, ")
                       .append(" MOD_DATE, ")
                       .append(" AC_ID     ")
                       .append(" FROM " + TABLE.TBL_LEVELTEST_TYPE)
                    ;
                    stmt = conn.createStatement();
                    rs  = stmt.executeQuery( sql.toString() );
                    while ( rs.next() ) {
                    	jso_i_1.put(StringUtils.defaultString(rs.getString("T_ID"   )),StringUtils.defaultString(rs.getString("T_TITLE")));
                    }
                jsr.put("item_type", jso_i_1 ); // data ����

	                JSONObject jso_i_2 = new JSONObject();
	                jso_i_2.put("E1","��1" );
	                jso_i_2.put("E2","��2" );
	                jso_i_2.put("E3","��3" );
	                jso_i_2.put("E4","��4" );
	                jso_i_2.put("E5","��5" );
	                jso_i_2.put("E6","��6" );
	                jso_i_2.put("M1","��1" );
	                jso_i_2.put("M2","��2" );
	                jso_i_2.put("M3","��3" );
	                jso_i_2.put("H1","��1" );
	                jso_i_2.put("H2","��2" );
	                jso_i_2.put("H3","��3" );
                jsr.put("item_grade", jso_i_2 ); // �г�
#T=insert into -prepare
    /**
     * �л� ������ Ǯ��
     * @param ���� ��� ( I/U/D )
     * @param key
     * @param ������
     * @param ��뿩��
     * @param �ۼ�����
     * @param ��������
     * @return  ������ ���� ó��
     */
    @POST
    @Produces("application/json")
  //@Consumes("application/x-www-form-urlencoded")
    @Path("paper_solve")
    public JSONObject writeType(@FormParam("p_id"    ) int p_id            ,
                                @FormParam("i_num_correct"    ) List<String> i_num_correct
    ) throws Exception{
        JSONObject jsr = new JSONObject();
        if ( loginInfo.adminYn.equals("N") ) {
            jsr.put("return" , "-1"); // �α��ε����� ����
            jsr.put("data", ""); // data
        } else {
            //Util.logger.info(req);
            getConnection();
            try {
                int sIdx = 0;
                StringBuffer sql = new StringBuffer();
                sql.append("INSERT INTO " + TABLE.TBL_LEVELTEST_TYPE + "(" )
                   .append("AC_ID    ,") // 1
                   .append("MEM_ID   ,") // 2
                   .append("P_ID     ,") // 3
                   .append("I_NUM    ,") // 4
                   .append("O_CORRECT,") // 5
                   .append("S_CORRECT ") // 6
                   .append(" ) VALUES (")
                   .append("?,")         // 1
                   .append("?,")         // 2
                   .append("?,")         // 3
                   .append("?,")         // 4
                   .append("?,")         // 5
                   .append("? ")         // 6
                   .append(")")
                ;
                pstmt = conn.prepareStatement( sql.toString() );
                pstmt.setString(sIdx++ , loginInfo.acId   );   // 1
                pstmt.setString(sIdx++ , loginInfo.memId  );   // 2
                pstmt.setInt   (sIdx++ , p_id             );   // 3
                pstmt.setString(sIdx++ , t_title   );   // 4
                pstmt.setString(sIdx++ , t_title   );   // 5
                pstmt.setString(sIdx++ , t_title   );   // 6
              //pstmt.setInt(sIdx++ , Integer.parseInt((loginInfo.acId.equals("")?"0":loginInfo.acId))  );
                pstmt.executeUpdate();
                jsr.put("return" , "1"); // ����
            } catch (Exception e) {
                Util.logger.error("e.toString() : " + e.toString()+ "<BR>");
                jsr.put("return" , "-1"); // ����
                jsr.put("error" , e.toString()); // error message
            } finally {
                releaseConnection();
            }
        }
        return jsr;
    }   
#