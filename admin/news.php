<?php
	include("inc/settings.php");
	$per_page=30;
	$oper=$_POST['oper'];

	if(!isAllowed("rnews")) {die("У Вас недостаточно прав для просмотра этой страницы");}
	if (!isset($curr_page)) $curr_page=0;
	$_SESSION["pageback"]="newspage.php?curr_page=$curr_page";
	
	if(!($sortby)) $sortby='news_date'; else {$sortby=explode(" ",$sortby);$sortby=$sortby[0];}

	if(!isset($sortdir)) {$sortdir="1";$realsortdir="ASC"; }
	else 
	{
		if($sortdir==0) {$realsortdir="DESC";} else {$sortdir=1;$realsortdir="ASC";} 
	}                                                                                                   



	$mainquery="SELECT
				{$PREFFIX}_news.news_code,
				{$PREFFIX}_news.news_date,
				{$PREFFIX}_news.news_url,
				{$PREFFIX}_page.page_code,
				{$PREFFIX}_page.page_name,
				{$PREFFIX}_page.page_active
				FROM
				{$PREFFIX}_news
				INNER JOIN {$PREFFIX}_page ON {$PREFFIX}_news.page_code = {$PREFFIX}_page.page_code
				order by $sortby $realsortdir";
	//echo $mainquery;
	if (!empty($oper))
	{

		if ($oper=='I')
		{
			$err=0;
			mysql_query("start transaction;");
			$query="insert into {$PREFFIX}_page (page_name,  page_active, page_type) values('$page_name',1,'news')";
			$result=mysql_query($query) or $err=1;//die("Не могу добавить страницу:<br>$query<br>".mysql_error());
			if (!$err)
			{	
				$page_code=mysql_insert_id();
				$query="insert into {$PREFFIX}_news (news_date,news_url,page_code) values('$news_date','$news_url',$page_code)";
				$result=mysql_query($query) or $err=1;//die("Не могу добавить страницу:<br>$query<br>".mysql_error());
				$news_code=mysql_insert_id();
			}

			if(!$err)
			{
				mysql_query("commit;");
				//для постраничного-------------------------------------------------------------
				$result=mysql_query($mainquery) or die("Incorrect News Query ".mainquery) ;
			}
			else mysql_query("rollback;");
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
				if ( ($varName=="C")&&($value=="on"))
				{
					$err=0;
					$query = "delete from {$PREFFIX}_page where page_code=$varCode";
					$resultdel = mysql_query($query) or $err+=10;

					$query = "delete from {$PREFFIX}_news where page_code=$varCode";
					$resultdel = mysql_query($query) or $err+=10;
				}
			} 
		}

		if (!strcasecmp($oper,"U"))
		{
			$err=0;
			while (list($key,$value)=each($_POST))
			{
				$arr=explode('#',$key);
				$varName=$arr[0];
				$varCode=$arr[1];
				$varField=$arr[2];
				$varType=$arr[3];

				if ($_POST["C#$varCode"]=="on")
				{
					$flag=0;
					if ($varName=="F")
					{
						$fieldname=$varField;
						$tablename=strtok($fieldname,'_'); //Смотрим, какую таблицу править      	
						if ($varType=="string") $tmp="'"; else $tmp="";
						$sqlupd = "update {$PREFFIX}_{$tablename} set $varField=$tmp".$value."$tmp  where page_code=$varCode";
						$resultupd = MYSQL_QUERY($sqlupd) or $err-=10;
					}
				}
			}

		}
		if($sortby) $tmp="&sortby=$sortby&sortdir=$sortdir"; else $tmp="";
		header("Location: $PHP_SELF?err=$err$tmp");
	}
?>

<? include ("inc/head.php"); ?>

<script language = JavaScript>
function Send(a)
{
	document.data.oper.value=a;
	document.data.submit();
}
                
