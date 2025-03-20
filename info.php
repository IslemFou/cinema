<?php
phpinfo();
?>
<!-- ..
ma page web
.. -->


<!-- Dans le cadre d'un erreur de type "page blanche" 
 1-Insérer phpinfo() au niveau de la page qui porte l'erreur 
 2- chercher dans le tableau d'information "log" 
 error_log	C:/laragon/tmp/php_errors.log	C:/laragon/tmp/php_errors.log

 allez vers le chemin et ouvrir le fichier php_errors.log avec vs code

 cherchez en bas du code, on trouve l'erreur.

 ------------

 modifier la configuration de php afin qu'il affiche directement les erreurs sur la page 
 display_errors   
 
 -->