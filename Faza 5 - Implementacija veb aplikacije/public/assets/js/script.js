 /*
    Autor: Jelena Pančevski 0123/2018
    Brisanje zahteva za kreiranje kastinga i postavljanje statusa kastinga na Odbijen putem Ajax-a
    @return void
    */
function removeReject(id) {

    let ID = id.toString();
    let myobj = document.getElementById(ID);  
    $.ajax({
            url: window.location.origin+"/Administrator/OdbijKasting",    
            type: "post",    //request type,
            dataType: 'json',
            data: {IdKastinga: ID
            },
            complete:function(data){
                 myobj.remove();
            }
        });
   
}
 /*
    Autor: Jelena Pančevski 0123/2018
    Brisanje zahteva za kreiranje kastinga i postavljanje statusa kastinga na Prihvacen putem Ajax-a
    @return void
    */
function removeAccept(id) {

    let ID = id.toString();
    let myobj = document.getElementById(ID);  
    $.ajax({
            url: window.location.origin+"/Administrator/PrihvatiKasting",    
            type: "post",    //request type,
            dataType: 'json',
            data: {IdKastinga: ID
            },
            complete:function(data){
                 myobj.remove();
            }
        });
   
}
 /*
    Autor: Jelena Pančevski 0123/2018
    Prikaz greške prilikom postavljanja monologa/pesme
    @return void
    */
function error(message) {
    var popup = document.getElementById("myPopup");
    popup.innerHTML = message;
    popup.classList.toggle("show");
}
 /*
    Autor: Jelena Pančevski 0123/2018
    Uklanjanje prikaza greške prilikom postavljanja monologa/pesme
    @return void
    */
function closepopup() {
    var popup = document.getElementById("myPopup");
    popup.innerHTML = "";
    popup.classList.toggle("show");
}
 /*
    Autor: Jelena Pančevski 0123/2018
    Prikaz greške prilikom prijavljivanja korisnika
    @return void
    */
function loginerror(message, username) {
    switch (message){
        case "Pogresna lozinka":document.getElementById('KorisnickoIme').setAttribute("value", username);
                              document.getElementById('Lozinka').placeholder = message;
                              break;
        case "Korisnicko ime ne postoji": 
                              document.getElementById('KorisnickoIme').placeholder = message;
                              break;
        case "The Lozinka field is required.":
        document.getElementById('Lozinka').placeholder = "Lozinka je obavezna";
        break;
        case "The KorisnickoIme field is required." :document.getElementById('KorisnickoIme').placeholder = "Korisnicko ime je obavezno";
       break;
       case 'Zahtev za registraciju na cekanju':
            document.getElementById('KorisnickoIme').placeholder = message;
        break;
    }
}

 /*
    Autor: Jelena Pančevski 0123/2018
    Izmena informacija o prijavljenom korisniku na stranici profil putem Ajax-a.
    @return void
    */
function EditProfile(){
   let Ime= document.getElementById("Ime").value;
   let Prezime=document.getElementById("Prezime").value;
   if(Ime!="") document.getElementById("Ime").placeholder=Ime;
   if(Prezime!="") document.getElementById("Prezime").placeholder=Prezime;
   document.getElementById("Ime").value="";
   document.getElementById("Prezime").value="";
    $.ajax({
            url: window.location.origin+"/Korisnik/izmenaprofila",    
            type: "post",    //request type,
            dataType: 'json',
            data: {Ime: Ime, Prezime:Prezime
            },
            
        });
}
/*
    Autor: Đorđe Milinović 0334/2018
    Prihvatanje/Odbijanje zahteva za registraciju reditelja i uklanjanje zahteva iz liste korišćenjem Ajax-a.
    @return void
    */
function DirectorRequest(Reditelj,Odluka){
    let myobj = document.getElementById(Reditelj);  
     $.ajax({
            url: window.location.origin+"/Administrator/PrihvatiOdbijReditelja",    
            type: "post",    //request type,
            dataType: 'json',
            data: {Reditelj: Reditelj, Odluka:Odluka
            },
            complete:function(data){
                 myobj.remove();
            }
        });
}

/*
    Autor: Đorđe Milinović 0334/2018
    Prikazivanje određenih kastinga po kriterijumu uloge(Glumac/Statista/Svi)
    @return void
    */
function filterPrikaz() {
    let tip= document.getElementById("Tip").value;
    let myobj = document.getElementById('actorType');
    let controler= document.getElementById('Controller').value;
    var num = 0;
    switch (myobj.value) {
        case 'Statista':
            num = 2;
            break;
        case 'Glumac':
            num = 1;
            break;
        case 'Sve':
            num = 0;
            break;
            // code block
    }
    
    $.ajax({

        url: window.location.origin + "/" + controler + "/FiltriranjeKastinga",
        type: "post", //request type,
        dataType: 'json',
        data: {ActorType: num, Tip:tip, Controller:controler
        },
        complete : function($data){
            document.getElementById('Kastinzi').innerHTML=$data['responseText'];
        }
    });
}




/*function alertcreatedcasting() {
    if (document.getElementById("NazivKastinga").value != "")
        alert("Zahtev za kreiranje novog kastinga uspesno je poslat");
}

function registration() {
    let t = '';
    let obj = document.getElementById("notification");
    let name = document.getElementById("name").value;
    let surname = document.getElementById("surname").value;
    let email = document.getElementById("email").value;
    let username = document.getElementById("username").value;
    let password = document.getElementById("password").value;
    let usertype = doucment.getElementsByName("TipKorisnika");
    var regexemail = /^\w+@\w+.com$/;
    var node = document.createElement('div');
    node.setAttribute('class', 'notification');
    if (name != "" && surname != "" && regexemail.test(email) && username != "" && password != "" && (usertype[0].value == true || usertype[1].value == true))
        t = document.createTextNode("Succesfull registration")
    if (t != '') {
        //node.appendChild(t);
        // sekcija=document.getElementById('forma');
        obj.innerHTML = t;
        //obj.appendChild(node);
    } else
        obj.innerHTML = "Ne radi provera";
    alert("Uspesna registracija");
}

function postcomment() {
    var ul = document.getElementById("list");
    var li = document.createElement("li");
    let comment = document.getElementById("NewComment").value;
    let date = new Date();
    let currentdate = date.getDate() + "/" + (date.getMonth() + 1) + "/" + (date.getYear() + 1900);
    li.innerHTML = '<table><tr><td><img class="Image" src="miksa.png"/><div class="User">Publisher: MihajloNikitovic</div><div class="User">Date: ' + currentdate + '</div> </td><td class="Comment"> <div>' + comment + '</div></td></tr></table>';
    ul.appendChild(li);

    document.getElementById("NewComment").value = "";
}
*/