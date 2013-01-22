<?php
include("inc/settings.php");  

$page_code=1;    

if (!isset($page_code)) header("Location: 404.html");
if (!is_numeric($page_code)) header("Location: 404.html");
    

if ($page_code==1) {$side_str=" на главной"; $w=250;}
if ($page_code==2) {$side_str=" на страницах"; $w=180;}

$oper=$_POST['oper'];

$per_page=10;

if(!$REGUSER["name"]) {die("У Вас недостаточно прав для просмотра этой страницы");}


if (!empty($oper))
{
if ($oper=='I')
{
$newicon=$icon+1;

$resu=mysql_query("select max(picture_code) from {$PREFFIX}_banners");
$newunitcode=mysql_result($resu,0,0);
$newunitcode=$newunitcode+1;
  if ($_FILES['picbig'])
  {
      $r=basename($_FILES['picbig']['name']);
      $o=strlen($r);$ext="";
      while(($r[$o]!=".")&&($o>=0))
           { $ext=$r[$o].$ext; $o--;  }
      $big="banner".$newunitcode.".".$ext;
  }
  if ($_FILES['picbig'])
   {
     move_uploaded_file($_FILES['picbig']['tmp_name'],"../banners/$big");
   }
 $res=mysql_query("update {$PREFFIX}_banners set picpos=picpos+1 where picpos>=$picpos and page_code=$page_code");
 $query="insert into {$PREFFIX}_banners values($newunitcode,$page_code,'$picname','$big',$picpos,'$pic_link','$pic_flashcode','$pic_flashcode_en',$pic_active)";
 // echo"$query";
 $result=mysql_query($query) or die("Cannot Insert Picture:<br>".$query) ;

//для постраничного-------------------------------------------------------------
 $query="select picture_code from {$PREFFIX}_banners where page_code=$page_code order by picpos";
 $result=mysql_query($query) or die("Incorrect Currpage Query") ;
 $num_pages=mysql_num_rows($result);
 for($i=0;$i<$num_pages;$i++)
        if (mysql_result($result,$i,0)==$newunitcode) break;
 $curr_p=ceil($i/$per_page)-1;
 if ($curr_p==-1) $curr_p=0;
//------------------------------------------------------------------------------
 RenumeratePos("{$PREFFIX}_banners","picture_code","picpos","page_code",$page_code);
}

if ($oper=="D")
{
  while (list($key,$value)=each($_POST))
  {
      unset($arr);
      $arr=explode('#',$key);
      $varName=$arr[0];
      $varCode=$arr[1];
      $varPos=$arr[2];
      $varExt=$arr[3];
//      echo"varCode=$varCode<br>varName=$varName<br>varPos=$varPos<br>";
      if ( ($varName=="C")&&($value=="on"))
      {
         $query = "delete from {$PREFFIX}_banners where picture_code=$varCode";
         $resultdel = mysql_query($query) or die ("Cannot Delete Picture.");
//удаление файлов из таблицы-----------------------------------------
            $picbig="banner".$varCode.".".$varExt;
            $picbig="../banners/".$picbig;
            unlink($picbig); 
//------------------------------------------------------------------------------
         $res=mysql_query("update {$PREFFIX}_banners set picpos=picpos-1 where picpos>$varPos and page_code=$page_code");
      }
  }
 RenumeratePos("{$PREFFIX}_banners","picture_code","picpos","page_code",$page_code);
}//oper=D

if (!strcasecmp($oper,"U"))
{
/*
echo"<pre>";
print_r($_POST);
echo"</pre>";
*/
  while (list($key,$value)=each($_POST))
  {
      $arr=explode('#',$key);
      $varName=$arr[0];
      $varCode=$arr[1];
      $varPos=$arr[2];
      $varExt=$arr[3];
      $varField=$arr[4];
      $varType=$arr[5];
//      echo"varCode=$varCode<br>varName=$varName<br>varPos=$varPos<br>";

    if ($_POST["C#$varCode#$varPos#$varExt"]=="on")
      if ($varName=="F")
      {
         if ($varType=="string") $tmp="'"; else $tmp="";
         $sqlupd = "update {$PREFFIX}_banners set $varField=$tmp".$value."$tmp where picture_code=$varCode";
//         echo"$sqlupd";
         $resultupd = MYSQL_QUERY($sqlupd) or die ("Cannot Update Picture.");

         if ($varField=="picpos")
         {
           $newpos=$value;
           $oldpos=$varPos;
           //двигаем вниз
           if ($oldpos<$newpos) mysql_query("update {$PREFFIX}_banners set picpos=picpos-1 where picpos<=$newpos and picpos>$oldpos and page_code=$page_code");
           //двигаем вверх
           if ($oldpos>$newpos) mysql_query("update {$PREFFIX}_banners set picpos=picpos+1 where picpos>=$newpos and page_code=$page_code");
           mysql_query("update {$PREFFIX}_banners set picpos=$newpos where picture_code=$varCode");
           RenumeratePos("{$PREFFIX}_banners","picture_code","picpos","page_code",$page_code);
         }
      }//if ($varName=="F")
  }//while
}//if  (UPD)
   if($sortby) $tmp="&sortby=$sortby&sortdir=$sortdir";else $tmp="";
   header("Location: $PHP_SELF?curr_page=$curr_page&curr_p=$curr_p&page_code=$page_code");
}//empty
?>



