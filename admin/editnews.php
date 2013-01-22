<?php
    include("inc/settings.php");
    if (!intval($news_code)) {header("Location: index.php");die();}

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
    

if(!isAllowed("rnews")) {die("У Вас недостаточно прав для просмотра этой страницы");}

    if (!empty($oper))
    {       
    
    
   

        $query="update {$PREFFIX}_news set
        news_short$lng='$news_short', 
        news_text$lng='$news_text' 
        where news_code=$news_code";
        
//        echo"$query <br>";

        mysql_query($query) or die(mysql_error());

//           echo htmlspecialchars($query)."<br>";
        if ($en==1) header("Location: $PHP_SELF?en=$en&news_code=$news_code&curr_page=$curr_page");
        else header("Location: $PHP_SELF?news_code=$news_code&curr_page=$curr_page");
    }

 $mainquery="SELECT news_name$lng, news_short$lng, news_text$lng
              FROM {$PREFFIX}_news
              where news_code=$news_code";
//echo $mainquery;
 $res=mysql_query($mainquery);
 list($news_name, $news_short, $news_text)=mysql_fetch_array($res);
 $_SESSION['acode']=$spage_code;

 include ("inc/head.php");

 $editorname='news_text,news_short';
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
     <div class=wmiddletext><a href="main.php">Администрирование сайта</a> &#187; <a href="news.php">Новости</a> &#187; <a href=""><? echo"$news_name";?></a></div>
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
  <td ><div ><h4><?=$news_name;?></h4></div></td>
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
     <input type=hidden name=news_code value=<?=$news_code;?>>


<table Border=0 CellSpacing=0 CellPadding=0 width=650>
 <tr><td height=10></td></tr>
 <tr>
  <td bgcolor=#f9f9f9 style='padding:5px'>
  <center>
  <table Border=0 CellSpacing=0 CellPadding=0>
     
     
     <tr><td class=lmenutext align=center colspan=5><a href="news.php?curr_page=<?=$curr_page;?>">[ назад ]</a><br><br><br></td></tr>
         
     <tr><td class=lmenutext colspan=5><a>Аннотация <?=$add;?>:</a><br>
       <textarea name='news_short' style="width:630px;height:80px;"><?=$news_short;?></textarea><p>
     </td></tr>
     
     <tr><td height=5></td></tr>

     <tr><td class=lmenutext colspan=5><a>Полный текст <?=$add;?>:</a><br>
       <textarea name='news_text' style="width:630px;height:400px;"><?=$news_text;?></textarea><p>
     </td></tr>
     

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
     <tr><td class=lmenutext align=center><a href="news.php?curr_page=<?=$curr_page;?>">[ назад ]</a><br><br>
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
