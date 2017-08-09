-- ***********************************************
--  CREATION DE LA BDD
--************************************************
CREATE DATABASE bibliotheque;
--  Pour faire Les requete sql nous utilison la console sous xampp:
-- 1 : cd c:\xampp\mysql\bin
-- 2 : mysql.exe -u root --password
  SHOW DATABASE;  -- affiche  liste BDD disponible.


  --************************************
--   Exercice
--*************************************

--1.afficheer d'id_d'abonne de Laura
SELECT id_abonne  FROM abonne WHERE prenom = 'Laura';

--2.l'abonne d'id-abonne 2 est venu emprunter un livre a quelle date_sortie ?
SELECT date_sortie FROM emprunt WHERE id_abonne ='2';

--3.combient d'emprunt ont ete effectuer en tout.
SELECT COUNT(id_emprunt) FROM emprunt;

--4. Combien de livre Sont sortis Le 2011-11-19.
SELECT date_sortie FROM emprunt WHERE date_sortie ="2011-12-19 ";

--5. " une Vie " et de quel auteur.
SELECT auteur FROM livre WHERE titre ="Une Vie" ;

--6. De combien de livre D'alexandre dumas dispose t'on ?
SELECT COUNT(auteur) FROM livre WHERE auteur="ALEXANDRE DUMAS";
--7. Quel id_abonne et le plus de emprunte?
SELECT id_livre,date_sortie FROM emprunt;
SELECT id_livre , COUNT(date_sortie) FROM emprunt GROUP BY id_livre;

--8. quel id_abonne emprunte le plus de livres?
SELECT id_livre, COUNT(date_sortie) AS nombre FROM emprunt GROUP BY id_livre ORDER BY nombre DESC;
.
--******************************************
-- Requétes imbriquees
--******************************************

--une requéte ibrique permet de realiser des requete sur deux ou plusieur tables.
--afin de realiser une requete imbrique, il faut obligatoirement un champ COMMUN entre les deux tables.

-- Un champ ce teste avec IS NULL:
    SELECT id_livre FROM emprunt WHERE date_rendu IS NULL;--affiche les id livre non rendus:

--Afficher le titre de ces  livre non rendus.
    SELECT titre FROM livre WHERE id_livre IN (SELECT id_livre FROM emprunt WHERE date_rendu IS NULL);
--On affiche le titre de la tables livre pour lequel L'id_livre est dans la liste donné par la seconde requete entre parenthéses, soit 100,105.
    --Equivaut à:
        SELECT titre FROM livre WHERE id_livre IN (100,105);
        --Notez que l4on execute d'abort  la requéte entre parenthése puis celle qui est a lexterieur

        -- Le In de La seconde requete peut etre remplacer par un "=" IN  c quans il y a plusieur resulat alor qu'on utilise "=" quant on et sur d'avoir qu'un seul resultat .EXEMPLE:

        -- Afficher le n° des livre que cloe a emprunte:
        --SELECT id_livre FROM emprunt WHERE id_abonne="3"; --ou
        SELECT id_livre FROM emprunt WHERE id_abonne = (SELECT id_abonne FROM abonne WHERE prenom = 'chloe');

        --***************************************************************************************
        --Exercice :  afficher les prenom des abonner ayant emprunter un livre le '2011-12-19'
            SELECT prenom FROM abonne WHERE id_abonne IN (SELECT id_abonne  FROM emprunt WHERE date_sortie = "2011-12-19") ;

        --Exercice :  afficher les prenom des abonner ayant emprunter le livre d4alfonce daudet

          SELECT prenom  FROM abonne WHERE id_abonne IN (SELECT id_abonne  FROM emprunt  WHERE id_livre = "103") ;

        --Execice : Nous aimeron savoir le titre des livre que cloe a empruntés
        SELECT titre  FROM  WHERE  IN (SELECT   FROM  WHERE  = "") ;

        --Execice : Nous aimeron savoir le titre des livre que cloe n'a Pas empruntés
        SELECT titre  FROM livre  WHERE id_livre IN (SELECT id_livre FROM emprunt  WHERE id_abonne = (SELECT id_abonne FROM abonne WHERE prenom='Chloe')) ;

        --Exercice : Combient de livre benoit a emprunter a la bibliotheque?
        SELECT COUNT(id-livre) FROM emprunt WHERE id_abonne IN (SELECT id_abonne FROM abonne WHERE prenom= 'Benoit' )

        --Exercice : Qui (prenom) a emprunter le plus de livre a la bibliotheque
        SELECT prenom FROM abonne WHERE id_abonne = (SELECT id_abonne FROM emprunt GROUP BY  id_abonne ORDER BY COUNT(id-abonne) DESC LIMIT 1 );

--****************************************************************************************
--     LES jointure internes
--***********************************************************************************
-- UNe jointure et possible dans tout les cas , alor q'une requete et imbrique est possible
-- seulement dans le cas ou les champ afficher (ceux qui sont dans le SELECT) proviene de la meme table.
--avec une jointure il pourron etre afficher dans le meme SELECT et issu de table différantes.

