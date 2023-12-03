/* 회원정보 */
DROP TABLE IF EXISTS tbl_member;
CREATE TABLE tbl_member (
    USER_NO             INT UNSIGNED                NOT NULL AUTO_INCREMENT             COMMENT '회원번호'             ,
    USER_ID             VARCHAR (20  )              NOT NULL                            COMMENT '아이디'               ,
    USER_EMAIL          VARCHAR (100 )              NOT NULL                            COMMENT '이메일'               ,
    USER_LEVEL          CHAR    (1  )               NOT NULL                            COMMENT '회원 레벨'            ,
    PASSWD              VARCHAR (50 )               NOT NULL                            COMMENT '비밀번호'             ,
    USER_NAME           VARCHAR (20 )                                                   COMMENT '이름'                 ,

    PASSWD_HINT         VARCHAR (100)                                                   COMMENT '비밀번호힌트'         ,
    PASSWD_CORRECT      VARCHAR (100)                                                   COMMENT '비밀번호정답'         ,
    ACCESS              MEDIUMINT UNSIGNED          DEFAULT 0                           COMMENT '접속 횟수'            ,
    REG_DATE            DATETIME                    DEFAULT '0000-00-00 00:00:00'       COMMENT '가입 일자'            ,
    ACC_DATE            DATETIME                    DEFAULT '0000-00-00 00:00:00'       COMMENT '최근 접근일'          ,
    STATE               CHAR    (1  )               NOT NULL                            COMMENT '회원 상태'            ,
    CONSTRAINT tbl_member_PK PRIMARY KEY (USER_NO),
    CONSTRAINT tbl_member_UK UNIQUE KEY  (USER_EMAIL),
    KEY IDX_tbl_member_0 ( USER_EMAIL,PASSWD),
    KEY IDX_tbl_member_1 ( USER_LEVEL    ),
    KEY IDX_tbl_member_2 ( USER_NAME     )
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='회원정보' ;
-- ALTER TABLE tbl_member ADD USER_ID VARCHAR (20  ) NOT NULL COMMENT '아이디' AFTER USER_NO;
-- ALTER TABLE tbl_member DROP INDEX tbl_member_UK;
-- ALTER TABLE tbl_member ADD UNIQUE tbl_member_UK (USER_ID);

/* 기업정보 */
DROP TABLE IF EXISTS tbl_company;
CREATE TABLE tbl_company (
    COMPANY_NO          INT UNSIGNED                NOT NULL AUTO_INCREMENT             COMMENT '기업번호'              ,
    USER_NO             INT UNSIGNED                NOT NULL                            COMMENT '회원번호'              ,
    REG_CODE            CHAR    (14 )               NOT NULL                            COMMENT '기업등록코드 : KO201202030001',
    COUNTRY_TYPE        CHAR    (2  )               NOT NULL                            COMMENT '국가:COUNTRY_TYPE'     ,

    COMPANY_CODE        VARCHAR (10 )                                                   COMMENT '사업자번호'            ,
    COMPANY_TYPE        CHAR    (1  )               NOT NULL                            COMMENT '기업형태:COMPANY_TYPE_',

    COMPANY_NM_KR       VARCHAR (50 )               NOT NULL                            COMMENT '기업명 한글'           ,
    COMPANY_NM_EN       VARCHAR (50 )               NOT NULL                            COMMENT '기업명 영문'           ,
    COMPANY_NM_HJ       VARCHAR (50 )                                                   COMMENT '기업명 한자'           ,
    COMPANY_NM_JP       VARCHAR (50 )                                                   COMMENT '기업명 일문'           ,

    CEO_NM_KR           VARCHAR (50 )               NOT NULL                            COMMENT '대표자 한글'           ,
    CEO_NM_EN           VARCHAR (50 )               NOT NULL                            COMMENT '대표자 영문'           ,
    CEO_NM_HJ           VARCHAR (50 )                                                   COMMENT '대표자 한자'           ,
    CEO_NM_JP           VARCHAR (50 )                                                   COMMENT '대표자 일문'           ,

    BIZ_FIELD           CHAR    (1  )               NOT NULL                            COMMENT '업종분야'              ,
    BIZ_CLASSIFIED      VARCHAR (50 )                                                   COMMENT '업종분류'              ,
    BIZ_CLASSIFIED_ETC  VARCHAR (50 )                                                   COMMENT '업종분류 - 기타'       ,
    BIZ_NAME            VARCHAR (50 )               NOT NULL                            COMMENT '업종명'                ,
    BIZ_NAME_JP         VARCHAR (50 )                                                   COMMENT '업종명 일문'           ,

    ESTABLISH_DATE      DATE                        DEFAULT '0000-00-00'                COMMENT '설립연월일'            ,
    ZIP_CODE            VARCHAR (7  )                                                   COMMENT '우편번호'              ,
    ADDR_KR             VARCHAR (100)                                                   COMMENT '본사 한글 주소'        ,
    ADDR_EN             VARCHAR (100)                                                   COMMENT '본사 영어 주소'        ,
    ADDR_HJ             VARCHAR (100)                                                   COMMENT '본사 한자 주소'        ,
    ADDR_JP             VARCHAR (100)                                                   COMMENT '본사 일문 주소'        ,

    WORKER_CNT          MEDIUMINT UNSIGNED          DEFAULT 0                           COMMENT '종업원수'              ,
    TEL                 VARCHAR (20 )                                                   COMMENT '전화번호'              ,
    FAX                 VARCHAR (20 )                                                   COMMENT '팩스'                  ,

    HOMEPAGE            VARCHAR (255)                                                   COMMENT '홈페이지 주소'         ,

    CAPITAL             INT UNSIGNED                                                    COMMENT '자본금'                ,
    SALES               INT UNSIGNED                                                    COMMENT '매출액'                ,
    EXPECT_SALES        INT UNSIGNED                                                    COMMENT '예상매출액'            ,
    ORDINARY_INCOME     INT UNSIGNED                                                    COMMENT '경상이익'              ,
    MAIN_PRODUCT        VARCHAR (255)                                                   COMMENT '주생산품'              ,
    COMPANY_INTRO       TEXT                                                            COMMENT '회사소개'              ,
    COMPANY_INTRO_JP    TEXT                                                            COMMENT '회사소개(일어)'        ,
    JP_TRADE_YN         CHAR    (1  )              NOT NULL                             COMMENT '일본과 거래 경험 : 있음:Y, 없음:N'        ,
    ETC_TRADE_YN        CHAR    (1  )              NOT NULL                             COMMENT '기타 국가와 거래 경험 : 있음:Y, 없음:N'        ,

    INTERNAL_CUSTOMER    TEXT                                                           COMMENT '주요거래처(국내)'      ,
    INTERNAL_CUSTOMER_JP TEXT                                                           COMMENT '주요거래처(국내)(일어)',
    EXTERNAL_CUSTOMER    TEXT                                                           COMMENT '주요거래처(해외)'      ,
    EXTERNAL_CUSTOMER_JP TEXT                                                           COMMENT '주요거래처(해외)(일어)',

    FILE_NO1            INT UNSIGNED                                                    COMMENT '자료첨부 - 회사소개서' ,
    FILE_NO2            INT UNSIGNED                                                    COMMENT '자료첨부 - 제품소개서' ,
    FILE_NO3            INT UNSIGNED                                                    COMMENT '자료첨부 - 기타'       ,

    REG_DATE            DATETIME                    DEFAULT '0000-00-00 00:00:00'       COMMENT '등록 일자'         ,
    MOD_DATE            DATETIME                    DEFAULT '0000-00-00 00:00:00'       COMMENT '수정 일자'         ,

    CONSTRAINT tbl_company_PK PRIMARY KEY (COMPANY_NO )
    --CONSTRAINT tbl_company_UK UNIQUE KEY  (USER_NO)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='기업정보' ;

--ALTER TABLE TBL_COMPANY DROP KEY tbl_company_UK;
--ALTER TABLE TBL_COMPANY MODIFY COMPANY_CODE        VARCHAR (10 );
--ALTER TABLE TBL_COMPANY ADD COMPANY_INTRO_JP    TEXT AFTER COMPANY_INTRO;
--ALTER TABLE TBL_COMPANY ADD INTERNAL_CUSTOMER_JP TEXT AFTER INTERNAL_CUSTOMER;
--ALTER TABLE TBL_COMPANY ADD EXTERNAL_CUSTOMER_JP TEXT AFTER EXTERNAL_CUSTOMER;
--ALTER TABLE TBL_COMPANY ADD BIZ_NAME_JP         VARCHAR (50 )               NOT NULL                            COMMENT '업종명 일문' AFTER BIZ_NAME;

/* 기업정보 - 생산제품 및 취급품목 */
DROP TABLE IF EXISTS tbl_company_product;
CREATE  TABLE  tbl_company_product (
    COMPANY_NO          INT UNSIGNED                NOT NULL                COMMENT '기업번호'          ,
    SEQ                 TINYINT UNSIGNED            NOT NULL                COMMENT '순번'              ,
    PRODUCT_KR          VARCHAR (50 )                                       COMMENT '생산제품 및 취급품목 한글' ,
    PRODUCT_EN          VARCHAR (50 )                                       COMMENT '생산제품 및 취급품목 영문' ,
    PRODUCT_JP          VARCHAR (50 )                                       COMMENT '생산제품 및 취급품목 일문' ,
    CONSTRAINT tbl_company_product_PK PRIMARY KEY (COMPANY_NO,SEQ)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='생산제품 및 취급품목' ;

/* 관심기업 */
DROP TABLE IF EXISTS tbl_interest_company;
CREATE TABLE tbl_interest_company (
    USER_NO             INT UNSIGNED                NOT NULL                            COMMENT '회원번호'          ,
    COMPANY_NO          INT UNSIGNED                NOT NULL                            COMMENT '관심기업번호'          ,
    REG_DATE            DATETIME                    DEFAULT '0000-00-00 00:00:00'       COMMENT '등록 일자'         ,
    CONSTRAINT tbl_interest_company_PK PRIMARY KEY (USER_NO,COMPANY_NO)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='관심기업' ;

/* 비지니스 상담정보 & 매칭정보 */
DROP TABLE IF EXISTS tbl_biz_consult;
CREATE TABLE tbl_biz_consult (
    CONSULT_NO          INT UNSIGNED                NOT NULL AUTO_INCREMENT COMMENT '상담번호'              ,
    REG_CODE            CHAR    (14 )               NOT NULL                COMMENT '비즈니스코드'          , --  : KO201202030001
    PROC_TYPE           CHAR    (1  )               NOT NULL                COMMENT '처리형태'              , -- PROC_TYPE_BC, PROC_TYPE_BM
    COMPANY_NO          INT UNSIGNED                NOT NULL                COMMENT '기업번호'              ,

    CONSULT_COMPANY_NO  INT UNSIGNED                                        COMMENT '컨선팅할 기업번호 : 상담은 NULL , 매칭 NOT NULL'              ,
    STATE               CHAR    (2  )               NOT NULL                COMMENT '처리상황 : 접수 / 수정요청중 /접수대기 / JK-BiC등록대기 / JK-BiC등록완료'      ,

    CONSULT_ITEM        VARCHAR (100)               NOT NULL                COMMENT '비즈니스 상담 안건'            ,
    CONSULT_ITEM_JP     VARCHAR (100)                                       COMMENT '비즈니스 상담 안건 일어'       ,
    HOPE_BIZ_TYPE       CHAR    (1  )                                       COMMENT '희망 비즈니스 형태'            ,
    HOPE_BIZ            TEXT                                                COMMENT '희망 비즈니스 내용 요약'       ,
    HOPE_BIZ_JP         TEXT                                                COMMENT '희망 비즈니스 내용 요약 일어'  ,

    HOPE_TRADE_TYPE     VARCHAR (100)                                       COMMENT '거래 희망 일본 기업 유형'      ,
    HOPE_TRADE_TYPE_JP  VARCHAR (100)                                       COMMENT '거래 희망 일본 기업 유형 일어' ,

    OPEN_LIMIT          CHAR    (1  )                                       COMMENT '자료 공개 기한: ○  1년 이하   ○  3년 이하  ○  5년 이하   ○ 무기한'    ,
    ETC_QUESTION        TEXT                                                COMMENT '기타 의견 및 문의사항 '    ,
    ETC_QUESTION_JP     TEXT                                                COMMENT '기타 의견 및 문의사항 일어',

    FILE_NO1            INT UNSIGNED                                        COMMENT '제품사진'              ,
    FILE_NO2            INT UNSIGNED                                        COMMENT '제품소개서'            ,
    FILE_NO3            INT UNSIGNED                                        COMMENT '기타'                  ,
    WORKER_NO           INT UNSIGNED                                        COMMENT '담당자번호'            ,

    ACTION_PLAN         TEXT                                                COMMENT '대응방안 '             ,

    OPEN_YN             CHAR    (1  )                                       COMMENT '노출여부'              ,
    REG_DATE            DATETIME        DEFAULT '0000-00-00 00:00:00'       COMMENT '등록 일자'             ,
    MOD_DATE            DATETIME        DEFAULT '0000-00-00 00:00:00'       COMMENT '수정 일자'             ,

    CONSTRAINT tbl_biz_consult_PK PRIMARY KEY (CONSULT_NO),
    CONSTRAINT tbl_biz_consult_UK UNIQUE KEY  (REG_CODE  )
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='비지니스 상담정보 & 매칭정보' ;

-- ALTER TABLE tbl_biz_consult ADD CONSULT_ITEM_JP     VARCHAR (100) COMMENT '비즈니스 상담 안건 일어' AFTER CONSULT_ITEM;
-- ALTER TABLE tbl_biz_consult ADD HOPE_TRADE_TYPE_JP     VARCHAR (100) COMMENT '거래 희망 일본 기업 유형 일어' AFTER HOPE_TRADE_TYPE;
-- ALTER TABLE tbl_biz_consult ADD HOPE_BIZ_JP     TEXT COMMENT '희망 비즈니스 내용 요약 일어' AFTER HOPE_BIZ;
-- ALTER TABLE tbl_biz_consult ADD ETC_QUESTION_JP     TEXT COMMENT '기타 의견 및 문의사항 일어' AFTER ETC_QUESTION;

/* 기술니즈신청 & 기술시드매칭신청*/
DROP TABLE IF EXISTS tbl_tech_consult;
CREATE TABLE tbl_tech_consult (
    CONSULT_NO          INT UNSIGNED                NOT NULL AUTO_INCREMENT COMMENT '상담번호'      ,
    REG_CODE            CHAR    (14 )               NOT NULL                COMMENT '비즈니스코드'  ,
    PROC_TYPE           CHAR    (1  )               NOT NULL                COMMENT 'PROC_TYPE : PROC_TYPE_NC, PROC_TYPE_SM'  ,

    TECH_L_CAT          CHAR    (2  )                                       COMMENT '기술분야1 : tbl_tech_category'     ,
    TECH_M_CAT          CHAR    (2  )                                       COMMENT '기술분야2'     ,
    TECH_S_CAT          CHAR    (2  )                                       COMMENT '기술분야3'     ,

    TECH_NM             VARCHAR (100)                                       COMMENT '기술명 '       ,
    TECH_NM_JP          VARCHAR (100)                                       COMMENT '기술명 일어'   ,
    TECH_CONTENT        TEXT                                                COMMENT '기술내용'      ,
    TECH_CONTENT_JP     TEXT                                                COMMENT '기술내용 일어' ,
    TECH_COMMENT        TEXT                                                COMMENT '기술설명'      ,
    TECH_COMMENT_JP     TEXT                                                COMMENT '기술설명 일어' ,
    KEYWORD             VARCHAR (100)                                       COMMENT '키워드'        ,
    KEYWORD_JP          VARCHAR (100)                                       COMMENT '키워드 일어'   ,

    TRADE_HOPE_TYPE     CHAR    (1  )                                       COMMENT '거래희망유형'          ,
    TRADE_HOPE_TYPE_ETC VARCHAR (50 )                                       COMMENT '거래희망유형 - 기타'   ,

    STATE               CHAR    (2  )               NOT NULL                COMMENT '처리상황 : STATE_NC, STATE_SM'      ,
    OPEN_YN             CHAR    (1  )               DEFAULT 'N'             COMMENT '노출여부'      ,

    WORKER_NO           INT UNSIGNED                                        COMMENT '담당자번호'    ,

    COMPANY_NO          INT UNSIGNED                                        COMMENT '기업번호'      ,
    TECH_NO             INT UNSIGNED                                        COMMENT '기술번호 : 시드신청의 경우에만 가능' ,

    REG_DATE            DATETIME        DEFAULT '0000-00-00 00:00:00'       COMMENT '등록 일자'             ,
    MOD_DATE            DATETIME        DEFAULT '0000-00-00 00:00:00'       COMMENT '수정 일자'             ,

    CONSTRAINT tbl_tech_need_consult_PK PRIMARY KEY (CONSULT_NO),
    CONSTRAINT tbl_tech_need_consult_UK UNIQUE KEY  (REG_CODE  )
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='기술니즈신청 & 기술시드매칭신청' ;

/* 기술시드 - 공급 가능한 기술 */
DROP TABLE IF EXISTS tbl_tech_seed;
CREATE TABLE tbl_tech_seed (
    TECH_NO             INT UNSIGNED                NOT NULL AUTO_INCREMENT COMMENT '기술번호'      ,
    REG_CODE            CHAR    (14 )               NOT NULL                COMMENT '비즈니스코드'  ,
    TECH_L_CAT          CHAR    (2  )               NOT NULL                COMMENT '기술분야1 : tbl_tech_category'     ,
    TECH_M_CAT          CHAR    (2  )               NOT NULL                COMMENT '기술분야2'     ,
    TECH_S_CAT          CHAR    (2  )               NOT NULL                COMMENT '기술분야3'     ,
    ORGAN               VARCHAR (100)                                       COMMENT '기관명'        ,
    URL                 VARCHAR (255)                                       COMMENT '해당URL '      ,
    TECH_NM             VARCHAR (100)                                       COMMENT '기술명 '       ,
    TECH_NM_JP          VARCHAR (100)                                       COMMENT '기술명 일어'   ,
    LICENSE_NUMBER      VARCHAR (100)                                       COMMENT '특허번호 '     ,
    PURPOSE             VARCHAR (100)                                       COMMENT '목적 '         ,
    PURPOSE_JP          VARCHAR (100)                                       COMMENT '목적 일어'     ,
    OUTLINE             VARCHAR (100)                                       COMMENT '개요 '         ,
    OUTLINE_JP          VARCHAR (100)                                       COMMENT '개요 일어'     ,
    FEATURE             VARCHAR (100)                                       COMMENT '특징 '         ,
    FEATURE_JP          VARCHAR (100)                                       COMMENT '특징 일어'     ,
    KEYWORD             VARCHAR (100)                                       COMMENT '키워드'        ,
    KEYWORD_JP          VARCHAR (100)                                       COMMENT '키워드 일어'   ,
    FILE_NO1            INT UNSIGNED                                        COMMENT '첨부파일'      ,
    OPEN_YN             CHAR    (1  )                                       COMMENT '노출여부'      ,

    REG_DATE            DATETIME        DEFAULT '0000-00-00 00:00:00'       COMMENT '등록 일자'     ,
    MOD_DATE            DATETIME        DEFAULT '0000-00-00 00:00:00'       COMMENT '수정 일자'     ,

    USER_NO             INT UNSIGNED                                        COMMENT '등록자번호'    ,
    WORKER_NO           INT UNSIGNED                                        COMMENT '담당자번호'    ,

    CONSTRAINT tbl_tech_need_consult_PK PRIMARY KEY (TECH_NO  ),
    CONSTRAINT tbl_tech_need_consult_UK UNIQUE KEY  (REG_CODE )
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='기술시드' ;

/* 관리자 Comment */
DROP TABLE IF EXISTS tbl_consult_admin_comment;
CREATE  TABLE  tbl_consult_admin_comment (
    PROC_TYPE           CHAR    (1  )               NOT NULL                COMMENT '처리형태'          ,
    CONSULT_NO          INT UNSIGNED                NOT NULL                COMMENT '상담번호'          ,
    SEQ                 TINYINT UNSIGNED            NOT NULL                COMMENT '순번'              ,
    ADMIN_COMMENT       TEXT                                                COMMENT '관리자 Comment'    ,
    REG_DATE            DATETIME        DEFAULT '0000-00-00 00:00:00'       COMMENT '등록 일자'         ,
    MOD_DATE            DATETIME        DEFAULT '0000-00-00 00:00:00'       COMMENT '수정 일자'         ,
    CONSTRAINT tbl_consult_admin_comment_PK PRIMARY KEY (PROC_TYPE, CONSULT_NO, SEQ)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='관리자 Comment' ;

/* 담당자정보 */
DROP TABLE IF EXISTS tbl_worker;
CREATE  TABLE  tbl_worker (
    WORKER_NO           INT UNSIGNED                NOT NULL AUTO_INCREMENT             COMMENT '담당자번호'        ,
    PROC_TYPE           CHAR    (2  )               NOT NULL                            COMMENT 'PROC_TYPE'         ,
    NM_KR               VARCHAR (50 )               NOT NULL                            COMMENT '담당자 한글'       ,
    NM_EN               VARCHAR (50 )                                                   COMMENT '담당자 영문'       ,
    NM_HJ               VARCHAR (50 )                                                   COMMENT '담당자 한자'       ,
    NM_JP               VARCHAR (50 )                                                   COMMENT '담당자 일문'       ,
    EMAIL               VARCHAR (100 )                                                  COMMENT '이메일'            ,
    TEL                 VARCHAR (20 )                                                   COMMENT '전화번호'          ,
    HP                  VARCHAR (20 )                                                   COMMENT '휴대폰'            ,
    FAX                 VARCHAR (20 )                                                   COMMENT '팩스'              ,
    POSSIBLE_LANG       VARCHAR (10 )                                                   COMMENT '대응 가능 외국어 : JP: 일본어 EN: 영어   NO : 없음  콤마로 연결해서 저장'    ,
    DEPT                VARCHAR (50 )                                                   COMMENT '부서'              ,
    POSITION            VARCHAR (50 )                                                   COMMENT '직위'              ,

    DEPT_JP             VARCHAR (50 )                                                   COMMENT '부서 일문'         ,
    POSITION_JP         VARCHAR (50 )                                                   COMMENT '직위 일문'         ,

    COMPANY_NO          INT UNSIGNED                                                    COMMENT '기업번호'          ,
    REG_DATE            DATETIME                    DEFAULT '0000-00-00 00:00:00'       COMMENT '등록 일자'         ,
    MOD_DATE            DATETIME                    DEFAULT '0000-00-00 00:00:00'       COMMENT '수정 일자'         ,
    CONSTRAINT tbl_worker_PK PRIMARY KEY ( WORKER_NO )
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='담당자정보' ;

/* 일본기술자정보 - 간단 */
DROP TABLE IF EXISTS tbl_jp_engineer;
CREATE  TABLE  tbl_jp_engineer (
    ENGINEER_NO         INT UNSIGNED                NOT NULL AUTO_INCREMENT             COMMENT '기술자번호'    ,
    NM_HJ               VARCHAR (50 )                                                   COMMENT '담당자 한자'       ,
    NM_JP               VARCHAR (50 )                                                   COMMENT '담당자 일문'       ,
    NM_KR               VARCHAR (50 )               NOT NULL                            COMMENT '담당자 한글'       ,
    NM_EN               VARCHAR (50 )                                                   COMMENT '담당자 영문'       ,
    TEL                 VARCHAR (20 )                                                   COMMENT '전화번호'          ,
    EMAIL               VARCHAR (100 )                                                  COMMENT '이메일'            ,
    HP                  VARCHAR (20 )                                                   COMMENT '휴대폰'            ,
    FILE_NO1            INT UNSIGNED                                                    COMMENT '이력서-첨부파일'   ,
    FILE_NO2            INT UNSIGNED                                                    COMMENT '각서-첨부파일'     ,
    USER_NO             INT UNSIGNED                                                    COMMENT '등록자번호'        ,

    REG_DATE            DATETIME                    DEFAULT '0000-00-00 00:00:00'       COMMENT '등록 일자'         ,
    MOD_DATE            DATETIME                    DEFAULT '0000-00-00 00:00:00'       COMMENT '수정 일자'         ,
    CONSTRAINT tbl_jp_engineer_PK PRIMARY KEY ( ENGINEER_NO )
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='일본기술자정보' ;

/* 첨부파일 */
DROP TABLE IF EXISTS tbl_file;
CREATE  TABLE  tbl_file (
    FILE_NO             INT UNSIGNED                NOT NULL AUTO_INCREMENT             COMMENT '파일번호'      ,
    PROC_TYPE           CHAR    (1  )               NOT NULL                            COMMENT 'PROC_TYPE : PROC_TYPE_EM'  ,
    USER_NO             INT UNSIGNED                                                    COMMENT '회원번호'      ,
    COMPANY_NO          INT UNSIGNED                                                    COMMENT '기업번호'      ,
    FILE_NAME           VARCHAR (100)               NOT NULL                            COMMENT '파일명'        ,
    FILE_EXT            VARCHAR (10 )               NOT NULL                            COMMENT '파일 확장자'   ,
    FILE_SIZE           VARCHAR (10 )               NOT NULL                            COMMENT '파일 크기'     ,
    REG_DATE            DATETIME                    DEFAULT '0000-00-00 00:00:00'       COMMENT '등록 일자'     ,
    MOD_DATE            DATETIME                    DEFAULT '0000-00-00 00:00:00'       COMMENT '수정 일자'     ,
    CONSTRAINT tbl_file_PK PRIMARY KEY ( FILE_NO ),
    KEY IDX_tbl_file_0 ( FILE_NAME , PROC_TYPE )
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='첨부파일' ;

/* 기술분류 */
/* tbl_tech_category.csv */
DROP TABLE IF EXISTS tbl_tech_category;
CREATE  TABLE  tbl_tech_category (
    L_CAT               CHAR    (2  )               NOT NULL                            COMMENT '대분류'            ,
    M_CAT               CHAR    (2  )               NOT NULL                            COMMENT '중분류'            ,
    S_CAT               CHAR    (2  )               NOT NULL                            COMMENT '소분류'            ,
    NM                  VARCHAR (50 )               NOT NULL                            COMMENT '분류명'            ,
    NM_JP               VARCHAR (50 )               NOT NULL                            COMMENT '분류명(일문)'      ,
    CONSTRAINT tbl_tech_category_PK PRIMARY KEY ( L_CAT, M_CAT, S_CAT )
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='기술분류' ;
-- alter table tbl_tech_category add NM_JP VARCHAR (50 ) NOT NULL COMMENT '분류명(일문)';

/* 시도 */
/* tbl_city_category.csv */
DROP TABLE IF EXISTS tbl_city_category;
CREATE  TABLE  tbl_city_category (
    SIDO                CHAR    (2  )               NOT NULL                            COMMENT '시도'            ,
    GUGUN               CHAR    (2  )               NOT NULL                            COMMENT '구군'            ,
    NM                  VARCHAR (50 )               NOT NULL                            COMMENT '명칭'            ,
    CONSTRAINT TB_FILE_PK PRIMARY KEY ( SIDO, GUGUN )
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='시도카테고리' ;

--DROP TABLE IF EXISTS tbl_post;
CREATE  TABLE tbl_post (
    ZIPCODE             VARCHAR (7  )               NULL DEFAULT NULL                   COMMENT '우편번호'      ,
    AREA1               VARCHAR (4  )               NULL DEFAULT NULL                   COMMENT '도시'          ,
    AREA2               VARCHAR (15 )               NULL DEFAULT NULL                   COMMENT '시구군'        ,
    AREA3               VARCHAR (52 )               NULL DEFAULT NULL                   COMMENT '동'            ,
    AREA4               VARCHAR (17 )               NULL DEFAULT NULL                   COMMENT '상세'
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='우편번호' ;
