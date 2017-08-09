--*********************
--Table virtuelles : Vues
--*******************

-- les vues ou les tables virtuelles sont des objet de la bdd , constitués d'un nom , et d'une requêete de selection

-- une fois q'une vues et definie , on peut l'utiliser comme n'importe quelle table.
-- cette vue contien un sous emssemble de donnees résultant de la requête de selection .

USE entreprise

--cree une vue :
CREATE VIEW vue_homme AS SELECT prenom,nom,sexe,service  FROM employes WHERE sexe = 'm';--cree une vue rempplie par les donner du SELECT , à savoire les info de l'employe

-- on peut ensuite faire n'importe quelle requête sur cette vue:
SELECT prenom FROM vue_homme; -- on selctionne les prenom dans la vue

-- on peut avoir la vue parmi les table de la  bdd:
SHOW TABLES;

-- si il yv a un changement  dans la table d'origine , la vue est corrigée car elle  pointe a cette table grace a la requête de selection. Idem, s'il y a un changement dans la vue , il ce repercute dans le table d'origines

-- il y a  un interet a faire ds vues en termes de gain de performances , ou quand il ya des requete complexe a executer. la sert dans ce cas a stocker les q'une premier requete sur la quelle sera executée une seconde requête.
-- pour supprimer une vue :
DROP VIEW vue_homme ; 