<? include ("inc/head.php"); ?>

<script language = JavaScript>
function Send(a)
{
document.data.oper.value=a;
document.data.submit();
}

function change_line(Check,Unit)
{
Elem=document.getElementById("C#"+Check);
Elem.checked=true;
Unit=document.getElementById(Unit);
while ((Unit.id==null)||(Unit.id.indexOf('#')==0)) Unit=Unit.parentElement;
var name=Unit.id;
var value=Unit.innerHTML.replace("'","&#39;");
if (value.indexOf('<input')>=0) return ;
res = "<input style='width:100%;' class=smalltext name='"+name+"' value='" + value+"'>";
Unit.innerHTML = res;
}
            
function change_yes_no(Check,Unit){
Elem=document.getElementById("C#"+Check);
Elem.checked=true;
Unit=document.getElementById(Unit);
while ((Unit.id==null)||(Unit.id.indexOf('#')==0)) Unit=Unit.parentElement;
var name=Unit.id;
var value=Unit.innerHTML.replace("'","&#39;");
if (value.indexOf('<SELECT')>=0) return ;
res = "<SELECT style='width:100%' class=smalltext name='"+name+"'><OPTION VALUE=0>нет</OPTION><OPTION VALUE=1>да</OPTION></SELECT>";
Unit.innerHTML = res;
}
            

function ConfirmSend(a)
{
    document.data.oper.value=a;
    document.data.submit();
}

</script>

<BODY>
<center>

<div class=mainbody>

<? include("inc/top.php"); ?>

<table Border=0 CellSpacing=0 CellPadding=0 width=100%>
  <tr><td class=pageline>
     <div class=wmiddletext><a href="main.php">Администрирование сайта</a> &#187; <a>Партнеры</a></div>
  </td></tr>
</table>
&nbsp;


<table Border=0 CellSpacing=0 CellPadding=0 class=mainbody>
 <tr valign=top>

  <td width=10></td>
  <? include("inc/leftmenu.php"); ?>
  <td width=10></td>

  <td>

<?php
echo"<form name='data' action=$PHP_SELF method=POST enctype=\"multipart/form-data\">";
echo"<input type=hidden name='oper' value=''>";
echo"<input type=hidden name=curr_page value=\"$curr_page\">";
echo"<input type=hidden name=page_code value=\"$page_code\">";  
echo"<input type=hidden name=curr_p value=\"$curr_p\">";

?>

<table class=grayhead Border=0 CellSpacing=0 CellPadding=0 >
 <tr class=normaltext>
  <td ><div ><h4>Партнеры</h4></div></td>
  <td align=right class=wmiddletext><a class=submenu onclick="displayform(this,'добавить партнера')">добавить партнера</a></td>
 </tr>
</table>

<?php
if ($page_code==0)
{
  $rt=mysql_query("SELECT min(page_code) FROM {$PREFFIX}_page where page_code>0") or die("Unable to Comply Request");
  $page_code=@mysql_result($rt,0,0);
  if ($page_code==0)
      die ("<div align=center><B>ОШИБКА : работа с изображениями невозможна, так как не определено ни одной страницы альбома. Определите <a class=blue href=page.php><u>страницы альбома</u></a> и повторите запрос.</B></div>");

}
?>

