/**
 * 입력
 * @param array $argus
 */
function insert($argus) {
    $p_user_id   = $argus[user_email  ];

    $this->testJsCall($argus);
    $this->startXML();
    try {
        if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
        $query = array();
        $query [] = "INSERT INTO " . TBL_BIZ_CONSULT;
        $query [] = " (";
        $query [] = " REG_CODE        ,";
        $query [] = " PROC_TYPE       ,";
        $query [] = " COMPANY_NO      ,";
        $query [] = " REG_DATE         ";
        $query [] = " ) VALUES (";
        $query [] = "'" . $reg_code    . "',";
        $query [] = "'" . $proc_type   . "',";
        $query [] = "'" . COMPANY_NO   . "' ";
        $query [] = " now() ";
        $query [] = " );";
        $this->setQuery(join("\n", $query));
        $this->db->setAutoCommit(false);
        if ( $this->exec($query) ) {
            $this->db->commit();
        } else {
            throw new Exception("입력처리중 에러가 발생하였습니다.");
        }
    } catch (Exception $e) {
        $this->addErrMessage($e->getMessage());
    }
    $this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_SAVE)); // 성공시 출력 메시지.
    $this->printXML(C_DB_PROCESS_MODE_PROC);
}

/**
 * 입력
 * @param array $argus
 */
function update($argus) {
    $p_user_id   = $argus[user_email  ];

    $this->testJsCall($argus);
    $this->startXML();
    try {
        if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
        $query = array();
        $query[] = " UPDATE " .TBL_BIZ_CONSULT;
        $query[] = " SET ";
        $query[] = " REG_CODE      ='" . $reg_code     . "',";
        $query[] = " PASSWD_HINT   ='" . $proc_type    . "',";
        $query[] = " PASSWD_CORRECT='" . COMPANY_NO    . "' ";
        $query[] = " WHERE COMPANY_NO ='" . COMPANY_NO . "'";
        $query[] = " AND   USER_NO    ='" . USRE_NO    . "'";
        $query[] = " AND   REG_CODE   ='" . $reg_code  . "'";
        $this->setQuery(join("\n", $query));
        $this->db->setAutoCommit(false);
        if ( $this->exec($query) ) {
            $this->db->commit();
        } else {
            throw new Exception("수정처리중 에러가 발생하였습니다.");
        }
    } catch (Exception $e) {
        $this->addErrMessage($e->getMessage());
    }
    $this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_SAVE)); // 성공시 출력 메시지.
    $this->printXML(C_DB_PROCESS_MODE_PROC);
}


/**
 * 삭제
 * @param array $argus
 */
function delete($argus) {
    $p_user_id   = $argus[user_email  ];

    $this->testJsCall($argus);
    $this->startXML();
    try {
        if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
        $query = array();
        $query[] = " DELETE FROM " .TBL_BIZ_CONSULT;
        $query[] = " WHERE COMPANY_NO ='" . COMPANY_NO . "'";
        $query[] = " AND   USER_NO    ='" . USRE_NO    . "'";
        $query[] = " AND   REG_CODE   ='" . $reg_code  . "'";
        $this->setQuery(join("\n", $query));
        $this->db->setAutoCommit(false);
        if ( $this->exec($query) ) {
            $this->db->commit();
        } else {
            throw new Exception("삭제처리중 에러가 발생하였습니다.");
        }
    } catch (Exception $e) {
        $this->addErrMessage($e->getMessage());
    }
    $this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_SAVE)); // 성공시 출력 메시지.
    $this->printXML(C_DB_PROCESS_MODE_PROC);
}