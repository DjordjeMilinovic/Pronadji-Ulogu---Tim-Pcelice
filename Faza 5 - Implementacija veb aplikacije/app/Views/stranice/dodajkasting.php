<!--Autor: Jelena Pančevski-->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/dodajkasting.css">
    <title>Document</title>
    <script src="script.js"></script>
</head>

<form autocomplete="off" method ="post" action="<?php echo base_url('Reditelj/dodajNoviKasting')?>" enctype="multipart/form-data">
    <div>
        
        <table > 
            <tr>
                <td colspan="2" >
                    <h1>Kasting</h1>
                </td>
            </tr>
            <tr>
                <td>
                    <input id="NazivKastinga" name ="kastingNaziv" type="textbox" class="TextBoxes" placeholder="Naziv kastinga" required/>
                </td>
                <td>
                    <label id="Kategorija" >Kategorija:</label>
                    <select name="KategorijaKastinga" class="SongType" required>
                        <option value="Film">
                            Film
                        </option>
                        <option value="Pozorište">
                            Pozorište
                        </option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><textarea id="description" name="description" placeholder="Opis kastinga" rows="25" cols="40" ></textarea>
                </td>
                <td>
                    <div>
                        <div class="Koordinate"> Profile picture
                                <input type="file" id="myFile" name="slika" accept="image/jpeg" >
                        </div>
                        <span data-type="radio" class="radiobuttons">
                            <span class="Type">
                                <label>Glumac</label>
                                <input type="checkbox"  name="CheckGlumac"></span>
                            <input type="number" class="Boxes" name="Glumac" placeholder="Broj potrebnih glumaca"/> <br>
                            <span class="Type">
                                <label>Statista</label>
                                <input type="checkbox" name="CheckStatista"></span>
                            <input type="number"  name="Statista" class="Boxes" placeholder="Broj potrebnih statista"/>
                        </span>
                    </div>

                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="button"><button type="submit" onclick="alertcreatedcasting()">Postavi kasting</button></div>
                </td>
            </tr>
        </table>

    </div>
</form>


</body>
</html>