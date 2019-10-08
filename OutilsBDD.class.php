<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

error_reporting(E_ALL);
ini_set("display_errors", 1);
class OutilsBDD
{
    /**
     * @var string L'adresse de votre base MySQL.
     */
    private $hote = 'pgsql:host=localhost'; // Changez et mettez votre nom d'hôte. Il est sans doute différent si sur
    // une machine différente. Dans le cas contraire, laissez tel quel.
    /**
     * @var string Le nom de base qui doit être utilisée. Nom conseillé à l'installation : curlVocapia.
     */
    private $nomBase = 'boussole';   // Pensez à changer la base. Conseil : il vous a été conseillé à
    //l'installation de la nommer curlVocapia
    /**
     * @var string Un utilisateur MySQL ayant des droits sur cette base.
     */
    private $utilisateur = 'boussole';   // Je vous suggère d'avoir créé un utilisateur n'ayant de droits que
    // sur la base curlVocapia. Cela vous évitera de possibles problèmes de sécurité.
    /**
     * @var string Le mot de passe de l'utilisateur ayant des droits sur la base.
     */
    private $motDePasseBDD = 'boussole'; // Le mot de passe que vous avez mis à l'utilisateur de votre
    // base de données.
    /**
     * @var self L'instance unique de cette classe. Pour être sûr qu'il n'y a qu'une et une seule instance.
     */
    private static $instance;
    /**
     * @var PDO Le lien de connexion BD (objet PDO).
     */
    protected $connexion;
    /**
     * OutilsBDD constructor. Constructeur privé qui initialise la connexion.
     */
    private function __construct()
    {
        // Création d'un objet PDO avec les variables suivantes :
        $this->connexion = new PDO($this->hote . ';dbname=' . $this->nomBase, $this->utilisateur, $this->motDePasseBDD);
        // Mettre Exception comme mode d'erreur.
        $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    /**
     * // Clonage impossible.
     */
    private function __clone()
    {
    }
    /**
     * @return OutilsBDD Accéder à l'UNIQUE instance de la classe.
     */
    static public function getInstance()
    {
        if (! (self::$instance instanceof self))
        {
            self::$instance = new self();
        }
        return self::$instance;
    }
    /**
     * @return PDO Accesseur de la connexion.
     */
    public function getConnexion()
    {
        return $this->connexion;
    }
}