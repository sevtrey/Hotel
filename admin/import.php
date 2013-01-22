<?php
include("inc/settings.php");
$per_page=50;
$oper=$_POST['oper'];

if(!isAllowed("rdirectory")) {die("У Вас недостаточно прав для просмотра этой страницы");}


if (!empty($oper))
{
 $error=0;

  if ($_FILES['import_file']['name'])
  {
     
     $all=file($_FILES['import_file']['tmp_name']);
     $cntU=0; $cntA=0;
                    
     $i=0; $this_type=0;
     while($i<count($all))
     {
       $data=explode(";",$all[$i]);
       // echo"$i -> $data<br>";
       $first=trim($data[0]);  
        
       if ($first)
       {

        if ($first=="*")
        {
           $this_type=trim($data[1]);
        }
        else
        {   
            $obj_code=$first;
            $obj_name=htmlspecialchars(trim($data[1]),ENT_QUOTES);
            $obj_name_en=htmlspecialchars(trim($data[2]),ENT_QUOTES);
            $obj_unit=htmlspecialchars(trim($data[3]),ENT_QUOTES);
            $obj_unit_en=htmlspecialchars(trim($data[4]),ENT_QUOTES);
            $obj_price=trim($data[5]);
            $obj_price_en=trim($data[6]);
            
            if ($obj_price_en=="") $obj_price_en=0; 

            // echo"    obj_name -> $obj_name<br>"; 

            $testquery="select object_code from {$PREFFIX}_price where object_code=$obj_code";
            $testres=mysql_query ($testquery) or die ("Error 23");
            $num_obj=mysql_num_rows($testres);
            if($num_obj)
            {
               // есть услуга с таким кодом
               
               $updatequery="update {$PREFFIX}_price set  
                            object_name='$obj_name',
                            object_name_en='$obj_name_en',
                            object_unit='$obj_unit',
                            object_unit_en='$obj_unit_en',
                            object_price='$obj_price',
                            object_price_en='$obj_price_en'
                          where object_code=$obj_code
                         ";                                       
               $updateres=mysql_query ($updatequery) or die ("Error 24<br>$updatequery<br>");
               $cntU++;
            }
            
            else 
            {
               // нет услуги с таким кодом. добавляем
                       
               $presu=mysql_query("select max(object_date) from {$PREFFIX}_price where type_code=$this_type ");
               $obj_pos=mysql_result($presu,0,0)+1;
                                      

               $query="insert into {$PREFFIX}_price values($obj_code,$this_type,$obj_pos,'$obj_name','$obj_name_en','','','$obj_unit','$obj_unit_en','$obj_price','$obj_price_en',0,0,1)";
               $result=mysql_query($query) or die("Не могу добавить услуги:<br>$query<br>".mysql_error());
               $object_code=mysql_insert_id();        
          
               $query="insert into {$PREFFIX}_page (page_name) values('прайс:  ".addslashes($obj_name)."')";
               $result=mysql_query($query) or $err=4;//die("Не могу добавить page:".mysql_error());
               $page_code=mysql_insert_id();
               $result=mysql_query("update {$PREFFIX}_price   set page_code=$page_code where object_code=$object_code") or die("Не могу изменить page :".mysql_error());

               $query="insert into {$PREFFIX}_spage (spage_name) values('прайс ".addslashes($obj_name)."')";
               $result=mysql_query($query) or $err=4;//die("Не могу добавить spage:".mysql_error());
               $spage_code=mysql_insert_id();
               $result=mysql_query("update {$PREFFIX}_price   set spage_code=$spage_code where object_code=$object_code") or die("Не могу изменить spage :".mysql_error());

               $cntA++;

            }



        }
        
        }

        $i++;
        
        

     } // строки
 
  } // if files uploaded

  header("Location: $PHP_SELF?err=$error&cntU=$cntU&cntA=$cntA");
}//empty


?>



<? include ("inc/head.php"); ?>

<script language = JavaScript>

function ConfirmSend(a)
{
if (confirm('Вы уверены, что хотите выполнить импорт прайс-листа?'))
 {
    document.data.oper.value=a;
    document.data.submit();
 }
}

</script>



<BODY>
<center>

<div class=mainbody>

<? include("inc/top.php");?>


<table Border=0 CellSpacing=0 CellPadding=0 width=100%>
  <tr><td class=pageline>
     <div class=wmiddletext><a href="main.php">Администрирование сайта</a> &#187; <a>Импорт прайс-листа</a> </div>
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
?>

<table class=grayhead Border=0 CellSpacing=0 CellPadding=0 >
 <tr class=normaltext>
  <td ><div ><h4>Импорт прайс-листа</h4></div></td>
  <td align=right class=wmiddletext></td>
 </tr>
</table>

<center>
<div id=addform2>
<table Border=0 CellSpacing=0 class=pagebluetable CellPadding=0>
 <tr><td colspan=3 bgcolor=#ffffff height=10></td></tr>
 <tr><td colspan=10 class=blueheadcolor><center><div class=normaltext>ИМПОРТ ПРАЙС-ЛИСТА</div></center></td></tr>
 <tr><td colspan=3 height=1 bgcolor=#ffffff></td></tr>
 <tr><td>
 <center>
 <table cellpadding=2  cellspacing=0 align=center>
 <tr height=40>
    <td class=lmenutext>Файл (.csv):</td>
    <td width=5></td>
    <td><input name='import_file' type=file style="width:250px" class=smalltext></td>
 </tr>
 </table>
 </center>
 </td>

 </tr>
 <tr><td colspan=3 height=1 bgcolor=#ffffff></td></tr>
 <tr><td colspan=10 id=blueheadcolor><center><input type=button onClick=ConfirmSend('I') value='выполнить'  class=smalltext></td></tr>
</table>
</div>
</center>

<br>
<?php
 if((!intval($err)) && (isset($err))) echo"<div class=smalltext align=center style='color:#009900;'><b>Импорт выполнен успешно.</b><br>$cntA позиций добавлено.<br>$cntU позиций измененно.</div>";
 if(intval($err)) echo"<div class=smalltext align=center style='color:red;'>Ошибка при выполнении импорта. Возможно, неверный формат файла.</div>";
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
