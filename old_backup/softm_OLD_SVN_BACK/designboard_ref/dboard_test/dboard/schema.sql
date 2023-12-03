<?
/* 게시판 정보 */
    $tb_bbs_infor_schm  = "CREATE  TABLE  $tb_bbs_infor (";
    $tb_bbs_infor_schm .= "    no                       INT     (10)    NOT NULL            , /* 게시판 번호            */";
    $tb_bbs_infor_schm .= "    bbs_id                   VARCHAR (40)    NOT NULL            , /* 게시판 아이디          */";
    $tb_bbs_infor_schm .= "    skin_no                  INT     (10)                        , /* 스킨 번호              */";
    $tb_bbs_infor_schm .= "    skin_name                VARCHAR (40)    NOT NULL            , /* 스킨 명                */";
    $tb_bbs_infor_schm .= "    design_method            CHAR    (1)     DEFAULT '1'         , /* 헤더풋터 형식 : '1' , 인클루드 형식 : '0' */";
    $tb_bbs_infor_schm .= "    use_default_login        CHAR    (1)     DEFAULT 'Y'         , /* 기본 로그인 사용여부   */";
    $tb_bbs_infor_schm .= "    login_skin_name          VARCHAR (40)    NULL                , /* 로그인 스킨 명         */";
    $tb_bbs_infor_schm .= "    use_category             CHAR    (1)     DEFAULT 'N'         , /* 카테고리 사용여부      */";
    $tb_bbs_infor_schm .= "    table_width_unit         CHAR    (1)     DEFAULT 1           , /* 게시판 넓이 단위       */";
    $tb_bbs_infor_schm .= "    table_width              INT     (4)     DEFAULT 90          , /* 게시판 넓이            */";
    $tb_bbs_infor_schm .= "    how_many                 INT     (3)     DEFAULT 15          , /* 첫 페이지    글수      */";
    $tb_bbs_infor_schm .= "    more_many                INT     (3)     DEFAULT 15          , /* 첫 페이지이후 글수     */";
    $tb_bbs_infor_schm .= "    page_many                INT     (3)     DEFAULT 10          , /* 페이지 표시 수         */";
    $tb_bbs_infor_schm .= "    title_limit              INT     (3)     DEFAULT 30          , /* 제목글자제한 (자)      */";
    $tb_bbs_infor_schm .= "    max_capacity             INT     (5)     DEFAULT 2           , /* 첨부용량제한 (MB)      */";
    $tb_bbs_infor_schm .= "    mail_send_method         CHAR    (1)     DEFAULT '1'         , /* 폼메일 : '1' , e_mail : '2' */";
    $tb_bbs_infor_schm .= "    display_list             CHAR    (10)    DEFAULT '1101110100', /* 메뉴표시 선택(리스트)  */";
    $tb_bbs_infor_schm .= "    display_write            CHAR    (10)    DEFAULT '1000000000', /* 메뉴표시 선택(글쓰기)  */";
    $tb_bbs_infor_schm .= "    display_view             CHAR    (10)    DEFAULT '0000000000', /* 리스트 출력  의견달기  */";
    $tb_bbs_infor_schm .= "    header                   VARCHAR (255)                       , /* 상단 파일 경로         // 사용 안함 */";
    $tb_bbs_infor_schm .= "    footer                   VARCHAR (255)                       , /* 하단 파일 경로         // 사용 안함 */";
    $tb_bbs_infor_schm .= "    base_path                VARCHAR (255)                       , /* 기반 디렉토리          */";
    $tb_bbs_infor_schm .= "    operator_id              VARCHAR (255)                       , /* 부운영자 아이디        */";
    $tb_bbs_infor_schm .= "    grant_character_image    VARCHAR (255)                       , /* 회원 아이콘 권한       */";
    $tb_bbs_infor_schm .= "    reg_date                 VARCHAR (18)    NOT NULL            , /* 게시판 생성 일자       */";
    $tb_bbs_infor_schm .= "    upd_date                 VARCHAR (18)    NULL                , /* 게시판 수정 일자       */";
    $tb_bbs_infor_schm .= "    primary key (bbs_id)";
    $tb_bbs_infor_schm .= ") ;";

/* 게시판 카테고리 정보 */
    $tb_bbs_category_schm  = "CREATE TABLE $tb_bbs_category" . "_" . $bbs_id. "(";
    $tb_bbs_category_schm .= "    no                   INT         (4  )       NOT NULL    , /* 카테고리 번호      */";
    $tb_bbs_category_schm .= "    o_seq                INT         (4  )                   , /* 정렬 순서          */";
    $tb_bbs_category_schm .= "    name                 VARCHAR     (255)                   , /* 상단 파일 경로     */";
    $tb_bbs_category_schm .= "    etc                  VARCHAR     (255)                   , /* 비고               */";
    $tb_bbs_category_schm .= "    primary key (no )";
    $tb_bbs_category_schm .= ") ;";

