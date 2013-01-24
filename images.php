<html>
<head>
	<? 
	include("inc/connect.php");
	$static_code = $_GET['static_code'];
	?>
	<meta http-EQUIV="Content-Type" Content="text/html"; charset='utf-8'>
	<title><?=GetStatic($static_code,"st_seo_title")?></title>
	<meta name="description" content="<?=GetStatic($static_code,"st_seo_desc")?>" />
	<meta name="keywords" content="<?=GetStatic($static_code,"st_seo_key")?>" />
		<style>
			body{font:12px/1.2 Verdana, sans-serif; padding:0 10px;}
			a:link, a:visited{text-decoration:none; color:#416CE5; border-bottom:1px solid #416CE5;}
			h2{font-size:13px; margin:15px 0 0 0;}
		</style>
		<link rel="stylesheet" href="style/colorbox.css" />
		<script src="js/jquery.min.js"></script>
		<script src="js/jquery.colorbox.js"></script>
		<script>
			$(document).ready(function(){
				$(".group1").colorbox({rel:'group1'});
				//$(".ajax").colorbox();
				$(".callbacks").colorbox({
					onOpen:function(){ alert('onOpen: colorbox is about to open'); },
					onLoad:function(){ alert('onLoad: colorbox has started to load the targeted content'); },
					onComplete:function(){ alert('onComplete: colorbox has displayed the loaded content'); },
					onCleanup:function(){ alert('onCleanup: colorbox has begun the close process'); },
					onClosed:function(){ alert('onClosed: colorbox has completely closed'); }
				});
				
				//Example of preserving a JavaScript event for inline calls.
				$("#click").click(function(){ 
					$('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
					return false;
				});
			});
		</script>
</head>
<body>

	<? include("menu.php"); ?>
	<br>
	<table width=50% CELLPADDING=0 CELLSPACING=0> <td><?=GetStatic("7","st_abstract")?></td> </table>
	<br><br>
	<table width=50% CELLPADDING=0 CELLSPACING=0> <td><?=GetStatic("7","st_text")?></td> </table>
	<?GetImages($static_code);?>
</body>
</html>