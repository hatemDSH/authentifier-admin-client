<?php require_once('connexion.php'); ?>
<?php
/*
-----------------------------------
------ SCRIPT DE PROTECTION -------
          DBProtect V1.2
-----------------------------------
*/

session_start(); // On relaye la session
/*
if (session_is_registered("authentification")){ // v�rification sur la session authentification (la session est elle enregistr�e ?)
// ici les �ventuelles actions en cas de r�ussite de la connexion
}*/
if (isset($_SESSION['nom'])){ // v�rification sur la session authentification (la session est elle enregistr�e ?)
  // ici les �ventuelles actions en cas de r�ussite de la connexion
  }

else {
header("Location:index.php?erreur=intru"); // redirection en cas d'echec
}
?>
<html>
<head>
<title>ESPACE PRIVE - DBProtect</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="styles.css" rel="stylesheet" type="text/css">
</head>
<body align="center" >
<div class="boxprinci" align="center"  > 
    <p align="" class="titre"><strong>- : : : VOTRE ESPACE PRIVE : : : -</strong></p>
    <br><br> <br> 
    <p>Bienvenue &quot;<span class="donnee"><?php echo $_SESSION['prenom']; ?></span> <span class="donnee"><?php echo $_SESSION['nom']; ?></span>&quot; dans votre espace s&eacute;curis&eacute;. <br>
     Vous &ecirc;tes connect&eacute; en tant que &quot;<span class="donnee"><?php echo $_SESSION['login']; ?></span>&quot; avec le privil&egrave;ge &quot;<span class="donnee"><?php echo $_SESSION['privilege']; ?></span>&quot;.<br>
     Votre mot de passe est &quot;<span class="donnee"><?php echo $_SESSION['pass']; ?></span>&quot;.<br>
     
     (chiffr&eacute; par MD5 &gt; ne peut donc &ecirc;tre vivible en clair).</p>
</div> 


  <?php 
/*
--- AFFICHAGE CONDITIONNEL OU REDIRECTION EN FONCTION DU PRIVILEGE ---
	Config actuelle : le script g�re un affichage conditionnel
	Pour rediriger l'utilisateur en fonction de son privilege, ajoutez les lignes suivantes aux endroits indiqu�s
	Dans la zone d'affichage admin : 
			header("Location:URL SI ADMIN")
	Dans la zone d'affichage admin : 
			header("Location:URL SI USER SIMPLE")
			
Note: pour ajouter des privil�ges, editez ce fichier en rajoutant une condition d'affichage
et editez le fichier admin.php en ajoutant � la liste "select" un privilege.
*/
  
  
  // si l'utilisateur est connect� comme admin ...
  if($_SESSION['privilege'] == "admin") {
     // Affichage conditionnel : si et seulement si l'utilisateur est connect� avec le privilege administrateur ?>
<strong><u>En tant qu'administrateur vous pouvez effectuer les actions suivantes : </u></strong></p>
<p class="Style4">- <a href="admin.php">G&eacute;rer les utilisateurs</a>
  <?php } // fin de l'affichage conditionnel?>
</p>
<p>
  <?php 
  // si l'utilisateur est connect� comme simple utilisateur ...
  if($_SESSION['privilege'] == "user") { // Affichage conditionnel : si et seulement si l'utilisateur est connect� avec le privilege utilisateur simple ?>
  <strong><u>En tant qu'utilisateur simple vous ne pouvez pas effectuer d'actions</u></strong>
<?php } // fin de l'affichage conditionnel?>
</p>
<p align="center"><a href="index.php?erreur=logout"><strong>Vous d&eacute;connecter</strong></a></p>
</body>
</html>