function change_yes_no(Check,Unit)
{
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
	if (confirm('Вы уверены, что хотите удалить новость?'))
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
     <div class=wmiddletext><a href="main.php">Администрирование сайта</a> &#187; <a><?=$part_name;?></a></div>
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
	echo"<form name='data' action=$PHP_SELF method=POST>";
	echo"<input type=hidden name='oper' value=''>";
	echo"<input type=hidden name=curr_page value=\"$curr_page\">";
	echo"<input type=hidden name=sortby value=\"$sortby\">";
	echo"<input type=hidden name=sortdir value=\"$sortdir\">";
?>

<table class=grayhead Border=0 CellSpacing=0 CellPadding=0 >
 <tr class=normaltext>
  <td ><div ><h4><?=$part_name;?></h4></div></td>
  <td align=right class=wmiddletext><a class=submenu onclick="displayform(this,'добавить новость')">добавить новость</a></td>  
 </tr>
</table>

<div id=addform>
<table Border=0 CellSpacing=0 class=pagebluetable CellPadding=0>
 <tr><td colspan=3 bgcolor=#ffffff height=10></td></tr>
 <tr><td colspan=10 class=blueheadcolor><center><div class=normaltext>ДОБАВИТЬ НОВОСТЬ</div></center></td></tr>
 <tr><td colspan=3 height=1 bgcolor=#ffffff></td></tr>
 <tr><td>
 <center>
  <table cellpadding=2  cellspacing=0>
 <tr height=30 >
    <td class=lmenutext>Дата (ГГГГ-ММ-ДД):</td>
    <td width=5></td>
    <td><input name='news_date' type=text style="width:250px" class=smalltext value='<?=date("Y-m-d");?>'></td>
 </tr>
 <tr height=30 >
    <td class=lmenutext>Кратко о чем:</td>
    <td width=5></td>
    <td><input name='page_name' type=text style="width:250px" class=smalltext></td>
 </tr>
 <tr height=30 >
    <td class=lmenutext> URL: </td>
    <td width=5></td>
    <td><input name='news_url' type=text style="width:250px" class=smalltext></td>
 </tr> 
 </table>
 </td>

 <td class=helpzone>

     <table Border=0 CellSpacing=1 CellPadding=0 bgcolor=#999999 class=helptable>
       <tr>
        <td class=helptd>

             <div class=ssmalltext>
                Заполните поля формы и нажмите кнопку "добавить новость". </a>
             </div>

        </td>
       </tr>
     </table>

 </td>


 </tr>
 <tr><td colspan=3 height=1 bgcolor=#ffffff></td></tr>
 <tr> <td colspan=10 id=blueheadcolor><center><input type=button onClick=Send('I') value='добавить новость'  class=smalltext> </td></tr>
</table>
</div>


<table Border=0 CellSpacing=0 class=pagebluetable CellPadding=0 >
 <tr><td class=lmenutext height=30 bgcolor=#ffffff align="center">СПИСОК ДОБАВЛЕННЫХ НОВОСТЕЙ</td></tr>
</table>

<?php
	if(intval($err)<=-10) echo"<div class=smalltext align=center style='color:red;'>Ошибка при изменении новости</div>";
	if(intval($err)>=10) echo"<div class=smalltext align=center style='color:red;'>Ошибка при удалении новости</div>";
	if(intval($err)==1) echo"<div class=smalltext align=center style='color:red;'>Ошибка при добавлении новости</div>";
?>


<table Border=0 CellSpacing=0 class=pagebluetable CellPadding=0>
 <tr><td>
 <center>
 <table>
 <tr height=30 >
   <td><input type=button onClick=Send('U') value='изменить отмеченные' class=smalltext></td> 
   <td width=5></td>
   <td><input type=button onClick=ConfirmSend('D') value='удалить отмеченные'  class=smalltext></td>
 </tr>

 </table>
 </td></tr>
</table>

<center>
<table Border=0 CellSpacing=1 class=bluetable CellPadding=4 width=100%>
  <tr class=lmenutext height=20 align=center bgcolor=#ffffff>
    <td width=20>&nbsp;</td>
    <td width="80"><?=SortTitle("Дата","news_date",$sortby,$sortdir);?></td>
    <td><?=SortTitle("Заголовок","page_name",$sortby,$sortdir);?></td>
    <td width="50"><?=SortTitle("Активность","page_active",$sortby,$sortdir);?></td>
    <td width="180"><?=SortTitle("URL","news_URL",$sortby,$sortdir);?></td>
    <td width=40>Текст</td>
    <!-- <td width=40>SEO</td> -->
    <td width=30>Фотогалерея</td>
  </tr>
  
<?php
	$res=mysql_query ($mainquery) or die ("Не могу выбрать страницы. Ошибка в запросе.");
	$num_rows=mysql_num_rows($res);  //Количество строк  
	if($num_rows)
	{
		$page_quant=ceil($num_rows / $per_page); //всего страниц
		$start_pos=$curr_page*$per_page;
		if ($start_pos+$per_page<$num_rows) $end_pos=$start_pos+$per_page;
		else $end_pos=$num_rows;
		mysql_data_seek($res,$start_pos);
		for ($x=$start_pos; $x<$end_pos; $x++)
		{
			list($news_code,$news_date,$news_url,$page_code, $page_name, $page_active)=mysql_fetch_array($res);
			$checkname=$page_code;            
			if($page_active) {$page_active="да";$bg="#FFFFFF";} else {$page_active="нет";$bg="#EEEEEE";}    
			echo"<tr class=edittabletext height=24 bgcolor=$bg>";
			echo"<TD width=20 align=center ><input type='checkbox' name=\"C#$checkname\" id=\"C#$checkname\"></TD>";
			echo"<TD align=left class=smalltext ondblclick='change_line(\"$checkname\",\"F#$checkname#news_date#string\");' id=\"F#$checkname#news_date#string\">".Show($news_date)."</TD>\n";
			echo"<TD align=left class=smalltext ondblclick='change_line(\"$checkname\",\"F#$checkname#page_name#string\");' id=\"F#$checkname#page_name#string\">".Show($page_name)."</TD>\n";
			echo"<TD class=smalltext align=center  ondblclick='change_yes_no(\"$checkname\",\"F#$checkname#page_active#int\");' id=\"F#$checkname#page_active#int\">".Show($page_active)."</TD>\n";
			echo"<TD align=center class=smalltext ondblclick='change_line(\"$checkname\",\"F#$checkname#news_url#string\");' id=\"F#$checkname#news_url#string\">".Show($news_url)."</TD>\n"; 
			echo"<td align=center ><a href='editstatic.php?page_code=$page_code&page_name=$page_name'><img height='20' width='20' src='graph/edit.gif' border=0 title='Редактировать текст новости'></a></td>";
			echo"<td><center><a href=\"picture.php?back=statlist&icon=250&page_code=$page_code\"><img height='24' width='24' src='graph/photo.gif' border=0 alt='Фотогалерея ' title='Редактировать фотогалерею'></a></td>";
			echo"</TR>\n";
		}
	}
?>

</table>
</center>

<table Border=0 CellSpacing=0 class=pagebluetable CellPadding=0 width=95%>
 <tr><td>
 <center>
 <table>
 <tr height=30 >
   <td><input type=button onClick=Send('U') value='изменить отмеченные' class=smalltext></td> 
   <td width=5></td>
   <td><input type=button onClick=ConfirmSend('D') value='удалить отмеченные'  class=smalltext></td>
 </tr>
 </table>
 </td></tr>
</table>

<br>
<?php
	{
		echo"<div align=left class=smalltext><b>Страницы:</b>  ";
		for ($i=1;$i<$page_quant+1;$i++)
		{
			$y=$i-1;
			if ($curr_page==$y) {$t1="<b>";$t2="</b>";} else {$t1="";$t2="";}
			echo"<a class=blue href=$PHP_SELF?curr_page=$y&sortby=$sortby&sortdir=$sortdir>$t1 $i $t2|</a>&nbsp";
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