/* 게시물 추출 정보 */
    $tb_bbs_abstract_schm  = "CREATE  TABLE  $tb_bbs_abstract (";
    $tb_bbs_abstract_schm .= "    no               INT     (10)    NOT NULL        , /* 게시판 번호            */";
    $tb_bbs_abstract_schm .= "    bbs_id           VARCHAR (40)    NOT NULL        , /* 게시판 아이디          */";
    $tb_bbs_abstract_schm .= "    cat_no           INT     (4)                     , /* 카테고리 번호          */";
    $tb_bbs_abstract_schm .= "    use_category     CHAR    (1)     DEFAULT 'N'     , /* 카테고리 사용여부      */";
    $tb_bbs_abstract_schm .= "    skin_no          INT     (10)                    , /* 스킨 번호              */";
    $tb_bbs_abstract_schm .= "    skin_name        VARCHAR (40)    NOT NULL        , /* 스킨 명                */";
    $tb_bbs_abstract_schm .= "    start_pos        INT     (4)     DEFAULT 1       , /* 게시물 추출 시작 위치  */";
    $tb_bbs_abstract_schm .= "    end_pos          INT     (4)     DEFAULT 5       , /* 게시물 추출 끝   위치  */";
    $tb_bbs_abstract_schm .= "    title_limit      INT     (3)     DEFAULT 30      , /* 제목길이               */";
    $tb_bbs_abstract_schm .= "    content_limit    INT     (10)    DEFAULT  0      , /* 제목길이               */";
    $tb_bbs_abstract_schm .= "    display_list     CHAR    (10)    DEFAULT '001001000' , /* 출력옵션               */";
    $tb_bbs_abstract_schm .= "    display_mode     CHAR    (1)     DEFAULT '1'     , /* 선택 글 표시형식       */";
    $tb_bbs_abstract_schm .= "    base_path        VARCHAR (255)                   , /* 기반 디렉토리          */";
    $tb_bbs_abstract_schm .= "    header           VARCHAR (255)                   , /* 상단 파일 경로         // 사용 안함 */";
    $tb_bbs_abstract_schm .= "    footer           VARCHAR (255)                   , /* 하단 파일 경로         // 사용 안함 */";
    $tb_bbs_abstract_schm .= "    reg_date         VARCHAR (18)    NOT NULL        , /* 생성 일자              */";
    $tb_bbs_abstract_schm .= "    primary key (no)";
    $tb_bbs_abstract_schm .= ") ;";

/* 게시판 스킨 정보 */
    $tb_bbs_skin_schm  = "CREATE  TABLE  $tb_bbs_skin (";
    $tb_bbs_skin_schm .= "    no                  INT     (10)    NOT NULL, /* 게시판 스킨 번호   */";
    $tb_bbs_skin_schm .= "    name                VARCHAR (40)    NOT NULL, /* 게시판 스킨 명     */";
    $tb_bbs_skin_schm .= "    use_st              INT     (1)             , /* 사용 상태          */";
    $tb_bbs_skin_schm .= "    primary key (no)";
    $tb_bbs_skin_schm .= ") ;";

/* 게시판 사용자별 권한 */
    $tb_bbs_grant_schm  = "CREATE  TABLE  $tb_bbs_grant (";
    $tb_bbs_grant_schm .= "    no                     INT     (10)    NOT NULL, /* 게시판 번호  */";
    $tb_bbs_grant_schm .= "    bbs_id                 VARCHAR (40)    NOT NULL, /* 게시판 아이디*/";
    $tb_bbs_grant_schm .= "    member_level           INT     (2)     NOT NULL, /* 회원 레벨    */";
    $tb_bbs_grant_schm .= "    grant_list             CHAR    (1)             , /* 접근제한     */";
    $tb_bbs_grant_schm .= "    grant_view             CHAR    (1)             , /* 읽기제한     */";
    $tb_bbs_grant_schm .= "    grant_write            CHAR    (1)             , /* 쓰기제한     */";
    $tb_bbs_grant_schm .= "    grant_answer           CHAR    (1)             , /* 답변제한     */";
    $tb_bbs_grant_schm .= "    grant_comment          CHAR    (1)             , /* 의견글제한   */";
    $tb_bbs_grant_schm .= "    grant_down             CHAR    (1)             , /* 다운제한     */";
    $tb_bbs_grant_schm .= "    primary key (no ,member_level)";
    $tb_bbs_grant_schm .= ") ;";

