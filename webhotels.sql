-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Φιλοξενητής: 127.0.0.1:3306
-- Χρόνος δημιουργίας: 13 Ιουν 2021 στις 10:13:38
-- Έκδοση διακομιστή: 5.7.31
-- Έκδοση PHP: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Βάση δεδομένων: `webhotels`
--

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `hotels`
--

DROP TABLE IF EXISTS `hotels`;
CREATE TABLE IF NOT EXISTS `hotels` (
  `hotelid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `businessTitle` varchar(100) NOT NULL,
  `location` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `telephoneNum` varchar(15) NOT NULL,
  `roomsAvailable` int(11) DEFAULT NULL,
  `equipment` set('Πισίνα','Εστιατόριο-Μπαρ','Κινηματογράφος','Γυμναστήριο','Παιδικές Δραστηριότητες') DEFAULT NULL,
  `rating` enum('1','2','3','4','5') DEFAULT NULL,
  `businessEmail` varchar(80) DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `description` text,
  `username_FK` varbinary(30) DEFAULT NULL,
  PRIMARY KEY (`hotelid`),
  KEY `username_fk` (`username_FK`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Άδειασμα δεδομένων του πίνακα `hotels`
--

INSERT INTO `hotels` (`hotelid`, `businessTitle`, `location`, `address`, `telephoneNum`, `roomsAvailable`, `equipment`, `rating`, `businessEmail`, `longitude`, `latitude`, `description`, `username_FK`) VALUES
(4, 'Ξενοδοχείο ΠΑΛΑΣ', 'Κέρκυρα', 'Γκίλφορδ 14', '6956457812', 3, 'Πισίνα', '3', 'palas@mail.com', 19.922632, 39.621274, 'Επισκεφτείτε το ξενοδοχείο μας!', 0x416e6173746173696132),
(5, 'Meteora Hotel', 'Καλαμπάκα', '2nd km. Kalambaka - Ioannina, Kastraki, Kalambaka 422 00', '2432078180', 20, 'Πισίνα,Εστιατόριο-Μπαρ', '4', 'meteroraHotel@mail.com', 21.608002, 39.716606, 'Αυτό το ήσυχο εποχικό ξενοδοχείο, το οποίο έχει θέα στους μονολιθικούς βραχώδεις σχηματισμούς των Μετεώρων, απέχει 3 χλμ. από το Μουσείο Φυσικής Ιστορίας Μετεώρων και Μουσείο Μανιταριών.', 0x616e61737461736961),
(6, 'Lithos by Spyros & Flora', 'Μύκονος', 'Άγιος Ιωάννης', '2281457123', 30, 'Πισίνα,Γυμναστήριο', '5', 'lithos@mail.com', 25.311293, 37.423512, 'Στα δωμάτια υπάρχει ένα κλιματιστικό κι ένα μπάνιο. Ένα μπαλκόνι ανήκει στα στάνταρ των περισσότερων δωματίων και προσφέρει επιπλέον χώρο για ανάπαυση και ξεκούραση κατά τη διαμονή. Η θέα προς τη θάλασσα σε πολλά καταλύμματα δημιουργεί ένα ευχάριστο περιβάλλον.', 0x4c6f75667465726973),
(7, 'ibis Styles Heraklion Central', 'Ηράκλειο', '26 Κορονέου & Αγίου Τίτου ', '235689741', 20, 'Πισίνα,Εστιατόριο-Μπαρ', '4', 'ibis@mail.com', 25.135765, 35.340542, 'Αυτό το χαλαρό ξενοδοχείο, που βρίσκεται στο πολυσύχναστο κέντρο της πόλης, περιβάλλεται από καταστήματα και εστιατόρια και απέχει 1 χλμ. από τον σταθμό φεριμπότ του Ηρακλείου και 4 χλμ. από την παραλία Αμμουδάρα.', 0x6a6f686e),
(8, 'Mythic Valley', 'Λιτόχωρο', 'Βαρδάκα 15', '2352081140', 20, '', '3', 'mythic@mail.com', 22.503139, 40.104588, 'Αυτό το απλό ξενοδοχείο με παράρτημα βρίσκεται σε μια οικιστική περιοχή στους πρόποδες του Ολύμπου και απέχει 5 χλμ. από την Παραλία Μύλος στο Αιγαίο Πέλαγος.', 0x776562686f74656c73),
(11, 'Casa Cook Rhodes', 'Ρόδος', 'Eνωμενης Eυρωπης, Κολύμπια 851 02', '2241056333', 20, 'Πισίνα', '5', 'casa@mail.com', 28.155136, 36.242223, 'Αυτό το κομψό μπουτίκ ξενοδοχείο μόνο για ενήλικες, το οποίο έχει φόντο το βραχώδες τοπίο του καταφυγίου άγριας ζωής \"Παναγιά Τσαμπίκα Ψηλή Δήμου Αρχαγγέλου\", απέχει 9 λεπτά με τα πόδια από την Παραλία Κολύμπια και 29 χλμ. από τον Κρατικό Αερολιμένα Ρόδου \"Διαγόρας\".', 0x7461736f6f6c6168),
(13, 'Volcano View Hotel', 'Σαντορίνη', 'Θήρα', '2286024780', 20, 'Πισίνα,Εστιατόριο-Μπαρ', '4', 'volcanoview@mail.com', 25.438121, 36.394716, 'Αυτό το πολυτελές, σύγχρονο ξενοδοχείο, το οποίο είναι χτισμένο σε στιλ που θυμίζει τα κυκλαδίτικα υπόσκαφα σπίτια, βρίσκεται σε μια τοποθεσία στην κορυφή ενός βράχου και απέχει 2 χλμ. από το Μουσείο Προϊστορικής Θήρας και 9 χλμ. από τον αρχαιολογικό χώρο του Ακρωτηρίου.', 0x706f6c7973),
(14, 'Divani Corfu Palace Hotel', 'Κέρκυρα', 'Ναυσικάς 20', '2661038996', 30, 'Πισίνα,Γυμναστήριο', '4', 'divani@mail.com', 19.921556, 39.598754, 'Αυτό το πολυτελές ξενοδοχείο βρίσκεται σε απόσταση 3 χλμ. από το κέντρο της πόλης και το Αρχαιολογικό Μουσείο Κέρκυρας, ενώ απέχει 1,5 χλμ. από την παραλία Μον Ρεπό.', 0x617468656e61),
(15, 'Grand Forest Metsovo', 'Μέτσοβο', 'Μέτσοβο', '2656300500', 15, 'Πισίνα,Εστιατόριο-Μπαρ', '5', 'forest@mail.com', 21.204602, 39.774819, 'Αυτό το γραφικό ορεινό θέρετρο με θέα την πόλη του Μετσόβου απέχει 25 χλμ. από τους πίνακες στο μουσείο τέχνης Πινακοθήκη Ε. Αβέρωφ και 24 χλμ. από το ορεινό πέρασμα της Κατάρας.', 0x67656f726765),
(16, 'Poseidon Hotel & Spa Paros', 'Πάρος', 'Χρυσή Ακτή', '2284042650', 15, 'Πισίνα,Εστιατόριο-Μπαρ,Γυμναστήριο', '5', 'poseidon@mail.com', 25.244392, 37.009599, NULL, 0x7461736f6f6c61);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `images`
--

DROP TABLE IF EXISTS `images`;
CREATE TABLE IF NOT EXISTS `images` (
  `imageID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `imageName` varchar(150) NOT NULL,
  `description` varchar(50) DEFAULT NULL,
  `type` varchar(5) NOT NULL,
  `user_FK` varbinary(30) NOT NULL,
  `hotel_FK` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`imageID`),
  KEY `user_fk` (`user_FK`),
  KEY `hotel_fk` (`hotel_FK`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8;

--
-- Άδειασμα δεδομένων του πίνακα `images`
--

INSERT INTO `images` (`imageID`, `imageName`, `description`, `type`, `user_FK`, `hotel_FK`) VALUES
(20, 'uploaded-pictures/5/C44D9B82-5264-4478-99FA-0E704691D89C.jpg', '', 'jpg', 0x616e61737461736961, 5),
(21, 'uploaded-pictures/5/546420B3-A753-401C-A4D7-6A8ABE13CDD9.jpg', '', 'jpg', 0x616e61737461736961, 5),
(22, 'uploaded-pictures/5/CA2B0EB9-C8D6-4C49-9712-5647C5046802.jpg', '', 'jpg', 0x616e61737461736961, 5),
(23, 'uploaded-pictures/5/3F5CD407-3BB1-4383-9CF9-5421474F7F3C.jpg', '', 'jpg', 0x616e61737461736961, 5),
(24, 'uploaded-pictures/5/FD115A1B-566A-4A75-8211-E98CCBDED15C.jpg', '', 'jpg', 0x616e61737461736961, 5),
(25, 'uploaded-pictures/5/FEC27356-0BEF-4896-9856-E2AE9E65757C.jpg', '', 'jpg', 0x616e61737461736961, 5),
(26, 'uploaded-pictures/6/8AB9D3C2-3878-4025-BA7A-417033F4BB1F.jpg', '', 'jpg', 0x4c6f75667465726973, 6),
(27, 'uploaded-pictures/6/DE700F4E-14FE-403F-BB8D-0958358A72C5.jpg', '', 'jpg', 0x4c6f75667465726973, 6),
(28, 'uploaded-pictures/6/B09455BD-00F4-4BF8-BE53-E331365511A7.jpg', '', 'jpg', 0x4c6f75667465726973, 6),
(29, 'uploaded-pictures/11/4FE46FD6-8EF7-4770-AAEA-466CBE7DA14C.jpg', '', 'jpg', 0x7461736f6f6c6168, 11),
(30, 'uploaded-pictures/11/7BC16776-5075-48C8-BF29-DD9C86C6B67E.jpg', '', 'jpg', 0x7461736f6f6c6168, 11),
(31, 'uploaded-pictures/11/DC9F38C4-97F1-403D-825F-A69194055BEC.jpg', '', 'jpg', 0x7461736f6f6c6168, 11),
(32, 'uploaded-pictures/11/C5C77E18-317D-4CC0-B59E-5BE5F98DE5F0.jpg', '', 'jpg', 0x7461736f6f6c6168, 11),
(33, 'uploaded-pictures/8/43431080-3108-4DD6-AF8E-310E9E0EB4C4.jpg', 'Εσωτερικό Δωματίου', 'jpg', 0x776562686f74656c73, 8),
(34, 'uploaded-pictures/8/DD7DD03E-917C-462E-B96E-561BA5911140.jpg', '', 'jpg', 0x776562686f74656c73, 8),
(35, 'uploaded-pictures/8/764F387D-F1F1-48C6-827B-381A390AB37E.jpg', 'Εξωτερικό', 'jpg', 0x776562686f74656c73, 8),
(36, 'uploaded-pictures/7/ibis1-min.jpg', '', 'jpg', 0x6a6f686e, 7),
(37, 'uploaded-pictures/7/ibis2-min.jpg', '', 'jpg', 0x6a6f686e, 7),
(38, 'uploaded-pictures/14/divani1-min.jpg', 'Θέα από το ξενοδοχείο', 'jpg', 0x617468656e61, 14),
(39, 'uploaded-pictures/14/divani2-min.jpg', '', 'jpg', 0x617468656e61, 14),
(40, 'uploaded-pictures/14/divani3-min.jpg', 'Δωμάτιο', 'jpg', 0x617468656e61, 14),
(41, 'uploaded-pictures/14/divani4-min.jpg', '', 'jpg', 0x617468656e61, 14),
(42, 'uploaded-pictures/15/metsovo1-min.jpg', 'Θέα', 'jpg', 0x67656f726765, 15),
(43, 'uploaded-pictures/15/metsovo2-min.jpg', 'Πισίνα', 'jpg', 0x67656f726765, 15),
(44, 'uploaded-pictures/15/metsovo3-min.jpg', 'Σαλόνι', 'jpg', 0x67656f726765, 15),
(45, 'uploaded-pictures/16/poseidon-min.jpg', 'Από ψηλά', 'jpg', 0x7461736f6f6c61, 16),
(46, 'uploaded-pictures/16/poseidon2-min.jpg', 'Από ψηλά', 'jpg', 0x7461736f6f6c61, 16),
(47, 'uploaded-pictures/16/poseidon4-min.jpg', 'Δωμάτιο', 'jpg', 0x7461736f6f6c61, 16),
(48, 'uploaded-pictures/13/062DBB02-ECD6-43D6-B5B5-65986017B463.jpg', 'Θέα', 'jpg', 0x706f6c7973, 13),
(49, 'uploaded-pictures/13/34870DD0-4DEB-4BB4-A3C1-7EF30E07723F.jpg', '', 'jpg', 0x706f6c7973, 13),
(50, 'uploaded-pictures/13/29EB9FB0-BB23-42C3-98F0-59D1721AE31B.jpg', '', 'jpg', 0x706f6c7973, 13),
(51, 'uploaded-pictures/13/B8326401-1647-4243-B87A-4209B4BF2165.jpg', '', 'jpg', 0x706f6c7973, 13),
(52, 'uploaded-pictures/13/1A15DE8B-4285-46B4-B04D-FEC4D594E6B2.jpg', '', 'jpg', 0x706f6c7973, 13);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `username` varbinary(50) NOT NULL,
  `password` varbinary(200) NOT NULL,
  `email` varbinary(100) NOT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`username`),
  UNIQUE KEY `email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Άδειασμα δεδομένων του πίνακα `users`
--

INSERT INTO `users` (`username`, `password`, `email`, `verified`) VALUES
(0x416e6173746173696132, 0x2436243336696c69367365306e6d346f736773246141466f4c36576b2f416350422f3045356f6661733074384451702e494e41736c2e6e62732f486b6e67594c614e5663655652776e666d4133394933704f6b6b4847702f416f706d624c736e466c442f35456d2f352e, 0x76616665616469616e40676d61696c2e636f6d, 1),
(0x4c6f75667465726973, 0x243624626b38636f7865363563666e327a6932246b48457a334a52415349493747353142497a653944674f786f337a6c4471327a56536958753653694b6c354e3158774e7667744d4767372f3765692f4e424763663468737878626c664c624e6f537839457037543931, 0x757030726e69726f6e6e6f3140676d61696c2e636f6d, 1),
(0x616e61737461736961, 0x24362477387830727335733770653933626f3524596869346a2f4e564f49516f59556745386959485876664c476e4c746961426b614670347270765367415046574a422f6a78374261325243476d2f566e6a523136613748537a4236317952635346483566764f564f31, 0x616e6163746163696133323640676d61696c2e636f6d, 1),
(0x617468656e61, 0x617468656e613132333435, 0x617468656e61406d61696c2e636f6d, 1),
(0x67656f726765, 0x67656f7267653132333435, 0x67656f726765406d61696c2e636f6d, 1),
(0x6a6f686e, 0x6a6f686e3132333435, 0x6a6f686e406d61696c2e636f6d, 1),
(0x706f6c7973, 0x2436247231337178783367657674327839767024435848634830774f744f3469563361414933715138336d576f4d7648694130794e32696f736e425454755676765168786348654772554c53336b35715574365357676b74745a6a4877466856382e682e2f31726a6730, 0x706f6c79736c616d626f726768696e6940676d61696c2e636f6d, 1),
(0x7461736f6f6c61, 0x77657274793132333435, 0x7461736f6f6c61406d61696c2e636f6d, 1),
(0x7461736f6f6c6168, 0x24362470726934316e3272316b356f396e36722455534a456653346d48626a7161664a466a6477716a596755324471623434757032785050467557533567526a4b393566714e3176773539535543796b7034397044507a6c564b3265582e5350346f2e474f792e53552f, 0x76616665616469406f75746c6f6f6b2e636f6d, 1),
(0x776562686f74656c73, 0x243624616765386639797039326b6574636c792448576f797470354358315765636d52586d6f6f7a313336706f6a364a4c4e4171703149414157376a4e2f496d766a525367306e6f4e4e723356642e73483630375a67677730646a7441542f356d30786b35344d736a31, 0x776562686f74656c7367726565636540676d61696c2e636f6d, 1);

--
-- Περιορισμοί για άχρηστους πίνακες
--

--
-- Περιορισμοί για πίνακα `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_ibfk_1` FOREIGN KEY (`user_FK`) REFERENCES `users` (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
