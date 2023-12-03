<?
/* �Խ��� ���� */
    $tb_bbs_infor_schm  = "CREATE  TABLE  $tb_bbs_infor (";
    $tb_bbs_infor_schm .= "    no                       INT     (10)    NOT NULL            , /* �Խ��� ��ȣ            */";
    $tb_bbs_infor_schm .= "    bbs_id                   VARCHAR (40)    NOT NULL            , /* �Խ��� ���̵�          */";
    $tb_bbs_infor_schm .= "    skin_no                  INT     (10)                        , /* ��Ų ��ȣ              */";
    $tb_bbs_infor_schm .= "    skin_name                VARCHAR (40)    NOT NULL            , /* ��Ų ��                */";
    $tb_bbs_infor_schm .= "    design_method            CHAR    (1)     DEFAULT '1'         , /* ���ǲ�� ���� : '1' , ��Ŭ��� ���� : '0' */";
    $tb_bbs_infor_schm .= "    use_default_login        CHAR    (1)     DEFAULT 'Y'         , /* �⺻ �α��� ��뿩��   */";
    $tb_bbs_infor_schm .= "    login_skin_name          VARCHAR (40)    NULL                , /* �α��� ��Ų ��         */";
    $tb_bbs_infor_schm .= "    use_category             CHAR    (1)     DEFAULT 'N'         , /* ī�װ� ��뿩��      */";
    $tb_bbs_infor_schm .= "    table_width_unit         CHAR    (1)     DEFAULT 1           , /* �Խ��� ���� ����       */";
    $tb_bbs_infor_schm .= "    table_width              INT     (4)     DEFAULT 90          , /* �Խ��� ����            */";
    $tb_bbs_infor_schm .= "    how_many                 INT     (3)     DEFAULT 15          , /* ù ������    �ۼ�      */";
    $tb_bbs_infor_schm .= "    more_many                INT     (3)     DEFAULT 15          , /* ù ���������� �ۼ�     */";
    $tb_bbs_infor_schm .= "    page_many                INT     (3)     DEFAULT 10          , /* ������ ǥ�� ��         */";
    $tb_bbs_infor_schm .= "    title_limit              INT     (3)     DEFAULT 30          , /* ����������� (��)      */";
    $tb_bbs_infor_schm .= "    max_capacity             INT     (5)     DEFAULT 2           , /* ÷�ο뷮���� (MB)      */";
    $tb_bbs_infor_schm .= "    mail_send_method         CHAR    (1)     DEFAULT '1'         , /* ������ : '1' , e_mail : '2' */";
    $tb_bbs_infor_schm .= "    display_list             CHAR    (10)    DEFAULT '1101110100', /* �޴�ǥ�� ����(����Ʈ)  */";
    $tb_bbs_infor_schm .= "    display_write            CHAR    (10)    DEFAULT '1000000000', /* �޴�ǥ�� ����(�۾���)  */";
    $tb_bbs_infor_schm .= "    display_view             CHAR    (10)    DEFAULT '0000000000', /* ����Ʈ ���  �ǰߴޱ�  */";
    $tb_bbs_infor_schm .= "    header                   VARCHAR (255)                       , /* ��� ���� ���         // ��� ���� */";
    $tb_bbs_infor_schm .= "    footer                   VARCHAR (255)                       , /* �ϴ� ���� ���         // ��� ���� */";
    $tb_bbs_infor_schm .= "    base_path                VARCHAR (255)                       , /* ��� ���丮          */";
    $tb_bbs_infor_schm .= "    operator_id              VARCHAR (255)                       , /* �ο�� ���̵�        */";
    $tb_bbs_infor_schm .= "    grant_character_image    VARCHAR (255)                       , /* ȸ�� ������ ����       */";
    $tb_bbs_infor_schm .= "    reg_date                 VARCHAR (18)    NOT NULL            , /* �Խ��� ���� ����       */";
    $tb_bbs_infor_schm .= "    upd_date                 VARCHAR (18)    NULL                , /* �Խ��� ���� ����       */";
    $tb_bbs_infor_schm .= "    primary key (bbs_id)";
    $tb_bbs_infor_schm .= ") ;";

/* �Խ��� ī�װ� ���� */
    $tb_bbs_category_schm  = "CREATE TABLE $tb_bbs_category" . "_" . $bbs_id. "(";
    $tb_bbs_category_schm .= "    no                   INT         (4  )       NOT NULL    , /* ī�װ� ��ȣ      */";
    $tb_bbs_category_schm .= "    o_seq                INT         (4  )                   , /* ���� ����          */";
    $tb_bbs_category_schm .= "    name                 VARCHAR     (255)                   , /* ��� ���� ���     */";
    $tb_bbs_category_schm .= "    etc                  VARCHAR     (255)                   , /* ���               */";
    $tb_bbs_category_schm .= "    primary key (no )";
    $tb_bbs_category_schm .= ") ;";

