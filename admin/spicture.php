<?
   include("inc/settings.php");

if(!$REGUSER["name"]) {die("У Вас недостаточно прав для просмотра этой страницы");}


   if ($_GET['code']) $spage_code=$_GET['code'];
   else
     if ($_POST['code']) $spage_code=$_POST['code'];
        else $spage_code=$_SESSION['acode'];

   $_SESSION['acode']=$spage_code;


$oper=$_POST['oper'];
$per_page=100;

if (!empty($oper))
{
if ($oper=='I')
{
$resu=mysql_query("select max(spicture_code) from {$PREFFIX}_spicture");
$newunitcode=mysql_result($resu,0,0);
$newunitcode=$newunitcode+1;
  if ($_FILES['picbig']!="none")
  {
      $r=basename($_FILES['picbig']['name']);
      $o=strlen($r);$ext="";
      while(($r[$o]!=".")&&($o>=0))
           { $ext=$r[$o].$ext; $o--;  }
      $big="static".$newunitcode.".".$ext;
  }
  if ($_FILES['picbig']!="none")
   move_uploaded_file($_FILES['picbig']['tmp_name'],"../images/$big");

 $query="insert into {$PREFFIX}_spicture values($newunitcode,$spage_code,'$big','$big',0,'','')";
//echo"$query";
 $result=mysql_query($query) or die("Cannot Insert spicture: ".mysql_error()) ;
//для постраничного-------------------------------------------------------------
 $query="select spicture_code from {$PREFFIX}_spicture where spage_code=$spage_code order by spicture_code";
 $result=mysql_query($query) or die("Incorrect Currpage Query") ;
 $num_pages=mysql_num_rows($result);
 for($i=0;$i<$num_pages;$i++)
        if (mysql_result($result,$i,0)==$newunitcode) break;
 $curr_page=ceil($i/$per_page)-1;
 if ($curr_page==-1) $curr_page=0;
//------------------------------------------------------------------------------
}

if ($oper=="D")
{
  while (list($key,$value)=each($_POST))
  {
      unset($arr);
      $arr=explode('#',$key);
      $varName=$arr[0];
      $varCode=$arr[1];
      $varExt=$arr[2];
//      echo"varCode=$varCode<br>varName=$varName<br>varPos=$varPos<br>";
      if ( ($varName=="C")&&($value=="on"))
      {
         $query = "delete from {$PREFFIX}_spicture where spicture_code=$varCode";
         $resultdel = mysql_query($query) or die ("Cannot Delete spicture.");
//удаление файлов из таблицы-----------------------------------------
            $picbig="static".$varCode.".".$varExt;
            $picbig="../images/".$picbig;
            unlink($picbig);
//------------------------------------------------------------------------------
      }
  }
}//oper=D

if (!strcasecmp($oper,"U"))
{
  while (list($key,$value)=each($_POST))
  {
      $arr=explode('#',$key);
      $varName=$arr[0];
      $varCode=$arr[1];
      $varExt=$arr[2];
      $varField=$arr[3];
      $varType=$arr[4];
//      echo"varCode=$varCode<br>varName=$varName<br>varPos=$varPos<br>";

    if ($_POST["C#$varCode#$varExt"]=="on")
      if ($varName=="F")
      {
         if ($varType=="string") $tmp="'"; else $tmp="";
         $sqlupd = "update {$PREFFIX}_spicture set $varField=$tmp".$value."$tmp  where spicture_code=$varCode";
//echo"$sqlupd";
         $resultupd = MYSQL_QUERY($sqlupd) or die ("Cannot Update spicture.");
      }//if ($varName=="F")
  }//while
}//if  (UPD)
   header("Location: $PHP_SELF?curr_page=$curr_page&code=$spage_code");
}//empty
?>
<html>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
   <LINK REL=stylesheet HREF="css/styles.css" TYPE="text/css">
   <title>Изображения</title>

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

function ConfirmSend(a)
{
    document.data.oper.value=a;
    document.data.submit();
}

</script>

</head>

<body marginheight=0 marginwidth=0 rightmargin=0 bottommargin=0 leftmargin=0 topmargin=0>


<center>

<?php
echo"<form name='data' action=$PHP_SELF method=POST enctype=multipart/form-data>";
echo"<input type=hidden name='oper' value=''>";
echo"<input type=hidden name='code' value='$spage_code'>";
echo"<input type=hidden name=curr_page value=$curr_page>";
?>


