<?php
// ATH!
// Í þessa config skrá þarf að fylla inn eftirfarandi upplýsingar svo síðan virki eins og ætlast er til

// HOST_USER þarf að vera notandanafn þess sem hýsir síðuna á sínu notandasvæði
define("HOST_USER", "uglu notandanafn hér");
// Dæmi:
// notandi með vefsvæðið https://notendur.hi.is/~sfg6/ hefur notandanafnið "sfg6"

// Hér má breyta nokkrum hlutum varðandi síðuna
$website_title = "Titill síðu";
$website_name = "Nafn síðu";
$website_content = "Örstutt lýsing á hlutverki, efni og innihaldi síðu.";

// ef síðan er sett í undirmöppu í .public_html möppunni þá þarf að setja það inn hér, annars hafa tómt (þ.e. setja sem "")
$website_subfolder = "viso/";

// dev breyta: ef verið er að vinna í síðunni á localhost á hún að vera true, annars false
$development = True;

?>