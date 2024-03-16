<?php
session_start();
require_once '../errors.php';
require_once '../models/usersModel.php';

//tableau d'erreurs de formulaire
$formErrors = [];

$regex = [
    'name' => '/^[A-Za-zÀ-ÖØ-öø-ÿ-]+$/',
    'birthdate' => '/^[0-9]{4}(-[0-9]{2}){2}$/',
    'password' => '/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'

];
// Veux dire si le formaulaire est remplie on commence alors les vérification des expresision (condition)
if (count($_POST) > 0) {


    //instanciation de l'objet users
    $user = new users;
    // fonction renvoi un résultat 


    //  Méthode qui assure que les prénoms et les noms entrés dans un formulaire ne sont pas vides 
    //  et correspondent à un format valide
    //  (lettres et caractères spéciaux). Les données sont nettoyées et assignées à des variables dans l'objet $user,
    //  ou des messages d'erreur sont affichés en cas de problème.

    //  Si $post firstname n'est pas vide (!empty)
    if (!empty($_POST['firstname'])) {
        //si la regex firstname correspond à la donnée entrée par l'utilisateur dans firstname = $post firstname
        if (preg_match($regex['name'], $_POST['firstname'])) {
            $user->firstname = strip_tags($_POST['lastname']);
        } else {
            $formErrors['firstname'] = USERS_FIRSTNAME_ERROR_INVALID;
        }
    } else {
        $formErrors['firstname'] = USERS_FIRSTNAME_ERROR_EMPTY;
    }

    if (!empty($_POST['lastname'])) {
        if (preg_match($regex['name'], $_POST['lastname'])) {
            $user->lastname = strip_tags($_POST['firstname']);
        } else {
            $formErrors['lastname'] = USERS_LASTNAME_ERROR_INVALID;
        }
    } else {
        $formErrors['lastname'] = USERS_LASTNAME_ERROR_EMPTY;
    }

    //empty = vide, ! = l'inverse de / n'est pas
    if (!empty($_POST['birthdate'])) {
        //SI la donnée entrer par l'utilisateur correspond (preg_match) à  la regex birthdate
        if (preg_match($regex['birthdate'], $_POST['birthdate'])) {
            $date  = explode('-', $_POST['birthdate']);
            // SI une date est une date valide, puis, si la date est valide, 
            // elle est stockée dans l'objet utilisateur après avoir été nettoyée de tout code HTML
            if (checkdate($date[1], $date[2], $date[0])) {
                $user->birthdate = strip_tags($_POST['birthdate']);
            } else {
                $formErrors['birthdate'] = USERS_BIRTHDATE_ERROR_INVALID;
            }
        } else {
            $formErrors['birthdate'] = USERS_BIRTHDATE_ERROR_INVALID;
        }
    } else {
        $formErrors['birthdate'] = USERS_BIRTHDATE_ERROR_EMPTY;
    }

    // Méthode qui vérifie i l'utilisateur a saisi une adresse e-mail non vide et valide. 
    // Si l'adresse est correcte, elle est nettoyée et stockée. 
    // Si l'adresse e-mail est déjà enregistrée dans la base de données, ou si elle est invalide.
    // ALORS affichage des messages d'erreur.
    if (!empty($_POST['email'])) {
        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            //si les conditions d'au dessus sont vraies, on attribut la valeur entrée par
            //l'utilisateur ($POST['exemple']) à l'attribut de l'objet = $user->email.
            $user->email = strip_tags($_POST['email']);

            try {
                //vérification de la disponibilté de l'email dans la bdd
                if ($user->checkAvaibility() == 1) {
                    $formErrors['email'] = USERS_EMAIL_ERROR_ALREADY_EXISTS;
                }
                //sinon j'attrape les erreurs lié au PDO et j'affiche mon erreur 
            } catch (PDOException $e) {
                $formErrors['general'] = DB_ERROR_GENERAL;
            }

        } else {
            $formErrors['email'] = USERS_EMAIL_ERROR_INVALID;
        }
    } else {
        $formErrors['email'] = USERS_EMAIL_ERROR_EMPTY;
    }

    // Méthode qui vérifie si l'utilisateur a saisi un mot de passe dans un formulaire et si ce mot de passe est valide.
    //Si la données post password n'est pas vide 
    if (!empty($_POST['password'])) {
        //Si la données password match avec la regex password
        if (preg_match($regex['password'], $_POST['password'])) {
            //alors la données password se stock dans l'attribut password de l'objet $user
            $user->password = strip_tags($_POST['password']);
        } else {
            //Si ca matche pas on met cet erreur 
            $formErrors['password'] = USERS_PASSWORD_ERROR_INVALID;
        }
    } else { // si c'est vide on met celle ci 
        $formErrors['password'] = USERS_PASSWORD_ERROR_EMPTY;
    }

    //Méthode qui vérifie si l'utilisateur a saisi une confirmation de mot de passe dans un formulaire d'inscription.
    if (!empty($_POST['passwordConfirm'])) {
        //isset = existe  et !isset = n'existe pas 
        if (!isset($formErrors['password'])) {
            if ($_POST['password'] == $_POST['passwordConfirm']) {
                //password_hash pour crypter le mot de passe dans la bdd
                $user->password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            } else {
                $formErrors['passwordConfirm'] = USERS_PASSWORD_ERROR_DIFFERENT;
            }
        }
    } else {
        $formErrors['passwordConfirm'] = USERS_PASSWORD_CONFIRM_ERROR_EMPTY;
    }

    //Méthode d'ajout d'un nouvel utilisateur à la base de données. 
    //S'il n'y a pas d'erreurs dans le formulaire et que l'ajout réussit, un message de succès est affiché. 
    //SINON, des messages d'erreur appropriés sont affichés en cas d'échec.
    try {
        if (count($formErrors) == 0) {
            if ($user->add()) {
                $success = USERS_ADD_SUCCESS;
            } else {
                $formErrors['general'] = USERS_ADD_FAIL;
            }
        }
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}

require_once '../views/parts/header.php';
require_once '../views/register.php';
require_once '../views/parts/footer.php';