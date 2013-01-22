<?php


function writemapxml($url)
{
    
   global $PREFFIX;
   $xmlfile = fopen($url,"w");

   fputs ($xmlfile,"<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n");
   fputs ($xmlfile,"<points>\n");
                        
   
   $pointquery="select point_code,point_name,point_x,point_y from {$PREFFIX}_mappoint where point_active=1 order by point_pos";                     
   $pointres=mysql_query($pointquery) or die(mysql_error());
   while(list($point_code,$point_name,$point_x,$point_y)=mysql_fetch_array($pointres))   
   {
       $point_name = iconv("CP1251","UTF-8",$point_name);  
       $pointstr=" <point x=\"$point_x\" y=\"$point_y\" name=\"$point_name\">\n";
       fputs ($xmlfile,$pointstr);

          $itemquery="select unit_name,unit_link from {$PREFFIX}_mapunit where point_code=$point_code and unit_active=1 order by unit_pos";                     
          $itemres=mysql_query($itemquery) or die(mysql_error());
          while(list($item_name,$item_link)=mysql_fetch_array($itemres))   
          { 
               $item_name = iconv("CP1251","UTF-8",$item_name);  
               $itemstr="   <item name=\"$item_name\" link=\"$item_link\"/>\n";
               fputs ($xmlfile,$itemstr);
          }
   
       fputs ($xmlfile," </point>\n");
   
   } 

   fputs ($xmlfile,"</points>\n");
   fclose ($xmlfile);
}


function writegamexml($url)
{
    
   global $PREFFIX;
   
   $probabquery="select probab_value from {$PREFFIX}_probab limit 1";                     
   $probabres=mysql_query($probabquery) or die(mysql_error());
   list($pro_value)=mysql_fetch_array($probabres);   

   
   $xmlfile = fopen($url,"w");

   
   fputs ($xmlfile,"<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n");
   fputs ($xmlfile,"<game>\n");
   fputs ($xmlfile," <probability>$pro_value</probability>\n");
   fputs ($xmlfile," <discounts>\n");


   $discountquery="select discount_value,discount_num,discount_purpose from {$PREFFIX}_discount order by discount_value";                     
   $discountres=mysql_query($discountquery) or die(mysql_error());
   while(list($d_value,$d_num,$discount_purpose)=mysql_fetch_array($discountres))   
   {
       $discount_purpose = iconv("CP1251","UTF-8",$discount_purpose);  
       $dstr="   <discount value=\"$d_value\" Number=\"$d_num\" key=\"$discount_purpose\" text=\"$discount_purpose\" />\n";
       fputs ($xmlfile,$dstr);
   } 
   fputs ($xmlfile," </discounts>\n");
   fputs ($xmlfile,"</game>\n");
   fclose ($xmlfile);

}




// url ВБООЕТБ РП УФТБОЙГЕ
function getbanner($pl_code,$lim)
{
  $thisday=date("Y-m-d");

  $bquery="SELECT banner_file, banner_alt, banner_url, banner_link 
           FROM fmradio_banner 
           WHERE banner_start<='$thisday' and banner_stop>='$thisday' and  place_code=$pl_code
           order by rand() limit $lim";
  // echo"$bquery<br>";
  $bres=mysql_query($bquery);                              
  $num_rows=mysql_num_rows($bres);
  
  if ($num_rows=0)
  { 
    $getbanner="";
    return($getbanner);
  }
  else 
  {
    while(list($b_file,$b_alt,$b_url,$b_link)=mysql_fetch_array($bres))
    {
       if (strlen($b_file)>0)
       {
         $getbanner="<a href='".$b_url."' target=_blank><img src='banners/".$b_file."' border=0 alt='".$b_alt."'></a>";
       }
       else 
       {  
         if (strlen($b_link)>0)  $getbanner=$b_link;
       }
    }
  }   
  return($getbanner);
}         
         
   
// url ДМС 3-И ВБООЕТПЧ Ч ФПРЕ
function get3banner($pl_code,$lim)
{
  $thisday=date("Y-m-d");

  $bquery="SELECT banner_file, banner_alt, banner_url, banner_link 
           FROM fmradio_banner 
           WHERE banner_start<='$thisday' and banner_stop>='$thisday' and  place_code=$pl_code
           order by rand() limit $lim";
  // echo"$bquery<br>";
  $bres=mysql_query($bquery);                              
  $num_rows=mysql_num_rows($bres);
//  echo"$num_rows<br>";
  if ($num_rows=0)
  { 
    $getbanner="";
    return($getbanner);
  }
  else 
  {
    $getbanner="<table Border=0 CellSpacing=3 CellPadding=0 ><tr>";
    while(list($b_file,$b_alt,$b_url,$b_link)=mysql_fetch_array($bres))
    {
       if (strlen($b_file)>0)
       {
         $getbanner=$getbanner."<td class=bannertd><a href='".$b_url."' target=_blank><img src='banners/".$b_file."' border=0 alt='".$b_alt."'></a></td><td><img src=graph/blank.gif width=1 height=1 border=0></td>";
       }
       else 
       {  
         if (strlen($b_link)>0)  $getbanner=$getbanner."<td class=bannertd>".$b_link."</td><td><img src=graph/blank.gif width=1 height=1 border=0></td>";
       }
    } 
    $getbanner=$getbanner."</tr></table>";
  }   
  return($getbanner);
}         