/* 회원 정보 */
    $tb_member_schm  = "CREATE  TABLE  $tb_member (";
    $tb_member_schm .= "    no                   INT     (10)    NOT NULL auto_increment primary key,";
    $tb_member_schm .= "    user_id              VARCHAR (20)    NOT NULL, /* 아이디     */";
    $tb_member_schm .= "    member_level         INT     (2 )    NOT NULL, /* 회원 레벨  */";
    $tb_member_schm .= "    password             VARCHAR (41)    NOT NULL, /* 비밀번호   */";
    $tb_member_schm .= "    name                 VARCHAR (20)            , /* 이름       */";
    $tb_member_schm .= "    nick_name            VARCHAR (20)            , /* 별명       */";
    $tb_member_schm .= "    sex                  INT     (1 )            , /* 성별       */";
    $tb_member_schm .= "    e_mail               VARCHAR (100)           , /* E-mail     */";
    $tb_member_schm .= "    home                 VARCHAR (255)           , /* 홈페이지 주소*/";
    $tb_member_schm .= "    jumin                VARCHAR (41)            , /* 주민번호   */";
    $tb_member_schm .= "    birth                VARCHAR (14)            , /* 생년월일   */";
    $tb_member_schm .= "    age                  INT     (3 )            , /* 나이       */";
    $tb_member_schm .= "    tel                  VARCHAR (20)            , /* 전화번호1  */";
    $tb_member_schm .= "    address              VARCHAR (100)           , /* 주소       */";
    $tb_member_schm .= "    post_no              VARCHAR (7 )            , /* 우편번호   */";
    $tb_member_schm .= "    member_st            INT     (1 )    DEFAULT 1,/* 회원 상태  */";
    $tb_member_schm .= "    news_yn              CHAR    (1 )    DEFAULT 'Y' NOT NULL , /* 뉴스 레터 수신 여부 */";
    $tb_member_schm .= "    point                INT     (11)    DEFAULT 0,/* 포인트 점수*/";
    $tb_member_schm .= "    access               INT     (10)    DEFAULT 0,/* 접속 횟수  */";
    $tb_member_schm .= "    user_id_open         CHAR    (1 )    DEFAULT 'Y' NOT NULL , /* 아이디     공개 : 'Y' , 공개안함 : 'N' */";
    $tb_member_schm .= "    member_level_open    CHAR    (1 )    DEFAULT 'Y' NOT NULL , /* 회원 종류  공개 : 'Y' , 공개안함 : 'N' */";
    $tb_member_schm .= "    name_open            CHAR    (1 )    DEFAULT 'Y' NOT NULL , /* 이름       공개 : 'Y' , 공개안함 : 'N' */";
    $tb_member_schm .= "    nick_name_open       CHAR    (1 )    DEFAULT 'Y' NOT NULL , /* 별명       공개 : 'Y' , 공개안함 : 'N' */";
    $tb_member_schm .= "    sex_open             CHAR    (1 )    DEFAULT 'Y' NOT NULL , /* 성별       공개 : 'Y' , 공개안함 : 'N' */";
    $tb_member_schm .= "    e_mail_open          CHAR    (1 )    DEFAULT 'Y' NOT NULL , /* 이메일     공개 : 'Y' , 공개안함 : 'N' */";
    $tb_member_schm .= "    home_open            CHAR    (1 )    DEFAULT 'Y' NOT NULL , /* 홈페이지   공개 : 'Y' , 공개안함 : 'N' */";
    $tb_member_schm .= "    birth_open           CHAR    (1 )    DEFAULT 'Y' NOT NULL , /* 생년월일   공개 : 'Y' , 공개안함 : 'N' */";
    $tb_member_schm .= "    age_open             CHAR    (1 )    DEFAULT 'Y' NOT NULL , /* 나이       공개 : 'Y' , 공개안함 : 'N' */";
    $tb_member_schm .= "    tel_open             CHAR    (1 )    DEFAULT 'Y' NOT NULL , /* 전화번호   공개 : 'Y' , 공개안함 : 'N' */";
    $tb_member_schm .= "    address_open         CHAR    (1 )    DEFAULT 'Y' NOT NULL , /* 주소       공개 : 'Y' , 공개안함 : 'N' */";
    $tb_member_schm .= "    post_no_open         CHAR    (1 )    DEFAULT 'Y' NOT NULL , /* 우편번호   공개 : 'Y' , 공개안함 : 'N' */";
    $tb_member_schm .= "    point_open           CHAR    (1 )    DEFAULT 'Y' NOT NULL , /* 포인트     공개 : 'Y' , 공개안함 : 'N' */";
    $tb_member_schm .= "    access_open          CHAR    (1 )    DEFAULT 'Y' NOT NULL , /* 접속수     공개 : 'Y' , 공개안함 : 'N' */";
    $tb_member_schm .= "    picture_image_open   CHAR    (1 )    DEFAULT 'Y' NOT NULL , /* 사진       공개 : 'Y' , 공개안함 : 'N' */";
    $tb_member_schm .= "    character_image_open CHAR    (1 )    DEFAULT 'Y' NOT NULL , /* 아이콘     공개 : 'Y' , 공개안함 : 'N' */";
    $tb_member_schm .= "    hint                 INT     (3 )               , /* 힌트        */";
    $tb_member_schm .= "    answer               VARCHAR (255)              , /* 답          */";
    $tb_member_schm .= "    reg_date             VARCHAR (18)    NOT NULL   , /* 가입 일자   */";
    $tb_member_schm .= "    acc_date             VARCHAR (18)               , /* 최근 접근일 */";
    $tb_member_schm .= "    unique key (user_id),";
    $tb_member_schm .= "    KEY idx_member_0 ( member_level  ), ";
    $tb_member_schm .= "    KEY idx_member_1 ( user_id       ), ";
    $tb_member_schm .= "    KEY idx_member_2 ( password      ), ";
    $tb_member_schm .= "    KEY idx_member_3 ( name          )  ";
    $tb_member_schm .= ") ;";

/* 회원 종류 */
    $tb_member_kind_schm  = "CREATE  TABLE  $tb_member_kind (";
    $tb_member_kind_schm .= "    member_level        INT     (2)        NOT NULL    , /* 회원 구분      */";
    $tb_member_kind_schm .= "    member_nm           VARCHAR (100)      NOT NULL    , /* 회원 구분 명   */";
    $tb_member_kind_schm .= "    etc                 VARCHAR (255)                  , /* 비고           */";
    $tb_member_kind_schm .= "    point               INT     (10)       DEFAULT  1  , /* 포인트 점수    */";
    $tb_member_kind_schm .= "    reg_date            VARCHAR (18)       NOT NULL    , /* 가입 일자      */";
    $tb_member_kind_schm .= "    primary key (member_level)";
    $tb_member_kind_schm .= ") ;";

/* 회원 가입 폼 설정 */
    $tb_member_config_schm  = "CREATE  TABLE  $tb_member_config (";
    $tb_member_config_schm .= "    member_level        INT     (2)     NOT NULL     , /* 회원 레벨          */";
    $tb_member_config_schm .= "    agreement           CHAR    (1)     DEFAULT  'Y' , /* 가입 약관 표시     */";
    $tb_member_config_schm .= "    agreement_content   TEXT                         , /* 가입 약관          */";
    $tb_member_config_schm .= "    name                CHAR    (1)     DEFAULT  'Y' , /* 이름 표시          */";
    $tb_member_config_schm .= "    nick_name           CHAR    (1)     DEFAULT  'Y' , /* 별명 표시          */";
    $tb_member_config_schm .= "    sex                 CHAR    (1)     DEFAULT  'Y' , /* 성별               */";
    $tb_member_config_schm .= "    e_mail              CHAR    (1)     DEFAULT  'Y' , /* 이메일 표시        */";
    $tb_member_config_schm .= "    home                CHAR    (1)     DEFAULT  'Y' , /* 홈페이지 표시      */";
    $tb_member_config_schm .= "    jumin               CHAR    (1)     DEFAULT  'Y' , /* 주민등록번호 표시  */";
    $tb_member_config_schm .= "    birth               CHAR    (1)     DEFAULT  'Y' , /* 생년월일 표시      */";
    $tb_member_config_schm .= "    age                 CHAR    (1)     DEFAULT  'Y' , /* 나이     표시      */";
    $tb_member_config_schm .= "    tel                 CHAR    (1)     DEFAULT  'Y' , /* 연락처번호 표시    */";
    $tb_member_config_schm .= "    address             CHAR    (1)     DEFAULT  'Y' , /* 주소 표시          */";
    $tb_member_config_schm .= "    news_yn             CHAR    (1)     DEFAULT  'Y' , /* 뉴스레터 수신 표시 */";
    $tb_member_config_schm .= "    news_point          INT     (10)    DEFAULT  500 , /* 뉴스레터 수신 포인트 점수 */";
    $tb_member_config_schm .= "    point_yn            CHAR    (1)     DEFAULT  'Y' , /* 포인터 표시        */";
    $tb_member_config_schm .= "    point               INT     (10)    DEFAULT  1000, /* 포인트 점수        */";
    $tb_member_config_schm .= "    hint                CHAR    (1)     DEFAULT  'Y' , /* 힌트 표시          */";
    $tb_member_config_schm .= "    picture_image       CHAR    (1)     DEFAULT  'Y' , /* 회원 사진   표시   */";
    $tb_member_config_schm .= "    character_image     CHAR    (1)     DEFAULT  'Y' , /* 회원 아이콘 표시   */";
    $tb_member_config_schm .= "    primary key (member_level)";
    $tb_member_config_schm .= ");";

