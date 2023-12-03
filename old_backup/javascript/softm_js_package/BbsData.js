<!--
    function Bbs_OnLoad () {
        if ( typeof ( document.SearchForm ) != "undefined" ) {
            bbsSearch_OnLoad(); /* 검색 OnLoad Event시 처리 */
            document.SearchForm.onsubmit = bbsSearch;
        }

        if ( typeof ( document.MainForm ) != "undefined" ) {
            document.MainForm.onsubmit = bbsWriteExecute;
            if ( p_mode == "insert" || p_mode == "update" || p_mode == "answer") {
                bbsSetItem1 ("document.bbsForm", "document.MainForm");
                if ( p_mode == "answer" ) {
                    var content  = "=============== 본문인용 ===============\n";
                        content += document.MainForm.Body.value;
                        content += "\n=============== ======== ===============\n";
                    setValue( document.MainForm.Body, content);
                }
            }
        }
//      document.SearchForm.action  = ls_target;
    }

    function bbsSetItem1 (frmObjStr, toObjStr) {
        var frmObj = eval ( frmObjStr );
        var toObj  = eval ( toObjStr  );
        if ( typeof ( frmObj ) != "undefined" ) {
            for ( var i=0; i<frmObj.length; i++ ) {
                var propNm  = frmObj.elements[i].name ;
                var propVal = frmObj.elements[i].value;
                if ( propVal != "#" ) {
//                  alert ( propNm + '/ ' + propVal );
                    copyElement (frmObjStr,propNm, toObjStr,propNm)
                }
            }
        }
    }

    function bbsSearch_OnLoad() {
        ObjectSelected ( document.SearchForm.p_search_gb, p_searchGb );
        setValue       ( document.SearchForm.p_search   , p_search );
    }

    function bbsSearch () {
        process    ( document.bbsForm       , "list");
        setObjectValue ( document.bbsForm.p_search    , document.SearchForm.p_search     );
        setObjectValue ( document.bbsForm.p_search_gb , document.SearchForm.p_search_gb  );
        submitForm ( document.bbsForm );
        return false;
    }

    /* 게시판 입력 페이지로 이동 합니다. */
    function bbsWrite() {
        if ( bbsWriteGrantCheck() ) {
            process    ( document.bbsForm       , "insert");
            setValue   ( document.bbsForm.p_seq , ""      );
            submitForm ( document.bbsForm       , "");
        }
    }
    /* 게시판 답변 페이지로 이동 합니다. */
    function bbsAnswer() {
        if ( bbsAnswerGrantCheck() ) {
            process    ( document.bbsForm       , "answer");
    //      setValue   ( document.bbsForm.p_seq , ""      );
            submitForm ( document.bbsForm       , "");
        }
    }

    /* 게시판 수정 페이지로 이동 합니다. */
    function bbsUpdate() {
        process    ( document.bbsForm       , "update");
        if ( bbsUpdateGrantCheck() ) {/*  성공시 로그인 하면서 작성자인사람. */
            setValue ( document.bbsForm.User_Id, writeId  );
    //      setValue   ( document.bbsForm.p_seq , ""      );
            submitForm ( document.bbsForm       , ""      );
        }
    }

    /* 게시판 자료 삭제 처리 */
    function bbsDelete() {
        process    ( document.bbsForm       , "delete");
        setValue (document.bbsForm.p_back_url, selfPage);
        setValue (document.bbsForm.G_Seq     , gSeq    );
        setValue (document.bbsForm.O_Seq     , oSeq    );
        setValue (document.bbsForm.Depth     , depth   );
        var url = homeUrl + "/jsp/newuser/bbs/U_BbsDataWrite_P.jsp";
            document.bbsForm.action = url;
        if ( bbsDeleteGrantCheck() ) {/*  성공시 로그인 하면서 작성자인사람. */
            setValue ( document.bbsForm.User_Id, writeId  );
            submitForm ( document.bbsForm       , url       );
        }
    }

    /* 게시판 상세 페이지로 이동 합니다. */
    function bbsDetail( Seq, mainMenuCd, subMenuCd ) {
        if ( bbsDetailGrantCheck() ) {
            process    ( document.bbsForm       , "increase");
            setValue (document.bbsForm.p_back_url, selfPage);
            setValue   ( document.bbsForm.p_seq , Seq       );
            if ( typeof (mainMenuCd) != "undefined" ) {
                setValue   ( document.bbsForm.p_main_menu_cd, mainMenuCd);
            }
            if ( typeof (mainMenuCd) != "undefined" ) {
                setValue   ( document.bbsForm.p_sub_menu_cd, subMenuCd);
            }

            var url = homeUrl + "/jsp/newuser/bbs/U_BbsDataWrite_P.jsp";
            submitForm ( document.bbsForm       , url       );
        }
    }

    /* 게시판 목록 페이지로 이동 합니다. */
    function bbsList() {
        setValue   ( document.bbsForm.p_mode, "list");
        setValue   ( document.bbsForm.p_seq , ""      );
        submitForm ( document.bbsForm, "");
    }

    var submitYN = "N";
    function bbsWriteExecute(){
        if ( bbsFormCheck() ) {
            var url = homeUrl + "/jsp/newuser/bbs/U_BbsDataWrite_P.jsp";
            document.bbsForm.action = url;
            if ( typeof ( document.MainForm.Passwd) == 'object' ) {
                submitForm ( document.bbsForm, url);
            } else {/* 입력시 Passwd영역이 스킨에존재 하지 않을경우의 처리 */
                bbsDisplayPasswdBox();
            }
        }
        return false;
    }

    function bbsDisplayPasswdBox() { /* 패스워드 상자 보이기 */
        var obj = getObject( "divPassword" );
            objectMoveTo(obj, getMouseXPos(), getMouseYPos());
            objectShow  (obj      );
            setFocus(document.passwdForm.Passwd);
    }

    function bbsPasswordInput () { /* 비밀번호 입력 상자에서 실행 버튼 클릭시 실행 */
        var strPasswd = getValue(document.passwdForm.Passwd);
        if ( strPasswd == '' ) {
            alert ( '비밀번호를 입력해 주세요.' ); setFocus (document.passwdForm.Passwd); return ;
        }
        if ( !StringEmptyCheck ( strPasswd ) ) {
            alert ( '비밀번호에 공백을 사용할 수 없습니다.' ); setFocus (document.passwdForm.Passwd); return ;
        }
        setValue ( document.bbsForm.Passwd , document.passwdForm.Passwd.value );
        setValue ( document.bbsForm.User_Id, writeId                          );
//      alert ( "bbsForm.submit()");
        submitForm ( document.bbsForm );

    }

    /* 입력, 수정, 답변시 입력 값 검사 */
    function bbsFormCheck() { // 'I' : 입력 , 'A' : 답변
        if ( submitYN == 'Y' ) { return false; }

        if ( typeof ( document.MainForm ) == 'undefined' ) {
            return false;
        } else if ( typeof ( document.MainForm ) == 'object' ) {
            /* 이름  */
            if ( typeof(document.MainForm.Nm) == 'object' ) {
                var strNm = getValue( document.MainForm.Nm);
                if( !StringInputCheck( strNm ) ) {
                    alert ('이름을 다시 입력하세요'); setFocus (document.MainForm.Nm); return false;
                }
                setValue (document.bbsForm.Nm,strNm);
            }

            /* Email */
            if ( typeof(document.MainForm.E_Mail) == 'object' ) {
                var strEMail = getValue( document.MainForm.E_Mail);
                if( strEMail != '' && !IsEmail( strEMail ) ) {
                    alert ('Email주소를 다시 입력하세요'); setFocus (document.MainForm.E_Mail); return false;
                }
                setValue  (document.bbsForm.E_Mail,strEMail);
            }

            /* 제목  */
            if ( typeof(document.MainForm.Title) == 'object' ) {
                var strTitle = getValue( document.MainForm.Title);
                if( !StringInputCheck( strTitle ) || strTitle   == '' ) {
                    alert ('제목을 다시 입력하세요'); setFocus (document.MainForm.Title); return false;
                }
                setValue  (document.bbsForm.Title,strTitle);
            }

            // Password 입력 설정
            // 게시판이 패스워드 사용으로 설정되어있고 비회원일 경우
            // 비회원에대한 비밀번호 입력 요구를 위해.
            if ( typeof(document.MainForm.Passwd ) == 'object') {
                var strPasswd = getValue(document.MainForm.Passwd);
                if ( strPasswd == '' ) {
                    alert ( '비밀번호를 입력해 주세요.' ); setFocus (document.MainForm.Passwd); return false;
                }
                if ( !StringEmptyCheck ( strPasswd ) ) {
                    alert ( '비밀번호에 공백을 사용할 수 없습니다.' ); setFocus (document.MainForm.Passwd); return false;
                }
                setValue  (document.bbsForm.Passwd,strPasswd);
            }

            /* 내용  */
            if ( typeof(document.MainForm.Body ) == 'object') {
                var strBody = getValue(document.MainForm.Body);
                if( Trim(strBody) == '' ) {
                    alert ('내용을 다시 입력하세요'); setFocus (document.MainForm.Body); return false;
                }
                setValue  (document.bbsForm.Body,strBody);
            }

            /* 홈페이지 */
            if ( typeof(document.MainForm.Home) == 'object' ) {
                var strHome = getValue(document.MainForm.Home);
                if(  strHome != '' && !StringEmptyCheck(strHome) ) {
                    alert ('홈 주소를 올바르게 입력해 주세요'); setFocus (document.MainForm.Home); return false;
                }
                setValue  (document.bbsForm.Home,strHome);
            }
        }
        setValue (document.bbsForm.p_back_url, selfPage);
        bbsSetItem1 ("document.MainForm", "document.bbsForm");
//      alert ( 'bbsFormCheck 성공' );
        submitYN = 'Y';
        return true;
    }

