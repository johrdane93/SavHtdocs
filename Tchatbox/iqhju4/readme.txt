Ce tutoriel explique comment héberger soi-même une salle de tchat.

1/ Dézipper le contenu de ce zip dans un répertoire sur votre serveur web.

2/ La salle ne doit pas comporter de mot de passe. Si ce n'est pas le cas, éditez le fichier "conf.json" et laissez un champ vide à la place du mot de passe.

3/ Vous pouvez alors accéder à votre salle en pointant vers le fichier tchat.php.

4/ Il est aussi possible d'inclure le tchat dans une page web existante en utilisant une iframe : <iframe src="tchat.php" width="500" height="400"></iframe> (les dimensions sont à ajuster).