/* 회원 통계 */
    $tb_dic_member_statistic_schm  = "CREATE TABLE $tb_dic_member_statistic (          ";
    $tb_dic_member_statistic_schm .= "    cnt INT     (10) /* 총 회원수 */";
    $tb_dic_member_statistic_schm .= ");";

/* 설문 조사 정보 */
    $tb_poll_master_schm  = "CREATE  TABLE  $tb_poll_master (";
    $tb_poll_master_schm .= "    no                     INT     (10 )   NOT NULL   , /* 설문 번호  */";
    $tb_poll_master_schm .= "    title                  VARCHAR (255)   NOT NULL   , /* 설문 제목  */";
    $tb_poll_master_schm .= "    skin_no                INT     (10 )              , /* 스킨 번호  */";
    $tb_poll_master_schm .= "    skin_name              VARCHAR (40 )   NOT NULL   , /* 스킨 명    */";
    $tb_poll_master_schm .= "    start_date             CHAR    (17 )   NOT NULL   , /* 설문 시작일*/";
    $tb_poll_master_schm .= "    end_date               CHAR    (17 )   NOT NULL   , /* 설문 종료일*/";
    $tb_poll_master_schm .= "    title_limit            INT     (3  )   DEFAULT  0 , /* 제목글자제한 (자)*/";
    $tb_poll_master_schm .= "    opinion_yn             CHAR    (1  )   DEFAULT 'Y', /* 의견 출력        */";
    $tb_poll_master_schm .= "    display_mode           CHAR    (1  )   DEFAULT '2', /* 결과화면 출력형식*/";
    $tb_poll_master_schm .= "    header                 VARCHAR (255)              , /* 상단 파일 경로         // 사용 안함 */";
    $tb_poll_master_schm .= "    footer                 VARCHAR (255)              , /* 하단 파일 경로         // 사용 안함 */";
    $tb_poll_master_schm .= "    total_hit              INT     (10 )   DEFAULT '0', /* 총 설문조사 참여인원수*/";
    $tb_poll_master_schm .= "    use_top                CHAR    (1  )   DEFAULT 'Y', /* 항상 최근 설문으로 설정 'Y' : 설정 , 'N' : 설정 안함 */";
    $tb_poll_master_schm .= "    poll_process           CHAR    (1  )   DEFAULT '1', /* 투표후 처리 페이지 : '1' : 결과페이지, '2' : 알림상자, '3' : url입력 */";
    $tb_poll_master_schm .= "    suc_url                VARCHAR (255)              , /* 성공 이동 페이지   */";
    $tb_poll_master_schm .= "    base_path              VARCHAR (255)              , /* 기반 디렉토리      */";
    $tb_poll_master_schm .= "    grant_character_image  VARCHAR (255)              , /* 회원 아이콘 권한   */";
    $tb_poll_master_schm .= "    reg_date               VARCHAR (18 )   NOT NULL   , /* 설문 생성 일자     */";
    $tb_poll_master_schm .= "    primary key (no)";
    $tb_poll_master_schm .= ") ;";

/* 설문 조사 항목       */
    $tb_poll_item_schm  = "CREATE  TABLE  $tb_poll_item (";
    $tb_poll_item_schm .= "    no      INT     (10)    NOT NULL    , /* 설문 항목 번호 */";
    $tb_poll_item_schm .= "    p_no    INT     (10)    NOT NULL    , /* 상위 설문 번호 */";
    $tb_poll_item_schm .= "    item    VARCHAR (255)   NOT NULL    , /* 설문 항목      */";
    $tb_poll_item_schm .= "    hit     INT     (10)                , /* 득표 수        */";
    $tb_poll_item_schm .= "    primary key (no ,p_no)";
    $tb_poll_item_schm .= ") ;";

/* 설문 조사 스킨 */
    $tb_poll_skin_schm  = "CREATE  TABLE  $tb_poll_skin (";
    $tb_poll_skin_schm .= "    no                  INT     (10)    NOT NULL, /* 게시판 스킨 번호   */";
    $tb_poll_skin_schm .= "    name                VARCHAR (40)    NOT NULL, /* 게시판 스킨 명     */";
    $tb_poll_skin_schm .= "    use_st              INT     (1)             , /* 사용 상태          */";
    $tb_poll_skin_schm .= "    primary key (no)";
    $tb_poll_skin_schm .= ") ;";

