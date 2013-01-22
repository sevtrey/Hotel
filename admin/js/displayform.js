display=0;
function displayform(obj,text){
if (display==0)
{
  addform.style.display='block';
  display=1;
  eval(obj).innerHTML="скрыть форму добавления";
}
else
{
  addform.style.display='none';
  display=0;
  eval(obj).innerHTML=text;
}
}

function showedit(params)
{
   msg=window.open("editwindow.php?"+params,"_blank","toolbar=no,directories=no,menubar=no,scrollbars=no,status=no,resizable=no,width=570,height=500");
}

function showedit2(params)
{
   msg=window.open("editwindow2.php?"+params,"_blank","toolbar=no,directories=no,menubar=no,scrollbars=no,status=no,resizable=no,width=570,height=600");
}

function showedit3(params)
{
   msg=window.open("editwindow3.php?"+params,"_blank","toolbar=no,directories=no,menubar=no,scrollbars=yes,status=no,resizable=no,width=570,height=700");
}



function submenu(a,all)
{
for (i=0;i<all; i++)
 {
   s=eval('submenu'+i);
   if (i==a)
    {
      if (s.style.display == 'block') s.style.display='none';
         else s.style.display='block';
    }
    else s.style.display='none';
 }
}
