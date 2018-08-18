<?php require_once('connexion.php'); ?>
<?php
/*
-----------------------------------
------ SCRIPT DE PROTECTION -------
          DBProtect V1.2
-----------------------------------
*/

session_start(); // On relaye la session
if (isset($_SESSION['nom']) && $_SESSION['privilege'] == "admin" ){ // v�rification sur la session authentification (la session est elle enregistr�e ?)
  // ici les �ventuelles actions en cas de r�ussite de la connexion
  }
/*
if (session_is_registered("authentification") && $_SESSION['privilege'] == "admin"){ // v�rification sur la session authentification (la session est elle enregistr�e ?)
// On v�rifie �galement si la session ouverte est bien une session admin et on place ici les �ventuelles actions en cas de r�ussite de la connexion
}*/
else {
header("Location:index.php?erreur=intru"); // redirection en cas d'echec
}
?>
<?php 
// ------ AJOUT D'UN UTILISATEUR --------
if(isset($_POST['login'])){ // on v�rifie la pr�sence des variables de formulaire (si le formulaire a �t� envoy�)
	if(($_POST['login'] == "") || ($_POST['pass'] == "")){ // si login ou mot de passe non sp�cifi�s >> message d'erreur
		header("Location:admin.php?erreur=empty");
	}
	else if($_POST['pass'] == $_POST['pass2']){ // on v�rifie si le mot de passe et le mot de passe confirm� ont la m�me valeur
		// on passe toutes les variables $POST en variables
		$login = $_POST['login'];
		$pass = md5($_POST['pass']); // ici, on crypte le mot de passe � l'aide de MD5 (c'est tout simple non ? :)
		$nom = $_POST['nom'];
		$prenom = $_POST['prenom'];
		$privilege = $_POST['privilege'];
		// on fait l'INSERT dans la base de donn�es
		$add_user = sprintf("INSERT INTO utilisateurs (login, pass, nom, prenom, privilege) VALUES ('$login', '$pass', '$nom', '$prenom', '$privilege')");
    //	mysqli_select_db($database_dbprotect, $dbprotect);
    $dbprotect=mysqli_connect("localhost","root","","dbprotect");
  	$result = mysqli_query($dbprotect,$add_user ) or die(mysql_error($dbprotect));
		header("Location:admin.php?add=ok"); // redirection si cr�ation r�ussie
	}
	else{
		header("Location:admin.php?erreur=pass"); // redirection si le pass1 est diff�rent du pass2
	}
}

// ------ SUPPRESSION D'UN UTILISATEUR --------
// on fait la requ�te sur tous les utilisateurs de la base pour alimenter notre s�lecteur (on fait un tri par nom)
// mysqli_select_db($database_dbprotect, $dbprotect);
$dbprotect= mysqli_connect ($hostname_dbprotect,$username_dbprotect,$password_dbprotect,"dbprotect");
$query_users = "SELECT * FROM utilisateurs ORDER BY nom ASC"; // ORDER BY renvoi les donn�es tri�es (ici par nom croissant)
$users = mysqli_query($dbprotect ,$query_users ) or die(mysqli_error($dbprotect));
// mysqli_query($con,"SELECT * FROM Persons");
$row_users = mysqli_fetch_assoc($users);

if(isset($_POST['suppr']) && ($_POST['suppr'] != "1")){ // on v�rifie la pr�sence des variables de formulaire (si le formulaire a �t� envoy�)
	$id = $_POST['suppr'];
    $delete_user = sprintf("DELETE FROM utilisateurs WHERE id_user='$id'");
    $dbprotect= mysqli_connect ($hostname_dbprotect,$username_dbprotect,$password_dbprotect,"dbprotect");
  // mysqli_select_db($database_dbprotect, $dbprotect);
  $result = mysqli_query($dbprotect,$delete_user) or die(mysqli_error($dbprotect));
  header("Location:admin.php?delete=ok"); // url qui servira pour afficher le message de r�ussite
}
?>
<html>
<head>
<title>ADMINISTRATION - DBProtect</title>
<link href="styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<form action="" method="post" name="add">
 <div class="titre">- : : : ESPACE ADMINISTRATION : : : -</div> 
 <p align="center">
    <?php if(isset($_GET['erreur']) && ($_GET['erreur'] == "pass")) { // Affiche l'erreur  ?>
    <span class="erreur">Veuillez entrer deux fois votre mot de passe SVP</span>
    <?php } ?>
    <?php if(isset($_GET['add']) && ($_GET['add'] == "ok")) { // Affiche l'erreur ?>
    <span class="reussite">L'utilisateur a &eacute;t&eacute; cr&eacute;&eacute; avec succ&egrave;s !</span>
    <?php } ?>
    <?php if(isset($_GET['erreur']) && ($_GET['erreur'] == "empty")) { // Affiche l'erreur  ?>
    <span class="erreur">Un petit oubli non ? Veuillez renseigner au moins un login et un mot de passe SVP</span>
    <?php } ?>