/* 설문 조사 사용 권한 */
    $tb_poll_grant_schm  = "CREATE  TABLE  $tb_poll_grant (";
    $tb_poll_grant_schm .= "    no                      INT    (10)     NOT NULL, /* 설문 번호          */";
    $tb_poll_grant_schm .= "    member_level            INT    (2)      NOT NULL, /* 회원 레벨          */";
    $tb_poll_grant_schm .= "    grant_poll              CHAR   (1)              , /* 투표제한           */";
    $tb_poll_grant_schm .= "    grant_poll_result       CHAR   (1)              , /* 투표 결과 보기 제한*/";
    $tb_poll_grant_schm .= "    grant_write             CHAR   (1)              , /* 의견 쓰기 제한     */";
    $tb_poll_grant_schm .= "    primary key (no ,member_level)";
    $tb_poll_grant_schm .= ") ;";

/* 게시판 */
    $tb_bbs_data_schm  = "CREATE  TABLE  $tb_bbs_data" . "_" . $bbs_id. "(";
    $tb_bbs_data_schm .= "    no                  INT     (20)    NOT NULL    , /* 게시물 번호        */";
    $tb_bbs_data_schm .= "    cat_no              INT     (4)                 , /* 카테고리 번호      */";
    $tb_bbs_data_schm .= "    g_no                INT     (20)    NOT NULL    , /* 그룹아이디         */";
    $tb_bbs_data_schm .= "    depth               INT     (10)    NOT NULL    , /* 답변레벨           */";
    $tb_bbs_data_schm .= "    o_seq               INT     (2)     NOT NULL    , /* 정렬 순서          */";
    $tb_bbs_data_schm .= "    pre_no              INT     (20)    NOT NULL    , /* 이전 게시물 번호   */";
    $tb_bbs_data_schm .= "    next_no             INT     (20)    NOT NULL    , /* 이후 게시물 번호   */";
    $tb_bbs_data_schm .= "    member_level        INT     (2)     NOT NULL    , /* 회원 레벨          */";
    $tb_bbs_data_schm .= "    user_id             VARCHAR (20)    NOT NULL    , /* 사용자 ID          */";
    $tb_bbs_data_schm .= "    name                VARCHAR (40)    NOT NULL    , /* 이름               */";
    $tb_bbs_data_schm .= "    password            VARCHAR (41)    NOT NULL    , /* 비밀번호           */";
    $tb_bbs_data_schm .= "    title               VARCHAR (255)   NOT NULL    , /* 제목               */";
    $tb_bbs_data_schm .= "    content             TEXT            NOT NULL    , /* 내용               */";
    $tb_bbs_data_schm .= "    e_mail              VARCHAR (100)               , /* E-mail             */";
    $tb_bbs_data_schm .= "    home                VARCHAR (100)               , /* Homepage           */";
    $tb_bbs_data_schm .= "    f_path1             VARCHAR (255)               , /* 파일 실제 경로1    */";
    $tb_bbs_data_schm .= "    f_name1             VARCHAR (255)               , /* 실제 파일 명1      */";
    $tb_bbs_data_schm .= "    f_ext1              VARCHAR (10)                , /* 파일 확장자1       */";
    $tb_bbs_data_schm .= "    f_size1             INT     (7)                 , /* 파일 크기1         */";
    $tb_bbs_data_schm .= "    f_date1             CHAR    (18)    NOT NULL    , /* 저장 파일명1       */";
    $tb_bbs_data_schm .= "    f_path2             VARCHAR (255)               , /* 파일 실제 경로1    */";
    $tb_bbs_data_schm .= "    f_name2             VARCHAR (255)               , /* 실제 파일 명1      */";
    $tb_bbs_data_schm .= "    f_ext2              VARCHAR (10)                , /* 파일 확장자1       */";
    $tb_bbs_data_schm .= "    f_size2             INT     (7)                 , /* 파일 크기1         */";
    $tb_bbs_data_schm .= "    f_date2             CHAR    (18)    NOT NULL    , /* 저장 파일명1       */";
    $tb_bbs_data_schm .= "    reg_date            VARCHAR (18)    NOT NULL    , /* 작성 및 변경일자   */";
    $tb_bbs_data_schm .= "    html_yn             CHAR    (1)     NOT NULL    , /* Html 사용여부      */";
    $tb_bbs_data_schm .= "    mail_yn             CHAR    (1)     NOT NULL    , /* 답변 확인 메일     */";
    $tb_bbs_data_schm .= "    use_st              INT     (1)     NOT NULL    , /* 글 상태            */";
    $tb_bbs_data_schm .= "    recom_hit           INT     (4)     DEFAULT 0   , /* 추천 수            */";
    $tb_bbs_data_schm .= "    hit                 INT     (6)     DEFAULT 0   , /* 조회수             */";
    $tb_bbs_data_schm .= "    down_hit1           INT     (6)     DEFAULT 0   , /* 다운수1            */";
    $tb_bbs_data_schm .= "    down_hit2           INT     (6)     DEFAULT 0   , /* 다운수2            */";
    $tb_bbs_data_schm .= "    link1               VARCHAR (255)               , /* 링크1              */";
    $tb_bbs_data_schm .= "    link2               VARCHAR (255)               , /* 링크2              */";
    $tb_bbs_data_schm .= "    total_comment       INT     (3)     DEFAULT 0   , /* 코멘트 수          */";
    $tb_bbs_data_schm .= "    comment_date        CHAR    (14)    NULL        , /* 의견글 마지막 작성일자 */";
    $tb_bbs_data_schm .= "    ip                  VARCHAR (15)    NOT NULL    , /* 작성 IP 주소       */";
    $tb_bbs_data_schm .= "    primary key (no),";
    $tb_bbs_data_schm .= "    KEY idx_bbsd_0 ( g_no, o_seq  ), ";
    $tb_bbs_data_schm .= "    KEY idx_bbsd_1 ( depth        ), ";
    $tb_bbs_data_schm .= "    KEY idx_bbsd_2 ( cat_no       ), ";
    $tb_bbs_data_schm .= "    KEY idx_bbsd_3 ( pre_no       ), ";
    $tb_bbs_data_schm .= "    KEY idx_bbsd_4 ( next_no      ), ";
    $tb_bbs_data_schm .= "    KEY idx_bbsd_5 ( user_id      ), ";
    $tb_bbs_data_schm .= "    KEY idx_bbsd_6 ( member_level ), ";
    $tb_bbs_data_schm .= "    KEY idx_bbsd_7 ( name         ), ";
    $tb_bbs_data_schm .= "    KEY idx_bbsd_8 ( use_st       ), ";
    $tb_bbs_data_schm .= "    KEY idx_bbsd_9 ( reg_date     )  ";
    $tb_bbs_data_schm .= ") ;";