/* �Խù� ���� ���� */
    $tb_bbs_abstract_schm  = "CREATE  TABLE  $tb_bbs_abstract (";
    $tb_bbs_abstract_schm .= "    no               INT     (10)    NOT NULL        , /* �Խ��� ��ȣ            */";
    $tb_bbs_abstract_schm .= "    bbs_id           VARCHAR (40)    NOT NULL        , /* �Խ��� ���̵�          */";
    $tb_bbs_abstract_schm .= "    cat_no           INT     (4)                     , /* ī�װ� ��ȣ          */";
    $tb_bbs_abstract_schm .= "    use_category     CHAR    (1)     DEFAULT 'N'     , /* ī�װ� ��뿩��      */";
    $tb_bbs_abstract_schm .= "    skin_no          INT     (10)                    , /* ��Ų ��ȣ              */";
    $tb_bbs_abstract_schm .= "    skin_name        VARCHAR (40)    NOT NULL        , /* ��Ų ��                */";
    $tb_bbs_abstract_schm .= "    start_pos        INT     (4)     DEFAULT 1       , /* �Խù� ���� ���� ��ġ  */";
    $tb_bbs_abstract_schm .= "    end_pos          INT     (4)     DEFAULT 5       , /* �Խù� ���� ��   ��ġ  */";
    $tb_bbs_abstract_schm .= "    title_limit      INT     (3)     DEFAULT 30      , /* �������               */";
    $tb_bbs_abstract_schm .= "    content_limit    INT     (10)    DEFAULT  0      , /* �������               */";
    $tb_bbs_abstract_schm .= "    display_list     CHAR    (10)    DEFAULT '001001000' , /* ��¿ɼ�               */";
    $tb_bbs_abstract_schm .= "    display_mode     CHAR    (1)     DEFAULT '1'     , /* ���� �� ǥ������       */";
    $tb_bbs_abstract_schm .= "    base_path        VARCHAR (255)                   , /* ��� ���丮          */";
    $tb_bbs_abstract_schm .= "    header           VARCHAR (255)                   , /* ��� ���� ���         // ��� ���� */";
    $tb_bbs_abstract_schm .= "    footer           VARCHAR (255)                   , /* �ϴ� ���� ���         // ��� ���� */";
    $tb_bbs_abstract_schm .= "    reg_date         VARCHAR (18)    NOT NULL        , /* ���� ����              */";
    $tb_bbs_abstract_schm .= "    primary key (no)";
    $tb_bbs_abstract_schm .= ") ;";

/* �Խ��� ��Ų ���� */
    $tb_bbs_skin_schm  = "CREATE  TABLE  $tb_bbs_skin (";
    $tb_bbs_skin_schm .= "    no                  INT     (10)    NOT NULL, /* �Խ��� ��Ų ��ȣ   */";
    $tb_bbs_skin_schm .= "    name                VARCHAR (40)    NOT NULL, /* �Խ��� ��Ų ��     */";
    $tb_bbs_skin_schm .= "    use_st              INT     (1)             , /* ��� ����          */";
    $tb_bbs_skin_schm .= "    primary key (no)";
    $tb_bbs_skin_schm .= ") ;";

/* �Խ��� ����ں� ���� */
    $tb_bbs_grant_schm  = "CREATE  TABLE  $tb_bbs_grant (";
    $tb_bbs_grant_schm .= "    no                     INT     (10)    NOT NULL, /* �Խ��� ��ȣ  */";
    $tb_bbs_grant_schm .= "    bbs_id                 VARCHAR (40)    NOT NULL, /* �Խ��� ���̵�*/";
    $tb_bbs_grant_schm .= "    member_level           INT     (2)     NOT NULL, /* ȸ�� ����    */";
    $tb_bbs_grant_schm .= "    grant_list             CHAR    (1)             , /* ��������     */";
    $tb_bbs_grant_schm .= "    grant_view             CHAR    (1)             , /* �б�����     */";
    $tb_bbs_grant_schm .= "    grant_write            CHAR    (1)             , /* ��������     */";
    $tb_bbs_grant_schm .= "    grant_answer           CHAR    (1)             , /* �亯����     */";
    $tb_bbs_grant_schm .= "    grant_comment          CHAR    (1)             , /* �ǰ߱�����   */";
    $tb_bbs_grant_schm .= "    grant_down             CHAR    (1)             , /* �ٿ�����     */";
    $tb_bbs_grant_schm .= "    primary key (no ,member_level)";
    $tb_bbs_grant_schm .= ") ;";

