--
-- Structure de la table `ADMIN_LOGS`
--
CREATE TABLE IF NOT EXISTS `ADMIN_LOGS` (
  `ID` int(9) NOT NULL,
  `EMAIL` varchar(60) NOT NULL,
  `DATE` varchar(30) NOT NULL,
  `OK` int(1) NOT NULL,
  `IP` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Structure de la table `ADMIN_MESSAGES`
--
CREATE TABLE IF NOT EXISTS `ADMIN_MESSAGES` (
  `ID` int(4) NOT NULL,
  `DATE` varchar(10) NOT NULL,
  `TYPE` varchar(30) NOT NULL,
  `NOM` varchar(80) NOT NULL,
  `EMAIL` varchar(80) NOT NULL,
  `TELEPHONE` varchar(15) NOT NULL,
  `ADRESSE` varchar(120) NOT NULL,
  `CP` varchar(5) NOT NULL,
  `VILLE` varchar(55) NOT NULL,
  `MESSAGE` varchar(2000) NOT NULL,
  `IP` varchar(30) NOT NULL,
  `DESTINATAIRE` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Structure de la table `ADMIN_PAGES`
--
CREATE TABLE IF NOT EXISTS `ADMIN_PAGES` (
  `ID` int(2) NOT NULL,
  `URL` varchar(120) NOT NULL,
  `TITRE` varchar(250) NOT NULL,
  `CONTENU` varchar(12500) NOT NULL,
  `VISIBLE` varchar(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `ADMIN_PAGES`
--
INSERT INTO `ADMIN_PAGES` (`ID`, `URL`, `TITRE`, `CONTENU`, `VISIBLE`) VALUES
(1, '/admin/index.php', 'Administration du site', '', '1'),
(2, '/admin/actualites.php', 'Actus', '', '1'),
(3, '/admin/pages.php', 'Pages', '', '1'),
(4, '/admin/backup.php', 'Sauvegardes', '', '1'),
(5, '/admin/messages.php', 'Messages', '', '1'),
(6, '/admin/login.php', 'Accès interdit', '', '1'),
(7, '/admin/enregistrement.php', 'Nouvel utilisateur', '', '1'),
(8, '/admin/logs.php', 'Log des connexions', '', '1'),
(9, '/admin/utilisateurs.php', 'Utilisateurs', '', '1'),
(10, '/admin/statistiques.php', 'Statistiques', '', '1'),
(11, '/admin/parametres.php', 'Paramètres', '', '1'),
(12, '/admin/sitemap.php', 'Sitemap', '', '1'),
(13, '/admin/menus.php', 'Menu', '', '1'),
(14, '/admin/vignettes.php', 'Vignettes', '', '1'),
(15, '/admin/carousel.php', 'Carousel', '', '1'),
(16, '/admin/reinitialiser.php', 'Réinitialisation du mot de passe', '', '1'),
(17, '/admin/nouveau-mdp.php', 'Mot de passe perdu', '', '1'),
(18, '/admin/aide.php', 'Aide', '', '1'),
(19, '/admin/fichiers.php', 'Fichiers', '', '1');

-- --------------------------------------------------------

--
-- Structure de la table `ADMIN_PARAMETRES`
--
CREATE TABLE IF NOT EXISTS `ADMIN_PARAMETRES` (
  `ID` int(11) NOT NULL,
  `NOM` varchar(128) NOT NULL,
  `TYPE` varchar(256) NOT NULL,
  `CONTENU` varchar(256) NOT NULL,
  `AIDE` varchar(256) NOT NULL,
  `MENU` int(11) NOT NULL,
  `POSITION` int(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `ADMIN_PARAMETRES`
--
INSERT INTO `ADMIN_PARAMETRES` (`ID`, `NOM`, `TYPE`, `CONTENU`, `AIDE`, `MENU`, `POSITION`) VALUES
(1, 'Email', 'email', 'xxxxxxxxxxxxxxxxxx', 'Destinataire du formulaire de contact', 2, 3),
(2, 'Durée du blocage', 'number', '10', 'En minutes', 5, 3),
(3, 'Nombre de tentatives avant blocage', 'number', '5', 'Ex : "5"', 5, 1),
(4, 'Nom du site', 'text', 'xxxxxxxxxxxxxxxxxx', '', 1, 1),
(6, 'URL du site', 'url', 'http://www.xxxxxxxxxxxxxxxxxx.fr', 'Ex : "http://www.NOMDUSITE.fr"', 1, 3),
(7, 'Description simple', 'text', 'xxxxxxxxxxxxxxxxxx', 'Environ 60/80 signes', 1, 2),
(8, 'Logo', 'imgpicker', '../img/Bg.jpg', 'Ex : "../img/Logo.png"', 3, 3),
(9, 'Nom de la page', 'text', 'NON', 'Sans le "https://www.facebook.com/". "NON" pour désactiver', 4, 1),
(10, 'Bouton J''aime sur les pages', 'select', 'NON', '"NON" pour désactiver', 4, 2),
(11, 'Image d''arrière plan', 'imgpicker', '../img/Bg.jpg', 'Ex : "../img/Bg.jpg"', 3, 1),
(12, 'Couleur principale', 'colorpicker', '#1AA680', 'Ex : "#ACDE24"', 3, 7),
(13, 'Couleur secondaire', 'colorpicker', '#0F93F1', 'Ex : "#54301A". Couleur foncée conseillée', 3, 8),
(15, 'Téléphone', 'text', 'NON', '"NON" pour désactiver', 2, 2),
(16, 'Adresse postale', 'text', 'NON', '"NON" pour désactiver', 2, 1),
(17, 'Message du formulaire de contact', 'text', 'Merci ! Votre message a bien été envoyé, il sera traité dans les meilleurs délais.', 'Ex : "Merci ! Votre message a bien été envoyé, il sera traité dans les meilleurs délais."', 2, 4),
(18, 'Titre des vignettes', 'text', 'NON', '"NON" pour désactiver', 6, 2),
(19, 'Icône devant les titres', 'iconpicker', '\\f105', '"NON" pour désactiver', 3, 9),
(20, 'Emplacement du Menu', 'selectmenu', 'TOP', '"NON" pour désactiver', 8, 1),
(21, 'Afficher l''image d''arrière plan du header', 'select', 'OUI', 'Permet d''afficher une image dans le Header, derrière le logo.', 3, 4),
(22, 'Image d''arrière plan du Header', 'imgpicker', 'NON', '"NON" pour désactiver', 3, 5),
(23, 'Carte Google Map', 'text', 'NON', '"NON" pour désactiver', 2, 5),
(24, 'Afficher les images en plein écran en cliquant dessus', 'select', 'NON', '"NON" pour désactiver', 3, 10),
(25, 'Identifiant Google Analytics', 'text', 'NON', 'Ex : "UA-XXXXXXXX-X". "NON" pour désactiver', 4, 4),
(26, 'Répéter l''image d''arrière plan', 'repeat', 'no-repeat', 'Utile si l''image d''arrière plan est un motif et non une image (elle sera alors zoomé pour remplir l''arrière plan).', 3, 2),
(27, 'Couleur d''arrière plan', 'colorpicker', '#F5F5F5', 'Visible si aucune image d''arrière plan n''est sélectionnée', 3, 6),
(29, 'Emplacement Carousel', 'emplacement', 'HOME', '', 7, 3),
(30, 'Titre du Carousel', 'text', 'NON', '"NON" pour désactiver', 7, 2),
(31, 'Durée de transition', 'number', '3600', 'En millisecondes ("3200" par défaut)', 7, 4),
(32, 'Durée écoulée pour comptabiliser les tentatives échouées', 'number', '2', 'En minutes', 5, 2),
(33, 'Autoriser "Mot de passe perdu ?"', 'select', 'OUI', '"NON" pour désactiver', 5, 4),
(34, 'Bouton Accueil <i class="fa fa-home fa-1x"></i>', 'select', 'OUI', '"NON" pour désactiver', 8, 1),
(35, 'Lien Accueil visible sur la page d''accueil ?', 'select', 'NON', '', 8, 2),
(36, 'Ordre aléatoire', 'select', 'OUI', '"NON" pour désactiver', 6, 2),
(37, 'Ordre aléatoire', 'select', 'OUI', '"NON" pour désactiver', 7, 2),
(38, 'Emplacement Vignettes', 'emplacement', 'HOME', '"NON" pour désactiver', 6, 3),
(28, 'Afficher Titre & Contenu', 'select', 'OUI', '"NON" pour désactiver', 7, 5),
(39, 'Vidéo youTube', 'text', 'NON', 'ID de la vidéo sans le début de l''URL "https://www.youtube.com/watch?v=". "NON" pour désactiver', 2, 6),
(40, 'Afficher la dernière Actu', 'select', 'OUI', '"NON" pour désactiver', 8, 4),
(41, 'Lecture automatique', 'select', 'NON', '"NON" pour désactiver', 2, 7);

--
-- Structure de la table `ADMIN_UTILISATEURS`
--
CREATE TABLE IF NOT EXISTS `ADMIN_UTILISATEURS` (
  `ID` int(11) NOT NULL,
  `NOM` varchar(30) NOT NULL,
  `EMAIL` varchar(50) NOT NULL,
  `MDP` char(128) NOT NULL,
  `SEL` char(128) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `ADMIN_UTILISATEURS`
--
INSERT INTO `ADMIN_UTILISATEURS` (`ID`, `NOM`, `EMAIL`, `MDP`, `SEL`) VALUES
(1, 'Demo123', 'demo@demo.fr', 'acace974330f0b54a7cf906db1129e3cd5588c2b01dc66a4c828566a95daaa0351690644922cc3179a45123900f399313c1cafb2c1b3ca24ba7fe262ceac2eb8', '447f61cae4999adb515edd04795803462f44486c451d81202778e20929df83208fa2603a27406375c72a304c7bc3d14d5032e74ab15136e8d1a45064eca30e74');

--
-- Structure de la table `SITE_ACTUS`
--
CREATE TABLE IF NOT EXISTS `SITE_ACTUS` (
  `ID` int(11) NOT NULL,
  `DATE_CREATION` varchar(10) NOT NULL,
  `TITRE` varchar(250) NOT NULL,
  `CONTENU` varchar(12500) NOT NULL,
  `VISIBLE` varchar(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Structure de la table `SITE_CAROUSEL`
--
CREATE TABLE IF NOT EXISTS `SITE_CAROUSEL` (
  `ID` int(2) NOT NULL,
  `URL` varchar(120) NOT NULL,
  `IMG` varchar(128) NOT NULL,
  `TITRE` varchar(250) NOT NULL,
  `CONTENU` varchar(12500) NOT NULL,
  `VISIBLE` varchar(1) NOT NULL DEFAULT '2',
  `ORDRE` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Structure de la table `SITE_PAGES`
--
CREATE TABLE IF NOT EXISTS `SITE_PAGES` (
  `ID` int(2) NOT NULL,
  `URL` varchar(120) NOT NULL,
  `TITRE` varchar(250) NOT NULL,
  `CONTENU` varchar(12500) NOT NULL,
  `VISIBLE` varchar(1) NOT NULL DEFAULT '1',
  `MENU` int(11) NOT NULL,
  `ORDRE` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=76 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `SITE_PAGES`
--
INSERT INTO `SITE_PAGES` (`ID`, `URL`, `TITRE`, `CONTENU`, `VISIBLE`, `MENU`, `ORDRE`) VALUES
(1, '/index.php', 'Bienvenue', '<p style="text-align: left;">Vous pouvez modifier ce texte.</p>', '3', 0, 0),
(2, '/actualites.php', 'Actus', '', '3', 0, 1),
(3, '/qui-sommes-nous.php', 'Qui sommes-nous', '<p style="text-align: left;">Vous pouvez modifier ce texte.</p>', '3', 1, 1),
(4, '/recherche.php', 'Formulaire de recherche', '<h2>Rechercher sur le site</h2>', '1', 0, 0),
(5, '/erreur-404.php', 'Contenu non trouvé :(', '<p>Le contenu n''existe plus ou a &eacute;t&eacute; modifi&eacute;. Merci d''utiliser le <strong>formulaire de recherche</strong> ci-dessous pour le retrouver, ou bien de <a href="../contact.php">nous en avertir</a>&nbsp;!</p>', '3', 0, 0),
(6, '/contact.php', 'Contact', '<h2>Une question, un projet ?</h2>\r\n<p>N''h&eacute;sitez pas &agrave; nous laisser un message <strong>par le formulaire ci-dessous</strong>, ou bien contactez directement l''interlocuteur de votre secteur :</p>', '3', 1, 15), 
(7, '/mentions-legales.php', 'Mentions légales', '<h2><strong>EDITEUR DU SITE</strong></h2>\n<p><strong>XXXXXXXXXX</strong></p>\n<p>Si&egrave;ge administratif :&nbsp;XXXXXXXXXXXXXXXXXXXXXXXX<br />T&eacute;l&eacute;phone : XX XX XX XX XX&nbsp; <br />Responsable de la r&eacute;daction :&nbsp;XXXXXXXXXXXXXXX</p>\n<h2><strong>CONCEPTION ET D&Eacute;VELOPPEMENT</strong></h2>\n<p>XXXXXXXXXXXX</p>\n<h2><strong>H&Eacute;BERGEUR</strong></h2>\n<p>Internet : <a title="" href="http://www.XXXXXXXXXXXXX.com/" rel="nofollow">XXX </a></p>\n<h2><strong>MISE EN GARDE</strong></h2>\n<ul>\n<li>Les informations contenues dans ce site ne constituent aucunement des offres commerciales de produits ou de services. Le contenu des pages diffus&eacute; &agrave; titre purement informatif ne saurait donc engager la responsabilit&eacute; de l''&eacute;diteur du site.</li>\n<li>Toute personne souhaitant se procurer un des produits ou services pr&eacute;sent&eacute;s est invit&eacute;e &agrave; contacter l&rsquo;&eacute;diteur du site pour &ecirc;tre inform&eacute;e de l''ensemble des conditions de souscription des produits et services.</li>\n<li>Les textes, photos et images, et plus g&eacute;n&eacute;ralement l''ensemble des &eacute;l&eacute;ments contenus dans le site sont prot&eacute;g&eacute;s par le droit d''auteur. Toute reproduction est donc strictement interdite.</li>\n<li>Par le pr&eacute;sent site vous pourrez acc&eacute;der &agrave; d''autres sites, con&ccedil;us et g&eacute;r&eacute;s sous la responsabilit&eacute; de tiers. Nous n''exer&ccedil;ons aucun contr&ocirc;le sur les contenus desdits sites et nous d&eacute;clinons toute responsabilit&eacute; notamment s''agissant de leur contenu.</li>\n<li>La Loi applicable est la Loi fran&ccedil;aise, les tribunaux comp&eacute;tents sont les tribunaux fran&ccedil;ais.</li>\n</ul>\n<h2><strong>VIE PRIV&Eacute;E</strong></h2>\n<ul>\n<li>Nous nous engageons &agrave; respecter les obligations de la Loi relative &agrave; la protection des personnes physiques &agrave; l&rsquo;&eacute;gard des traitements de donn&eacute;es &agrave; caract&egrave;re personnel ainsi que le principe du respect de la vie priv&eacute;e qui en d&eacute;coule.</li>\n<li>A ce titre nous consid&eacute;rons que l''ensemble des donn&eacute;es personnelles vous concernant recueillies sur notre site constituent des donn&eacute;es confidentielles qui ne peuvent &ecirc;tre transmises ou exploit&eacute;es que selon des modalit&eacute;s qui sont expos&eacute;es ci-apr&egrave;s.Certaines informations que vous nous communiquez sont n&eacute;cessaires pour le traitement de vos demandes. Ces informations seront utilis&eacute;es pour les n&eacute;cessit&eacute;s de la gestion et pour satisfaire aux obligations l&eacute;gales et r&eacute;glementaires. Elles pourront &ecirc;tre utilis&eacute;es par l&rsquo;&eacute;diteur du site pour vous transmettre des documentations commerciales ou pour r&eacute;pondre &agrave; vos demandes envoy&eacute;es par le formulaire de contact.&nbsp;</li>\n<li>Conform&eacute;ment aux dispositions l&eacute;gales nous conservons ces informations dans des conditions de s&eacute;curit&eacute; ad&eacute;quate et durant des dur&eacute;es limit&eacute;es. Ces informations ne seront ni c&eacute;d&eacute;es ni vendues &agrave; des tiers.</li>\n<li>Concernant les informations collect&eacute;es sur notre site nous vous rappelons que vous disposez d''un droit d''acc&egrave;s, de rectification, de suppression des donn&eacute;es et d&rsquo;opposition dans les conditions pr&eacute;vues par la Loi du 6 ao&ucirc;t 2004. Pour exercer l&rsquo;un de ces droits, vous pouvez vous adresser &agrave; nous par courrier &agrave; l''adresse postale ci-dessus, ou via le formulaire de contact de ce site.</li>\n</ul>\n<h2><strong>CR&Eacute;DITS PHOTOS</strong></h2>\n<p>Tous droits r&eacute;serv&eacute;s pour les photographies illustrant ce site.</p>', '3', 0, 0),

--
-- Structure de la table `SITE_VIGNETTES`
--
CREATE TABLE IF NOT EXISTS `SITE_VIGNETTES` (
  `ID` int(2) NOT NULL,
  `URL` varchar(120) NOT NULL,
  `IMG` varchar(128) NOT NULL,
  `TITRE` varchar(250) NOT NULL,
  `CONTENU` varchar(12500) NOT NULL,
  `VISIBLE` varchar(1) NOT NULL DEFAULT '2',
  `CATEGORIE` varchar(64) NOT NULL,
  `ORDRE` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;


--
-- Index pour la table `ADMIN_LOGS`
--
ALTER TABLE `ADMIN_LOGS`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `ADMIN_MESSAGES`
--
ALTER TABLE `ADMIN_MESSAGES`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `ADMIN_PAGES`
--
ALTER TABLE `ADMIN_PAGES`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `ADMIN_PARAMETRES`
--
ALTER TABLE `ADMIN_PARAMETRES`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `ADMIN_UTILISATEURS`
--
ALTER TABLE `ADMIN_UTILISATEURS`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `SITE_ACTUS`
--
ALTER TABLE `SITE_ACTUS`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `SITE_CAROUSEL`
--
ALTER TABLE `SITE_CAROUSEL`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `SITE_PAGES`
--
ALTER TABLE `SITE_PAGES`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `SITE_VIGNETTES`
--
ALTER TABLE `SITE_VIGNETTES`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT pour la table `ADMIN_LOGS`
--
ALTER TABLE `ADMIN_LOGS`
  MODIFY `ID` int(9) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `ADMIN_MESSAGES`
--
ALTER TABLE `ADMIN_MESSAGES`
  MODIFY `ID` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `ADMIN_PAGES`
--
ALTER TABLE `ADMIN_PAGES`
  MODIFY `ID` int(2) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT pour la table `ADMIN_UTILISATEURS`
--
ALTER TABLE `ADMIN_UTILISATEURS`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `SITE_ACTUS`
--
ALTER TABLE `SITE_ACTUS`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT pour la table `SITE_CAROUSEL`
--
ALTER TABLE `SITE_CAROUSEL`
  MODIFY `ID` int(2) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT pour la table `SITE_PAGES`
--
ALTER TABLE `SITE_PAGES`
  MODIFY `ID` int(2) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `SITE_VIGNETTES`
--
ALTER TABLE `SITE_VIGNETTES`
  MODIFY `ID` int(2) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;