<?php
//usermodel gére les informations des utilisateurs, les enregistrer dans la base de données et les récupérer au besoin.

//objet users : objet utilisateur ( class users)
class users{
    // Attributs de l'objet = colonnes de table user : on les retrouve dans phpmyadmin
    public $id;
    public $lastname;
    public $firstname;
    public $birthdate;
    public $email;
    public $password;
    private $db;
    // Lire Setter getter a voir absolument !

    //Méthode connexion à la bdd (base de données) : construct se déclenche au moment de l'instanciation de l'objet
    public function __construct(){
        try{
            $this->db = new PDO('mysql:host=localhost;dbname=hattsbabyhaven;charset=utf8', 'test', 'test');
        } catch (PDOException $e){
            die($e->getMessage());
        }
    }
    //Méthode pour ajouter un utilisateur dans la base de données.
    public function add(){
        //query = requete
        $query = 'INSERT INTO `kh9jg_users`(`lastname`, `firstname`, `birthdate`, `email`, `password`) 
        VALUES (:lastname, :firstname, :birthdate, :email, :password)';
        //préparer la requete
        $request = $this->db->prepare($query);
        //bindValue => associer des valeurs
        //:firstname => marqueur nominatif => la future valeur entrée par l'utiisateur dans le form
        $request->bindValue(':lastname', $this->lastname, PDO::PARAM_STR);
        $request->bindValue(':firstname', $this->firstname, PDO::PARAM_STR);
        $request->bindValue(':birthdate', $this->birthdate, PDO::PARAM_STR);
        $request->bindValue(':email', $this->email, PDO::PARAM_STR);
        $request->bindValue(':password', $this->password, PDO::PARAM_STR);
        //executer la requete
        return $request->execute();
    }
    
    //Méthode qui vérifie si une adresse e-mail est déjà utilisée dans la base de données en comptant combien de fois elle apparaît.
    //vérifier la dispo de l'email dans la base de données
    public function checkAvaibility(){
        $query = 'SELECT COUNT(*) FROM `kh9jg_users` WHERE `email` = :email;';
        $request = $this->db->prepare($query);
        $request->bindValue(':email', $this->email, PDO::PARAM_STR);
        $request->execute();
        return $request->fetch(PDO::FETCH_COLUMN);
    }
 
    //Méthode pour récupérer le mot de passe hashé
    public function getHash(){
        $query = 'SELECT `password` FROM `kh9jg_users` WHERE `email` = :email;';
        $request = $this->db->prepare($query);
        $request->bindValue(':email', $this->email, PDO::PARAM_STR);
        $request->execute();
        return $request->fetch(PDO::FETCH_COLUMN);
    }

    //Méthode permet de rechercher l'ID d'un utilisateur en utilisant son adresse e-mail dans la base de données.
    public function getInfos() {
        $query = 'SELECT `id` FROM `kh9jg_users` WHERE `email` = :email;';
        $request = $this->db->prepare($query);
        $request->bindValue(':email', $this->email, PDO::PARAM_STR);
        $request->execute();
        return $request->fetch(PDO::FETCH_ASSOC);
    }
    //Méthode permet de mettre à jour les informations d'un utilisateur dans la base de données en utilisant de nouvelles valeurs.
    public function updateInfos(){
        $query = 'UPDATE `kh9jg_users` SET `lastname`= :lastname, `firstname`= :firstname,`birthdate`= :birthdate ,`email`= :email WHERE `id` = :id';
        $request = $this->db->prepare($query);
        $request->bindValue(':lastname', $this->lastname, PDO::PARAM_STR);
        $request->bindValue(':firstname', $this->firstname, PDO::PARAM_STR);
        $request->bindValue(':birthdate', $this->birthdate, PDO::PARAM_STR);
        $request->bindValue(':email', $this->email, PDO::PARAM_STR);
        $request->bindValue(':id', $this->id, PDO::PARAM_INT);
        return $request->execute();
}

    //Méthode pour modifier le mot de passe
     public function updatePassword() {
        $query = 'UPDATE `kh9jg_users` SET `password`= :password WHERE id = :id';
        $request = $this->db->prepare($query);
        $request->bindValue(':password', $this->password, PDO::PARAM_STR);
        $request->bindValue(':id', $this->id, PDO::PARAM_INT);
        return $request->execute();

    }

    //Méthode pour supprimer un compte utilisateur en effectuant une opération de suppression dans la base de données
    //delete user account
    public function deleteAccount()
    {
        $query = 'DELETE FROM kh9jg_users WHERE id = :id';
        $request = $this->db->prepare($query);
        $request->bindValue(':id', $this->id, PDO::PARAM_INT);
        return $request->execute();
    } 
}