/*
    $tb_bbs_data_idx0  = "CREATE INDEX idx_bbsd_0 ON $tb_bbs_data" . "_" . $bbs_id . "( g_no    );";
    $tb_bbs_data_idx1  = "CREATE INDEX idx_bbsd_1 ON $tb_bbs_data" . "_" . $bbs_id . "( depth   );";
    $tb_bbs_data_idx2  = "CREATE INDEX idx_bbsd_2 ON $tb_bbs_data" . "_" . $bbs_id . "( o_seq   );";
    $tb_bbs_data_idx3  = "CREATE INDEX idx_bbsd_3 ON $tb_bbs_data" . "_" . $bbs_id . "( pre_no  );";
    $tb_bbs_data_idx4  = "CREATE INDEX idx_bbsd_4 ON $tb_bbs_data" . "_" . $bbs_id . "( next_no );";
    $tb_bbs_data_idx5  = "CREATE INDEX idx_bbsd_5 ON $tb_bbs_data" . "_" . $bbs_id . "( user_id );";
    $tb_bbs_data_idx6  = "CREATE INDEX idx_bbsd_6 ON $tb_bbs_data" . "_" . $bbs_id . "( name    );";
    $tb_bbs_data_idx7  = "CREATE INDEX idx_bbsd_7 ON $tb_bbs_data" . "_" . $bbs_id . "( use_st  );";
*/

/* 게시판 파일 업로드 정보 --> 현재 버전에서는 구성되지 않음 :: 추후. 게시판 파일 관리 버전에 적용됨. */
    $tb_bbs_file_schm .= "CREATE  TABLE  $tb_bbs_file" . "_" . $bbs_id. "(";
    $tb_bbs_file_schm .= "    p_num               INT     (20   )   NOT NULL    , /* 게시물 번호        */";
    $tb_bbs_file_schm .= "    num                 INT     (20   )   NOT NULL    , /* 파일 번호          */";
    $tb_bbs_file_schm .= "    title               VARCHAR (255  )               , /* 제목               */";
    $tb_bbs_file_schm .= "    memo                TEXT                          , /* 내용               */";
    $tb_bbs_file_schm .= "    gubun               CHAR    (1    )               , /* 구분               */";
    $tb_bbs_file_schm .= "    f_name              VARCHAR (255  )               , /* 파일 명            */";
    $tb_bbs_file_schm .= "    f_ext               VARCHAR (10   )               , /* 파일 확장자        */";
    $tb_bbs_file_schm .= "    f_size              INT     (7    )               , /* 파일 크기          */";
    $tb_bbs_file_schm .= "    reg_date            VARCHAR (18   )   NOT NULL    , /* 작성 및 변경일자   */";
    $tb_bbs_file_schm .= "    primary key (p_num ,num)";
    $tb_bbs_file_schm .= ") ;";

/* 설문 조사 간단 답변 */
    $tb_poll_comment_schm  = "CREATE  TABLE  $tb_poll_comment" . "_" . $poll_id . "(";
    $tb_poll_comment_schm .= "    no                  INT     (10)    NOT NULL    , /* 코멘트 번호    */";
    $tb_poll_comment_schm .= "    p_no                INT     (20)    NOT NULL    , /* 설문 번호      */";
    $tb_poll_comment_schm .= "    user_id             VARCHAR (20)    NOT NULL    , /* 사용자 ID      */";
    $tb_poll_comment_schm .= "    name                VARCHAR (40)                , /* 이름           */";
    $tb_poll_comment_schm .= "    password            VARCHAR (41)                , /* 비밀번호       */";
    $tb_poll_comment_schm .= "    memo                TEXT                        , /* 내용           */";
    $tb_poll_comment_schm .= "    ip                  VARCHAR (15)                , /* 작성 IP 주소   */";
    $tb_poll_comment_schm .= "    reg_date            VARCHAR (18)    NOT NULL    , /* 가입 일자      */";
    $tb_poll_comment_schm .= "    primary key (no ,p_no)";
    $tb_poll_comment_schm .= ") ;";

/* 게시판 간단 답변 */
    $tb_bbs_comment_schm  = "CREATE  TABLE  $tb_bbs_comment" . "_" . $bbs_id . "(";
    $tb_bbs_comment_schm .= "    no                  INT     (10)    NOT NULL    , /* 코멘트 번호    */";
    $tb_bbs_comment_schm .= "    p_no                INT     (20)    NOT NULL    , /* 게시물 번호    */";
    $tb_bbs_comment_schm .= "    user_id             VARCHAR (20)    NOT NULL    , /* 사용자 ID      */";
    $tb_bbs_comment_schm .= "    name                VARCHAR (40)                , /* 이름           */";
    $tb_bbs_comment_schm .= "    password            VARCHAR (41)                , /* 비밀번호       */";
    $tb_bbs_comment_schm .= "    memo                TEXT                        , /* 내용           */";
    $tb_bbs_comment_schm .= "    ip                  VARCHAR (15)                , /* 작성 IP 주소   */";
    $tb_bbs_comment_schm .= "    reg_date            VARCHAR (18)    NOT NULL    , /* 가입 일자      */";
    $tb_bbs_comment_schm .= "    primary key (no ,p_no)";
    $tb_bbs_comment_schm .= ") ;";

