<?php
	include("inc/settings.php");
	
	if (!intval($admin_code)) {die("Ошибка: администратор не задан");}
	$oper=$_POST['oper'];

	if(!isAllowed("radmin")) {die("У Вас недостаточно прав для просмотра этой страницы");}

    list($admin_name,$admin_login)=mysql_fetch_array(mysql_query("select admin_name,admin_login from {$PREFFIX}_admin where admin_code=$admin_code"));

    if (!empty($oper))
    {
        $err=0;
        $admin_c = $_POST["admin_code"];
        foreach($_POST as $name=>$val) if($val=="on") $$name=1;else $$name=0; //$_POST["$name"]=1;else $_POST["$name"]=0;
        $admin_code = $admin_c;
        $query="update {$PREFFIX}_admin set
        admin_rstatic    = ".intval($admin_rstatic).",
        admin_ralbum     = ".intval($admin_ralbum).",       
        admin_radmin     = ".intval($admin_radmin)."
        where admin_code = ".intval($admin_code);
        mysql_query($query) or $err=1; //die("ошибка редактирования:<br>$query<br>".mysql_error());
        header("Location: $PHP_SELF?admin_code=$admin_code&err=$err");
    }

    $mainquery="select admin_rstatic, admin_ralbum, admin_radmin  
				from {$PREFFIX}_admin where admin_code=$admin_code";
    $res=mysql_query($mainquery);
    list($admin_rstatic,$admin_ralbum,$admin_radmin)=mysql_fetch_array($res);
?>

<? include ("inc/head.php"); ?>

<script language = JavaScript>
function Send(a)
{
	document.data.oper.value=a;
	document.data.submit();
}
</script>

<BODY>
<center>
	<table Border=0 CellSpacing=0 CellPadding=0 class=mainbody>
		 <tr valign=top>

		  <td>

		<?php
		echo"<form name='data' action=$PHP_SELF method=POST>";
		echo"<input type=hidden name='oper' value=''>";
		echo"<input type=hidden name=admin_code value=\"$admin_code\">";
		?>

		<table class=grayhead Border=0 CellSpacing=0 CellPadding=0 >
		 <tr class=normaltext>
		  <td ><div ><h4>Редактирование прав доступа для администратора "<?=$admin_name." (Логин: $admin_login)"?>"</h4></div></td>
		  <td align=right class=wmiddletext></td>
		 </tr>
	</table>

	<table Border=0 CellSpacing=0 class=pagebluetable CellPadding=0 >
	 <tr><td class=lmenutext height=30 bgcolor=#ffffff align="center"><u>Отредактируйте права администратора:</u></td></tr>
	</table>
	<table Border=0 CellSpacing=1 class=bluetable CellPadding=4 width=50% align=center>
		<tr class=edittabletext height=18 bgcolor="#FFFFFF">
		 <td width=20 align=center ><input type='checkbox' id="admin_radmin" name="admin_radmin" <?php if($admin_radmin) echo" checked";?>></td><td><label for="admin_radmin">Управление администрированием и правами доступа</label></td>
		 </tr>
		<tr class=edittabletext height=18 bgcolor="#FFFFFF">
		 <td width=20 align=center ><input type='checkbox' id="admin_rstatic" name="admin_rstatic" <?php if($admin_rstatic) echo" checked";?>></td><td><label for="admin_rstatic">Управление текстовыми страницами</label></td>     
		</tr>
	</table>

	<table Border=0 CellSpacing=1 class=bluetable CellPadding=4 width=50% align=center>
		<tr class=edittabletext height=18 bgcolor="#FFFFFF">
		 <td width=20 align=center ><input type='checkbox' id="admin_ralbum" name="admin_ralbum" <?php if($admin_ralbum) echo" checked";?>></td><td><label for="admin_ralbum">Управление галереями</label></td>
		</tr>
	</table>

	<?php
		if(intval($err)>=1) echo"<div class=smalltext align=center style='color:red;'>Ошибка при сохранении данных</div>";
		if((isset($err))&&(intval($err)==0)) echo"<div class=smalltext align=center style='color:#009900;'>Данные измененены</div>";
	?>

	<table Border=0 CellSpacing=0 class=pagebluetable CellPadding=0 width=95%>
	 <tr height=30><td align="center">
		<input type=button onClick=Send('I') value='сохранить изменения' class=smalltext></td>
	 </tr>
	 </table>

	 </td></tr>
	</table>

	</form>
	  </td>
		<td width=10></td>
	</tr>

	</table>
</center>

</BODY>
</HTML>