-- Nous aimeron connaitre les date de sortie  et de rendu de l'abonne  Guillaume :
SELECT a.prenom, e.date_sortie,e.date_rendu
FROM abonne a
INNER JOIN emprunt e
ON a.id_abonne = e.id_abonne
WHERE a.prenom = 'Guillaume';

--1er ligne  : ce que je souhaite afficher
--2eme ligne : la 1er table viennet des information
--3eme ligne : on lies la premier table a lla secondes table d'ou viennet les information.
--4eme ligne : il sajit de la jointure qui lies es deux champ en COMMUN dans les  deux tables
--5eme ligne : condition supplémentaire sur le prenom

 -- Exercice : qui (prenom) a emprunté "Une Vie" sur 2011 ?
SELECT a.prenom , e.date_sortie, e.date_rendu
FROM abonne a
INNER JOIN emprunt e
ON a.id_abonne = e.id_abonne
WHERE l.auteur =' alphonse dauet ' ;
 -- Exercice : afficher le nombre de livre emprunter par chaque abonnés (prenom)
SELECT a.prenom,COUNT(e.id_abonne)
FROM abonne a
INNER JOIN emprunt e
ON a.id_abonne = e.id



 -- Exercice : Qui (prenom) a emprunt quoi (titre) et a quelles date (date_sortie)?
SELECT a.prenom,m.titre,e.date_sortie
FROM abonne a
INNER JOIN emprunt e
ON a.id_abonne =e.id_abonne
INNER JOIN livre l
ON e.id_livre =l.id_livre;

--***********************************************************************
--afficher les prenom des abonnes avec les id_livres qu'il on empruntés--
--***********************************************************************
SELECT a.prenom,e.id_livre
FROM abonne a
INNER JOIN emprunt e
ON  a.id_abonne = e.id_abonne;

--**************************************************
--UNE jointure externe est une requéte sans correspondance exigée entre les valeur affiches
--EXEMPLE :
INSERT INTO abonne (prenom) VALUES ('moi'); -- on s'insére dans la table abonne


--SI on relance la dernier requête de jointure internes , vous n'apparaisseez pas dans la liste des abonnes (Normale vous n'avez rien empruntés,)
--Si on souhaite que la liste des abonnes soit axostive , y compri ceux qui n'on rien emprunter , on fait une jointure externe:

SELECT abonne.prenom,emprunt.id_livre
FROM abonne
LEFT JOIN emprunt
ON abonne.id_abonne = emprunt.id_abonne;

--La clause LEFT JOIN permet de rapatrier TOUTEs Les données dans la table considérée comme étant a gauche  de l'instruction LEFT JOIN sans correspondance exigée dans l'autre Table(emprunt).
--Les valeur n'ayant pas de correspondance apparaissee avec la mention NULL.


--Voici le cas avec un livre supprimez de la bibliotheque:
--1° On supprime Le Livre "Une Vie"d'id_livre 100:
DELETE FROM livre WHERE id_livre = 100;

-- 2° On affiche la liste de tout les emprunt, y compris ceux pour lesquels il manque un livre:
SELECT e.id_emprunt, l.titre
FROM emprunt e
LEFT JOIN livre l
ON e.id_livre = l.id_livre;

-- on peut aussi utilisser cette reqête avec RIGHT JOIN  en inverssant la position des tables .
SELECT e.id_emprunt, l.titre
FROM emprunt e
RIGHT JOIN livre l
ON e.id_livre = l.id_livre;

-- ICI RIGHT JOIN signifi que la table à DROIT d l'instruction , donc emprunt, sera complétement affichée. Le le livre manquant(UNE VIE)est Donc remplacer par la mention NULL.
--***********************************
--    UNION
--*********************************
--UNION permet de fusionner le resultat de deux requête dans la même liste de resulatat.

-- Exemple : Si on désinscrit Guillaume (Par une suppression du profil de a table abonne ), on on peut affiche a  la fois tout les livres empruntés ,  y comprit par des lecteur désincrit (on affiche NULL a la place dee Guillaume),Et tout les abonne y comprit ceux qui n'on rien empruntés ( on afficheNULL ds id_livre pour moi).

-- suppression de l'abonné Guillaume
DELETE abonne WHERE id_abonne =1;
-- Requête sur le slivre empruntés
(SELECT abonne.prenom, emprunt.id_livre
FROM abonne
LEFT JOIN emprunt
ON abonne.id_abonne = emprunt.id_abonne)

UNION

(SELECT abonne.prenom, emprunt.id_livre
FROM abonne
RIGHT JOIN emprunt
ON abonne.id_abonne = emprunt.id_abonne);

--****
--Question/reponce
(SELECT prenom FROM abonne) UNION (SELECT titre FROM livre);--onaffiche dans la même liste les prenom et les titre
-- on affiche dans DEUX colonnes differante les prenom et les titre.
SELECT abonne.prenom, livre.titre
FROM abonne
INNER JOIN emprunt
ON abonne.id_abonne = emprunt.id_abonne
INNER JOIN livre
ON  livre.id_livre = emprunt.id_livre;
