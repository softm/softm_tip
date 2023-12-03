
                 <?
                    $message = '<html>' . "\n"
                          . '<body>' ."\n"
                          . 'Dear Sir or Madam,' . "<br>" ."<br>" ."<br>" ."\n"
                          . 'Thanks for using Calko, TKEK Quotation System.' . "<br>" ."<br>" . "\n"
                          . 'Attached please find the quotation link for your review.' . "<br>" ."<br>" . "\n"
                          . 'Please don\'t hesitate to contact TKEK Oversea team if you have any queries.' . "<br><br>" . "\n"

                          . "<TABLE style='padding:10px;border-collapse:collapse;border:1px solid black' border=1>" . "\n"
                          . "    <TR>" . "\n"
                          . "    <TD style='padding:0px 4px 0px 4px;background-color:#7B7B7B;color:white;height:30px;font-weight:bold'>Quotation Number</TD>". "\n"
                          . "    <TD style='padding:0px 4px 0px 4px'>" . substr($p_esti_no,0,6) . '-' . substr($p_esti_no,6,5) . '-' . substr($p_esti_no,11) . "</TD>". "\n"
                          . "    </TR>". "\n"
                          . "    <TR>". "\n"
                          . "    <TD style='padding:0px 4px 0px 4px;background-color:#7B7B7B;color:white;height:30px;font-weight:bold'>Requesting Date</TD>". "\n"
                          . "    <TD style='padding:0px 4px 0px 4px'>" . $tp_send_date . "</TD>". "\n"
                          . "    </TR>". "\n"
                          . "    <TR>". "\n"
                          . "    <TD style='padding:0px 4px 0px 4px;background-color:#7B7B7B;color:white;height:30px;font-weight:bold'>Quotation Link</TD>". "\n"
                          . "    <TD style='padding:0px 4px 0px 4px'>" . "<b><a href=\"http://" . SERVER_DOMAIN . "/?backurl=". urlencode("/calko/calko_write.php?p_esti_no=") . $p_esti_no . "\">" . "http://" . SERVER_DOMAIN . "/?backurl=/calko/calko_write.php?p_esti_no=" . $p_esti_no . "</a></b>" . "</TD>". "\n"
                          . "    </TR>". "\n"
                          . "</TABLE>". "\n"
                          . "<BR>". "\n"
                          . 'CENE Team : 82-2-2610-7764' ."<br>" . "<br>" . "\n"
                          . 'AMS Team  : ...' . "<br>" . "\n"
                          . '</body>' . "\n"
                          . '</html>' . "\n";
                          //echo $message;
                          ?>