</p>
  <p align="center"><strong><u>Cr&eacute;er un utilisateur</u></strong></p>
  <table width="350" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#eeeeee" class="tableaux">
    <tr>
      <td width="40"><b>Login</b></td>
      <td width="144"><input name="login" type="text" id="login"></td>
    </tr>
    <tr>
      <td><b> Mot de passe </b> </td>
      <td><input name="pass" type="password" id="pass"></td>
    </tr>
    <tr>
      <td><b> R&eacute;p&eacute;ter mot de passe </b> </td>
      <td><input name="pass2" type="password" id="pass2"></td>
    </tr>
    <tr>
      <td><b> NOM </b> </td>
      <td><input name="nom" type="text" id="nom"></td>
    </tr>
    <tr>
      <td><b> Pr&eacute;nom  </b> </td>
      <td><input name="prenom" type="text" id="prenom"></td>
    </tr>
    <tr>
      <td><b> Privil&egrave;ge </b> </td>
      <td><select name="privilege" id="privilege">
          <option value="user">Utilisateur</option>
          <option value="admin">Administrateur</option>
        </select></td>
    </tr>
    <tr>
      <td height="50" colspan="2"><div align="center">
          <input type="submit" name="Submit" value="Cr&eacute;er cet utilisateur">
        </div></td>
    </tr>
  </table>
</form>
<p align="center"><strong>
  <?php 
if(isset($_GET['delete']) && ($_GET['delete'] == "ok")) { // Affiche l'erreur  ?>
  <span class="reussite">L'utilisateur a &eacute;t&eacute; supprim&eacute; avec succ&egrave;s</span>
  <?php } ?>
  <?php 
if(isset($_POST['verif']) && (!isset($_POST['suppr']))) { // Affiche l'erreur  ?>
</strong><span class="erreur">Veuillez s&eacute;lectionner un utilisateur &agrave; supprimer </span><strong>
<?php } ?>
<?php 
if(isset($_POST['suppr']) && ($_POST['suppr'] == "1")) { // Affiche l'erreur  ?>
</strong><span class="erreur">Vous ne pouvez pas supprimer l'utilisateur par d&eacute;faut toto.<br>
Pour tester la fonction de supression, ajoutez un utilisateur.<br>
Pour s&eacute;curiser votre script, il est fortement recommand&eacute; de le supprimer manuellement dans votre BDD ... </span><strong>
<?php } ?></strong></p>
<form action="" method="post" name="suppr">
  <p align="center"><strong><u>Supprimer un utilisateur</u></strong></p>
  <div align="center">
    <table width="500" border="0" cellpadding="5" cellspacing="0" class="tableaux">
      <tr>
        <td width="240"><div align="center">
            <select name="suppr" size="5" id="select2">
              <?php
	do {  
?>
              <option value="<?php echo $row_users['id_user']?>">
              <?php if($row_users['privilege']== "admin") echo ">> "; echo $row_users['nom']." ".$row_users['prenom']." (".$row_users['login'].")"; if($row_users['privilege']== "admin") echo " <<"?>
              </option>
              <?php
	} while ($row_users = mysqli_fetch_assoc($users));
 		$rows = mysqli_num_rows($users);
  		if($rows > 0) {
      		mysqli_data_seek($users, 0);
	  		$row_users = mysqli_fetch_assoc($users);
		}
?>
            </select>
            <input name="verif" type="hidden" id="verif">
        </div></td>
        <td width="157"><input type="submit" name="Submit2" value="Supprimer cet utilisateur"></td>
      </tr>
    </table>
    <p><a href="accueil.php"><strong>&lt; Retour accueil</strong></a></p>
  </div>
</form>
</body>
</html>