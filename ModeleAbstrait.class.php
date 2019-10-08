<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);
abstract class ModeleAbstrait
{
    /**
     * @var PDO Une instance d'un singleton de connexion à la base de données.
     */
    protected $BDD;

    /**
     * ModeleAbstrait constructor.
     * Récupération de la racine du serveur et du singleton de connexion à la base de données.
     */
    public function __construct()
    {
        include_once("OutilsBDD.class.php");
        $this->BDD = OutilsBDD::getInstance()->getConnexion();
    }
}