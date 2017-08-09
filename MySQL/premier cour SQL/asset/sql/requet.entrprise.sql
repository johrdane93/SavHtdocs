-- ************************
        Generalités
-- ***************************

--  Pour faire Les requete sql nous utilison la console sous xampp:
-- 1 : cd c:\xampp\mysql\bin
-- 2 : mysql.exe -u root --password
-- 3 : Le sql n'est pas sensible a la casse , mais par convention on le met les mot cle SQL en MAJUSCULES .

 -- *****************************
--   Requete generales
 -- *******************************
 CREATE DATABASE entreprise;  -- cree une base de donner appeler " entreprise"
 USE entreprise; -- pour ce connecter a la base donner "entreprise".
 SHOW DATABASES; -- affiche les base de donner disponible dans le SGBD.


       --on va cree la table "employes" et la remplir dans la console
  TRUNCATE employes;--Vide la table "employes" definitivement
  SHOW TABLES; --liste Les table de la bdd sur la quelle on et connecté(ici entreprise)
  DESC employes; --affiche la structure de la table employes


  --*************************************<br>
    --Chercher ou Afficher Des information
  --***************************************
  SELECT nom,PRENOM FROM employes; --affiche Le nom et le premon de tout les employes contenue dans la table

  SELECT service FORM employes;-- affiche le service des employes.
  --DISTINCT--

   SELECT DISTINCT service FROM employes; -- DISTINCT permet d'eliminer les doublon dans la requete de selection : ainsi on affiche  la liste precise des  service.

  ALL ou * | SELECT * FROM employes; -- affiche TOUS les champs des employes (nom, premon,ect...).cette requete permet d'&fficher l'integraliter d'une table.

  --clause WHERE
  SELECT nom, prenom FROM employes WHERE service = 'informatique' ; --affiche le nom et le prenom des employes du servive informatique.Notez que informatique est une valeur passe entre quotes

  -- BETWEEN

   SELECT nom, prenom, date_embauche FROM employes WHERE date_embauche BETWEEN'2006-01-01' AND'2010-12-31';

  --LIKE
    ---- Le % est un caractére joker qui remplace tous les autre caratct&re . On affiche donc les prenom des employes qui commence par s .
  SELECT prenom FROM employes WHERE prenom LIKE 's%';
  SELECT prenom FROM employes WHERE prenom LIKE '%-%';

  --opérateur de comparaisons
     -- affiche le nom et le prenom des employes qui ne sont pas du service informatique.
  SELECT nom , prenom FROM employes WHERE service != 'informatique';
  -- =
  -- <
  -- >
  -- <=
  -- >=
  -- != ou <> pour differante de

SELECT nom, prenom FROM employes WHERE salaire > 3000; -- affiche le nom prenom at salaire des employes de salaire supperieur a 3000.

--ORDER BY
SELECT nom,prenom,salaire FROM employes ORDER BY salaire; --affiche le nom prenom et le salaire des employes par ordre de salaire croissant. par defaut l'ordre et croissant.

 SELECT nom,prenom,salaire FROM employes ORDER BY salaire ASC, prenom DESC ;  -- asc pour ordre croissanr , DESC pour ordre décroissant  (selon l'alphabet).affiche les info d'abord par ordre croissant des salaires puis par ordre décroissant des prenoms<

 --LIMIT

 SELECT nom,prenom,salaire FROM employes ORDER BY salaire DESC LIMIT 0,1; --affiche le nom prenom salaire de l'employer ayant le salaire le plus élever : on tire les salaire par odre décroissant puis avec ORDER BY puis on prend le prelier enregistrement avec LIMIT .01 (c4est a direà partire de l'enregistrement  0 et sur 1 ligne)

--L'alias avec AS

SELECT nom,prenom,salaire * 12 AS salaire_annuel FROM employes; ---- donc HAS permet de donner une etiquette au calcul salaire *12,appelee alias.

--SUM

SELECT SUM(salaire* 12)FROM employes; --affiche la somme des saliare multipliés pas 12mois

--MIN & MAX
SELECT MIN(salaire)FROM employes; --affiche le plus petit salaires.
SELECT MAX(salaire)FROM employes; --affiche le plus haut salaire .
SELECT prenom.nom. MIN(salaire FROM employes); --affiche le mon premon et salaire minimum pour afficher les info du salaire le plus petit on fait un ORDER BY suivi d'un LIMIT (cf ci-dessus)

-- AVG (Pour average = moyenne)

SELECT AVG(salaire)FROM employes; --affiche la moyenne des salaires

--ROUND
SELECT ROUND(AVG(salaire),0) FROM employes; --arrondit la moyenne des salaires a 0 décimale

--COUNT
SELECT COUNT(id_employes) FROM employes WHERE sexe ='f'; --affiche le nombre d'employes féminins.

-- IN
SELECT nom,prenom,service FROM employes WHERE service IN ('conpatibilite','informatique');-- affiche les employes dont le service est dans la liste 'conpatibilité', 'informatique'.
SELECT nom,prenom,service FROM employes WHERE service NOT IN ('conpatibilite','informatique');-- affiche dans le service les employer qui ne sont pas dans le service compta et info.


-- AND & OR

SELECT * FROM employes WHERE service ='commercial' AND salaire <= 2000;--affiche toutes les ingo (*) des employes du service commercial ET dont le salaireest infériaur ou egale a 2000

SELECT * FROM employes WHERE service ='production' AND salaire =1900 OR salaire =2300;--affiche les employes de la production dont le salire et de 1900, ou les employes dont le salire et de 2300.

