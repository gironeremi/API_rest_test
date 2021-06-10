<?php
class Players{
    // Connexion
    private $connexion;
    private $table = "players";

    // object properties
    public $id;
    public $name;
    public $age;
    public $city;

    /**
     * Constructeur avec $db pour la connexion à la base de données
     *
     * @param $db
     */
    public function __construct($db){
        $this->connexion = $db;
    }

    /**
     * Lecture des joueurs
     *
     * @return void
     */
    public function list(){
        // On écrit la requête
        $sql = "SELECT id, name, age, city FROM " . $this->table;

        // On prépare la requête
        $query = $this->connexion->prepare($sql);

        // On exécute la requête
        $query->execute();

        // On retourne le résultat
        return $query;
    }

    /**
     * Créer un joueur
     *
     * @return void
     */
    public function add(){

        // Ecriture de la requête SQL en y insérant le nom de la table
        $sql = "INSERT INTO " . $this->table . " SET name=:name, age=:age, city=:city";

        // Préparation de la requête
        $query = $this->connexion->prepare($sql);

        // Protection contre les injections
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->age=htmlspecialchars(strip_tags($this->age));
        $this->city=htmlspecialchars(strip_tags($this->city));

        // Ajout des données protégées
        $query->bindParam(":name", $this->name);
        $query->bindParam(":age", $this->age);
        $query->bindParam(":city", $this->city);

        // Exécution de la requête
        if($query->execute()){
            return true;
        }
        return false;
    }

    /**
     * Lire un joueur
     *
     * @return void
     */
    public function get(){
        // On écrit la requête
        $sql = "SELECT id, name, age, city FROM " . $this->table . " WHERE id = ?";

        // On prépare la requête
        $query = $this->connexion->prepare( $sql );

        // On attache l'id
        $query->bindParam(1, $this->id);

        // On exécute la requête
        $query->execute();

        // on récupère la ligne
        $row = $query->fetch(PDO::FETCH_ASSOC);

        // On hydrate l'objet
        $this->name = $row['name'];
        $this->age = $row['age'];
        $this->city = $row['city'];
    }

    /**
     * Supprimer un joueur
     *
     * @return void
     */
    public function delete(){
        // On écrit la requête
        $sql = "DELETE FROM " . $this->table . " WHERE id = ?";

        // On prépare la requête
        $query = $this->connexion->prepare( $sql );

        // On sécurise les données
        $this->id=htmlspecialchars(strip_tags($this->id));

        // On attache l'id
        $query->bindParam(1, $this->id);

        // On exécute la requête
        if($query->execute()){
            return true;
        }
        
        return false;
    }

    /**
     * Mettre à jour un joueur
     *
     * @return void
     */
    public function update(){
        // On écrit la requête
        $sql = "UPDATE " . $this->table . " SET name=:name, age=:age, city=:city WHERE id = :id";
        
        // On prépare la requête
        $query = $this->connexion->prepare($sql);
        
        // On sécurise les données
        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->age=htmlspecialchars(strip_tags($this->age));
        $this->city=htmlspecialchars(strip_tags($this->city));
        
        // On attache les variables
        $query->bindParam(':id', $this->id);
        $query->bindParam(':name', $this->name);
        $query->bindParam(':age', $this->age);
        $query->bindParam(':city', $this->city);
        
        // On exécute
        if($query->execute()){
            return true;
        }
        
        return false;
    }

}