<?php
session_start();
require_once '../models/usersModel.php';
require_once '../errors.php';

// Cette expression vérifie si des chaînes de texte correspondent à des formats spécifiques, 
// tels que des prénoms, des dates de naissance et des mots de passe sécurisés.
$regex = [
    'name' => '/^[A-Za-zÀ-ÖØ-öø-ÿ-]+$/',
    'birthdate' => '/^[0-9]{4}(-[0-9]{2}){2}$/',
    'password' => '/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'
];

$formErrors = [];

// Ce code crée un outil pour s'occuper des infos d'un utilisateur et lui dit de s'occuper spécifiquement de l'utilisateur qui est connecté.
// pour faire des changements ou des actions liées à cet utilisateur.
$userUpdate = new users;
$userUpdate->id = $_SESSION['user']['id'];

// Méthode permet à un utilisateur de supprimer son compte. 
// S'il clique sur le bouton de suppression, son compte est effacé, il est déconnecté,
//  et il est renvoyé à la page d'accueil du site.
if (isset($_POST['delete'])) {
    if ($userUpdate->deleteAccount()) {
        unset($_SESSION['user']);
        session_destroy();
        header('Location: /accueil');
        exit;
    }
   }
//Méthode MODIFICATION PROFIL, vérifie que l'utilisateur a saisi un prénom non vide et valide dans un formulaire. 
//S'il le fait, le prénom est sécurisé en retirant les balises HTML, puis il est assigné à l'utilisateur. 
//Si le prénom n'est pas correct, des messages d'erreur appropriés sont affichés.
if (isset($_POST['updateInfos'])) {
    if (!empty($_POST['firstname'])) {
        if (preg_match($regex['name'], $_POST['firstname'])) {
            //isset : si la donnée updateInfos existe
            //!empty: si la donnée firstname n'est pas remplie
            //preg_match: si la donée firstname match avec la regex name
            // strips_tags sert à retirer les balises html => permet de securisé le fonctionnement du site
            $userUpdate->firstname = strip_tags($_POST['firstname']);
        } else {
            $formErrors['firstname'] = USERS_LASTNAME_ERROR_INVALID;
        }
    } else {
        $formErrors['firstname'] = USERS_LASTNAME_ERROR_EMPTY;
    }


    if (!empty($_POST['lastname'])) {
        if (preg_match($regex['name'], $_POST['lastname'])) {
            $userUpdate->lastname = strip_tags($_POST['lastname']);
        } else {
            $formErrors['lastname'] =  USERS_FIRSTNAME_ERROR_INVALID;
        }
    } else {
        $formErrors['lastname'] = USERS_FIRSTNAME_ERROR_EMPTY;
    }

    // Méthode vérifie que la date de naissance soumise dans le formulaire est non vide, bien formatée, et valide. 
    // Si ces conditions sont remplies, du coût  
    // il enregistre la date de naissance de l'utilisateur. Sinon, il affiche des messages d'erreur appropriés.
    if (!empty($_POST['birthdate'])) {
        if (preg_match($regex['birthdate'], $_POST['birthdate'])) {
            $date  = explode('-', $_POST['birthdate']);
            if (checkdate($date[1], $date[2], $date[0])) {
                $userUpdate->birthdate = strip_tags($_POST['birthdate']);
            } else {
                $formErrors['birthdate'] = USERS_BIRTHDATE_ERROR_INVALID;
            }
        } else {
            $formErrors['birthdate'] = USERS_BIRTHDATE_ERROR_INVALID;
        }
    } else {
        $formErrors['birthdate'] = USERS_BIRTHDATE_ERROR_EMPTY;
    }

    // Il vérifie que l'adresse e-mail soumise dans le formulaire est non vide, a un format valide, 
    // n'est pas déjà utilisée par un autre utilisateur, et la nettoie avant de l'enregistrer.
    // S'il y a des problèmes avec l'adresse e-mail, des messages d'erreur appropriés sont alors affichés.
    if (!empty($_POST['email'])) {
        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $userUpdate->email = strip_tags($_POST['email']);
            try {
                //vérification de la disponibilté de l'email dans la bdd
                if ($userUpdate->checkAvaibility() == 1 && $userUpdate->email != $_SESSION['user']['email']) {
                    $formErrors['email'] = USERS_EMAIL_ERROR_ALREADY_EXISTS;
                }
            } catch (PDOException $e) {
                $formErrors['general'] = DB_ERROR_GENERAL;
            }
        } else {
            $formErrors['email'] = USERS_EMAIL_ERROR_INVALID;
        }
    } else {
        $formErrors['email'] = USERS_EMAIL_ERROR_EMPTY;
    }

    //si pas d'erreur sur le formulaire je lance la méthode updateInfos


    // Méthode qui vérifie s'il y a des erreurs dans un formulaire.
    // S'il n'y a pas d'erreurs, il tente de mettre à jour les informations de l'utilisateur dans la base de données.
    // Si la mise à jour réussit, il met à jour les informations de l'utilisateur dans la session et affiche un message de succès. 
    // S'il y a des erreurs, il affiche un message d'erreur
    if (count($formErrors) == 0) {
        $userUpdate->id = $_SESSION['user']['id'];
        try {
            if ($userUpdate->updateInfos()) {
                $_SESSION['user']['firstname'] = $_POST['firstname'];
                $success['updateInfos'] = USERS_UPDATE_SUCCESS;
            } else {
                $formErrors['general'] = USERS_UPDATE_FAIL;
            }
        } catch (PDOException $e) {
            $formErrors['general'] = DB_ERROR_GENERAL;
            //Ligne pour débuggage : die arrête l'éxecution du code et affiche le message passé en paramètre - ici récupéré par getMessage
            //  die($e->getMessage());
        }
    }
}

