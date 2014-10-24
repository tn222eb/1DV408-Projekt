-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 24 okt 2014 kl 01:23
-- Serverversion: 5.6.15-log
-- PHP-version: 5.5.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databas: `logindb`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `answer`
--

CREATE TABLE IF NOT EXISTS `answer` (
  `AnswerId` int(11) NOT NULL AUTO_INCREMENT,
  `AnswerA` varchar(60) NOT NULL,
  `AnswerB` varchar(60) NOT NULL,
  `AnswerC` varchar(60) NOT NULL,
  `RightAnswer` varchar(5) NOT NULL,
  `QuestionId` int(11) NOT NULL,
  PRIMARY KEY (`AnswerId`),
  KEY `QuestionId` (`QuestionId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=50 ;

--
-- Dumpning av Data i tabell `answer`
--

INSERT INTO `answer` (`AnswerId`, `AnswerA`, `AnswerB`, `AnswerC`, `RightAnswer`, `QuestionId`) VALUES
(3, 'Kai Greene', 'Mamdouh Elssbiay', 'Dennis Wolf', 'A', 3),
(4, 'Frank Zane', 'Lou Ferrigno', 'Arnold Schwarzenegger', 'C', 4),
(5, 'Ronnie Coleman', 'Dexter Jackson', 'Jay Cutler', 'A', 5),
(6, 'Arnold Schwarzenegger', 'Lou Ferrigno', 'Franco Columbu', 'B', 6),
(19, 'Dennis Wolf', 'Kai Greene', 'Phil Heath', 'C', 22),
(22, 'Judas Priest', 'Iron Maiden', 'Pearl Jam', 'C', 27),
(23, 'TvÃ¤ttmaskin', 'GunghÃ¤st', 'DocksÃ¤ng', 'A', 28),
(24, 'LÃ¶nen som procentandel av landets samlade privata inkomst', 'LÃ¶n efter skatt, bidrag och avdrag', 'LÃ¶nens kÃ¶pkraft i fÃ¶rhÃ¥llande till konsumentpriserna', 'C', 29),
(25, '1960-talet', '1980-talet', '1990-talet', 'B', 30),
(26, 'Pilgrimsfalk', 'HavsÃ¶rn', 'Varg', 'A', 31),
(27, 'Grekisk', 'Tysk', 'IrlÃ¤nsk', 'C', 32),
(28, 'Sid Meier', 'Tim Berners-Lee', 'Linus Torvalds', 'B', 33),
(29, 'Do Mainstream', 'Direct Message', 'Delete Message', 'B', 34),
(30, 'En akronym fÃ¶r Unlimited Resources of Learning', 'Adressen pÃ¥ en fil med www', 'Ett datorprogram', 'B', 35),
(31, 'Den ena Ã¤r sÃ¤krare Ã¤n det andra', 'Det ena kan Ã¶vervakas, det kan inte det andra', 'Den ena Ã¤r offentlig, den andra privat', 'C', 36),
(32, 'Hitta vÃ¤nner', 'Lyssna pÃ¥ musik', 'Kolla pÃ¥ bilder', 'B', 39),
(33, 'Nintendo GameCube', 'Nintendo DS', 'Nintendo Wii', 'C', 40),
(34, 'Google.com', 'Altavista.com', 'Dmoz.org', 'C', 41),
(35, 'Hypertext Transer Protocol Secure', 'High Task Termination Procedure Save', 'Hyper Transfer of Text Procedures Savely', 'A', 42),
(36, '1985', '1981', '1976', 'C', 43),
(37, 'New York', 'San Fransisco', 'Philadelphia', 'C', 44),
(38, 'Berlin', 'London', 'Chicago', 'A', 45),
(39, 'Peter Weir', 'Lasse HallstrÃ¶m', 'Bille August', 'B', 46),
(40, 'Keira Knightley', 'Alice Evans', 'Heather Mills', 'A', 47),
(41, '6', '3', '7', 'A', 48),
(42, 'Norge', 'Danmark', 'Sverige', 'C', 49),
(43, 'Anakin', 'Gandalf', 'Sam', 'A', 50),
(44, 'Micke och Molle', 'Timon och Pumba', 'Tim och Tumba', 'B', 51),
(45, 'Ronnie Coleman', 'Flex Wheeler', 'Dorian Yates', 'A', 54);

-- --------------------------------------------------------

--
-- Tabellstruktur `question`
--

CREATE TABLE IF NOT EXISTS `question` (
  `QuestionId` int(11) NOT NULL AUTO_INCREMENT,
  `QuestionName` varchar(150) NOT NULL,
  `QuizId` int(11) NOT NULL,
  PRIMARY KEY (`QuestionId`),
  UNIQUE KEY `QuestionName` (`QuestionName`),
  KEY `QuizId` (`QuizId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=73 ;

--
-- Dumpning av Data i tabell `question`
--

INSERT INTO `question` (`QuestionId`, `QuestionName`, `QuizId`) VALUES
(3, 'Vem kallas The Predator', 3),
(4, 'Vem kallas The Oak', 3),
(5, 'Vem vann Mr Olympia 2003', 3),
(6, 'Vem spelade Hulken i TV-Serien Den otrolige Hulken', 3),
(22, 'Vem vann Mr Olympia 2014', 3),
(27, 'Vilket band stod pÃ¥ scen under 2010-Ã¥rs Roskildefestival dÃ¥ nio mÃ¤nniskor klÃ¤mdes ihjÃ¤l', 6),
(28, 'Vad av fÃ¶ljande saker hÃ¶r inte hemma i ett barnrum', 6),
(29, 'Vad fÃ¶rstÃ¥r man med reallÃ¶n', 6),
(30, 'Under vilket Ã¥rtionde hade Nik Kershaw sin storhetstid', 6),
(31, 'Vilket djur Ã¤r symbol fÃ¶r NaturskyddsfÃ¶reningen', 6),
(32, 'Vilken nationalitet hade fÃ¶rfattaren James Joyce', 6),
(33, 'Vem uppfann World Wide Web', 7),
(34, 'Vad betyder uttrycket "DM" som anvÃ¤nds pÃ¥ den sociala nÃ¤tverkstjÃ¤nsten Twitter', 7),
(35, 'Vad Ã¤r en URL', 7),
(36, 'Vad Ã¤r skillnaden mellan Internet och intranÃ¤t', 7),
(39, 'Vad kunde man huvudsakligen gÃ¶ra pÃ¥ webbplatsen MySpace dÃ¥ den lanserades Ã¥r 2003', 7),
(40, 'Vilken spelkonsol lanserades av Nintendo Ã¥r 2006 och Ã¤r kÃ¤nd fÃ¶r sina interaktiva sportspel', 7),
(41, 'Vad kom internetkatalogen directory.mozilla.org senare att heta', 7),
(42, 'FÃ¶r betyder fÃ¶rkortningen "https" som ibland stÃ¥r skriven framfÃ¶r en webbadress', 7),
(43, 'Vilket Ã¥r grundades Apple', 6),
(44, 'I vilken stad utspelar sig "Rocky"-filmerna med Sylvester Stallone i huvudrollen', 8),
(45, 'I vilken stad utspelar sig Bob Fosses film "Cabaret" frÃ¥n Ã¥r 1972', 8),
(46, 'I filmen "Chocolat" frÃ¥n Ã¥r 2000 medverkar bland annat Johnny Depp, men vem regisserade denna film', 8),
(47, 'Vem Ã¤r den brittiska skÃ¥despelerskan som gÃ¶r rollen som Elisabeth Swann i "Pirates of the Caribbean"', 8),
(48, 'I hur mÃ¥nga James Bond-filmer har Sean Connery gjort huvudrollen som Agent 007', 8),
(49, 'FrÃ¥n vilket land kommer regissÃ¶ren Ingmar Bergman', 8),
(50, 'Vem av fÃ¶ljande karaktÃ¤rer Ã¤r inte med i Sagan om ringen-trilogin', 8),
(51, 'Vad heter Simbas vÃ¤nner i den tecknade filmen "Lejonkungen"', 8),
(54, 'Vem Ã¤r kÃ¤nd fÃ¶r detta citatet "Everybody wants to be a bodybuilder, but don''t nobody wanna lift no heavy ass weights"', 3);

-- --------------------------------------------------------

--
-- Tabellstruktur `quiz`
--

CREATE TABLE IF NOT EXISTS `quiz` (
  `QuizId` int(11) NOT NULL AUTO_INCREMENT,
  `QuizName` varchar(60) NOT NULL,
  PRIMARY KEY (`QuizId`),
  UNIQUE KEY `QuizName` (`QuizName`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumpning av Data i tabell `quiz`
--

INSERT INTO `quiz` (`QuizId`, `QuizName`) VALUES
(6, 'Blandat'),
(3, 'Bodybuilding'),
(7, 'Datorer och Internet'),
(8, 'Film');

-- --------------------------------------------------------

--
-- Tabellstruktur `results`
--

CREATE TABLE IF NOT EXISTS `results` (
  `ResultId` int(11) NOT NULL AUTO_INCREMENT,
  `Result` int(11) NOT NULL,
  `NumberOfQuestions` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `QuizId` int(11) NOT NULL,
  PRIMARY KEY (`ResultId`),
  KEY `QuizId` (`QuizId`),
  KEY `UserId` (`UserId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=111 ;

--
-- Dumpning av Data i tabell `results`
--

INSERT INTO `results` (`ResultId`, `Result`, `NumberOfQuestions`, `UserId`, `QuizId`) VALUES
(110, 0, 8, 4, 7);

-- --------------------------------------------------------

--
-- Tabellstruktur `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `UserId` int(11) NOT NULL AUTO_INCREMENT,
  `Username` varchar(40) NOT NULL,
  `Hash` varchar(255) NOT NULL,
  `IsAdmin` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`UserId`),
  UNIQUE KEY `Name` (`Username`),
  KEY `Id` (`UserId`),
  KEY `Id_2` (`UserId`),
  KEY `Id_3` (`UserId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumpning av Data i tabell `user`
--

INSERT INTO `user` (`UserId`, `Username`, `Hash`, `IsAdmin`) VALUES
(2, 'User', '$2a$10$d8pad/DSnUF46GiZCiNnHeVp2B/80LDxTZr65RmUGSCAOPeWV0rX2', 0),
(4, 'Admin', '$2a$10$26T1DvTgDipJ2l3ftUG9HO1NkQDwzkjApiEor2NybDR./LesCj5sG', 1);

--
-- Restriktioner för dumpade tabeller
--

--
-- Restriktioner för tabell `answer`
--
ALTER TABLE `answer`
  ADD CONSTRAINT `answer_ibfk_1` FOREIGN KEY (`QuestionId`) REFERENCES `question` (`QuestionId`) ON DELETE CASCADE;

--
-- Restriktioner för tabell `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `question_ibfk_1` FOREIGN KEY (`QuizId`) REFERENCES `quiz` (`QuizId`) ON DELETE CASCADE;

--
-- Restriktioner för tabell `results`
--
ALTER TABLE `results`
  ADD CONSTRAINT `results_ibfk_1` FOREIGN KEY (`QuizId`) REFERENCES `quiz` (`QuizId`) ON DELETE CASCADE,
  ADD CONSTRAINT `results_ibfk_2` FOREIGN KEY (`UserId`) REFERENCES `user` (`UserId`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