/* ȸ�� ���� */
    $tb_member_schm  = "CREATE  TABLE  $tb_member (";
    $tb_member_schm .= "    no                   INT     (10)    NOT NULL auto_increment primary key,";
    $tb_member_schm .= "    user_id              VARCHAR (20)    NOT NULL, /* ���̵�     */";
    $tb_member_schm .= "    member_level         INT     (2 )    NOT NULL, /* ȸ�� ����  */";
    $tb_member_schm .= "    password             VARCHAR (41)    NOT NULL, /* ��й�ȣ   */";
    $tb_member_schm .= "    name                 VARCHAR (20)            , /* �̸�       */";
    $tb_member_schm .= "    nick_name            VARCHAR (20)            , /* ����       */";
    $tb_member_schm .= "    sex                  INT     (1 )            , /* ����       */";
    $tb_member_schm .= "    e_mail               VARCHAR (100)           , /* E-mail     */";
    $tb_member_schm .= "    home                 VARCHAR (255)           , /* Ȩ������ �ּ�*/";
    $tb_member_schm .= "    jumin                VARCHAR (41)            , /* �ֹι�ȣ   */";
    $tb_member_schm .= "    birth                VARCHAR (14)            , /* �������   */";
    $tb_member_schm .= "    age                  INT     (3 )            , /* ����       */";
    $tb_member_schm .= "    tel                  VARCHAR (20)            , /* ��ȭ��ȣ1  */";
    $tb_member_schm .= "    address              VARCHAR (100)           , /* �ּ�       */";
    $tb_member_schm .= "    post_no              VARCHAR (7 )            , /* �����ȣ   */";
    $tb_member_schm .= "    member_st            INT     (1 )    DEFAULT 1,/* ȸ�� ����  */";
    $tb_member_schm .= "    news_yn              CHAR    (1 )    DEFAULT 'Y' NOT NULL , /* ���� ���� ���� ���� */";
    $tb_member_schm .= "    point                INT     (11)    DEFAULT 0,/* ����Ʈ ����*/";
    $tb_member_schm .= "    access               INT     (10)    DEFAULT 0,/* ���� Ƚ��  */";
    $tb_member_schm .= "    user_id_open         CHAR    (1 )    DEFAULT 'Y' NOT NULL , /* ���̵�     ���� : 'Y' , �������� : 'N' */";
    $tb_member_schm .= "    member_level_open    CHAR    (1 )    DEFAULT 'Y' NOT NULL , /* ȸ�� ����  ���� : 'Y' , �������� : 'N' */";
    $tb_member_schm .= "    name_open            CHAR    (1 )    DEFAULT 'Y' NOT NULL , /* �̸�       ���� : 'Y' , �������� : 'N' */";
    $tb_member_schm .= "    nick_name_open       CHAR    (1 )    DEFAULT 'Y' NOT NULL , /* ����       ���� : 'Y' , �������� : 'N' */";
    $tb_member_schm .= "    sex_open             CHAR    (1 )    DEFAULT 'Y' NOT NULL , /* ����       ���� : 'Y' , �������� : 'N' */";
    $tb_member_schm .= "    e_mail_open          CHAR    (1 )    DEFAULT 'Y' NOT NULL , /* �̸���     ���� : 'Y' , �������� : 'N' */";
    $tb_member_schm .= "    home_open            CHAR    (1 )    DEFAULT 'Y' NOT NULL , /* Ȩ������   ���� : 'Y' , �������� : 'N' */";
    $tb_member_schm .= "    birth_open           CHAR    (1 )    DEFAULT 'Y' NOT NULL , /* �������   ���� : 'Y' , �������� : 'N' */";
    $tb_member_schm .= "    age_open             CHAR    (1 )    DEFAULT 'Y' NOT NULL , /* ����       ���� : 'Y' , �������� : 'N' */";
    $tb_member_schm .= "    tel_open             CHAR    (1 )    DEFAULT 'Y' NOT NULL , /* ��ȭ��ȣ   ���� : 'Y' , �������� : 'N' */";
    $tb_member_schm .= "    address_open         CHAR    (1 )    DEFAULT 'Y' NOT NULL , /* �ּ�       ���� : 'Y' , �������� : 'N' */";
    $tb_member_schm .= "    post_no_open         CHAR    (1 )    DEFAULT 'Y' NOT NULL , /* �����ȣ   ���� : 'Y' , �������� : 'N' */";
    $tb_member_schm .= "    point_open           CHAR    (1 )    DEFAULT 'Y' NOT NULL , /* ����Ʈ     ���� : 'Y' , �������� : 'N' */";
    $tb_member_schm .= "    access_open          CHAR    (1 )    DEFAULT 'Y' NOT NULL , /* ���Ӽ�     ���� : 'Y' , �������� : 'N' */";
    $tb_member_schm .= "    picture_image_open   CHAR    (1 )    DEFAULT 'Y' NOT NULL , /* ����       ���� : 'Y' , �������� : 'N' */";
    $tb_member_schm .= "    character_image_open CHAR    (1 )    DEFAULT 'Y' NOT NULL , /* ������     ���� : 'Y' , �������� : 'N' */";
    $tb_member_schm .= "    hint                 INT     (3 )               , /* ��Ʈ        */";
    $tb_member_schm .= "    answer               VARCHAR (255)              , /* ��          */";
    $tb_member_schm .= "    reg_date             VARCHAR (18)    NOT NULL   , /* ���� ����   */";
    $tb_member_schm .= "    acc_date             VARCHAR (18)               , /* �ֱ� ������ */";
    $tb_member_schm .= "    unique key (user_id),";
    $tb_member_schm .= "    KEY idx_member_0 ( member_level  ), ";
    $tb_member_schm .= "    KEY idx_member_1 ( user_id       ), ";
    $tb_member_schm .= "    KEY idx_member_2 ( password      ), ";
    $tb_member_schm .= "    KEY idx_member_3 ( name          )  ";
    $tb_member_schm .= ") ;";

/* ȸ�� ���� */
    $tb_member_kind_schm  = "CREATE  TABLE  $tb_member_kind (";
    $tb_member_kind_schm .= "    member_level        INT     (2)        NOT NULL    , /* ȸ�� ����      */";
    $tb_member_kind_schm .= "    member_nm           VARCHAR (100)      NOT NULL    , /* ȸ�� ���� ��   */";
    $tb_member_kind_schm .= "    etc                 VARCHAR (255)                  , /* ���           */";
    $tb_member_kind_schm .= "    point               INT     (10)       DEFAULT  1  , /* ����Ʈ ����    */";
    $tb_member_kind_schm .= "    reg_date            VARCHAR (18)       NOT NULL    , /* ���� ����      */";
    $tb_member_kind_schm .= "    primary key (member_level)";
    $tb_member_kind_schm .= ") ;";

