<?php        
       $langquery="select * from {$PREFFIX}_lang"; 
	   $res=mysql_query($langquery) or die(mysql_error());
	   
	   print '<form name="formlang" method="get" action="">'; 
       print '<input type=hidden name=page_code value='.$page_code.'>';
       print '<input type=hidden name=page_name value='.$page_name.'>';
	   print 'язык <select name="langindex" onchange="submit()">';
	   $num_rows=mysql_num_rows($res);   
        for ($i=0;$i<$num_rows; $i++) 
        { $row = mysql_fetch_array($res);
          if (!intval($langindex)) $langindex=$row[lang_code];
          echo '<option';
          if ($row[lang_code]==$langindex) { echo ' selected '; $langname=$row[lang_name];}
          echo ' value="'.$row[lang_code].'">'.$row[lang_name].'</option>';
         
        }
         mysql_free_result($result);
        print '</select> </form>';
?>