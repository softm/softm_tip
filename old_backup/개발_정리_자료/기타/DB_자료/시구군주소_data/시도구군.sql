/* 시도 */
/* tbl_tech_category.csv */
CREATE  TABLE  tbl_city_category (
    SIDO                CHAR    (2  )               NOT NULL                            COMMENT '시도'            ,
    GUGUN               CHAR    (2  )               NOT NULL                            COMMENT '구군'            ,
    NM                  VARCHAR (50 )               NOT NULL                            COMMENT '명칭'            ,
    CONSTRAINT TB_FILE_PK PRIMARY KEY ( WORKER_NO )
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='시도카테고리' ;

