#TITLE=topsmall
#INFO
New Cliptext library
#SORT=n

#T==================================
=================================
#T=기본템플릿
<html>
<head>
{INDEX_HEAD}
</head>
<body topmargin="0" leftmargin="0" bgcolor="#F1F1F1">
{# TOP}
<!-- 메인이미지 -->
<table border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
	<td><img src="{URL_ICON_HOME}/{MAIN_IMAGE}" border="0"></td>
	<td width="100%" background="{URL_ICON_HOME}sub03/main_img_bg.gif"></td></tr>
</table>
<!-- /메인이미지 -->
<!-- 메인테이블 -->
<table border="0" cellspacing="0" cellpadding="0" width="980">
<tr>
	<td width="200" valign="top">
{# MENU}
	</td>
	<td width="10"></td>
	<td width="770" valign="top">
<!-- BODY CONTENTS -->
		<!-- 내용부분 -->
^!
		<!-- /내용부분 -->

	</td></tr>
</table>
<!-- /메인테이블 -->
{# COPY}
</body>
</html>
#T=<textarea></textarea>
<textarea>^!</textarea>
#T=home nav
<font style="font-family:Gulim;font-size:12px;color:#6a4a5d;line-height:23px"> 현재위치 > <a href='/'>Home</a> ><a href='<?=$_SERVER[REQUEST_URI]?>'>{CTNAME}</a></font>
#T=http://localhost/?pgname=home/shop_cart
http://localhost/?pgname=home/shop_cart
#T==== 상품박스 ===========================
=== 상품박스 ===========================
#T=전체
<!--

URL_ICON
URL_ICON_HOME
BOX_HEAD

GOODSBOX_NAME
GOODSBOX_MORE
BOARDBOX_MORE_URL
GOODSBOX_TOP
GOODSBOX_BOTTOM

@ GOODSBOX_LIST

	GOODSBOX_LIST.TRTD_START

	GOODSBOX_LIST.URL_LINK
	GOODSBOX_LIST.URL_PICX
	GOODSBOX_LIST.ZOOM

	GOODSBOX_LIST.PIC_URL
	GOODSBOX_LIST.PIC
	GOODSBOX_LIST.NO

	GOODSBOX_LIST.GDNO
	GOODSBOX_LIST.GCODE
	GOODSBOX_LIST.GNAME
	GOODSBOX_LIST.MAKER
	GOODSBOX_LIST.BRAND
	GOODSBOX_LIST.ORIGIN
	GOODSBOX_LIST.INFO
	GOODSBOX_LIST.SPEC
	GOODSBOX_LIST.KEYWORD
	GOODSBOX_LIST.PRICE_P_NUM
	GOODSBOX_LIST.PRICE_R_NUM
	GOODSBOX_LIST.DISCOUNT
	GOODSBOX_LIST.POINT_NUM
	GOODSBOX_LIST.TRANS_NUM
	GOODSBOX_LIST.VIEW

	GOODSBOX_LIST.ICON_NEW
	GOODSBOX_LIST.ICON_COOL
	GOODSBOX_LIST.ICON_HOT
	GOODSBOX_LIST.ICON_OUT
	GOODSBOX_LIST.ICON_OUTSTOCK
	GOODSBOX_LIST.ICON_DISCOUNT
	GOODSBOX_LIST.ICON_POINT

	GOODSBOX_LIST.TRTD_END

-->
{URL_ICON}
{URL_ICON_HOME}
{GOODSBOX_NAME}
{GOODSBOX_MORE}
{BOARDBOX_MORE_URL}
<textarea>{GOODSBOX_TOP}</textarea>
<table width="100%" border="0" cellspacing="0" class="box">
	<tr class="title" style="text-align:left">
		<td height="24">&nbsp;{GOODSBOX_NAME}</td><td align="right">{GOODSBOX_MORE}&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2">{GOODSBOX_TOP}</td>
	</tr>
	<tr>
		<td colspan="2">
			<table width="100%">
				<!--{@ GOODSBOX_LIST}-->
				{GOODSBOX_LIST.TRTD_START}
				<table>
					<tr><td align="center" style="word-break:break-all"><a href="{GOODSBOX_LIST.URL_LINK}">{GOODSBOX_LIST.PIC}</a><br>{GOODSBOX_LIST.ZOOM}</td></tr>
					<tr><td align="center"><a href="{GOODSBOX_LIST.URL_LINK}">{GOODSBOX_LIST.GNAME} {GOODSBOX_LIST.ICON_NEW} {GOODSBOX_LIST.ICON_COOL} {GOODSBOX_LIST.ICON_HOT} {GOODSBOX_LIST.ICON_OUT} {GOODSBOX_LIST.ICON_OUTSTOCK} {GOODSBOX_LIST.ICON_DISCOUNT} {GOODSBOX_LIST.ICON_POINT}</a></td></tr>
					<tr><td align="center">{GOODSBOX_LIST.PRICE_P_NUM}</td></tr>
					<tr><td align="center">{GOODSBOX_LIST.PRICE_R_NUM}</td></tr>
				</table>
				{GOODSBOX_LIST.TRTD_END}
				<!--{/}-->
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2">{GOODSBOX_BOTTOM}</td>
	</tr>
</table>

#T={GOODSBOX_NAME}
{GOODSBOX_NAME}
#T={GOODSBOX_MORE}
{GOODSBOX_MORE}
#T={URL_ICON}
{URL_ICON}
#T={BOARDBOX_MORE_URL}
{BOARDBOX_MORE_URL}
#T===링크================
==링크================
#T=로그아웃
<a href="?pgname=home/member_login&mode=PO">로그아웃<!-- <img src="{URL_ICON_HOME}topmenu02.gif" border="0" alt="Log in"> --></a>
#T=로그인
<a href="?pgname=home/member_login"><img src="{URL_ICON_HOME}topmenu02.gif" border="0" alt="Log in"></a>
#T=회원가입
<a href="?pgname=home/member_join"><img src="{URL_ICON_HOME}topmenu03.gif" border="0" alt="Log in"></a>

#T=아이디 패스워드 찾기
<a href="?pgname=home/member_search_idpw"><b>아이디 패스워드 찾기</b></a>
#T=MYPAGE
<a href="?pgname=home/member_main">MYPAGE<!-- <img src="{URL_ICON_HOME}topmenu03.gif" border="0" alt="Log in"> --></a>
#T=장바구니
<a href="?pgname=home/shop_cart"><font color="#FFFFFF"><b>장바구니</b></font></a>
#T=이용안내
<a href="?pgname=home/home_infosite"><font color="#555555">이용안내</font></a>
#T=고객센터
<a href="?pgname=home/home_customer"><font color="#555555">고객센터</font></a>
#T=주문조회
<a href="?pgname=home/shop_info_orderform"><font color="#FFFFFF"><b>주문조회</b></font></a>
#T=비교함
<a onclick="open('index_popup.php?pgname=home/shop_compare','compare','width=900,height=800,top=0,left=0,scrollbars=1')"><font color="#FFFFFF" style="cursor:hand"><b>비교함</b></font></a>
#T=질문답변게시판
<a href="?pgname=home/board&brcode=myqna">질문답변게시판</a>
#T=HOME
<a href="?pgname=home/main"><font color="#555555">HOME</font></a>
#T=<a href="{BOARDBOX_MORE_URL}">^!</a>
<a href="{BOARDBOX_MORE_URL}">^!</a>
#T===변수==========================
==변수==========================
#T={MEMBER_ID}
{MEMBER_ID}
#T={MEMBER_NAME}
{MEMBER_NAME}
#T={HTTPHOST_DIR}
{HTTPHOST_DIR}
#T={USER_DIR}
{USER_DIR}
#T={MEMBER_ID}
{MEMBER_ID}
#T===템플릿===================
==템플릿===================
#T={# TOP}
{# TOP}
#T={# TOP_LOGIN_FORM}
{# TOP_LOGIN_FORM}
#T={# SHOP_CATEGORY}
{# SHOP_CATEGORY}
#T={# COPY}
{# COPY}
#T={# MAIN_NOTICE}
{# MAIN_NOTICE}
#T={# BODY_SHOP_TODAYGOODS}
{# BODY_SHOP_TODAYGOODS}
#T={# MENU_GOODS}
{# MENU_GOODS}
#T=상품상세 - {# BODY_SHOP_GOODS}
						<!-- BODY CONTENTS -->
						{# BODY_SHOP_GOODS}

#T=쇼핑카트-{# BODY_SHOP_CART}
{# BODY_SHOP_CART}
#T===템플릿===================
==템플릿===================
#T={* MAIN_NEWGOODS}
{* MAIN_NEWGOODS}
#T={* MAIN_HITGOODS}
{* MAIN_HITGOODS}
#T={* MAIN_RECOMGOODS}
{* MAIN_RECOMGOODS}
#T===템플릿===================
==템플릿===================
#T={- MAIN_NEWS}
{- MAIN_NEWS}
#T={URL_ICON_HOME}
{URL_ICON_HOME}
#T={- MAIN_NOTICE}
{- MAIN_NOTICE}
#T===SOFTM 디파인 ===================
==SOFTM 디파인 ===================
#T={MAIN_IMAGE}
{MAIN_IMAGE}
#T={MENU_IMAGE}
{MENU_IMAGE}
#