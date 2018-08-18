<?php
/*
-----------------------------------
------ SCRIPT DE PROTECTION -------
          DBProtect V1.2
-----------------------------------
*/
// Param�tres de connexion
$hostname_dbprotect = "localhost"; // nom ou ip de votre serveur
$database_dbprotect = "dbprotect"; // nom de votre base de donn�es
$username_dbprotect = "root"; // nom d'utilisateur (root par d�faut) !!! ATTENTION, en utilisant root, vos visiteurs on tout les droits sur la base
$password_dbprotect = ""; // mot de passe (aucun par d�faut mais il est fortement recommand� d'en mettre un ... sinon, � quoi bon la s�curit� ?)

$dbprotect=mysqli_connect("localhost","root","","dbprotect");


// $dbprotect = mysqli_connect($hostname_dbprotect, $username_dbprotect, $password_dbprotect) or trigger_error(mysqli_error(),E_USER_ERROR); 
?>