/*===================================== 권한 관련 ================================*/
    function bbsGradeGrantCheck() { /* 등급 권한 */
        if ( grantM < 100 ) { alert ( msgGrantM ); return false; }
        return true;
    }

    function bbsDetailGrantCheck() { /* 보기 권한 */
        if ( grantV < 100 ) { alert ( msgGrantV ); return false; }
        return true;
    }

    function bbsWriteGrantCheck() { /* 입력 권한 */
        if ( grantI < 100 ) { alert ( msgGrantI ); return false; }
        return true;
    }

    function bbsUpdateGrantCheck() { /* 수정 권한 */
        if ( grantU < 100 ) { alert ( msgGrantU ); return false; }
//      alert ( p_userId + " / " + writeId ) ;
        if ( writeId == "guest") { 
//          alert ( "수정 비밀번호 입력창 출력..." );
            bbsDisplayPasswdBox();
            return false;
        }
        if ( p_userId != writeId ) { alert ( "작성자만이 수정이 가능합니다." ); return false; }
        return true;
    }


    function bbsDeleteGrantCheck() { /* 삭제 권한 */
        if ( grantD < 100 ) { alert ( msgGrantD ); return false; }
//        alert ( p_userId + " / " + writeId ) ;
        if ( writeId == "guest") { 
//          alert ( "삭제 비밀번호 입력창 출력..." );
            bbsDisplayPasswdBox();
            return false;
        }
        if ( p_userId != writeId ) { alert ( "작성자만이 삭제가 가능합니다." ); return false; }
        return true;
    }

    function bbsAnswerGrantCheck() { /* 답변 권한 */
        if ( grantA < 100 ) { alert ( msgGrantA ); return false; }
        else {
            if ( parseInt ( depth ) >= parseInt ( limitDepth ) ) {
                alert ( limitDepth + " 레벨 이상 답변이 제한 되었습니다." );
                return false;
            }
        }
        return true;
    }
//-->