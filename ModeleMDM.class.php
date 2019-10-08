<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

error_reporting(E_ALL);
ini_set("display_errors", 1);
require_once 'ModeleAbstrait.class.php';

class ModeleMDM extends ModeleAbstrait
{
    private $idWaldec='';
    private $idSiret='';
    private $name = '';
    private $address='';
    private $codeINSEE= '';
    private $geoCoord='';
    private $email='';
    private $phone='';
    private $private = 0;
    private $referentEntityId=1;
    private $useLiason=0;
    private $liaisonReferentEntity=1;
    private $liaisonFileUrl='';
    private $hours='';
    private $validated=1;

    public function __construct(array $donnees=array())
    {
        parent::__construct();
        $this->name             = $donnees['nom'];
        $this->address          = $donnees['adresse'];
        $this->geoCoord         = $donnees['geoCoord'];
        $this->email            = $donnees['email'];
        $this->phone            = $donnees['telephone'];
        $this->hours            = $donnees['hours'];
        $this->liaisonFileUrl   = $donnees['liaisonFileUrl'];

    }


    public function inscrireMDMEnBase()
    {
        $req = $this->BDD->prepare('INSERT INTO referent_entity (
                             name,
                             address,
                             "geoCoord",
                             email,
                             phone,
                             "liaisonFileUrl") VALUES (?,?,?,?,?,?)');
        try
        {
            $this->BDD->beginTransaction();
            $req->execute([
                $this->name,
                $this->address,
                $this->geoCoord,
                $this->email,
                $this->phone,
                $this->liaisonFileUrl
            ]);
            $this->BDD->commit();
        } catch(PDOException $e)
        {
            $this->BDD->rollback();
            print "Error!: " . $e->getMessage() . "</br>";
        }

        $req = $this->BDD->prepare('INSERT INTO partner_structure (
                               name,
                               address,
                               "geoCoord",
                               email,
                               phone,
                               private,
                               "useLiaison",
                               "liaisonReferentEntity",
                               "liaisonFileUrl",
                               hours
                               ) VALUES (?,?,?,?,?,?,?,?,?,?)');
        try
        {
            $this->BDD->beginTransaction();
            $req->execute([
                $this->name,
                $this->address,
                $this->geoCoord,
                $this->email,
                $this->phone,
                $this->private,
                $this->useLiason,
                $this->liaisonReferentEntity,
                $this->liaisonFileUrl,
                $this->hours
            ]);
            $this->BDD->commit();
        } catch(PDOException $e)
        {
            $this->BDD->rollback();
            print "Error!: " . $e->getMessage() . "</br>";
        }
    }
}