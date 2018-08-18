<?php require_once('connexion.php'); 
 mysqli_connect ($hostname_dbprotect,$username_dbprotect,$password_dbprotect,"dbprotect");
 ?>
<?php
/*
-----------------------------------
------ SCRIPT DE PROTECTION -------
          DBProtect V1.2
-----------------------------------
*/

session_start(); // d�but de session

if (isset($_POST['login'])){ // execution uniquement apres envoi du formulaire (test si la variable POST existe)
	$login = addslashes($_POST['login']); // mise en variable du nom d'utilisateur
	$pass = addslashes(md5($_POST['pass'])); // mise en variable du mot de passe chiffr� � l'aide de md5 (I love md5)
  //$pass = addslashes($_POST['pass']);
// requete sur la table administrateurs (on r�cup�re les infos de la personne)
//mysql_select_db($database_dbprotect, $dbprotect);

$verif_query=sprintf("SELECT * FROM utilisateurs WHERE login='$login' AND pass='$pass'"); // requ�te sur la base administrateurs
$verif = mysqli_query($dbprotect,$verif_query ) or die(mysqli_error($dbprotect));
$row_verif = mysqli_fetch_assoc($verif);
$utilisateur = mysqli_num_rows($verif);

	
	if ($utilisateur) {	// On test s'il y a un utilisateur correspondant
	    echo "ok " ;
	   // session_register("authentification"); // enregistrement de la session
		
		// d�claration des variables de session
		$_SESSION['privilege'] = $row_verif['privilege']; // le privil�ge de l'utilisateur (permet de d�finir des niveaux d'utilisateur)
		$_SESSION['nom']       = $row_verif['nom']; // Son nom
		$_SESSION['prenom']    = $row_verif['prenom']; // Son Pr�nom
		$_SESSION['login'] = $row_verif['login']; // Son Login
		$_SESSION['pass'] = $row_verif['pass']; // Son mot de passe (� �viter)
		
		header("Location:accueil.php"); // redirection si OK
	}
	else {
    echo  "nn " ;
		header("Location:index.php?erreur=login"); // redirection si utilisateur non reconnu
	}
}


// Gestion de la  d�connexion
if(isset($_GET['erreur']) && $_GET['erreur'] == 'logout'){ // Test sur les param�tres d'URL qui permettront d'identifier un contexte de d�connexion
	$prenom = $_SESSION['prenom']; // On garde le pr�nom en variable pour dire au revoir (soyons polis :-)
	session_unset("authentification");
	header("Location:index.php?erreur=delog&prenom=$prenom");
}
?>
<html>
<head>
<title>AUTHENTIFICATION - DBProtect</title>
<link href="styles.css" rel="stylesheet" type="text/css">

</head>
<body>
<div class="" >
    <form action="" method="post" name="connect">
         <p align="center" class="titre"><strong>- : : : ESPACE SECURISE PAR DBProtect : : : -</strong></p>
         <p align="center" class="title">
         <?php if(isset($_GET['erreur']) && ($_GET['erreur'] == "login")) { // Affiche l'erreur  ?>
         <strong class="erreur">Echec d'authentification !!! &gt; login ou mot de passe incorrect</strong>
         <?php } ?>
         <?php if(isset($_GET['erreur']) && ($_GET['erreur'] == "delog")) { // Affiche l'erreur ?>
         <strong class="reussite">D&eacute;connexion r&eacute;ussie... A bient&ocirc;t <?php echo $_GET['prenom'];?> !</strong>
         <?php } ?>
         <?php if(isset($_GET['erreur']) && ($_GET['erreur'] == "intru")) { // Affiche l'erreur ?>
         <strong class="erreur">Echec d'authentification !!! &gt; Aucune session n'est ouverte ou vous n'avez pas les droits pour afficher cette page</strong>
          <?php } ?>
         </p>
  <p align="center"><u>Authentification s&eacute;curis&eacute;e utilisant :</u><br>
    - BDD MySQL<br>
    - Sessions PHP c&ocirc;t&eacute; serveur <br>
  - Empreintes des mot de passe stock&eacute;s par md5</p>
  <p align="center"><em><a href="lisez_moi.htm">lire les instructions d'installation &gt;&gt;</a><br>
    <a href="details.doc">lire le fonctionnement d&eacute;taill&eacute; &gt;&gt;</a></em></p>
  <table width="300"  border="0" align="center" cellpadding="10" cellspacing="0" bgcolor="#eeeeee" class="tableaux">
    <tr>
      <td width="50%"><div align="right">login</div></td>
      <td width="50%"><input name="login" type="text" id="login"></td>
    </tr>
    <tr>
      <td width="50%"><div align="right">mot de passe</div></td>
      <td width="50%"><input name="pass" type="password" id="pass"></td>
    </tr>
    <tr>
      <td height="34" colspan="2"><div align="center">
          <input type="submit" name="Submit" value="Se connecter">
      </div></td>
    </tr>
  </table>
  <p align="center"><a href="http://www.cv-webmaster.com" title="cv webmaster webdesigner d�veloppeur php/mysql">CV webmaster et auteur du script</a></p>
</form>
</body>
</html>
