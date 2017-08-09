

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `annonceo`
--

-- --------------------------------------------------------

--
-- Structure de la table `annonce`
--

CREATE TABLE `annonce` (
  `id_annonce` int(3) NOT NULL,
  `titre` varchar(255) COLLATE utf8_bin NOT NULL,
  `description_courte` varchar(255) COLLATE utf8_bin NOT NULL,
  `description_longue` text COLLATE utf8_bin NOT NULL,
  `prix` decimal(10,0) NOT NULL,
  `photo` varchar(200) COLLATE utf8_bin NOT NULL,
  `pays` varchar(20) COLLATE utf8_bin NOT NULL,
  `ville` varchar(20) COLLATE utf8_bin NOT NULL,
  `adresse` varchar(50) COLLATE utf8_bin NOT NULL,
  `cp` int(5) NOT NULL,
  `membre_id` int(3) NOT NULL,
  `photo_id` int(3) NOT NULL,
  `categorie_id` int(3) NOT NULL,
  `date_enregistrement` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id_categorie` int(3) NOT NULL,
  `titre` varchar(255) COLLATE utf8_bin NOT NULL,
  `motscles` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

CREATE TABLE `commentaire` (
  `id_commentaire` int(3) NOT NULL,
  `membre_id` int(3) NOT NULL,
  `annonce_id` int(3) NOT NULL,
  `commentaire` text COLLATE utf8_bin NOT NULL,
  `date_enregistrement` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

CREATE TABLE `membre` (
  `id_membre` int(3) NOT NULL,
  `pseudo` varchar(20) COLLATE utf8_bin NOT NULL,
  `mdp` varchar(60) COLLATE utf8_bin NOT NULL,
  `nom` varchar(20) COLLATE utf8_bin NOT NULL,
  `prenom` varchar(20) COLLATE utf8_bin NOT NULL,
  `telephone` varchar(20) COLLATE utf8_bin NOT NULL,
  `email` varchar(50) COLLATE utf8_bin NOT NULL,
  `civilite` enum('m','f') COLLATE utf8_bin NOT NULL,
  `statut` int(1) NOT NULL,
  `date_enregistrement` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `note`
--

CREATE TABLE `note` (
  `id_note` int(3) NOT NULL,
  `membre_id1` int(3) NOT NULL,
  `membre_id2` int(3) NOT NULL,
  `note` int(3) NOT NULL,
  `avis` text COLLATE utf8_bin NOT NULL,
  `date_enregistrement` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `photo`
--

CREATE TABLE `photo` (
  `id_photo` int(3) NOT NULL,
  `photo1` varchar(255) COLLATE utf8_bin NOT NULL,
  `photo2` varchar(255) COLLATE utf8_bin NOT NULL,
  `photo3` varchar(255) COLLATE utf8_bin NOT NULL,
  `photo4` varchar(255) COLLATE utf8_bin NOT NULL,
  `photo5` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `annonce`
--
ALTER TABLE `annonce`
  ADD PRIMARY KEY (`id_annonce`),
  ADD KEY `membre_id` (`membre_id`),
  ADD KEY `photo_id` (`photo_id`),
  ADD KEY `categorie_id` (`categorie_id`);

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id_categorie`);

--
-- Index pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD PRIMARY KEY (`id_commentaire`),
  ADD KEY `membre_id` (`membre_id`),
  ADD KEY `annonce_id` (`annonce_id`);

--
-- Index pour la table `membre`
--
ALTER TABLE `membre`
  ADD PRIMARY KEY (`id_membre`);

--
-- Index pour la table `note`
--
ALTER TABLE `note`
  ADD PRIMARY KEY (`id_note`),
  ADD KEY `membre_id1` (`membre_id1`),
  ADD KEY `membre_id2` (`membre_id2`);

