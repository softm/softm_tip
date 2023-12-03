<div id=alert_box class=alert_box>
    <TABLE width='100%' border=0 cellspacing=0 cellpadding=0 style='border:0px solid blue'>
        <TR id='alert_box_progress'>
        <TD align=center style='height:55px'><IMG SRC='<?=SERVICE_DIR?>/common/js/ajax-loader.gif' BORDER="1" ALT="" style='vertical-align:text-top'></TD>
        </TR>
        <TR>
        <TD style='font-weight:bold' align=center id='alert_box.message'>Processing
        <br>
        </TD>
        </TR>
        <TR>
        <TD align=center style='padding-top:10px'>
        <button id='alert_box.ok'       >Ok</button>&nbsp;&nbsp;
        <button id='alert_box.cancel'   >Cancel</button>
        </TD>
        </TR>
    </TABLE>
</div>
<div id=message_box class=alert_box style='padding:1px 1px 10px 1px'>
    <TABLE width='100%' border=0 cellspacing=0 cellpadding=0 style='border:0px solid blue'>
        <TR bgcolor=gray height='25'>
        <TD style='font-weight:bold' align=center id='message_box.title'>Information
        <br>
        </TD>
        </TR>
        <TR>
        <TD style='padding-top:15px;font-weight:bold' align=center id='message_box.message'>Message
        <br>
        </TD>
        </TR>
        <TR>
        <TD align=center style='padding-top:10px'>
        <button id='message_box.ok'       >Ok</button>&nbsp;&nbsp;
        </TD>
        </TR>
    </TABLE>
</div>

<div id=confirm_box class=alert_box style='padding:1px 1px 10px 1px'>
    <TABLE width='100%' border=0 cellspacing=0 cellpadding=0 style='border:0px solid blue'>
        <TR bgcolor=gray height='25'>
        <TD style='font-weight:bold' align=center id='confirm_box.title'>Information
        <br>
        </TD>
        </TR>
        <TR>
        <TD style='padding-top:15px;font-weight:bold' align=center id='confirm_box.message'>Message
        <br>
        </TD>
        </TR>
        <TR>
        <TD align=center style='padding-top:10px'>
        <button id='confirm_box.ok'       >Ok</button>&nbsp;&nbsp;
        <button id='confirm_box.cancel'   >Cancel</button>
        </TD>
        </TR>
    </TABLE>
</div>

<div id=wait_box class=alert_box>
    <TABLE width='100%' border=0 cellspacing=0 cellpadding=0 style='border:0px solid blue'>
        <TR id='wait_box_progress'>
        <TD align=center style='height:55px'><IMG SRC='<?=SERVICE_DIR?>/common/js/ajax-loader.gif' BORDER="1" ALT="" style='vertical-align:text-top'></TD>
        </TR>
        <TR>
        <TD style='font-weight:bold' align=center id='wait_box.message'>Processing...
        <br>
        </TD>
        </TR>
    </TABLE>
</div>