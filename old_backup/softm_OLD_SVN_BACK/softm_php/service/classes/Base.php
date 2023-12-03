<?php
require_once SERVICE_DIR .'/classes/common/Message.php'        ; // 메시지 클래스

/**
 * @author softm
 * 기본 클래스
 */
class Base extends stdClass
{
    /**
     * @var
     * 회원 등급
     */
    public static $CODE_USER_LEVEL = array(MEMBER_TYPE_STD=>"일반회원",MEMBER_TYPE_ADM=>"관리자"  );

    /**
     * @var array
     * 사용자 상태
     */
    public static $CODE_USER_STATE = array(
                                "U"=>"사용",
                                "S"=>"정지",
                                "R"=>"탈퇴"
                            );
    /**
     * @var array
     * 성별
     */
    public static $CODE_SEX = array(
                                "F"=>"여자",
                                "M"=>"남자"
                            );
    /**
     * @var array
     * 사용여부
     */
    public static $CODE_YN = array(
                                "Y"=>"사용",
                                "N"=>"미사용"
                            );
    /**
     * @var array
     * 유/무
     */
    public static $CODE_EXIST = array(
    		"Y"=>"있음",
    		"N"=>"없음"
    );
    /**
     * @var array
     * 승인상태 : 접수[R] / 승인[A] / 취소[C] -   $CODE_STATE_REGINFO
     */
    public static
    $CODE_STATE_REGINFO = array(
                            STATE_REGINFO_START         =>"접수"    ,
                            STATE_REGINFO_APPROVAL      =>"승인"    ,
                            STATE_REGINFO_CANCEL        =>"취소"
    );

    /**
     * @var array
     * 승인상태 : 접수[R] / 승인[A] / 취소[C] -   $CODE_STATE_REGINFO
     */
    public static
    $CODE_AREA = array(
                            "11"      =>"서울"    ,
                            "26"      =>"부산"    ,
                            "27"      =>"대구"    ,
                            "28"      =>"인천"    ,
                            "29"      =>"광주"    ,
                            "30"      =>"대전"    ,
                            "31"      =>"울산"    ,
                            "41"      =>"경기"    ,
                            "42"      =>"강원"    ,
                            "43"      =>"충북"    ,
                            "44"      =>"충남"    ,
                            "45"      =>"전북"    ,
                            "46"      =>"전남"    ,
                            "47"      =>"경북"    ,
                            "48"      =>"경남"    ,
                            "50"      =>"제주"
    );

    /**
     * @var array
     * 문의유형 형태 : 일반[1], 기타[2] QNA_TYPE -   $CODE_QNA_TYPE
     */
    public static
    $CODE_QNA_TYPE = array(
                            QNA_TYPE_1  =>"일반"    ,
                            QNA_TYPE_2  =>"기타"
    );

    /**
     * @var array
     * 답변상태 : 질문[Q] / 답변완료[A] QNA_STATE -   $CODE_QNA_STATE
     */
    public static
    $CODE_QNA_STATE = array(
                            QNA_STATE_Q  =>"질문"    ,
                            QNA_STATE_A  =>"답변완료"
    );

    function __construct() {
    }

    function __destruct() {
    }
}
?>