<?php
    include("inc/settings.php");
    if (!intval($object_code)) {header("Location: index.php");die();}

    if ($en==1) 
    {
      $lng="_en";  
      $add="(англ)";
    } 
    else 
    {
      $lng="";
      $add="";
    }    
    

if(!isAllowed("rdirectory")) {die("У Вас недостаточно прав для просмотра этой страницы");}

    if (!empty($oper))
    {       
    
    
        $query="update {$PREFFIX}_price set
        object_text$lng='$object_text', 
        object_price$lng='$object_price', 
        object_unit$lng='$object_unit' 
        where object_code=$object_code";
        
//        echo"$query <br>";

        mysql_query($query) or die(mysql_error());

//           echo htmlspecialchars($query)."<br>";
        if ($en==1) header("Location: $PHP_SELF?en=$en&object_code=$object_code&type_code=$type_code&curr_page=$curr_page");
        else header("Location: $PHP_SELF?object_code=$object_code&type_code=$type_code&curr_page=$curr_page");
    }

 $mainquery="SELECT object_name$lng, object_text$lng, object_unit$lng, object_price$lng, spage_code
              FROM {$PREFFIX}_price
              where object_code=$object_code";
//echo $mainquery;
 $res=mysql_query($mainquery);
 list($object_name, $object_text, $object_unit, $object_price, $spage_code)=mysql_fetch_array($res);
 $_SESSION['acode']=$spage_code;

 include ("inc/head.php");

 $editorname='object_text';
 include("inc/editorbigfull.php");
?>                        

<script language="JavaScript">
function Send(a)
{
document.data.oper.value=a;
document.data.submit();
}
</script>
<BODY>
<center>

<div class=mainbody>

<? include("inc/top.php");?>


<table Border=0 CellSpacing=0 CellPadding=0 width=100%>
  <tr><td class=pageline>
     <div class=wmiddletext><a href="main.php">Администрирование сайта</a> &#187; <a href="price.php">Прайс-лист</a></a></div>
  </td></tr>
</table>
&nbsp;


<table Border=0 CellSpacing=0 CellPadding=0 class=mainbody>
 <tr valign=top>

  <td width=10></td>
  <? include("inc/leftmenu.php"); ?>
  <td width=10></td>

  <td>

<table class=grayhead Border=0 CellSpacing=0 CellPadding=0>
 <tr class=normaltext>
  <td ><div ><h4><?=$object_name;?></h4></div></td>
  <td align=right>
  </td>
 </tr>
</table>
        
        
        
<script language="JavaScript"><!--
  
function disbledform(e,num){
                      
                      
if (e.value!=0)
{
 for(j = 0; j < document.data.elements.length; j++)
  { 
    if ((j>3)&&(j!=num)&&(j<10))      
     document.data.elements[j].disabled=true;

  }            
}
else   
 for(j = 0; j < document.data.elements.length; j++)
  { 
    if ((j>3)&&(j!=num)&&(j<10))      
     document.data.elements[j].disabled=false;

  }            
}
  

--></script>        
        

<center>
     <form name=data action=<?=$PHP_SELF;?> method=POST>
     <input type=hidden name=oper>
     <input type=hidden name=en value=<?=$en;?>>
     <input type=hidden name=curr_page value=<?=$curr_page;?>>
     <input type=hidden name=object_code value=<?=$object_code;?>>
     <input type=hidden name=type_code value=<?=$type_code;?>>


<table Border=0 CellSpacing=0 CellPadding=0 width=650>
 <tr><td height=10></td></tr>
 <tr>
  <td bgcolor=#f9f9f9 style='padding:5px'>
  <center>
  <table Border=0 CellSpacing=0 CellPadding=0>
     
     
     <tr><td class=lmenutext align=center><a href='price.php?type_code=<?=$type_code;?>'>[ назад ]</a><br><br>
         
     
     <tr><td class=lmenutext colspan=5><a>Единица измерения <?=$add;?>:</a><br>
       <input name='object_unit' style="width:130px;" value='<?=$object_unit;?>'><p>
     </td></tr>

     <tr><td class=lmenutext colspan=5><a>Цена <?=$add;?>:</a><br>
       <input name='object_price' style="width:130px;" value='<?=$object_price;?>'><p>
     </td></tr>
     

     <tr><td class=lmenutext colspan=5><a>Описание проекта <?=$add;?>:</a><br>
       <textarea name='object_text' style="width:630px;height:400px;"><?=$object_text;?></textarea><p>
     </td></tr>


     
 <tr>
  <td bgcolor=#f9f9f9 height=150>
  <center>
  <table Border=0 CellSpacing=0 CellPadding=0 Width="%" Align="" vAlign="">
     <tr><td height=25 class=lmenutext><a>Изображения:</a></td></tr>
     <tr><td>
       <iframe src="spicture.php?code=<?=$spage_code;?>" width="630" height="400" scrolling="auto" frameborder=1></IFRAME>
     </td></tr>
  </table>
  </td>
 </tr>
 

  </table>
  </td>
 </tr>    
 
 

 

 <tr><td height=10 bgcolor=#f9f9f9 height=0></td></tr>
 <tr><td bgcolor=#f9f9f9 ><center><input type=submit class=smalltext value='сохранить изменения' onClick=Send('I')></td></tr>
 <tr><td height=10 bgcolor=#f9f9f9 height=0></td></tr>
 <tr><td height=10 height=0></td></tr>
</table>
</form>
 

<table Border=0 CellSpacing=0 CellPadding=0 width=650>
 <tr><td height=10></td></tr>
     <tr><td class=lmenutext align=center><a href='price.php?type_code=<?=$type_code;?>'>[ назад ]</a><br><br>
</table>

</center>

  </td>
    <td width=10></td>
</tr>

</table>
</div>
</center>

</BODY>
</HTML>
