
/* 기술자 정보 */
DROP TABLE IF EXISTS tbl_engineer;
CREATE TABLE tbl_engineer (
    ENGINEER_NO         INT UNSIGNED                NOT NULL AUTO_INCREMENT COMMENT '기술자번호'    ,
    REG_CODE            CHAR    (14 )               NOT NULL                COMMENT '기술자코드'    ,
/* 기술자 기본 정보 */
    NM_KR               VARCHAR (50 )               NOT NULL                COMMENT '성명 한글'     ,
    NM_EN               VARCHAR (50 )                                       COMMENT '성명 영문'     ,
    NM_HJ               VARCHAR (50 )                                       COMMENT '성명 한자'     ,
    AGE                 TINYINT UNSIGNED                                    COMMENT '나이'          ,
    SEX                 CHAR    (1  )                                       COMMENT '성별 남:M,여:F',
    ZIP_CODE            VARCHAR (7  )                                       COMMENT '우편번호'      ,
    ADDR                VARCHAR (100)                                       COMMENT '주소'          ,
    TECH_L_CAT          CHAR    (2  )                                       COMMENT '기술분야1 : tbl_tech_category'     ,
    TECH_M_CAT          CHAR    (2  )                                       COMMENT '기술분야2'     ,
    TECH_S_CAT          CHAR    (2  )                                       COMMENT '기술분야3'     ,
    KEYWORD             VARCHAR (100)                                       COMMENT '키워드'        ,

/* 학력 및 경력사항 */
    CAREER_SUMMARY      VARCHAR (255)                                       COMMENT '학력및경력요약',
    TECH_SUMMARY        VARCHAR (255)                                       COMMENT '기술분야요약'  ,

/* 기타정보 */
    LICENSE             TEXT                                                COMMENT '자격 및 면허'  ,
    WRITING             TEXT                                                COMMENT '저술 및 논문'  ,
    AWARDED             TEXT                                                COMMENT '수상이력'      ,

    LANG_EN_LEVEL       CHAR    (1  )                                       COMMENT '외국어 상:1,중:2,하:3',
    LANG_KR_LEVEL       CHAR    (1  )                                       COMMENT '외국어 상:1,중:2,하:3',
    LANG_JP_LEVEL       CHAR    (1  )                                       COMMENT '외국어 상:1,중:2,하:3',
    LANG_ETC_LEVEL      VARCHAR (50)                                        COMMENT '외국어 기타'       ,

    CONTACT_METHOD      CHAR    (1  )                                       COMMENT '문서 연락 가능 매체 : E-mail:E □ FAX:F ',

/* 지도가능분야  */
    ADVISER_BIZ         VARCHAR (100)                                       COMMENT '지도가능업종'      ,
    ADVISER_CONTENT     TEXT                                                COMMENT '지도 가능 내용'    ,
    ADVISER_DAY         VARCHAR (100)                                       COMMENT '지도 가능 일수'    ,

    PR                  TEXT                                                COMMENT '자기 PR'           ,
    REG_DATE            DATETIME        DEFAULT '0000-00-00 00:00:00'       COMMENT '등록 일자'         ,
    MOD_DATE            DATETIME        DEFAULT '0000-00-00 00:00:00'       COMMENT '수정 일자'         ,

    COMPANY_NO          INT UNSIGNED                DEFAULT 0               COMMENT '기업번호'          ,

    CONSTRAINT tbl_engineer_PK PRIMARY KEY (ENGINEER_NO),
    CONSTRAINT tbl_engineer_UK UNIQUE KEY  (REG_CODE  )
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='기술자 정보' ;

/* 기술자 경력사항 */
DROP TABLE IF EXISTS tbl_engineer_career;
CREATE  TABLE  tbl_engineer_career (
    ENGINEER_NO         INT UNSIGNED                NOT NULL                COMMENT '기술자번호'        ,
    SEQ                 TINYINT UNSIGNED            NOT NULL                COMMENT '순번'              ,
    FROM_DATE           DATE                        DEFAULT '0000-00-00'    COMMENT '시작일자'          ,
    TO_DATE             DATE                        DEFAULT '0000-00-00'    COMMENT '종료일자'          ,
    INSTITUTION         VARCHAR (50)                                        COMMENT '출신학교&소속기관' ,
    CONTENT             VARCHAR (100)                                       COMMENT '학위 or 부서/직위(담당업무/수행프로젝트) '  ,

    CONSTRAINT tbl_engineer_career_PK PRIMARY KEY (ENGINEER_NO,SEQ)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='기술자 경력사항' ;

/* 기술자 지도 실적 및 경험 */
DROP TABLE IF EXISTS tbl_engineer_adviser;
CREATE  TABLE  tbl_engineer_adviser (
    ENGINEER_NO         INT UNSIGNED                NOT NULL                COMMENT '기술자번호'        ,
    SEQ                 TINYINT UNSIGNED            NOT NULL                COMMENT '순번'              ,

    ADVISER_TASK        VARCHAR (100)                                       COMMENT '지도 과제명'       ,
    ADVISER_CONTENT     TEXT                                                COMMENT '지도 내용'         ,

    FROM_DATE           DATE                        DEFAULT '0000-00-00'    COMMENT '지도 기간 시작일자',
    TO_DATE             DATE                        DEFAULT '0000-00-00'    COMMENT '지도 기간 종료일자',
    ADVISER_COUNTRY     VARCHAR (50 )                                       COMMENT '지도 국가'         ,

    CONSTRAINT tbl_engineer_adviser_PK PRIMARY KEY (ENGINEER_NO,SEQ)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='지도 실적 및 경험' ;

/* 기술자 지도가능분야 */
DROP TABLE IF EXISTS tbl_engineer_adviser_field;
CREATE  TABLE  tbl_engineer_adviser_field (
    ENGINEER_NO         INT UNSIGNED                NOT NULL                COMMENT '기술자번호'        ,
    SEQ                 TINYINT UNSIGNED            NOT NULL                COMMENT '순번'              ,
    ADVISER_FIELD       CHAR    (1  )               NOT NULL                COMMENT '지도가능분야 : ADVISER_FIELD'     ,
    NOTE                VARCHAR (100)                                       COMMENT '기타 시 입력 '     ,
    CONSTRAINT tbl_engineer_adviser_field_PK PRIMARY KEY (ENGINEER_NO,SEQ)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='지도가능분야' ;

/* 관심기술자 */
DROP TABLE IF EXISTS tbl_interest_engineer;
CREATE TABLE tbl_interest_engineer (
    USER_NO             INT UNSIGNED                NOT NULL                            COMMENT '회원번호'          ,
    ENGINEER_NO         INT UNSIGNED                NOT NULL                            COMMENT '기술자번호'        ,
    REG_DATE            DATETIME                    DEFAULT '0000-00-00 00:00:00'       COMMENT '등록 일자'         ,
    MOD_DATE            DATETIME                    DEFAULT '0000-00-00 00:00:00'       COMMENT '수정 일자'         ,
    CONSTRAINT tbl_interest_engineer_PK PRIMARY KEY (USER_NO,ENGINEER_NO)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='관심기술자' ;

/* 기술자매칭 */
DROP TABLE IF EXISTS tbl_engineer_consult;
CREATE TABLE tbl_engineer_consult (
    CONSULT_NO          INT UNSIGNED                NOT NULL AUTO_INCREMENT COMMENT '상담번호'      ,
    REG_CODE            CHAR    (14 )               NOT NULL                COMMENT '비즈니스코드'  ,
    PROC_TYPE           CHAR    (1  )               NOT NULL                COMMENT 'PROC_TYPE : PROC_TYPE_EM'  ,

    COMPANY_NO          INT UNSIGNED                                        COMMENT '기업번호'      ,
    OPEN_YN             CHAR    (1  )                                       COMMENT '노출여부'      ,

    STATE               CHAR    (2  )               NOT NULL                COMMENT '처리상황 : 접수 / 수정요청중 /접수대기 / JK-BiC등록대기 / JK-BiC등록완료'      ,
/* 기술자 선택정보 : tbl_engineer_consult_engineer */
    
/* 초청기술자 */
    TECH_L_CAT          CHAR    (2  )                                       COMMENT '기술분야1 : tbl_tech_category'     ,
    TECH_M_CAT          CHAR    (2  )                                       COMMENT '기술분야2'     ,
    TECH_S_CAT          CHAR    (2  )                                       COMMENT '기술분야3'     ,
    INVITE_START_DATE   DATE                        DEFAULT '0000-00-00'    COMMENT '초청기간 - 시작 - 년월만입력됨'          ,
    INVITE_END_DATE     DATE                        DEFAULT '0000-00-00'    COMMENT '초청기간 - 종료 - 년월만입력됨'          ,

    EXPECT_PAY1         INT UNSIGNED                                        COMMENT '급여수준1'     ,
    EXPECT_PAY2         INT UNSIGNED                                        COMMENT '급여수준2'     ,
    EXPECT_PAY3         INT UNSIGNED                                        COMMENT '급여수준3'     ,

    ALLIANCE_TYPE       CHAR    (1  )                                       COMMENT '제휴형태 ALLIANCE_TYPE '      ,
    ALLIANCE_TYPE_ETC   VARCHAR (50 )                                       COMMENT '제휴형태-기타' ,

/* 일본기술자 활용계획서  */
    WORKER_NO           INT UNSIGNED                                        COMMENT '담당자번호'            ,
    USE_TYPE            CHAR    (1  )                                       COMMENT '활용형태'              ,
    USE_TYPE_ETC        VARCHAR (50 )                                       COMMENT '활용형태 - 기타'       ,
    USE_TYPE_ETC_JP     VARCHAR (50 )                                       COMMENT '활용형태 - 기타 일어'  ,

    EXPECT_TERM         SMALLINT UNSIGNED                                   COMMENT '예상계약기간'          ,
    EXPECT_WORK_TERM1   SMALLINT UNSIGNED                                   COMMENT '예상근무일수 월간'     ,
    EXPECT_WORK_TERM2   SMALLINT UNSIGNED                                   COMMENT '예상근무일수 일'       ,

    TRANSLATION_TYPE    CHAR    (1  )                                       COMMENT '통역필요유무 TRANSLATION_TYPE'              ,

    WORK_ZONE           VARCHAR (50 )                                       COMMENT '근무지역'              ,
    WORK_ZONE_JP        VARCHAR (50 )                                       COMMENT '근무지역 일어'         ,
    WORK_DAY            TINYINT UNSIGNED                                    COMMENT '근무시간'              ,

    BENEFIT_TYPE_1      CHAR    (1  )                                       COMMENT '복리후생 숙소    BENEFIT_TYPE'              ,
    BENEFIT_TYPE_2      CHAR    (1  )                                       COMMENT '복리후생 식사제공'     ,
    BENEFIT_TYPE_3      CHAR    (1  )                                       COMMENT '복리후생 교통비'       ,
    BENEFIT_TYPE_4      CHAR    (1  )                                       COMMENT '복리후생 기타 상태'    ,
    BENEFIT_TYPE_ETC    VARCHAR (50 )                                       COMMENT '복리후생 기타'         ,
    BENEFIT_TYPE_ETC_JP VARCHAR (50 )                                       COMMENT '복리후생 기타 일어'    ,

    WORK_CONDITION      TEXT                                                COMMENT '기타근무조건 상세 기술',
    WORK_CONDITION_JP   TEXT                                                COMMENT '기타근무조건 상세 기술 일어',

/* 일본기술자 활용 사유 (구체적, 서술식으로) */
    USE_REASON          TEXT                                                COMMENT '일본기술자 활용 사유'      ,
    USE_REASON_JP       TEXT                                                COMMENT '일본기술자 활용 사유 일어' ,

/* 요청 업무 내용 */
    BIZ_ADVISE_TYPE     CHAR    (1  )                                       COMMENT '업무분야 BIZ_ADVISE_TYPE'              ,
    BIZ_ADVISE_TYPE_ETC VARCHAR (50 )                                       COMMENT '업무분야 BIZ_ADVISE_TYPE'              ,

    BIZ_REQUEST_1       VARCHAR (100)                                       COMMENT '업무사항1 '             ,
    BIZ_REQUEST_2       VARCHAR (100)                                       COMMENT '업무사항2 '             ,
    BIZ_REQUEST_3       VARCHAR (100)                                       COMMENT '업무사항3 '             ,
    BIZ_REQUEST_4       VARCHAR (100)                                       COMMENT '업무사항4 '             ,

    BIZ_REQUEST_1_JP    VARCHAR (100)                                       COMMENT '업무사항1 일어'        ,
    BIZ_REQUEST_2_JP    VARCHAR (100)                                       COMMENT '업무사항2 일어'        ,
    BIZ_REQUEST_3_JP    VARCHAR (100)                                       COMMENT '업무사항3 일어'        ,
    BIZ_REQUEST_4_JP    VARCHAR (100)                                       COMMENT '업무사항4 일어'        ,

/* 기타 참고사항  */
    RELATION_COMPANY1   VARCHAR (100)                                       COMMENT '일본의 관련분야 기업명1 ' ,
    RELATION_COMPANY2   VARCHAR (100)                                       COMMENT '일본의 관련분야 기업명2 ' ,

    RELATION_COMPANY1_JP VARCHAR (100)                                      COMMENT '일본의 관련분야 기업명1 일어' ,
    RELATION_COMPANY2_JP VARCHAR (100)                                      COMMENT '일본의 관련분야 기업명2 일어' ,

    ETC_NOTE            TEXT                                                COMMENT '기타'                  ,
    ETC_NOTE_JP         TEXT                                                COMMENT '기타 일어'             ,

    FILE_NO1            INT UNSIGNED                                        COMMENT '대차대조표 및 순익계산서 ' ,
    FILE_NO2            INT UNSIGNED                                        COMMENT '사업자등록증 '         ,
    FILE_NO3            INT UNSIGNED                                        COMMENT '이력서 '               ,

    REG_DATE            DATETIME                    DEFAULT '0000-00-00 00:00:00'       COMMENT '등록 일자'         ,
    MOD_DATE            DATETIME                    DEFAULT '0000-00-00 00:00:00'       COMMENT '수정 일자'         ,
    CONSTRAINT tbl_tech_consult_PK PRIMARY KEY (CONSULT_NO),
    CONSTRAINT tbl_tech_consult_UK UNIQUE KEY  (REG_CODE  )
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='기술자매칭' ;

/* 기술자 선택정보 */
DROP TABLE IF EXISTS tbl_engineer_consult_engineer;
CREATE  TABLE  tbl_engineer_consult_engineer (
    CONSULT_NO          INT UNSIGNED                NOT NULL AUTO_INCREMENT COMMENT '상담번호'          ,
    ENGINEER_NO         INT UNSIGNED                NOT NULL                COMMENT '기술자번호'        ,
    SEQ                 TINYINT UNSIGNED            NOT NULL                COMMENT '순번'              ,
    NOTE                VARCHAR (100)                                       COMMENT '임시로 생성만해놈' ,
    CONSTRAINT tbl_engineer_consult_engineer_PK PRIMARY KEY (CONSULT_NO, ENGINEER_NO, SEQ)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='기술자 선택정보' ;

/* 일본기술자 활용 월별 계획 */
DROP TABLE IF EXISTS tbl_engineer_consult_monthly_useplan;
CREATE  TABLE  tbl_engineer_consult_monthly_useplan (
    CONSULT_NO          INT UNSIGNED                NOT NULL AUTO_INCREMENT COMMENT '상담번호'          ,
    MONTH               TINYINT UNSIGNED            NOT NULL                COMMENT '월'                ,
    PLAN                TEXT                                                COMMENT '세부활용계획'      ,
    PLAN_JP             TEXT                                                COMMENT '세부활용계획 일어' ,
    NOTE                TEXT                                                COMMENT '비고'              ,
    NOTE_JP             TEXT                                                COMMENT '비고 일어'         ,
    CONSTRAINT tbl_engineer_career_PK PRIMARY KEY (CONSULT_NO, MONTH)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='일본기술자 활용 월별 계획' ;