<table Border=0 CellSpacing=0 class=bluetable CellPadding=0 width=100%>
 <tr><td>
 <center>
 <table>
 <tr height=30 >
    <td class=lmenutext>Изображение:</a></td>
    <td width=5></td>
    <td><input type=file name=picbig class=smalltext></td>
    <td width=5></td>
<!--
    <td class=lmenutext>Комментарий:</a></td>
    <td width=5></td>
    <td><input type=text name=piccomment style="width:75px" class=smalltext></td>
-->
    <td width=5></td>
    <td><input type=button value=добавить class=smalltext onClick=Send('I')></td>
 </tr>
 </table>
 </td></tr>

 <tr><td class=lmenutext height=30 bgcolor=#ffffff align="center">СПИСОК ИЗОБРАЖЕНИЙ</td></tr>

</table>




<table Border=0 CellSpacing=0 class=bluetable CellPadding=0 width=95%>
 <tr><td>
 <center>
 <table>
 <tr height=30 >
    <td><input type=button  onClick=Send('U') value='изменить отмеченные' class=smalltext></td>
    <td width=5></td>
    <td><input type=button  onClick=ConfirmSend('D') value='удалить отмеченные'  class=smalltext></td>
 </tr>
 </table>
 </td></tr>
</table>


<table Border=0 CellSpacing=1 class=bluetable CellPadding=4 width=95%>

  <tr class=lmenutext height=20 align=center bgcolor=#ffffff>
    <td width=30>&nbsp;</td>
<!--    <td>Комментарий</td> -->
    <td>Изображение</td>
  </tr>

<?php
$res=mysql_query ("SELECT * FROM {$PREFFIX}_spicture where spage_code=$spage_code order by spicture_code") or die ("Cannot Select spicture");
$num_rows = mysql_num_rows($res);
$page_quant=ceil($num_rows / $per_page); //всего страниц
$start_pos=$curr_page*$per_page;
if ($start_pos+$per_page<$num_rows) $end_pos=$start_pos+$per_page;
   else $end_pos=$num_rows;
for ($x=$start_pos; $x<$end_pos; $x++)
           {
            echo"<tr class=lmenutext height=18 align=center bgcolor=#ffffff>";
    $spicture_code=mysql_result($res,$x,"spicture_code");
    $picsmall="../images/".mysql_result($res,$x,"spicsmall");

    $filename=basename($picsmall);
    DevideFile($filename,$name,$ext);

    $spiccomment=mysql_result($res,$x,"spiccomment");

    $checkname=$spicture_code."#".$ext;
    echo "<TD><input type='checkbox' name=\"C#$checkname\" id=\"C#$checkname\"></TD>";
//    echo"<TD ondblclick='change_line(\"$checkname\",\"F#$checkname#spiccomment#string\");' class=smalltext id=\"F#$checkname#spiccomment#string\">".Show($spiccomment)."</TD>\n";
    echo"<TD class=smalltext><img width=150 src=$picsmall></TD>\n";
        echo"</TR>\n";
           } //end for x
echo"</table><br>";
echo"</form>";

if ($spage_quont>1)
{
echo"<div align=left class=lmenutext style='padding-left:30px;'>Страницы:  ";
for ($i=1;$i<$spage_quant+1;$i++)
 {
   $y=$i-1;
   if ($curr_page==$y) {$t1="<";$t2=">";} else {$t1="";$t2="";}
   echo"<a class=lmenutext href=$PHP_SELF?curr_page=$y&spage_code=$spage_code>$t1 $i $t2|</a>&nbsp";
 }
echo"</div>";
}
       mysql_free_result($res);
       mysql_close ($link);
?>



</table>

<table Border=0 CellSpacing=0 class=bluetable CellPadding=0 width=95%>
 <tr><td>
 <center>
 <table>
 <tr height=30 >
    <td><input type=button  onClick=Send('U') value='изменить отмеченные' class=smalltext></td>
    <td width=5></td>
    <td><input type=button  onClick=ConfirmSend('D') value='удалить отмеченные'  class=smalltext></td>
 </tr>
 </table>
 </td></tr>
</table>

</form>

<table Border=0 CellSpacing=0 class=bluetable CellPadding=0 width=100%>
 <tr><td class=lmenutext height=30 bgcolor=#ffffff><center><a href="#top">наверх</a></td></tr>
</table>

</center>

</body>
</html>
