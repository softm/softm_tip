<!--
    function Bbs_OnLoad () {
        if ( typeof ( document.SearchForm ) != "undefined" ) {
            bbsSearch_OnLoad(); /* �˻� OnLoad Event�� ó�� */
            document.SearchForm.onsubmit = bbsSearch;
        }

        if ( typeof ( document.MainForm ) != "undefined" ) {
            document.MainForm.onsubmit = bbsWriteExecute;
            if ( p_mode == "insert" || p_mode == "update" || p_mode == "answer") {
                bbsSetItem1 ("document.bbsForm", "document.MainForm");
                if ( p_mode == "answer" ) {
                    var content  = "=============== �����ο� ===============\n";
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

    /* �Խ��� �Է� �������� �̵� �մϴ�. */
    function bbsWrite() {
        if ( bbsWriteGrantCheck() ) {
            process    ( document.bbsForm       , "insert");
            setValue   ( document.bbsForm.p_seq , ""      );
            submitForm ( document.bbsForm       , "");
        }
    }
    /* �Խ��� �亯 �������� �̵� �մϴ�. */
    function bbsAnswer() {
        if ( bbsAnswerGrantCheck() ) {
            process    ( document.bbsForm       , "answer");
    //      setValue   ( document.bbsForm.p_seq , ""      );
            submitForm ( document.bbsForm       , "");
        }
    }

    /* �Խ��� ���� �������� �̵� �մϴ�. */
    function bbsUpdate() {
        process    ( document.bbsForm       , "update");
        if ( bbsUpdateGrantCheck() ) {/*  ������ �α��� �ϸ鼭 �ۼ����λ��. */
            setValue ( document.bbsForm.User_Id, writeId  );
    //      setValue   ( document.bbsForm.p_seq , ""      );
            submitForm ( document.bbsForm       , ""      );
        }
    }

    /* �Խ��� �ڷ� ���� ó�� */
    function bbsDelete() {
        process    ( document.bbsForm       , "delete");
        setValue (document.bbsForm.p_back_url, selfPage);
        setValue (document.bbsForm.G_Seq     , gSeq    );
        setValue (document.bbsForm.O_Seq     , oSeq    );
        setValue (document.bbsForm.Depth     , depth   );
        var url = homeUrl + "/jsp/newuser/bbs/U_BbsDataWrite_P.jsp";
            document.bbsForm.action = url;
        if ( bbsDeleteGrantCheck() ) {/*  ������ �α��� �ϸ鼭 �ۼ����λ��. */
            setValue ( document.bbsForm.User_Id, writeId  );
            submitForm ( document.bbsForm       , url       );
        }
    }

    /* �Խ��� �� �������� �̵� �մϴ�. */
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

    /* �Խ��� ��� �������� �̵� �մϴ�. */
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
            } else {/* �Է½� Passwd������ ��Ų������ ���� ��������� ó�� */
                bbsDisplayPasswdBox();
            }
        }
        return false;
    }

    function bbsDisplayPasswdBox() { /* �н����� ���� ���̱� */
        var obj = getObject( "divPassword" );
            objectMoveTo(obj, getMouseXPos(), getMouseYPos());
            objectShow  (obj      );
            setFocus(document.passwdForm.Passwd);
    }

    function bbsPasswordInput () { /* ��й�ȣ �Է� ���ڿ��� ���� ��ư Ŭ���� ���� */
        var strPasswd = getValue(document.passwdForm.Passwd);
        if ( strPasswd == '' ) {
            alert ( '��й�ȣ�� �Է��� �ּ���.' ); setFocus (document.passwdForm.Passwd); return ;
        }
        if ( !StringEmptyCheck ( strPasswd ) ) {
            alert ( '��й�ȣ�� ������ ����� �� �����ϴ�.' ); setFocus (document.passwdForm.Passwd); return ;
        }
        setValue ( document.bbsForm.Passwd , document.passwdForm.Passwd.value );
        setValue ( document.bbsForm.User_Id, writeId                          );
//      alert ( "bbsForm.submit()");
        submitForm ( document.bbsForm );

    }

    /* �Է�, ����, �亯�� �Է� �� �˻� */
    function bbsFormCheck() { // 'I' : �Է� , 'A' : �亯
        if ( submitYN == 'Y' ) { return false; }

        if ( typeof ( document.MainForm ) == 'undefined' ) {
            return false;
        } else if ( typeof ( document.MainForm ) == 'object' ) {
            /* �̸�  */
            if ( typeof(document.MainForm.Nm) == 'object' ) {
                var strNm = getValue( document.MainForm.Nm);
                if( !StringInputCheck( strNm ) ) {
                    alert ('�̸��� �ٽ� �Է��ϼ���'); setFocus (document.MainForm.Nm); return false;
                }
                setValue (document.bbsForm.Nm,strNm);
            }

            /* Email */
            if ( typeof(document.MainForm.E_Mail) == 'object' ) {
                var strEMail = getValue( document.MainForm.E_Mail);
                if( strEMail != '' && !IsEmail( strEMail ) ) {
                    alert ('Email�ּҸ� �ٽ� �Է��ϼ���'); setFocus (document.MainForm.E_Mail); return false;
                }
                setValue  (document.bbsForm.E_Mail,strEMail);
            }

            /* ����  */
            if ( typeof(document.MainForm.Title) == 'object' ) {
                var strTitle = getValue( document.MainForm.Title);
                if( !StringInputCheck( strTitle ) || strTitle   == '' ) {
                    alert ('������ �ٽ� �Է��ϼ���'); setFocus (document.MainForm.Title); return false;
                }
                setValue  (document.bbsForm.Title,strTitle);
            }

            // Password �Է� ����
            // �Խ����� �н����� ������� �����Ǿ��ְ� ��ȸ���� ���
            // ��ȸ�������� ��й�ȣ �Է� �䱸�� ����.
            if ( typeof(document.MainForm.Passwd ) == 'object') {
                var strPasswd = getValue(document.MainForm.Passwd);
                if ( strPasswd == '' ) {
                    alert ( '��й�ȣ�� �Է��� �ּ���.' ); setFocus (document.MainForm.Passwd); return false;
                }
                if ( !StringEmptyCheck ( strPasswd ) ) {
                    alert ( '��й�ȣ�� ������ ����� �� �����ϴ�.' ); setFocus (document.MainForm.Passwd); return false;
                }
                setValue  (document.bbsForm.Passwd,strPasswd);
            }

            /* ����  */
            if ( typeof(document.MainForm.Body ) == 'object') {
                var strBody = getValue(document.MainForm.Body);
                if( Trim(strBody) == '' ) {
                    alert ('������ �ٽ� �Է��ϼ���'); setFocus (document.MainForm.Body); return false;
                }
                setValue  (document.bbsForm.Body,strBody);
            }

            /* Ȩ������ */
            if ( typeof(document.MainForm.Home) == 'object' ) {
                var strHome = getValue(document.MainForm.Home);
                if(  strHome != '' && !StringEmptyCheck(strHome) ) {
                    alert ('Ȩ �ּҸ� �ùٸ��� �Է��� �ּ���'); setFocus (document.MainForm.Home); return false;
                }
                setValue  (document.bbsForm.Home,strHome);
            }
        }
        setValue (document.bbsForm.p_back_url, selfPage);
        bbsSetItem1 ("document.MainForm", "document.bbsForm");
//      alert ( 'bbsFormCheck ����' );
        submitYN = 'Y';
        return true;
    }

/*===================================== ���� ���� ================================*/
    function bbsGradeGrantCheck() { /* ��� ���� */
        if ( grantM < 100 ) { alert ( msgGrantM ); return false; }
        return true;
    }

    function bbsDetailGrantCheck() { /* ���� ���� */
        if ( grantV < 100 ) { alert ( msgGrantV ); return false; }
        return true;
    }

    function bbsWriteGrantCheck() { /* �Է� ���� */
        if ( grantI < 100 ) { alert ( msgGrantI ); return false; }
        return true;
    }

    function bbsUpdateGrantCheck() { /* ���� ���� */
        if ( grantU < 100 ) { alert ( msgGrantU ); return false; }
//      alert ( p_userId + " / " + writeId ) ;
        if ( writeId == "guest") { 
//          alert ( "���� ��й�ȣ �Է�â ���..." );
            bbsDisplayPasswdBox();
            return false;
        }
        if ( p_userId != writeId ) { alert ( "�ۼ��ڸ��� ������ �����մϴ�." ); return false; }
        return true;
    }


    function bbsDeleteGrantCheck() { /* ���� ���� */
        if ( grantD < 100 ) { alert ( msgGrantD ); return false; }
//        alert ( p_userId + " / " + writeId ) ;
        if ( writeId == "guest") { 
//          alert ( "���� ��й�ȣ �Է�â ���..." );
            bbsDisplayPasswdBox();
            return false;
        }
        if ( p_userId != writeId ) { alert ( "�ۼ��ڸ��� ������ �����մϴ�." ); return false; }
        return true;
    }

    function bbsAnswerGrantCheck() { /* �亯 ���� */
        if ( grantA < 100 ) { alert ( msgGrantA ); return false; }
        else {
            if ( parseInt ( depth ) >= parseInt ( limitDepth ) ) {
                alert ( limitDepth + " ���� �̻� �亯�� ���� �Ǿ����ϴ�." );
                return false;
            }
        }
        return true;
    }
//-->