/* ȸ�� ���� �� ���� */
    $tb_member_config_schm  = "CREATE  TABLE  $tb_member_config (";
    $tb_member_config_schm .= "    member_level        INT     (2)     NOT NULL     , /* ȸ�� ����          */";
    $tb_member_config_schm .= "    agreement           CHAR    (1)     DEFAULT  'Y' , /* ���� ��� ǥ��     */";
    $tb_member_config_schm .= "    agreement_content   TEXT                         , /* ���� ���          */";
    $tb_member_config_schm .= "    name                CHAR    (1)     DEFAULT  'Y' , /* �̸� ǥ��          */";
    $tb_member_config_schm .= "    nick_name           CHAR    (1)     DEFAULT  'Y' , /* ���� ǥ��          */";
    $tb_member_config_schm .= "    sex                 CHAR    (1)     DEFAULT  'Y' , /* ����               */";
    $tb_member_config_schm .= "    e_mail              CHAR    (1)     DEFAULT  'Y' , /* �̸��� ǥ��        */";
    $tb_member_config_schm .= "    home                CHAR    (1)     DEFAULT  'Y' , /* Ȩ������ ǥ��      */";
    $tb_member_config_schm .= "    jumin               CHAR    (1)     DEFAULT  'Y' , /* �ֹε�Ϲ�ȣ ǥ��  */";
    $tb_member_config_schm .= "    birth               CHAR    (1)     DEFAULT  'Y' , /* ������� ǥ��      */";
    $tb_member_config_schm .= "    age                 CHAR    (1)     DEFAULT  'Y' , /* ����     ǥ��      */";
    $tb_member_config_schm .= "    tel                 CHAR    (1)     DEFAULT  'Y' , /* ����ó��ȣ ǥ��    */";
    $tb_member_config_schm .= "    address             CHAR    (1)     DEFAULT  'Y' , /* �ּ� ǥ��          */";
    $tb_member_config_schm .= "    news_yn             CHAR    (1)     DEFAULT  'Y' , /* �������� ���� ǥ�� */";
    $tb_member_config_schm .= "    news_point          INT     (10)    DEFAULT  500 , /* �������� ���� ����Ʈ ���� */";
    $tb_member_config_schm .= "    point_yn            CHAR    (1)     DEFAULT  'Y' , /* ������ ǥ��        */";
    $tb_member_config_schm .= "    point               INT     (10)    DEFAULT  1000, /* ����Ʈ ����        */";
    $tb_member_config_schm .= "    hint                CHAR    (1)     DEFAULT  'Y' , /* ��Ʈ ǥ��          */";
    $tb_member_config_schm .= "    picture_image       CHAR    (1)     DEFAULT  'Y' , /* ȸ�� ����   ǥ��   */";
    $tb_member_config_schm .= "    character_image     CHAR    (1)     DEFAULT  'Y' , /* ȸ�� ������ ǥ��   */";
    $tb_member_config_schm .= "    primary key (member_level)";
    $tb_member_config_schm .= ");";

/* ȸ�� ��� */
    $tb_dic_member_statistic_schm  = "CREATE TABLE $tb_dic_member_statistic (          ";
    $tb_dic_member_statistic_schm .= "    cnt INT     (10) /* �� ȸ���� */";
    $tb_dic_member_statistic_schm .= ");";

/* ���� ���� ���� */
    $tb_poll_master_schm  = "CREATE  TABLE  $tb_poll_master (";
    $tb_poll_master_schm .= "    no                     INT     (10 )   NOT NULL   , /* ���� ��ȣ  */";
    $tb_poll_master_schm .= "    title                  VARCHAR (255)   NOT NULL   , /* ���� ����  */";
    $tb_poll_master_schm .= "    skin_no                INT     (10 )              , /* ��Ų ��ȣ  */";
    $tb_poll_master_schm .= "    skin_name              VARCHAR (40 )   NOT NULL   , /* ��Ų ��    */";
    $tb_poll_master_schm .= "    start_date             CHAR    (17 )   NOT NULL   , /* ���� ������*/";
    $tb_poll_master_schm .= "    end_date               CHAR    (17 )   NOT NULL   , /* ���� ������*/";
    $tb_poll_master_schm .= "    title_limit            INT     (3  )   DEFAULT  0 , /* ����������� (��)*/";
    $tb_poll_master_schm .= "    opinion_yn             CHAR    (1  )   DEFAULT 'Y', /* �ǰ� ���        */";
    $tb_poll_master_schm .= "    display_mode           CHAR    (1  )   DEFAULT '2', /* ���ȭ�� �������*/";
    $tb_poll_master_schm .= "    header                 VARCHAR (255)              , /* ��� ���� ���         // ��� ���� */";
    $tb_poll_master_schm .= "    footer                 VARCHAR (255)              , /* �ϴ� ���� ���         // ��� ���� */";
    $tb_poll_master_schm .= "    total_hit              INT     (10 )   DEFAULT '0', /* �� �������� �����ο���*/";
    $tb_poll_master_schm .= "    use_top                CHAR    (1  )   DEFAULT 'Y', /* �׻� �ֱ� �������� ���� 'Y' : ���� , 'N' : ���� ���� */";
    $tb_poll_master_schm .= "    poll_process           CHAR    (1  )   DEFAULT '1', /* ��ǥ�� ó�� ������ : '1' : ���������, '2' : �˸�����, '3' : url�Է� */";
    $tb_poll_master_schm .= "    suc_url                VARCHAR (255)              , /* ���� �̵� ������   */";
    $tb_poll_master_schm .= "    base_path              VARCHAR (255)              , /* ��� ���丮      */";
    $tb_poll_master_schm .= "    grant_character_image  VARCHAR (255)              , /* ȸ�� ������ ����   */";
    $tb_poll_master_schm .= "    reg_date               VARCHAR (18 )   NOT NULL   , /* ���� ���� ����     */";
    $tb_poll_master_schm .= "    primary key (no)";
    $tb_poll_master_schm .= ") ;";

/* ���� ���� �׸�       */
    $tb_poll_item_schm  = "CREATE  TABLE  $tb_poll_item (";
    $tb_poll_item_schm .= "    no      INT     (10)    NOT NULL    , /* ���� �׸� ��ȣ */";
    $tb_poll_item_schm .= "    p_no    INT     (10)    NOT NULL    , /* ���� ���� ��ȣ */";
    $tb_poll_item_schm .= "    item    VARCHAR (255)   NOT NULL    , /* ���� �׸�      */";
    $tb_poll_item_schm .= "    hit     INT     (10)                , /* ��ǥ ��        */";
    $tb_poll_item_schm .= "    primary key (no ,p_no)";
    $tb_poll_item_schm .= ") ;";