function Show($val)
{    if (trim($val)=="") return "&nbsp"; else return $val; }

function  DevideFile($filename,&$name,&$ext)
{
  $p=strrpos($filename,".");
  $name=substr($filename,0,$p);
  $ext=substr($filename,$p+1,strlen($filename)-$p);
}

  // функция нормализации для генерации text_id
  function Normalize($st)
  {
    $st=preg_replace("/[^a-zA-Z0-9 ]/si","-",$st);
    $st=str_replace(" ","-",$st);
    // Возвращаем результат.
    return strtolower($st);
  }

  // функция превода текста с кириллицы в траскрипт
  function translit($st)
  {
    // Сначала заменяем "односимвольные" фонемы.
    $st=strtr($st,"абвгдеёзийклмнопрстуфхъыэ_",
                  "abvgdeeziyklmnoprstufh-ie");
    $st=strtr($st,"АБВГДЕЁЗИЙКЛМНОПРСТУФХЪЫЭ_",
                  "ABVGDEEZIYKLMNOPRSTUFH-IE");
    // Затем - "многосимвольные".
    $st=strtr($st,
                    array(
                        "ж"=>"zh", "ц"=>"ts", "ч"=>"ch", "ш"=>"sh",
                        "щ"=>"sch","ь"=>"", "ю"=>"yu", "я"=>"ya",
                        "Ж"=>"ZH", "Ц"=>"TS", "Ч"=>"CH", "Ш"=>"SH",
                        "Щ"=>"SHCH","Ь"=>"", "Ю"=>"YU", "Я"=>"YA",
                        "ї"=>"i", "Ї"=>"Yi", "є"=>"ie", "Є"=>"Ye"
                        )
             );

     $st=Normalize($st);
    // Возвращаем результат.
    return $st;
  }

function SortTitle($title,$fieldname,$sortby,$sortdir)
{
  $baseurl=preg_replace("/&sortby=.*/i","",$_SERVER['REQUEST_URI']);
  $baseurl=preg_replace("/&sortdir=[0|1]/i","",$baseurl);
  if(!strpos($baseurl,"?")) $baseurl.="?a=1";
  if($fieldname==$sortby)
  {
       $t1="<u>";$t2="</u>";
       if($sortdir==1) $c1="border=1";else $c1="border=0";
       if($sortdir==0) $c0="border=1";else $c0="border=0";
  }
  else { $t1=$t2=""; $c1=$c0="border=0"; }
  return "<a href=\"$baseurl&sortby=$fieldname&sortdir=0\" ><img class=\"arr\" title=\"сортировать по возрастанию\" alt=\"сортировать по возрастанию\" src=\"graph/uarr.gif\" width=9 height=10 $c0></a>&nbsp;{$t1}$title{$t2}&nbsp;<a href=\"$baseurl&sortby=$fieldname&sortdir=1\"><img class=\"arr\" title=\"сортировать по убыванию\" alt=\"сортировать по убыванию\" src=\"graph/darr.gif\" width=9 height=10 $c1 ></a></div>";
}

function mime_type($fname)
{
  DevideFile($fname,$name,$ext);
  $f=fopen("types.mime","r");
  while($st=fgets($f))
  {
    $s=substr($st,0,strlen($st)-2);
      $a=explode(" ",$s);
      if (in_array($ext,$a)) {fclose($f);return $a[0];}
  }
  fclose($f);
  return "application/octet-stream";
}


