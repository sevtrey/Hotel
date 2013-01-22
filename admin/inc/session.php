<?php
  session_start();

 if (!isset($_SESSION["FMRADIO"]))
 {
//echo"not set";
    //session_unset();
    unset($REGUSER);
    $_SESSION["FMRADIO"]=1;
 }

//выделение пользователя----------------------------------------------------------------------------------------
 if (isset($op))
 {
      if ($op=="in")
         {
               include("userfrombase.php"); //попытка достать юзера из базы
               if (!$REGUSER['name'])
               {
                     header("Location: $PHP_SELF?err=1");
                     die();
               }
                   else {
                             header("Location: main.php");
                             die();
                        }

         }
         else
      if ($op=="out")
         {
           unset($_SESSION['REGUSER']);
           unset($REGUSER);
           header("Location: $PHP_SELF?err=2");
           die();
         }
  }

   $REGUSER["code"]=$_SESSION["REGUSER"]["code"];
   $REGUSER["name"]=$_SESSION["REGUSER"]["name"];
   $REGUSER["login"]=$_SESSION["REGUSER"]["login"];
   $REGUSER["pass"]=$_SESSION["REGUSER"]["pass"];
   $REGUSER["email"]=$_SESSION["REGUSER"]["email"];
// --------------- права -------------------------------------------------------
   $REGUSER["radmin"]=$_SESSION["REGUSER"]["radmin"];
   $REGUSER["rstatic"]=$_SESSION["REGUSER"]["rstatic"];
   $REGUSER["ralbum"]=$_SESSION["REGUSER"]["ralbum"];
   
   /*$REGUSER["rnews"]=$_SESSION["REGUSER"]["rnews"];
   $REGUSER["rstation"]=$_SESSION["REGUSER"]["rstation"];
   $REGUSER["rperson"]=$_SESSION["REGUSER"]["rperson"];
   $REGUSER["rreport"]=$_SESSION["REGUSER"]["rreport"];
   $REGUSER["rread"]=$_SESSION["REGUSER"]["rread"];
   $REGUSER["rlisten"]=$_SESSION["REGUSER"]["rlisten"];
   $REGUSER["rwork"]=$_SESSION["REGUSER"]["rwork"];
   $REGUSER["rpremium"]=$_SESSION["REGUSER"]["rpremium"];
   $REGUSER["rtns"]=$_SESSION["REGUSER"]["rtns"];
   $REGUSER["rgb"]=$_SESSION["REGUSER"]["rgb"];
   $REGUSER["rdirectory"]=$_SESSION["REGUSER"]["rdirectory"];*/

// -----------------------------------------------------------------------------

if( (!trim($REGUSER["name"]))&&(strpos($_SERVER['REQUEST_URI'],"index.php")===false)&&(strpos($_SERVER['REQUEST_URI'],".php")!==false)  ) header("Location: index.php");
//конец выделения пользователя----------------------------------------------------------------------------------------

?>
