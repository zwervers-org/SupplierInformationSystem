function formhash(form, password) {
   // Create a new element input, this will be out hashed password field.
   var p = document.createElement("input");
   // Add the new element to our form.
   if (navigator.appName == 'Microsoft Internet Explorer'){
   // code for Internet Explorer
		p = document.createElement("<INPUT NAME='p' TYPE='hidden' VALUE='"+hex_sha512(password.value)+"'>");  
		form.appendChild(p);
	}
   else {
   // code for Chrome, Opera, Safari, Firefox
	   form.appendChild(p);
	   p.type = 'hidden';
	   p.name = 'p';
	   p.value = hex_sha512(password.value);
	}
   // Make sure the plaintext password doesn't get sent.
   password.value = "";
   // Finally submit the form.
   form.submit();
}

function reghash(form, oldpassword, newpassword) {
   // Create a new element input, this will be out hashed password field.
   var pnew = document.createElement("input");
   var pold = document.createElement("input");
   // Add the new element to our form.
   if (navigator.appName == 'Microsoft Internet Explorer'){
   // code for Internet Explorer
		pold = document.createElement("<INPUT NAME='pold' TYPE='hidden' VALUE='"+hex_sha512(oldpassword.value)+"'>");  
		form.appendChild(pold);
		pnew = document.createElement("<INPUT NAME='pnew' TYPE='hidden' VALUE='"+hex_sha512(newpassword.value)+"'>");  
		form.appendChild(pnew);
	}
   else {
   // code for Chrome, Opera, Safari, Firefox
	   form.appendChild(pold);
	   pold.type = 'hidden';
	   pold.name = 'pold';
	   pold.value = hex_sha512(oldpassword.value);
	   
	   form.appendChild(pnew);
	   pnew.type = 'hidden';
	   pnew.name = 'pnew';
	   pnew.value = hex_sha512(newpassword.value);
	}
   // Make sure the plaintext password doesn't get sent.
   newpassword.value = "";
   oldpassword.value = "";
   // Finally submit the form.
   form.submit();
}

function showHide(ShowHideDiv) {
    var ele = document.getElementById(ShowHideDiv.id);
		if(ele.style.display == "") {
			ele.style.display = "none";
		}
		else if(ele.style.display == "block") {
			ele.style.display = "none";
		}
		else{
		ele.style.display = "block";
		}
}

function DependDropList(id,list){
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("droplist").innerHTML=xmlhttp.responseText;
    }
}

xmlhttp.open("GET","./script/loadList.php?id="+id+"&list="+list,true);
xmlhttp.send();
}

function submit(){
form.submit();
}
