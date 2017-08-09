--1. qui conduit la voiture d'id_vehicule 503 ?
--MOI
--SELECT  nom,prenom
--FROM conducteur
--INNER JOIN association_vehicule_conducteur
--ON   conducteur.id_conducteur = association_vehicule_conducteur.id_conducteur
--WHERE   id_vehicule ='503';
techLiesJ
SELECT prenom FROM conducteur WHERE id_conducteur = (id_conducteur FROM association_vehicule_conducteur WHERE id_vehicule = 503);--ci on peut faire une requete imbrique car on affiche un champ issu d'une seul table (prenom).

--2. qui(prenom)conduit quel model?
SELECT c.nom ,c.prenom,v.modele
FROM conducteur c
INNER JOIN association_vehicule_conducteur
ON  c.id_conducteur= a.id_conducteur
INNER JOIN veicule v
ON  v.id_vehicule= a.id_vehicule;
--3 Ajoutez-vous dans la liste des conducteurs.
INSERT INTO conducteur  VALUES (NULL,'john','Doe');
INSERT INTO conducteur(nom,prenom)  VALUES ('rudy','test');
--Afficher tout ls conducteurs(ycompris ceux qui n'ont pas de veicule affecté) ainsi que les modeles de veicules.
SELECT prenom, nom, modele
FROM conducteur c
LEFT JOIN association_vehicule_conducteur
ON c.id_conducteur = a.id_conducteur
LEFT JOIN vehicule d
ON a.id_vehicule = v.id_vehicule;
--4.Ajoutez un nouvel enregistrement dans la table veicule.
INSERT INTO  vehicule
--05.puis Afficher tout les conducteurs(ycompris ceux qui n'ont pas de véhicule) ET tout les chauffeur affecté).
(SELECT v.modele , c.prenom
FROM conducteur c
RIGHT JOIN association_vehicule_conducteur
ON c.id_conducteur = a.id_conducteur
RIGHT JOIN veicule v
ON a.id_vehicule = v.id_vehicule)

UNION

(SELECT v.modele , c.prenom
FROM conducteur c
LEFT JOIN association_vehicule_conducteur
ON c.id_conducteur = a.id_conducteur
LEFT JOIN veicule v
ON a.id_vehicule = v.id_vehicule);
