<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ini_set('max_execution_time', 300);

$contenuFichier = file_get_contents('docs/ter_territoire.maison_de_la_metropole.json');
$contenuParse = json_decode($contenuFichier, true);


// Table des MDM
include_once 'ModeleMDM.class.php';

foreach ($contenuParse['values'] as $MDM) {
    //var_dump($MDM);
    $MDMCourante = new ModeleMDM(array(
        'nom'=>$MDM['nom'],
        'adresse'=>$MDM['adresse'] . ' ' . $MDM['adresse_complement'] . ' ' . $MDM['code_postal'] . ' ' . $MDM['ville'],
        'geoCoord'=>'{"lon":"' . round($MDM['x_wgs84'], 4) . '","lat":"' . round($MDM['y_wgs84'], 4) . '"}',
        'email'=>$MDM['courriel'],
        'telephone'=>$MDM['telephone'],
        'liaisonFileUrl'=>''
        )
    );
    $MDMCourante->inscrireMDMEnBase();
}


// Table des structures partenaires
require_once 'ModelePartenaire.class.php';
require_once 'BigFileIterator.class.php';
$largefile = new BigFileIterator(__DIR__ . '/data/rna_waldec_20190901.csv');
$iterator = $largefile->iterate("Text");
$compteurAsso = 0;
foreach ($iterator as $line) {
    $donnees_waldec = str_getcsv($line, ';');
    // code postal : 23
    // est actif : 37
    if(count($donnees_waldec)>=38) {
        // La ligne csv est valide.
        if($donnees_waldec[37]==='A' && substr($donnees_waldec[23], 0, 2)=='69' ) {
            // L'association est activé et se trouve dans le Rhône.
            $objetsSociauxGardes = array(
                '009005',
                '009007',
                '009010',
                '009015',
                '009020',
                '009025',
                '009035',
                '030005',
                '030010',
                '030020',
                '030050',
                '014040',
                '014045',
                '014050',
                '014070',
                '020000',
                '020005',
                '020010',
                '020015',
                '020020',
                '020025',
                '007080',
                '003012',
                '003020',
                '003025',
                '003030',
                '003045',
                '003050',
                '003035',
                '015025',
                '015030',
                '015087',
                '015090',
                '015100',
                '019004',
                '019005',
                '019010',
                '019012',
                '019014',
                '019016',
                '019020',
                '019025',
                '019032',
                '019035',
                '019040',
                '019047',
                '019050',
                '019055',
                '032510',
                '032525',
                '017020',
                '017025',
                '017075',
                '017095',
                '017115',
                '017125',
                '017300',
                '018005',
                '018010',
                '018015',
                '018030',
                '018050',
                '021010',
                '021015',
                '021020'
            );
            if( in_array($donnees_waldec[15], $objetsSociauxGardes) || in_array($donnees_waldec[16], $objetsSociauxGardes) ) {
                $compteurAsso++;
                $donnees = array(
                    "idWaldec"=>utf8_encode($donnees_waldec[0]),
                    "idSiret"=>utf8_encode($donnees_waldec[2]),
                    "nom"=>utf8_encode($donnees_waldec[11]),
                    "adresse"=>utf8_encode($donnees_waldec[16] . ' ' . $donnees_waldec[17] . ' ' . $donnees_waldec[18] . ' ' . $donnees_waldec[19] . ' ' . $donnees_waldec[20] . ' ' . $donnees_waldec[23] . ' ' . $donnees_waldec[24]),
                    "codeINSEE"=>utf8_encode($donnees_waldec[22]),
                    "geoCoord"=>"",
                    "email"=>"",
                    "siteWeb"=>utf8_encode($donnees_waldec[34]),
                    "telephone"=>"",
                    "logoUrl"=>"",
                    "notes"=>"",
                    "private"=>0,
                    "referentEntityId"=>1,
                    "useLiason"=>0,
                    "liaisonReferentEntity"=>1,
                    "liaisonFileUrl"=>"",
                    "hours"=>"",
                    "validated"=>1,
                );
                //var_dump($donnees);
                //$partenaireCourant = new ModelePartenaire($donnees);
                //$partenaireCourant->inscrirePartenaireEnBase();
            }
        }
    }
}

echo $compteurAsso;