function  DeleteMusic($album_code)
{
  global $PREFFIX;
  $res=mysql_query("select music_file from {$PREFFIX}_music where album_code=$album_code");
  while(list($music_file)=mysql_fetch_array($res))
  {
      unlink("../music/".$music_file);
  }
  mysql_query("delete from {$PREFFIX}_music where album_code=$album_code");
}

function  DeleteSpage($spage_code)
{
  global $PREFFIX;
  $res=mysql_query("select spicsmall,spicbig from {$PREFFIX}_spicture where spage_code=$spage_code");
  while(list($spicsmall,$spicbig)=mysql_fetch_array($res))
  {
      unlink("../images/".$spicsmall);
      unlink("../images/".$spicbig);
  }
  mysql_query("delete from {$PREFFIX}_spicture where spage_code=$spage_code");
  mysql_query("delete from {$PREFFIX}_spage where spage_code=$spage_code");
}

function  DeletePage($page_code)
{
  global $PREFFIX;
  $res=mysql_query("select picsmall,picbig from {$PREFFIX}_picture where page_code=$page_code");
  while(list($picsmall,$picbig)=mysql_fetch_array($res))
  {
      unlink("../images/".$picsmall);
      unlink("../images/".$picbig);
  }
  mysql_query("delete from {$PREFFIX}_picture where page_code=$page_code");
  mysql_query("delete from {$PREFFIX}_page where page_code=$page_code");
}

function  DeleteSMIPage($smipage_code)
{
  global $PREFFIX;
  $res=mysql_query("select picsmall,picmed,picbig from {$PREFFIX}_smipicture where smipage_code=$smipage_code");
  while(list($picsmall,$picmed,$picbig)=mysql_fetch_array($res))
  {
      unlink("../images/".$picsmall);
      unlink("../images/".$picmed);
      unlink("../images/".$picbig);
  }
  mysql_query("delete from {$PREFFIX}_smipicture where smipage_code=$smipage_code");
  mysql_query("delete from {$PREFFIX}_smipage where smipage_code=$smipage_code");
}

function  DeleteSMIAudioPage($smiaudiopage_code)
{
  global $PREFFIX;
  $res=mysql_query("select smiaudio_file1,smiaudio_file2 from {$PREFFIX}_smiaudio where smiaudiopage_code=$smiaudiopage_code");
  while(list($smiaudio_file1,$smiaudio_file2)=mysql_fetch_array($res))
  {
      unlink("../smiaudio/".$smiaudio_file1);
      unlink("../smiaudio/".$smiaudio_file2);
  }
  mysql_query("delete from {$PREFFIX}_smiaudio where smiaudiopage_code=$smiaudiopage_code");
  mysql_query("delete from {$PREFFIX}_smiaudiopage where smiaudiopage_code=$smiaudiopage_code");
}

function  DeleteSMIVideoPage($smivideopage_code)
{
  global $PREFFIX;
  $res=mysql_query("select smivideo_file from {$PREFFIX}_smivideo where smivideopage_code=$smivideopage_code");
  while(list($smivideo_file)=mysql_fetch_array($res))
  {
      unlink("../smivideo/".$smivideo_file);
  }
  mysql_query("delete from {$PREFFIX}_smivideo where smivideopage_code=$smivideopage_code");
  mysql_query("delete from {$PREFFIX}_smivideopage where smivideopage_code=$smivideopage_code");
}

function  DeleteSMIFilePage($smifilepage_code)
{
  global $PREFFIX;
  $res=mysql_query("select smifile_file from {$PREFFIX}_smifile where smifilepage_code=$smifilepage_code");
  while(list($smifile_file)=mysql_fetch_array($res))
  {
      unlink("../smifiles/".$smifile_file);
  }
  mysql_query("delete from {$PREFFIX}_smifile where smifilepage_code=$smifilepage_code");
  mysql_query("delete from {$PREFFIX}_smifilepage where smifilepage_code=$smifilepage_code");
}

function  DeleteHDPage($hdpage_code)
{
  global $PREFFIX;
  $res=mysql_query("select picsmall,picbig from {$PREFFIX}_hdpicture where hdpage_code=$hdpage_code");
  while(list($picsmall,$picbig)=mysql_fetch_array($res))
  {
      unlink("../images/".$picsmall);
      unlink("../images/".$picbig);
  }
  mysql_query("delete from {$PREFFIX}_hdpicture where hdpage_code=$hdpage_code");
  mysql_query("delete from {$PREFFIX}_hdpage where hdpage_code=$hdpage_code");
}


