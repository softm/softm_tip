<?
/*
* include �Ǿ������� �˻�
**/
if ( defined("_message_class_included") ) return;
else define ("_message_class_included", true);

// �޽��� Ŭ����
class Message {
    var $errType = '';
    var $errNo = '';
    var $errMsg = '';
    var $errPage = '';
    var $errAction= '';
    var $errButton= '';

    // D : ������ ���̽� ���� Error;
    // I : �Խ��� ���� ����;
    function Message ($errType, $errNo, $errMsg, $errPage) {
        $this->errType = $errType;
        $this->errNo   = $errNo  ;
        $this->errMsg  = $errMsg ;
        $this->errPage = $errPage ;
        $this->errAction='';
        $this->errButton='';

        $this->messageAbstract();
    }

    function getErrType() { return $this->errType ; }
    function getErrNo  () { return $this->errNo   ; }
    function getErrMsg () { return $this->errMsg  ; }
    function getErrPage() { return $this->errPage ; }

    function messageAbstract() {
        global $baseDir;

        if ( $this->errType == 'M' ) { // ���� �޽���
            if ( !$this->errPage ) {
                $this->errAction = 'history.back();';
                $this->errButton = '���ư���';
            } else {
                $_tmp = $this->errNo;
                $end = strrpos ( $_tmp , ':');
                $this->errAction = substr ( $_tmp, 0, $end );
                $this->errButton = substr ( $_tmp, $end + 1);
            }
        } else {
            if ( !$this->errPage ) {
                $this->errAction = 'history.back();';
                $this->errButton = '���ư���';
            } else {
                $val = explode ( ':', $this->errPage );
                $gubun	 = $val[0];
                if ( strtoupper ( $gubun ) == 'JAVASCRIPT' ) {
                    $this->errAction = $val[1];
                    $this->errButton = $val[2];
                } else if ( strtoupper ( $gubun ) == 'MOVE' ) {
                    $this->errAction = "document.location.href=\"" . $val[1] . "\";";
                    $this->errButton = $val[2];
                } else if ( strtoupper ( $gubun ) == 'CLOSE' ) {
                    $this->errAction = "self.close();";
                    $this->errButton = $val[1];
                } else {
                    $this->errAction = 'history.back();';
                    $this->errButton = '���ư���';
                }
            }
        }
    }
}
?>