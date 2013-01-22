<?php
include("inc/settings.php");
include ("inc/head.php");
?>


<script language="JavaScript"><!--
function sendloginpassw() {

  num=document.userform.elements.length;

  for(i=0;i<num;i++)
  {
   if((document.userform.elements[i].value=="")&&(document.userform.elements[i].value!=" "))
     {
        alert('Необходимо заполнить все поля формы!');
        document.userform.elements[i].focus();
        return;
     }
  }

  document.userform.submit();

}
--></script>


<BODY>

<table Border=0 CellSpacing=0 CellPadding=0 Width=100% Height=100%>
 <tr>
  <td height=100% align=center>

<center>

<img src="../img/logo.png" border=0>

<form name=userform action='<?$PHP_SELF?>' method=POST enctype=multipart/form-data>
<input type=hidden name=op value='in'>
<table Border=0 class=smalltext bgcolor=#ffffff CellSpacing=0 CellPadding=0 width=370>
 <tr><td height=45 bgcolor=#333333 class=normaltext><b><center><h4>Вход в панель администрирования</h4></td></tr>
 <tr><td height=15></td></tr>
 <tr><td >
 <center>
 <table Border=0 class=loginformtext CellSpacing=0 CellPadding=0>
    <tr><td align=right><font color=#999999>Логин:</font> &nbsp;</td><td><input type=text class=loginformtext name=login style='width:170px'><td></tr>
    <tr><td height=5></td></tr>
    <tr><td align=right><font color=#999999>Пароль:</font> &nbsp;</td><td><input type=password class=loginformtext name=password style='width:170px'><td></tr>
    <tr><td height=5></td></tr>
                                                                                        
<?
if ($err==1)
echo"
    <tr><td height=10></td></tr>
    <tr><td colspan=2 class=normaltext><CENTER><font color=red>указан неверный логин или пароль</font></CENTER><td></tr>
    <tr><td height=10></td></tr>
    <tr><td colspan=2 class=smalltext><CENTER><a href='reminder.php'>восстановить пароль</a></CENTER><td></tr>
    <tr><td height=5></td></tr>
";
if ($err==2)
echo"
    <tr><td height=10></td></tr>
    <tr><td colspan=2 class=normaltext><CENTER><font color='#009900'>выход успешно завершен</font></CENTER><td></tr>
    <tr><td height=10></td></tr>
";
?>

 </table>
 </td></tr>
 <tr><td height=70 ><center><input type=submit onclick='sendloginpassw()' class=bigtext value='Войти в систему' ></td></tr>

</table>
 </form>
<p>


  </td>
 </tr>
</table>

</BODY>