/* 우편 번호 */
    $tb_post_schm  = "CREATE TABLE $tb_post(";
    $tb_post_schm .= "  zipcode    CHAR         (7 ) NOT NULL   , /*  우편번호          */";
    $tb_post_schm .= "  sido       VARCHAR      (20)            , /*  특별시,광역시,도  */";
    $tb_post_schm .= "  gugun      VARCHAR      (20)            , /*  시,군,구          */";
    $tb_post_schm .= "  dong       VARCHAR      (24) NOT NULL   , /*  읍,면,동          */";
    $tb_post_schm .= "  ri         VARCHAR      (36)            , /*  리, 건물명        */";
    $tb_post_schm .= "  bunji      VARCHAR      (17)            , /*  번지,아파트동,호수*/";
    $tb_post_schm .= "  st         CHAR         (1 ) NOT NULL   , /*  구분 ( 1, 일반 주소 : 2 : 기관 주소 ) */";
    $tb_post_schm .= "  KEY idx_post (zipcode, dong, st) /* 인덱스 생성 */";
    $tb_post_schm .= ") ;";
/*
    $tb_post_idx0  = "CREATE INDEX idx_post0 ON $tb_post ( zipcode  );";
    $tb_post_idx1  = "CREATE INDEX idx_post1 ON $tb_post ( dong     );";
    $tb_post_idx2  = "CREATE INDEX idx_post2 ON $tb_post ( st       );";
*/

/* 게시판 포인트 정보 */
    $tb_point_infor_schm  = "CREATE  TABLE  $tb_point_infor (";
    $tb_point_infor_schm .= "    no              INT     (10 )       NOT NULL    , /* 포인트 번호  */";
    $tb_point_infor_schm .= "    bbs_id          VARCHAR (40 )       NOT NULL    , /* 게시판 아이디*/";
    $tb_point_infor_schm .= "    member_level    INT     (2  )       NOT NULL    , /* 회원 레벨    */";
    $tb_point_infor_schm .= "    use_st          INT     (1  )       NOT NULL    , /* 사용 상태    */";
    $tb_point_infor_schm .= "    point           INT     (10 )       DEFAULT '0' , /* 포인트 점수  */";
    $tb_point_infor_schm .= "    etc             VARCHAR (255)                   , /* 비고         */";
    $tb_point_infor_schm .= "    reg_date        VARCHAR (18 )       NOT NULL    , /* 생성 일자    */";
    $tb_point_infor_schm .= "    primary key (no, bbs_id, member_level)          ,";
    $tb_point_infor_schm .= "  KEY idx_point_infor (use_st) /* 인덱스 생성 */";
    $tb_point_infor_schm .= ") ;";

/* 설문 포인트 정보 */
    $tb_poll_point_infor_schm  = "CREATE  TABLE  $tb_poll_point_infor (";
    $tb_poll_point_infor_schm .= "    no              INT     (10 )       NOT NULL    , /* 포인트 번호  */";
    $tb_poll_point_infor_schm .= "    poll_no         INT     (10 )       NOT NULL    , /* 설문 번호    */";
    $tb_poll_point_infor_schm .= "    member_level    INT     (2  )       NOT NULL    , /* 회원 레벨    */";
    $tb_poll_point_infor_schm .= "    use_st          INT     (1  )       NOT NULL    , /* 사용 상태    */";
    $tb_poll_point_infor_schm .= "    point           INT     (10 )       DEFAULT '0' , /* 포인트 점수  */";
    $tb_poll_point_infor_schm .= "    etc             VARCHAR (255)                   , /* 비고         */";
    $tb_poll_point_infor_schm .= "    reg_date        VARCHAR (18 )       NOT NULL    , /* 생성 일자    */";
    $tb_poll_point_infor_schm .= "    primary key (no, poll_no, member_level)          ,";
    $tb_poll_point_infor_schm .= "  KEY idx_poll_point_infor (use_st) /* 인덱스 생성 */";
    $tb_poll_point_infor_schm .= ") ;";

/* 이벤트 정보 */
    $tb_event_schm  = "CREATE  TABLE  $tb_event (";
    $tb_event_schm .= "    no                   INT     (10 )       NOT NULL    , /* 이벤트 번호             */";
    $tb_event_schm .= "    title                VARCHAR (255)       NOT NULL    , /* 이벤트 제목             */";
    $tb_event_schm .= "    display_mode         CHAR    (1  )       DEFAULT '1' , /* 이벤트 표시형식         */";
    $tb_event_schm .= "    title_limit          INT     (3  )       DEFAULT 30  , /* 제목글자제한 (자)       */";
    $tb_event_schm .= "    suc_url              VARCHAR (255)                   , /* 성공 이동 페이지        */";
    $tb_event_schm .= "    use_top              CHAR    (1  )       DEFAULT 'N' , /* 항상 최근 이벤트로 설정 */";
    $tb_event_schm .= "    start_date           CHAR    (14 )                   , /* 이벤트 시작일           */";
    $tb_event_schm .= "    end_date             CHAR    (14 )                   , /* 이벤트 종료일           */";
    $tb_event_schm .= "    window_width         INT     (4  )                   , /* 이벤트 창 높이          */";
    $tb_event_schm .= "    window_height        INT     (4  )                   , /* 이벤트 창 넓이          */";
    $tb_event_schm .= "    left_pos             INT     (4  )                   , /* 이벤트 창 X 좌표        */";
    $tb_event_schm .= "    top_pos              INT     (4  )                   , /* 이벤트 창 Y 좌표        */";
    $tb_event_schm .= "    scroll_yn            CHAR    (1  )       DEFAULT 'Y' , /* 팝업 스크롤 여부        */";
    $tb_event_schm .= "    base_path            VARCHAR (255)                   , /* 기반 디렉토리           */";
    $tb_event_schm .= "    login_skin_name      VARCHAR (40 )       NOT NULL    , /* 로그인 스킨 명          */";
    $tb_event_schm .= "    use_default_login    CHAR    (1  )       DEFAULT 'Y' , /* 기본 로그인 사용여부    */";
    $tb_event_schm .= "    reg_date             VARCHAR (18 )       NOT NULL    , /* 이벤트 생성 일자        */";
    $tb_event_schm .= "    primary key (no)";
    $tb_event_schm .= ") ;";