<div id=addform>
<table Border=0 CellSpacing=0 class=pagebluetable CellPadding=0>
 <tr><td colspan=3  bgcolor=#ffffff height=10></td></tr>
 <tr><td colspan=10 class=blueheadcolor><center><div class=normaltext>ДОБАВИТЬ ПАРТНЕРА</div></center></td></tr>
 <tr><td colspan=3  height=1 bgcolor=#ffffff></td></tr>
 <tr><td>
 <center>
 <table cellpadding=2 cellspacing=0>
 <tr height=30 >
    <td class=lmenutext>Баннер:</td>
    <td width=5></td>
    <td colspan=5><input name='picbig' type=file style="width:320px" class=smalltext></td>
 </tr>
 <tr height=30 >
    <td class=lmenutext>Название:</td>
    <td width=5></td>
    <td colspan=5><input name=picname type=text style="width:320px" class=smalltext></td>
 </tr>
 <tr height=30 >
    <td class=lmenutext>Ссылка на сайт:</td>
    <td width=5></td>
    <td colspan=5><input name=pic_link type=text style="width:320px" class=smalltext></td>
 </tr>
 <tr height=30 >
    <td class=lmenutext>Аннотация:</td>
    <td width=5></td>
    <td colspan=5><textarea name=pic_flashcode style="width:320px"  rows=5 class=smalltext></textarea></td>
 </tr>
 <tr height=30 >
    <td class=lmenutext>Аннотация (англ):</td>
    <td width=5></td>
    <td colspan=5><textarea name=pic_flashcode_en style="width:320px"  rows=5 class=smalltext></textarea></td>
 </tr> <tr height=30 >
    <td class=lmenutext>Позиция:</td>
    <td width=5></td>                    
<?
$presu=mysql_query("select max(picpos) from {$PREFFIX}_banners ");
$newpos=mysql_result($presu,0,0)+1;
?> 
    <td><input name=picpos value='<?=$newpos;?>' type=text style="width:100px" class=smalltext></td>
    <td width=5></td>
    <td class=lmenutext>Активность:</td>
    <td width=5></td>
    <td><select name=pic_active style="width:50px" class=smalltext><option value=1> да </option><option value=2> нет </option></select></td>
    <td width=5></td>
 </tr>
 </table>
 </td>

 <td class=helpzone>

     <table Border=0 CellSpacing=1 CellPadding=0 bgcolor=#999999 class=helptable>
       <tr>
        <td class=helptd>

             <div class=ssmalltext>
                Выберите изображение, используя кнопку "Обзор". Заполните необходимые поля формы и нажмите кнопку "добавить партнера". Для изменения последовательности вывода на страницах, измените поле "Позиция".
             </div>

        </td>
       </tr>
     </table>

 </td>


 </tr>
 <tr><td colspan=3 height=1 bgcolor=#ffffff></td></tr>
 <tr><td colspan=10 class=blueheadcolor><center><input type=button onClick=Send('I') value='добавить партнера'  class=smalltext></td></tr>
</table>
</div>


<table Border=0 CellSpacing=0 class=pagebluetable CellPadding=0 >
 <tr><td class=lmenutext height=30 bgcolor=#ffffff align="center">СПИСОК ПАРТНЕРОВ</td></tr>
</table>

<?

$res=mysql_query ("SELECT picture_code,picsmall,picbig,picpos,pic_link,pic_flashcode,pic_flashcode_en,pic_active FROM {$PREFFIX}_banners where page_code=$page_code order by picpos") or die ("Cannot Select Picture");
  $num_rows=mysql_num_rows($res);
  if($num_rows)
  {
      $page_quant=ceil($num_rows / $per_page); //всего страниц
  } 
  
if ($page_quant>1)
{
echo"<div align=left class=smalltext><b>Страницы:</b>  ";
for ($i=1;$i<$page_quant+1;$i++)
 {
   $y=$i-1;
   if ($curr_p==$y) {$t1="<b>";$t2="</b>";} else {$t1="";$t2="";}
   echo"<a class=blue href=$PHP_SELF?curr_page=$curr_page&curr_p=$y&page_code=$page_code>$t1 $i $t2 |</a>&nbsp";
 }
echo"</div><br>";
}


?>


<table Border=0 CellSpacing=0 class=pagebluetable CellPadding=0>
 <tr><td>
 <center>
 <table>
 <tr height=30 >
    <td><input type=button onClick=Send('U') value='изменить отмеченные' class=smalltext></td>
    <td width=5></td>
    <td><input type=button onClick=Send('D') value='удалить отмеченные'  class=smalltext></td>
 </tr>
 </table>
 </td></tr>