// возвращает ID по названию категории указанного языка. Учитывается совпадающие имена и конфликт решается счетчиком
function genID($name,$lng="")
{
  global $PREFFIX;
  if($lng=="")  $base_id=$id=Normalize(translit($name));
  else $base_id=$id=Normalize($name);
  $cnt=1;
  $res=mysql_query("select category_code from {$PREFFIX}_category where category_textid='$id'");
  while (mysql_num_rows($res)!=0)
  {
     $id=$base_id.$cnt;
    $res=mysql_query("select category_code from {$PREFFIX}_category where category_textid='$id'");
      $cnt++;
  }
  return $id;
}

//сквозная нумерация при изменении позиции
/*delimfield- поле-ограничитель (нАпример: page_code) delimvalue - его значение*/
function RenumeratePos($table,$keyfield,$posfield,$delimfield="",$delimvalue=0)
{
  if ($delimfield=='') $query="select * from $table order by $posfield";
     else $query="select * from $table where $delimfield=$delimvalue order by $posfield";
// echo"<br>----------$query---------<br>";
  $res=mysql_query($query);
  $num_rows=mysql_num_rows($res);
  for ($i=0;$i<$num_rows;$i++)
  {
   $code=mysql_result($res,$i,"$keyfield");
// echo"update $table set $posfield=".($i+1)." where $keyfield=$code<br>";
   mysql_query("update $table set $posfield=".($i+1)." where $keyfield=$code");
  }
  mysql_free_result($res);
}

function fullBack($url="/")
{
    header("Location: $url");
    die();
}


