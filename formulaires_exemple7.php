<?php
// Démarrage ou reprise de session
// Commentaire test.
session_start();  
?>
<!doctype html>
<html lang="fr">
   <head>
     <title>Formulaires - Exemple 6</title>  
     <meta charset="utf-8">
   </head>
   <body>
<?php
function ecrit_formulaire_saisie() {
   echo "<form method=\"post\">\n";
   echo "<p><label>Prénom </label>\n";
   echo "<input type=\"text\" name=\"prénom\" value=\""       
       .(isset($_SESSION['prénom']) ? htmlspecialchars($_SESSION['prénom'], ENT_COMPAT, "UTF-8") : '')."\"></p>\n";
   echo "<p><label>Année de naissance </label>\n";
   date_default_timezone_set('Europe/Paris');

   $date_courante = getdate();
   $annee_courante = $date_courante['year'];
   echo "<select name=\"naissance\">\n";
   for($annee = $annee_courante; $annee >= 1900; $annee--) {     
      echo "<option value=\"$annee\"";
      if ((isset($_SESSION['naissance'])) && ($annee == $_SESSION['naissance']))         
         echo "selected=\"selected\"";    
      echo ">$annee</option>\n";
   }
   echo "</select></p>\n";
   echo "<p><input type=\"submit\" name=\"validation\"  value=\"Valider\"></p>\n";
   echo "</form>\n";
}

// Après validation du formulaire de saisie : affichage des informations
// saisies, puis d'un formulaire de confirmation affichant seulement
// deux boutons ("confirmer" et "modifier")
if (isset($_POST['validation'])) {
   if (!empty($_POST['prénom'])) {
     echo "<p>Prénom : ".htmlspecialchars($_POST['prénom'], ENT_COMPAT, "UTF-8")."</p>\n";
     echo "<p>Année de naissance : ".$_POST['naissance']."</p>\n";
     // Copie des données saisies dans des variables de session
      $_SESSION['prénom'] = $_POST['prénom'];
      $_SESSION['naissance'] = $_POST['naissance'];
	 // Liens hypertextes pour la confirmation ou la modification des données
	 echo "<p><a href=\"".$_SERVER['SCRIPT_NAME']."?confirmation\">Confirmer</a></p>\n";
	 echo "<p><a href=\"".$_SERVER['SCRIPT_NAME']."\">Modifier</a></p>\n";
   }
   else {
      unset($_SESSION['prénom']);
      ecrit_formulaire_saisie();
      echo "<p>Veuillez saisir votre prénom, s'il vous plaît.</p>\n";
   }
}
// Après validation du formulaire de confirmation : 
// affichage du message de bienvenue
else if (isset($_GET['confirmation'])) {
   echo "<p>Bonjour ".htmlspecialchars($_SESSION['prénom'], ENT_COMPAT, "UTF-8")
       .", vous êtes né(e) en ".$_SESSION['naissance'].".</p>\n";
   echo "<p><a href=\"".$_SERVER['SCRIPT_NAME']."\">Retour au formulaire</a></p>\n";
   session_destroy();
}
// Affichage de la page dans son état initial 
//(premier chargement ou nouvelle saisie)
else
   ecrit_formulaire_saisie();
?>
       
  </body>
</html>