/* ���� ���� ��Ų */
    $tb_poll_skin_schm  = "CREATE  TABLE  $tb_poll_skin (";
    $tb_poll_skin_schm .= "    no                  INT     (10)    NOT NULL, /* �Խ��� ��Ų ��ȣ   */";
    $tb_poll_skin_schm .= "    name                VARCHAR (40)    NOT NULL, /* �Խ��� ��Ų ��     */";
    $tb_poll_skin_schm .= "    use_st              INT     (1)             , /* ��� ����          */";
    $tb_poll_skin_schm .= "    primary key (no)";
    $tb_poll_skin_schm .= ") ;";

/* ���� ���� ��� ���� */
    $tb_poll_grant_schm  = "CREATE  TABLE  $tb_poll_grant (";
    $tb_poll_grant_schm .= "    no                      INT    (10)     NOT NULL, /* ���� ��ȣ          */";
    $tb_poll_grant_schm .= "    member_level            INT    (2)      NOT NULL, /* ȸ�� ����          */";
    $tb_poll_grant_schm .= "    grant_poll              CHAR   (1)              , /* ��ǥ����           */";
    $tb_poll_grant_schm .= "    grant_poll_result       CHAR   (1)              , /* ��ǥ ��� ���� ����*/";
    $tb_poll_grant_schm .= "    grant_write             CHAR   (1)              , /* �ǰ� ���� ����     */";
    $tb_poll_grant_schm .= "    primary key (no ,member_level)";
    $tb_poll_grant_schm .= ") ;";

/* �Խ��� */
    $tb_bbs_data_schm  = "CREATE  TABLE  $tb_bbs_data" . "_" . $bbs_id. "(";
    $tb_bbs_data_schm .= "    no                  INT     (20)    NOT NULL    , /* �Խù� ��ȣ        */";
    $tb_bbs_data_schm .= "    cat_no              INT     (4)                 , /* ī�װ� ��ȣ      */";
    $tb_bbs_data_schm .= "    g_no                INT     (20)    NOT NULL    , /* �׷���̵�         */";
    $tb_bbs_data_schm .= "    depth               INT     (10)    NOT NULL    , /* �亯����           */";
    $tb_bbs_data_schm .= "    o_seq               INT     (2)     NOT NULL    , /* ���� ����          */";
    $tb_bbs_data_schm .= "    pre_no              INT     (20)    NOT NULL    , /* ���� �Խù� ��ȣ   */";
    $tb_bbs_data_schm .= "    next_no             INT     (20)    NOT NULL    , /* ���� �Խù� ��ȣ   */";
    $tb_bbs_data_schm .= "    member_level        INT     (2)     NOT NULL    , /* ȸ�� ����          */";
    $tb_bbs_data_schm .= "    user_id             VARCHAR (20)    NOT NULL    , /* ����� ID          */";
    $tb_bbs_data_schm .= "    name                VARCHAR (40)    NOT NULL    , /* �̸�               */";
    $tb_bbs_data_schm .= "    password            VARCHAR (41)    NOT NULL    , /* ��й�ȣ           */";
    $tb_bbs_data_schm .= "    title               VARCHAR (255)   NOT NULL    , /* ����               */";
    $tb_bbs_data_schm .= "    content             TEXT            NOT NULL    , /* ����               */";
    $tb_bbs_data_schm .= "    e_mail              VARCHAR (100)               , /* E-mail             */";
    $tb_bbs_data_schm .= "    home                VARCHAR (100)               , /* Homepage           */";
    $tb_bbs_data_schm .= "    f_path1             VARCHAR (255)               , /* ���� ���� ���1    */";
    $tb_bbs_data_schm .= "    f_name1             VARCHAR (255)               , /* ���� ���� ��1      */";
    $tb_bbs_data_schm .= "    f_ext1              VARCHAR (10)                , /* ���� Ȯ����1       */";
    $tb_bbs_data_schm .= "    f_size1             INT     (7)                 , /* ���� ũ��1         */";
    $tb_bbs_data_schm .= "    f_date1             CHAR    (18)    NOT NULL    , /* ���� ���ϸ�1       */";
    $tb_bbs_data_schm .= "    f_path2             VARCHAR (255)               , /* ���� ���� ���1    */";
    $tb_bbs_data_schm .= "    f_name2             VARCHAR (255)               , /* ���� ���� ��1      */";
    $tb_bbs_data_schm .= "    f_ext2              VARCHAR (10)                , /* ���� Ȯ����1       */";
    $tb_bbs_data_schm .= "    f_size2             INT     (7)                 , /* ���� ũ��1         */";
    $tb_bbs_data_schm .= "    f_date2             CHAR    (18)    NOT NULL    , /* ���� ���ϸ�1       */";
    $tb_bbs_data_schm .= "    reg_date            VARCHAR (18)    NOT NULL    , /* �ۼ� �� ��������   */";
    $tb_bbs_data_schm .= "    html_yn             CHAR    (1)     NOT NULL    , /* Html ��뿩��      */";
    $tb_bbs_data_schm .= "    mail_yn             CHAR    (1)     NOT NULL    , /* �亯 Ȯ�� ����     */";
    $tb_bbs_data_schm .= "    use_st              INT     (1)     NOT NULL    , /* �� ����            */";
    $tb_bbs_data_schm .= "    recom_hit           INT     (4)     DEFAULT 0   , /* ��õ ��            */";
    $tb_bbs_data_schm .= "    hit                 INT     (6)     DEFAULT 0   , /* ��ȸ��             */";
    $tb_bbs_data_schm .= "    down_hit1           INT     (6)     DEFAULT 0   , /* �ٿ��1            */";
    $tb_bbs_data_schm .= "    down_hit2           INT     (6)     DEFAULT 0   , /* �ٿ��2            */";
    $tb_bbs_data_schm .= "    link1               VARCHAR (255)               , /* ��ũ1              */";
    $tb_bbs_data_schm .= "    link2               VARCHAR (255)               , /* ��ũ2              */";
    $tb_bbs_data_schm .= "    total_comment       INT     (3)     DEFAULT 0   , /* �ڸ�Ʈ ��          */";
    $tb_bbs_data_schm .= "    comment_date        CHAR    (14)    NULL        , /* �ǰ߱� ������ �ۼ����� */";
    $tb_bbs_data_schm .= "    ip                  VARCHAR (15)    NOT NULL    , /* �ۼ� IP �ּ�       */";
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

