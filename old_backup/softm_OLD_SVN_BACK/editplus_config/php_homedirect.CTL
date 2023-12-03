#TITLE=php_homedirect
#INFO
New Cliptext library
#SORT=n

#T=<?=^!?>
<?=^!?>
#T=다음맵 <script>
<script type="text/javascript" src="http://apis.daum.net/maps/maps.js?apikey=3c77cb2018ef2aaad1df4046c86f41b7fc8e77ee" charset="utf-8"></script>

#T= value='<?=$rs[HEAD_TITLE]?>'
 value='<?=$rs[HEAD_TITLE]?>'
#T=eTwinkle
    var mObj = $('msg');
        cObj = $('user_id');
                mObj.innerHTML = "비밀 번호 입력을 확인해 주세요.";
                eTwinkle(cObj,mObj);
#T=<div class='textOf' style="width:210;" title='<?=$rs[ADDRESS1]?> <?=$rs[ADDRESS2]?>'><nobr><?=$rs[ADDRESS1]?> <?=$rs[ADDRESS2]?></nobr></div>
<div class='textOf' style="width:210;" title=''><nobr>^!</nobr></div>
#T=redirectPage($url,$replace=false)
redirectPage("admin_login.php",true);
#T=javascriptExec($str)
javascriptExec($str)
#T=rs 를 json형식으로
-------------- php --------------------------
            foreach ($rs as $k => $v) $result[] = json_encode($k).':'.json_encode($v);
            echo '{' . join(',', $result) . '}';

-------------- javascript --------------------
    var ajaxR = new asyncConnector('xmlhttp');
    var url  = '../service/gateway.php';
        url += '?p_hash=' + p_hash;

    if( p_user_id ) $('p_user_id').value  = p_user_id;

    ajaxR.openCallBack= function (str) {
        var r = ajaxR.responseText();

        if ( r ) {
            var d = JSON.parse(r);
            $('p_user_name').value  = d.USER_NAME   ;
            $('p_user_no').value    = d.USER_NO     ;
            $('p_user_level').value = d.USER_LEVEL  ;
        }
    }
        var bData = {service    : 'SESSION',
                     className  : 'common.Session',
                     method     : 'getUserInfo'     ,
                     argus      : {
                                p_user_id:p_user_id
                                }
                };
    loadSwf.showSwf();
    ajaxR.httpOpen('POST', url, false,encodeURIComponent(JSON.stringify(bData)));
    return false;

#T=echo 'sql : ' . $sql . ' /<BR>';
echo 'sql : ' . $sql . ' /<BR>';
#T=" UPDATE " . TB_PAYMENT . " SET"
    $errMsg = array();

    $sql  = " UPDATE " . TB_PAYMENT . " SET"
          . " CONFIRM_DATE = null,"
          . " STATE  = 'C'"
          . " WHERE PAY_NO IN(" . $inStr. ")";

    if ( !$db->simpleSQLExecute($sql) ) $errMsg[] = $db->getErrMsg();

    if ( sizeof($errMsg) == 0 ) {
        echo 'SUCCESS';
        $rtn = true;
    } else {
        echo 'ERROR|' . join($errMsg);
        $rtn = false;
    }
#T=$db             = $argus[db]?$argus[db]:null;
        $db             = $argus[db]?$argus[db]:null;
        if ( !$argus[db] ) {
            $db = new DB();
            $db->getConnect();
        }
        if ( !$argus[db] ) $db->release();

#