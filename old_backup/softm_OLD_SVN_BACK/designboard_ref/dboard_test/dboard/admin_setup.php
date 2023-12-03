<?
define("DBOARD_PAGE_DIRECT_ACCESS",$_SERVER["SCRIPT_FILENAME"] == str_replace("\\", "/", __FILE__));
include ( "common/lib.inc"          ); // 공통 라이브러리
include ( "common/message.inc"      ); // 에러 페이지 처리

$memInfor = getMemInfor(); // 세션에 저장되어있는 회원정보를 읽음
head("관리자 설정 페이지");        // Header 출력
css ($skinDir); // css 설정

if ( !$config ) {
    MessageExit('P', '0002', 'MOVE:setup.php:이동');
}

if ( $memInfor['admin_yn'] == "N" ) {
    MessageExit('U', '0003', 'MOVE:admin.php:이동');
} else {
?>
<!--
-->
<?
include 'common/js/common_js.php'; // 공통 javascript
body('class="jui"');
    include 'common/rest/get_site_info.inc'; // 사이트 정보 얻기. from designboard
//     echo PATCH_VERSION . " / " . MIG_VERSION;
?>
<!-- <a id="btn1" class="btn btn-large btn-purple">Large button</a> -->
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
  <tr>
    <td valign="top" height="122">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="70">
<?
    include ( 'admin_top.php' ); // 상단 메뉴
?>
          </td>
        </tr>
        <tr>
          <td height="1" bgcolor="003A43"></td>
        </tr>
        <tr>
          <td height="40" bgcolor="015966"></td>
        </tr>
        <tr>
          <td height="1" bgcolor="003A43"></td>
        </tr>
        <tr>
          <td height="10"></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td valign="top" class="unnamed1">
      <table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
        <tr>
          <td width="200" bgcolor="F5F5F5" valign="top">
<?
    include ( 'admin_left_menu.php'          ); // 왼쪽 메뉴
?>
          </td>
          <td bgcolor="FAFAFA" valign="top">


            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="854">
                  <table width="100%" border="0" cellspacing="1" cellpadding="2" bgcolor="CCCCCC" class="text_01">
                    <tr bgcolor="#FFFFFF">
                      <td colspan="4" height="40" bgcolor="#FFFFFF" valign="top">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="text_01">
                          <tr>
                            <td rowspan="3" width="30">&nbsp;</td>
                            <td height="30">&nbsp;</td>
                            <td rowspan="3" width="30">&nbsp;</td>
                          </tr>
                          <tr>
                            <td class="text_01">
<?php
include 'common/rest/set_admin_access_info.inc';
include 'common/patch/dboard_patch.inc';
if ( $patch_msg ) {
?>
      <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="cccccc" class="text_01">
		<colgroup>
		<col width="100">
		<col width="">
		<col width="80">
		</colgroup>
        <tr>
          <td align="right" bgcolor="efefef"><strong>업데이트 내용&nbsp;</strong></td>
          <td bgcolor="fafafa"><font color="990000"><span id='msg'>
          <?=$patch_title?>
          </span></font></td>
          <td bgcolor="fafafa" align="center">
          <button onclick="document.location.reload();">닫기</button>
          </td>
        </tr>
        <tr>
          <td align="right" bgcolor="efefef" colspan="3">
          <textarea style="width:100%;height:50px;overflow:scroll;overflow-x:hidden;"><?=$patch_msg?></textarea>
          </td>
        </tr>
      </table>
<?
} else {
// 패치가 완료되면
// 마이그레이션 화면을 보여준다.
// 마이그레이션은 아직 미구현이며
// patch/dboard_migration.php을 단계별로 ajax를 이용해서 호출하고,
// 프로그래스바를 통해 진행율을 보여주는 형태로작업할 계획이다.
?>
	<?php
	if ( IS_DB_SCHEMA_UPDATE ) {
	?>
<SCRIPT type="text/javascript">
<!--
    function fCallSyncDB(){
        url = "";
        $.ajax (
        {
            async:false,
            url:url,
            type: "POST",
            dataType:'json',
            data:{
                param1:"param1",
                param2:"param2"
            }
        }).done(
            function(data) {
                //console.debug(data);
                $("#txt_result").get(0).value = " data.key1 : " + data.key1
                                              + "\n" + " data.key2 : " + data.key2
                                              + "\n" + " data.key3 : " + data.key3
                ;
                //console.debug("data", data);
            }
        );
    }

	function progress(gubun, totProgCnt, curCnt ) {

    var proVal   = parseInt(( totProgCnt / parseInt(total) ) * 100);
        percentObj.innerHTML   = Math.round(parseFloat(proVal),-2) + '%';
        if ( proVal > 0 ) {
            progressObj.width      = proVal + '%';
        }

        if ( gubun == 'board' ) {
            getObject('board_insert_total'          ).innerHTML = curCnt; // 게시글
        }

        if ( gubun == 'category' ) {
            getObject('category_insert_total'       ).innerHTML = curCnt; // 카테고리
        }

        if ( gubun == 'comment' ) {
            getObject('comment_insert_total'        ).innerHTML = curCnt; // 의견글
        }

        if ( gubun == 'grant' ) {
            getObject('grant_insert_total'          ).innerHTML = curCnt; // 권한
        }

        if ( gubun == 'member' ) {
            getObject('member_insert_total'         ).innerHTML = curCnt; // 회원
        }

        if ( gubun == 'member_kind' ) {
            getObject('member_kind_insert_total'    ).innerHTML = curCnt; // 회원 종류
        }

        getObject('all_kind_insert_total').innerHTML = totProgCnt   ; // 전체

//      dataPannelDocument.write ( proVal +'<BR>');
//      send_message.innerHTML   = '총 <span class="text_04">' + saveArea.totCnt + '</span>명중 <span class="text_04">' + ( saveArea.curIdx ) + '</span>명 의 회원께 발송중입니다.';
}
    jui.ready(function(ui, uix, _) {
    	$("#btnConfirm").click(function(e){
    	});

    	$("#cal1").click(function(e){
    		$("#datepicker1").show();
    		var position = $(this).position();
    		$("#datepicker1").css("top",(position.top)+$(this).height()+3);
    		$("#datepicker1").css("left",(position.left));
    	});
    });
//-->
</SCRIPT>
<!--

	      <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="cccccc" class="text_01">
			<colgroup>
			<col width="100">
			<col width="">
			<col width="80">
			</colgroup>
	        <tr>
	          <td align="right" bgcolor="efefef"><strong>업데이트내용&nbsp;</strong></td>
	          <td bgcolor="fafafa"><font color="990000"><span id='msg'>디비구조를 최신화합니다.
	          </span></font></td>
	          <td bgcolor="fafafa" align="center">
	          <button class="btn btn-gray" type="button" id="btnConfirm">확인</button>
	          </td>
	        </tr>
	        <tr>
	          <td align="right" bgcolor="efefef" colspan="3">
	          <textarea style="width:100%;height:100px;overflow:scroll;overflow-x:hidden;"><?=$patch_msg?></textarea>
	          </td>
	        </tr>
            <tr>
              <td align="right" bgcolor="efefef"><strong>진행상황&nbsp;</strong></td>
              <td bgcolor="#fafafa" colspan="2" valign="middle" style="vertical-align: middle;padding-top: 20px">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="100%">
                      <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="828282">
                        <tr>
                          <td height="20" id='progress' width="" bgcolor="990000"></td>
                          <td bgcolor="#FFFFFF" width='1'></td>
                        </tr>
                      </table></td>
                    <td width="10">&nbsp;</td>
                    <td class="text_01"><font color="990000">
    <span id='percent'></span>
                    </font></td>
                  </tr>
                </table>
			 </td>
            </tr>
	      </table>
 -->
	<?
	}
	?>
<?
}
?>
<!--       <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="cccccc" class="text_01"> -->
<!-- 		<colgroup> -->
<!-- 		<col width="100"> -->
<!-- 		</colgroup>       -->
<!--         <tr> -->
<!--           <td align="right" bgcolor="efefef"><strong>업데이트 내용&nbsp;</strong></td> -->
<!--           <td bgcolor="fafafa"><font color="990000"><span id='msg'>상태표시를 나타내는 부분입니다.</span></font></td> -->
<!--         </tr> -->
<!--         <tr> -->
<!--           <td align="right" bgcolor="efefef" colspan="2"> -->
<!--           </td> -->
<!--         </tr> -->
<!--         <tr> -->
<!--           <td align="right" bgcolor="efefef"><strong>진행상황&nbsp;</strong></td> -->
<!--           <td bgcolor="fafafa"> -->
<!--             <table width="100%" border="0" cellspacing="0" cellpadding="0"> -->
<!--               <tr> -->
<!--                 <td width="100%"> -->
<!--                   <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="828282"> -->
<!--                     <tr> -->
<!--                       <td height="20" id='progress' width="" bgcolor="990000"></td> -->
<!--                       <td bgcolor="#FFFFFF" width='1'></td> -->
<!--                     </tr> -->
<!--                   </table></td> -->
<!--                 <td width="10">&nbsp;</td> -->
<!--                 <td class="text_01"><font color="990000"> -->
<!-- <span id='percent'></span> -->
<!--                 </font></td> -->
<!--               </tr> -->
<!--             </table> -->
<!--             </td> -->
<!--         </tr> -->
<!--       </table>     -->
<br/>
                              <table width="100%" border="0" cellspacing="1" cellpadding="10" bgcolor="cccccc" class="text_01">
                                <tr>
                                  <td bgcolor="fafafa" class="text_01"><b><font color="015966">디자인보드
                                    버전
<?
    $version = explode ( ' ', $_dboard_ver  );
    echo  $version[1];
?>
                                    관리자화면 입니다.</font></b><br>
                                    <br>
                                    디자인보드를 사용해 주셔서 감사합니다.<br>
                                    디자인보드는 PHP언어로 만들어졌으며 mySQL DB에서 돌아가는 무료로 배포하는공개형
                                    게시판 프로그램 입니다.<br>
                                    디자인보드는 게시판, 회원관리, 설문조사, 메일링리스트, 멀티추출을 편리하게
                                    관리하고 사용할수 있으며 앞으로 다양한 기능과 이쁜디자인의 스킨들을 계속 추가할
                                    예정입니다. <br>
                                    또한 ASP버전과 JSP버전 개발과 모든 DB를 지원 가능하게 하자는 예정이지만
                                    단기간에 쉽게 되리라고 생각하지는 않습니다.<br>
                                    디자인보드에 잘못된 부분이 원하시는 기능이 또는 궁금한점 있으시면 <a href="http://www.Designboard.net" target="_blank"><font color="015966">www.Designboard.net</font></a>
                                    통해 기탄없이 말씀해 주십시요. ^_^<br>
                                    많이 부족한점 꾸준히 매꾸어 가겠습니다.<br>
                                    디자인보드가 열분들의 홈페이지를 만드시는데 조금이나마 도움이 되었으면 좋겠습니다.<br>
                                    다시한번 디자인보드를 사용해 주셔서 감사드리며 이만 물러갑니다... (--)
                                    (__) (--) 꾸벅~</td>
                                </tr>
                              </table>
                              <br>
                              <br>
                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td bgcolor="F2F2F2" height="1"></td>
                                </tr>
                              </table>
                              <br>
                              <p><b>1. 저작권</b> <br>
                              <table width="100%" border="0" cellspacing="0" cellpadding="0" class="text_01">
                                <tr>
                                  <td valign="top" colspan="2" height="8"></td>
                                </tr>
                                <tr>
                                  <td valign="top" width="10">-</td>
                                  <td>디자인보드는 무료공개 소프트웨어로서 개인은 누구나 제한없이 사용가능하며
                                    프로그램과 관련된 설명서들에 대한 모든 저작권 및 지적 소유권은 디자인보드에게
                                    있습니다. 단, 스킨 저작권은 스킨 제작자에게 있습니다.</td>
                                </tr>
                                <tr>
                                  <td valign="top" width="10">-</td>
                                  <td>디자인보드는 디자인보드에 대해 유지보수의 책임을 지지 않습니다.</td>
                                </tr>
                                <tr>
                                  <td valign="top" width="10">- </td>
                                  <td>본 프로그램 사용중 관리소홀로 인한 데이타의 유실및 기타 손해에 대해 어떠한
                                    책임도 지지 않습니다.</td>
                                </tr>
                                <tr>
                                  <td valign="top" width="10">-</td>
                                  <td>디자인보드는 소프트웨어는 저작권법과 컴퓨터 프로그램 보호법에 의해 보호되고
                                    있습니다. </td>
                                </tr>
                                <tr>
                                  <td valign="top" width="10">-</td>
                                  <td>디자인보드 프로그램 코드의 변경은 프로그램 저작권법 위반으로 기소 사유가
                                    됩니다. </td>
                                </tr>
                              </table>
                              <br>
                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td bgcolor="eeeeee" height="1"></td>
                                </tr>
                              </table>
                              <b><br>
                              2. 배포 및 재배포</b><br>
                              <table width="100%" border="0" cellspacing="0" cellpadding="0" class="text_01">
                                <tr>
                                  <td valign="top" colspan="2" height="8"></td>
                                </tr>
                                <tr>
                                  <td valign="top" width="10">-</td>
                                  <td>디자인보드의 배포는 Designboard.net 에서 이루어지며 수정배포가
                                    아니라면 재배포할 수 있습니다.</td>
                                </tr>
                                <tr>
                                  <td valign="top" width="10">-</td>
                                  <td>변형 및 가공된 디자인보드의 재배포는 Designboard.net 의 동의를
                                    얻어야 하며 Designboard.net 에서만 배포가능합니다.</td>
                                </tr>
                                <tr>
                                  <td valign="top" width="10">-</td>
                                  <td>디자인보드에서 제작한 스킨 이외의 스킨은 해당 스킨제작자에게 저작권이 있으므로
                                    해당 스킨의 재배포는 스킨제작자의 동의없이 재배포 할수 없습니다. </td>
                                </tr>
                              </table>
                              <br>
                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td bgcolor="eeeeee" height="1"></td>
                                </tr>
                              </table>
                              <br>
                              <b>3. 카피라이트 표시여부</b><br>
                              <br>
                              1) 게시판 하단의 외부 카피라이트 코드 <br>
                              <table width="100%" border="0" cellspacing="0" cellpadding="0" class="text_01">
                                <tr>
                                  <td valign="top" colspan="2" height="8"></td>
                                </tr>
                                <tr>
                                  <td valign="top" width="10">-</td>
                                  <td>삭제여부는 자유입니다. 단, 회사나 영리목적의 사이트는 삭제 하실수 없습니다.
                                  </td>
                                </tr>
                                <tr>
                                  <td valign="top" width="10">-</td>
                                  <td>단 디자인보드에서 기본으로 제공하는 스킨은 괜찮으나 다른 스킨은 스킨제작자에게
                                    저작권이 있으므로 스킨제작자의 동의 없이는 스킨제작자 명시부분을 삭제하실수
                                    없습니다.</td>
                                </tr>
                                <tr>
                                  <td valign="top" width="10">-</td>
                                  <td>copyright Designboard / skin Designboard </td>
                                </tr>
                              </table>
                              <br>
                              2) HTML 쏘스내부 카피라이트 코드는삭제 하실수 없습니다. 삭제를 원하시면 정식구입
                              절차를 통해 삭제 하실 수 있습니다. <br>
                              <table width="100%" border="0" cellspacing="0" cellpadding="0" class="text_01">
                                <tr>
                                  <td valign="top" colspan="2" height="8"></td>
                                </tr>
                                <tr>
                                  <td valign="top" width="10">-</td>
                                  <td>PROGRAM NAME : Designboard (디자인보드)</td>
                                </tr>
                                <tr>
                                  <td valign="top" width="10">-</td>
                                  <td>VERSION : <?=$version[1]?> (<?=$_dboard_update_date?>)</td>
                                </tr>
                                <tr>
                                  <td valign="top" width="10">-</td>
                                  <td>DEVELOPER : Designboard</td>
                                </tr>
                                <tr>
                                  <td valign="top" width="10">-</td>
                                  <td>운영자: 김지훈</td>
                                </tr>
                                <tr>
                                  <td valign="top" width="10">-</td>
                                  <td>HOMEPAGE : <a href="http://www.Designboard.net" target="_blank"><font color="015966">www.Designboard.net</font></a></td>
                                </tr>
                                <tr>
                                  <td valign="top" width="10">&nbsp;</td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td valign="top" width="10">&nbsp;</td>
                                  <td>copyright Designboard all rights reserved.<br>
                                    본 디자인보드에 관한 정보 및 최신버젼은 홈페이지(Designboard.net)에서
                                    확인하실 수 있습니다.</td>
                                </tr>
                              </table>
                              <br>
                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td bgcolor="eeeeee" height="1"></td>
                                </tr>
                              </table>
                              <b><br>
                              4. 정식구입 (HTML쏘스 내부카피라이터 삭제비용)</b><br>
                              <table width="100%" border="0" cellspacing="0" cellpadding="0" class="text_01">
                                <tr>
                                  <td valign="top" colspan="2" height="8"></td>
                                </tr>
                                <tr>
                                  <td valign="top" width="10">-</td>
                                  <td>디자인보는 무료로 배포되는 프로그램으로 무료로 사용하실수 있습니다. 개인이나
                                    비영리 목적인경우 외부카피라이터 삭제가 자유로와 디자인을 해칠 우려가 없으니
                                    되도록 그냥 사용하시기를 권유합니다.</td>
                                </tr>
                                <tr>
                                  <td valign="top" width="10">-</td>
                                  <td>하지만 회사나 영리 목적인 경우나 HTML쏘스 내부카피라이터도 꼭 지우시고
                                    싶으신 분들은 정식 구입하시기 바랍니다. <br>
                                    정식 구입신청 : <a href="mailto:order@Designboard.net">order@Designboard.net</a><BR><BR></td>
                                </tr>

                                <tr>
                                  <td valign="top" width="10">-</td>
                                  <td>
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="text_01">
                                      <tr>
                                        <td>※ 정식구입비 - 1개의 라이센스 정식구입은 1개의 사이트에만 해당합니다.</td>
                                        <td align="right">(부가세별도)</td>
                                      </tr>
                                      <tr>
                                        <td colspan="2" height="10"></td>
                                      </tr>
                                    </table>
                                    <table width="100%" border="0" cellspacing="1" cellpadding="4" bgcolor="cccccc" class="text_01">
                                      <tr align="center">
                                        <td bgcolor="eeeeee" width="25%"><b>순수 개인홈페이지</b></td>
                                        <td bgcolor="eeeeee" width="25%"><b>비법인,비영리단체</b></td>
                                        <td bgcolor="eeeeee" width="25%"><b>영리, 개인사업자</b></td>
                                        <td bgcolor="eeeeee" width="25%"><b>법인단체, 법인회사</b></td>
                                      </tr>
                                      <tr align="center">
                                        <td bgcolor="#FFFFFF">1만원</td>
                                        <td bgcolor="#FFFFFF">2만원</td>
                                        <td bgcolor="#FFFFFF">3만원</td>
                                        <td bgcolor="#FFFFFF">5만원</td>
                                      </tr>
                                    </table>
                                    <br>