/* �Խ��� ���� ���ε� ���� --> ���� ���������� �������� ���� :: ����. �Խ��� ���� ���� ������ �����. */
    $tb_bbs_file_schm .= "CREATE  TABLE  $tb_bbs_file" . "_" . $bbs_id. "(";
    $tb_bbs_file_schm .= "    p_num               INT     (20   )   NOT NULL    , /* �Խù� ��ȣ        */";
    $tb_bbs_file_schm .= "    num                 INT     (20   )   NOT NULL    , /* ���� ��ȣ          */";
    $tb_bbs_file_schm .= "    title               VARCHAR (255  )               , /* ����               */";
    $tb_bbs_file_schm .= "    memo                TEXT                          , /* ����               */";
    $tb_bbs_file_schm .= "    gubun               CHAR    (1    )               , /* ����               */";
    $tb_bbs_file_schm .= "    f_name              VARCHAR (255  )               , /* ���� ��            */";
    $tb_bbs_file_schm .= "    f_ext               VARCHAR (10   )               , /* ���� Ȯ����        */";
    $tb_bbs_file_schm .= "    f_size              INT     (7    )               , /* ���� ũ��          */";
    $tb_bbs_file_schm .= "    reg_date            VARCHAR (18   )   NOT NULL    , /* �ۼ� �� ��������   */";
    $tb_bbs_file_schm .= "    primary key (p_num ,num)";
    $tb_bbs_file_schm .= ") ;";

/* ���� ���� ���� �亯 */
    $tb_poll_comment_schm  = "CREATE  TABLE  $tb_poll_comment" . "_" . $poll_id . "(";
    $tb_poll_comment_schm .= "    no                  INT     (10)    NOT NULL    , /* �ڸ�Ʈ ��ȣ    */";
    $tb_poll_comment_schm .= "    p_no                INT     (20)    NOT NULL    , /* ���� ��ȣ      */";
    $tb_poll_comment_schm .= "    user_id             VARCHAR (20)    NOT NULL    , /* ����� ID      */";
    $tb_poll_comment_schm .= "    name                VARCHAR (40)                , /* �̸�           */";
    $tb_poll_comment_schm .= "    password            VARCHAR (41)                , /* ��й�ȣ       */";
    $tb_poll_comment_schm .= "    memo                TEXT                        , /* ����           */";
    $tb_poll_comment_schm .= "    ip                  VARCHAR (15)                , /* �ۼ� IP �ּ�   */";
    $tb_poll_comment_schm .= "    reg_date            VARCHAR (18)    NOT NULL    , /* ���� ����      */";
    $tb_poll_comment_schm .= "    primary key (no ,p_no)";
    $tb_poll_comment_schm .= ") ;";

/* �Խ��� ���� �亯 */
    $tb_bbs_comment_schm  = "CREATE  TABLE  $tb_bbs_comment" . "_" . $bbs_id . "(";
    $tb_bbs_comment_schm .= "    no                  INT     (10)    NOT NULL    , /* �ڸ�Ʈ ��ȣ    */";
    $tb_bbs_comment_schm .= "    p_no                INT     (20)    NOT NULL    , /* �Խù� ��ȣ    */";
    $tb_bbs_comment_schm .= "    user_id             VARCHAR (20)    NOT NULL    , /* ����� ID      */";
    $tb_bbs_comment_schm .= "    name                VARCHAR (40)                , /* �̸�           */";
    $tb_bbs_comment_schm .= "    password            VARCHAR (41)                , /* ��й�ȣ       */";
    $tb_bbs_comment_schm .= "    memo                TEXT                        , /* ����           */";
    $tb_bbs_comment_schm .= "    ip                  VARCHAR (15)                , /* �ۼ� IP �ּ�   */";
    $tb_bbs_comment_schm .= "    reg_date            VARCHAR (18)    NOT NULL    , /* ���� ����      */";
    $tb_bbs_comment_schm .= "    primary key (no ,p_no)";
    $tb_bbs_comment_schm .= ") ;";

/* ���� ��ȣ */
    $tb_post_schm  = "CREATE TABLE $tb_post(";
    $tb_post_schm .= "  zipcode    CHAR         (7 ) NOT NULL   , /*  �����ȣ          */";
    $tb_post_schm .= "  sido       VARCHAR      (20)            , /*  Ư����,������,��  */";
    $tb_post_schm .= "  gugun      VARCHAR      (20)            , /*  ��,��,��          */";
    $tb_post_schm .= "  dong       VARCHAR      (24) NOT NULL   , /*  ��,��,��          */";
    $tb_post_schm .= "  ri         VARCHAR      (36)            , /*  ��, �ǹ���        */";
    $tb_post_schm .= "  bunji      VARCHAR      (17)            , /*  ����,����Ʈ��,ȣ��*/";
    $tb_post_schm .= "  st         CHAR         (1 ) NOT NULL   , /*  ���� ( 1, �Ϲ� �ּ� : 2 : ��� �ּ� ) */";
    $tb_post_schm .= "  KEY idx_post (zipcode, dong, st) /* �ε��� ���� */";
    $tb_post_schm .= ") ;";
