<?php
	$query="select * from {$PREFFIX}_admin
			where binary admin_login='".htmlspecialchars($_POST['login'],ENT_QUOTES)."' and binary admin_pass=MD5('".$_POST['password']."') and admin_active=1";
	$res=@mysql_query($query) or die("Cannot Extract User:$query<br>".mysql_error());
	//echo"$query<br>";
	if (mysql_num_rows($res)!=0)
	{
		$REGUSER["code"]=mysql_result($res,0,"admin_code");
		$REGUSER["name"]=mysql_result($res,0,"admin_name");
		$REGUSER["login"]=mysql_result($res,0,"admin_login");
		$REGUSER["pass"]=mysql_result($res,0,"admin_pass");
		$REGUSER["email"]=mysql_result($res,0,"admin_email");

		// --------------- права -------------------------------------------------------
		$REGUSER["radmin"]=mysql_result($res,0,"admin_radmin");		// право на редактирование других админов
		$REGUSER["rstatic"]=mysql_result($res,0,"admin_rstatic");	// на редактирование стат. страниц
		$REGUSER["ralbum"]=mysql_result($res,0,"admin_ralbum");		// на редактирование галерей (альбомов)
		// -----------------------------------------------------------------------------

		unset($_SESSION["REGUSER"]);
		$_SESSION["REGUSER"]=$REGUSER;
	} else unset($REGUSER);
?>