--
-- Index pour la table `photo`
--
ALTER TABLE `photo`
  ADD PRIMARY KEY (`id_photo`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `annonce`
--
ALTER TABLE `annonce`
  MODIFY `id_annonce` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id_categorie` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `commentaire`
--
ALTER TABLE `commentaire`
  MODIFY `id_commentaire` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `membre`
--
ALTER TABLE `membre`
  MODIFY `id_membre` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `note`
--
ALTER TABLE `note`
  MODIFY `id_note` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `photo`
--
ALTER TABLE `photo`
  MODIFY `id_photo` int(3) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


/****************** CONTENU TABLE ANNONCE ******************************/

INSERT INTO `annonce` (`titre`, `description_courte`, `description_longue`, `prix`
, `photo`, `pays`, `ville`, `adresse`, `cp`, `membre_id`, `photo_id`, `categorie_id`
, `date_enregistrement`)

VALUES
('titre_01', 'description_courte_01', 'description_longue_01', 101,
'url_01','pays_01','ville_01','adresse_01',10001,001,001,001,'2017-06-22 01:01:01'),
('titre_02', 'description_courte_02', 'description_longue_02', 102,
'url_02','pays_02','ville_02','adresse_02',10002,002,002,002,'2017-06-22 02:01:01'),
('titre_03', 'description_courte_03', 'description_longue_03', 103,
'url_03','pays_03','ville_03','adresse_03',10003,003,003,003,'2017-06-22 03:01:01'),
('titre_04', 'description_courte_04', 'description_longue_04', 104,
'url_04','pays_04','ville_04','adresse_04',10004,004,004,004,'2017-06-22 04:01:01'),
('titre_05', 'description_courte_05', 'description_longue_05', 105,
'url_05','pays_05','ville_05','adresse_05',10005,005,005,005,'2017-06-22 05:01:01'),
('titre_06', 'description_courte_06', 'description_longue_06', 106,
'url_06','pays_06','ville_06','adresse_06',10006,006,006,006,'2017-06-22 06:01:01'),
('titre_07', 'description_courte_07', 'description_longue_07', 107,
'url_07','pays_07','ville_07','adresse_07',10007,007,007,007,'2017-06-22 07:01:01'),
('titre_08', 'description_courte_08', 'description_longue_08', 108,
'url_08','pays_08','ville_08','adresse_08',10008,008,008,008,'2017-06-22 08:01:01'),
('titre_09', 'description_courte_09', 'description_longue_09', 109,
'url_09','pays_09','ville_09','adresse_09',10009,009,009,009,'2017-06-22 09:01:01'),
('titre_10', 'description_courte_10', 'description_longue_10', 110,
'url_10','pays_10','ville_10','adresse_10',10010,010,010,010,'2017-06-22 10:01:01');



/****************** CONTENU TABLE CATEGORIE  ******************************/

INSERT INTO `categorie` (`titre`, `motscles`)

VALUES
('Emploi', 'Offres d\'emploi'),
('Vehicule', 'Voitures, Motos, Bateaux, Vélos, Equipement'),
('Immoblier', 'Ventes, Locations, Colocations, Bureaux, Logement'),
('Vacances', 'Camping, Hotels, Hôte'),
('Multimadia', 'Jeux Vidéos, Informatique, Image, Son, Téléphone'),
('Loisir', 'Films, Musique, Livres'),
('Materiel', 'Outillage, Fournitures de Bureau, Matériel Agricole, ...'),
('Services', 'Prestations de services, Evénements, ...'),
('Maison', 'Ameublement, Electroménager, Bricolage, Jardinage, ...'),
('Vetements', 'Jean, Chemises, Robes, Chaussure, ...'),
('Autres','...');

INSERT INTO membre (pseudo, mdp, nom, prenom, telephone, email, civilite, statut, date_enregistrement) VALUES


('Bret', 'password', 'Graham','Leanne', '1-770-736-8031', 'Sincere@april.biz', 'f', 0,'' ),


('Antonette', 'password', 'Howell','Ervin','010-692-6593','Shanna@melissa.tv', 'm', 0 ,''),

('Samantha','password','Bauch','Clementine','1-463-123-4447','Nathan@yesenia.net','f', 0 ,''),

('Karianne','password','Lebsack','Patricia', '493-170-9623','Julianne.OConner@kory.org','f',0,''),

('Kamren','password','Dietrich','Chelsey','(254)954-1289','Lucio_Hettinger@annie.ca','f',0,''),

('Leopoldo_Corkery','password','Schulist','Dennis','1-477-935-8478','Karley_Dach@jasper.info','m',0,''),

('Elwyn.Skiles','password','Weissnat','Kurtis','210.067.6132','Telly.Hoeger@billy.biz','m',0,''),

('Maxime_Nienow','password','Runolfsdottir','Nicholas', '586.493.6943','Sherwood@rosamond.me','m',0,''),

('Delphine','password','Reichert','Glenna','(775)976-6794','Chaim_McDermott@dana.io','f',0,''),

('Moriah.Stanton','password','DuBuque','Clementina','024-648-3804','Rey.Padberg@karina.biz','f',0,'');
