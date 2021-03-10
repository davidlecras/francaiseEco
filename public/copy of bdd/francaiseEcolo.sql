-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Mar 10, 2021 at 01:46 PM
-- Server version: 5.7.32
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `francaiseEcolo`
--

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`id`, `user_id`, `name`, `firstname`, `lastname`, `compagny`, `address`, `postcode`, `city`, `country`, `phone`) VALUES
(1, 1, 'Dom', 'David', 'Lecras', NULL, '30 Bis, Avenue De Ceinture', '95880', 'Enghien-les-Bains', 'FR', '0768173470');

--
-- Dumping data for table `carousel_header`
--

INSERT INTO `carousel_header` (`id`, `title`, `content`, `btn_title`, `btn_url`, `image`, `link_is_inactive`) VALUES
(1, 'La Française écolo-mode', '<div>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</div>', '100% écolo, 100% française', '/la-boutique', '1ad5081ffb4a06af2c01533648157dc92922997a.jpg', 0),
(2, 'Prochainement: une boutique homme', '<div>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</div>', '100%homme, 100% écolo-gentleman', '#', 'fd87c97665f77c3af87f452752dfeffbb5dfd6dc.jpg', 1);

--
-- Dumping data for table `carrier`
--

INSERT INTO `carrier` (`id`, `name`, `description`, `price`) VALUES
(1, 'Chronopost', 'Livraison sous 48 heures maximum', 1299),
(2, 'Colissimo', 'Livraison en 3-4 jours ouvrés.', 399);

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Écharpes'),
(2, 'T-shirts'),
(3, 'Manteaux'),
(4, 'Bonnets');

--
-- Dumping data for table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20210310130735', '2021-03-10 13:07:43', 470);

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id`, `user_id`, `created_at`, `carrier_name`, `carrier_price`, `delivery`, `is_paid`, `reference`, `stripe_session_id`) VALUES
(1, 1, '2021-03-10 13:32:43', 'Colissimo', 399, 'David Lecras</br>0768173470</br>30 Bis, Avenue De Ceinture</br>95880 Enghien-les-Bains</br>France', 1, '10032021-6048ca7bc8d83', 'cs_test_b1dZbLApgyefQcBwbrg0FWU5rHUMpLm7hQlcV2hZb05nB2sONlyIUv3isK');

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `my_order_id`, `product`, `quantity`, `price`, `total`) VALUES
(1, 1, 'Écharpe en lin', 1, 7299, 7299);

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `category_id`, `name`, `slug`, `image`, `subtitle`, `description`, `prix`, `is_best`) VALUES
(1, 4, 'Bonnet Rouge', 'bonnet-rouge', 'e50d5a9a6e9777c9e4166d6bd7cda99760c7520b.jpg', 'Quand il neige', '<div>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.&nbsp;<br>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>', 3299, 1),
(2, 4, 'Bonnet Breton', 'bonnet-breton', '7c4c019d443ca08c25565e8ec6c594b3430bd35a.jpg', 'Idéal avec une galette', '<div>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. <br><strong>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. </strong><br>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>', 3299, 0),
(3, 3, 'Manteau gris', 'manteau-gris', 'fe8423681efe42893484b5ab3dbcdd69e9cc3ac1.jpg', 'Classic is vintage', '<div>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>', 19999, 1),
(4, 3, 'Veste en denim', 'veste-en-denim', '7c0a1c09b06c6b549de97a7699c6722d9a2b5a72.jpg', 'Denim de Nime', '<div>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>', 15999, 0),
(5, 1, 'Écharpe chaude', 'echarpe-chaude', '5fd12db3bf1928003a7ac51883ebdfd366cd1887.jpg', 'Quand tu as froid', '<div>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>', 4299, 0),
(6, 1, 'Écharpe en lin', 'echarpe-en-lin', '0cb4d03d4ea31ed74e13c7c8d8efb474a6cf11c9.jpg', 'Le lin c\'est divin', '<div>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.&nbsp;<br>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>', 7299, 1),
(7, 2, 'T-shirt noir', 't-shirt-noir', '2201fc2a33c6a0649e33eb32960a783da4d45a57.jpg', 'Française in black', '<div>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>', 3299, 1),
(8, 2, 'T-shirt basic blanc', 't-shirt-basic-blanc', '6a719d86a14a3f5b75e0f278c1af89a4064c62b2.jpg', 'White is the new black', '<div>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>', 1799, 0);

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `firstname`, `lastname`) VALUES
(1, 'admin@gmail.com', '[\"ROLE_ADMIN\"]', '$argon2id$v=19$m=65536,t=4,p=1$eTMGPZ/tS8dph8D7IdQVxQ$2Um0UfIMsnmHfhfxvF/5No3Ps3Q4CqWVeG5JqbWmlyI', 'Admin', 'Admin');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
