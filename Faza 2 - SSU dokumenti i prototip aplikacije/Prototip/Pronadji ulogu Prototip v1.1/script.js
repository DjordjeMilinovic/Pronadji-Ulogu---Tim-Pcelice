function alertcreatedcasting(){
    if(document.getElementById("NazivKastinga").value!="")alert("Zahtev za kreiranje novog kastinga uspesno je poslat");
}

function registration(){
    let t='';
    let obj = document.getElementById("notification");
    let name=document.getElementById("name").value;
    let surname=document.getElementById("surname").value;
    let email=document.getElementById("email").value;
    let username=document.getElementById("username").value;
    let password=document.getElementById("password").value;
    let usertype=doucment.getElementsByName("TipKorisnika");
    var regexemail=/^\w+@\w+.com$/;
    var node=document.createElement('div');
    node.setAttribute('class','notification');
    if(name!="" && surname!="" && regexemail.test(email) && username!="" && password!="" && (usertype[0].value==true ||usertype[1].value==true ))
   t= document.createTextNode("Succesfull registration")
   if(t!=''){
    //node.appendChild(t);
   // sekcija=document.getElementById('forma');
   obj.innerHTML=t;
    //obj.appendChild(node);
  }
  else obj.innerHTML="Ne radi provera";
  alert("Uspesna registracija");
}

function postcomment(){
  var ul = document.getElementById("list");
  var li = document.createElement("li");
let comment=document.getElementById("NewComment").value;
let date = new Date();
let currentdate = date.getDate()+"/"+(date.getMonth()+1)+"/"+(date.getYear()+1900);
  li.innerHTML='<table><tr><td><img class="Image" src="miksa.png"/><div class="User">Publisher: MihajloNikitovic</div><div class="User">Date: '+currentdate+'</div> </td><td class="Comment"> <div>'+ comment+'</div></td></tr></table>';
  ul.appendChild(li);

  document.getElementById("NewComment").value="";
}

function remove(id) {
  var myobj = document.getElementById(id);
  myobj.remove();
}