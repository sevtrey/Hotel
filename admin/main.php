<?php
include("inc/settings.php");
include ("inc/head.php");
//if(!isAllowed("radmin")) {die("У Вас недостаточно прав для просмотра этой страницы");}
?>

<BODY>
<center>

<div class=mainbody>

<? include("inc/top.php");?>

<table Border=0 CellSpacing=0 CellPadding=0 width=100%>
  <tr><td class=pageline>
     <div class=wmiddletext><a href="main.php">Администрирование сайта</a> </div>
  </td></tr>
</table>
&nbsp;

<table Border=0 CellSpacing=0 CellPadding=0 width=100%>
 <tr valign=top>

  <td width=10></td>
  <? include("inc/leftmenu.php"); ?>
  <td width=10></td>

  <td>
        
        
<table Border=0 CellSpacing=0 CellPadding=0 Width=100%>
 <tr align=cener valign=top>
     <td width=48%>
     
<?
if( (isAllowed("radmin")) || (isAllowed("rstatic")) )
{
echo"
<table class=grayhead Border=0 CellSpacing=0 CellPadding=0>
 <tr colspan=10 class=normaltext><td ><div ><h4>Администрирование</h4></div></td></tr>
</table>
<table Border=0 CellSpacing=15 CellPadding=0>
 <tr class=middletext align=center valign=top>";
if (isAllowed("radmin")) echo"
    <td><a href=\"admin.php\"><img src=\"graph/icon/admins.gif\"  border=0><p class=\"space\">управление<br>доступом</a></td>";
if (isAllowed("rstatic")) echo"
    <td>&nbsp;</td>
    <td><a href=\"statlist.php\"><img src=\"graph/icon/ticket.gif\" border=0><p class=\"space\">текстовые<br>страницы</a></td>";
echo"
 </tr>
</table>
&nbsp;";
}
                    
?>


<?

if((isAllowed("ralbum")))
{
echo"
<table class=grayhead Border=0 CellSpacing=0 CellPadding=0>
 <tr colspan=10 class=normaltext><td ><div ><h4>Содержимое сайта</h4></div></td></tr>
</table>
<table Border=0 CellSpacing=15 CellPadding=0>
 <tr class=middletext align=center valign=top>";
if (isAllowed("ralbum")) echo"
    <td><a href=\"albumlist.php\"><img src=\"graph/icon/mainplayer.gif\" border=0><p class=\"space\">Галереи</a></td>
    <td>&nbsp;</td>";
echo"
 </tr>
</table>
&nbsp;";
}



/*if( (isAllowed("rnews")) || (isAllowed("rbanner"))  || (isAllowed("rpremium")) || (isAllowed("rreport")) )
{
    echo"   
<table class=grayhead Border=0 CellSpacing=0 CellPadding=0>
 <tr colspan=10 class=normaltext><td ><div ><h4>Информация</h4></div></td></tr>
</table>
<table Border=0 CellSpacing=15 CellPadding=0>
 <tr class=middletext align=center valign=top>";
if (isAllowed("rnews")) echo"
    <td ><a href=\"news.php\"><img src=\"graph/icon/news.gif\"  border=0><p class=\"space\">новости</a></td>";
if (isAllowed("rpremium")) echo"
    <td>&nbsp;</td>
    <td ><a href=\"doctypes.php\"><img src=\"graph/icon/events.gif\"  border=0><p class=\"space\">советы</a></td>";
if (isAllowed("rbanner")) echo"
    <td>&nbsp;</td>
    <td ><a href=\"banners.php\"><img src=\"graph/icon/artist.gif\"  border=0><p class=\"space\">партнеры</a></td>";
   
    

echo"
 </tr>
</table>
</center>
";

}*/


?>

    
     

     </td>
     
     <td width=4%>&nbsp;</td>
     
     <td width=48%>
   
<!--   
   

<?

/*if (isAllowed("rdirectory"))  
{
    echo"   
<center>
<table class=grayhead Border=0 CellSpacing=0 CellPadding=0>
 <tr colspan=10 class=normaltext><td ><div ><h4>Справочники</h4></div></td></tr>
</table>
<table Border=0 CellSpacing=15 CellPadding=0>
 <tr class=middletext align=center valign=top>
    <td ><a href='types.php'><img src='graph/icon/partners.gif'  border=0><p class=space>Назначения</a></td><td>&nbsp;</td>
    <td ><a href='country.php'><img src='graph/icon/bottom.gif'  border=0><p class=space>Страны</a></td><td>&nbsp;</td>
    <td ><a href='factory.php'><img src='graph/icon/city.gif'  border=0><p class=space>Заводы</a></td>

 </tr><tr class=middletext align=center valign=top>
    <td ><a href='styles.php'><img src='graph/icon/adv.gif'  border=0><p class=space>Стили</a></td><td>&nbsp;</td>
    <td ><a href='colors.php'><img src='graph/icon/dep.gif'  border=0><p class=space>Цвета</a></td><td>&nbsp;</td>
    <td ><a href='materials.php'><img src='graph/icon/files.gif'  border=0><p class=space>Материалы</a></td>
 
 </tr><tr class=middletext align=center valign=top>
    <td ><a href='surfaces.php'><img src='graph/icon/artmain.gif'  border=0><p class=space>Типы поверхности</a></td><td>&nbsp;</td>
    <td ><a href='status.php'><img src='graph/icon/sminews.jpg'  border=0><p class=space>Статусы коллекций</a></td><td>&nbsp;</td>
    <td ><a href='pricegroups.php'><img src='graph/icon/smiinfo.gif'  border=0><p class=space>Ценовые группы</a></td>
 </tr>
</table>
</center>
";

}   */   
?>

     
-->
     
     </td>
 </tr>
</table>        
        
        



  
  </td>
  <td width=10></td>



</tr>

</table>
</div>
</center>

</BODY>
</HTML>
