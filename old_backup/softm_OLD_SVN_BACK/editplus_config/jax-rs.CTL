#TITLE=jax_rs
#INFO
New Cliptext library
#SORT=n

#T=put code json
                jsr.put("data", jsa); // data
                    JSONObject jso_i_1 = new JSONObject();
                    // 유형
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
                jsr.put("item_type", jso_i_1 ); // data 유형

	                JSONObject jso_i_2 = new JSONObject();
	                jso_i_2.put("E1","초1" );
	                jso_i_2.put("E2","초2" );
	                jso_i_2.put("E3","초3" );
	                jso_i_2.put("E4","초4" );
	                jso_i_2.put("E5","초5" );
	                jso_i_2.put("E6","초6" );
	                jso_i_2.put("M1","중1" );
	                jso_i_2.put("M2","중2" );
	                jso_i_2.put("M3","중3" );
	                jso_i_2.put("H1","고1" );
	                jso_i_2.put("H2","고2" );
	                jso_i_2.put("H3","고3" );
                jsr.put("item_grade", jso_i_2 ); // 학년
#T=insert into -prepare
    /**
     * 학생 시험지 풀기
     * @param 실행 모드 ( I/U/D )
     * @param key
     * @param 유형명
     * @param 사용여부
     * @param 작성일자
     * @param 수정일자
     * @return  데이터 저장 처리
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
            jsr.put("return" , "-1"); // 로그인되있지 않음
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
                jsr.put("return" , "1"); // 성공
            } catch (Exception e) {
                Util.logger.error("e.toString() : " + e.toString()+ "<BR>");
                jsr.put("return" , "-1"); // 실패
                jsr.put("error" , e.toString()); // error message
            } finally {
                releaseConnection();
            }
        }
        return jsr;
    }   
#