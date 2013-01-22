<?php
  include("../../../../inc/const.php");
  include("../../../../inc/session.php");
  include("../../../../inc/connect.php");
  include("../../../../inc/functions.php");
?>

<?php
/*
 echo "SC=".$_SESSION['spage_code']."<br><br><br>";

  foreach (glob("../../../../images/*.jpg") as $filename)
      if (!is_dir($filename))
          {
            $base="images/".basename($filename);
            echo"<img width=100 src=$filename ondblClick='javascript:window.opener.document.forms[0].src.value=\"$base\"; window.close();'> images/$base<br>";
          }
*/
?>



<html>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
   <LINK REL=stylesheet HREF="../../../../css/styles.css" TYPE="text/css">
   <title>Файлы</title>
<script language=JavaScript>
function clickFunc(val1,val2)
{
window.opener.document.forms[0].href.value=val1;
val2=val2.replace(/j!j!j/g, "'");
val2=val2.replace(/l!l!l/g, '"');
window.opener.document.forms[0].linktitle.value=val2;
window.close();
}
</script>
</head>

<body marginheight=0 marginwidth=0 rightmargin=0 bottommargin=0 leftmargin=0 topmargin=0>

<center>



<table Border=0 CellSpacing=0 class=bluetable CellPadding=0 width=100%>
 <tr><td class=lmenutext height=30 bgcolor=#ffffff><center>СПИСОК ФАЙЛОВ</td></tr>
</table>

<table Border=0 CellSpacing=1 class=bluetable CellPadding=4 width=95%>

  <tr class=lmenutext height=20 align=center bgcolor=#ffffff>
    <td>Файл</td>
    <td>Комментарий</td>
  </tr>

<?php
$res=mysql_query ("SELECT * FROM {$PREFFIX}_docfile order by docfile_code") or die ("Cannot Select Files");
$num_rows = mysql_num_rows($res);
/*
$spage_quant=ceil($num_rows / $per_spage); //всего страниц
$start_pos=$curr_spage*$per_spage;
if ($start_pos+$per_spage<$num_rows) $end_pos=$start_pos+$per_spage;
   else $end_pos=$num_rows;
for ($x=$start_pos; $x<$end_pos; $x++)
*/
for ($x=0; $x<$num_rows; $x++)
           {
  		  echo"<tr class=lmenutext height=18 align=center bgcolor=#ffffff>";
    $docfile_code=mysql_result($res,$x,"docfile_code");
    $docfile_name=mysql_result($res,$x,"docfile_name");
    $docfile_file=mysql_result($res,$x,"docfile_file");
    $docfile_comment=mysql_result($res,$x,"docfile_comment");

    $filename="../../../../../files/".$docfile_comment;

    $base="../files/".basename($docfile_file);


$docfile_c=$docfile_comment;
$docfile_c=str_replace("'","j!j!j",$docfile_c);
$docfile_c=str_replace('"',"l!l!l",$docfile_c);
//echo"-- clickFunc(\"$base\",\"$docfile_c\") --------<br>";
    echo "<TD ondblClick='clickFunc(\"$base\",\"$docfile_c\")' class=normaltext>$docfile_name</TD>";
    echo"<TD class=normaltext>".Show($docfile_comment)."</TD>";
        echo"</TR>\n";
           } //end for x
echo"</table><br>";
       mysql_free_result($res);
       mysql_close ($link);
?>



</table>

<table Border=0 CellSpacing=0 class=bluetable CellPadding=0 width=100%>
 <tr><td class=lmenutext height=30 bgcolor=#ffffff><center><a href="#top">наверх</a></td></tr>
</table>

</center>

</body>
</html>
</body>
</html>