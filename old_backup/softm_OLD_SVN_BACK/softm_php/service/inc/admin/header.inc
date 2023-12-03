<!DOCTYPE html>
<html lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
<title>개발-프레임.</title>
<link rel="stylesheet" type="text/css" href="<?=SERVICE_URL?>/css/admin.css" />
<script language="Javascript1.2" type="text/javascript" src="<?=SERVICE_URL?>/js/jquery-1.7.1.js"></script>
<script language="Javascript1.2" type="text/javascript" src="<?=SERVICE_URL?>/js/softm.jquery.js"></script>
<script language="Javascript1.2" type="text/javascript" src="<?=SERVICE_URL?>/js/softm.grid.js"></script>
<script language="Javascript1.2" type="text/javascript" src="<?=SERVICE_URL?>/js/json2.js"></script>
<script language="Javascript1.2" type="text/javascript" src="<?=SERVICE_URL?>/js/jquery.zclip.js"></script>
<script language="Javascript1.2" type="text/javascript" src="<?=SERVICE_URL?>/js/common.js"></script>
<script type="text/javascript">
<!--
var p_hash   = '<?=md5('rlawlgns' . date ("Y-m-d"))?>';
var LOGIN     = <?=LOGIN?"true":"false"?>;
var ADMIN     = <?=ADMIN?"true":"false"?>;
var USER_LEVEL= "<?=USER_LEVEL?>";
var USER_NO   = "<?=USER_NO?>";
var USER_ID   = "<?=USER_ID?>";
var COMPANY_NO= "<?=COMPANY_NO?>";
var SERVICE_BASE = "<?=SERVICE_BASE?>";
//-->
</script>
</HEAD>

<BODY>
	<dl class="skipNavi">
		<dt class="hidden">바로가기 메뉴</dt>
		<dd><a href="#content">본문 바로가기</a></dd>
		<dd><a href="#footer">하단 바로가기</a></dd>
	</dl>

	<!-- header -->
	<div class="header" id="header">
		<div class="header_inner">
			<h1><a href="<?=ADMIN_URL?>">관리자</a></h1>
			<h2>쉽게만들자~!</h2>
			<div class="login_area">
<!-- 				<a href="">Admin</a> -->
<!-- 				<a href="">Login</a> -->
				<?php 
				if ( LOGIN ) {
					echo "<a href='".LOGOUT_URL."'>Logout</a>";
				} else {
					echo "<a href='".ADMIN_URL."'>Login</a>";
				}
				?>
			</div>
		</div>
		<div id="gnb">
			<ul>
				<li><a href="admin_member.php">회원관리</a></li>
				<li><a href="admin_product.php">대중소관리</a>
					<div class="gnb_sub sub01">
						<ul>
							<li><a href="admin_product.php">대공종</a></li>
							<li><a href="admin_product.php?sub=procitcd">공종항목</a></li>
							<li><a href="admin_product.php?sub=procbdcd">공종항목내역</a></li>
						</ul>
					</div>
				</li>
				<li><a href="admin_reginfo.php">등록정보승인</a></li>
				<li><a href="admin_bbs.php">공지사항</a></li>
				<li><a href="admin_qna.php">질문과 답변</a></li>
			</ul>
		</div>
	</div>
	<!-- //header -->