//update user password form

//Méthode de vérification pour MODIFIER MOT DE PASSE d'un utilisateur sur un site web.
if (isset($_POST['updatePassword'])) {
    if (!empty($_POST['currentPassword'])) {
        $userUpdate->email = $_SESSION['user']['email'];
        $password = $userUpdate->getHash();
        if (!password_verify($_POST['currentPassword'], $password)) {
            $formErrors['currentPassword'] = USERS_PASSWORD_CURRENT_ERROR_INCORRECT;
        }
    } else {
        $formErrors['currentPassword'] = USERS_PASSWORD_CURRENT_ERROR_EMPTY;
    }


    // Méthode qui vérifie si l'utilisateur a SAISIR UN NOUVEAU MOT DE PASSE non vide et qu'il répond à des critères de sécurité. 
    // Si le mot de passe est valide, il est considéré comme correct. 
    // SINON , des messages d'erreur appropriés sont affichés.
    if (!empty($_POST['newPassword'])) {
        if (!preg_match($regex['password'], $_POST['newPassword'])) {
            $formErrors['newPassword'] = USERS_PASSWORD_ERROR_INVALID;
        }
    } else {
        $formErrors['newPassword'] = USERS_PASSWORD_ERROR_EMPTY;
    }

    // Vérifie si l'utilisateur a saisi une CONFIRMATION MOT DE PASSE dans un formulaire de mise à jour de mot de passe.
    if (!empty($_POST['passwordConfirm'])) {
        if (!isset($formErrors['newPassword'])) {
            if ($_POST['newPassword'] == $_POST['passwordConfirm']) {
                $userUpdate->password = password_hash($_POST['newPassword'], PASSWORD_DEFAULT);
            } else {
                $formErrors['newPassword'] = $formErrors['passwordConfirm'] = USERS_PASSWORD_ERROR_DIFFERENT;
            }
        }
    } else {
        $formErrors['passwordConfirm'] = USERS_PASSWORD_CONFIRM_ERROR_EMPTY;
    }

    // Cette méthode vérifie s'il y a des erreurs dans un formulaire, et s'il n'y en a pas, 
    // il tente de mettre à jour le mot de passe de l'utilisateur. En fonction du résultat de cette mise à jour, 
    // il affiche un message de succès ou d'échec, et gère les erreurs liées à la base de données.
    if (count($formErrors) == 0) {
        $userUpdate->id = $_SESSION['user']['id'];
        try {
            //SI pas d'erreur j'appelle la méthode userPassword dans l'objet userUpdate
            if ($userUpdate->updatePassword()) {
                $success['password'] = USERS_UPDATE_PASSWORD_SUCCESS;
            } else {
                $formErrors['general'] = USERS_UPDATE_PASSWORD_FAIL;
            }
        } catch (PDOException $e) {
            $formErrors['general'] = DB_ERROR_GENERAL;
            // die($e->getMessage());
        }
    }
}




// Il permet de construire une page web complète en assemblant des parties réutilisables, 
// comme l'en-tête, le contenu du profil, et le pied de page, à partir de fichiers distincts. 
// Cela permet de maintenir une structure cohérente sur l'ensemble du site.
// require_once inclut des fichiers dans une page web.
require_once '../views/parts/header.php';
require_once '../views/profil.php';
require_once '../views/parts/footer.php';