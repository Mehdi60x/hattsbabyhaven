<?php
//session start à chaque début de controller
session_start();
//require once = appel à un fichier
require_once '../models/usersModel.php';
//tableau d'erreurs
$formErrors = [];
require_once '../errors.php';
//si le formulaire est rempli
if(count($_POST) > 0){
    $user = new users;

    //  Vérifie si l'utilisateur a saisi une adresse e-mail dans un formulaire de connexion,
    //  Si l'adresse est bien formatée, et si elle existe dans la base de données.
    //  Selon le résultat de ses vérif, des messages d'erreur appropriés sont affichés.
    if(!empty($_POST['email'])){
        //filter var => comme une regex
        if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            $user->email = $_POST['email'];
            //si l'email n'existe pas dans la bdd
            if($user->checkAvaibility() == 0){
                //on affiche l'erreur 
                $formErrors['email'] = $formErrors['password'] = USERS_LOGIN_ERROR_INCORRECT;
            }
        } else {
            $formErrors['email'] = USERS_EMAIL_ERROR_INVALID;
        }
    } else {
        $formErrors['email'] = USERS_EMAIL_ERROR_EMPTY;
    }

    // Méthode qui vérifie si l'utilisateur a saisi un mot de passe dans un formulaire de connexion 
    // compare aussi ce mot de passe avec celui stocké dans la base de données.
    if (!empty($_POST['password'])) {
        if (!isset($formErrors['email'])) {
            //stocker le password haché
            $user->password = $user->getHash();
            //vérifier si le password haché correspond au passord saisi
            if (password_verify($_POST['password'], $user->password)) {
                $_SESSION['user'] = $user->getInfos();
                $_SESSION['user']['email'] = $user->email;

                header('Location:/profil');
                exit;
            } else {
                $formErrors['email'] = $formErrors['password'] = USERS_LOGIN_ERROR_INCORRECT;
            }
        }
    } else {
        $formErrors['password'] = USERS_PASSWORD_ERROR_EMPTY;
    }
}
require_once '../views/parts/header.php';
require_once '../views/login.php';
require_once '../views/parts/footer.php';
?>