<pre>
<B>은   행: 기업은행 | 계   좌: 070-037500-02-015 | 예금주: 김지훈</B>
</pre>
                                    ※ 정식 구입하실때 등록된 도메인에 한하며 도메인이 바뀌게 되면 재등록 하시면 됩니다. <br>
                                    <br>
                                  </td>
                                </tr>
                                <tr>
                                  <td valign="top" width="10">-</td>
                                  <td>정식구입비는 디자인보드의 지속적인 업그래이드에 사용될 커피값 및 야참 비용으로
                                    사용 하겠습니다. -_-;;</td>
                                </tr>
                                <tr>
                                  <td valign="top" width="10">-</td>
                                  <td>디자인보드에 잘못된 부분이 원하시는 기능이 있으면 기탄없이 말씀해 주십시요.
                                    최대한 반영되도록 노력하겠습니다.</td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                          <tr>
                            <td height="50">&nbsp;</td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                  <table border="0" cellspacing="0" cellpadding="0" height="100%">
                    <tr>
                      <td bgcolor="CCCCCC" width="1"></td>
                    </tr>
                  </table>
                </td>
                <td valign="top">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
                    <tr>
                      <td bgcolor="CCCCCC" height="1"></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<?
    footer(); // Footer 출력
}// else END
?>