-- GROUP BY

SELECT service,COUNT(id_employes)FROM employes; --affiche le nombre d'employes par service : GROUP BY est utiliser avec COUNT , SUM, AVG,pour regrouper leur résultat selon le champ indiqué


-- GROUP BY ... HAVING

SELECT service,COUNT(id_employes) AS nombre FROM employes GROUP BY service HAVING nombre >1; --

--*****************************************
--        Les requéte d'insertion
--*****************************************


SELECT * FROM employes ;

INSERT INTO employes(id_employes,prenom,nom,sexe,service,date_embauche,salaire)
      VALUE(8059,'alexis','richy','m','informatique','2011-12-28', 1800);-- on insert un employes avec des donner dans les champ indiques dans les premiéres
--parenthéses, les valeur inbséré etant spécifiees dans le  même ordre  ans les secondes parenthéses .

--une insertion avec  aut-increment : on  ne spésifi pas le champ id_employes qui s'incremante tout seul.


-- une requete qui ne marche pas
INSERT INTO employes VALUES(8061,'test','test','m','informatique','2012-01-28',1800,);-- on peut ne pas spécifier les champs lors d'une insertion, à condition de spécifier une valeur pour tous et dans l'ordre de presence dans le la  table. Ici'en trop ne correspond a aucun champ, la requéte est donc innoperante.


-- ************************
-- Requêtes de modification
-- ************************

SELECT * FROM employes;

-- UPDATE
UPDATE employes SET salaire = 1870 WHERE nom ='cottet'; -- Modifie le salaire à 1870 de l'employé de nom 'cottet';

-- Dans la réalité,on passe par l'id_employe pour etre certain de ne modifier que l'enregistrement concerné (cas des homonymes):
UPDATE employes SET salaire = 1871 WHERE id_employes = 699;

UPDATE employes SET salaire = 1872, service = 'autre' WHERE id_employes = 699; -- on peut modifier plusieurs champs dans la même requête.

-- A NE PAS FAIRE :un UPDATE sans clause WHERE :
UPDATE employes SET salaire = 0; -- ici on update tout la table employés !

-- REPLACE
REPLACE INTO employes (id_employes,prenom, nom, sexe, service, date_embauche, salaire) VALUES(2000,'test','test','m','marketing','2010-07-05', 2600);-- Le Replace se comporte comme un INSERT car L'id_employes 2000 n'existe pas.

REPLACE INTO employes (id_employes,prenom, nom, sexe, service, date_embauche, salaire) VALUES(2000,'test','test','m','marketing','2010-07-05', 2601); -- ici Le REPLACE se comporte comme unUDAPTE car l'id_employes 200 existe .



--*****************************************
--        Les requéte de suppression
--*****************************************

--DELETE
DELETE FROM employes WHERE nom ='lagarde'; --supprime l'employes de nom lagarde

--REMARQUE : il faudrait passer par  l'id_employes pour être certain de n'en supprimer qu'in seul !

DELETE FROM employes WHERE service = 'informatique' AND id_employes != 802;


DELETE FROM employes WHERE id_employes = 388 OR id_employes = 990; -- pour supprimer simultannément Les id_employes 388 et 990 on met un OR : en effet un employes ne peut pas savoir 2 id differante (car l'id est unique) comme voudrait le dire un AND.

--Ce qui revien a ecrire ceci:
DELETE FROM employes WHERE id_employes = 388, 990;--On supprime Les id_employes qui sont dans cette liste.

-- A NE PAS FAIRE : un DELET sans clause WHERE:
DELETE FROM employes; -- revien A FAIRE UN TRUNCATE( vider la table) qui est irreversible.

--*****************************************
--                 Exercice
--*****************************************
--1. Afficher Le service de L'employes 547 :
SELECT service FROM employes WHERE id_employes =547;


--2. Afficher date d'embauche d'amandine
SELECT date_embauche FROM employes WHERE prenom ='ammandine';

--3. Afficher le nombre d'employes du service commercial
    SELECT COUNT(id_employes)FROM employes WHERE  service ='commercial';

--4. afficher la somme des salires annuels Des service:
    SELECT SUM(salaire * 12) FROM employes WHERE service = 'employes';

--5.  Afficher Le salaire moyen par service

  SELECT service,avg(salaire) FROM employes GROUP BY service;

--6. Afficher le nombre de recrutement sur l'anne 2010 (1 solution parmit 3)
    SELECT COUNT(id_employes) FROM employes WHERE date_embauche >='2010-01-01' AND date_embauche <='2010-12-31';
    --1
    SELECT COUNT(id_employes) FROM employes WHERE date_embauche LIKE '2010%';
    --2
    SELECT COUNT(id_employes) FROM employes WHERE date_embauche BETWEEN '2010-01-01' AND '2010-12-31';
    --3
--7. *augmenter le salaire de tous les employes de +100
    UPDATE employes SET salaire = Salaire +100;

--8. Afficher le  nombre de service different
    SELECT COUNT(DISTINCT service) FROM employes;

--9. Afficher le nombre d'employes par service
      SELECT service , COUNT(id_employes)FROM employes ;

--10. Afficher toutes les info de l'empliyer du service commercial le mieux payé
  SELECT * FROM employes WHERE service ='commercial' ORDER BY salaire DESC LIMIT 0,1;

--11. Afficher l'employer ayant été embauché en dernier
    SELECT * FROM employes ORDER BY date_embauche DESC LIMIT 0,1;











































--