function ChangeAlbumPageSpageName($artist_code,$artist_name)
{
    global $PREFFIX;
    $res1=mysql_query("select album_name,page_code,spage_code from {$PREFFIX}_artistalbum
                       inner join {$PREFFIX}_album on ({$PREFFIX}_album.album_code={$PREFFIX}_artistalbum.album_code)
                       where {$PREFFIX}_artistalbum.artist_code=$artist_code
                      ");
    while(list($album_name,$p_c,$s_c)=mysql_fetch_array($res1))
    {
     $new_name="Альбом ".addslashes("$album_name - $artist_name");
     mysql_query("update {$PREFFIX}_page set page_name='$new_name' where page_code=$p_c");
     mysql_query("update {$PREFFIX}_spage set spage_name='$new_name' where spage_code=$s_c");
    }
}

function isAllowed($right)
{
    global $PREFFIX,$REGUSER;
    return ($REGUSER[$right]);
}


/*
Array ( [TAG] => TAG
        [NAME] => Была не была
        [ARTISTS] => Джанго
        [ALBUM] => Была не была
        [YEAR] => 2005
        [COMMENT] => http://www.mp3real.ru
        [TRACK] => 1
        [GENRENO] => 17
        [filesize] => 5583352
        [encoding_type] => CBR
        [mpeg_ver] => 1
        [layer] => 3
        [bitrate] => 192
        [frequency] => 44100
        [mode] => Stereo
        [samples_per_frame] => 1152
        [length] => 03:52
        [lengthh] => 00:03:52
        [lengths] => 232
        [samples] => 10231200
        [frames] => 8882
        [musicsize] => 5568000
*/
function getMP3info($file) {
    if (! ($f = fopen($file, 'rb')) ) die("Unable to open " . $file);

    fseek($f, -128, SEEK_END);
    $tmp = fread($f,128);
    if ($tmp[125] == Chr(0) and $tmp[126] != Chr(0)) {
        // ID3 v1.1
        $format = 'a3TAG/a30NAME/a30ARTISTS/a30ALBUM/a4YEAR/a28COMMENT/x1/C1TRACK/C1GENRENO';
    } else {
        // ID3 v1
        $format = 'a3TAG/a30NAME/a30ARTISTS/a30ALBUM/a4YEAR/a30COMMENT/C1GENRENO';
    }

    $res = unpack($format, $tmp);

    $res['filesize'] = filesize($file);
    rewind($f);
    do {
        while (fread($f,1) != Chr(255)) { // Find the first frame
            if (feof($f))  die( "No mpeg frame found") ;
        }
        fseek($f, ftell($f) - 1); // back up one byte

        $frameoffset = ftell($f);

        $r = fread($f, 4);

        $bits = sprintf("%'08b%'08b%'08b%'08b", ord($r{0}), ord($r{1}), ord($r{2}), ord($r{3}));
    }
    while (!$bits[8] and !$bits[9] and !$bits[10]); // 1st 8 bits true from the while

   $vbroffset = 32; // MPEG 1 Stereo
   fseek($f, ftell($f) + $vbroffset);
   $r = fread($f, 4);

   switch ($r) {
       case 'Xing':
           $res['encoding_type'] = 'VBR';
       case 'VBRI':
       default:
           if ($vbroffset != 32) {
               // VBRI Header is fixed after 32 bytes, so maybe we are looking at the wrong place.
               fseek($f, ftell($f) + 32 - $vbroffset);
               $r = fread($f, 4);

               if ($r != 'VBRI') {
                   $res['encoding_type'] = 'CBR';
                   break;
               }
           } else {
               $res['encoding_type'] = 'CBR';
               break;
           }

           $res['encoding_type'] = 'VBR';
   }

   fclose($f);

       $res['mpeg_ver'] = "1";
       $bitrates = array(
           '1' => array(0, 32, 64, 96, 128, 160, 192, 224, 256, 288, 320, 352, 384, 416, 448, 0),
           '2' => array(0, 32, 48, 56,  64,  80,  96, 112, 128, 160, 192, 224, 256, 320, 384, 0),
           '3' => array(0, 32, 40, 48,  192,  64,  80,  96, 112, 128, 160, 192, 224, 256, 320, 0),
                );

   $layer = array(
       array(0,3),
       array(2,1),
             );
   $res['layer'] = 3;

   if ($bits[15] == 0) {
       // It's backwards, if the bit is not set then it is protected.
       $res['crc'] = true;
   }

   $bitrate = 0;

   if ($bits[16] == 1) $bitrate += 8;
   if ($bits[17] == 1) $bitrate += 4;
   if ($bits[18] == 1) $bitrate += 2;
   if ($bits[19] == 1) $bitrate += 1;

   $res['bitrate'] = $bitrates[$res['layer']][$bitrate];

   $frequency = array(
       '1' => array(
           '0' => array(44100, 48000),
           '1' => array(32000, 0),
               ),
       '2' => array(
           '0' => array(22050, 24000),
           '1' => array(16000, 0),
               ),
       '2.5' => array(
           '0' => array(11025, 12000),
           '1' => array(8000, 0),
                 ),
         );
   $res['frequency'] = $frequency[$res['mpeg_ver']][$bits[20]][$bits[21]];

   $mode = array(
       array('Stereo', 'Joint Stereo'),
       array('Dual Channel', 'Mono'),
            );
   $res['mode'] = $mode[$bits[24]][$bits[25]];

   $samplesperframe = array(
       '1' => array(
           '1' => 384,
           '2' => 1152,
           '3' => 1152
       ),
       '2' => array(
           '1' => 384,
           '2' => 1152,
           '3' => 576
       ),
       '2.5' => array(
           '1' => 384,
           '2' => 1152,
           '3' => 576
       ),
   );
   $res['samples_per_frame'] = $samplesperframe[$res['mpeg_ver']][$res['layer']];

   if ($res['encoding_type'] != 'VBR') {
       if ($res['bitrate'] == 0) {
           $s = -1;
       } else {
           $s = ((8*filesize($file))/1000) / $res['bitrate'];
       }
       $res['length'] = sprintf('%02d:%02d',floor($s/60),floor($s-(floor($s/60)*60)));
       $res['lengthh'] = sprintf('%02d:%02d:%02d',floor($s/3600),floor($s/60),floor($s-(floor($s/60)*60)));
       $res['lengths'] = (int)$s;

       $res['samples'] = ceil($res['lengths'] * $res['frequency']);
       if(0 != $res['samples_per_frame']) {
           $res['frames'] = ceil($res['samples'] / $res['samples_per_frame']);
       } else {
           $res['frames'] = 0;
       }
        $res['musicsize'] = ceil($res['lengths'] * $res['bitrate'] * 1000 / 8);
    } else {
        $res['samples'] = $res['samples_per_frame'] * $res['frames'];
        $s = $res['samples'] / $res['frequency'];

        $res['length'] = sprintf('%02d:%02d',floor($s/60),floor($s-(floor($s/60)*60)));
        $res['lengthh'] = sprintf('%02d:%02d:%02d',floor($s/3600),floor($s/60),floor($s-(floor($s/60)*60)));
        $res['lengths'] = (int)$s;

        $res['bitrate'] = (int)(($res['musicsize'] / $s) * 8 / 1000);
    }

    return $res;
}

function secToTime($sec)
{
   $minu=floor($sec/60);
   $sec=$sec%60;
   return sprintf("%02d:%02d",$minu,$sec);
}

function timeToSec($time)
{
   $arr=explode(":",$time);
   return intval($arr[0])*60+intval($arr[1]);
}

//отправляет письмо с указанным текстом и темой на указанный адрес
function mailSend($email,$subj,$text,$from="",$replyto="",$bcc="")
{
global $adminemail,$adminname;
if(!$from) $from="$adminname <$adminemail>";
if(!$replyto) $replyto=$adminemail;
    $boundary = strtoupper(md5(uniqid(time())));
    $headers = "From: $from\nReply-To: $replyto\r\n";
if($bcc) $headers.="Bcc: $bcc\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: multipart/mixed; boundary=$boundary\r\n";

    $data= "This is a multi-part message in MIME format.\r\n\r\n";
    $data .= "--$boundary\n";
    $data .= "Content-Type: text/html; charset=windows-1251\n";
    $data .= "Content-Transfer-Encoding:base64\r\n\r\n";

    $ttext="<html><body>".stripslashes($text)."</body></html>";
    $ttext = chunk_split(base64_encode($ttext));

    $data .= "$ttext\r\n\r\n";
//$email="admin@crusader.ru";
    mail($email,$subj,$data,$headers);
}




// накладывает изображение , переданное как "watermark_file" в виде ватермарка на "image_file".
// позиции (position) могут быть topleft,topright,bottomleft,bottomright,center
// $xpad,$ypad - отступы по горизонтали и вертикали
// Сохраняет полученный файл под именем "save_name"
// возвращает true - OK , false - ошибка
function putWatermark($image_file,$watermark_file,$save_file,$position="bottomright",$xpad=0,$ypad=0)
{
 $err=0;
// смещение относительно угла
 $w_offset = $xpad;
 $h_offset = $ypad;
// обрабатываем image_file
 $info=getImageSize($image_file);
// берем тип и размер оригинала
 $swidth = $info[0];
 $sheight = $info[1];
 $type=$info[2];
 switch ($type)
 {
     case IMAGETYPE_JPEG: $background = imagecreatefromjpeg($image_file);break;
     case IMAGETYPE_PNG: $background = imagecreatefrompng($image_file);break;
     case IMAGETYPE_GIF: $background = imagecreatefromgif($image_file);break;
     default: $err=1;
 }
 if ($err) return false;
 imagealphablending($background, true);

// обрабатываем watermark_file
 $oinfo=getImageSize($watermark_file);
// берем тип и размер оригинала
 $owidth = $oinfo[0];
 $oheight = $oinfo[1];
 $otype=$oinfo[2];
 switch ($otype)
 {
     case IMAGETYPE_JPEG: $overlay = imagecreatefromjpeg($watermark_file);break;
     case IMAGETYPE_PNG: $overlay = imagecreatefrompng($watermark_file);break;
     case IMAGETYPE_GIF: $overlay = imagecreatefromgif($watermark_file);break;
     default: $err=1;
 }
 if ($err) return false;

// вычисляем координаты наложения
 switch ($position)
 {
     case "topleft": {$xpos=$w_offset; $ypos=$h_offset; }break;
     case "topright": {$xpos=$swidth - $owidth - $w_offset; $ypos=$h_offset; }break;
     case "bottomleft": {$xpos=$w_offset; $ypos=$sheight - $oheight - $h_offset; }break;
     case "bottomright": {$xpos=$swidth - $owidth - $w_offset; $ypos=$sheight - $oheight - $h_offset; }break;
     case "center": {$xpos=($swidth/2) - ($owidth/2); $ypos=($sheight/2) - ($oheight/2); }break;
     default: {$xpos=$swidth - $owidth - $w_offset; $ypos=$sheight - $oheight - $h_offset; }
 }
 if ($err) return false;
// наложение
 imagecopy($background, $overlay, $xpos, $ypos, 0, 0, $owidth, $oheight);

// получаем расширение файла-результата
 $ext=strtoupper(pathinfo($save_file,PATHINFO_EXTENSION));

// сохраняем файл-результат
 switch ($ext)
 {
     case "JPG":
     case "JPEG":imagejpeg($background,$save_file); break;
     case "PNG": imagepng($background,$save_file); break;
     case "GIF": imagegif($background,$save_file); break;
     default: $err=1;
 }
 if ($err) return false;
 imagedestroy($background);
 imagedestroy($overlay);

 return true;
}



?>
