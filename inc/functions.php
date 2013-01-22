<?
	function GetStatic($st_code,$field)
{
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

?>