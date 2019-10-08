<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class ModelePartenaire extends ModeleAbstrait
{
    private $idWaldec='';
    private $idSiret='';
    private $name='';
    private $address='';
    private $codeINSEE= '';
    private $geoCoord='';
    private $email='';
    private $phone='';
    private $logoUrl='';
    private $notes='';
    private $private=false;
    private $referentEntityId=1;
    private $useLiason=false;
    private $liaisonReferentEntity=true;
    private $liaisonFileUrl='';
    private $hours='';
    private $validated=true;

    public function __construct(array $donnees=array())
    {
        parent::__construct();
        $this->idWaldec         = $donnees['idWaldec'];
        $this->idSiret          = $donnees['idSiret'];
        $this->name             = $donnees['nom'];
        $this->address          = $donnees['adresse'];
        $this->codeINSEE        = $donnees['codeINSEE'];
        $this->geoCoord         = $donnees['geoCoord'];
        $this->email            = $donnees['email'];
        $this->siteWeb          = $donnees['siteWeb'];
        $this->phone            = $donnees['telephone'];
        $this->logoUrl          = $donnees['logoUrl'];
        $this->notes            = $donnees['notes'];
        $this->private          = $donnees['private'];
        $this->referentEntityId = $donnees['referentEntityId'];
        $this->useLiason        = $donnees['useLiason'];
        $this->liaisonReferentEntity= $donnees['liaisonReferentEntity'];
        $this->liaisonFileUrl   = $donnees['liaisonFileUrl'];
        $this->hours            = $donnees['hours'];
        $this->validated        = $donnees['validated'];
        //var_dump($this);
    }


    public function inscrirePartenaireEnBase()
    {
        $req = $this->BDD->prepare('INSERT INTO partner_structure (
                               name,
                               address,
                               "geoCoord",
                               email,
                               phone,
                               "logoUrl",
                               notes,
                               private,
                               "referentEntityId",
                               "useLiaison",
                               "liaisonReferentEntity",
                               "liaisonFileUrl",
                               "hours",
                               "validated",
                               "siret",
                               "waldec",
                               "insee"
                               ) VALUES (?,?,?,?,?,?, ?,?,?,?,?,?, ?,?,?,?,?)');
        try
        {
            $this->BDD->beginTransaction();
            $req->execute([
                $this->name,
                $this->address,
                $this->geoCoord,
                $this->email,
                $this->phone,
                $this->logoUrl,
                $this->notes,
                0,
                $this->referentEntityId,
                0,
                1,
                $this->liaisonFileUrl,
                $this->hours,
                1,
                $this->idSiret,
                $this->idWaldec,
                $this->codeINSEE
            ]);
            $this->BDD->commit();
        } catch(PDOException $e)
        {
            $this->BDD->rollback();
            print "Error!: " . $e->getMessage() . "</br>";
        }
    }
}