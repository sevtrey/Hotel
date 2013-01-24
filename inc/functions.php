<?
function GetStatic($st_code,$field)
{
	if(!$st_code)
		return "error";
	$query = "SELECT * FROM hotel_static WHERE (static_code='$st_code');";//находим строку
	$res = mysql_query($query);//выполняем запрос
	list($static_code,$static_title,$static_abstract,$static_text,$static_seo_title,$static_seo_desc,$static_seo_key,$static_type)=mysql_fetch_array($res);
	switch($field) 
	{
		case "st_title": return $static_title;
		case "st_abstract": return $static_abstract;
		case "st_text": return $static_text;
		case "st_seo_title": return $static_seo_title;
		case "st_seo_desc": return $static_seo_desc;
		case "st_seo_key": return $static_seo_key;
		case "st_type": return $static_type;
		default: echo "Error";
	}
}

function GetGalleries()
{
	$query = "SELECT * FROM hotel_static WHERE (static_type='gallery');";
	$res1 = mysql_query($query);//выполняем запрос
	$i=1;
	?>
	<table width=450 border=0>
	<?
    while (list($static_code,$static_title,$static_abstract,$static_text,$static_seo_title,$static_seo_desc,$static_seo_key,$static_type) = mysql_fetch_array($res1))
	{
		if($i > 0)
			if($i % 3 == 1)
				echo "<tr>";
		echo "<td width = 150 align='center'> $static_title <br>";
		$query = "SELECT * FROM hotel_picture WHERE (static_code='$static_code') AND (picpos='1');";//находим строку
		$res = mysql_query($query);//выполняем запрос
		list($picture_code,$static_code,$picsmall,$picbig,$picpos,$piccomment)=mysql_fetch_array($res);
		?> <a href=<?echo "images.php?static_code=$static_code&type=$static_type";?>><img height=100 src=<?echo "images/$picsmall"?>  alt= <?$piccomment?> ></a>
		<?
		echo "</td>";
		if($i % 3 == 0) 
			echo "</tr>";
		$i++;
	}
	?>
	</table>
	<?
}	

function GetImages($static_code)
{
	$i=1;
	$query = "SELECT * FROM hotel_picture WHERE (static_code='$static_code') AND (picpos='$i');";
	$res = mysql_query($query);//выполняем запрос
	?>
	<table width=450 border=0>
	<?
    while (list($picture_code,$static_code,$picsmall,$picbig,$picpos,$piccomment)=mysql_fetch_array($res))
	{
		if($i > 0)
			if($i % 3 == 1)
				echo "<tr>";
		echo "<td width = 150 align='center'>";
		//<a href=<?echo "images.php?static_code=$static_code&type=$static_type";><img height=100 src=echo "images/$picsmall"  alt= <?$piccomment ></a>
		?>
		<img height=100 src=<? echo "images/$picsmall" ?> alt = <?$piccomment?> title = <?$piccomment?>>
		<?
		echo "</td>";
		$i++;
		$query = "SELECT * FROM hotel_picture WHERE (static_code='$static_code') AND (picpos='$i');";//находим строку
		$res = mysql_query($query);//выполняем запрос
		if($i % 3 == 0) 
			echo "</tr>";
	}
	?>
	</table>
	<?
}
?>