</table>

<table Border=0 CellSpacing=1 class=bluetable CellPadding=4 width=100%>
  <tr class=lmenutext height=20 align=center bgcolor=#ffffff>
    <td width=20>&nbsp;</td>
    <td width=260>Изображение</td>
    <td>Название</td>
    <td>Ссылка</td>
    <td>Аннотация</td>
    <td>Аннотация<br>(англ)</td>
    <td>Позиция</td>
    <td>Активность</td>
  </tr>

<?php
  if($num_rows)
  {
      $page_quant=ceil($num_rows / $per_page); //всего страниц
    $start_pos=$curr_p*$per_page;
    if ($start_pos+$per_page<$num_rows) $end_pos=$start_pos+$per_page;
       else $end_pos=$num_rows;
    mysql_data_seek($res,$start_pos);
    for ($x=$start_pos; $x<$end_pos; $x++)
    {
    list($picture_code,$picname,$picbig,$picpos,$pic_link,$pic_flashcode,$pic_flashcode_en,$pic_active)=mysql_fetch_array($res);

    DevideFile($picsmall,$name,$ext);
    $picsmall="../banners/".$picbig;            
    
    $w=108;
                                                                                                                                                             
    if($pic_active==1) {$pic_active="да";$bg="bgcolor=#FFFFFF";} 
    else {$pic_active="нет";$bg="bgcolor=#EEEEEE";}

    $checkname=$picture_code."#".$picpos."#".$ext;
    echo"<tr class=edittabletext height=18 align=center $bg>";
    echo"<TD width=20 align=center ><input type='checkbox' name=\"C#$checkname\" id=\"C#$checkname\"></TD>";
    echo"<TD class=normaltext><img src=$picsmall width=$w></TD>\n";
    echo"<TD ondblclick='change_line(\"$checkname\",\"F#$checkname#pic_name#string\")' id=\"F#$checkname#pic_name#string\" class=smalltext>".Show($picname)."</TD>\n";
    echo"<TD ondblclick='change_line(\"$checkname\",\"F#$checkname#pic_link#string\")' id=\"F#$checkname#pic_link#string\" class=smalltext>".Show($pic_link)."</TD>\n";
    echo"<TD ondblclick='change_line(\"$checkname\",\"F#$checkname#pic_flashcode#string\")' id=\"F#$checkname#pic_flashcode#string\" class=smalltext>".Show($pic_flashcode)."</TD>\n";
    echo"<TD ondblclick='change_line(\"$checkname\",\"F#$checkname#pic_flashcode_en#string\")' id=\"F#$checkname#pic_flashcode_en#string\" class=smalltext>".Show($pic_flashcode_en)."</TD>\n";
    echo"  <td ondblclick='change_line(\"$checkname\",\"F#$checkname#picpos#int\");' class=smalltext id=\"F#$checkname#picpos#int\">".Show($picpos)."</td>";
    echo"  <td ondblclick='change_yes_no(\"$checkname\",\"F#$checkname#pic_active#int\");' class=smalltext id=\"F#$checkname#pic_active#int\">".Show($pic_active)."</td>";
    echo"</TR>\n";
    } //end for x
  }//if($num_rows)

?>

</table>

<table Border=0 CellSpacing=0 class=pagebluetable CellPadding=0 width=95%>
 <tr><td>
 <center>
 <table>
 <tr height=30 >
    <td><input type=button onClick=Send('U') value='изменить отмеченные' class=smalltext></td>
    <td width=5></td>
    <td><input type=button onClick=Send('D') value='удалить отмеченные'  class=smalltext></td>
 </tr>
 </table>
 </td></tr>
</table>
<br>
<?php
{
echo"<div align=left class=smalltext><b>Страницы:</b>  ";

if($sortby) $tmp="&sortby=$sortby&sortdir=$sortdir";else $tmp="";

for ($i=1;$i<$page_quant+1;$i++)
 {
   $y=$i-1;
   if ($curr_p==$y) {$t1="<b>";$t2="</b>";} else {$t1="";$t2="";}
   echo"<a class=blue href=$PHP_SELF?curr_page=$curr_page&curr_p=$y&page_code=$page_code>$t1 $i $t2 |</a>&nbsp";
 }
echo"</div>";
}
?>

</form>
  </td>
    <td width=10></td>
</tr>

</table>
</div>
</center>

</BODY>
</HTML>
