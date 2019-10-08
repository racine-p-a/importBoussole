<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

error_reporting(E_ALL);
ini_set("display_errors", 1);
require_once 'ModeleAbstrait.class.php';

class ModeleMDM extends ModeleAbstrait
{
    private $name = '';
    private $address='';
    private $geoCoord='';
    private $email='';
    private $phone='';
    private $liaisonFileUrl='';

    public function __construct(array $donnees=array())
    {
        parent::__construct();
        $this->name             = $donnees['nom'];
        $this->address          = $donnees['adresse'];
        $this->geoCoord         = $donnees['geoCoord'];
        $this->email            = $donnees['email'];
        $this->phone            = $donnees['telephone'];
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
    }
}