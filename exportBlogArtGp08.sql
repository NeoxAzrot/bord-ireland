-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  Dim 29 mars 2020 à 23:03
-- Version du serveur :  5.7.26
-- Version de PHP :  7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `blogart20`
--

-- --------------------------------------------------------

--
-- Structure de la table `angle`
--

DROP TABLE IF EXISTS `angle`;
CREATE TABLE IF NOT EXISTS `angle` (
  `NumAngl` char(8) NOT NULL,
  `LibAngl` char(60) DEFAULT NULL,
  `NumLang` char(8) NOT NULL,
  PRIMARY KEY (`NumAngl`),
  KEY `ANGLE_FK` (`NumAngl`),
  KEY `FK_ASSOCIATION_6` (`NumLang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `angle`
--

INSERT INTO `angle` (`NumAngl`, `LibAngl`, `NumLang`) VALUES
('ANGL0101', 'Fictif', 'FRAN01'),
('ANGL0201', 'Informatif', 'FRAN01'),
('ANGL0301', 'Classement', 'FRAN01'),
('ANGL0401', 'Conseil', 'FRAN01');

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
  `NumArt` char(10) NOT NULL,
  `DtCreA` date DEFAULT NULL,
  `LibTitrA` text,
  `LibChapoA` text,
  `LibAccrochA` text,
  `Parag1A` text,
  `LibSsTitr1` text,
  `Parag2A` text,
  `LibSsTitr2` text,
  `Parag3A` text,
  `LibConclA` text,
  `UrlPhotA` char(62) DEFAULT NULL,
  `Likes` int(11) DEFAULT NULL,
  `NumAngl` char(8) NOT NULL,
  `NumThem` char(8) NOT NULL,
  `NumLang` char(8) NOT NULL,
  PRIMARY KEY (`NumArt`),
  KEY `ARTICLE_FK` (`NumArt`),
  KEY `FK_ASSOCIATION_1` (`NumAngl`),
  KEY `FK_ASSOCIATION_2` (`NumThem`),
  KEY `FK_ASSOCIATION_3` (`NumLang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`NumArt`, `DtCreA`, `LibTitrA`, `LibChapoA`, `LibAccrochA`, `Parag1A`, `LibSsTitr1`, `Parag2A`, `LibSsTitr2`, `Parag3A`, `LibConclA`, `UrlPhotA`, `Likes`, `NumAngl`, `NumThem`, `NumLang`) VALUES
('01', '2020-03-17', 'Coronavirus: Les tips &agrave; suivre pour une Saint Patrick &agrave; l&rsquo;irlandaise !', 'Nous sommes en pleine pand&eacute;mie ! Nous sommes en Guerre, comme l&rsquo;a annonc&eacute; Pr&eacute;sident Macron Lundi soir. Mais ce n&rsquo;est pas pour autant que vous ne pourrez pas faire vos propres festivit&eacute;s chez vous avec les heureux &eacute;lus de votre confinement! Suivez ces petits tips pour vous assurez de passer la saint-Patrick comme un vrai irlandais depuis votre canap&eacute; !', '', 'Le soir du lundi 16 Mars 2020, Pr&eacute;sident Macron annonce au peuple fran&ccedil;ais que nous sommes en Guerre. Oui, en guerre contre un ennemi encore plus f&eacute;roce qu\'auparavant, le coronavirus, scientifiquement nomm&eacute; le Covid-19. Et c&rsquo;est donc pour cela qu&rsquo;il a pris la d&eacute;cision de mettre chaque habitant du territoire fran&ccedil;ais en confinement chez eux. La propagation du virus a pris beaucoup d&rsquo;ampleur ces derniers mois, ce qui n&rsquo;a laiss&eacute; aucun choix au gouvernement de prendre les pr&eacute;cautions suivantes : tous les bars, cin&eacute;mas et restaurants doivent fermer leurs portes jusqu&rsquo;&agrave; nouvel ordre. Cette nouvelle nous a tous pris un peu par surprise. Si vous &ecirc;tes comme nous, la premi&egrave;re pens&eacute;e qui vous est pass&eacute; par l&rsquo;esprit est : &ldquo;comment vais-je faire pour f&ecirc;ter ma f&ecirc;te pr&eacute;f&eacute;r&eacute;, La Saint Patrick ?&rdquo; Ne cherchez pas plus loin, nous allons r&eacute;soudre ce petit probl&egrave;me qui vous fait terreur. Dans cet article nous allons vous aider &agrave; vous pr&eacute;parer &agrave; faire votre meilleur f&ecirc;te &agrave; ce jour. Nous allons vous aider &agrave; cr&eacute;er un petit coin d&rsquo;Irlande dans votre salon ! Que ce soit au niveau de la d&eacute;coration, l&rsquo;ambiance, nourriture ou boisson, nous sommes l&agrave; pour vous et vous partager nos petits secrets.', 'L&rsquo;IRLANDE CHEZ VOUS', 'Sur l\'&icirc;le d\'&eacute;meraude , c&rsquo;est la tradition de porter du vert, la couleur nationale, le 17 mars, afin de f&ecirc;ter la f&ecirc;te nationale. Il y a aussi des parades &agrave; chaque coin de rue, des gens avec des cheveux, moustache et barbe verte ! Et comme on le sait tous afin de se sentir comme un Irlandais il faut d&rsquo;abord lui ressembler !\r\n\r\nTips n&deg;1 : Mettez un peu de vert:\r\n\r\nTips N&deg;2 : D&eacute;corez votre appartement ou maison avec quelques tr&egrave;fles, petites pi&egrave;ces d&rsquo;or et\r\narc-en-ciel pour &ecirc;tre dans le th&egrave;me; puisque vous ne pouvez pas sortir, c&rsquo;est l&rsquo;Irlande qui s&rsquo;invite chez vous.\r\n\r\nTips n&deg;3 : Dites &agrave; vos partenaires de confinement de se mettre dans le th&egrave;me eux aussi, il ont forc&eacute;ment un v&ecirc;tement vert au minimum. \r\nUn autre petit conseil est de faire une bonne playlist de musique irlandaise, Mais pas trop fort, le but n&rsquo;est &eacute;videmment pas de r&eacute;veiller ou &eacute;nerver les voisins !! \r\nTips n&deg;4 : N&rsquo;ayez pas peur de danser. Et oui en Irlande on aime bien danser, rigoler que si c&rsquo;est pour s&rsquo;amuser un peu.\r\n\r\ntips n&deg;5 Racontez vous des l&eacute;gendes ou des histoires, puisque que dans cette culture. Les Irlandais adorent &eacute;changer, donc apprenez les uns des autres, l&rsquo;Irlande est aussi un pays qui aime ses symboliques et ses l&eacute;gendes.', 'La d&eacute;co et l&rsquo;ambiance c&rsquo;est bien, et sinon on mange et on boit quoi ?', 'F&ecirc;ter la Saint Patrick demande aussi un festin type Irlandais. Et je suis s&ucirc;re que ces id&eacute;es pourraient vous surprendre.\r\nAfin de vous pr&eacute;parer pour la soir&eacute;e de c&eacute;l&eacute;bration qu&rsquo;est la St Patrick, nous vous conseillons de faire un &lsquo;Irish Fry&rsquo;, c&rsquo;est &agrave; dire une grillade &agrave; L&rsquo;irlandaise. Traditionnellement, cette grillade est constitu&eacute; de bacon croustillant, tomates grill&eacute;es, champignons grill&eacute;s, des oeufs au plats et des bien s&ucirc;r du pain grill&eacute;. Mais vous &ecirc;tes libre d&rsquo;ajouter et d&rsquo;enlever certains &eacute;l&eacute;ment &agrave; votre guise. \r\nMais la Saint Patrick c&rsquo;est aussi un moment pour boire une bonne bi&egrave;re fra&icirc;che, ou deux.\r\nEt on va vous conseiller sur le top des bi&egrave;res et autre boissons, que l&rsquo;on retrouve dans tous les pubs &agrave; travers ce petit pays.\r\nBien sur, on ne peut pas parler d&rsquo;Irlande sans que le nom Guinness vienne en jeux. Cette stout Irlandaise est connu &agrave; travers le monde. C&rsquo;est une bi&egrave;re de couleur fonc&eacute; et un peu &eacute;paisse mais qui boit avec facilit&eacute;.Mais si les stouts ne sont pas &agrave; votre go&ucirc;t, vous pouvez go&ucirc;ter le Cidre Irlandais Magners, &agrave; boire tr&egrave;s frais.\r\nEnsuite nous vous proposons bien sur, le Bailey&rsquo;s, une liqueur typiquement irlandaise &agrave; base de whiskey irlandais et de cr&egrave;me. Celle-ci &agrave; un go&ucirc;t de caf&eacute; cr&eacute;meux, et peut se boire avec des gla&ccedil;ons, comme un bon whiskey. Vous pouvez aussi m&eacute;langer du Bailey&rsquo;s avec du Kahlua, dans un shooter pour faire des &lsquo;Baby Guinness&rsquo;. Ce shoot est nomm&eacute; comme &ccedil;a puisqu&rsquo;il ressemble &eacute;norm&eacute;ment &agrave; la bi&egrave;re classique de l&rsquo;Irlande. Et bien s&ucirc;r, il y a le Irish Coffee, un grand classique qui ne d&eacute;&ccedil;oit jamais ! La boisson est constitu&eacute; de caf&eacute;, whiskey et de chantilly sur le tout, afin de donner trois couches distinctes.', 'Voil&agrave; les quelques conseils que nous pouvons vous donner pour f&ecirc;ter la saint Patrick chez vous dans cette p&eacute;riode difficile. N&rsquo;h&eacute;sitez pas &agrave; nous envoyer vos d&eacute;guisements et d&eacute;corations de vos soir&eacute;es par mail. Nous afficherons les meilleures photos sur le blog la semaine prochaine. Bonne Saint-Patrick.', 'article01.jpg', 43, 'ANGL0401', 'THE0101', 'FRAN01'),
('02', '2020-03-14', 'Le r&ocirc;le secret des familles irlandaises dans le vin de Bordeaux !', 'Bordeaux est connue &agrave; travers le monde entier pour son vin et ses vignobles l&eacute;gendaires qui entoure la belle cit&eacute; du vin. Vous connaissez s&ucirc;rement les ch&acirc;teaux Lynch-Bages, Leoville-Barton, Ph&eacute;lan-S&eacute;gur et Kirwan, tous des noms reconnus mondialement. Et si je vous disais que derri&egrave;re ces grands noms se trouvent des familles irlandaises.', '', 'Il est vrai que l&rsquo;Irlande est connue pour sa bi&egrave;re fonc&eacute;e et son whiskey, mais les liens entre les vignobles de Bordeaux et les Irlandais du 17&egrave;me et 18&egrave;me si&egrave;cle, un peu moins. Ce lien commence lors du r&egrave;gne de Louis XIV, Bordeaux est d&eacute;j&agrave; une ville importante o&ugrave; se font de nombreux &eacute;changes et march&eacute;s de toutes sortes de marchands. Il y avait, bien entendu des marchands irlandais faisant partie de la tribu de Galway. La tribu de Galway est un groupe compos&eacute; quatorze familles de marchands. &Agrave; Galway en Irlande, ces familles dominaient la vie politique, commerciale et sociale. Cette tribu de marchands &eacute;taient des stricts catholiques, comme la majorit&eacute; de L&rsquo;Irlande &agrave; cette &eacute;poque. Or en 1641, il y a eu un coup d&rsquo;&Eacute;tat port&eacute; par les catholiques contre les administrations d&rsquo;anglais et d&rsquo;&eacute;cossais protestants, la raison pour cette ne r&eacute;bellion &eacute;tant que les nobles catholiques sentaient une invasion imm&eacute;diate par les Anglais. Cette r&eacute;bellion entra&icirc;ne donc la Guerre des Trois Royaumes, entre les conf&eacute;d&eacute;r&eacute;s d&rsquo;Irlande et les Protestants anglais et &eacute;cossais. Douze ans apr&egrave;s la r&eacute;bellion, la victoire est d&eacute;clar&eacute;e par les Protestants. Cette victoire est non seulement tr&egrave;s importante pour la suite de l&rsquo;Histoire irlandaise, mais aussi pour l&rsquo;Histoire de certains vignobles de Bordeaux.', 'La naissance des &ldquo;Wine Geese&rdquo; (Oies du vin)', '&Agrave; partir de 1653, les co&ucirc;ts de la d&eacute;faite pour les Irlandais catholiques &eacute;taient importants, puisqu&rsquo;il est estim&eacute; que l&rsquo;Irlande a perdu pr&egrave;s d\'un tiers de sa population. Les partisans de Cromwell ont laiss&eacute; les derni&egrave;res troupes rebelles rejoindre l&rsquo;arm&eacute;e fran&ccedil;aise seulement parce que Charles 1er d\'Angleterre s&rsquo;&eacute;tait exil&eacute; l&agrave;-bas, au lieu de les ex&eacute;cuter sur-le-champ. Mais surtout, il y a eu une confiscation massive des terres qui appartenait au Irlandais catholique qui refusait d&rsquo;abandonner leur foi. Ce n\'est pour cela qu&rsquo;une partie des familles qui composaient la tribu de Galway, et certains nobles ont quitt&eacute; l\'&icirc;le d\'&eacute;meraude pour rejoindre le pays du Roi Soleil.\r\nCe voyage marque le d&eacute;but que ce qu&rsquo;on appelle, en anglais, les &ldquo;Wine Geese&rdquo;.\r\nLes Wine Geese, ou Oies du vin en fran&ccedil;ais, est le nom donn&eacute; aux personnes qui ont quitt&eacute; l&rsquo;Irlande pour s&rsquo;installer &agrave; l&rsquo;&eacute;tranger, et comme leur nom l&rsquo;indique,  dans le but de participer au commerce mondial du vin. Il y aura une autre p&eacute;riode pour les oies du vin au 18&egrave;me si&egrave;cle avec la Grande famine, qui poussera plusieurs Irlandais &agrave; s&rsquo;expatrier &agrave; travers le monde.', 'Le r&eacute;sultat des migrations des oies du vin', 'De nombreuses familles irlandaises ont jou&eacute; un r&ocirc;le essentiel dans les vignobles de Gironde. Certaines d&rsquo;entre elles ont eu les vignobles par h&eacute;ritage, par alliance, ou encore par des mariages. Beaucoup de marchands qui sont partis de l&rsquo;Irlande ont nou&eacute; de fort lien avec des marchands de vins en France, ce qui fait des mariages et des biens &eacute;chang&eacute;s. Ceci a &eacute;t&eacute; le cas de plusieurs ch&acirc;teaux, comme celui de Lynch-Bages et  Kirwan. Mais le ch&acirc;teau de L&eacute;oville-Barton, a &eacute;t&eacute; achet&eacute; au d&eacute;but du 19&egrave;me si&egrave;cle par Hugh Barton et qui reste encore, &agrave; ce jour dans sa famille. Mark Kirwan, qui &eacute;taient le propri&eacute;taire du domaine Kirwan, a eu beaucoup de succ&egrave;s avec son vin, qui a &eacute;t&eacute; reconnu par l&rsquo;ambassadeur des &Eacute;tats-Unis (qui en sera pr&eacute;sident dans le futur) et par Napol&eacute;on III. Les vins du ch&acirc;teau de Kirwan ont donc, gr&acirc;ce &agrave; l&rsquo;ambassadeur une reconnaissance mondiale. M&ecirc;me si la propri&eacute;t&eacute; a &eacute;t&eacute; vendu a la fin du 19&egrave;me si&egrave;cle.Quant au ch&acirc;teau Ph&eacute;lan S&eacute;gur, son fondateur Bernard O\'Phelan, &eacute;tait un commer&ccedil;ant de vins irlandais. Il acquiert  le Clos de Garramey ainsi que le domaine S&eacute;gur de Cabanac. Il est passionn&eacute; de vin et veut &eacute;difier un ch&acirc;teau sur le vin. Il sera un des premiers &agrave; concevoir un cuvier &agrave; la &ldquo;m&eacute;docaine&rdquo;.', 'Voici des petits secrets historiques sur les vignobles iconiques de Bordeaux. Qui aurait cru des familles irlandaises fuyant la pers&eacute;cution aurait eu un impact sur les vins de Bordeaux !', 'article02.jpg', 56, 'ANGL0201', 'THE0102', 'FRAN01'),
('03', '2020-03-16', 'Top 3 des l&eacute;gendes irlandaises que vous devez absolument conna&icirc;tre !', 'Terre d&rsquo;histoire, d&rsquo;aventure, de h&eacute;ros et de l&eacute;gendes, l&rsquo;Irlande est un lieu magique et aujourd&rsquo;hui elle est encore impr&eacute;gn&eacute;e de tous ces mythes. Et si un jour vous comptez vous rendre en Irlande, vous ne pourrez pas &eacute;chapper aux l&eacute;gendes qui vont suivre !', '', 'Vous connaissez s&ucirc;rement la chauss&eacute;e des g&eacute;ants, vous l&rsquo;avez sans aucuns doutes d&eacute;j&agrave; vue &agrave; la t&eacute;l&eacute; ou sur internet, car ce lieu l&eacute;gendaire Irlandais est visit&eacute; chaque ann&eacute;e par des milliers de touristes, mais savez-vous vraiment comment s&rsquo;est form&eacute; ce lieu mythique ? \r\n\r\nD&rsquo;apr&egrave;s le folklore Irlandais, la chauss&eacute;e des g&eacute;ants se serait form&eacute;e apr&egrave;s une affrontation entre devinez quoi ?... Deux g&eacute;ants ! Un g&eacute;ant Irlandais se nommant Finn MacCool qui entendit qu&rsquo;un g&eacute;ant &eacute;cossais nomm&eacute; Benandonner mena&ccedil;ais l&rsquo;Irlande. Finn s&rsquo;est donc saisi de morceaux de la c&ocirc;te d&rsquo;Antrim et les a jet&eacute;s &agrave; la mer afin de former un chemin pour aller combattre Benandonner. Malheureusement, en arrivant devant le g&eacute;ant &eacute;cossais, Finn s&rsquo;est rendu compte que Benandonner &eacute;tait bien trop grand pour qu&rsquo;il puisse avoir une chance de gagner face &agrave; lui. Il fit donc demi-tour et s&rsquo;&eacute;chappa en Irlande. Sa femme tr&egrave;s vive d&rsquo;esprit, d&eacute;cida, afin de sauver Finn de la d&eacute;guiser en b&eacute;b&eacute;. Lorsque l\'&Eacute;cossais arriva, il vu la taille du b&eacute;b&eacute; et pris peur de la taille immense du p&egrave;re et finit par repartir. Ainsi, Finn MacCool gagna son combat gr&acirc;ce &agrave; la ruse. \r\nLa meilleure, c&rsquo;est que beaucoup des personnes habitants pr&ecirc;t du lieux croient &agrave; cette l&eacute;gende !\r\n\r\nIl y a n&eacute;anmoins une explication scientifique : La chauss&eacute;e des g&eacute;ants serait issu du refroidissement de 40000 colonnes de basaltes les unes dans les autres.', 'La l&eacute;gende de la Saint Patrick', 'La Saint Patrick ! Cette fameuse f&ecirc;te Irlandaise o&ugrave; alcool et musique vont bon train et o&ugrave; le vert est &agrave; l&rsquo;honneur. Si vous ne la connaissiez pas, et bien maintenant vous en savez un peu plus sur cette f&ecirc;te que beaucoup de personne mais surtout beaucoup d&rsquo;Irlandais c&eacute;l&egrave;brent &agrave; travers le monde. Mais connaissez vous son origine ? \r\n\r\nEt bien figurez vous que cette f&ecirc;te c&eacute;l&egrave;bre le saint-patron irlandais : Patrick (&eacute;videmment).\r\nD&rsquo;apr&egrave;s la l&eacute;gende, patrick aurait &eacute;t&eacute; enlev&eacute; puis r&eacute;duit en esclavage par des pirates Irlandais. Il aurait ensuite &eacute;t&eacute; fait berger par un Druide puis aurait beaucoup voyag&eacute; avant de se convertir &agrave; la vie religieuse. Sa mission voulait qu&rsquo;il convertisse son pays entier au catholicisme. Pour cela, il aurait r&eacute;ussi &agrave; d&eacute;barrasser l&rsquo;enti&egrave;ret&eacute; de l&rsquo;Irlande de b&ecirc;tes terriblement f&eacute;roce : les serpents. Il les auraient vaincu en les faisant p&eacute;rir dans les flots. \r\nLes l&eacute;gendes autour de la Saint Patrick restent tr&egrave;s flou et peu de monde r&eacute;ussi &agrave; s&rsquo;accorder sur la v&eacute;racit&eacute; de son histoire. La Saint Patrick reste n&eacute;anmoins une f&ecirc;te tr&egrave;s ancr&eacute;e dans la culture Irlandaise. \r\n\r\nN&rsquo;oubliez donc pas de porter un tr&egrave;fle et de vous habiller en vert le 17 Mars, jour de la mort de Saint Patrick !', 'La l&eacute;gende du triangle amoureux :', 'La troisi&egrave;me l&eacute;gende est la moins connue des trois &agrave; l&rsquo;international, elle n&rsquo;en reste pas moins une l&eacute;gende tr&egrave;s importante dans le folklore Irlandais. Celle-ci est la l&eacute;gende de Diarmuid, Grainne et Fionn : le triangle amoureux\r\n\r\nElle commence lors du banquet qui pr&eacute;c&egrave;de les noces entre Fionn MacCumaill et sa futur &eacute;pouse Grainne qui, elle, ne souhaitait malheureusement pas l&rsquo;&eacute;pouser. Au d&eacute;but des noces, Grainne tombe &eacute;perdument amoureuse d&rsquo;un soldat pr&eacute;sent au banquet, le neveu de son futur mari, ce soldat s&rsquo;appelle Diarmuid. Elle d&eacute;cide que c&rsquo;est avec lui qu&rsquo;elle voudrait se marier, elle le convainc donc de fuir avec elle avant les noces. Et, pPour r&eacute;ussir &agrave; fuir, elle versa un puissant somnif&egrave;re dans les coupes de toutes les personnes pr&eacute;sentes au mariage, toutes sauf une : celle de Diarmuid ! C&rsquo;est ainsi qu&rsquo;ils err&egrave;rent en Irlande pendant plus de 20 ans avant de se faire rattraper par les troupes de Fionn. La raison ? Un sanglier aurait bless&eacute; mortellement Diarmuid et la seule fa&ccedil;on de le gu&eacute;rir &eacute;tait de faire appelle aux pouvoirs de Fionn qui peut gu&eacute;rir quiconque boit l&rsquo;eau de sa coupe. Diarmuid finit tout de m&ecirc;me par mourir et d&rsquo;apr&egrave;s la l&eacute;gende, Grainne, pour noyer son chagrin se serait marri&eacute;e avec Fionn MacCumaill. \r\n\r\nUne des romances tragique les plus connues en Irlande !', 'Vous connaissez maintenant un peu plus les l&eacute;gendes qui traverse le pays magique qu&rsquo;est l&rsquo;Irlande, mais croyez moi ce pays mythique ne vous a pas encore d&eacute;voil&eacute; tous ses secrets !', 'article03.jpg', 86, 'ANGL0301', 'THE0103', 'FRAN01'),
('04', '2020-03-20', 'Confidence Irlandais', 'Me voil&agrave; arriv&eacute; dans cette pi&egrave;ce secr&egrave;te domin&eacute;e par l&rsquo;ombre. J&rsquo;entre doucement, la luminosit&eacute; produit par les anciennes lampes &agrave; huile regorge de nuances jaun&acirc;tres et cr&eacute;e une teinte magnifique sur le cuir mat du chesterfield des ann&eacute;es 70 qui se trouve devant moi. Delwyn est accoud&eacute; au bar, avec une bouteille d&rsquo;un bleu &eacute;meraude &eacute;clatant et me demande de le rejoindre. Ce m&eacute;lange de tons provoque en moi une &eacute;vasion, un sentiment de voyage, une pens&eacute;e irlandaise.', '', 'Je m&rsquo;installe confortablement dans le chesterfield avec une savoureuse Guinness, douceur irlandaise comme ils aiment si bien le dire. La voix grave de Delwyn r&eacute;sonne dans le sous-sol, ses paroles sur l&rsquo;Irlande me chamboule face &agrave; ce pays celtique, cette &icirc;le magnifique, ces d&eacute;cors fig&eacute;s dans le temps et ces paysages verdoyants. Mais l&rsquo;Irlande n&rsquo;est pas qu&rsquo;un d&eacute;cor idyllique, c&rsquo;est aussi une histoire forte, un pays ravag&eacute; par les conflits entre l&rsquo;Irlande du Nord et celle du Sud. J&rsquo;arrive &agrave; ressentir l&rsquo;&eacute;motion qui se d&eacute;gage dans les paroles de Delwyn. Mais le peuple celtique n&rsquo;est pas qu&rsquo;une terre de guerre, c&rsquo;est aussi un patrimoine culturel ahurissant avec les fameuses brasseries historiques b&acirc;ties des traditionnelles briquettes rouges. Ses usines mythiques de whisky artisanal, ses musiciens renomm&eacute;s ou encore leurs laines de mouton avec un savoir &eacute;tonnant pour le tissage. Je bois ses paroles, tout autant que ma bi&egrave;re d&rsquo;ailleurs. Les verres sont vides et les gorges sont s&egrave;ches, Delwyn se l&egrave;ve et m&rsquo;apporte une bouteille de whisky des ann&eacute;es 90 et m&rsquo;assure qu&rsquo;il faut absolument le go&ucirc;ter.', 'Terre de Whisky', 'L\'Irlande est la capitale mondiale de la vente de whisky avec plus de 1000 sortes diff&eacute;rentes. Delwyn pose sur la table une bouteille de Connemara de 1998 et me sert un verre. Il m&rsquo;explique qu&rsquo;il provient d&rsquo;une unique distillerie en Irlande, la brillante distillerie Cooley situ&eacute;e dans l&rsquo;ouest, dans le comt&eacute; de Galway, r&eacute;gion riche en paysages bucoliques. Le Connemara lanc&eacute; en 1995 fut le premier Irish tourb&eacute; avec un taux de 75 % d&rsquo;orge malt&eacute;e. &Agrave; travers mon verre, mes yeux se noient dans sa couleur dor&eacute;e. L&rsquo;odeur qui se d&eacute;gage est d&rsquo;une puret&eacute; rare, j&rsquo;arrive &agrave; sentir l&rsquo;odeur des c&eacute;r&eacute;ales malt&eacute;es. Je go&ucirc;te une premi&egrave;re fois, le contact avec mes l&egrave;vres se r&eacute;v&egrave;le &eacute;tonnant. Les saveurs sont extras, leurs m&eacute;langes provoquent en bouche des sensations de bonheur. Mais je suis dans le flou, je n&rsquo;arrive pas &agrave; mettre un nom sur chaque ar&ocirc;me. &Agrave; l\'aveugle, il n\'&eacute;voque en rien le style irlandais et se montre beaucoup plus proche d\'un whisky &eacute;cossais par sa corpulence et sa typicit&eacute; aromatique. Les verres s&rsquo;encha&icirc;nent et la chaleur ambiante commence &agrave; hausser. Delwyn m\'interpelle, il enl&egrave;ve son pull en laine et m&rsquo;exprime l&rsquo;affection qu&rsquo;il la pour ce pull qui appartenait &agrave; son arri&egrave;re-grand-p&egrave;re, berger dans les Highlands.', 'Un patrimoine vestimentaire', 'Les pulls en laine irlandais sont d&rsquo;une couleur naturellement &eacute;crue, caract&eacute;ris&eacute;e par ce typique col rond avec un maillage tr&egrave;s serr&eacute;. Ils sont connus dans le monde entier, c&rsquo;est devenu une ic&ocirc;ne de la mode. Ils tiennent leurs origines de l&rsquo;archipel des &icirc;les d&rsquo;Aran situ&eacute;es au large de Galway, sur la vaste c&ocirc;te ouest de l&rsquo;Irlande, terre de p&ecirc;cheurs et d&rsquo;agriculteurs avec un climat pluvieux et venteux. Les &eacute;levages de moutons y &eacute;tant nombreux, les Irlandais ont commenc&eacute; &agrave; tisser leur laine pour en faire des pulls qui les prot&eacute;geaient du froid et de l&rsquo;humidit&eacute; pendant les longs mois d&rsquo;hiver. Les pulls tricot&eacute;s enti&egrave;rement &agrave; la main sont devenus de v&eacute;ritables &oelig;uvres d&rsquo;art. Chaque pull n&eacute;cessitait plus de cent-mille coutures avec une dur&eacute;e de plus soixante jours de tricotage. Delwyn me fait part de l&rsquo; existence de bon nombre de motifs traditionnels, chacun raconte sa propre histoire. Le pull de l&rsquo;arri&egrave;re-grand-p&egrave;re a pour motif la torsade, c&rsquo;est le plus c&eacute;l&egrave;bre des motifs Aran, il repr&eacute;sente les cordages des p&ecirc;cheurs et symbolise la chance.', 'Les f&ucirc;ts et les bouteilles sont vides. L&rsquo;heure du d&eacute;part s&rsquo;approche, il est temps pour moi de quitter cet endroit rempli de vie irlandaise. Pendant une soir&eacute;e, j&rsquo;ai voyag&eacute; dans les bas-fonds de l&rsquo;Irlande alors que je n&rsquo;&eacute;tais qu&rsquo;&agrave; Bordeaux. Delwyn, g&eacute;rant du comptoir irlandais, vous permet de vous &eacute;vader, le temps d&rsquo;une soir&eacute;e.', 'article04.jpg', 93, 'ANGL0101', 'THE0104', 'FRAN01'),
('05', '2020-03-24', 'Tout savoir sur le pr&eacute;nom Patrick.', 'Patrick, tout le monde a un oncle ou un coll&egrave;gue de travail qui porte ce pr&eacute;nom. Et pourtant, connaissez vous ses origines et son rapport &agrave; la f&ecirc;te Irlandaise qui porte son nom ?', '', 'Tout d\'abord, Patrick est un pr&eacute;nom anglais, la variante fran&ccedil;aise &eacute;tant vraisemblablement Patrice, &agrave; moins de dire Patrique (Patricia au f&eacute;minin). Historiquement, c&rsquo;est le d&eacute;riv&eacute; du latin &quot;patricius&quot;, se rapportant aux patriciens. Les patriciens, dans la Rome antique, &eacute;taient les citoyens de la classe sup&eacute;rieure, par opposition aux pl&eacute;b&eacute;iens. Ils avaient des droits et s&rsquo;occupaient de la vie politique et religieuse de la cit&eacute;. Ce mot fut utilis&eacute; apr&egrave;s la civilisation romaine pour d&eacute;signer la haute bourgeoisie. \r\nBeaucoup utilis&eacute; au &Eacute;tats-Unis et dans toute la grande Bretagne, le pr&eacute;nom Patrick n&rsquo;est arriv&eacute; en France qu&rsquo;en 1950 et conna&icirc;t un pic de popularit&eacute; dans les ann&eacute;es 1960 avec plus de 20000 naissances chaque ann&eacute;es. De nos jours, tout comme la tecktonik, ce pr&eacute;nom n&rsquo;est plus du tout &agrave; la mode (moins de 150 naissances par an). Au total durant le 20&egrave;me si&egrave;cle, on d&eacute;nombre pas moins de 394000 naissances de Patrick en France. \r\nEn r&eacute;sum&eacute;, si vous vous appelez Patrick, vous avez la classe car votre pr&eacute;nom d&eacute;signait autrefois les personnes importantes, et vous &ecirc;tes tr&egrave;s s&ucirc;rement n&eacute; pendant le baby boom.\r\n \r\nMais alors, quel rapport avec l\'Irlande me diriez-vous ?', 'Patrick et la Saint-Patrick.', 'Plut&ocirc;t que se questionner sur pourquoi votre coll&egrave;gue de la compta s&rsquo;appelle Patrick, nous allons nous demander pourquoi le 17 Mars, c&rsquo;est la Saint-Patrick et non la Saint-Sylvestre (un exemple parmi tant d&rsquo;autre, nous parlerons de la Saint-sylvestre une autre fois).\r\nPlus qu&rsquo;une f&ecirc;te, Saint-Patrick est un Saint (jusque-l&agrave;, rien d&rsquo;&eacute;tonnant). Ce personnage serait n&eacute; vraisemblablement vers 386, en actuelle Grande Bretagne,  mais rien n&rsquo;est s&ucirc;r. Apr&egrave;s avoir &eacute;t&eacute; consacr&eacute; &eacute;v&ecirc;que en France, Il est parti &eacute;vang&eacute;liser l&rsquo;Irlande. Sa biographie a &eacute;t&eacute; noy&eacute; sous les l&eacute;gendes &agrave; partir du VII&egrave;me si&egrave;cle, et c&rsquo;est pour cela qu&rsquo;il est consid&eacute;r&eacute; comme le fondateur du christianisme irlandais, faisant passer Saint Patrick d&rsquo;un simple culte local en ap&ocirc;tre de l&rsquo;Irlande. Il utilisait le tr&egrave;fle comme symbole dans ses discours pour symboliser la sainte Trinit&eacute;, qui deviendra par la suite symbole national. Saint Patrick d&eacute;c&egrave;de  le 17 Mars 461. Cette date devient la date de la f&ecirc;te nationale Irlandaise en 1607. Pour l&rsquo;anecdote, ce pr&eacute;nom est tellement r&eacute;pandu en Irlande que les anglais les d&eacute;signe avec le diminutif &ldquo;Paddy&rdquo;.', 'Quelques Patrick c&eacute;l&egrave;bres.', 'Patrick Bruel : chanteur de vari&eacute;t&eacute; fran&ccedil;aise et acteur, sa passion est le poker.\r\nPatrick Poivre d&rsquo;Arvor : dit PPDA, c&rsquo;est un journaliste fran&ccedil;ais et &eacute;crivain. Il a notamment inspir&eacute; la marionnette principale de l&rsquo;&eacute;mission les guignols de l&rsquo;info sur Canal+.\r\nPatrick Balkany : homme politique fran&ccedil;ais, ancien maire de Levallois-Perret, il est connu pour ses affaires de fraude fiscale.\r\nPatrick l&rsquo;&eacute;toile de mer : meilleur ami de Bob l&rsquo;&eacute;ponge, expert dans l&rsquo;art de ne rien faire, il est repr&eacute;sent&eacute; dans le dessin anim&eacute; comme l&rsquo;idiot du village.\r\nPatrick Chirac. Personnage principal des films Camping, il fr&eacute;quente chaque &eacute;t&eacute; le camping les flots bleus. il a prononc&eacute; la c&eacute;l&egrave;bre phrase : &ldquo;Alors, on attends pas Patrick ?&rdquo; (son acteur ne s&rsquo;appelle malheureusement pas Patrick et n&rsquo;a donc pas sa place dans cet article.)\r\nPatrick S&eacute;bastien : chanteur paillard et pr&eacute;sentateur de l&rsquo;&eacute;mission Le plus grand cabaret du monde, son plus grand chef-d&rsquo;&oelig;uvre est sa chanson &ldquo;Les Sardines&rdquo;.', 'Nous savons maintenant que Saint-Patrick, le patron de l&rsquo;Irlande, est la raison du rapport entre ce pr&eacute;nom et son pays. Nous savons aussi pourquoi nous f&ecirc;tons la Saint-Patrick le 17 Mars : c&rsquo;est l&rsquo;anniversaire de la mort de Saint-Patrick.\r\nVoil&agrave; ce que je pouvais dire sur les origines du pr&eacute;nom Patrick et sa relation avec l&rsquo;Irlande, en esp&eacute;rant qu&rsquo;&agrave; la fin du confinement vous pourrez aller vous vanter aupr&egrave;s de votre coll&egrave;gue ou oncle de tout savoir &agrave; propos de son pr&eacute;nom.', 'article05.jpg', 36, 'ANGL0201', 'THE0105', 'FRAN01'),
('06', '2020-03-28', 'Le mouton, la mascotte du pays Irlandais!', 'Vous &ecirc;tes vous d&eacute;j&agrave; demand&eacute; pourquoi le symbole de votre ville, de votre pays &eacute;tait aussi original ? En Irlande, un v&eacute;ritable embl&egrave;me du pays est le mouton. Au m&ecirc;me titre que le tr&egrave;fle, la harpe, la bi&egrave;re, le whisky et le rugby, c&rsquo;est tout simplement une mascotte qu&rsquo;on adore !', '', 'Vous avez s&ucirc;rement d&eacute;j&agrave; d&ucirc; entendre parler de la l&eacute;gende du mouton en Irlande. D&rsquo;apr&egrave;s de nombreuses personnes : il y aurait plus de moutons dans cette vaste contr&eacute;e que d&rsquo;habitants.\r\nNous en croisons tellement dans ce pays que nous pouvons &ecirc;tre amen&eacute;s &agrave; penser qu&rsquo;il y en aurait au moins deux fois plus que d&rsquo;habitants. Attention aux id&eacute;es re&ccedil;ues ! Sur l&rsquo;&icirc;le, nous comptons 5 548 219 moutons pour 6 399 115 habitants, d&rsquo;apr&egrave;s des chiffres de 2012. Cependant, l&rsquo;Irlande du Nord est plus peupl&eacute; de ce tendre animal que d&rsquo;&ecirc;tre humain : on d&eacute;plore 1 969 000 moutons pour 1 810 863 habitants (chiffres de 2012).\r\nMalgr&eacute; un mythe d&eacute;construit, ce chiffre reste d&eacute;mesur&eacute; ! &Agrave; titre de comparaison, en France, le Minist&egrave;re de l&rsquo;agriculture affirme en 2009, qu&rsquo;il y avait 7.5 millions de moutons pour 65 millions d&rsquo;habitants. Ridicule compar&eacute; au pays celtique !\r\nUne question peut vous venir &agrave; l&rsquo;esprit : &laquo; Pourquoi autant de moutons en Irlande ? &raquo;. La r&eacute;ponse est pourtant simple ! Juste sous vos yeux, il suffit de regarder : l&rsquo;Irlande est une terre verte avec beaucoup de r&eacute;gions montagneuses. C&rsquo;est un paysage propice &agrave; l&rsquo;&eacute;levage de moutons.', 'Tout est bon, dans le mouton !', 'Vous l\'aurez compris, c&rsquo;est un animal bon march&eacute; qui profite aux paysans. Le mouton est un animal &eacute;conomique en entretien et en nourriture. Et pour faire son bonheur, il lui suffit d&rsquo;une simple bergerie et de kilom&egrave;tres de verts p&acirc;turages &agrave; parcourir comme bon lui semble. Il offre donc un excellent retour sur investissement aux paysans irlandais et participe &agrave; grande &eacute;chelle au d&eacute;veloppement de l&rsquo;&eacute;conomie agricole en Irlande. La plupart du temps, les &eacute;leveurs irlandais laissent vagabonder leurs charmantes b&ecirc;tes &agrave; laine en toute libert&eacute;, ce qui explique que vous puissiez en trouver aux abords de la route.\r\nEn parlant de laine, cet animal en produit de grande qualit&eacute; avec laquelle de gros pulls seront fabriqu&eacute;s ou encore du tweed (sp&eacute;cialit&eacute; typique de l\'&icirc;le). Ind&eacute;pendamment de la qualit&eacute; de sa laine, le mouton est aussi utilis&eacute; pour sa peau. Qui sera utilis&eacute;e pour la confection de v&ecirc;tements, de chaussures et m&ecirc;me d&rsquo;instruments de musiques ! Du c&ocirc;t&eacute; de la viande, elle est plut&ocirc;t tendre et agr&eacute;able en go&ucirc;t. Elle fait donc partie de celle que l&rsquo;on retrouve le plus souvent dans les assiettes irlandaises.\r\nCertains paysans &eacute;l&egrave;vent aussi des pures races pour augmenter la somme de la b&ecirc;te afin de les vendre lors de foires ou de concours.', 'Les moutons fluos, un code original', 'Rouge, vert, bleu, rose, etc. Unicolore ou multicolore. Navr&eacute; de vous d&eacute;cevoir, mais le marquage de couleur n&rsquo;est pas le r&eacute;sultat de parties de paintball rat&eacute;es. Tout comme en France, il est coutume de marquer ces moutons afin de les diff&eacute;rencier de celui des autres propri&eacute;taires. Ces b&ecirc;tes sont pour la plupart du temps en libert&eacute;, sans ce marquage, les agriculteurs ne pourraient pas faire la diff&eacute;rence entre leurs b&eacute;tails et celui du voisin.\r\nCes couleurs mobiles font maintenant parties du d&eacute;cors irlandais. Et les touristes guettent avec plaisir &agrave; chaque tournant de route ces merveilleuses petites b&ecirc;tes venus errer &agrave; la campagne Irlandaise.', 'L&rsquo;Irlande sans son mouton c&rsquo;est comme un Fran&ccedil;ais sans sa baguette, un Anglais sans sa tasse de th&eacute;, ou encore un Bordelais sans son verre de vin ! Pour retrouver des airs irlandais dans votre ch&egrave;re ville de Bordeaux, je vous invite &agrave; lire l&rsquo;article &laquo; Comment f&ecirc;ter la Saint Patrick &agrave; l&rsquo;Irlandaise &raquo;, disponible sur ce m&ecirc;me blog.', 'article06.jpg', 109, 'ANGL0201', 'THE0106', 'FRAN01');

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `NumCom` char(6) NOT NULL,
  `DtCreC` datetime DEFAULT NULL,
  `PseudoAuteur` char(20) NOT NULL,
  `EmailAuteur` char(60) NOT NULL,
  `TitrCom` char(60) NOT NULL,
  `LibCom` text NOT NULL,
  `NumArt` char(10) NOT NULL,
  PRIMARY KEY (`NumCom`),
  KEY `COMMENT_FK` (`NumCom`),
  KEY `FK_ASSOCIATION_7` (`NumArt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `date`
--

DROP TABLE IF EXISTS `date`;
CREATE TABLE IF NOT EXISTS `date` (
  `DtJour` datetime NOT NULL,
  PRIMARY KEY (`DtJour`),
  KEY `DATE_FK` (`DtJour`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `date`
--

INSERT INTO `date` (`DtJour`) VALUES
('2017-12-12 00:00:00'),
('2018-11-09 00:00:00'),
('2018-12-01 00:00:00'),
('2018-12-12 00:00:00'),
('2018-12-12 09:00:00'),
('2018-12-12 11:00:00'),
('2018-12-13 00:00:00'),
('2018-12-17 00:00:00'),
('2018-12-18 00:00:00'),
('2019-01-11 00:00:00'),
('2019-01-13 00:00:00'),
('2019-01-17 00:00:00'),
('2019-02-22 14:30:00');

-- --------------------------------------------------------

--
-- Structure de la table `langue`
--

DROP TABLE IF EXISTS `langue`;
CREATE TABLE IF NOT EXISTS `langue` (
  `NumLang` char(8) NOT NULL,
  `Lib1Lang` char(25) DEFAULT NULL,
  `Lib2Lang` char(45) DEFAULT NULL,
  `NumPays` char(4) DEFAULT NULL,
  PRIMARY KEY (`NumLang`),
  KEY `LANGUE_FK` (`NumLang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `langue`
--

INSERT INTO `langue` (`NumLang`, `Lib1Lang`, `Lib2Lang`, `NumPays`) VALUES
('ALLE01', 'Allemand(e)', 'Langue allemande', 'ALLE'),
('ANGL01', 'Anglais(e)', 'Langue anglaise', 'ANGL'),
('ESPA01', 'Espagnol(e)', 'Langue espagnole', 'ESPA'),
('FRAN01', 'Français(e)', 'Langue française', 'FRAN'),
('IRLA01', 'Irlandais(e)', 'Langue irlandaise', 'IRLA'),
('ITAL01', 'Italien(ne)', 'Langue italienne', 'ITAL');

-- --------------------------------------------------------

--
-- Structure de la table `motcle`
--

DROP TABLE IF EXISTS `motcle`;
CREATE TABLE IF NOT EXISTS `motcle` (
  `NumMoCle` char(8) NOT NULL,
  `LibMoCle` char(30) DEFAULT NULL,
  `NumLang` char(8) NOT NULL,
  PRIMARY KEY (`NumMoCle`),
  KEY `MOTCLE_FK` (`NumMoCle`),
  KEY `FK_ASSOCIATION_5` (`NumLang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `motcle`
--

INSERT INTO `motcle` (`NumMoCle`, `LibMoCle`, `NumLang`) VALUES
('MTCL0101', 'Saint-Patrick', 'FRAN01'),
('MTCL0102', 'Coronavirus', 'FRAN01'),
('MTCL0103', 'Restez chez vous', 'FRAN01'),
('MTCL0104', 'Irlande', 'FRAN01'),
('MTCL0105', 'Bi&egrave;re', 'FRAN01'),
('MTCL0106', 'Vins', 'FRAN01'),
('MTCL0107', 'Bordeaux', 'FRAN01'),
('MTCL0108', 'Oies du Vin', 'FRAN01'),
('MTCL0109', 'Irlandais', 'FRAN01'),
('MTCL0110', 'Vignoble bordelais', 'FRAN01'),
('MTCL0111', 'L&eacute;gende', 'FRAN01'),
('MTCL0112', 'Mythe', 'FRAN01'),
('MTCL0113', 'Whisky', 'FRAN01'),
('MTCL0114', 'Laine', 'FRAN01'),
('MTCL0115', 'Voyage', 'FRAN01'),
('MTCL0116', 'Patrick', 'FRAN01'),
('MTCL0117', 'Pr&eacute;nom', 'FRAN01'),
('MTCL0118', 'Symbole', 'FRAN01'),
('MTCL0119', 'Mouton', 'FRAN01'),
('MTCL0120', 'Mascotte', 'FRAN01'),
('MTCL0121', 'Embl&egrave;me', 'FRAN01'),
('MTCL0122', 'Paysan', 'FRAN01');

-- --------------------------------------------------------

--
-- Structure de la table `motclearticle`
--

DROP TABLE IF EXISTS `motclearticle`;
CREATE TABLE IF NOT EXISTS `motclearticle` (
  `NumArt` char(10) NOT NULL,
  `NumMoCle` char(8) NOT NULL,
  PRIMARY KEY (`NumArt`,`NumMoCle`),
  KEY `MOTCLEARTICLE_FK` (`NumArt`),
  KEY `MOTCLEARTICLE2_FK` (`NumMoCle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `motclearticle`
--

INSERT INTO `motclearticle` (`NumArt`, `NumMoCle`) VALUES
('01', 'MTCL0101'),
('03', 'MTCL0101'),
('01', 'MTCL0102'),
('01', 'MTCL0103'),
('01', 'MTCL0104'),
('04', 'MTCL0104'),
('05', 'MTCL0104'),
('01', 'MTCL0105'),
('02', 'MTCL0106'),
('02', 'MTCL0107'),
('04', 'MTCL0107'),
('02', 'MTCL0108'),
('02', 'MTCL0109'),
('03', 'MTCL0109'),
('02', 'MTCL0110'),
('03', 'MTCL0111'),
('05', 'MTCL0111'),
('03', 'MTCL0112'),
('04', 'MTCL0113'),
('04', 'MTCL0114'),
('04', 'MTCL0115'),
('05', 'MTCL0116'),
('05', 'MTCL0117'),
('06', 'MTCL0118'),
('06', 'MTCL0119'),
('06', 'MTCL0120'),
('06', 'MTCL0121'),
('06', 'MTCL0122');

-- --------------------------------------------------------

--
-- Structure de la table `pays`
--

DROP TABLE IF EXISTS `pays`;
CREATE TABLE IF NOT EXISTS `pays` (
  `idPays` int(11) NOT NULL AUTO_INCREMENT,
  `cdPays` char(2) NOT NULL,
  `numPays` char(4) NOT NULL,
  `frPays` varchar(255) NOT NULL,
  `enPays` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idPays`),
  KEY `PAYS_FK` (`idPays`)
) ENGINE=InnoDB AUTO_INCREMENT=239 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `pays`
--

INSERT INTO `pays` (`idPays`, `cdPays`, `numPays`, `frPays`, `enPays`) VALUES
(1, 'AF', 'AFGH', 'Afghanistan', 'Afghanistan'),
(2, 'ZA', 'AFRI', 'Afrique du Sud', 'South Africa'),
(3, 'AL', 'ALBA', 'Albanie', 'Albania'),
(4, 'DZ', 'ALGE', 'Algérie', 'Algeria'),
(5, 'DE', 'ALLE', 'Allemagne', 'Germany'),
(6, 'AD', 'ANDO', 'Andorre', 'Andorra'),
(7, 'AO', 'ANGO', 'Angola', 'Angola'),
(8, 'AI', 'ANGU', 'Anguilla', 'Anguilla'),
(9, 'AQ', 'ARTA', 'Antarctique', 'Antarctica'),
(10, 'AG', 'ANTG', 'Antigua-et-Barbuda', 'Antigua & Barbuda'),
(11, 'AN', 'ANTI', 'Antilles néerlandaises', 'Netherlands Antilles'),
(12, 'SA', 'ARAB', 'Arabie saoudite', 'Saudi Arabia'),
(13, 'AR', 'ARGE', 'Argentine', 'Argentina'),
(14, 'AM', 'ARME', 'Arménie', 'Armenia'),
(15, 'AW', 'ARUB', 'Aruba', 'Aruba'),
(16, 'AU', 'AUST', 'Australie', 'Australia'),
(17, 'AT', 'AUTR', 'Autriche', 'Austria'),
(18, 'AZ', 'AZER', 'Azerbaïdjan', 'Azerbaijan'),
(19, 'BJ', 'BENI', 'Bénin', 'Benin'),
(20, 'BS', 'BAHA', 'Bahamas', 'Bahamas, The'),
(21, 'BH', 'BAHR', 'Bahreïn', 'Bahrain'),
(22, 'BD', 'BANG', 'Bangladesh', 'Bangladesh'),
(23, 'BB', 'BARB', 'Barbade', 'Barbados'),
(24, 'PW', 'BELA', 'Belau', 'Palau'),
(25, 'BE', 'BELG', 'Belgique', 'Belgium'),
(26, 'BZ', 'BELI', 'Belize', 'Belize'),
(27, 'BM', 'BERM', 'Bermudes', 'Bermuda'),
(28, 'BT', 'BHOU', 'Bhoutan', 'Bhutan'),
(29, 'BY', 'BIEL', 'Biélorussie', 'Belarus'),
(30, 'MM', 'BIRM', 'Birmanie', 'Myanmar (ex-Burma)'),
(31, 'BO', 'BOLV', 'Bolivie', 'Bolivia'),
(32, 'BA', 'BOSN', 'Bosnie-Herzégovine', 'Bosnia and Herzegovina'),
(33, 'BW', 'BOTS', 'Botswana', 'Botswana'),
(34, 'BR', 'BRES', 'Brésil', 'Brazil'),
(35, 'BN', 'BRUN', 'Brunei', 'Brunei Darussalam'),
(36, 'BG', 'BULG', 'Bulgarie', 'Bulgaria'),
(37, 'BF', 'BURK', 'Burkina Faso', 'Burkina Faso'),
(38, 'BI', 'BURU', 'Burundi', 'Burundi'),
(39, 'CI', 'IVOI', 'Côte d\'Ivoire', 'Ivory Coast (see Cote d\'Ivoire)'),
(40, 'KH', 'CAMB', 'Cambodge', 'Cambodia'),
(41, 'CM', 'CAME', 'Cameroun', 'Cameroon'),
(42, 'CA', 'CANA', 'Canada', 'Canada'),
(43, 'CV', 'CVER', 'Cap-Vert', 'Cape Verde'),
(44, 'CL', 'CHIL', 'Chili', 'Chile'),
(45, 'CN', 'CHIN', 'Chine', 'China'),
(46, 'CY', 'CHYP', 'Chypre', 'Cyprus'),
(47, 'CO', 'COLO', 'Colombie', 'Colombia'),
(48, 'KM', 'COMO', 'Comores', 'Comoros'),
(49, 'CG', 'CONG', 'Congo', 'Congo'),
(50, 'KP', 'CNOR', 'Corée du Nord', 'Korea, Demo. People s Rep. of'),
(51, 'KR', 'CSUD', 'Corée du Sud', 'Korea, (South) Republic of'),
(52, 'CR', 'RICA', 'Costa Rica', 'Costa Rica'),
(53, 'HR', 'CROA', 'Croatie', 'Croatia'),
(54, 'CU', 'CUBA', 'Cuba', 'Cuba'),
(55, 'DK', 'DANE', 'Danemark', 'Denmark'),
(56, 'DJ', 'DJIB', 'Djibouti', 'Djibouti'),
(57, 'DM', 'DOMI', 'Dominique', 'Dominica'),
(58, 'EG', 'EGYP', 'Égypte', 'Egypt'),
(59, 'AE', 'EMIR', 'Émirats arabes unis', 'United Arab Emirates'),
(60, 'EC', 'EQUA', 'Équateur', 'Ecuador'),
(61, 'ER', 'ERYT', 'Érythrée', 'Eritrea'),
(62, 'ES', 'ESPA', 'Espagne', 'Spain'),
(63, 'EE', 'ESTO', 'Estonie', 'Estonia'),
(64, 'US', 'USA_', 'États-Unis', 'United States'),
(65, 'ET', 'ETHO', 'Éthiopie', 'Ethiopia'),
(66, 'FI', 'FINL', 'Finlande', 'Finland'),
(67, 'FR', 'FRAN', 'France', 'France'),
(68, 'GE', 'GEOR', 'Géorgie', 'Georgia'),
(69, 'GA', 'GABO', 'Gabon', 'Gabon'),
(70, 'GM', 'GAMB', 'Gambie', 'Gambia, the'),
(71, 'GH', 'GANA', 'Ghana', 'Ghana'),
(72, 'GI', 'GIBR', 'Gibraltar', 'Gibraltar'),
(73, 'GR', 'GREC', 'Grèce', 'Greece'),
(74, 'GD', 'GREN', 'Grenade', 'Grenada'),
(75, 'GL', 'GROE', 'Groenland', 'Greenland'),
(76, 'GP', 'GUAD', 'Guadeloupe', 'Guinea, Equatorial'),
(77, 'GU', 'GUAM', 'Guam', 'Guam'),
(78, 'GT', 'GUAT', 'Guatemala', 'Guatemala'),
(79, 'GN', 'GUIN', 'Guinée', 'Guinea'),
(80, 'GQ', 'GUIE', 'Guinée équatoriale', 'Equatorial Guinea'),
(81, 'GW', 'GUIB', 'Guinée-Bissao', 'Guinea-Bissau'),
(82, 'GY', 'GUYA', 'Guyana', 'Guyana'),
(83, 'GF', 'GUYF', 'Guyane française', 'Guiana, French'),
(84, 'HT', 'HAIT', 'Haïti', 'Haiti'),
(85, 'HN', 'HOND', 'Honduras', 'Honduras'),
(86, 'HK', 'KONG', 'Hong Kong', 'Hong Kong, (China)'),
(87, 'HU', 'HONG', 'Hongrie', 'Hungary'),
(88, 'BV', 'BOUV', 'Ile Bouvet', 'Bouvet Island'),
(89, 'CX', 'CHRI', 'Ile Christmas', 'Christmas Island'),
(90, 'NF', 'NORF', 'Ile Norfolk', 'Norfolk Island'),
(91, 'KY', 'CAYM', 'Iles Cayman', 'Cayman Islands'),
(92, 'CK', 'COOK', 'Iles Cook', 'Cook Islands'),
(93, 'FO', 'FERO', 'Iles Féroé', 'Faroe Islands'),
(94, 'FK', 'FALK', 'Iles Falkland', 'Falkland Islands (Malvinas)'),
(95, 'FJ', 'FIDJ', 'Iles Fidji', 'Fiji'),
(96, 'GS', 'GEOR', 'Iles Géorgie du Sud et Sandwich du Sud', 'S. Georgia and S. Sandwich Is.'),
(97, 'HM', 'HEAR', 'Iles Heard et McDonald', 'Heard and McDonald Islands'),
(98, 'MH', 'MARS', 'Iles Marshall', 'Marshall Islands'),
(99, 'PN', 'PITC', 'Iles Pitcairn', 'Pitcairn Island'),
(100, 'SB', 'SALO', 'Iles Salomon', 'Solomon Islands'),
(101, 'SJ', 'SVAL', 'Iles Svalbard et Jan Mayen', 'Svalbard and Jan Mayen Islands'),
(102, 'TC', 'TURK', 'Iles Turks-et-Caicos', 'Turks and Caicos Islands'),
(103, 'VI', 'VIEA', 'Iles Vierges américaines', 'Virgin Islands, U.S.'),
(104, 'VG', 'VIEB', 'Iles Vierges britanniques', 'Virgin Islands, British'),
(105, 'CC', 'COCO', 'Iles des Cocos (Keeling)', 'Cocos (Keeling) Islands'),
(106, 'UM', 'MINE', 'Iles mineures éloignées des États-Unis', 'US Minor Outlying Islands'),
(107, 'IN', 'INDE', 'Inde', 'India'),
(108, 'ID', 'INDO', 'Indonésie', 'Indonesia'),
(109, 'IR', 'IRAN', 'Iran', 'Iran, Islamic Republic of'),
(110, 'IQ', 'IRAQ', 'Iraq', 'Iraq'),
(111, 'IE', 'IRLA', 'Irlande', 'Ireland'),
(112, 'IS', 'ISLA', 'Islande', 'Iceland'),
(113, 'IL', 'ISRA', 'Israël', 'Israel'),
(114, 'IT', 'ITAL', 'Italie', 'Italy'),
(115, 'JM', 'JAMA', 'Jamaïque', 'Jamaica'),
(116, 'JP', 'JAPO', 'Japon', 'Japan'),
(117, 'JO', 'JORD', 'Jordanie', 'Jordan'),
(118, 'KZ', 'KAZA', 'Kazakhstan', 'Kazakhstan'),
(119, 'KE', 'KNYA', 'Kenya', 'Kenya'),
(120, 'KG', 'KIRG', 'Kirghizistan', 'Kyrgyzstan'),
(121, 'KI', 'KIRI', 'Kiribati', 'Kiribati'),
(122, 'KW', 'KWEI', 'Koweït', 'Kuwait'),
(123, 'LA', 'LAOS', 'Laos', 'Lao People s Democratic Republic'),
(124, 'LS', 'LESO', 'Lesotho', 'Lesotho'),
(125, 'LV', 'LETT', 'Lettonie', 'Latvia'),
(126, 'LB', 'LIBA', 'Liban', 'Lebanon'),
(127, 'LR', 'LIBE', 'Liberia', 'Liberia'),
(128, 'LY', 'LIBY', 'Libye', 'Libyan Arab Jamahiriya'),
(129, 'LI', 'LIEC', 'Liechtenstein', 'Liechtenstein'),
(130, 'LT', 'LITU', 'Lituanie', 'Lithuania'),
(131, 'LU', 'LUXE', 'Luxembourg', 'Luxembourg'),
(132, 'MO', 'MACA', 'Macao', 'Macao, (China)'),
(133, 'MG', 'MADA', 'Madagascar', 'Madagascar'),
(134, 'MY', 'MALA', 'Malaisie', 'Malaysia'),
(135, 'MW', 'MALW', 'Malawi', 'Malawi'),
(136, 'MV', 'MALD', 'Maldives', 'Maldives'),
(137, 'ML', 'MALI', 'Mali', 'Mali'),
(138, 'MT', 'MALT', 'Malte', 'Malta'),
(139, 'MP', 'MARI', 'Mariannes du Nord', 'Northern Mariana Islands'),
(140, 'MA', 'MARO', 'Maroc', 'Morocco'),
(141, 'MQ', 'MART', 'Martinique', 'Martinique'),
(142, 'MU', 'MAUC', 'Maurice', 'Mauritius'),
(143, 'MR', 'MAUR', 'Mauritanie', 'Mauritania'),
(144, 'YT', 'MAYO', 'Mayotte', 'Mayotte'),
(145, 'MX', 'MEXI', 'Mexique', 'Mexico'),
(146, 'FM', 'MICR', 'Micronésie', 'Micronesia, Federated States of'),
(147, 'MD', 'MOLD', 'Moldavie', 'Moldova, Republic of'),
(148, 'MC', 'MONA', 'Monaco', 'Monaco'),
(149, 'MN', 'MONG', 'Mongolie', 'Mongolia'),
(150, 'MS', 'MONS', 'Montserrat', 'Montserrat'),
(151, 'MZ', 'MOZA', 'Mozambique', 'Mozambique'),
(152, 'NP', 'NEPA', 'Népal', 'Nepal'),
(153, 'NA', 'NAMI', 'Namibie', 'Namibia'),
(154, 'NR', 'NAUR', 'Nauru', 'Nauru'),
(155, 'NI', 'NICA', 'Nicaragua', 'Nicaragua'),
(156, 'NE', 'NIGE', 'Niger', 'Niger'),
(157, 'NG', 'NIGA', 'Nigeria', 'Nigeria'),
(158, 'NU', 'NIOU', 'Nioué', 'Niue'),
(159, 'NO', 'NORV', 'Norvège', 'Norway'),
(160, 'NC', 'NOUC', 'Nouvelle-Calédonie', 'New Caledonia'),
(161, 'NZ', 'NOUZ', 'Nouvelle-Zélande', 'New Zealand'),
(162, 'OM', 'OMAN', 'Oman', 'Oman'),
(163, 'UG', 'OUGA', 'Ouganda', 'Uganda'),
(164, 'UZ', 'OUZE', 'Ouzbékistan', 'Uzbekistan'),
(165, 'PE', 'PERO', 'Pérou', 'Peru'),
(166, 'PK', 'PAKI', 'Pakistan', 'Pakistan'),
(167, 'PA', 'PANA', 'Panama', 'Panama'),
(168, 'PG', 'PAPU', 'Papouasie-Nouvelle-Guinée', 'Papua New Guinea'),
(169, 'PY', 'PARA', 'Paraguay', 'Paraguay'),
(170, 'NL', 'PBAS', 'pays-Bas', 'Netherlands'),
(171, 'PH', 'PHIL', 'Philippines', 'Philippines'),
(172, 'PL', 'POLO', 'Pologne', 'Poland'),
(173, 'PF', 'POLY', 'Polynésie française', 'French Polynesia'),
(174, 'PR', 'RICO', 'Porto Rico', 'Puerto Rico'),
(175, 'PT', 'PORT', 'Portugal', 'Portugal'),
(176, 'QA', 'QATA', 'Qatar', 'Qatar'),
(177, 'CF', 'CAFR', 'République centrafricaine', 'Central African Republic'),
(178, 'CD', 'CONG', 'République démocratique du Congo', 'Congo, Democratic Rep. of the'),
(179, 'DO', 'DOMI', 'République dominicaine', 'Dominican Republic'),
(180, 'CZ', 'TCHE', 'République tchèque', 'Czech Republic'),
(181, 'RE', 'REUN', 'Réunion', 'Reunion'),
(182, 'RO', 'ROUM', 'Roumanie', 'Romania'),
(183, 'GB', 'MIQU', 'Royaume-Uni', 'Saint Pierre and Miquelon'),
(184, 'RU', 'RUSS', 'Russie', 'Russia (Russian Federation)'),
(185, 'RW', 'RWAN', 'Rwanda', 'Rwanda'),
(186, 'SN', 'SENE', 'Sénégal', 'Senegal'),
(187, 'EH', 'SAHA', 'Sahara occidental', 'Western Sahara'),
(188, 'KN', 'NIEV', 'Saint-Christophe-et-Niévès', 'Saint Kitts and Nevis'),
(189, 'SM', 'SMAR', 'Saint-Marin', 'San Marino'),
(190, 'PM', 'SPIE', 'Saint-Pierre-et-Miquelon', 'Saint Pierre and Miquelon'),
(191, 'VA', 'SSIE', 'Saint-Siège ', 'Vatican City State (Holy See)'),
(192, 'VC', 'SVIN', 'Saint-Vincent-et-les-Grenadines', 'Saint Vincent and the Grenadines'),
(193, 'SH', 'SLN_', 'Sainte-Hélène', 'Saint Helena'),
(194, 'LC', 'SLUC', 'Sainte-Lucie', 'Saint Lucia'),
(195, 'SV', 'SALV', 'Salvador', 'El Salvador'),
(196, 'WS', 'SAMO', 'Samoa', 'Samoa'),
(197, 'AS', 'SAMA', 'Samoa américaines', 'American Samoa'),
(198, 'ST', 'TOME', 'Sao Tomé-et-Principe', 'Sao Tome and Principe'),
(199, 'SC', 'SEYC', 'Seychelles', 'Seychelles'),
(200, 'SL', 'LEON', 'Sierra Leone', 'Sierra Leone'),
(201, 'SG', 'SING', 'Singapour', 'Singapore'),
(202, 'SI', 'SLOV', 'Slovénie', 'Slovenia'),
(203, 'SK', 'SLOQ', 'Slovaquie', 'Slovakia'),
(204, 'SO', 'SOMA', 'Somalie', 'Somalia'),
(205, 'SD', 'SOUD', 'Soudan', 'Sudan'),
(206, 'LK', 'SRIL', 'Sri Lanka', 'Sri Lanka (ex-Ceilan)'),
(207, 'SE', 'SUED', 'Suède', 'Sweden'),
(208, 'CH', 'SUIS', 'Suisse', 'Switzerland'),
(209, 'SR', 'SURI', 'Suriname', 'Suriname'),
(210, 'SZ', 'SWAZ', 'Swaziland', 'Swaziland'),
(211, 'SY', 'SYRI', 'Syrie', 'Syrian Arab Republic'),
(212, 'TW', 'TAIW', 'Taïwan', 'Taiwan'),
(213, 'TJ', 'TADJ', 'Tadjikistan', 'Tajikistan'),
(214, 'TZ', 'TANZ', 'Tanzanie', 'Tanzania, United Republic of'),
(215, 'TD', 'TCHA', 'Tchad', 'Chad'),
(216, 'TF', 'TERR', 'Terres australes françaises', 'French Southern Territories - TF'),
(217, 'IO', 'BOIN', 'Territoire britannique de l Océan Indien', 'British Indian Ocean Territory'),
(218, 'TH', 'THAI', 'Thaïlande', 'Thailand'),
(219, 'TL', 'TIMO', 'Timor Oriental', 'Timor-Leste (East Timor)'),
(220, 'TG', 'TOGO', 'Togo', 'Togo'),
(221, 'TK', 'TOKE', 'Tokélaou', 'Tokelau'),
(222, 'TO', 'TONG', 'Tonga', 'Tonga'),
(223, 'TT', 'TOBA', 'Trinité-et-Tobago', 'Trinidad & Tobago'),
(224, 'TN', 'TUNI', 'Tunisie', 'Tunisia'),
(225, 'TM', 'TURK', 'Turkménistan', 'Turkmenistan'),
(226, 'TR', 'TURQ', 'Turquie', 'Turkey'),
(227, 'TV', 'TUVA', 'Tuvalu', 'Tuvalu'),
(228, 'UA', 'UKRA', 'Ukraine', 'Ukraine'),
(229, 'UY', 'URUG', 'Uruguay', 'Uruguay'),
(230, 'VU', 'VANU', 'Vanuatu', 'Vanuatu'),
(231, 'VE', 'VENE', 'Venezuela', 'Venezuela'),
(232, 'VN', 'VIET', 'Viêt Nam', 'Viet Nam'),
(233, 'WF', 'WALI', 'Wallis-et-Futuna', 'Wallis and Futuna'),
(234, 'YE', 'YEME', 'Yémen', 'Yemen'),
(235, 'YU', 'YOUG', 'Yougoslavie', 'Saint Pierre and Miquelon'),
(236, 'ZM', 'ZAMB', 'Zambie', 'Zambia'),
(237, 'ZW', 'ZIMB', 'Zimbabwe', 'Zimbabwe'),
(238, 'MK', 'MACE', 'ex-République yougoslave de Macédoine', 'Macedonia, TFYR');

-- --------------------------------------------------------

--
-- Structure de la table `thematique`
--

DROP TABLE IF EXISTS `thematique`;
CREATE TABLE IF NOT EXISTS `thematique` (
  `NumThem` char(8) NOT NULL,
  `LibThem` char(60) DEFAULT NULL,
  `NumLang` char(8) NOT NULL,
  PRIMARY KEY (`NumThem`),
  KEY `THEMATIQUE_FK` (`NumThem`),
  KEY `FK_ASSOCIATION_4` (`NumLang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `thematique`
--

INSERT INTO `thematique` (`NumThem`, `LibThem`, `NumLang`) VALUES
('THE0101', 'Coronavirus', 'FRAN01'),
('THE0102', 'Vin', 'FRAN01'),
('THE0103', 'L&eacute;gendes', 'FRAN01'),
('THE0104', 'Confidence', 'FRAN01'),
('THE0105', 'Pr&eacute;nom', 'FRAN01'),
('THE0106', 'Moutons', 'FRAN01');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `Login` char(30) NOT NULL,
  `Pass` char(255) NOT NULL,
  `LastName` char(30) DEFAULT NULL,
  `FirstName` char(30) DEFAULT NULL,
  `EMail` char(50) NOT NULL,
  PRIMARY KEY (`Login`,`Pass`),
  KEY `USER_FK` (`Login`,`Pass`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`Login`, `Pass`, `LastName`, `FirstName`, `EMail`) VALUES
('Admin', '$2y$10$3N11..NaiD13gEHyi7/xnOU4F6g7S0tkUYvLYg3fyU2WsqIkGuq06', 'Administrateur', 'Administrateur', 'sami.lepays@gmail.com'),
('Anouska_irlandaise', '$2y$10$qNLa2OgNL.f/Tg10DEeYvu83tY4Kc3cdmhrDwiDgnw89/zEk0.KG.', 'O\'Mullan', 'Anouska', 'anouska.omullan@mmibordeaux.com'),
('Hitsohi', '$2y$10$pbH08FdLktqJIEaZMsvm7uyy.YbsT1VfbDcoVyovNjor6guqyR2yC', 'Quillevere', 'Justin', 'justin.quillevere@mmibordeaux.com'),
('Lucas_pastis', '$2y$10$T5fCo/5sgu95iCXVoCTVruW5CQa3oki/lS7kTKN4lemYyueyfN.g2', 'Marsalle', 'Lucas', 'lucas.marsalle@mmibordeaux.com'),
('Marc la coc', '$2y$10$fxMkKAhAFHYxUiVOE2zxfu34Q7jD56TCSvWQQLZNjqpRd2dcjI7YC', 'Lacault', 'Marc', 'marc.lacault@mmibordeaux.com'),
('NeoxAzrot', '$2y$10$rGu8hYdTAtZIOnR3ipPmYeAYpGgpC6dktvg8voix99.jAOq.SVmuu', 'Lafrance', 'Sami', 'sami.lafrance@mmibordeaux.com'),
('NiyesNino', '$2y$10$QfC2KQzgs5e0G8Udulij0OAenyuDNvxp26/kwq6nZmObkPCZHtkyi', 'Mansencal', 'Nino', 'nino.mansencal@mmibordeaux.com');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `angle`
--
ALTER TABLE `angle`
  ADD CONSTRAINT `FK_ASSOCIATION_6` FOREIGN KEY (`NumLang`) REFERENCES `langue` (`NumLang`);

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `FK_ASSOCIATION_1` FOREIGN KEY (`NumAngl`) REFERENCES `angle` (`NumAngl`),
  ADD CONSTRAINT `FK_ASSOCIATION_2` FOREIGN KEY (`NumThem`) REFERENCES `thematique` (`NumThem`),
  ADD CONSTRAINT `FK_ASSOCIATION_3` FOREIGN KEY (`NumLang`) REFERENCES `langue` (`NumLang`);

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `FK_ASSOCIATION_7` FOREIGN KEY (`NumArt`) REFERENCES `article` (`NumArt`);

--
-- Contraintes pour la table `motcle`
--
ALTER TABLE `motcle`
  ADD CONSTRAINT `FK_ASSOCIATION_5` FOREIGN KEY (`NumLang`) REFERENCES `langue` (`NumLang`);

--
-- Contraintes pour la table `motclearticle`
--
ALTER TABLE `motclearticle`
  ADD CONSTRAINT `FK_MotCleArt1` FOREIGN KEY (`NumMoCle`) REFERENCES `motcle` (`NumMoCle`),
  ADD CONSTRAINT `FK_MotCleArt2` FOREIGN KEY (`NumArt`) REFERENCES `article` (`NumArt`);

--
-- Contraintes pour la table `thematique`
--
ALTER TABLE `thematique`
  ADD CONSTRAINT `FK_ASSOCIATION_4` FOREIGN KEY (`NumLang`) REFERENCES `langue` (`NumLang`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
