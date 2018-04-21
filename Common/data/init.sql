--
-- Structure de la table `t_session`
--

CREATE TABLE IF NOT EXISTS `t_session` (
  `id` char(32) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL,
  `modified` int(11) DEFAULT NULL,
  `lifetime` int(11) DEFAULT NULL,
  `data` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;


--
-- Structure de la table `t_langue`
--

CREATE TABLE IF NOT EXISTS `t_langue` (
  `idLangue` int(11) NOT NULL AUTO_INCREMENT,
  `libLangue` varchar(30) NOT NULL DEFAULT 'French',
  `fichier` varchar(30) NOT NULL DEFAULT 'lang_french',
  `drapeau` varchar(50) NOT NULL,
  PRIMARY KEY (`idLangue`),
  UNIQUE KEY `libLangue` (`libLangue`),
  KEY `fichier` (`fichier`)
) ENGINE=InnoDB  AUTO_INCREMENT=3;

--
-- Contenu de la table `t_langue`
--

INSERT INTO `t_langue` (`idLangue`, `libLangue`, `fichier`, `drapeau`) VALUES
(1, 'French', 'fr', 'france.gif'),
(2, 'English', 'en', 'royaumeuni.gif');

--
-- Structure de la table `t_pays`
--

CREATE TABLE IF NOT EXISTS `t_pays` (
  `idPays` int(11) NOT NULL AUTO_INCREMENT,
  `libPays_fr` varchar(100) NOT NULL,
  `libPays_en` varchar(100) NOT NULL,
  `classPays` varchar(50) NOT NULL,
  PRIMARY KEY (`idPays`),
  KEY `libPaysFR` (`libPays_fr`),
  KEY `libPaysAN` (`libPays_en`)
) ENGINE=InnoDB  AUTO_INCREMENT=236;


INSERT INTO `t_pays` (`idPays`, `libPays_fr`, `libPays_en`, `classPays`) VALUES
(1, 'France', 'France', 'france'),
(2, 'Angleterre', 'England', 'angleterre'),
(3, 'Allemagne', 'Germany', 'allemagne'),
(4, 'Australie', 'Australia', 'australie'),
(5, 'Autriche', 'Austria', 'autriche'),
(6, 'Belgique', 'Belgium', 'belgique'),
(7, 'Bresil', 'Brazil', 'bresil'),
(8, 'Canada', 'Canada', 'canada'),
(9, 'Danemark', 'Denmark', 'danemark'),
(10, 'Espagne', 'Spain', 'espagne'),
(11, 'Etats-Unis', 'United States', 'etats_unis'),
(12, 'Finlande', 'Finland', 'finlande'),
(13, 'Grece', 'Greece', 'grece'),
(14, 'Hongrie', 'Hungary', 'hongrie'),
(15, 'Irlande', 'Ireland', 'irlande'),
(16, 'Italie', 'Italy', 'italie'),
(17, 'Japon', 'Japan', 'japon'),
(18, 'Luxembourg', 'Luxembourg', 'luxembourg'),
(19, 'Pays-Bas', 'Netherlands', 'pays_bas'),
(20, 'Portugal', 'Portugal', 'portugal'),
(21, 'Russie', 'Russia', 'russie'),
(22, 'Suede', 'Sweden', 'suede'),
(23, 'Suisse', 'Switzerland', 'suisse'),
(24, 'Algérie', 'Algeria', 'algerie'),
(25, 'Maroc', 'Morocco', 'maroc'),
(26, 'Mexique', 'Mexico', 'mexique'),
(27, 'Ile Maurice', 'Mauritius', 'maurice'),
(28, 'Pologne', 'Poland', 'pologne'),
(29, 'Tunisie', 'Tunisia', 'tunisie'),
(30, 'Chili', 'Chile', 'chili'),
(31, 'Polynesie Française', 'French Polynesia', 'polynesiefrancaise'),
(32, 'Côte d\\''Ivoire', 'Ivory Coast', 'cotedivoire'),
(33, 'Norvège', 'Norway', 'norvege'),
(34, 'Thaïlande', 'Thailand', 'thailande'),
(35, 'Turquie', 'Turkey', 'turquie'),
(36, 'Israël', 'Israel', 'israel'),
(37, 'Roumanie', 'Romania', 'roumanie'),
(38, 'Philippines', 'Philippines', 'phillipine'),
(39, 'République Tchèque', 'Czech Republic', 'rep_tcheque'),
(40, 'Colombie', 'Colombia', 'colombie'),
(41, 'Sénégal', 'Senegal', 'senegal'),
(42, 'Venezuela', 'Venezuela', 'venezuela'),
(43, 'Argentine', 'Argentina', 'argentine'),
(44, 'Monaco', 'Monaco', 'monaco'),
(45, 'Nouvelle-Zélande', 'New Zealand', 'nouvellezelande'),
(46, 'Indonésie', 'Indonesia', 'indonesie'),
(47, 'Porto Rico', 'Puerto Rico', 'portorico'),
(48, 'Aaland', 'Aaland', 'aaland'),
(49, 'Afghanistan', 'Afghanistan', 'afganistan'),
(50, 'Afrique du Sud', 'South Africa', 'afriquedusud'),
(51, 'Albanie', 'Albania', 'albanie'),
(52, 'Andorre', 'Andorra', 'andorre'),
(53, 'Angola', 'Angola', 'angola'),
(54, 'Anguilla', 'Anguilla', 'anguilla'),
(55, 'Antigua-et-Barbuda', 'Antigua & Barbuda', 'antigua_barbuda'),
(56, 'Antilles néerlandaises', 'Netherlands antilles', 'antilles_neerlandaises'),
(57, 'Arabie saoudite', 'Saudi Arabia', 'arabie_saoudite'),
(58, 'Arménie', 'Armenia', 'armenie'),
(59, 'Aruba', 'Aruba', 'aruba'),
(60, 'Azerbaïdjan', 'Azerbaijan', 'azerbaidjan'),
(61, 'Bahamas', 'Bahamas', 'bahamas'),
(62, 'Bahreïn', 'Bahrain', 'bahrein'),
(63, 'Bangladesh', 'Bangladesh', 'bangladesh'),
(64, 'Barbade', 'Bangladesh', 'barbade'),
(65, 'Belize', 'Belize', 'belize'),
(66, 'Bénin', 'Benin', 'benin'),
(67, 'Bermudes', 'Bermuda', 'bermudes'),
(68, 'Bhoutan', 'Bhutan', 'bhoutan'),
(69, 'Biélorussie', 'Belarus', 'bielorussie'),
(70, 'Birmanie', 'Myanmar', 'birmanie'),
(71, 'Bolivie', 'Bolivia', 'bolivie'),
(72, 'Bosnie-Herzégovine', 'Bosnia & Herzegovina', 'bosnie_herzegovine'),
(73, 'Botswana', 'Botswana', 'botswana'),
(74, 'Brunei', 'Brunei Darussalam', 'brunei'),
(75, 'Bulgarie', 'Bulgaria', 'bulgarie'),
(76, 'Burkina Faso', 'Burkina Faso', 'burkina_faso'),
(77, 'Burundi', 'Burundi', 'burundi'),
(78, 'Cambodge', 'Cambodia', 'cambodge'),
(79, 'Cameroun', 'Cameroon', 'cameroun'),
(80, 'Cap-Vert', 'Cape Verde', 'capvert'),
(81, 'Chine', 'China', 'chine'),
(82, 'Chypre', 'Cyprus', 'chypre'),
(83, 'Comores', 'Comoros', 'comores'),
(84, 'Congo', 'Congo', 'congo'),
(85, 'Corée du Nord', 'North Korea', 'coreenord'),
(86, 'Corée du Sud', 'South Korea', 'coreesud'),
(87, 'Costa Rica', 'Costa Rica', 'costarica'),
(88, 'Croatie', 'Croatia', 'croatie'),
(89, 'Cuba', 'Cuba', 'cuba'),
(90, 'Djibouti', 'Djibouti', 'djibouti'),
(91, 'Dominique', 'Dominica', 'dominique'),
(92, 'Écosse', 'Scotland', 'ecosse'),
(93, 'Égypte', 'Egypt', 'egypte'),
(94, 'Émirats arabes unis', 'United Arab Emirates', 'emirats_arabes_unis'),
(95, 'Équateur', 'Ecuador', 'equateur'),
(96, 'Érythrée', 'Eritrea', 'erythree'),
(97, 'Estonie', 'Estonia', 'estonie'),
(98, 'Éthiopie', 'Ethiopia', 'ethiopie'),
(99, 'Fidji', 'Fiji', 'fidji'),
(100, 'Gabon', 'Gabon', 'gabon'),
(101, 'Gambie', 'Gambia', 'gambie'),
(102, 'Géorgie', 'Georgia', 'georgie'),
(103, 'Géorgie du Sud et Sandwich du Sud', 'South Georgia and South Sandwich Islands', 'georgiedusud_ilessandwichdusud'),
(104, 'Ghana', 'Ghana', 'ghana'),
(105, 'Gibraltar', 'Gibraltar', 'gibraltar'),
(106, 'Grenade', 'Grenada', 'grenade'),
(107, 'Groenland', 'Greenland', 'groenland'),
(108, 'Guadeloupe', 'Guadeloupe', 'guadeloupe'),
(109, 'Guam', 'Guam', 'guam'),
(110, 'Guatemala', 'Guatemala', 'guatemala'),
(111, 'Guinée', 'Guinea', 'guinee'),
(112, 'Guinée-Bissau', 'Guinea-Bissau', 'guineebissau'),
(113, 'Guinée équatoriale', 'Equatorial Guinea', 'guineeequatoriale'),
(114, 'Guyana', 'Guyana', 'guyana'),
(115, 'Guyane', 'French Guiana', 'guyannefrancaise'),
(116, 'Haïti', 'Haiti', 'haiti'),
(117, 'Honduras', 'Honduras', 'honduras'),
(118, 'Hong Kong', 'Hong Kong', 'hongkong'),
(119, 'Île Christmas', 'Christmas Island', 'ile_christmas'),
(120, 'Île Saint-Hélène', 'Saint Helena Island', 'ile_saint_helene'),
(121, 'Îles Caïmans', 'Cayman Islands', 'iles_caimans'),
(122, 'Îles Cocos', 'Cocos Islands', 'iles_cocos'),
(123, 'Îles Cook', 'Cook Islands', 'iles_cook'),
(124, 'Îles Féroé', 'Faroe Islands', 'iles_feroe'),
(125, 'Îles Malouines', 'Falkland Islands', 'iles_malouines'),
(126, 'Îles Vièrges des États-Unis', 'Virgin Islands of United-States', 'iles_vierges_des_usa'),
(127, 'Inde', 'India', 'inde'),
(128, 'Irak', 'Iraq', 'irak'),
(129, 'Iran', 'Iran', 'iran'),
(130, 'Islande', 'Iceland', 'islande'),
(131, 'Jamaïque', 'Jamaica', 'jamaique'),
(132, 'Jordanie', 'Jordan', 'jordanie'),
(133, 'Kazakhstan', 'Kazakhstan', 'kazakhstan'),
(134, 'Kenya', 'Kenya', 'kenya'),
(135, 'Kirghizistan', 'Kyrgyzstan', 'kirghizistan'),
(136, 'Kiribati', 'Kiribati', 'kiribati'),
(137, 'Koweït', 'Kuwait', 'koweit'),
(138, 'Laos', 'Lao', 'laos'),
(139, 'Lesotho', 'Lesotho', 'lesotho'),
(140, 'Lettonie', 'Latvia', 'lettonie'),
(141, 'Liban', 'Lebanon', 'liban'),
(142, 'Libéria', 'Liberia', 'liberia'),
(143, 'Libye', 'Libya', 'libye'),
(144, 'Liechtenstein', 'Liechtenstein', 'liechtenstein'),
(145, 'Lituanie', 'Lithuania', 'lituanie'),
(146, 'Macao', 'Macao', 'macao'),
(147, 'Macédoine', 'Macedonia', 'macedoine'),
(148, 'Madagascar', 'Madagascar', 'madagascar'),
(149, 'Malaisie', 'Malaysia', 'malaisie'),
(150, 'Malawi', 'Malawi', 'malawi'),
(151, 'Maldives', 'Maldives', 'maldives'),
(152, 'Mali', 'Mali', 'mali'),
(153, 'Malte', 'Malta', 'malte'),
(154, 'Mariannes du Nord', 'Northern Mariana Islands', 'mariannesdunord'),
(155, 'Marshall', 'Marshall Islands', 'marshall'),
(156, 'Mauritanie', 'Mauritania', 'mauritanie'),
(157, 'Mayotte', 'Mayotte', 'mayotte'),
(158, 'Micronésie', 'Micronesia', 'micronesie'),
(159, 'Moldavie', 'Moldova', 'moldavie'),
(160, 'Mongolie', 'Mongolia', 'mongolie'),
(161, 'Monténégro', 'Montenegro', 'montenegro'),
(162, 'Montserrat', 'Montserrat', 'montserrat'),
(163, 'Mozambique', 'Mozambique', 'mozambique'),
(164, 'Namibie', 'Namibia', 'namibie'),
(165, 'Nauru', 'Nauru', 'nauru'),
(166, 'Népal', 'Nepal', 'nepal'),
(167, 'Nicaragua', 'Nicaragua', 'nicaragua'),
(168, 'Niger', 'Niger', 'niger'),
(169, 'Nigeria', 'Nigeria', 'nigeria'),
(170, 'Niué', 'Niue', 'niue'),
(171, 'Île Norfolk', 'Norfolk Island', 'norfolk'),
(172, 'Nouvelle Calédonie', 'New Caledonia', 'nouvellecaledonie'),
(173, 'Oman', 'Oman', 'oman'),
(174, 'Ouganda', 'Uganda', 'ouganda'),
(175, 'Ouzbékistan', 'Uzbekistan', 'ouzbekistan'),
(176, 'Pakistan', 'Pakistan', 'pakistan'),
(177, 'Palaos', 'Palau', 'palaos'),
(178, 'Palestine', 'Palestine', 'palestine'),
(179, 'Panama', 'Panama', 'panama'),
(180, 'Papouasie-Nouvelle-Guinée', 'Papua New Guinea', 'papouasie_nouvelle_guinee'),
(181, 'Paraguay', 'Paraguay', 'paraguay'),
(182, 'Pays de Galles', 'Wales', 'paysdegalles'),
(183, 'Pérou', 'Peru', 'perou'),
(184, 'Pitcairn', 'Pitcairn Island', 'pitcairn'),
(185, 'Qatar', 'Qatar', 'qatar'),
(186, 'Québec', 'Quebec', 'quebec'),
(187, 'République Centrafricaine', 'Central African Republic', 'rep_centrafricaine'),
(188, 'République Démocratique du Congo', 'Democratic Republic of the Congo', 'rep_dem_congo'),
(189, 'République Dominicaine', 'Dominican Republic', 'rep_dominicaine'),
(190, 'Réunion', 'Reunion', 'reunion'),
(191, 'Royaume-Uni', 'United Kingdom', 'royaumeuni'),
(192, 'Rwanda', 'Rwanda', 'rwanda'),
(193, 'Saint-Christophe-et-Nièves', 'Saint Kitts and Nevis', 'saint_christophe_nieves'),
(194, 'Saint-Marin', 'San Marino', 'saint_marin'),
(195, 'Saint-Pierre-et-Miquelon', 'Saint Pierre and Miquelon', 'saint_pierre_miquelon'),
(196, 'Saint-Vincent-et-les Grenadine', 'Saint Vincent and the Grenadines', 'saint_vincent_les_grenadines'),
(197, 'Sainte-Lucie', 'Saint Lucia', 'sainte_lucie'),
(198, 'Salomon', 'Solomon Islands', 'salomon'),
(199, 'Salvadore', 'El Salvador', 'salvadore'),
(200, 'Samoa', 'Samoa', 'samoa'),
(201, 'Samoa américaines', 'American Samoa', 'samoa_americaines'),
(202, 'Sao Tomé-et-Principe', 'Sao Tome and Principe', 'sao_tome_principe'),
(203, 'Serbie', 'Serbia', 'serbie'),
(204, 'Seychelles', 'Seychelles', 'seychelles'),
(205, 'Sierra-Léon', 'Sierra Leone', 'sierra_leon'),
(206, 'Singapour', 'Singapore', 'singapour'),
(207, 'Slovénie', 'Slovenia', 'slovenie'),
(208, 'Somalie', 'Somalia', 'somalie'),
(209, 'Soudan', 'Sudan', 'soudan'),
(210, 'Sri Lanka', 'Sri Lanka', 'sri_lanka'),
(211, 'Suriname', 'Suriname', 'suriname'),
(212, 'Swaziland', 'Swaziland', 'swaziland'),
(213, 'Syrie', 'Syria', 'syrie'),
(214, 'Tadjikistan', 'Tajikistan', 'tadjikistan'),
(215, 'Taïwan', 'Taiwan', 'taiwan'),
(216, 'Tanzanie', 'Tanzania', 'tanzanie'),
(217, 'Tchad', 'Chad', 'tchad'),
(218, 'Terres Australes et Antarctiques Françaises', 'French Southern Territories', 'TAAF'),
(219, 'Territoire britannique de l\\''océan Indien', 'British Indian Ocean Territory', 'BIOT'),
(220, 'Timor oriental', 'Timor-Leste', 'timor_oriental'),
(221, 'Togo', 'Togo', 'togo'),
(222, 'Tokelau', 'Tokelau', 'tokelau'),
(223, 'Tonga', 'Tonga', 'tonga'),
(224, 'Trinité-et-Tobago', 'Trinidad & Tobago', 'trinite_tobago'),
(225, 'Turkménistan', 'Turkmenistan', 'turkmenistan'),
(226, 'Tuvalu', 'Tuvalu', 'tuvalu'),
(227, 'Ukraine', 'Ukraine', 'ukraine'),
(228, 'Uruguay', 'Uruguay', 'uruguay'),
(229, 'Vanuatu', 'Vanuatu', 'vanuatu'),
(230, 'Vatican', 'Vatican City State', 'vatican'),
(231, 'Vietnam', 'Viet Nam', 'vietnam'),
(232, 'Wallis-et-Futuna', 'Wallis and Futuna', 'wallis_futuna'),
(233, 'Yémen', 'Yemen', 'yemen'),
(234, 'Zambie', 'Zambia', 'zambie'),
(235, 'Zimbabwe', 'Zimbabwe', 'zimbabwe');

--
-- Structure de la table `t_membre_statut`
--

CREATE TABLE IF NOT EXISTS `t_membre_statut` (
  `idStatut` int(11) NOT NULL AUTO_INCREMENT,
  `statut_fr` varchar(50) NOT NULL DEFAULT 'Membre',
  `statut_en` varchar(50) NOT NULL DEFAULT 'Member',
  `order` int(11) NOT NULL,
  PRIMARY KEY (`idStatut`),
  KEY `statut_fr` (`statut_fr`),
  KEY `statut_en` (`statut_en`)
) ENGINE=InnoDB AUTO_INCREMENT=2 ;


INSERT INTO `t_membre_statut` (`idStatut`, `statut_fr`, `statut_en`, `order`) VALUES
(1, 'Membre', 'Member', 1);

--
-- Structure de la table `t_membre`
--

CREATE TABLE IF NOT EXISTS `t_membre` (
  `idMembre` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `dateNaissance` date DEFAULT NULL,
  `statutCompte` enum('ACTIF','INACTIF','SUPPRIME','BANNI') NOT NULL DEFAULT 'INACTIF',
  `avatar` varchar(100) NOT NULL DEFAULT 'default.png',
  `siteWeb` varchar(255) DEFAULT NULL,
  `sexe` enum('homme','femme') NOT NULL DEFAULT 'homme',
  `presentation` text,
  `nbConnexion` int(11) NOT NULL DEFAULT '0',
  `derniereConnexion` datetime NULL,
  `boolContact` tinyint(4) NOT NULL DEFAULT '0',
  `boolTeam` tinyint(4) NOT NULL DEFAULT '0',
  `boolAssoc` tinyint(4) NOT NULL DEFAULT '0',
  `dateCreation` datetime NOT NULL,
  `dateModification` datetime NOT NULL,
  `idLangue` int(11) NOT NULL DEFAULT '1',
  `idPays` int(11) NOT NULL DEFAULT '1',
  `idStatut` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idMembre`),
  UNIQUE KEY `pseudo` (`pseudo`),
  KEY `idxLangue` (`idLangue`),
  KEY `idxPays` (`idPays`),
  KEY `idxStatut` (`idStatut`)
) ENGINE=InnoDB;

ALTER TABLE `t_membre`
  ADD CONSTRAINT `t_membre_ibfk_1` FOREIGN KEY (`idLangue`) REFERENCES `t_langue` (`idLangue`),
  ADD CONSTRAINT `t_membre_ibfk_2` FOREIGN KEY (`idPays`) REFERENCES `t_pays` (`idPays`),
  ADD CONSTRAINT `t_membre_ibfk_3` FOREIGN KEY (`idStatut`) REFERENCES `t_membre_statut` (`idStatut`);

--
-- Structure de la table `t_role`
--

CREATE TABLE IF NOT EXISTS `t_role` (
  `idRole` int(11) NOT NULL AUTO_INCREMENT,
  `libRole` varchar(50) NOT NULL,
  PRIMARY KEY (`idRole`),
  UNIQUE KEY `libRole` (`libRole`)
) ENGINE=InnoDB;



INSERT INTO `t_role` (`libRole`) VALUES ('superadmin');
INSERT INTO `t_role` (`libRole`) VALUES ('admin');


--
-- Structure de la table `t_role_membre`
--

CREATE TABLE IF NOT EXISTS `t_role_membre` (
  `idMembre` int(11) NOT NULL,
  `idRole` int(11) NOT NULL,
  PRIMARY KEY (`idMembre`,`idRole`),
  KEY `idRole` (`idRole`)
) ENGINE=InnoDB;


ALTER TABLE `t_role_membre`
  ADD CONSTRAINT `t_role_membre_ibfk_1` FOREIGN KEY (`idMembre`) REFERENCES `t_membre` (`idMembre`) ON DELETE CASCADE,
  ADD CONSTRAINT `t_role_membre_ibfk_2` FOREIGN KEY (`idRole`) REFERENCES `t_role` (`idRole`) ON DELETE CASCADE;