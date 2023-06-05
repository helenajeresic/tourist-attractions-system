<?php

require_once __SITE_PATH . '/vendor/autoload.php';

use MongoDB\BSON\ObjectId;
function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


$user_id_1 = new MongoDB\BSON\ObjectId;
$user_id_2 = new MongoDB\BSON\ObjectId;
$user_id_3 = new MongoDB\BSON\ObjectId;
$user_id_4 = new MongoDB\BSON\ObjectId;
$user_id_5 = new MongoDB\BSON\ObjectId;


$documents_users = [

    [
        "_id" => $user_id_1,
        "username" => "ana123",
        "passwordHash" => password_hash("aninalozinka", PASSWORD_DEFAULT),
        "email" => "ana123@net.hr",
        "registrationSequence" => generateRandomString(10),
        "hasRegistered" => 1,
        "isAdmin" => 0,
        "name" => "Ana",
        "lastname" => "Anic"
    ],

    [
        "_id" => $user_id_2,
        "username" => "pero321",
        "passwordHash" => password_hash("perinalozinka", PASSWORD_DEFAULT),
        "email" => "pero321@net.hr",
        "registrationSequence" => generateRandomString(10),
        "hasRegistered" => 1,
        "isAdmin" => 0,
        "name" => "Pero",
        "lastname" => "Horvat"
    ],

    [
        "_id" => $user_id_3,
        "username" => "david99",
        "passwordHash" => password_hash("mirkovasifra", PASSWORD_DEFAULT),
        "email" => "davidljulj@net.hr",
        "registrationSequence" => generateRandomString(10),
        "hasRegistered" => 1,
        "isAdmin" => 0,
        "name" => "David",
        "lastname" => "Ljulj"
    ],

    [
        "_id" => $user_id_4,
        "username" => "banana",
        "passwordHash" => password_hash("bananalozinka", PASSWORD_DEFAULT),
        "email" => "anaban@net.hr",
        "registrationSequence" => generateRandomString(10),
        "hasRegistered" => 1,
        "isAdmin" => 0,
        "name" => "Ana",
        "lastname" => "Ban"
    ],

    [
        "_id" => $user_id_5,
        "username" => "marina",
        "passwordHash" => password_hash("jasammarina", PASSWORD_DEFAULT),
        "email" => "marina0908@net.hr",
        "registrationSequence" => generateRandomString(10),
        "hasRegistered" => 1,
        "isAdmin" => 1,
        "name" => "Marina",
        "lastname" => "Maric"
    ],
];

$attraction_id_1 = new MongoDB\BSON\ObjectId;
$attraction_id_2 = new MongoDB\BSON\ObjectId;
$attraction_id_3 = new MongoDB\BSON\ObjectId;
$attraction_id_4 = new MongoDB\BSON\ObjectId;
$attraction_id_5 = new MongoDB\BSON\ObjectId;
$attraction_id_6 = new MongoDB\BSON\ObjectId;
$attraction_id_7 = new MongoDB\BSON\ObjectId;
$attraction_id_8 = new MongoDB\BSON\ObjectId;
$attraction_id_9 = new MongoDB\BSON\ObjectId;
$attraction_id_10 = new MongoDB\BSON\ObjectId;
$attraction_id_11 = new MongoDB\BSON\ObjectId;
$attraction_id_12 = new MongoDB\BSON\ObjectId;
$attraction_id_13 = new MongoDB\BSON\ObjectId;
$attraction_id_14 = new MongoDB\BSON\ObjectId;

