<?php
// define crée une constante (une donnée qui ne peut pas être changée), 

// ICI  on s'en sert pour stocker le message d'erreur qui sera utilisé partout où la donnée doit être vérifiée

define('DB_ERROR_GENERAL', 'Une erreur est survenue, l\'administrateur a été prévenu');
//USERS
//Lastname
define('USERS_LASTNAME_ERROR_EMPTY', 'Veuillez entrer votre nom');
define('USERS_LASTNAME_ERROR_INVALID', 'Votre nom ne peut comporter que des majuscules , minuscules et tirets');

//Firstname
define('USERS_FIRSTNAME_ERROR_EMPTY', 'Veuillez entrer votre prénom');
define('USERS_FIRSTNAME_ERROR_INVALID', 'Votre prénom ne peut comporter que des majuscules , minuscules et tirets');

//Birthdate
define('USERS_BIRTHDATE_ERROR_EMPTY', 'Veuillez entrer votre date de naissance');
define('USERS_BIRTHDATE_ERROR_INVALID', 'Votre date de naissance doit être au format jj/mm/aaaa');

//Email
define('USERS_EMAIL_ERROR_EMPTY', 'Veuillez entrer votre mail');
define('USERS_EMAIL_ERROR_INVALID', 'Votre mail ne peut contenir que des lettres, chiffres, tirets, underscore et doit contenir un arobase');
define('USERS_EMAIL_ERROR_ALREADY_EXISTS', 'L\'adresse mail est déjà utilisée');

//Password
define('USERS_PASSWORD_ERROR_EMPTY', 'Veuillez entrer votre mot de passe');
define('USERS_PASSWORD_ERROR_INVALID', 'Votre mot de passe n\'est pas valide. Il doit comporter au moins 8 caractères dont une majuscule, une minuscule, un chiffre et un caractère spécial');
define('USERS_PASSWORD_CONFIRM_ERROR_EMPTY', 'Veuillez confirmer votre mot de passe');
define('USERS_PASSWORD_ERROR_DIFFERENT', 'Les mots de passe ne correspondent pas');
define('USERS_PASSWORD_CURRENT_ERROR_EMPTY', 'Veuillez entrer votre mot de passe actuel');
define('USERS_PASSWORD_CURRENT_ERROR_INCORRECT', 'Le mot de passe actuel n\'est pas correct');
define('USERS_LOGIN_ERROR_INCORRECT', 'L\'adresse mail ou le mot de passe est incorrect');

//Actions
define('USERS_ADD_SUCCESS', 'Bienvenue, votre inscription à bien été prise en compte.');
define('USERS_ADD_FAIL', 'Votre inscription n\'a pas pu être prise en compte');
define('USERS_UPDATE_SUCCESS', 'Vos informations ont bien été mises à jour');
define('USERS_UPDATE_FAIL', 'Vos informations n\'ont pas pu être mises à jour');
define('USERS_UPDATE_PASSWORD_SUCCESS', 'Votre mot de passe à bien été mis à jour');
define('USERS_UPDATE_PASSWORD_FAIL', 'Votre mot de passe n\'apas pu être mis à jour');