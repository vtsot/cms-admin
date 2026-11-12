-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql:3306
-- Generation Time: Nov 12, 2026 at 11:49 PM
-- Server version: 8.0.46
-- PHP Version: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms_admin`
--

-- --------------------------------------------------------

--
-- Table structure for table `banner_translations`
--

CREATE TABLE `banner_translations` (
  `id` int NOT NULL,
  `locale` varchar(8) NOT NULL,
  `field` varchar(32) NOT NULL,
  `content` longtext,
  `object_id` binary(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime(6) DEFAULT NULL,
  `execution_time` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20261025205802', '2026-10-25 23:02:30.195025', 7351),
('DoctrineMigrations\\Version20261025205807', '2026-10-25 23:02:37.559481', 18),
('DoctrineMigrations\\Version20261102015338', '2026-11-02 03:54:16.154480', 294),
('DoctrineMigrations\\Version20261102115145', '2026-11-02 13:52:28.256146', 51),
('DoctrineMigrations\\Version20261104120714', '2026-11-04 14:08:33.172139', 332),
('DoctrineMigrations\\Version20261107120349', '2026-11-07 14:37:51.672733', 291);

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` binary(16) NOT NULL,
  `created_at` datetime(6) DEFAULT NULL,
  `updated_at` datetime(6) DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL,
  `method` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `request` text,
  `headers` text,
  `response` text,
  `content` text,
  `payload` text,
  `site_id` binary(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `navigations`
--

CREATE TABLE `navigations` (
  `id` binary(16) NOT NULL,
  `created_at` datetime(6) DEFAULT NULL,
  `updated_at` datetime(6) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT 'main',
  `active` tinyint NOT NULL DEFAULT '1',
  `link_type` varchar(15) DEFAULT NULL,
  `link_url` varchar(255) DEFAULT NULL,
  `link_target` varchar(15) DEFAULT NULL,
  `link_no_follow` tinyint NOT NULL DEFAULT '0',
  `position` int UNSIGNED NOT NULL DEFAULT '0',
  `parent_id` binary(16) DEFAULT NULL,
  `site_id` binary(16) DEFAULT NULL,
  `link_page_id` binary(16) DEFAULT NULL,
  `link_article_id` binary(16) DEFAULT NULL,
  `entity` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `navigations`
--

INSERT INTO `navigations` (`id`, `created_at`, `updated_at`, `title`, `type`, `active`, `link_type`, `link_url`, `link_target`, `link_no_follow`, `position`, `parent_id`, `site_id`, `link_page_id`, `link_article_id`, `entity`) VALUES
(0x01a19eb3449f71ebae06203fe7239e6d, '2026-11-03 01:58:31.070959', '2026-11-04 22:46:29.701672', 'menu-external follow', 'main', 1, 'link', 'https://example.com', '_blank', 0, 2, NULL, 0x01a174e093a37d359d6f349894ea976c, NULL, NULL, 'main'),
(0x01a19eb35997740d982015ab67888e65, '2026-11-03 01:58:36.439132', '2026-11-04 22:46:33.733371', 'menu-external no follow', 'main', 1, 'link', 'https://example.com?no-follow', '_blank', 1, 3, NULL, 0x01a174e093a37d359d6f349894ea976c, NULL, NULL, 'main'),
(0x01a19eb36bf57d14ab21e18805889d37, '2026-11-03 01:58:41.141694', '2026-11-04 22:46:38.346836', 'menu-page-1', 'main', 1, 'page', NULL, '_top', 0, 4, NULL, 0x01a174e093a37d359d6f349894ea976c, 0x01a17ef8873e70ad94d5f53dd9f43e48, NULL, 'main'),
(0x01a19eb3ae827df0b2c499522c55d639, '2026-11-03 01:58:58.178754', '2026-11-03 01:58:58.178757', 'menu-2-1', 'main', 1, 'link', NULL, '_top', 0, 0, 0x01a19eb35997740d982015ab67888e65, 0x01a174e093a37d359d6f349894ea976c, NULL, NULL, 'main'),
(0x01a19eb3bbf274949b1d31d45b7e96c7, '2026-11-03 01:59:01.618169', '2026-11-03 01:59:01.618172', 'menu-2-2', 'main', 1, 'link', NULL, '_top', 0, 0, 0x01a19eb35997740d982015ab67888e65, 0x01a174e093a37d359d6f349894ea976c, NULL, NULL, 'main'),
(0x01a19eb3cc8d7db7a3cc68c94892bfc1, '2026-11-03 01:59:05.869752', '2026-11-03 01:59:05.869755', 'menu-2-3', 'main', 1, 'link', NULL, '_top', 0, 0, 0x01a19eb35997740d982015ab67888e65, 0x01a174e093a37d359d6f349894ea976c, NULL, NULL, 'main'),
(0x01a19ebab3e87eb8a6bd624d79f10467, '2026-11-03 02:06:38.312795', '2026-11-03 02:06:38.312799', 'menu-2-2-1', 'main', 1, 'link', NULL, '_top', 0, 0, 0x01a19eb3bbf274949b1d31d45b7e96c7, 0x01a174e093a37d359d6f349894ea976c, NULL, NULL, 'main'),
(0x01a19ebabcab7da196f9465cff1a0418, '2026-11-03 02:06:40.555793', '2026-11-04 21:34:29.319961', 'menu-2-2-2', 'main', 1, 'page', NULL, '_top', 0, 0, 0x01a19eb3bbf274949b1d31d45b7e96c7, 0x01a174e093a37d359d6f349894ea976c, 0x01a17ef8a7a2713190fc0c922bf5e5ea, NULL, 'main'),
(0x01a19ebaea887437a0adba4ce67eae84, '2026-11-03 02:06:52.296111', '2026-11-04 22:00:27.425958', 'menu-2-2-3 artile-2', 'main', 1, 'article', NULL, '_top', 0, 0, 0x01a19eb3bbf274949b1d31d45b7e96c7, 0x01a174e093a37d359d6f349894ea976c, NULL, 0x01a17ef9356170c994dbccbfa4f95769, 'main'),
(0x01a1a78a077f75228e4b1feabf1db29e, '2026-11-04 19:10:03.391220', '2026-11-04 22:46:42.206095', 'menu-article-1', 'main', 1, 'article', NULL, '_top', 0, 5, NULL, 0x01a174e093a37d359d6f349894ea976c, NULL, 0x01a174eb64f974b0ae10521dcf34fa94, 'main'),
(0x01a1a85006327311886610dbdeabe5ac, '2026-11-04 22:46:19.186053', '2026-11-04 22:46:25.468036', 'homepage', 'main', 1, 'page', NULL, '_top', 0, 1, NULL, 0x01a174e093a37d359d6f349894ea976c, 0x01a174e093b47f619f76725c5b8368cc, NULL, 'main');

-- --------------------------------------------------------

--
-- Table structure for table `navigation_translations`
--

CREATE TABLE `navigation_translations` (
  `id` int NOT NULL,
  `locale` varchar(8) NOT NULL,
  `field` varchar(32) NOT NULL,
  `content` longtext,
  `object_id` binary(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `navigation_translations`
--

INSERT INTO `navigation_translations` (`id`, `locale`, `field`, `content`, `object_id`) VALUES
(1, 'uk_UA', 'title', 'Ukraine title', 0x01a19ebabcab7da196f9465cff1a0418),
(2, 'uk_UA', 'title', 'menu title Ukrainian (Ukraine)', 0x01a19eb3449f71ebae06203fe7239e6d);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` binary(16) NOT NULL,
  `created_at` datetime(6) DEFAULT NULL,
  `updated_at` datetime(6) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_keywords` varchar(1000) DEFAULT NULL,
  `meta_description` varchar(1000) DEFAULT NULL,
  `og_title` varchar(255) DEFAULT NULL,
  `og_description` longtext,
  `homepage` tinyint NOT NULL DEFAULT '0',
  `active` tinyint NOT NULL DEFAULT '1',
  `slug` varchar(255) DEFAULT NULL,
  `og_image` longtext,
  `is_indexed` tinyint NOT NULL DEFAULT '1',
  `sitemap_change_frequency` varchar(255) NOT NULL DEFAULT 'weekly',
  `sitemap_priority` double NOT NULL DEFAULT '0.5',
  `redirect` varchar(255) DEFAULT NULL,
  `code_block` text,
  `sources` text,
  `site_id` binary(16) DEFAULT NULL,
  `entity` varchar(255) NOT NULL,
  `related_articles_title` varchar(255) DEFAULT NULL,
  `description` text,
  `image_alt` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `created_at`, `updated_at`, `title`, `content`, `meta_title`, `meta_keywords`, `meta_description`, `og_title`, `og_description`, `homepage`, `active`, `slug`, `og_image`, `is_indexed`, `sitemap_change_frequency`, `sitemap_priority`, `redirect`, `code_block`, `sources`, `site_id`, `entity`, `related_articles_title`, `description`, `image_alt`, `image`) VALUES
(0x01a174e093b47f619f76725c5b8368cc, '2026-10-25 23:03:57.364942', '2026-11-04 21:54:38.896061', 'Welcome homepage', '<p>Content&nbsp;homepage</p>', 'Meta title homepage', 'Meta keywords homepage', 'Meta description homepage', 'Og title homepage', 'Og description homepage', 1, 1, 'homepage', NULL, 1, 'always', 0.5, NULL, 'Code block homepage', '<p>Sources&nbsp;homepage</p>', 0x01a174e093a37d359d6f349894ea976c, 'page', 'Related Articles Title homepage', NULL, NULL, NULL),
(0x01a174eb64f974b0ae10521dcf34fa94, '2026-10-25 23:15:46.297094', '2026-11-04 21:53:47.231265', 'article-1', '<p>Content</p>', 'Meta title', 'Meta keywords', 'Meta description', 'Og title', 'Og description', 0, 1, 'article-1', NULL, 1, 'monthly', 0.5, NULL, 'Code block', '<p>Sources</p>', 0x01a174e093a37d359d6f349894ea976c, 'article', NULL, '<p>Short Description</p>', 'Image Alt', '01a1a72c-835d-7d4d-9766-5b8454e2bea4.jpg'),
(0x01a17ef8873e70ad94d5f53dd9f43e48, '2026-10-27 22:06:19.195240', '2026-11-04 18:09:01.135765', 'page-1', '<p>Content</p>', 'Meta title', 'Meta keywords', 'Meta description', 'Og title', 'Og description', 0, 1, 'page-1', NULL, 1, 'always', 0.5, NULL, 'Code block', '<p>Sources</p>', 0x01a174e093a37d359d6f349894ea976c, 'page', 'Related Articles Title', NULL, NULL, NULL),
(0x01a17ef8a7a2713190fc0c922bf5e5ea, '2026-10-27 22:06:27.489948', '2026-11-04 21:53:47.231671', 'page-2', '<p>Content&nbsp;page-2</p>', 'Meta title  page-2', 'Meta keywords  page-2', 'Meta description  page-2', 'Og title  page-2', 'Og description  page-2', 0, 1, 'page-2', NULL, 1, 'always', 0.5, NULL, 'Code block  page-2', '<p>Sources&nbsp;page-2</p>', 0x01a174e093a37d359d6f349894ea976c, 'page', 'Related Articles Title page-2', NULL, NULL, NULL),
(0x01a17ef8c0cd732b8e905b43cd4d5ed7, '2026-10-27 22:06:33.933078', '2026-10-27 22:06:33.933080', 'page-3', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 'page-3', NULL, 1, 'always', 0.5, NULL, NULL, NULL, 0x01a174e093a37d359d6f349894ea976c, 'page', NULL, NULL, NULL, NULL),
(0x01a17ef9356170c994dbccbfa4f95769, '2026-10-27 22:07:03.776516', '2026-11-04 22:48:31.226127', 'article-2', '<p>Content</p>', 'Meta title', 'Meta keywords', 'Meta description', 'Og title', 'Og description', 0, 1, 'article-2', NULL, 1, 'always', 0.5, NULL, 'Code block', '<p>Sources</p>', 0x01a174e093a37d359d6f349894ea976c, 'article', NULL, '<p>Short Description</p>', 'Image Alt', '01a1a852-09f9-71a7-9fea-34d5db953004.png'),
(0x01a17ef9604272e08f5f225630b976a9, '2026-10-27 22:07:14.754028', '2026-10-27 22:16:19.750606', 'article-3', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 'article-3', NULL, 1, 'always', 0.5, NULL, NULL, NULL, 0x01a174e093a37d359d6f349894ea976c, 'article', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `page_related_articles`
--

CREATE TABLE `page_related_articles` (
  `id` binary(16) NOT NULL,
  `created_at` datetime(6) DEFAULT NULL,
  `updated_at` datetime(6) DEFAULT NULL,
  `active` tinyint NOT NULL DEFAULT '1',
  `position` int UNSIGNED NOT NULL DEFAULT '0',
  `page_id` binary(16) DEFAULT NULL,
  `article_id` binary(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `page_related_articles`
--

INSERT INTO `page_related_articles` (`id`, `created_at`, `updated_at`, `active`, `position`, `page_id`, `article_id`) VALUES
(0x01a1a75225c6773aab85afe63c1f111f, '2026-11-04 18:09:01.126298', '2026-11-04 18:09:01.126300', 1, 0, 0x01a17ef8873e70ad94d5f53dd9f43e48, 0x01a174eb64f974b0ae10521dcf34fa94),
(0x01a1a75225c677ceab85afe63c7a7093, '2026-11-04 18:09:01.126490', '2026-11-04 18:09:01.126492', 1, 0, 0x01a17ef8873e70ad94d5f53dd9f43e48, 0x01a17ef9356170c994dbccbfa4f95769),
(0x01a1a75225c6781eab85afe63d16c0be, '2026-11-04 18:09:01.126513', '2026-11-04 18:09:01.126514', 1, 0, 0x01a17ef8873e70ad94d5f53dd9f43e48, 0x01a17ef9604272e08f5f225630b976a9),
(0x01a1a765b96e789bb572e90dc76e3a2a, '2026-11-04 18:30:24.110387', '2026-11-04 18:30:24.110389', 1, 0, 0x01a174e093b47f619f76725c5b8368cc, 0x01a174eb64f974b0ae10521dcf34fa94),
(0x01a1a765b96e7937b572e90dc7f1c9d5, '2026-11-04 18:30:24.110580', '2026-11-04 18:30:24.110581', 1, 0, 0x01a174e093b47f619f76725c5b8368cc, 0x01a17ef9356170c994dbccbfa4f95769),
(0x01a1a765b96e798bb572e90dc8866ebb, '2026-11-04 18:30:24.110604', '2026-11-04 18:30:24.110605', 1, 0, 0x01a174e093b47f619f76725c5b8368cc, 0x01a17ef9604272e08f5f225630b976a9),
(0x01a1a81feddb7699b4e69d9da9c3aa1c, '2026-11-04 21:53:47.227261', '2026-11-04 21:53:47.227263', 1, 0, 0x01a17ef8a7a2713190fc0c922bf5e5ea, 0x01a174eb64f974b0ae10521dcf34fa94),
(0x01a1a81feddb7739b4e69d9da9cfd968, '2026-11-04 21:53:47.227453', '2026-11-04 21:53:47.227454', 1, 0, 0x01a17ef8a7a2713190fc0c922bf5e5ea, 0x01a17ef9356170c994dbccbfa4f95769),
(0x01a1a81feddb7791b4e69d9da9defda4, '2026-11-04 21:53:47.227477', '2026-11-04 21:53:47.227478', 1, 0, 0x01a17ef8a7a2713190fc0c922bf5e5ea, 0x01a17ef9604272e08f5f225630b976a9);

-- --------------------------------------------------------

--
-- Table structure for table `page_translations`
--

CREATE TABLE `page_translations` (
  `id` int NOT NULL,
  `locale` varchar(8) NOT NULL,
  `field` varchar(32) NOT NULL,
  `content` longtext,
  `object_id` binary(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `page_translations`
--

INSERT INTO `page_translations` (`id`, `locale`, `field`, `content`, `object_id`) VALUES
(1, 'uk_UA', 'title', 'стаття-1', 0x01a174eb64f974b0ae10521dcf34fa94),
(2, 'uk_UA', 'title', 'стаття-2', 0x01a17ef9356170c994dbccbfa4f95769),
(3, 'uk_UA', 'title', 'стаття-3', 0x01a17ef9604272e08f5f225630b976a9),
(4, 'ru_UA', 'title', 'статья-1', 0x01a174eb64f974b0ae10521dcf34fa94),
(5, 'ru_UA', 'title', 'статья-2', 0x01a17ef9356170c994dbccbfa4f95769),
(6, 'ru_UA', 'title', 'статья-3', 0x01a17ef9604272e08f5f225630b976a9),
(7, 'de_DE', 'title', 'Artikel-1', 0x01a174eb64f974b0ae10521dcf34fa94),
(8, 'de_DE', 'title', 'Artikel-2', 0x01a17ef9356170c994dbccbfa4f95769),
(9, 'de_DE', 'title', 'Artikel-3', 0x01a17ef9604272e08f5f225630b976a9);

-- --------------------------------------------------------

--
-- Table structure for table `refresh_tokens`
--

CREATE TABLE `refresh_tokens` (
  `refresh_token` varchar(128) NOT NULL,
  `username` varchar(255) NOT NULL,
  `valid` datetime(6) NOT NULL,
  `family` varchar(32) DEFAULT NULL,
  `family_valid` datetime(6) DEFAULT NULL,
  `id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sites`
--

CREATE TABLE `sites` (
  `id` binary(16) NOT NULL,
  `created_at` datetime(6) DEFAULT NULL,
  `updated_at` datetime(6) DEFAULT NULL,
  `domain` varchar(255) NOT NULL,
  `token` varchar(40) DEFAULT NULL,
  `active` tinyint NOT NULL DEFAULT '1',
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `registrar_email` varchar(255) DEFAULT NULL,
  `registrar_name` varchar(255) DEFAULT NULL,
  `registered_at` datetime(6) DEFAULT NULL,
  `expire_at` datetime(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sites`
--

INSERT INTO `sites` (`id`, `created_at`, `updated_at`, `domain`, `token`, `active`, `title`, `description`, `registrar_email`, `registrar_name`, `registered_at`, `expire_at`) VALUES
(0x01a174e093a37d359d6f349894ea976c, '2026-10-25 23:03:57.345719', '2026-11-02 19:06:46.124888', 'https://cms-client.local', 'f57513b7377507d7420ba364def607df4b53b29b', 1, 'vacancy-grabber', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `site_banners`
--

CREATE TABLE `site_banners` (
  `id` binary(16) NOT NULL,
  `created_at` datetime(6) DEFAULT NULL,
  `updated_at` datetime(6) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `image_alt` varchar(255) DEFAULT NULL,
  `desktop_image` varchar(255) DEFAULT NULL,
  `mobile_image` varchar(255) DEFAULT NULL,
  `active` tinyint NOT NULL DEFAULT '1',
  `priority` int UNSIGNED NOT NULL DEFAULT '0',
  `link_type` varchar(15) DEFAULT NULL,
  `link_url` varchar(255) DEFAULT NULL,
  `link_target` varchar(15) DEFAULT NULL,
  `link_no_follow` tinyint NOT NULL DEFAULT '0',
  `site_id` binary(16) DEFAULT NULL,
  `link_page_id` binary(16) DEFAULT NULL,
  `link_article_id` binary(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `site_banners`
--

INSERT INTO `site_banners` (`id`, `created_at`, `updated_at`, `title`, `image_alt`, `desktop_image`, `mobile_image`, `active`, `priority`, `link_type`, `link_url`, `link_target`, `link_no_follow`, `site_id`, `link_page_id`, `link_article_id`) VALUES
(0x01a197644f8e7937bb3715767ad801bb, '2026-11-01 15:54:56.004228', '2026-11-01 15:54:56.014570', 'title', 'Image Alt', '01a19764-4f86-7f51-9c8d-4538a8d18563.png', '01a19764-4f8d-7f77-b224-93847a705416.jpg', 1, 0, 'link', 'https://example.com', '_blank', 0, 0x01a174e093a37d359d6f349894ea976c, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `site_contacts`
--

CREATE TABLE `site_contacts` (
  `id` binary(16) NOT NULL,
  `site_id` binary(16) DEFAULT NULL,
  `context` json DEFAULT NULL,
  `created_at` datetime(6) DEFAULT NULL,
  `updated_at` datetime(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `site_contacts`
--

INSERT INTO `site_contacts` (`id`, `site_id`, `context`, `created_at`, `updated_at`) VALUES
(0x01a1b60439687ebc91fa824749939957, 0x01a174e093a37d359d6f349894ea976c, '{\"name\": \"name\", \"email\": \"email@example.com\", \"message\": \"message\"}', '2026-11-07 14:38:12.583966', '2026-11-07 14:38:12.583970'),
(0x01a1b60464267aa989c38de48d16335c, 0x01a174e093a37d359d6f349894ea976c, '{\"name\": \"name\", \"email\": \"email@example.com\", \"message\": \"message\"}', '2026-11-07 14:38:23.526406', '2026-11-07 14:38:23.526410'),
(0x01a1b604691f7b519855062cb05727b7, 0x01a174e093a37d359d6f349894ea976c, '{\"name\": \"name\", \"email\": \"email@example.com\", \"message\": \"message\"}', '2026-11-07 14:38:24.799540', '2026-11-07 14:38:24.799543'),
(0x01a1b7f867c37843b37dc1a3216ee108, 0x01a174e093a37d359d6f349894ea976c, '{\"name\": \"name\", \"email\": \"email@example.com\", \"message\": \"message\"}', '2026-11-07 23:44:32.451361', '2026-11-07 23:44:32.451363'),
(0x01a1b82722b17c67ab3954c4b31684a1, 0x01a174e093a37d359d6f349894ea976c, '{\"name\": \"name\", \"email\": \"email@example.com\", \"message\": \"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit animi id est laborum.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit animi id est laborum.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit animi id est laborum.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit animi id est laborum.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit animi id est laborum.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit animi id est laborum.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit animi id est laborum.\"}', '2026-11-08 00:35:34.959375', '2026-11-08 00:35:34.959378'),
(0x01a1b827311575f3b2b382a8463123fd, 0x01a174e093a37d359d6f349894ea976c, '{\"name\": \"name\", \"email\": \"email@example.com\", \"message\": \"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit animi id est laborum.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit animi id est laborum.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit animi id est laborum.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit animi id est laborum.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit animi id est laborum.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit animi id est laborum.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit animi id est laborum.\"}', '2026-11-08 00:35:38.645223', '2026-11-08 00:35:38.645225'),
(0x01a1b827378f7400aea08baebe4e961c, 0x01a174e093a37d359d6f349894ea976c, '{\"name\": \"name\", \"email\": \"email@example.com\", \"message\": \"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit animi id est laborum.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit animi id est laborum.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit animi id est laborum.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit animi id est laborum.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit animi id est laborum.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit animi id est laborum.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit animi id est laborum.\"}', '2026-11-08 00:35:40.303127', '2026-11-08 00:35:40.303130'),
(0x01a1b8273c7878de8254d802623feda4, 0x01a174e093a37d359d6f349894ea976c, '{\"name\": \"name\", \"email\": \"email@example.com\", \"message\": \"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit animi id est laborum.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit animi id est laborum.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit animi id est laborum.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit animi id est laborum.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit animi id est laborum.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit animi id est laborum.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit animi id est laborum.\"}', '2026-11-08 00:35:41.560410', '2026-11-08 00:35:41.560413');

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` binary(16) NOT NULL,
  `created_at` datetime(6) DEFAULT NULL,
  `updated_at` datetime(6) DEFAULT NULL,
  `favicon` varchar(255) DEFAULT NULL,
  `image_alt` varchar(255) DEFAULT NULL,
  `desktop_image` varchar(255) DEFAULT NULL,
  `mobile_image` varchar(255) DEFAULT NULL,
  `sender_name` varchar(255) DEFAULT NULL,
  `sender_email` varchar(255) DEFAULT NULL,
  `from_name` varchar(255) DEFAULT NULL,
  `from_email` varchar(255) DEFAULT NULL,
  `site_id` binary(16) DEFAULT NULL,
  `api_log_enabled` tinyint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `created_at`, `updated_at`, `favicon`, `image_alt`, `desktop_image`, `mobile_image`, `sender_name`, `sender_email`, `from_name`, `from_email`, `site_id`, `api_log_enabled`) VALUES
(0x01a174e093a37f059d6f3498952e0f72, '2026-10-25 23:03:57.347886', '2026-11-04 14:09:27.537437', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0x01a174e093a37d359d6f349894ea976c, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` binary(16) NOT NULL,
  `created_at` datetime(6) DEFAULT NULL,
  `updated_at` datetime(6) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `active` tinyint NOT NULL DEFAULT '1',
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `is_google_authenticator_enabled` tinyint NOT NULL DEFAULT '0',
  `google_authenticator_token` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `roles` json NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `created_at`, `updated_at`, `email`, `active`, `first_name`, `last_name`, `is_google_authenticator_enabled`, `google_authenticator_token`, `password`, `roles`) VALUES
(0x01a174df5bfc70df89c24e60f19fdc64, '2026-10-25 21:02:37.000000', '2026-10-28 03:28:43.275919', 'super-admin@example.com', 1, NULL, NULL, 0, NULL, '$2y$13$UbJK5a4z6hPBNO3PP4TFQ.aXBGMC1wn5r5f9GFKFbWBAMloPWyl4C', '[\"ROLE_SUPERVISOR\"]'),
(0x01a1801f586077e0aa70d8600088540d, '2026-10-28 03:28:19.960490', '2026-11-02 13:39:52.139473', 'regular@example.com', 1, 'regular', NULL, 0, NULL, '$2y$13$tL6YLe/CULCABRO9KVS0ZepMEytqaB0sZyTTfZJvBgf371DXj99Sq', '[\"ROLE_USER\"]'),
(0x01a18039eb4e764ea1aa848d5b2ba54c, '2026-10-28 03:57:21.431206', '2026-11-02 03:58:36.917075', 'user@example.com', 1, NULL, NULL, 0, NULL, '$2y$13$0rsydHSScn9qcJNAFkePGuzLqe87Z.BaByBDEhF.6OfZ/WYJNziCK', '[\"ROLE_USER\"]'),
(0x01a19b9db88d78ce8ef8f3a767094ccf, '2026-11-02 11:36:06.605131', '2026-11-02 11:36:06.605138', 'user2@example.com', 1, 'User2', NULL, 0, NULL, '$2y$13$r20TyvS//d01BooKDSzre.T1Qu2Ai.d3xNkf9ny4jX8vVH6PKSWwi', '[\"ROLE_USER\"]'),
(0x01a19bf661377d76af2dbc887a5b298d, '2026-11-02 13:12:57.313598', '2026-11-08 00:49:50.536787', 'admin@example.com', 1, 'admin', NULL, 0, NULL, '$2y$13$01nbeQQ7qvC4uZvor1MnMeg/Bf8raVSEhWXefRIGrFahSlnwmV/bm', '[\"ROLE_ADMIN\"]'),
(0x01a19dc1c17d74c8bd9add5eb232aada, '2026-11-02 21:34:42.993737', '2026-11-08 00:50:06.282832', 'manager@example.com', 1, 'manager', NULL, 0, NULL, '$2y$13$A.CbR3Dv8ZLkUH3j/0RuPeQSJ.WR3bjpPtQhLir5uCmezZ6nqLiuK', '[\"ROLE_SITE_MANAGER\"]');

-- --------------------------------------------------------

--
-- Table structure for table `user_clients`
--

CREATE TABLE `user_clients` (
  `user_id` binary(16) NOT NULL,
  `site_id` binary(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_clients`
--

INSERT INTO `user_clients` (`user_id`, `site_id`) VALUES
(0x01a1801f586077e0aa70d8600088540d, 0x01a174e093a37d359d6f349894ea976c),
(0x01a18039eb4e764ea1aa848d5b2ba54c, 0x01a174e093a37d359d6f349894ea976c);

-- --------------------------------------------------------

--
-- Table structure for table `user_sites`
--

CREATE TABLE `user_sites` (
  `user_id` binary(16) NOT NULL,
  `site_id` binary(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_sites`
--

INSERT INTO `user_sites` (`user_id`, `site_id`) VALUES
(0x01a174df5bfc70df89c24e60f19fdc64, 0x01a174e093a37d359d6f349894ea976c),
(0x01a1801f586077e0aa70d8600088540d, 0x01a174e093a37d359d6f349894ea976c),
(0x01a19bf661377d76af2dbc887a5b298d, 0x01a174e093a37d359d6f349894ea976c),
(0x01a19dc1c17d74c8bd9add5eb232aada, 0x01a174e093a37d359d6f349894ea976c);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banner_translations`
--
ALTER TABLE `banner_translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_locale_object_field` (`locale`,`object_id`,`field`),
  ADD KEY `IDX_F8B8D8B232D562B` (`object_id`);

--
-- Indexes for table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_id` (`id`),
  ADD KEY `fk_site_id` (`site_id`),
  ADD KEY `idx_created_at` (`created_at`),
  ADD KEY `idx_updated_at` (`updated_at`);

--
-- Indexes for table `navigations`
--
ALTER TABLE `navigations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_id` (`id`),
  ADD KEY `idx_parent_id` (`parent_id`),
  ADD KEY `fk_link_page` (`link_page_id`),
  ADD KEY `fk_link_article` (`link_article_id`),
  ADD KEY `idx_active` (`active`),
  ADD KEY `fk_site_id` (`site_id`),
  ADD KEY `idx_created_at` (`created_at`),
  ADD KEY `idx_updated_at` (`updated_at`);

--
-- Indexes for table `navigation_translations`
--
ALTER TABLE `navigation_translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_locale_object_field` (`locale`,`object_id`,`field`),
  ADD KEY `IDX_DC8810C6232D562B` (`object_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_id` (`id`),
  ADD UNIQUE KEY `uniq_site_slug` (`slug`,`site_id`),
  ADD KEY `fk_site_id` (`site_id`),
  ADD KEY `idx_active` (`active`),
  ADD KEY `idx_homepage` (`homepage`),
  ADD KEY `idx_created_at` (`created_at`),
  ADD KEY `idx_updated_at` (`updated_at`);

--
-- Indexes for table `page_related_articles`
--
ALTER TABLE `page_related_articles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_id` (`id`),
  ADD KEY `fk_page_id` (`page_id`),
  ADD KEY `fk_article_id` (`article_id`),
  ADD KEY `idx_active` (`active`),
  ADD KEY `idx_created_at` (`created_at`),
  ADD KEY `idx_updated_at` (`updated_at`);

--
-- Indexes for table `page_translations`
--
ALTER TABLE `page_translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_locale_object_field` (`locale`,`object_id`,`field`),
  ADD KEY `IDX_78AB76C9232D562B` (`object_id`);

--
-- Indexes for table `refresh_tokens`
--
ALTER TABLE `refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_9BACE7E1C74F2195` (`refresh_token`);

--
-- Indexes for table `sites`
--
ALTER TABLE `sites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_domain` (`domain`),
  ADD UNIQUE KEY `uniq_id` (`id`),
  ADD UNIQUE KEY `uniq_token` (`token`),
  ADD KEY `idx_active` (`active`),
  ADD KEY `idx_registrar_email` (`registrar_email`),
  ADD KEY `idx_registered_at` (`registered_at`),
  ADD KEY `idx_expire_at` (`expire_at`),
  ADD KEY `idx_created_at` (`created_at`),
  ADD KEY `idx_updated_at` (`updated_at`);

--
-- Indexes for table `site_banners`
--
ALTER TABLE `site_banners`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_id` (`id`),
  ADD KEY `fk_site_id` (`site_id`),
  ADD KEY `idx_active` (`active`),
  ADD KEY `fk_link_page` (`link_page_id`),
  ADD KEY `fk_link_article_id` (`link_article_id`),
  ADD KEY `idx_created_at` (`created_at`),
  ADD KEY `idx_updated_at` (`updated_at`);

--
-- Indexes for table `site_contacts`
--
ALTER TABLE `site_contacts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_id` (`id`),
  ADD KEY `fk_site_id` (`site_id`),
  ADD KEY `idx_created_at` (`created_at`),
  ADD KEY `idx_updated_at` (`updated_at`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_id` (`id`),
  ADD UNIQUE KEY `UNIQ_E9081F1FF6BD1646` (`site_id`),
  ADD KEY `fk_site_id` (`site_id`),
  ADD KEY `idx_created_at` (`created_at`),
  ADD KEY `idx_updated_at` (`updated_at`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_email` (`email`),
  ADD UNIQUE KEY `uniq_id` (`id`),
  ADD KEY `idx_active` (`active`),
  ADD KEY `idx_google_authenticator_enabled` (`is_google_authenticator_enabled`),
  ADD KEY `idx_google_authenticator_token` (`google_authenticator_token`),
  ADD KEY `idx_created_at` (`created_at`),
  ADD KEY `idx_updated_at` (`updated_at`);

--
-- Indexes for table `user_clients`
--
ALTER TABLE `user_clients`
  ADD PRIMARY KEY (`user_id`,`site_id`),
  ADD KEY `IDX_58C5307EA76ED395` (`user_id`),
  ADD KEY `IDX_58C5307EF6BD1646` (`site_id`);

--
-- Indexes for table `user_sites`
--
ALTER TABLE `user_sites`
  ADD PRIMARY KEY (`user_id`,`site_id`),
  ADD KEY `IDX_5EC2513BA76ED395` (`user_id`),
  ADD KEY `IDX_5EC2513BF6BD1646` (`site_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banner_translations`
--
ALTER TABLE `banner_translations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `navigation_translations`
--
ALTER TABLE `navigation_translations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `page_translations`
--
ALTER TABLE `page_translations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `refresh_tokens`
--
ALTER TABLE `refresh_tokens`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=720;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `banner_translations`
--
ALTER TABLE `banner_translations`
  ADD CONSTRAINT `FK_F8B8D8B232D562B` FOREIGN KEY (`object_id`) REFERENCES `site_banners` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `FK_F08FC65CF6BD1646` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `navigations`
--
ALTER TABLE `navigations`
  ADD CONSTRAINT `FK_AD21D8F3251E4669` FOREIGN KEY (`link_article_id`) REFERENCES `pages` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `FK_AD21D8F371203911` FOREIGN KEY (`link_page_id`) REFERENCES `pages` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `FK_AD21D8F3727ACA70` FOREIGN KEY (`parent_id`) REFERENCES `navigations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_AD21D8F3F6BD1646` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `navigation_translations`
--
ALTER TABLE `navigation_translations`
  ADD CONSTRAINT `FK_DC8810C6232D562B` FOREIGN KEY (`object_id`) REFERENCES `navigations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pages`
--
ALTER TABLE `pages`
  ADD CONSTRAINT `FK_2074E575F6BD1646` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `page_related_articles`
--
ALTER TABLE `page_related_articles`
  ADD CONSTRAINT `FK_785937197294869C` FOREIGN KEY (`article_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_78593719C4663E4` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `page_translations`
--
ALTER TABLE `page_translations`
  ADD CONSTRAINT `FK_78AB76C9232D562B` FOREIGN KEY (`object_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `site_banners`
--
ALTER TABLE `site_banners`
  ADD CONSTRAINT `FK_DEABC7A3251E4669` FOREIGN KEY (`link_article_id`) REFERENCES `pages` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `FK_DEABC7A371203911` FOREIGN KEY (`link_page_id`) REFERENCES `pages` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `FK_DEABC7A3F6BD1646` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `site_contacts`
--
ALTER TABLE `site_contacts`
  ADD CONSTRAINT `FK_B7C604F3F6BD1646` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD CONSTRAINT `FK_E9081F1FF6BD1646` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_clients`
--
ALTER TABLE `user_clients`
  ADD CONSTRAINT `FK_58C5307EA76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_58C5307EF6BD1646` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_sites`
--
ALTER TABLE `user_sites`
  ADD CONSTRAINT `FK_5EC2513BA76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_5EC2513BF6BD1646` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