$documents_attractions = [
    [
        "_id" => $attraction_id_1,
        "name" => "Crkva sv. Marka",
        "description" => "Prekrasne kamene ulice i crveni popločani krovovi zgrada u 
                        srednjovjekovnom Gornjem gradu, zagrebačkom Gornjem gradu, 
                        čine lijepim mjestom za početak razgledavanja glavnog grada Hrvatske. 
                        Nakon dva odvojena mjesta poznata kao Kaptol i Gradec, Gornji grad je dom 
                        mnogih najposjećenijih turističkih atrakcija grada, uključujući katedralu, 
                        zgradu parlamenta i brojne muzeje i crkve. Ostale značajke uključuju poznatu 
                        kamena vrata koja označavaju ulaz na istočnu stranu Gradeca; Kaptolski trg, poznat 
                        po brojnim zgradama iz 17. stoljeća; i tržnicu Dolac za voće i povrće. Možda je 
                        najzanimljivija osobina Crkva sv. Marka, koja je lako prepoznatljiva svojim svijetlim 
                        obojenim krovnim pločicama s grbom Hrvatske, Dalmacije, Slavonije i Zagreba. Prateći 
                        svoje korijene natrag u neku raniju crkvu iz 13. stoljeća, crkva sv. Marka ima i značajne 
                        značajke romaničkih prozora; Gotička vrata Ivana Parlera; i niz kipova od 12 apostola, 
                        zajedno s Isusom, Marijom i Sv Markom. Svakako potražite i prekrasnu unutrašnjost sa svojim 
                        kipovima poznatih hrvatskih kipara Ivana Meštrovića, zajedno s freskama koje je naslikao 
                        Jozo Kljaković",
        "image_path" => "image1.jpg",
        "x_coordinate" => 3,
        "y_coordinate" => 40
    ],

    [
        "_id" => $attraction_id_2,
        "name" => "Zagrebačka katedrala",
        "description" => "Zagrebačka katedrala - Katedrala Uznesenja Blažene Djevice Marije, ranije poznata 
                        kao Katedrala Sv. Stjepana, podignuta je na mjestu prethodne strukture koju su 
                        uništili Tatari početkom 1200. godine. Poznat je po dva ukrašena tornja, sadašnja 
                        katedrala sagrađena je u kasnijoj polovici 13. stoljeća, iako su napravljene mnoge 
                        izmjene i obnove jer su to dramatično promijenile strukturu. Nedavno, potres 1880. godine 
                        uništio je velike dijelove, uključujući kupolu i zvonik, iako je rekonstrukcija 
                        zadržala izvorni srednjovjekovni dizajn. Svakako posjetite riznicu katedrale s brojnim 
                        lijepim djelima vjerske umjetnosti, odjeće i sakralnih objekata.",
        "image_path" => "image2.jpg",
        "x_coordinate" => 15,
        "y_coordinate" => 20
    ],

    [
        "_id" => $attraction_id_3,
        "name" => "Muzej Mimara",
        "description" => "Muzej Mimara stvoren je za smještaj zbirke koju je 1972. 
                        godine darovao privatni sakupljač Ante Topic Mimara.
                        U 1895 neorenesansnoj zgradi posebno dizajniranoj za to, 
                        ova opsežna zbirka pokriva širok raspon predmeta iz raznolikost 
                        lokacija i vremenskih razdoblja, uključujući fina arheološka 
                        zbirka koja sadrži djela iz starog Egipta, Mezopotamije, Perzije, 
                        Bliskog istoka, Dalekog Istoka, Indije, te Inke i Pre-Inke Južne 
                        Amerike. Tu je i velika staklena zbirka iz Europe i drugih mediteranskih 
                        zemalja, zajedno s namještajem iz srednjeg vijeka i skulpturama iz 
                        antičke Grčke",
        "image_path" => "image3.jpg",
        "x_coordinate" => 7,
        "y_coordinate" => 79
    ],

    [
        "_id" => $attraction_id_4,
        "name" => "Umjetnički paviljon i Galerija Meštrović",
        "description" => "Umjetnički paviljon, izgrađen za međunarodnu izložbu u Budimpešti 1896. 
                        godine, dobio je svoj stalni dom nakon što je originalni željezni okvir 
                        prevezen i rekonstruiran na svojoj aktualnoj lokaciji. 
                        Značajan za njegovu živopisnu žute žalbe, Art Paviljon danas se koristi 
                        za promjenu izložbi suvremene umjetnosti i sadrži važna djela čuvenog 
                        hrvatskog umjetnika Ivan Meštrović, Najstarija izložbena dvorana ove 
                        vrste u Hrvatskoj, ova impresivna građevina okrenuta je prema Trgu 
                        Kralja Tomislava, velikom javnom trgu zabilježenom za svoj spomenik 
                        koji obilježava prvi kralj Hrvatske. Zanimljiv je i ljubitelj umjetnosti 
                        Galerija Meštrović (Atelje Meštrović), smještena u kući iz 17. stoljeća, 
                        u kojemu je Ivan Meštrović nekoć živio i oblikovao. ",
        "image_path" => "image4.jpg",
        "x_coordinate" => 32,
        "y_coordinate" => 6
    ],

    [
        "_id" => $attraction_id_5,
        "name" => "Arheološki i etnografski muzeji",
        "description" => "S naglaskom na bogatu povijest Hrvatske, Arheoloski muzej u 
                        Zagrebu ima pet glavnih zbirki s oko 400.000 komada, od kojih su 
                        mnogi iz lokalnog područja. Od posebnog je interesa muzejska izložba 
                        egipatskih mumija (tkanina iz mumije Zagreba pokazuje skriptu koja se 
                        tek treba dešifrirati), grčke vaze i srednjovjekovni dio koji se 
                        fokusira na velike migracije naroda. Jedan od najznačajnijih dijelova 
                        je voditelj Plautile iz drevnog grada Salone, kao i opsežna zbirka 
                        novčića, uključujući grčke, keltske, rimske, bizantske i moderne. 
                        Zanimljiv je i Etnografski muzej s bogatom zbirkom koja prikazuje 
                        kulturne povijesti Hrvatske kroz izložbe keramike, nakita, zlata, 
                        glazbala, tekstila, alata, oružja i razrađenih kostima. 
                        Vrijedi posjetiti tradicionalne narodne nošnje, s različitim bojama 
                        i stilovima koji ilustriraju regionalnu raznolikost zemlje.",
        "image_path" => "image5.jpg",
        "x_coordinate" => 121,
        "y_coordinate" => 3
    ],

    [
        "_id" => $attraction_id_6,
        "name" => "Hrvatsko narodno kazalište",
        "description" => "Hrvatsko narodno kazalište, izgrađeno 1895. bečkim arhitektima Hermannom 
                        Helmerom i Ferdinandom Fellnerom, nalazi se na sjeverozapadnom kutu zagrebačke Zelene potkove
                        u Donjem gradu. Službeno otvoren 1894. od strane Austro-Ugarskog cara Franje Josipa I., 
                        ova impozantna žuta struktura u Trgu Marsala značajna je značajka Donji grad, Izgrađen u 
                        neobaroknom i rokoko stilu s dvije male kupole na prednjoj strani i većom kupolom prema natrag,
                        zgrada također ima vrhunsku unutrašnjost koja sadrži djela Vlaha Bukovca i Uvaljak života Ivana 
                        Meštrovića (ako je moguće, nastojite uzeti jednu od redovitih opernih, baletnih ili dramskih predstava).",
        "image_path" => "image6.jpg",
        "x_coordinate" => 20,
        "y_coordinate" => 78
    ],

    [
        "_id" => $attraction_id_7,
        "name" => "Moderna galerija",
        "description" => "U Zagrebu je Galerija moderne umjetnosti (Moderna galerija) Donji 
                        Grad u veličanstvenoj palači Vraniczany, sagrađena 1882. godine. 
                        Dom je brojnih lijepih djela hrvatskih umjetnika iz 19. i 20. stoljeća, 
                        Galerije moderne umjetnosti otvorena 1973. godine, iako je institucija iz 
                        ranih 1900-ih godina kada je počela nabavljati važne dijelove kao što su Ivan Meštrović, 
                        Mirko Racki i F Bilak. Zbirka je izrasla kroz godine i sada prikazuje djela Ljubo Babića, 
                        Miljenka Stančića, V Karasa, M Masica, Emanuela Vidovića i niz drugih poznatih hrvatskih umjetnika, 
                        uz česte privremene izložbe.",
        "image_path" => "image7.jpg",
        "x_coordinate" => 35,
        "y_coordinate" => 76
    ],

    [
        "_id" => $attraction_id_8,
        "name" => "Park Maksimir",
        "description" => "Dizajniran u stilu starog engleskog vrta, Maksimirski park (Maksimirska) je prekrasan 
                        zeleni prostor koji obuhvaća gotovo 45 hektara. Najveći park u Zagrebu, sadrži dva paviljona: 
                        Bellevue paviljon, izgrađen 1843. i Echo paviljon, dodan nakon švicarskog dizajna. Park također 
                        ima mnoge odlične staze i staze, kao i umjetna jezera, šumovita područja i cvjetne vrtove, što ga 
                        čini idealnim mjestom za opuštanje ili piknik. Za one koji putuju s djecom, postoji i mali zoološki vrt. 
                        Poznati lokalni stanovnici kao živi spomenik Zagreba, Maksimirski park dobio je ime po 
                        biskupu Maksimilijanu Vrhovcu koji je 1794. bio odgovoran za izgradnju. Preko parkova Maksimir je 
                        Nogometni stadion Dinamo gdje je Hrvatska domaćin međunarodnih utakmica.",
        "image_path" => "image8.jpg",
        "x_coordinate" => 98,
        "y_coordinate" => 17
    ],

    [
        "_id" => $attraction_id_9,
        "name" => "Crkva sv. Katarine",
        "description" => "Isusovačka crkva Sv. Katarine sagrađena je u prvoj polovici 17. stoljeća i smatra 
                        se jednim od najljepših crkava u Zagrebu. Izdvajamo uključuju njegovu prekrasnu 
                        unutrašnjost s mnogim lijepim primjerima barokne umjetnosti, uz reljefne 
                        štukature talijanskog umjetnika Antonio Quadrio iz 1720-ih. Značajno je 
                        također i strop broda s brojnim medaljonima s prizorima koji prikazuju život Svete 
                        Katarine od Giulio Quaglie. Ostale zanimljivosti su oltari sv. Ignacija Francesca Robbe, 
                        a iza glavnog oltara freska Sv. Katarina među Alexandrinim filozofima i pisacima 
                        Kristof Andrej Jelovsek iz 1762.",
        "image_path" => "image9.jpg",
        "x_coordinate" => 53,
        "y_coordinate" => 69
    ],

    [
        "_id" => $attraction_id_10,
        "name" => "Toranj Lotrščak",
        "description" => "Izgrađen da čuva južna vrata gradskog zida, kula Lotrščak (Kula Lotrščak) datira 
                        iz 13. stoljeća i odavno je jedna od najprepoznatljivijih zagrebačkih znamenitosti. 
                        Legenda kaže da je ta velika, četvrtasta romanička kula nekoć održavala 
                        zvono koje je svake noći zazvonilo prije zatvaranja vrata kako bi se stanovnici 
                        izvan zidina upozoravali da se vrate (svi koji su ostali vani trebali bi ostati 
                        tamo za noć). U 19. stoljeću, u kula je dodan četvrti kat i prozori, a na krovu 
                        je postavljen top, koji je od tada otkazan svaki dan u podne. Posjetitelji mogu 
                        penjati se na toranj za zapanjujuće poglede na grad i posjetiti izložbenu galeriju 
                        i trgovine poklonima. Druga važna srednjovjekovna struktura je Kamenita vrata (Kamenita Vrata), 
                        zadnja od pet izvornih gradskih vrata. Izgrađena u 13. stoljeću, zgrada slavno 
                        preživjela požar u 1731, kao i njegova slika Marije i Isusa. Kako bi se spomenuo važnu relikvije, 
                        sagrađena je kapelica za slikanje (predmet hodočašća od tada, još uvijek se može vidjeti iza metalne rešetke).",
        "image_path" => "image10.jpg",
        "x_coordinate" => 42,
        "y_coordinate" => 22
    ],

    [
        "_id" => $attraction_id_11,
        "name" => "Gradski muzej",
        "description" => "Gradski muzej (Muzej Grada Zagreba), na zagrebačkom Gornjem gradu, sastoji se od 
                        samostana sv. Claira, kula iz 11. stoljeća i 17. stoljeća žitnice.Izgrađen uz 
                        istočni gradski zid, muzej je u funkciji od 1907. godine, a kuća ima 12 kolekcija, uključujući 
                        gotovo 75.000 komada. Zajednički zbirke opisuju povijest Zagreba kroz dokumente, mape, umjetnost, 
                        arheološke nalaze i druge povijesne cjeline, uključujući vrhunski model starog grada Gradeca. 
                        Gradski muzej također ima interaktivne muzeje za zanimanje djece, uključujući 
                        zabavne radne radionice i igraonicu",
        "image_path" => "image11.jpg",
        "x_coordinate" => 27,
        "y_coordinate" => 59
    ],

    [
        "_id" => $attraction_id_12,
        "name" => "Strossmayerova galerija starih majstora",
        "description" => "Strossmayerova Galerija Starih Majstora nalazi se na drugom katu Hrvatska akademija 
                        znanosti i umjetnosti u Donji grad Zagreba. Ova neorenesansna građevina iz 19. 
                        stoljeća naručila je biskup Josip Juraj Strossmayer 1870-ih godina u kojoj je smještena 
                        Akademija i Galerija starih majstora i sadrži zbirku od gotovo 600 komada, koje je i 
                        sam donirao. Na izložbi su djela G Bellini, Veronese, Tiepolo, Bartolomeo Caporali, Proudhon, 
                        Carpeaux, Brueghel, Van Dyck, hrvatski umjetnici Medulić i Benković te skulptura poznatog 
                        hrvatskog kipara Ivana Meštrovića. Vrijedi posjetiti i Muzej za umjetnost i obrt sa zbirkom od 
                        preko 160.000 komada iz Hrvatske i drugih europskih zemalja. Na izložbi su tekstili, 
                        uključujući poznati varaždinski vez i tapiserije iz Tournaija, Antwerpena i Bruxellesa, 
                        kao i rijetki nakit, glazbeni instrumenti, gotičke i barokne skulpture, slike i keramike.",
        "image_path" => "image12.jpg",
        "x_coordinate" => 32,
        "y_coordinate" => 65
    ],

    [
        "_id" => $attraction_id_13,
        "name" => "Muzeji naivne umjetnosti i razbijene veze",
        "description" => "Uz mnoge institucije likovne umjetnosti i povijesti, Zagreb ima niz prilično jedinstvenih, 
                        čak i nevjerojatnih muzeja vrijednih posjeta. Jedan od najpopularnijih je Hrvatski muzej 
                        naivnih umjetnosti s brojnim prikazima djela takvih poznatih naivnih umjetnika kao što su 
                        Ivan Generalić, Mraz, Mirko Virius i Smaljic. Također su prikazani slični stilski radovi - 
                        ponekad nazvani primitivnim umjetničkim djelima - međunarodnih umjetnika. Još jedna 
                        atrakcija od interesa je Muzej prekinutih veza s fascinantnim zbirkama osobnih predmeta 
                        i artefakata starih ljubavnika i partnera, a svaka je popraćena detaljima 
                        o propaloj vezi o kojoj je riječ.",
        "image_path" => "image13.jpg",
        "x_coordinate" => 11,
        "y_coordinate" => 32
    ],

    [
        "_id" => $attraction_id_14,
        "name" => "Botanički vrt grada Zagreba",
        "description" => "Botanički Vrt je izvorno izgrađen kao područje istraživanja za Botanički fakultet 
                        Sveučilišta u Zagrebu. Obuhvaćajući oko 50.000 četvornih metara, 
                        dio je niza parkova, koji čine gradsku Green Horseshoe u Donji grad, 
                        Na osnovi su arboretum, dva bara s brojnim vodenim biljkama, ukrasni most i oko 10.000 
                        različitih biljnih vrsta, čineći ugodan izlazak iz grada i odlično mjesto za 
                        opuštanje ili šetnju. Nakon toga, ako imate još energije za još jedan muzej, 
                        uzmite u obližnje Prirodoslovni muzej (Hrvatski Prirodoslovni Muzej). 
                        Nalazi se u palači Amadeo sagrađenoj početkom 1700. godine, muzej ima oko dvije i pol 
                        milijuna komada, uključujući minerale iz cijelog svijeta, opsežnu zoološku zbirku koja 
                        bilježi niz biljaka i životinja iz Hrvatske, a pronalazi lokalno arheološki iskopi.",
        "image_path" => "image14.jpg",
        "x_coordinate" => 101,
        "y_coordinate" => 3
    ],

];
?>