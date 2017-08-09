--****************************
--Fonction predefinies
--***************************

-- Une fonction predefinies es une fonction qui est prevut par le languages SQL et qui est executée par le devloppeur.


--Fonction sur les dates :
SELECT *, DATE_FORMAT(date_rendu,'%d-%m-%Y') AS date_fr FROM emprunt;
--met la date au format indiqué :%d pour day,%m pour month , %Y majuscule pour 4 chiffre %y pour anne sur 2 chiffre

 SELECT NOW();-- affiche la date et l'heur du jour et de l'instant presen. **utile par exemple pour enregistrer la date d'inscription d'un membre

 SELECT CURDATE(); --afficheLa date du jour

 SELECT CURTIME(); -- affiche L'heure presente

--***************
-- fonction sur les chaine de caractéres:
 SELECT CONCAT('a','b','c'); -- concatène en 'abc'. Pratique pour réunir une adress par Exemple (adress+Ville+cp)
  SELECT CONCAT_WS(' - ','premier prenom','2eme prenom'); --Signifi CONCAT With Separator : concatène avec le separateur indiqué

  SELECT SUBSTRING ('bonjour',1,3);-- affiche "bon" : coupe le string de la position1 es sur 3 caractères


  SELECT SUBSTRING ('bonjour',8);-- affiche prenom.:coupe e affiche le string de la position 8

  SELECT TRIM('    bonjour    '); --supprime devant et derrière la chaine de caractères
  
  --REssource internet pour trouver les fonction predefinies le site http://sql.sh
