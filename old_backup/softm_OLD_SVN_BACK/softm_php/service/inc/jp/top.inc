マッチングサービス紹介  ㅣ  <A href="<?=JP_ENGINEER_URL."&mode=index"?>">技術者情報</A> ㅣ <A href="<?=JP_BIZ_URL."&mode=index"?>">ビジネス情報</a>  ㅣ <A href="<?=JP_TECH_URL."&mode=index"?>">技術情報</a>
<div id="head">
    <div class="wrap">
        <h1><a href="./.."><img src="/images/head/h1Logo.gif" alt="KJT Net - 한일산업기술통합정보시스템" /></a></h1>

        <ul class="tnb">
            <li><a href="#"><img src="/images/head/tnb01.gif" alt="오시는길" /></a></li>
            <li><a href="#"><img src="/images/head/tnb02.gif" alt="사이트맵" /></a></li>
            <li><a href="http://lioness.kr/main_jpn.php"><img src="/images/head/tnb03.gif" alt="日本語" /></a></li>
        </ul>

        <div class="nav">
            <ul>
                <li><a href="<?=BIZ_URL."&mode=index"?>"><img src="/images/head/gnb01.gif" alt="비즈니스정보" /></a></li>
                <li><a href="<?=ENGINEER_URL."&mode=index"?>"><img src="/images/head/gnb02.gif" alt="기술자정보" /></a></li>
                <li><a href="<?=TECH_URL."&mode=index"?>"><img src="/images/head/gnb03.gif" alt="기술정보" /></a></li>
                <li><a href="/sub.php?flashmenu=10401"><img src="/images/head/gnb04.gif" alt="시스템소개" /></a></li>
            </ul>
<?
if ( LOGIN ) {
?>
            <!-- s : logged in -->
            <div class="info">
                <strong><A href="<?=MYPAGE_URL."&mode=member_upd"?>"><?=USER_NAME?></A><span>님</span></strong>
                <span>비즈니스정보 <strong>0<em>건</em></strong></span>
                <span>기술자정보 <strong>0<em>건</em></strong></span>
                <span>기술정보 <strong>0<em>건</em></strong></span>
		<A href="<?=LOGOUT_URL?>">로그아웃</A>
		<A href="<?=MEMBER_UPD_URL?>">회원수정</A>                    
            </div>
            <!-- e : logged in -->
<?
} else {
?>
            <div class="member">
                <form name="lForm" method="post" onsubmit="return 로그인();">
                	<input type='hidden' name='back' value='<?print (BACKURL?BACKURL:$_SERVER[HTTP_REFERER]);?>'>
                    <input type="text" title="아이디 입력" name="uid" class="uid required trim focus alert" maxlength=100 minlength=0 message="아이디를 입력하세요."/>
                    <input type="password" title="패스워드 입력" name="upass" class="upass required focus" message="비밀번호를 입력하세요."/>
                    <input type="image" src="/images/head/btnLogin.gif" alt="Login" class="submit" />
                </form>
                <a href="<?=MEMBER_REG_URL?>">회원가입</a>
                <a href="/sub.php?contents=member&load=member_findid2">아이디/비밀번호찾기</a>
            </div>
<?
}
?>             
        </div>
    </div>
</div>