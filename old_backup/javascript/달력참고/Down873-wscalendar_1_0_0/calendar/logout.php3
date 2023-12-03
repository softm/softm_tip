<?PHP session_start(); #programmed by WindHunter '97 ?> 
<?
   session_unregister("session_calendar_viewday");
   session_unregister("session_calendar_login");
   session_unregister("session_calendar_id");
   session_unregister("session_calendar_name");

   echo("<meta http-equiv='refresh' content='0; url=calendar.php3'>");
?>