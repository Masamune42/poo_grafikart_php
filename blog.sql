SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `blog`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

DROP TABLE IF EXISTS `articles`;
CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) DEFAULT NULL,
  `contenu` longtext DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`id`, `titre`, `contenu`, `date`, `category_id`) VALUES
(2, 'Mon titre', 'Remember, a Jedi can feel the Force flowing through him. No! Alderaan is peaceful. We have no weapons. You can\'t possibly… Dantooine. They\'re on Dantooine. She must have hidden the plans in the escape pod. Send a detachment down to retrieve them, and see to it personally, Commander. There\'ll be no one to stop us this time!', '2020-11-07 11:18:28', 1),
(1, 'Mon titre', 'I want to come with you to Alderaan. There\'s nothing for me here now. I want to learn the ways of the Force and be a Jedi, like my father before me. I don\'t know what you\'re talking about. I am a member of the Imperial Senate on a diplomatic mission to Alderaan', '2020-11-07 11:15:06', 2),
(3, 'Mon titre', 'You mean it controls your actions? But with the blast shield down, I can\'t even see! How am I supposed to fight? I can\'t get involved! I\'ve got work to do! It\'s not that I like the Empire, I hate it, but there\'s nothing I can do about it right now. It\'s such a long way from here.', '2020-11-07 11:18:30', 2);

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `titre`) VALUES
(1, 'Piscine'),
(2, 'Longboard');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