/*
    $tb_post_idx0  = "CREATE INDEX idx_post0 ON $tb_post ( zipcode  );";
    $tb_post_idx1  = "CREATE INDEX idx_post1 ON $tb_post ( dong     );";
    $tb_post_idx2  = "CREATE INDEX idx_post2 ON $tb_post ( st       );";
*/

/* �Խ��� ����Ʈ ���� */
    $tb_point_infor_schm  = "CREATE  TABLE  $tb_point_infor (";
    $tb_point_infor_schm .= "    no              INT     (10 )       NOT NULL    , /* ����Ʈ ��ȣ  */";
    $tb_point_infor_schm .= "    bbs_id          VARCHAR (40 )       NOT NULL    , /* �Խ��� ���̵�*/";
    $tb_point_infor_schm .= "    member_level    INT     (2  )       NOT NULL    , /* ȸ�� ����    */";
    $tb_point_infor_schm .= "    use_st          INT     (1  )       NOT NULL    , /* ��� ����    */";
    $tb_point_infor_schm .= "    point           INT     (10 )       DEFAULT '0' , /* ����Ʈ ����  */";
    $tb_point_infor_schm .= "    etc             VARCHAR (255)                   , /* ���         */";
    $tb_point_infor_schm .= "    reg_date        VARCHAR (18 )       NOT NULL    , /* ���� ����    */";
    $tb_point_infor_schm .= "    primary key (no, bbs_id, member_level)          ,";
    $tb_point_infor_schm .= "  KEY idx_point_infor (use_st) /* �ε��� ���� */";
    $tb_point_infor_schm .= ") ;";

/* ���� ����Ʈ ���� */
    $tb_poll_point_infor_schm  = "CREATE  TABLE  $tb_poll_point_infor (";
    $tb_poll_point_infor_schm .= "    no              INT     (10 )       NOT NULL    , /* ����Ʈ ��ȣ  */";
    $tb_poll_point_infor_schm .= "    poll_no         INT     (10 )       NOT NULL    , /* ���� ��ȣ    */";
    $tb_poll_point_infor_schm .= "    member_level    INT     (2  )       NOT NULL    , /* ȸ�� ����    */";
    $tb_poll_point_infor_schm .= "    use_st          INT     (1  )       NOT NULL    , /* ��� ����    */";
    $tb_poll_point_infor_schm .= "    point           INT     (10 )       DEFAULT '0' , /* ����Ʈ ����  */";
    $tb_poll_point_infor_schm .= "    etc             VARCHAR (255)                   , /* ���         */";
    $tb_poll_point_infor_schm .= "    reg_date        VARCHAR (18 )       NOT NULL    , /* ���� ����    */";
    $tb_poll_point_infor_schm .= "    primary key (no, poll_no, member_level)          ,";
    $tb_poll_point_infor_schm .= "  KEY idx_poll_point_infor (use_st) /* �ε��� ���� */";
    $tb_poll_point_infor_schm .= ") ;";

/* �̺�Ʈ ���� */
    $tb_event_schm  = "CREATE  TABLE  $tb_event (";
    $tb_event_schm .= "    no                   INT     (10 )       NOT NULL    , /* �̺�Ʈ ��ȣ             */";
    $tb_event_schm .= "    title                VARCHAR (255)       NOT NULL    , /* �̺�Ʈ ����             */";
    $tb_event_schm .= "    display_mode         CHAR    (1  )       DEFAULT '1' , /* �̺�Ʈ ǥ������         */";
    $tb_event_schm .= "    title_limit          INT     (3  )       DEFAULT 30  , /* ����������� (��)       */";
    $tb_event_schm .= "    suc_url              VARCHAR (255)                   , /* ���� �̵� ������        */";
    $tb_event_schm .= "    use_top              CHAR    (1  )       DEFAULT 'N' , /* �׻� �ֱ� �̺�Ʈ�� ���� */";
    $tb_event_schm .= "    start_date           CHAR    (14 )                   , /* �̺�Ʈ ������           */";
    $tb_event_schm .= "    end_date             CHAR    (14 )                   , /* �̺�Ʈ ������           */";
    $tb_event_schm .= "    window_width         INT     (4  )                   , /* �̺�Ʈ â ����          */";
    $tb_event_schm .= "    window_height        INT     (4  )                   , /* �̺�Ʈ â ����          */";
    $tb_event_schm .= "    left_pos             INT     (4  )                   , /* �̺�Ʈ â X ��ǥ        */";
    $tb_event_schm .= "    top_pos              INT     (4  )                   , /* �̺�Ʈ â Y ��ǥ        */";
    $tb_event_schm .= "    scroll_yn            CHAR    (1  )       DEFAULT 'Y' , /* �˾� ��ũ�� ����        */";
    $tb_event_schm .= "    base_path            VARCHAR (255)                   , /* ��� ���丮           */";
    $tb_event_schm .= "    login_skin_name      VARCHAR (40 )       NOT NULL    , /* �α��� ��Ų ��          */";
    $tb_event_schm .= "    use_default_login    CHAR    (1  )       DEFAULT 'Y' , /* �⺻ �α��� ��뿩��    */";
    $tb_event_schm .= "    reg_date             VARCHAR (18 )       NOT NULL    , /* �̺�Ʈ ���� ����        */";
    $tb_event_schm .= "    primary key (no)";
    $tb_event_schm .= ") ;";