/* 이벤트 권한 */
    $tb_event_grant_schm  = "CREATE  TABLE  $tb_event_grant (";
    $tb_event_grant_schm .= "    no              INT     (10 )       NOT NULL    , /* 이벤트 번호    */";
    $tb_event_grant_schm .= "    member_level    INT     (2  )       NOT NULL    , /* 회원 레벨      */";
    $tb_event_grant_schm .= "    grant_join      CHAR    (1  )                   , /* 참가           */";
    $tb_event_grant_schm .= "    join_point      INT     (10 )                   , /* 포인트 점수    */";
    $tb_event_grant_schm .= "    primary key (no ,member_level)";
    $tb_event_grant_schm .= ") ;";

/* 이벤트 항목 */
    $tb_event_item_schm  = "CREATE  TABLE  $tb_event_item(";
    $tb_event_item_schm .= "    no              INT     (10 )       NOT NULL    , /* 이벤트 번호        */";
    $tb_event_item_schm .= "    g_no            INT     (4  )       NOT NULL    , /* 이벤트 그룹 번호   */";
    $tb_event_item_schm .= "    seq             INT     (4  )       NOT NULL    , /* 항목 순번          */";
    $tb_event_item_schm .= "    o_seq           INT     (4  )                   , /* 정렬 순서          */";
    $tb_event_item_schm .= "    item            CHAR    (1  )                   , /* 항목명 구분        */";
    $tb_event_item_schm .= "    item_name       VARCHAR (255)                   , /* 항목 명            */";
    $tb_event_item_schm .= "    primary key (no, g_no, seq)";
    $tb_event_item_schm .= ") ;";

/* 이벤트 결과 메인 */
    $tb_event_result_master_schm  = "CREATE  TABLE  $tb_event_result_master(";
    $tb_event_result_master_schm .= "    no              INT     (10 )       NOT NULL    , /* 이벤트 번호    */";
    $tb_event_result_master_schm .= "    user_id         VARCHAR (20 )       NOT NULL    , /* 사용자 ID      */";
    $tb_event_result_master_schm .= "    prize_yn        CHAR    (1  )                   , /* 당첨 여부      */";
    $tb_event_result_master_schm .= "    prize_point     INT     (10 )                   , /* 당첨 포인트    */";
    $tb_event_result_master_schm .= "    join_date       CHAR    (14 )       NOT NULL    , /* 참가 일자      */";
    $tb_event_result_master_schm .= "    primary key (no, user_id)";
    $tb_event_result_master_schm .= ") ;";

/* 이벤트 결과 상세 */
    $tb_event_result_detail_schm  = "CREATE  TABLE  $tb_event_result_detail(";
    $tb_event_result_detail_schm .= "    no              INT     (10 )       NOT NULL    , /* 이벤트 번호       */";
    $tb_event_result_detail_schm .= "    user_id         VARCHAR (20 )       NOT NULL    , /* 사용자 ID         */";
    $tb_event_result_detail_schm .= "    g_no            INT     (4  )       NOT NULL    , /* 이벤트 그룹 번호  */";
    $tb_event_result_detail_schm .= "    key_seq         INT     (4  )       NOT NULL    , /* 순번              */";
    $tb_event_result_detail_schm .= "    choice_data     TEXT                            , /* 선택된 값         */";
    $tb_event_result_detail_schm .= "    primary key (no, user_id, g_no, key_seq)";
    $tb_event_result_detail_schm .= ") ;";

/* 로그인 추출 정보     */
    $tb_login_abstract_schm  = "CREATE  TABLE  $tb_login_abstract (";
    $tb_login_abstract_schm .= "    skin_no          INT     (10)                    , /* 스킨 번호         */";
    $tb_login_abstract_schm .= "    skin_name        VARCHAR (40)    NOT NULL        , /* 스킨 명           */";
    $tb_login_abstract_schm .= "    display_mode     CHAR    (1)     DEFAULT '1'     , /* 화면 형식         */";
    $tb_login_abstract_schm .= "    window_width     INT     (4  )                   , /* 팝업 창 높이      */";
    $tb_login_abstract_schm .= "    window_height    INT     (4  )                   , /* 팝업 창 넓이      */";
    $tb_login_abstract_schm .= "    left_pos         INT     (4  )                   , /* 팝업 창 X 좌표    */";
    $tb_login_abstract_schm .= "    top_pos          INT     (4  )                   , /* 팝업 창 Y 좌표    */";
    $tb_login_abstract_schm .= "    scroll_yn        CHAR    (1)     DEFAULT 'Y'     , /* 팝업 스크롤 여부  */";
    $tb_login_abstract_schm .= "    suc_mode         CHAR    (1)     DEFAULT '1'     , /* 성공 실행 형태    */";
    $tb_login_abstract_schm .= "    suc_url          VARCHAR (255)                   , /* 성공 이동 페이지  */";
    $tb_login_abstract_schm .= "    message          VARCHAR (255)                   , /* 알림상자 메세지   */";
    $tb_login_abstract_schm .= "    base_path        VARCHAR (255)                   , /* 기반 디렉토리     */";
    $tb_login_abstract_schm .= "    upd_date         CHAR    (14)    NOT NULL          /* 생성 일자         */";
    $tb_login_abstract_schm .= ") ;";
?>
