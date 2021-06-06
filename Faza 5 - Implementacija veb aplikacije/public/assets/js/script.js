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
 /*
    Autor: Jelena Pančevski 0123/2018
    Dodavanje komentara na temu putem Ajax-a
    @return void
    */
function dodajKomentar() {
    let idTeme=document.getElementById("idTeme").value;
    let komentar=document.getElementById("NewComment").value;
    let controler=document.getElementById("controler").value;
   $.ajax({

        url: window.location.origin + "/" + controler + "/dodajNoviKomentar",
        type: "post", //request type,
        dataType: 'json',
        data: {idTeme: idTeme, NewComment:komentar, Controller:controler
        },
        complete : function($data){
           
            document.getElementById('komentari').innerHTML+=$data['responseText'];
        }
    });
    document.getElementById("NewComment").value="";
    
}
