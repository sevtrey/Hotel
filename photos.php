<html>
<head>
	<? include("inc/connect.php"); ?>
	<title><?=GetStatic("7","st_seo_title")?></title>
	<meta http-EQUIV="Content-Type" Content="text/html; charset=utf-8">
	<meta name="description" content="<?=GetStatic("7","st_seo_desc")?>" />
	<meta name="keywords" content="<?=GetStatic("7","st_seo_key")?>" />
	<link href="css/style.css" TYPE="text/css" rel="stylesheet">

</head>
<body>
	<? include("menu.php"); ?>
	<br>
	<table width=50% CELLPADDING=0 CELLSPACING=0> <td><?=GetStatic("7","st_abstract")?></td> </table>
	<br><br>
	<table width=50% CELLPADDING=0 CELLSPACING=0> <td><?=GetStatic("7","st_text")?></td> </table>
	<?GetGalleries();?>
</body>
</html>