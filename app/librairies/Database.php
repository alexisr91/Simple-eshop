<?php

/*
* Classe database avec PDO
* Connection à la bdd
* Création de requêtes préparées
* Sécurité des données
* Retourner les résultats
*/

class Database
{
    
    private $dbh;
    private $stmt;
    private $error;

    public function __construct()
    {
        // On déclare les DSN

        $dns = 'mysql:host=' . $this->host . ';
                dbname=' . $this->dbname;

        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );
        // On crée une nouvelle instance PDO (avec try et catch)

        try {
            $this->dbh = new PDO($dns, $this->user, $this->password, $options);
        } catch (PDOEXCEPTION $e) {
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }
    // On prépare la requête

    public function query($sql)
    {
        $this->stmt = $this->dbh->prepare($sql);
    }
    // On sécurise les données (bindvalue)

    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR; // PARAM_STRING
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }
    // On execute les requêtes préparées

    public function execute()
    {
        return $this->stmt->execute();
    }
    // On retourne toutes les lignes dans un tableau d'objets

    public function resultSet()
    {
        $this->execute();
        return $this->stmt->fetchALL(PDO::FETCH_OBJ);
    }
    // Retourne une ligne de la table

    public function single()
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }
    // On retourne un nombre de ligne

    public function rowCount(){
        return $this->stmt->rowCount();
    }
}