/* �̺�Ʈ ���� */
    $tb_event_grant_schm  = "CREATE  TABLE  $tb_event_grant (";
    $tb_event_grant_schm .= "    no              INT     (10 )       NOT NULL    , /* �̺�Ʈ ��ȣ    */";
    $tb_event_grant_schm .= "    member_level    INT     (2  )       NOT NULL    , /* ȸ�� ����      */";
    $tb_event_grant_schm .= "    grant_join      CHAR    (1  )                   , /* ����           */";
    $tb_event_grant_schm .= "    join_point      INT     (10 )                   , /* ����Ʈ ����    */";
    $tb_event_grant_schm .= "    primary key (no ,member_level)";
    $tb_event_grant_schm .= ") ;";

/* �̺�Ʈ �׸� */
    $tb_event_item_schm  = "CREATE  TABLE  $tb_event_item(";
    $tb_event_item_schm .= "    no              INT     (10 )       NOT NULL    , /* �̺�Ʈ ��ȣ        */";
    $tb_event_item_schm .= "    g_no            INT     (4  )       NOT NULL    , /* �̺�Ʈ �׷� ��ȣ   */";
    $tb_event_item_schm .= "    seq             INT     (4  )       NOT NULL    , /* �׸� ����          */";
    $tb_event_item_schm .= "    o_seq           INT     (4  )                   , /* ���� ����          */";
    $tb_event_item_schm .= "    item            CHAR    (1  )                   , /* �׸�� ����        */";
    $tb_event_item_schm .= "    item_name       VARCHAR (255)                   , /* �׸� ��            */";
    $tb_event_item_schm .= "    primary key (no, g_no, seq)";
    $tb_event_item_schm .= ") ;";

/* �̺�Ʈ ��� ���� */
    $tb_event_result_master_schm  = "CREATE  TABLE  $tb_event_result_master(";
    $tb_event_result_master_schm .= "    no              INT     (10 )       NOT NULL    , /* �̺�Ʈ ��ȣ    */";
    $tb_event_result_master_schm .= "    user_id         VARCHAR (20 )       NOT NULL    , /* ����� ID      */";
    $tb_event_result_master_schm .= "    prize_yn        CHAR    (1  )                   , /* ��÷ ����      */";
    $tb_event_result_master_schm .= "    prize_point     INT     (10 )                   , /* ��÷ ����Ʈ    */";
    $tb_event_result_master_schm .= "    join_date       CHAR    (14 )       NOT NULL    , /* ���� ����      */";
    $tb_event_result_master_schm .= "    primary key (no, user_id)";
    $tb_event_result_master_schm .= ") ;";

/* �̺�Ʈ ��� �� */
    $tb_event_result_detail_schm  = "CREATE  TABLE  $tb_event_result_detail(";
    $tb_event_result_detail_schm .= "    no              INT     (10 )       NOT NULL    , /* �̺�Ʈ ��ȣ       */";
    $tb_event_result_detail_schm .= "    user_id         VARCHAR (20 )       NOT NULL    , /* ����� ID         */";
    $tb_event_result_detail_schm .= "    g_no            INT     (4  )       NOT NULL    , /* �̺�Ʈ �׷� ��ȣ  */";
    $tb_event_result_detail_schm .= "    key_seq         INT     (4  )       NOT NULL    , /* ����              */";
    $tb_event_result_detail_schm .= "    choice_data     TEXT                            , /* ���õ� ��         */";
    $tb_event_result_detail_schm .= "    primary key (no, user_id, g_no, key_seq)";
    $tb_event_result_detail_schm .= ") ;";

/* �α��� ���� ����     */
    $tb_login_abstract_schm  = "CREATE  TABLE  $tb_login_abstract (";
    $tb_login_abstract_schm .= "    skin_no          INT     (10)                    , /* ��Ų ��ȣ         */";
    $tb_login_abstract_schm .= "    skin_name        VARCHAR (40)    NOT NULL        , /* ��Ų ��           */";
    $tb_login_abstract_schm .= "    display_mode     CHAR    (1)     DEFAULT '1'     , /* ȭ�� ����         */";
    $tb_login_abstract_schm .= "    window_width     INT     (4  )                   , /* �˾� â ����      */";
    $tb_login_abstract_schm .= "    window_height    INT     (4  )                   , /* �˾� â ����      */";
    $tb_login_abstract_schm .= "    left_pos         INT     (4  )                   , /* �˾� â X ��ǥ    */";
    $tb_login_abstract_schm .= "    top_pos          INT     (4  )                   , /* �˾� â Y ��ǥ    */";
    $tb_login_abstract_schm .= "    scroll_yn        CHAR    (1)     DEFAULT 'Y'     , /* �˾� ��ũ�� ����  */";
    $tb_login_abstract_schm .= "    suc_mode         CHAR    (1)     DEFAULT '1'     , /* ���� ���� ����    */";
    $tb_login_abstract_schm .= "    suc_url          VARCHAR (255)                   , /* ���� �̵� ������  */";
    $tb_login_abstract_schm .= "    message          VARCHAR (255)                   , /* �˸����� �޼���   */";
    $tb_login_abstract_schm .= "    base_path        VARCHAR (255)                   , /* ��� ���丮     */";
    $tb_login_abstract_schm .= "    upd_date         CHAR    (14)    NOT NULL          /* ���� ����         */";
    $tb_login_abstract_schm .= ") ;";
?>
