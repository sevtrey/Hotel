<html>
<head>
	<? 
		//include(admin/inc/head.php);
		include("inc/connect.php");
	?>
	<title><?=GetStatic("3","st_seo_title")?></title>
	<meta http-EQUIV="Content-Type" Content="text/html; charset=utf-8">
	<meta name="description" content="<?=GetStatic("3","st_seo_desc")?>" />
	<meta name="keywords" content="<?=GetStatic("3","st_seo_key")?>" />
	<link href="css/style.css" TYPE="text/css" rel="stylesheet">

</head>
<body>
	<? 
		//include(admin/inc/head.php);
		include("menu.php");
	?>
	<?=GetStatic("3","st_abstract")?>
	<center><?=GetStatic("3","st_text")?></center>
</body>
</html>