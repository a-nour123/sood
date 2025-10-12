-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 22, 2023 at 08:18 AM
-- Server version: 10.6.7-MariaDB
-- PHP Version: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `grc_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `actions`
--

CREATE TABLE `actions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `actions`
--

INSERT INTO `actions` (`id`, `name`) VALUES
(1, 'vulnerability_add'),
(3, 'vulnerability_delete'),
(2, 'vulnerability_update');

-- --------------------------------------------------------

--
-- Table structure for table `answer_sub_questions`
--

CREATE TABLE `answer_sub_questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `answer_id` bigint(20) UNSIGNED NOT NULL,
  `question_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assessments`
--

CREATE TABLE `assessments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assessments`
--

INSERT INTO `assessments` (`id`, `name`, `created`) VALUES
(3, 'test', '2023-08-22 06:16:08');

-- --------------------------------------------------------

--
-- Table structure for table `assessment_answers`
--

CREATE TABLE `assessment_answers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `assessment_id` bigint(20) UNSIGNED NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `submit_risk` tinyint(1) NOT NULL DEFAULT 0,
  `risk_subject` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `risk_score` double(8,2) NOT NULL,
  `assessment_scoring_id` bigint(20) UNSIGNED NOT NULL,
  `risk_owner` int(11) DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 999999
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assessment_answers_to_assets`
--

CREATE TABLE `assessment_answers_to_assets` (
  `assessment_answer_id` bigint(20) UNSIGNED NOT NULL,
  `asset_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assessment_answers_to_asset_groups`
--

CREATE TABLE `assessment_answers_to_asset_groups` (
  `assessment_answer_id` bigint(20) UNSIGNED NOT NULL,
  `asset_group_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assessment_questions`
--

CREATE TABLE `assessment_questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `assessment_id` bigint(20) UNSIGNED NOT NULL,
  `question` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int(11) NOT NULL DEFAULT 999999
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assessment_scorings`
--

CREATE TABLE `assessment_scorings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `scoring_method` int(11) NOT NULL,
  `calculated_risk` double(8,2) NOT NULL,
  `CLASSIC_likelihood` double(8,2) NOT NULL DEFAULT 5.00,
  `CLASSIC_impact` double(8,2) NOT NULL DEFAULT 5.00,
  `CVSS_AccessVector` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `CVSS_AccessComplexity` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'L',
  `CVSS_Authentication` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `CVSS_ConfImpact` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'C',
  `CVSS_IntegImpact` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'C',
  `CVSS_AvailImpact` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'C',
  `CVSS_Exploitability` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ND',
  `CVSS_RemediationLevel` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ND',
  `CVSS_ReportConfidence` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ND',
  `CVSS_CollateralDamagePotential` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ND',
  `CVSS_TargetDistribution` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ND',
  `CVSS_ConfidentialityRequirement` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ND',
  `CVSS_IntegrityRequirement` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ND',
  `CVSS_AvailabilityRequirement` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ND',
  `DREAD_DamagePotential` int(11) NOT NULL DEFAULT 10,
  `DREAD_Reproducibility` int(11) NOT NULL DEFAULT 10,
  `DREAD_Exploitability` int(11) NOT NULL DEFAULT 10,
  `DREAD_AffectedUsers` int(11) NOT NULL DEFAULT 10,
  `DREAD_Discoverability` int(11) NOT NULL DEFAULT 10,
  `OWASP_SkillLevel` int(11) NOT NULL DEFAULT 10,
  `OWASP_Motive` int(11) NOT NULL DEFAULT 10,
  `OWASP_Opportunity` int(11) NOT NULL DEFAULT 10,
  `OWASP_Size` int(11) NOT NULL DEFAULT 10,
  `OWASP_EaseOfDiscovery` int(11) NOT NULL DEFAULT 10,
  `OWASP_EaseOfExploit` int(11) NOT NULL DEFAULT 10,
  `OWASP_Awareness` int(11) NOT NULL DEFAULT 10,
  `OWASP_IntrusionDetection` int(11) NOT NULL DEFAULT 10,
  `OWASP_LossOfConfidentiality` int(11) NOT NULL DEFAULT 10,
  `OWASP_LossOfIntegrity` int(11) NOT NULL DEFAULT 10,
  `OWASP_LossOfAvailability` int(11) NOT NULL DEFAULT 10,
  `OWASP_LossOfAccountability` int(11) NOT NULL DEFAULT 10,
  `OWASP_FinancialDamage` int(11) NOT NULL DEFAULT 10,
  `OWASP_ReputationDamage` int(11) NOT NULL DEFAULT 10,
  `OWASP_NonCompliance` int(11) NOT NULL DEFAULT 10,
  `OWASP_PrivacyViolation` int(11) NOT NULL DEFAULT 10,
  `Custom` double(8,2) NOT NULL DEFAULT 10.00,
  `Contributing_Likelihood` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assessment_scoring_contributing_impacts`
--

CREATE TABLE `assessment_scoring_contributing_impacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `assessment_scoring_id` bigint(20) UNSIGNED NOT NULL,
  `contributing_risk_id` bigint(20) UNSIGNED NOT NULL,
  `impact` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE `assets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ip` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `asset_value_id` bigint(20) UNSIGNED NOT NULL,
  `location_id` bigint(20) UNSIGNED DEFAULT NULL,
  `teams` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `verified` tinyint(4) NOT NULL DEFAULT 0,
  `start_date` date DEFAULT NULL,
  `expiration_date` date DEFAULT NULL,
  `alert_period` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assets`
--

INSERT INTO `assets` (`id`, `ip`, `name`, `asset_value_id`, `location_id`, `teams`, `details`, `created`, `verified`, `start_date`, `expiration_date`, `alert_period`) VALUES
(1, '127.0.0.1', 'Asset1', 8, 1, '1,4', 'Details asset 1', '2019-07-01 08:32:43', 1, '0000-00-00', '0000-00-00', 30),
(2, '127.0.0.2', 'Asset2', 10, 2, '1,4', 'Details asset 2', '2019-07-01 08:32:43', 1, '0000-00-00', '0000-00-00', 30),
(3, '127.0.0.3', 'Asset3', 3, 3, '1,4', 'Details asset 3', '2019-07-01 08:32:43', 1, '0000-00-00', '0000-00-00', 30),
(4, '127.0.0.4', 'Asset4', 1, 4, '1,4', 'Details asset 4', '2019-07-01 08:32:43', 1, '0000-00-00', '0000-00-00', 30),
(5, '127.0.0.5', 'Asset5', 10, 5, '1,4', 'Details asset 5', '2019-07-01 08:32:43', 1, '0000-00-00', '0000-00-00', 30),
(6, '127.0.0.6', 'Asset6', 9, 6, '1,4', 'Details asset 6', '2019-07-01 08:32:43', 1, '0000-00-00', '0000-00-00', 30),
(7, '127.0.0.7', 'Asset7', 7, 7, '1,4', 'Details asset 7', '2019-07-01 08:32:43', 1, '0000-00-00', '0000-00-00', 30),
(8, '127.0.0.8', 'Asset8', 5, 8, '1,4', 'Details asset 8', '2019-07-01 08:32:43', 1, '0000-00-00', '0000-00-00', 30),
(9, '127.0.0.9', 'Asset9', 9, 9, '1,4', 'Details asset 9', '2019-07-01 08:32:43', 1, '0000-00-00', '0000-00-00', 30),
(10, '127.0.0.10', 'Asset10', 9, 10, '1,4', 'Details asset 10', '2019-07-01 08:32:43', 1, '0000-00-00', '0000-00-00', 30),
(11, '127.0.0.11', 'Asset11', 9, 11, '1,4', 'Details asset 11', '2019-07-01 08:32:43', 1, '0000-00-00', '0000-00-00', 30),
(12, '127.0.0.12', 'Asset12', 5, 12, '1,4', 'Details asset 12', '2019-07-01 08:32:43', 1, '0000-00-00', '0000-00-00', 30),
(13, '127.0.0.13', 'Asset13', 9, 13, '1,4', 'Details asset 13', '2019-07-01 08:32:43', 1, '0000-00-00', '0000-00-00', 30),
(14, '127.0.0.14', 'Asset14', 10, 14, '1,4', 'Details asset 14', '2019-07-01 08:32:43', 1, '0000-00-00', '0000-00-00', 30),
(15, '127.0.0.15', 'Asset15', 6, 15, '1,4', 'Details asset 15', '2019-07-01 08:32:43', 1, '0000-00-00', '0000-00-00', 30),
(16, '127.0.0.16', 'Asset16', 9, 16, '1,4', 'Details asset 16', '2019-07-01 08:32:43', 1, '0000-00-00', '0000-00-00', 30),
(17, '127.0.0.17', 'Asset17', 4, 17, '1,4', 'Details asset 17', '2019-07-01 08:32:43', 1, '0000-00-00', '0000-00-00', 30),
(18, '127.0.0.18', 'Asset18', 8, 18, '1,4', 'Details asset 18', '2019-07-01 08:32:43', 1, '0000-00-00', '0000-00-00', 30),
(19, '127.0.0.19', 'Asset19', 1, 19, '1,4', 'Details asset 19', '2019-07-01 08:32:43', 1, '0000-00-00', '0000-00-00', 30),
(20, '127.0.0.20', 'Asset20', 6, 20, '1,4', 'Details asset 20', '2019-07-01 08:32:43', 1, '0000-00-00', '0000-00-00', 30),
(21, NULL, 'ERP system', 2, 1, NULL, NULL, '2023-07-13 10:49:11', 1, '2023-07-13', '2023-07-31', 10),
(22, '127.0.0.56', 'Asset1112', 1, 1, '1', 'wq', '2023-08-21 19:27:06', 1, '2023-08-21', '2023-08-23', 1);

-- --------------------------------------------------------

--
-- Table structure for table `assets_asset_groups`
--

CREATE TABLE `assets_asset_groups` (
  `asset_id` bigint(20) UNSIGNED NOT NULL,
  `asset_group_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `asset_asset_groups`
--

CREATE TABLE `asset_asset_groups` (
  `asset_id` bigint(20) UNSIGNED NOT NULL,
  `asset_group_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `asset_asset_groups`
--

INSERT INTO `asset_asset_groups` (`asset_id`, `asset_group_id`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 8),
(9, 9),
(10, 10),
(11, 11),
(12, 12),
(13, 13),
(14, 14),
(15, 15),
(16, 16),
(17, 17),
(18, 18),
(19, 19),
(20, 20),
(21, 21);

-- --------------------------------------------------------

--
-- Table structure for table `asset_groups`
--

CREATE TABLE `asset_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `asset_groups`
--

INSERT INTO `asset_groups` (`id`, `name`) VALUES
(1, 'Asset Group 1'),
(10, 'Asset Group 10'),
(11, 'Asset Group 11'),
(12, 'Asset Group 12'),
(13, 'Asset Group 13'),
(14, 'Asset Group 14'),
(15, 'Asset Group 15'),
(16, 'Asset Group 16'),
(17, 'Asset Group 17'),
(18, 'Asset Group 18'),
(19, 'Asset Group 19'),
(2, 'Asset Group 2'),
(20, 'Asset Group 20'),
(3, 'Asset Group 3'),
(4, 'Asset Group 4'),
(5, 'Asset Group 5'),
(6, 'Asset Group 6'),
(7, 'Asset Group 7'),
(8, 'Asset Group 8'),
(9, 'Asset Group 9'),
(21, 'S.W');

-- --------------------------------------------------------

--
-- Table structure for table `asset_values`
--

CREATE TABLE `asset_values` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `min_value` int(11) NOT NULL,
  `max_value` int(11) DEFAULT NULL,
  `valuation_level_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `asset_values`
--

INSERT INTO `asset_values` (`id`, `min_value`, `max_value`, `valuation_level_name`) VALUES
(1, 0, 100000, ''),
(2, 100001, 200000, ''),
(3, 200001, 300000, ''),
(4, 300001, 400000, ''),
(5, 400001, 500000, ''),
(6, 500001, 600000, ''),
(7, 600001, 700000, ''),
(8, 700001, 800000, ''),
(9, 800001, 900000, ''),
(10, 900001, 1000000, '');

-- --------------------------------------------------------

--
-- Table structure for table `asset_vulnerabilities`
--

CREATE TABLE `asset_vulnerabilities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `asset_id` bigint(20) UNSIGNED NOT NULL,
  `vulnerability_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `asset_vulnerabilities`
--

INSERT INTO `asset_vulnerabilities` (`id`, `asset_id`, `vulnerability_id`) VALUES
(1, 1, 1),
(2, 10, 1),
(3, 1, 2),
(4, 4, 2),
(5, 6, 2),
(6, 8, 2),
(7, 11, 2),
(8, 12, 2),
(9, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `risk_id` int(11) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `message` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `log_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'This is table name'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `audit_logs`
--

INSERT INTO `audit_logs` (`timestamp`, `risk_id`, `user_id`, `message`, `log_type`) VALUES
('2023-07-05 12:42:46', 1, 1, 'A new risk ID \"1001\" was submitted by username \"Admin\".', 'risk'),
('2023-07-05 12:42:46', 2, 1, 'A new risk ID \"1002\" was submitted by username \"Admin\".', 'risk'),
('2023-07-05 12:42:46', 3, 1, 'A new risk ID \"1003\" was submitted by username \"Admin\".', 'risk'),
('2023-07-05 12:42:46', 4, 1, 'A new risk ID \"1004\" was submitted by username \"Admin\".', 'risk'),
('2023-07-05 12:42:46', 5, 1, 'A new risk ID \"1005\" was submitted by username \"Admin\".', 'risk'),
('2023-07-05 12:42:46', 6, 1, 'A new risk ID \"1006\" was submitted by username \"Admin\".', 'risk'),
('2023-07-05 12:42:46', 7, 1, 'A new risk ID \"1007\" was submitted by username \"Admin\".', 'risk'),
('2023-07-05 12:42:46', 8, 1, 'A new risk ID \"1008\" was submitted by username \"Admin\".', 'risk'),
('2023-07-05 12:42:46', 9, 1, 'A new risk ID \"1009\" was submitted by username \"Admin\".', 'risk'),
('2023-07-05 12:42:46', 10, 1, 'A new risk ID \"1010\" was submitted by username \"Admin\".', 'risk'),
('2023-07-05 12:42:46', 11, 1, 'A new risk ID \"1011\" was submitted by username \"Admin\".', 'risk'),
('2023-07-05 12:42:46', 12, 1, 'A new risk ID \"1012\" was submitted by username \"Admin\".', 'risk'),
('2023-07-05 12:42:46', 13, 1, 'A new risk ID \"1013\" was submitted by username \"Admin\".', 'risk'),
('2023-07-05 12:42:46', 14, 1, 'A new risk ID \"1014\" was submitted by username \"Admin\".', 'risk'),
('2023-07-05 12:42:46', 15, 1, 'A new risk ID \"1015\" was submitted by username \"Admin\".', 'risk'),
('2023-07-05 12:42:46', 16, 1, 'A new risk ID \"1016\" was submitted by username \"Admin\".', 'risk'),
('2023-07-05 12:42:46', 17, 1, 'A new risk ID \"1017\" was submitted by username \"Admin\".', 'risk'),
('2023-07-05 12:42:46', 18, 1, 'A new risk ID \"1018\" was submitted by username \"Admin\".', 'risk'),
('2023-07-05 12:42:46', 19, 1, 'A new risk ID \"1019\" was submitted by username \"Admin\".', 'risk'),
('2023-07-05 12:42:46', 20, 1, 'A new risk ID \"1020\" was submitted by username \"Admin\".', 'risk'),
('2023-07-05 12:42:46', 21, 1, 'A new risk ID \"1021\" was submitted by username \"Admin\".', 'risk'),
('2023-07-05 12:42:46', 22, 1, 'A new risk ID \"1022\" was submitted by username \"Admin\".', 'risk'),
('2023-07-05 12:42:46', 23, 1, 'A new risk ID \"1023\" was submitted by username \"Admin\".', 'risk'),
('2023-07-05 12:42:46', 24, 1, 'A new risk ID \"1024\" was submitted by username \"Admin\".', 'risk'),
('2023-07-05 12:42:46', 25, 1, 'A new risk ID \"1025\" was submitted by username \"Admin\".', 'risk'),
('2023-07-05 13:52:06', 1, 1, 'User \"Admin\" Initiate Audit', 'App\\Models\\FrameworkControlTestAudit'),
('2023-07-05 13:59:59', 1, 1, 'Risk details were updated for risk ID \"1001\" by username \"Admin\".\nField name : `regulation` (``=>`NCA-ECC – 1: 2018`), Field name : `control` (` ()`=>`ECC 1-1-2 (ECC 1-1-2)`), Field name : `template_group` (`1`=>`0`)', 'risk'),
('2023-07-05 14:00:44', 1, 1, 'A mitigation was submitted for risk ID \"1001\" by username \"Admin\".', 'risk'),
('2023-07-13 13:49:11', 21, 1, 'An asset named \"ERP system\" was added by username \"Admin\".', 'asset'),
('2023-07-13 13:49:47', 21, 1, 'User \"Admin\" created Asset Group \"S.W\"(ID:1021) with initial assets of \"ERP system\".', 'asset_group'),
('2023-07-13 13:50:27', 1, 1, 'Risk details were updated for risk ID \"1001\" by username \"Admin\".\n', 'risk'),
('2023-08-07 11:21:24', 2, 1, 'User \"Admin\" Initiate Audit', 'App\\Models\\FrameworkControlTestAudit'),
('2023-08-07 11:21:24', 3, 1, 'User \"Admin\" Initiate Audit', 'App\\Models\\FrameworkControlTestAudit'),
('2023-08-07 11:21:24', 4, 1, 'User \"Admin\" Initiate Audit', 'App\\Models\\FrameworkControlTestAudit'),
('2023-08-07 11:21:24', 5, 1, 'User \"Admin\" Initiate Audit', 'App\\Models\\FrameworkControlTestAudit'),
('2023-08-07 11:33:28', 5, 1, 'User \"Admin\" update Audits. Changes: {`test result` (``=>`Implemented`), `summary` (``=>`test`), `test date` (`0000-00-00`=>`2023-08-08`)}.', 'App\\Models\\FrameworkControlTestAudit'),
('2023-08-07 11:34:36', 26, 1, 'A new risk ID \"1026\" was submitted by username \"Admin\".', 'risk'),
('2023-08-10 11:23:22', 1, 1, 'A vulnerability named \"test\" was added by username \"Admin\".', 'vulnerability'),
('2023-08-20 17:27:30', 2, 2, 'Risk details were updated for risk ID \"1002\" by username \"مدير الرئيس التنفيذى\".\nField name : `source` (`System`=>`People`), Field name : `template_group` (`1`=>`0`)', 'risk'),
('2023-08-20 17:36:24', 1, 1, 'A system notification setting with message \"\" was added by username \"Admin\".', 'system_notification_Setting'),
('2023-08-20 17:36:45', 2, 1, 'A vulnerability named \"Eaton Cross\" was added by username \"Admin\".', 'vulnerability'),
('2023-08-20 18:40:00', 7, 2, 'User \"مدير الرئيس التنفيذى\" Initiate Audit', 'App\\Models\\FrameworkControlTestAudit'),
('2023-08-20 18:48:16', 9, 2, 'User \"مدير الرئيس التنفيذى\" Initiate Audit', 'App\\Models\\FrameworkControlTestAudit'),
('2023-08-20 19:02:55', 10, 2, 'User \"مدير الرئيس التنفيذى\" Initiate Audit', 'App\\Models\\FrameworkControlTestAudit'),
('2023-08-20 20:06:34', 11, 6, 'User \"مدير الحوكمة والمخاطر والالتزام\" update Audits. Changes: {`test result` (``=>`Partially Implemented`), `summary` (``=>`صصضث`), `test date` (`0000-00-00`=>`2023-08-21`)}.', 'App\\Models\\FrameworkControlTestAudit'),
('2023-08-20 20:10:26', 12, 3, 'User \"مدير اﻹدارة العامة ﻷمن المعلومات\" Initiate Audit', 'App\\Models\\FrameworkControlTestAudit'),
('2023-08-21 18:24:23', 1, 2, 'A system notification setting with message \"\" was added by username \"مدير الرئيس التنفيذى\".', 'system_notification_Setting'),
('2023-08-21 18:25:23', 3, 2, 'A vulnerability named \"Vul_testing\" was added by username \"مدير الرئيس التنفيذى\".', 'vulnerability'),
('2023-08-21 18:29:14', 1, 1, 'A system notification setting with message \"\" was added by username \"Admin\".', 'system_notification_Setting'),
('2023-08-21 18:29:48', 4, 1, 'A vulnerability named \"Vul2_Testing\" was added by username \"Admin\".', 'vulnerability'),
('2023-08-21 18:34:23', 27, 3, 'A new risk ID \"1027\" was submitted by username \"مدير اﻹدارة العامة ﻷمن المعلومات\".', 'risk'),
('2023-08-21 18:36:29', 27, 1, 'Risk details were updated for risk ID \"1027\" by username \"Admin\".\nField name : `regulation` (`NCA-SMACC`=>`NCA-CCC – 1: 2020`), Field name : `control` (`SMACC 1-1-1-1 (SMACC 1-1-1-1)`=>`CCC ١-١-ش۔١ (CCC ١-١-ش۔١)`)', 'risk'),
('2023-08-21 18:37:44', 27, 1, 'Risk details were updated for risk ID \"1027\" by username \"Admin\".\n', 'risk'),
('2023-08-21 18:40:22', 27, 1, 'A mitigation was submitted for risk ID \"1027\" by username \"Admin\".', 'risk'),
('2023-08-21 18:40:32', 27, 1, 'Risk mitigation details were updated for risk ID \"1027\" by username \"Admin\".\n', 'risk'),
('2023-08-21 18:40:32', 27, 1, 'Risk mitigation details were updated for risk ID \"1027\" by username \"Admin\".\n', 'risk'),
('2023-08-21 18:40:34', 27, 1, 'Risk mitigation details were updated for risk ID \"1027\" by username \"Admin\".\n', 'risk'),
('2023-08-21 18:40:36', 27, 1, 'Risk mitigation details were updated for risk ID \"1027\" by username \"Admin\".\n', 'risk'),
('2023-08-21 18:40:36', 27, 1, 'Risk mitigation details were updated for risk ID \"1027\" by username \"Admin\".\n', 'risk'),
('2023-08-21 18:42:13', 27, 1, 'Mitigation for risk ID  \"1027 accepted by \"Admin\" user.', 'risk'),
('2023-08-21 21:45:16', 28, 1, 'A new risk ID \"1028\" was submitted by username \"Admin\".', 'risk'),
('2023-08-21 21:45:29', 29, 1, 'A new risk ID \"1029\" was submitted by username \"Admin\".', 'risk'),
('2023-08-21 21:50:07', 29, 1, 'Risk ID \"1029\" was DELETED by username \"Admin\".', 'risk'),
('2023-08-21 21:50:53', 28, 1, 'Risk details were updated for risk ID \"1028\" by username \"Admin\".\n', 'risk'),
('2023-08-21 21:56:12', 28, 3, 'A management review was submitted for risk ID \"1028\" by username \"مدير اﻹدارة العامة ﻷمن المعلومات\".', 'risk'),
('2023-08-21 22:06:06', 28, 2, 'A management review was submitted for risk ID \"1028\" by username \"مدير الرئيس التنفيذى\".', 'risk'),
('2023-08-21 22:09:42', 28, 1, 'A risk status for subject \"{Risk33_test}\" was changed by the \"Admin\" user.', 'risk'),
('2023-08-21 22:16:01', 28, 1, 'A mitigation was submitted for risk ID \"1028\" by username \"Admin\".', 'risk'),
('2023-08-21 22:22:32', 2, 2, 'A system notification setting with message \"\" was added by username \"مدير الرئيس التنفيذى\".', 'system_notification_Setting'),
('2023-08-21 22:22:48', 2, 2, 'A system notification setting with message \"\" was added by username \"مدير الرئيس التنفيذى\".', 'system_notification_Setting'),
('2023-08-21 22:23:22', 4, 2, 'A vulnerability named \"Vul2_Testing\" was deleted by username \"مدير الرئيس التنفيذى\".', 'vulnerability'),
('2023-08-21 22:27:06', 22, 2, 'An asset named \"Asset1112\" was added by username \"مدير الرئيس التنفيذى\".', 'asset'),
('2023-08-21 22:39:19', 30, 2, 'A new risk ID \"1030\" was submitted by username \"مدير الرئيس التنفيذى\".', 'risk'),
('2023-08-21 23:06:23', 1, 1, 'User \"Admin\" deleted Asset Group \"test\"(ID:1001).', 'assessment'),
('2023-08-21 23:07:05', 2, 1, 'User \"Admin\" deleted Asset Group \"test\"(ID:1002).', 'assessment'),
('2023-08-22 08:38:06', 31, 1, 'A new risk ID \"1031\" was submitted by username \"Admin\".', 'risk');

-- --------------------------------------------------------

--
-- Table structure for table `backups`
--

CREATE TABLE `backups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `random_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `app_zip_file_name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `db_zip_file_name` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Gestión de Acceso'),
(2, 'La Resistencia Ambiental'),
(3, 'Vigilancia'),
(4, 'Seguridad Física'),
(5, 'Politica y Procedimiento'),
(6, 'Gestión de datos sensibles'),
(7, 'Gestión de Tecnica de Vulnerabilidades'),
(8, 'Gestión de Terceros');

-- --------------------------------------------------------

--
-- Table structure for table `change_requests`
--

CREATE TABLE `change_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_file_name` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unique_file_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Department-Manager-In-Review','Department-Manager-Rejected','Responsible-Department-In-Review','Responsible-Department-Accepted','Responsible-Department-Rejected') COLLATE utf8mb4_unicode_ci NOT NULL,
  `review_cycle` enum('Department-Manager-Review','Responsible-Department-Review') COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_review_cycle` enum('Department-Manager-Review','Responsible-Department-Review') COLLATE utf8mb4_unicode_ci NOT NULL,
  `rejection_reason` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `change_requests`
--

INSERT INTO `change_requests` (`id`, `title`, `description`, `display_file_name`, `unique_file_name`, `status`, `review_cycle`, `start_review_cycle`, `rejection_reason`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'ERP change Req', 'ERP change Req', 'act-report.pdf', 'change_request/1/HHKxM3Ia60nTg7gLbOvBanVxazRAkBCab1MkfDFT.pdf', 'Responsible-Department-Accepted', 'Responsible-Department-Review', 'Responsible-Department-Review', NULL, 1, '2023-08-10 11:26:36', '2023-08-10 11:30:18');

-- --------------------------------------------------------

--
-- Table structure for table `close_reasons`
--

CREATE TABLE `close_reasons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `close_reasons`
--

INSERT INTO `close_reasons` (`id`, `name`) VALUES
(1, 'Rejected'),
(2, 'Fully Mitigated'),
(3, 'System Retired'),
(4, 'Cancelled'),
(5, 'Too Insignificant');

-- --------------------------------------------------------

--
-- Table structure for table `closures`
--

CREATE TABLE `closures` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `risk_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `closure_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `close_reason` int(11) DEFAULT NULL,
  `note` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `closures`
--

INSERT INTO `closures` (`id`, `risk_id`, `user_id`, `closure_date`, `close_reason`, `note`) VALUES
(1, 16, 1, '2000-06-26 17:48:03', 2, 'asd'),
(2, 8, 1, '2017-05-03 17:52:04', 4, 'asd'),
(3, 3, 1, '2021-03-19 18:39:04', 1, 'asd'),
(4, 15, 1, '2000-09-09 22:29:38', 4, 'asd'),
(5, 14, 1, '1998-12-25 02:02:41', 2, 'asd'),
(6, 12, 1, '1987-04-03 20:52:27', 4, 'asd'),
(7, 18, 1, '2001-02-07 00:36:42', 4, 'asd'),
(8, 5, 1, '1998-06-16 13:51:32', 4, 'asd'),
(9, 7, 1, '1984-07-10 23:07:12', 4, 'asd'),
(10, 9, 1, '2005-11-11 16:17:31', 1, 'asd'),
(11, 6, 1, '2007-11-17 20:03:13', 1, 'asd'),
(12, 10, 1, '2017-09-27 18:04:57', 4, 'asd'),
(13, 13, 1, '1973-06-08 04:39:14', 5, 'asd'),
(14, 4, 1, '1986-06-19 17:26:31', 5, 'asd'),
(15, 19, 1, '1979-12-26 12:49:50', 1, 'asd'),
(16, 2, 1, '2012-05-24 02:47:34', 2, 'asd'),
(17, 11, 1, '1981-01-17 20:55:37', 5, 'asd'),
(18, 17, 1, '1990-10-19 15:23:00', 1, 'asd'),
(19, 20, 1, '2005-06-01 04:15:11', 3, 'asd'),
(20, 1, 1, '2010-05-17 07:51:07', 5, 'asd');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `risk_id` bigint(20) UNSIGNED NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `user` int(11) NOT NULL,
  `comment` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `compliance_files`
--

CREATE TABLE `compliance_files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ref_id` int(11) NOT NULL,
  `ref_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unique_name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `user` int(11) NOT NULL,
  `content` longblob NOT NULL,
  `version` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_questionnaires`
--

CREATE TABLE `contact_questionnaires` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `questionnaire_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_questionnaire_answers`
--

CREATE TABLE `contact_questionnaire_answers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `asset_id` bigint(20) UNSIGNED DEFAULT NULL,
  `percentage_complete` int(11) NOT NULL DEFAULT 0,
  `approved_status` enum('yes','no') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `status` enum('incomplete','complete') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'incomplete',
  `submission_type` enum('draft','complete') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `contact_id` bigint(20) UNSIGNED NOT NULL,
  `questionnaire_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_questionnaire_answer_results`
--

CREATE TABLE `contact_questionnaire_answer_results` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `contact_questionnaire_answer_id` bigint(20) UNSIGNED NOT NULL,
  `question_id` bigint(20) UNSIGNED NOT NULL,
  `answer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `answer_type` enum('1','2','3') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1:single select 2:multiple select 3:fill in the blank',
  `answer` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contributing_risks`
--

CREATE TABLE `contributing_risks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subject` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `weight` double(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contributing_risks`
--

INSERT INTO `contributing_risks` (`id`, `subject`, `weight`) VALUES
(1, 'Safety', 0.25),
(2, 'SLA', 0.25),
(3, 'Financial', 0.25),
(4, 'Reputation', 0.25);

-- --------------------------------------------------------

--
-- Table structure for table `contributing_risks_impacts`
--

CREATE TABLE `contributing_risks_impacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `contributing_risks_id` bigint(20) UNSIGNED NOT NULL,
  `value` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contributing_risks_impacts`
--

INSERT INTO `contributing_risks_impacts` (`id`, `contributing_risks_id`, `value`, `name`) VALUES
(1, 1, 1, 'Insignificante'),
(2, 2, 1, 'Insignificante'),
(3, 3, 1, 'Insignificante'),
(4, 4, 1, 'Insignificante'),
(5, 1, 2, 'Menor'),
(6, 2, 2, 'Menor'),
(7, 3, 2, 'Menor'),
(8, 4, 2, 'Menor'),
(9, 1, 3, 'Moderado'),
(10, 2, 3, 'Moderado'),
(11, 3, 3, 'Moderado'),
(12, 4, 3, 'Moderado'),
(13, 1, 4, 'Mayor'),
(14, 2, 4, 'Mayor'),
(15, 3, 4, 'Mayor'),
(16, 4, 4, 'Mayor'),
(17, 1, 5, 'Extremo/Catastrofico'),
(18, 2, 5, 'Extremo/Catastrofico'),
(19, 3, 5, 'Extremo/Catastrofico'),
(20, 4, 5, 'Extremo/Catastrofico');

-- --------------------------------------------------------

--
-- Table structure for table `contributing_risks_likelihoods`
--

CREATE TABLE `contributing_risks_likelihoods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `value` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `control_audit_policies`
--

CREATE TABLE `control_audit_policies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `document_id` bigint(20) UNSIGNED NOT NULL,
  `framework_control_test_audit_id` bigint(20) UNSIGNED NOT NULL,
  `document_audit_status` enum('no_action','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no_action'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `control_audit_policies`
--

INSERT INTO `control_audit_policies` (`id`, `document_id`, `framework_control_test_audit_id`, `document_audit_status`) VALUES
(1, 24, 1, 'no_action'),
(2, 2, 2, 'no_action'),
(3, 18, 3, 'no_action'),
(4, 24, 5, 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `control_classes`
--

CREATE TABLE `control_classes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `control_classes`
--

INSERT INTO `control_classes` (`id`, `name`) VALUES
(1, 'Technical'),
(2, 'Operational'),
(3, 'Management');

-- --------------------------------------------------------

--
-- Table structure for table `control_desired_maturities`
--

CREATE TABLE `control_desired_maturities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `control_desired_maturities`
--

INSERT INTO `control_desired_maturities` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Not Performed', '2023-07-05 12:42:41', '2023-07-05 12:42:41'),
(2, 'Performed', '2023-07-05 12:42:41', '2023-07-05 12:42:41'),
(3, 'Documented', '2023-07-05 12:42:41', '2023-07-05 12:42:41'),
(4, 'Managed', '2023-07-05 12:42:41', '2023-07-05 12:42:41'),
(5, 'Reviewed', '2023-07-05 12:42:41', '2023-07-05 12:42:41'),
(6, 'Optimizing', '2023-07-05 12:42:41', '2023-07-05 12:42:41');

-- --------------------------------------------------------

--
-- Table structure for table `control_maturities`
--

CREATE TABLE `control_maturities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `control_maturities`
--

INSERT INTO `control_maturities` (`id`, `name`) VALUES
(1, 'Not Performed'),
(2, 'Performed'),
(3, 'Documented'),
(4, 'Managed'),
(5, 'Reviewed'),
(6, 'Optimizing');

-- --------------------------------------------------------

--
-- Table structure for table `control_objectives`
--

CREATE TABLE `control_objectives` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` tinytext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `control_owners`
--

CREATE TABLE `control_owners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `control_owners`
--

INSERT INTO `control_owners` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'perspiciatis', '2023-07-05 12:42:47', '2023-07-05 12:42:47'),
(2, 'quo', '2023-07-05 12:42:47', '2023-07-05 12:42:47'),
(3, 'qui', '2023-07-05 12:42:47', '2023-07-05 12:42:47'),
(4, 'occaecati', '2023-07-05 12:42:47', '2023-07-05 12:42:47'),
(5, 'dolor', '2023-07-05 12:42:47', '2023-07-05 12:42:47'),
(6, 'adipisci', '2023-07-05 12:42:47', '2023-07-05 12:42:47'),
(7, 'officiis', '2023-07-05 12:42:47', '2023-07-05 12:42:47'),
(8, 'eligendi', '2023-07-05 12:42:47', '2023-07-05 12:42:47'),
(9, 'enim', '2023-07-05 12:42:47', '2023-07-05 12:42:47'),
(10, 'autem', '2023-07-05 12:42:47', '2023-07-05 12:42:47'),
(11, 'laudantium', '2023-07-05 12:42:47', '2023-07-05 12:42:47'),
(12, 'et', '2023-07-05 12:42:47', '2023-07-05 12:42:47'),
(13, 'dicta', '2023-07-05 12:42:47', '2023-07-05 12:42:47'),
(14, 'molestiae', '2023-07-05 12:42:47', '2023-07-05 12:42:47'),
(15, 'provident', '2023-07-05 12:42:47', '2023-07-05 12:42:47'),
(16, 'ut', '2023-07-05 12:42:47', '2023-07-05 12:42:47'),
(17, 'ducimus', '2023-07-05 12:42:47', '2023-07-05 12:42:47'),
(18, 'voluptas', '2023-07-05 12:42:47', '2023-07-05 12:42:47'),
(19, 'vel', '2023-07-05 12:42:47', '2023-07-05 12:42:47'),
(20, 'atque', '2023-07-05 12:42:47', '2023-07-05 12:42:47'),
(21, 'rerum', '2023-07-05 12:42:47', '2023-07-05 12:42:47');

-- --------------------------------------------------------

--
-- Table structure for table `control_phases`
--

CREATE TABLE `control_phases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `control_phases`
--

INSERT INTO `control_phases` (`id`, `name`) VALUES
(1, 'Physical'),
(2, 'Procedural'),
(3, 'Technical'),
(4, 'Legal and Regulatory or Compliance');

-- --------------------------------------------------------

--
-- Table structure for table `control_priorities`
--

CREATE TABLE `control_priorities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `control_priorities`
--

INSERT INTO `control_priorities` (`id`, `name`) VALUES
(1, 'P0'),
(2, 'P1'),
(3, 'P2'),
(4, 'P3');

-- --------------------------------------------------------

--
-- Table structure for table `control_questions`
--

CREATE TABLE `control_questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `framework_control_id` bigint(20) UNSIGNED NOT NULL,
  `assessment_question_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `control_types`
--

CREATE TABLE `control_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `control_types`
--

INSERT INTO `control_types` (`id`, `name`) VALUES
(1, 'Standalone'),
(2, 'Project'),
(3, 'Enterprise');

-- --------------------------------------------------------

--
-- Table structure for table `custom_risk_model_values`
--

CREATE TABLE `custom_risk_model_values` (
  `impact_id` bigint(20) UNSIGNED NOT NULL,
  `likelihood_id` bigint(20) UNSIGNED NOT NULL,
  `value` double(3,1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cvss_scorings`
--

CREATE TABLE `cvss_scorings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `metric_name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abrv_metric_name` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `metric_value` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abrv_metric_value` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numeric_value` double(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `data_classifications`
--

CREATE TABLE `data_classifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `data_classifications`
--

INSERT INTO `data_classifications` (`id`, `name`, `order`) VALUES
(1, 'Public', 1),
(2, 'Internal', 2),
(3, 'Confidential', 3),
(4, 'Restricted', 4);

-- --------------------------------------------------------

--
-- Table structure for table `date_formats`
--

CREATE TABLE `date_formats` (
  `value` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `date_formats`
--

INSERT INTO `date_formats` (`value`) VALUES
('DD MM YYYY'),
('DD-MM-YYYY'),
('DD.MM.YYYY'),
('DD/MM/YYYY'),
('MM DD YYYY'),
('MM-DD-YYYY'),
('MM.DD.YYYY'),
('MM/DD/YYYY'),
('YYYY DD MM'),
('YYYY MM DD'),
('YYYY-DD-MM'),
('YYYY-MM-DD'),
('YYYY.DD.MM'),
('YYYY.MM.DD'),
('YYYY/DD/MM'),
('YYYY/MM/DD');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `manager_id` bigint(20) UNSIGNED DEFAULT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `required_num_emplyees` int(11) DEFAULT NULL,
  `color_id` bigint(20) UNSIGNED NOT NULL,
  `vision` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mission` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `objectives` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `responsibilities` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `code`, `manager_id`, `parent_id`, `required_num_emplyees`, `color_id`, `vision`, `message`, `mission`, `objectives`, `responsibilities`, `created_at`, `updated_at`) VALUES
(1, 'الرئيس التنفيذى', '#000001', 2, NULL, NULL, 1, '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '2023-07-05 12:42:42', '2023-07-05 12:42:42'),
(2, 'اﻹدارة العامة ﻷمن المعلومات', '#000002', 3, 1, NULL, 2, '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '2023-07-05 12:42:42', '2023-07-05 12:42:43'),
(3, 'نائب المدير العام', '#000003', 4, 2, NULL, 3, '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '2023-07-05 12:42:42', '2023-07-05 12:42:43'),
(4, 'المكتب اﻹدارى', '#000004', 5, 2, 6, 4, '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '2023-07-05 12:42:42', '2023-07-05 12:42:43'),
(5, 'الحوكمة والمخاطر والالتزام', '#000005', 6, 2, 21, 5, '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '2023-07-05 12:42:42', '2023-07-05 12:42:43'),
(6, 'المراقبة اﻷمنية والاستجابة والتحليل', '#000006', 7, 2, 43, 6, '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '2023-07-05 12:42:42', '2023-07-05 12:42:43'),
(7, 'إدارة الحلول اﻷمنية', '#000007', 8, 2, 11, 7, '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '2023-07-05 12:42:42', '2023-07-05 12:42:43'),
(8, 'المعمارية والتخطيط', '#000008', 9, 2, 8, 8, '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '2023-07-05 12:42:42', '2023-07-05 12:42:43'),
(9, 'الحوكمة', '#000009', 10, 5, NULL, 9, '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '2023-07-05 12:42:42', '2023-07-05 12:42:43'),
(10, 'المخاطر', '#000010', 11, 5, NULL, 10, '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '2023-07-05 12:42:42', '2023-07-05 12:42:43'),
(11, 'الالتزام', '#000011', 12, 5, NULL, 11, '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '2023-07-05 12:42:42', '2023-07-05 12:42:43'),
(12, 'المراقبة اﻷمنية', '#000012', 13, 6, NULL, 12, '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '2023-07-05 12:42:42', '2023-07-05 12:42:43'),
(13, 'التحليل الرقمى والاستجابة للحوادث', '#000013', 14, 6, NULL, 13, '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '2023-07-05 12:42:42', '2023-07-05 12:42:43'),
(14, 'المعلومات الاستخباراتية والتهديدات', '#000014', 15, 6, NULL, 14, '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '2023-07-05 12:42:42', '2023-07-05 12:42:43'),
(15, 'تحليل التهديدات والثغرات', '#000015', 16, 6, NULL, 15, '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '2023-07-05 12:42:42', '2023-07-05 12:42:44');
INSERT INTO `departments` (`id`, `name`, `code`, `manager_id`, `parent_id`, `required_num_emplyees`, `color_id`, `vision`, `message`, `mission`, `objectives`, `responsibilities`, `created_at`, `updated_at`) VALUES
(16, 'إدارة الضوابط التقنية اﻷمنية', '#000016', 17, 7, NULL, 16, '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '2023-07-05 12:42:42', '2023-07-05 12:42:44'),
(17, 'تطوير واختبار الحلول اﻷمنية', '#000017', 18, 7, NULL, 17, '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '2023-07-05 12:42:42', '2023-07-05 12:42:44'),
(18, 'إدارة الهويات والصلاحيات', '#000018', 19, 7, NULL, 18, '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '2023-07-05 12:42:42', '2023-07-05 12:42:44'),
(19, 'التخطيط والتطوير', '#000019', 20, 8, NULL, 19, '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '2023-07-05 12:42:42', '2023-07-05 12:42:44'),
(20, 'المعمارية اﻷمنية', '#000020', 21, 8, NULL, 20, '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '2023-07-05 12:42:42', '2023-07-05 12:42:44'),
(21, 'قسم الانتاج', 'F_1', 6, 20, 2, 20, '{\"ops\":[{\"insert\":\"انتاج\\n\"}]}', '{\"ops\":[{\"insert\":\"انتاج\\n\"}]}', '{\"ops\":[{\"insert\":\"انتاج\\n\"}]}', '{\"ops\":[{\"insert\":\"انتاج\\n\"}]}', '{\"ops\":[{\"insert\":\"انتاج\\n\"}]}', '2023-08-20 13:04:08', '2023-08-20 17:31:07');

-- --------------------------------------------------------

--
-- Table structure for table `department_colors`
--

CREATE TABLE `department_colors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(9) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `department_colors`
--

INSERT INTO `department_colors` (`id`, `name`, `value`) VALUES
(1, 'الرئيس التنفيذى', '#557B83'),
(2, 'اﻹدارة العامة ﻷمن المعلومات', '#39AEA9'),
(3, 'نائب المدير العام', '#A2D5AB'),
(4, 'المكتب اﻹدارى', '#E5EFC1'),
(5, 'الحوكمة والمخاطر والالتزام', '#46244C'),
(6, 'المراقبة اﻷمنية والاستجابة والتحليل', '#C74B50'),
(7, 'إدارة الحلول اﻷمنية', '#D49B54'),
(8, 'المعمارية والتخطيط', '#712B75'),
(9, 'الحوكمة', '#332FD0'),
(10, 'المخاطر', '#F0A500'),
(11, 'الالتزام', '#874356'),
(12, 'المراقبة اﻷمنية', '#019267'),
(13, 'التحليل الرقمى والاستجابة للحوادث', '#9ADCFF'),
(14, 'المعلومات الاستخباراتية والتهديدات', '#008E89'),
(15, 'تحليل التهديدات والثغرات', '#313552'),
(16, 'إدارة الضوابط التقنية اﻷمنية', '#FF5959'),
(17, 'تطوير واختبار الحلول اﻷمنية', '#161853'),
(18, 'إدارة الهويات والصلاحيات', '#544179'),
(19, 'التخطيط والتطوير', '#125C13'),
(20, 'المعمارية اﻷمنية', '#557B83');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `document_type` bigint(20) UNSIGNED NOT NULL,
  `privacy` bigint(20) UNSIGNED DEFAULT NULL,
  `document_name` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent` int(11) DEFAULT NULL,
  `document_status` int(11) NOT NULL DEFAULT 1 COMMENT '[1 => Draft],[2=> InReview, [3 => Approved]',
  `file_id` int(11) NOT NULL,
  `creation_date` date DEFAULT NULL,
  `last_review_date` date DEFAULT NULL,
  `review_frequency` int(11) DEFAULT NULL,
  `next_review_date` date DEFAULT NULL,
  `approval_date` date DEFAULT NULL,
  `control_ids` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `framework_ids` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document_owner` bigint(20) UNSIGNED NOT NULL,
  `document_reviewer` bigint(20) UNSIGNED DEFAULT NULL,
  `additional_stakeholders` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approver` int(11) DEFAULT NULL,
  `team_ids` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `document_type`, `privacy`, `document_name`, `parent`, `document_status`, `file_id`, `creation_date`, `last_review_date`, `review_frequency`, `next_review_date`, `approval_date`, `control_ids`, `framework_ids`, `document_owner`, `document_reviewer`, `additional_stakeholders`, `approver`, `team_ids`, `created_by`) VALUES
(2, 2, 2, 'السياسة العامة للأمن السيبراني', NULL, 3, 0, '2023-07-05', '2023-07-05', 180, '2024-01-01', NULL, '11', '1', 1, NULL, '', NULL, '', 1),
(3, 2, 2, 'سياسة الالتزام بتشريعات وتنظيمات الأمن السيبراني', NULL, 3, 0, '2023-07-05', '2023-07-05', 180, '2024-01-01', NULL, '35', '1', 1, NULL, '', NULL, '', 1),
(4, 2, 2, 'سياسة الإعدادات والتحصين', NULL, 3, 0, '2023-07-05', '2023-07-05', 180, '2024-01-01', NULL, '28,34', '1', 1, NULL, '', NULL, '', 1),
(5, 2, 2, 'سياسة الحماية من البرمجيات الضارة', NULL, 3, 0, '2023-07-05', '2023-07-05', 180, '2024-01-01', NULL, '76', '1', 1, NULL, '', NULL, '', 1),
(6, 2, 2, 'سياسة أمن الخوادم', NULL, 3, 0, '2023-07-05', '2023-07-05', 180, '2024-01-01', NULL, '76,125', '1', 1, NULL, '', NULL, '', 1),
(7, 2, 2, 'سياسة أمن الشبكات', NULL, 3, 0, '2023-07-05', '2023-07-05', 180, '2024-01-01', NULL, '93,96,103', '1', 1, NULL, '', NULL, '', 1),
(8, 2, 2, 'سياسة أمن البريد الإلكتروني', NULL, 3, 0, '2023-07-05', '2023-07-05', 180, '2024-01-01', NULL, '84', '1', 1, NULL, '', NULL, '', 1),
(9, 2, 2, 'سياسة أمن أجهزة المستخدمين والأجهزة المحمولة والأجهزة الشخصية', NULL, 3, 0, '2023-07-05', '2023-07-05', 180, '2024-01-01', NULL, '76,105', '1', 1, NULL, '', NULL, '', 1),
(10, 2, 2, 'سياسة الاستخدام المقبول للأصول', NULL, 3, 0, '2023-07-05', '2023-07-05', 180, '2024-01-01', NULL, '63', '1', 1, NULL, '', NULL, '', 1),
(11, 2, 2, 'سياسة مراجعة وتدقيق الأمن السيبراني', NULL, 3, 0, '2023-07-05', '2023-07-05', 180, '2024-01-01', NULL, '37', '1', 1, NULL, '', NULL, '', 1),
(12, 2, 2, 'سياسة إدارة هويات الدخول والصلاحيات', NULL, 3, 0, '2023-07-05', '2023-07-05', 180, '2024-01-01', NULL, '67', '1', 1, NULL, '', NULL, '', 1),
(13, 2, 2, 'سياسة الأمن السيبراني للموارد البشرية', NULL, 3, 0, '2023-07-05', '2023-07-05', 180, '2024-01-01', NULL, '40', '1', 1, NULL, '', NULL, '', 1),
(14, 2, 2, 'سياسة إدارة سجلات الأحداث ومراقبة الأمن السيبراني', NULL, 3, 0, '2023-07-05', '2023-07-05', 180, '2024-01-01', NULL, '149', '1', 1, NULL, '', NULL, '', 1),
(15, 2, 2, 'سياسة إدارة حزم التحديثات والإصلاحات', NULL, 3, 0, '2023-07-05', '2023-07-05', 180, '2024-01-01', NULL, '81', '1', 1, NULL, '', NULL, '', 1),
(16, 2, 2, 'سياسة الأمن السيبراني المتعلّق بالأطراف الخارجية', NULL, 3, 0, '2023-07-05', '2023-07-05', 180, '2024-01-01', NULL, '192,199', '1', 1, NULL, '', NULL, '', 1),
(17, 2, 2, 'أدوار ومسؤوليات الأمن السيبراني', NULL, 3, 0, '2023-07-05', '2023-07-05', 180, '2024-01-01', NULL, '15,40', '1', 1, NULL, '', NULL, '', 1),
(18, 2, 2, 'الوثيقة المنظمة للجنة الإشرافية للأمن السيبراني', NULL, 3, 0, '2023-07-05', '2023-07-05', 180, '2024-01-01', NULL, '10', '1', 1, NULL, '', NULL, '', 1),
(19, 2, 2, 'سياسة اختبار الاختراق', NULL, 3, 0, '2023-07-05', '2023-07-05', 180, '2024-01-01', NULL, '61,143,148', '1', 1, NULL, '', NULL, '', 1),
(20, 2, 2, 'سياسة إدارة الثغرات', NULL, 3, 0, '2023-07-05', '2023-07-05', 180, '2024-01-01', NULL, '134,137,141', '1', 1, NULL, '', NULL, '', 1),
(21, 2, 2, 'سياسة إدارة حوادث وتهديدات الأمن السيبراني', NULL, 3, 0, '2023-07-05', '2023-07-05', 180, '2024-01-01', NULL, '157,158,161,162,163,164,165', '1', 1, NULL, '', NULL, '', 1),
(22, 2, 2, 'سياسة أمن قواعد البيانات', NULL, 3, 0, '2023-07-05', '2023-07-05', 180, '2024-01-01', NULL, '12,82', '1', 1, NULL, '', NULL, '', 1),
(23, 2, 2, 'سياسة حماية تطبيقات الويب', NULL, 3, 0, '2023-07-05', '2023-07-05', 180, '2024-01-01', NULL, '100,176,179,180,182,184', '1', 1, NULL, '', NULL, '', 1),
(24, 2, 2, 'استراتيجية الأمن السيبراني', NULL, 3, 0, '2023-07-05', '2023-07-05', 180, '2024-01-01', NULL, '5', '1', 1, NULL, '', NULL, '', 1),
(25, 2, 2, 'الهيكل التنظيمي للأمن السيبراني', NULL, 3, 0, '2023-07-05', '2023-07-05', 180, '2024-01-01', NULL, '8', '1', 1, NULL, '', NULL, '', 1),
(26, 2, 2, 'سياسة الأمن السيبراني لأنظمة التحكم الصناعي', NULL, 3, 0, '2023-07-05', '2023-07-05', 180, '2024-01-01', NULL, '208,212,213,215,217,218,221', '1', 1, NULL, '', NULL, '', 1),
(27, 2, 2, 'سياسة التشفير', NULL, 3, 0, '2023-07-05', '2023-07-05', 180, '2024-01-01', NULL, '120,121,123,126', '1', 1, NULL, '', NULL, '', 1),
(31, 2, 2, 'سياسة إدارة مخاطر الأمن السيبراني', NULL, 3, 0, '2023-07-05', '2023-07-05', 180, '2024-01-01', NULL, '17', '1', 1, NULL, '', NULL, '', 1),
(32, 2, 2, 'سياسة الأمن السيبراني المتعلق بالحوسبة السحابية والاستضافة', NULL, 3, 0, '2023-07-05', '2023-07-05', 180, '2024-01-01', NULL, '201,204,205,206', '1', 1, NULL, '', NULL, '', 1),
(33, 2, 2, 'سياسة الأمن السيبراني ضمن استمرارية الأعمال', NULL, 3, 0, '2023-07-05', '2023-07-05', 180, '2024-01-01', NULL, '185,845', '1,5', 1, NULL, '', NULL, '', 1),
(34, 2, 2, 'سياسة الأمن السيبراني المتعلق بالأمن المادي', NULL, 3, 0, '2023-07-05', '2023-07-05', 180, '2024-01-01', NULL, '167', '1', 1, NULL, '', NULL, '', 1),
(35, 3, 2, 'معيار أمن الشبكات', NULL, 3, 0, '2023-07-05', '2023-07-05', 180, '2024-01-01', NULL, '93', '1', 1, NULL, '', NULL, '', 1),
(36, 3, 2, 'معيار حماية البريد الإلكتروني', NULL, 3, 0, '2023-07-05', '2023-07-05', 180, '2024-01-01', NULL, '13,84', '1', 1, NULL, '', NULL, '', 1),
(37, 3, 2, 'معيار إدارة سجلات الأحداث ومراقبة الأمن السيبراني', NULL, 3, 0, '2023-07-05', '2023-07-05', 180, '2024-01-01', NULL, '13,149', '1', 1, NULL, '', NULL, '', 1),
(38, 3, 2, 'معيار الحماية من البرمجيات الضارة', NULL, 3, 0, '2023-07-05', '2023-07-05', 180, '2024-01-01', NULL, '79', '1', 1, NULL, '', NULL, '', 1),
(39, 3, 2, 'معيار أمن أجهزة المستخدمين', NULL, 3, 0, '2023-07-05', '2023-07-05', 180, '2024-01-01', NULL, '76', '1', 1, NULL, '', NULL, '', 1),
(40, 3, 2, 'معيار أمن الأجهزة المحمولة', NULL, 3, 0, '2023-07-05', '2023-07-05', 180, '2024-01-01', NULL, '13,105', '1', 1, NULL, '', NULL, '', 1),
(41, 3, 2, 'معيار أمن الخوادم', NULL, 3, 0, '2023-07-05', '2023-07-05', 180, '2024-01-01', NULL, '76', '1', 1, NULL, '', NULL, '', 1),
(42, 3, 2, 'معيار أمن قواعد البيانات', NULL, 3, 0, '2023-07-05', '2023-07-05', 180, '2024-01-01', NULL, '76', '1', 1, NULL, '', NULL, '', 1),
(43, 3, 2, 'معيار إدارة الثغرات', NULL, 3, 0, '2023-07-05', '2023-07-05', 180, '2024-01-01', NULL, '134', '1', 1, NULL, '', NULL, '', 1),
(44, 3, 2, 'معيار إدارة حوادث وتهديدات الأمن السيبراني', NULL, 3, 0, '2023-07-05', '2023-07-05', 180, '2024-01-01', NULL, '158', '1', 1, NULL, '', NULL, '', 1),
(45, 3, 2, 'معيار اختبار الاختراق', NULL, 3, 0, '2023-07-05', '2023-07-05', 180, '2024-01-01', NULL, '143', '1', 1, NULL, '', NULL, '', 1),
(46, 3, 2, 'معيار التطوير الآمن للتطبيقات', NULL, 3, 0, '2023-07-05', '2023-07-05', 180, '2024-01-01', NULL, '30', '1', 1, NULL, '', NULL, '', 1),
(47, 3, 2, 'معيار حماية تطبيقات الويب', NULL, 3, 0, '2023-07-05', '2023-07-05', 180, '2024-01-01', NULL, '176', '1', 1, NULL, '', NULL, '', 1),
(48, 3, 2, 'معيار التشفير', NULL, 3, 0, '2023-07-05', '2023-07-05', 180, '2024-01-01', NULL, '120', '1', 1, NULL, '', NULL, '', 1),
(49, 3, 2, 'معيار أمن الشبكات اللاسلكية', NULL, 3, 0, '2023-07-05', '2023-07-05', 180, '2024-01-01', NULL, '93', '1', 1, NULL, '', NULL, '', 1),
(54, 8, 1, 'لوائح صمود الامن السيبراني', NULL, 3, 0, '2023-07-05', '2023-07-05', 180, '2024-01-01', NULL, '138,284', '1,4', 1, NULL, '', NULL, '', 1),
(55, 2, 1, 'Doc_Test', NULL, 2, 11, '2023-08-21', '2023-08-23', 0, '2023-08-23', NULL, '5', '1', 3, 4, '2', NULL, '', 1),
(56, 10, 1, 'Doc_Test2', NULL, 2, 12, '2023-08-21', '2023-08-22', 0, '2023-08-22', NULL, '5', '1', 3, 4, '2', NULL, '', 1),
(57, 10, 2, 'Doc_Test3', NULL, 3, 13, '2023-08-21', '2023-08-22', 0, '2023-08-22', '2023-08-23', '508', '3', 1, NULL, '1', NULL, '', 1),
(58, 10, 2, 'Doc_Test4', NULL, 3, 14, '2023-08-21', '2023-08-22', 0, '2023-08-22', '2023-08-22', '751', '5', 1, NULL, '1', NULL, '1', 1),
(60, 10, 1, 'Doc_Test5', NULL, 3, 16, '2023-08-19', '2023-08-23', 3, '2023-08-26', '2023-08-22', '891', '9', 3, 1, '2', NULL, '', 1),
(61, 10, 1, 'Doc_Test7', NULL, 2, 17, '2023-08-21', '2023-08-23', 3, '2023-08-26', NULL, '6', '1', 1, 4, '2', NULL, '', 3),
(62, 2, 2, 'Doc_Test100', NULL, 3, 18, '2023-08-21', '2023-08-21', 3, '2023-08-24', '2023-08-22', '276', '4', 3, 2, '2,4', NULL, '', 1),
(63, 10, 2, 'Doccccs', NULL, 3, 24, '2023-08-22', '2023-08-24', 2, '2023-08-26', '2023-08-22', '223', '2', 4, NULL, '3', NULL, '', 2);

-- --------------------------------------------------------

--
-- Table structure for table `document_exceptions`
--

CREATE TABLE `document_exceptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `policy_document_id` int(11) DEFAULT NULL,
  `control_framework_id` int(11) DEFAULT NULL,
  `owner` int(11) DEFAULT NULL,
  `additional_stakeholders` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creation_date` date NOT NULL DEFAULT '0000-00-00',
  `review_frequency` int(11) NOT NULL DEFAULT 0,
  `next_review_date` date NOT NULL DEFAULT '0000-00-00',
  `approval_date` date NOT NULL DEFAULT '0000-00-00',
  `approver` int(11) DEFAULT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT 0,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `justification` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_id` int(11) NOT NULL,
  `associated_risks` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `document_exceptions_statuses`
--

CREATE TABLE `document_exceptions_statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `document_notes`
--

CREATE TABLE `document_notes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `document_id` bigint(20) UNSIGNED NOT NULL,
  `note` tinytext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `document_notes`
--

INSERT INTO `document_notes` (`id`, `user_id`, `document_id`, `note`, `created_at`) VALUES
(1, 4, 60, 'sad', '2023-08-21 14:43:13');

-- --------------------------------------------------------

--
-- Table structure for table `document_note_files`
--

CREATE TABLE `document_note_files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `document_id` bigint(20) UNSIGNED NOT NULL,
  `display_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unique_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `document_statuses`
--

CREATE TABLE `document_statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `document_statuses`
--

INSERT INTO `document_statuses` (`id`, `name`) VALUES
(1, 'Draft'),
(2, 'In Review'),
(3, 'Approved');

-- --------------------------------------------------------

--
-- Table structure for table `document_types`
--

CREATE TABLE `document_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `document_types`
--

INSERT INTO `document_types` (`id`, `name`, `icon`, `created_at`, `updated_at`) VALUES
(2, 'نماذج سياسات الأمن السيبراني', 'fas  fa-lock', '2023-07-05 12:42:50', '2023-07-05 12:42:50'),
(3, 'معايير الأمن السيبراني', 'fas  fa-lock', '2023-07-05 12:42:50', '2023-07-05 12:42:50'),
(4, 'الاجراءات', 'fas fa-bug', '2023-07-05 12:42:50', '2023-07-05 12:42:50'),
(8, 'صمود الأمن السيبراني', 'fas fa-unlink', '2023-07-05 12:42:50', '2023-07-05 12:42:50'),
(9, 'test', 'fas fa-id-badge', '2023-07-23 11:45:17', '2023-07-23 11:45:17'),
(10, 'Doc_Test111', 'fas fa-bug', '2023-08-21 15:30:19', '2023-08-21 17:54:52');

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_saved_selections`
--

CREATE TABLE `dynamic_saved_selections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('private','public') COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `custom_display_settings` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `custom_selection_settings` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `custom_column_filters` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_login_attempts`
--

CREATE TABLE `failed_login_attempts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `expired` tinyint(1) NOT NULL DEFAULT 0,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `ip` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0.0.0.0',
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `families`
--

CREATE TABLE `families` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(350) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int(11) NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `families`
--

INSERT INTO `families` (`id`, `name`, `order`, `parent_id`) VALUES
(1, 'حوكمة الأمن السيبراني CyberSecurity Governance', 1, NULL),
(2, 'تعزيز الأمن السيبراني CyberSecurity Defense', 2, NULL),
(3, 'صمود الأمن السيبراني CyberSecurity Resilience', 3, NULL),
(4, 'الأمن السيبراني المتعلق باﻷطراف الخارجية والحوسبة السحابية Third-Party and Cloud Computing CyberSecurity', 4, NULL),
(5, 'الأمن السيبراني ﻷنظمة التحكم الصناعي ICS CyberSecurity', 5, NULL),
(6, 'Cyber Security Leadership and Governance', 6, NULL),
(7, 'Cyber Security Risk Management and Compliance', 7, NULL),
(8, 'Cyber Security Operations and Technology', 8, NULL),
(9, 'Third Party Cyber Security', 9, NULL),
(10, 'Annex A.5 – Information Security Policies', 10, NULL),
(11, 'Annex A.6 – Organisation of Information Security', 11, NULL),
(12, 'Annex A.7 – Human Resource Security', 12, NULL),
(13, 'Annex A.8 – Asset Management', 13, NULL),
(14, 'Annex A.9 – Access Control', 14, NULL),
(15, 'Annex A.10 – Cryptography', 15, NULL),
(16, 'Annex A.11 – Physical & Environmental Security', 16, NULL),
(17, 'Annex A.12 – Operations Security', 17, NULL),
(18, 'Annex A.13 – Communications Security', 18, NULL),
(19, 'Annex A.14 – System Acquisition, Development & Maintenance', 19, NULL),
(20, 'Annex A.15 – Supplier Relationships', 20, NULL),
(21, 'Annex A.16 – Information Security Incident Management', 21, NULL),
(22, 'Annex A.17 – Information Security Aspects of Business Continuity Management', 22, NULL),
(23, 'Annex A.18 – Compliance', 23, NULL),
(24, 'إستراتيجية الأمن السيبراني CyberSecurity Strategy', 1, 1),
(25, 'إدارة الأمن السيبراني CyberSecurity Management', 2, 1),
(26, 'سياسات وإجراءات الأمن السيبراني CyberSecurity Policies and Procedures', 3, 1),
(27, 'أدارة ومسئوليات الأمن السيبراني CyberSecurity Role and Responsibilities', 4, 1),
(28, 'إدارة مخاطر الأمن السيبراني CyberSecurity Risk Management', 5, 1),
(29, 'الأمن السيبراني ضمن إدارة المشاريع المعلوماتية والتقنية CyberSecurity in Information Technology Projects', 6, 1),
(30, 'اﻹلتزام بتشريعات وتنظيمات ومعايير الأمن السيبراني CyberSecurity Regulatory Compliance', 7, 1),
(31, 'المراجعة والتدقيق الدورى للأمن السيبراني CyberSecurity Periodical Assessment and Audit', 8, 1),
(32, 'الأمن السيبراني المتعلق بالموارد البشرية CyberSecurity in Human Resources', 9, 1),
(33, 'برنامج التوعية والتدريب بالأمن السيبراني CyberSecurity Awareness and Training Program', 10, 1),
(34, 'إدارة اﻷصول Asset Management', 1, 2),
(35, 'إدارة هويات الدخول والصلاحيات Identity and Access Management', 2, 2),
(36, 'حماية اﻷنظمة وأجهزة معالجة المعلومات Information System and Processing Facilities Protection', 3, 2),
(37, 'حماية البريد اﻹلكترونى Email Protection', 4, 2),
(38, 'إدارة أمن الشبكات Networks Security Management', 5, 2),
(39, 'أمن اﻷجهزة المحمولة Mobile Devices Security', 6, 2),
(40, 'حماية البيانات والمعلومات Data and Information Protection', 7, 2),
(41, 'التشفير Cryptography', 8, 2),
(42, 'إدارة النسخ الاحتياطية Backup and Recovery Management', 9, 2),
(43, 'إدارة الثغرات Vulnerabilities Management', 10, 2),
(44, 'إختبار الاختراق Penetration Testing', 11, 2),
(45, 'إدارة سجلات اﻷحداث ومراقبة اﻷمن السيبرانى CyberSecurity Event Logs and Monitoring Management', 12, 2),
(46, 'إدارة حوادث وتهديدات اﻷمن السيبراني CyberSecurity Incident and Threat Management', 13, 2),
(47, 'اﻷمن المادى Physical Security', 14, 2),
(48, 'حماية تطبيقات الويب Web Application Security', 15, 2),
(49, 'جوانب صمود اﻷمن السيبراني فى إدارة استمرارية اﻷعمال CyberSecurity Resilience aspects of Business Continuity Management (BCM)', 1, 3),
(50, 'الأمن السيبراني المتعلق باﻷطراف الخارجية Third-Party CyberSecurity', 1, 4),
(51, 'الأمن السيبراني المتعلق بالحوسبة السحابية والاستضافة Cloud Computing and hosting CyberSecurity', 2, 4),
(52, 'حماية أجمزة وأنظمة التحكم الصناعي Industrial Control Systems (ICS) Protection', 1, 5),
(53, 'Cyber Security Governance', 1, 6),
(54, 'Cyber Security Strategy', 2, 6),
(55, 'Cyber Security Policy', 3, 6),
(56, 'Cyber Security Roles and Responsibilities', 4, 6),
(57, 'Cyber Security in Project Management', 5, 6),
(58, 'Cyber Security Awareness', 6, 6),
(59, 'Cyber Security Training', 7, 6),
(60, 'Cyber Security Risk Management', 1, 7),
(61, 'Regulatory Compliance', 2, 7),
(62, 'Compliance with (inter)national industry standards', 3, 7),
(63, 'Cyber Security Review', 4, 7),
(64, 'Cyber Security Audits', 5, 7),
(65, 'Human Resources', 1, 8),
(66, 'Physical Security', 2, 8),
(67, 'Asset Management', 3, 8),
(68, 'Cyber Security Architecture', 4, 8),
(69, 'Identity and Access Management', 5, 8),
(70, 'Application Security', 6, 8),
(71, 'Change Management', 7, 8),
(72, 'Infrastructure Security', 8, 8),
(73, 'Cryptography', 9, 8),
(74, 'Bring Your Own Device (BYOD)', 10, 8),
(75, 'Secure Disposal of Information Assets', 11, 8),
(76, 'Payment Systems', 12, 8),
(77, 'Electronic Banking Services', 13, 8),
(78, 'Cyber Security Event Management', 14, 8),
(79, 'Cyber Security Incident Management', 15, 8),
(80, 'Threat Management', 16, 8),
(81, 'Vulnerability Management', 17, 8),
(82, 'Contract and Vendor Management', 1, 9),
(83, 'Outsourcing', 2, 9),
(84, 'Cloud Computing', 3, 9),
(85, 'Management direction for information Security', 1, 10),
(86, 'Internal organization', 1, 11),
(87, 'Mobile devices and teleworking', 2, 11),
(88, 'Prior to employment', 1, 12),
(89, 'During employment', 2, 12),
(90, 'Termination and change of employment', 3, 12),
(91, 'Responsibility for assets', 1, 13),
(92, 'Information classification', 2, 13),
(93, 'Media Handling', 3, 13),
(94, 'Business requirements of access Control', 1, 14),
(95, 'User access Management', 2, 14),
(96, 'User responsibilities', 3, 14),
(97, 'System and application access Control', 4, 14),
(98, 'Cryptographic Controls', 1, 15),
(99, 'Ensuring Secure Physical and Environmental Areas', 1, 16),
(100, 'Equipment', 2, 16),
(101, 'Operational Procedures and Responsibilities', 1, 17),
(102, 'Protection From Malware', 2, 17),
(103, 'Backup', 3, 17),
(104, 'Logging and Monitoring', 4, 17),
(105, 'Control of Operational Software', 5, 17),
(106, 'Technical Vulnerability Management', 6, 17),
(107, 'Information Systems and Audit Considerations', 7, 17),
(108, 'Network Security Management', 1, 18),
(109, 'Information Transfer', 2, 18),
(110, 'Security Requirements of Information Systems', 1, 19),
(111, 'Security in Development and Support Processes', 2, 19),
(112, 'Test data', 3, 19),
(113, 'Information Security in Supplier Relationships', 1, 20),
(114, 'Supplier Service Delivery Management', 2, 20),
(115, 'Management of Information Security incidents, events and Weaknesses', 1, 21),
(116, 'Information Security Continuity', 1, 22),
(117, 'Redundancies', 2, 22),
(118, 'Compliance with legal and Contractual Requirements', 1, 23),
(119, 'Information Security Reviews', 2, 23),
(120, 'الأمن السيبراني ضمن إدارة التغير Management Change in Cybersecurity', 11, 1),
(121, 'إدارة المفاتيح Key management', 16, 2),
(122, 'حماية التطبيقات Application Security', 17, 2),
(123, 'أمن تطوير الأنظمة System Development Security', 18, 2),
(124, 'أمن وسائط التخزين Storage Media Security', 19, 2),
(125, 'حمايه المنظم ومرافق المعالجة Facility Processing and System Protection', 20, 2),
(126, 'الإتلاف الآمن للبيانات secure Data Disposal', 21, 2),
(127, 'الأمن السيبراني للطابعات و الماسحات الضوئيه وآللات التصوير Cybersecurity for printers,scanners and Copy machines', 22, 2);

-- --------------------------------------------------------

--
-- Table structure for table `fields`
--

CREATE TABLE `fields` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `risk_id` bigint(20) UNSIGNED DEFAULT NULL,
  `view_type` int(11) NOT NULL DEFAULT 1,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unique_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `risk_id`, `view_type`, `name`, `unique_name`, `type`, `size`, `timestamp`, `user`) VALUES
(1, NULL, 1, 'CYBER MODE1.pdf', 'security_awareness/1/MS9dHM9GzX6HC5fZiAqwQwzZbqD8rbRJrOZCY3PD.pdf', NULL, 0, '2023-07-05 11:14:45', 0),
(2, NULL, 1, 'CYBER MODE1.pdf', 'security_awareness/2/rNPYa8wXwy4e0ZSLfStnYEm2ve5K10u8cuKbqNWX.pdf', NULL, 0, '2023-07-05 11:17:44', 0),
(3, NULL, 1, 'act-report.pdf', 'security_awareness/3/VcJbzIBslS4y8Rdrf80FGEY8B1Nl1mgEoYVUrQJV.pdf', NULL, 0, '2023-07-13 11:15:34', 0),
(4, NULL, 1, 'ceiling (1).pdf', 'security_awareness/4/5HMLcqgYA0y1sIlcWPV6NEafK9vno8vL5YU8BaHT.pdf', NULL, 0, '2023-07-17 09:38:11', 0),
(5, NULL, 1, 'CYBER MODE1.pdf', 'security_awareness/5/9L2HEDtoowh2TahkrkBqRoBTrm5FMwvvqYVnuxD3.pdf', NULL, 0, '2023-08-08 13:31:18', 0),
(6, NULL, 1, 'so_survey_2019.pdf', 'security_awareness/6/zotzHUl8w0ufOnCSwe4kAFXTznO9IAjV8Qxg99qw.pdf', NULL, 0, '2023-08-09 07:19:15', 0),
(7, NULL, 1, 'so_survey_2019.pdf', 'security_awareness/7/KxXa5BdoUe8nxezAM48kETBKnhqStdCzjVtAGqSv.pdf', NULL, 0, '2023-08-09 07:57:26', 0),
(8, NULL, 1, 'تقرير Students status (3).pdf', 'security_awareness/8/0QnKRT3sCfAMRILkmRWxSlKX23No1NXCBmRNmaUK.pdf', NULL, 0, '2023-08-20 14:39:56', 0),
(9, NULL, 1, 'تقرير Students status (3).pdf', 'security_awareness/9/3RivBVf0cK2u2tnrmsA6hQGgjbuEKfbUtU11FagA.pdf', NULL, 0, '2023-08-20 14:44:48', 0),
(10, NULL, 1, 'تقرير Students status (3).pdf', 'security_awareness/10/JHFmskPir1Namj9qOpsxBTNC7QPgVhdqkovMXuL3.pdf', NULL, 0, '2023-08-20 14:46:11', 0),
(11, NULL, 1, 'dashboard_report.pdf', 'docs/55/NOfk5y8dpyJX28wPuwpuGiEfDvdnxfCI0cwMTq2Q.pdf', NULL, 0, '2023-08-21 12:28:45', 0),
(12, NULL, 1, 'dashboard_report.pdf', 'docs/56/hh0k0vmWnJEhl4uitIX0SPz8xY7uyufgAS9SOWpQ.pdf', NULL, 0, '2023-08-21 12:32:03', 0),
(13, NULL, 1, 'dashboard_report.pdf', 'docs/57/TPSC8oqk3rPO3826btOlYLr6TDBRNJJBAsWBtEFZ.pdf', NULL, 0, '2023-08-21 12:41:02', 0),
(14, NULL, 1, 'dashboard_report.pdf', 'docs/58/CDnYcUO1e6Ta4HCMZRTF9pC39OWMYhUGccpMhHzY.pdf', NULL, 0, '2023-08-21 12:45:17', 0),
(16, NULL, 1, 'dashboard_report.pdf', 'docs/60/rByiIwRzaV4jUC9a7qGxLl69B5kTqh3cNi2bSCHi.pdf', NULL, 0, '2023-08-21 13:14:36', 0),
(17, NULL, 1, 'dashboard_report.pdf', 'docs/61/OhuSZcDsqZNWiQMxIlgmcwVLXSxp2qtucRXQzJXl.pdf', NULL, 0, '2023-08-21 14:37:47', 0),
(18, NULL, 1, 'dashboard_report (1).pdf', 'docs/62/aPA0O0VPJKqmGoDisaE3l0j91oKI3gbxdTX7iYWz.pdf', NULL, 0, '2023-08-21 14:57:11', 0),
(19, 27, 1, 'dashboard_report (1).pdf', 'risk/27/OwAoQBnW4j8Sm4wTDJdAZfFRAsrc3kZE60qxOdfd.pdf', 'application/pdf', 2133602, '2023-08-21 15:34:23', 3),
(20, 27, 2, 'dashboard_report (1).pdf', 'risk_mitigation/22/e0BSrL8RXxqkksj4TD6MI7i0m4nG0TUNO7gZaBVM.pdf', 'application/pdf', 2133602, '2023-08-21 15:40:22', 1),
(21, 28, 1, 'dashboard_report (1).pdf', 'risk/28/P6W8lfJMOpAPf3UZ6oOnIc4qBzNsZzJcxHkTXTuO.pdf', 'application/pdf', 2133602, '2023-08-21 18:45:16', 1),
(23, 31, 1, '620x354-51560428878185.jpg', 'risk/31/ylKzvG164fqkZlQ8WxVYKX7YecSFr7Ng7ZSIGPgk.jpg', 'image/jpeg', 38844, '2023-08-22 05:38:06', 1),
(24, NULL, 1, '620x354-51560428878185.jpg', 'docs/63/S2aXki0OuiQR2YQJ4oSrikUN6bofJ4ZXLscbEuBZ.jpg', NULL, 0, '2023-08-22 05:39:41', 0),
(25, NULL, 1, 'تقرير Students status (3).pdf', 'security_awareness/11/0YH1u4vWvbSmRobFYUUq7zLFJhzKgkPwCtPU0SEh.pdf', NULL, 0, '2023-08-22 06:16:14', 0);

-- --------------------------------------------------------

--
-- Table structure for table `file_tasks`
--

CREATE TABLE `file_tasks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `task_id` bigint(20) UNSIGNED NOT NULL,
  `display_name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unique_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `file_tasks`
--

INSERT INTO `file_tasks` (`id`, `task_id`, `display_name`, `unique_name`) VALUES
(1, 1, 'image1.png', 'task/1/aPyqSQJoKkGGBrghLXA7lV25wW8DOiGE9WPN1ude.png'),
(2, 1, 'image2.png', 'task/1/LD9pe8s3hnVfV3zKjLU5J3GItQaY9LNecEOc7dei.png');

-- --------------------------------------------------------

--
-- Table structure for table `file_types`
--

CREATE TABLE `file_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `file_types`
--

INSERT INTO `file_types` (`id`, `name`) VALUES
(21, 'application/csv'),
(18, 'application/force-download'),
(16, 'application/msword'),
(11, 'application/octet-stream'),
(19, 'application/pdf'),
(15, 'application/vnd.ms-excel'),
(8, 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'),
(7, 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'),
(17, 'application/x-gzip'),
(6, 'application/x-pdf'),
(9, 'application/zip'),
(1, 'image/gif'),
(5, 'image/jpeg'),
(2, 'image/jpg'),
(3, 'image/png'),
(4, 'image/x-png'),
(14, 'text/comma-separated-values'),
(20, 'text/csv'),
(12, 'text/plain'),
(10, 'text/rtf'),
(13, 'text/xml');

-- --------------------------------------------------------

--
-- Table structure for table `file_type_extensions`
--

CREATE TABLE `file_type_extensions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `file_type_extensions`
--

INSERT INTO `file_type_extensions` (`id`, `name`) VALUES
(12, 'csv'),
(14, 'doc'),
(16, 'dot'),
(6, 'dotx'),
(1, 'gif'),
(15, 'gz'),
(4, 'jpeg'),
(2, 'jpg'),
(5, 'pdf'),
(3, 'png'),
(9, 'rtf'),
(10, 'txt'),
(18, 'xla'),
(13, 'xls'),
(7, 'xlsx'),
(17, 'xlt'),
(11, 'xml'),
(8, 'zip');

-- --------------------------------------------------------

--
-- Table structure for table `frameworks`
--

CREATE TABLE `frameworks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `order` int(11) DEFAULT NULL,
  `last_audit_date` date DEFAULT NULL,
  `next_audit_date` date DEFAULT NULL,
  `desired_frequency` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `frameworks`
--

INSERT INTO `frameworks` (`id`, `parent`, `name`, `description`, `icon`, `status`, `order`, `last_audit_date`, `next_audit_date`, `desired_frequency`, `created_at`, `updated_at`) VALUES
(1, NULL, 'NCA-ECC – 1: 2018', 'The National Cybersecurity Authority “NCA” has developed the Essential Cybersecurity Controls (ECC – 1: 2018) to set the minimum cybersecurity requirements based on best practices and standards to minimize the cybersecurity risks to the information and technical assets of organizations that originate from internal and external threats. The Essential Cybersecurity Controls consist of 114 main controls, divided into five main domains.', 'fa-universal-access', 1, NULL, NULL, NULL, NULL, '2023-07-05 12:42:48', '2023-07-05 12:42:48'),
(2, NULL, 'NCA-SMACC', 'Based on the objectives of the National Cybersecurity Authority (NCA) strategy and in continuation of its role in regulating and protecting the Kingdom\'s cyberspace, NCA has issued the Organizations’ Social Media Accounts Cybersecurity Controls document. These controls were developed after reviewing many international cybersecurity standards, frameworks, controls and international practices in cybersecurity.', 'fa-whatsapp', 1, NULL, NULL, NULL, NULL, '2023-07-05 12:42:48', '2023-07-05 12:42:48'),
(3, NULL, 'NCA-CCC – 1: 2020', 'The National Cybersecurity Authority “NCA” has developed the Cloud Cybersecurity Controls (CCC – 1: 2020) as an extension and a complement to Essential Cybersecurity Controls (ECC – 1: 2018). The CCC aims to set cybersecurity requirements for cloud computing from the perspective of Cloud Service Providers (CSPs) and Cloud Service Tenants (CSTs); to meet the security needs and raise the CSPs’ and the CSTs’ preparedness towards reducing cybersecurity risks on all cloud computing services. The Cloud Cybersecurity Controls consist of 37 main controls and 96 subcontrols for CSPs, and 18 main controls and 26 subcontrols for CSTs, divided into four main domains.', 'fa-warning', 1, NULL, NULL, NULL, NULL, '2023-07-05 12:42:48', '2023-07-05 12:42:48'),
(4, NULL, 'NCA-TCC', 'Based on the objectives of the National Cybersecurity Authority (NCA) strategy and in continuation of its role in regulating and protecting the Kingdom\'s cyberspace, NCA has issued the Telework Cybersecurity Controls (TCC) document. These controls were developed after reviewing many international cybersecurity standards, frameworks, controls and international practices in cybersecurity. The document aims to contribute to raising the level of cybersecurity at the national level by enabling the organization to perform its work remotely in a secure manner and adapt to the changes in the business environment and telework systems, and enhancing the organization’s cybersecurity capabilities and resilience against cyber threats when providing remote work. These controls are an extension to the Essential Cybersecurity Controls (ECC).', 'fa-user-times', 1, NULL, NULL, NULL, NULL, '2023-07-05 12:42:48', '2023-07-05 12:42:48'),
(5, NULL, 'NCA-CSCC – 1: 2019', 'The National Cybersecurity Authority “NCA” has developed the Critical Systems Cybersecurity Controls (CSCC – 1: 2019), as an extension and a complement to the Essential Cybersecurity Controls (ECC), to fit the cybersecurity needs for national critical systems. The Critical Systems Cybersecurity Controls consist of 32 main controls and 73 subcontrols, divided into four main domains.', 'fa-lock', 1, NULL, NULL, NULL, NULL, '2023-07-05 12:42:48', '2023-07-05 12:42:48'),
(6, NULL, 'NCA-OTCC-1:2022', 'In continuation of its role in regulating and protecting the Kingdom\'s cyberspace, and in line with the Kingdom’s Vision 2030, NCA publishes the Operational Technology Cybersecurity Controls (OTCC-1:2022). These controls are aligned with related international cybersecurity standards, frameworks, controls, and best practices.\n    \n                The controls aim to raise the cybersecurity level of OT systems in the Kingdom by setting the minimum cybersecurity requirements for organizations to protect their Industrial Control systems (ICS) from cyber threats that could result in negative impacts. These controls are an extension to the NCA’s Essential Cybersecurity Controls (ECC).', 'fa-upload', 1, NULL, NULL, NULL, NULL, '2023-07-05 12:42:48', '2023-07-05 12:42:48'),
(7, NULL, 'NCA-DCC-1:2022', 'In continuation of its role in regulating and protecting the Kingdom\'s cyberspace, NCA has issued the Data Cybersecurity Controls (DCC-1:2022). These controls have been developed after conducting a comprehensive study of multiple national and international cybersecurity standards, frameworks and controls, studying related laws and regulations, reviewing cybersecurity best practices and analyzing cybersecurity risks, threats, previous incidents and attacks at the national level.', 'fa-usb', 1, NULL, NULL, NULL, NULL, '2023-07-05 12:42:48', '2023-07-05 12:42:48'),
(8, NULL, 'SAMA', 'SAMA established a Cyber Security Framework (“the Framework”) to enable Financial Institutions regulated by SAMA (“the Member Organizations”) to effectively identify and address risks related to cyber security. To maintain the protection of information assets and online services, the Member Organizations must adopt the Framework.', 'fa-eye', 1, NULL, NULL, NULL, NULL, '2023-07-05 12:42:48', '2023-07-05 12:42:48'),
(9, NULL, 'ISO-27001', 'ISO/IEC 27001 is is the world’s best-known standard for information security management systems (ISMS) and their requirements. Additional best practice in data protection and cyber resilience are covered by more than a dozen standards in the ISO/IEC 27000 family. Together, they enable organizations of all sectors and sizes to manage the security of assets such as financial information, intellectual property, employee data and information entrusted by third parties.', 'fa-user-circle', 1, NULL, NULL, NULL, NULL, '2023-07-05 12:42:48', '2023-07-05 12:42:48'),
(10, NULL, 'Test_Test2', 'Testing', 'far fa-id-badge', 1, NULL, NULL, NULL, NULL, '2023-08-20 17:25:55', '2023-08-20 17:25:55');

-- --------------------------------------------------------

--
-- Table structure for table `framework_controls`
--

CREATE TABLE `framework_controls` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `short_name` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `long_name` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supplemental_guidance` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `control_number` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `control_status` enum('Not Applicable','Not Implemented','Partially Implemented','Implemented') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Not Applicable',
  `family` bigint(20) UNSIGNED NOT NULL,
  `control_owner` bigint(20) UNSIGNED DEFAULT NULL,
  `desired_maturity` bigint(20) UNSIGNED DEFAULT NULL,
  `control_priority` bigint(20) UNSIGNED DEFAULT NULL,
  `control_class` bigint(20) UNSIGNED DEFAULT NULL,
  `control_maturity` bigint(20) UNSIGNED DEFAULT 1,
  `control_phase` bigint(20) UNSIGNED DEFAULT NULL,
  `control_type` bigint(20) UNSIGNED DEFAULT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `submission_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_audit_date` date DEFAULT NULL,
  `next_audit_date` date DEFAULT NULL,
  `desired_frequency` int(11) DEFAULT NULL,
  `mitigation_percent` int(11) DEFAULT 0,
  `status` int(11) DEFAULT 1,
  `deleted` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `framework_controls`
--

INSERT INTO `framework_controls` (`id`, `short_name`, `long_name`, `description`, `supplemental_guidance`, `control_number`, `control_status`, `family`, `control_owner`, `desired_maturity`, `control_priority`, `control_class`, `control_maturity`, `control_phase`, `control_type`, `parent_id`, `submission_date`, `last_audit_date`, `next_audit_date`, `desired_frequency`, `mitigation_percent`, `status`, `deleted`, `created_at`, `updated_at`) VALUES
(5, 'ECC 1-1-1', 'ECC 1-1-1', 'يجب تحديد وتوثيق واعتماد إستراتيجية الامـن السيبراني للجهة ودعمها من قبل رئيس الجهة أو من\r\nينيبه ويشار له في هذه الضوابط بـاسم »صاحب الصلاحية« وأن تتماشى الاهداف الاستراتيجية للامن\r\nالسيبراني للجهة مع المتطلبات التشريعية والتنظيمية ذات العلاقة', NULL, 'ECC 1-1-1', 'Implemented', 24, 1, 3, NULL, NULL, 5, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(6, 'ECC 1-1-2', 'ECC 1-1-2', 'يجب العمل على تنفيذ خطة عمل لتطبيق إستراتيجية الامن السيبراني من قبل الجهة', NULL, 'ECC 1-1-2', 'Partially Implemented', 24, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(7, 'ECC 1-1-3', 'ECC 1-1-3', 'يجب مراجعة إستراتيجية الامن السيبراني على فترات زمنية مخطط لها أو في حالة حدوث تغييرات في\r\nالمتطلبات التشريعية والتنظيمية ذات العلاقة', NULL, 'ECC 1-1-3', 'Not Applicable', 24, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(8, 'ECC 1-2-1', 'ECC 1-2-1', 'يجب إنشاء إدارة معنية بالامن السيبراني في الجهة مستقلة عن إدارة تقنية المعلومات والاتصالات وفقا للأمر السامي الكريم  رقم 37140  وتاريخ 14 \\/ 8 \\/ 1438 هـ. ويفضل ارتباطها مباشرة برئيس (ICT\\/ IT)\r\n وفقا للجهة أو من ينيبه، مع الاخذ بالاعتبار عدم تعارض المصالح.', NULL, 'ECC 1-2-1', 'Partially Implemented', 25, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(9, 'ECC 1-2-2', 'ECC 1-2-2', 'يجب أن يشغل رئاسة الادارة المعنية بالامن السيبراني والوظائف الاشرافية والحساسة بها مواطنون\r\n متفرغون وذو كفاءة عالية في مجال الامن السيبراني.', NULL, 'ECC 1-2-2', 'Not Applicable', 25, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(10, 'ECC 1-2-3', 'ECC 1-2-3', 'يجب إنشاء لجنة إشرافية للامن السيبراني بتوجيه من صاحب الصلاحية للجهة لضمان التزام ودعم ومتابعة\r\nتطبيق برامج وتشريعات الامن السيبراني، ويتم تحديد وتوثيق واعتماد أعضاء اللجنة ومسؤولياتها وإطار\r\nحوكمة أعمالها على أن يكون رئيس الادارة المعنية بالامن السيبراني أحد أعضائها. ويفضل ارتباطها مباشرة\r\nبرئيس الجهة أو من ينيبه، مع الاخذ بالاعتبار عدم تعارض المصالح', NULL, 'ECC 1-2-3', 'Not Applicable', 25, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(11, 'ECC 1-3-1', 'ECC 1-3-1', 'يجب على الادارة المعنية بالامن السيبراني في الجهة تحديد سياسات وإجـراءات الامن السيبراني وما\r\nتشمله من ضوابط ومتطلبات الامن السيبراني، وتوثيقها واعتمادها من قبل صاحب الصلاحية في الجهة،\r\nكما يجب نشرها إلى ذوي العلاقة من العاملين في الجهة والاطراف المعنية بها.', NULL, 'ECC 1-3-1', 'Not Applicable', 26, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(12, 'ECC 1-3-2', 'ECC 1-3-2', 'يجب على الادارة المعنية بالامن السيبراني ضمان تطبيق سياسات وإجراءات الامن السيبراني في الجهة\r\nوما تشمله من ضوابط ومتطلبات.', NULL, 'ECC 1-3-2', 'Not Applicable', 26, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(13, 'ECC 1-3-3', 'ECC 1-3-3', 'يجب أن تكون سياسات وإجراءات الامن السيبراني مدعومة بمعايير تقنية أمنية )على سبيل المثال => المعايير\r\n التقنية المنية لجدار الحماية وقواعد البيانات، وأنظمة التشغيل، إلخ(', NULL, 'ECC 1-3-3', 'Not Applicable', 26, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(14, 'ECC 1-3-4', 'ECC 1-3-4', 'يجب مراجعة سياسات وإجــراءات ومعايير الامـن السيبراني وتحديثها على فترات زمنية مخطط لها )أو\r\nفي حالة حدوث تغييرات في المتطلبات التشريعية والتنظيمية والمعايير ذات العلاقة(، كما يجب توثيق\r\nالتغييرات واعتمادها.', NULL, 'ECC 1-3-4', 'Not Applicable', 26, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(15, 'ECC 1-4-1', 'ECC 1-4-1', 'يجب على صاحب الصلاحية تحديد وتوثيق واعتماد الهيكل التنظيمي للحوكمة والادوار والمسؤوليات\r\nالخاصة بالامن السيبراني للجهة، وتكليف الاشخاص المعنيين بها، كما يجب تقديم الدعم اللزم لنفاذ\r\nذلك، مع الاخذ بالاعتبار عدم تعارض المصالح', NULL, 'ECC 1-4-1', 'Not Applicable', 27, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(16, 'ECC 1-4-2', 'ECC 1-4-2', 'يجب مراجعة أدوار ومسؤوليات الامن السيبراني في الجهة وتحديثها على فترات زمنية مخطط لها )أو في\r\n حالة حدوث تغييرات في المتطلبات التشريعية والتنظيمية ذات العلقة(.', NULL, 'ECC 1-4-2', 'Not Applicable', 27, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(17, 'ECC 1-5-1', 'ECC 1-5-1', 'يجب على الادارة المعنية بالامن السيبراني في الجهة تحديد وتوثيق واعتماد منهجية وإجـراءات إدارة\r\nمخاطر الامن السيبراني في الجهة. وذلك وفقاً لعتبارات السرية وتوافر وسلامة الاصول المعلوماتية\r\nوالتقنية', NULL, 'ECC 1-5-1', 'Not Applicable', 28, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(18, 'ECC 1-5-2', 'ECC 1-5-2', 'يجب على الادارة المعنية بالامن السيبراني تطبيق منهجية وإجـراءات إدارة مخاطر الامن السيبراني في\r\nالجهة', NULL, 'ECC 1-5-2', 'Not Applicable', 28, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(19, 'ECC 1-5-3', 'ECC 1-5-3', 'يجب تنفيذ إجراءات تقييم مخاطر الامن السيبراني', NULL, 'ECC 1-5-3', 'Not Applicable', 28, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(20, 'ECC 1-5-3-1', 'ECC 1-5-3-1', 'يجب تنفيذ إجراءات تقييم مخاطر الامن السيبراني في مرحلة مبكرة من المشاريع التقنية', NULL, 'ECC 1-5-3-1', 'Not Applicable', 28, 1, NULL, NULL, NULL, 1, NULL, NULL, 19, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(21, 'ECC 1-5-3-2', 'ECC 1-5-3-2', 'يجب تنفيذ إجراءات تقييم مخاطر الامن السيبراني   قبل إجراء تغيير جوهري في البنية التقنية', NULL, 'ECC 1-5-3-2', 'Not Applicable', 28, 1, NULL, NULL, NULL, 1, NULL, NULL, 19, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(22, 'ECC 1-5-3-3', 'ECC 1-5-3-3', 'يجب تنفيذ إجراءات تقييم مخاطر الامن السيبراني عند التخطيط للحصول على خدمات طرف خارجي', NULL, 'ECC 1-5-3-3', 'Not Applicable', 28, 1, NULL, NULL, NULL, 1, NULL, NULL, 19, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(23, 'ECC 1-5-3-4', 'ECC 1-5-3-4', 'يجب تنفيذ إجراءات تقييم مخاطر الأمن السيبراني  عند التخطيط وقبل إطلق منتجات وخدمات تقنية جديدة.', NULL, 'ECC 1-5-3-4', 'Not Applicable', 28, 1, NULL, NULL, NULL, 1, NULL, NULL, 19, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(24, 'ECC 1-5-4', 'ECC 1-5-4', 'يجب مراجعة منهجية وإجراءات إدارة مخاطر الامن السيبراني وتحديثها على فترات زمنية مخطط لها )أو\r\nفي حالة حدوث تغييرات في المتطلبات التشريعية والتنظيمية والمعايير ذات العلاقة(، كما يجب توثيق\r\nالتغييرات واعتمادها.', NULL, 'ECC 1-5-4', 'Not Applicable', 28, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(25, 'ECC 1-6-1', 'ECC 1-6-1', 'يجب تضمين متطلبات الامـن السيبراني في منهجية وإجــراءات إدارة المشاريع وفي إدارة التغيير على\r\nالاصول المعلوماتية والتقنية في الجهة لضمان تحديد مخاطر الامن السيبراني ومعالجتها كجزء من دورة\r\nحياة المشروع التقني، وأن تكون متطلبات الامن السيبراني جزء أساسي من متطلبات المشاريع التقنية.', NULL, 'ECC 1-6-1', 'Not Applicable', 29, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(26, 'ECC 1-6-2', 'ECC 1-6-2', 'يجب أن تغطي متطلبات الامن السيبراني لادارة المشاريع والتغييرات على الاصول المعلوماتية والتقنية\r\nللجهة', NULL, 'ECC 1-6-2', 'Not Applicable', 29, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(27, 'ECC 1-6-2-1', 'ECC 1-6-2-1', 'يجب أن تغطي متطلبات الامن السيبراني لادارة المشاريع \r\n والتغييرات على الاصول المعلوماتية والتقنية  تقييم الثغرات ومعالجتها', NULL, 'ECC 1-6-2-1', 'Not Applicable', 29, 1, NULL, NULL, NULL, 1, NULL, NULL, 26, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(28, 'ECC 1-6-2-2', 'ECC 1-6-2-2', 'يجب أن تغطي متطلبات الامن السيبراني لادارة المشاريع والتغييرات على الاصول المعلوماتية والتقنية\r\nللجهة  وحـزم( Secure Confguration and Hardening( والتحصين لـإعـدادات مراجعة اجــراء \r\nالتحديثات قبل إطلق وتدشين المشاريع والتغييرات.', NULL, 'ECC 1-6-2-2', 'Not Applicable', 29, 1, NULL, NULL, NULL, 1, NULL, NULL, 26, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(29, 'ECC 1-6-3', 'ECC 1-6-3', 'يجب أن تغطي متطلبات الامن السيبراني لمشاريع تطوير التطبيقات والبرمجيات الخاصة للجهة', NULL, 'ECC 1-6-3', 'Not Implemented', 29, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(30, 'ECC 1-6-3-1', 'ECC 1-6-3-1', 'يجب أن تغطي متطلبات الامن السيبراني لمشاريع تطوير التطبيقات والبرمجيات الخاصة للجهة بحد أدنى )Secure Coding Standards( للتطبيقات الامن التطوير معايير ا', NULL, 'ECC 1-6-3-1', 'Not Applicable', 29, 1, NULL, NULL, NULL, 1, NULL, NULL, 29, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(31, 'ECC 1-6-3-2', 'ECC 1-6-3-2', 'يجب أن تغطي متطلبات الامن السيبراني لمشاريع تطوير التطبيقات والبرمجيات الخاصة للجهة بحد أدنى استخدام مصادر مرخصة وموثوقة لادوات تطوير التطبيقات والمكتبات الخاصة بها )Libraries.)', NULL, 'ECC 1-6-3-2', 'Not Applicable', 29, 1, NULL, NULL, NULL, 1, NULL, NULL, 29, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(32, 'ECC 1-6-3-3', 'ECC 1-6-3-3', 'يجب أن تغطي متطلبات الامن السيبراني لمشاريع تطوير التطبيقات والبرمجيات الخاصة للجهة بحد أدنى اجراء اختبار للتحقق من مدى استيفاء التطبيقات للمتطلبات الامنية السيبرانية للجهة.', NULL, 'ECC 1-6-3-3', 'Not Applicable', 29, 1, NULL, NULL, NULL, 1, NULL, NULL, 29, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(33, 'ECC 1-6-3-4', 'ECC 1-6-3-4', 'يجب أن تغطي متطلبات الامن السيبراني لمشاريع تطوير التطبيقات والبرمجيات الخاصة للجهة بحد أدنى  التطبيقات بين( Integration( التكامل أم', NULL, 'ECC 1-6-3-4', 'Not Implemented', 29, 1, NULL, NULL, NULL, 1, NULL, NULL, 29, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(34, 'ECC 1-6-3-5', 'ECC 1-6-3-5', 'يجب أن تغطي متطلبات الامن السيبراني لمشاريع تطوير التطبيقات والبرمجيات الخاصة للجهة بحد أدنى وحـزم( Secure Confguration and Hardening( والتحصين لـإعـدادات مراجعة اج التحديثات قبل إطلق وتدشين التطبيقات', NULL, 'ECC 1-6-3-5', 'Not Applicable', 29, 1, NULL, NULL, NULL, 1, NULL, NULL, 29, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(35, 'ECC 1-7-1', 'ECC 1-7-1', 'يجب على الجهة الالتزام بالمتطلبات التشريعية والتنظيمية الوطنية المتعلقة بالامن السيبراني', NULL, 'ECC 1-7-1', 'Not Applicable', 30, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(36, 'ECC 1-7-2', 'ECC 1-7-2', 'في حال وجود اتفاقيات أو إلتزامات دولية معتمدة محلياً تتضمن متطلبات خاصة بالامن السيبراني، فيجب\r\nعلى الجهة الالتزام بتلك المتطلبات.', NULL, 'ECC 1-7-2', 'Not Applicable', 30, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(37, 'ECC 1-8-1', 'ECC 1-8-1', 'يجب على الادارة المعنية بالامن السيبراني في الجهة مراجعة تطبيق ضوابط الامن السيبراني دورياً.', NULL, 'ECC 1-8-1', 'Not Applicable', 31, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(38, 'ECC 1-8-2', 'ECC 1-8-2', 'يجب مراجعة وتدقيق تطبيق ضوابط الامن السيبراني في الجهة، من قبل أطراف مستقلة عن الادارة\r\nالمعنية بالمن السيبراني )مثل الادارة المعنية بالمراجعة في الجهة(. على أن تتم المراجعة والتدقيق\r\nبشكل مستقل يراعى فيه مبدأ عدم تعارض المصالح، وذلك وفقاً للمعايير العامة المقبولة للمراجعة\r\nوالتدقيق والمتطلبات التشريعية والتنظيمية ذات العلاقة.', NULL, 'ECC 1-8-2', 'Not Applicable', 31, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(39, 'ECC 1-8-3', 'ECC 1-8-3', 'يجب توثيق نتائج مراجعة وتدقيق الامـن السيبراني، وعرضها على اللجنة الشرافية للامن السيبراني\r\nوصاحب الصلاحية. كما يجب أن تشتمل النتائج على نطاق المراجعة والتدقيق، والملاحظات المكتشفة،\r\nوالتوصيات والجراءات التصحيحية، وخطة معالجة الملاحظات.', NULL, 'ECC 1-8-3', 'Not Applicable', 31, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(40, 'ECC 1-9-1', 'ECC 1-9-1', 'يجب تحديد وتوثيق واعتماد متطلبات الامن السيبراني المتعلقة بالعاملين قبل توظيفهم وأثناء عملهم\r\nوعند انتهاء\\/إنهاء عملهم في الجهة', NULL, 'ECC 1-9-1', 'Not Applicable', 32, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(41, 'ECC 1-9-2', 'ECC 1-9-2', 'يجب تطبيق متطلبات الامن السيبراني المتعلقة بالعاملين في الجهة.', NULL, 'ECC 1-9-2', 'Not Applicable', 32, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(42, 'ECC 1-9-3', 'ECC 1-9-3', 'يجب أن تغطي متطلبات الامن السيبراني قبل بدء علاقة العاملين المهنية بالجهة', NULL, 'ECC 1-9-3', 'Not Applicable', 32, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(43, 'ECC 1-9-3-1', 'ECC 1-9-3-1', 'يجب أن تغطي متطلبات الامن السيبراني قبل بدء علاقة العاملين المهنية بالجهة تـضـمـيـن مــســؤولــيــات الامـــــن الــســيــبــرانــي وبـــنـــود الــمــحــافــظــة عــلــى ســريــة الـمـعـلـومـات\r\n)Clauses Disclosure-Non )في عقود العاملين في الجهة )لتشمل خلال وبعد انتهاء\\/إنهاء\r\nالعلقة الوظيفية مع الجهة(', NULL, 'ECC 1-9-3-1', 'Not Applicable', 32, 1, NULL, NULL, NULL, 1, NULL, NULL, 42, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(44, 'ECC 1-9-3-2', 'ECC 1-9-3-2', 'يجب أن تغطي متطلبات الامن السيبراني قبل بدء علاقة العاملين المهنية بالجهة   إجراء المسح الامني )Vetting or Screening )للعاملين في وظائف الامن السيبراني والوظائف\r\nالتقنية ذات الصلاحيات الهامة والحساسة', NULL, 'ECC 1-9-3-2', 'Not Applicable', 32, 1, NULL, NULL, NULL, 1, NULL, NULL, 42, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(45, 'ECC 1-9-4', 'ECC 1-9-4', 'يجب أن تغطي متطلبات الامن السيبراني خلل علاقة العاملين المهنية بالجهة', NULL, 'ECC 1-9-4', 'Not Applicable', 32, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(46, 'ECC 1-9-4-1', 'ECC 1-9-4-1', 'يجب أن تغطي متطلبات الامن السيبراني خلل علاقة العاملين المهنية بالجهة  التوعية بالامن السيبراني )عند بداية المهنة الوظيفية وخلالها(.', NULL, 'ECC 1-9-4-1', 'Not Applicable', 32, 1, NULL, NULL, NULL, 1, NULL, NULL, 45, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(47, 'ECC 1-9-4-2', 'ECC 1-9-4-2', 'يجب أن تغطي متطلبات الامن السيبراني خلل علاقة العاملين المهنية بالجهة  تطبيق متطلبات الامـن السيبراني والالـتـزام بها وفقاً لسياسات وإجـــراءات وعمليات الامن\r\nالسيبراني للجهة', NULL, 'ECC 1-9-4-2', 'Not Applicable', 32, 1, NULL, NULL, NULL, 1, NULL, NULL, 45, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(48, 'ECC 1-9-5', 'ECC 1-9-5', 'يجب مراجعة وإلغاء الصلاحيات للعاملين مباشرة بعد انتهاء\\/إنهاء الخدمة المهنية لهم بالجهة.', NULL, 'ECC 1-9-5', 'Not Applicable', 32, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(49, 'ECC 1-9-6', 'ECC 1-9-6', 'يجب مراجعة متطلبات الامن السيبراني المتعلقة بالعاملين في الجهة دوري', NULL, 'ECC 1-9-6', 'Not Applicable', 32, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(50, 'ECC 1-10-1', 'ECC 1-10-1', 'يجب تطوير واعتماد برنامج للتوعية بالامن السيبراني في الجهة من خلل قنوات متعددة دورياً، وذلك لتعزيز الوعي بالامن السيبراني وتهديداته ومخاطره، وبناء ثقافة إيجابية للامن السيبراني.', NULL, 'ECC 1-10-1', 'Not Applicable', 33, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(51, 'ECC 1-10-2', 'ECC 1-10-2', 'يجب تطبيق البرنامج المعتمد للتوعية بالامن السيبراني في الجهة', NULL, 'ECC 1-10-2', 'Not Applicable', 33, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(52, 'ECC 1-10-3', 'ECC 1-10-3', 'يجب أن يغطي برنامج التوعية بالامن السيبراني كيفية حماية الجهة من أهم المخاطر والتهديدات السيبرانية\r\nوما يستجد منها', NULL, 'ECC 1-10-3', 'Not Applicable', 33, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(53, 'ECC 1-10-3-1', 'ECC 1-10-3-1', 'يجب أن يغطي برنامج التوعية بالامن السيبراني كيفية حماية الجهة من أهم المخاطر والتهديدات السيبرانية\r\nوما يستجد منها بما في ذلك => التعامل الامن مع خدمات البريد اللكتروني خصوصاً مع رسائل التصيد الالكتروني', NULL, 'ECC 1-10-3-1', 'Not Applicable', 33, 1, NULL, NULL, NULL, 1, NULL, NULL, 52, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(54, 'ECC 1-10-3-2', 'ECC 1-10-3-2', 'يجب أن يغطي برنامج التوعية بالامن السيبراني كيفية حماية الجهة من أهم المخاطر والتهديدات السيبرانية\r\nوما يستجد منها، بما في ذلك التعامل الامن مع الجهزة المحمولة ووسائط التخزين.', NULL, 'ECC 1-10-3-2', 'Not Applicable', 33, 1, NULL, NULL, NULL, 1, NULL, NULL, 52, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(55, 'ECC 1-10-3-4', 'ECC 1-10-3-4', 'يجب أن يغطي برنامج التوعية بالامن السيبراني كيفية حماية الجهة من أهم المخاطر والتهديدات السيبرانية\r\nوما يستجد منها، بما في ذلك التعامل الامن مع وسائل التواصل الاجتماعي.', NULL, 'ECC 1-10-3-4', 'Not Applicable', 33, 1, NULL, NULL, NULL, 1, NULL, NULL, 52, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(56, 'ECC 1-10-4', 'ECC 1-10-4', 'يجب توفير المهارات المتخصصة والتدريب الازم للعاملين في المجلالت الوظيفية ذات العلاقة المباشرة\r\nبالامن السيبراني في الجهة، وتصنيفها بما يتماشى مع مسؤولياتهم الوظيفية فيما يتعلق بالامن\r\nالسيبراني', NULL, 'ECC 1-10-4', 'Not Applicable', 33, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(57, 'ECC 1-10-4-1', 'ECC 1-10-4-1', 'يجب توفير المهارات المتخصصة والتدريب اللزم للعاملين في المجالت الوظيفية ذات العلقة المباشرة\r\nبالامن السيبراني في الجهة، وتصنيفها بما يتماشى مع مسؤولياتهم الوظيفية فيما يتعلق بالامن\r\nالسيبراني، بما في ذلك  موظفو الادارة المعنية بالامن السيبراني', NULL, 'ECC 1-10-4-1', 'Not Applicable', 33, 1, NULL, NULL, NULL, 1, NULL, NULL, 56, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(58, 'ECC 1-10-4-3', 'ECC 1-10-4-3', 'جب توفير المهارات المتخصصة والتدريب الازم للعاملين في المجلالت الوظيفية ذات العلقة المباشرة\r\nبالامن السيبراني في الجهة، وتصنيفها بما يتماشى مع مسؤولياتهم الوظيفية فيما يتعلق بالامن\r\nالسيبراني، بما في ذلك الاشرافية الوظائف', NULL, 'ECC 1-10-4-3', 'Not Applicable', 33, 1, NULL, NULL, NULL, 1, NULL, NULL, 56, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(59, 'ECC 1-10-4-2', 'ECC 1-10-4-2', 'يجب توفير المهارات المتخصصة والتدريب اللازم للعاملين في المجالت الوظيفية ذات العلاقة المباشرة\r\nبالامن السيبراني في الجهة، وتصنيفها بما يتماشى مع مسؤولياتهم الوظيفية فيما يتعلق بالامن\r\nالسيبراني، بما في ذلك الموظفون العاملون في تطوير البرامج والتطبيقات والموظفون المشغلون للاصول المعلوماتية\r\nوالتقنية للجهة', NULL, 'ECC 1-10-4-2', 'Not Applicable', 33, 1, NULL, NULL, NULL, 1, NULL, NULL, 56, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(60, 'ECC 1-10-5', 'ECC 1-10-5', 'يجب مراجعة تطبيق برنامج التوعية بالامن السيبراني في الجهة دوريا', NULL, 'ECC 1-10-5', 'Not Applicable', 33, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(61, 'ECC 2-1-1', 'ECC 2-1-1', 'يجب تحديد وتوثيق واعتماد متطلبات الامن السيبراني الادارة الاصول المعلوماتية والتقنية للجهة.', NULL, 'ECC 2-1-1', 'Not Applicable', 34, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(62, 'ECC 2-1-2', 'ECC 2-1-2', 'يجب تطبيق متطلبات الامن السيبراني الادارة الاصول المعلوماتية والتقنية للجهة', NULL, 'ECC 2-1-2', 'Not Applicable', 34, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(63, 'ECC 2-1-3', 'ECC 2-1-3', 'يجب تحديد وتوثيق واعتماد ونشر سياسة الستخدام المقبول للاصول المعلوماتية والتقنية للجهة', NULL, 'ECC 2-1-3', 'Not Applicable', 34, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(64, 'ECC 2-1-4', 'ECC 2-1-4', 'يجب تطبيق سياسة الاستخدام المقبول للاصول المعلوماتية والتقنية للجهة', NULL, 'ECC 2-1-4', 'Not Applicable', 34, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(65, 'ECC 2-1-5', 'ECC 2-1-5', 'يجب تصنيف الاصول المعلوماتية والتقنية للجهة وترميزها )Labeling )والتعامل معها وفقاً للمتطلبات\r\nالتشريعية والتنظيمية ذات العلاقة', NULL, 'ECC 2-1-5', 'Not Applicable', 34, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(66, 'ECC 2-1-6', 'ECC 2-1-6', 'يجب مراجعة متطلبات الامن السيبراني لادارة الاصول المعلوماتية والتقنية للجهة دورياً', NULL, 'ECC 2-1-6', 'Not Applicable', 34, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(67, 'ECC 2-2-1', 'ECC 2-2-1', 'يجب تحديد وتوثيق واعتماد متطلبات الامن السيبراني لادارة هويات الدخول والصلاحيات في الجهة', NULL, 'ECC 2-2-1', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(68, 'ECC 2-2-2', 'ECC 2-2-2', 'يجب تطبيق متطلبات الامن السيبراني لادارة هويات الدخول والصلاحيات في الجهة', NULL, 'ECC 2-2-2', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(69, 'ECC 2-2-3', 'ECC 2-2-3', 'يجب أن تغطي متطلبات الامن السيبراني المتعلقة بـإدارة هويات الدخول والصلاحيات في الجهة', NULL, 'ECC 2-2-3', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(70, 'ECC 2-2-3-1', 'ECC 2-2-3-1', 'يجب أن تغطي متطلبات الامن السيبراني المتعلقة بـإدارة هويات الدخول والصلاحيات في الجهة بحد\r\nأدنى  بناء( User Authentication( المستخدم هوية من ا  على إدارة تسجيل المستخدم وإدارة كلمة المرور', NULL, 'ECC 2-2-3-1', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, 69, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(71, 'ECC 2-2-3-2', 'ECC 2-2-3-2', 'يجب أن تغطي متطلبات الامن السيبراني المتعلقة بـإدارة هويات الدخول والصلاحيات في الجهة بحد\r\nأدنى  التحقق من الهوية متعدد العناصر )Authentication Factor-Multi )لعمليات الدخول عن بعد', NULL, 'ECC 2-2-3-2', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, 69, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(72, 'ECC 2-2-3-3', 'ECC 2-2-3-3', 'يجب أن تغطي متطلبات الامن السيبراني المتعلقة بـإدارة هويات الدخول والصلاحيات في الجهة بحد\r\nأدنى   إدارة تصاريح وصلاحيات المستخدمين )Authorization )بناء على مبادئ التحكم بالدخول ،\"Need-to-know and Need-to-use\" والستخدام المعرفة إلى الحاجة مبدأ )و  ومـبـدأ الحد الادنــى مـن الصلاحيات والامـتـيـازات \"Privilege Least ،\"ومـبـدأ فصل المهام  .)\"Segregation of Duties\"', NULL, 'ECC 2-2-3-3', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, 69, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(73, 'ECC 2-2-3-4', 'ECC 2-2-3-4', 'يجب أن تغطي متطلبات الامن السيبراني المتعلقة بـإدارة هويات الدخول والصلاحيات في الجهة بحد\r\nأدنى  .)Privileged Access Management( والحساسة الهامة الاصلاحى  .)Privileged Access Management( والحساسة الهامة الصلاحيايات الإدارة', NULL, 'ECC 2-2-3-4', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, 69, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(74, 'ECC 2-2-3-5', 'ECC 2-2-3-5', 'يجب أن تغطي متطلبات الامن السيبراني المتعلقة بـإدارة هويات الدخول والصلاحيات في الجهة بحد\r\nأدنى  المراجعة الدورية لهويات الدخول والصلاحيات', NULL, 'ECC 2-2-3-5', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, 69, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(75, 'ECC 2-2-4', 'ECC 2-2-4', 'يجب مراجعة تطبيق متطلبات الامن السيبراني لادارة هويات الدخول والصلاحيات في الجهة دورياً', NULL, 'ECC 2-2-4', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(76, 'ECC 2-3-1', 'ECC 2-3-1', 'يجب تحديد وتوثيق واعتماد متطلبات الامن السيبراني لحماية المنظمة وأجهزة معالجة المعلومات للجهة', NULL, 'ECC 2-3-1', 'Not Applicable', 36, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(77, 'ECC 2-3-2', 'ECC 2-3-2', 'يجب تطبيق متطلبات الامن السيبراني لحماية المنظمة وأجهزة معالجة المعلومات للجهة.', NULL, 'ECC 2-3-2', 'Not Applicable', 36, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(78, 'ECC 2-3-3', 'ECC 2-3-3', 'يجب أن تغطي متطلبات الامن السيبراني لحماية المنظمة وأجهزة معالجة المعلومات للجهة', NULL, 'ECC 2-3-3', 'Not Applicable', 36, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(79, 'ECC 2-3-3-1', 'ECC 2-3-3-1', 'يجب أن تغطي متطلبات الامن السيبراني لحماية المنظمة وأجهزة معالجة المعلومات للجهة بحد أدنى  الحماية من الفيروسات والبرامج والنشطة المشبوهة والبرمجيات الضارة )Malware )على\r\nأجهزة المستخدمين والخوادم باستخدام تقنيات وآليات الحماية الحديثة والمتقدمة، وإدارتها\r\nبشكل آمن', NULL, 'ECC 2-3-3-1', 'Not Applicable', 36, 1, NULL, NULL, NULL, 1, NULL, NULL, 78, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(80, 'ECC 2-3-3-2', 'ECC 2-3-3-2', 'يجب أن تغطي متطلبات الامن السيبراني لحماية المنظمة وأجهزة معالجة المعلومات للجهة بحد أدنى  التقييد الحازم لستخدام أجهزة وسائط التخزين الخارجية والامن المتعلق بها.', NULL, 'ECC 2-3-3-2', 'Not Applicable', 36, 1, NULL, NULL, NULL, 1, NULL, NULL, 78, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(81, 'ECC 2-3-3-3', 'ECC 2-3-3-3', 'يجب أن تغطي متطلبات الامن السيبراني لحماية المنظمة وأجهزة معالجة المعلومات للجهة بحد أدنى إدارة حزم التحديثات والصلاحات للمنظمة والتطبيقات والاجهزة )Management Patch.', NULL, 'ECC 2-3-3-3', 'Not Applicable', 36, 1, NULL, NULL, NULL, 1, NULL, NULL, 78, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(82, 'ECC 2-3-3-4', 'ECC 2-3-3-4', 'يجب أن تغطي متطلبات الامن السيبراني لحماية المنظمة وأجهزة معالجة المعلومات للجهة بحد أدنى  مزامنة التوقيت )Synchronization Clock )مركزياً ومن مصدر دقيق وموثوق، ومن هذه\r\nالمصادر ما توفره الهيئة السعودية للمواصفات والمقاييس والجودة.', NULL, 'ECC 2-3-3-4', 'Not Applicable', 36, 1, NULL, NULL, NULL, 1, NULL, NULL, 78, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(83, 'ECC 2-3-4', 'ECC 2-3-4', 'يجب مراجعة متطلبات الامن السيبراني لحماية المنظمة وأجهزة معالجة المعلومات للجهة دورياً', NULL, 'ECC 2-3-4', 'Not Applicable', 36, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(84, 'ECC 2-4-1', 'ECC 2-4-1', 'جب تحديد وتوثيق واعتماد متطلبات الامن السيبراني لحماية البريد الالكتروني للجهة.', NULL, 'ECC 2-4-1', 'Not Applicable', 37, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(85, 'ECC 2-4-2', 'ECC 2-4-2', 'يجب تطبيق متطلبات الامن السيبراني لحماية البريد الالكتروني للجهة', NULL, 'ECC 2-4-2', 'Not Applicable', 37, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(86, 'ECC 2-4-3', 'ECC 2-4-3', 'يجب أن تغطي متطلبات الامن السيبراني لحماية البريد الالكتروني للجهة', NULL, 'ECC 2-4-3', 'Not Applicable', 37, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(87, 'ECC 2-4-3-1', 'ECC 2-4-3-1', 'يجب أن تغطي متطلبات الامن السيبراني لحماية البريد الالكتروني للجهة بحد أدنى  تحليل وتصفية )Filtering ) ّ رسـائـل البريد الالكتروني )وخـصـوصـاً رسـائـل التصيد الالكتروني\r\n»Emails Phishing »والرسائل القتحامية »Emails Spam )»باستخدام تقنيات وآليات\r\nالحماية الحديثة والمتقدمة للبريد الالكتروني.', NULL, 'ECC 2-4-3-1', 'Not Applicable', 37, 1, NULL, NULL, NULL, 1, NULL, NULL, 86, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(88, 'ECC 2-4-3-2', 'ECC 2-4-3-2', 'يجب أن تغطي متطلبات الامن السيبراني لحماية البريد الالكتروني للجهة بحد أدنى التحقق من الهوية متعدد العناصر )Authentication Factor-Multi )للدخول عن بعد والدخول\r\nعن طريق صفحة موقع البريد الالكتروني )Webmail.', NULL, 'ECC 2-4-3-2', 'Not Applicable', 37, 1, NULL, NULL, NULL, 1, NULL, NULL, 86, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(89, 'ECC 2-4-3-3', 'ECC 2-4-3-3', 'يجب أن تغطي متطلبات الامن السيبراني لحماية البريد الالكتروني للجهة بحد أدنى النسخ الاحتياطي والرشفة للبريد الالكتروني.', NULL, 'ECC 2-4-3-3', 'Not Applicable', 37, 1, NULL, NULL, NULL, 1, NULL, NULL, 86, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(90, 'ECC 2-4-3-4', 'ECC 2-4-3-4', 'يجب أن تغطي متطلبات الامن السيبراني لحماية البريد الالكتروني للجهة بحد أدنى لحماية من التهديدات المتقدمة المستمرة )Protection APT ،)التي تستخدم عادة الفيروسات\r\nوالبرمجيات الضارة غير المعروفة مسبقاً )Malware Day-Zero ،)وإدارتها بشكل آمن', NULL, 'ECC 2-4-3-4', 'Not Applicable', 37, 1, NULL, NULL, NULL, 1, NULL, NULL, 86, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(91, 'ECC 2-4-3-5', 'ECC 2-4-3-5', 'يجب أن تغطي متطلبات الامن السيبراني لحماية البريد الالكتروني للجهة بحد أدنى توثيق مجال البريد الالكتروني للجهة بالطرق التقنية، مثل طريقة إطار سياسة المرسل )Sender\r\n.)Policy Framework', NULL, 'ECC 2-4-3-5', 'Not Applicable', 37, 1, NULL, NULL, NULL, 1, NULL, NULL, 86, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(92, 'ECC 2-4-4', 'ECC 2-4-4', 'يجب مراجعة تطبيق متطلبات الامن السيبراني الخاصة بحماية البريد الالكتروني للجهة دورياً.', NULL, 'ECC 2-4-4', 'Not Applicable', 37, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(93, 'ECC 2-5-1', 'ECC 2-5-1', 'يجب تحديد وتوثيق واعتماد متطلبات الامن السيبراني لادارة أمن شبكات الجهة.', NULL, 'ECC 2-5-1', 'Not Applicable', 38, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(94, 'ECC 2-5-2', 'ECC 2-5-2', 'يجب تطبيق متطلبات الامن السيبراني لادارة أمن شبكات الجهة.', NULL, 'ECC 2-5-2', 'Not Applicable', 38, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(95, 'ECC 2-5-3', 'ECC 2-5-3', 'يجب أن تغطي متطلبات الامن السيبراني لادارة أمن شبكات الجهة', NULL, 'ECC 2-5-3', 'Not Applicable', 38, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(96, 'ECC 2-5-3-1', 'ECC 2-5-3-1', 'يجب أن تغطي متطلبات الامن السيبراني لادارة أمن شبكات الجهة بحد أدنى العزل والتقسيم المادي أو المنطقي لجزاء الشبكات بشكل آمن، والالزم للسيطرة على مخاطر\r\nالامن السيبراني ذات العلاقة، باستخدام جدار الحماية )Firewall )ومبدأ الدفاع الامني متعدد\r\n.)Defense-in-Depth( الامر', NULL, 'ECC 2-5-3-1', 'Not Applicable', 38, 1, NULL, NULL, NULL, 1, NULL, NULL, 95, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(97, 'ECC 2-5-3-2', 'ECC 2-5-3-2', 'يجب أن تغطي متطلبات الامن السيبراني لادارة أمن شبكات الجهة بحد أدنى  عزل شبكة بيئة النتاج عن شبكات بيئات التطوير والاختبار', NULL, 'ECC 2-5-3-2', 'Not Applicable', 38, 1, NULL, NULL, NULL, 1, NULL, NULL, 95, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(98, 'ECC 2-5-3-3', 'ECC 2-5-3-3', 'يجب أن تغطي متطلبات الامن السيبراني لادارة أمن شبكات الجهة بحد أدنى أمن التصفح والاتصال بالانترنت، ويشمل ذلك التقييد الحازم للمواقع الالكترونية المشبوهة،\r\nومواقع مشاركة وتخزين الملفات، ومواقع الدخول عن بعد', NULL, 'ECC 2-5-3-3', 'Not Applicable', 38, 1, NULL, NULL, NULL, 1, NULL, NULL, 95, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(99, 'ECC 2-5-3-4', 'ECC 2-5-3-4', 'يجب أن تغطي متطلبات الامن السيبراني لادارة أمن شبكات الجهة بحد أدنى أمن الشبكات الالسلكية وحمايتها باستخدام وسائل آمنة للتحقق من الهوية والتشفير، وعدم\r\nً على دراسة متكاملة للمخاطر المترتبة\r\nربط الشبكات الالسلكية بشبكة الجهة الداخلية إل بناء\r\nعلى ذلك والتعامل معها بما يضمن حماية الاصول التقنية للجهة', NULL, 'ECC 2-5-3-4', 'Not Applicable', 38, 1, NULL, NULL, NULL, 1, NULL, NULL, 95, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(100, 'ECC 2-5-3-5', 'ECC 2-5-3-5', 'يجب أن تغطي متطلبات الامن السيبراني لادارة أمن شبكات الجهة بحد أدنى قيود وإدارة منافذ وبروتوكولت وخدمات الشبكة', NULL, 'ECC 2-5-3-5', 'Not Applicable', 38, 1, NULL, NULL, NULL, 1, NULL, NULL, 95, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(101, 'ECC 2-5-3-6', 'ECC 2-5-3-6', 'يجب أن تغطي متطلبات الامن السيبراني لادارة أمن شبكات الجهة بحد أدنى )Intrusion Prevention Systems( الختراقات ومنع لكتشاف المتقدمة الحماية أ', NULL, 'ECC 2-5-3-6', 'Not Applicable', 38, 1, NULL, NULL, NULL, 1, NULL, NULL, 95, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(102, 'ECC 2-5-3-7', 'ECC 2-5-3-7', 'يجب أن تغطي متطلبات الامن السيبراني لادارة أمن شبكات الجهة بحد أدنى .)DNS( النطاقات أسماء نظام أ', NULL, 'ECC 2-5-3-7', 'Not Applicable', 38, 1, NULL, NULL, NULL, 1, NULL, NULL, 95, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(103, 'ECC 2-5-3-8', 'ECC 2-5-3-8', 'يجب أن تغطي متطلبات الامن السيبراني لادارة أمن شبكات الجهة بحد أدنى حماية قناة تصفح الانترنت من التهديدات المتقدمة المستمرة )Protection APT ،)التي\r\nتستخدم عادة الفيروسات والبرمجيات الضارة غير المعروفة مسبقاً )Malware Day-Zero ،)\r\nوإدارتها بشكل آمن.', NULL, 'ECC 2-5-3-8', 'Not Applicable', 38, 1, NULL, NULL, NULL, 1, NULL, NULL, 95, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(104, 'ECC 2-5-4', 'ECC 2-5-4', 'يجب مراجعة تطبيق متطلبات الامن السيبراني لادارة أمن شبكات الجهة دورياً.', NULL, 'ECC 2-5-4', 'Not Applicable', 38, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(105, 'ECC 2-6-1', 'ECC 2-6-1', 'يجب تحديد وتوثيق واعتماد متطلبات الامن السيبراني الخاصة بأمن الجهزة المحمولة والاجهزة الشخصية\r\n للعاملين )BYOD )عند ارتباطها بشبكة الجهة.', NULL, 'ECC 2-6-1', 'Not Applicable', 39, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(106, 'ECC 2-6-2', 'ECC 2-6-2', 'يجب تطبيق متطلبات الامن السيبراني الخاصة بأمن الجهزة المحمولة وأجهزة )BYOD )للجهة.', NULL, 'ECC 2-6-2', 'Not Applicable', 39, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(107, 'ECC 2-6-3', 'ECC 2-6-3', 'يجب أن تغطي متطلبات الامن السيبراني الخاصة بأمن الاجهزة المحمولة وأجهزة )BYOD )للجهة', NULL, 'ECC 2-6-3', 'Not Applicable', 39, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(108, 'ECC 2-6-3-1', 'ECC 2-6-3-1', 'يجب أن تغطي متطلبات الامن السيبراني الخاصة بأمن الاجهزة المحمولة وأجهزة )BYOD )للجهة بحد\r\nأدنى فصل وتشفير البيانات والمعلومات )الخاصة بالجهة( المخزنة على الجهزة المحمولة وأجهزة\r\n.)BYOD(', NULL, 'ECC 2-6-3-1', 'Not Applicable', 39, 1, NULL, NULL, NULL, 1, NULL, NULL, 107, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(109, 'ECC 2-6-3-2', 'ECC 2-6-3-2', 'يجب أن تغطي متطلبات الامن السيبراني الخاصة بأمن الاجهزة المحمولة وأجهزة )BYOD )للجهة بحد\r\nأدنى  الستخدام المحدد والمقيد بناء  على ما تتطلبه مصلحة أعمال الجهة', NULL, 'ECC 2-6-3-2', 'Not Applicable', 39, 1, NULL, NULL, NULL, 1, NULL, NULL, 107, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(110, 'ECC 2-6-3-3', 'ECC 2-6-3-3', 'يجب أن تغطي متطلبات الامن السيبراني الخاصة بأمن الاجهزة المحمولة وأجهزة )BYOD )للجهة بحد\r\nأدنى حذف البيانات والمعلومات )الخاصة بالجهة( المخزنة على الجهزة المحمولة وأجهزة )BYOD )\r\nعند فقدان الجهزة أو بعد انتهاء\\/إنهاء العلقة الوظيفية مع الجهة.', NULL, 'ECC 2-6-3-3', 'Not Applicable', 39, 1, NULL, NULL, NULL, 1, NULL, NULL, 107, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(111, 'ECC 2-6-3-4', 'ECC 2-6-3-4', 'يجب أن تغطي متطلبات الامن السيبراني الخاصة بأمن الاجهزة المحمولة وأجهزة )BYOD )للجهة بحد\r\nأدنى  لمستخدمين الامنية ا', NULL, 'ECC 2-6-3-4', 'Not Applicable', 39, 1, NULL, NULL, NULL, 1, NULL, NULL, 107, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(112, 'ECC 2-6-4', 'ECC 2-6-4', 'يجب مراجعة تطبيق متطلبات الامن السيبراني الخاصة لامن الاجهزة المحمولة وأجهزة )BYOD )للجهة\r\n.ًدوري', NULL, 'ECC 2-6-4', 'Not Applicable', 39, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(113, 'ECC 2-7-1', 'ECC 2-7-1', 'يجب تحديد وتوثيق واعتماد متطلبات الامن السيبراني لحماية بيانات ومعلومات الجهة، والتعامل معها\r\n وفقاً للمتطلبات التشريعية والتنظيمية ذات العلاقة.', NULL, 'ECC 2-7-1', 'Not Applicable', 40, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(114, 'ECC 2-7-2', 'ECC 2-7-2', 'يجب تطبيق متطلبات الامن السيبراني لحماية بيانات ومعلومات الجهة.', NULL, 'ECC 2-7-2', 'Not Applicable', 40, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(115, 'ECC 2-7-3', 'ECC 2-7-3', 'يجب أن تغطي متطلبات الامن السيبراني لحماية البيانات والمعلومات', NULL, 'ECC 2-7-3', 'Not Applicable', 40, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(116, 'ECC 2-7-3-1', 'ECC 2-7-3-1', 'يجب أن تغطي متطلبات الامن السيبراني لحماية البيانات والمعلومات بحد أدنى .والمعلومات البيانات ملكية', NULL, 'ECC 2-7-3-1', 'Not Applicable', 40, 1, NULL, NULL, NULL, 1, NULL, NULL, 115, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(117, 'ECC 2-7-3-2', 'ECC 2-7-3-2', 'يجب أن تغطي متطلبات الامن السيبراني لحماية البيانات والمعلومات بحد أدنى )Classifcation and Labeling Mechanisms( ترميزها وآلية والمعلومات البيانات ت', NULL, 'ECC 2-7-3-2', 'Not Applicable', 40, 1, NULL, NULL, NULL, 1, NULL, NULL, 115, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(118, 'ECC 2-7-3-3', 'ECC 2-7-3-3', 'جب أن تغطي متطلبات الامن السيبراني لحماية البيانات والمعلومات بحد أدنى والمعلومات البيانات خصوصية', NULL, 'ECC 2-7-3-3', 'Not Applicable', 40, 1, NULL, NULL, NULL, 1, NULL, NULL, 115, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(119, 'ECC 2-7-4', 'ECC 2-7-4', 'يجب مراجعة تطبيق متطلبات الامن السيبراني لحماية بيانات ومعلومات الجهة دورياً.', NULL, 'ECC 2-7-4', 'Not Applicable', 40, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(120, 'ECC 2-8-1', 'ECC 2-8-1', 'يجب تحديد وتوثيق واعتماد متطلبات الامن السيبراني للتشفير في الجهة.', NULL, 'ECC 2-8-1', 'Not Applicable', 41, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(121, 'ECC 2-8-2', 'ECC 2-8-2', 'يجب تطبيق متطلبات الامن السيبراني للتشفير في الجهة', NULL, 'ECC 2-8-2', 'Not Applicable', 41, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(122, 'ECC 2-8-3', 'ECC 2-8-3', 'جب أن تغطي متطلبات الامن السيبراني للتشفير', NULL, 'ECC 2-8-3', 'Not Applicable', 41, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(123, 'ECC 2-8-3-1', 'ECC 2-8-3-1', 'يجب أن تغطي متطلبات الامن السيبراني للتشفير بحد أدنى معايير حلول التشفير المعتمدة والقيود المطبقة عليها )تقنياً وتنظيمياً(.', NULL, 'ECC 2-8-3-1', 'Not Applicable', 41, 1, NULL, NULL, NULL, 1, NULL, NULL, 122, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(124, 'ECC 2-8-3-2', 'ECC 2-8-3-2', 'يجب أن تغطي متطلبات الامن السيبراني للتشفير بحد أدنى الادارة الامنة لمفاتيح التشفير خلل عمليات دورة حياتها.', NULL, 'ECC 2-8-3-2', 'Not Applicable', 41, 1, NULL, NULL, NULL, 1, NULL, NULL, 122, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(125, 'ECC 2-8-3-3', 'ECC 2-8-3-3', 'يجب أن تغطي متطلبات الامن السيبراني للتشفير بحد أدنى  تشفير البيانات أثناء النقل والتخزين بناء على تصنيفها وحسب المتطلبات التشريعية والتنظيمية\r\nذات العلاقة', NULL, 'ECC 2-8-3-3', 'Not Applicable', 41, 1, NULL, NULL, NULL, 1, NULL, NULL, 122, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(126, 'ECC 2-8-4', 'ECC 2-8-4', 'جب مراجعة تطبيق متطلبات الامن السيبراني للتشفير في الجهة دورياً.', NULL, 'ECC 2-8-4', 'Not Applicable', 41, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(127, 'ECC 2-9-1', 'ECC 2-9-1', 'يجب تحديد وتوثيق واعتماد متطلبات الامن السيبراني لادارة النسخ الاحتياطية للجهة', NULL, 'ECC 2-9-1', 'Not Applicable', 42, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(128, 'ECC 2-9-2', 'ECC 2-9-2', 'يجب تطبيق متطلبات الامن السيبراني لادارة النسخ الاحتياطية للجهة.', NULL, 'ECC 2-9-2', 'Not Applicable', 42, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(129, 'ECC 2-9-3', 'ECC 2-9-3', 'يجب أن تغطي متطلبات الامن السيبراني لادارة النسخ الاحتياطية', NULL, 'ECC 2-9-3', 'Not Applicable', 42, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(130, 'ECC 2-9-3-1', 'ECC 2-9-3-1', 'يجب أن تغطي متطلبات الامن السيبراني لادارة النسخ الاحتياطية بحد أدنى  1 نطاق النسخ الااحتياطية وشموليتها للصول المعلوماتية والتقنية الحساسة.', NULL, 'ECC 2-9-3-1', 'Not Applicable', 42, 1, NULL, NULL, NULL, 1, NULL, NULL, 129, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(131, 'ECC 2-9-3-2', 'ECC 2-9-3-2', 'يجب أن تغطي متطلبات الامن السيبراني لادارة النسخ الاحتياطية بحد أدنى  القدرة السريعة على استعادة البيانات والانظمة بعد التعرض لحوادث الامن السيبراني', NULL, 'ECC 2-9-3-2', 'Not Applicable', 42, 1, NULL, NULL, NULL, 1, NULL, NULL, 129, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(132, 'ECC 2-9-3-3', 'ECC 2-9-3-3', 'يجب أن تغطي متطلبات الامن السيبراني لادارة النسخ الاحتياطية بحد أدنى إجراء فحص دوري لمدى فعالية استعادة النسخ الاحتياطية.', NULL, 'ECC 2-9-3-3', 'Not Applicable', 42, 1, NULL, NULL, NULL, 1, NULL, NULL, 129, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(133, 'ECC 2-9-4', 'ECC 2-9-4', 'يجب مراجعة تطبيق متطلبات الامن السيبراني لادارة النسخ الاحتياطية للجهة.', NULL, 'ECC 2-9-4', 'Not Applicable', 42, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(134, 'ECC 2-10-1', 'ECC 2-10-1', 'يجب تحديد وتوثيق واعتماد متطلبات الامن السيبراني لادارة الثغرات التقنية للجهة.', NULL, 'ECC 2-10-1', 'Not Applicable', 43, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(135, 'ECC 2-10-2', 'ECC 2-10-2', 'يجب تطبيق متطلبات الامن السيبراني لادارة الثغرات التقنية للجهة.', NULL, 'ECC 2-10-2', 'Not Applicable', 43, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(136, 'ECC 2-10-3', 'ECC 2-10-3', 'يجب أن تغطي متطلبات الامن السيبراني لادارة الثغرات', NULL, 'ECC 2-10-3', 'Not Applicable', 43, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(137, 'ECC 2-10-3-1', 'ECC 2-10-3-1', 'يجب أن تغطي متطلبات المن السيبراني لدارة الثغرات بحد أدنى  فحص واكتشاف الثغرات دورياً.', NULL, 'ECC 2-10-3-1', 'Not Applicable', 43, 1, NULL, NULL, NULL, 1, NULL, NULL, 136, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(138, 'ECC 2-10-3-2', 'ECC 2-10-3-2', 'يجب أن تغطي متطلبات الامن السيبراني لادارة الثغرات بحد أدنى تصنيف الثغرات حسب خطورتها', NULL, 'ECC 2-10-3-2', 'Not Applicable', 43, 1, NULL, NULL, NULL, 1, NULL, NULL, 136, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(139, 'ECC 2-10-3-3', 'ECC 2-10-3-3', 'يجب أن تغطي متطلبات الامن السيبراني لادارة الثغرات بحد أدنى على تصنيفها والمخاطر السيبرانية المترتبة عليها.\r\nبناء الثغرات م', NULL, 'ECC 2-10-3-3', 'Not Applicable', 43, 1, NULL, NULL, NULL, 1, NULL, NULL, 136, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(140, 'ECC 2-10-3-4', 'ECC 2-10-3-4', 'يجب أن تغطي متطلبات الامن السيبراني لادارة الثغرات بحد أدنى   إدارة حزم التحديثات والصلاحيات الامنية لمعالجة الثغرات', NULL, 'ECC 2-10-3-4', 'Not Applicable', 43, 1, NULL, NULL, NULL, 1, NULL, NULL, 136, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(141, 'ECC 2-10-3-5', 'ECC 2-10-3-5', 'يجب أن تغطي متطلبات الامن السيبراني لادارة الثغرات بحد أدنى  التواصل والاشتراك مع مصادر موثوقة فيما يتعلق بالتنبيهات المتعلقة بالثغرات الجديدة\r\nوالمحدثة.', NULL, 'ECC 2-10-3-5', 'Not Applicable', 43, 1, NULL, NULL, NULL, 1, NULL, NULL, 136, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(142, 'ECC 2-10-4', 'ECC 2-10-4', 'يجب مراجعة تطبيق متطلبات الامن السيبراني لادارة الثغرات التقنية للجهة دورياً.', NULL, 'ECC 2-10-4', 'Not Applicable', 43, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(143, 'ECC 2-11-1', 'ECC 2-11-1', 'يجب تحديد وتوثيق واعتماد متطلبات الامن السيبراني لعمليات اختبار الاختراق في الجهة', NULL, 'ECC 2-11-1', 'Not Applicable', 44, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(144, 'ECC 2-11-2', 'ECC 2-11-2', 'يجب تنفيذ عمليات اختبار الاختراق في الجهة', NULL, 'ECC 2-11-2', 'Not Applicable', 44, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(145, 'ECC 2-11-3', 'ECC 2-11-3', 'يجب أن تغطي متطلبات الامن السيبراني لختبار الاختراق', NULL, 'ECC 2-11-3', 'Not Applicable', 44, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(146, 'ECC 2-11-3-1', 'ECC 2-11-3-1', 'يجب أن تغطي متطلبات الامن السيبراني لختبار الاختراق بحد أدنى نطاق عمل اختبار الاخـتـراق، ليشمل جميع الخدمات المقدمة خارجياً )عـن طريق الانترنت(\r\nومكوناتها التقنية، ومنها => البنية التحتية، المواقع الالكترونية، تطبيقات الويب، تطبيقات الهواتف\r\nالذكية والاوحية، البريد الالكتروني والدخول عن بعد.', NULL, 'ECC 2-11-3-1', 'Not Applicable', 44, 1, NULL, NULL, NULL, 1, NULL, NULL, 145, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(147, 'ECC 2-11-3-2', 'ECC 2-11-3-2', 'يجب أن تغطي متطلبات الامن السيبراني لختبار الاختراق بحد أدنى عمل اختبار الاختراق دورياً', NULL, 'ECC 2-11-3-2', 'Not Applicable', 44, 1, NULL, NULL, NULL, 1, NULL, NULL, 145, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(148, 'ECC 2-11-4', 'ECC 2-11-4', 'يجب مراجعة تطبيق متطلبات الامن السيبراني لعمليات اختبار الاختراق في الجهة دورياً.', NULL, 'ECC 2-11-4', 'Not Applicable', 44, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(149, 'ECC 2-12-1', 'ECC 2-12-1', 'يجب تحديد وتوثيق واعتماد متطلبات إدارة سجلت الاحداث ومراقبة الامن السيبراني للجهة.', NULL, 'ECC 2-12-1', 'Not Applicable', 45, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(150, 'ECC 2-12-2', 'ECC 2-12-2', 'يجب تطبيق متطلبات إدارة سجلت الاحداث ومراقبة الامن السيبراني للجهة.', NULL, 'ECC 2-12-2', 'Not Applicable', 45, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(151, 'ECC 2-12-3', 'ECC 2-12-3', 'يجب أن تغطي متطلبات إدارة سجلت الاحداث ومراقبة الامن السيبراني', NULL, 'ECC 2-12-3', 'Not Applicable', 45, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(152, 'ECC 2-12-3-1', 'ECC 2-12-3-1', 'يجب أن تغطي متطلبات إدارة سجلت الأحداث ومراقبة الامن السيبراني بحد أدنى', NULL, 'ECC 2-12-3-1', 'Not Applicable', 45, 1, NULL, NULL, NULL, 1, NULL, NULL, 151, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(153, 'ECC 2-12-3-2', 'ECC 2-12-3-2', 'يجب أن تغطي متطلبات إدارة سجلت الاحداث ومراقبة الامن السيبراني بحد أدنى تفعيل سجلت الاحـداث الخاصة بالحسابات ذات الصلاحيات الهامة والحساسة على الاصول\r\nالمعلوماتية وأحداث عمليات الدخول عن بعد لدى الجهة', NULL, 'ECC 2-12-3-2', 'Not Applicable', 45, 1, NULL, NULL, NULL, 1, NULL, NULL, 151, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(154, 'ECC 2-12-3-3', 'ECC 2-12-3-3', 'يجب أن تغطي متطلبات إدارة سجلات الاحداث ومراقبة الامن السيبراني بحد أدنى تحديد التقنيات الازمة )SIEM )لجمع سجلات الاحداث الخاصة بالامن السيبراني', NULL, 'ECC 2-12-3-3', 'Not Applicable', 45, 1, NULL, NULL, NULL, 1, NULL, NULL, 151, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(155, 'ECC 2-12-3-4', 'ECC 2-12-3-4', 'يجب أن تغطي متطلبات إدارة سجلات الاحداث ومراقبة الامن السيبراني بحد أدنى المراقبة المستمرة لسجلات الاحداث الخاصة بالامن السيبراني.', NULL, 'ECC 2-12-3-4', 'Not Applicable', 45, 1, NULL, NULL, NULL, 1, NULL, NULL, 151, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(156, 'ECC 2-12-3-5', 'ECC 2-12-3-5', 'يجب أن تغطي متطلبات إدارة سجلات الاحداث ومراقبة الامن السيبراني بحد أدنى مدة الاحتفاظ بسجلات الاحداث الخاصة بالامن السيبراني )على أل تقل عن 12 شهر(.', NULL, 'ECC 2-12-3-5', 'Not Applicable', 45, 1, NULL, NULL, NULL, 1, NULL, NULL, 151, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(157, 'ECC 2-12-4', 'ECC 2-12-4', 'يجب مراجعة تطبيق متطلبات إدارة سجلات الاحداث ومراقبة الامن السيبراني في الجهة دورياً.', NULL, 'ECC 2-12-4', 'Not Applicable', 45, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(158, 'ECC 2-13-1', 'ECC 2-13-1', 'يجب تحديد وتوثيق واعتماد متطلبات إدارة حوادث وتهديدات الامن السيبراني في الجهة', NULL, 'ECC 2-13-1', 'Not Applicable', 46, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(159, 'ECC 2-13-2', 'ECC 2-13-2', 'يجب تطبيق متطلبات إدارة حوادث وتهديدات الامن السيبراني في الجهة.', NULL, 'ECC 2-13-2', 'Not Applicable', 46, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(160, 'ECC 2-13-3', 'ECC 2-13-3', 'يجب أن تغطي متطلبات إدارة حوادث وتهديدات الامن السيبراني', NULL, 'ECC 2-13-3', 'Not Applicable', 46, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL);
INSERT INTO `framework_controls` (`id`, `short_name`, `long_name`, `description`, `supplemental_guidance`, `control_number`, `control_status`, `family`, `control_owner`, `desired_maturity`, `control_priority`, `control_class`, `control_maturity`, `control_phase`, `control_type`, `parent_id`, `submission_date`, `last_audit_date`, `next_audit_date`, `desired_frequency`, `mitigation_percent`, `status`, `deleted`, `created_at`, `updated_at`) VALUES
(161, 'ECC 2-13-3-1', 'ECC 2-13-3-1', 'يجب أن تغطي متطلبات إدارة حوادث وتهديدات الامن السيبراني بحد أدنى  وضع خطط الاستجابة للحوادث الامنية وآليات التصعيد.', NULL, 'ECC 2-13-3-1', 'Not Applicable', 46, 1, NULL, NULL, NULL, 1, NULL, NULL, 160, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(162, 'ECC 2-13-3-2', 'ECC 2-13-3-2', 'يجب أن تغطي متطلبات إدارة حوادث وتهديدات الامن السيبراني بحد أدنى تصنيف حوادث الامن السيبراني', NULL, 'ECC 2-13-3-2', 'Not Applicable', 46, 1, NULL, NULL, NULL, 1, NULL, NULL, 160, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(163, 'ECC 2-13-3-3', 'ECC 2-13-3-3', 'يجب أن تغطي متطلبات إدارة حوادث وتهديدات الامن السيبراني بحد أدنى  تبليغ الهيئة عند حدوث حادثة أمن سيبراني', NULL, 'ECC 2-13-3-3', 'Not Applicable', 46, 1, NULL, NULL, NULL, 1, NULL, NULL, 160, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(164, 'ECC 2-13-3-4', 'ECC 2-13-3-4', 'يجب أن تغطي متطلبات إدارة حوادث وتهديدات الامن السيبراني بحد أدنى مشاركة التنبيهات والمعلومات الستباقية ومؤشرات الاختراق وتقارير حوادث الامن السيبراني\r\nمع الهيئة', NULL, 'ECC 2-13-3-4', 'Not Applicable', 46, 1, NULL, NULL, NULL, 1, NULL, NULL, 160, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(165, 'ECC 2-13-3-5', 'ECC 2-13-3-5', 'يجب أن تغطي متطلبات إدارة حوادث وتهديدات الامن السيبراني بحد أدنى الحصول على المعلومات الاستباقية )Intelligence Threat )والتعامل معها.', NULL, 'ECC 2-13-3-5', 'Not Applicable', 46, 1, NULL, NULL, NULL, 1, NULL, NULL, 160, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(166, 'ECC 2-13-4', 'ECC 2-13-4', 'يجب مراجعة تطبيق متطلبات إدارة حوادث وتهديدات الامن السيبراني في الجهة دورياً.', NULL, 'ECC 2-13-4', 'Not Applicable', 46, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(167, 'ECC 2-14-1', 'ECC 2-14-1', 'يجب تحديد وتوثيق واعتماد متطلبات الامن السيبراني لحماية الاصول المعلوماتية والتقنية للجهة من\r\nالوصول المادي غير المصرح به والفقدان والسرقة والتخريب.', NULL, 'ECC 2-14-1', 'Not Applicable', 47, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(168, 'ECC 2-14-2', 'ECC 2-14-2', 'يجب تطبيق متطلبات الامن السيبراني لحماية الاصول المعلوماتية والتقنية للجهة من الوصول المادي\r\nغير المصرح به والفقدان والسرقة والتخريب', NULL, 'ECC 2-14-2', 'Not Applicable', 47, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(169, 'ECC 2-14-3', 'ECC 2-14-3', 'يجب أن تغطي متطلبات الامن السيبراني لحماية الاصول المعلوماتية والتقنية للجهة من الوصول المادي\r\nغير المصرح به والفقدان والسرقة والتخريب', NULL, 'ECC 2-14-3', 'Not Applicable', 47, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(170, 'ECC 2-14-3-1', 'ECC 2-14-3-1', 'يجب أن تغطي متطلبات الامن السيبراني لحماية الاصول المعلوماتية والتقنية للجهة من الوصول المادي\r\nغير المصرح به والفقدان والسرقة والتخريب بحد أدنى  الدخول المصرح به للاماكن الحساسة في الجهة )مثل => مركز بيانات الجهة، مركز التعافي من\r\nالكوارث، أماكن معالجة المعلومات الحساسة، مركز المراقبة المنية، غرف اتصالات الشبكة،\r\nمناطق المداد الخاصة بالجهزة والاعداد التقنية، وغيرها(.', NULL, 'ECC 2-14-3-1', 'Not Applicable', 47, 1, NULL, NULL, NULL, 1, NULL, NULL, 169, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(171, 'ECC 2-14-3-2', 'ECC 2-14-3-2', 'يجب أن تغطي متطلبات الامن السيبراني لحماية الاصول المعلوماتية والتقنية للجهة من الوصول المادي\r\nغير المصرح به والفقدان والسرقة والتخريب بحد أدنى  .)CCTV( والمراقبة الدخول س', NULL, 'ECC 2-14-3-2', 'Not Applicable', 47, 1, NULL, NULL, NULL, 1, NULL, NULL, 169, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(172, 'ECC 2-14-3-3', 'ECC 2-14-3-3', 'يجب أن تغطي متطلبات الامن السيبراني لحماية الاصول المعلوماتية والتقنية للجهة من الوصول المادي\r\nغير المصرح به والفقدان والسرقة والتخريب بحد أدنى  حماية معلومات سجلات الدخول والمراقبة', NULL, 'ECC 2-14-3-3', 'Not Applicable', 47, 1, NULL, NULL, NULL, 1, NULL, NULL, 169, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(173, 'ECC 2-14-3-4', 'ECC 2-14-3-4', 'يجب أن تغطي متطلبات الامن السيبراني لحماية الاصول المعلوماتية والتقنية للجهة من الوصول المادي\r\nغير المصرح به والفقدان والسرقة والتخريب بحد أدنى  أمن إتلف وإعادة استخدام الاصول المادية التي تحوي معلومات مصنفة )وتشمل => الوثائق\r\nالورقية ووسائط الحفظ والتخزين(.', NULL, 'ECC 2-14-3-4', 'Not Applicable', 47, 1, NULL, NULL, NULL, 1, NULL, NULL, 169, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(174, 'ECC 2-14-3-5', 'ECC 2-14-3-5', 'يجب أن تغطي متطلبات الامن السيبراني لحماية الاصول المعلوماتية والتقنية للجهة من الوصول المادي\r\nغير المصرح به والفقدان والسرقة والتخريب بحد أدنى أمن الجهزة والمعدات داخل مباني الجهة وخارجها.', NULL, 'ECC 2-14-3-5', 'Not Applicable', 47, 1, NULL, NULL, NULL, 1, NULL, NULL, 169, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(175, 'ECC 2-14-4', 'ECC 2-14-4', 'جب مراجعة متطلبات الامن السيبراني لحماية الاصول المعلوماتية والتقنية للجهة من الوصول المادي\r\n غير المصرح به والفقدان والسرقة والتخريب دوريا', NULL, 'ECC 2-14-4', 'Not Applicable', 47, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(176, 'ECC 2-15-1', 'ECC 2-15-1', 'يجب تحديد وتوثيق واعتماد متطلبات الامن السيبراني لحماية تطبيقات الويب الخارجية للجهة من المخاطر\r\nالسيبرانية', NULL, 'ECC 2-15-1', 'Not Applicable', 48, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(177, 'ECC 2-15-2', 'ECC 2-15-2', 'يجب تطبيق متطلبات الامن السيبراني لحماية تطبيقات الويب الخارجية للجهة.', NULL, 'ECC 2-15-2', 'Not Applicable', 48, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(178, 'ECC 2-15-3', 'ECC 2-15-3', 'يجب أن تغطي متطلبات الامن السيبراني لحماية تطبيقات الويب الخارجية للجهة', NULL, 'ECC 2-15-3', 'Not Applicable', 48, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(179, 'ECC 2-15-3-1', 'ECC 2-15-3-1', 'يجب أن تغطي متطلبات الامن السيبراني لحماية تطبيقات الويب الخارجية للجهة بحد أدنى .)Web Application Firewall( الويب لتطبيقات الحماية جدار ا', NULL, 'ECC 2-15-3-1', 'Not Applicable', 48, 1, NULL, NULL, NULL, 1, NULL, NULL, 178, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(180, 'ECC 2-15-3-2', 'ECC 2-15-3-2', 'يجب أن تغطي متطلبات الامن السيبراني لحماية تطبيقات الويب الخارجية للجهة بحد أدنى .)Multi-tier Architecture( المستويات متعددة المعمارية مبدأ ا', NULL, 'ECC 2-15-3-2', 'Not Applicable', 48, 1, NULL, NULL, NULL, 1, NULL, NULL, 178, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(181, 'ECC 2-15-3-3', 'ECC 2-15-3-3', 'يجب أن تغطي متطلبات الامن السيبراني لحماية تطبيقات الويب الخارجية للجهة بحد أدنى  استخدام بروتوكولات آمنة )مثل بروتوكول HTTPS.', NULL, 'ECC 2-15-3-3', 'Not Applicable', 48, 1, NULL, NULL, NULL, 1, NULL, NULL, 178, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(182, 'ECC 2-15-3-4', 'ECC 2-15-3-4', 'يجب أن تغطي متطلبات الامن السيبراني لحماية تطبيقات الويب الخارجية للجهة بحد أدنى توضيح سياسة الاستخدام الامن للمستخدمين.', NULL, 'ECC 2-15-3-4', 'Not Applicable', 48, 1, NULL, NULL, NULL, 1, NULL, NULL, 178, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(183, 'ECC 2-15-3-5', 'ECC 2-15-3-5', 'يجب أن تغطي متطلبات الامن السيبراني لحماية تطبيقات الويب الخارجية للجهة بحد أدنى التحقق مـن الهوية متعدد العناصر )Authentication Factor-Multi )لعمليات دخـول\r\nالمستخدمين', NULL, 'ECC 2-15-3-5', 'Not Applicable', 48, 1, NULL, NULL, NULL, 1, NULL, NULL, 178, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(184, 'ECC 2-15-4', 'ECC 2-15-4', 'يجب مراجعة متطلبات الامن السيبراني لحماية تطبيقات الويب للجهة من المخاطر السيبرانية دوريا', NULL, 'ECC 2-15-4', 'Not Applicable', 48, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(185, 'ECC 3-1-1', 'ECC 3-1-1', 'يجب تحديد وتوثيق واعتماد متطلبات الامن السيبراني ضمن إدارة استمرارية أعمال الجهة', NULL, 'ECC 3-1-1', 'Not Applicable', 49, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(186, 'ECC 3-1-2', 'ECC 3-1-2', 'يجب تطبيق متطلبات الامن السيبراني ضمن إدارة استمرارية أعمال الجهة', NULL, 'ECC 3-1-2', 'Not Applicable', 49, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(187, 'ECC 3-1-3', 'ECC 3-1-3', 'يجب أن تغطي إدارة استمرارية العمال في الجهة', NULL, 'ECC 3-1-3', 'Not Applicable', 49, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(188, 'ECC 3-1-3-1', 'ECC 3-1-3-1', 'يجب أن تغطي إدارة استمرارية العمال في الجهة بحد أدنى التأكد من استمرارية الانظمة والجراءات المتعلقة بالامن السيبراني.', NULL, 'ECC 3-1-3-1', 'Not Applicable', 49, 1, NULL, NULL, NULL, 1, NULL, NULL, 187, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(189, 'ECC 3-1-3-2', 'ECC 3-1-3-2', 'يجب أن تغطي إدارة استمرارية العمال في الجهة بحد أدنى وضع خطط الستجابة لحوداث الامن السيبراني التي قد تؤثر على استمرارية أعمال الجهة.', NULL, 'ECC 3-1-3-2', 'Not Applicable', 49, 1, NULL, NULL, NULL, 1, NULL, NULL, 187, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(190, 'ECC 3-1-3-3', 'ECC 3-1-3-3', 'يجب أن تغطي إدارة استمرارية العمال في الجهة بحد أدنى .)Disaster Recovery Plan( الكوارث من التعافي خطط و', NULL, 'ECC 3-1-3-3', 'Not Applicable', 49, 1, NULL, NULL, NULL, 1, NULL, NULL, 187, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(191, 'ECC 3-1-4', 'ECC 3-1-4', 'يجب مراجعة متطلبات الامن السيبراني ضمن إدارة استمرارية أعمال الجهة دورياً.', NULL, 'ECC 3-1-4', 'Not Applicable', 49, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(192, 'ECC 4-1-1', 'ECC 4-1-1', 'يجب تحديد وتوثيق واعتماد متطلبات الامن السيبراني ضمن العقود والتفاقيات مع الاطـراف الخارجية\r\nللجهة.', NULL, 'ECC 4-1-1', 'Not Applicable', 50, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(193, 'ECC 4-1-2', 'ECC 4-1-2', 'يجب أن تغطي متطلبات الامن السيبراني ضمن العقود والتفاقيات )مثل اتفاقية مستوى الخدمة SLA )مع\r\nالاطراف الخارجية التي قد تتأثر بإصابتها بيانات الجهة أو الخدمات المقدمة له', NULL, 'ECC 4-1-2', 'Not Applicable', 50, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(194, 'ECC 4-1-2-1', 'ECC 4-1-2-1', 'يجب أن تغطي متطلبات الامن السيبراني ضمن العقود والتفاقيات )مثل اتفاقية مستوى الخدمة SLA )مع\r\nالاطراف الخارجية التي قد تتأثر بإصابتها بيانات الجهة أو الخدمات المقدمة لها بحد أدنى   بنود المحافظة على سرية المعلومات )Clauses Disclosure-Non ) َ و الحذف الامن من قِ بل\r\nالطرف الخارجي لبيانات الجهة عند انتهاء الخدمة', NULL, 'ECC 4-1-2-1', 'Not Applicable', 50, 1, NULL, NULL, NULL, 1, NULL, NULL, 193, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(195, 'ECC 4-1-2-2', 'ECC 4-1-2-2', 'يجب أن تغطي متطلبات الامن السيبراني ضمن العقود والتفاقيات )مثل اتفاقية مستوى الخدمة SLA )مع\r\nالاطراف الخارجية التي قد تتأثر بإصابتها بيانات الجهة أو الخدمات المقدمة لها بحد أدنى   إجراءات التواصل في حال حدوث حادثة أمن سيبراني.', NULL, 'ECC 4-1-2-2', 'Not Applicable', 50, 1, NULL, NULL, NULL, 1, NULL, NULL, 193, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(196, 'ECC 4-1-2-3', 'ECC 4-1-2-3', 'يجب أن تغطي متطلبات الامن السيبراني ضمن العقود والتفاقيات )مثل اتفاقية مستوى الخدمة SLA )مع\r\nالاطراف الخارجية التي قد تتأثر بإصابتها بيانات الجهة أو الخدمات المقدمة لها بحد أدنى   إلزام الطرف الخارجي بتطبيق متطلبات وسياسات الامن السيبراني للجهة والمتطلبات التشريعية\r\nوالاتنظيمية ذات العلاقة', NULL, 'ECC 4-1-2-3', 'Not Applicable', 50, 1, NULL, NULL, NULL, 1, NULL, NULL, 193, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(197, 'ECC 4-1-3', 'ECC 4-1-3', 'يجب أن تغطي متطلبات الامن السيبراني مع الاطراف الخارجية التي تقدم خدمات إسناد لتقنية المعلومات،\r\nأو خدمات مدارة', NULL, 'ECC 4-1-3', 'Not Applicable', 50, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(198, 'ECC 4-1-3-1', 'ECC 4-1-3-1', 'يجب أن تغطي متطلبات الامن السيبراني مع الاطراف الخارجية التي تقدم خدمات إسناد لتقنية المعلومات،\r\nأو خدمات مدارة بحد أدنى  إجراء تقييم لمخاطر الامن السيبراني، والتأكد من وجود مايضمن السيطرة على تلك المخاطر، قبل\r\nتوقيع العقود والتفاقيات أو عند تغيير المتطلبات التشريعية والاتنظيمية ذات العلاقة.', NULL, 'ECC 4-1-3-1', 'Not Applicable', 50, 1, NULL, NULL, NULL, 1, NULL, NULL, 197, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(199, 'ECC 4-1-3-2', 'ECC 4-1-3-2', 'يجب أن تغطي متطلبات الامن السيبراني مع الاطراف الخارجية التي تقدم خدمات إسناد لتقنية المعلومات،\r\nأو خدمات مدارة بحد أدنى  أن تكون مراكز عمليات خدمات الامن السيبراني المدارة للتشغيل والمراقبة، والتي تستخدم طريقة\r\nالوصول عن بعد، موجودة بالكامل داخل المملكة.', NULL, 'ECC 4-1-3-2', 'Not Applicable', 50, 1, NULL, NULL, NULL, 1, NULL, NULL, 197, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(200, 'ECC 4-1-4', 'ECC 4-1-4', 'يجب مراجعة متطلبات الامن السيبراني مع الاطراف الخارجية دورياً.', NULL, 'ECC 4-1-4', 'Not Applicable', 50, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(201, 'ECC 4-2-1', 'ECC 4-2-1', 'يجب تحديد وتوثيق واعتماد متطلبات الامـن السيبراني الخاصة باستخدام خدمات الحوسبة السحابية\r\nوالاستضافة.', NULL, 'ECC 4-2-1', 'Not Applicable', 51, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(202, 'ECC 4-2-2', 'ECC 4-2-2', 'يجب تطبيق متطلبات الامن السيبراني الخاصة بخدمات الحوسبة السحابية والاستضافة للجهة.', NULL, 'ECC 4-2-2', 'Not Applicable', 51, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(203, 'ECC 4-2-3', 'ECC 4-2-3', 'بما يتوافق مع المتطلبات التشريعية والاتنظيمية ذات العالقة، وبالضافة إلى ما ينطبق من الضوابط ضمن\r\nالمكونات الرئيسية رقم )1 )و )2 )و )3 )والمكون الفرعي رقم )4-1 )الضرورية لحماية بيانات الجهة أو الخدمات\r\nالمقدمة لها، يجب أن تغطي متطلبات الامـن السيبراني الخاصة باستخدام خدمات الحوسبة السحابية\r\nوالاستضافة', NULL, 'ECC 4-2-3', 'Not Applicable', 51, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(204, 'ECC 4-2-3-1', 'ECC 4-2-3-1', 'بما يتوافق مع المتطلبات التشريعية والاتنظيمية ذات العلاقة، وبالضافة إلى ما ينطبق من الضوابط ضمن\r\nالمكونات الرئيسية رقم )1 )و )2 )و )3 )والمكون الفرعي رقم )4-1 )الضرورية لحماية بيانات الجهة أو الخدمات\r\nالمقدمة لها، يجب أن تغطي متطلبات الامـن السيبراني الخاصة باستخدام خدمات الحوسبة السحابية\r\nوالستضافة بحد أدنى   تصنيف البيانات قبل استضافتها لدى مقدمي خدمات الحوسبة السحابية والستضافة، وإعادتها\r\nللجهة )بصيغة قابلة للستخدام( عند إنتهاء الخدمة', NULL, 'ECC 4-2-3-1', 'Not Applicable', 51, 1, NULL, NULL, NULL, 1, NULL, NULL, 203, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(205, 'ECC 4-2-3-2', 'ECC 4-2-3-2', 'بما يتوافق مع المتطلبات التشريعية والاتنظيمية ذات العلاقة، وبالاضافة إلى ما ينطبق من الضوابط ضمن\r\nالمكونات الرئيسية رقم )1 )و )2 )و )3 )والمكون الفرعي رقم )4-1 )الضرورية لحماية بيانات الجهة أو الخدمات\r\nالمقدمة لها، يجب أن تغطي متطلبات الامـن السيبراني الخاصة باستخدام خدمات الحوسبة السحابية\r\nوالاستضافة بحد أدنى  فصل البيئة الخاصة بالجهة )وخصوصاً الخوادم الفتراضية( عن غيرها من البيئات التابعة لجهات\r\nأخرى في خدمات الحوسبة السحابية', NULL, 'ECC 4-2-3-2', 'Not Applicable', 51, 1, NULL, NULL, NULL, 1, NULL, NULL, 203, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(206, 'ECC 4-2-3-3', 'ECC 4-2-3-3', 'بما يتوافق مع المتطلبات التشريعية والاتنظيمية ذات العلاقة، وبالاضافة إلى ما ينطبق من الضوابط ضمن\r\nالمكونات الرئيسية رقم )1 )و )2 )و )3 )والمكون الفرعي رقم )4-1 )الضرورية لحماية بيانات الجهة أو الخدمات\r\nالمقدمة لها، يجب أن تغطي متطلبات الامـن السيبراني الخاصة باستخدام خدمات الحوسبة السحابية\r\nوالاستضافة بحد أدنى  موقع استضافة وتخزين معلومات الجهة يجب أن يكون داخل المملكة.', NULL, 'ECC 4-2-3-3', 'Not Applicable', 51, 1, NULL, NULL, NULL, 1, NULL, NULL, 203, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(207, 'ECC 4-2-4', 'ECC 4-2-4', 'يجب مراجعة متطلبات الامن السيبراني الخاصة بخدمات الحوسبة السحابية والاستضافة دورياً.', NULL, 'ECC 4-2-4', 'Not Applicable', 51, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(208, 'ECC 5-1-1', 'ECC 5-1-1', 'يجب تحديد وتـوثـيـق واعـتـمـاد متطلبات الامــن السيبراني لحماية أجـهـزة وأنـظـمـة التحكم الصناعي\r\n.للجهة( OT\\/ICS(', NULL, 'ECC 5-1-1', 'Not Applicable', 52, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(209, 'ECC 5-1-2', 'ECC 5-1-2', 'يجب تطبيق متطلبات الامن السيبراني لحماية أجهزة وأنظمة التحكم الصناعي )ICS\\/OT )للجهة.', NULL, 'ECC 5-1-2', 'Not Applicable', 52, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(210, 'ECC 5-1-3', 'ECC 5-1-3', 'بالضافة إلى ما يمكن تطبيقه من الضوابط ضمن المكونات الرئيسية رقم )1 )و )2 )و )3 )و )4 )الضرورية\r\nلحماية بيانات الجهة وخدماتها، فإن متطلبات الامن السيبراني لحماية أجهزة وأنظمة التحكم الصناعي\r\n)ICS\\/O', NULL, 'ECC 5-1-3', 'Not Applicable', 52, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(211, 'ECC 5-1-3-1', 'ECC 5-1-3-1', 'بالضافة إلى ما يمكن تطبيقه من الضوابط ضمن المكونات الرئيسية رقم )1 )و )2 )و )3 )و )4 )الضرورية\r\nلحماية بيانات الجهة وخدماتها، فإن متطلبات الامن السيبراني لحماية أجهزة وأنظمة التحكم الصناعي\r\n)ICS\\/OT )يجب أن تغطي بحد أدنى  1 الـتـقـيـيـد الــحــازم والـتـقـسـيـم الــمــادي والـمـنـطـقـي عــنــد ربــــط شــبــكــات النــتــاج الـصـنـاعـيـة\r\n)ICS\\/OT )مــع الـشـبـكـات الخــــرى الـتـابـعـة لـلـجـهـة، مـثـل => شبكة الاعــمــال الـداخـلـيـة للجهة\r\n.\"Corporate Network\"', NULL, 'ECC 5-1-3-1', 'Not Applicable', 52, 1, NULL, NULL, NULL, 1, NULL, NULL, 210, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(212, 'ECC 5-1-3-2', 'ECC 5-1-3-2', 'بالضافة إلى ما يمكن تطبيقه من الضوابط ضمن المكونات الرئيسية رقم )1 )و )2 )و )3 )و )4 )الضرورية\r\nلحماية بيانات الجهة وخدماتها، فإن متطلبات الامن السيبراني لحماية أجهزة وأنظمة التحكم الصناعي\r\n)ICS\\/OT )يجب أن تغطي بحد أدنى  التقييد الحازم والتقسيم المادي والمنطقي عند ربط الانظمة أو الشبكات الصناعية مع شبكات\r\nخارجية، مثل => الانترنت أو الدخول عن بعد أو الاتصال الاسلكي', NULL, 'ECC 5-1-3-2', 'Not Applicable', 52, 1, NULL, NULL, NULL, 1, NULL, NULL, 210, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(213, 'ECC 5-1-3-3', 'ECC 5-1-3-3', 'بالضافة إلى ما يمكن تطبيقه من الضوابط ضمن المكونات الرئيسية رقم )1 )و )2 )و )3 )و )4 )الضرورية\r\nلحماية بيانات الجهة وخدماتها، فإن متطلبات الامن السيبراني لحماية أجهزة وأنظمة التحكم الصناعي\r\n)ICS\\/OT )يجب أن تغطي بحد أدنى  تفعيل سجلات الاحداث )logs Event )الخاصة بالامن السيبراني للشبكة الصناعية والاتصالت\r\nالمرتبطة بها ما أمكن ذلك، والمراقبة المستمرة لها.', NULL, 'ECC 5-1-3-3', 'Not Applicable', 52, 1, NULL, NULL, NULL, 1, NULL, NULL, 210, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(214, 'ECC 5-1-3-4', 'ECC 5-1-3-4', 'بالضافة إلى ما يمكن تطبيقه من الضوابط ضمن المكونات الرئيسية رقم )1 )و )2 )و )3 )و )4 )الضرورية\r\nلحماية بيانات الجهة وخدماتها، فإن متطلبات الامن السيبراني لحماية أجهزة وأنظمة التحكم الصناعي\r\n)ICS\\/OT )يجب أن تغطي بحد أدنى  .)Safety Instrumented System “SIS”( السلمة معدات أنظمة ع', NULL, 'ECC 5-1-3-4', 'Not Applicable', 52, 1, NULL, NULL, NULL, 1, NULL, NULL, 210, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(215, 'ECC 5-1-3-5', 'ECC 5-1-3-5', 'بالاضافة إلى ما يمكن تطبيقه من الضوابط ضمن المكونات الرئيسية رقم )1 )و )2 )و )3 )و )4 )الضرورية\r\nلحماية بيانات الجهة وخدماتها، فإن متطلبات الامن السيبراني لحماية أجهزة وأنظمة التحكم الصناعي\r\n)ICS\\/OT )يجب أن تغطي بحد أدنى  التقييد الحازم لستخدام وسائط التخزين الخارجية', NULL, 'ECC 5-1-3-5', 'Not Applicable', 52, 1, NULL, NULL, NULL, 1, NULL, NULL, 210, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(216, 'ECC 5-1-3-6', 'ECC 5-1-3-6', 'الضافة إلى ما يمكن تطبيقه من الضوابط ضمن المكونات الرئيسية رقم )1 )و )2 )و )3 )و )4 )الضرورية\r\nلحماية بيانات الجهة وخدماتها، فإن متطلبات الامن السيبراني لحماية أجهزة وأنظمة التحكم الصناعي\r\n)ICS\\/OT )يجب أن تغطي بحد أدنى   التقييد الحازم لتوصيل الجهزة المحمولة على شبكة النتاج الصناعية.', NULL, 'ECC 5-1-3-6', 'Not Applicable', 52, 1, NULL, NULL, NULL, 1, NULL, NULL, 210, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(217, 'ECC 5-1-3-7', 'ECC 5-1-3-7', 'بالاضافة إلى ما يمكن تطبيقه من الضوابط ضمن المكونات الرئيسية رقم )1 )و )2 )و )3 )و )4 )الضرورية\r\nلحماية بيانات الجهة وخدماتها، فإن متطلبات الامن السيبراني لحماية أجهزة وأنظمة التحكم الصناعي\r\n)ICS\\/OT )يجب أن تغطي بحد أدنى   مراجعة إعدادات وتحصين النظمة الصناعية، وأنظمة الدعم والاجهزة اللية الصناعية )Secure\r\n.ًدوريا( Confguration and Hardening', NULL, 'ECC 5-1-3-7', 'Not Applicable', 52, 1, NULL, NULL, NULL, 1, NULL, NULL, 210, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(218, 'ECC 5-1-3-8', 'ECC 5-1-3-8', 'بالاضافة إلى ما يمكن تطبيقه من الضوابط ضمن المكونات الرئيسية رقم )1 )و )2 )و )3 )و )4 )الضرورية\r\nلحماية بيانات الجهة وخدماتها، فإن متطلبات الامن السيبراني لحماية أجهزة وأنظمة التحكم الصناعي\r\n)ICS\\/OT )يجب أن تغطي بحد أدنى   )OT\\/ICS Vulnerability Management( الصناعية اللانظمة ثغرات إدارة', NULL, 'ECC 5-1-3-8', 'Not Applicable', 52, 1, NULL, NULL, NULL, 1, NULL, NULL, 210, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(219, 'ECC 5-1-3-9', 'ECC 5-1-3-9', 'بالضافة إلى ما يمكن تطبيقه من الضوابط ضمن المكونات الرئيسية رقم )1 )و )2 )و )3 )و )4 )الضرورية\r\nلحماية بيانات الجهة وخدماتها، فإن متطلبات الامن السيبراني لحماية أجهزة وأنظمة التحكم الصناعي\r\n)ICS\\/OT )يجب أن تغطي بحد أدنى  إدارة حــــــــــزم الـــــتـــــحـــــديـــــثـــــات والصــــــــــــلحــــــــــــات المــــــنــــــيــــــة لـــــانـــــظـــــمـــــة الــــصــــنــــاعــــيــــة\r\n.)OT\\/ICS Patch Management(', NULL, 'ECC 5-1-3-9', 'Not Applicable', 52, 1, NULL, NULL, NULL, 1, NULL, NULL, 210, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(220, 'ECC 5-1-3-10', 'ECC 5-1-3-10', 'الضافة إلى ما يمكن تطبيقه من الضوابط ضمن المكونات الرئيسية رقم )1 )و )2 )و )3 )و )4 )الضرورية\r\nلحماية بيانات الجهة وخدماتها، فإن متطلبات الامن السيبراني لحماية أجهزة وأنظمة التحكم الصناعي\r\n)ICS\\/OT )يجب أن تغطي بحد أدنى   إدارة البرامج الخاصة بالامن السيبراني الصناعي للحماية من الفيروسات والبرمجيات المشبوهة\r\nوالضارة.', NULL, 'ECC 5-1-3-10', 'Not Applicable', 52, 1, NULL, NULL, NULL, 1, NULL, NULL, 210, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(221, 'ECC 5-1-4', 'ECC 5-1-4', 'يجب مراجعة متطلبات الامن السيبراني لحماية أجهزة وأنظمة التحكم الصناعي )ICS\\/OT )للجهة دورياً.', NULL, 'ECC 5-1-4', 'Not Applicable', 52, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(222, 'SMACC 1-1-1', 'SMACC 1-1-1', 'رجوعــاً للضابــط 1- 3-1 يف الضوابــط األساســية الامــن الســيرباين، يجــب أن تشــمل سياســات\r\nوإجــراءات الامــن الســيرباني', NULL, 'SMACC 1-1-1', 'Not Applicable', 26, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(223, 'SMACC 1-1-1-1', 'SMACC 1-1-1-1', 'رجوعــاً للضابــط 1- 3-1 في الضوابــط الاساســيةالامــن السـيبراني، يجــب أن تشــمل سياســات\r\nوإجــراءات الامــن الســيبراني  تحديــد وتوثيــق متطلبــات وضوابــط الامــن الســيرباني لحســابات التواصــل\r\nاالاجتامعــي ضمــن سياســات الامــن الســيرباني للجهــة', NULL, 'SMACC 1-1-1-1', 'Not Applicable', 26, 1, NULL, NULL, NULL, 1, NULL, NULL, 222, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(224, 'SMACC 1-2-1', 'SMACC 1-2-1', 'باإلاضافـة للضوابـط ضمـن المكـون الفرعـي 1 - 5 يف الضوابـط الاساسـية الألمـن السـيرباني، يجـب أن\r\nتشـمل منهجيـة إدارة مخاطـر الامـن السـيرباني', NULL, 'SMACC 1-2-1', 'Not Applicable', 28, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(225, 'SMACC 1-2-1-1', 'SMACC 1-2-1-1', 'بالاضافـة للضوابـط ضمـن المكـون الفرعـي 1 - 5 يف الضوابـط الاساسـية الامـن السـيرباني، يجـب أن\r\nتشـمل منهجيـة إدارة مخاطـرالامـن السـيرباين بحـد أدى  تقييــم مخاطــر الامــن الســيرباين لحســابات التواصــل االاجتامعــي، مــرة واحــدة\r\nســنوياً، عــى الاقــل', NULL, 'SMACC 1-2-1-1', 'Not Applicable', 28, 1, NULL, NULL, NULL, 1, NULL, NULL, 224, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(226, 'SMACC 1-2-1-2', 'SMACC 1-2-1-2', 'بالاضافـة للضوابـط ضمـن المكـون الفرعـي 1 - 5 يف الضوابـط الاساسـيةللامـن السـيرباين، يجـب أن\r\nتشـمل منهجيـة إدارة مخاطـر الامـن السـيرباين بحـد أدى  تقييـم مخاطـرالامـن السـيرباين عنـد التخطيـط وقبـل السـاح باسـتخدام شـبكات\r\nالتواصــل االاجتامعي.', NULL, 'SMACC 1-2-1-2', 'Not Applicable', 28, 1, NULL, NULL, NULL, 1, NULL, NULL, 224, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(227, 'SMACC 1-2-1-3', 'SMACC 1-2-1-3', 'بالاضافـة للضوابـط ضمـن المكـون الفرعـي 1 - 5 يف الضوابـط الاساسـية للامـن السـيرباين، يجـب أن\r\nتشـمل منهجيـة إدارة مخاطـرالامـن السـيرباين بحـد أدى  تضمــن مخاطــر الامــن الســيرباين الخاصــة بحســابات التواصــل االاجتامعــي\r\nوالخدمــات والانظمــة المســتخدمة يف ذلــك يف ســجل مخاطــر الامــن الســيرباين\r\nالخــاص بالجهــة، ومتابعتــه مــرة واحــدة ســنويا، عــى األقــل', NULL, 'SMACC 1-2-1-3', 'Not Applicable', 28, 1, NULL, NULL, NULL, 1, NULL, NULL, 224, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(228, 'SMACC 1-3-1', 'SMACC 1-3-1', 'بالالضافـة للضوابـط الفرعيــة ضمــن الضابــط 1 – 9 – 4 يف الضوابـط الاساسـيةللامـن السـيرباين،\r\nيجـب أن تشـمل متطلبـات الامـن السـيرباين المتعلقـة بالعاملـين الملسـؤولني عـن إدارة حسـابات\r\nالتواصـل االاجتامعـي للجهـة', NULL, 'SMACC 1-3-1', 'Not Applicable', 32, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(229, 'SMACC 1-3-1-1', 'SMACC 1-3-1-1', 'بالاضافـة للضوابـط الفرعيــة ضمــن الضابــط 1 – 9 – 4 يف الضوابـط الاساسـية للامـن السـيرباين،\r\nيجـب أن تشـمل متطلبـات الامـن السـيرباين المتعلقـة بالعاملـين املسـؤولني عـن إدارة حسـابات\r\nالتواصـل الاجتامعـي للجهـة بحـد أدى  التوعية بالامن السيرباين لحسابات التواصل الاجتامعي', NULL, 'SMACC 1-3-1-1', 'Not Applicable', 32, 1, NULL, NULL, NULL, 1, NULL, NULL, 228, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(230, 'SMACC 1-3-1-2', 'SMACC 1-3-1-2', 'بالاضافـة للضوابـط الفرعيــة ضمــن الضابــط 1 – 9 – 4 يف الضوابـط الاساسـية للامـن السـيرباين،\r\nيجـب أن تشـمل متطلبـات الامـن السـيرباين المتعلقـة بالعامليـن املسـؤولني عـن إدارة حسـابات\r\nالتواصـل الاجتامعـي للجهـة بحـد أدى  تطبيـق متطلبـات الامــن السـيرباين واالالـتــزام بهـا وفقـاً لسياسـات وإجــــراءات\r\nوعمليــات الامــن الســيرباين لحســابات التواصــل الاجتامعــي', NULL, 'SMACC 1-3-1-2', 'Not Applicable', 32, 1, NULL, NULL, NULL, 1, NULL, NULL, 228, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(231, 'SMACC 1-4-1', 'SMACC 1-4-1', 'بالاضافـة للضوابـط الفرعيـة ضمـن الضابـط 1 - 10 -3 يف الضوابـط الاساسـية للامـن السـيرباين، فإنه\r\nيجـب أن يغطـي برنامـج التوعيـة بالامـن السـيرباين المخاطـر والتهديـدات السـيربانية لحسـابات\r\nالتواصـل الاجتامعـي والاسـتخدام الامـن للحـد مـن هـذه المخاطـر والتهديـدات', NULL, 'SMACC 1-4-1', 'Not Applicable', 33, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(232, 'SMACC 1-4-1-1', 'SMACC 1-4-1-1', 'الاضافـة للضوابـط الفرعيـة ضمـن الضابـط 1 - 10 -3 يف الضوابـط الاساسـية للامـن السـيرباين، فإنه\r\nيجـب أن يغطـي برنامـج التوعيـة بالامـن السـيرباين المخاطـر والتهديـدات السـيربانية لحسـابات\r\nالتواصـل الاجتامعـي والاسـتخدام الامـن للحـد مـن هـذه المخاطـر والتهديـدات، مبـا يف ذلـك  االاسـتخدام الامـن لألجهـزة المخصصـة لحسـابات التواصـل الاجتامعـي والمحافظـة\r\nعليهـا وحاميتهـا. وعـدم احتوائهـا عـى بيانـات مصنفـة أو اسـتخدامها ألاغـراض\r\nشـخصية', NULL, 'SMACC 1-4-1-1', 'Not Applicable', 33, 1, NULL, NULL, NULL, 1, NULL, NULL, 231, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(233, 'SMACC 1-4-1-2', 'SMACC 1-4-1-2', 'بالاضافـة للضوابـط الفرعيـة ضمـن الضابـط 1 - 10 -3 يف الضوابـط الاساسـية للامـن السـيرباين، فإنه\r\nيجـب أن يغطـي برنامـج التوعيـة بالامـن السـيرباين المخاطـر والتهديـدات السـيربانية لحسـابات\r\nالتواصـل الاجتامعـي واالاسـتخدام الامـن للحـد مـن هـذه المخاطـر والتهديـدات، مبـا يف ذلـك  التعامل الامن مع هويات الدخول وكلامت المرور والاسئلة الامنية', NULL, 'SMACC 1-4-1-2', 'Not Applicable', 33, 1, NULL, NULL, NULL, 1, NULL, NULL, 231, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(234, 'SMACC 1-4-1-3', 'SMACC 1-4-1-3', 'بالاضافـة للضوابـط الفرعيـة ضمـن الضابـط 1 - 10 -3 يف الضوابـط الاساسـية للامـن السـيرباين، فإنه\r\nيجـب أن يغطـي برنامـج التوعيـة بالامـن السـيرباين المخاطـر والتهديـدات السـيربانية لحسـابات\r\nالتواصـل الاجتامعـي واالاسـتخدام لامـن للحـد مـن هـذه المخاطـر والتهديـدات، مبـا يف ذلـك  خطة استعادة حسابات التواصل لاجتامعي والتعامل مع الحوادث السيربانية.', NULL, 'SMACC 1-4-1-3', 'Not Applicable', 33, 1, NULL, NULL, NULL, 1, NULL, NULL, 231, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(235, 'SMACC 1-4-1-4', 'SMACC 1-4-1-4', 'بالاضافـة للضوابـط الفرعيـة ضمـن الضابـط 1 - 10 -3 يف الضوابـط الاساسـية للأمـن السـيرباين، فإنه\r\nيجـب أن يغطـي برنامـج التوعيـة بالامـن السـيرباين المخاطـر والتهديـدات السـيربانية لحسـابات\r\nالتواصـل الاجتامعـي واالاسـتخدام الامـن للحـد مـن هـذه المخاطـر والتهديـدات، مبـا يف ذلـك  التعامــل الامــن مــع التطبيقــات والحلــول المســتخدمة لحســابات التواصــل\r\nالاجتامعــي.', NULL, 'SMACC 1-4-1-4', 'Not Applicable', 33, 1, NULL, NULL, NULL, 1, NULL, NULL, 231, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(236, 'SMACC 1-4-1-5', 'SMACC 1-4-1-5', 'بالاضافـة للضوابـط الفرعيـة ضمـن الضابـط 1 - 10 -3 يف الضوابـط الاساسـية للامـن السـيرباين، فإنه\r\nيجـب أن يغطـي برنامـج التوعيـة بالامـن السـيرباين المخاطـر والتهديـدات السـيربانية لحسـابات\r\nالتواصـل الاجتامعـي والاسـتخدام الامـن للحـد مـن هـذه المخاطـر والتهديـدات، مبـا يف ذلـك  عـدم اسـتخدام حسـابات التواصـل الاجتامعـي الرسـمية ألغـراض شـخصية مثـل\r\nالتصفـح.', NULL, 'SMACC 1-4-1-5', 'Not Applicable', 33, 1, NULL, NULL, NULL, 1, NULL, NULL, 231, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(237, 'SMACC 1-4-1-6', 'SMACC 1-4-1-6', 'الاضافـة للضوابـط الفرعيـة ضمـن الضابـط 1 - 10 -3 يف الضوابـط الاساسـية لألمـن السـيرباين، فإنه\r\nيجـب أن يغطـي برنامـج التوعيـة بالامـن السـيرباين المخاطـر والتهديـدات السـيربانية لحسـابات\r\nالتواصـل الاجتامعـي واالاسـتخدامالامـن للحـد مـن هـذه المخاطـر والتهديـدات، مبـا يف ذلـك تجنــب الدخــول لحســابات التواصــل الاجتامعــي باســتخدام أجهــزة أو شــبكات\r\nعامـة غـر موثوقـة.', NULL, 'SMACC 1-4-1-6', 'Not Applicable', 33, 1, NULL, NULL, NULL, 1, NULL, NULL, 231, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(238, 'SMACC 1-4-1-7', 'SMACC 1-4-1-7', 'بالاضافـة للضوابـط الفرعيـة ضمـن الضابـط 1 - 10 -3 يف الضوابـط الاساسـية للامـن السـيرباين، فإنه\r\nيجـب أن يغطـي برنامـج التوعيـة بالامـن السـيرباين المخاطـر والتهديـدات السـيربانية لحسـابات\r\nالتواصـل الاجتامعـي والاسـتخدام الامـن للحـد مـن هـذه المخاطـر والتهديـدات، مبـا يف ذلـك التواصــل مبــارشة مــع الادارة لاشــتباه\r\nبتهديـد أمـن سـيرباين.', NULL, 'SMACC 1-4-1-7', 'Not Applicable', 33, 1, NULL, NULL, NULL, 1, NULL, NULL, 231, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(239, 'SMACC 1-4-2', 'SMACC 1-4-2', 'بالاضافـة للضوابـط الفرعيـة ضمـن الضابـط 1 - 10 - 4 يف الضوابـط الاساسـية للأمـن السـيرباين،\r\nفإنـه يجـب تدريـب العامليـن المسـؤولني عـن إدارة حسـابات التواص الاجتامعـي للجهـة عـى\r\nالمهــارات التقنيــة والخطــط والاجــراءات الازمــة لضــان تطبيــق متطلبــات ومامرســات الامــن\r\nالســيرباين عنــد اســتخدام حســابات التواصــل الاجتامعــي', NULL, 'SMACC 1-4-2', 'Not Applicable', 33, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(240, 'SMACC 2-1-1', 'SMACC 2-1-1', 'باإلضافـة للضوابـط ضمـن املكـون الفرعـي 2-1 يف الضوابـط األساسـية لألمـن السـيرباين، يجـب أن\r\nتشـمل متطلبـات األمـن السـيرباين إلدارة األصـول املعلوماتيـة والتقنيـة', NULL, 'SMACC 2-1-1', 'Not Applicable', 34, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(241, 'SMACC 2-1-1-1', 'SMACC 2-1-1-1', 'بالاضافـة للضوابـط ضمـن المكـون الفرعـي 2-1 يف الضوابـط الاساسـية للامـن السـيرباين، يجـب أن\r\nتشـمل متطلبـات الامـن السـيرباين إلادارة الاصـول المعلوماتيـة والتقنيـة، بحـد أدى  يجــب تحديــد وحــر حســابات التواصــل الاجتامعــي والاصــول المعلوماتيــة\r\nوالتقنيــة المتعلقــة بهــا، وتحديثهــا مــرة واحــدة، كل ســنة؛ عــى الاقــل.', NULL, 'SMACC 2-1-1-1', 'Not Applicable', 34, 1, NULL, NULL, NULL, 1, NULL, NULL, 240, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(242, 'SMACC 2-2-1', 'SMACC 2-2-1', 'بالاضافـة للضوابـط الفرعيـة ضمـن الضابـط 2-2-3 يف الضوابـط الاساسـيةللامـن السـيرباين، يجـب\r\nأن تغطـي متطلبـات الامـن السـيرباين المتعلقـة بـإدارة هويـات الدخـول، والصلاحيـات لحسـابات\r\nالتواصل الاجتامعـي للجهـة،', NULL, 'SMACC 2-2-1', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(243, 'SMACC 2-2-1-1', 'SMACC 2-2-1-1', 'بالاضافـة للضوابـط الفرعيـة ضمـن الضابـط 2-2-3 يف الضوابـط  الاساسـية للامـن السـيرباين، يجـب\r\nأن تغطـي متطلبـات الامـن السـيرباين المتعلقـة بـإدارة هويـات الدخـول، والصلاحيـات لحسـابات\r\nالتواصـل الاجتامعـي للجهـة، بحـد أدى  استخدام حسابات التواصل الاجتامعي المخصصة للجهات، وليس الافراد', NULL, 'SMACC 2-2-1-1', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, 242, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(244, 'SMACC 2-2-1-2', 'SMACC 2-2-1-2', 'بالاضافـة للضوابـط الفرعيـة ضمـن الضابـط 2-2-3 يف الضوابـط الاساسـية للامـن السـيرباين، يجـب\r\nأن تغطـي متطلبـات الامـن السـيرباين المتعلقـة بـإدارة هويـات الدخـول، والصلاحيـات لحسـابات\r\nالتواصـل الاجتامعـي للجهـة، بحـد أدى  التسـجيل باسـتخدام معلومـات رسـمية )بريـد إلالكـروين رسـمي خـاص لوسـائل\r\nالتواصـل الاجتامعـي ورقـم جـوال رسـمي(، وعـدم اسـتخدام معلومات شـخصية', NULL, 'SMACC 2-2-1-2', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, 242, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(245, 'SMACC 2-2-1-3', 'SMACC 2-2-1-3', 'بالاضافـة للضوابـط الفرعيـة ضمـن الضابـط 2-2-3 يف الضوابـط الاساسـية للامـن السـيرباين، يجـب\r\nأن تغطـي متطلبـات الامـن السـيرباين المتعلقـة بـإدارة هويـات الدخـول، والصلاحيـات لحسـابات\r\nالتواصـل الاجتامعـي للجهـة، بحـد أدى   توثيــق حســابات التواصــل الاجتامعــي والمحافظــة عــى هويــة متســقة يف\r\nجميـع حسـابات التواصـل الاجتامعـي المسـتخدمة؛ لتسـهيل معرفـة الحسـابات\r\nالرســمية، واكتشــاف حســابات االاحتيــال', NULL, 'SMACC 2-2-1-3', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, 242, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(246, 'SMACC 2-2-1-4', 'SMACC 2-2-1-4', 'بالاضافـة للضوابـط الفرعيـة ضمـن الضابـط 2-2-3 يف الضوابـط الاساسـية للأمـن السـيرباين، يجـب\r\nأن تغطـي متطلبـات الامـن السـيرباين المتعلقـة بـإدارة هويـات الدخـول، والصلاحيـات لحسـابات\r\nالتواصـل الاجتامعـي للجهـة، بحـد أدىن،  اســتخدام كلمــة مــرور آمنــة وخاصــة لــكل حســابات التواصــل الاجتامعــي.\r\nوتغيــر كلمــة المــرور بشــكل دوري، وعــدم إعــادة اســتخدام كلمــة مــرور تــم\r\nاســتخدامها مــن قبــل.', NULL, 'SMACC 2-2-1-4', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, 242, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(247, 'SMACC 2-2-1-5', 'SMACC 2-2-1-5', 'بالاضافـة للضوابـط الفرعيـة ضمـن الضابـط 2-2-3 يف الضوابـط الاساسـية للأمـن السـيرباين، يجـب\r\nأن تغطـي متطلبـات الامـن السـيرباين المتعلقـة بـإدارة هويـات الدخـول، والصلاحيـات لحسـابات\r\nالتواصـل الاجتامعـي للجهـة، بحـد أدى  اســتخدام التحقــق مــن الهويــة متعــدد العنــارص )Factor-Multi\r\nAuthentication )لعمليــات الدخــول لحســابات التواصــل الاجتامعــي', NULL, 'SMACC 2-2-1-5', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, 242, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(248, 'SMACC 2-2-1-6', 'SMACC 2-2-1-6', 'بالاضافـة للضوابـط الفرعيـة ضمـن الضابـط 2-2-3 يف الضوابـط الاساسـية للأمـن السـيرباين، يجـب\r\nأن تغطـي متطلبـات الامـن السـيرباين المتعلقـة بـإدارة هويـات الدخـول، والصلاحيـات لحسـابات\r\nالتواصـل الاجتامعـي للجهـة، بحـد أدى  تفعيل وتحديث الاسئلة الامنية وتوثيقها في مكان آمن', NULL, 'SMACC 2-2-1-6', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, 242, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(249, 'SMACC 2-2-1-7', 'SMACC 2-2-1-7', 'بالاضافـة للضوابـط الفرعيـة ضمـن الضابـط 2-2-3 يف الضوابـط الاساسـية للأمـن السـيرباين، يجـب\r\nأن تغطـي متطلبـات الامـن السـيرباين المتعلقـة بـإدارة هويـات الدخـول، والصلاحيـات لحسـابات\r\nالتواصـل الاجتامعـي للجهـة، بحـد أدى   إدارة صلاحيــات المســتخدمين ً لحســابات التواصــل الاجتامعــي بنــاء عــلى\r\nاحتياجــات العمــل، مــع مراعــاة حساســية الحســابات ومســتوى الصلاحيــات،\r\nونوعيــة الاجهــزة والانظمــة المســتخدمة.', NULL, 'SMACC 2-2-1-7', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, 242, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(250, 'SMACC 2-2-1-8', 'SMACC 2-2-1-8', 'بالاضافـة للضوابـط الفرعيـة ضمـن الضابـط 2-2-3 يف الضوابـط الاساسـية للامـن السـيرباين، يجـب\r\nأن تغطـي متطلبـات الامـن السـيرباين المتعلقـة بـإدارة هويـات الدخـول، والصلاحيـات لحسـابات\r\nالتواصـل الاجتامعـي للجهـة، بحـد أدنى صلاحيـات مقدمـي خدمـة إدارة حسـابات التواصـل الاجتامعـي أو المراقبة\r\nاالاليـة لحسـابات التواصـل الاجتامعـي أو حاميـة هويـة الجهـة مـن الانتحال.', NULL, 'SMACC 2-2-1-8', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, 242, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(251, 'SMACC 2-2-1-9', 'SMACC 2-2-1-9', 'بالاضافـة للضوابـط الفرعيـة ضمـن الضابـط 2-2-3 يف الضوابـط الاساسـيةللامـن السـيرباين، يجـب\r\nأن تغطـي متطلبـات الامـن السـيرباين المتعلقـة بـإدارة هويـات الدخـول، والصلاحيـات لحسـابات\r\nالتواصـل الاجتامعـي للجهـة، بحـد أدى  حــر إمكانيــة الدخــول لحســابات التواصــل الاجتامعــي للجهــة مــن أجهــزة\r\nمحــددة.', NULL, 'SMACC 2-2-1-9', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, 242, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(252, 'SMACC 2-2-2', 'SMACC 2-2-2', 'رجوعـاً للضابـط الفرعـي 2-2-3-5 يف الضوابـط الاساسـية للامـن السـيرباين، يجـب مراجعـة هويات\r\nالدخـول والصلاحيـات المسـتخدمة لحسـابات التواصـل الاجتامعـي للجهـة، بحـد أدىن مـرة واحـدة\r\nكل سـنة', NULL, 'SMACC 2-2-2', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(253, 'SMACC 2-3-1', 'SMACC 2-3-1', 'الاضافـة للضوابـط الفرعيـة ضمـن الضابـط 2-3-3 يف الضوابـط الاساسـية للامـن السـيرباين، يجـب\r\nأن تغطـي متطلبـات الامـن السـيرباين لحاميـة حسـابات التواصـل الاجتامعـي للجهـة، والاصـول\r\nالتقنيـة الخاصـة بهـا', NULL, 'SMACC 2-3-1', 'Not Applicable', 36, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(254, 'SMACC 2-3-1-1', 'SMACC 2-3-1-1', 'بالاضافـة للضوابـط الفرعيـة ضمـن الضابـط 2-3-3 يف الضوابـط الاساسـية للامـن السـيرباين، يجـب\r\nأن تغطـي متطلبـات الامـن السـيرباين لحاميـة حسـابات التواصـل الاجتامعـي للجهـة، والاصـول\r\nالتقنيـة الخاصـة بهـا، بحـد أدى  تطبيـق حـزم التحديثـات، والصلاحـات الامنيـة لتطبيقـات التواصـل الاجتامعـي،\r\nمـرة واحـدة شـهرياً عـلى الاقـل.', NULL, 'SMACC 2-3-1-1', 'Not Applicable', 36, 1, NULL, NULL, NULL, 1, NULL, NULL, 253, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(255, 'SMACC 2-3-1-2', 'SMACC 2-3-1-2', 'بالاضافـة للضوابـط الفرعيـة ضمـن الضابـط 2-3-3 يف الضوابـط الاساسـيةللامـن السـيرباين، يجـب\r\nأن تغطـي متطلبـات الامـن السـيرباين لحاميـة حسـابات التواصـل الاجتامعـي للجهـة، والاصـول\r\nالتقنيـة الخاصـة بهـا، بحـد أدى  مراجعـة إعـدادات الحاميـة والتحصـن لحسـابات التواصـل الاجتامعـي للجهـة\r\nوالاصــول التقنيــة الخاصــة بهــا )Hardening and Configuration Secure ،)\r\nمـرة واحـدة كل سـنة عـى الاقـل', NULL, 'SMACC 2-3-1-2', 'Not Applicable', 36, 1, NULL, NULL, NULL, 1, NULL, NULL, 253, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(256, 'SMACC 2-3-1-3', 'SMACC 2-3-1-3', 'بالاضافـة للضوابـط الفرعيـة ضمـن الضابـط 2-3-3 يف الضوابـطالاساسـية للامـن السـيرباين، يجـب\r\nأن تغطـي متطلبـات الامـن السـيرباين لحاميـة حسـابات التواصـل الاجتامعـي للجهـة، والاصـول\r\nالتقنيـة الخاصـة بهـا، بحـد أدى  مراجعـة وتحصـن اإلاعـدادات المصنعيـة )Configuration Default )لحسـابات\r\nالتواصــل الاجتامعــي والاصــول التقنيــة، ومنهــا وجــود كلــات مــرور ثابتــة أو\r\nتسـجيل الدخـول المسـبق، وإقفـال الاجهـزة )Lockout', NULL, 'SMACC 2-3-1-3', 'Not Applicable', 36, 1, NULL, NULL, NULL, 1, NULL, NULL, 253, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(257, 'SMACC 2-3-1-4', 'SMACC 2-3-1-4', 'بالاضافـة للضوابـط الفرعيـة ضمـن الضابـط 2-3-3 يف الضوابـط الاساسـية للامـن السـيرباين، يجـب\r\nأن تغطـي متطلبـات الامـن السـيرباين لحاميـة حسـابات التواصـل الاجتامعـي للجهـة، والاصـول\r\nالتقنيـة الخاصـة بهـا، بحـد أدى   تقييـد تفعيـل الخصائـص والخدمـات يف حسـابات التواصـل الاجتامعـي حسـب\r\nالحاجــة، عــى أن يتــم تحليــل المخاطــر الســيربانية المحتملــة يف حــال الحاجــة\r\nلتفعيلهـا.', NULL, 'SMACC 2-3-1-4', 'Not Applicable', 36, 1, NULL, NULL, NULL, 1, NULL, NULL, 253, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(258, 'SMACC 2-4-1', 'SMACC 2-4-1', 'بالاضافـة للضوابـط الفرعيـة ضمـن الضابـط 2-6-3 يف الضوابـط الاساسـية للامـن السـيرباين، يجـب\r\nأن تغطــي متطلبــات الامــن الســيرباين الخاصــة بأمــن الاجهــزة املحمولــة لحســابات التواصــل\r\nالاجتامعـي للجهـة', NULL, 'SMACC 2-4-1', 'Not Applicable', 39, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(259, 'SMACC 2-4-1-1', 'SMACC 2-4-1-1', 'بالاضافـة للضوابـط الفرعيـة ضمـن الضابـط 2-6-3 يف الضوابـط الاساسـية لألمـن السـيرباين، يجـب\r\nأن تغطــي متطلبــات الامــن الســيرباين الخاصــة بأمــن الاجهــزة المحمولــة لحســابات التواصــل\r\nالا جتامعـي للجهـة، بحـد أدىن،    إدارة الاجهــزة المحمولــة مركزيــاً باســتخدام نظــام إدارة الاجهــزة المحمولــة\r\n)MDM - Management Device M', NULL, 'SMACC 2-4-1-1', 'Not Applicable', 39, 1, NULL, NULL, NULL, 1, NULL, NULL, 258, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(260, 'SMACC 2-4-1-2', 'SMACC 2-4-1-2', 'بالاضافـة للضوابـط الفرعيـة ضمـن الضابـط 2-6-3 يف الضوابـط الاساسـية للامـن السـيرباين، يجـب\r\nأن تغطــي متطلبــات الامــن الســيرباين الخاصــة بأمــن الاجهــزة المحمولــة لحســابات التواصــل\r\nالاجتامعـي للجهـة، بحـد أدى   تطبيـق حـزم التحديثـات، والاصلحات الامنيـة للأجهـزة المحمولـة، مـرة واحـدة\r\nشـهرياً، علـى الاقـل', NULL, 'SMACC 2-4-1-2', 'Not Applicable', 39, 1, NULL, NULL, NULL, 1, NULL, NULL, 258, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(261, 'SMACC 2-5-1', 'SMACC 2-5-1', 'بالاضافــة للضوابــط الفرعيــة ضمــن الضابــط 2-7-3 يف الضوابــط الاساســية للامــن الســيرباني،\r\nيجـب أن تغطـي متطلبـات الامـن السـيرباني لحاميـة البيانـات والملعومـات لحسـابات التواصـل\r\nالاجتامعــي للجهــة', NULL, 'SMACC 2-5-1', 'Not Applicable', 40, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(262, 'SMACC 2-5-1-1', 'SMACC 2-5-1-1', 'بالاضافــة للضوابــط الفرعيــة ضمــن الضابــط 2-7-3 يف الضوابــط الاساســية للامــن الســيرباني،\r\nيجـب أن تغطـي متطلبـات الامـن السـيرباين لحاميـة البيانـات والمعلومـات لحسـابات التواصـل\r\nالاجتامعــي للجهــة، بحــد أدى   يجــب أن ال تحتــوي الاصــول التقنيــة الخاصــة بحســابات التواصــل الاجتامعــي\r\nللجهــة عــى بيانــات مصنفــة، حســب الترشيعــات ذات العلاقــة', NULL, 'SMACC 2-5-1-1', 'Not Applicable', 40, 1, NULL, NULL, NULL, 1, NULL, NULL, 261, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(263, 'SMACC 2-6-1', 'SMACC 2-6-1', 'الاضافــة للضوابــط الفرعيــة ضمــن الضابــط 2-12-3 يف الضوابــط الاساســية للأمــن الســيرباني،\r\nيجـب أن تغطـي متطلبـات إدارة سـجلات الاحـداث، ومراقبـة الامـن السـيرباني لحسـابات التواصـل\r\nالاجتامعـي للجهـة والاصـول التقنيـة التابعـة لهـا', NULL, 'SMACC 2-6-1', 'Not Applicable', 45, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(264, 'SMACC 2-6-1-1', 'SMACC 2-6-1-1', 'بالاضافــة للضوابــط الفرعيــة ضمــن الضابــط 2-12-3 يف الضوابــط الاساســية للامــن الســيرباني،\r\nيجـب أن تغطـي متطلبـات إدارة سـجلات الاحـداث، ومراقبـة الامـن السـيرباني لحسـابات التواصـل\r\nالاجتامعـي للجهـة والاصـول التقنيـة التابعـة لهـا، بحـد أدى  تفعيـل جميـع الاشـعارات وتنبيهـات الامـن السـيرباني الخاصة بحسـابات التواصل\r\nالاجتامعـي وسـجلات الاحـداث )Logs Event )الخاصـة باألمـن السـيرباني علـى\r\nالاصـول التقنيـة الخاصـة بحسـابات التواصـل الاجتامعـي', NULL, 'SMACC 2-6-1-1', 'Not Applicable', 45, 1, NULL, NULL, NULL, 1, NULL, NULL, 263, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(265, 'SMACC 2-6-1-2', 'SMACC 2-6-1-2', 'بالاضافــة للضوابــط الفرعيــة ضمــن الضابــط 2-12-3 يف الضوابــط الاساســية الامــن الســيرباني،\r\nيجـب أن تغطـي متطلبـات إدارة سـجلات الاحـداث، ومراقبـة الامـن السـيرباني لحسـابات التواصـل\r\nالاجتامعـي للجهـة والاصـول التقنيـة التابعـة لهـا، بحـد أدى    متابعــة حســابات التواصــل الاجتامعــي و مراقبتهــا للتأكــد مــن عــدم نــر أي\r\nمحتــوى غــر مــرح، أو تســجيل أي دخــول غــر مــرح.', NULL, 'SMACC 2-6-1-2', 'Not Applicable', 45, 1, NULL, NULL, NULL, 1, NULL, NULL, 263, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(266, 'SMACC 2-6-1-3', 'SMACC 2-6-1-3', 'بالاضافــة للضوابــط الفرعيــة ضمــن الضابــط 2-12-3 يف الضوابــط الاساســية لألمــن الســيرباني،\r\nيجـب أن تغطـي متطلبـات إدارة سـجلات الاحـداث، ومراقبـة الامـن السـيرباني لحسـابات التواصـل\r\nالاجتامعـي للجهـة والاصـول التقنيـة التابعـة لهـا، بحـد أدى   لمتابعـة شـبكات التواصـل الاجتامعـي ومراقبتهـا للتأكـد مـن عـدم انتحـال هويـة\r\nالجهة.', NULL, 'SMACC 2-6-1-3', 'Not Applicable', 45, 1, NULL, NULL, NULL, 1, NULL, NULL, 263, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(267, 'SMACC 2-6-1-4', 'SMACC 2-6-1-4', 'بالاضافــة للضوابــط الفرعيــة ضمــن الضابــط 2-12-3 يف الضوابــط الاساســية للامــن الســيرباني،\r\nيجـب أن تغطـي متطلبـات إدارة سـجلات الاحـداث، ومراقبـة الامـن السـيرباني لحسـابات التواصـل\r\nالاجتامعـي للجهـة والاصـول التقنيـة التابعـة لهـا، بحـد أدى  المراقبــة الاليــة ألي تغيــر يف منــط الحســابات أو مــؤرشات اخـتـراق أو نــر أي\r\nمحتـوى غـر مـرح أو انتحـال هويـة الجهـة', NULL, 'SMACC 2-6-1-4', 'Not Applicable', 45, 1, NULL, NULL, NULL, 1, NULL, NULL, 263, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(268, 'SMACC 2-7-1', 'SMACC 2-7-1', 'بالاضافـة للضوابـط الفرعيـة ضمـن الضابـط 2-13-3 يف الضوابـطالاساسـية للامـن السـيرباني، يجب\r\nأن تغطـي متطلبـات إدارة حـوادث وتهديـدات الامـن السـيرباني في الجهـة', NULL, 'SMACC 2-7-1', 'Not Applicable', 46, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(269, 'SMACC 2-7-1-1', 'SMACC 2-7-1-1', 'بالاضافـة للضوابـط الفرعيـة ضمـن الضابـط 2-13-3 يف الضوابـط الاساسـية لألمـن السـيرباني، يجب\r\nأن تغطـي متطلبـات إدارة حـوادث وتهديـدات الامـن السـيرباني في الجهـة، بحـد أدى  وضــع خطــة اســتعادة حســابات التواصــل الاجتامعــي والتعامــل مــع الحــوادث\r\nالســيربانية.', NULL, 'SMACC 2-7-1-1', 'Not Applicable', 46, 1, NULL, NULL, NULL, 1, NULL, NULL, 268, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(270, 'SMACC 3-1-1', 'SMACC 3-1-1', 'يجــب تقييــم مــدى الحاجــة الســتخدام خدمــات إدارة حســابات التواصــل الاجتامعــي )social\r\nmanagement media )واملراقبـة الاليـة لحسـابات التواصـل الاجتامعـي أو لحاميـة هويـة الجهـة\r\nمـن الانتحـال )protection brand )ومخاطـر الامـن السـيرباني', NULL, 'SMACC 3-1-1', 'Not Applicable', 50, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(271, 'SMACC 3-1-2', 'SMACC 3-1-2', 'بالاضافــة للضوابــط الفرعيــة ضمــن الضابــط 4 - 1 - 2 يف الضوابــط الاساســية للامــن الســيرباني،\r\nيجـب أن تغطـي متطلبـات الامـن السـيرباني الخاصـة باسـتخدام خدمـات إدارة حسـابات التواصـل\r\nالاجتامعـي )management media social )والمراقبـة الاليـة لحسـابات التواصـل الا جتامعـي أو\r\nلحاميـة هويـة الجهـة مـن الانتحـال )protection b', NULL, 'SMACC 3-1-2', 'Not Applicable', 50, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(272, 'SMACC 3-1-2-1', 'SMACC 3-1-2-1', 'بالاضافــة للضوابــط الفرعيــة ضمــن الضابــط 4 - 1 - 2 يف ,الضوابــط الاساســية للامــن الســيرباني\r\nيجـب أن تغطـي متطلبـات الامـن السـيرباني الخاصـة باسـتخدام خدمـات إدارة حسـابات التواصـل\r\nالاجتامعـي )management media social )والمراقبـة الاليـة لحسـابات التواصـل الاجتامعـي أو\r\nلحاميـة هويـة الجهـة مـن الانتحـال )protection brand ،)بحـد أدىن،   بنــود املحافظــة عــى رسيــة المعلومــات )Clauses Disclosure-Non )والحــذف\r\nالامـن مـن قبـل الطـرف الخارجـي لبيانـات الجهـة عنـد انتهـاء الخدمـة', NULL, 'SMACC 3-1-2-1', 'Not Applicable', 50, 1, NULL, NULL, NULL, 1, NULL, NULL, 271, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(273, 'SMACC 3-1-2-2', 'SMACC 3-1-2-2', 'بالاضافــة للضوابــط الفرعيــة ضمــن الضابــط 4 - 1 - 2 يف الضوابــط الاساســية للامــن الســيرباني،\r\nيجـب أن تغطـي متطلبـات الامـن السـيرباني الخاصـة باسـتخدام خدمـات إدارة حسـابات التواصـل\r\nالاجتامعـي )management media social )والمراقبـة الاليـة لحسـابات التواصـل الاجتامعـي أو\r\nلحاميـة هويـة الجهـة مـن االانتحـال )protection brand ،)بحـد أدى   إجراءات التواصل لإلبالغ عن الثغرات ويف حال اكتشاف حادثة أمن سيرباني.', NULL, 'SMACC 3-1-2-2', 'Not Applicable', 50, 1, NULL, NULL, NULL, 1, NULL, NULL, 271, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL);
INSERT INTO `framework_controls` (`id`, `short_name`, `long_name`, `description`, `supplemental_guidance`, `control_number`, `control_status`, `family`, `control_owner`, `desired_maturity`, `control_priority`, `control_class`, `control_maturity`, `control_phase`, `control_type`, `parent_id`, `submission_date`, `last_audit_date`, `next_audit_date`, `desired_frequency`, `mitigation_percent`, `status`, `deleted`, `created_at`, `updated_at`) VALUES
(274, 'SMACC 3-1-2-3', 'SMACC 3-1-2-3', 'بالاضافــة للضوابــط الفرعيــة ضمــن الضابــط 4 - 1 - 2 يف الضوابــط الاساســية للامــن الســيرباني،\r\nيجـب أن تغطـي متطلبـات الامـن السـيرباني الخاصـة باسـتخدام خدمـات إدارة حسـابات التواصـل\r\nالاجتامعـي )management media social )والمراقبـة الاليـة لحسـابات التواصـلالاجتامعـي أو\r\nلحاميـة هويـة الجهـة مـن االنتحـال )protection brand ،)بحـد أدى    إلــزام الطــرف الخارجــي بتطبيــق متطلبــات وسياســات الامــن الســيرباني لحاميــة\r\nحســابات التواصــل الاجتامعــي للجهــة والمتطلبــات الترشيعيــة والتنظيميــة ذات\r\nالعلاقــة', NULL, 'SMACC 3-1-2-3', 'Not Applicable', 50, 1, NULL, NULL, NULL, 1, NULL, NULL, 271, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(275, 'TCC 1-1-1', 'TCC 1-1-1', 'رجوعا للضابط 1- 3-1 يف الضوابط الاساسيةللامن السيرباني، يجب أن تغطي سياسات وإجراءات\r\nالامن السيرباني', NULL, 'TCC 1-1-1', 'Not Applicable', 26, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(276, 'TCC 1-1-1-1', 'TCC 1-1-1-1', 'رجوعا للضابط 1- 3-1 يف الضوابط الاساسية للأمن السيرباني، يجب أن تغطي سياسات وإجراءات\r\nالامن السيرباني بحد أدى تحديد وتوثيق متطلبات وضوابط الامن السيرباني للعمل عن بعد ضمن سياسات\r\nالامن السيرباني للجهة', NULL, 'TCC 1-1-1-1', 'Not Applicable', 26, 1, NULL, NULL, NULL, 1, NULL, NULL, 275, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(277, 'TCC 1-2-1', 'TCC 1-2-1', 'بالاضافة للضوابط ضمن المكون الفرعي 1 - 5 يف الضوابط الاساسية لألمن السيرباني، يجب أن\r\nتغطي منهجية إدارة مخاطر الامن السيرباني', NULL, 'TCC 1-2-1', 'Not Applicable', 28, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(278, 'TCC 1-2-1-1', 'TCC 1-2-1-1', 'بالاضافة للضوابط ضمن المكون الفرعي 1 - 5 يف الضوابط الاساسية للامن السيرباني، يجب أن\r\nتغطي منهجية إدارة مخاطر الامن السيرباني بحد أدى   تقييم مخاطر الامن السيرباني ألانظمة العمل عن بعد، مرة واحدة سنوياً، عىل\r\nالاقل', NULL, 'TCC 1-2-1-1', 'Not Applicable', 28, 1, NULL, NULL, NULL, 1, NULL, NULL, 277, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(279, 'TCC 1-2-1-2', 'TCC 1-2-1-2', 'بالاضافة للضوابط ضمن المكون الفرعي 1 - 5 يف الضوابط الاساسية للامن السيرباني، يجب أن\r\nتغطي منهجية إدارة مخاطر الامن السيرباين بحد أدى   تقييم مخاطر الامن السيرباني عند التخطيط وقبل السامح بالعمل عن بعد ألي\r\nخدمة أو نظام.', NULL, 'TCC 1-2-1-2', 'Not Applicable', 28, 1, NULL, NULL, NULL, 1, NULL, NULL, 277, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(280, 'TCC 1-2-1-3', 'TCC 1-2-1-3', 'تضمني مخاطر الامن السيرباين الخاصة بأنظمة العمل عن بعد والخدمات\r\nوالانظمة المسموح لها بالعمل عن بعد يف سجل مخاطر الامن السيرباني الخاص\r\nبالجهة، ومتابعته مرة واحدة سنويا، عىل الاقل', NULL, 'TCC 1-2-1-3', 'Not Applicable', 28, 1, NULL, NULL, NULL, 1, NULL, NULL, 277, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(281, 'TCC 1-3-1', 'TCC 1-3-1', 'بالاضافة للضوابط الفرعية ضمن الضابط 1 - 10 -3 يف الضوابط الاساسية للامن السيرباي، فإنه\r\nيجب أن يغطي برنامج التوعية بالامن السيرباني المخاطر والتهديدات السيربانية للعمل عن بعد\r\nوالاستخدام الامن للحد من هذه المخاطر والتهديدات', NULL, 'TCC 1-3-1', 'Not Applicable', 33, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(282, 'TCC 1-3-1-1', 'TCC 1-3-1-1', 'الاستخدام الامن للأجهزة المخصصة للعمل عن بعد والمحافظة عليها وحاميتها.', NULL, 'TCC 1-3-1-1', 'Not Applicable', 33, 1, NULL, NULL, NULL, 1, NULL, NULL, 281, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(283, 'TCC 1-3-1-2', 'TCC 1-3-1-2', 'التعامل الامن مع هويات الدخول وكلمات المرور.', NULL, 'TCC 1-3-1-2', 'Not Applicable', 33, 1, NULL, NULL, NULL, 1, NULL, NULL, 281, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(284, 'TCC 1-3-1-3', 'TCC 1-3-1-3', 'حامية البيانات التي يتم حفظها على الاجهزة المستخدمة للعمل عن بعد\r\nوالتعامل معها حسب تصنيفها وإجراءات وسياسات الجهة', NULL, 'TCC 1-3-1-3', 'Not Applicable', 33, 1, NULL, NULL, NULL, 1, NULL, NULL, 281, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(285, 'TCC 1-3-1-4', 'TCC 1-3-1-4', 'التعامل الامن مع التطبيقات والحلول المستخدمة للعمل عن بعد كالاجتامعات\r\nاالفرتاضية، والتعاون ومشاركة الملفات', NULL, 'TCC 1-3-1-4', 'Not Applicable', 33, 1, NULL, NULL, NULL, 1, NULL, NULL, 281, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(286, 'TCC 1-3-1-5', 'TCC 1-3-1-5', 'التعامل الامن مع الشبكات المنزلية والتأكد من إعدادت الحامية الخاصة بها', NULL, 'TCC 1-3-1-5', 'Not Applicable', 33, 1, NULL, NULL, NULL, 1, NULL, NULL, 281, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(287, 'TCC 1-3-1-6', 'TCC 1-3-1-6', 'تجنب العمل عن بعد باستخدام أجهزة أو شبكات عامة غري موثوقة أو أثناء\r\nالتواجد يف أماكن عامة.', NULL, 'TCC 1-3-1-6', 'Not Applicable', 33, 1, NULL, NULL, NULL, 1, NULL, NULL, 281, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(288, 'TCC 1-3-1-7', 'TCC 1-3-1-7', 'الوصول الملادي غري مصرح به والفقدان والرسقة والتخريب الأصول التقنية\r\nوأنظمة العمل عن بعد.', NULL, 'TCC 1-3-1-7', 'Not Applicable', 33, 1, NULL, NULL, NULL, 1, NULL, NULL, 281, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(289, 'TCC 1-3-1-8', 'TCC 1-3-1-8', 'التواصل مبارشة مع اإلدارة املعنية باألمن السيرباين يف الجهة حال االشتباه بتهديد\r\nأمن سيرباي', NULL, 'TCC 1-3-1-8', 'Not Applicable', 33, 1, NULL, NULL, NULL, 1, NULL, NULL, 281, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(290, 'TCC 1-3-2', 'TCC 1-3-2', 'بالاضافة للضوابط الفرعية ضمن الضابط 1 - 10 - 4 يف الضوابط الاساسية للامن السيرباني، فإنه\r\nيجب تدريب العاملين على المهارات التقنية الالزمة لضامن تطبيق متطلبات ومامرسات الامن\r\nالسيرباني عند التعامل مع أنظمة العمل عن بعد', NULL, 'TCC 1-3-2', 'Not Applicable', 33, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(291, 'TCC 2-1-1', 'TCC 2-1-1', 'بالاضافة للضوابط ضمن المكون الفرعي 2-1 يف الضوابط الاساسية للامن السيرباني، يجب أن\r\nتغطي متطلبات الامن السيرباني إلادارةالاصول المعلوماتية والتقنية', NULL, 'TCC 2-1-1', 'Not Applicable', 34, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(292, 'TCC 2-1-1-1', 'TCC 2-1-1-1', 'تحديد وحرص الاصول المعلوماتية والتقنية للانظمة العمل عن بعد، وتحديثها\r\nمرة واحدة، كل سنة؛ عىل الاقل', NULL, 'TCC 2-1-1-1', 'Not Applicable', 34, 1, NULL, NULL, NULL, 1, NULL, NULL, 291, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(293, 'TCC 2-2-1', 'TCC 2-2-1', 'بالاضافة للضوابط الفرعية ضمن الضابط 2-2-3 يف الضوابط الاساسية للامن السيرباني، يجب\r\nأن تغطي متطلبات الامن السيرياني المتعلقة بإدارة هويات الدخول، والصلاحيات للانظمة\r\nالمستخدمة يف العمل عن بعد في الجهة', NULL, 'TCC 2-2-1', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(294, 'TCC 2-2-1-1', 'TCC 2-2-1-1', 'ً على احتياجات العمل، مع\r\nإدارة صلاحيات المستخدمين للعمل عن بعد بناء\r\nمراعاة حساسيةالانظمة ومستوى الصلاحيات، ونوعية الاجهزة المستخدمة من\r\nقبل الموظفين للعمل عن بعد', NULL, 'TCC 2-2-1-1', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, 293, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(295, 'TCC 2-2-1-2', 'TCC 2-2-1-2', 'تقييد إمكانية الوصول عن بعد لنفس المستخدم من أجهزة حاسبات متعددة\r\nيف نفس الوقت )Logins Concurrent.', NULL, 'TCC 2-2-1-2', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, 293, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(296, 'TCC 2-2-1-3', 'TCC 2-2-1-3', 'استخدام معايري آمنة إلادارة الهويات وكليمات المرور المستخدمة في أنظمة\r\nالعمل عن بعد.', NULL, 'TCC 2-2-1-3', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, 293, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(297, 'TCC 2-2-2', 'TCC 2-2-2', 'رجوعاً للضابط الفرعي 2-2-3-5 يف الضوابط الاساسية للامن السيرباني، يجب مراجعة هويات\r\nالدخول والصلاحيات المستخدمة للعمل عن بعد، بحد أدنى مرة واحدة كل سنة', NULL, 'TCC 2-2-2', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(298, 'TCC 2-3-1', 'TCC 2-3-1', 'بالاضافة للضوابط الفرعية ضمن الضابط 2-3-3 في الضوابط الاساسية للامن السيرباني، يجب أن\r\nتغطي متطلبات الامن السيرباني لحامية أنظمة العمل عن بعد، وأجهزة المعلومات الخاصة بها،', NULL, 'TCC 2-3-1', 'Not Applicable', 36, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(299, 'TCC 2-3-1-1', 'TCC 2-3-1-1', 'تطبيق حزم التحديثات، والاصلاحات الامنية للانظمة العمل عن بعد، مرة واحدة\r\nشهريا على الاقل', NULL, 'TCC 2-3-1-1', 'Not Applicable', 36, 1, NULL, NULL, NULL, 1, NULL, NULL, 298, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(300, 'TCC 2-3-1-2', 'TCC 2-3-1-2', 'مراجعة إعدادات الحاميةالانظمة العمل عن بعد والتحصين\r\n)Hardening and Configuration Secure ،)مرة واحدة كل سنة عىل الاقل', NULL, 'TCC 2-3-1-2', 'Not Applicable', 36, 1, NULL, NULL, NULL, 1, NULL, NULL, 298, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(301, 'TCC 2-3-1-3', 'TCC 2-3-1-3', 'مراجعة وتحصين الاعدادت المصنعية )Configuration Default )لأصولا\r\nالتقنية الانظمة العمل عن بعد، ومنها وجود كليمات مرور ثابتة، وخلفية\r\nافتراضية', NULL, 'TCC 2-3-1-3', 'Not Applicable', 36, 1, NULL, NULL, NULL, 1, NULL, NULL, 298, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(302, 'TCC 2-3-1-4', 'TCC 2-3-1-4', 'اإالدارة آلامنة لجلسات )Management Session Secure ،)ويشمل موثوقية\r\nالجلسات )Authenticity ،)وإقفالها )Lockout ،)وإنهاء مهلتها )Timeout.)', NULL, 'TCC 2-3-1-4', 'Not Applicable', 36, 1, NULL, NULL, NULL, 1, NULL, NULL, 298, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(303, 'TCC 2-3-1-5', 'TCC 2-3-1-5', 'تقييد تفعيل الخصائص والخدمات في أنظمة العمل عن بعد حسب الحاجة،\r\nعىل أن يتم تحليل المخاطر السيربانية المحتملة في حال الحاجة لتفعيلها.', NULL, 'TCC 2-3-1-5', 'Not Applicable', 36, 1, NULL, NULL, NULL, 1, NULL, NULL, 298, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(304, 'TCC 2-4-1', 'TCC 2-4-1', 'بالاضافة للضوابط الفرعية ضمن الضابط 2-5-3 في الضوابط الاساسية للامن السيرباين، يجب\r\nأن تغطي متطلبات اللمن السيرباني إلادارة أمن شبكات الجهة للعمل عن بعد', NULL, 'TCC 2-4-1', 'Not Applicable', 38, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(305, 'TCC 2-4-1-1', 'TCC 2-4-1-1', 'تقييد منافذ وبروتوكوالت وخدمات الشبكة المستخدمة لعمليات الدخول عن\r\nبعد، وخصوصاً على الانظمة الداخلية، وفتحها حسب الحاجة', NULL, 'TCC 2-4-1-1', 'Not Applicable', 38, 1, NULL, NULL, NULL, 1, NULL, NULL, 304, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(306, 'TCC 2-4-1-2', 'TCC 2-4-1-2', 'مراجعة إعدادات وقوائم جدار الحامية )Rules Firewall )ذات العلاقة\r\nبأنظمة العمل عن بعد؛ مرة واحدة كل سنة على الاقل', NULL, 'TCC 2-4-1-2', 'Not Applicable', 38, 1, NULL, NULL, NULL, 1, NULL, NULL, 304, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(307, 'TCC 2-4-1-3', 'TCC 2-4-1-3', 'الحامية من هجامت تعطيل الشبكات ))DDoS (Service of Denial Distributed )\r\nعلى أنظمة العمل عن بعد للحد من المخاطر الناتجة عن هجامت تعطيل الشبكات', NULL, 'TCC 2-4-1-3', 'Not Applicable', 38, 1, NULL, NULL, NULL, 1, NULL, NULL, 304, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(308, 'TCC 2-4-1-4', 'TCC 2-4-1-4', 'الحامية من التهديدات المتقدمة المستمرة عىل مستوى الشبكة ألانظمة العمل\r\nعن بعد )APT Network.', NULL, 'TCC 2-4-1-4', 'Not Applicable', 38, 1, NULL, NULL, NULL, 1, NULL, NULL, 304, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(309, 'TCC 2-5-1', 'TCC 2-5-1', 'بالاضافة للضوابط الفرعية ضمن الضابط 2-6-3 يف الضوابط الاساسية للامن السيرباني، يجب أن\r\nتغطي متطلبات الامن السيرباني الخاصة بأمن الاجهزة المحمولة للعمل عن بعد في الجهة', NULL, 'TCC 2-5-1', 'Not Applicable', 39, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(310, 'TCC 2-5-1-1', 'TCC 2-5-1-1', 'إدارة الاجهزة المحمولة وأجهزة )BYOD )مركزياً باستخدام نظام إدارة الاجهزة\r\nالمحمولة ))MDM (Management Device Mobile.)', NULL, 'TCC 2-5-1-1', 'Not Applicable', 39, 1, NULL, NULL, NULL, 1, NULL, NULL, 309, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(311, 'TCC 2-5-1-2', 'TCC 2-5-1-2', 'تطبيق حزم التحديثات، والاصلاحات األمنية للأجهزة المحمولة، مرة واحدة\r\nشهريا، على الاقل', NULL, 'TCC 2-5-1-2', 'Not Applicable', 39, 1, NULL, NULL, NULL, 1, NULL, NULL, 309, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(312, 'TCC 2-6-1', 'TCC 2-6-1', 'بالاضافة للضوابط الفرعية ضمن الضابط 2-7-3 يف الضوابط الاساسية للامن السيرباني، يجب\r\nأن تغطي متطلبات الامن السيرباني لحامية البيانات والمعومات للعمل عن بعد في الجهة', NULL, 'TCC 2-6-1', 'Not Applicable', 40, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(313, 'TCC 2-6-1-1', 'TCC 2-6-1-1', 'تحديد البيانات المصنفة، حسب الترشيعات ذات العلاقة، التي ميكن استخدامها\r\nأو الوصول إليها أو التعامل معها من خلال أنظمة العمل عن بعد', NULL, 'TCC 2-6-1-1', 'Not Applicable', 40, 1, NULL, NULL, NULL, 1, NULL, NULL, 312, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(314, 'TCC 2-6-1-2', 'TCC 2-6-1-2', 'حامية البيانات المصنفة، التي تم تحديدها في الضابط 2-6-1-1 ،باستخدام\r\nضوابط مثل منع استخدام نوع من البيانات المصنفة أو تقنيات مثل منع\r\nترسيب البيانات )Prevention Leakage Data .)وميكن تحديد هذه الضوابط\r\nوالتقنيات عن طريق تحليل المخاطر السيربانية للجهة', NULL, 'TCC 2-6-1-2', 'Not Applicable', 40, 1, NULL, NULL, NULL, 1, NULL, NULL, 312, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(315, 'TCC 2-7-1', 'TCC 2-7-1', 'بالاضافة للضوابط الفرعية ضمن الضابط 2-8-3 في الضوابط الاساسية للامن السيرباني، يجب أن\r\nتغطي متطلبات الامن السيرباني الخاصة بالتشفر لدى المشرتكين،', NULL, 'TCC 2-7-1', 'Not Applicable', 41, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(316, 'TCC 2-7-1-1', 'TCC 2-7-1-1', 'استخدام طرق وخوارزميات محدثة وآمنة للتشفري على كامل الاتصال الشبيك\r\nالمستخدم للعمل عن بعد وفقاً للمستوى المتقدم )Advanced )ضمن المعايري\r\nالوطنية للتشفري )2020:1 – NCS.)', NULL, 'TCC 2-7-1-1', 'Not Applicable', 41, 1, NULL, NULL, NULL, 1, NULL, NULL, 315, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(317, 'TCC 2-8-1', 'TCC 2-8-1', 'بالاضافة للضوابط الفرعية ضمن الضابط 2-9-3 في الضوابط الاساسية للامن السيرباني، يجب أن\r\nتغطي متطلبات الامن السيرباني إلادارة النسخ الاحتياطية ألانظمة العمل عن بعد في الجهة', NULL, 'TCC 2-8-1', 'Not Applicable', 42, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(318, 'TCC 2-8-1-1', 'TCC 2-8-1-1', 'عمل النسخ الاحتياطي على فرتات زمنية مخطط لها؛ بناء عىل تقييم المخاطر\r\nللجهة، لأنظمة العمل عن بعد. وتوصي الهيئة بأن يتم عمل النسخ الاحتياطية،\r\nلانظمة العمل عن بعد مرة واحدة كل أسبوع', NULL, 'TCC 2-8-1-1', 'Not Applicable', 42, 1, NULL, NULL, NULL, 1, NULL, NULL, 317, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(319, 'TCC 2-8-2', 'TCC 2-8-2', 'رجوعاً للضابط 2-9-3-3 في الضوابط الاساسية الامن السيرباني، يجب إجراء فحص دوري؛ كل\r\nستة أشهر على الاقل، لتحديد مدى فعالية استعادة النسخ الاحتياطية، الخاصة بأنظمة العمل\r\nعن بعد', NULL, 'TCC 2-8-2', 'Not Applicable', 42, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(320, 'TCC 2-9-1', 'TCC 2-9-1', 'بالاضافة للضوابط الفرعية ضمن الضابط 2-10-3 في الضوابط الاساسية الامن السيرباني، يجب\r\nأن تغطي متطلبات الامن السيرباني إلادارة الثغرات الأصول التقنية وأنظمة العمل عن بعد', NULL, 'TCC 2-9-1', 'Not Applicable', 43, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(321, 'TCC 2-9-1-1', 'TCC 2-9-1-1', 'فحص الثغرات واكتشافها على أنظمة العمل عن بعد وتصنيفها حسب خطورتها،\r\nمرة واحدة كل ثالثة أشهر على الاقل', NULL, 'TCC 2-9-1-1', 'Not Applicable', 43, 1, NULL, NULL, NULL, 1, NULL, NULL, 320, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(322, 'TCC 2-9-1-2', 'TCC 2-9-1-2', 'معالجة الثغرات عىل أنظمة العمل عن بعد، مرة واحدة كل ثالثة أشهر عىل\r\nاألقل.', NULL, 'TCC 2-9-1-2', 'Not Applicable', 43, 1, NULL, NULL, NULL, 1, NULL, NULL, 320, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(323, 'TCC 2-10-1', 'TCC 2-10-1', 'بالاضافة للضوابط الفرعية ضمن الضابط ٢-١١-٣ يف الضوابط الاساسية للامن السيرباني، يجب\r\nأن تغطي متطلبات الامن السيرباني لاختبار ااختراق لانظمة العمل عن بعد،', NULL, 'TCC 2-10-1', 'Not Applicable', 44, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(324, 'TCC 2-10-1-1', 'TCC 2-10-1-1', 'نطاق عمل اختبارالاختراق، ليشمل جميع المكونات التقنية لانظمة العمل عن\r\nبعد', NULL, 'TCC 2-10-1-1', 'Not Applicable', 44, 1, NULL, NULL, NULL, 1, NULL, NULL, 323, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(325, 'TCC 2-10-2', 'TCC 2-10-2', 'رجوعاً للضابط ٢-١١-٣-٢ في الضوابط الاساسية للامن السيرباني، يجب عمل اختبار الاختراق على\r\nأنظمة العمل عن بعد مرة واحدة كل سنة على الاقل', NULL, 'TCC 2-10-2', 'Not Applicable', 44, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(326, 'TCC 2-11-1', 'TCC 2-11-1', 'بالاضافة للضوابط الفرعية ضمن الضابط 2-12-3 في الضوابط الاساسية للامن السيرباني، يجب أن\r\nتغطي متطلبات إدارة سجلات الاحداث، ومراقبة الامن السيرباني لاصول التقنية وأنظمة العمل\r\nعن بعد', NULL, 'TCC 2-11-1', 'Not Applicable', 45, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(327, 'TCC 2-11-1-1', 'TCC 2-11-1-1', 'تفعيل سجلات الاحداث )Logs Event )الخاصة بالامن السيرباني على الاصول\r\nالتقنية وأنظمة العمل عن بعد', NULL, 'TCC 2-11-1-1', 'Not Applicable', 45, 1, NULL, NULL, NULL, 1, NULL, NULL, 326, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(328, 'TCC 2-11-1-2', 'TCC 2-11-1-2', 'مراقبة سلوك مستخدمي أنظمة العمل عن بعد ))UBA (Analytics Behavior User )\r\nوتحليله', NULL, 'TCC 2-11-1-2', 'Not Applicable', 45, 1, NULL, NULL, NULL, 1, NULL, NULL, 326, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(329, 'TCC 2-11-1-3', 'TCC 2-11-1-3', 'مراقبة سجلات الاحداث، الخاصة بالاصول التقنية وأنظمة العمل عن بعد على\r\nمدار الساعة.', NULL, 'TCC 2-11-1-3', 'Not Applicable', 45, 1, NULL, NULL, NULL, 1, NULL, NULL, 326, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(330, 'TCC 2-11-1-4', 'TCC 2-11-1-4', 'تحديث إجراءات مراقبة الامن السيرباني على مدار الساعة وتطبيقها، بحيث\r\nتشمل مراقبة عمليات الدخول عن بعد، والسيام عمليات الدخول عن بعد من\r\nخارج المملكة والتحقق من صحتها.', NULL, 'TCC 2-11-1-4', 'Not Applicable', 45, 1, NULL, NULL, NULL, 1, NULL, NULL, 326, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(331, 'TCC 2-11-2', 'TCC 2-11-2', 'رجوعاً للضابط 2-12-3-5 في الضوابط الاساسية للامن السيرباني، يجب أال تقل مدة الاحتفاظ\r\nبسجلات الاحداث الخاصة بالامن السيرباني ألانظمة العمل عن بعد عن 12 شهراً؛ حسب المتطلبات\r\nالترشيعية والتنظيمية ذات العلاقة.', NULL, 'TCC 2-11-2', 'Not Applicable', 45, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(332, 'TCC 2-12-1', 'TCC 2-12-1', 'بالاضافة للضوابط الفرعية ضمن الضابط 2-13-3 في الضوابط الاساسية الامن السيرباني، يجب أن\r\nتغطي متطلبات إدارة حوادث وتهديدات الامن السيرباني في الجهة', NULL, 'TCC 2-12-1', 'Not Applicable', 46, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(333, 'TCC 2-12-1-1', 'TCC 2-12-1-1', 'تحديث خطط الاستجابة لحوادث الامن السيرباني ومعلومات التواصل داخل\r\nالجهة مبا يتوافق مع حالة العمل عن بعد، ومبا يضمن القدرة عىل التواصل\r\nوجاهزية فرق الاستجابة للحوادث', NULL, 'TCC 2-12-1-1', 'Not Applicable', 46, 1, NULL, NULL, NULL, 1, NULL, NULL, 332, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(334, 'TCC 2-12-1-2', 'TCC 2-12-1-2', 'الحصول على المعلومات الاستباقية )Intelligence Threat )ذات العلاقة\r\nبأنظمة العمل عن بعد بشكل دوري والتعامل معها.', NULL, 'TCC 2-12-1-2', 'Not Applicable', 46, 1, NULL, NULL, NULL, 1, NULL, NULL, 332, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(335, 'TCC 2-12-1-3', 'TCC 2-12-1-3', 'تنفيذ وتطبيق التوصيات والتنبيهات الخاصة بحوادث وتهديدات الامن السيرباني\r\nالصادرة من مرشف القطاع أو الهيئة الوطنية الامن السيرباني', NULL, 'TCC 2-12-1-3', 'Not Applicable', 46, 1, NULL, NULL, NULL, 1, NULL, NULL, 332, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(336, 'TCC 3-1-1', 'TCC 3-1-1', 'بالالضافة للضوابط الفرعية ضمن الضابط 4- 2-3 في الضوابط الاساسية الامن السرياني، يجب أن\r\nتغطي متطلبات الامن السيرباني الخاصة باستخدام خدمات الحوسبة السحابية والاستضافة', NULL, 'TCC 3-1-1', 'Not Applicable', 51, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(337, 'TCC 3-1-1-1', 'TCC 3-1-1-1', 'موقع استضافة أنظمة العمل عن بعد يجب أن يكون داخل اململكة.', NULL, 'TCC 3-1-1-1', 'Not Applicable', 51, 1, NULL, NULL, NULL, 1, NULL, NULL, 336, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(338, 'OTCC 1-1-1', 'OTCC 1-1-1', 'رجوعاً للضابطين 1-3-1 و 1-3-2 في الضوابط الاساسية الامن السيرباني؛\r\nيجب على الجهة توثيق مجموعة من سياسات وإجراءات الامن السيرباني\r\nالمخصصة أالنظمة التحكم الصناعي )ICS\\/OT )واعتامدها وتطبيقها .', NULL, 'OTCC 1-1-1', 'Not Applicable', 26, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(339, 'OTCC 1-1-2', 'OTCC 1-1-2', 'رجوعاً للضابط 1-3-3 يف الضوابط الاساسية للامن السيرباني؛ يجب أن تكون\r\nسياسات وإجراءات الامن السيرباني انظمة التحكم الصناعي )ICS\\/OT )\r\nمدعومة مبتطلبات ومعايري الامن السيرباني والمتطلبات التقنية ذات العلاقة.\r\n)مثل => توصيات الجهة المصنعة، إرشادات التطبيق والتنفيذ، إرشادات إدارة\r\nالاعدادات(.', NULL, 'OTCC 1-1-2', 'Not Applicable', 26, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(340, 'OTCC 1-1-3', 'OTCC 1-1-3', 'رجوعاً للضابط 1-3-4 يف الضوابط الاساسيةللامن السيرباني؛ يجب مراجعة\r\nسياسات وإجراءات الامن السيرباني أنظمة التحكم الصناعي )ICS\\/OT )\r\nدوريا، أو عند حدوث تغيريات تؤثر عىل أمن وسلامة أنظمة التحكم\r\nالصناعي )ICS\\/OT( .)مثل => حدوث تغيريات في مستوى وطبيعة المخاطر،\r\nأو تغيري يف الهيكل التنظيمي للجهة، أو تغريات في العمليات والاجراءات\r\nالتشغيلية(.', NULL, 'OTCC 1-1-3', 'Not Applicable', 26, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(341, 'OTCC 1-2-1', 'OTCC 1-2-1', 'الاضافة للضوابط ضمن المكون الفرعي 1-4 في الضوابط الاساسية للامن\r\nالسيرباني؛ يجب أن تغطي متطلبات الامن السيرباني المتعلقة بأدوار\r\nومسؤوليات الامن السيرباني في بيئة أنظمة التحكم الصناعي )ICS\\/OT )', NULL, 'OTCC 1-2-1', 'Not Applicable', 27, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(342, 'OTCC 1-2-1-1', 'OTCC 1-2-1-1', 'يجب على صاحب الصلاحية، تحديد الادوار والمسؤوليات الخاصة\r\nبالامن السيرباني )RACI )وتوثيقها واعتامدها لجميع أصحاب المصلحة\r\nالمعنيني بأنظمة التحكم الصناعي )ICS\\/OT ،)مع الاخذ في الحسبان عدم\r\nتعارض المصالح', NULL, 'OTCC 1-2-1-1', 'Not Applicable', 27, 1, NULL, NULL, NULL, 1, NULL, NULL, 341, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(343, 'OTCC 1-2-1-2', 'OTCC 1-2-1-2', 'يجب إسناد أدوار الامن السيرباني ومسؤولياته المتعلقة بأنظمة\r\nالتحكم الصناعي )ICS\\/OT )لإلدارة المعنية بالامن السيرباني لدى الجهة؛\r\nمع الاخذ في الحسبان عدم تعارض المصالح.\r\n1-3 إدارة مخاطر الامن السيرباني )Manage', NULL, 'OTCC 1-2-1-2', 'Not Applicable', 27, 1, NULL, NULL, NULL, 1, NULL, NULL, 341, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(344, 'OTCC 1-3-1', 'OTCC 1-3-1', 'الاضافة للضوابط ضمن المكون الفرعي 1-5 في الضوابط الاساسية الامن\r\nالسيرباني؛ يجب أن تغطي متطلبات إدارة مخاطر الامن السيرباني المتعلقة\r\nبأنظمة التحكم الصناعي )ICS\\/OT', NULL, 'OTCC 1-3-1', 'Not Applicable', 28, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(345, 'OTCC 1-3-1-1', 'OTCC 1-3-1-1', 'وضع منهجية مخاطر الامن السيرباني، المتعلقة بأنظمة التحكم\r\nالصناعي )ICS\\/OT )ضمن منهجية إدارة المخاطر و إدارة مخاطر السالمة\r\nوإجراءاتها في الجهة', NULL, 'OTCC 1-3-1-1', 'Not Applicable', 28, 1, NULL, NULL, NULL, 1, NULL, NULL, 344, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(346, 'OTCC 1-3-1-2', 'OTCC 1-3-1-2', 'يجب تقييم مخاطر الامن السيرباني،لانظمة التحكم الصناعي\r\n)ICS\\/OT )بشكل دوري، مع التأكد من تضمني مخاطر توقيع العقود\r\nوالاتفاقيات، مع الاطراف الخارجية المتعلقة بأنظمة التحكم الصناعي\r\n)ICS\\/OT )و\\/أو عند حدوث تغيريات باملتطلبات الترشيعية والتنظيمية،\r\nذات العلاقة بوصفها جزء من التقييم', NULL, 'OTCC 1-3-1-2', 'Not Applicable', 28, 1, NULL, NULL, NULL, 1, NULL, NULL, 344, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(347, 'OTCC 1-3-1-3', 'OTCC 1-3-1-3', 'تضمني سجل مخاطر الامن السيرباني، المتعلقة بأنظمة التحكم\r\nالصناعي )ICS\\/OT )ضمن سجل المخاطر في الجهة.', NULL, 'OTCC 1-3-1-3', 'Not Applicable', 28, 1, NULL, NULL, NULL, 1, NULL, NULL, 344, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(348, 'OTCC 1-3-1-4', 'OTCC 1-3-1-4', 'تحديد المستويات الملائمة للمناطق، والمرافق التي تحتوي على\r\nً على منهجية معتمدة.\r\nأنظمة التحكم الصناعي )ICS\\/OT', NULL, 'OTCC 1-3-1-4', 'Not Applicable', 28, 1, NULL, NULL, NULL, 1, NULL, NULL, 344, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(349, 'OTCC 1-3-1-5', 'OTCC 1-3-1-5', 'تضمني تحليل نوعي )Analysis Qualitative )مخاطر الامن\r\nالسيرباني، ضمن إجراءات تحليل مخاطر العمليات )Hazard Process\r\nAnalysis )الذي يطبق قبل أي تغيري في العمليات أو إجراءاتها في المصانع', NULL, 'OTCC 1-3-1-5', 'Not Applicable', 28, 1, NULL, NULL, NULL, 1, NULL, NULL, 344, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(350, 'OTCC 1-3-1-6', 'OTCC 1-3-1-6', 'في حال عدم التمكن من استيفاء متطلبات الامن السيرباني\r\nداخل البيئة الخاصة بأنظمة التحكم الصناعي )ICS\\/OT ،)فيجب توضيح\r\nالمربرات الالزمة، مع توثيقها واعتامدها من قبل الجهة المعنية بالامن\r\nالسيرباني، وموافقة صاحب الصلاحية', NULL, 'OTCC 1-3-1-6', 'Not Applicable', 28, 1, NULL, NULL, NULL, 1, NULL, NULL, 344, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(351, 'OTCC 1-3-1-7', 'OTCC 1-3-1-7', 'في حال الموافقة عىل قبول المخاطر السيربانية؛ فيجب تحديد\r\nالضوابط البديلة لها مع توثيقها، واعتامدها من قبل صاحب الصلاحية؛\r\nمع التأكد من تطبيقها بفعالية في وقت محدد، مع الاستمرار في تقييم تلك\r\nالمخاطر ومراجعتها بشكل مستمر', NULL, 'OTCC 1-3-1-7', 'Not Applicable', 28, 1, NULL, NULL, NULL, 1, NULL, NULL, 344, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(352, 'OTCC 1-4-1', 'OTCC 1-4-1', 'بالاضافة للضوابط الفرعية ضمن الضابطين 1-6-2 و 1-6-3 من الضوابط\r\nالاساسية للامن السيرباين؛ يجب أن تغطي متطلبات الامن السيرباني ضمن\r\nإدارة مشاريع أنظمة التحكم الصناعي )ICS\\/OT )', NULL, 'OTCC 1-4-1', 'Not Applicable', 29, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(353, 'OTCC 1-4-1-1', 'OTCC 1-4-1-1', 'تضمني متطلبات الامن السيرباني بوصفه جزء من دورة حياة\r\nاملشاريع المتعلقة بأنظمة التحكم الصناعي )ICS\\/OT.)', NULL, 'OTCC 1-4-1-1', 'Not Applicable', 29, 1, NULL, NULL, NULL, 1, NULL, NULL, 352, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(354, 'OTCC 1-4-1-2', 'OTCC 1-4-1-2', 'تضمني متطلبات الامن السيرباني ضمن اختبارات القبول\r\n)Test Acceptance )وعمليات التقييم )Process Evaluation .)مثل:\r\nاختبارات قبول المصنع ))FAT (Tests Acceptance Factory )واختبارات\r\nالقبول الميداين ))SAT (Tests Acceptance Site )واختبارات التشغيل\r\n)Tests Commissioning )واختبارات التغيري )Tests Change )\r\nواختبارات التكامل )Tests Integration )ومراجعة الشفرة المصدرية\r\n)Review Code Source.)', NULL, 'OTCC 1-4-1-2', 'Not Applicable', 29, 1, NULL, NULL, NULL, 1, NULL, NULL, 352, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(355, 'OTCC 1-4-1-3', 'OTCC 1-4-1-3', 'تضمني مبدأ الامن من خلال التصميم )Design-By-Secure ) بوصفه جزء من الامن المعامري لتصميم البيئة الخاصة بأنظمة التحكم الصناعي )ICS\\/OT.)', NULL, 'OTCC 1-4-1-3', 'Not Applicable', 29, 1, NULL, NULL, NULL, 1, NULL, NULL, 352, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(356, 'OTCC 1-4-1-4', 'OTCC 1-4-1-4', 'حامية الانظمة في البيئة التطويرية )Development\r\nEnvironment ،)وتشمل بيئات الاختبار)Environment Testing )\r\nوالمنصات التكاملية )Platforms Integration.', NULL, 'OTCC 1-4-1-4', 'Not Applicable', 29, 1, NULL, NULL, NULL, 1, NULL, NULL, 352, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(357, 'OTCC 1-4-2', 'OTCC 1-4-2', 'جب مراجعة متطلبات الامن السيرباني، ضمن إدارة مشاريع أنظمة التحكم\r\n1-4-2 الصناعي )ICS\\/OT )وقياس فعالية تطبيقها وتقييمها دورياً.', NULL, 'OTCC 1-4-2', 'Not Applicable', 29, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(358, 'OTCC 1-5-1', 'OTCC 1-5-1', '‏يجب تحديد متطلبات الأمن السيبراني وتوثيقها واعتمادها. ضمن إدارة\r\nالتغيير لدى الجهة. ويجب التأكد من أن متطلبات الأمن السيبراني تمثل\r\nجزءًا لا يتجزأ من المتطلبات الأساسية لإدارة التغيير لأنظمة التحكم\r\nالصناعي (07\\/168)', NULL, 'OTCC 1-5-1', 'Not Applicable', 120, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(359, 'OTCC 1-5-2', 'OTCC 1-5-2', '‏يجب تطبيق متطلبات الأمن السيبراني ضمن دورة حياة إدارة التغيير.\r\nالمتعلقة بأنظمة التحكم الصناعي (01\\/105) لدى الجهة.', NULL, 'OTCC 1-5-2', 'Not Applicable', 120, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(360, 'OTCC 1-5-3', 'OTCC 1-5-3', 'بالإضافة للضوابط الفرعية ضمن الضابطين ‎٢-٦-١‏ و ‎٣-٦-١‏ في الضوابط\r\nالأساسية للأمن السيبراني؛ يجب أن تغطي متطلبات الأمن السيبراني. ضمن\r\nإدارة التغيير لأنظمة التحكم الصناعي (07\\/108)', NULL, 'OTCC 1-5-3', 'Not Applicable', 120, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(361, 'OTCC 1-5-3-1', 'OTCC 1-5-3-1', 'تضمين متطلبات الأمن السيبراني بوصفها جزء من دورة حياة\r\nإدارة التغيير.', NULL, 'OTCC 1-5-3-1', 'Not Applicable', 120, 1, NULL, NULL, NULL, 1, NULL, NULL, 360, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(362, 'OTCC 1-5-3-2', 'OTCC 1-5-3-2', 'التحقق من صحة وسلامة التغييرات في بي\r\nعلى بيئة النتاج )', NULL, 'OTCC 1-5-3-2', 'Not Applicable', 120, 1, NULL, NULL, NULL, 1, NULL, NULL, 360, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(363, 'OTCC 1-5-3-3', 'OTCC 1-5-3-3', 'التحقق من كفاءة متطلبات الأمن السيبراني لأنظمة التحكم\r\nالصناعي (07\\/15) في حال استبدالها بأجهزة مماثلة لها. سواء أكان ذلك\r\nفي بيئات التصاميم؛ أم الاختبارات. أو التشغيلية. للتأكد من سلامتها. وذلك\r\nقبل تطبيقها في بيئة الإنتاج. أو البينة التشغيلية', NULL, 'OTCC 1-5-3-3', 'Not Applicable', 120, 1, NULL, NULL, NULL, 1, NULL, NULL, 360, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(364, 'OTCC 1-5-3-4', 'OTCC 1-5-3-4', 'تطبيق إجراءات مقيدة. وآمنة للتغييرات الاستثنائية', NULL, 'OTCC 1-5-3-4', 'Not Applicable', 120, 1, NULL, NULL, NULL, 1, NULL, NULL, 360, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(365, 'OTCC 1-5-3-5', 'OTCC 1-5-3-5', '(‏تطبيق آلية أتمتة الإعدادات ))Configuration Automated\r\n‏وآلية كشف التغييرات بالأصول )مع ح عع)۔‎', NULL, 'OTCC 1-5-3-5', 'Not Applicable', 120, 1, NULL, NULL, NULL, 1, NULL, NULL, 360, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(366, 'OTCC 1-5-4', 'OTCC 1-5-4', '‏يجب مراجعة متطلبات الأمن السيراني. ضمن إدارة التغيير المتعلقة بأنظمة\r\nالتحكم الصناعي (01\\/108) و قياس فعالية تطبيقها وتقييمها دورا.', NULL, 'OTCC 1-5-4', 'Not Applicable', 120, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(367, 'OTCC 1-6-1', 'OTCC 1-6-1', '‏رجوعا للضابط ‎٢-٨-١‏ في الضوابط الأساسية للأمن السيبراني؛ يجب مراجعة\r\nتطبيق ضوابط الآمن السيبراني للأنظمة التشغيلية (2022 :0106-1) من\r\nقبل أطراف مستقلة عن الإدارة المعنية بالأمن السيبراني في الجهة. وذلك مرة\r\nواحدة كل سنويا على الأقل', NULL, 'OTCC 1-6-1', 'Not Applicable', 31, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(368, 'OTCC 1-6-2', 'OTCC 1-6-2', '‏رجوعا للضابط ‎٢-٨-١‏ في الضوابط الأساسية للأمن السيبراني؛ يجب مراجعة\r\nتطبيق ضوابط الآمن السيبراني للأنظمة التشغيلية (2022 :0106-1) من\r\nقبل أطراف مستقلة عن الإدارة المعنية بالأمن السيبراني في الجهة. وذلك مرة\r\nواحدة كل ثلاث سنوات على الأقل', NULL, 'OTCC 1-6-2', 'Not Applicable', 31, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(369, 'OTCC 1-7-1', 'OTCC 1-7-1', 'بالإضافة للضوابط الفرعية ضمن الضابط ‎٣-٢-١‏ في الضوابط الأساسية للأمن\r\nالسيبراني؛ يجب أن تغطي متطلبات الأمن السيبراني. المتعلقة بالموارد البشرية\r\nلأنظمة التحكم الصناعي (07\\/165©). بحد أدنى؛ إجراء عمل مسح أمني\r\n)ن عه نععك) لجميع العاملين (ويشمل ذلك الموظفين والمتعاقدين)\r\nوالذين يمكنهم الوصول إلى أصول أنظمة التحكم الصناعي (01\\/108) أو\r\nاستخدامها؛ وذلك قبل منحهم صلاحيات الوصول', NULL, 'OTCC 1-7-1', 'Not Applicable', 32, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(370, 'OTCC 1-7-2', 'OTCC 1-7-2', 'رجوعاً للضابط ‎7-9-١‏ في الضوابط الأساسية للأمن السيبراني؛ يجب مراجعة\r\nمتطلبات الأمن السيبراني لأنظمة التحكم الصناعي (01\\/108) المتعلقة\r\nبالموارد البشرية. وقياس فعالية تطبيقهاء وتقييمها دورياً', NULL, 'OTCC 1-7-2', 'Not Applicable', 32, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(371, 'OTCC 1-8-1', 'OTCC 1-8-1', 'بالإضافة للضوابط الفرعية. ضمن الضابط ‎٣-١٠-١‏ في الضوابط الأساسية\r\nللأمن السيرا في؛ يجب أن يتضمن برنامج التوعية بالأمن السيبراني. التعامل | ي | ي | ي\r\nالآمن مع أنظمة التحكم الصناعي (07\\/165) في الجهة', NULL, 'OTCC 1-8-1', 'Not Applicable', 33, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(372, 'OTCC 1-8-2', 'OTCC 1-8-2', 'بالإضافة للضوابط الفرعية. ضمن الضابط ١-٠١-ع‏ في الضوابط الأساسية\r\nللأمن السيبراني؛ يجب أن تغطي متطلبات الأمن السيراني. المتعلقة\r\nببرنامج التوعية والتدريب بالأمن السيبراني في بيئة أنظمة التحكم\r\nالصناعي (01\\/105', NULL, 'OTCC 1-8-2', 'Not Applicable', 33, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(373, 'OTCC 1-8-2-1', 'OTCC 1-8-2-1', 'يجب أن يتم توفير تمارين خاصة. وشهادات مهنية. ومهارات\r\nاحترافية في مجال الأمن السييراني. لجميع العاملين على الأصول المتعلقة\r\nبأنظمة التحكم الصناعي (01\\/105). كما تشجع الهيئة الجهة على.\r\nالاستفادة من الإطار السعودي لكوادر الأمن السيبراني (سيوف) ليكون\r\nمرجع لها.', NULL, 'OTCC 1-8-2-1', 'Not Applicable', 33, 1, NULL, NULL, NULL, 1, NULL, NULL, 372, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(374, 'OTCC 1-8-2-2', 'OTCC 1-8-2-2', 'يجب تشجيع الجهة للمشاركة مع الجهات المعتمدة و\\/أو ذات\r\nالاختصاص في مجال أنظمة التحكم الصناعي (01\\/105) للتعرف على\r\nأحدث التقنيات والممارسات في مجال الآمن السيبراني لأنظمة التحكم\r\nالصناعي (071\\/105)', NULL, 'OTCC 1-8-2-2', 'Not Applicable', 33, 1, NULL, NULL, NULL, 1, NULL, NULL, 372, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(375, 'OTCC 2-1-1', 'OTCC 2-1-1', 'بالإضافة للضوابط. ضمن المكون الفرعي ‎١-‏ في الضوابط الأساسية للأمن\r\nالسيبراني؛ يجب أن تغطي متطلبات الأمن السييراني. المتعلقة بإدارة الأصول\r\nأنظمة التحكم الصناعي (071\\/108', NULL, 'OTCC 2-1-1', 'Not Applicable', 34, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(376, 'OTCC 2-1-1-1', 'OTCC 2-1-1-1', 'نشاء قائمة جرد إلكترونية. لجميع أصول أنظمة التحكم الصناعي\r\n(01\\/105) ومراجعتها بشكل دوري', NULL, 'OTCC 2-1-1-1', 'Not Applicable', 34, 1, NULL, NULL, NULL, 1, NULL, NULL, 375, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(377, 'OTCC 2-1-1-2', 'OTCC 2-1-1-2', 'استخدام تقنيات الأتمتة لحصر الأصول', NULL, 'OTCC 2-1-1-2', 'Not Applicable', 34, 1, NULL, NULL, NULL, 1, NULL, NULL, 375, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(378, 'OTCC 2-1-1-3', 'OTCC 2-1-1-3', '‏حفظ معلومات أصول أنظمة التحكم الصناعي‎ ٣-١-١-٢\r\n‏المحصورة بشكل آمن.‎', NULL, 'OTCC 2-1-1-3', 'Not Applicable', 34, 1, NULL, NULL, NULL, 1, NULL, NULL, 375, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(379, 'OTCC 2-1-1-4', 'OTCC 2-1-1-4', 'تحديد ملاك الأصول (عص٧٥‏ :8فوه) لجميع أصول أنظمة\r\nالتحكم الصناعي (01\\/105) والتأكد من مشاركتهم في دورة حياة إدارة\r\nجرد الأصول ذات العلاقة.', NULL, 'OTCC 2-1-1-4', 'Not Applicable', 34, 1, NULL, NULL, NULL, 1, NULL, NULL, 375, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(380, 'OTCC 2-1-1-5', 'OTCC 2-1-1-5', 'تصنيف مستوى الحساسية (من رانلةعنان) وتوثيقه\r\nواعتماده لجميع الأصول. من قبل ملاك الأصول.', NULL, 'OTCC 2-1-1-5', 'Not Applicable', 34, 1, NULL, NULL, NULL, 1, NULL, NULL, 375, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(381, 'OTCC 2-1-2', 'OTCC 2-1-2', '‏رجوعا للضابط 7-1-3 في الضوابط الأساسية للأمن السيبراني؛ يجب مراجعة\r\nمتطلبات الأمن السيبراني المتعلقة بإدارة أصول أنظمة التحكم الصناعي\r\n(01\\/105). وقياس فعالية تطبيقها وتقييمها دورباً.', NULL, 'OTCC 2-1-2', 'Not Applicable', 34, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(382, 'OTCC 2-2-1', 'OTTC 2-2-1', 'بالإضافة للضوابط الفرعية. ضمن الضابط ‎٣-٢-٢‏ في الضوابط الأساسية\r\nللأمن السيبراني. يجب أن تغطي متطلبات الأمن السيبراني المتعلقة بإدارة\r\nهويات الدخول. والصلاحيات في بيئة أنظمة التحكم الصناعي (07\\/105', NULL, 'OTTC 2-2-1', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(383, 'OTCC 2-2-1-1', 'OTCC 2-2-1-1', 'التأكد من أن دورة حياة إدارة هويات الدخول والصلاحيات»\r\nلأنظمة التحكم الصناعي (01\\/105) مفصولة ومستقلة. عن تلك المتعلقة\r\nبتقنية المعلومات (17) وذلك يشمل الحلول التقنية المستخدمة في الإدارة\r\nالمركزية لهويات الدخول والصلاحيات', NULL, 'OTCC 2-2-1-1', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, 382, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(384, 'OTCC 2-2-1-2', 'OTCC 2-2-1-2', 'الإدارة الآمنة لحسابات الخدمات (و)صاععه 166 :5) المتعلقة\r\nبخدمات التحكم الصناعي (071\\/108) وتطبيقاتها! وأنظمتها. وأجهزتها\r\nالمعزولة وغير المتصلة بحسابات دخول المستخدمين التفاعلية )عصا', NULL, 'OTCC 2-2-1-2', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, 382, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(385, 'OTCC 2-2-1-3', 'OTCC 2-2-1-3', 'تغيير الهويات المصنعية )ولصءلعءح} السه؟ء() لجميع الأصول\r\nالمتعلقة بأنظمة التحكم الصناعي (071\\/168) أو تعطيلهاء أو إزالتها', NULL, 'OTCC 2-2-1-3', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, 382, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(386, 'OTCC 2-2-1-4', 'OTCC 2-2-1-4', 'الإدارة الآمنة لجلسات الاتصال\" ويشمل ذلك موثوقية الجلسات\r\nجد | )نط ن). و إقفالها مم1 وإنهاء مهلتها )معسنآ)', NULL, 'OTCC 2-2-1-4', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, 382, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(387, 'OTCC 2-2-1-5', 'OTCC 2-2-1-5', 'منع التعطيل. أو الإزالة التلقائية لحسابات الخدمات. أو البرامج.\r\nأو حسابات الأجهزة المتعلقة بأنظمة التحكم الصناعي (01\\/105) باستثناء | مي\r\nأنظمة المراقبة', NULL, 'OTCC 2-2-1-5', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, 382, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(388, 'OTCC 2-2-1-6', 'OTCC 2-2-1-6', 'استخدام إجراءات الاعتمادات الثنائية (لةدهءممه لهسط) وآليات\r\nمحددة لتصعيد الصلاحيات للإجراءات الحساسة. داخل بيئة أنظمة التحكم | مي\r\nالصناعي', NULL, 'OTCC 2-2-1-6', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, 382, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(389, 'OTCC 2-2-1-7', 'OTCC 2-2-1-7', 'تقييد الوصول عن بعد لشبكات أنظمة التحكم الصناعي\r\n(01\\/108) وتمكينه بشكل استثنائي عند الضرورة. ووجود المبررات\r\nاللازمة. على أن يتم إجراء تقييم مخاطر الأمن السيبراني قبل منح\r\nالوصول عن بعد. ورصد المخاطر المتعلقة بذلك وإدارتها. وأن يكون\r\nالدخول المصرح به من خلال التحقق من الهوية ذات العناصر المتعددة | ي | ي\r\n)”“ ن ة-نال”) وعبر قناة مشفرة لفترة\r\nزمنية محددة. وبصلاحيات محدودة. ويتم مراقبة جلسة الوصول عن بعد\r\nوتسجيلها. على أن تكون الصلاحيات الممنوحة للمستخدم. متوافقة مع\r\nتقييم مخاطر الأمن السيبراني', NULL, 'OTCC 2-2-1-7', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, 382, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(390, 'OTCC 2-2-1-8', 'OTCC 2-2-1-8', 'تطبيق معايير آمنة ومعقدة لكلمات المرور', NULL, 'OTCC 2-2-1-8', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, 382, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(391, 'OTCC 2-2-1-9', 'OTCC 2-2-1-9', 'استخدام آليات آمنة لتخزين كلمات المرور. الخاصة بأصول أنظمة\r\nالتحكم الصناعي', NULL, 'OTCC 2-2-1-9', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, 382, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(392, 'OTCC 2-2-1-10', 'OTCC 2-2-1-10', 'رجوعا للضابط الفرعي 0-2-7-7 في الضوابط الأساسية للأمن\r\nالسيبراني؛ يجب مراجعة هويات الدخول والصلاحيات. عند الاستجابة\r\nلحوادث الأمن السيبراني. وعند التغيير في أدوار العاملين. أو عند حدوث أي\r\nتغيبر في الهيكلية المعمارية لأنظمة التحكم الصناعي', NULL, 'OTCC 2-2-1-10', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, 382, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(393, 'OTCC 2-2-1-11', 'OTCC 2-2-1-11', 'إلغاء صلاحيات الدخول مباشرة. عند انتهاء الحاجة لها.', NULL, 'OTCC 2-2-1-11', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, 382, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(394, 'OTCC 2-2-2', 'OTCC 2-2-2', '‏رجوعا للضابط 2-7-9 في الضوابط الأساسية للأمن السيبرا\r\n\r\n‏مراجعة متطلبات الأمن السيبراني. المتعلقة بإدارة هويات الدخول\r\nوالصلاحيات. في بينة أنظمة التحكم الصناعي (01\\/105)؛ وقياس فعالية ‏تطبيقها وتقييمها دوريا', NULL, 'OTCC 2-2-2', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(395, 'OTCC 2-3-1', 'OTCC 2-3-1', '‏بالإضافة للضوابط الفرعية. ضمن الضابط ‎٣-٣-٢‏ في الضوابط الأساسية\r\nللأمن السيبراني؛ يجب أن تغطي متطلبات الأمن السيبراني. لحماية الأنظمة\r\nوأجهزة معالجة المعلومات. المتعلقة بأنظمة التحكم الصناعي', NULL, 'OTCC 2-3-1', 'Not Applicable', 125, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(396, 'OTCC 2-3-1-1', 'OTCC 2-3-1-1', 'استخدام تقنيات وآليات الحماية الحديثة والمتقدمة. وإدارتها\r\nبشكل آمن. للحماية من الفيروسات. والبرامج. والأنشطة المشبوهة.\r\nوالبرمجيات الضارة (8ته»2481). والتهديدات المتقدمة المستمرة (7)“\r\nوالملفات الضارة. وحظرها.', NULL, 'OTCC 2-3-1-1', 'Not Applicable', 125, 1, NULL, NULL, NULL, 1, NULL, NULL, 395, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(397, 'OTCC 2-3-1-2', 'OTCC 2-3-1-2', 'إجراء مراجعة دورية للإعدادات والتحصين )ء\r\n\r\n‏ن ة مج) بما يتوافق مع إرشادات الأمن\r\nالسيبراني. وأفضل الممارسات. والتوصيات الخاصة بالموردين (:Vendors).‏\r\nوما يتوافق مع آليات إدارة التغيير المتبعة في الجهة.', NULL, 'OTCC 2-3-1-2', 'Not Applicable', 125, 1, NULL, NULL, NULL, 1, NULL, NULL, 395, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(398, 'OTCC 2-3-1-3', 'OTCC 2-3-1-3', 'تطبيق حزم التحديثات والإصلاحات الأمنية بشكل دوري.\r\nعلى أنظمة التحكم الصناعي (01\\/105) يما يتوافق مع إرشادات\r\nالأمن السيبراني. وأفضل الممارسات الخاصة بالموردين (Vendors٢).‏ وبما\r\nيتوافق مع آليات إدارة التغيير المتبعة في الجهة.', NULL, 'OTCC 2-3-1-3', 'Not Applicable', 125, 1, NULL, NULL, NULL, 1, NULL, NULL, 395, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(399, 'OTCC 2-3-1-4', 'OTCC 2-3-1-4', 'تطبيق مبدأ الحد الأدنى من الصلاحيات والامتيازات (ا5ةء[\r\nععلدن) والحد الأدنى من الامكانيات', NULL, 'OTCC 2-3-1-4', 'Not Applicable', 125, 1, NULL, NULL, NULL, 1, NULL, NULL, 395, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(400, 'OTCC 2-3-1-5', 'OTCC 2-3-1-5', 'إعداد ووضع وحدات التحكم (5:»ل000:01) في أنظمة معدات\r\nالسلامة (515) في الأوضاع الاعتيادية التشغيلية في جميع الأوقات؛ مما يمنع\r\nأي تغييرات غير مصرح بها. ولا يكون تغييرها الى الوضع غير الاعتيادي إلا\r\nبصفة استثنا\r\n‏ائية. ويكون ذلك مقيدا بفترة زمنية محددة', NULL, 'OTCC 2-3-1-5', 'Not Applicable', 125, 1, NULL, NULL, NULL, 1, NULL, NULL, 395, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(401, 'OTCC 2-3-1-6', 'OTCC 2-3-1-6', 'تحديد قوائم محددة من التطبيقات المسموح بتشغيلها في بيئة\r\nأنظمة التحكم الصناعي (071\\/105) من خلال التقنيات المتاحة', NULL, 'OTCC 2-3-1-6', 'Not Applicable', 125, 1, NULL, NULL, NULL, 1, NULL, NULL, 395, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(402, 'OTCC 2-3-1-7', 'OTCC 2-3-1-7', 'إدارة أصول أنظمة التحكم الصناعي (071\\/105) من خلال أجهزة\r\nالمهندسين (صمنهام٥‏ ومنععصنعصع) وأجهزة واجهات التعامل مع\r\nالأنظمة )”“ ه عصنطة-صةصنل]). والتأكد من أن تكون\r\nأجهزة إدارة الأصول و صيانتها! محصنة ومعزولة', NULL, 'OTCC 2-3-1-7', 'Not Applicable', 125, 1, NULL, NULL, NULL, 1, NULL, NULL, 395, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(403, 'OTCC 2-3-1-8', 'OTCC 2-3-1-8', 'فحص وسائط التخزين الخارجية. وتحليلها ضد البرامج الضارة.\r\nوالتهديدات المتقدمة المستمرة', NULL, 'OTCC 2-3-1-8', 'Not Applicable', 125, 1, NULL, NULL, NULL, 1, NULL, NULL, 395, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(404, 'OTCC 2-3-1-9', 'OTCC 2-3-1-9', 'التقييد الحازم لاستخدام وسائط التخزين الخارجية في بيئة الإنتاج»\r\nما م يتم تطوير آليات آمنة وتطبيقها لنقل البيانات', NULL, 'OTCC 2-3-1-9', 'Not Applicable', 125, 1, NULL, NULL, NULL, 1, NULL, NULL, 395, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(405, 'OTCC 2-3-1-10', 'OTCC 2-3-1-10', 'حماية سجلات الأحداث. والملفات الحساسة. من الدخول غير\r\nالمصرح به. أو التلاعب أو التغيير غير المصرح به. أو الحذف', NULL, 'OTCC 2-3-1-10', 'Not Applicable', 125, 1, NULL, NULL, NULL, 1, NULL, NULL, 395, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(406, 'OTCC 2-3-1-11', 'OTCC 2-3-1-11', 'اكتشاف التطبيقات والبرامج النصية (وامنت) والمهمات\r\nوالتغييرات غير المصرح بها! وفحصها', NULL, 'OTCC 2-3-1-11', 'Not Applicable', 125, 1, NULL, NULL, NULL, 1, NULL, NULL, 395, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(407, 'OTCC 2-3-1-12', 'OTCC 2-3-1-12', 'كتشاف الأوامر المنفذة ))Execution Commands) وجلسات\r\nالاتصالات الحديثة ))Sessions Communication New).‏ وفحصها', NULL, 'OTCC 2-3-1-12', 'Not Applicable', 125, 1, NULL, NULL, NULL, 1, NULL, NULL, 395, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(408, 'OTCC 2-3-1-13', 'OTCC 2-3-1-13', 'اكتشاف الاتصالات المباشرة بين بيئة شبكات أنظمة التحكم\r\nالصناعي (07\\/125©) والأطراف الخارجية ):s Extern). وفحصها.', NULL, 'OTCC 2-3-1-13', 'Not Applicable', 125, 1, NULL, NULL, NULL, 1, NULL, NULL, 395, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(409, 'OTCC 2-3-2', 'OTCC 2-3-2', 'رجوعا للضابط 2-3-3 في الضوابط الأساسية للأمن السيبراني؛ يجب مراجعة\r\nمتطلبات الأمن السيبراني لحماية أنظمة معالجة المعلومات والأجهزة\r\nالمتعلقة بأنظمة التحكم الصناعي (07\\/165©). وقياس فعالية تطبيقها\r\nوتقييمها دوريا.', NULL, 'OTCC 2-3-2', 'Not Applicable', 125, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(410, 'OTCC 2-4-1', 'OTCC 2-4-1', 'بالإضافة للضوابط الفرعية ضمن الضابط 2-0-3 في الضوابط الأساسية للأمن\r\nالسيبراني؛ يجب أن تغطي متطلبات الأمن السيبراني. لإدارة أمن الشبكات\r\nالمتعلقة بأنظمة التحكم الصناعي', NULL, 'OTCC 2-4-1', 'Not Applicable', 38, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(411, 'OTCC 2-4-1-1', 'OTCC 2-4-1-1', 'تقسيم شبكات أنظمة التحكم الصناعي (07\\/108) منطقيا أو\r\nماديا عن الشبكات الأخرى.', NULL, 'OTCC 2-4-1-1', 'Not Applicable', 38, 1, NULL, NULL, NULL, 1, NULL, NULL, 410, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(412, 'OTCC 2-4-1-2', 'OTCC 2-4-1-2', 'تقسيم المناطق المختلفة (ءصه7) داخل بيئة أنظمة التحكم\r\nالصناعي (01\\/108) منطقيا أو ماديا وفقاً للمستوى المناسب للمنطقة\r\nوعزل تدفق البيانات بين المناطق بحيث يتم الاتصال بين المناطق عبر نقاط\r\nاتصال محددة', NULL, 'OTCC 2-4-1-2', 'Not Applicable', 38, 1, NULL, NULL, NULL, 1, NULL, NULL, 410, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(413, 'OTCC 2-4-1-3', 'OTCC 2-4-1-3', 'تقسيم أنظمة معدات السلامة ) ك\r\n7\" وصءءرك) منطقياً أو مادياً عن الشبكات الأخرى الخاصة بأنظمة\r\nالتحكم الصناعي', NULL, 'OTCC 2-4-1-3', 'Not Applicable', 38, 1, NULL, NULL, NULL, 1, NULL, NULL, 410, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(414, 'OTCC 2-4-1-4', 'OTCC 2-4-1-4', '‏تقييد استخدام التقنيات اللاسلكية (مثل => ,طهعداظ‎ ٤-١-٤٢\r\n‏للع مالك . وغيرها) . على أن يكون استخدامها لتلبية متطلبات‎\r\n‏عمل محددة مع ضمان تأمينها بالشكل المناسب.‎', NULL, 'OTCC 2-4-1-4', 'Not Applicable', 38, 1, NULL, NULL, NULL, 1, NULL, NULL, 410, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(415, 'OTCC 2-4-1-5', 'OTCC 2-4-1-5', 'عزل التقنيات اللاسلكية منطقيًا أو ماديًا. عن الشبكات الخاصة\r\nبأنظمة التحكم الصناعي', NULL, 'OTCC 2-4-1-5', 'Not Applicable', 38, 1, NULL, NULL, NULL, 1, NULL, NULL, 410, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(416, 'OTCC 2-4-1-6', 'OTCC 2-4-1-6', 'تقييد استخدام اتصالات الشبكة. والخدمات. ونقاط الاتصال بين\r\nالمناطق المختلفة ()Zones )) وحصرها على الحد الأدفى؛ لتلبية متطلبات\r\nالتشغيل والصيانة والسلامة', NULL, 'OTCC 2-4-1-6', 'Not Applicable', 38, 1, NULL, NULL, NULL, 1, NULL, NULL, 410, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL);
INSERT INTO `framework_controls` (`id`, `short_name`, `long_name`, `description`, `supplemental_guidance`, `control_number`, `control_status`, `family`, `control_owner`, `desired_maturity`, `control_priority`, `control_class`, `control_maturity`, `control_phase`, `control_type`, `parent_id`, `submission_date`, `last_audit_date`, `next_audit_date`, `desired_frequency`, `mitigation_percent`, `status`, `deleted`, `created_at`, `updated_at`) VALUES
(417, 'OTCC 2-4-1-7', 'OTCC 2-4-1-7', 'منع الوصول المباشر لخدمات التحقق. و إدارة الدخول عن بعد\r\n) سه عصعع) على الأجهزة\r\nالمتواجدة في الشبكة الخارجية للجهة', NULL, 'OTCC 2-4-1-7', 'Not Applicable', 38, 1, NULL, NULL, NULL, 1, NULL, NULL, 410, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(418, 'OTCC 2-4-1-8', 'OTCC 2-4-1-8', 'قصر الوصول لخدمات الأعمال الحساسة )1 => عنس(\r\nالمتعلقة بالشبكة الداخلية لأنظمة التحكم الصناعي (07\\/108) على\r\nالخدمات المصرح بها. ويجب الحد من الوصول للخدمات ذات الثغرات\r\nالأمنية المعروفة إلى أقصى حد ممكن', NULL, 'OTCC 2-4-1-8', 'Not Applicable', 38, 1, NULL, NULL, NULL, 1, NULL, NULL, 410, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(419, 'OTCC 2-4-1-9', 'OTCC 2-4-1-9', 'منع الوصول المباشر عن بعد. بين منطقة الجهة الداخلية\r\n) ) ومنطقة شبكات أنظمة التحكم الصناعي (Zone Corporate ))»\r\nوتوجيه جميع الاتصالات إلى نقاط الوصول عن بعد (110555 مصدا[) بحيث\r\nتكون مخصصة لهذه العمليات. وآمنة ومحصنة في المنطقة المحايدة', NULL, 'OTCC 2-4-1-9', 'Not Applicable', 38, 1, NULL, NULL, NULL, 1, NULL, NULL, 410, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(420, 'OTCC 2-4-1-10', 'OTCC 2-4-1-10', 'عدم الاتصال بشبكات أنظمة التحكم الصناعي (7\\/1&5©)\r\nباستخدام نقطة الوصول عن بعد المتواجدة في المنطقة المحايدة\r\n(0112) إلا عند الحاجة. مع ضمان تطبيق مبدأ التحقق من الهوية.\r\nذات العناصر المتعددة )”“ م ح-(\r\nوتسجيل جلسات الاتصال ”MFA “Authentication Factor-Multi) وأن يكون الاتصال\r\nلفترة زمنية محددة فحسب', NULL, 'OTCC 2-4-1-10', 'Not Applicable', 38, 1, NULL, NULL, NULL, 1, NULL, NULL, 410, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(421, 'OTCC 2-4-1-11', 'OTCC 2-4-1-11', 'استخدام الوكيل ((:2:0) بين منطقة الجهة الداخلية\r\n) ) ومنطقة أنظمة التحكم الصناعي (017\\/108)\r\nللتحكم بالحركة عند الاتصال ما بين الأجهزة  )Machine-to-Machine.)', NULL, 'OTCC 2-4-1-11', 'Not Applicable', 38, 1, NULL, NULL, NULL, 1, NULL, NULL, 410, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(422, 'OTCC 2-4-1-12', 'OTCC 2-4-1-12', 'استخدام البوابات (رة\"»ءاة6) المخصصة؛ لتقسيم\r\nشبكات أنظمة التحكم الصناعي (07\\/108) من الشبكة الداخلية  )Zone Corporate', NULL, 'OTCC 2-4-1-12', 'Not Applicable', 38, 1, NULL, NULL, NULL, 1, NULL, NULL, 410, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(423, 'OTCC 2-4-1-13', 'OTCC 2-4-1-13', 'استخدام منطقة محايدة (DMZ) لاستضافة أي نظام. يقدم\r\nخدمات بين منطقة الشبكة الداخلية )ع ع1ه:0م:00) ومنطقة أنظمة\r\nالتحكم الصناعي', NULL, 'OTCC 2-4-1-13', 'Not Applicable', 38, 1, NULL, NULL, NULL, 1, NULL, NULL, 410, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(424, 'OTCC 2-4-1-14', 'OTCC 2-4-1-14', 'التقييد الصارم على تمكين البروتوكولات الصناعية (لمنعاس4صا\r\nوله»2:010) والمنافذ (20:18) واستخدامها إلى الحد الأدنى. بالتوافق مع\r\nمتطلبات التشغيل والصيانة والسلامة', NULL, 'OTCC 2-4-1-14', 'Not Applicable', 38, 1, NULL, NULL, NULL, 1, NULL, NULL, 410, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(425, 'OTCC 2-4-1-15', 'OTCC 2-4-1-15', 'اعتماد حزم التحديثات الدورية. والإصلاحات الأمنية للأصول في\r\nبيئة الإنتاج. من قبل الشركة المصنعة. وإجراء اختبار في بيئة تجريبية قبل\r\nتطبيقها على بيئة الإنتاج', NULL, 'OTCC 2-4-1-15', 'Not Applicable', 38, 1, NULL, NULL, NULL, 1, NULL, NULL, 410, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(426, 'OTCC 2-4-1-16', 'OTCC 2-4-1-16', 'الحفاظ على الوثائق المفصلة. لهندسة الشبكة وتصميمها.\r\nوتقسيماتهاء وتدفقات بيانات الشبكة. و نقاط ترابطهاء واعتماديتها؛ وتوثيق.\r\nوتحديث الوثائق مع كل تغيير', NULL, 'OTCC 2-4-1-16', 'Not Applicable', 38, 1, NULL, NULL, NULL, 1, NULL, NULL, 410, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(427, 'OTCC 2-4-2', 'OTCC 2-4-2', '‏رجوعا للضابط 2-0-7 في الضوابط الأساسية للأمن السيبراني؛ يجب مراجعة\r\nمتطلبات الآمن السيبراني لإدارة أمن شبكات أنظمة التحكم الصناعي )ICS\\/OT)\r\nوقياس فعالية تطبيقها وتقييمها دورياً.', NULL, 'OTCC 2-4-2', 'Not Applicable', 38, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(428, 'OTCC 2-5-1', 'OTCC 2-5-1', 'بالإضافة للضوابط الفرعية. ضمن الضابط ‎٣-٦-٢‏ في الضوابط الأساسية\r\nللأمن السيبراني؛ يجب أن تغطي متطلبات الأمن السيبراني لأمن الأجهزة\r\nالمحمولة', NULL, 'OTCC 2-5-1', 'Not Applicable', 39, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(429, 'OTCC 2-5-1-1', 'OTCC 2-5-1-1', 'تقييد استخدام الأجهزة المحمولة. لشبكات أنظمة التحكم الصناعي\r\n(01\\/108) عند الحاجة لاستخدام الأجهزة المحمولة. ويجب إجراء تقييم | ‎٧‏ | ص\r\nمخاطر الأمن السييراني. وتحديد المخاطر وإدارتها. يجب الحصول على\r\nموافقة الإدارة المعنية بالأمن السيبراني لفترة زمنية محددة فحسب\" بما\r\nيتوافق مع آليات إدارة صلاحيات الوصول المتبعة في الجهة', NULL, 'OTCC 2-5-1-1', 'Not Applicable', 39, 1, NULL, NULL, NULL, 1, NULL, NULL, 428, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(430, 'OTCC 2-5-1-2', 'OTCC 2-5-1-2', 'استخدام الأجهزة المحمولة المخصصة لأغراض العمل. وبما يتوافق\r\nمع متطلبات الأمن السيبراني. للمناطق الخاصة بها (وعصه7) قبل توصيلها\r\n٢-٥۔١‏ ببيئة شبكات أنظمة التحكم الصناعي (01\\/105). ويجب أن يتم تحصينها\r\nوتحديثها بالتحديثات الأمنية الحديثة؛ وفحصها من البرمجيات الضارة\r\n(ع»له1) والتهديدات المتقدمة المستمرة', NULL, 'OTCC 2-5-1-2', 'Not Applicable', 39, 1, NULL, NULL, NULL, 1, NULL, NULL, 428, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(431, 'OTCC 2-5-1-3', 'OTCC 2-5-1-3', 'تحديد قائمة مقيدة بالأجهزة المحمولة المصرح بها مع ضمان\r\nإمكانية توصيل هذه الأجهزة المحمولة فحسب ببيئة التقنية التشغيلية | ي | ي\r\nوأنظمة التحكم الصناعي (01\\/105). واعتمادها', NULL, 'OTCC 2-5-1-3', 'Not Applicable', 39, 1, NULL, NULL, NULL, 1, NULL, NULL, 428, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(432, 'OTCC 2-5-1-4', 'OTCC 2-5-1-4', 'تطبيق آلية لإدارة الأجهزة المحمولة. مركزياً   ice Mobile\r\nMDM “Management.)', NULL, 'OTCC 2-5-1-4', 'Not Applicable', 39, 1, NULL, NULL, NULL, 1, NULL, NULL, 428, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(433, 'OTCC 2-5-1-5', 'OTCC 2-5-1-5', 'تنفيذ عمليات التشفير على الأجهزة المحمولة المصرح باستخدامها\r\nللوصول إلى أصول أنظمة التحكم الصناعي', NULL, 'OTCC 2-5-1-5', 'Not Applicable', 39, 1, NULL, NULL, NULL, 1, NULL, NULL, 428, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(434, 'OTCC 2-5-2', 'OTCC 2-5-2', 'رجوعا للضابط 2-7-7 في الضوابط الأساسية للأمن السيبراني؛ يجب مراجعة\r\nلما متطلبات الأمن السيبراني لحماية استخدام الأجهزة المحمولة في بيئة ث\r\nأنظمة التحكم الصناعي (01\\/108) وقياس فعالية تطبيقها', NULL, 'OTCC 2-5-2', 'Not Applicable', 39, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(435, 'OTCC 2-6-1', 'OTCC 2-6-1', 'بالإضافة للضوابط الفرعية ضمن الضابط ‎٣-٧-٢‏ في الضوابط الأساسية\r\nللأمن السيبراني؛ يجب أن تغطي متطلبات الأمن السيبراني لحماية البيانات\r\nوالمعلومات المتعلقة بأنظمة التحكم الصناعي', NULL, 'OTCC 2-6-1', 'Not Applicable', 40, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(436, 'OTCC 2-6-1-1', 'OTCC 2-6-1-1', 'حماية البيانات الإلكترونية والمادية (في حال التخزين والنقل)\r\nبالمستوى الذي يتوافق مع تصنيف البيانات', NULL, 'OTCC 2-6-1-1', 'Not Applicable', 40, 1, NULL, NULL, NULL, 1, NULL, NULL, 435, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(437, 'OTCC 2-6-1-2', 'OTCC 2-6-1-2', 'حماية البيانات والمعلومات المصنفة من خلال تقنيات. منع\r\nتسريب البيانات', NULL, 'OTCC 2-6-1-2', 'Not Applicable', 40, 1, NULL, NULL, NULL, 1, NULL, NULL, 435, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(438, 'OTCC 2-6-1-3', 'OTCC 2-6-1-3', 'استخدام آليات الحذف الآمنة )صن ) لبيانات\r\nالإعدادات والبيانات المخزنة على أصول أنظمة التحكم الصناعي (07\\/105)»\r\nوذلك عند الانتهاء منها.', NULL, 'OTCC 2-6-1-3', 'Not Applicable', 40, 1, NULL, NULL, NULL, 1, NULL, NULL, 435, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(439, 'OTCC 2-6-1-4', 'OTCC 2-6-1-4', 'التقييد الحازم لنقل بيانات أنظمة التحكم الصناعي (01\\/105)\r\nأو استخدامها خارج بيئة الإنتاج؛ إلى أن تطبق ضوابط صارمة لحماية تلك\r\nالبيانات.', NULL, 'OTCC 2-6-1-4', 'Not Applicable', 40, 1, NULL, NULL, NULL, 1, NULL, NULL, 435, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(440, 'OTCC 2-6-2', 'OTCC 2-6-2', '‏رجوعا للضابط 2-1-9 في الضوابط الأساسية للأمن السيبراني؛ يجب مراجعة\r\nمتطلبات الأمن السيبراني لحماية البيانات والمعلومات في بيئة شبكات أنظمة\r\nالتحكم الصناعي (07\\/165©). وقياس فعالية تطبيقها وتقييمها دوريا.', NULL, 'OTCC 2-6-2', 'Not Applicable', 40, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(441, 'OTCC 2-7-1', 'OTCC 2-7-1', '‏بالإضافة للضوابط الفرعية. ضمن الضابط 2-0-3 في الضوابط الأساسية\r\nللأمن السيبراني؛ يجب على الجهة أن تتأكد من مواءمة تقنيات التشفير\r\nالمستخدمة في بيئة شبكات أنظمة التحكم الصناعي (01\\/105) مع المعايير\r\nالوطنية للتشفير ‎', NULL, 'OTCC 2-7-1', 'Not Applicable', 41, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(442, 'OTCC 2-7-2', 'OTCC 2-7-2', 'رجوعا للضابط 2-8-7 في الضوابط الأساسية للأمن السيبراني؛ فإنه يجب\r\nمراجعة متطلبات الآمن السيبراني للتشفير. في بيئة شبكات أنظمة التحكم\r\nالصناعي (01\\/105). وقياس فعالية تطبيقها وتقييمها دوريا.', NULL, 'OTCC 2-7-2', 'Not Applicable', 41, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(443, 'OTCC 2-8-1', 'OTCC 2-8-1', 'بالإضافة للضوابط الفرعية. ضمن الضابط 2-9-3 في الضوابط الأساسية للأمن\r\nالسيبراني؛ يجب أن تغطي متطلبات الأمن السيبراني لإدارة النسخ الاحتياطية\r\nالمتعلقة بأنظمة التحكم الصناعي (07\\/165)', NULL, 'OTCC 2-8-1', 'Not Applicable', 42, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(444, 'OTCC 2-8-1-1', 'OTCC 2-8-1-1', 'يجب أن تغطي النسخ الاحتياطية جميع أصول أنظمة التحكم\r\nالصناعي (01\\/108), كما يجب تخزينها بشكل مركزي )ءينلةاه>\r\n«متا10) وفي مواقع غير متصلة بالشبكة.', NULL, 'OTCC 2-8-1-1', 'Not Applicable', 42, 1, NULL, NULL, NULL, 1, NULL, NULL, 443, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(445, 'OTCC 2-8-1-2', 'OTCC 2-8-1-2', 'التأكد من كون ملفات الإعدادات الحساسة والهندسية المختصة\r\nبأنظمة التحكم الصناعي (01\\/105) مضمنه في النسخ الاحتياطية', NULL, 'OTCC 2-8-1-2', 'Not Applicable', 42, 1, NULL, NULL, NULL, 1, NULL, NULL, 443, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(446, 'OTCC 2-8-1-3', 'OTCC 2-8-1-3', 'إجراء عمليات النسخ الاحتياطي دوريا. وفقاً لتصنيف أصول\r\nأنظمة التحكم الصناعي (01\\/105) والمخاطر المتعلقة بها', NULL, 'OTCC 2-8-1-3', 'Not Applicable', 42, 1, NULL, NULL, NULL, 1, NULL, NULL, 443, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(447, 'OTCC 2-8-1-4', 'OTCC 2-8-1-4', 'تأمين الوصول والتخزين والنقل للنسخ الاحتياطية ووسائطهاء\r\nوضمان حمايتها من التلف أو التغيير. أو الوصول غير المصرح به.', NULL, 'OTCC 2-8-1-4', 'Not Applicable', 42, 1, NULL, NULL, NULL, 1, NULL, NULL, 443, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(448, 'OTCC 2-8-2', 'OTCC 2-8-2', '‏رجوعاً للضابط 2-9-3 في الضوابط الأساسية للأمن السيبراني؛ يجب مراجعة\r\nمتطلبات الأمن السيبراني لإدارة النسخ الاحتياطية الخاصة بأنظمة التحكم\r\nالصناعي (01\\/105). وقياس فعالية تطبيقها وتقييمها دورياً', NULL, 'OTCC 2-8-2', 'Not Applicable', 42, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(449, 'OTCC 2-9-1', 'OTCC 2-9-1', '‏بالإضافة للضوابط الفرعية ضمن الضابط ‎٢١٠٢‏ في الضوابط الأساسية\r\nي لإدارة الثغرات\r\nالمتعلقة بأنظمة التحكم الصناعي', NULL, 'OTCC 2-9-1', 'Not Applicable', 43, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(450, 'OTCC 2-9-1-1', 'OTCC 2-9-1-1', 'يجب تحديد نطاق عمليات تقييم الثغرات وأنشطتها لبيئة شبكات\r\nأنظمة التحكم الصناعي (01\\/108) بوصفه جزء من الآليات الرسمية لإدارة\r\nالثغرات في الجهة. وضمان تأثير محدود أو غير محدود على بيئة الإنتاج', NULL, 'OTCC 2-9-1-1', 'Not Applicable', 43, 1, NULL, NULL, NULL, 1, NULL, NULL, 449, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(451, 'OTCC 2-9-1-2', 'OTCC 2-9-1-2', 'رجوعا للضابط الفرعي ‎٣-٢-١٠-٢‏ في الضوابط الأساسية للأمن\r\nالسيبراني؛ يتم التأكد من ضمان المعالجة الفورية. للثغرات الحساسة\r\nالمكتشفة حديثاً. والتي تشكل مخاطر كبيرة على بينة شبكات أنظمة التحكم\r\nالصناعي', NULL, 'OTCC 2-9-1-2', 'Not Applicable', 43, 1, NULL, NULL, NULL, 1, NULL, NULL, 449, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(452, 'OTCC 2-9-1-3', 'OTCC 2-9-1-3', 'رجوعا للضابط الفرعي ‎١-٣-١٠-٢‏ في الضوابط الأساسية للأمن\r\nالسيبراني؛ يجب إجراء تقييم الثغرات لأنظمة التحكم الصناعي دوريا.', NULL, 'OTCC 2-9-1-3', 'Not Applicable', 43, 1, NULL, NULL, NULL, 1, NULL, NULL, 449, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(453, 'OTCC 2-9-2', 'OTCC 2-9-2', 'رجوعا للضابط ٢-٠١-ع‏ في الضوابط الأساسية للأمن السيبراني؛ يجب مراجعة\r\nمتطلبات الأمن السيبراني لإدارة الثغرات الخاصة بأنظمة التحكم الصناعي | ي | ي\r\n(01\\/105). وقياس فعالية تطبيقها وتقييمها دوريا.', NULL, 'OTCC 2-9-2', 'Not Applicable', 43, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(454, 'OTCC 2-10-1', 'OTCC 2-10-1', 'بالإضافة للضوابط الفرعية ضمن الضابط ‎2-١-7‏ في الضوابط الأساسية\r\nللأمن السيبراني؛ يجب أن تغطي متطلبات الأمن السيبراني إجراء اختبارات\r\nاختراق على أنظمة التحكم الصناعي (07\\/165)', NULL, 'OTCC 2-10-1', 'Not Applicable', 44, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(455, 'OTCC 2-10-1-1', 'OTCC 2-10-1-1', 'رجوعا للضابط الفرعي ‎١-٣-١١-٢‏ في الضوابط الأساسية للأمن\r\nالسيبراني؛ يجب تحديد نطاق أنشطة اختبارات الاختراق. لتغطي بيئة\r\nشبكات أ التحكم الصناعي (01\\/105) و الشبكات الرتب 8\r\nالتشغيلية. وأن يتم عمل الاختبارات من قبل فريق ذي كفاءة عالية', NULL, 'OTCC 2-10-1-1', 'Not Applicable', 44, 1, NULL, NULL, NULL, 1, NULL, NULL, 454, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(456, 'OTCC 2-10-1-2', 'OTCC 2-10-1-2', 'رجوعا للضابط الفرعي ‎٢-٢-١١-٢‏ في الضوابط الأساسية للأمن\r\nالسيبراني؛ يجب إجراء اختبار الاختراق\" بعد التأكد من أن تأثير الاختبار6\r\nمحدود على بيئة الإنتاج. أو إجراء اختبار الاختراق. في بيئة منفصلة مماثلة', NULL, 'OTCC 2-10-1-2', 'Not Applicable', 44, 1, NULL, NULL, NULL, 1, NULL, NULL, 454, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(457, 'OTCC 2-10-1-3', 'OTCC 2-10-1-3', 'في الضوابط الأساسية للأمن‎ ٢-٢-١١-٢ ‏رجوعا للضابط الفرعي‎ 3-1-١-٠\r\n‏السيبراني؛ يجب إجراء اختبار الاختراق لأنظمة التحكم الصناعي دوريا.', NULL, 'OTCC 2-10-1-3', 'Not Applicable', 44, 1, NULL, NULL, NULL, 1, NULL, NULL, 454, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(458, 'OTCC 2-10-1-4', 'OTCC 2-10-1-4', '‏يجب تحديد طرق اختبارات بديلة وتنفيذها مثل الاختبارات‎ ٤١-١٠-٢\r\n‏غير الفعالة (وصناتع]\' ©19ومة0) لجمع المعلومات عندما يكون هنالك أثر‎\r\n‏محتمل على بيئة الإنتاج التشغيلية.‎', NULL, 'OTCC 2-10-1-4', 'Not Applicable', 44, 1, NULL, NULL, NULL, 1, NULL, NULL, 454, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(459, 'OTCC 2-10-2', 'OTCC 2-10-2', '‏رجوعا للضابط ‎2-١-3‏ في الضوابط الأساسية للأمن السيبراني؛ يجب مراجعة\r\nمتطلبات الأمن السيبراني لاختبارات الاختراق على أنظمة التحكم الصناعي | ي\r\n(01\\/105). وقياس فعالية تطبيقها وتقييمها دوريا.', NULL, 'OTCC 2-10-2', 'Not Applicable', 44, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(460, 'OTCC 2-11-1', 'OTCC 2-11-1', 'بالإضافة للضوابط الفرعية. ضمن الضابط ‎٣-١٢-٢‏ في الضوابط الأساسية\r\nللأمن السيبراني؛ يجب أن تغطي متطلبات الآمن السيبراني لإدارة سجلات\r\nالأحداث ومراقبة الأمن السيبراني الخاصة بأنظمة التحكم الصناعي', NULL, 'OTCC 2-11-1', 'Not Applicable', 45, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(461, 'OTCC 2-11-1-1', 'OTCC 2-11-1-1', 'تفعيل سجلات الأحداث المتعلقة بالأمن السيبراني على جميع\r\nالأصول في بيئة شبكات أنظمة التحكم الصناعي', NULL, 'OTCC 2-11-1-1', 'Not Applicable', 45, 1, NULL, NULL, NULL, 1, NULL, NULL, 460, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(462, 'OTCC 2-11-1-2', 'OTCC 2-11-1-2', 'اكتشاف محاولات فشل الوصول إلى نظام المراقبة الخاص\r\nبالجهة. ورصدها.', NULL, 'OTCC 2-11-1-2', 'Not Applicable', 45, 1, NULL, NULL, NULL, 1, NULL, NULL, 460, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(463, 'OTCC 2-11-1-3', 'OTCC 2-11-1-3', 'إجراء مراجعة ومراقبة مستمرة ودقيقة لسجلات الأحداث\r\n(1088 صعءع) والتدقيق(ولنةء7 انهسه) المتعلقة بالأمن السيبراني. على\r\nأصول أنظمة التحكم الصناعي', NULL, 'OTCC 2-11-1-3', 'Not Applicable', 45, 1, NULL, NULL, NULL, 1, NULL, NULL, 460, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(464, 'OTCC 2-11-1-4', 'OTCC 2-11-1-4', 'إجراء مراقبة وكشف. وتحليل لسلوك المستخدم  “ UBA “Analytics Behaviors User.', NULL, 'OTCC 2-11-1-4', 'Not Applicable', 45, 1, NULL, NULL, NULL, 1, NULL, NULL, 460, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(465, 'OTCC 2-11-1-5', 'OTCC 2-11-1-5', 'اكتشاف عمليات الرفع أو التنزيل على أجهزة وأنظمة التحكم\r\nالصناعي (01\\/105). بما في ذلك أنظمة السلامة', NULL, 'OTCC 2-11-1-5', 'Not Applicable', 45, 1, NULL, NULL, NULL, 1, NULL, NULL, 460, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(466, 'OTCC 2-11-1-6', 'OTCC 2-11-1-6', 'مراقبة جميع عمليات الوصول عن بعد  s Remote\r\nSessions', NULL, 'OTCC 2-11-1-6', 'Not Applicable', 45, 1, NULL, NULL, NULL, 1, NULL, NULL, 460, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(467, 'OTCC 2-11-1-7', 'OTCC 2-11-1-7', '‏ اكتشاف الاحداث الضارة Malicious events) وفحصها.', NULL, 'OTCC 2-11-1-7', 'Not Applicable', 45, 1, NULL, NULL, NULL, 1, NULL, NULL, 460, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(468, 'OTCC 2-11-1-8', 'OTCC 2-11-1-8', 'تسجيل التنبيهات الحديثة ومراقبتها في حال اتصال أجهزة\r\nجديدة. أو غير مسموح بها بشبكات أنظمة التحكم الصناعي', NULL, 'OTCC 2-11-1-8', 'Not Applicable', 45, 1, NULL, NULL, NULL, 1, NULL, NULL, 460, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(469, 'OTCC 2-11-1-9', 'OTCC 2-11-1-9', 'استخدام التهديدات الاستباقية (ععصععنلاءاصآ هععط]آ) المتعلقة\r\nبأنظمة التحكم الصناعي (071\\/1058) لضبط تنبيهات نظام إدارة سجلات\r\nالاحداث وتحديثها. ومراقبة الأمن السيبراني (:]51) بشكل منتظم.', NULL, 'OTCC 2-11-1-9', 'Not Applicable', 45, 1, NULL, NULL, NULL, 1, NULL, NULL, 460, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(470, 'OTCC 2-11-1-10', 'OTCC 2-11-1-10', 'مراقبة جميع نقاط التحكم بالدخول )ؤ :دهعم\r\nوصنه) بين حدود الشبكة )Boundaries N‏ والاتصالات الخارجية.', NULL, 'OTCC 2-11-1-10', 'Not Applicable', 45, 1, NULL, NULL, NULL, 1, NULL, NULL, 460, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(471, 'OTCC 2-11-2', 'OTCC 2-11-2', 'رجوعا للضابط 2-1-3 في الضوابط الأساسية للأمن السيبراني؛ يجب\r\nمراجعة متطلبات الأمن السيبراني لإدارة سجلات الأحداث. ومراقبة الأمن\r\nالسيبراني لأنظمة التحكم الصناعي (07\\/165©). وقياس فعالية تطبيقها\r\nوتقييمها دورياً.', NULL, 'OTCC 2-11-2', 'Not Applicable', 45, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(472, 'OTCC 2-12-1', 'OTCC 2-12-1', 'بالإضافة للضوابط الفرعية ضمن الضابط ‎٢-١٣-٢‏ في الضوابط الأساسية\r\nللأمن السيبراني؛ يجب أن تغطي متطلبات الأمن السيبراني لإدارة حوادث\r\nوتهديدات الأمن السيبراني المتعلقة بأنظمة التحكم الصناعي', NULL, 'OTCC 2-12-1', 'Not Applicable', 46, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(473, 'OTCC 2-12-1-1', 'OTCC 2-12-1-1', 'التأكد من أن خطط الاستجابة للحوادث الأمنية. المتعلقة بأنظمة\r\nالتحكم الصناعي (01\\/105) مدمجة. ومتوائمة مع خطط الجهة وإجراءاتها؛\r\nمثل خطط الاستجابة لحوادث تقنية المعلومات. وإدارة الأزمات. وخطط\r\n‏استمرارية الأعمال', NULL, 'OTCC 2-12-1-1', 'Not Applicable', 46, 1, NULL, NULL, NULL, 1, NULL, NULL, 472, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(474, 'OTCC 2-12-1-2', 'OTCC 2-12-1-2', 'إجراء تحليل للحوادث\" وتحليل الأسباب الجذرية )e Root\r\nAnalysis )) لحوادث الأمن السيبراني. بطريقة منظمة. بعد اكتشاف الحوادث', NULL, 'OTCC 2-12-1-2', 'Not Applicable', 46, 1, NULL, NULL, NULL, 1, NULL, NULL, 472, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(475, 'OTCC 2-12-1-3', 'OTCC 2-12-1-3', 'تحديد تسلسل أنشطة الاستجابة. لحوادث الأمن السيبراني\r\nاللازمة لاستعادة العمليات التشغيلية لطبيعتها', NULL, 'OTCC 2-12-1-3', 'Not Applicable', 46, 1, NULL, NULL, NULL, 1, NULL, NULL, 472, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(476, 'OTCC 2-12-1-4', 'OTCC 2-12-1-4', 'إنشاء خطط التواصل. عند وقوع الحوادث', NULL, 'OTCC 2-12-1-4', 'Not Applicable', 46, 1, NULL, NULL, NULL, 1, NULL, NULL, 472, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(477, 'OTCC 2-12-1-5', 'OTCC 2-12-1-5', 'تضمين إجراءات التعافي لأنظمة التحكم الصناعي وتشمل أنظمة\r\nمعدات السلامة (515) في خطط الاستجابة للحوادث. واستعادة النظام. | ‎٩‏\r\n‏واستمرارية الأعمال', NULL, 'OTCC 2-12-1-5', 'Not Applicable', 46, 1, NULL, NULL, NULL, 1, NULL, NULL, 472, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(478, 'OTCC 2-12-1-6', 'OTCC 2-12-1-6', 'تزويد العاملين بالجهة بالمهارات والدورات التدريبية المطلوبة\r\n(الموظفين والمتعاقدين). للاستجابة لحوادث الأمن السيبراني المتعلقة بأنظمة | ي | ي | ي\r\nالتحكم الصناعي', NULL, 'OTCC 2-12-1-6', 'Not Applicable', 46, 1, NULL, NULL, NULL, 1, NULL, NULL, 472, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(479, 'OTCC 2-12-1-7', 'OTCC 2-12-1-7', 'اختبار قدرات الاستجابة لحوادث الأمن السيبراني ومستوى\r\nالجاهزية والخطة المعتمدة بشكل دوري من خلال إجراء تمارين محاكاة | ص | يي\r\nللهجمات السيبرانية', NULL, 'OTCC 2-12-1-7', 'Not Applicable', 46, 1, NULL, NULL, NULL, 1, NULL, NULL, 472, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(480, 'OTCC 2-12-1-8', 'OTCC 2-12-1-8', 'استخدام معلومات التهديدات الاستباقية )محن ععط7)\r\nلتحديد الخطط والأساليب والإجراءات (1178) المستخدمة من قبل\r\nالمجموعات النشطة (ومسه:6 زالناءه) التي تستهدف أنظمة التحكم\r\nالصناعي', NULL, 'OTCC 2-12-1-8', 'Not Applicable', 46, 1, NULL, NULL, NULL, 1, NULL, NULL, 472, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(481, 'OTCC 2-12-2', 'OTCC 2-12-2', '‏رجوعا للضابط ٢-٣١-ع‏ في الضوابط الأساسية للأمن السيبراني. يجب مراجعة\r\nيفيص متطلبات الأمن السيبراني لإدارة حوادث وتهديدات الأمن السيبراني في بينة | ي | ي\r\nأنظمة التحكم الصناعي (01\\/108). وقياس فعالية تطبيقها وتقييمها دورياً.', NULL, 'OTCC 2-12-2', 'Not Applicable', 46, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(482, 'OTCC 2-13-1', 'OTCC 2-13-1', 'بالإضافة للضوابط الفرعية ضمن الضابط ‎٣-١٤٢‏ في الضوابط الأساسية\r\nللأمن السيبراني؛ يجب أن تغطي متطلبات الآمن السيبراني للأمن المادي\r\nالمتعلقة بأنظمة التحكم الصناعي', NULL, 'OTCC 2-13-1', 'Not Applicable', 47, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(483, 'OTCC 2-13-1-1', 'OTCC 2-13-1-1', 'الاحتفاظ بقائمة الأشخاص. الذين لديهم حق الوصول المادي\r\nالمصرح به إلى المنشآت والأماكن الحساسة. التي يتواجد بها أصول أنظمة\r\nالتحكم الصناعي', NULL, 'OTCC 2-13-1-1', 'Not Applicable', 47, 1, NULL, NULL, NULL, 1, NULL, NULL, 482, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(484, 'OTCC 2-13-1-2', 'OTCC 2-13-1-2', 'تطبيق الآليات المناسبة للتنبيه. والكشف عن التسلل المادي\r\n(صمنوسعصا لمعنورط2ٍ) والمراقبة (ع>صةللنعبءسك) بشكل لحظي (-لةعج\r\nءنآ). للتعرف على محاولات الدخول المحتملة. وتطبيق إجراءات\r\nالاستجابة المعتمدة.', NULL, 'OTCC 2-13-1-2', 'Not Applicable', 47, 1, NULL, NULL, NULL, 1, NULL, NULL, 482, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(485, 'OTCC 2-13-1-3', 'OTCC 2-13-1-3', 'حماية نقاط الدخول المادية. والمحيط بالأماكن التي تحتوي\r\nعلى أنظمة التحكم الصناعي (01\\/105) الحساسة. والتأكد من مراقبتها\r\nباستمرار.', NULL, 'OTCC 2-13-1-3', 'Not Applicable', 47, 1, NULL, NULL, NULL, 1, NULL, NULL, 482, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(486, 'OTCC 2-13-1-4', 'OTCC 2-13-1-4', 'استخدام إجراءات الحماية المناسبة؛ مثل الأقفال على جميع\r\nالخزائن (ماءصنطة0) التي تحتوي على أنظمة تحكم)عرك !دصهح)\r\nوأصول حساسة متعلقة بأنظمة التحكم الصناعي (071\\/105) وذلك لمنع\r\nالوصول غير المصرح به للأجهزة. التي يمكن أن توفر آلية لاختراق أصول\r\nأنظمة التحكم الصناعي', NULL, 'OTCC 2-13-1-4', 'Not Applicable', 47, 1, NULL, NULL, NULL, 1, NULL, NULL, 482, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(487, 'OTCC 2-13-1-5', 'OTCC 2-13-1-5', 'تطبيق قيود صارمة على صلاحيات الوصول المادي. لجميع أصول\r\nأجهزة وأنظمة التحكم الصناعي؛ بما في ذلك أنظمة معدات السلامة', NULL, 'OTCC 2-13-1-5', 'Not Applicable', 47, 1, NULL, NULL, NULL, 1, NULL, NULL, 482, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(488, 'OTCC 2-13-1-6', 'OTCC 2-13-1-6', 'الاحتفاظ بسجلات دخول الزوار إلى المناطق الحساسة. والتي\r\nتحتوي على أنظمة التحكم الصناعي', NULL, 'OTCC 2-13-1-6', 'Not Applicable', 47, 1, NULL, NULL, NULL, 1, NULL, NULL, 482, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(489, 'OTCC 2-13-1-7', 'OTCC 2-13-1-7', 'مراقبة الأعمال. التي يتم تأديتها من المقاولين. أو الموظفين\r\nالتابعين للموردين. ومزودي الخدمات.', NULL, 'OTCC 2-13-1-7', 'Not Applicable', 47, 1, NULL, NULL, NULL, 1, NULL, NULL, 482, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(490, 'OTCC 2-13-1-8', 'OTCC 2-13-1-8', 'تزويد حراس الأمن بالمهارات المتخصصة. والتدريب اللازم. يما\r\nيتوافق مع المهمات والمسؤوليات المنوطة بهم؛ فيما يتعلق بالأمن المادي\r\nلأنظمة التحكم الصناعي', NULL, 'OTCC 2-13-1-8', 'Not Applicable', 47, 1, NULL, NULL, NULL, 1, NULL, NULL, 482, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(491, 'OTCC 2-13-1-9', 'OTCC 2-13-1-9', 'اختبار إمكانيات الأمن المادي وجاهزيته بشكل دوري؛ من خلال\r\nعمل تمارين المحاكاة (مثل => الهندسة الاجتماعية).', NULL, 'OTCC 2-13-1-9', 'Not Applicable', 47, 1, NULL, NULL, NULL, 1, NULL, NULL, 482, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(492, 'OTCC 2-13-2', 'OTCC 2-13-2', 'رجوعا للضابط 2-14-4 في الضوابط الأساسية للأمن السيبراني يجب مراجعة متطلبات الامن السيبراني لإدارة الأمن المادي في بيئة أنظمة التحكم الصناعي', NULL, 'OTCC 2-13-2', 'Not Applicable', 47, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(493, 'OTCC 3-1-1', 'OTCC 3-1-1', 'بالإضافة للضوابط الفرعية ضمن الضابط ‎٣-١-٢‏ في الضوابط الأساسية\r\nللأمن السيبراني؛ يجب أن تغطي متطلبات صمود الأمن السيبراني في إدارة\r\nاستمرارية الأعمال المتعلقة بأنظمة التحكم الصناعي', NULL, 'OTCC 3-1-1', 'Not Applicable', 49, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(494, 'OTCC 3-1-1-1', 'OTCC 3-1-1-1', 'تحديد الأنشطة اللازمة. للمحافظة على الحد الأدنى من العمليات\r\nالمتعلقة بأنظمة التحكم الصناعي', NULL, 'OTCC 3-1-1-1', 'Not Applicable', 49, 1, NULL, NULL, NULL, 1, NULL, NULL, 493, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(495, 'OTCC 3-1-1-2', 'OTCC 3-1-1-2', 'تطبيق التوافر (رعصةص4ءع) للشبكات. والوسائط. والأجهزة\r\nالحساسة لأصول أنظمة التحكم الصناعي (01\\/105) وفقاً للتقييم الدوري\r\nلمخاطر الأمن السيبراني. لأصول أنظمة التحكم الصناعي', NULL, 'OTCC 3-1-1-2', 'Not Applicable', 49, 1, NULL, NULL, NULL, 1, NULL, NULL, 493, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(496, 'OTCC 3-1-1-3', 'OTCC 3-1-1-3', 'تضمين متطلبات الأمن السيبراني. المتعلقة بأنظمة التحكم الصناعي\r\n(01\\/105) إلى خطة استمرارية الأعمال (}8)؛ تحليل التأثر عاى الأعمال\r\n(ه8[1). ووقت الاستعادة المستهدف (870). ونقطة الاستعادة المستهدفة', NULL, 'OTCC 3-1-1-3', 'Not Applicable', 49, 1, NULL, NULL, NULL, 1, NULL, NULL, 493, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(497, 'OTCC 3-1-1-4', 'OTCC 3-1-1-4', 'تضمين متطلبات الأمن السيبراني المتعلقة بأنظمة التحكم\r\nالصناعي (01\\/105) ضمن خطط التعافي من الكوارث (0180)؛ بحيث\r\nتشمل سيناريوهات الكوارث المتعلقة بالأمن السيبراني. وإجراءات التعامل\r\nمع توقف النظام. وإجراءات إدارة العمليات التشغيلية.', NULL, 'OTCC 3-1-1-4', 'Not Applicable', 49, 1, NULL, NULL, NULL, 1, NULL, NULL, 493, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(498, 'OTCC 3-1-1-5', 'OTCC 3-1-1-5', 'عند فشل الأنظمة بسبب حادثة أمن سيبراني؛ يجب أن تكون\r\nأنظمة التحكم الصناعي (01\\/105) قادرة على العمل بمستوى أمان مقبول.\r\nأو بأوضاع تسمح باستمرارية العمل.', NULL, 'OTCC 3-1-1-5', 'Not Applicable', 49, 1, NULL, NULL, NULL, 1, NULL, NULL, 493, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(499, 'OTCC 3-1-1-6', 'OTCC 3-1-1-6', 'إجراء اختبارات وتمارين المحاكاة. بشكل دوري (مثل مهعاطة]\'\r\n1177\" ¡ع×غ) من أجل اختبار فعالية أنظمة التحكم الصناعي (\\/07\r\n© المتعلقة بخطط التعافي من الكوارث (01) وخطة استمرارية\r\nالعمل (ع}8) وإجراء تحليل الأسباب الجذرية )ل ح (\r\nللحوادث', NULL, 'OTCC 3-1-1-6', 'Not Applicable', 49, 1, NULL, NULL, NULL, 1, NULL, NULL, 493, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(500, 'OTCC 3-1-2', 'OTCC 3-1-2', 'رجوعا للضابط 3-1-4 في الضوابط الأساسية للأمن السيبراني يجب مراجعة متطلبات الامن السيبراني في ادارة استمرارية الاعمال', NULL, 'OTCC 3-1-2', 'Not Applicable', 49, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(501, 'OTCC 4-1-1', 'OTCC 4-1-1', 'بالإضافة للضوابط الفرعية ضمن الضابطين ‎٢-١-٤‏ و 2-1-6 في الضوابط\r\nالأساسية للأمن السيبراني؛ يجب أن تغطي متطلبات الأمن السيبراني للأطراف\r\nالخارجية. المتعلقة ب التحكم الصناعي', NULL, 'OTCC 4-1-1', 'Not Applicable', 50, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(502, 'OTCC 4-1-1-1', 'OTCC 4-1-1-1', 'تضمين متطلبات الأمن السيبراني. أثناء دورة حياة المشتريات.\r\nلمنتجات وخدمات أنظمة التحكم الصناعي', NULL, 'OTCC 4-1-1-1', 'Not Applicable', 50, 1, NULL, NULL, NULL, 1, NULL, NULL, 501, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(503, 'OTCC 4-1-1-2', 'OTCC 4-1-1-2', 'تحديد متطلبات الآمن السيبراني. لتقييم الأطراف الخارجية\r\n1-1 } | واختيارهم ومشاركتهم المعلومات', NULL, 'OTCC 4-1-1-2', 'Not Applicable', 50, 1, NULL, NULL, NULL, 1, NULL, NULL, 501, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(504, 'OTCC 4-1-1-3', 'OTCC 4-1-1-3', 'استخدام المتعاقدين والموردين الخارجيين ممارسات رسمية\r\nوموثقة لدورة حياة التطوير الآمن (©601) للبرامج الخاصة بالأنظمة | ي | ي\r\nوالأصول المصممة أو المطبقة في بيئة أنظمة التحكم الصناعي', NULL, 'OTCC 4-1-1-3', 'Not Applicable', 50, 1, NULL, NULL, NULL, 1, NULL, NULL, 501, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(505, 'OTCC 4-1-1-4', 'OTCC 4-1-1-4', 'إجراء تقييم للأمن السيبراني وتدقيق له. بشكل دوري للأطراف\r\nالخارجية؛ والتأكد من وجود ما يضمن السيطرة؛ على أي مخاطر سيبرانية | ‎٩‏\r\n‏تم رصدها.', NULL, 'OTCC 4-1-1-4', 'Not Applicable', 50, 1, NULL, NULL, NULL, 1, NULL, NULL, 501, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(506, 'OTCC 4-1-2', 'OTCC 4-1-2', '‏رجوعا للضابط ‎2-١-6‏ في الضوابط الأساسية للأمن السيبراني؛ يجب مرا\r\nبحص متطلبات الأمن السيبراني للأمن السيبراني للأطراف الخارجية. لبينة أنظمة | ي | ي\r\nالتحكم الصناعي (01\\/108). وقياس فعالية تطبيقها وتقييمها دوريا.', NULL, 'OTCC 4-1-2', 'Not Applicable', 50, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(507, 'CCC ١-١-م-١', 'CCC ١-١-م-١', 'بالإضافة للضابط ‎٠-6-١‏ في الضوابط الأساسية للأمن السيبراني. يجب على صاحب الصلاحية\r\nتحديد وتوثيق واعتماد', NULL, 'CCC ١-١-م-١', 'Not Applicable', 27, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(508, 'CCC ١-١-م-١-١‏', 'CCC ١-١-م-١-١‏', 'أدوار الأمن السيبراني. وتكليفات المسؤولية والمحاسبة والاستشارة والتبليغ\r\n(1هع) لكل أصحاب العلاقة في خدمات الحوسبة السحابية. بما في ذلك أدوار\r\nومسؤوليات صاحب الصلاحية', NULL, 'CCC ١-١-م-١-١‏', 'Not Applicable', 27, 1, NULL, NULL, NULL, 1, NULL, NULL, 507, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(509, 'CCC ١-١-ش۔١', 'CCC ١-١-ش۔١', 'بالإضافة للضابط ‎٠-6-١‏ في الضوابط الأساسية للأمن السيبراني. يجب على صاحب الصلاحية\r\nتحديد وتوثيق واعتماد', NULL, 'CCC ١-١-ش۔١', 'Not Applicable', 27, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(510, 'CCC ١-١-ش۔١-١', 'CCC ١-١-ش۔١-١', 'أدوار الأمن السيبراني. وتكليفات المسؤولية والمحاسبة والاستشارة والتبليغ\r\n([ع) لكل أصحاب العلاقة في خدمات الحوسبة السحابية. بما في ذلك أدوار\r\nومسؤوليات صاحب الصلاحية', NULL, 'CCC ١-١-ش۔١-١', 'Not Applicable', 27, 1, NULL, NULL, NULL, 1, NULL, NULL, 509, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(511, 'CCC ١-٢-م-١', 'CCC ١-٢-م-١', 'يجب أن تتضمن منهجية إدارة مخاطر الأمن السيبراني المذكورة في المكون الفرعي ‎0-١‏ في\r\nالضوابط الأساسية للأمن السيبراني لدى مقدمي الخدمات', NULL, 'CCC ١-٢-م-١', 'Not Applicable', 28, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(512, 'CCC ١-٢-م-١-١‏', 'CCC ١-٢-م-١-١‏', 'تحديد المستوى المقبول للمخاطر (160865 ون عاطةامع}) فيما يتعلق\r\nبخدمات الحوسبة السحابية. وتوضيحها للمشترك إذا كانت المخاطر ذات علاقة\r\nبه.', NULL, 'CCC ١-٢-م-١-١‏', 'Not Applicable', 28, 1, NULL, NULL, NULL, 1, NULL, NULL, 511, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(513, 'CCC ١-٢-م-١-٢', 'CCC ١-٢-م-١-٢', 'أخذ تصنيف البيانات والمعلومات بالاعتبار في منهجية إدارة مخاطر الأمن\r\nالسيبراني.', NULL, 'CCC ١-٢-م-١-٢', 'Not Applicable', 28, 1, NULL, NULL, NULL, 1, NULL, NULL, 511, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(514, 'CCC ١-٢-م-١-3', 'CCC ١-٢-م-١-3', 'إنشاء سجل لمخاطر الأمن السيبراني خاص بالعمليات وخدمات الحوسبة\r\nالسحابية. ومتابعته دوريًا بما يتناسب مع طبيعة المخاطر.', NULL, 'CCC ١-٢-م-١-3', 'Not Applicable', 28, 1, NULL, NULL, NULL, 1, NULL, NULL, 511, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(515, 'CCC ١-٢-ش-١', 'CCC ١-٢-ش-١', 'يجب أن تتضمن منهجية إدارة مخاطر الأمن السيبراني المذكورة في المكون الفرعي ‎٥-١‏ في\r\nالضوابط الأساسية للأمن السيبراني لدى المشتركين', NULL, 'CCC ١-٢-ش-١', 'Not Applicable', 28, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(516, 'CCC ١-٢-ش-١-١', 'CCC ١-٢-ش-١-١', 'تحديد المستوى المقبول للمخاطر (:1عع] فن عاطةامعع}) فيما يتعلق\r\nبخدمات الحوسبة السحابية', NULL, 'CCC ١-٢-ش-١-١', 'Not Applicable', 28, 1, NULL, NULL, NULL, 1, NULL, NULL, 515, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(517, 'CCC ١-٢-ش۔١۔٢', 'CCC ١-٢-ش۔١۔٢', 'أخذ تصنيف البيانات والمعلومات بالاعتبار في منهجية إدارة مخاطر الأمن\r\nالسيبراني.', NULL, 'CCC ١-٢-ش۔١۔٢', 'Not Applicable', 28, 1, NULL, NULL, NULL, 1, NULL, NULL, 515, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(518, 'CCC ١-٢-ش۔١۔3‏', 'CCC ١-٢-ش۔١۔3‏', 'إنشاء سجل لمخاطر الأمن السيبراني خاص بالعمليات وخدمات الحوسبة\r\nالسحابية. ومتابعته دوريًا يما يتناسب مع طبيعة المخاطر.', NULL, 'CCC ١-٢-ش۔١۔3‏', 'Not Applicable', 28, 1, NULL, NULL, NULL, 1, NULL, NULL, 515, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(519, 'CCC ١-٣-م-١', 'CCC ١-٣-م-١', 'بالإضافة للضابط ‎١-7-١‏ في الضوابط الأساسية للأمن السيبراني. يجب أن يشتمل التزام مقدمي\r\nالخدمات بالمتطلبات التشريعية والتنظيمية', NULL, 'CCC ١-٣-م-١', 'Not Applicable', 30, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(520, 'CCC ١-٣-م-١-١', 'CCC ١-٣-م-١-١', 'الالتزام الدائم والمستمر بجميع الأنظمة واللوائح والتعليمات والقرارات والأطر\r\nوالضوابط التنظيمية المتعلقة بالأمن السيبراني والمعمول بها في المملكة.', NULL, 'CCC ١-٣-م-١-١', 'Not Applicable', 30, 1, NULL, NULL, NULL, 1, NULL, NULL, 519, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(521, 'CCC ١-٣-ش۔١', 'CCC ١-٣-ش۔١', 'بالإضافة للضابط ‎1-7-١‏ في الضوابط الأساسية للأمن السيبراني. يجب أن يشتمل التزام المشتركين\r\nبالمتطلبات التشريعية والتنظيمية', NULL, 'CCC ١-٣-ش۔١', 'Not Applicable', 30, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(522, 'CCC ١-٣-ش-١-١', 'CCC ١-٣-ش-١-١', 'المراقبة الدائمة والمستمرة لمدى التزام مقدمي الخدمات بالتشريعات. وبنود\r\nالعقود المتعلقة بالأمن السيبراني.', NULL, 'CCC ١-٣-ش-١-١', 'Not Applicable', 30, 1, NULL, NULL, NULL, 1, NULL, NULL, 521, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(523, 'CCC ١-٤-م-١', 'CCC ١-٤-م-١', 'بالإضافة للضوابط الفرعية ضمن الضابطين ‎٣-٢-١‏ و ‎2-9-١‏ في الضوابط الأساسية للأمن السيبراني؛\r\n\r\nيجب أن تغطي متطلبات الأمن السيبراني قبل بدء وخلال العلاقة المهنية بين العاملين ومقدمي\r\nالخدمة', NULL, 'CCC ١-٤-م-١', 'Not Applicable', 32, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(524, 'CCC ١-٤-م-١-١', 'CCC ١-٤-م-١-١', 'فيما يتعلق بمراكز البيانات التابعة مقدم الخدمة داخل المملكة. يجب أن يشغل\r\nوظائف الأمن السيبراني مواطنون سعوديون مؤهلون', NULL, 'CCC ١-٤-م-١-١', 'Not Applicable', 32, 1, NULL, NULL, NULL, 1, NULL, NULL, 523, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(525, 'CCC ١-٤-م-١۔٢', 'CCC ١-٤-م-١۔٢', 'إجراء المسح الأمني للعاملين داخل المملكة الذين لهم حق الوصول إلى الأنظمة\r\nالتقنية السحابية', NULL, 'CCC ١-٤-م-١۔٢', 'Not Applicable', 32, 1, NULL, NULL, NULL, 1, NULL, NULL, 523, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(526, 'CCC ١-٤-م-١۔3', 'CCC ١-٤-م-١۔3', 'إقرار وتوقيع العاملين على جميع سياسات الأمن السيبراني كشرط مسبق للوصول\r\nإلى الأنظمة التقنية السحابية', NULL, 'CCC ١-٤-م-١۔3', 'Not Applicable', 32, 1, NULL, NULL, NULL, 1, NULL, NULL, 523, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(527, 'CCC ١-٤-م-2', 'CCC ١-٤-م-2', 'بالإضافة للضوابط الفرعية ضمن الضابط ‎0-4-١‏ في الضوابط الأساسية للأمن السيبراني. يجب أن\r\nتغطي متطلبات الأمن السيبراني بعد انتهاء العلاقة المهنية بين العاملين ومقدمي الخدمة', NULL, 'CCC ١-٤-م-2', 'Not Applicable', 32, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(528, 'CCC ١-٤-م-2۔1', 'CCC ١-٤-م-2۔1', 'ضمان إعادة الأصول الخاصة بمقدمي الخدمات (لا سيما ذات الصلة بالأمن\r\nالسيبراني) بمجرد إنهاء الخدمة مع العاملين.', NULL, 'CCC ١-٤-م-2۔1', 'Not Applicable', 32, 1, NULL, NULL, NULL, 1, NULL, NULL, 527, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(529, 'CCC ١-٤-ش-١', 'CCC ١-٤-ش-١', 'الإضافة للضوابط الفرعية ضمن الضابط ‎٣-٢-١‏ في الضوابط الأساسية للأمن السيبراني. يجب\r\nأن تغطي متطلبات الأمن السيبراني قبل بدء العلاقة المهنية بين العاملين والمشتركين', NULL, 'CCC ١-٤-ش-١', 'Not Applicable', 32, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(530, 'CCC ١-٤-ش-١-١', 'CCC ١-٤-ش-١-١', 'إجراء المسح الأمني للعاملين الذين لهم حق الوصول إلى المهام الحساسة\r\nلخدمات الحوسبة السحابية. مثل => إدارة المفاتيح. إدارة الخدمات التحكم\r\nبالوصول', NULL, 'CCC ١-٤-ش-١-١', 'Not Applicable', 32, 1, NULL, NULL, NULL, 1, NULL, NULL, 529, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(531, 'CCC ١-٥-م-١', 'CCC ١-٥-م-١', 'يجب تحديد متطلبات الأمن السيبراني لإدارة التغيير لدى مقدمي الخدمات\" وتوثيقهاء واعتمادها.', NULL, 'CCC ١-٥-م-١', 'Not Applicable', 120, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(532, 'CCC ١-٥-م-٢', 'CCC ١-٥-م-٢', 'يجب تطبيق متطلبات الأمن السيبراني. الخاصة بإدارة التغيير لدى مقدمي الخدمات.', NULL, 'CCC ١-٥-م-٢', 'Not Applicable', 120, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(533, 'CCC ١-٥-م-۳', 'CCC ١-٥-م-۳', 'يجب أن يغطي األمن السيرباين إلدارة التغيري لدى مقدمي الخدمات', NULL, 'CCC ١-٥-م-۳', 'Not Applicable', 120, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(534, 'CCC ١-٥-م-۳-١', 'CCC ١-٥-م-۳-١', 'إجراءات تنفيذ التغيريات )املخطط لها( بطرق آمنة، يف أنظمة اإلنتاج\r\n)Systems Production ،)مع إعطاء أولوية للمالحظات املتعلقة باألمن\r\nالسيرباي', NULL, 'CCC ١-٥-م-۳-١', 'Not Applicable', 120, 1, NULL, NULL, NULL, 1, NULL, NULL, 533, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(535, 'CCC ١-٥-م-۳-2', 'CCC ١-٥-م-۳-2', 'إجراءات تنفيذ التغيريات االستثنائية ذات العالقة باألمن السيرباين )مثل التغيريات\r\nأثناء التعايف من الحوادث(.', NULL, 'CCC ١-٥-م-۳-2', 'Not Applicable', 120, 1, NULL, NULL, NULL, 1, NULL, NULL, 533, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(536, 'CCC ١-٥-م-4', 'CCC ١-٥-م-4', 'يجب مراجعة متطلبات األمن السيرباين إلدارة التغيري لدى مقدمي الخدمات، ومراجعة تطبيقها،\r\nدوري', NULL, 'CCC ١-٥-م-4', 'Not Applicable', 120, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(537, 'CCC ٢-١-م-١', 'CCC ٢-١-م-١', 'بالإضافة للضوابط ضمن المكون الفرعي ‎١-٢‏ في الضوابط الأساسية للأمن السيبراني» يجب أن\r\nتغطي متطلبات الأمن السيبراني لإدارة الأصول المعلوماتية والتقنية لدى مقدمي الخدمات', NULL, 'CCC ٢-١-م-١', 'Not Applicable', 34, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(538, 'CCC ٢-١-م-١-١', 'CCC ٢-١-م-١-١', 'حصر جميع الأصول المعلوماتية والتقنية باستخدام التقنيات المناسبة كقاعدة\r\nبيانات إدارة الإعدادات (03101)؛ أو قدرة مماثلة. تتضمن جردًا لكل الأصول\r\nالتقنية', NULL, 'CCC ٢-١-م-١-١', 'Not Applicable', 34, 1, NULL, NULL, NULL, 1, NULL, NULL, 537, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(539, 'CCC ٢-١-م-١-2', 'CCC ٢-١-م-١-2', 'تحديد ملاك الأصول  وإشراكهم في دورة حياة إدارة الأصول', NULL, 'CCC ٢-١-م-١-2', 'Not Applicable', 34, 1, NULL, NULL, NULL, 1, NULL, NULL, 537, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(540, 'CCC ٢-١-ش۔١', 'CCC ٢-١-ش۔١', 'بالإضافة للضوابط ضمن المكون الفرعي ‎١-٢‏ في الضوابط الأساسية للأمن السيراني. يجب أن\r\nتغطي متطلبات الأمن السيبراني لإدارة الأصول المعلوماتية والتقنية لدى المشتركين', NULL, 'CCC ٢-١-ش۔١', 'Not Applicable', 34, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(541, 'CCC ٢-١-ش۔١-١‏', 'CCC ٢-١-ش۔١-١‏', 'حصر جميع الخدمات السحابية والأصول المعلوماتية والتقنية المتعلقة بها.\r\nإدارة هويات الدخول والصلاحيات', NULL, 'CCC ٢-١-ش۔١-١‏', 'Not Applicable', 34, 1, NULL, NULL, NULL, 1, NULL, NULL, 540, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(542, 'CCC ٢-٢-م-١', 'CCC ٢-٢-م-١', 'بالإضافة للضوابط الفرعية ضمن الضابط ‎٣-٢-٢‏ في الضوابط الأساسية للأمن السييراني. يجب\r\nأن تغطي متطلبات الأمن السيبراني الخاصة بإدارة هويات الدخول والصلاحيات لدى مقدمي\r\nالخدمات.', NULL, 'CCC ٢-٢-م-١', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(543, 'CCC ٢-٢-م-١-١', 'CCC ٢-٢-م-١-١', 'إدارة الحسابات العامة (فاصناهع>ه ععصء6) التي لا ممكن إسناد مسؤوليتها\r\nإلى أشخاص محددين', NULL, 'CCC ٢-٢-م-١-١', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, 542, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(544, 'CCC ٢-٢-م-١۔٢', 'CCC ٢-٢-م-١۔٢', 'الإدارة الآمنة للجلسات Management Session Secure ،). وتشمل مو\r\nالجلسات (Authenticity). وإقفالها لأدمعك16) وإنهاء مهلتها ()Timeout.)).', NULL, 'CCC ٢-٢-م-١۔٢', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, 542, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(545, 'CCC ٢-٢-م-١-٣', 'CCC ٢-٢-م-١-٣', 'التحقق من الهوية متعدد العناصر )ح -(\r\nلحسابات المستخدمين ذوي الصلاحيات الهامة والحساسة والذين لهم حق\r\nالوصول إلى الأنظمة التقنية السحابية', NULL, 'CCC ٢-٢-م-١-٣', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, 542, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(546, 'CCC ٢-٢-م۔١-٤', 'CCC ٢-٢-م۔١-٤', 'إجراءات لكشف محاولات الوصول غير المصرح به ومنعها مثل => (الحد الأقصى\r\nمن محاولات عمليات الدخول غير الناجحة', NULL, 'CCC ٢-٢-م۔١-٤', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, 542, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(547, 'CCC ٢-٢-م-١-٥', 'CCC ٢-٢-م-١-٥', 'استخدام الطرق والخوارزميات الآمنة لحفظ ومعالجة كلمات المرور مثل:\r\nاستخدام دوال اختزال آمنة', NULL, 'CCC ٢-٢-م-١-٥', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, 542, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(548, 'CCC ٢۔٢-م-١-٦', 'CCC ٢۔٢-م-١-٦', 'الإدارة الآمنة للحسابات الخاصة بالعاملين التابعين للأطراف الخارجية', NULL, 'CCC ٢۔٢-م-١-٦', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, 542, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(549, 'CCC ٢-٢-م-١-٧', 'CCC ٢-٢-م-١-٧', 'التحكم في الوصول إلى الأنظمة الإدارية (es A)‏ والإشرافية', NULL, 'CCC ٢-٢-م-١-٧', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, 542, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(550, 'CCC ٢-٢-م-١-٨', 'CCC ٢-٢-م-١-٨', 'إخفاء معلومات التحقق من الهوية. خاصة كلمات المرور. عند عرضها\r\nللمستخدم؛ لحمايتها من اطلاع الآخرين عليها', NULL, 'CCC ٢-٢-م-١-٨', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, 542, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(551, 'CCC ٢-٢-م-١-٩', 'CCC ٢-٢-م-١-٩', 'الحصول على موافقة المشترك قبل عملية الوصول إلى أي من الأصول والبيانات\r\nالخاصة به. من قبل مقدم الخدمة أو الأطراف الخارجية مقدم الخدمة.', NULL, 'CCC ٢-٢-م-١-٩', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, 542, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(552, 'CCC ٢-٢-م-١-١٠', 'CCC ٢-٢-م-١-١٠', 'القدرة على الإيقاف الفوري للجلسة (صمنوعك) لعمليات الدخول عن بعد\r\nومنع المستخدم من الدخول مستقبلا.', NULL, 'CCC ٢-٢-م-١-١٠', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, 542, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(553, 'CCC ٢-٢-م-١-١١‏', 'CCC ٢-٢-م-١-١١‏', 'تزويد المشتركين بخدمات التحقق من الهوية متعدد العناصر لكافة الحسابات\r\nالسحابية للمستخدمين ذوي الصلاحيات الهامة والحساسة', NULL, 'CCC ٢-٢-م-١-١١‏', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, 542, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(554, 'CCC ٢-٢-م-١-١٢', 'CCC ٢-٢-م-١-١٢', 'التحكم بالوصول لأنظمة ووسائل التخزين (مثل الشبكة الخاصة بالتخزين', NULL, 'CCC ٢-٢-م-١-١٢', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, 542, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(555, 'CCC ٢-٢-ش۔١', 'CCC ٢-٢-ش۔١', 'بالإضافة للضوابط الفرعية ضمن الضابط 7-7-9 في الضوابط الأساسية للأمن السيبراني. يجب أن\r\nتغطي متطلبات الأمن السيبراني الخاصة بإدارة هويات الدخول والصلاحيات لدى المشتركين', NULL, 'CCC ٢-٢-ش۔١', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(556, 'CCC ٢-٢-ش۔١۔1', 'CCC ٢-٢-ش۔١۔1', 'إدارة هويات الدخول والصلاحيات لجميع الحسابات. التي لديها صلاحية\r\nالوصول إلى الخدمات السحابية. خلال دورة حياتها', NULL, 'CCC ٢-٢-ش۔١۔1', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, 555, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(557, 'CCC ٢-٢-ش۔١۔٢‏', 'CCC ٢-٢-ش۔١۔٢‏', 'سرية هوية المستخدم والحسابات والصلاحيات بما في ذلك الطلب من\r\nالمستخدمين حفظ خصوصيتها (للعاملين. والأطراف الخغارجية\r\nوالمستخدمين من جهة المشترك', NULL, 'CCC ٢-٢-ش۔١۔٢‏', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, 555, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(558, 'CCC ٢-٢-ش۔١-٣‏', 'CCC ٢-٢-ش۔١-٣‏', 'الإدارة الآمنة لجلسات ) ). وتشمل موثوقية\r\nالجلسات (). وإقفالها (1) وإنهاء مهلتها .', NULL, 'CCC ٢-٢-ش۔١-٣‏', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, 555, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(559, 'CCC ٢۔٢-ش۔١-٤', 'CCC ٢۔٢-ش۔١-٤', 'التحقق من الهوية متعدد العناصر لكافة الحسابات السحابية للمستخدمين\r\nذوي الصلاحيات الهامة والحساسة', NULL, 'CCC ٢۔٢-ش۔١-٤', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, 555, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(560, 'CCC ٢-٢-ش-١-٥', 'CCC ٢-٢-ش-١-٥', 'إجراءات لكشف محاولات الوصول غير المصرح به ومنعها مثل => (الحد الأقصى\r\nمن محاولات عمليات الدخول غير الناجحة', NULL, 'CCC ٢-٢-ش-١-٥', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, 555, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(561, 'CCC  ٢-٣-م-١', 'ccc ٢-٣-م-١', 'بالإضافة للضوابط الفرعية ضمن الضابط ‎٢-٢-٢‏ في الضوابط الأساسية للأمن السيبراني. يجب أن\r\nتغطي متطلبات الأمن السيبراني الخاصة بحماية الأنظمة وأجهزة معالجة المعلومات لدى مقدمي\r\nالخدمات', NULL, 'ccc ٢-٣-م-١', 'Not Applicable', 36, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(562, 'CCC  ٢-٣-م-١-١', 'ccc ٢-٣-م-١-١', 'التحقق من مدى التزام الإعدادات التقنية معايير الأمن السيبراني المعتمدة لدى\r\nمقدم الخدمة', NULL, 'ccc ٢-٣-م-١-١', 'Not Applicable', 36, 1, NULL, NULL, NULL, 1, NULL, NULL, 561, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(563, 'CCC ٢-٣-م-١-٢‏', 'CCC ٢-٣-م-١-٢‏', 'وضع ضمانات لمنع اختلاط بيانات (ing D ) المشتركين', NULL, 'CCC ٢-٣-م-١-٢‏', 'Not Applicable', 36, 1, NULL, NULL, NULL, 1, NULL, NULL, 561, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(564, 'CCC  ٢-٣-م-١-٣‏', 'CCC  ٢-٣-م-١-٣‏', 'اتباع مبادئ الأمن السيبراني لتفعيل الحد الأدنى من الوظائف المطلوبة\r\n)ج نج صنصنصن) لإعدادات الأنظمة', NULL, 'CCC  ٢-٣-م-١-٣‏', 'Not Applicable', 36, 1, NULL, NULL, NULL, 1, NULL, NULL, 561, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(565, 'CCC ٢-٣-م-۔١-٤', 'CCC ٢-٣-م-۔١-٤', 'أن تكون الأنظمة التقنية السحابية (015) قادرة على التعامل بطرق آمنة مع:\r\nالمدخلات والتحقق منها ).‏ والاستثناء ات \r\nوالتوقف (عنلنة)', NULL, 'CCC ٢-٣-م-۔١-٤', 'Not Applicable', 36, 1, NULL, NULL, NULL, 1, NULL, NULL, 561, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL);
INSERT INTO `framework_controls` (`id`, `short_name`, `long_name`, `description`, `supplemental_guidance`, `control_number`, `control_status`, `family`, `control_owner`, `desired_maturity`, `control_priority`, `control_class`, `control_maturity`, `control_phase`, `control_type`, `parent_id`, `submission_date`, `last_audit_date`, `next_audit_date`, `desired_frequency`, `mitigation_percent`, `status`, `deleted`, `created_at`, `updated_at`) VALUES
(566, 'CCC ٢-٣-م-١-٥', 'CCC ٢-٣-م-١-٥', 'عزل التطبيقات والوظائف الأمنية عن التطبيقات والوظائف الأخرى في الأنظمة\r\nالتقنية السحابية', NULL, 'CCC ٢-٣-م-١-٥', 'Not Applicable', 36, 1, NULL, NULL, NULL, 1, NULL, NULL, 561, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(567, 'CCC ٢-٣-م-١-٦', 'CCC ٢-٣-م-١-٦', 'تبليغ المشترك بالمتطلبات المتعلقة بالأمن السيبراني التي يوفرها مقدم الخدمة\r\nوالقابلة للاستخدام من قبل المشترك', NULL, 'CCC ٢-٣-م-١-٦', 'Not Applicable', 36, 1, NULL, NULL, NULL, 1, NULL, NULL, 561, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(568, 'CCC ٢۔٣-م-١-٧', 'CCC ٢۔٣-م-١-٧', 'اكتشاف ومنع التغييرات غير المصرح بها على البرامج والأنظمة.', NULL, 'CCC ٢۔٣-م-١-٧', 'Not Applicable', 36, 1, NULL, NULL, NULL, 1, NULL, NULL, 561, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(569, 'CCC ٢-٣-م-١-٨', 'CCC ٢-٣-م-١-٨', 'العزل بين بيئات الاستضافة الخاصة بالمشتركين ) («\r\nوالحماية فيما بينها', NULL, 'CCC ٢-٣-م-١-٨', 'Not Applicable', 36, 1, NULL, NULL, NULL, 1, NULL, NULL, 561, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(570, 'CCC ٢-٣-م-١-٩', 'CCC ٢-٣-م-١-٩', 'أن تكون الحوسبة السحابية المشتركة المقدمة للمشتركين (الجهات الحكومية\r\nوالجهات ذات البنية التحتية الحساسة) معزولة عن أي حوسبة سحابية أخرى\r\nمقدمة للجهات خارج نطاق العمل', NULL, 'CCC ٢-٣-م-١-٩', 'Not Applicable', 36, 1, NULL, NULL, NULL, 1, NULL, NULL, 561, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(571, 'CCC ٢-٣-م-١-10', 'CCC ٢-٣-م-١-10', 'تقديم خدمات الحوسبة السحابية من داخل المملكة. وتشمل الأنظمة\r\nالمستخدمة بما في ذلك أنظمة التخزين والمعالجة ومراكز التعافي من الكوارث', NULL, 'CCC ٢-٣-م-١-10', 'Not Applicable', 36, 1, NULL, NULL, NULL, 1, NULL, NULL, 561, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(572, 'CCC ٢-٣-م-١-١١', 'CCC ٢-٣-م-١-١١', 'تقديم خدمات الحوسبة السحابية من داخل المملكة. وتشمل الأنظمة\r\nالمستخدمة بما في ذلك أنظمة المراقبة. والدعم.', NULL, 'CCC ٢-٣-م-١-١١', 'Not Applicable', 36, 1, NULL, NULL, NULL, 1, NULL, NULL, 561, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(573, 'CCC ٢-٣-م-١-12', 'CCC ٢-٣-م-١-12', 'استخدام التقنيات الحديثة. مثل تقنيات ة ع ع(\r\n))( صمم => . لضمان جاهزية خوادم وأجهزة المعلومات الخاصة\r\nبأنظمة وأجهزة معالجة المعلومات لدى مقدمي الخدمات للاستجابة السريعة\r\nللحوادث.', NULL, 'CCC ٢-٣-م-١-12', 'Not Applicable', 36, 1, NULL, NULL, NULL, 1, NULL, NULL, 561, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(574, 'CCC ٢-٣-ش۔١', 'CCC ٢-٣-ش۔١', 'بالإضافة للضوابط الفرعية ضمن الضابط ‎٣-٣-٢‏ في الضوابط الأساسية للأمن السيبراني يجب\r\n\r\nأن تغطي متطلبات الأمن السيبراني الخاصة بحماية الأنظمة وأجهزة معالجة المعلومات لدى\r\nالمشتركين', NULL, 'CCC ٢-٣-ش۔١', 'Not Applicable', 36, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(575, 'CCC ٢-٣-ش۔١-١', 'CCC ٢-٣-ش۔١-١', 'التحقق من قيام مقدم الخدمة بعزل الحوسبة السحابية المشتركة المقدمة\r\nللمشتركين (الجهات الحكومية والجهات ذات البنية التحتية الحساسة) عن أي\r\nحوسبة سحابية أخرى مقدمة للجهات خارج نطاق العمل.', NULL, 'CCC ٢-٣-ش۔١-١', 'Not Applicable', 36, 1, NULL, NULL, NULL, 1, NULL, NULL, 574, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(576, 'CCC ٢-٤-م-١', 'CCC ٢-٤-م-١', 'بالإضافة للضوابط الفرعية ضمن الضابط ‎٣-٥-٢‏ في الضوابط الأساسية للأمن السيبراني» يجب أن\r\nتغطي متطلبات الأمن السيبراني الخاصة بإدارة أمن الشبكات لدى مقدمي الخدمات', NULL, 'CCC ٢-٤-م-١', 'Not Applicable', 38, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(577, 'CCC ٢-٤-م-١-١', 'CCC ٢-٤-م-١-١', 'مراقبة الشبكات الداخلية والخارجية للكشف عن الأنشطة المشبوهة', NULL, 'CCC ٢-٤-م-١-١', 'Not Applicable', 38, 1, NULL, NULL, NULL, 1, NULL, NULL, 576, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(578, 'CCC ٢-٤-م-١-٢', 'CCC ٢-٤-م-١-٢', 'عزل وحماية الشبكة الخاصة بالأنظمة التقنية السحابية (015) من الشبكات\r\nالأخرى الداخلية والخارجية', NULL, 'CCC ٢-٤-م-١-٢', 'Not Applicable', 38, 1, NULL, NULL, NULL, 1, NULL, NULL, 576, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(579, 'CCC ٢-٤-م-١-٣', 'CCC ٢-٤-م-١-٣', 'الحماية من هجمات تعطيل الخدمات ((6٥(ا)‏ 567166 ه لمنصء(). وهجمات\r\nتعطيل الخدمات الموزعة', NULL, 'CCC ٢-٤-م-١-٣', 'Not Applicable', 38, 1, NULL, NULL, NULL, 1, NULL, NULL, 576, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(580, 'CCC ٢-٤-م-١-٤', 'CCC ٢-٤-م-١-٤', 'CCC  استخدام التشفير للبيانات المنتقلة عبر الشبكة من وإلى الشبكة الخاصة بالأنظمة التقنية السحابية (015) لعمليات الوصول الإشرافي والإداري', NULL, 'CCC ٢-٤-م-١-٤', 'Not Applicable', 38, 1, NULL, NULL, NULL, 1, NULL, NULL, 576, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(581, 'CCC ٢-٤-م-١-٥', 'CCC ٢-٤-م-١-٥', 'التحكم في الوصول ) بين أجزاء الشبكة\r\n‎)٦‏ المختلفة', NULL, 'CCC ٢-٤-م-١-٥', 'Not Applicable', 38, 1, NULL, NULL, NULL, 1, NULL, NULL, 576, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(582, 'CCC ٢-٤-م-١-٦', 'CCC ٢-٤-م-١-٦', 'العزل بين شبكات الخدمات السحابية )نع 567166 نها) وشبكات\r\nالإدارة السحابية (صعصععةصة1 01008) والشبكة الداخلية مقدم الخدمة', NULL, 'CCC ٢-٤-م-١-٦', 'Not Applicable', 38, 1, NULL, NULL, NULL, 1, NULL, NULL, 576, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(583, 'CCC ٢-٤-ش-١', 'CCC ٢-٤-ش-١', 'بالإضافة للضوابط الفرعية ضمن الضابط ‎٢-٥-٢‏ في الضوابط الأساسية للأمن السيبراني. يجب أن\r\nتغطي متطلبات الأمن السيبراني الخاصة بإدارة أمن الشبكات لدى المشتركين', NULL, 'CCC ٢-٤-ش-١', 'Not Applicable', 38, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(584, 'CCC ٢-٤-ش-1-١', 'CCC ٢-٤-ش-1-١', 'حماية القناة المستخدمة للاتصال الشبكي مع مقدم الخدمة.', NULL, 'CCC ٢-٤-ش-1-١', 'Not Applicable', 38, 1, NULL, NULL, NULL, 1, NULL, NULL, 583, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(585, 'CCC ٢-٥-م-١', 'CCC ٢-٥-م-١', 'بالإضافة للضوابط الفرعية ضمن الضابط ‎٢-٦-٢‏ في الضوابط الأساسية للأمن السيبراني. يجب أن\r\nتغطي متطلبات الأمن السيبراني الخاصة بأمن الأجهزة المحمولة لدى مقدمي الخدمات', NULL, 'CCC ٢-٥-م-١', 'Not Applicable', 39, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(586, 'CCC ٢-٥-م-١-١', 'CCC ٢-٥-م-١-١', 'الاحتفاظ بقائمة جرد محدثة (Inventory) للأجهزة المحمولة', NULL, 'CCC ٢-٥-م-١-١', 'Not Applicable', 39, 1, NULL, NULL, NULL, 1, NULL, NULL, 585, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(587, 'CCC ٢-٥-م-١-٢', 'CCC ٢-٥-م-١-٢', 'الإدارة الأمنية للأجهزة المحمولةement Device M21) مركزيا', NULL, 'CCC ٢-٥-م-١-٢', 'Not Applicable', 39, 1, NULL, NULL, NULL, 1, NULL, NULL, 585, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(588, 'CCC ٢-٥-م-١-٣', 'CCC ٢-٥-م-١-٣', 'قفل الشاشة لأجهزة المستخدمين', NULL, 'CCC ٢-٥-م-١-٣', 'Not Applicable', 39, 1, NULL, NULL, NULL, 1, NULL, NULL, 585, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(589, 'CCC ٢-٥-م-١-4', 'CCC ٢-٥-م-١-4', 'قبل إعادة استخدام الأجهزة المحمولة أو التخلص منها! خصوصًا التي يتم\r\nاستخدامها للدخول على الأنظمة التقنية السحابية (015)؛ يجب التأكد من\r\nعدم احتوائها على أية بيانات أو معلومات باستخدام وسائل آمنة', NULL, 'CCC ٢-٥-م-١-4', 'Not Applicable', 39, 1, NULL, NULL, NULL, 1, NULL, NULL, 585, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(590, 'CCC ٢-٥-ش-١', 'CCC ٢-٥-ش-١', 'بالإضافة للضوابط الفرعية ضمن الضابط ‎٢-٦-٢‏ في الضوابط الأساسية للأمن السيبراني. يجب أن\r\nتغطي متطلبات الأمن السيبراني الخاصة بأمن الأجهزة المحمولة لدى المشتركين', NULL, 'CCC ٢-٥-ش-١', 'Not Applicable', 39, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(591, 'CCC ٢-٥-ش۔١-١', 'CCC ٢-٥-ش۔١-١', 'قبل إعادة استخدام الأجهزة المحمولة أو التخلص منها! خصوصًا التي يتم\r\nاستخدامها للدخول على الخدمات السحابية. يجب التأكد من عدم احتوائها\r\nعلى أية بيانات أو معلومات باستخدام وسائل آمنة.', NULL, 'CCC ٢-٥-ش۔١-١', 'Not Applicable', 39, 1, NULL, NULL, NULL, 1, NULL, NULL, 590, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(592, 'CCC ٢-٦-م-١', 'CCC ٢-٦-م-١', 'بالإضافة للضوابط الفرعية ضمن الضابط ‎٣-٧-٢‏ في الضوابط الأساسية للأمن السيبراز\r\nتغطي متطلبات الأمن السيبراني الخاصة بحماية البيانات والمعلومات لدى مقدمي الخدمة', NULL, 'CCC ٢-٦-م-١', 'Not Applicable', 40, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(593, 'CCC ٢-٦-م-١-١', 'CCC ٢-٦-م-١-١', 'عدم استخدام بيانات الأنظمة التقنية السحابية (75©) في غير بيئة الإنتاج\r\n)ج «مناءه0:00) إلا بعد استخدام ضوابط مشددة لحماية\r\nتلك البيانات مثل => تقنيات تعتيم البيانات (ع«ن81ه134 ها) أو تقنيات مزج\r\ning D', NULL, 'CCC ٢-٦-م-١-١', 'Not Applicable', 40, 1, NULL, NULL, NULL, 1, NULL, NULL, 592, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(594, 'CCC ٢-٦-م-١-٢', 'CCC ٢-٦-م-١-٢', 'تزويد المشتركين بعمليات وإجراءات وتقنيات آمنة لتخزين البيانات» مع الالتزام\r\nبالمتطلبات التشريعية والتنظيمية ذات العلاقة', NULL, 'CCC ٢-٦-م-١-٢', 'Not Applicable', 40, 1, NULL, NULL, NULL, 1, NULL, NULL, 592, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(595, 'CCC ٢۔٦-م-١-٣', 'CCC ٢۔٦-م-١-٣', 'حذف وإتلاف بيانات المشترك بطرق آمنة عند الانتهاء من العلاقة مع المشترك', NULL, 'CCC ٢۔٦-م-١-٣', 'Not Applicable', 40, 1, NULL, NULL, NULL, 1, NULL, NULL, 592, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(596, 'CCC ٢-٦-م-۔١-٤', 'CCC ٢-٦-م-۔١-٤', 'الالتزام بالمحافظة على سرية بيانات ومعلومات ابلشترك. حسب المتطلبات\r\nالتشريعية والتنظيمية ذات العلاقة.', NULL, 'CCC  ٢-٦-م-۔١-٤', 'Not Applicable', 40, 1, NULL, NULL, NULL, 1, NULL, NULL, 592, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(597, 'CCC ٢-٦-م-١-٥', 'CCC ٢-٦-م-١-٥', 'تزويد المشتركين بوسائل آمنة لتصدير ونقل البيانات والبنية التحتية الافتراضية.', NULL, 'CCC ٢-٦-م-١-٥', 'Not Applicable', 40, 1, NULL, NULL, NULL, 1, NULL, NULL, 592, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(598, 'CCC ٢-٦-ش-١', 'CCC ٢-٦-ش-١', 'بالإضافة للضوابط الفرعية ضمن الضابط ‎٣-٧-٢‏ في الضوابط الأساسية للأمن السيبراني. يجب\r\n\r\nأن تغطي متطلبات الأمن السيبراني الخاصة بحماية بيانات و معلومات المشتركين في الحوسبة\r\nالسحابية', NULL, 'CCC ٢-٦-ش-١', 'Not Applicable', 40, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(599, 'CCC ٢-٦-ش۔١-١‏', 'CCC ٢-٦-ش۔١-١‏', 'وجود ضمانات للقدرة على حذف البيانات بطرق آمنة عند الانتهاء من العلاقة\r\nمع مقدم الخدمة', NULL, 'CCC ٢-٦-ش۔١-١‏', 'Not Applicable', 40, 1, NULL, NULL, NULL, 1, NULL, NULL, 598, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(600, 'CCC ٢-٦-ش۔١۔٢', 'CCC ٢-٦-ش۔١۔٢', 'استخدام وسائل آمنة لتصدير ونقل البيانات والبنية التحتية الافتراضية.', NULL, 'CCC ٢-٦-ش۔١۔٢', 'Not Applicable', 40, 1, NULL, NULL, NULL, 1, NULL, NULL, 598, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(601, 'CCC ٢-٧-م-١', 'CCC ٢-٧-م-١', 'بالإضافة للضوابط الفرعية ضمن الضابط 7-8-7 في الضوابط الأساسية للأمن السيبراني. يجب أن\r\nتغطي متطلبات الأمن السيبراني الخاصة بالتشفير لدى مقدمي الخدمات', NULL, 'CCC ٢-٧-م-١', 'Not Applicable', 41, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(602, 'CCC ٢-٧-م-١-١', 'CCC ٢-٧-م-١-١', 'لالتزام باستخدام طرق وخوارزميات ومفاتيح وأجهزة تشفير محدثة وآمنة.\r\nوفقا للمستوى المتقدم (ععصة٧4ه)‏ ضمن المعايير الوطنية للتشفير', NULL, 'CCC ٢-٧-م-١-١', 'Not Applicable', 41, 1, NULL, NULL, NULL, 1, NULL, NULL, 601, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(603, 'CCC ٢-٧-م-١۔٢', 'CCC ٢-٧-م-١۔٢', 'لقدرة على إصدار شهادات رقمية وإدارتها بطرق آمنة. أو استخدام شهادات\r\nرقمية صادرة من جهات موثوقة', NULL, 'CCC ٢-٧-م-١۔٢', 'Not Applicable', 41, 1, NULL, NULL, NULL, 1, NULL, NULL, 601, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(604, 'CCC ٢-٧-ش-١', 'CCC ٢-٧-ش-١', 'بالإضافة للضوابط الفرعية ضمن الضابط ‎٢-٨-٢‏ في الضوابط الأساسية للأمن السيبراني. يجب أن\r\nتغطي متطلبات الأمن السيبراني الخاصة بالتشفير لدى المشتركين', NULL, 'CCC ٢-٧-ش-١', 'Not Applicable', 41, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(605, 'CCC ٢-٧-ش۔١-١', 'CCC ٢-٧-ش۔١-١', 'الالتزام باستخدام طرق وخوارزميات ومفاتيح وأجهزة تشفير محدثة وآمنة.\r\nوفقا للمستوى المتقدم (لععصه٧4ه)‏ ضمن المعايير الوطنية للتشفير', NULL, 'CCC ٢-٧-ش۔١-١', 'Not Applicable', 41, 1, NULL, NULL, NULL, 1, NULL, NULL, 604, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(606, 'CCC ٢-٧-ش۔١۔٢', 'CCC ٢-٧-ش۔١۔٢', 'تشفير البيانات والمعلومات المنقولة إلى الخدمات السحابية. أو المنقولة منها!\r\nبحسب المتطلبات التشريعية والتنظيمية ذات العلاقة.', NULL, 'CCC ٢-٧-ش۔١۔٢', 'Not Applicable', 41, 1, NULL, NULL, NULL, 1, NULL, NULL, 604, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(607, 'CCC ٢-٨-م-١', 'CCC ٢-٨-م-١', 'بالإضافة للضوابط الفرعية ضمن الضابط ‎ في الضوابط الأساسية للأمن السيبراني. يجب أن\r\nتغطي متطلبات الأمن السيبراني الخاصة بإدارة النسخ الاحتياطية لدى مقدمي الخدمات', NULL, 'CCC ٢-٨-م-١', 'Not Applicable', 42, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(608, 'CCC ٢-٨-م-١-١', 'CCC ٢-٨-م-١-١', 'تأمين الوصول\" والتخزين\" والنقل لمحتوى النسخ الاحتياطية لبيانات المشترك\r\nووسائطهاء وحمايتها من الإتلاف. أو التعديل. أو الاطلاع غير المصرح به', NULL, 'CCC ٢-٨-م-١-١', 'Not Applicable', 42, 1, NULL, NULL, NULL, 1, NULL, NULL, 607, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(609, 'CCC ٢-٨-م-١۔٢', 'CCC ٢-٨-م-١۔٢', 'أمين الوصول\" والتخزين\" والنقل لمحتوى النسخ الاحتياطية للأنظمة التقنية\r\nالسحابية (015)؛ ووسائطها. وحمايتها من الإتلاف. أو التعديل. أو الاطلاع غير\r\nالمصرح به', NULL, 'CCC ٢-٨-م-١۔٢', 'Not Applicable', 42, 1, NULL, NULL, NULL, 1, NULL, NULL, 607, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(610, 'CCC ٢-٩-م-١', 'CCC ٢-٩-م-١', 'بالإضافة للضوابط الفرعية ضمن الضابط ‎٢-١٠-٢‏ في الضوابط الأساسية للأمن السيبراني» يجب أن\r\nتغطي متطلبات الأمن السيبراني الخاصة بإدارة الثغرات لدى مقدمي الخدمات\"', NULL, 'CCC ٢-٩-م-١', 'Not Applicable', 43, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(611, 'CCC ٢-٩-م-١-١', 'CCC ٢-٩-م-١-١', 'تقييم ومعالجة الثغرات لمكونات الأنظمة التقنية السحابية (015) الخارجية\r\nمرة واحدة شهريا على الأقل. وكل ثلاثة أشهر على الأقل لمكونات الأنظمة\r\nالتقنية السحابية (015) الداخلية.', NULL, 'CCC ٢-٩-م-١-١', 'Not Applicable', 43, 1, NULL, NULL, NULL, 1, NULL, NULL, 610, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(612, 'CCC ٢-٩-م-١-٢', 'CCC ٢-٩-م-١-٢', 'إشعار المشترك بالثغرات المكتشفة التي قد تؤثر عليه. وكيفية معالجتها', NULL, 'CCC ٢-٩-م-١-٢', 'Not Applicable', 43, 1, NULL, NULL, NULL, 1, NULL, NULL, 610, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(613, 'CCC ٢-٩-ش-١', 'CCC ٢-٩-ش-١', 'بالإضافة للضوابط الفرعية ضمن الضابط ‎٢-١٠-٢‏ في الضوابط الأساسية للأمن السيبراني» يجب أن\r\nتغطي متطلبات الأمن السيبراني الخاصة بإدارة الثغرات لدى المشتركين', NULL, 'CCC ٢-٩-ش-١', 'Not Applicable', 43, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(614, 'CCC ٢-٩-ش-١-١', 'CCC ٢-٩-ش-١-١', 'تقييم ومعالجة الثغرات الخاصة بالخدمات السحابية مرة واحدة كل ثلاثة أشهر\r\nعلى الأقل.', NULL, 'CCC ٢-٩-ش-١-١', 'Not Applicable', 43, 1, NULL, NULL, NULL, 1, NULL, NULL, 613, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(615, 'CCC ٢-٩-ش۔١۔٢', 'CCC ٢-٩-ش۔١۔٢', 'إدارة الثغرات التي تم إشعار المشترك بها عن طريق مقدم الخدمة. ومعالجتها', NULL, 'CCC ٢-٩-ش۔١۔٢', 'Not Applicable', 43, 1, NULL, NULL, NULL, 1, NULL, NULL, 613, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(616, 'CCC ٢-١٠-م-١', 'CCC ٢-١٠-م-١', 'الإضافة للضوابط الفرعية ضمن الضابط ‎٣-١١-٢‏ في الضوابط الأساسية للأمن السيبراني» يجب\r\nأن تغطي متطلبات الأمن السيبراني الخاصة باختبار الاختراق لدى مقدمي الخدمات', NULL, 'CCC ٢-١٠-م-١', 'Not Applicable', 44, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(617, 'CCC ٢-١٠-م-١-١', 'CCC ٢-١٠-م-١-١', 'يجب أن يشمل نطاق عمل اختبار الاختراق الأنظمة التقنية السحابية (015)»\r\nوأن يتم عمل اختبار الاختراق كل ستة أشهر؛ على الأقل.', NULL, 'CCC ٢-١٠-م-١-١', 'Not Applicable', 44, 1, NULL, NULL, NULL, 1, NULL, NULL, 616, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(618, 'CCC ٢-١١-م-١', 'CCC ٢-١١-م-١', 'بالإضافة للضوابط الفرعية ضمن الضابط ‎٣-١٢-٢‏ في الضوابط الأساسية للأمن السيبراني» يجب\r\n\r\nأن تغطي متطلبات الأمن السيبراني لإدارة سجلات الأحداث ومراقبة الأمن السيبراني لدى مقدمي\r\nالخدمات', NULL, 'CCC ٢-١١-م-١', 'Not Applicable', 45, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(619, 'CCC ٢-١١-م-١-١', 'CCC ٢-١١-م-١-١', 'تفعيل وحماية سجلات الأحداث ‎1٥8(‏ اصعءع) والتدقيق للف انهنه)\r\nللأنظمة التقنية السحابية', NULL, 'CCC ٢-١١-م-١-١', 'Not Applicable', 45, 1, NULL, NULL, NULL, 1, NULL, NULL, 618, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(620, 'CCC ٢-١١-م-١-٢', 'CCC ٢-١١-م-١-٢', 'تفعيل سجلات الأحداث الخاصة محاولات عمليات الدخول (صنع10) وجمعها.', NULL, 'CCC ٢-١١-م-١-٢', 'Not Applicable', 45, 1, NULL, NULL, NULL, 1, NULL, NULL, 618, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(621, 'CCC ٢-١١-م-١-٣', 'CCC ٢-١١-م-١-٣', 'تفعيل وحماية سجلات الأحداث لجميع الأنشطة والعمليات التي يقوم بها\r\nمقدم الخدمة على أنظمة المشتركين. بهدف دعم عمليات التحليل الرقمي\r\nالجناني', NULL, 'CCC ٢-١١-م-١-٣', 'Not Applicable', 45, 1, NULL, NULL, NULL, 1, NULL, NULL, 618, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(622, 'CCC ٢-١١-م-١-٤', 'CCC ٢-١١-م-١-٤', 'حماية سجلات الأحداث (1088 صءه2) الخاصة بالأمن السيبراني. من الوصول\r\nغير المصرح به. أو العبث. أو التغيير. أو الحذف غير المشروع. وذلك وفقا\r\nللمتطلبات التشريعية. أو التنظيمية', NULL, 'CCC ٢-١١-م-١-٤', 'Not Applicable', 45, 1, NULL, NULL, NULL, 1, NULL, NULL, 618, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(623, 'CCC ٢-١١۔م-١-٥', 'CCC ٢-١١۔م-١-٥', 'للمراقبة الأمنية المستمرة لأحداث الأمن السييراني )ص رح(\r\nباستخدام تقنيات (51814) بحيث تشمل جميع الأحداث المتعلقة بالأنظمة\r\nالتقنية السحابية', NULL, 'CCC ٢-١١۔م-١-٥', 'Not Applicable', 45, 1, NULL, NULL, NULL, 1, NULL, NULL, 618, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(624, 'CCC ٢-١١۔م-١-٦', 'CCC ٢-١١۔م-١-٦', 'المراجعة الدورية لسجلات الأحداث (1685 27604) والتدقيق (لنهع7 نهسه)\r\nبحيث تشمل الأحداث والسجلات المتعلقة بالأنظمة التقنية السحابية (75©)»\r\nالتي تم تنفيذها من قبل مقدم الخدمة', NULL, 'CCC ٢-١١۔م-١-٦', 'Not Applicable', 45, 1, NULL, NULL, NULL, 1, NULL, NULL, 618, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(625, 'CCC ٢-١١۔م-١-٧', 'CCC ٢-١١۔م-١-٧', 'ستخدام وسائل آلية لمراقبة سجلات الأحداث الخاصة بعمليات الدخول', NULL, 'CCC ٢-١١۔م-١-٧', 'Not Applicable', 45, 1, NULL, NULL, NULL, 1, NULL, NULL, 618, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(626, 'CCC ٢-١١۔م-١-٨‏', 'CCC ٢-١١۔م-١-٨‏', 'تعامل الآمن مع بيانات المستخدمين المتواجدة في سجلات الأحداث\r\n‎]Logs Events Cybersecurity. والتدقيق (فلنه 1 انهنه) وسجلات أحداث الأمن السيبراني', NULL, 'CCC ٢-١١۔م-١-٨‏', 'Not Applicable', 45, 1, NULL, NULL, NULL, 1, NULL, NULL, 618, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(627, 'CCC ٢-١١-ش-١', 'CCC ٢-١١-ش-١', 'بالإضافة للضوابط الفرعية ضمن الضابط ‎٢-١٢-٢‏ في الضوابط الأساسية للأمن السيبراني» يجب أن\r\nتغطي متطلبات الأمن السيبراني لإدارة سجلات الأحداث ومراقبة الأمن السيبراني لدى المشتركين', NULL, 'CCC ٢-١١-ش-١', 'Not Applicable', 45, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(628, 'CCC ٢-١١-ش-١-١', 'CCC ٢-١١-ش-١-١', 'تفعيل وجمع سجلات الأحداث الخاصة بعمليات الدخول (صنهه])» وسجلات\r\nالأحداث الخاصة بالأمن السيبراني على الأصول المتعلقة بالخدمات السحابية.', NULL, 'CCC ٢-١١-ش-١-١', 'Not Applicable', 45, 1, NULL, NULL, NULL, 1, NULL, NULL, 627, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(629, 'CCC ٢-١١-ش۔١۔٢', 'CCC ٢-١١-ش۔١۔٢', 'أن تشمل عملية المراقبة جميع الأحداث أحداث الأمن السيبراني المفعلة على\r\nالخدمات السحابية الخاصة بالمشترك', NULL, 'CCC ٢-١١-ش۔١۔٢', 'Not Applicable', 45, 1, NULL, NULL, NULL, 1, NULL, NULL, 627, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(630, 'CCC ٢-١٢-م-١', 'CCC ٢-١٢-م-١', 'بالإضافة للضوابط الفرعية ضمن الضابط ‎٢-١٣-٢‏ في الضوابط الأساسية للأمن السيبراني» يجب أن\r\nتغطي متطلبات الأمن السيبراني لإدارة حوادث وتهديدات الأمن السيبراني لدى مقدمي الخدمات.', NULL, 'CCC ٢-١٢-م-١', 'Not Applicable', 46, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(631, 'CCC ٢-١٢-م-١-1', 'CCC ٢-١٢-م-١-1', 'الاشتراك مع المجموعات والجهات المتخصصة والموثوقة للحصول على آخر\r\nالتهديدات والمستجدات في مجال الأمن السيبراني', NULL, 'CCC ٢-١٢-م-١-1', 'Not Applicable', 46, 1, NULL, NULL, NULL, 1, NULL, NULL, 630, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(632, 'CCC ٢-١٢-م-١-2', 'CCC ٢-١٢-م-١-2', 'تدريب العاملين (موظفين ومتعاقدين) على الاستجابة لحوادث الأمن السيبراني\r\nيما يتماثى مع الأدوار والمسؤوليات', NULL, 'CCC ٢-١٢-م-١-2', 'Not Applicable', 46, 1, NULL, NULL, NULL, 1, NULL, NULL, 630, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(633, 'CCC ٢-١٢-م-١-3', 'CCC ٢-١٢-م-١-3', 'اختبار قدرات الاستجابة لحوادث الأمن السيبراني دوريًا', NULL, 'CCC ٢-١٢-م-١-3', 'Not Applicable', 46, 1, NULL, NULL, NULL, 1, NULL, NULL, 630, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(634, 'CCC ٢-١٢-م-١-4', 'CCC ٢-١٢-م-١-4', 'تحليل وتحديد الأسباب الجذرية (و¡درلةمه عقنة0 ٥0ع)‏ لحوادث الأمن\r\nالسيبراني. ووضع الخطط الكفيلة بمعالجتها.', NULL, 'CCC ٢-١٢-م-١-4', 'Not Applicable', 46, 1, NULL, NULL, NULL, 1, NULL, NULL, 630, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(635, 'CCC ٢-١٢-م-١-5', 'CCC ٢-١٢-م-١-5', 'تقديم الدعم إلى المشتركين في حالات القضايا القانونية. والتحليل الرقمي الجناني.\r\nوالحفاظ على الأدلة الرقمية التي تقع تحت إدارة ومسؤولية مقدم الخدمة\r\nحسب المتطلبات التشريعية والتنظيمية ذات العلاقة', NULL, 'CCC ٢-١٢-م-١-5', 'Not Applicable', 46, 1, NULL, NULL, NULL, 1, NULL, NULL, 630, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(636, 'CCC ٢-١٢-م-١-6', 'CCC ٢-١٢-م-١-6', 'تبليغ المشترك بشكل فوري عن حوادث الأمن السيبراني التي قد تؤثر عليه. في\r\nحال اكتشاف الحادثة', NULL, 'CCC ٢-١٢-م-١-6', 'Not Applicable', 46, 1, NULL, NULL, NULL, 1, NULL, NULL, 630, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(637, 'CCC ٢-٢١-م-١-٧', 'CCC ٢-٢١-م-١-٧', 'دعم المشتركين للتعامل مع حوادث الأمن السيبراني حسب الاتفاقية مابين مقدم\r\nالخدمة والمشترك.', NULL, 'CCC ٢-٢١-م-١-٧', 'Not Applicable', 46, 1, NULL, NULL, NULL, 1, NULL, NULL, 630, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(638, 'CCC ٢-١٢-م-١-8', 'CCC ٢-١٢-م-١-8', 'قياس ومراقبة مؤشرات الأداء الخاصة بإدارة حوادث الأمن السيراني. ومراقبة\r\nمدى الالتزام بمتطلبات العقود والتشريعات', NULL, 'CCC ٢-١٢-م-١-8', 'Not Applicable', 46, 1, NULL, NULL, NULL, 1, NULL, NULL, 630, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(639, 'CCC ٢-١٣-م-1', 'CCC ٢-١٣-م-1', 'بالإضافة للضوابط الفرعية ضمن الضابط ‎٢-١٤-٢‏ في الضوابط الأساسية للأمن السيبراني» يجب أن\r\nتغطي متطلبات الأمن السيبراني الخاصة بالأمن المادي لدى مقدمي الخدمات', NULL, 'CCC ٢-١٣-م-1', 'Not Applicable', 47, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(640, 'CCC ٢-١٣-م-١-١', 'CCC ٢-١٣-م-١-١', 'للمراقبة المستمرة لعمليات الدخول والخروج للمباني والمواقع لدى مقدم الخدمة.', NULL, 'CCC ٢-١٣-م-١-١', 'Not Applicable', 47, 1, NULL, NULL, NULL, 1, NULL, NULL, 639, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(641, 'CCC ٢-١٣-م-١-٢', 'CCC ٢-١٣-م-١-٢', 'منع الوصول غير المصرح به للأجهزة التي تتعامل مباشرة مع الأنظمة التقنية\r\nالسحابية', NULL, 'CCC ٢-١٣-م-١-٢', 'Not Applicable', 47, 1, NULL, NULL, NULL, 1, NULL, NULL, 639, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(642, 'CCC ٢-١٣-م-١-٣', 'CCC ٢-١٣-م-١-٣', 'التخلص الآمن من أجهزة البنية التحتية )4 «\r\n) باتباع أفضل الممارسات\r\nوالتشريعات ذات العلاقة', NULL, 'CCC ٢-١٣-م-١-٣', 'Not Applicable', 47, 1, NULL, NULL, NULL, 1, NULL, NULL, 639, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(643, 'CCC ٢-١٤-م-١', 'CCC ٢-١٤-م-١', 'بالإضافة للضوابط الفرعية ضمن الضابط ‎٣-١٥-٢‏ في الضوابط الأساسية للأمن السيبراني» يجب أن\r\nتغطي متطلبات الأمن السيبراني الخاصة بحماية تطبيقات الويب لدى مقدمي الخدمات', NULL, 'CCC ٢-١٤-م-١', 'Not Applicable', 48, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(644, 'CCC ٢-١٤-م-١-١', 'CCC ٢-١٤-م-١-١', 'حماية المعلومات المستخدمة في إجراء المعاملات عن طريق تطبيقات الويب\r\nمن المخاطر المحتملة. مثل => انقطاع الاتصال )ممن «\r\nالتوجيه الخاطئ (ع018-20010). التعديل غير المصرح به. الاطلاع غير المصرح\r\nبه.', NULL, 'CCC ٢-١٤-م-١-١', 'Not Applicable', 48, 1, NULL, NULL, NULL, 1, NULL, NULL, 643, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(645, 'CCC ٢-١٥-م-١', 'CCC ٢-١٥-م-١', 'يجب تحديد وتوثيق واعتماد متطلبات الأمن السيبراني. الخاصة بعملية إدارة المفاتيح لدى\r\nمقدمي الخدمات.', NULL, 'CCC ٢-١٥-م-١', 'Not Applicable', 121, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(646, 'CCC ٢-١٥-م-٢', 'CCC ٢-١٥-م-٢', 'يجب تطبيق متطلبات الأمن السيبراني. الخاصة بعملية إدارة المفاتيح لدى مقدمي الخدمات', NULL, 'CCC ٢-١٥-م-٢', 'Not Applicable', 121, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(647, 'CCC ٢-١٥-م-٣', 'CCC ٢-١٥-م-٣', 'الإضافة للضابط ‎٢-٢-٨-٢‏ في الضوابط الأساسية للأمن السيبراني. يجب أن تغطي متطلبات الأمن\r\nالسيبراني الخاصة بعملية إدارة المفاتيح لدى مقدمي الخدمات', NULL, 'CCC ٢-١٥-م-٣', 'Not Applicable', 121, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(648, 'CCC ٢-١٥-م-٣-١', 'CCC ٢-١٥-م-٣-١', 'تحديد ملاك مفاتيح التشفير', NULL, 'CCC ٢-١٥-م-٣-١', 'Not Applicable', 121, 1, NULL, NULL, NULL, 1, NULL, NULL, 647, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(649, 'CCC ٢-١٥-م-٣-2', 'CCC ٢-١٥-م-٣-2', 'جود آلية آمنة لاسترجاع مفاتيح التشفير في حال فقدانها مثل => (نسخها احتياطيًا\r\nوتخزينها بطرق آمنة خارج الأنظمة السحابية).', NULL, 'CCC ٢-١٥-م-٣-2', 'Not Applicable', 121, 1, NULL, NULL, NULL, 1, NULL, NULL, 647, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(650, 'CCC ٢-١٥-م-٣-3', 'CCC ٢-١٥-م-٣-3', 'تفعيل سجلات الأحداث المتعلقة بمفاتيح التشفير. ومراقبتها', NULL, 'CCC ٢-١٥-م-٣-3', 'Not Applicable', 121, 1, NULL, NULL, NULL, 1, NULL, NULL, 647, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(651, 'CCC ٢-١٥-م-٤', 'CCC ٢-١٥-م-٤', 'يجب مراجعة متطلبات الأمن السيبراني. الخاصة بإدارة المفاتيح لدى مقدمي الخدمات. ومراجعة\r\nتطبيقها دوريا', NULL, 'CCC ٢-١٥-م-٤', 'Not Applicable', 121, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(652, 'CCC ٢-١٥-ش-١', 'CCC ٢-١٥-ش-١', 'يجب تحديد وتوثيق واعتماد متطلبات الأمن السيبراني. الخاصة بإدارة المفاتيح لدى المشتركين.', NULL, 'CCC ٢-١٥-ش-١', 'Not Applicable', 121, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(653, 'CCC ٢-١٥-ش-٢', 'CCC ٢-١٥-ش-٢', 'يجب تطبيق متطلبات الأمن السييراني. الخاصة بإدارة المفاتيح لدى المشتركين.', NULL, 'CCC ٢-١٥-ش-٢', 'Not Applicable', 121, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(654, 'CCC ٢-١٥-ش-3', 'CCC ٢-١٥-ش-3', 'بالإضافة للضابط ‎٢-٢-٨-٢‏ في الضوابط الأساسية للأمن السيبراني. يجب أن تغطي متطلبات الأمن\r\nالسيبراني. الخاصة بعملية إدارة المفاتيح لدى المشتركين', NULL, 'CCC ٢-١٥-ش-3', 'Not Applicable', 121, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(655, 'CCC ٢-١٥-ش-٣-١', 'CCC ٢-١٥-ش-٣-١', 'تحديد ملاك مفاتيح التشفير', NULL, 'CCC ٢-١٥-ش-٣-١', 'Not Applicable', 121, 1, NULL, NULL, NULL, 1, NULL, NULL, 654, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(656, 'CCC ٢-١٥-ش-٣-٢', 'CCC ٢-١٥-ش-٣-٢', 'وجود آلية آمنة لاسترجاع مفاتيح التشفير في حال فقدانها مثل => (نسخها احتياطيا\r\nوتخزينها بطرق آمنة خارج الأنظمة السحابية', NULL, 'CCC ٢-١٥-ش-٣-٢', 'Not Applicable', 121, 1, NULL, NULL, NULL, 1, NULL, NULL, 654, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(657, 'CCC ٢-١٥-ش-٤', 'CCC ٢-١٥-ش-٤', 'يجب مراجعة متطلبات الأمن السيبراني الخاصة بإدارة المفاتيح لدى المشتركين. ومراجعة تطبييقهاء\r\nدوريا.', NULL, 'CCC ٢-١٥-ش-٤', 'Not Applicable', 121, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(658, 'CCC ٢-١٦-م-١', 'CCC ٢-١٦-م-١', 'يجب تحديد متطلبات الأمن السيبراني لتطوير الأنظمة لدى مقدمي الخدمات. وتوثيقها\r\nواعتمادها.\r\nيجب تطبي', NULL, 'CCC ٢-١٦-م-١', 'Not Applicable', 123, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(659, 'CCC ٢-١٦-م-٢', 'CCC ٢-١٦-م-٢', 'يجب تطبيق متطلبات الأمن السيبراني لتطوير الأنظمة لدى مقدمي الخدمات.', NULL, 'CCC ٢-١٦-م-٢', 'Not Applicable', 123, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(660, 'CCC ٢-١٦-م-٣', 'CCC ٢-١٦-م-٣', 'يجب أن تغطي متطلبات الأمن السيبراني لتطوير الأنظمة لدى مقدمي الخدمات', NULL, 'CCC ٢-١٦-م-٣', 'Not Applicable', 123, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(661, 'CCC ٢-١٦-م-٣-١', 'CCC ٢-١٦-م-٣-١', 'أخذ متطلبات الأمن السيبراني (للأنظمة التقنية السحابية (015) والأنظمة\r\nذات العلاقة) بالاعتبار عند تصميم وتطوير خدمات الحوسبة السحابية.', NULL, 'CCC ٢-١٦-م-٣-١', 'Not Applicable', 123, 1, NULL, NULL, NULL, 1, NULL, NULL, 660, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(662, 'CCC ٢-١٦-م-٣-٢', 'CCC ٢-١٦-م-٣-٢', 'حماية بيئات للتطوير )ents Development ) والاختبار\r\n)ن منعآ) وماتحويه من بيانات. ومنصات التكامل', NULL, 'CCC ٢-١٦-م-٣-٢', 'Not Applicable', 123, 1, NULL, NULL, NULL, 1, NULL, NULL, 660, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(663, 'CCC ٢-١٦-م-4', 'CCC ٢-١٦-م-4', 'يجب مراجعة متطلبات الأمن السيبراني لتطوير الأنظمة لدى مقدمي الخدمات. ومراجعة\r\nتطبيقها. دوريا', NULL, 'CCC ٢-١٦-م-4', 'Not Applicable', 123, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(664, 'CCC ٢-١٧-م-١', 'CCC ٢-١٧-م-١', 'يجب تحديد وتوثيق واعتماد متطلبات الأمن السيبراني لاستخدام وسائط المعلومات والبيانات\r\nالمادية لدى مقدمي الخدمات.', NULL, 'CCC ٢-١٧-م-١', 'Not Applicable', 124, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(665, 'CCC ٢-١٧-م-٢', 'CCC ٢-١٧-م-٢', 'يجب تطبيق متطلبات الأمن السيبراني لاستخدام وسائط المعلومات والبيانات المادية لدى\r\nمقدمي الخدمات.', NULL, 'CCC ٢-١٧-م-٢', 'Not Applicable', 124, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(666, 'CCC ٢-١٧-م-٣', 'CCC ٢-١٧-م-٣', 'متطلبات الأمن السيبراني لاستخدام وسائط المعلومات والبيانات المادية لدى مقدمي الخدمات', NULL, 'CCC ٢-١٧-م-٣', 'Not Applicable', 124, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(667, 'CCC ٢-١٧-م-٣-١', 'CCC ٢-١٧-م-٣-١', 'يجب التأكد من عدم احتواء الوسائط على أية بيانات أو معلومات. قبل إعادة\r\nاستخدام الوسائط أو التخلص منها.', NULL, 'CCC ٢-١٧-م-٣-١', 'Not Applicable', 124, 1, NULL, NULL, NULL, 1, NULL, NULL, 666, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(668, 'CCC ٢-١٧-م-٣-٢', 'CCC ٢-١٧-م-٣-٢', 'يجب استخدام وسائل آمنة عند التخلص من الوسائط', NULL, 'CCC ٢-١٧-م-٣-٢', 'Not Applicable', 124, 1, NULL, NULL, NULL, 1, NULL, NULL, 666, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(669, 'CCC ٢-١٧-م-٣-٣', 'CCC ٢-١٧-م-٣-٣', 'الحفاظ على سرية وسلامة البيانات على أجهزة وسائط التخزين الخارجية.', NULL, 'CCC ٢-١٧-م-٣-٣', 'Not Applicable', 124, 1, NULL, NULL, NULL, 1, NULL, NULL, 666, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(670, 'CCC ٢-١٧-م-٣-٤', 'CCC ٢-١٧-م-٣-٤', 'وضع ترميز أو علامة (ع«نلكه1) مقروءة على الوسائط توضح تصنيفها ومدى\r\nحساسية المعلومات والبيانات التي تحتويها.', NULL, 'CCC ٢-١٧-م-٣-٤', 'Not Applicable', 124, 1, NULL, NULL, NULL, 1, NULL, NULL, 666, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(671, 'CCC ٢-١٧-م-٣-٥', 'CCC ٢-١٧-م-٣-٥', 'الحفظ الآمن لأجهزة وسائط التخزين الخارجية.', NULL, 'CCC ٢-١٧-م-٣-٥', 'Not Applicable', 124, 1, NULL, NULL, NULL, 1, NULL, NULL, 666, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(672, 'CCC ٢-١٧-م-٣-٦', 'CCC ٢-١٧-م-٣-٦', 'لتقييد الحازم لاستخدام وسائط التخزين الخارجية على الأنظمة التقنية\r\nالسحابية', NULL, 'CCC ٢-١٧-م-٣-٦', 'Not Applicable', 124, 1, NULL, NULL, NULL, 1, NULL, NULL, 666, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(673, 'CCC ٢-١٧-م-٤', 'CCC ٢-١٧-م-٤', 'يجب مراجعة متطلبات الأمن السيبراني لاستخدام وسائط المعلومات والبيانات المادية لدى\r\nمقدمي الخدمات\" ومراجعة تطبيقها دوريا.', NULL, 'CCC ٢-١٧-م-٤', 'Not Applicable', 124, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(674, 'CCC ٣-١-م-١', 'CCC ٣-١-م-١', 'بالإضافة للضوابط الفرعية ضمن الضابط ‎٣-١-٢‏ في الضوابط الأساسية للأمن السيبراني. يجب أن\r\nتغطي متطلبات الأمن السيبراني لجوانب صمود الأمن السيبراني في إدارة استمرارية الأعمال لدى\r\nمقدمي الخدمات', NULL, 'CCC ٣-١-م-١', 'Not Applicable', 49, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(675, 'CCC ٣-١-م-١-١', 'CCC ٣-١-م-١-١', 'تطوير وتنفيذ إجراءات التعافي من الكوارث واستمرارية الأعمال بصورة آمنة', NULL, 'CCC ٣-١-م-١-١', 'Not Applicable', 49, 1, NULL, NULL, NULL, 1, NULL, NULL, 674, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(676, 'CCC ٣-١-م-١-٢', 'CCC ٣-١-م-١-٢', 'تطوير وتنفيذ إجراءات لضمان صمود واستمرارية أنظمة الأمن السيبراني\r\nالمخصصة لحماية الأنظمة التقنية السحابي', NULL, 'CCC ٣-١-م-١-٢', 'Not Applicable', 49, 1, NULL, NULL, NULL, 1, NULL, NULL, 674, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(677, 'CCC ٣-١-ش-١', 'CCC ٣-١-ش-١', 'بالإضافة للضوابط الفرعية ضمن الضابط ‎٣-١-٢‏ في الضوابط الأساسية للأمن السيبراني. يجب أن\r\nتغطي متطلبات الأمن السيبراني لجوانب صمود الأمن السيبراني في إدارة استمرارية الأعمال لدى\r\nا مشتركين', NULL, 'CCC ٣-١-ش-١', 'Not Applicable', 49, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(678, 'CCC ٣-١-ش-١-١', 'CCC ٣-١-ش-١-١', 'تطوير وتنفيذ إجراءات التعافي من الكوارث واستمرارية الأعمال. المتعلقة\r\nبالحوسبة السحابية. بصورة آمنة.', NULL, 'CCC ٣-١-ش-١-١', 'Not Applicable', 49, 1, NULL, NULL, NULL, 1, NULL, NULL, 677, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(679, 'CCC ٤-١-م-١', 'CCC ٤-١-م-١', 'بالإضافة إلى تطبيق الضابطين ‎٢-١-٤‏ و ‎٢-١-٤‏ في الضوابط الأساسية للأمن السييراني. يجب أن\r\nتغطي متطلبات الأمن السيبراني المتعلق بالأطراف الخارجية لدى مقدمي الخدمات', NULL, 'CCC ٤-١-م-١', 'Not Applicable', 50, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(680, 'CCC ٤-١-م-١-١', 'CCC ٤-١-م-١-١', 'ضمان تنفيذ مقدم الخدمة لطلبات الهيئة الوطنية للأمن السيبراني الخاصة\r\nبإزالة البرمجيات أو الخدمات المقدمة من أطراف خارجية التي قد تعتبر تهديدا\r\nعلى الأمن السيبراني للجهات الوطنية. من السوق', NULL, 'CCC ٤-١-م-١-١', 'Not Applicable', 50, 1, NULL, NULL, NULL, 1, NULL, NULL, 679, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(681, 'CCC ٤-١-م-١-٢', 'CCC ٤-١-م-١-٢', 'طلب تقديم التوثيق (صمتاها«»«0000) اللازم! فيما يخص الأمن السيبراني؛\r\nلأي معدات أو خدمات مقدمة من الموردين ومقدمي الخدمات من الأطراف\r\nالخارجية.', NULL, 'CCC ٤-١-م-١-٢', 'Not Applicable', 50, 1, NULL, NULL, NULL, 1, NULL, NULL, 679, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(682, 'CCC ٤-١-م-١-٣', 'CCC ٤-١-م-١-٣', '‏ الزام الأطراف الخارجية بالمتطلبات التنظيمية؛ والتشريعية ذات الصلة بنطاق\r\nعملهم.', NULL, 'CCC ٤-١-م-١-٣', 'Not Applicable', 50, 1, NULL, NULL, NULL, 1, NULL, NULL, 679, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(683, 'CCC ٤-١-م-١-٤', 'CCC ٤-١-م-١-٤', 'يجب على الطرف الخارجي إدارة مخاطر الأمن السيبراني الخاصة به.', NULL, 'CCC ٤-١-م-١-٤', 'Not Applicable', 50, 1, NULL, NULL, NULL, 1, NULL, NULL, 679, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(684, 'DCC 1-1-1', 'DCC 1-1-1', 'رجوعا للضابط ‎١-١-١‏ في الضوابط الأساسية للأمن السيبراني. فإنه يجب على الإدارة المعنية\r\n\r\n‏بالأمن السيبراني في الجهة مراجعة تطبيق ضوابط الأمن السيبراني للبيانات حسب المدة كل سنة على الأقل\r\nالمحددة لكل مستوى', NULL, 'DCC 1-1-1', 'Not Applicable', 31, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(685, 'DCC 1-1-2', 'DCC 1-1-2', 'حا رجوعًا للضابط ‎3-0-١‏ في الضوابط الأساسية للأمن السيبراني يجب أن تتم مراجعة كل سنتان\r\nتطبيق ضوابط الأمن السيبراني للبيانات من قبل أطراف مستقلة عن الإدارة المعنية بالأمن', NULL, 'DCC 1-1-2', 'Not Applicable', 31, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(686, 'DCC 1-2-1', 'DCC 1-2-1', 'بالإضافة للضوابط الفرعية ضمن الضابط ‎٢-٢-١‏ في الضوابط الأساسية للأمن السيبراني يجب\r\nأن تغطي متطلبات الأمن السيبراني المتعلقة بالموارد البشرية لتشمل خلال وبعد إنتهاء\\/إنهاء\r\nالعلاقة الوظيفية في الجهة', NULL, 'DCC 1-2-1', 'Not Applicable', 32, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(687, 'DCC 1-2-1-1', 'DCC 1-2-1-1', 'إجراء المسح الأمني (screening 5) للعاملين في الوظائف ذات\r\nالعلاقة بالتعامل مع البيانات', NULL, 'DCC 1-2-1-1', 'Not Applicable', 32, 1, NULL, NULL, NULL, 1, NULL, NULL, 686, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(688, 'DCC 1-2-1-2', 'DCC 1-2-1-2', 'تعهد العاملين في الجهة بعدم استخدام تطبيقات التراسل أو التواصل\r\nالإجتماعي أو خدمات التخزين السحابية الشخصية لإنشاء أو تخزين أو\r\nمشاركة البيانات الخاصة بالجهة. باستثناء تطبيقات التراسل الآمنة المعتمدة\r\nمن الجهات ذات العلاقة.', NULL, 'DCC 1-2-1-2', 'Not Applicable', 32, 1, NULL, NULL, NULL, 1, NULL, NULL, 686, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(689, 'DCC 1-3-1', 'DCC 1-3-1', 'بالإضافة للضوابط الفرعية ضمن الضابط ‎٢-١٠-١‏ في الضوابط الأساسية للأمن السيبراني. فإنه\r\nيجب أن يغطي برنامج التوعية بالأمن السيبراني المحاور المتعلقة بحماية البيانات', NULL, 'DCC 1-3-1', 'Not Applicable', 33, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(690, 'DCC 1-3-1-1', 'DCC 1-3-1-1', 'مخاطر التسريب والوصول غير المصرح به للبيانات خلال دورة حياتها.', NULL, 'DCC 1-3-1-1', 'Not Applicable', 33, 1, NULL, NULL, NULL, 1, NULL, NULL, 689, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(691, 'DCC 1-3-1-2', 'DCC 1-3-1-2', 'التعامل الآمن مع البيانات المصنفة خلال السفر والتواجد خارج مكان العمل', NULL, 'DCC 1-3-1-2', 'Not Applicable', 33, 1, NULL, NULL, NULL, 1, NULL, NULL, 689, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(692, 'DCC 1-3-1-3', 'DCC 1-3-1-3', 'التعامل الآمن مع البيانات خلال الاجتماعات (الافتراضية والحضورية).', NULL, 'DCC 1-3-1-3', 'Not Applicable', 33, 1, NULL, NULL, NULL, 1, NULL, NULL, 689, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(693, 'DCC 1-3-1-4', 'DCC 1-3-1-4', 'الاستخدام الآمن للطابعات والماسحات الضوئية وآلات التصوير.', NULL, 'DCC 1-3-1-4', 'Not Applicable', 33, 1, NULL, NULL, NULL, 1, NULL, NULL, 689, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(694, 'DCC 1-3-1-5', 'DCC 1-3-1-5', 'إجراءات الإتلاف الآمن للبيانات.', NULL, 'DCC 1-3-1-5', 'Not Applicable', 33, 1, NULL, NULL, NULL, 1, NULL, NULL, 689, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(695, 'DCC 1-3-1-6', 'DCC 1-3-1-6', 'مخاطر مشاركة الوثائق والمعلومات من خلال قنوات تواصل غير مؤمنة', NULL, 'DCC 1-3-1-6', 'Not Applicable', 33, 1, NULL, NULL, NULL, 1, NULL, NULL, 689, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(696, 'DCC 1-3-1-7', 'DCC 1-3-1-7', 'المخاطر السيبرانية المتعلقة باستخدام وسائط التخزين الخارجية', NULL, 'DCC 1-3-1-7', 'Not Applicable', 33, 1, NULL, NULL, NULL, 1, NULL, NULL, 689, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(697, 'DCC 2-1-1', 'DCC 2-1-1', 'بالإضافة للضوابط الفرعية ضمن الضابط ‎٢-٢-٢‏ في الضوابط الأساسية للأمن السيبراني. يجب\r\n\r\n‏أن تغطي متطلبات الأمن السيبراني المتعلقة بإدارة هويات الدخول والصلاحيات', NULL, 'DCC 2-1-1', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(698, 'DCC 2-1-1-1', 'DCC 2-1-1-1', 'التقييد الحازم بالسماح للحد الأدنى من العاملين للوصول والاطلاع ومشاركة\r\nالبيانات بناء على قوائم صلاحيات مقتصرة على موظفين سعوديين إلا بموجب\r\nاستثناء من قبل صاحب الصلاحية (رئيس الجهة أو من يفوضه) وعاى أن يتم\r\nإعتمادهذه القوائم من قبل صاحب الصلاحية', NULL, 'DCC 2-1-1-1', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, 697, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(699, 'DCC 2-1-1-2', 'DCC 2-1-1-2', 'منع مشاركة قوائم الصلاحيات المعتمدة مع الأشخاص غير المصرح لهم.', NULL, 'DCC 2-1-1-2', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, 697, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(700, 'DCC 2-1-2', 'DCC 2-1-2', 'إدارة هويات الدخول وصلاحيات الاطلاع على البيانات باستخدام أنظمة إدارة الصلاحيات\r\nالهامة والحساسة', NULL, 'DCC 2-1-2', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(701, 'DCC 2-1-3', 'DCC 2-1-3', 'بالإضافة للضابط الفرعي ‎٥-٢-٢-٢‏ في الضوابط الأساسية للأمن السيبراني. يجب مراجعة قوائم\r\nالصلاحيات المعتمدة والصلاحيات المستخدمة', NULL, 'DCC 2-1-3', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(702, 'DCC 2-2-1', 'DCC 2-2-1', 'بالإضافة للضوابط الفرعية ضمن الضابط ‎2-7-١‏ في الضوابط الأساسية للأمن السيبراني', NULL, 'DCC 2-2-1', 'Not Applicable', 36, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(703, 'DCC 2-2-1-1', 'DCC 2-2-1-1', 'تطبيق حزم التحديثات. والإصلاحات الأمنية من وقت إطلاقها للأنظمة\r\nالمستخدمة للتعامل مع البيانات حسب المدة المحددة لكل مستوى.', NULL, 'DCC 2-2-1-1', 'Not Applicable', 36, 1, NULL, NULL, NULL, 1, NULL, NULL, 702, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(704, 'DCC 2-2-1-2', 'DCC 2-2-1-2', 'مراجعة إعدادات الحماية والتحصين للأنظمة المستخدمة للتعامل مع البيانات\r\n) ھ منم ) حسب المدة المحددة لكل\r\n‏مستوى.', NULL, 'DCC 2-2-1-2', 'Not Applicable', 36, 1, NULL, NULL, NULL, 1, NULL, NULL, 702, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(705, 'DCC 2-2-1-3', 'DCC 2-2-1-3', 'مراجعة وتحصين الإعدادات المصنعية', NULL, 'DCC 2-2-1-3', 'Not Applicable', 36, 1, NULL, NULL, NULL, 1, NULL, NULL, 702, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(706, 'DCC 2-2-1-4', 'DCC 2-2-1-4', 'تعطيل خاصية تصوير الشاشة  ) للأجهزة\r\nالتي تنشئ أو تعالج الوثائق', NULL, 'DCC 2-2-1-4', 'Not Applicable', 36, 1, NULL, NULL, NULL, 1, NULL, NULL, 702, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(707, 'DCC 2-3-1', 'DCC 2-3-1', 'بالإضافة للضوابط الفرعية ضمن الضابط 2-7-3 في الضوابط الأساسية للأمن السيبراني. يجب\r\nأن تغطي متطلبات الأمن السيبراني الخاصة بأمن الأجهزة المحمولة', NULL, 'DCC 2-3-1', 'Not Applicable', 39, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(708, 'DCC 2-3-1-1', 'DCC 2-3-1-1', 'إدارة الأجهزة المحمولة المملوكة للجهة مركزيا باستخدام نظام إدارة الأجهزة\r\nالمحمولة ) - س ء علنم”) وتفعيل خاصية\r\nالحذف عن بعد.', NULL, 'DCC 2-3-1-1', 'Not Applicable', 39, 1, NULL, NULL, NULL, 1, NULL, NULL, 707, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(709, 'DCC 2-3-1-2', 'DCC 2-3-1-2', 'إدارة أجهزة (ط0ل8) مركزيا باستخدام نظام إدارة الأجهزة المحمولة\r\n) - ه ء علناه”) وتفعيل خاصية الحذف عن يمنع إستخدام\r\nبعد. أجهزة', NULL, 'DCC 2-3-1-2', 'Not Applicable', 39, 1, NULL, NULL, NULL, 1, NULL, NULL, 707, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(710, 'DCC 2-4-1', 'DCC 2-4-1', 'استخدام خاصية العلامات المائية لترميز كامل الوثيقة عند الإنشاء والتخزين\r\n‏والطباعة وعلى الشاشة وعلى كل نسخة', NULL, 'DCC 2-4-1', 'Not Applicable', 40, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(711, 'DCC 2-4-1-1', 'DCC 2-4-1-1', 'استخدام خاصية العلامات المائية لترميز كامل الوثيقة عند الإنشاء والتخزين\r\n\r\n‏والطباعة وعلى الشاشة وعلى كل نسخة بحيث يكون الرمز يمكن تتبعه على\r\n‏1 4 4\r\nمستوى المستخدم أو الجهاز', NULL, 'DCC 2-4-1-1', 'Not Applicable', 40, 1, NULL, NULL, NULL, 1, NULL, NULL, 710, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(712, 'DCC 2-4-1-2', 'DCC 2-4-1-2', 'استخدام تقنيات منع تسريب البيانات )مم (\r\nوتقنيات إدارة الصلاحيات', NULL, 'DCC 2-4-1-2', 'Not Applicable', 40, 1, NULL, NULL, NULL, 1, NULL, NULL, 710, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(713, 'DCC 2-4-1-3', 'DCC 2-4-1-3', 'ظر استخدام البيانات في أي بيئة غير بيئة الإنتاج ) منع\r\n( للمخاطر وتطبيق ضوابط لحماية تلك', NULL, 'DCC 2-4-1-3', 'Not Applicable', 40, 1, NULL, NULL, NULL, 1, NULL, NULL, 710, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(714, 'DCC 2-4-1-4', 'DCC 2-4-1-4', 'استخدام خدمة حماية العلامة التجارية لحماية هوية الجهة من الانتحال\r\n) (.', NULL, 'DCC 2-4-1-4', 'Not Applicable', 40, 1, NULL, NULL, NULL, 1, NULL, NULL, 710, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(715, 'DCC 2-5-1', 'DCC 2-5-1', 'بالإضافة للضوابط الفرعية ضمن الضابط 7-8-3 في الضوابط الأساسية للأمن السيبراني. يجب\r\nأن تغطي متطلبات الأمن السيبراني للتشفير في الجهة', NULL, 'DCC 2-5-1', 'Not Applicable', 41, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(716, 'DCC 2-5-1-1', 'DCC 2-5-1-1', 'ستخدام طرق وخوارزميات محدثة وآمنة للتشفير عند الإنشاء والتخزين\r\nوالمشاركة وعلى كامل الاتصال الشبكي المستخدم لنقل البيانات وفقا للمستوى\r\nالمتقدم (لع2صة٧4)‏ ضمن المعايير الوطنية للتشفير (1:2020 - 0108.\r\nاستخدام طرق وخوارزميات محدثة وآمنة للتشفير عند الإنشاء والتخزين\r\nوالمشاركة وعلى كامل الاتصال الشبكي المستخدم لنقل البيانات وفقا للمستوى\r\nالمتوسط (ءء4٥)‏ ضمن المعايير الوطنية للتشفير', NULL, 'DCC 2-5-1-1', 'Not Applicable', 41, 1, NULL, NULL, NULL, 1, NULL, NULL, 715, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(717, 'DCC 2-5-1-2', 'DCC 2-5-1-2', 'استخدام طرق وخوارزميات محدثة وآمنة للتشفير عند الإنشاء والتخزين\r\nوالمشاركة وعلى كامل الاتصال الشبكي المستخدم لنقل البيانات وفقا للمستوى\r\nالمتقدم (لع2صة٧4)‏ ضمن المعايير الوطنية للتشفير (1:2020 - 0108.\r\nاستخدام طرق وخوارزميات محدثة وآمنة للتشفير عند الإنشاء والتخزين\r\nوالمشاركة وعلى كامل الاتصال الشبكي المستخدم لنقل البيانات وفقا للمستوى\r\nالمتوسط (ءء4٥)‏ ضمن المعايير الوطنية للتشفير', NULL, 'DCC 2-5-1-2', 'Not Applicable', 41, 1, NULL, NULL, NULL, 1, NULL, NULL, 715, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(718, 'DCC 2-6-1', 'DCC 2-6-1', 'يجب أن تغطي متطلبات الإتلاف الآمن للبيانات', NULL, 'DCC 2-6-1', 'Not Applicable', 126, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(719, 'DCC 2-6-1-1', 'DCC 2-6-1-1', 'ديد التقنيات والأدوات والإجراءات لتنفيذ عمليات الإتلاف الآمن للبيانات\r\nحسب مستوى تصنيف البيا', NULL, 'DCC 2-6-1-1', 'Not Applicable', 126, 1, NULL, NULL, NULL, 1, NULL, NULL, 718, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(720, 'DCC 2-6-1-2', 'DCC 2-6-1-2', 'عند انتهاء الحاجة لاستخدام وسائط التخزين بشكل نهائي. يجب أن يتم\r\nالإتلاف الآمن (لةهمنط ©5007) لوسائط التخزين وذلك باستخدام\r\nالتقنيات والأدوات وبإتباع الإجراءات التي تم تحديدها في الضابط رقم ‎-٦-٢‏\r\n‎.١-١‏', NULL, 'DCC 2-6-1-2', 'Not Applicable', 126, 1, NULL, NULL, NULL, 1, NULL, NULL, 718, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(721, 'DCC 2-6-1-3', 'DCC 2-6-1-3', 'عند الحاجة لإعادة استخدام وسائط التخزين. يجب أن يتم الحذف الآمن\r\nللبيانات). بحيث لا يمكن استرجاعها', NULL, 'DCC 2-6-1-3', 'Not Applicable', 126, 1, NULL, NULL, NULL, 1, NULL, NULL, 718, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(722, 'DCC 2-6-1-4', 'DCC 2-6-1-4', 'جب أن يتم التحقق من تنفيذ عمليات الإتلاف أو الحذف الآمن للبيانات\r\nالمشار إليها في الضابطين رقم 7-1-7-7 و٢-٦-١۔٣.‏', NULL, 'DCC 2-6-1-4', 'Not Applicable', 126, 1, NULL, NULL, NULL, 1, NULL, NULL, 718, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(723, 'DCC 2-6-1-5', 'DCC 2-6-1-5', 'الاحتفاظ بسجل لعمليات الإتلاف أو الحذف الآمن للبيانات التي تم تنفيذها.', NULL, 'DCC 2-6-1-5', 'Not Applicable', 126, 1, NULL, NULL, NULL, 1, NULL, NULL, 718, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(724, 'DCC 2-6-2', 'DCC 2-6-2', 'يجب مراجعة تطبيق متطلبات الإتلاف الآمن للبيانات في الجهة حسب المدة المحددة', NULL, 'DCC 2-6-2', 'Not Applicable', 126, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(725, 'DCC 2-7-1', 'DCC 2-7-1', 'يجب تحديد وتوثيق واعتماد متطلبات الآمن السيبراني لحماية الطابعات والماسحات الضوئية\r\nوآلات التصوير في الجهة', NULL, 'DCC 2-7-1', 'Not Applicable', 127, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(726, 'DCC 2-7-3', 'DCC 2-7-3', 'يجب أن تغطي متطلبات الأمن السيبراني للطابعات والما سحات الضوئية وآلات التصوير', NULL, 'DCC 2-7-3', 'Not Applicable', 127, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL);
INSERT INTO `framework_controls` (`id`, `short_name`, `long_name`, `description`, `supplemental_guidance`, `control_number`, `control_status`, `family`, `control_owner`, `desired_maturity`, `control_priority`, `control_class`, `control_maturity`, `control_phase`, `control_type`, `parent_id`, `submission_date`, `last_audit_date`, `next_audit_date`, `desired_frequency`, `mitigation_percent`, `status`, `deleted`, `created_at`, `updated_at`) VALUES
(727, 'DCC 2-7-3-1', 'DCC 2-7-3-1', 'تعطيل خاصية التخزين المؤقت', NULL, 'DCC 2-7-3-1', 'Not Applicable', 127, 1, NULL, NULL, NULL, 1, NULL, NULL, 726, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(728, 'DCC 2-7-3-2', 'DCC 2-7-3-2', 'تفعيل خاصية التحقق من الهوية في الطابعات واما سحات الضوئية والآت\r\nالتصوير المركزية قبل بدء عمليات الطباعة والتصوير والمسح الضوفي', NULL, 'DCC 2-7-3-2', 'Not Applicable', 127, 1, NULL, NULL, NULL, 1, NULL, NULL, 726, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(729, 'DCC 2-7-2', 'DCC 2-7-2', 'يجب تطبيق متطلبات الأمن السيبراني للطابعات والما سحات الضوئية وآلات الة صوير في\r\nالجهة', NULL, 'DCC 2-7-2', 'Not Applicable', 127, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(730, 'DCC 2-7-3-3', 'DCC 2-7-3-3', 'الاحتفاظ بطريقة آمنة بسجل الكتروني للعمليات الخاصة با ستخدام\r\nالطابعات والماسحات الضوئية والآت التصوير. لفترة لا تقل عن ‎١٢‏ شهرا.', NULL, 'DCC 2-7-3-3', 'Not Applicable', 127, 1, NULL, NULL, NULL, 1, NULL, NULL, 726, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(731, 'DCC 2-7-3-4', 'DCC 2-7-3-4', 'تفعيل وحماية سجلات المراقبة لأنظمة 00177 على مواقع أجهزة الطباعة\r\nالمركزية والماسحات الضوئية والآت التصوير', NULL, 'DCC 2-7-3-4', 'Not Applicable', 127, 1, NULL, NULL, NULL, 1, NULL, NULL, 726, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(732, 'DCC 2-7-3-5', 'DCC 2-7-3-5', 'استخدام أجهزة تمزيق الوثائق الورقية (صنكعحطك 0:088). لإتلاف الوثائق\r\nفي حال الانتهاء من استخدامها نهائيا', NULL, 'DCC 2-7-3-5', 'Not Applicable', 127, 1, NULL, NULL, NULL, 1, NULL, NULL, 726, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(733, 'DCC 2-7-4', 'DCC 2-7-4', 'يجب مراجعة تطبيق متطلبات الأمن السيبراني للطابعات والماسحات الضوئية وآلات التصوير\r\nفي الجهة حسب المدة المحددة لكل مستوى', NULL, 'DCC 2-7-4', 'Not Applicable', 127, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(734, 'DCC 3-1-1', 'DCC 3-1-1', 'بالإضافة للضوابط ضمن المكون الفرعي ‎١-٤‏ في الضوابط الأساسية للأمن السيبراني. يجب أن\r\nتشمل متطلبات الأمن السيبراني المتعلقة بالأطراف الخارجية', NULL, 'DCC 3-1-1', 'Not Applicable', 50, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(735, 'DCC 3-1-1-1', 'DCC 3-1-1-1', 'إجراء المسح الأمني SCREENING) لموظفي الأطراف الخارجية\r\nالذين لديهم صلاحيات الاطلاع على البيانات.', NULL, 'DCC 3-1-1-1', 'Not Applicable', 50, 1, NULL, NULL, NULL, 1, NULL, NULL, 734, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(736, 'DCC 3-1-1-2', 'DCC 3-1-1-2', '‏وجود ضمانات تعاقدية للقدرة على حذف بيانات الجهة بطرق آمنة لدى\r\nالطرف الخارجي عند الانتهاء\\/إنهاء العلاقة التعاقدية مع تقديم الأدلة على\r\nذلك', NULL, 'DCC 3-1-1-2', 'Not Applicable', 50, 1, NULL, NULL, NULL, 1, NULL, NULL, 734, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(737, 'DCC 3-1-1-3', 'DCC 3-1-1-3', '‏توثيق كافة عمليات مشاركة البيانات مع الأطراف الخارجية. على أن يشمل\r\nذلك مبررات مشاركة البيانات', NULL, 'DCC 3-1-1-3', 'Not Applicable', 50, 1, NULL, NULL, NULL, 1, NULL, NULL, 734, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(738, 'DCC 3-1-1-4', 'DCC 3-1-1-4', '‏عند مشاركة البيانات خارج المملكة يجب التحقق من قدرة الجهة المستضيفة\r\nعلى حماية تلك البيانات والحصول على موافقة صاحب الصلاحية بالإضافة إلى\r\nالالتزام بالمتطلبات التشريعية والتنظيمية ذات العلاقة.', NULL, 'DCC 3-1-1-4', 'Not Applicable', 50, 1, NULL, NULL, NULL, 1, NULL, NULL, 734, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(739, 'DCC 3-1-1-5', 'DCC 3-1-1-5', 'إلزام الأطراف الخارجية بإبلاغ الجهة مباشرة عند حدوث حادثة أمن سيبراني قد\r\nي تمت مشاركتها أو إنشائها', NULL, 'DCC 3-1-1-5', 'Not Applicable', 50, 1, NULL, NULL, NULL, 1, NULL, NULL, 734, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(740, 'DCC 3-1-1-6', 'DCC 3-1-1-6', 'عادة تصنيف البيانات إلى أقل مستوى يحقق الهدف. قبل مشاركتها مع الأطراف\r\nالخارجية وذلك باستخدام تقنيات تعتيم البيانات أو تقنيات\r\nمزج البيانات', NULL, 'DCC 3-1-1-6', 'Not Applicable', 50, 1, NULL, NULL, NULL, 1, NULL, NULL, 734, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(741, 'DCC 3-1-2', 'DCC 3-1-2', 'يتوافق مع المتطلبات التشريعية والتنظيمية ذات العلاقة. وبالإضافة إلى ما ينطبق من\r\nالضوابط الأساسية للأمن السيبراني والضوابط ضمن المكونات الرئيسية رقم ‎\r\n‏يجب أن تغطي متطلبات الأمن السيبراني عند التعامل مع الجهات الاستشارية\r\n‏للمشاريع الاستراتيجية ذات الحساسية العالية على المستوى الوطني', NULL, 'DCC 3-1-2', 'Not Applicable', 50, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(742, 'DCC 3-1-2-1', 'DCC 3-1-2-1', '‏إجراء المسح الأمني  لموظفي شركات الخدمات الاستشارية الذين لديهم صلاحيات الاطلاع على البيانات', NULL, 'DCC 3-1-2-1', 'Not Applicable', 50, 1, NULL, NULL, NULL, 1, NULL, NULL, 741, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(743, 'DCC 3-1-2-2', 'DCC 3-1-2-2', '‏وجود ضمانات تعاقدية تشمل إلزام موظفي الخدمات الاستشارية بعدم إفشاء\r\nالمعلومات وكذلك القدرة على حذف بيانات الجهة بطرق آمنة لدى شركات\r\nالخدمات الاستشارية عند الانتهاء\\/إنهاء العلاقة التعاقدية مع تقديم الأدلة على\r\nذلك', NULL, 'DCC 3-1-2-2', 'Not Applicable', 50, 1, NULL, NULL, NULL, 1, NULL, NULL, 741, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(744, 'DCC 3-1-2-3', 'DCC 3-1-2-3', '‏توثيق كافة عمليات مشاركة البيانات مع شركات الخدمات الاستشارية. على أن\r\nيشمل ذلك مبررات مشاركة البيانات.', NULL, 'DCC 3-1-2-3', 'Not Applicable', 50, 1, NULL, NULL, NULL, 1, NULL, NULL, 741, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(745, 'DCC 3-1-2-4', 'DCC 3-1-2-4', '‏إلزام شركات الخدمات الاستشارية بإبلاغ الجهة مباشرة عند حدوث حادثة أمن\r\nسيبراني قد تؤثر على البيانات التي تمت مشاركتها أو إنشائها.', NULL, 'DCC 3-1-2-4', 'Not Applicable', 50, 1, NULL, NULL, NULL, 1, NULL, NULL, 741, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(746, 'DCC 3-1-2-5', 'DCC 3-1-2-5', 'إعادة تصنيف البيانات إلى أقل مستوى يحقق الهدف. قبل مشاركتها مع شركات\r\nالخدمات الاستشارية وذلك باستخدام تقنيات تعتيم البيانات', NULL, 'DCC 3-1-2-5', 'Not Applicable', 50, 1, NULL, NULL, NULL, 1, NULL, NULL, 741, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(747, 'DCC 3-1-2-6', 'DCC 3-1-2-6', '‏تخصيص قاعة مغلقة لموظفي شركات الخدمات الاستشارية لأداء أعمالهم. مع\r\nتوفير أجهزة مخصصة مملوكة للجهة يتم من خلالها مشاركة البيانات ومعالجتها.', NULL, 'DCC 3-1-2-6', 'Not Applicable', 50, 1, NULL, NULL, NULL, 1, NULL, NULL, 741, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(748, 'DCC 3-1-2-7', 'DCC 3-1-2-7', 'تفعيل أنظمة التحكم بالدخول والخروج من القاعة المغلقة. على أن يكون\r\nللمصرح لهم فقط', NULL, 'DCC 3-1-2-7', 'Not Applicable', 50, 1, NULL, NULL, NULL, 1, NULL, NULL, 741, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(749, 'DCC 3-1-2-8', 'DCC 3-1-2-8', 'منع خروج الأجهزة ووحدات التخزين والوثائق من القاعة المغلقة. ومنع إدخال\r\nأي أجهزة إلكترونية للقاعة', NULL, 'DCC 3-1-2-8', 'Not Applicable', 50, 1, NULL, NULL, NULL, 1, NULL, NULL, 741, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(750, 'CSCC 1-1-1', 'CSCC 1-1-1', 'الإضافة للضوابط ضمن المكون الفرعي ‎١ - ١‏ في الضوابط الأساسية للأمن السيبراني. يجب أن تضع\r\nإستراتيجية الأمن السيبراني للجهة أولوية لدعم حماية الأنظمة الحساسة الخاصة بالجهة', NULL, 'CSCC 1-1-1', 'Not Applicable', 24, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(751, 'CSCC 1-2-1', 'CSCC 1-2-1', 'بالإضافة للضوابط ضمن المكون الفرعي ‎٥ - ١‏ في الضوابط الأساسية للأمن السيبراني. يجب أن تشمل\r\nمنهجية إدارة مخاطر الأمن السيبراني', NULL, 'CSCC 1-2-1', 'Not Applicable', 28, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(752, 'CSCC 1-2-1-1', 'CSCC 1-2-1-1', 'تنفيذ إجراء تقييم مخاطر الأمن السيبراني؛ على الأنظمة الحساسة. مرة واحدة سنويا.\r\nعلى الأقل.', NULL, 'CSCC 1-2-1-1', 'Not Applicable', 28, 1, NULL, NULL, NULL, 1, NULL, NULL, 751, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(753, 'CSCC 1-2-1-2', 'CSCC 1-2-1-2', 'إنشاء سجل مخاطر الأمن السيبراني الخاص بالأنظمة الحساسة. ومتابعته مرة شهريا\r\nعلى الأقل.', NULL, 'CSCC 1-2-1-2', 'Not Applicable', 28, 1, NULL, NULL, NULL, 1, NULL, NULL, 751, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(754, 'CSCC 1-3-1', 'CSCC 1-3-1', 'بالإضافة للضوابط الفرعية ضمن الضابط ‎٢ - ٦ - ١‏ في الضوابط الأساسية للأمن السييراني. يجب أن تغطي\r\nمتطلبات الأمن السيبراني. لإدارة المشاريع والتغييرات على الأصول المعلوماتية والتقنية للأنظمة\r\nالحساسة في الجهة', NULL, 'CSCC 1-3-1', 'Not Applicable', 29, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(755, 'CSCC 1-3-1-1', 'CSCC 1-3-1-1', 'إجراء اختبار التحمل  للتأكد من سعة المكونات المختلفة', NULL, 'CSCC 1-3-1-1', 'Not Applicable', 29, 1, NULL, NULL, NULL, 1, NULL, NULL, 754, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(756, 'CSCC 1-3-1-2', 'CSCC 1-3-1-2', 'التأكد من تطبيق متطلبات استمرارية الأعمال.', NULL, 'CSCC 1-3-1-2', 'Not Applicable', 29, 1, NULL, NULL, NULL, 1, NULL, NULL, 754, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(757, 'CSCC 1-3-2', 'CSCC 1-3-2', 'بالإضافة للضوابط الفرعية ضمن الضابط ‎٣ - ٦ - ١‏ في الضوابط الأساسية للأمن السييراني. يجب أن تغطي\r\nمتطلبات الأمن السييراني. لمشاريع تطوير التطبيقات. والبرمجيات الخاصة بالأنظمة الحساسة للجهة', NULL, 'CSCC 1-3-2', 'Not Applicable', 29, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(758, 'CSCC 1-3-2-1', 'CSCC 1-3-2-1', 'إجراء مراجعة أمنية للشفرة المصدرية. قبل إطلاقها', NULL, 'CSCC 1-3-2-1', 'Not Applicable', 29, 1, NULL, NULL, NULL, 1, NULL, NULL, 757, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(759, 'CSCC 1-3-2-2', 'CSCC 1-3-2-2', 'تأمين الوصول والتخزين. والتوثيق للشفرة المصدرية واصداراتها', NULL, 'CSCC 1-3-2-2', 'Not Applicable', 29, 1, NULL, NULL, NULL, 1, NULL, NULL, 757, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(760, 'CSCC 1-3-2-3', 'CSCC 1-3-2-3', '‏ تأمين واجهة برمجة التطبيقات   API A', NULL, 'CSCC 1-3-2-3', 'Not Applicable', 29, 1, NULL, NULL, NULL, 1, NULL, NULL, 757, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(761, 'CSCC 1-3-2-4', 'CSCC 1-3-2-4', 'النقل الآمن والموثوق للتطبيقات من بيئات الاختبار t Testin) إلى\r\nبيئات الإنتاج ) مع حذف أي بيانات. أو هويات. أو\r\nكلمات مرور. متعلقة ببينات الاختبار. قبل النقل', NULL, 'CSCC 1-3-2-4', 'Not Applicable', 29, 1, NULL, NULL, NULL, 1, NULL, NULL, 757, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(762, 'CSCC 1-4-1', 'CSCC 1-4-1', '‏رجوعا للضابط ‎١ - ٨ - ١‏ في الضوابط الأساسية للأمن السيبراني. فإنه يجب على الإدارة المعنية بالأمن\r\nالسيبراني؛ مراجعة تطبيق ضوابط الأمن السيبراني للأنظمة الحساسة. مرة واحدة سنوياً؛ على الأقل', NULL, 'CSCC 1-4-1', 'Not Applicable', 31, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(763, 'CSCC 1-4-2', 'CSCC 1-4-2', 'رجوعاً للضابط ‎٢ - ٨ - ١‏ في الضوابط الأساسية للأمن السيبراني. يجب أن تتم مراجعة تطبيق ضوابط الأمن السيبراني للأنظمة الحساسة؛ من قبل أطراف مستقلة عن الإدارة المعنية بالأمن السيبراني من داخل الجهة. مرة واحدة؛ كل ثلاث سنوات على الأقل.', NULL, 'CSCC 1-4-2', 'Not Applicable', 31, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(764, 'CSCC 1-5-1', 'CSCC 1-5-1', '‏بالإضافة للضوابط الفرعية ضمن الضابط ‎٣ - 3 - ١‏ في الضوابط الأساسية للأمن السيبراذ\r\nتغطي متطلبات الأمن السيبراني. قبل بدء علاقة العاملين المهنية بالجهة.', NULL, 'CSCC 1-5-1', 'Not Applicable', 32, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(765, 'CSCC 1-5-1-1', 'CSCC 1-5-1-1', 'إجراء امسح الأمني  للعاملين على الأنظمة الحساسة.', NULL, 'CSCC 1-5-1-1', 'Not Applicable', 32, 1, NULL, NULL, NULL, 1, NULL, NULL, 764, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(766, 'CSCC 1-5-1-2', 'CSCC 1-5-1-2', 'أن يشغل وظائف الدعم. والتطوير التقني. للأنظمة الحساسة؛ مواطنون ذوو كفاءة عالية', NULL, 'CSCC 1-5-1-2', 'Not Applicable', 32, 1, NULL, NULL, NULL, 1, NULL, NULL, 764, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(767, 'CSCC 2-1-1', 'CSCC 2-1-1', 'بالإضافة للضوابط ضمن المكون الفرعي ‎١ - ٢‏ في الضوابط الأساسية للأمن السييراني. يجب أن تشمل\r\nمتطلبات الآمن السيبراني لإدارة الأصول المعلوماتية والتقنية', NULL, 'CSCC 2-1-1', 'Not Applicable', 34, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(768, 'CSCC 2-1-1-1', 'CSCC 2-1-1-1', 'الاحتفاظ بقائمة محدثة سنويا. لجميع الأصول التابعة للأنظمة الحساسة', NULL, 'CSCC 2-1-1-1', 'Not Applicable', 34, 1, NULL, NULL, NULL, 1, NULL, NULL, 767, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(769, 'CSCC 2-1-1-2', 'CSCC 2-1-1-2', 'تحديد ملاك الأصول  وإشراكهم في دورة حياة إدارة الأصول\"\r\nالتابعة للأنظمة الحساسة.', NULL, 'CSCC 2-1-1-2', 'Not Applicable', 34, 1, NULL, NULL, NULL, 1, NULL, NULL, 767, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(770, 'CSCC 2-2-1', 'CSCC 2-2-1', '‏بالإضافة للضوابط الفرعية ضمن الضابط ‎٣ - ٢ - ٢‏ في الضوابط الأساسية للأمن السيبراني. يجب أن تغطي متطلبات الأمن السيبراني المتعلقة بإدارة هويات الدخول\" والصلاحيات للأنظمة الحساسة في الجهة', NULL, 'CSCC 2-2-1', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(771, 'CSCC 2-2-1-1', 'CSCC 2-2-1-1', 'منع الدخول عن بعد من خارج المملكة.', NULL, 'CSCC 2-2-1-1', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, 770, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(772, 'CSCC 2-2-1-2', 'CSCC 2-2-1-2', 'تقييد الدخول عن بعد من داخل المملكة؛ على أن يتم التأكد عن طريق مركز\r\nالعمليات الأمنية الخاص بالجهة. عند كل عملية دخول؛ ومراقبة الأنشطة المتعلقة\r\nبالدخول عن بعد باستمرار', NULL, 'CSCC 2-2-1-2', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, 770, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(773, 'CSCC 2-2-1-3', 'CSCC 2-2-1-3', 'التحقق من الهوية متعدد العناصر MFA «Authentication Factor-Multi )-(\r\nلجميع المستفيدين.', NULL, 'CSCC 2-2-1-3', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, 770, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(774, 'CSCC 2-2-1-4', 'CSCC 2-2-1-4', 'التحقق من الهوية متعدد العناصر )»« محن -(\r\nللمستخدمين ذوي الصلاحيات الهامة. والحساسة؛ وعلى الأنظمة المستخدمة لإدارة\r\nالأنظمة الحساسة المذكورة في الضابط ‎٤ - ١ - ٣ - ٢‏ ومتابعتها.', NULL, 'CSCC 2-2-1-4', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, 770, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(775, 'CSCC 2-2-1-5', 'CSCC 2-2-1-5', 'وضع سياسة آمنة لكلمة المرور ذات معايير عالية. وتطبيقها.', NULL, 'CSCC 2-2-1-5', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, 770, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(776, 'CSCC 2-2-1-6', 'CSCC 2-2-1-6', 'استخدام الطرق والخوارزميات الآمنة لحفظ ومعالجة كلمات المرور مثل => استخدام\r\nدوال الاختزال', NULL, 'CSCC 2-2-1-6', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, 770, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(777, 'CSCC 2-2-1-7', 'CSCC 2-2-1-7', 'الإدارة الآمنة لحسابات الخدمات  مابين التطبيقات والأنظمة؛\r\nوتعطيل الدخول البشري التفاعلي  من خلالها', NULL, 'CSCC 2-2-1-7', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, 770, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(778, 'CSCC 2-2-1-8', 'CSCC 2-2-1-8', 'يما عدا مشرفي قواعد البيانات  يمنع الوصول أو\r\nالتعامل المباشر لأي مستخدم مع قواعد البيانات؛ ويتم ذلك من خلال التطبيقات\r\nفقط وبناء على الصلاحيات المخؤل بها؛ مع مراعاة تطبيق حلول أمنية تحد. أو\r\nتمنح من اطلاع مشرفي قواعد البيانات على البيانات المصنفة', NULL, 'CSCC 2-2-1-8', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, 770, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(779, 'CSCC 2-2-2', 'CSCC 2-2-2', 'رجوعاً للضابط ‎٥ - ٣ - ٢ - ٢‏ في الضوابط الأساسية للأمن السيبراني. يجب مراجعة هويات الدخول على الأنظمة الحساسة مرة واحدة. كل ثلاثة أشهر. على الأقل.', NULL, 'CSCC 2-2-2', 'Not Applicable', 35, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(780, 'CSCC 2-3-1', 'CSCC 2-3-1', 'بالإضافة للضوابط الفرعية ضمن الضابط ‎٣ - ٣ - ٢‏ في الضوابط الأساسية للأمن السييراني. يجب أن تغطي متطلبات الأمن السيبراني لحماية الأنظمة الحساسة. وأجهزة معالجة المعلومات الخاصة بها!', NULL, 'CSCC 2-3-1', 'Not Applicable', 36, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(781, 'CSCC 2-3-1-1', 'CSCC 2-3-1-1', 'السماح فقط بقائمة محددة من ملفات التشغيل) للتطبيقات\r\nوالبرامج؛ للعمل على الخوادم الخاصة بالأنظمة الحساسة', NULL, 'CSCC 2-3-1-1', 'Not Applicable', 36, 1, NULL, NULL, NULL, 1, NULL, NULL, 780, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(782, 'CSCC 2-3-1-2', 'CSCC 2-3-1-2', 'حماية الخوادم الخاصة بالأنظمة الحساسة بتقنيات حماية الأجهزة الطرفية\r\n المعتمدة لدى الجهة.', NULL, 'CSCC 2-3-1-2', 'Not Applicable', 36, 1, NULL, NULL, NULL, 1, NULL, NULL, 780, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(783, 'CSCC 2-3-1-3', 'CSCC 2-3-1-3', 'تطبيق حزم التحديثات. والإصلاحات الأمنية. مرة واحدة شهرياً على الأقل. للأنظمة\r\nالحساسة الخارجية. والمتصلة بالإنترنت؛ وكل ثلاثة أشهر على الأقل. للأنظمة الحساسة\r\nالداخلية؛ مع اتباع آليات التغيير المعتمدة لدى الجهة', NULL, 'CSCC 2-3-1-3', 'Not Applicable', 36, 1, NULL, NULL, NULL, 1, NULL, NULL, 780, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(784, 'CSCC 2-3-1-4', 'CSCC 2-3-1-4', 'تخصيص أجهزة حاسب للعاملين في الوظائف التقنية. ذات\r\nالصلاحيات الهامة والحساسة؛ على أن تكون معزولة في شبكة خاصة لإدارة الأنظمة\r\n وعلى أن لا ترتبط بأي شبكة. أو خدمة أخرى مثل:\r\nخدمة البريد الإلكتروني. الإنترنت).', NULL, 'CSCC 2-3-1-4', 'Not Applicable', 36, 1, NULL, NULL, NULL, 1, NULL, NULL, 780, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(785, 'CSCC 2-3-1-5', 'CSCC 2-3-1-5', 'تشفير أي وصول إشرافي عبر الشبكة\r\nلأي من المكونات التقنية للأنظمة الحساسة. باستخدام خوارزميات\" وبروتوكولات\r\nالتشفير الآمنة', NULL, 'CSCC 2-3-1-5', 'Not Applicable', 36, 1, NULL, NULL, NULL, 1, NULL, NULL, 780, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(786, 'CSCC 2-3-1-6', 'CSCC 2-3-1-6', 'راجعة إعدادات الأنظمة الحساسة وتحصيناتها ) م 5\r\nمنعة ]) كل ستة أشهر على الأقل.', NULL, 'CSCC 2-3-1-6', 'Not Applicable', 36, 1, NULL, NULL, NULL, 1, NULL, NULL, 780, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(787, 'CSCC 2-3-1-7', 'CSCC 2-3-1-7', 'مراجعة الإعدادات المصنعية ل) وتعديلها والتأكد من عدم\r\nوجود كلمات مرور ثابتة. وخلفية. وإفتراضية', NULL, 'CSCC 2-3-1-7', 'Not Applicable', 36, 1, NULL, NULL, NULL, 1, NULL, NULL, 780, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(788, 'CSCC 2-3-1-8', 'CSCC 2-3-1-8', 'حماية السجلات. والملفات الحساسة للأنظمة. من الوصول غير المصرح به. أو العبث»\r\nأو التغيير. أو الحذف غير المشروع.', NULL, 'CSCC 2-3-1-8', 'Not Applicable', 36, 1, NULL, NULL, NULL, 1, NULL, NULL, 780, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(789, 'CSCC 2-4-1', 'CSCC 2-4-1', 'بالإضافة للضوابط الفرعية ضمن الضابط ‎٣ - ٥ - ٢‏ في الضوابط الأساسية للأمن السيبراني. يجب أن تغطي متطلبات الأمن السيبراني لإدارة أمن شبكات الأنظمة الحساسة للجهة', NULL, 'CSCC 2-4-1', 'Not Applicable', 38, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(790, 'CSCC 2-4-1-1', 'CSCC 2-4-1-1', 'العزل والتقسيم المادي. أو المنطقي. لشبكات الأنظمة الحساسة.', NULL, 'CSCC 2-4-1-1', 'Not Applicable', 38, 1, NULL, NULL, NULL, 1, NULL, NULL, 789, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(791, 'CSCC 2-4-1-2', 'CSCC 2-4-1-2', 'مراجعة إعدادات جدار الحماية (es F) وقوائمه؛ كل ستة أشهر. على الأقل', NULL, 'CSCC 2-4-1-2', 'Not Applicable', 38, 1, NULL, NULL, NULL, 1, NULL, NULL, 789, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(792, 'CSCC 2-4-1-3', 'CSCC 2-4-1-3', 'منع التوصيل المباشر. لأي جهاز بالشبكة المحلية للأنظمة الحساسة؛ إلا بعد الفحص\"\r\nوالتأكد من توافر عناصر الحماية المحققة. للمستويات المقبولة للأنظمة الحساسة', NULL, 'CSCC 2-4-1-3', 'Not Applicable', 38, 1, NULL, NULL, NULL, 1, NULL, NULL, 789, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(793, 'CSCC 2-4-1-4', 'CSCC 2-4-1-4', 'منع الأنظمة الحساسة من الاتصال بالشبكة اللاسلكية', NULL, 'CSCC 2-4-1-4', 'Not Applicable', 38, 1, NULL, NULL, NULL, 1, NULL, NULL, 789, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(794, 'CSCC 2-4-1-5', 'CSCC 2-4-1-5', 'الحماية من التهديدات المتقدمة المستمرة على مستوى الشبكة', NULL, 'CSCC 2-4-1-5', 'Not Applicable', 38, 1, NULL, NULL, NULL, 1, NULL, NULL, 789, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(795, 'CSCC 2-4-1-6', 'CSCC 2-4-1-6', 'منع الأنظمة الحساسة من الاتصال بالإنترنت في حال أن كانت تقدم خدمة داخلية\r\nللجهة؛ ولا توجد هناك حاجة ضرورية جدا. للدخول على الخدمة من خارج الجهة', NULL, 'CSCC 2-4-1-6', 'Not Applicable', 38, 1, NULL, NULL, NULL, 1, NULL, NULL, 789, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(796, 'CSCC 2-4-1-7', 'CSCC 2-4-1-7', 'تقديم خدمات الأنظمة الحساسة. من خلال شبكات مستقلة عن الإنترنت\" في حال أن\r\nكانت خدمات تلك الأنظمة. موجهة لجهات محدودة؛ وليست للأفراد.', NULL, 'CSCC 2-4-1-7', 'Not Applicable', 38, 1, NULL, NULL, NULL, 1, NULL, NULL, 789, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(797, 'CSCC 2-4-1-8', 'CSCC 2-4-1-8', 'الحماية من هجمات تعطيل الشبكات ) \r\n للحد من المخاطر الناتجة عن هجمات تعطيل الشبكات', NULL, 'CSCC 2-4-1-8', 'Not Applicable', 38, 1, NULL, NULL, NULL, 1, NULL, NULL, 789, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(798, 'CSCC 2-4-1-9', 'CSCC 2-4-1-9', 'السماح بقائمة محددة فقط. لقوائم جدار الحماية. الخاصة\r\nبالأنظمة الحساسة', NULL, 'CSCC 2-4-1-9', 'Not Applicable', 38, 1, NULL, NULL, NULL, 1, NULL, NULL, 789, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(799, 'CSCC 2-5-1', 'CSCC 2-5-1', 'بالإضافة للضوابط الفرعية ضمن الضابط ‎٣ - ٦ - ٢‏ في الضوابط الأساسية للأمن السيبراني. يجب أن تغطي متطلبات الأمن السيبراني. الخاصة بأمن الأجهزة المحمولة. وأجهزة ((80) للجهة', NULL, 'CSCC 2-5-1', 'Not Applicable', 39, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(800, 'CSCC 2-5-1-1', 'CSCC 2-5-1-1', 'منع الوصول من الأجهزة المحمولة للأنظمة الحساسة. إلا لفترة مؤقتة فقط؛ وذلك بعد\r\nإجراء تقييم المخاطر. وأخذ الموافقات اللازمة من الإدارة المعنية بالأمن السيبراني في الجهة', NULL, 'CSCC 2-5-1-1', 'Not Applicable', 39, 1, NULL, NULL, NULL, 1, NULL, NULL, 799, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(801, 'CSCC 2-5-1-2', 'CSCC 2-5-1-2', 'تشفير أقراص الأجهزة المحمولة. ذات صلاحية الوصول للأنظمة الحساسة. تشفيراً\r\nكامل', NULL, 'CSCC 2-5-1-2', 'Not Applicable', 39, 1, NULL, NULL, NULL, 1, NULL, NULL, 799, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(802, 'CSCC 2-6-1', 'CSCC 2-6-1', 'بالإضافة للضوابط الفرعية ضمن الضابط ‎٣ - ٧ - ٢‏ في الضوابط الأساسية للأمن السيبراني؛\r\nيجب أن تغطي متطلبات الأمن السيبراني لحماية البيانات والمعلومات', NULL, 'CSCC 2-6-1', 'Not Applicable', 40, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(803, 'CSCC 2-6-1-1', 'CSCC 2-6-1-1', 'عدم استخدام بيانات الأنظمة الحساسة في غير بيئة الإنتاج )Production\r\nEnvironment) إلا بعد استخدام ضوابط مشددة لحماية تلك البيانات مثل => تقنيات\r\nتعتيم البيانات (Masking D أو تقنيات مزج البيانات ) )Scrambling Data.).', NULL, 'CSCC 2-6-1-1', 'Not Applicable', 40, 1, NULL, NULL, NULL, 1, NULL, NULL, 802, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(804, 'CSCC 2-6-1-2', 'CSCC 2-6-1-2', 'تصنيف جميع بيانات الأنظمة الحساسة', NULL, 'CSCC 2-6-1-2', 'Not Applicable', 40, 1, NULL, NULL, NULL, 1, NULL, NULL, 802, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(805, 'CSCC 2-6-1-3', 'CSCC 2-6-1-3', 'حماية البيانات المصنفة الخاصة بالأنظمة الحساسة من خلال تقنيات. منع تسريب\r\nالبيانات', NULL, 'CSCC 2-6-1-3', 'Not Applicable', 40, 1, NULL, NULL, NULL, 1, NULL, NULL, 802, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(806, 'CSCC 2-6-1-4', 'CSCC 2-6-1-4', 'تحديد مدة الاحتفاظ المطلوبة  لبيانات الأعمال المتعلقة\r\nبالأنظمة الحساسة؛ حسب التشريعات ذات العلاقة. ويتم الاحتفاظ بالبيانات\r\nالمطلوبة فقط» في بينات الإنتاج للأنظمة الحساسة', NULL, 'CSCC 2-6-1-4', 'Not Applicable', 40, 1, NULL, NULL, NULL, 1, NULL, NULL, 802, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(807, 'CSCC 2-6-1-5', 'CSCC 2-6-1-5', 'منع نقل أي من بيانات بيئة الإنتاج الخاصة بالأنظمة الحساسة إلى أي بيئة أخرى.', NULL, 'CSCC 2-6-1-5', 'Not Applicable', 40, 1, NULL, NULL, NULL, 1, NULL, NULL, 802, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(808, 'CSCC 2-7-1', 'CSCC 2-7-1', 'بالإضافة للضوابط الفرعية ضمن الضابط ‎٣ - ٨ - ٢‏ في الضوابط الأساسية للأمن السيبراني. يجب أن تغطي\r\nمتطلبات الآمن السيبراني للتشفير.', NULL, 'CSCC 2-7-1', 'Not Applicable', 41, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(809, 'CSCC 2-7-1-1', 'CSCC 2-7-1-1', 'تشفير جميع بيانات الأنظمة الحساسة؛ أثناء النقل   ansit-In-Data.)', NULL, 'CSCC 2-7-1-1', 'Not Applicable', 41, 1, NULL, NULL, NULL, 1, NULL, NULL, 808, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(810, 'CSCC 2-7-1-2', 'CSCC 2-7-1-2', 'تشفير جميع بيانات الأنظمة الحساسة؛ أثناء التخزين  على مستوى\r\nالملفات. أو قاعدة البيانات. أو على مستوى أعمدة محددة. داخل قاعدة البيانات.', NULL, 'CSCC 2-7-1-2', 'Not Applicable', 41, 1, NULL, NULL, NULL, 1, NULL, NULL, 808, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(811, 'CSCC 2-7-1-3', 'CSCC 2-7-1-3', 'استخدام طرق وخوارزميات ومفاتيح وأجهزة تشفير محدثة وآمنة وفقاً لما تصدره\r\nالهيئة بهذا الشأن', NULL, 'CSCC 2-7-1-3', 'Not Applicable', 41, 1, NULL, NULL, NULL, 1, NULL, NULL, 808, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(812, 'CSCC 2-8-1', 'CSCC 2-8-1', 'بالإضافة للضوابط الفرعية ضمن الضابط ‎٣ - 9 - ٢‏ في الضوابط الأساسية للأمن السيبراني. يجب أن تغطي متطلبات الأمن السيبراني لإدارة النسخ الاحتياطية', NULL, 'CSCC 2-8-1', 'Not Applicable', 42, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(813, 'CSCC 2-8-1-1', 'CSCC 2-8-1-1', 'نطاق عمل النسخ الاحتياطي المتصل. وغير المتصل )Backup Offline and Online\r\nليشمل جميع الأنظمة الحساسة.', NULL, 'CSCC 2-8-1-1', 'Not Applicable', 42, 1, NULL, NULL, NULL, 1, NULL, NULL, 812, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(814, 'CSCC 2-8-1-2', 'CSCC 2-8-1-2', 'عمل النسخ الاحتياطي على فترات زمنية مخطط لها؛ بناء على تقييم المخاطر للجهة\r\nوتوصي الهيئة بأن يتم عمل النسخ الاحتياطي. للأنظمة الحساسة. بشكل يومي.', NULL, 'CSCC 2-8-1-2', 'Not Applicable', 42, 1, NULL, NULL, NULL, 1, NULL, NULL, 812, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(815, 'CSCC 2-8-1-3', 'CSCC 2-8-1-3', 'تأمين الوصول. والتخزين. والنقل لمحتوى النسخ الاحتياطية للأنظمة الحساسة\r\nووسائطهاء وحمايتها من الإتلاف. أو التعديل. أو الاطلاع غير المصرح به.', NULL, 'CSCC 2-8-1-3', 'Not Applicable', 42, 1, NULL, NULL, NULL, 1, NULL, NULL, 812, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(816, 'CSCC 2-8-2', 'CSCC 2-8-2', 'جوعا للضابط ‎٣ - ٩ - ٢‏ - © في الضوابط الأساسية للأمن السيبراني. يجب إجراء فحص دوري؛ كل ثلاثة\r\nأشهر على الأقل. لتحديد مدى فعالية استعادة النسخ الاحتياطية. الخاصة بالأنظمة الحساسة.', NULL, 'CSCC 2-8-2', 'Not Applicable', 42, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(817, 'CSCC 2-9-1', 'CSCC 2-9-1', 'بالإضافة للضوابط الفرعية ضمن الضابط ‎٣ - ٠١ - ٢‏ في الضوابط الأساسية للأمن السيبراني. يجب أن\r\nتغطي متطلبات الأمن السيبراني لإدارة الثغرات للأنظمة الحساسة', NULL, 'CSCC 2-9-1', 'Not Applicable', 43, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(818, 'CSCC 2-9-1-1', 'CSCC 2-9-1-1', 'استخدام وسائل وأدوات موثوقة لإكتشاف الثغرات.', NULL, 'CSCC 2-9-1-1', 'Not Applicable', 43, 1, NULL, NULL, NULL, 1, NULL, NULL, 817, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(819, 'CSCC 2-9-1-2', 'CSCC 2-9-1-2', 'تقييم الثغرات ومعالجتها (بتنصيب حزم التحديثات والإصلاحات) على المكونات\r\nالتقنية للأنظمة الحساسة. مرة واحدة شهريا. على الأقل. للأنظمة الحساسة الخارجية.\r\nوالمتصلة بالإنترنت؛ وكل ثلاثة أشهر على الأقل. للأنظمة الحساسة الداخلية.', NULL, 'CSCC 2-9-1-2', 'Not Applicable', 43, 1, NULL, NULL, NULL, 1, NULL, NULL, 817, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(820, 'CSCC 2-9-1-3', 'CSCC 2-9-1-3', 'معالجة فورية للثغرات الحرجة )) المكتشفة حديثا؟ مع\r\nاتباع آليات إدارة التغيير. المعتمدة لدى الجهة.', NULL, 'CSCC 2-9-1-3', 'Not Applicable', 43, 1, NULL, NULL, NULL, 1, NULL, NULL, 817, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(821, 'CSCC 2-9-2', 'CSCC 2-9-2', 'رجوعا للضابط ‎١ - ٣ - ١٠ - ٢‏ في الضوابط الأساسية للأمن السيبراني\r\nالمكونات التقنية. للأنظمة الحساسة. مرة واحدة شهريا على الأقل.', NULL, 'CSCC 2-9-2', 'Not Applicable', 43, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(822, 'CSCC 2-10-1', 'CSCC 2-10-1', 'بالإضافة للضوابط الفرعية ضمن الضابط ‎٣ - ١١ - ٢‏ في الضوابط الأساسية للأمن السيبراني. يجب أن\r\nتغطي متطلبات الأمن السيبراني لاختبار الاختراق للأنظمة الحساسة', NULL, 'CSCC 2-10-1', 'Not Applicable', 44, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(823, 'CSCC 2-10-1-1', 'CSCC 2-10-1-1', 'نطاق عمل اختبار الاختراق. ليشمل جميع المكونات التقنية للأنظمة الحساسة.\r\nوجميع الخدمات المقدمة داخليا وخارجيا.', NULL, 'CSCC 2-10-1-1', 'Not Applicable', 44, 1, NULL, NULL, NULL, 1, NULL, NULL, 822, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(824, 'CSCC 2-10-1-2', 'CSCC 2-10-1-2', 'عمل اختبار الاختراق من قبل فريق مؤهل.', NULL, 'CSCC 2-10-1-2', 'Not Applicable', 44, 1, NULL, NULL, NULL, 1, NULL, NULL, 822, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(825, 'CSCC 2-10-2', 'CSCC 2-10-2', '‏رجوعا للضابط ‎٢ - ٣ - ١١ - ٢‏ في الضوابط الأساسية للأمن السيبراني. يجب عمل اختبار الاختراق على\r\nالأنظمة الحساسة. كل ستة أشهر؛ على الأقل', NULL, 'CSCC 2-10-2', 'Not Applicable', 44, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(826, 'CSCC 2-11-1', 'CSCC 2-11-1', '‏بالإضافة للضوابط الفرعية ضمن الضابط ‎٣ - ١٢ - ٢‏ في الضوابط الأساسية للأمن السيبراني. يجب أن\r\n‏تغطي متطلبات إدارة سجلات الأحداث\" ومراقبة الأمن السيبراني للأنظمة الحساسة', NULL, 'CSCC 2-11-1', 'Not Applicable', 45, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(827, 'CSCC 2-11-1-1', 'CSCC 2-11-1-1', 'تفعيل سجلات الأحداث  الخاصة بالأمن السيبراني؛ على جميع المكونات\r\nالتقنية للأنظمة الحساسة', NULL, 'CSCC 2-11-1-1', 'Not Applicable', 45, 1, NULL, NULL, NULL, 1, NULL, NULL, 826, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(828, 'CSCC 2-11-1-2', 'CSCC 2-11-1-2', 'تفعيل التنبيهات وسجلات الأحداث المتعلقة بإدارة تغييرات الملفات ) ومراقبتها', NULL, 'CSCC 2-11-1-2', 'Not Applicable', 45, 1, NULL, NULL, NULL, 1, NULL, NULL, 826, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(829, 'CSCC 2-11-1-3', 'CSCC 2-11-1-3', 'مراقبة سلوك المستخدم»UBA «Analytics Behavior U وتحليله', NULL, 'CSCC 2-11-1-3', 'Not Applicable', 45, 1, NULL, NULL, NULL, 1, NULL, NULL, 826, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(830, 'CSCC 2-11-1-4', 'CSCC 2-11-1-4', 'مراقبة سجلات الأحداث الخاصة بالأنظمة الحساسة على مدار الساعة.', NULL, 'CSCC 2-11-1-4', 'Not Applicable', 45, 1, NULL, NULL, NULL, 1, NULL, NULL, 826, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(831, 'CSCC 2-11-1-5', 'CSCC 2-11-1-5', 'الاحتفاظ بسجلات الأحداث\" الخاصة بالأمن السيبراني. المتعلقة بالأنظمة الحساسة\r\nوحمايتها! على أن تكون شاملة. ومتضمنة للتفاصيل كاملة (مثل => الوقت\" التاريخ.\r\nالهوية. النظام اممتأثر', NULL, 'CSCC 2-11-1-5', 'Not Applicable', 45, 1, NULL, NULL, NULL, 1, NULL, NULL, 826, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(832, 'CSCC 2-11-2', 'CSCC 2-11-2', 'رجوعا للضابط ‎٥ - ٣ - ١٢ - ٢‏ في الضوابط الأساسية للأمن السيبراني. يجب أن لا تقل مدة الاحتفاظ\r\nبسجلات الأحداث الخاصة بالأمن السيبراني. على الأنظمة الحساسة عن ‎١8‏ شهرا حسب المتطلبات\r\nالتشريعية. والتنظيمية. ذات العلاقة.', NULL, 'CSCC 2-11-2', 'Not Applicable', 45, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(833, 'CSCC 2-12-1', 'CSCC 2-12-1', 'بالإضافة للضوابط الفرعية ضمن الضابط ‎٣ - ١٥ - ٢‏ في الضوابط الأساسية للأمن السيبراني. يجب\r\nأن تغطي متطلبات الآمن السيبراني. لحماية تطبيقات الويب الخارجية للأنظمة الحساسة للجهة', NULL, 'CSCC 2-12-1', 'Not Applicable', 48, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(834, 'CSCC 2-12-1-1', 'CSCC 2-12-1-1', 'الإدارة الآمنة للجلسات)Management Session Secure ،). ويشمل موثوقية\r\nالجلسات (Authenticity ،). وإقفالهاLockout ،).‏ وإنهاء مهلتها Timeout.', NULL, 'CSCC 2-12-1-1', 'Not Applicable', 48, 1, NULL, NULL, NULL, 1, NULL, NULL, 833, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(835, 'CSCC 2-12-1-2', 'CSCC 2-12-1-2', 'تطبيق معايير أمن التطبيقات وحمايتها )Ten Top OWASP) في حدها الأدنى', NULL, 'CSCC 2-12-1-2', 'Not Applicable', 48, 1, NULL, NULL, NULL, 1, NULL, NULL, 833, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(836, 'CSCC 2-12-2', 'CSCC 2-12-2', '‏رجوعا للضابط ‎٢ - ٢- ١٥ - ٢‏ في الضوابط الأساسية للأمن السيبراني. يجب استخدام مبداً المعمارية\r\nذات المستويات المتعددة ture tier-M على أن لا يقل عدد المستويات عن ‎٣‏\r\n‏) -3(.', NULL, 'CSCC 2-12-2', 'Not Applicable', 48, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(837, 'CSCC 2-13-1', 'CSCC 2-13-1', '‏يجب تحديد وتوثيق واعتماد متطلبات الأمن السيبراني لحماية التطبيقات الداخلية الخاصة بالأنظمة\r\n‏الحساسة للجهة من المخاطر السيبرانية.', NULL, 'CSCC 2-13-1', 'Not Applicable', 122, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(838, 'CSCC 2-13-2', 'CSCC 2-13-2', '‏يجب تطبيق متطلبات الأمن السيبراني؛ لحماية التطبيقات الداخلية. الخاصة بالأنظمة الحساسة للجهة.', NULL, 'CSCC 2-13-2', 'Not Applicable', 122, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(839, 'CSCC 2-13-3', 'CSCC 2-13-3', '‏يجب أن تغطي متطلبات الأمن السيبراني؛ لحماية التطبيقات الداخلية. الخاصة بالأنظمة الحساسة\r\nللجهة', NULL, 'CSCC 2-13-3', 'Not Applicable', 122, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(840, 'CSCC 2-13-3-1', 'CSCC 2-13-3-1', 'استخدام مبدأ المعمارية ذات المستويات المتعددة )نه )‏ على\r\nأن لا يقل عدد المستويات عن ‎٣‏', NULL, 'CSCC 2-13-3-1', 'Not Applicable', 122, 1, NULL, NULL, NULL, 1, NULL, NULL, 839, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(841, 'CSCC 2-13-3-2', 'CSCC 2-13-3-2', '.)1117175 ‏استخدام بروتوكولات آمنة (مثل بروتوكول HTTPS', NULL, 'CSCC 2-13-3-2', 'Not Applicable', 122, 1, NULL, NULL, NULL, 1, NULL, NULL, 839, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(842, 'CSCC 2-13-3-3', 'CSCC 2-13-3-3', '‏توضيح سياسة الاستخدام الآمن للمستخدمين', NULL, 'CSCC 2-13-3-3', 'Not Applicable', 122, 1, NULL, NULL, NULL, 1, NULL, NULL, 839, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(843, 'CSCC 2-13-3-4', 'CSCC 2-13-3-4', '‏ الإدارة الآمنة للجلسات  ويشمل موثوالجلسات  وإقفالها  وإنهاء مهلتها .', NULL, 'CSCC 2-13-3-4', 'Not Applicable', 122, 1, NULL, NULL, NULL, 1, NULL, NULL, 839, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(844, 'CSCC 2-13-4', 'CSCC 2-13-4', '‏مراجعة متطلبات الأمن السيبراني لحماية التطبيقات الداخلية الخاصة بالأنظمة الحساسة للجهة دوريا.', NULL, 'CSCC 2-13-4', 'Not Applicable', 122, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(845, 'CSCC 3-1-1', 'CSCC 3-1-1', 'بالإضافة للضوابط الفرعية ضمن الضابط ‎٣ - ١ - ٣‏ في الضوابط الأساسية للأمن السيبراني. يجب أن\r\nتغطي إدارة استمرارية الأعمال في الجهة', NULL, 'CSCC 3-1-1', 'Not Applicable', 49, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(846, 'CSCC 3-1-1-1', 'CSCC 3-1-1-1', 'وضع مركز للتعافي من الكوارث للأنظمة الحساسة.', NULL, 'CSCC 3-1-1-1', 'Not Applicable', 49, 1, NULL, NULL, NULL, 1, NULL, NULL, 845, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(847, 'CSCC 3-1-1-2', 'CSCC 3-1-1-2', 'إدراج الأنظمة الحساسة؛ ضمن خطط التعافي من الكوارث', NULL, 'CSCC 3-1-1-2', 'Not Applicable', 49, 1, NULL, NULL, NULL, 1, NULL, NULL, 845, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(848, 'CSCC 3-1-1-3', 'CSCC 3-1-1-3', 'إجراء اختبارات دورية؛ للتأكد من فعالية خطط التعافي. من الكوارث للأنظمة\r\nالحساسة. مرة واحدة سنوياً؛ على الأقل', NULL, 'CSCC 3-1-1-3', 'Not Applicable', 49, 1, NULL, NULL, NULL, 1, NULL, NULL, 845, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(849, 'CSCC 3-1-1-4', 'CSCC 3-1-1-4', 'توصي الهيئة بإجراء اختبار دوري حي؛ للتعافي من الكوارث (1888 ط عن]) للأنظمة\r\nالحساسة.', NULL, 'CSCC 3-1-1-4', 'Not Applicable', 49, 1, NULL, NULL, NULL, 1, NULL, NULL, 845, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(850, 'CSCC 4-1-1', 'CSCC 4-1-1', 'بالإضافة للضوابط ضمن المكون الفرعي ع - ‎١‏ في الضوابط الأساسية للأمن السيبراني. يجب أن تغطي متطلبات الأمن السيبراني. المتعلقة بالأطراف الخارجية', NULL, 'CSCC 4-1-1', 'Not Applicable', 50, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(851, 'CSCC 4-1-1-1', 'CSCC 4-1-1-1', 'إجراء المسح الأمني لشركات خدمات الإسناد. وموظفي\r\nخدمات الإسناد. والخدمات المدارة العاملين على الأنظمة الحساسة', NULL, 'CSCC 4-1-1-1', 'Not Applicable', 50, 1, NULL, NULL, NULL, 1, NULL, NULL, 850, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(852, 'CSCC 4-1-1-2', 'CSCC 4-1-1-2', 'أن تكون خدمات الإسناد. والخدمات المدارة على الأنظمة الحساسة؛ عن طريق شركات»\r\nوجهات وطنية؛ وفقاً للمتطلبات التشريحية. والتنظيمية ذات العلاقة.', NULL, 'CSCC 4-1-1-2', 'Not Applicable', 50, 1, NULL, NULL, NULL, 1, NULL, NULL, 850, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(853, 'CSCC 4-2-1', 'CSCC 4-2-1', '‏بالإضافة للضوابط الفرعية ضمن الضابط © - ‎٣ - ٢‏ في الضوابط الأساسية للأمن السيراني. يجب أن تغطي متطلبات الأمن السيبراني الخاصة باستخدام خدمات الحوسبة السحابية والاستضافة', NULL, 'CSCC 4-2-1', 'Not Applicable', 51, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(854, 'CSCC 4-2-1-1', 'CSCC 4-2-1-1', 'أن يكون موقع استضافة الأنظمة الحساسة. أو أي جزء من مكوناتها التقنية. داخل\r\n‏الجهة. أو في خدمات الحوسبة السحابية. المقدمة من قبل جهات حكومية. أو شركات وطنية\r\n‏محققة لضوابط الحوسبة السحابية الصادرة من الهيئة مع مراعاة تصنيف البيانات المستضافة.', NULL, 'CSCC 4-2-1-1', 'Not Applicable', 51, 1, NULL, NULL, NULL, 1, NULL, NULL, 853, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(855, 'SAMA 3-1-1', 'SAMA 3-1-1', 'To direct and control the overall approach to cyber security within the Member Organization', NULL, 'SAMA 3-1-1', 'Not Applicable', 53, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(856, 'SAMA 3-1-2', 'SAMA 3-1-2', 'To ensure that cyber security initiatives and projects within the Member Organization contribute to the\r\nMember Organization’s strategic objectives and are aligned with the Banking Sector’s cyber security\r\nstrategy.', NULL, 'SAMA 3-1-2', 'Not Applicable', 54, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(857, 'SAMA 3-1-3', 'SAMA 3-1-3', 'To document the Member Organization’s commitment and objectives of cyber security, and to\r\ncommunicate this to the relevant stakeholders.', NULL, 'SAMA 3-1-3', 'Not Applicable', 55, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(858, 'SAMA 3-1-4', 'SAMA 3-1-4', 'To ensure that relevant stakeholders are aware of the responsibilities with regard to cyber security and\r\napply cyber security controls throughout the Member Organization.', NULL, 'SAMA 3-1-4', 'Not Applicable', 56, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(859, 'SAMA 3-1-5', 'SAMA 3-1-5', 'To ensure that the all the Member Organization’s projects meet cyber security requirements.', NULL, 'SAMA 3-1-5', 'Not Applicable', 57, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(860, 'SAMA 3-1-6', 'SAMA 3-1-6', 'To create a cyber security risk-aware culture where the Member Organization’s staff, third parties and\r\ncustomers make effective risk-based decisions which protect the Member Organization’s information', NULL, 'SAMA 3-1-6', 'Not Applicable', 58, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(861, 'SAMA 3-1-7', 'SAMA 3-1-7', 'To ensure that staff of the Member Organization are equipped with the skills and required knowledge to\r\nprotect the Member Organization’s information assets and to fulfil their cyber security responsibilities', NULL, 'SAMA 3-1-7', 'Not Applicable', 59, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(862, 'SAMA 3-2-1', 'SAMA 3-2-1', 'To ensure cyber security risks are properly managed to protect the confidentiality, integrity and\r\navailability of the Member Organization’s information assets, and to ensure the cyber security risk\r\nmanagement process is aligned with the Member Organization’s enterprise risk management process.', NULL, 'SAMA 3-2-1', 'Not Applicable', 60, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(863, 'SAMA 3-2-1-1', 'SAMA 3-2-1-1', 'Cyber Security Risk Identification :\r\n  To find, recognize and describe the Member Organization’s cyber security risks', NULL, 'SAMA 3-2-1-1', 'Not Applicable', 60, 1, NULL, NULL, NULL, 1, NULL, NULL, 862, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(864, 'SAMA 3-2-1-2', 'SAMA 3-2-1-2', 'Cyber Security Risk Analysis  => \r\nTo analyze and determine the nature and the level of the identified cyber security risks.', NULL, 'SAMA 3-2-1-2', 'Not Applicable', 60, 1, NULL, NULL, NULL, 1, NULL, NULL, 862, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(865, 'SAMA 3-2-1-3', 'SAMA 3-2-1-3', 'Cyber Security Risk Response  => \r\nTo ensure cyber security risks are treated (i.e., accepted, avoided, transferred or mitigated).', NULL, 'SAMA 3-2-1-3', 'Not Applicable', 60, 1, NULL, NULL, NULL, 1, NULL, NULL, 862, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(866, 'SAMA 3-2-1-4', 'SAMA 3-2-1-4', 'Cyber Risk Monitoring and Review  => To ensure that the cyber security risk treatment is performed according to the treatment plans. To ensure\r\nthat the revised or newly implemented cyber security controls are effective.', NULL, 'SAMA 3-2-1-4', 'Not Applicable', 60, 1, NULL, NULL, NULL, 1, NULL, NULL, 862, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(867, 'SAMA 3-2-2', 'SAMA 3-2-2', 'To comply with regulations affecting cyber security of the Member Organization.', NULL, 'SAMA 3-2-2', 'Not Applicable', 61, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(868, 'SAMA 3-2-3', 'SAMA 3-2-3', 'To comply with mandatory (inter)national industry standards', NULL, 'SAMA 3-2-3', 'Not Applicable', 62, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(869, 'SAMA 3-2-4', 'SAMA 3-2-4', 'To ascertain whether the cyber security controls are securely designed and implemented, and the\r\neffectiveness of these controls is being monitored.', NULL, 'SAMA 3-2-4', 'Not Applicable', 63, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(870, 'SAMA 3-2-5', 'SAMA 3-2-5', 'To ascertain with reasonable assurance whether the cyber security controls are securely designed and\r\nimplemented, and whether the effectiveness of these controls is being monitored', NULL, 'SAMA 3-2-5', 'Not Applicable', 64, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(871, 'SAMA 3-3-1', 'SAMA 3-3-1', 'To ensure that Member Organization staff’s cyber security responsibilities are embedded in staff\r\nagreements and staff are being screened before and during their employment lifecycle.', NULL, 'SAMA 3-3-1', 'Not Applicable', 65, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(872, 'SAMA 3-3-2', 'SAMA 3-3-2', 'To prevent unauthorized physical access to the Member Organization information assets and to ensure its protection.', NULL, 'SAMA 3-3-2', 'Not Applicable', 66, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(873, 'SAMA 3-3-3', 'SAMA 3-3-3', 'To support the Member Organization in having an accurate and up-to-date inventory and central insight\r\nin the physical \\/ logical location and relevant details of all available information assets, in order to support\r\nits processes, such as financial, procurement, IT and cyber security processes', NULL, 'SAMA 3-3-3', 'Not Applicable', 67, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(874, 'SAMA 3-3-4', 'SAMA 3-3-4', 'To support the Member Organization in achieving a strategic, consistent, cost effective and end-to-end\r\ncyber security architecture.', NULL, 'SAMA 3-3-4', 'Not Applicable', 68, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(875, 'SAMA 3-3-5', 'SAMA 3-3-5', 'To ensure that the Member Organization only provides authorized and sufficient access privileges to\r\napproved users', NULL, 'SAMA 3-3-5', 'Not Applicable', 69, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(876, 'SAMA 3-3-6', 'SAMA 3-3-6', 'To ensure that sufficient cyber security controls are formally documented and implemented for all\r\napplications, and that the compliance is monitored and its effectiveness is evaluated periodically within\r\nthe Member Organization.', NULL, 'SAMA 3-3-6', 'Not Applicable', 70, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(877, 'SAMA 3-3-7', 'SAMA 3-3-7', 'To ensure that all change in the information assets within the Member Organization follow a strict change control process.', NULL, 'SAMA 3-3-7', 'Not Applicable', 71, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(878, 'SAMA 3-3-8', 'SAMA 3-3-8', 'To support that all cyber security controls within the infrastructure are formally documented and the\r\ncompliance is monitored and its effectiveness is evaluated periodically within the Member Organization', NULL, 'SAMA 3-3-8', 'Not Applicable', 72, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(879, 'SAMA 3-3-9', 'SAMA 3-3-9', 'To ensure that access to and integrity of sensitive information is protected and the originator of\r\ncommunication or transactions can be confirmed', NULL, 'SAMA 3-3-9', 'Not Applicable', 73, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(880, 'SAMA 3-3-10', 'SAMA 3-3-10', 'To ensure that business and sensitive information of the Member Organization is securely handled by\r\nstaff and protected during transmission and storage, when using personal devices.', NULL, 'SAMA 3-3-10', 'Not Applicable', 74, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(881, 'SAMA 3-3-11', 'SAMA 3-3-11', 'To ensure that the Member Organization’s business, customer and other sensitive information are\r\nprotected from leakage or unauthorized disclosure when disposed', NULL, 'SAMA 3-3-11', 'Not Applicable', 75, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(882, 'SAMA 3-3-12', 'SAMA 3-3-12', 'To ensure the Member Organization safeguards the confidentiality and integrity of shared banking\r\nsystems.', NULL, 'SAMA 3-3-12', 'Not Applicable', 76, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(883, 'SAMA 3-3-13', 'SAMA 3-3-13', 'To ensure the Member Organization safeguards the confidentiality and integrity of the customer\r\ninformation and transactions.', NULL, 'SAMA 3-3-13', 'Not Applicable', 77, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL);
INSERT INTO `framework_controls` (`id`, `short_name`, `long_name`, `description`, `supplemental_guidance`, `control_number`, `control_status`, `family`, `control_owner`, `desired_maturity`, `control_priority`, `control_class`, `control_maturity`, `control_phase`, `control_type`, `parent_id`, `submission_date`, `last_audit_date`, `next_audit_date`, `desired_frequency`, `mitigation_percent`, `status`, `deleted`, `created_at`, `updated_at`) VALUES
(884, 'SAMA 3-3-14', 'SAMA 3-3-14', 'To ensure timely identification and response to anomalies or suspicious events within regard to\r\ninformation assets', NULL, 'SAMA 3-3-14', 'Not Applicable', 78, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(885, 'SAMA 3-3-15', 'SAMA 3-3-15', 'To ensure timely identification and handling of cyber security incidents in order to reduce the (potential)\r\nbusiness impact for the Member Organization.', NULL, 'SAMA 3-3-15', 'Not Applicable', 79, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(886, 'SAMA 3-3-16', 'SAMA 3-3-16', 'To obtain an adequate understanding of the Member Organization’s emerging threat posture.', NULL, 'SAMA 3-3-16', 'Not Applicable', 80, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(887, 'SAMA 3-3-17', 'SAMA 3-3-17', 'To ensure timely identification and effective mitigation of application and infrastructure vulnerabilities in order to reduce the likelihood and business impact for the Member Organization.', NULL, 'SAMA 3-3-17', 'Not Applicable', 81, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(888, 'SAMA 3-4-1', 'SAMA 3-4-1', 'To ensure that the Member Organization’s approved cyber security requirements are appropriately\r\naddressed before signing the contract, and the compliance with the cyber security requirements is being monitored and evaluated during the contract life-cycle', NULL, 'SAMA 3-4-1', 'Not Applicable', 82, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(889, 'SAMA 3-4-2', 'SAMA 3-4-2', 'To ensure that the Member Organization’s cyber security requirements are appropriately addressed\r\nbefore, during and while exiting outsourcing contracts', NULL, 'SAMA 3-4-2', 'Not Applicable', 83, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(890, 'SAMA 3-4-3', 'SAMA 3-4-3', 'To ensure that all functions and staff within the Member Organization are aware of the agreed direction\r\nand position on hybrid and public cloud services, the required process to apply for hybrid and public cloud\r\nservices, the risk appetite on hybrid and public cloud services and the specific cyber security requirements\r\nfor hybrid and public cloud services', NULL, 'SAMA 3-4-3', 'Not Applicable', 84, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(891, 'ISO A.5.1.1', 'ISO A.5.1.1', 'Policies for information security  :\r\n A set of policies for information security shall be defined, approved by management, published and communicated to employees and relevant external parties.', NULL, 'ISO A.5.1.1', 'Not Applicable', 85, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(892, 'ISO A.5.1.2', 'ISO A.5.1.2', 'Review of the policies for information security  => \r\nThe policies for information security shall be reviewed at planned intervals or if significant changes occur to ensure their continuing suitability, adequacy and effectiveness', NULL, 'ISO A.5.1.2', 'Not Applicable', 85, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(893, 'ISO A.6.1.1', 'ISO A.6.1.1', 'Information security roles and responsibilities  => \r\nAll information security responsibilities shall be defined and allocated.', NULL, 'ISO A.6.1.1', 'Not Applicable', 86, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(894, 'ISO A.6.1.2', 'ISO A.6.1.2', 'Segregation of duties  => \r\nConflicting duties and areas of responsibility shall be segregated to reduce opportunities for unauthorized or unintentional modification or misuse of the organization’s assets', NULL, 'ISO A.6.1.2', 'Not Applicable', 86, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(895, 'ISO A.6.1.3', 'ISO A.6.1.3', 'Contact with authorities  => \r\nAppropriate contacts with relevant authorities shall be maintained', NULL, 'ISO A.6.1.3', 'Not Applicable', 86, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(896, 'ISO A.6.1.4', 'ISO A.6.1.4', 'Contact with special interest groups  => \r\nAppropriate contacts with special interest groups or other specialist security forums and professional associations shall be maintained', NULL, 'ISO A.6.1.4', 'Not Applicable', 86, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(897, 'ECC 1-6-4', 'ECC 1-6-4', 'يجب مراجعة متطلبات الأمن السيبراني في إدارة المشاريع في الجهة دوريًا', NULL, 'ECC 1-6-4', 'Not Applicable', 29, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(898, 'ISO A.6.1.5', 'ISO A.6.1.5', 'Information security in project management   => \r\nInformation security shall be addressed in project management, regardless of the type of the project', NULL, 'ISO A.6.1.5', 'Not Applicable', 86, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(899, 'ISO A.6.2.1', 'ISO A.6.2.1', 'Mobile device policy  => A policy and supporting security measures shall be adopted to manage the risks introduced by using mobile devices', NULL, 'ISO A.6.2.1', 'Not Applicable', 87, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(900, 'ISO A.6.2.2', 'ISO A.6.2.2', 'Teleworking  => A policy and supporting security measures shall be implemented to protect information accessed, processed or stored at teleworking sites.', NULL, 'ISO A.6.2.2', 'Not Applicable', 87, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(901, 'ISO A.7.1.1', 'ISO A.7.1.1', 'Screening  => \r\nBackground verification checks on all candidates for employment shall be carried out in accordance with relevant laws, regulations and ethics and shall be proportional to the business requirements, the classification of the information to be accessed and the perceived risks.', NULL, 'ISO A.7.1.1', 'Not Applicable', 88, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(902, 'ISO A.7.1.2', 'ISO A.7.1.2', 'Terms and conditions of employment  => \r\nThe contractual agreements with employees and contractors shall state their and the organization’s responsibilities for information security.', NULL, 'ISO A.7.1.2', 'Not Applicable', 88, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(903, 'ISO A.7.2.1', 'ISO A.7.2.1', 'Management responsibilities  => \r\nManagement shall require all employees and contractors to apply information security in accordance with the established policies and procedures of the organization.', NULL, 'ISO A.7.2.1', 'Not Applicable', 89, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(904, 'ISO A.7.2.2', 'ISO A.7.2.2', 'Information security awareness, education and training  => \r\nAll employees of the organization and, where relevant, contractors shall receive appropriate awareness education and training and regular updates in organizational policies and procedures, as relevant for their job function.', NULL, 'ISO A.7.2.2', 'Not Applicable', 89, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(905, 'ISO A.7.2.3', 'ISO A.7.2.3', 'Disciplinary process  => \r\nThere shall be a formal and communicated disciplinary process in place to take action against employees who have committed an information security breach', NULL, 'ISO A.7.2.3', 'Not Applicable', 89, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(906, 'ISO A.7.3.1', 'ISO A.7.3.1', 'Termination or change of employment responsibilities  => \r\nInformation security responsibilities and duties that remain valid after termination or change of employment shall be defined, communicated to the employee or contractor and enforced', NULL, 'ISO A.7.3.1', 'Not Applicable', 90, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(907, 'ISO A.8.1.1', 'ISO A.8.1.1', 'Inventory of assets  => \r\nAssets associated with information and information processing facilities shall be identified and an inventory of these assets shall be drawn up and maintained.', NULL, 'ISO A.8.1.1', 'Not Applicable', 91, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(908, 'ISO A.8.1.2', 'ISO A.8.1.2', 'Ownership of assets  => \r\nAssets maintained in the inventory shall be owned.', NULL, 'ISO A.8.1.2', 'Not Applicable', 91, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(909, 'ISO A.8.1.3', 'ISO A.8.1.3', 'Acceptable use of assets  => \r\nRules for the acceptable use of information and of assets associated with information and information processing facilities shall be identified, documented and implemented.', NULL, 'ISO A.8.1.3', 'Not Applicable', 91, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(910, 'ISO A.8.1.4', 'ISO A.8.1.4', 'Return of assets  => \r\nAll employees and external party users shall return all of the organizational assets in their possession upon termination of their employment, contract or agreement.', NULL, 'ISO A.8.1.4', 'Not Applicable', 91, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(911, 'ISO A.8.2.1', 'ISO A.8.2.1', 'Classification of information  => \r\nInformation shall be classified in terms of legal requirements, value, criticality and sensitivity to unauthorized disclosure or modification', NULL, 'ISO A.8.2.1', 'Not Applicable', 92, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(912, 'ISO A.8.2.2', 'ISO A.8.2.2', 'Labeling of information  => \r\nAn appropriate set of procedures for information labeling shall be developed and implemented in accordance with the information classification scheme adopted by the organization', NULL, 'ISO A.8.2.2', 'Not Applicable', 92, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(913, 'ISO A.8.2.3', 'ISO A.8.2.3', 'Handling of assets  => \r\nProcedures for handling assets shall be developed and implemented in accordance with the information classification scheme adopted by the organization', NULL, 'ISO A.8.2.3', 'Not Applicable', 92, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(914, 'ISO A.8.3.1', 'ISO A.8.3.1', 'Management of removable media  => \r\nProcedures shall be implemented for the management of removable media in accordance with the classification scheme adopted by the organization', NULL, 'ISO A.8.3.1', 'Not Applicable', 93, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(915, 'ISO A.8.3.2', 'ISO A.8.3.2', 'Disposal of media  => \r\nMedia shall be disposed of securely when no longer required, using formal procedures.', NULL, 'ISO A.8.3.2', 'Not Applicable', 93, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(916, 'ISO A.8.3.3', 'ISO A.8.3.3', 'Physical media transfer  => \r\nMedia containing information shall be protected against unauthorized access, misuse or corruption during transportation', NULL, 'ISO A.8.3.3', 'Not Applicable', 93, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(917, 'ISO A.9.1.1', 'ISO A.9.1.1', 'Access control policy   => \r\nAn access control policy shall be established, documented and reviewed based on business and information security requirements', NULL, 'ISO A.9.1.1', 'Not Applicable', 94, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(918, 'ISO A.9.1.2', 'ISO A.9.1.2', 'Access to networks and network services  => \r\nUsers shall only be provided with access to the network and network services that they have been specifically authorized to use', NULL, 'ISO A.9.1.2', 'Not Applicable', 94, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(919, 'ISO A.9.2.1', 'ISO A.9.2.1', 'User registration and de-registration  => \r\nA formal user registration and de-registration process shall be implemented to enable assignment of access rights.', NULL, 'ISO A.9.2.1', 'Not Applicable', 95, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(920, 'ISO A.9.2.2', 'ISO A.9.2.2', 'User access provisioning  => A formal user access provisioning process shall be implemented to assign or revoke access rights for all user types to all systems and services.', NULL, 'ISO A.9.2.2', 'Not Applicable', 95, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(921, 'ISO A.9.2.3', 'ISO A.9.2.3', 'Management of privileged access rights  => \r\nThe allocation and use of privileged access rights shall be restricted and controlled.', NULL, 'ISO A.9.2.3', 'Not Applicable', 95, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(922, 'ISO A.9.2.4', 'ISO A.9.2.4', 'Management of secret authentication information of users  => \r\nThe allocation of secret authentication information shall be controlled through a formal management process.', NULL, 'ISO A.9.2.4', 'Not Applicable', 95, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(923, 'ISO A.9.2.5', 'ISO A.9.2.5', 'Review of user access rights   => \r\nAsset owners shall review users’ access rights at regular intervals.', NULL, 'ISO A.9.2.5', 'Not Applicable', 95, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(924, 'ISO A.9.2.6', 'ISO A.9.2.6', 'Removal or adjustment of access rights   => The access rights of all employees and external party users to information and information processing facilities shall be removed upon termination of their employment, contract or agreement, or adjusted upon change', NULL, 'ISO A.9.2.6', 'Not Applicable', 95, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(925, 'ISO A.9.3.1', 'ISO A.9.3.1', 'Use of secret authentication information  => \r\nUsers shall be required to follow the organization’s practices in the use of secret authentication information', NULL, 'ISO A.9.3.1', 'Not Applicable', 96, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(926, 'ISO A.9.4.1', 'ISO A.9.4.1', 'Information access restriction  => \r\nAccess to information and application system functions shall be restricted in accordance with the access control policy', NULL, 'ISO A.9.4.1', 'Not Applicable', 97, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(927, 'ISO A.9.4.2', 'ISO A.9.4.2', 'Secure log-on procedures  => \r\nWhere required by the access control policy, access to systems and applications shall be controlled by a secure log-on procedure.', NULL, 'ISO A.9.4.2', 'Not Applicable', 97, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(928, 'ISO A.9.4.3', 'ISO A.9.4.3', 'Password management system   => \r\nPassword management systems shall be interactive and shall ensure quality passwords', NULL, 'ISO A.9.4.3', 'Not Applicable', 97, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(929, 'ISO A.9.4.4', 'ISO A.9.4.4', 'Use of privileged utility programs  => \r\nThe use of utility programs that might be capable of overriding system and application controls shall be restricted and tightly controlled.', NULL, 'ISO A.9.4.4', 'Not Applicable', 97, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(930, 'ISO A.9.4.5', 'ISO A.9.4.5', 'Access control to program source code  => \r\nAccess to program source code shall be restricted.', NULL, 'ISO A.9.4.5', 'Not Applicable', 97, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(931, 'ISO A.10.1.1', 'ISO A.10.1.1', 'Policy on the use of cryptographic controls :\r\nA policy on the use of cryptographic controls for protection of information shall be developed and implemented.', NULL, 'ISO A.10.1.1', 'Not Applicable', 98, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(932, 'ISO A.10.1.2', 'ISO A.10.1.2', 'Key management   => \r\nA policy on the use, protection and lifetime of cryptographic keys shall be developed and implemented through their whole lifecycle.', NULL, 'ISO A.10.1.2', 'Not Applicable', 98, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(933, 'ISO A.11.1.1', 'ISO A.11.1.1', 'Physical security perimeter   => \r\nSecurity perimeters shall be defined and used to protect areas that contain either sensitive or critical information and information processing facilities.', NULL, 'ISO A.11.1.1', 'Not Applicable', 99, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(934, 'ISO A.11.1.2', 'ISO A.11.1.2', 'Physical entry controls  => \r\nSecure areas shall be protected by appropriate entry controls to ensure that only authorized personnel are allowed access.', NULL, 'ISO A.11.1.2', 'Not Applicable', 99, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(935, 'ISO A.11.1.3', 'ISO A.11.1.3', 'Securing offices, rooms and facilities   => \r\nPhysical security for offices, rooms and facilities shall be designed and applied.', NULL, 'ISO A.11.1.3', 'Not Applicable', 99, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(936, 'ISO A.11.1.4', 'ISO A.11.1.4', 'Protecting against external and environmental threats  => \r\nPhysical protection against natural disasters, malicious attack or accidents shall be designed and applied.', NULL, 'ISO A.11.1.4', 'Not Applicable', 99, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(937, 'ISO A.11.1.5', 'ISO A.11.1.5', 'Working in secure areas  => \r\nProcedures for working in secure areas shall be designed and applied.', NULL, 'ISO A.11.1.5', 'Not Applicable', 99, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(938, 'ISO A.11.1.6', 'ISO A.11.1.6', 'Delivery and loading areas  => \r\nAccess points such as delivery and loading areas and other points where unauthorized persons could enter the premises shall be controlled and, if possible, isolated from information processing facilities to avoid unauthorized access.', NULL, 'ISO A.11.1.6', 'Not Applicable', 99, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(939, 'ISO A.11.2.1', 'ISO A.11.2.1', 'Equipment siting and protection  => \r\nEquipment shall be sited and protected to reduce the risks from environmental threats and hazards, and opportunities for unauthorized access.', NULL, 'ISO A.11.2.1', 'Not Applicable', 100, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(940, 'ISO A.11.2.2', 'ISO A.11.2.2', 'Supporting utilities  => \r\nEquipment shall be protected from power failures and other disruptions caused by failures in supporting utilities.', NULL, 'ISO A.11.2.2', 'Not Applicable', 100, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(941, 'ISO A.11.2.3', 'ISO A.11.2.3', 'Cabling security  => \r\nPower and telecommunications cabling carrying data or supporting information services shall be protected from interception, interference or damage.', NULL, 'ISO A.11.2.3', 'Not Applicable', 100, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(942, 'ISO A.11.2.4', 'ISO A.11.2.4', 'Equipment maintenance  => \r\nEquipment shall be correctly maintained to ensure its continued availability and integrity.', NULL, 'ISO A.11.2.4', 'Not Applicable', 100, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(943, 'ISO A.11.2.5', 'ISO A.11.2.5', 'Removal of assets  => \r\nEquipment, information or software shall not be taken off-site without prior authorization.', NULL, 'ISO A.11.2.5', 'Not Applicable', 100, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(944, 'ISO A.11.2.5', 'ISO A.11.2.5', 'Removal of assets  => \r\nEquipment, information or software shall not be taken off-site without prior authorization.', NULL, 'ISO A.11.2.5', 'Not Applicable', 100, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(945, 'ISO A.11.2.6', 'ISO A.11.2.6', 'Security of equipment and assets off-premises   => \r\nSecurity shall be applied to off-site assets taking into account the different risks of working outside the organization’s premises.', NULL, 'ISO A.11.2.6', 'Not Applicable', 100, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(946, 'ISO A.11.2.7', 'ISO A.11.2.7', 'Secure disposal or reuse of equipment   => \r\nAll items of equipment containing storage media shall be verified to ensure that any sensitive data and licensed software has been removed or securely overwritten prior to disposal or re-use.', NULL, 'ISO A.11.2.7', 'Not Applicable', 100, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(947, 'ISO A.11.2.8', 'ISO A.11.2.8', 'Unattended user equipment  => \r\nUsers shall ensure that unattended equipment has appropriate protection.', NULL, 'ISO A.11.2.8', 'Not Applicable', 100, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(948, 'ISO A.11.2.9', 'ISO A.11.2.9', 'Clear desk and clear screen policy   => \r\nA clear desk policy for papers and removable storage media and a clear screen policy for information processing facilities shall be adopted.', NULL, 'ISO A.11.2.9', 'Not Applicable', 100, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(949, 'ISO A.12.1.1', 'ISO A.12.1.1', 'Documented operating procedures   => \r\nOperating procedures shall be documented and made available to all users who need them.', NULL, 'ISO A.12.1.1', 'Not Applicable', 101, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(950, 'ISO A.12.1.2', 'ISO A.12.1.2', 'Change management  => \r\nChanges to the organization, business processes, information processing facilities and systems that affect information security shall be controlled.', NULL, 'ISO A.12.1.2', 'Not Applicable', 101, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(951, 'ISO A.12.1.3', 'ISO A.12.1.3', 'Capacity management   => \r\nThe use of resources shall be monitored, tuned and projections made of future capacity requirements to ensure the required system performance.', NULL, 'ISO A.12.1.3', 'Not Applicable', 101, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(952, 'ISO A.12.1.4', 'ISO A.12.1.4', 'Separation of development, testing and operational environments   => \r\nDevelopment, testing, and operational environments shall be separated to reduce the risks of unauthorized access or changes to the operational environment.', NULL, 'ISO A.12.1.4', 'Not Applicable', 101, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(953, 'ISO A.12.2.1', 'ISO A.12.2.1', 'Controls against malware   => \r\nDetection, prevention and recovery controls to protect against malware shall be implemented, combined with appropriate user awareness.', NULL, 'ISO A.12.2.1', 'Not Applicable', 102, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(954, 'ISO A.12.3.1', 'ISO A.12.3.1', 'Information backup   => \r\nBackup copies of information, software and system images shall be taken and tested regularly in accordance with an agreed backup policy.', NULL, 'ISO A.12.3.1', 'Not Applicable', 103, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(955, 'ISO A.12.4.1', 'ISO A.12.4.1', 'Event logging   =>  \r\nEvent logs recording user activities, exceptions, faults and information security events shall be produced, kept and regularly reviewed.', NULL, 'ISO A.12.4.1', 'Not Applicable', 104, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(956, 'ISO A.12.4.2', 'ISO A.12.4.2', 'Protection of log information   => \r\nLogging facilities and log information shall be protected against tampering and unauthorized access.', NULL, 'ISO A.12.4.2', 'Not Applicable', 104, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(957, 'ISO A.12.4.3', 'ISO A.12.4.3', 'Administrator and operator logs  => \r\nSystem administrator and system operator activities shall be logged and the logs protected and regularly reviewed.', NULL, 'ISO A.12.4.3', 'Not Applicable', 104, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(958, 'ISO A.12.4.4', 'ISO A.12.4.4', 'Clock synchronization  =>   \r\nThe clocks of all relevant information processing systems within an organization or security domain shall be synchronized to a single reference time source.', NULL, 'ISO A.12.4.4', 'Not Applicable', 104, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(959, 'ISO A.12.5.1', 'ISO A.12.5.1', 'Installation of software on operational systems   => \r\nProcedures shall be implemented to control the installation of software on operational systems.', NULL, 'ISO A.12.5.1', 'Not Applicable', 105, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(960, 'ISO A.12.6.1', 'ISO A.12.6.1', 'Management of technical vulnerabilities   =>   \r\nInformation about technical vulnerabilities of information systems being used shall be obtained in a timely fashion, the organization’s exposure to such vulnerabilities evaluated and appropriate measures taken to address the associated risk.', NULL, 'ISO A.12.6.1', 'Not Applicable', 106, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(961, 'ISO A.12.6.2', 'ISO A.12.6.2', 'Restrictions on software installation   => \r\nRules governing the installation of software by users shall be established and implemented.', NULL, 'ISO A.12.6.2', 'Not Applicable', 106, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(962, 'ISO A.12.7.1', 'ISO A.12.7.1', 'Information systems audit controls  => \r\nAudit requirements and activities involving verification of operational systems shall be carefully planned and agreed to minimize disruptions to business processes.', NULL, 'ISO A.12.7.1', 'Not Applicable', 107, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(963, 'ISO A.13.1.1', 'ISO A.13.1.1', 'Network controls  => \r\nNetworks shall be managed and controlled to protect information in systems and applications.', NULL, 'ISO A.13.1.1', 'Not Applicable', 108, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(964, 'ISO A.13.1.2', 'ISO A.13.1.2', 'Security of network services  => \r\nSecurity mechanisms, service levels and management requirements of all network services shall be identified and included in network services agreements, whether these services are provided in-house or outsourced.', NULL, 'ISO A.13.1.2', 'Not Applicable', 108, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(965, 'ISO A.13.1.3', 'ISO A.13.1.3', 'Segregation in networks   => \r\nGroups of information services, users and information systems shall be segregated on networks.', NULL, 'ISO A.13.1.3', 'Not Applicable', 108, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(966, 'ISO A.13.2.1', 'ISO A.13.2.1', 'Information transfer policies and procedures   => \r\nFormal transfer policies, procedures and controls shall be in place to protect the transfer of information through the use of all types of communication facilities.', NULL, 'ISO A.13.2.1', 'Not Applicable', 109, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(967, 'ISO A.13.2.2', 'ISO A.13.2.2', 'Agreements on information transfer  :\r\nAgreements shall address the secure transfer of business information between the organization and external parties.', NULL, 'ISO A.13.2.2', 'Not Applicable', 109, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(968, 'ISO A.13.2.3', 'ISO A.13.2.3', 'Electronic messaging  => \r\nInformation involved in electronic messaging shall be appropriately protected.', NULL, 'ISO A.13.2.3', 'Not Applicable', 109, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(969, 'ISO A.13.2.4', 'ISO A.13.2.4', 'Confidentiality or nondisclosure agreements  => \r\nRequirements for confidentiality or non-disclosure agreements reflecting the organization’s needs for the protection of information shall be identified, regularly reviewed and documented.', NULL, 'ISO A.13.2.4', 'Not Applicable', 109, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(970, 'ISO A.13.2.4', 'ISO A.13.2.4', 'Confidentiality or nondisclosure agreements  => \r\nRequirements for confidentiality or non-disclosure agreements reflecting the organization’s needs for the protection of information shall be identified, regularly reviewed and documented.', NULL, 'ISO A.13.2.4', 'Not Applicable', 109, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(971, 'ISO A.14.1.1', 'ISO A.14.1.1', 'Information security requirements analysis and specification   => \r\nThe information security related requirements shall be included in the requirements for new information systems or enhancements to existing information systems.', NULL, 'ISO A.14.1.1', 'Not Applicable', 110, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(972, 'ISO A.14.1.2', 'ISO A.14.1.2', 'Securing application services on public networks  => \r\nInformation involved in application services passing over public networks shall be protected from fraudulent activity, contract dispute and unauthorized disclosure and modification.', NULL, 'ISO A.14.1.2', 'Not Applicable', 110, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(973, 'ISO A.14.1.3', 'ISO A.14.1.3', 'Protecting application services transactions  => \r\nInformation involved in application service transactions shall be protected to prevent incomplete transmission, mis-routing, unauthorized message alteration, unauthorized disclosure, unauthorized message duplication or replay', NULL, 'ISO A.14.1.3', 'Not Applicable', 110, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(974, 'ISO A.14.2.1', 'ISO A.14.2.1', 'Secure development policy  => Rules for the development of software and systems shall be established and applied to developments within the organization.', NULL, 'ISO A.14.2.1', 'Not Applicable', 111, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(975, 'ISO A.14.2.2', 'ISO A.14.2.2', 'System change control procedures  => \r\nChanges to systems within the development lifecycle shall be controlled by the use of formal change control procedures.', NULL, 'ISO A.14.2.2', 'Not Applicable', 111, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(976, 'ISO A.14.2.3', 'ISO A.14.2.3', 'Technical review of applications after operating platform changes   => \r\nWhen operating platforms are changed, business critical applications shall be reviewed and tested to ensure there is no adverse impact on organizational operations or security.', NULL, 'ISO A.14.2.3', 'Not Applicable', 111, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(977, 'ISO A.14.2.4', 'ISO A.14.2.4', 'Restrictions on changes to software packages  => \r\nModifications to software packages shall be discouraged, limited to necessary changes and all changes shall be strictly controlled.', NULL, 'ISO A.14.2.4', 'Not Applicable', 111, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(978, 'ISO A.14.2.5', 'ISO A.14.2.5', 'Secure system engineering principles  => \r\nPrinciples for engineering secure systems shall be established, documented, maintained and applied to any information system implementation efforts.', NULL, 'ISO A.14.2.5', 'Not Applicable', 111, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(979, 'ISO A.14.2.6', 'ISO A.14.2.6', 'Secure development environment   => \r\nOrganizations shall establish and appropriately protect secure development environments for system development and integration efforts that cover the entire system development lifecycle.', NULL, 'ISO A.14.2.6', 'Not Applicable', 111, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(980, 'ISO A.14.2.7', 'ISO A.14.2.7', 'Outsourced development   =>  \r\nThe organization shall supervise and monitor the activity of outsourced system development.', NULL, 'ISO A.14.2.7', 'Not Applicable', 111, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(981, 'ISO A.14.2.8', 'ISO A.14.2.8', 'System security testing  => \r\nAcceptance testing programs and related criteria shall be established for new information systems, upgrades and new versions.', NULL, 'ISO A.14.2.8', 'Not Applicable', 111, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(982, 'ISO A.14.2.9', 'ISO A.14.2.9', 'System acceptance testing  => \r\nAcceptance testing programs and related criteria shall be established for new information systems, upgrades and new versions.', NULL, 'ISO A.14.2.9', 'Not Applicable', 111, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(983, 'ISO A.14.3.1', 'ISO A.14.3.1', 'Protection of test data   => \r\nTest data shall be selected carefully, protected and controlled.', NULL, 'ISO A.14.3.1', 'Not Applicable', 112, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(984, 'ISO A.15.1.1', 'ISO A.15.1.1', 'Information security policy for supplier relationships   => \r\nInformation security requirements for mitigating the risks associated with supplier’s access to the organization’s assets shall be agreed with the supplier and documented.', NULL, 'ISO A.15.1.1', 'Not Applicable', 113, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(985, 'ISO A.15.1.2', 'ISO A.15.1.2', 'Addressing security within supplier agreements   => \r\nAll relevant information security requirements shall be established and agreed with each supplier that may access, process, store, communicate, or provide IT infrastructure components for, the organization’s information.', NULL, 'ISO A.15.1.2', 'Not Applicable', 113, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(986, 'ISO A.15.1.3', 'ISO A.15.1.3', 'Information and communication technology supply chain  => \r\nAgreements with suppliers shall include requirements to address the information security risks associated with information and communications technology services and product supply chain.', NULL, 'ISO A.15.1.3', 'Not Applicable', 113, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(987, 'ISO A.15.2.1', 'ISO A.15.2.1', 'Monitoring and review of supplier services  => \r\nOrganizations shall regularly monitor, review and audit supplier service delivery.', NULL, 'ISO A.15.2.1', 'Not Applicable', 114, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(988, 'ISO A.15.2.2', 'ISO A.15.2.2', 'Managing changes to supplier services  => \r\nChanges to the provision of services by suppliers, including maintaining and improving existing information security policies, procedures and controls, shall be managed, taking account of the criticality of business information, systems and processes involved and re-assessment of risks.', NULL, 'ISO A.15.2.2', 'Not Applicable', 114, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(989, 'ISO A.16.1.1', 'ISO A.16.1.1', 'Responsibilities and procedures  => \r\nManagement responsibilities and procedures shall be established to ensure a quick, effective and orderly response to information security incidents.', NULL, 'ISO A.16.1.1', 'Not Applicable', 115, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(990, 'ISO A.16.1.2', 'ISO A.16.1.2', 'Reporting information security events  => \r\nInformation security events shall be reported through appropriate management channels as quickly as possible.', NULL, 'ISO A.16.1.2', 'Not Applicable', 115, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(991, 'ISO A.16.1.3', 'ISO A.16.1.3', 'Reporting information security weaknesses  => \r\nEmployees and contractors using the organization’s information systems and services shall be required to note and report any observed or suspected information security weaknesses in systems or services.', NULL, 'ISO A.16.1.3', 'Not Applicable', 115, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(992, 'ISO A.16.1.4', 'ISO A.16.1.4', 'Assessment of and decision on information security events  => \r\nInformation security events shall be assessed and it shall be decided if they are to be classified as information security incidents.', NULL, 'ISO A.16.1.4', 'Not Applicable', 115, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(993, 'ISO A.16.1.5', 'ISO A.16.1.5', 'Response to information security incidents  => \r\nInformation security incidents shall be responded to in accordance with the documented procedures.', NULL, 'ISO A.16.1.5', 'Not Applicable', 115, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(994, 'ISO A.16.1.6', 'ISO A.16.1.6', 'Learning from information security incidents  => \r\nKnowledge gained from analyzing and resolving information security incidents shall be used to reduce the likelihood or impact of future incidents.', NULL, 'ISO A.16.1.6', 'Not Applicable', 115, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(995, 'ISO A.16.1.7', 'ISO A.16.1.7', 'Collection of evidence  => \r\nThe organization shall define and apply procedures for the identification, collection, acquisition and preservation of information, which can serve as evidence.', NULL, 'ISO A.16.1.7', 'Not Applicable', 115, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(996, 'ISO A.17.1.1', 'ISO A.17.1.1', 'Planning information security continuity  => \r\nThe organization shall determine its requirements for information security and the continuity of information security management in adverse situations, e.g. during a crisis or disaster.', NULL, 'ISO A.17.1.1', 'Not Applicable', 116, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(997, 'ISO A.17.1.2', 'ISO A.17.1.2', 'Implementing information security continuity  => \r\nThe organization shall establish, document, implement and maintain processes, procedures and controls to ensure the required level of continuity for information security during an adverse situation.', NULL, 'ISO A.17.1.2', 'Not Applicable', 116, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(998, 'ISO A.17.1.3', 'ISO A.17.1.3', 'Verify, review and evaluate information security continuity  => \r\nThe organization shall verify the established and implemented information security continuity controls at regular intervals in order to ensure that they are valid and effective during adverse situations.', NULL, 'ISO A.17.1.3', 'Not Applicable', 116, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(999, 'ISO A.17.2.1', 'ISO A.17.2.1', 'Availability of information processing facilities  => \r\nInformation processing facilities shall be implemented with redundancy sufficient to meet availability requirements.', NULL, 'ISO A.17.2.1', 'Not Applicable', 117, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(1000, 'ISO A.18.1.1', 'ISO A.18.1.1', 'Identification of applicable legislation and contractual requirements  =>  \r\nAll relevant legislative statutory, regulatory, contractual requirements and the organization’s approach to meet these requirements shall be explicitly identified, documented and kept up to date for each information system and the organization.', NULL, 'ISO A.18.1.1', 'Not Applicable', 118, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(1001, 'ISO A.18.1.2', 'ISO A.18.1.2', 'Intellectual property rights :\r\nAppropriate procedures shall be implemented to ensure compliance with legislative, regulatory and contractual requirements related to intellectual property rights and use of proprietary software products.', NULL, 'ISO A.18.1.2', 'Not Applicable', 118, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(1002, 'ISO A.18.1.3', 'ISO A.18.1.3', 'Protection of records  => \r\nRecords shall be protected from loss, destruction, falsification, unauthorized access and unauthorized release, in accordance with legislative, regulatory, contractual and business requirements.', NULL, 'ISO A.18.1.3', 'Not Applicable', 118, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(1003, 'ISO A.18.1.4', 'ISO A.18.1.4', 'Privacy and protection of personally identifiable information  => \r\nPrivacy and protection of personally identifiable information shall be ensured as required in relevant legislation and regulation where applicable.', NULL, 'ISO A.18.1.4', 'Not Applicable', 118, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(1004, 'ISO A.18.1.5', 'ISO A.18.1.5', 'Regulation of cryptographic controls   => \r\nCryptographic controls shall be used in compliance with all relevant agreements, legislation and regulations.', NULL, 'ISO A.18.1.5', 'Not Applicable', 118, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(1005, 'ISO A.18.2.1', 'ISO A.18.2.1', 'Independent review of information security  => \r\nThe organization’s approach to managing information security and its implementation (i.e. control objectives, controls, policies, processes and procedures for information security) shall be reviewed independently at planned intervals or when significant changes occur.', NULL, 'ISO A.18.2.1', 'Not Applicable', 119, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(1006, 'ISO A.18.2.2', 'ISO A.18.2.2', 'Compliance with security policies and standards  => \r\nManagers shall regularly review the compliance of information processing and procedures within their area of responsibility with the appropriate security policies, standards and any other security requirements.', NULL, 'ISO A.18.2.2', 'Not Applicable', 119, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(1007, 'ISO A.18.2.3', 'ISO A.18.2.3', 'Technical compliance review  => \r\nInformation systems shall be regularly reviewed for compliance with the organization’s information security policies and standards.', NULL, 'ISO A.18.2.3', 'Partially Implemented', 119, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-05 12:42:47', NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(1008, 'test_test_123', 'test_test_127', 'testing', '4', 'te_785', 'Not Applicable', 24, 6, 2, 1, 1, 1, 1, 1, NULL, '2023-08-20 15:30:11', NULL, NULL, NULL, 4, 1, 0, NULL, NULL),
(1009, 'Control2_test', 'Control2_testtt', 'asd', NULL, 'Con_8989', 'Not Applicable', 26, 6, NULL, 3, 2, NULL, 2, 1, NULL, '2023-08-20 15:47:40', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(1010, 'Roll_Control_45', 'Roll_Control_45_number', 'as', NULL, 'Con_1223', 'Partially Implemented', 53, 2, 3, 2, 2, 3, 2, 2, NULL, '2023-08-20 16:09:03', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `framework_control_mappings`
--

CREATE TABLE `framework_control_mappings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `framework_control_id` bigint(20) UNSIGNED NOT NULL,
  `framework_id` bigint(20) UNSIGNED NOT NULL,
  `reference_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `framework_control_mappings`
--

INSERT INTO `framework_control_mappings` (`id`, `framework_control_id`, `framework_id`, `reference_name`, `created_at`, `updated_at`) VALUES
(1, 5, 1, '', NULL, NULL),
(2, 6, 1, '', NULL, NULL),
(3, 7, 1, '', NULL, NULL),
(4, 8, 1, '', NULL, NULL),
(5, 9, 1, '', NULL, NULL),
(6, 10, 1, '', NULL, NULL),
(7, 11, 1, '', NULL, NULL),
(8, 12, 1, '', NULL, NULL),
(9, 13, 1, '', NULL, NULL),
(10, 14, 1, '', NULL, NULL),
(11, 15, 1, '', NULL, NULL),
(12, 16, 1, '', NULL, NULL),
(13, 17, 1, '', NULL, NULL),
(14, 18, 1, '', NULL, NULL),
(15, 19, 1, '', NULL, NULL),
(16, 20, 1, '', NULL, NULL),
(19, 21, 1, '', NULL, NULL),
(20, 22, 1, '', NULL, NULL),
(22, 23, 1, '', NULL, NULL),
(24, 24, 1, '', NULL, NULL),
(25, 25, 1, '', NULL, NULL),
(26, 26, 1, '', NULL, NULL),
(27, 27, 1, '', NULL, NULL),
(29, 28, 1, '', NULL, NULL),
(31, 29, 1, '', NULL, NULL),
(32, 30, 1, '', NULL, NULL),
(34, 31, 1, '', NULL, NULL),
(36, 32, 1, '', NULL, NULL),
(38, 33, 1, '', NULL, NULL),
(40, 34, 1, '', NULL, NULL),
(42, 35, 1, '', NULL, NULL),
(43, 36, 1, '', NULL, NULL),
(44, 37, 1, '', NULL, NULL),
(45, 38, 1, '', NULL, NULL),
(46, 39, 1, '', NULL, NULL),
(47, 40, 1, '', NULL, NULL),
(48, 41, 1, '', NULL, NULL),
(49, 42, 1, '', NULL, NULL),
(51, 43, 1, '', NULL, NULL),
(52, 44, 1, '', NULL, NULL),
(54, 45, 1, '', NULL, NULL),
(55, 46, 1, '', NULL, NULL),
(58, 47, 1, '', NULL, NULL),
(59, 48, 1, '', NULL, NULL),
(60, 49, 1, '', NULL, NULL),
(61, 50, 1, '', NULL, NULL),
(62, 51, 1, '', NULL, NULL),
(63, 52, 1, '', NULL, NULL),
(64, 53, 1, '', NULL, NULL),
(66, 54, 1, '', NULL, NULL),
(68, 55, 1, '', NULL, NULL),
(70, 56, 1, '', NULL, NULL),
(71, 57, 1, '', NULL, NULL),
(73, 58, 1, '', NULL, NULL),
(75, 59, 1, '', NULL, NULL),
(77, 60, 1, '', NULL, NULL),
(78, 61, 1, '', NULL, NULL),
(79, 62, 1, '', NULL, NULL),
(80, 63, 1, '', NULL, NULL),
(81, 64, 1, '', NULL, NULL),
(82, 65, 1, '', NULL, NULL),
(83, 66, 1, '', NULL, NULL),
(84, 67, 1, '', NULL, NULL),
(85, 68, 1, '', NULL, NULL),
(86, 69, 1, '', NULL, NULL),
(87, 70, 1, '', NULL, NULL),
(90, 71, 1, '', NULL, NULL),
(91, 72, 1, '', NULL, NULL),
(93, 73, 1, '', NULL, NULL),
(96, 74, 1, '', NULL, NULL),
(97, 75, 1, '', NULL, NULL),
(98, 76, 1, '', NULL, NULL),
(99, 77, 1, '', NULL, NULL),
(100, 78, 1, '', NULL, NULL),
(102, 79, 1, '', NULL, NULL),
(103, 80, 1, '', NULL, NULL),
(105, 81, 1, '', NULL, NULL),
(107, 82, 1, '', NULL, NULL),
(109, 83, 1, '', NULL, NULL),
(110, 84, 1, '', NULL, NULL),
(111, 85, 1, '', NULL, NULL),
(112, 86, 1, '', NULL, NULL),
(113, 87, 1, '', NULL, NULL),
(115, 88, 1, '', NULL, NULL),
(117, 89, 1, '', NULL, NULL),
(119, 90, 1, '', NULL, NULL),
(122, 91, 1, '', NULL, NULL),
(123, 92, 1, '', NULL, NULL),
(124, 93, 1, '', NULL, NULL),
(125, 94, 1, '', NULL, NULL),
(126, 95, 1, '', NULL, NULL),
(128, 96, 1, '', NULL, NULL),
(129, 97, 1, '', NULL, NULL),
(131, 98, 1, '', NULL, NULL),
(134, 99, 1, '', NULL, NULL),
(135, 100, 1, '', NULL, NULL),
(137, 101, 1, '', NULL, NULL),
(139, 102, 1, '', NULL, NULL),
(141, 103, 1, '', NULL, NULL),
(143, 104, 1, '', NULL, NULL),
(144, 105, 1, '', NULL, NULL),
(145, 106, 1, '', NULL, NULL),
(146, 107, 1, '', NULL, NULL),
(147, 108, 1, '', NULL, NULL),
(149, 109, 1, '', NULL, NULL),
(151, 110, 1, '', NULL, NULL),
(154, 111, 1, '', NULL, NULL),
(155, 112, 1, '', NULL, NULL),
(156, 113, 1, '', NULL, NULL),
(157, 114, 1, '', NULL, NULL),
(158, 115, 1, '', NULL, NULL),
(160, 116, 1, '', NULL, NULL),
(161, 117, 1, '', NULL, NULL),
(163, 118, 1, '', NULL, NULL),
(165, 119, 1, '', NULL, NULL),
(166, 120, 1, '', NULL, NULL),
(167, 121, 1, '', NULL, NULL),
(168, 122, 1, '', NULL, NULL),
(169, 123, 1, '', NULL, NULL),
(171, 124, 1, '', NULL, NULL),
(173, 125, 1, '', NULL, NULL),
(175, 126, 1, '', NULL, NULL),
(176, 127, 1, '', NULL, NULL),
(177, 128, 1, '', NULL, NULL),
(178, 129, 1, '', NULL, NULL),
(179, 130, 1, '', NULL, NULL),
(181, 131, 1, '', NULL, NULL),
(183, 132, 1, '', NULL, NULL),
(185, 133, 1, '', NULL, NULL),
(186, 134, 1, '', NULL, NULL),
(187, 135, 1, '', NULL, NULL),
(188, 136, 1, '', NULL, NULL),
(189, 137, 1, '', NULL, NULL),
(192, 138, 1, '', NULL, NULL),
(193, 139, 1, '', NULL, NULL),
(195, 140, 1, '', NULL, NULL),
(198, 141, 1, '', NULL, NULL),
(199, 142, 1, '', NULL, NULL),
(200, 143, 1, '', NULL, NULL),
(201, 144, 1, '', NULL, NULL),
(202, 145, 1, '', NULL, NULL),
(203, 146, 1, '', NULL, NULL),
(205, 147, 1, '', NULL, NULL),
(207, 148, 1, '', NULL, NULL),
(208, 149, 1, '', NULL, NULL),
(209, 150, 1, '', NULL, NULL),
(210, 151, 1, '', NULL, NULL),
(211, 152, 1, '', NULL, NULL),
(213, 153, 1, '', NULL, NULL),
(215, 154, 1, '', NULL, NULL),
(218, 155, 1, '', NULL, NULL),
(219, 156, 1, '', NULL, NULL),
(221, 157, 1, '', NULL, NULL),
(222, 158, 1, '', NULL, NULL),
(223, 159, 1, '', NULL, NULL),
(224, 160, 1, '', NULL, NULL),
(225, 161, 1, '', NULL, NULL),
(227, 162, 1, '', NULL, NULL),
(230, 163, 1, '', NULL, NULL),
(231, 164, 1, '', NULL, NULL),
(233, 165, 1, '', NULL, NULL),
(235, 166, 1, '', NULL, NULL),
(236, 167, 1, '', NULL, NULL),
(237, 168, 1, '', NULL, NULL),
(238, 169, 1, '', NULL, NULL),
(239, 170, 1, '', NULL, NULL),
(241, 171, 1, '', NULL, NULL),
(243, 172, 1, '', NULL, NULL),
(245, 173, 1, '', NULL, NULL),
(247, 174, 1, '', NULL, NULL),
(249, 175, 1, '', NULL, NULL),
(250, 176, 1, '', NULL, NULL),
(251, 177, 1, '', NULL, NULL),
(252, 178, 1, '', NULL, NULL),
(253, 179, 1, '', NULL, NULL),
(256, 180, 1, '', NULL, NULL),
(257, 181, 1, '', NULL, NULL),
(259, 182, 1, '', NULL, NULL),
(262, 183, 1, '', NULL, NULL),
(263, 184, 1, '', NULL, NULL),
(264, 185, 1, '', NULL, NULL),
(265, 186, 1, '', NULL, NULL),
(266, 187, 1, '', NULL, NULL),
(267, 188, 1, '', NULL, NULL),
(269, 189, 1, '', NULL, NULL),
(271, 190, 1, '', NULL, NULL),
(273, 191, 1, '', NULL, NULL),
(274, 192, 1, '', NULL, NULL),
(275, 193, 1, '', NULL, NULL),
(276, 194, 1, '', NULL, NULL),
(278, 195, 1, '', NULL, NULL),
(280, 196, 1, '', NULL, NULL),
(282, 197, 1, '', NULL, NULL),
(283, 198, 1, '', NULL, NULL),
(285, 199, 1, '', NULL, NULL),
(287, 200, 1, '', NULL, NULL),
(288, 201, 1, '', NULL, NULL),
(289, 202, 1, '', NULL, NULL),
(290, 203, 1, '', NULL, NULL),
(291, 204, 1, '', NULL, NULL),
(294, 205, 1, '', NULL, NULL),
(295, 206, 1, '', NULL, NULL),
(297, 207, 1, '', NULL, NULL),
(298, 208, 1, '', NULL, NULL),
(299, 209, 1, '', NULL, NULL),
(300, 210, 1, '', NULL, NULL),
(301, 211, 1, '', NULL, NULL),
(303, 212, 1, '', NULL, NULL),
(305, 213, 1, '', NULL, NULL),
(307, 214, 1, '', NULL, NULL),
(309, 215, 1, '', NULL, NULL),
(311, 216, 1, '', NULL, NULL),
(314, 217, 1, '', NULL, NULL),
(315, 218, 1, '', NULL, NULL),
(317, 219, 1, '', NULL, NULL),
(320, 220, 1, '', NULL, NULL),
(321, 221, 1, '', NULL, NULL),
(322, 222, 2, '', NULL, NULL),
(323, 223, 2, '', NULL, NULL),
(324, 224, 2, '', NULL, NULL),
(325, 225, 2, '', NULL, NULL),
(326, 226, 2, '', NULL, NULL),
(327, 227, 2, '', NULL, NULL),
(328, 228, 2, '', NULL, NULL),
(329, 229, 2, '', NULL, NULL),
(330, 230, 2, '', NULL, NULL),
(334, 231, 2, '', NULL, NULL),
(335, 232, 2, '', NULL, NULL),
(336, 233, 2, '', NULL, NULL),
(337, 234, 2, '', NULL, NULL),
(338, 235, 2, '', NULL, NULL),
(339, 236, 2, '', NULL, NULL),
(340, 237, 2, '', NULL, NULL),
(341, 238, 2, '', NULL, NULL),
(342, 239, 2, '', NULL, NULL),
(343, 240, 2, '', NULL, NULL),
(345, 241, 2, '', NULL, NULL),
(346, 242, 2, '', NULL, NULL),
(347, 243, 2, '', NULL, NULL),
(348, 244, 2, '', NULL, NULL),
(349, 245, 2, '', NULL, NULL),
(350, 246, 2, '', NULL, NULL),
(351, 247, 2, '', NULL, NULL),
(352, 248, 2, '', NULL, NULL),
(353, 249, 2, '', NULL, NULL),
(354, 250, 2, '', NULL, NULL),
(355, 251, 2, '', NULL, NULL),
(356, 252, 2, '', NULL, NULL),
(357, 253, 2, '', NULL, NULL),
(358, 254, 2, '', NULL, NULL),
(359, 255, 2, '', NULL, NULL),
(360, 256, 2, '', NULL, NULL),
(361, 257, 2, '', NULL, NULL),
(362, 258, 2, '', NULL, NULL),
(363, 259, 2, '', NULL, NULL),
(364, 260, 2, '', NULL, NULL),
(365, 261, 2, '', NULL, NULL),
(366, 262, 2, '', NULL, NULL),
(367, 263, 2, '', NULL, NULL),
(368, 264, 2, '', NULL, NULL),
(369, 265, 2, '', NULL, NULL),
(370, 266, 2, '', NULL, NULL),
(371, 267, 2, '', NULL, NULL),
(372, 268, 2, '', NULL, NULL),
(373, 269, 2, '', NULL, NULL),
(374, 270, 2, '', NULL, NULL),
(375, 271, 2, '', NULL, NULL),
(376, 272, 2, '', NULL, NULL),
(377, 273, 2, '', NULL, NULL),
(378, 274, 2, '', NULL, NULL),
(379, 275, 4, '', NULL, NULL),
(380, 276, 4, '', NULL, NULL),
(381, 277, 4, '', NULL, NULL),
(382, 278, 4, '', NULL, NULL),
(383, 279, 4, '', NULL, NULL),
(384, 280, 4, '', NULL, NULL),
(385, 281, 4, '', NULL, NULL),
(386, 282, 4, '', NULL, NULL),
(387, 283, 4, '', NULL, NULL),
(388, 284, 4, '', NULL, NULL),
(389, 285, 4, '', NULL, NULL),
(390, 286, 4, '', NULL, NULL),
(391, 287, 4, '', NULL, NULL),
(392, 288, 4, '', NULL, NULL),
(393, 289, 4, '', NULL, NULL),
(394, 290, 4, '', NULL, NULL),
(395, 291, 4, '', NULL, NULL),
(396, 292, 4, '', NULL, NULL),
(397, 293, 4, '', NULL, NULL),
(398, 294, 4, '', NULL, NULL),
(399, 295, 4, '', NULL, NULL),
(400, 296, 4, '', NULL, NULL),
(401, 297, 4, '', NULL, NULL),
(402, 298, 4, '', NULL, NULL),
(403, 299, 4, '', NULL, NULL),
(404, 300, 4, '', NULL, NULL),
(405, 301, 4, '', NULL, NULL),
(406, 302, 4, '', NULL, NULL),
(407, 303, 4, '', NULL, NULL),
(408, 304, 4, '', NULL, NULL),
(409, 305, 4, '', NULL, NULL),
(410, 306, 4, '', NULL, NULL),
(411, 307, 4, '', NULL, NULL),
(412, 308, 4, '', NULL, NULL),
(413, 309, 4, '', NULL, NULL),
(414, 310, 4, '', NULL, NULL),
(415, 311, 4, '', NULL, NULL),
(416, 312, 4, '', NULL, NULL),
(417, 313, 4, '', NULL, NULL),
(418, 314, 4, '', NULL, NULL),
(419, 315, 4, '', NULL, NULL),
(420, 316, 4, '', NULL, NULL),
(421, 317, 4, '', NULL, NULL),
(422, 318, 4, '', NULL, NULL),
(423, 319, 4, '', NULL, NULL),
(424, 320, 4, '', NULL, NULL),
(425, 321, 4, '', NULL, NULL),
(426, 322, 4, '', NULL, NULL),
(427, 323, 4, '', NULL, NULL),
(428, 324, 4, '', NULL, NULL),
(429, 325, 4, '', NULL, NULL),
(430, 326, 4, '', NULL, NULL),
(431, 327, 4, '', NULL, NULL),
(432, 328, 4, '', NULL, NULL),
(433, 329, 4, '', NULL, NULL),
(434, 330, 4, '', NULL, NULL),
(435, 331, 4, '', NULL, NULL),
(436, 332, 4, '', NULL, NULL),
(437, 333, 4, '', NULL, NULL),
(438, 334, 4, '', NULL, NULL),
(439, 335, 4, '', NULL, NULL),
(440, 336, 4, '', NULL, NULL),
(441, 337, 4, '', NULL, NULL),
(442, 338, 6, '', NULL, NULL),
(443, 339, 6, '', NULL, NULL),
(444, 340, 6, '', NULL, NULL),
(445, 341, 6, '', NULL, NULL),
(446, 342, 6, '', NULL, NULL),
(447, 343, 6, '', NULL, NULL),
(448, 344, 6, '', NULL, NULL),
(449, 345, 6, '', NULL, NULL),
(450, 346, 6, '', NULL, NULL),
(451, 347, 6, '', NULL, NULL),
(452, 348, 6, '', NULL, NULL),
(453, 349, 6, '', NULL, NULL),
(454, 350, 6, '', NULL, NULL),
(455, 351, 6, '', NULL, NULL),
(456, 352, 6, '', NULL, NULL),
(457, 353, 6, '', NULL, NULL),
(458, 354, 6, '', NULL, NULL),
(459, 355, 6, '', NULL, NULL),
(460, 356, 6, '', NULL, NULL),
(461, 357, 6, '', NULL, NULL),
(462, 358, 6, '', NULL, NULL),
(463, 359, 6, '', NULL, NULL),
(464, 360, 6, '', NULL, NULL),
(465, 361, 6, '', NULL, NULL),
(466, 362, 6, '', NULL, NULL),
(467, 363, 6, '', NULL, NULL),
(468, 364, 6, '', NULL, NULL),
(469, 365, 6, '', NULL, NULL),
(470, 366, 6, '', NULL, NULL),
(471, 367, 6, '', NULL, NULL),
(472, 368, 6, '', NULL, NULL),
(473, 369, 6, '', NULL, NULL),
(474, 370, 6, '', NULL, NULL),
(475, 371, 6, '', NULL, NULL),
(476, 372, 6, '', NULL, NULL),
(477, 373, 6, '', NULL, NULL),
(478, 374, 6, '', NULL, NULL),
(479, 375, 6, '', NULL, NULL),
(480, 376, 6, '', NULL, NULL),
(481, 377, 6, '', NULL, NULL),
(482, 378, 6, '', NULL, NULL),
(483, 379, 6, '', NULL, NULL),
(484, 380, 6, '', NULL, NULL),
(485, 381, 6, '', NULL, NULL),
(486, 382, 6, '', NULL, NULL),
(487, 383, 6, '', NULL, NULL),
(488, 384, 6, '', NULL, NULL),
(489, 385, 6, '', NULL, NULL),
(490, 386, 6, '', NULL, NULL),
(491, 387, 6, '', NULL, NULL),
(492, 388, 6, '', NULL, NULL),
(493, 389, 6, '', NULL, NULL),
(494, 390, 6, '', NULL, NULL),
(495, 391, 6, '', NULL, NULL),
(496, 392, 6, '', NULL, NULL),
(497, 393, 6, '', NULL, NULL),
(498, 394, 6, '', NULL, NULL),
(499, 395, 6, '', NULL, NULL),
(500, 396, 6, '', NULL, NULL),
(501, 397, 6, '', NULL, NULL),
(502, 398, 6, '', NULL, NULL),
(503, 399, 6, '', NULL, NULL),
(504, 400, 6, '', NULL, NULL),
(505, 401, 6, '', NULL, NULL),
(506, 402, 6, '', NULL, NULL),
(507, 403, 6, '', NULL, NULL),
(508, 404, 6, '', NULL, NULL),
(509, 405, 6, '', NULL, NULL),
(510, 406, 6, '', NULL, NULL),
(511, 407, 6, '', NULL, NULL),
(512, 408, 6, '', NULL, NULL),
(513, 409, 6, '', NULL, NULL),
(514, 410, 6, '', NULL, NULL),
(515, 411, 6, '', NULL, NULL),
(516, 412, 6, '', NULL, NULL),
(517, 413, 6, '', NULL, NULL),
(518, 414, 6, '', NULL, NULL),
(519, 415, 6, '', NULL, NULL),
(520, 416, 6, '', NULL, NULL),
(521, 417, 6, '', NULL, NULL),
(522, 418, 6, '', NULL, NULL),
(523, 419, 6, '', NULL, NULL),
(524, 420, 6, '', NULL, NULL),
(525, 421, 6, '', NULL, NULL),
(526, 422, 6, '', NULL, NULL),
(527, 423, 6, '', NULL, NULL),
(528, 424, 6, '', NULL, NULL),
(529, 425, 6, '', NULL, NULL),
(530, 426, 6, '', NULL, NULL),
(531, 427, 6, '', NULL, NULL),
(532, 428, 6, '', NULL, NULL),
(533, 429, 6, '', NULL, NULL),
(534, 430, 6, '', NULL, NULL),
(535, 431, 6, '', NULL, NULL),
(536, 432, 6, '', NULL, NULL),
(537, 433, 6, '', NULL, NULL),
(538, 434, 6, '', NULL, NULL),
(539, 435, 6, '', NULL, NULL),
(540, 436, 6, '', NULL, NULL),
(541, 437, 6, '', NULL, NULL),
(542, 438, 6, '', NULL, NULL),
(543, 439, 6, '', NULL, NULL),
(544, 440, 6, '', NULL, NULL),
(545, 441, 6, '', NULL, NULL),
(546, 442, 6, '', NULL, NULL),
(547, 443, 6, '', NULL, NULL),
(548, 444, 6, '', NULL, NULL),
(549, 445, 6, '', NULL, NULL),
(550, 446, 6, '', NULL, NULL),
(551, 447, 6, '', NULL, NULL),
(552, 448, 6, '', NULL, NULL),
(553, 449, 6, '', NULL, NULL),
(554, 450, 6, '', NULL, NULL),
(555, 451, 6, '', NULL, NULL),
(556, 452, 6, '', NULL, NULL),
(557, 453, 6, '', NULL, NULL),
(558, 454, 6, '', NULL, NULL),
(559, 455, 6, '', NULL, NULL),
(560, 456, 6, '', NULL, NULL),
(561, 457, 6, '', NULL, NULL),
(562, 458, 6, '', NULL, NULL),
(563, 459, 6, '', NULL, NULL),
(564, 460, 6, '', NULL, NULL),
(565, 461, 6, '', NULL, NULL),
(566, 462, 6, '', NULL, NULL),
(567, 463, 6, '', NULL, NULL),
(568, 464, 6, '', NULL, NULL),
(569, 465, 6, '', NULL, NULL),
(570, 466, 6, '', NULL, NULL),
(571, 467, 6, '', NULL, NULL),
(572, 468, 6, '', NULL, NULL),
(573, 469, 6, '', NULL, NULL),
(574, 470, 6, '', NULL, NULL),
(575, 471, 6, '', NULL, NULL),
(576, 472, 6, '', NULL, NULL),
(577, 473, 6, '', NULL, NULL),
(578, 474, 6, '', NULL, NULL),
(579, 475, 6, '', NULL, NULL),
(580, 476, 6, '', NULL, NULL),
(581, 477, 6, '', NULL, NULL),
(582, 478, 6, '', NULL, NULL),
(583, 479, 6, '', NULL, NULL),
(584, 480, 6, '', NULL, NULL),
(585, 481, 6, '', NULL, NULL),
(586, 482, 6, '', NULL, NULL),
(587, 483, 6, '', NULL, NULL),
(588, 484, 6, '', NULL, NULL),
(589, 485, 6, '', NULL, NULL),
(590, 486, 6, '', NULL, NULL),
(591, 487, 6, '', NULL, NULL),
(592, 488, 6, '', NULL, NULL),
(593, 489, 6, '', NULL, NULL),
(594, 490, 6, '', NULL, NULL),
(595, 491, 6, '', NULL, NULL),
(596, 492, 6, '', NULL, NULL),
(597, 493, 6, '', NULL, NULL),
(598, 494, 6, '', NULL, NULL),
(599, 495, 6, '', NULL, NULL),
(600, 496, 6, '', NULL, NULL),
(601, 497, 6, '', NULL, NULL),
(602, 498, 6, '', NULL, NULL),
(603, 499, 6, '', NULL, NULL),
(604, 500, 6, '', NULL, NULL),
(605, 501, 6, '', NULL, NULL),
(606, 502, 6, '', NULL, NULL),
(607, 503, 6, '', NULL, NULL),
(608, 504, 6, '', NULL, NULL),
(609, 505, 6, '', NULL, NULL),
(610, 506, 6, '', NULL, NULL),
(611, 507, 3, '', NULL, NULL),
(612, 508, 3, '', NULL, NULL),
(613, 509, 3, '', NULL, NULL),
(614, 510, 3, '', NULL, NULL),
(615, 511, 3, '', NULL, NULL),
(616, 512, 3, '', NULL, NULL),
(617, 513, 3, '', NULL, NULL),
(618, 514, 3, '', NULL, NULL),
(619, 515, 3, '', NULL, NULL),
(620, 516, 3, '', NULL, NULL),
(621, 517, 3, '', NULL, NULL),
(622, 518, 3, '', NULL, NULL),
(623, 519, 3, '', NULL, NULL),
(624, 520, 3, '', NULL, NULL),
(625, 521, 3, '', NULL, NULL),
(626, 522, 3, '', NULL, NULL),
(627, 523, 3, '', NULL, NULL),
(628, 524, 3, '', NULL, NULL),
(629, 525, 3, '', NULL, NULL),
(630, 526, 3, '', NULL, NULL),
(631, 527, 3, '', NULL, NULL),
(632, 528, 3, '', NULL, NULL),
(633, 529, 3, '', NULL, NULL),
(634, 530, 3, '', NULL, NULL),
(635, 531, 3, '', NULL, NULL),
(636, 532, 3, '', NULL, NULL),
(637, 533, 3, '', NULL, NULL),
(638, 534, 3, '', NULL, NULL),
(639, 535, 3, '', NULL, NULL),
(640, 536, 3, '', NULL, NULL),
(641, 537, 3, '', NULL, NULL),
(642, 538, 3, '', NULL, NULL),
(643, 539, 3, '', NULL, NULL),
(644, 540, 3, '', NULL, NULL),
(645, 541, 3, '', NULL, NULL),
(646, 542, 3, '', NULL, NULL),
(647, 543, 3, '', NULL, NULL),
(648, 544, 3, '', NULL, NULL),
(649, 545, 3, '', NULL, NULL),
(650, 546, 3, '', NULL, NULL),
(651, 547, 3, '', NULL, NULL),
(652, 548, 3, '', NULL, NULL),
(653, 549, 3, '', NULL, NULL),
(654, 550, 3, '', NULL, NULL),
(655, 551, 3, '', NULL, NULL),
(656, 552, 3, '', NULL, NULL),
(657, 553, 3, '', NULL, NULL),
(658, 554, 3, '', NULL, NULL),
(659, 555, 3, '', NULL, NULL),
(660, 556, 3, '', NULL, NULL),
(661, 557, 3, '', NULL, NULL),
(662, 558, 3, '', NULL, NULL),
(663, 559, 3, '', NULL, NULL),
(664, 560, 3, '', NULL, NULL),
(665, 561, 3, '', NULL, NULL),
(666, 562, 3, '', NULL, NULL),
(667, 563, 3, '', NULL, NULL),
(668, 564, 3, '', NULL, NULL),
(669, 565, 3, '', NULL, NULL),
(670, 566, 3, '', NULL, NULL),
(671, 567, 3, '', NULL, NULL),
(672, 568, 3, '', NULL, NULL),
(673, 569, 3, '', NULL, NULL),
(674, 570, 3, '', NULL, NULL),
(675, 571, 3, '', NULL, NULL),
(676, 572, 3, '', NULL, NULL),
(677, 573, 3, '', NULL, NULL),
(678, 574, 3, '', NULL, NULL),
(679, 575, 3, '', NULL, NULL),
(680, 576, 3, '', NULL, NULL),
(681, 577, 3, '', NULL, NULL),
(682, 578, 3, '', NULL, NULL),
(683, 579, 3, '', NULL, NULL),
(684, 580, 3, '', NULL, NULL),
(685, 581, 3, '', NULL, NULL),
(686, 582, 3, '', NULL, NULL),
(687, 583, 3, '', NULL, NULL),
(688, 584, 3, '', NULL, NULL),
(689, 585, 3, '', NULL, NULL),
(690, 586, 3, '', NULL, NULL),
(691, 587, 3, '', NULL, NULL),
(692, 588, 3, '', NULL, NULL),
(693, 589, 3, '', NULL, NULL),
(694, 590, 3, '', NULL, NULL),
(695, 591, 3, '', NULL, NULL),
(696, 592, 3, '', NULL, NULL),
(697, 593, 3, '', NULL, NULL),
(698, 594, 3, '', NULL, NULL),
(699, 595, 3, '', NULL, NULL),
(700, 596, 3, '', NULL, NULL),
(701, 597, 3, '', NULL, NULL),
(702, 598, 3, '', NULL, NULL),
(703, 599, 3, '', NULL, NULL),
(704, 600, 3, '', NULL, NULL),
(705, 601, 3, '', NULL, NULL),
(706, 602, 3, '', NULL, NULL),
(707, 603, 3, '', NULL, NULL),
(708, 604, 3, '', NULL, NULL),
(709, 605, 3, '', NULL, NULL),
(710, 606, 3, '', NULL, NULL),
(711, 607, 3, '', NULL, NULL),
(712, 608, 3, '', NULL, NULL),
(713, 609, 3, '', NULL, NULL),
(714, 610, 3, '', NULL, NULL),
(715, 611, 3, '', NULL, NULL),
(716, 612, 3, '', NULL, NULL),
(717, 613, 3, '', NULL, NULL),
(718, 614, 3, '', NULL, NULL),
(719, 615, 3, '', NULL, NULL),
(720, 616, 3, '', NULL, NULL),
(721, 617, 3, '', NULL, NULL),
(722, 618, 3, '', NULL, NULL),
(723, 619, 3, '', NULL, NULL),
(724, 620, 3, '', NULL, NULL),
(725, 621, 3, '', NULL, NULL),
(726, 622, 3, '', NULL, NULL),
(727, 623, 3, '', NULL, NULL),
(728, 624, 3, '', NULL, NULL),
(729, 625, 3, '', NULL, NULL),
(730, 626, 3, '', NULL, NULL),
(731, 627, 3, '', NULL, NULL),
(732, 628, 3, '', NULL, NULL),
(733, 629, 3, '', NULL, NULL),
(734, 630, 3, '', NULL, NULL),
(735, 631, 3, '', NULL, NULL),
(736, 632, 3, '', NULL, NULL),
(737, 633, 3, '', NULL, NULL),
(738, 634, 3, '', NULL, NULL),
(739, 635, 3, '', NULL, NULL),
(740, 636, 3, '', NULL, NULL),
(741, 637, 3, '', NULL, NULL),
(742, 638, 3, '', NULL, NULL),
(743, 639, 3, '', NULL, NULL),
(744, 640, 3, '', NULL, NULL),
(745, 641, 3, '', NULL, NULL),
(746, 642, 3, '', NULL, NULL),
(747, 643, 3, '', NULL, NULL),
(748, 644, 3, '', NULL, NULL),
(749, 645, 3, '', NULL, NULL),
(750, 646, 3, '', NULL, NULL),
(751, 647, 3, '', NULL, NULL),
(752, 648, 3, '', NULL, NULL),
(753, 649, 3, '', NULL, NULL),
(754, 650, 3, '', NULL, NULL),
(755, 651, 3, '', NULL, NULL),
(756, 652, 3, '', NULL, NULL),
(757, 653, 3, '', NULL, NULL),
(758, 654, 3, '', NULL, NULL),
(759, 655, 3, '', NULL, NULL),
(760, 656, 3, '', NULL, NULL),
(761, 657, 3, '', NULL, NULL),
(762, 658, 3, '', NULL, NULL),
(763, 659, 3, '', NULL, NULL),
(764, 660, 3, '', NULL, NULL),
(765, 661, 3, '', NULL, NULL),
(766, 662, 3, '', NULL, NULL),
(767, 663, 3, '', NULL, NULL),
(768, 664, 3, '', NULL, NULL),
(769, 665, 3, '', NULL, NULL),
(770, 666, 3, '', NULL, NULL),
(771, 667, 3, '', NULL, NULL),
(772, 668, 3, '', NULL, NULL),
(773, 669, 3, '', NULL, NULL),
(774, 670, 3, '', NULL, NULL),
(775, 671, 3, '', NULL, NULL),
(776, 672, 3, '', NULL, NULL),
(777, 673, 3, '', NULL, NULL),
(778, 674, 3, '', NULL, NULL),
(779, 675, 3, '', NULL, NULL),
(780, 676, 3, '', NULL, NULL),
(781, 677, 3, '', NULL, NULL),
(782, 678, 3, '', NULL, NULL),
(783, 679, 3, '', NULL, NULL),
(784, 680, 3, '', NULL, NULL),
(785, 681, 3, '', NULL, NULL),
(786, 682, 3, '', NULL, NULL),
(787, 683, 3, '', NULL, NULL),
(788, 684, 7, '', NULL, NULL),
(789, 685, 7, '', NULL, NULL),
(790, 686, 7, '', NULL, NULL),
(791, 687, 7, '', NULL, NULL),
(792, 688, 7, '', NULL, NULL),
(793, 689, 7, '', NULL, NULL),
(794, 690, 7, '', NULL, NULL),
(795, 691, 7, '', NULL, NULL),
(796, 692, 7, '', NULL, NULL),
(797, 693, 7, '', NULL, NULL),
(798, 694, 7, '', NULL, NULL),
(799, 695, 7, '', NULL, NULL),
(800, 696, 7, '', NULL, NULL),
(801, 697, 7, '', NULL, NULL),
(802, 698, 7, '', NULL, NULL),
(803, 699, 7, '', NULL, NULL),
(804, 700, 7, '', NULL, NULL),
(806, 702, 7, '', NULL, NULL),
(807, 703, 7, '', NULL, NULL),
(808, 704, 7, '', NULL, NULL),
(809, 705, 7, '', NULL, NULL),
(810, 706, 7, '', NULL, NULL),
(811, 707, 7, '', NULL, NULL),
(812, 708, 7, '', NULL, NULL),
(813, 709, 7, '', NULL, NULL),
(814, 710, 7, '', NULL, NULL),
(815, 711, 7, '', NULL, NULL),
(816, 712, 7, '', NULL, NULL),
(817, 713, 7, '', NULL, NULL),
(818, 714, 7, '', NULL, NULL),
(819, 715, 7, '', NULL, NULL),
(820, 716, 7, '', NULL, NULL),
(821, 717, 7, '', NULL, NULL),
(822, 718, 7, '', NULL, NULL),
(823, 719, 7, '', NULL, NULL),
(824, 720, 7, '', NULL, NULL),
(825, 721, 7, '', NULL, NULL),
(826, 722, 7, '', NULL, NULL),
(827, 723, 7, '', NULL, NULL),
(828, 724, 7, '', NULL, NULL),
(829, 725, 7, '', NULL, NULL),
(830, 726, 7, '', NULL, NULL),
(831, 727, 7, '', NULL, NULL),
(832, 728, 7, '', NULL, NULL),
(833, 729, 7, '', NULL, NULL),
(834, 730, 7, '', NULL, NULL),
(835, 731, 7, '', NULL, NULL),
(836, 732, 7, '', NULL, NULL),
(837, 733, 7, '', NULL, NULL),
(838, 734, 7, '', NULL, NULL),
(839, 735, 7, '', NULL, NULL),
(840, 736, 7, '', NULL, NULL),
(841, 737, 7, '', NULL, NULL),
(842, 738, 7, '', NULL, NULL),
(843, 739, 7, '', NULL, NULL),
(844, 740, 7, '', NULL, NULL),
(845, 741, 7, '', NULL, NULL),
(846, 742, 7, '', NULL, NULL),
(847, 743, 7, '', NULL, NULL),
(848, 744, 7, '', NULL, NULL),
(849, 745, 7, '', NULL, NULL),
(850, 746, 7, '', NULL, NULL),
(851, 747, 7, '', NULL, NULL),
(852, 748, 7, '', NULL, NULL),
(853, 749, 7, '', NULL, NULL),
(854, 750, 5, '', NULL, NULL),
(855, 751, 5, '', NULL, NULL),
(856, 752, 5, '', NULL, NULL),
(857, 753, 5, '', NULL, NULL),
(858, 754, 5, '', NULL, NULL),
(859, 755, 5, '', NULL, NULL),
(860, 756, 5, '', NULL, NULL),
(861, 757, 5, '', NULL, NULL),
(862, 758, 5, '', NULL, NULL),
(863, 759, 5, '', NULL, NULL),
(864, 760, 5, '', NULL, NULL),
(865, 761, 5, '', NULL, NULL),
(866, 762, 5, '', NULL, NULL),
(867, 763, 5, '', NULL, NULL),
(868, 764, 5, '', NULL, NULL),
(869, 765, 5, '', NULL, NULL),
(870, 766, 5, '', NULL, NULL),
(871, 767, 5, '', NULL, NULL),
(872, 768, 5, '', NULL, NULL),
(873, 769, 5, '', NULL, NULL),
(874, 770, 5, '', NULL, NULL),
(875, 771, 5, '', NULL, NULL),
(876, 772, 5, '', NULL, NULL),
(877, 773, 5, '', NULL, NULL),
(878, 774, 5, '', NULL, NULL),
(879, 775, 5, '', NULL, NULL),
(880, 776, 5, '', NULL, NULL),
(881, 777, 5, '', NULL, NULL),
(882, 778, 5, '', NULL, NULL),
(883, 779, 5, '', NULL, NULL),
(884, 780, 5, '', NULL, NULL),
(885, 781, 5, '', NULL, NULL),
(886, 782, 5, '', NULL, NULL),
(887, 783, 5, '', NULL, NULL),
(888, 784, 5, '', NULL, NULL),
(889, 785, 5, '', NULL, NULL),
(890, 786, 5, '', NULL, NULL),
(891, 787, 5, '', NULL, NULL),
(892, 788, 5, '', NULL, NULL),
(893, 789, 5, '', NULL, NULL),
(894, 790, 5, '', NULL, NULL),
(895, 791, 5, '', NULL, NULL),
(896, 792, 5, '', NULL, NULL),
(897, 793, 5, '', NULL, NULL),
(898, 794, 5, '', NULL, NULL),
(899, 795, 5, '', NULL, NULL),
(900, 796, 5, '', NULL, NULL),
(901, 797, 5, '', NULL, NULL),
(902, 798, 5, '', NULL, NULL),
(903, 799, 5, '', NULL, NULL),
(904, 800, 5, '', NULL, NULL),
(905, 801, 5, '', NULL, NULL),
(906, 802, 5, '', NULL, NULL),
(907, 803, 5, '', NULL, NULL),
(908, 804, 5, '', NULL, NULL),
(909, 805, 5, '', NULL, NULL),
(910, 806, 5, '', NULL, NULL),
(911, 807, 5, '', NULL, NULL),
(912, 808, 5, '', NULL, NULL),
(913, 809, 5, '', NULL, NULL),
(914, 810, 5, '', NULL, NULL),
(915, 811, 5, '', NULL, NULL),
(916, 812, 5, '', NULL, NULL),
(917, 813, 5, '', NULL, NULL),
(918, 814, 5, '', NULL, NULL),
(919, 815, 5, '', NULL, NULL),
(920, 816, 5, '', NULL, NULL),
(921, 817, 5, '', NULL, NULL),
(922, 818, 5, '', NULL, NULL),
(923, 819, 5, '', NULL, NULL),
(924, 820, 5, '', NULL, NULL),
(925, 821, 5, '', NULL, NULL),
(926, 822, 5, '', NULL, NULL),
(927, 823, 5, '', NULL, NULL),
(928, 824, 5, '', NULL, NULL),
(929, 825, 5, '', NULL, NULL),
(930, 826, 5, '', NULL, NULL),
(931, 827, 5, '', NULL, NULL),
(932, 828, 5, '', NULL, NULL),
(933, 829, 5, '', NULL, NULL),
(934, 830, 5, '', NULL, NULL),
(935, 831, 5, '', NULL, NULL),
(936, 832, 5, '', NULL, NULL),
(937, 833, 5, '', NULL, NULL),
(938, 834, 5, '', NULL, NULL),
(939, 835, 5, '', NULL, NULL),
(940, 836, 5, '', NULL, NULL),
(941, 837, 5, '', NULL, NULL),
(942, 838, 5, '', NULL, NULL),
(943, 839, 5, '', NULL, NULL),
(944, 840, 5, '', NULL, NULL),
(945, 841, 5, '', NULL, NULL),
(946, 842, 5, '', NULL, NULL),
(947, 843, 5, '', NULL, NULL),
(948, 844, 5, '', NULL, NULL),
(949, 845, 5, '', NULL, NULL),
(950, 846, 5, '', NULL, NULL),
(951, 847, 5, '', NULL, NULL),
(952, 848, 5, '', NULL, NULL),
(953, 849, 5, '', NULL, NULL),
(954, 850, 5, '', NULL, NULL),
(955, 851, 5, '', NULL, NULL),
(956, 852, 5, '', NULL, NULL),
(957, 853, 5, '', NULL, NULL),
(958, 854, 5, '', NULL, NULL),
(959, 855, 8, '', NULL, NULL),
(960, 856, 8, '', NULL, NULL),
(961, 857, 8, '', NULL, NULL),
(962, 858, 8, '', NULL, NULL),
(963, 859, 8, '', NULL, NULL),
(964, 860, 8, '', NULL, NULL),
(965, 861, 8, '', NULL, NULL),
(966, 862, 8, '', NULL, NULL),
(967, 863, 8, '', NULL, NULL),
(968, 864, 8, '', NULL, NULL),
(969, 865, 8, '', NULL, NULL),
(970, 866, 8, '', NULL, NULL),
(971, 867, 8, '', NULL, NULL),
(972, 868, 8, '', NULL, NULL),
(973, 869, 8, '', NULL, NULL),
(974, 870, 8, '', NULL, NULL),
(975, 871, 8, '', NULL, NULL),
(976, 872, 8, '', NULL, NULL),
(977, 873, 8, '', NULL, NULL),
(978, 874, 8, '', NULL, NULL),
(979, 875, 8, '', NULL, NULL),
(980, 876, 8, '', NULL, NULL),
(981, 877, 8, '', NULL, NULL),
(982, 878, 8, '', NULL, NULL),
(983, 879, 8, '', NULL, NULL),
(984, 880, 8, '', NULL, NULL),
(985, 881, 8, '', NULL, NULL),
(986, 882, 8, '', NULL, NULL),
(987, 883, 8, '', NULL, NULL),
(988, 884, 8, '', NULL, NULL),
(989, 885, 8, '', NULL, NULL),
(990, 886, 8, '', NULL, NULL),
(991, 887, 8, '', NULL, NULL),
(992, 888, 8, '', NULL, NULL),
(993, 889, 8, '', NULL, NULL),
(994, 890, 8, '', NULL, NULL),
(995, 891, 9, '', NULL, NULL),
(996, 892, 9, '', NULL, NULL),
(997, 893, 9, '', NULL, NULL),
(998, 894, 9, '', NULL, NULL),
(999, 895, 9, '', NULL, NULL),
(1000, 896, 9, '', NULL, NULL),
(1001, 897, 1, '', NULL, NULL),
(1002, 898, 9, '', NULL, NULL),
(1003, 899, 9, '', NULL, NULL),
(1004, 900, 9, '', NULL, NULL),
(1005, 901, 9, '', NULL, NULL),
(1006, 902, 9, '', NULL, NULL),
(1007, 903, 9, '', NULL, NULL),
(1008, 904, 9, '', NULL, NULL),
(1009, 905, 9, '', NULL, NULL),
(1010, 906, 9, '', NULL, NULL),
(1011, 907, 9, '', NULL, NULL),
(1012, 908, 9, '', NULL, NULL),
(1013, 909, 9, '', NULL, NULL),
(1014, 910, 9, '', NULL, NULL),
(1015, 911, 9, '', NULL, NULL),
(1016, 912, 9, '', NULL, NULL),
(1017, 913, 9, '', NULL, NULL),
(1018, 914, 9, '', NULL, NULL),
(1019, 915, 9, '', NULL, NULL),
(1020, 916, 9, '', NULL, NULL),
(1021, 917, 9, '', NULL, NULL),
(1022, 918, 9, '', NULL, NULL),
(1023, 919, 9, '', NULL, NULL),
(1024, 920, 9, '', NULL, NULL),
(1025, 921, 9, '', NULL, NULL),
(1026, 922, 9, '', NULL, NULL),
(1027, 923, 9, '', NULL, NULL),
(1028, 924, 9, '', NULL, NULL),
(1029, 925, 9, '', NULL, NULL),
(1030, 926, 9, '', NULL, NULL),
(1031, 701, 7, '', NULL, NULL),
(1032, 927, 9, '', NULL, NULL),
(1033, 928, 9, '', NULL, NULL),
(1034, 929, 9, '', NULL, NULL),
(1035, 930, 9, '', NULL, NULL),
(1036, 931, 9, '', NULL, NULL),
(1037, 932, 9, '', NULL, NULL),
(1038, 933, 9, '', NULL, NULL),
(1039, 934, 9, '', NULL, NULL),
(1040, 935, 9, '', NULL, NULL),
(1041, 936, 9, '', NULL, NULL),
(1042, 937, 9, '', NULL, NULL),
(1043, 938, 9, '', NULL, NULL),
(1044, 939, 9, '', NULL, NULL),
(1045, 940, 9, '', NULL, NULL),
(1046, 941, 9, '', NULL, NULL),
(1047, 942, 9, '', NULL, NULL),
(1048, 943, 9, '', NULL, NULL),
(1049, 944, 9, '', NULL, NULL),
(1050, 945, 9, '', NULL, NULL),
(1051, 946, 9, '', NULL, NULL),
(1052, 947, 9, '', NULL, NULL),
(1053, 948, 9, '', NULL, NULL),
(1054, 949, 9, '', NULL, NULL),
(1055, 950, 9, '', NULL, NULL),
(1056, 951, 9, '', NULL, NULL),
(1057, 952, 9, '', NULL, NULL),
(1058, 953, 9, '', NULL, NULL),
(1059, 954, 9, '', NULL, NULL),
(1060, 955, 9, '', NULL, NULL),
(1061, 956, 9, '', NULL, NULL),
(1062, 957, 9, '', NULL, NULL),
(1063, 958, 9, '', NULL, NULL),
(1064, 959, 9, '', NULL, NULL),
(1065, 960, 9, '', NULL, NULL),
(1066, 961, 9, '', NULL, NULL),
(1067, 962, 9, '', NULL, NULL),
(1068, 963, 9, '', NULL, NULL),
(1069, 964, 9, '', NULL, NULL),
(1070, 965, 9, '', NULL, NULL),
(1071, 966, 9, '', NULL, NULL),
(1072, 967, 9, '', NULL, NULL),
(1073, 968, 9, '', NULL, NULL),
(1074, 969, 9, '', NULL, NULL),
(1075, 970, 9, '', NULL, NULL),
(1076, 971, 9, '', NULL, NULL),
(1077, 972, 9, '', NULL, NULL),
(1078, 973, 9, '', NULL, NULL),
(1079, 974, 9, '', NULL, NULL),
(1080, 975, 9, '', NULL, NULL),
(1081, 976, 9, '', NULL, NULL),
(1082, 977, 9, '', NULL, NULL),
(1083, 978, 9, '', NULL, NULL),
(1084, 979, 9, '', NULL, NULL),
(1085, 980, 9, '', NULL, NULL),
(1086, 981, 9, '', NULL, NULL),
(1087, 982, 9, '', NULL, NULL),
(1088, 983, 9, '', NULL, NULL),
(1089, 984, 9, '', NULL, NULL),
(1090, 985, 9, '', NULL, NULL),
(1091, 986, 9, '', NULL, NULL),
(1092, 987, 9, '', NULL, NULL),
(1093, 988, 9, '', NULL, NULL),
(1094, 989, 9, '', NULL, NULL),
(1095, 990, 9, '', NULL, NULL),
(1096, 991, 9, '', NULL, NULL),
(1097, 992, 9, '', NULL, NULL),
(1098, 993, 9, '', NULL, NULL),
(1099, 994, 9, '', NULL, NULL),
(1100, 995, 9, '', NULL, NULL),
(1101, 996, 9, '', NULL, NULL),
(1102, 997, 9, '', NULL, NULL),
(1103, 998, 9, '', NULL, NULL),
(1104, 999, 9, '', NULL, NULL),
(1105, 1000, 9, '', NULL, NULL),
(1106, 1001, 9, '', NULL, NULL),
(1107, 1002, 9, '', NULL, NULL),
(1108, 1003, 9, '', NULL, NULL),
(1109, 1004, 9, '', NULL, NULL),
(1110, 1005, 9, '', NULL, NULL),
(1111, 1006, 9, '', NULL, NULL),
(1112, 1007, 9, '', NULL, NULL),
(1113, 1008, 1, '', NULL, NULL),
(1114, 1009, 2, '', NULL, NULL),
(1115, 1010, 8, '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `framework_control_tests`
--

CREATE TABLE `framework_control_tests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tester` bigint(20) UNSIGNED NOT NULL,
  `test_frequency` int(11) DEFAULT 0,
  `last_date` date DEFAULT NULL,
  `next_date` date DEFAULT NULL,
  `name` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `objective` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `test_steps` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approximate_time` int(11) DEFAULT NULL,
  `expected_results` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `framework_control_id` bigint(20) UNSIGNED DEFAULT NULL,
  `desired_frequency` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT 1,
  `additional_stakeholders` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `framework_control_tests`
--

INSERT INTO `framework_control_tests` (`id`, `tester`, `test_frequency`, `last_date`, `next_date`, `name`, `objective`, `test_steps`, `approximate_time`, `expected_results`, `framework_control_id`, `desired_frequency`, `status`, `additional_stakeholders`, `created_at`, `updated_at`) VALUES
(5, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-1-1', NULL, NULL, NULL, NULL, 5, NULL, 1, NULL, NULL, NULL),
(6, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-1-2', NULL, NULL, NULL, NULL, 6, NULL, 1, NULL, NULL, NULL),
(7, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-1-3', NULL, NULL, NULL, NULL, 7, NULL, 1, NULL, NULL, NULL),
(8, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-2-1', NULL, NULL, NULL, NULL, 8, NULL, 1, NULL, NULL, NULL),
(9, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-2-2', NULL, NULL, NULL, NULL, 9, NULL, 1, NULL, NULL, NULL),
(10, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-2-3', NULL, NULL, NULL, NULL, 10, NULL, 1, NULL, NULL, NULL),
(11, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-3-1', NULL, NULL, NULL, NULL, 11, NULL, 1, NULL, NULL, NULL),
(12, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-3-2', NULL, NULL, NULL, NULL, 12, NULL, 1, NULL, NULL, NULL),
(13, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-3-3', NULL, NULL, NULL, NULL, 13, NULL, 1, NULL, NULL, NULL),
(14, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-3-4', NULL, NULL, NULL, NULL, 14, NULL, 1, NULL, NULL, NULL),
(15, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-4-1', NULL, NULL, NULL, NULL, 15, NULL, 1, NULL, NULL, NULL),
(16, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-4-2', NULL, NULL, NULL, NULL, 16, NULL, 1, NULL, NULL, NULL),
(17, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-5-1', NULL, NULL, NULL, NULL, 17, NULL, 1, NULL, NULL, NULL),
(18, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-5-2', NULL, NULL, NULL, NULL, 18, NULL, 1, NULL, NULL, NULL),
(19, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-5-3', NULL, NULL, NULL, NULL, 19, NULL, 1, NULL, NULL, NULL),
(20, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-5-3-1', NULL, NULL, NULL, NULL, 20, NULL, 1, NULL, NULL, NULL),
(21, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-5-3-2', NULL, NULL, NULL, NULL, 21, NULL, 1, NULL, NULL, NULL),
(22, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-5-3-3', NULL, NULL, NULL, NULL, 22, NULL, 1, NULL, NULL, NULL),
(23, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-5-3-4', NULL, NULL, NULL, NULL, 23, NULL, 1, NULL, NULL, NULL),
(24, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-5-4', NULL, NULL, NULL, NULL, 24, NULL, 1, NULL, NULL, NULL),
(25, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-6-1', NULL, NULL, NULL, NULL, 25, NULL, 1, NULL, NULL, NULL),
(26, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-6-2', NULL, NULL, NULL, NULL, 26, NULL, 1, NULL, NULL, NULL),
(27, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-6-2-1', NULL, NULL, NULL, NULL, 27, NULL, 1, NULL, NULL, NULL),
(28, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-6-2-2', NULL, NULL, NULL, NULL, 28, NULL, 1, NULL, NULL, NULL),
(29, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-6-3', NULL, NULL, NULL, NULL, 29, NULL, 1, NULL, NULL, NULL),
(30, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-6-3-1', NULL, NULL, NULL, NULL, 30, NULL, 1, NULL, NULL, NULL),
(31, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-6-3-2', NULL, NULL, NULL, NULL, 31, NULL, 1, NULL, NULL, NULL),
(32, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-6-3-3', NULL, NULL, NULL, NULL, 32, NULL, 1, NULL, NULL, NULL),
(33, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-6-3-4', NULL, NULL, NULL, NULL, 33, NULL, 1, NULL, NULL, NULL),
(34, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-6-3-5', NULL, NULL, NULL, NULL, 34, NULL, 1, NULL, NULL, NULL),
(35, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-7-1', NULL, NULL, NULL, NULL, 35, NULL, 1, NULL, NULL, NULL),
(36, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-7-2', NULL, NULL, NULL, NULL, 36, NULL, 1, NULL, NULL, NULL),
(37, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-8-1', NULL, NULL, NULL, NULL, 37, NULL, 1, NULL, NULL, NULL),
(38, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-8-2', NULL, NULL, NULL, NULL, 38, NULL, 1, NULL, NULL, NULL),
(39, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-8-3', NULL, NULL, NULL, NULL, 39, NULL, 1, NULL, NULL, NULL),
(40, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-9-1', NULL, NULL, NULL, NULL, 40, NULL, 1, NULL, NULL, NULL),
(41, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-9-2', NULL, NULL, NULL, NULL, 41, NULL, 1, NULL, NULL, NULL),
(42, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-9-3', NULL, NULL, NULL, NULL, 42, NULL, 1, NULL, NULL, NULL),
(43, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-9-3-1', NULL, NULL, NULL, NULL, 43, NULL, 1, NULL, NULL, NULL),
(44, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-9-3-2', NULL, NULL, NULL, NULL, 44, NULL, 1, NULL, NULL, NULL),
(45, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-9-4', NULL, NULL, NULL, NULL, 45, NULL, 1, NULL, NULL, NULL),
(46, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-9-4-1', NULL, NULL, NULL, NULL, 46, NULL, 1, NULL, NULL, NULL),
(47, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-9-4-2', NULL, NULL, NULL, NULL, 47, NULL, 1, NULL, NULL, NULL),
(48, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-9-5', NULL, NULL, NULL, NULL, 48, NULL, 1, NULL, NULL, NULL),
(49, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-9-6', NULL, NULL, NULL, NULL, 49, NULL, 1, NULL, NULL, NULL),
(50, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-10-1', NULL, NULL, NULL, NULL, 50, NULL, 1, NULL, NULL, NULL),
(51, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-10-2', NULL, NULL, NULL, NULL, 51, NULL, 1, NULL, NULL, NULL),
(52, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-10-3', NULL, NULL, NULL, NULL, 52, NULL, 1, NULL, NULL, NULL),
(53, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-10-3-1', NULL, NULL, NULL, NULL, 53, NULL, 1, NULL, NULL, NULL),
(54, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-10-3-2', NULL, NULL, NULL, NULL, 54, NULL, 1, NULL, NULL, NULL),
(55, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-10-3-4', NULL, NULL, NULL, NULL, 55, NULL, 1, NULL, NULL, NULL),
(56, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-10-4', NULL, NULL, NULL, NULL, 56, NULL, 1, NULL, NULL, NULL),
(57, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-10-4-1', NULL, NULL, NULL, NULL, 57, NULL, 1, NULL, NULL, NULL),
(58, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-10-4-3', NULL, NULL, NULL, NULL, 58, NULL, 1, NULL, NULL, NULL),
(59, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-10-4-2', NULL, NULL, NULL, NULL, 59, NULL, 1, NULL, NULL, NULL),
(60, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-10-5', NULL, NULL, NULL, NULL, 60, NULL, 1, NULL, NULL, NULL),
(61, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-1-1', NULL, NULL, NULL, NULL, 61, NULL, 1, NULL, NULL, NULL),
(62, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-1-2', NULL, NULL, NULL, NULL, 62, NULL, 1, NULL, NULL, NULL),
(63, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-1-3', NULL, NULL, NULL, NULL, 63, NULL, 1, NULL, NULL, NULL),
(64, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-1-4', NULL, NULL, NULL, NULL, 64, NULL, 1, NULL, NULL, NULL),
(65, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-1-5', NULL, NULL, NULL, NULL, 65, NULL, 1, NULL, NULL, NULL),
(66, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-1-6', NULL, NULL, NULL, NULL, 66, NULL, 1, NULL, NULL, NULL),
(67, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-2-1', NULL, NULL, NULL, NULL, 67, NULL, 1, NULL, NULL, NULL),
(68, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-2-2', NULL, NULL, NULL, NULL, 68, NULL, 1, NULL, NULL, NULL),
(69, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-2-3', NULL, NULL, NULL, NULL, 69, NULL, 1, NULL, NULL, NULL),
(70, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-2-3-1', NULL, NULL, NULL, NULL, 70, NULL, 1, NULL, NULL, NULL),
(71, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-2-3-2', NULL, NULL, NULL, NULL, 71, NULL, 1, NULL, NULL, NULL),
(72, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-2-3-3', NULL, NULL, NULL, NULL, 72, NULL, 1, NULL, NULL, NULL),
(73, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-2-3-4', NULL, NULL, NULL, NULL, 73, NULL, 1, NULL, NULL, NULL),
(74, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-2-3-5', NULL, NULL, NULL, NULL, 74, NULL, 1, NULL, NULL, NULL),
(75, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-2-4', NULL, NULL, NULL, NULL, 75, NULL, 1, NULL, NULL, NULL),
(76, 1, 0, '2023-07-05', '2023-07-05', 'EEC 2-3-1', NULL, NULL, NULL, NULL, 76, NULL, 1, NULL, NULL, NULL),
(77, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-3-2', NULL, NULL, NULL, NULL, 77, NULL, 1, NULL, NULL, NULL),
(78, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-3-3', NULL, NULL, NULL, NULL, 78, NULL, 1, NULL, NULL, NULL),
(79, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-3-3-1', NULL, NULL, NULL, NULL, 79, NULL, 1, NULL, NULL, NULL),
(80, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-3-3-2', NULL, NULL, NULL, NULL, 80, NULL, 1, NULL, NULL, NULL),
(81, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-3-3-3', NULL, NULL, NULL, NULL, 81, NULL, 1, NULL, NULL, NULL),
(82, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-3-3-4', NULL, NULL, NULL, NULL, 82, NULL, 1, NULL, NULL, NULL),
(83, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-3-4', NULL, NULL, NULL, NULL, 83, NULL, 1, NULL, NULL, NULL),
(84, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-4-1', NULL, NULL, NULL, NULL, 84, NULL, 1, NULL, NULL, NULL),
(85, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-4-2', NULL, NULL, NULL, NULL, 85, NULL, 1, NULL, NULL, NULL),
(86, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-4-3', NULL, NULL, NULL, NULL, 86, NULL, 1, NULL, NULL, NULL),
(87, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-4-3-1', NULL, NULL, NULL, NULL, 87, NULL, 1, NULL, NULL, NULL),
(88, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-4-3-2', NULL, NULL, NULL, NULL, 88, NULL, 1, NULL, NULL, NULL),
(89, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-4-3-3', NULL, NULL, NULL, NULL, 89, NULL, 1, NULL, NULL, NULL),
(90, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-4-3-4', NULL, NULL, NULL, NULL, 90, NULL, 1, NULL, NULL, NULL),
(91, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-4-3-5', NULL, NULL, NULL, NULL, 91, NULL, 1, NULL, NULL, NULL),
(92, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-4-4', NULL, NULL, NULL, NULL, 92, NULL, 1, NULL, NULL, NULL),
(93, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-5-1', NULL, NULL, NULL, NULL, 93, NULL, 1, NULL, NULL, NULL),
(94, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-5-2', NULL, NULL, NULL, NULL, 94, NULL, 1, NULL, NULL, NULL),
(95, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-5-3', NULL, NULL, NULL, NULL, 95, NULL, 1, NULL, NULL, NULL),
(96, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-5-3-1', NULL, NULL, NULL, NULL, 96, NULL, 1, NULL, NULL, NULL),
(97, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-5-3-2', NULL, NULL, NULL, NULL, 97, NULL, 1, NULL, NULL, NULL),
(98, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-5-3-3', NULL, NULL, NULL, NULL, 98, NULL, 1, NULL, NULL, NULL),
(99, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-5-3-4', NULL, NULL, NULL, NULL, 99, NULL, 1, NULL, NULL, NULL),
(100, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-5-3-5', NULL, NULL, NULL, NULL, 100, NULL, 1, NULL, NULL, NULL),
(101, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-5-3-6', NULL, NULL, NULL, NULL, 101, NULL, 1, NULL, NULL, NULL),
(102, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-5-3-7', NULL, NULL, NULL, NULL, 102, NULL, 1, NULL, NULL, NULL),
(103, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-5-3-8', NULL, NULL, NULL, NULL, 103, NULL, 1, NULL, NULL, NULL),
(104, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-5-4', NULL, NULL, NULL, NULL, 104, NULL, 1, NULL, NULL, NULL),
(105, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-6-1', NULL, NULL, NULL, NULL, 105, NULL, 1, NULL, NULL, NULL),
(106, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-6-2', NULL, NULL, NULL, NULL, 106, NULL, 1, NULL, NULL, NULL),
(107, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-6-3', NULL, NULL, NULL, NULL, 107, NULL, 1, NULL, NULL, NULL),
(108, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-6-3-1', NULL, NULL, NULL, NULL, 108, NULL, 1, NULL, NULL, NULL),
(109, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-6-3-2', NULL, NULL, NULL, NULL, 109, NULL, 1, NULL, NULL, NULL),
(110, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-6-3-3', NULL, NULL, NULL, NULL, 110, NULL, 1, NULL, NULL, NULL),
(111, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-6-3-4', NULL, NULL, NULL, NULL, 111, NULL, 1, NULL, NULL, NULL),
(112, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-6-4', NULL, NULL, NULL, NULL, 112, NULL, 1, NULL, NULL, NULL),
(113, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-7-1', NULL, NULL, NULL, NULL, 113, NULL, 1, NULL, NULL, NULL),
(114, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-7-2', NULL, NULL, NULL, NULL, 114, NULL, 1, NULL, NULL, NULL),
(115, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-7-3', NULL, NULL, NULL, NULL, 115, NULL, 1, NULL, NULL, NULL),
(116, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-7-3-1', NULL, NULL, NULL, NULL, 116, NULL, 1, NULL, NULL, NULL),
(117, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-7-3-2', NULL, NULL, NULL, NULL, 117, NULL, 1, NULL, NULL, NULL),
(118, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-7-3-3', NULL, NULL, NULL, NULL, 118, NULL, 1, NULL, NULL, NULL),
(119, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-7-4', NULL, NULL, NULL, NULL, 119, NULL, 1, NULL, NULL, NULL),
(120, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-8-1', NULL, NULL, NULL, NULL, 120, NULL, 1, NULL, NULL, NULL),
(121, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-8-2', NULL, NULL, NULL, NULL, 121, NULL, 1, NULL, NULL, NULL),
(122, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-8-3', NULL, NULL, NULL, NULL, 122, NULL, 1, NULL, NULL, NULL),
(123, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-8-3-1', NULL, NULL, NULL, NULL, 123, NULL, 1, NULL, NULL, NULL),
(124, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-8-3-2', NULL, NULL, NULL, NULL, 124, NULL, 1, NULL, NULL, NULL),
(125, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-8-3-3', NULL, NULL, NULL, NULL, 125, NULL, 1, NULL, NULL, NULL),
(126, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-8-4', NULL, NULL, NULL, NULL, 126, NULL, 1, NULL, NULL, NULL),
(127, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-9-1', NULL, NULL, NULL, NULL, 127, NULL, 1, NULL, NULL, NULL),
(128, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-9-2', NULL, NULL, NULL, NULL, 128, NULL, 1, NULL, NULL, NULL),
(129, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-9-3', NULL, NULL, NULL, NULL, 129, NULL, 1, NULL, NULL, NULL),
(130, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-9-3-1', NULL, NULL, NULL, NULL, 130, NULL, 1, NULL, NULL, NULL),
(131, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-9-3-2', NULL, NULL, NULL, NULL, 131, NULL, 1, NULL, NULL, NULL),
(132, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-9-3-3', NULL, NULL, NULL, NULL, 132, NULL, 1, NULL, NULL, NULL),
(133, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-9-4', NULL, NULL, NULL, NULL, 133, NULL, 1, NULL, NULL, NULL),
(134, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-10-1', NULL, NULL, NULL, NULL, 134, NULL, 1, NULL, NULL, NULL),
(135, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-10-2', NULL, NULL, NULL, NULL, 135, NULL, 1, NULL, NULL, NULL),
(136, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-10-3', NULL, NULL, NULL, NULL, 136, NULL, 1, NULL, NULL, NULL),
(137, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-10-3-1', NULL, NULL, NULL, NULL, 137, NULL, 1, NULL, NULL, NULL),
(138, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-10-3-2', NULL, NULL, NULL, NULL, 138, NULL, 1, NULL, NULL, NULL),
(139, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-10-3-3', NULL, NULL, NULL, NULL, 139, NULL, 1, NULL, NULL, NULL),
(140, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-10-3-4', NULL, NULL, NULL, NULL, 140, NULL, 1, NULL, NULL, NULL),
(141, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-10-3-5', NULL, NULL, NULL, NULL, 141, NULL, 1, NULL, NULL, NULL),
(142, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-10-4', NULL, NULL, NULL, NULL, 142, NULL, 1, NULL, NULL, NULL),
(143, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-11-1', NULL, NULL, NULL, NULL, 143, NULL, 1, NULL, NULL, NULL),
(144, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-11-2', NULL, NULL, NULL, NULL, 144, NULL, 1, NULL, NULL, NULL),
(145, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-11-3', NULL, NULL, NULL, NULL, 145, NULL, 1, NULL, NULL, NULL),
(146, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-11-3-1', NULL, NULL, NULL, NULL, 146, NULL, 1, NULL, NULL, NULL),
(147, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-11-3-2', NULL, NULL, NULL, NULL, 147, NULL, 1, NULL, NULL, NULL),
(148, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-11-4', NULL, NULL, NULL, NULL, 148, NULL, 1, NULL, NULL, NULL),
(149, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-12-1', NULL, NULL, NULL, NULL, 149, NULL, 1, NULL, NULL, NULL),
(150, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-12-2', NULL, NULL, NULL, NULL, 150, NULL, 1, NULL, NULL, NULL),
(151, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-12-3', NULL, NULL, NULL, NULL, 151, NULL, 1, NULL, NULL, NULL),
(152, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-12-3-1', NULL, NULL, NULL, NULL, 152, NULL, 1, NULL, NULL, NULL),
(153, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-12-3-2', NULL, NULL, NULL, NULL, 153, NULL, 1, NULL, NULL, NULL),
(154, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-12-3-3', NULL, NULL, NULL, NULL, 154, NULL, 1, NULL, NULL, NULL),
(155, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-12-3-4', NULL, NULL, NULL, NULL, 155, NULL, 1, NULL, NULL, NULL),
(156, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-12-3-5', NULL, NULL, NULL, NULL, 156, NULL, 1, NULL, NULL, NULL),
(157, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-12-4', NULL, NULL, NULL, NULL, 157, NULL, 1, NULL, NULL, NULL),
(158, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-13-1', NULL, NULL, NULL, NULL, 158, NULL, 1, NULL, NULL, NULL),
(159, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-13-2', NULL, NULL, NULL, NULL, 159, NULL, 1, NULL, NULL, NULL),
(160, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-13-3', NULL, NULL, NULL, NULL, 160, NULL, 1, NULL, NULL, NULL),
(161, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-13-3-1', NULL, NULL, NULL, NULL, 161, NULL, 1, NULL, NULL, NULL),
(162, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-13-3-2', NULL, NULL, NULL, NULL, 162, NULL, 1, NULL, NULL, NULL),
(163, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-13-3-3', NULL, NULL, NULL, NULL, 163, NULL, 1, NULL, NULL, NULL),
(164, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-13-3-4', NULL, NULL, NULL, NULL, 164, NULL, 1, NULL, NULL, NULL),
(165, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-13-3-5', NULL, NULL, NULL, NULL, 165, NULL, 1, NULL, NULL, NULL),
(166, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-13-4', NULL, NULL, NULL, NULL, 166, NULL, 1, NULL, NULL, NULL),
(167, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-14-1', NULL, NULL, NULL, NULL, 167, NULL, 1, NULL, NULL, NULL),
(168, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-14-2', NULL, NULL, NULL, NULL, 168, NULL, 1, NULL, NULL, NULL),
(169, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-14-3', NULL, NULL, NULL, NULL, 169, NULL, 1, NULL, NULL, NULL),
(170, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-14-3-1', NULL, NULL, NULL, NULL, 170, NULL, 1, NULL, NULL, NULL),
(171, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-14-3-2', NULL, NULL, NULL, NULL, 171, NULL, 1, NULL, NULL, NULL),
(172, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-14-3-3', NULL, NULL, NULL, NULL, 172, NULL, 1, NULL, NULL, NULL),
(173, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-14-3-4', NULL, NULL, NULL, NULL, 173, NULL, 1, NULL, NULL, NULL),
(174, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-14-3-5', NULL, NULL, NULL, NULL, 174, NULL, 1, NULL, NULL, NULL),
(175, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-14-4', NULL, NULL, NULL, NULL, 175, NULL, 1, NULL, NULL, NULL),
(176, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-15-1', NULL, NULL, NULL, NULL, 176, NULL, 1, NULL, NULL, NULL),
(177, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-15-2', NULL, NULL, NULL, NULL, 177, NULL, 1, NULL, NULL, NULL),
(178, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-15-3', NULL, NULL, NULL, NULL, 178, NULL, 1, NULL, NULL, NULL),
(179, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-15-3-1', NULL, NULL, NULL, NULL, 179, NULL, 1, NULL, NULL, NULL),
(180, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-15-3-2', NULL, NULL, NULL, NULL, 180, NULL, 1, NULL, NULL, NULL),
(181, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-15-3-3', NULL, NULL, NULL, NULL, 181, NULL, 1, NULL, NULL, NULL),
(182, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-15-3-4', NULL, NULL, NULL, NULL, 182, NULL, 1, NULL, NULL, NULL),
(183, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-15-3-5', NULL, NULL, NULL, NULL, 183, NULL, 1, NULL, NULL, NULL),
(184, 1, 0, '2023-07-05', '2023-07-05', 'ECC 2-15-4', NULL, NULL, NULL, NULL, 184, NULL, 1, NULL, NULL, NULL),
(185, 1, 0, '2023-07-05', '2023-07-05', 'ECC 3-1-1', NULL, NULL, NULL, NULL, 185, NULL, 1, NULL, NULL, NULL),
(186, 1, 0, '2023-07-05', '2023-07-05', 'ECC 3-1-2', NULL, NULL, NULL, NULL, 186, NULL, 1, NULL, NULL, NULL),
(187, 1, 0, '2023-07-05', '2023-07-05', 'ECC 3-1-3', NULL, NULL, NULL, NULL, 187, NULL, 1, NULL, NULL, NULL),
(188, 1, 0, '2023-07-05', '2023-07-05', 'ECC 3-1-3-1', NULL, NULL, NULL, NULL, 188, NULL, 1, NULL, NULL, NULL),
(189, 1, 0, '2023-07-05', '2023-07-05', 'ECC 3-1-3-2', NULL, NULL, NULL, NULL, 189, NULL, 1, NULL, NULL, NULL),
(190, 1, 0, '2023-07-05', '2023-07-05', 'ECC 3-1-3-3', NULL, NULL, NULL, NULL, 190, NULL, 1, NULL, NULL, NULL),
(191, 1, 0, '2023-07-05', '2023-07-05', 'ECC 3-1-4', NULL, NULL, NULL, NULL, 191, NULL, 1, NULL, NULL, NULL),
(192, 1, 0, '2023-07-05', '2023-07-05', 'ECC 4-1-1', NULL, NULL, NULL, NULL, 192, NULL, 1, NULL, NULL, NULL),
(193, 1, 0, '2023-07-05', '2023-07-05', 'ECC 4-1-2', NULL, NULL, NULL, NULL, 193, NULL, 1, NULL, NULL, NULL),
(194, 1, 0, '2023-07-05', '2023-07-05', 'ECC 4-1-2-1', NULL, NULL, NULL, NULL, 194, NULL, 1, NULL, NULL, NULL),
(195, 1, 0, '2023-07-05', '2023-07-05', 'ECC 4-1-2-2', NULL, NULL, NULL, NULL, 195, NULL, 1, NULL, NULL, NULL),
(196, 1, 0, '2023-07-05', '2023-07-05', 'ECC 4-1-2-3', NULL, NULL, NULL, NULL, 196, NULL, 1, NULL, NULL, NULL),
(197, 1, 0, '2023-07-05', '2023-07-05', 'ECC 4-1-3', NULL, NULL, NULL, NULL, 197, NULL, 1, NULL, NULL, NULL),
(198, 1, 0, '2023-07-05', '2023-07-05', 'ECC 4-1-3-1', NULL, NULL, NULL, NULL, 198, NULL, 1, NULL, NULL, NULL),
(199, 1, 0, '2023-07-05', '2023-07-05', 'ECC 4-1-3-2', NULL, NULL, NULL, NULL, 199, NULL, 1, NULL, NULL, NULL),
(200, 1, 0, '2023-07-05', '2023-07-05', 'ECC 4-1-4', NULL, NULL, NULL, NULL, 200, NULL, 1, NULL, NULL, NULL),
(201, 1, 0, '2023-07-05', '2023-07-05', 'ECC 4-2-1', NULL, NULL, NULL, NULL, 201, NULL, 1, NULL, NULL, NULL),
(202, 1, 0, '2023-07-05', '2023-07-05', 'ECC 4-2-2', NULL, NULL, NULL, NULL, 202, NULL, 1, NULL, NULL, NULL),
(203, 1, 0, '2023-07-05', '2023-07-05', 'ECC 4-2-3', NULL, NULL, NULL, NULL, 203, NULL, 1, NULL, NULL, NULL),
(204, 1, 0, '2023-07-05', '2023-07-05', 'ECC 4-2-3-1', NULL, NULL, NULL, NULL, 204, NULL, 1, NULL, NULL, NULL),
(205, 1, 0, '2023-07-05', '2023-07-05', 'ECC 4-2-3-2', NULL, NULL, NULL, NULL, 205, NULL, 1, NULL, NULL, NULL),
(206, 1, 0, '2023-07-05', '2023-07-05', 'ECC 4-2-3-3', NULL, NULL, NULL, NULL, 206, NULL, 1, NULL, NULL, NULL),
(207, 1, 0, '2023-07-05', '2023-07-05', 'ECC 4-2-4', NULL, NULL, NULL, NULL, 207, NULL, 1, NULL, NULL, NULL),
(208, 1, 0, '2023-07-05', '2023-07-05', 'ECC 5-1-1', NULL, NULL, NULL, NULL, 208, NULL, 1, NULL, NULL, NULL),
(209, 1, 0, '2023-07-05', '2023-07-05', 'ECC 5-1-2', NULL, NULL, NULL, NULL, 209, NULL, 1, NULL, NULL, NULL),
(210, 1, 0, '2023-07-05', '2023-07-05', 'ECC 5-1-3', NULL, NULL, NULL, NULL, 210, NULL, 1, NULL, NULL, NULL),
(211, 1, 0, '2023-07-05', '2023-07-05', 'ECC 5-1-3-1', NULL, NULL, NULL, NULL, 211, NULL, 1, NULL, NULL, NULL),
(212, 1, 0, '2023-07-05', '2023-07-05', 'ECC 5-1-3-2', NULL, NULL, NULL, NULL, 212, NULL, 1, NULL, NULL, NULL),
(213, 1, 0, '2023-07-05', '2023-07-05', 'ECC 5-1-3-3', NULL, NULL, NULL, NULL, 213, NULL, 1, NULL, NULL, NULL),
(214, 1, 0, '2023-07-05', '2023-07-05', 'ECC 5-1-3-4', NULL, NULL, NULL, NULL, 214, NULL, 1, NULL, NULL, NULL),
(215, 1, 0, '2023-07-05', '2023-07-05', 'ECC 5-1-3-5', NULL, NULL, NULL, NULL, 215, NULL, 1, NULL, NULL, NULL),
(216, 1, 0, '2023-07-05', '2023-07-05', 'ECC 5-1-3-6', NULL, NULL, NULL, NULL, 216, NULL, 1, NULL, NULL, NULL),
(217, 1, 0, '2023-07-05', '2023-07-05', 'ECC 5-1-3-7', NULL, NULL, NULL, NULL, 217, NULL, 1, NULL, NULL, NULL),
(218, 1, 0, '2023-07-05', '2023-07-05', 'ECC 5-1-3-8', NULL, NULL, NULL, NULL, 218, NULL, 1, NULL, NULL, NULL),
(219, 1, 0, '2023-07-05', '2023-07-05', 'ECC 5-1-3-9', NULL, NULL, NULL, NULL, 219, NULL, 1, NULL, NULL, NULL),
(220, 1, 0, '2023-07-05', '2023-07-05', 'ECC 5-1-3-10', NULL, NULL, NULL, NULL, 220, NULL, 1, NULL, NULL, NULL),
(221, 1, 0, '2023-07-05', '2023-07-05', 'ECC 5-1-4', NULL, NULL, NULL, NULL, 221, NULL, 1, NULL, NULL, NULL),
(222, 1, 0, '2023-07-05', '2023-07-05', 'SMACC 1-1-1', NULL, NULL, NULL, NULL, 222, NULL, 1, NULL, NULL, NULL),
(223, 1, 0, '2023-07-05', '2023-07-05', 'SMACC 1-1-1-1', NULL, NULL, NULL, NULL, 223, NULL, 1, NULL, NULL, NULL),
(224, 1, 0, '2023-07-05', '2023-07-05', 'SMACC 1-2-1', NULL, NULL, NULL, NULL, 224, NULL, 1, NULL, NULL, NULL),
(225, 1, 0, '2023-07-05', '2023-07-05', 'SMACC 1-2-1-1', NULL, NULL, NULL, NULL, 225, NULL, 1, NULL, NULL, NULL),
(226, 1, 0, '2023-07-05', '2023-07-05', 'SMACC 1-2-1-2', NULL, NULL, NULL, NULL, 226, NULL, 1, NULL, NULL, NULL),
(227, 1, 0, '2023-07-05', '2023-07-05', 'SMACC 1-2-1-3', NULL, NULL, NULL, NULL, 227, NULL, 1, NULL, NULL, NULL),
(228, 1, 0, '2023-07-05', '2023-07-05', 'SMACC 1-3-1', NULL, NULL, NULL, NULL, 228, NULL, 1, NULL, NULL, NULL),
(229, 1, 0, '2023-07-05', '2023-07-05', 'SMACC 1-3-1-1', NULL, NULL, NULL, NULL, 229, NULL, 1, NULL, NULL, NULL),
(230, 1, 0, '2023-07-05', '2023-07-05', 'SMACC 1-3-1-2', NULL, NULL, NULL, NULL, 230, NULL, 1, NULL, NULL, NULL),
(231, 1, 0, '2023-07-05', '2023-07-05', 'SMACC 1-4-1', NULL, NULL, NULL, NULL, 231, NULL, 1, NULL, NULL, NULL),
(232, 1, 0, '2023-07-05', '2023-07-05', 'SMACC 1-4-1-1', NULL, NULL, NULL, NULL, 232, NULL, 1, NULL, NULL, NULL),
(233, 1, 0, '2023-07-05', '2023-07-05', 'SMACC 1-4-1-2', NULL, NULL, NULL, NULL, 233, NULL, 1, NULL, NULL, NULL),
(234, 1, 0, '2023-07-05', '2023-07-05', 'SMACC 1-4-1-3', NULL, NULL, NULL, NULL, 234, NULL, 1, NULL, NULL, NULL),
(235, 1, 0, '2023-07-05', '2023-07-05', 'SMACC 1-4-1-4', NULL, NULL, NULL, NULL, 235, NULL, 1, NULL, NULL, NULL),
(236, 1, 0, '2023-07-05', '2023-07-05', 'SMACC 1-4-1-5', NULL, NULL, NULL, NULL, 236, NULL, 1, NULL, NULL, NULL),
(237, 1, 0, '2023-07-05', '2023-07-05', 'SMACC 1-4-1-6', NULL, NULL, NULL, NULL, 237, NULL, 1, NULL, NULL, NULL),
(238, 1, 0, '2023-07-05', '2023-07-05', 'SMACC 1-4-1-7', NULL, NULL, NULL, NULL, 238, NULL, 1, NULL, NULL, NULL),
(239, 1, 0, '2023-07-05', '2023-07-05', 'SMACC 1-4-2', NULL, NULL, NULL, NULL, 239, NULL, 1, NULL, NULL, NULL),
(240, 1, 0, '2023-07-05', '2023-07-05', 'SMACC 2-1-1', NULL, NULL, NULL, NULL, 240, NULL, 1, NULL, NULL, NULL),
(241, 1, 0, '2023-07-05', '2023-07-05', 'SMACC 2-1-1', NULL, NULL, NULL, NULL, 241, NULL, 1, NULL, NULL, NULL),
(242, 1, 0, '2023-07-05', '2023-07-05', 'SMACC 2-2-1', NULL, NULL, NULL, NULL, 242, NULL, 1, NULL, NULL, NULL),
(243, 1, 0, '2023-07-05', '2023-07-05', 'SMACC 2-2-1-1', NULL, NULL, NULL, NULL, 243, NULL, 1, NULL, NULL, NULL),
(244, 1, 0, '2023-07-05', '2023-07-05', 'SMACC 2-2-1-2', NULL, NULL, NULL, NULL, 244, NULL, 1, NULL, NULL, NULL),
(245, 1, 0, '2023-07-05', '2023-07-05', 'SMACC 2-2-1-3', NULL, NULL, NULL, NULL, 245, NULL, 1, NULL, NULL, NULL),
(246, 1, 0, '2023-07-05', '2023-07-05', 'SMACC 2-2-1-4', NULL, NULL, NULL, NULL, 246, NULL, 1, NULL, NULL, NULL),
(247, 1, 0, '2023-07-05', '2023-07-05', 'SMACC 2-2-1-5', NULL, NULL, NULL, NULL, 247, NULL, 1, NULL, NULL, NULL),
(248, 1, 0, '2023-07-05', '2023-07-05', 'SMACC 2-2-1-6', NULL, NULL, NULL, NULL, 248, NULL, 1, NULL, NULL, NULL),
(249, 1, 0, '2023-07-05', '2023-07-05', 'SMACC 2-2-1-7', NULL, NULL, NULL, NULL, 249, NULL, 1, NULL, NULL, NULL),
(250, 1, 0, '2023-07-05', '2023-07-05', 'SMACC 2-2-1-8', NULL, NULL, NULL, NULL, 250, NULL, 1, NULL, NULL, NULL),
(251, 1, 0, '2023-07-05', '2023-07-05', 'SMACC 2-2-1-9', NULL, NULL, NULL, NULL, 251, NULL, 1, NULL, NULL, NULL),
(252, 1, 0, '2023-07-05', '2023-07-05', 'SMACC 2-2-2', NULL, NULL, NULL, NULL, 252, NULL, 1, NULL, NULL, NULL),
(253, 1, 0, '2023-07-05', '2023-07-05', 'SMACC 2-3-1', NULL, NULL, NULL, NULL, 253, NULL, 1, NULL, NULL, NULL),
(254, 1, 0, '2023-07-05', '2023-07-05', 'SMACC 2-3-1-1', NULL, NULL, NULL, NULL, 254, NULL, 1, NULL, NULL, NULL),
(255, 1, 0, '2023-07-05', '2023-07-05', 'SMACC 2-3-1-2', NULL, NULL, NULL, NULL, 255, NULL, 1, NULL, NULL, NULL),
(256, 1, 0, '2023-07-05', '2023-07-05', 'SMACC 2-3-1-3', NULL, NULL, NULL, NULL, 256, NULL, 1, NULL, NULL, NULL),
(257, 1, 0, '2023-07-05', '2023-07-05', 'SMACC 2-3-1-4', NULL, NULL, NULL, NULL, 257, NULL, 1, NULL, NULL, NULL),
(258, 1, 0, '2023-07-05', '2023-07-05', 'SMACC 2-4-1', NULL, NULL, NULL, NULL, 258, NULL, 1, NULL, NULL, NULL),
(259, 1, 0, '2023-07-05', '2023-07-05', 'SMACC 2-4-1-1', NULL, NULL, NULL, NULL, 259, NULL, 1, NULL, NULL, NULL),
(260, 1, 0, '2023-07-05', '2023-07-05', 'SMACC 2-4-1-2', NULL, NULL, NULL, NULL, 260, NULL, 1, NULL, NULL, NULL),
(261, 1, 0, '2023-07-05', '2023-07-05', 'SMACC 2-5-1', NULL, NULL, NULL, NULL, 261, NULL, 1, NULL, NULL, NULL),
(262, 1, 0, '2023-07-05', '2023-07-05', 'SMACC 2-5-1-1', NULL, NULL, NULL, NULL, 262, NULL, 1, NULL, NULL, NULL),
(263, 1, 0, '2023-07-05', '2023-07-05', 'SMACC 2-6-1', NULL, NULL, NULL, NULL, 263, NULL, 1, NULL, NULL, NULL),
(264, 1, 0, '2023-07-05', '2023-07-05', 'SMACC 2-6-1-1', NULL, NULL, NULL, NULL, 264, NULL, 1, NULL, NULL, NULL),
(265, 1, 0, '2023-07-05', '2023-07-05', 'SMACC 2-6-1-2', NULL, NULL, NULL, NULL, 265, NULL, 1, NULL, NULL, NULL),
(266, 1, 0, '2023-07-05', '2023-07-05', 'SMACC 2-6-1-3', NULL, NULL, NULL, NULL, 266, NULL, 1, NULL, NULL, NULL),
(267, 1, 0, '2023-07-05', '2023-07-05', 'SMACC 2-6-1-4', NULL, NULL, NULL, NULL, 267, NULL, 1, NULL, NULL, NULL),
(268, 1, 0, '2023-07-05', '2023-07-05', 'SMACC 2-7-1', NULL, NULL, NULL, NULL, 268, NULL, 1, NULL, NULL, NULL),
(269, 1, 0, '2023-07-05', '2023-07-05', 'SMACC 2-7-1-1', NULL, NULL, NULL, NULL, 269, NULL, 1, NULL, NULL, NULL),
(270, 1, 0, '2023-07-05', '2023-07-05', 'SMACC 3-1-1', NULL, NULL, NULL, NULL, 270, NULL, 1, NULL, NULL, NULL),
(271, 1, 0, '2023-07-05', '2023-07-05', 'SMACC 3-1-2', NULL, NULL, NULL, NULL, 271, NULL, 1, NULL, NULL, NULL),
(272, 1, 0, '2023-07-05', '2023-07-05', 'SMACC 3-1-2-1', NULL, NULL, NULL, NULL, 272, NULL, 1, NULL, NULL, NULL),
(273, 1, 0, '2023-07-05', '2023-07-05', 'SMACC 3-1-2-2', NULL, NULL, NULL, NULL, 273, NULL, 1, NULL, NULL, NULL),
(274, 1, 0, '2023-07-05', '2023-07-05', 'SMACC 3-1-2-3', NULL, NULL, NULL, NULL, 274, NULL, 1, NULL, NULL, NULL),
(275, 1, 0, '2023-07-05', '2023-07-05', 'TCC 1-1-1', NULL, NULL, NULL, NULL, 275, NULL, 1, NULL, NULL, NULL),
(276, 1, 0, '2023-07-05', '2023-07-05', 'TCC 1-1-1-1', NULL, NULL, NULL, NULL, 276, NULL, 1, NULL, NULL, NULL),
(277, 1, 0, '2023-07-05', '2023-07-05', 'TCC 1-2-1', NULL, NULL, NULL, NULL, 277, NULL, 1, NULL, NULL, NULL),
(278, 1, 0, '2023-07-05', '2023-07-05', 'TCC 1-2-1-1', NULL, NULL, NULL, NULL, 278, NULL, 1, NULL, NULL, NULL),
(279, 1, 0, '2023-07-05', '2023-07-05', 'TCC 1-2-1-2', NULL, NULL, NULL, NULL, 279, NULL, 1, NULL, NULL, NULL),
(280, 1, 0, '2023-07-05', '2023-07-05', 'TCC 1-2-1-3', NULL, NULL, NULL, NULL, 280, NULL, 1, NULL, NULL, NULL),
(281, 1, 0, '2023-07-05', '2023-07-05', 'TCC 1-3-1', NULL, NULL, NULL, NULL, 281, NULL, 1, NULL, NULL, NULL),
(282, 1, 0, '2023-07-05', '2023-07-05', 'TCC 1-3-1-1', NULL, NULL, NULL, NULL, 282, NULL, 1, NULL, NULL, NULL),
(283, 1, 0, '2023-07-05', '2023-07-05', 'TCC 1-3-1-2', NULL, NULL, NULL, NULL, 283, NULL, 1, NULL, NULL, NULL),
(284, 1, 0, '2023-07-05', '2023-07-05', 'TCC 1-3-1-3', NULL, NULL, NULL, NULL, 284, NULL, 1, NULL, NULL, NULL),
(285, 1, 0, '2023-07-05', '2023-07-05', 'TCC 1-3-1-4', NULL, NULL, NULL, NULL, 285, NULL, 1, NULL, NULL, NULL),
(286, 1, 0, '2023-07-05', '2023-07-05', 'TCC 1-3-1-5', NULL, NULL, NULL, NULL, 286, NULL, 1, NULL, NULL, NULL),
(287, 1, 0, '2023-07-05', '2023-07-05', 'TCC 1-3-1-6', NULL, NULL, NULL, NULL, 287, NULL, 1, NULL, NULL, NULL),
(288, 1, 0, '2023-07-05', '2023-07-05', 'TCC 1-3-1-7', NULL, NULL, NULL, NULL, 288, NULL, 1, NULL, NULL, NULL),
(289, 1, 0, '2023-07-05', '2023-07-05', 'TCC 1-3-1-8', NULL, NULL, NULL, NULL, 289, NULL, 1, NULL, NULL, NULL),
(290, 1, 0, '2023-07-05', '2023-07-05', 'TCC 1-3-2', NULL, NULL, NULL, NULL, 290, NULL, 1, NULL, NULL, NULL),
(291, 1, 0, '2023-07-05', '2023-07-05', 'TCC 2-1-1', NULL, NULL, NULL, NULL, 291, NULL, 1, NULL, NULL, NULL),
(292, 1, 0, '2023-07-05', '2023-07-05', 'TCC 2-1-1-1', NULL, NULL, NULL, NULL, 292, NULL, 1, NULL, NULL, NULL),
(293, 1, 0, '2023-07-05', '2023-07-05', 'TCC 2-2-1', NULL, NULL, NULL, NULL, 293, NULL, 1, NULL, NULL, NULL),
(294, 1, 0, '2023-07-05', '2023-07-05', 'TCC 2-2-1-1', NULL, NULL, NULL, NULL, 294, NULL, 1, NULL, NULL, NULL),
(295, 1, 0, '2023-07-05', '2023-07-05', 'TCC 2-2-1-2', NULL, NULL, NULL, NULL, 295, NULL, 1, NULL, NULL, NULL),
(296, 1, 0, '2023-07-05', '2023-07-05', 'TCC 2-2-1-3', NULL, NULL, NULL, NULL, 296, NULL, 1, NULL, NULL, NULL),
(297, 1, 0, '2023-07-05', '2023-07-05', 'TCC 2-2-2', NULL, NULL, NULL, NULL, 297, NULL, 1, NULL, NULL, NULL),
(298, 1, 0, '2023-07-05', '2023-07-05', 'TCC 2-3-1', NULL, NULL, NULL, NULL, 298, NULL, 1, NULL, NULL, NULL),
(299, 1, 0, '2023-07-05', '2023-07-05', 'TCC 2-3-1-1', NULL, NULL, NULL, NULL, 299, NULL, 1, NULL, NULL, NULL),
(300, 1, 0, '2023-07-05', '2023-07-05', 'TCC 2-3-1-2', NULL, NULL, NULL, NULL, 300, NULL, 1, NULL, NULL, NULL),
(301, 1, 0, '2023-07-05', '2023-07-05', 'TCC 2-3-1-3', NULL, NULL, NULL, NULL, 301, NULL, 1, NULL, NULL, NULL),
(302, 1, 0, '2023-07-05', '2023-07-05', 'TCC 2-3-1-4', NULL, NULL, NULL, NULL, 302, NULL, 1, NULL, NULL, NULL),
(303, 1, 0, '2023-07-05', '2023-07-05', 'TCC 2-3-1-5', NULL, NULL, NULL, NULL, 303, NULL, 1, NULL, NULL, NULL),
(304, 1, 0, '2023-07-05', '2023-07-05', 'TCC 2-4-1', NULL, NULL, NULL, NULL, 304, NULL, 1, NULL, NULL, NULL),
(305, 1, 0, '2023-07-05', '2023-07-05', 'TCC 2-4-1-1', NULL, NULL, NULL, NULL, 305, NULL, 1, NULL, NULL, NULL),
(306, 1, 0, '2023-07-05', '2023-07-05', 'TCC 2-4-1-2', NULL, NULL, NULL, NULL, 306, NULL, 1, NULL, NULL, NULL),
(307, 1, 0, '2023-07-05', '2023-07-05', 'TCC 2-4-1-3', NULL, NULL, NULL, NULL, 307, NULL, 1, NULL, NULL, NULL),
(308, 1, 0, '2023-07-05', '2023-07-05', 'TCC 2-4-1-4', NULL, NULL, NULL, NULL, 308, NULL, 1, NULL, NULL, NULL),
(309, 1, 0, '2023-07-05', '2023-07-05', 'TCC 2-5-1', NULL, NULL, NULL, NULL, 309, NULL, 1, NULL, NULL, NULL),
(310, 1, 0, '2023-07-05', '2023-07-05', 'TCC 2-5-1-1', NULL, NULL, NULL, NULL, 310, NULL, 1, NULL, NULL, NULL),
(311, 1, 0, '2023-07-05', '2023-07-05', 'TCC 2-5-1-2', NULL, NULL, NULL, NULL, 311, NULL, 1, NULL, NULL, NULL),
(312, 1, 0, '2023-07-05', '2023-07-05', 'TCC 2-6-1', NULL, NULL, NULL, NULL, 312, NULL, 1, NULL, NULL, NULL),
(313, 1, 0, '2023-07-05', '2023-07-05', 'TCC 2-6-1-1', NULL, NULL, NULL, NULL, 313, NULL, 1, NULL, NULL, NULL),
(314, 1, 0, '2023-07-05', '2023-07-05', 'TCC 2-6-1-2', NULL, NULL, NULL, NULL, 314, NULL, 1, NULL, NULL, NULL),
(315, 1, 0, '2023-07-05', '2023-07-05', 'TCC 2-7-1', NULL, NULL, NULL, NULL, 315, NULL, 1, NULL, NULL, NULL),
(316, 1, 0, '2023-07-05', '2023-07-05', 'TCC 2-7-1-1', NULL, NULL, NULL, NULL, 316, NULL, 1, NULL, NULL, NULL),
(317, 1, 0, '2023-07-05', '2023-07-05', 'TCC 2-8-1', NULL, NULL, NULL, NULL, 317, NULL, 1, NULL, NULL, NULL),
(318, 1, 0, '2023-07-05', '2023-07-05', 'TCC 2-8-1-1', NULL, NULL, NULL, NULL, 318, NULL, 1, NULL, NULL, NULL),
(319, 1, 0, '2023-07-05', '2023-07-05', 'TCC 2-8-2', NULL, NULL, NULL, NULL, 319, NULL, 1, NULL, NULL, NULL),
(320, 1, 0, '2023-07-05', '2023-07-05', 'TCC 2-9-1', NULL, NULL, NULL, NULL, 320, NULL, 1, NULL, NULL, NULL),
(321, 1, 0, '2023-07-05', '2023-07-05', 'TCC 2-9-1-1', NULL, NULL, NULL, NULL, 321, NULL, 1, NULL, NULL, NULL),
(322, 1, 0, '2023-07-05', '2023-07-05', 'TCC 2-9-1-2', NULL, NULL, NULL, NULL, 322, NULL, 1, NULL, NULL, NULL),
(323, 1, 0, '2023-07-05', '2023-07-05', 'TCC 2-10-1', NULL, NULL, NULL, NULL, 323, NULL, 1, NULL, NULL, NULL),
(324, 1, 0, '2023-07-05', '2023-07-05', 'TCC 2-10-1-1', NULL, NULL, NULL, NULL, 324, NULL, 1, NULL, NULL, NULL),
(325, 1, 0, '2023-07-05', '2023-07-05', 'TCC 2-10-2', NULL, NULL, NULL, NULL, 325, NULL, 1, NULL, NULL, NULL),
(326, 1, 0, '2023-07-05', '2023-07-05', 'TCC 2-11-1', NULL, NULL, NULL, NULL, 326, NULL, 1, NULL, NULL, NULL),
(327, 1, 0, '2023-07-05', '2023-07-05', 'TCC 2-11-1-1', NULL, NULL, NULL, NULL, 327, NULL, 1, NULL, NULL, NULL),
(328, 1, 0, '2023-07-05', '2023-07-05', 'TCC 2-11-1-2', NULL, NULL, NULL, NULL, 328, NULL, 1, NULL, NULL, NULL),
(329, 1, 0, '2023-07-05', '2023-07-05', 'TCC 2-11-1-3', NULL, NULL, NULL, NULL, 329, NULL, 1, NULL, NULL, NULL),
(330, 1, 0, '2023-07-05', '2023-07-05', 'TCC 2-11-1-4', NULL, NULL, NULL, NULL, 330, NULL, 1, NULL, NULL, NULL),
(331, 1, 0, '2023-07-05', '2023-07-05', 'TCC 2-11-2', NULL, NULL, NULL, NULL, 331, NULL, 1, NULL, NULL, NULL),
(332, 1, 0, '2023-07-05', '2023-07-05', 'TCC 2-12-1', NULL, NULL, NULL, NULL, 332, NULL, 1, NULL, NULL, NULL),
(333, 1, 0, '2023-07-05', '2023-07-05', 'TCC 2-12-1-1', NULL, NULL, NULL, NULL, 333, NULL, 1, NULL, NULL, NULL),
(334, 1, 0, '2023-07-05', '2023-07-05', 'TCC 2-12-1-2', NULL, NULL, NULL, NULL, 334, NULL, 1, NULL, NULL, NULL),
(335, 1, 0, '2023-07-05', '2023-07-05', 'TCC 2-12-1-3', NULL, NULL, NULL, NULL, 335, NULL, 1, NULL, NULL, NULL),
(336, 1, 0, '2023-07-05', '2023-07-05', 'TCC 3-1-1', NULL, NULL, NULL, NULL, 336, NULL, 1, NULL, NULL, NULL),
(337, 1, 0, '2023-07-05', '2023-07-05', 'TCC 3-1-1-1', NULL, NULL, NULL, NULL, 337, NULL, 1, NULL, NULL, NULL),
(338, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 1-1-1', NULL, NULL, NULL, NULL, 338, NULL, 1, NULL, NULL, NULL),
(339, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 1-1-2', NULL, NULL, NULL, NULL, 339, NULL, 1, NULL, NULL, NULL),
(340, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 1-1-3', NULL, NULL, NULL, NULL, 340, NULL, 1, NULL, NULL, NULL),
(341, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 1-2-1', NULL, NULL, NULL, NULL, 341, NULL, 1, NULL, NULL, NULL),
(342, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 1-2-1-1', NULL, NULL, NULL, NULL, 342, NULL, 1, NULL, NULL, NULL),
(343, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 1-2-1-2', NULL, NULL, NULL, NULL, 343, NULL, 1, NULL, NULL, NULL),
(344, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 1-3-1', NULL, NULL, NULL, NULL, 344, NULL, 1, NULL, NULL, NULL),
(345, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 1-3-1-1', NULL, NULL, NULL, NULL, 345, NULL, 1, NULL, NULL, NULL),
(346, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 1-3-1-2', NULL, NULL, NULL, NULL, 346, NULL, 1, NULL, NULL, NULL),
(347, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 1-3-1-3', NULL, NULL, NULL, NULL, 347, NULL, 1, NULL, NULL, NULL),
(348, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 1-3-1-4', NULL, NULL, NULL, NULL, 348, NULL, 1, NULL, NULL, NULL),
(349, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 1-3-1-5', NULL, NULL, NULL, NULL, 349, NULL, 1, NULL, NULL, NULL),
(350, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 1-3-1-6', NULL, NULL, NULL, NULL, 350, NULL, 1, NULL, NULL, NULL),
(351, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 1-3-1-7', NULL, NULL, NULL, NULL, 351, NULL, 1, NULL, NULL, NULL),
(352, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 1-4-1', NULL, NULL, NULL, NULL, 352, NULL, 1, NULL, NULL, NULL),
(353, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 1-4-1-1', NULL, NULL, NULL, NULL, 353, NULL, 1, NULL, NULL, NULL),
(354, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 1-4-1-2', NULL, NULL, NULL, NULL, 354, NULL, 1, NULL, NULL, NULL),
(355, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 1-4-1-3', NULL, NULL, NULL, NULL, 355, NULL, 1, NULL, NULL, NULL),
(356, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 1-4-1-4', NULL, NULL, NULL, NULL, 356, NULL, 1, NULL, NULL, NULL),
(357, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 1-4-2', NULL, NULL, NULL, NULL, 357, NULL, 1, NULL, NULL, NULL),
(358, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 1-5-1', NULL, NULL, NULL, NULL, 358, NULL, 1, NULL, NULL, NULL),
(359, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 1-5-2', NULL, NULL, NULL, NULL, 359, NULL, 1, NULL, NULL, NULL),
(360, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 1-5-3', NULL, NULL, NULL, NULL, 360, NULL, 1, NULL, NULL, NULL),
(361, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 1-5-3-1', NULL, NULL, NULL, NULL, 361, NULL, 1, NULL, NULL, NULL),
(362, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 1-5-3-2', NULL, NULL, NULL, NULL, 362, NULL, 1, NULL, NULL, NULL),
(363, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 1-5-3-3', NULL, NULL, NULL, NULL, 363, NULL, 1, NULL, NULL, NULL),
(364, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 1-5-3-4', NULL, NULL, NULL, NULL, 364, NULL, 1, NULL, NULL, NULL),
(365, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 1-5-3-5', NULL, NULL, NULL, NULL, 365, NULL, 1, NULL, NULL, NULL),
(366, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 1-5-4', NULL, NULL, NULL, NULL, 366, NULL, 1, NULL, NULL, NULL),
(367, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 1-6-1', NULL, NULL, NULL, NULL, 367, NULL, 1, NULL, NULL, NULL),
(368, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 1-6-2', NULL, NULL, NULL, NULL, 368, NULL, 1, NULL, NULL, NULL),
(369, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 1-7-1', NULL, NULL, NULL, NULL, 369, NULL, 1, NULL, NULL, NULL),
(370, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 1-7-2', NULL, NULL, NULL, NULL, 370, NULL, 1, NULL, NULL, NULL),
(371, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 1-8-1', NULL, NULL, NULL, NULL, 371, NULL, 1, NULL, NULL, NULL),
(372, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 1-8-2', NULL, NULL, NULL, NULL, 372, NULL, 1, NULL, NULL, NULL),
(373, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 1-8-2-1', NULL, NULL, NULL, NULL, 373, NULL, 1, NULL, NULL, NULL),
(374, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 1-8-2-2', NULL, NULL, NULL, NULL, 374, NULL, 1, NULL, NULL, NULL),
(375, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-1-1', NULL, NULL, NULL, NULL, 375, NULL, 1, NULL, NULL, NULL),
(376, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-1-1-1', NULL, NULL, NULL, NULL, 376, NULL, 1, NULL, NULL, NULL),
(377, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-1-1-2', NULL, NULL, NULL, NULL, 377, NULL, 1, NULL, NULL, NULL),
(378, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-1-1-3', NULL, NULL, NULL, NULL, 378, NULL, 1, NULL, NULL, NULL),
(379, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-1-1-4', NULL, NULL, NULL, NULL, 379, NULL, 1, NULL, NULL, NULL),
(380, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-1-1-5', NULL, NULL, NULL, NULL, 380, NULL, 1, NULL, NULL, NULL),
(381, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-1-2', NULL, NULL, NULL, NULL, 381, NULL, 1, NULL, NULL, NULL),
(382, 1, 0, '2023-07-05', '2023-07-05', 'OTTC 2-2-1', NULL, NULL, NULL, NULL, 382, NULL, 1, NULL, NULL, NULL),
(383, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-2-1-1', NULL, NULL, NULL, NULL, 383, NULL, 1, NULL, NULL, NULL),
(384, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-2-1-2', NULL, NULL, NULL, NULL, 384, NULL, 1, NULL, NULL, NULL),
(385, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-2-1-3', NULL, NULL, NULL, NULL, 385, NULL, 1, NULL, NULL, NULL),
(386, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-2-1-4', NULL, NULL, NULL, NULL, 386, NULL, 1, NULL, NULL, NULL),
(387, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-2-1-5', NULL, NULL, NULL, NULL, 387, NULL, 1, NULL, NULL, NULL),
(388, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-2-1-6', NULL, NULL, NULL, NULL, 388, NULL, 1, NULL, NULL, NULL),
(389, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-2-1-7', NULL, NULL, NULL, NULL, 389, NULL, 1, NULL, NULL, NULL),
(390, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-2-1-8', NULL, NULL, NULL, NULL, 390, NULL, 1, NULL, NULL, NULL),
(391, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-2-1-9', NULL, NULL, NULL, NULL, 391, NULL, 1, NULL, NULL, NULL),
(392, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-2-1-10', NULL, NULL, NULL, NULL, 392, NULL, 1, NULL, NULL, NULL),
(393, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-2-1-11', NULL, NULL, NULL, NULL, 393, NULL, 1, NULL, NULL, NULL),
(394, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-2-2', NULL, NULL, NULL, NULL, 394, NULL, 1, NULL, NULL, NULL),
(395, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-3-1', NULL, NULL, NULL, NULL, 395, NULL, 1, NULL, NULL, NULL),
(396, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-3-1-1', NULL, NULL, NULL, NULL, 396, NULL, 1, NULL, NULL, NULL),
(397, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-3-1-2', NULL, NULL, NULL, NULL, 397, NULL, 1, NULL, NULL, NULL),
(398, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-3-1-3', NULL, NULL, NULL, NULL, 398, NULL, 1, NULL, NULL, NULL),
(399, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-3-1-4', NULL, NULL, NULL, NULL, 399, NULL, 1, NULL, NULL, NULL),
(400, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-3-1-5', NULL, NULL, NULL, NULL, 400, NULL, 1, NULL, NULL, NULL),
(401, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-3-1-6', NULL, NULL, NULL, NULL, 401, NULL, 1, NULL, NULL, NULL),
(402, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-3-1-7', NULL, NULL, NULL, NULL, 402, NULL, 1, NULL, NULL, NULL),
(403, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-3-1-8', NULL, NULL, NULL, NULL, 403, NULL, 1, NULL, NULL, NULL),
(404, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-3-1-9', NULL, NULL, NULL, NULL, 404, NULL, 1, NULL, NULL, NULL),
(405, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-3-1-10', NULL, NULL, NULL, NULL, 405, NULL, 1, NULL, NULL, NULL),
(406, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-3-1-11', NULL, NULL, NULL, NULL, 406, NULL, 1, NULL, NULL, NULL),
(407, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-3-1-12', NULL, NULL, NULL, NULL, 407, NULL, 1, NULL, NULL, NULL),
(408, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-3-1-13', NULL, NULL, NULL, NULL, 408, NULL, 1, NULL, NULL, NULL),
(409, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-3-2', NULL, NULL, NULL, NULL, 409, NULL, 1, NULL, NULL, NULL),
(410, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-4-1', NULL, NULL, NULL, NULL, 410, NULL, 1, NULL, NULL, NULL),
(411, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-4-1-1', NULL, NULL, NULL, NULL, 411, NULL, 1, NULL, NULL, NULL),
(412, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-4-1-2', NULL, NULL, NULL, NULL, 412, NULL, 1, NULL, NULL, NULL),
(413, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-4-1-3', NULL, NULL, NULL, NULL, 413, NULL, 1, NULL, NULL, NULL),
(414, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-4-1-4', NULL, NULL, NULL, NULL, 414, NULL, 1, NULL, NULL, NULL),
(415, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-4-1-5', NULL, NULL, NULL, NULL, 415, NULL, 1, NULL, NULL, NULL),
(416, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-4-1-6', NULL, NULL, NULL, NULL, 416, NULL, 1, NULL, NULL, NULL),
(417, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-4-1-7', NULL, NULL, NULL, NULL, 417, NULL, 1, NULL, NULL, NULL),
(418, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-4-1-8', NULL, NULL, NULL, NULL, 418, NULL, 1, NULL, NULL, NULL),
(419, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-4-1-9', NULL, NULL, NULL, NULL, 419, NULL, 1, NULL, NULL, NULL),
(420, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-4-1-10', NULL, NULL, NULL, NULL, 420, NULL, 1, NULL, NULL, NULL),
(421, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-4-1-11', NULL, NULL, NULL, NULL, 421, NULL, 1, NULL, NULL, NULL),
(422, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-4-1-12', NULL, NULL, NULL, NULL, 422, NULL, 1, NULL, NULL, NULL),
(423, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-4-1-13', NULL, NULL, NULL, NULL, 423, NULL, 1, NULL, NULL, NULL),
(424, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-4-1-14', NULL, NULL, NULL, NULL, 424, NULL, 1, NULL, NULL, NULL),
(425, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-4-1-15', NULL, NULL, NULL, NULL, 425, NULL, 1, NULL, NULL, NULL),
(426, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-4-1-16', NULL, NULL, NULL, NULL, 426, NULL, 1, NULL, NULL, NULL),
(427, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-4-2', NULL, NULL, NULL, NULL, 427, NULL, 1, NULL, NULL, NULL),
(428, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-5-1', NULL, NULL, NULL, NULL, 428, NULL, 1, NULL, NULL, NULL),
(429, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-5-1-1', NULL, NULL, NULL, NULL, 429, NULL, 1, NULL, NULL, NULL),
(430, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-5-1-2', NULL, NULL, NULL, NULL, 430, NULL, 1, NULL, NULL, NULL),
(431, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-5-1-3', NULL, NULL, NULL, NULL, 431, NULL, 1, NULL, NULL, NULL),
(432, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-5-1-4', NULL, NULL, NULL, NULL, 432, NULL, 1, NULL, NULL, NULL),
(433, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-5-1-5', NULL, NULL, NULL, NULL, 433, NULL, 1, NULL, NULL, NULL),
(434, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-5-2', NULL, NULL, NULL, NULL, 434, NULL, 1, NULL, NULL, NULL),
(435, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-6-1', NULL, NULL, NULL, NULL, 435, NULL, 1, NULL, NULL, NULL),
(436, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-6-1-1', NULL, NULL, NULL, NULL, 436, NULL, 1, NULL, NULL, NULL),
(437, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-6-1-2', NULL, NULL, NULL, NULL, 437, NULL, 1, NULL, NULL, NULL),
(438, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-6-1-3', NULL, NULL, NULL, NULL, 438, NULL, 1, NULL, NULL, NULL),
(439, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-6-1-4', NULL, NULL, NULL, NULL, 439, NULL, 1, NULL, NULL, NULL),
(440, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-6-2', NULL, NULL, NULL, NULL, 440, NULL, 1, NULL, NULL, NULL),
(441, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-7-1', NULL, NULL, NULL, NULL, 441, NULL, 1, NULL, NULL, NULL),
(442, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-7-2', NULL, NULL, NULL, NULL, 442, NULL, 1, NULL, NULL, NULL),
(443, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-8-1', NULL, NULL, NULL, NULL, 443, NULL, 1, NULL, NULL, NULL),
(444, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-8-1-1', NULL, NULL, NULL, NULL, 444, NULL, 1, NULL, NULL, NULL),
(445, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-8-1-2', NULL, NULL, NULL, NULL, 445, NULL, 1, NULL, NULL, NULL),
(446, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-8-1-3', NULL, NULL, NULL, NULL, 446, NULL, 1, NULL, NULL, NULL),
(447, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-8-1-4', NULL, NULL, NULL, NULL, 447, NULL, 1, NULL, NULL, NULL),
(448, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-8-2', NULL, NULL, NULL, NULL, 448, NULL, 1, NULL, NULL, NULL),
(449, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-9-1', NULL, NULL, NULL, NULL, 449, NULL, 1, NULL, NULL, NULL),
(450, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-9-1-1', NULL, NULL, NULL, NULL, 450, NULL, 1, NULL, NULL, NULL),
(451, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-9-1-2', NULL, NULL, NULL, NULL, 451, NULL, 1, NULL, NULL, NULL),
(452, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-9-1-3', NULL, NULL, NULL, NULL, 452, NULL, 1, NULL, NULL, NULL),
(453, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-9-2', NULL, NULL, NULL, NULL, 453, NULL, 1, NULL, NULL, NULL),
(454, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-10-1', NULL, NULL, NULL, NULL, 454, NULL, 1, NULL, NULL, NULL),
(455, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-10-1-1', NULL, NULL, NULL, NULL, 455, NULL, 1, NULL, NULL, NULL),
(456, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-10-1-2', NULL, NULL, NULL, NULL, 456, NULL, 1, NULL, NULL, NULL),
(457, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-10-1-3', NULL, NULL, NULL, NULL, 457, NULL, 1, NULL, NULL, NULL),
(458, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-10-1-4', NULL, NULL, NULL, NULL, 458, NULL, 1, NULL, NULL, NULL);
INSERT INTO `framework_control_tests` (`id`, `tester`, `test_frequency`, `last_date`, `next_date`, `name`, `objective`, `test_steps`, `approximate_time`, `expected_results`, `framework_control_id`, `desired_frequency`, `status`, `additional_stakeholders`, `created_at`, `updated_at`) VALUES
(459, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-10-2', NULL, NULL, NULL, NULL, 459, NULL, 1, NULL, NULL, NULL),
(460, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-11-1', NULL, NULL, NULL, NULL, 460, NULL, 1, NULL, NULL, NULL),
(461, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-11-1-1', NULL, NULL, NULL, NULL, 461, NULL, 1, NULL, NULL, NULL),
(462, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-11-1-2', NULL, NULL, NULL, NULL, 462, NULL, 1, NULL, NULL, NULL),
(463, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-11-1-3', NULL, NULL, NULL, NULL, 463, NULL, 1, NULL, NULL, NULL),
(464, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-11-1-4', NULL, NULL, NULL, NULL, 464, NULL, 1, NULL, NULL, NULL),
(465, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-11-1-5', NULL, NULL, NULL, NULL, 465, NULL, 1, NULL, NULL, NULL),
(466, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-11-1-6', NULL, NULL, NULL, NULL, 466, NULL, 1, NULL, NULL, NULL),
(467, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-11-1-7', NULL, NULL, NULL, NULL, 467, NULL, 1, NULL, NULL, NULL),
(468, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-11-1-8', NULL, NULL, NULL, NULL, 468, NULL, 1, NULL, NULL, NULL),
(469, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-11-1-9', NULL, NULL, NULL, NULL, 469, NULL, 1, NULL, NULL, NULL),
(470, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-11-1-10', NULL, NULL, NULL, NULL, 470, NULL, 1, NULL, NULL, NULL),
(471, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-11-2', NULL, NULL, NULL, NULL, 471, NULL, 1, NULL, NULL, NULL),
(472, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-12-1', NULL, NULL, NULL, NULL, 472, NULL, 1, NULL, NULL, NULL),
(473, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-12-1-1', NULL, NULL, NULL, NULL, 473, NULL, 1, NULL, NULL, NULL),
(474, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-12-1-2', NULL, NULL, NULL, NULL, 474, NULL, 1, NULL, NULL, NULL),
(475, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-12-1-3', NULL, NULL, NULL, NULL, 475, NULL, 1, NULL, NULL, NULL),
(476, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-12-1-4', NULL, NULL, NULL, NULL, 476, NULL, 1, NULL, NULL, NULL),
(477, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-12-1-5', NULL, NULL, NULL, NULL, 477, NULL, 1, NULL, NULL, NULL),
(478, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-12-1-6', NULL, NULL, NULL, NULL, 478, NULL, 1, NULL, NULL, NULL),
(479, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-12-1-7', NULL, NULL, NULL, NULL, 479, NULL, 1, NULL, NULL, NULL),
(480, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-12-1-8', NULL, NULL, NULL, NULL, 480, NULL, 1, NULL, NULL, NULL),
(481, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-12-2', NULL, NULL, NULL, NULL, 481, NULL, 1, NULL, NULL, NULL),
(482, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-13-1', NULL, NULL, NULL, NULL, 482, NULL, 1, NULL, NULL, NULL),
(483, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-13-1-1', NULL, NULL, NULL, NULL, 483, NULL, 1, NULL, NULL, NULL),
(484, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-13-1-2', NULL, NULL, NULL, NULL, 484, NULL, 1, NULL, NULL, NULL),
(485, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-13-1-3', NULL, NULL, NULL, NULL, 485, NULL, 1, NULL, NULL, NULL),
(486, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-13-1-4', NULL, NULL, NULL, NULL, 486, NULL, 1, NULL, NULL, NULL),
(487, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-13-1-5', NULL, NULL, NULL, NULL, 487, NULL, 1, NULL, NULL, NULL),
(488, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-13-1-6', NULL, NULL, NULL, NULL, 488, NULL, 1, NULL, NULL, NULL),
(489, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-13-1-7', NULL, NULL, NULL, NULL, 489, NULL, 1, NULL, NULL, NULL),
(490, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-13-1-8', NULL, NULL, NULL, NULL, 490, NULL, 1, NULL, NULL, NULL),
(491, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-13-1-9', NULL, NULL, NULL, NULL, 491, NULL, 1, NULL, NULL, NULL),
(492, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 2-13-2', NULL, NULL, NULL, NULL, 492, NULL, 1, NULL, NULL, NULL),
(493, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 3-1-1', NULL, NULL, NULL, NULL, 493, NULL, 1, NULL, NULL, NULL),
(494, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 3-1-1-1', NULL, NULL, NULL, NULL, 494, NULL, 1, NULL, NULL, NULL),
(495, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 3-1-1-2', NULL, NULL, NULL, NULL, 495, NULL, 1, NULL, NULL, NULL),
(496, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 3-1-1-3', NULL, NULL, NULL, NULL, 496, NULL, 1, NULL, NULL, NULL),
(497, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 3-1-1-4', NULL, NULL, NULL, NULL, 497, NULL, 1, NULL, NULL, NULL),
(498, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 3-1-1-5', NULL, NULL, NULL, NULL, 498, NULL, 1, NULL, NULL, NULL),
(499, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 3-1-1-6', NULL, NULL, NULL, NULL, 499, NULL, 1, NULL, NULL, NULL),
(500, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 3-1-2', NULL, NULL, NULL, NULL, 500, NULL, 1, NULL, NULL, NULL),
(501, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 4-1-1', NULL, NULL, NULL, NULL, 501, NULL, 1, NULL, NULL, NULL),
(502, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 4-1-1-1', NULL, NULL, NULL, NULL, 502, NULL, 1, NULL, NULL, NULL),
(503, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 4-1-1-2', NULL, NULL, NULL, NULL, 503, NULL, 1, NULL, NULL, NULL),
(504, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 4-1-1-3', NULL, NULL, NULL, NULL, 504, NULL, 1, NULL, NULL, NULL),
(505, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 4-1-1-4', NULL, NULL, NULL, NULL, 505, NULL, 1, NULL, NULL, NULL),
(506, 1, 0, '2023-07-05', '2023-07-05', 'OTCC 4-1-2', NULL, NULL, NULL, NULL, 506, NULL, 1, NULL, NULL, NULL),
(507, 1, 0, '2023-07-05', '2023-07-05', 'CCC ١-١-م-١', NULL, NULL, NULL, NULL, 507, NULL, 1, NULL, NULL, NULL),
(508, 1, 0, '2023-07-05', '2023-07-05', 'CCC ١-١-م-١-١‏', NULL, NULL, NULL, NULL, 508, NULL, 1, NULL, NULL, NULL),
(509, 1, 0, '2023-07-05', '2023-07-05', 'CCC ١-١-ش۔١', NULL, NULL, NULL, NULL, 509, NULL, 1, NULL, NULL, NULL),
(510, 1, 0, '2023-07-05', '2023-07-05', 'CCC ١-١-ش۔١-١', NULL, NULL, NULL, NULL, 510, NULL, 1, NULL, NULL, NULL),
(511, 1, 0, '2023-07-05', '2023-07-05', 'CCC ١-٢-م-١', NULL, NULL, NULL, NULL, 511, NULL, 1, NULL, NULL, NULL),
(512, 1, 0, '2023-07-05', '2023-07-05', 'CCC ١-٢-م-١-١‏', NULL, NULL, NULL, NULL, 512, NULL, 1, NULL, NULL, NULL),
(513, 1, 0, '2023-07-05', '2023-07-05', 'CCC ١-٢-م-١-٢', NULL, NULL, NULL, NULL, 513, NULL, 1, NULL, NULL, NULL),
(514, 1, 0, '2023-07-05', '2023-07-05', 'CCC ١-٢-م-١-3', NULL, NULL, NULL, NULL, 514, NULL, 1, NULL, NULL, NULL),
(515, 1, 0, '2023-07-05', '2023-07-05', 'CCC ١-٢-ش-١', NULL, NULL, NULL, NULL, 515, NULL, 1, NULL, NULL, NULL),
(516, 1, 0, '2023-07-05', '2023-07-05', 'CCC ١-٢-ش-۔١-١‏', NULL, NULL, NULL, NULL, 516, NULL, 1, NULL, NULL, NULL),
(517, 1, 0, '2023-07-05', '2023-07-05', 'CCC ١-٢-ش۔١۔٢', NULL, NULL, NULL, NULL, 517, NULL, 1, NULL, NULL, NULL),
(518, 1, 0, '2023-07-05', '2023-07-05', 'CCC ١-٢-ش۔١۔3‏', NULL, NULL, NULL, NULL, 518, NULL, 1, NULL, NULL, NULL),
(519, 1, 0, '2023-07-05', '2023-07-05', 'CCC ١-٣-م-١', NULL, NULL, NULL, NULL, 519, NULL, 1, NULL, NULL, NULL),
(520, 1, 0, '2023-07-05', '2023-07-05', 'CCC ١-٣-م-١-١', NULL, NULL, NULL, NULL, 520, NULL, 1, NULL, NULL, NULL),
(521, 1, 0, '2023-07-05', '2023-07-05', 'CCC ١-٣-ش۔١', NULL, NULL, NULL, NULL, 521, NULL, 1, NULL, NULL, NULL),
(522, 1, 0, '2023-07-05', '2023-07-05', 'CCC ١-٣-ش-١-١', NULL, NULL, NULL, NULL, 522, NULL, 1, NULL, NULL, NULL),
(523, 1, 0, '2023-07-05', '2023-07-05', 'CCC ١-٤-م-١', NULL, NULL, NULL, NULL, 523, NULL, 1, NULL, NULL, NULL),
(524, 1, 0, '2023-07-05', '2023-07-05', 'CCC ١-٤-م-١-١', NULL, NULL, NULL, NULL, 524, NULL, 1, NULL, NULL, NULL),
(525, 1, 0, '2023-07-05', '2023-07-05', 'CCC ١-٤-م-١۔٢', NULL, NULL, NULL, NULL, 525, NULL, 1, NULL, NULL, NULL),
(526, 1, 0, '2023-07-05', '2023-07-05', 'CCC ١-٤-م-١۔3', NULL, NULL, NULL, NULL, 526, NULL, 1, NULL, NULL, NULL),
(527, 1, 0, '2023-07-05', '2023-07-05', 'CCC ١-٤-م-2', NULL, NULL, NULL, NULL, 527, NULL, 1, NULL, NULL, NULL),
(528, 1, 0, '2023-07-05', '2023-07-05', 'CCC ١-٤-م-2۔1', NULL, NULL, NULL, NULL, 528, NULL, 1, NULL, NULL, NULL),
(529, 1, 0, '2023-07-05', '2023-07-05', 'CCC ١-٤-ش-١', NULL, NULL, NULL, NULL, 529, NULL, 1, NULL, NULL, NULL),
(530, 1, 0, '2023-07-05', '2023-07-05', 'CCC ١-٤-ش-١-١', NULL, NULL, NULL, NULL, 530, NULL, 1, NULL, NULL, NULL),
(531, 1, 0, '2023-07-05', '2023-07-05', 'CCC ١-م-5-1', NULL, NULL, NULL, NULL, 531, NULL, 1, NULL, NULL, NULL),
(532, 1, 0, '2023-07-05', '2023-07-05', 'CCC ١-٥-م-٢', NULL, NULL, NULL, NULL, 532, NULL, 1, NULL, NULL, NULL),
(533, 1, 0, '2023-07-05', '2023-07-05', 'CCC ١-٥-م-۳', NULL, NULL, NULL, NULL, 533, NULL, 1, NULL, NULL, NULL),
(534, 1, 0, '2023-07-05', '2023-07-05', 'CCC ١-٥-م-۳-١', NULL, NULL, NULL, NULL, 534, NULL, 1, NULL, NULL, NULL),
(535, 1, 0, '2023-07-05', '2023-07-05', 'CCC ١-٥-م-۳-2', NULL, NULL, NULL, NULL, 535, NULL, 1, NULL, NULL, NULL),
(536, 1, 0, '2023-07-05', '2023-07-05', 'CCC ١-٥-م-4', NULL, NULL, NULL, NULL, 536, NULL, 1, NULL, NULL, NULL),
(537, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١-م-١', NULL, NULL, NULL, NULL, 537, NULL, 1, NULL, NULL, NULL),
(538, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١-م-١-١', NULL, NULL, NULL, NULL, 538, NULL, 1, NULL, NULL, NULL),
(539, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١-م-١-2', NULL, NULL, NULL, NULL, 539, NULL, 1, NULL, NULL, NULL),
(540, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١-ش۔١', NULL, NULL, NULL, NULL, 540, NULL, 1, NULL, NULL, NULL),
(541, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١-ش۔١-١‏', NULL, NULL, NULL, NULL, 541, NULL, 1, NULL, NULL, NULL),
(542, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٢-م-١', NULL, NULL, NULL, NULL, 542, NULL, 1, NULL, NULL, NULL),
(543, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٢-م-١-١', NULL, NULL, NULL, NULL, 543, NULL, 1, NULL, NULL, NULL),
(544, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٢-م-١۔٢', NULL, NULL, NULL, NULL, 544, NULL, 1, NULL, NULL, NULL),
(545, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٢-م-١-٣', NULL, NULL, NULL, NULL, 545, NULL, 1, NULL, NULL, NULL),
(546, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٢-م۔١-٤', NULL, NULL, NULL, NULL, 546, NULL, 1, NULL, NULL, NULL),
(547, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٢-م-١-٥', NULL, NULL, NULL, NULL, 547, NULL, 1, NULL, NULL, NULL),
(548, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢۔٢-م-١-٦', NULL, NULL, NULL, NULL, 548, NULL, 1, NULL, NULL, NULL),
(549, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٢-م-١-٧', NULL, NULL, NULL, NULL, 549, NULL, 1, NULL, NULL, NULL),
(550, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٢-م-١-٨', NULL, NULL, NULL, NULL, 550, NULL, 1, NULL, NULL, NULL),
(551, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٢-م-١-٩', NULL, NULL, NULL, NULL, 551, NULL, 1, NULL, NULL, NULL),
(552, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٢-م-١-١٠', NULL, NULL, NULL, NULL, 552, NULL, 1, NULL, NULL, NULL),
(553, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٢-م-١-١١‏', NULL, NULL, NULL, NULL, 553, NULL, 1, NULL, NULL, NULL),
(554, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٢-م-١-١٢', NULL, NULL, NULL, NULL, 554, NULL, 1, NULL, NULL, NULL),
(555, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٢-ش۔١', NULL, NULL, NULL, NULL, 555, NULL, 1, NULL, NULL, NULL),
(556, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٢-ش۔١۔1', NULL, NULL, NULL, NULL, 556, NULL, 1, NULL, NULL, NULL),
(557, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٢-ش۔١۔٢‏', NULL, NULL, NULL, NULL, 557, NULL, 1, NULL, NULL, NULL),
(558, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٢-ش۔١-٣‏', NULL, NULL, NULL, NULL, 558, NULL, 1, NULL, NULL, NULL),
(559, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢۔٢-ش۔١-٤', NULL, NULL, NULL, NULL, 559, NULL, 1, NULL, NULL, NULL),
(560, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٢-ش-١-٥', NULL, NULL, NULL, NULL, 560, NULL, 1, NULL, NULL, NULL),
(561, 1, 0, '2023-07-05', '2023-07-05', 'ccc ٢-٣-م-١', NULL, NULL, NULL, NULL, 561, NULL, 1, NULL, NULL, NULL),
(562, 1, 0, '2023-07-05', '2023-07-05', 'ccc ٢-٣-م-١-١', NULL, NULL, NULL, NULL, 562, NULL, 1, NULL, NULL, NULL),
(563, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٣-م-١-٢‏', NULL, NULL, NULL, NULL, 563, NULL, 1, NULL, NULL, NULL),
(564, 1, 0, '2023-07-05', '2023-07-05', 'CCC  ٢-٣-م-١-٣‏', NULL, NULL, NULL, NULL, 564, NULL, 1, NULL, NULL, NULL),
(565, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٣-م-۔١-٤', NULL, NULL, NULL, NULL, 565, NULL, 1, NULL, NULL, NULL),
(566, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٣-م-١-٥', NULL, NULL, NULL, NULL, 566, NULL, 1, NULL, NULL, NULL),
(567, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٣-م-١-٦', NULL, NULL, NULL, NULL, 567, NULL, 1, NULL, NULL, NULL),
(568, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢۔٣-م-١-٧', NULL, NULL, NULL, NULL, 568, NULL, 1, NULL, NULL, NULL),
(569, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٣-م-١-٨', NULL, NULL, NULL, NULL, 569, NULL, 1, NULL, NULL, NULL),
(570, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٣-م-١-٩', NULL, NULL, NULL, NULL, 570, NULL, 1, NULL, NULL, NULL),
(571, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٣-م-١-10', NULL, NULL, NULL, NULL, 571, NULL, 1, NULL, NULL, NULL),
(572, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٣-م-١-١١', NULL, NULL, NULL, NULL, 572, NULL, 1, NULL, NULL, NULL),
(573, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٣-م-١-12', NULL, NULL, NULL, NULL, 573, NULL, 1, NULL, NULL, NULL),
(574, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٣-ش۔١', NULL, NULL, NULL, NULL, 574, NULL, 1, NULL, NULL, NULL),
(575, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٣-ش۔١-١', NULL, NULL, NULL, NULL, 575, NULL, 1, NULL, NULL, NULL),
(576, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٤-م-١', NULL, NULL, NULL, NULL, 576, NULL, 1, NULL, NULL, NULL),
(577, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٤-م-١-١', NULL, NULL, NULL, NULL, 577, NULL, 1, NULL, NULL, NULL),
(578, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٤-م-١-٢', NULL, NULL, NULL, NULL, 578, NULL, 1, NULL, NULL, NULL),
(579, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٤-م-١-٣', NULL, NULL, NULL, NULL, 579, NULL, 1, NULL, NULL, NULL),
(580, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٤-م-١-٤', NULL, NULL, NULL, NULL, 580, NULL, 1, NULL, NULL, NULL),
(581, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٤-م-١-٥', NULL, NULL, NULL, NULL, 581, NULL, 1, NULL, NULL, NULL),
(582, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٤-م-١-٦', NULL, NULL, NULL, NULL, 582, NULL, 1, NULL, NULL, NULL),
(583, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٤-ش-١', NULL, NULL, NULL, NULL, 583, NULL, 1, NULL, NULL, NULL),
(584, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٤-ش-1-١', NULL, NULL, NULL, NULL, 584, NULL, 1, NULL, NULL, NULL),
(585, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٥-م-١', NULL, NULL, NULL, NULL, 585, NULL, 1, NULL, NULL, NULL),
(586, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٥-م-١-١', NULL, NULL, NULL, NULL, 586, NULL, 1, NULL, NULL, NULL),
(587, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٥-م-١-٢', NULL, NULL, NULL, NULL, 587, NULL, 1, NULL, NULL, NULL),
(588, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٥-م-١-٣', NULL, NULL, NULL, NULL, 588, NULL, 1, NULL, NULL, NULL),
(589, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٥-م-١-4', NULL, NULL, NULL, NULL, 589, NULL, 1, NULL, NULL, NULL),
(590, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٥-ش-١', NULL, NULL, NULL, NULL, 590, NULL, 1, NULL, NULL, NULL),
(591, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٥-ش۔١-١', NULL, NULL, NULL, NULL, 591, NULL, 1, NULL, NULL, NULL),
(592, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٦-م-١', NULL, NULL, NULL, NULL, 592, NULL, 1, NULL, NULL, NULL),
(593, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٦-م-١-١', NULL, NULL, NULL, NULL, 593, NULL, 1, NULL, NULL, NULL),
(594, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٦-م-١-٢', NULL, NULL, NULL, NULL, 594, NULL, 1, NULL, NULL, NULL),
(595, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢۔٦-م-١-٣', NULL, NULL, NULL, NULL, 595, NULL, 1, NULL, NULL, NULL),
(596, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٦-م-۔١-٤', NULL, NULL, NULL, NULL, 596, NULL, 1, NULL, NULL, NULL),
(597, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٦-م-١-٥', NULL, NULL, NULL, NULL, 597, NULL, 1, NULL, NULL, NULL),
(598, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٦-ش-١', NULL, NULL, NULL, NULL, 598, NULL, 1, NULL, NULL, NULL),
(599, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٦-ش۔١-١‏', NULL, NULL, NULL, NULL, 599, NULL, 1, NULL, NULL, NULL),
(600, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٦-ش۔١۔٢', NULL, NULL, NULL, NULL, 600, NULL, 1, NULL, NULL, NULL),
(601, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٧-م-١', NULL, NULL, NULL, NULL, 601, NULL, 1, NULL, NULL, NULL),
(602, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٧-م-١-١', NULL, NULL, NULL, NULL, 602, NULL, 1, NULL, NULL, NULL),
(603, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٧-م-١۔٢', NULL, NULL, NULL, NULL, 603, NULL, 1, NULL, NULL, NULL),
(604, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٧-ش-١', NULL, NULL, NULL, NULL, 604, NULL, 1, NULL, NULL, NULL),
(605, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٧-ش۔١-١', NULL, NULL, NULL, NULL, 605, NULL, 1, NULL, NULL, NULL),
(606, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٧-ش۔١۔٢', NULL, NULL, NULL, NULL, 606, NULL, 1, NULL, NULL, NULL),
(607, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٨-م-١', NULL, NULL, NULL, NULL, 607, NULL, 1, NULL, NULL, NULL),
(608, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٨-م-١-١', NULL, NULL, NULL, NULL, 608, NULL, 1, NULL, NULL, NULL),
(609, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٨-م-١۔٢', NULL, NULL, NULL, NULL, 609, NULL, 1, NULL, NULL, NULL),
(610, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٩-م-١', NULL, NULL, NULL, NULL, 610, NULL, 1, NULL, NULL, NULL),
(611, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٩-م-١-١', NULL, NULL, NULL, NULL, 611, NULL, 1, NULL, NULL, NULL),
(612, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٩-م-١-٢', NULL, NULL, NULL, NULL, 612, NULL, 1, NULL, NULL, NULL),
(613, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٩-ش-١', NULL, NULL, NULL, NULL, 613, NULL, 1, NULL, NULL, NULL),
(614, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٩-ش-١-١', NULL, NULL, NULL, NULL, 614, NULL, 1, NULL, NULL, NULL),
(615, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٩-ش۔١۔٢', NULL, NULL, NULL, NULL, 615, NULL, 1, NULL, NULL, NULL),
(616, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١٠-م-١', NULL, NULL, NULL, NULL, 616, NULL, 1, NULL, NULL, NULL),
(617, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١٠-م-١-١', NULL, NULL, NULL, NULL, 617, NULL, 1, NULL, NULL, NULL),
(618, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١١-م-١', NULL, NULL, NULL, NULL, 618, NULL, 1, NULL, NULL, NULL),
(619, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١١-م-١-١', NULL, NULL, NULL, NULL, 619, NULL, 1, NULL, NULL, NULL),
(620, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١١-م-١-٢', NULL, NULL, NULL, NULL, 620, NULL, 1, NULL, NULL, NULL),
(621, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١١-م-١-٣', NULL, NULL, NULL, NULL, 621, NULL, 1, NULL, NULL, NULL),
(622, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١١-م-١-٤', NULL, NULL, NULL, NULL, 622, NULL, 1, NULL, NULL, NULL),
(623, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١١۔م-١-٥', NULL, NULL, NULL, NULL, 623, NULL, 1, NULL, NULL, NULL),
(624, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١١۔م-١-٦', NULL, NULL, NULL, NULL, 624, NULL, 1, NULL, NULL, NULL),
(625, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١١۔م-١-٧', NULL, NULL, NULL, NULL, 625, NULL, 1, NULL, NULL, NULL),
(626, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١١۔م-١-٨‏', NULL, NULL, NULL, NULL, 626, NULL, 1, NULL, NULL, NULL),
(627, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١١-ش-١', NULL, NULL, NULL, NULL, 627, NULL, 1, NULL, NULL, NULL),
(628, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١١-ش-١-١', NULL, NULL, NULL, NULL, 628, NULL, 1, NULL, NULL, NULL),
(629, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١١-ش۔١۔٢', NULL, NULL, NULL, NULL, 629, NULL, 1, NULL, NULL, NULL),
(630, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١٢-م-١', NULL, NULL, NULL, NULL, 630, NULL, 1, NULL, NULL, NULL),
(631, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١٢-م-١-1', NULL, NULL, NULL, NULL, 631, NULL, 1, NULL, NULL, NULL),
(632, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١٢-م-١-2', NULL, NULL, NULL, NULL, 632, NULL, 1, NULL, NULL, NULL),
(633, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١٢-م-١-3', NULL, NULL, NULL, NULL, 633, NULL, 1, NULL, NULL, NULL),
(634, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١٢-م-١-4', NULL, NULL, NULL, NULL, 634, NULL, 1, NULL, NULL, NULL),
(635, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١٢-م-١-5', NULL, NULL, NULL, NULL, 635, NULL, 1, NULL, NULL, NULL),
(636, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١٢-م-١-6', NULL, NULL, NULL, NULL, 636, NULL, 1, NULL, NULL, NULL),
(637, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-٢١-م-١-٧', NULL, NULL, NULL, NULL, 637, NULL, 1, NULL, NULL, NULL),
(638, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١٢-م-١-8', NULL, NULL, NULL, NULL, 638, NULL, 1, NULL, NULL, NULL),
(639, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١٣-م-1', NULL, NULL, NULL, NULL, 639, NULL, 1, NULL, NULL, NULL),
(640, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١٣-م-١-١', NULL, NULL, NULL, NULL, 640, NULL, 1, NULL, NULL, NULL),
(641, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١٣-م-١-٢', NULL, NULL, NULL, NULL, 641, NULL, 1, NULL, NULL, NULL),
(642, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١٣-م-١-٣', NULL, NULL, NULL, NULL, 642, NULL, 1, NULL, NULL, NULL),
(643, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١٤-م-١', NULL, NULL, NULL, NULL, 643, NULL, 1, NULL, NULL, NULL),
(644, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١٤-م-١-١', NULL, NULL, NULL, NULL, 644, NULL, 1, NULL, NULL, NULL),
(645, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١٥-م-١', NULL, NULL, NULL, NULL, 645, NULL, 1, NULL, NULL, NULL),
(646, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١٥-م-٢', NULL, NULL, NULL, NULL, 646, NULL, 1, NULL, NULL, NULL),
(647, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١٥-م-٣', NULL, NULL, NULL, NULL, 647, NULL, 1, NULL, NULL, NULL),
(648, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١٥-م-٣-١', NULL, NULL, NULL, NULL, 648, NULL, 1, NULL, NULL, NULL),
(649, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١٥-م-٣-2', NULL, NULL, NULL, NULL, 649, NULL, 1, NULL, NULL, NULL),
(650, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١٥-م-٣-3', NULL, NULL, NULL, NULL, 650, NULL, 1, NULL, NULL, NULL),
(651, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١٥-م-٤', NULL, NULL, NULL, NULL, 651, NULL, 1, NULL, NULL, NULL),
(652, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١٥-ش-١', NULL, NULL, NULL, NULL, 652, NULL, 1, NULL, NULL, NULL),
(653, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١٥-ش-٢', NULL, NULL, NULL, NULL, 653, NULL, 1, NULL, NULL, NULL),
(654, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١٥-ش-3', NULL, NULL, NULL, NULL, 654, NULL, 1, NULL, NULL, NULL),
(655, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١٥-ش-٣-١', NULL, NULL, NULL, NULL, 655, NULL, 1, NULL, NULL, NULL),
(656, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١٥-ش-٣-٢', NULL, NULL, NULL, NULL, 656, NULL, 1, NULL, NULL, NULL),
(657, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١٥-ش-٤', NULL, NULL, NULL, NULL, 657, NULL, 1, NULL, NULL, NULL),
(658, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١٦-م-١', NULL, NULL, NULL, NULL, 658, NULL, 1, NULL, NULL, NULL),
(659, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١٦-م-٢', NULL, NULL, NULL, NULL, 659, NULL, 1, NULL, NULL, NULL),
(660, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١٦-م-٣', NULL, NULL, NULL, NULL, 660, NULL, 1, NULL, NULL, NULL),
(661, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١٦-م-٣-١', NULL, NULL, NULL, NULL, 661, NULL, 1, NULL, NULL, NULL),
(662, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١٦-م-٣-٢', NULL, NULL, NULL, NULL, 662, NULL, 1, NULL, NULL, NULL),
(663, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١٦-م-4', NULL, NULL, NULL, NULL, 663, NULL, 1, NULL, NULL, NULL),
(664, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١٧-م-١', NULL, NULL, NULL, NULL, 664, NULL, 1, NULL, NULL, NULL),
(665, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١٧-م-٢', NULL, NULL, NULL, NULL, 665, NULL, 1, NULL, NULL, NULL),
(666, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١٧-م-٣', NULL, NULL, NULL, NULL, 666, NULL, 1, NULL, NULL, NULL),
(667, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١٧-م-٣-١', NULL, NULL, NULL, NULL, 667, NULL, 1, NULL, NULL, NULL),
(668, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١٧-م-٣-٢', NULL, NULL, NULL, NULL, 668, NULL, 1, NULL, NULL, NULL),
(669, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١٧-م-٣-٣', NULL, NULL, NULL, NULL, 669, NULL, 1, NULL, NULL, NULL),
(670, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١٧-م-٣-٤', NULL, NULL, NULL, NULL, 670, NULL, 1, NULL, NULL, NULL),
(671, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١٧-م-٣-٥', NULL, NULL, NULL, NULL, 671, NULL, 1, NULL, NULL, NULL),
(672, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١٧-م-٣-٦', NULL, NULL, NULL, NULL, 672, NULL, 1, NULL, NULL, NULL),
(673, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٢-١٧-م-٤', NULL, NULL, NULL, NULL, 673, NULL, 1, NULL, NULL, NULL),
(674, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٣-١-م-١', NULL, NULL, NULL, NULL, 674, NULL, 1, NULL, NULL, NULL),
(675, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٣-١-م-١-١', NULL, NULL, NULL, NULL, 675, NULL, 1, NULL, NULL, NULL),
(676, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٣-١-م-١-٢', NULL, NULL, NULL, NULL, 676, NULL, 1, NULL, NULL, NULL),
(677, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٣-١-ش-١', NULL, NULL, NULL, NULL, 677, NULL, 1, NULL, NULL, NULL),
(678, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٣-١-ش-١-١', NULL, NULL, NULL, NULL, 678, NULL, 1, NULL, NULL, NULL),
(679, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٤-١-م-١', NULL, NULL, NULL, NULL, 679, NULL, 1, NULL, NULL, NULL),
(680, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٤-١-م-١-١', NULL, NULL, NULL, NULL, 680, NULL, 1, NULL, NULL, NULL),
(681, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٤-١-م-١-٢', NULL, NULL, NULL, NULL, 681, NULL, 1, NULL, NULL, NULL),
(682, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٤-١-م-١-٣', NULL, NULL, NULL, NULL, 682, NULL, 1, NULL, NULL, NULL),
(683, 1, 0, '2023-07-05', '2023-07-05', 'CCC ٤-١-م-١-٤', NULL, NULL, NULL, NULL, 683, NULL, 1, NULL, NULL, NULL),
(684, 1, 0, '2023-07-05', '2023-07-05', 'DCC 1-1-1', NULL, NULL, NULL, NULL, 684, NULL, 1, NULL, NULL, NULL),
(685, 1, 0, '2023-07-05', '2023-07-05', 'DCC 1-1-2', NULL, NULL, NULL, NULL, 685, NULL, 1, NULL, NULL, NULL),
(686, 1, 0, '2023-07-05', '2023-07-05', 'DCC 1-2-1', NULL, NULL, NULL, NULL, 686, NULL, 1, NULL, NULL, NULL),
(687, 1, 0, '2023-07-05', '2023-07-05', 'DCC 1-2-1-1', NULL, NULL, NULL, NULL, 687, NULL, 1, NULL, NULL, NULL),
(688, 1, 0, '2023-07-05', '2023-07-05', 'DCC 1-2-1-2', NULL, NULL, NULL, NULL, 688, NULL, 1, NULL, NULL, NULL),
(689, 1, 0, '2023-07-05', '2023-07-05', 'DCC 1-3-1', NULL, NULL, NULL, NULL, 689, NULL, 1, NULL, NULL, NULL),
(690, 1, 0, '2023-07-05', '2023-07-05', 'DCC 1-3-1-1', NULL, NULL, NULL, NULL, 690, NULL, 1, NULL, NULL, NULL),
(691, 1, 0, '2023-07-05', '2023-07-05', 'DCC 1-3-1-2', NULL, NULL, NULL, NULL, 691, NULL, 1, NULL, NULL, NULL),
(692, 1, 0, '2023-07-05', '2023-07-05', 'DCC 1-3-1-3', NULL, NULL, NULL, NULL, 692, NULL, 1, NULL, NULL, NULL),
(693, 1, 0, '2023-07-05', '2023-07-05', 'DCC 1-3-1-4', NULL, NULL, NULL, NULL, 693, NULL, 1, NULL, NULL, NULL),
(694, 1, 0, '2023-07-05', '2023-07-05', 'DCC 1-3-1-5', NULL, NULL, NULL, NULL, 694, NULL, 1, NULL, NULL, NULL),
(695, 1, 0, '2023-07-05', '2023-07-05', 'DCC 1-3-1-6', NULL, NULL, NULL, NULL, 695, NULL, 1, NULL, NULL, NULL),
(696, 1, 0, '2023-07-05', '2023-07-05', 'DCC 1-3-1-7', NULL, NULL, NULL, NULL, 696, NULL, 1, NULL, NULL, NULL),
(697, 1, 0, '2023-07-05', '2023-07-05', 'DCC 2-1-1', NULL, NULL, NULL, NULL, 697, NULL, 1, NULL, NULL, NULL),
(698, 1, 0, '2023-07-05', '2023-07-05', 'DCC 2-1-1-1', NULL, NULL, NULL, NULL, 698, NULL, 1, NULL, NULL, NULL),
(699, 1, 0, '2023-07-05', '2023-07-05', 'DCC 2-1-1-2', NULL, NULL, NULL, NULL, 699, NULL, 1, NULL, NULL, NULL),
(700, 1, 0, '2023-07-05', '2023-07-05', 'DCC 2-1-2', NULL, NULL, NULL, NULL, 700, NULL, 1, NULL, NULL, NULL),
(701, 1, 0, '2023-07-05', '2023-07-05', 'DCC 2-1-3', NULL, NULL, NULL, NULL, 701, NULL, 1, NULL, NULL, NULL),
(702, 1, 0, '2023-07-05', '2023-07-05', 'DCC 2-2-1', NULL, NULL, NULL, NULL, 702, NULL, 1, NULL, NULL, NULL),
(703, 1, 0, '2023-07-05', '2023-07-05', 'DCC 2-2-1-1', NULL, NULL, NULL, NULL, 703, NULL, 1, NULL, NULL, NULL),
(704, 1, 0, '2023-07-05', '2023-07-05', 'DCC 2-2-1-2', NULL, NULL, NULL, NULL, 704, NULL, 1, NULL, NULL, NULL),
(705, 1, 0, '2023-07-05', '2023-07-05', 'DCC 2-2-1-3', NULL, NULL, NULL, NULL, 705, NULL, 1, NULL, NULL, NULL),
(706, 1, 0, '2023-07-05', '2023-07-05', 'DCC 2-2-1-4', NULL, NULL, NULL, NULL, 706, NULL, 1, NULL, NULL, NULL),
(707, 1, 0, '2023-07-05', '2023-07-05', 'DCC 2-3-1', NULL, NULL, NULL, NULL, 707, NULL, 1, NULL, NULL, NULL),
(708, 1, 0, '2023-07-05', '2023-07-05', 'DCC 2-3-1-1', NULL, NULL, NULL, NULL, 708, NULL, 1, NULL, NULL, NULL),
(709, 1, 0, '2023-07-05', '2023-07-05', 'DCC 2-3-1-2', NULL, NULL, NULL, NULL, 709, NULL, 1, NULL, NULL, NULL),
(710, 1, 0, '2023-07-05', '2023-07-05', 'DCC 2-4-1', NULL, NULL, NULL, NULL, 710, NULL, 1, NULL, NULL, NULL),
(711, 1, 0, '2023-07-05', '2023-07-05', 'DCC 2-4-1-1', NULL, NULL, NULL, NULL, 711, NULL, 1, NULL, NULL, NULL),
(712, 1, 0, '2023-07-05', '2023-07-05', 'DCC 2-4-1-2', NULL, NULL, NULL, NULL, 712, NULL, 1, NULL, NULL, NULL),
(713, 1, 0, '2023-07-05', '2023-07-05', 'DCC 2-4-1-3', NULL, NULL, NULL, NULL, 713, NULL, 1, NULL, NULL, NULL),
(714, 1, 0, '2023-07-05', '2023-07-05', 'DCC 2-4-1-4', NULL, NULL, NULL, NULL, 714, NULL, 1, NULL, NULL, NULL),
(715, 1, 0, '2023-07-05', '2023-07-05', 'DCC 2-5-1', NULL, NULL, NULL, NULL, 715, NULL, 1, NULL, NULL, NULL),
(716, 1, 0, '2023-07-05', '2023-07-05', 'DCC 2-5-1-1', NULL, NULL, NULL, NULL, 716, NULL, 1, NULL, NULL, NULL),
(717, 1, 0, '2023-07-05', '2023-07-05', 'DCC 2-5-1-2', NULL, NULL, NULL, NULL, 717, NULL, 1, NULL, NULL, NULL),
(718, 1, 0, '2023-07-05', '2023-07-05', 'DCC 2-6-1', NULL, NULL, NULL, NULL, 718, NULL, 1, NULL, NULL, NULL),
(719, 1, 0, '2023-07-05', '2023-07-05', 'DCC 2-6-1-1', NULL, NULL, NULL, NULL, 719, NULL, 1, NULL, NULL, NULL),
(720, 1, 0, '2023-07-05', '2023-07-05', 'DCC 2-6-1-2', NULL, NULL, NULL, NULL, 720, NULL, 1, NULL, NULL, NULL),
(721, 1, 0, '2023-07-05', '2023-07-05', 'DCC 2-6-1-3', NULL, NULL, NULL, NULL, 721, NULL, 1, NULL, NULL, NULL),
(722, 1, 0, '2023-07-05', '2023-07-05', 'DCC 2-6-1-4', NULL, NULL, NULL, NULL, 722, NULL, 1, NULL, NULL, NULL),
(723, 1, 0, '2023-07-05', '2023-07-05', 'DCC 2-6-1-5', NULL, NULL, NULL, NULL, 723, NULL, 1, NULL, NULL, NULL),
(724, 1, 0, '2023-07-05', '2023-07-05', 'DCC 2-6-2', NULL, NULL, NULL, NULL, 724, NULL, 1, NULL, NULL, NULL),
(725, 1, 0, '2023-07-05', '2023-07-05', 'DCC 2-7-1', NULL, NULL, NULL, NULL, 725, NULL, 1, NULL, NULL, NULL),
(726, 1, 0, '2023-07-05', '2023-07-05', 'DCC 2-7-2', NULL, NULL, NULL, NULL, 726, NULL, 1, NULL, NULL, NULL),
(727, 1, 0, '2023-07-05', '2023-07-05', 'DCC 2-7-2-1', NULL, NULL, NULL, NULL, 727, NULL, 1, NULL, NULL, NULL),
(728, 1, 0, '2023-07-05', '2023-07-05', 'DCC 2-7-2-2', NULL, NULL, NULL, NULL, 728, NULL, 1, NULL, NULL, NULL),
(729, 1, 0, '2023-07-05', '2023-07-05', 'DCC 2-7-2', NULL, NULL, NULL, NULL, 729, NULL, 1, NULL, NULL, NULL),
(730, 1, 0, '2023-07-05', '2023-07-05', 'DCC 2-7-3-2', NULL, NULL, NULL, NULL, 730, NULL, 1, NULL, NULL, NULL),
(731, 1, 0, '2023-07-05', '2023-07-05', 'DCC 2-7-3-4', NULL, NULL, NULL, NULL, 731, NULL, 1, NULL, NULL, NULL),
(732, 1, 0, '2023-07-05', '2023-07-05', 'DCC 2-7-3-5', NULL, NULL, NULL, NULL, 732, NULL, 1, NULL, NULL, NULL),
(733, 1, 0, '2023-07-05', '2023-07-05', 'DCC 2-7-4', NULL, NULL, NULL, NULL, 733, NULL, 1, NULL, NULL, NULL),
(734, 1, 0, '2023-07-05', '2023-07-05', 'DCC 3-1-1', NULL, NULL, NULL, NULL, 734, NULL, 1, NULL, NULL, NULL),
(735, 1, 0, '2023-07-05', '2023-07-05', 'DCC 3-1-1-1', NULL, NULL, NULL, NULL, 735, NULL, 1, NULL, NULL, NULL),
(736, 1, 0, '2023-07-05', '2023-07-05', 'DCC 3-1-1-2', NULL, NULL, NULL, NULL, 736, NULL, 1, NULL, NULL, NULL),
(737, 1, 0, '2023-07-05', '2023-07-05', 'DCC 3-1-1-3', NULL, NULL, NULL, NULL, 737, NULL, 1, NULL, NULL, NULL),
(738, 1, 0, '2023-07-05', '2023-07-05', 'DCC 3-1-1-4', NULL, NULL, NULL, NULL, 738, NULL, 1, NULL, NULL, NULL),
(739, 1, 0, '2023-07-05', '2023-07-05', 'DCC 3-1-1-5', NULL, NULL, NULL, NULL, 739, NULL, 1, NULL, NULL, NULL),
(740, 1, 0, '2023-07-05', '2023-07-05', 'DCC 3-1-1-6', NULL, NULL, NULL, NULL, 740, NULL, 1, NULL, NULL, NULL),
(741, 1, 0, '2023-07-05', '2023-07-05', 'DCC 3-1-2', NULL, NULL, NULL, NULL, 741, NULL, 1, NULL, NULL, NULL),
(742, 1, 0, '2023-07-05', '2023-07-05', 'DCC 3-1-2-1', NULL, NULL, NULL, NULL, 742, NULL, 1, NULL, NULL, NULL),
(743, 1, 0, '2023-07-05', '2023-07-05', 'DCC 3-1-2-2', NULL, NULL, NULL, NULL, 743, NULL, 1, NULL, NULL, NULL),
(744, 1, 0, '2023-07-05', '2023-07-05', 'DCC 3-1-2-3', NULL, NULL, NULL, NULL, 744, NULL, 1, NULL, NULL, NULL),
(745, 1, 0, '2023-07-05', '2023-07-05', 'DCC 3-1-2-4', NULL, NULL, NULL, NULL, 745, NULL, 1, NULL, NULL, NULL),
(746, 1, 0, '2023-07-05', '2023-07-05', 'DCC 3-1-2-5', NULL, NULL, NULL, NULL, 746, NULL, 1, NULL, NULL, NULL),
(747, 1, 0, '2023-07-05', '2023-07-05', 'DCC 3-1-2-6', NULL, NULL, NULL, NULL, 747, NULL, 1, NULL, NULL, NULL),
(748, 1, 0, '2023-07-05', '2023-07-05', 'DCC 3-1-2-7', NULL, NULL, NULL, NULL, 748, NULL, 1, NULL, NULL, NULL),
(749, 1, 0, '2023-07-05', '2023-07-05', 'DCC 3-1-2-8', NULL, NULL, NULL, NULL, 749, NULL, 1, NULL, NULL, NULL),
(750, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 1-1-1', NULL, NULL, NULL, NULL, 750, NULL, 1, NULL, NULL, NULL),
(751, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 1-2-1', NULL, NULL, NULL, NULL, 751, NULL, 1, NULL, NULL, NULL),
(752, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 1-2-1-1', NULL, NULL, NULL, NULL, 752, NULL, 1, NULL, NULL, NULL),
(753, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 1-2-1-2', NULL, NULL, NULL, NULL, 753, NULL, 1, NULL, NULL, NULL),
(754, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 1-3-1', NULL, NULL, NULL, NULL, 754, NULL, 1, NULL, NULL, NULL),
(755, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 1-3-1-1', NULL, NULL, NULL, NULL, 755, NULL, 1, NULL, NULL, NULL),
(756, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 1-3-1-2', NULL, NULL, NULL, NULL, 756, NULL, 1, NULL, NULL, NULL),
(757, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 1-3-2', NULL, NULL, NULL, NULL, 757, NULL, 1, NULL, NULL, NULL),
(758, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 1-3-2-1', NULL, NULL, NULL, NULL, 758, NULL, 1, NULL, NULL, NULL),
(759, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 1-3-2-2', NULL, NULL, NULL, NULL, 759, NULL, 1, NULL, NULL, NULL),
(760, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 1-3-2-3', NULL, NULL, NULL, NULL, 760, NULL, 1, NULL, NULL, NULL),
(761, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 1-3-2-4', NULL, NULL, NULL, NULL, 761, NULL, 1, NULL, NULL, NULL),
(762, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 1-4-1', NULL, NULL, NULL, NULL, 762, NULL, 1, NULL, NULL, NULL),
(763, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 1-4-2', NULL, NULL, NULL, NULL, 763, NULL, 1, NULL, NULL, NULL),
(764, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 1-5-1', NULL, NULL, NULL, NULL, 764, NULL, 1, NULL, NULL, NULL),
(765, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 1-5-1-1', NULL, NULL, NULL, NULL, 765, NULL, 1, NULL, NULL, NULL),
(766, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 1-5-1-2', NULL, NULL, NULL, NULL, 766, NULL, 1, NULL, NULL, NULL),
(767, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-1-1', NULL, NULL, NULL, NULL, 767, NULL, 1, NULL, NULL, NULL),
(768, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-1-1-1', NULL, NULL, NULL, NULL, 768, NULL, 1, NULL, NULL, NULL),
(769, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-1-1-2', NULL, NULL, NULL, NULL, 769, NULL, 1, NULL, NULL, NULL),
(770, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-2-1', NULL, NULL, NULL, NULL, 770, NULL, 1, NULL, NULL, NULL),
(771, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-2-1-1', NULL, NULL, NULL, NULL, 771, NULL, 1, NULL, NULL, NULL),
(772, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-2-1-2', NULL, NULL, NULL, NULL, 772, NULL, 1, NULL, NULL, NULL),
(773, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-2-1-3', NULL, NULL, NULL, NULL, 773, NULL, 1, NULL, NULL, NULL),
(774, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-2-1-4', NULL, NULL, NULL, NULL, 774, NULL, 1, NULL, NULL, NULL),
(775, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-2-1-5', NULL, NULL, NULL, NULL, 775, NULL, 1, NULL, NULL, NULL),
(776, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-2-1-6', NULL, NULL, NULL, NULL, 776, NULL, 1, NULL, NULL, NULL),
(777, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-2-1-7', NULL, NULL, NULL, NULL, 777, NULL, 1, NULL, NULL, NULL),
(778, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-2-1-8', NULL, NULL, NULL, NULL, 778, NULL, 1, NULL, NULL, NULL),
(779, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-2-2', NULL, NULL, NULL, NULL, 779, NULL, 1, NULL, NULL, NULL),
(780, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-3-1', NULL, NULL, NULL, NULL, 780, NULL, 1, NULL, NULL, NULL),
(781, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-3-1-1', NULL, NULL, NULL, NULL, 781, NULL, 1, NULL, NULL, NULL),
(782, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-3-1-2', NULL, NULL, NULL, NULL, 782, NULL, 1, NULL, NULL, NULL),
(783, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-3-1-3', NULL, NULL, NULL, NULL, 783, NULL, 1, NULL, NULL, NULL),
(784, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-3-1-4', NULL, NULL, NULL, NULL, 784, NULL, 1, NULL, NULL, NULL),
(785, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-3-1-5', NULL, NULL, NULL, NULL, 785, NULL, 1, NULL, NULL, NULL),
(786, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-3-1-6', NULL, NULL, NULL, NULL, 786, NULL, 1, NULL, NULL, NULL),
(787, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-3-1-7', NULL, NULL, NULL, NULL, 787, NULL, 1, NULL, NULL, NULL),
(788, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-3-1-8', NULL, NULL, NULL, NULL, 788, NULL, 1, NULL, NULL, NULL),
(789, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-4-1', NULL, NULL, NULL, NULL, 789, NULL, 1, NULL, NULL, NULL),
(790, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-4-1-1', NULL, NULL, NULL, NULL, 790, NULL, 1, NULL, NULL, NULL),
(791, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-4-1-2', NULL, NULL, NULL, NULL, 791, NULL, 1, NULL, NULL, NULL),
(792, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-4-1-3', NULL, NULL, NULL, NULL, 792, NULL, 1, NULL, NULL, NULL),
(793, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-4-1-4', NULL, NULL, NULL, NULL, 793, NULL, 1, NULL, NULL, NULL),
(794, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-4-1-5', NULL, NULL, NULL, NULL, 794, NULL, 1, NULL, NULL, NULL),
(795, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-4-1-6', NULL, NULL, NULL, NULL, 795, NULL, 1, NULL, NULL, NULL),
(796, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-4-1-7', NULL, NULL, NULL, NULL, 796, NULL, 1, NULL, NULL, NULL),
(797, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-4-1-8', NULL, NULL, NULL, NULL, 797, NULL, 1, NULL, NULL, NULL),
(798, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-4-1-9', NULL, NULL, NULL, NULL, 798, NULL, 1, NULL, NULL, NULL),
(799, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-5-1', NULL, NULL, NULL, NULL, 799, NULL, 1, NULL, NULL, NULL),
(800, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-5-1-1', NULL, NULL, NULL, NULL, 800, NULL, 1, NULL, NULL, NULL),
(801, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-5-1-2', NULL, NULL, NULL, NULL, 801, NULL, 1, NULL, NULL, NULL),
(802, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-6-1', NULL, NULL, NULL, NULL, 802, NULL, 1, NULL, NULL, NULL),
(803, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-6-1-1', NULL, NULL, NULL, NULL, 803, NULL, 1, NULL, NULL, NULL),
(804, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-6-1-2', NULL, NULL, NULL, NULL, 804, NULL, 1, NULL, NULL, NULL),
(805, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-6-1-3', NULL, NULL, NULL, NULL, 805, NULL, 1, NULL, NULL, NULL),
(806, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-6-1-4', NULL, NULL, NULL, NULL, 806, NULL, 1, NULL, NULL, NULL),
(807, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-6-1-5', NULL, NULL, NULL, NULL, 807, NULL, 1, NULL, NULL, NULL),
(808, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-7-1', NULL, NULL, NULL, NULL, 808, NULL, 1, NULL, NULL, NULL),
(809, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-7-1-1', NULL, NULL, NULL, NULL, 809, NULL, 1, NULL, NULL, NULL),
(810, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-7-1-2', NULL, NULL, NULL, NULL, 810, NULL, 1, NULL, NULL, NULL),
(811, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-7-1-3', NULL, NULL, NULL, NULL, 811, NULL, 1, NULL, NULL, NULL),
(812, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-8-1', NULL, NULL, NULL, NULL, 812, NULL, 1, NULL, NULL, NULL),
(813, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-8-1-1', NULL, NULL, NULL, NULL, 813, NULL, 1, NULL, NULL, NULL),
(814, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-8-1-2', NULL, NULL, NULL, NULL, 814, NULL, 1, NULL, NULL, NULL),
(815, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-8-1-3', NULL, NULL, NULL, NULL, 815, NULL, 1, NULL, NULL, NULL),
(816, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-8-2', NULL, NULL, NULL, NULL, 816, NULL, 1, NULL, NULL, NULL),
(817, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-9-1', NULL, NULL, NULL, NULL, 817, NULL, 1, NULL, NULL, NULL),
(818, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-9-1-1', NULL, NULL, NULL, NULL, 818, NULL, 1, NULL, NULL, NULL),
(819, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-9-1-2', NULL, NULL, NULL, NULL, 819, NULL, 1, NULL, NULL, NULL),
(820, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-9-1-3', NULL, NULL, NULL, NULL, 820, NULL, 1, NULL, NULL, NULL),
(821, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-9-2', NULL, NULL, NULL, NULL, 821, NULL, 1, NULL, NULL, NULL),
(822, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-10-1', NULL, NULL, NULL, NULL, 822, NULL, 1, NULL, NULL, NULL),
(823, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-10-1-1', NULL, NULL, NULL, NULL, 823, NULL, 1, NULL, NULL, NULL),
(824, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-10-1-2', NULL, NULL, NULL, NULL, 824, NULL, 1, NULL, NULL, NULL),
(825, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-10-2', NULL, NULL, NULL, NULL, 825, NULL, 1, NULL, NULL, NULL),
(826, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-11-1', NULL, NULL, NULL, NULL, 826, NULL, 1, NULL, NULL, NULL),
(827, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-11-1-1', NULL, NULL, NULL, NULL, 827, NULL, 1, NULL, NULL, NULL),
(828, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-11-1-2', NULL, NULL, NULL, NULL, 828, NULL, 1, NULL, NULL, NULL),
(829, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-11-1-3', NULL, NULL, NULL, NULL, 829, NULL, 1, NULL, NULL, NULL),
(830, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-11-1-4', NULL, NULL, NULL, NULL, 830, NULL, 1, NULL, NULL, NULL),
(831, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-11-1-5', NULL, NULL, NULL, NULL, 831, NULL, 1, NULL, NULL, NULL),
(832, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-11-2', NULL, NULL, NULL, NULL, 832, NULL, 1, NULL, NULL, NULL),
(833, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-12-1', NULL, NULL, NULL, NULL, 833, NULL, 1, NULL, NULL, NULL),
(834, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-12-1-1', NULL, NULL, NULL, NULL, 834, NULL, 1, NULL, NULL, NULL),
(835, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-12-1-2', NULL, NULL, NULL, NULL, 835, NULL, 1, NULL, NULL, NULL),
(836, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-12-2', NULL, NULL, NULL, NULL, 836, NULL, 1, NULL, NULL, NULL),
(837, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-13-1', NULL, NULL, NULL, NULL, 837, NULL, 1, NULL, NULL, NULL),
(838, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-13-2', NULL, NULL, NULL, NULL, 838, NULL, 1, NULL, NULL, NULL),
(839, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-13-3', NULL, NULL, NULL, NULL, 839, NULL, 1, NULL, NULL, NULL),
(840, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-13-3-1', NULL, NULL, NULL, NULL, 840, NULL, 1, NULL, NULL, NULL),
(841, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-13-3-2', NULL, NULL, NULL, NULL, 841, NULL, 1, NULL, NULL, NULL),
(842, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-13-3-3', NULL, NULL, NULL, NULL, 842, NULL, 1, NULL, NULL, NULL),
(843, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-13-3-4', NULL, NULL, NULL, NULL, 843, NULL, 1, NULL, NULL, NULL),
(844, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 2-13-4', NULL, NULL, NULL, NULL, 844, NULL, 1, NULL, NULL, NULL),
(845, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 3-1-1', NULL, NULL, NULL, NULL, 845, NULL, 1, NULL, NULL, NULL),
(846, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 3-1-1-1', NULL, NULL, NULL, NULL, 846, NULL, 1, NULL, NULL, NULL),
(847, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 3-1-1-2', NULL, NULL, NULL, NULL, 847, NULL, 1, NULL, NULL, NULL),
(848, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 3-1-1-3', NULL, NULL, NULL, NULL, 848, NULL, 1, NULL, NULL, NULL),
(849, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 3-1-1-4', NULL, NULL, NULL, NULL, 849, NULL, 1, NULL, NULL, NULL),
(850, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 4-1-1', NULL, NULL, NULL, NULL, 850, NULL, 1, NULL, NULL, NULL),
(851, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 4-1-1-1', NULL, NULL, NULL, NULL, 851, NULL, 1, NULL, NULL, NULL),
(852, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 4-1-1-2', NULL, NULL, NULL, NULL, 852, NULL, 1, NULL, NULL, NULL),
(853, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 4-2-1', NULL, NULL, NULL, NULL, 853, NULL, 1, NULL, NULL, NULL),
(854, 1, 0, '2023-07-05', '2023-07-05', 'CSCC 4-2-1-1', NULL, NULL, NULL, NULL, 854, NULL, 1, NULL, NULL, NULL),
(855, 1, 0, '2023-07-05', '2023-07-05', 'SAMA 3-1-1', NULL, NULL, NULL, NULL, 855, NULL, 1, NULL, NULL, NULL),
(856, 1, 0, '2023-07-05', '2023-07-05', 'SAMA 3-1-2', NULL, NULL, NULL, NULL, 856, NULL, 1, NULL, NULL, NULL),
(857, 1, 0, '2023-07-05', '2023-07-05', 'SAMA 3-1-3', NULL, NULL, NULL, NULL, 857, NULL, 1, NULL, NULL, NULL),
(858, 1, 0, '2023-07-05', '2023-07-05', 'SAMA 3-1-4', NULL, NULL, NULL, NULL, 858, NULL, 1, NULL, NULL, NULL),
(859, 1, 0, '2023-07-05', '2023-07-05', 'SAMA 3-1-5', NULL, NULL, NULL, NULL, 859, NULL, 1, NULL, NULL, NULL),
(860, 1, 0, '2023-07-05', '2023-07-05', 'SAMA 3-1-6', NULL, NULL, NULL, NULL, 860, NULL, 1, NULL, NULL, NULL),
(861, 1, 0, '2023-07-05', '2023-07-05', 'SAMA 3-1-7', NULL, NULL, NULL, NULL, 861, NULL, 1, NULL, NULL, NULL),
(862, 1, 0, '2023-07-05', '2023-07-05', 'SAMA 3-2-1', NULL, NULL, NULL, NULL, 862, NULL, 1, NULL, NULL, NULL),
(863, 1, 0, '2023-07-05', '2023-07-05', 'SAMA 3-2-1-1', NULL, NULL, NULL, NULL, 863, NULL, 1, NULL, NULL, NULL),
(864, 1, 0, '2023-07-05', '2023-07-05', 'SAMA 3-2-1-2', NULL, NULL, NULL, NULL, 864, NULL, 1, NULL, NULL, NULL),
(865, 1, 0, '2023-07-05', '2023-07-05', 'SAMA 3-2-1-3', NULL, NULL, NULL, NULL, 865, NULL, 1, NULL, NULL, NULL),
(866, 1, 0, '2023-07-05', '2023-07-05', 'SAMA 3-2-1-4', NULL, NULL, NULL, NULL, 866, NULL, 1, NULL, NULL, NULL),
(867, 1, 0, '2023-07-05', '2023-07-05', 'SAMA 3-2-2', NULL, NULL, NULL, NULL, 867, NULL, 1, NULL, NULL, NULL),
(868, 1, 0, '2023-07-05', '2023-07-05', 'SAMA 3-2-3', NULL, NULL, NULL, NULL, 868, NULL, 1, NULL, NULL, NULL),
(869, 1, 0, '2023-07-05', '2023-07-05', 'SAMA 3-2-4', NULL, NULL, NULL, NULL, 869, NULL, 1, NULL, NULL, NULL),
(870, 1, 0, '2023-07-05', '2023-07-05', 'SAMA 3-2-5', NULL, NULL, NULL, NULL, 870, NULL, 1, NULL, NULL, NULL),
(871, 1, 0, '2023-07-05', '2023-07-05', 'SAMA 3-3-1', NULL, NULL, NULL, NULL, 871, NULL, 1, NULL, NULL, NULL),
(872, 1, 0, '2023-07-05', '2023-07-05', 'SAMA 3-3-2', NULL, NULL, NULL, NULL, 872, NULL, 1, NULL, NULL, NULL),
(873, 1, 0, '2023-07-05', '2023-07-05', 'SAMA 3-3-3', NULL, NULL, NULL, NULL, 873, NULL, 1, NULL, NULL, NULL),
(874, 1, 0, '2023-07-05', '2023-07-05', 'SAMA 3-3-4', NULL, NULL, NULL, NULL, 874, NULL, 1, NULL, NULL, NULL),
(875, 1, 0, '2023-07-05', '2023-07-05', 'SAMA 3-3-5', NULL, NULL, NULL, NULL, 875, NULL, 1, NULL, NULL, NULL),
(876, 1, 0, '2023-07-05', '2023-07-05', 'SAMA 3-3-6', NULL, NULL, NULL, NULL, 876, NULL, 1, NULL, NULL, NULL),
(877, 1, 0, '2023-07-05', '2023-07-05', 'SAMA 3-3-7', NULL, NULL, NULL, NULL, 877, NULL, 1, NULL, NULL, NULL),
(878, 1, 0, '2023-07-05', '2023-07-05', 'SAMA 3-3-8', NULL, NULL, NULL, NULL, 878, NULL, 1, NULL, NULL, NULL),
(879, 1, 0, '2023-07-05', '2023-07-05', 'SAMA 3-3-9', NULL, NULL, NULL, NULL, 879, NULL, 1, NULL, NULL, NULL),
(880, 1, 0, '2023-07-05', '2023-07-05', 'SAMA 3-3-10', NULL, NULL, NULL, NULL, 880, NULL, 1, NULL, NULL, NULL),
(881, 1, 0, '2023-07-05', '2023-07-05', 'SAMA 3-3-11', NULL, NULL, NULL, NULL, 881, NULL, 1, NULL, NULL, NULL),
(882, 1, 0, '2023-07-05', '2023-07-05', 'SAMA 3-3-12', NULL, NULL, NULL, NULL, 882, NULL, 1, NULL, NULL, NULL),
(883, 1, 0, '2023-07-05', '2023-07-05', 'SAMA 3-3-13', NULL, NULL, NULL, NULL, 883, NULL, 1, NULL, NULL, NULL),
(884, 1, 0, '2023-07-05', '2023-07-05', 'SAMA 3-3-14', NULL, NULL, NULL, NULL, 884, NULL, 1, NULL, NULL, NULL),
(885, 1, 0, '2023-07-05', '2023-07-05', 'SAMA 3-3-15', NULL, NULL, NULL, NULL, 885, NULL, 1, NULL, NULL, NULL),
(886, 1, 0, '2023-07-05', '2023-07-05', 'SAMA 3-3-16', NULL, NULL, NULL, NULL, 886, NULL, 1, NULL, NULL, NULL),
(887, 1, 0, '2023-07-05', '2023-07-05', 'SAMA 3-3-17', NULL, NULL, NULL, NULL, 887, NULL, 1, NULL, NULL, NULL),
(888, 1, 0, '2023-07-05', '2023-07-05', 'SAMA 3-4-1', NULL, NULL, NULL, NULL, 888, NULL, 1, NULL, NULL, NULL),
(889, 1, 0, '2023-07-05', '2023-07-05', 'SAMA 3-4-2', NULL, NULL, NULL, NULL, 889, NULL, 1, NULL, NULL, NULL),
(890, 1, 0, '2023-07-05', '2023-07-05', 'SAMA 3-4-3', NULL, NULL, NULL, NULL, 890, NULL, 1, NULL, NULL, NULL),
(891, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.5.1.1', NULL, NULL, NULL, NULL, 891, NULL, 1, NULL, NULL, NULL),
(892, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.5.1.2', NULL, NULL, NULL, NULL, 892, NULL, 1, NULL, NULL, NULL),
(893, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.6.1.1', NULL, NULL, NULL, NULL, 893, NULL, 1, NULL, NULL, NULL),
(894, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.6.1.2', NULL, NULL, NULL, NULL, 894, NULL, 1, NULL, NULL, NULL),
(895, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.6.1.3', NULL, NULL, NULL, NULL, 895, NULL, 1, NULL, NULL, NULL),
(896, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.6.1.4', NULL, NULL, NULL, NULL, 896, NULL, 1, NULL, NULL, NULL),
(897, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-6-4', NULL, NULL, NULL, NULL, 897, NULL, 1, NULL, NULL, NULL),
(898, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.6.1.5', NULL, NULL, NULL, NULL, 898, NULL, 1, NULL, NULL, NULL),
(899, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.6.2.1', NULL, NULL, NULL, NULL, 899, NULL, 1, NULL, NULL, NULL),
(900, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.6.2.2', NULL, NULL, NULL, NULL, 900, NULL, 1, NULL, NULL, NULL),
(901, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.7.1.1', NULL, NULL, NULL, NULL, 901, NULL, 1, NULL, NULL, NULL),
(902, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.7.1.2', NULL, NULL, NULL, NULL, 902, NULL, 1, NULL, NULL, NULL),
(903, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.7.2.1', NULL, NULL, NULL, NULL, 903, NULL, 1, NULL, NULL, NULL),
(904, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.7.2.2', NULL, NULL, NULL, NULL, 904, NULL, 1, NULL, NULL, NULL),
(905, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.7.2.3', NULL, NULL, NULL, NULL, 905, NULL, 1, NULL, NULL, NULL),
(906, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.7.3.1', NULL, NULL, NULL, NULL, 906, NULL, 1, NULL, NULL, NULL);
INSERT INTO `framework_control_tests` (`id`, `tester`, `test_frequency`, `last_date`, `next_date`, `name`, `objective`, `test_steps`, `approximate_time`, `expected_results`, `framework_control_id`, `desired_frequency`, `status`, `additional_stakeholders`, `created_at`, `updated_at`) VALUES
(907, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.8.1.1', NULL, NULL, NULL, NULL, 907, NULL, 1, NULL, NULL, NULL),
(908, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.8.1.2', NULL, NULL, NULL, NULL, 908, NULL, 1, NULL, NULL, NULL),
(909, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.8.1.3', NULL, NULL, NULL, NULL, 909, NULL, 1, NULL, NULL, NULL),
(910, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.8.1.4', NULL, NULL, NULL, NULL, 910, NULL, 1, NULL, NULL, NULL),
(911, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.8.2.1', NULL, NULL, NULL, NULL, 911, NULL, 1, NULL, NULL, NULL),
(912, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.8.2.2', NULL, NULL, NULL, NULL, 912, NULL, 1, NULL, NULL, NULL),
(913, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.8.2.3', NULL, NULL, NULL, NULL, 913, NULL, 1, NULL, NULL, NULL),
(914, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.8.3.1', NULL, NULL, NULL, NULL, 914, NULL, 1, NULL, NULL, NULL),
(915, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.8.3.2', NULL, NULL, NULL, NULL, 915, NULL, 1, NULL, NULL, NULL),
(916, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.8.3.3', NULL, NULL, NULL, NULL, 916, NULL, 1, NULL, NULL, NULL),
(917, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.9.1.1', NULL, NULL, NULL, NULL, 917, NULL, 1, NULL, NULL, NULL),
(918, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.9.1.2', NULL, NULL, NULL, NULL, 918, NULL, 1, NULL, NULL, NULL),
(919, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.9.2.1', NULL, NULL, NULL, NULL, 919, NULL, 1, NULL, NULL, NULL),
(920, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.9.2.2', NULL, NULL, NULL, NULL, 920, NULL, 1, NULL, NULL, NULL),
(921, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.9.2.3', NULL, NULL, NULL, NULL, 921, NULL, 1, NULL, NULL, NULL),
(922, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.9.2.4', NULL, NULL, NULL, NULL, 922, NULL, 1, NULL, NULL, NULL),
(923, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.9.2.5', NULL, NULL, NULL, NULL, 923, NULL, 1, NULL, NULL, NULL),
(924, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.9.2.6', NULL, NULL, NULL, NULL, 924, NULL, 1, NULL, NULL, NULL),
(925, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.9.3.1', NULL, NULL, NULL, NULL, 925, NULL, 1, NULL, NULL, NULL),
(926, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.9.4.1', NULL, NULL, NULL, NULL, 926, NULL, 1, NULL, NULL, NULL),
(927, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.9.4.2', NULL, NULL, NULL, NULL, 927, NULL, 1, NULL, NULL, NULL),
(928, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.9.4.3', NULL, NULL, NULL, NULL, 928, NULL, 1, NULL, NULL, NULL),
(929, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.9.4.4', NULL, NULL, NULL, NULL, 929, NULL, 1, NULL, NULL, NULL),
(930, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.9.4.5', NULL, NULL, NULL, NULL, 930, NULL, 1, NULL, NULL, NULL),
(931, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.10.1.1', NULL, NULL, NULL, NULL, 931, NULL, 1, NULL, NULL, NULL),
(932, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.10.1.2', NULL, NULL, NULL, NULL, 932, NULL, 1, NULL, NULL, NULL),
(933, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.11.1.1', NULL, NULL, NULL, NULL, 933, NULL, 1, NULL, NULL, NULL),
(934, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.11.1.2', NULL, NULL, NULL, NULL, 934, NULL, 1, NULL, NULL, NULL),
(935, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.11.1.3', NULL, NULL, NULL, NULL, 935, NULL, 1, NULL, NULL, NULL),
(936, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.11.1.4', NULL, NULL, NULL, NULL, 936, NULL, 1, NULL, NULL, NULL),
(937, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.11.1.5', NULL, NULL, NULL, NULL, 937, NULL, 1, NULL, NULL, NULL),
(938, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.11.1.6', NULL, NULL, NULL, NULL, 938, NULL, 1, NULL, NULL, NULL),
(939, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.11.2.1', NULL, NULL, NULL, NULL, 939, NULL, 1, NULL, NULL, NULL),
(940, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.11.2.2', NULL, NULL, NULL, NULL, 940, NULL, 1, NULL, NULL, NULL),
(941, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.11.2.3', NULL, NULL, NULL, NULL, 941, NULL, 1, NULL, NULL, NULL),
(942, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.11.2.4', NULL, NULL, NULL, NULL, 942, NULL, 1, NULL, NULL, NULL),
(943, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.11.2.5', NULL, NULL, NULL, NULL, 943, NULL, 1, NULL, NULL, NULL),
(944, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.11.2.5', NULL, NULL, NULL, NULL, 944, NULL, 1, NULL, NULL, NULL),
(945, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.11.2.6', NULL, NULL, NULL, NULL, 945, NULL, 1, NULL, NULL, NULL),
(946, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.11.2.7', NULL, NULL, NULL, NULL, 946, NULL, 1, NULL, NULL, NULL),
(947, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.11.2.8', NULL, NULL, NULL, NULL, 947, NULL, 1, NULL, NULL, NULL),
(948, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.11.2.9', NULL, NULL, NULL, NULL, 948, NULL, 1, NULL, NULL, NULL),
(949, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.12.1.1', NULL, NULL, NULL, NULL, 949, NULL, 1, NULL, NULL, NULL),
(950, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.12.1.2', NULL, NULL, NULL, NULL, 950, NULL, 1, NULL, NULL, NULL),
(951, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.12.1.3', NULL, NULL, NULL, NULL, 951, NULL, 1, NULL, NULL, NULL),
(952, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.12.1.4', NULL, NULL, NULL, NULL, 952, NULL, 1, NULL, NULL, NULL),
(953, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.12.2.1', NULL, NULL, NULL, NULL, 953, NULL, 1, NULL, NULL, NULL),
(954, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.12.3.1', NULL, NULL, NULL, NULL, 954, NULL, 1, NULL, NULL, NULL),
(955, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.12.4.1', NULL, NULL, NULL, NULL, 955, NULL, 1, NULL, NULL, NULL),
(956, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.12.4.2', NULL, NULL, NULL, NULL, 956, NULL, 1, NULL, NULL, NULL),
(957, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.12.4.3', NULL, NULL, NULL, NULL, 957, NULL, 1, NULL, NULL, NULL),
(958, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.12.4.4', NULL, NULL, NULL, NULL, 958, NULL, 1, NULL, NULL, NULL),
(959, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.12.5.1', NULL, NULL, NULL, NULL, 959, NULL, 1, NULL, NULL, NULL),
(960, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.12.6.1', NULL, NULL, NULL, NULL, 960, NULL, 1, NULL, NULL, NULL),
(961, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.12.6.2', NULL, NULL, NULL, NULL, 961, NULL, 1, NULL, NULL, NULL),
(962, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.12.7.1', NULL, NULL, NULL, NULL, 962, NULL, 1, NULL, NULL, NULL),
(963, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.13.1.1', NULL, NULL, NULL, NULL, 963, NULL, 1, NULL, NULL, NULL),
(964, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.13.1.2', NULL, NULL, NULL, NULL, 964, NULL, 1, NULL, NULL, NULL),
(965, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.13.1.3', NULL, NULL, NULL, NULL, 965, NULL, 1, NULL, NULL, NULL),
(966, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.13.2.1', NULL, NULL, NULL, NULL, 966, NULL, 1, NULL, NULL, NULL),
(967, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.13.2.2', NULL, NULL, NULL, NULL, 967, NULL, 1, NULL, NULL, NULL),
(968, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.13.2.3', NULL, NULL, NULL, NULL, 968, NULL, 1, NULL, NULL, NULL),
(969, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.13.2.4', NULL, NULL, NULL, NULL, 969, NULL, 1, NULL, NULL, NULL),
(970, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.13.2.4', NULL, NULL, NULL, NULL, 970, NULL, 1, NULL, NULL, NULL),
(971, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.14.1.1', NULL, NULL, NULL, NULL, 971, NULL, 1, NULL, NULL, NULL),
(972, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.14.1.2', NULL, NULL, NULL, NULL, 972, NULL, 1, NULL, NULL, NULL),
(973, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.14.1.3', NULL, NULL, NULL, NULL, 973, NULL, 1, NULL, NULL, NULL),
(974, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.14.2.1', NULL, NULL, NULL, NULL, 974, NULL, 1, NULL, NULL, NULL),
(975, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.14.2.2', NULL, NULL, NULL, NULL, 975, NULL, 1, NULL, NULL, NULL),
(976, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.14.2.3', NULL, NULL, NULL, NULL, 976, NULL, 1, NULL, NULL, NULL),
(977, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.14.2.4', NULL, NULL, NULL, NULL, 977, NULL, 1, NULL, NULL, NULL),
(978, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.14.2.5', NULL, NULL, NULL, NULL, 978, NULL, 1, NULL, NULL, NULL),
(979, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.14.2.6', NULL, NULL, NULL, NULL, 979, NULL, 1, NULL, NULL, NULL),
(980, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.14.2.7', NULL, NULL, NULL, NULL, 980, NULL, 1, NULL, NULL, NULL),
(981, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.14.2.8', NULL, NULL, NULL, NULL, 981, NULL, 1, NULL, NULL, NULL),
(982, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.14.2.9', NULL, NULL, NULL, NULL, 982, NULL, 1, NULL, NULL, NULL),
(983, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.14.3.1', NULL, NULL, NULL, NULL, 983, NULL, 1, NULL, NULL, NULL),
(984, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.15.1.1', NULL, NULL, NULL, NULL, 984, NULL, 1, NULL, NULL, NULL),
(985, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.15.1.2', NULL, NULL, NULL, NULL, 985, NULL, 1, NULL, NULL, NULL),
(986, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.15.1.3', NULL, NULL, NULL, NULL, 986, NULL, 1, NULL, NULL, NULL),
(987, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.15.2.1', NULL, NULL, NULL, NULL, 987, NULL, 1, NULL, NULL, NULL),
(988, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.15.2.2', NULL, NULL, NULL, NULL, 988, NULL, 1, NULL, NULL, NULL),
(989, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.16.1.1', NULL, NULL, NULL, NULL, 989, NULL, 1, NULL, NULL, NULL),
(990, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.16.1.2', NULL, NULL, NULL, NULL, 990, NULL, 1, NULL, NULL, NULL),
(991, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.16.1.3', NULL, NULL, NULL, NULL, 991, NULL, 1, NULL, NULL, NULL),
(992, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.16.1.4', NULL, NULL, NULL, NULL, 992, NULL, 1, NULL, NULL, NULL),
(993, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.16.1.5', NULL, NULL, NULL, NULL, 993, NULL, 1, NULL, NULL, NULL),
(994, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.16.1.6', NULL, NULL, NULL, NULL, 994, NULL, 1, NULL, NULL, NULL),
(995, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.16.1.7', NULL, NULL, NULL, NULL, 995, NULL, 1, NULL, NULL, NULL),
(996, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.17.1.1', NULL, NULL, NULL, NULL, 996, NULL, 1, NULL, NULL, NULL),
(997, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.17.1.2', NULL, NULL, NULL, NULL, 997, NULL, 1, NULL, NULL, NULL),
(998, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.17.1.3', NULL, NULL, NULL, NULL, 998, NULL, 1, NULL, NULL, NULL),
(999, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.17.2.1', NULL, NULL, NULL, NULL, 999, NULL, 1, NULL, NULL, NULL),
(1000, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.18.1.1', NULL, NULL, NULL, NULL, 1000, NULL, 1, NULL, NULL, NULL),
(1001, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.18.1.2', NULL, NULL, NULL, NULL, 1001, NULL, 1, NULL, NULL, NULL),
(1002, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.18.1.3', NULL, NULL, NULL, NULL, 1002, NULL, 1, NULL, NULL, NULL),
(1003, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.18.1.4', NULL, NULL, NULL, NULL, 1003, NULL, 1, NULL, NULL, NULL),
(1004, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.18.1.5', NULL, NULL, NULL, NULL, 1004, NULL, 1, NULL, NULL, NULL),
(1005, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.18.2.1', NULL, NULL, NULL, NULL, 1005, NULL, 1, NULL, NULL, NULL),
(1006, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.18.2.2', NULL, NULL, NULL, NULL, 1006, NULL, 1, NULL, NULL, NULL),
(1007, 1, 0, '2023-07-05', '2023-07-05', 'ISO A.18.2.3', NULL, NULL, NULL, NULL, 1007, NULL, 1, NULL, NULL, NULL),
(1008, 1, 2, '2023-08-22', '2023-08-24', 'tes_4', '4', '4', 15, 't', 1008, NULL, 1, NULL, NULL, NULL),
(1009, 6, 2, '2023-08-23', '2023-08-25', 'tt_7', 'e', 'e', NULL, 'e', 1009, NULL, 1, NULL, NULL, NULL),
(1010, 6, 3, '2023-08-21', '2023-08-24', 'ew', 'weweqe', 'eweqweqwe', 30, 'qweqwe', 1010, NULL, 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `framework_control_test_audits`
--

CREATE TABLE `framework_control_test_audits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `test_id` bigint(20) UNSIGNED NOT NULL,
  `tester` bigint(20) UNSIGNED NOT NULL,
  `test_frequency` int(11) DEFAULT 0,
  `last_date` date DEFAULT NULL,
  `next_date` date DEFAULT NULL,
  `name` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `objective` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `test_steps` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approximate_time` int(11) DEFAULT NULL,
  `expected_results` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `framework_control_id` bigint(20) UNSIGNED DEFAULT NULL,
  `desired_frequency` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `framework_control_test_audits`
--

INSERT INTO `framework_control_test_audits` (`id`, `test_id`, `tester`, `test_frequency`, `last_date`, `next_date`, `name`, `objective`, `test_steps`, `approximate_time`, `expected_results`, `framework_control_id`, `desired_frequency`, `status`, `created_at`, `updated_at`) VALUES
(1, 5, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-1-1(1)', NULL, NULL, NULL, NULL, 5, NULL, 1, NULL, NULL),
(2, 11, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-3-1(1)', NULL, NULL, NULL, NULL, 11, NULL, 1, NULL, NULL),
(3, 10, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-2-3(1)', NULL, NULL, NULL, NULL, 10, NULL, 1, NULL, NULL),
(4, 7, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-1-3(1)', NULL, NULL, NULL, NULL, 7, NULL, 1, NULL, NULL),
(5, 5, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-1-1(2)', NULL, NULL, NULL, NULL, 5, NULL, 1, NULL, NULL),
(6, 1008, 1, 2, '2023-08-22', '2023-08-24', 'tes_4(1)', NULL, NULL, NULL, NULL, 1008, NULL, 1, NULL, NULL),
(7, 1008, 1, 2, '2023-08-24', '2023-08-26', 'tes_4(2)', '4', '4', 15, 't', 1008, NULL, 1, NULL, NULL),
(8, 1009, 1, 2, '2023-08-23', '2023-08-25', 'tt_7(1)', NULL, NULL, NULL, NULL, 1009, NULL, 1, NULL, NULL),
(9, 1009, 1, 2, '2023-08-25', '2023-08-27', 'tt_7(2)', 'e', 'e', NULL, 'e', 1009, NULL, 1, NULL, NULL),
(10, 1009, 6, 2, '2023-08-27', '2023-08-29', 'tt_7(3)', 'e', 'e', NULL, 'e', 1009, NULL, 1, NULL, NULL),
(11, 1010, 6, 3, '2023-08-21', '2023-08-24', 'ew(1)', NULL, NULL, NULL, NULL, 1010, NULL, 1, NULL, NULL),
(12, 14, 1, 0, '2023-07-05', '2023-07-05', 'ECC 1-3-4(1)', NULL, NULL, NULL, NULL, 14, NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `framework_control_test_comments`
--

CREATE TABLE `framework_control_test_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `test_audit_id` bigint(20) UNSIGNED NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `user` int(11) NOT NULL,
  `comment` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `framework_control_test_comments`
--

INSERT INTO `framework_control_test_comments` (`id`, `test_audit_id`, `date`, `user`, `comment`) VALUES
(1, 5, '2023-08-07 11:29:56', 1, 'for test');

-- --------------------------------------------------------

--
-- Table structure for table `framework_control_test_results`
--

CREATE TABLE `framework_control_test_results` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `test_audit_id` bigint(20) UNSIGNED NOT NULL,
  `test_result` bigint(20) UNSIGNED DEFAULT NULL,
  `summary` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `test_date` date NOT NULL,
  `submitted_by` int(11) NOT NULL,
  `submission_date` datetime NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `framework_control_test_results`
--

INSERT INTO `framework_control_test_results` (`id`, `test_audit_id`, `test_result`, `summary`, `test_date`, `submitted_by`, `submission_date`, `last_updated`) VALUES
(1, 1, NULL, '', '0000-00-00', 0, '0000-00-00 00:00:00', '2023-07-05 10:52:06'),
(2, 2, NULL, '', '0000-00-00', 0, '0000-00-00 00:00:00', '2023-08-07 08:21:24'),
(3, 3, NULL, '', '0000-00-00', 0, '0000-00-00 00:00:00', '2023-08-07 08:21:24'),
(4, 4, NULL, '', '0000-00-00', 0, '0000-00-00 00:00:00', '2023-08-07 08:21:24'),
(5, 5, 4, 'test', '2023-08-08', 0, '2023-08-07 00:00:00', '2023-08-07 08:33:28'),
(6, 6, NULL, '', '0000-00-00', 0, '0000-00-00 00:00:00', '2023-08-20 15:30:11'),
(7, 7, NULL, '', '0000-00-00', 0, '0000-00-00 00:00:00', '2023-08-20 15:40:00'),
(8, 8, NULL, '', '0000-00-00', 0, '0000-00-00 00:00:00', '2023-08-20 15:47:40'),
(9, 9, NULL, '', '0000-00-00', 0, '0000-00-00 00:00:00', '2023-08-20 15:48:16'),
(10, 10, NULL, '', '0000-00-00', 0, '0000-00-00 00:00:00', '2023-08-20 16:02:55'),
(11, 11, 3, 'صصضث', '2023-08-21', 0, '2023-08-20 00:00:00', '2023-08-20 17:06:34'),
(12, 12, NULL, '', '0000-00-00', 0, '0000-00-00 00:00:00', '2023-08-20 17:10:26');

-- --------------------------------------------------------

--
-- Table structure for table `framework_control_test_results_to_risks`
--

CREATE TABLE `framework_control_test_results_to_risks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `test_results_id` bigint(20) UNSIGNED DEFAULT NULL,
  `risk_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `framework_control_test_results_to_risks`
--

INSERT INTO `framework_control_test_results_to_risks` (`id`, `test_results_id`, `risk_id`) VALUES
(2, 5, 26),
(3, 10, 30);

-- --------------------------------------------------------

--
-- Table structure for table `framework_control_to_frameworks`
--

CREATE TABLE `framework_control_to_frameworks` (
  `control_id` bigint(20) UNSIGNED NOT NULL,
  `framework_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `framework_control_type_mappings`
--

CREATE TABLE `framework_control_type_mappings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `control_id` bigint(20) UNSIGNED NOT NULL,
  `control_type_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `framework_families`
--

CREATE TABLE `framework_families` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `framework_id` bigint(20) UNSIGNED NOT NULL,
  `family_id` bigint(20) UNSIGNED NOT NULL,
  `parent_family_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `framework_families`
--

INSERT INTO `framework_families` (`id`, `framework_id`, `family_id`, `parent_family_id`) VALUES
(1, 1, 1, NULL),
(2, 1, 2, NULL),
(3, 1, 3, NULL),
(4, 1, 4, NULL),
(5, 1, 5, NULL),
(6, 1, 24, 1),
(7, 1, 25, 1),
(8, 1, 26, 1),
(9, 1, 27, 1),
(10, 1, 28, 1),
(11, 1, 29, 1),
(12, 1, 30, 1),
(13, 1, 31, 1),
(14, 1, 32, 1),
(15, 1, 33, 1),
(16, 1, 34, 2),
(17, 1, 35, 2),
(18, 1, 36, 2),
(19, 1, 37, 2),
(20, 1, 38, 2),
(21, 1, 39, 2),
(22, 1, 40, 2),
(23, 1, 41, 2),
(24, 1, 42, 2),
(25, 1, 43, 2),
(26, 1, 44, 2),
(27, 1, 45, 2),
(28, 1, 46, 2),
(29, 1, 47, 2),
(30, 1, 48, 2),
(31, 1, 49, 3),
(32, 1, 50, 4),
(33, 1, 51, 4),
(34, 1, 52, 5),
(35, 2, 1, NULL),
(36, 2, 2, NULL),
(37, 2, 4, NULL),
(38, 2, 26, 1),
(39, 2, 28, 1),
(40, 2, 32, 1),
(41, 2, 33, 1),
(42, 2, 34, 2),
(43, 2, 35, 2),
(44, 2, 36, 2),
(45, 2, 39, 2),
(46, 2, 40, 2),
(47, 2, 45, 2),
(48, 2, 46, 2),
(49, 2, 50, 4),
(50, 3, 1, NULL),
(51, 3, 2, NULL),
(52, 3, 3, NULL),
(53, 3, 4, NULL),
(54, 3, 27, 1),
(55, 3, 28, 1),
(56, 3, 30, 1),
(57, 3, 32, 1),
(58, 3, 120, 1),
(59, 3, 34, 2),
(60, 3, 35, 2),
(61, 3, 36, 2),
(62, 3, 38, 2),
(63, 3, 39, 2),
(64, 3, 40, 2),
(65, 3, 41, 2),
(66, 3, 42, 2),
(67, 3, 43, 2),
(68, 3, 44, 2),
(69, 3, 45, 2),
(70, 3, 46, 2),
(71, 3, 47, 2),
(72, 3, 48, 2),
(73, 3, 121, 2),
(74, 3, 123, 2),
(75, 3, 124, 2),
(76, 3, 49, 3),
(77, 3, 50, 4),
(78, 4, 1, NULL),
(79, 4, 2, NULL),
(80, 4, 4, NULL),
(81, 4, 26, 1),
(82, 4, 28, 1),
(83, 4, 33, 1),
(84, 4, 34, 2),
(85, 4, 35, 2),
(86, 4, 36, 2),
(87, 4, 38, 2),
(88, 4, 39, 2),
(89, 4, 40, 2),
(90, 4, 41, 2),
(91, 4, 42, 2),
(92, 4, 43, 2),
(93, 4, 44, 2),
(94, 4, 45, 2),
(95, 4, 46, 2),
(96, 4, 51, 4),
(97, 5, 1, NULL),
(98, 5, 2, NULL),
(99, 5, 3, NULL),
(100, 5, 4, NULL),
(101, 5, 24, 1),
(102, 5, 28, 1),
(103, 5, 29, 1),
(104, 5, 31, 1),
(105, 5, 32, 1),
(106, 5, 34, 2),
(107, 5, 35, 2),
(108, 5, 36, 2),
(109, 5, 38, 2),
(110, 5, 39, 2),
(111, 5, 40, 2),
(112, 5, 41, 2),
(113, 5, 42, 2),
(114, 5, 43, 2),
(115, 5, 44, 2),
(116, 5, 45, 2),
(117, 5, 48, 2),
(118, 5, 122, 2),
(119, 5, 49, 3),
(120, 5, 50, 4),
(121, 5, 51, 4),
(122, 6, 1, NULL),
(123, 6, 2, NULL),
(124, 6, 3, NULL),
(125, 6, 4, NULL),
(126, 6, 26, 1),
(127, 6, 27, 1),
(128, 6, 28, 1),
(129, 6, 29, 1),
(130, 6, 31, 1),
(131, 6, 32, 1),
(132, 6, 33, 1),
(133, 6, 120, 1),
(134, 6, 34, 2),
(135, 6, 35, 2),
(136, 6, 38, 2),
(137, 6, 39, 2),
(138, 6, 40, 2),
(139, 6, 41, 2),
(140, 6, 42, 2),
(141, 6, 43, 2),
(142, 6, 44, 2),
(143, 6, 45, 2),
(144, 6, 46, 2),
(145, 6, 47, 2),
(146, 6, 125, 2),
(147, 6, 49, 3),
(148, 6, 50, 4),
(149, 7, 1, NULL),
(150, 7, 2, NULL),
(151, 7, 4, NULL),
(152, 7, 31, 1),
(153, 7, 32, 1),
(154, 7, 33, 1),
(155, 7, 35, 2),
(156, 7, 36, 2),
(157, 7, 39, 2),
(158, 7, 40, 2),
(159, 7, 41, 2),
(160, 7, 126, 2),
(161, 7, 127, 2),
(162, 7, 50, 4),
(163, 8, 6, NULL),
(164, 8, 7, NULL),
(165, 8, 8, NULL),
(166, 8, 9, NULL),
(167, 8, 53, 6),
(168, 8, 54, 6),
(169, 8, 55, 6),
(170, 8, 56, 6),
(171, 8, 57, 6),
(172, 8, 58, 6),
(173, 8, 59, 6),
(174, 8, 60, 7),
(175, 8, 61, 7),
(176, 8, 62, 7),
(177, 8, 63, 7),
(178, 8, 64, 7),
(179, 8, 65, 8),
(180, 8, 66, 8),
(181, 8, 67, 8),
(182, 8, 68, 8),
(183, 8, 69, 8),
(184, 8, 70, 8),
(185, 8, 71, 8),
(186, 8, 72, 8),
(187, 8, 73, 8),
(188, 8, 74, 8),
(189, 8, 75, 8),
(190, 8, 76, 8),
(191, 8, 77, 8),
(192, 8, 78, 8),
(193, 8, 79, 8),
(194, 8, 80, 8),
(195, 8, 81, 8),
(196, 8, 82, 9),
(197, 8, 83, 9),
(198, 8, 84, 9),
(199, 9, 10, NULL),
(200, 9, 11, NULL),
(201, 9, 12, NULL),
(202, 9, 13, NULL),
(203, 9, 14, NULL),
(204, 9, 15, NULL),
(205, 9, 16, NULL),
(206, 9, 17, NULL),
(207, 9, 18, NULL),
(208, 9, 19, NULL),
(209, 9, 20, NULL),
(210, 9, 21, NULL),
(211, 9, 22, NULL),
(212, 9, 23, NULL),
(213, 9, 85, 10),
(214, 9, 86, 11),
(215, 9, 87, 11),
(216, 9, 88, 12),
(217, 9, 89, 12),
(218, 9, 90, 12),
(219, 9, 91, 13),
(220, 9, 92, 13),
(221, 9, 93, 13),
(222, 9, 94, 14),
(223, 9, 95, 14),
(224, 9, 96, 14),
(225, 9, 97, 14),
(226, 9, 98, 15),
(227, 9, 99, 16),
(228, 9, 100, 16),
(229, 9, 101, 17),
(230, 9, 102, 17),
(231, 9, 103, 17),
(232, 9, 104, 17),
(233, 9, 105, 17),
(234, 9, 106, 17),
(235, 9, 107, 17),
(236, 9, 108, 18),
(237, 9, 109, 18),
(238, 9, 110, 19),
(239, 9, 111, 19),
(240, 9, 112, 19),
(241, 9, 113, 20),
(242, 9, 114, 20),
(243, 9, 115, 21),
(244, 9, 116, 22),
(245, 9, 117, 22),
(246, 9, 118, 23),
(247, 9, 119, 23),
(248, 10, 1, NULL),
(249, 10, 24, 1);

-- --------------------------------------------------------

--
-- Table structure for table `framework_icons`
--

CREATE TABLE `framework_icons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `impacts`
--

CREATE TABLE `impacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `impacts`
--

INSERT INTO `impacts` (`id`, `name`) VALUES
(1, 'Insignificant'),
(2, 'Minor'),
(3, 'Moderate'),
(4, 'Major'),
(5, 'Extreme/Catastrophic');

-- --------------------------------------------------------

--
-- Table structure for table `items_to_teams`
--

CREATE TABLE `items_to_teams` (
  `item_id` int(11) NOT NULL,
  `team_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `items_to_teams`
--

INSERT INTO `items_to_teams` (`item_id`, `team_id`, `type`) VALUES
(1, 6, 'test'),
(2, 6, 'test'),
(3, 4, 'test'),
(4, 7, 'test'),
(5, 4, 'test'),
(6, 8, 'test'),
(7, 2, 'test'),
(8, 4, 'test'),
(9, 3, 'test'),
(10, 4, 'test'),
(11, 7, 'test'),
(12, 8, 'test'),
(13, 9, 'test'),
(14, 9, 'test'),
(15, 10, 'test'),
(16, 8, 'test'),
(17, 10, 'test'),
(18, 4, 'test'),
(19, 5, 'test'),
(20, 4, 'test'),
(1010, 1, 'test');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `name`, `description`, `code`, `created_at`, `updated_at`) VALUES
(1, 'CEO', 'This job for CEO', '#00001', '2023-07-05 12:42:42', '2023-07-05 12:42:42'),
(2, 'Department manager', 'This job for department manager', '#00003', '2023-07-05 12:42:42', '2023-07-05 12:42:42'),
(3, 'Job1', 'Job description1', '#11111', '2023-07-05 12:42:42', '2023-07-05 12:42:42'),
(4, 'Job2', 'Job description2', '#22222', '2023-07-05 12:42:42', '2023-07-05 12:42:42'),
(5, 'Job3', 'Job description3', '#33333', '2023-07-05 12:42:42', '2023-07-05 12:42:42'),
(6, 'Job4', 'Job description4', '#44444', '2023-07-05 12:42:42', '2023-07-05 12:42:42'),
(7, 'Job5', 'Job description5', '#55555', '2023-07-05 12:42:42', '2023-07-05 12:42:42'),
(8, 'Job6', 'Job description6', '#66666', '2023-07-05 12:42:42', '2023-07-05 12:42:42'),
(9, 'Job7', 'Job description7', '#77777', '2023-07-05 12:42:42', '2023-07-05 12:42:42'),
(10, 'Job8', 'Job description8', '#88888', '2023-07-05 12:42:42', '2023-07-05 12:42:42'),
(11, 'Job9', 'Job description9', '#99999', '2023-07-05 12:42:42', '2023-07-05 12:42:42'),
(12, 'Job10', 'Job description10', '#101010101', '2023-07-05 12:42:42', '2023-07-05 12:42:42');

-- --------------------------------------------------------

--
-- Table structure for table `kpis`
--

CREATE TABLE `kpis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `value_type` enum('Time','Percentage','Number') COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `period_of_assessment` enum('3','6','9','12') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Period in months',
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kpis`
--

INSERT INTO `kpis` (`id`, `department_id`, `title`, `description`, `value_type`, `value`, `period_of_assessment`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'TIme of Res', 'TIme of Res', 'Time', '90', '3', 1, '2023-08-10 11:32:46', '2023-08-10 11:32:46');

-- --------------------------------------------------------

--
-- Table structure for table `kpi_assessments`
--

CREATE TABLE `kpi_assessments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kpi_id` bigint(20) UNSIGNED NOT NULL,
  `assessment_value` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `action_by` bigint(20) UNSIGNED DEFAULT NULL,
  `assessment_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kpi_assessments`
--

INSERT INTO `kpi_assessments` (`id`, `kpi_id`, `assessment_value`, `created_by`, `action_by`, `assessment_date`, `created_at`, `updated_at`) VALUES
(1, 1, '60', 1, 2, '2023-08-10 11:34:44', '2023-08-10 11:33:27', '2023-08-10 11:34:44');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `full` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `full`) VALUES
(1, 'en', 'English'),
(4, 'ar', 'Arabic');

-- --------------------------------------------------------

--
-- Table structure for table `likelihoods`
--

CREATE TABLE `likelihoods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `likelihoods`
--

INSERT INTO `likelihoods` (`id`, `name`) VALUES
(1, 'Remote'),
(2, 'Unlikely'),
(3, 'Credible'),
(4, 'Likely'),
(5, 'Almost Certain');

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `name`) VALUES
(1, 'Location 1'),
(2, 'Location 2'),
(3, 'Location 3'),
(4, 'Location 4'),
(5, 'Location 5'),
(6, 'Location 6'),
(7, 'Location 7'),
(8, 'Location 8'),
(9, 'Location 9'),
(10, 'Location 10'),
(11, 'Location 11'),
(12, 'Location 12'),
(13, 'Location 13'),
(14, 'Location 14'),
(15, 'Location 15'),
(16, 'Location 16'),
(17, 'Location 17'),
(18, 'Location 18'),
(19, 'Location 19'),
(20, 'Location 20');

-- --------------------------------------------------------

--
-- Table structure for table `mail_settings`
--

CREATE TABLE `mail_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `action_id` bigint(20) UNSIGNED NOT NULL,
  `subject` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mgmt_reviews`
--

CREATE TABLE `mgmt_reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `risk_id` bigint(20) UNSIGNED NOT NULL,
  `submission_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `review` bigint(20) UNSIGNED DEFAULT NULL,
  `reviewer` bigint(20) UNSIGNED DEFAULT NULL,
  `next_step_id` bigint(20) UNSIGNED DEFAULT NULL,
  `comments` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `next_review` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mgmt_reviews`
--

INSERT INTO `mgmt_reviews` (`id`, `risk_id`, `submission_date`, `review`, `reviewer`, `next_step_id`, `comments`, `next_review`) VALUES
(1, 1, '1981-08-27 10:24:54', 2, 1, 1, 'Deserunt aliquid fugiat et molestias eum quae error.', '1999-10-13'),
(2, 2, '2015-08-06 20:29:51', 1, 1, 3, 'Laboriosam fuga veniam est ut at.', '1999-08-12'),
(3, 3, '2009-11-25 23:19:03', 1, 1, 3, 'Vero ut placeat eum.', '1978-09-24'),
(4, 4, '2019-10-20 13:13:17', 1, 1, 1, 'Sit dolor voluptatem aut nemo quasi aliquid.', '1979-02-09'),
(5, 5, '1974-01-27 03:00:31', 1, 1, 1, 'Sint voluptatibus ut nihil sit aut provident.', '1996-05-05'),
(6, 6, '1976-08-15 19:18:31', 1, 1, 3, 'Debitis sed asperiores aspernatur accusamus.', '1986-08-10'),
(7, 7, '2006-08-30 15:15:10', 2, 1, 1, 'Sapiente et quod libero temporibus illo dolor.', '1995-11-26'),
(8, 8, '1978-07-08 23:21:05', 1, 1, 3, 'Rerum enim ea est maxime consequatur ipsam consequatur enim.', '2019-08-26'),
(9, 9, '2012-01-20 09:07:48', 2, 1, 3, 'Totam adipisci quasi quis et architecto animi sed numquam.', '1994-11-05'),
(10, 10, '1997-07-06 08:12:27', 1, 1, 1, 'Odit qui ea aut nesciunt quis.', '2019-09-21'),
(11, 11, '1976-02-18 13:45:39', 2, 1, 3, 'Eligendi molestiae magnam officia fugiat sed voluptatem.', '2011-06-18'),
(12, 12, '1980-11-15 20:30:41', 1, 1, 3, 'Blanditiis sunt autem odio architecto quia occaecati repellat.', '2013-03-19'),
(13, 13, '2004-08-14 00:45:38', 2, 1, 3, 'Rerum dolor saepe id est sit quos.', '2008-10-15'),
(14, 14, '1989-06-28 05:37:35', 1, 1, 1, 'Ullam consequatur corporis ut saepe quasi numquam a excepturi.', '2013-08-08'),
(15, 15, '1970-06-08 18:15:59', 2, 1, 3, 'Non dignissimos quas voluptatem molestias suscipit voluptates.', '1973-08-15'),
(16, 16, '1992-02-02 03:34:20', 2, 1, 3, 'Maxime est sapiente aut perferendis qui nulla maiores cumque.', '1998-09-18'),
(17, 17, '1984-04-05 17:20:31', 1, 1, 1, 'Eveniet non vitae placeat eius dignissimos delectus minima.', '2013-02-02'),
(18, 18, '1990-02-09 21:19:02', 1, 1, 3, 'Similique eum sunt maiores itaque dolor rerum ut.', '2010-08-30'),
(19, 19, '1995-02-11 08:42:19', 1, 1, 1, 'Et quis quasi ut consequuntur voluptatem itaque iure.', '1997-04-21'),
(20, 20, '1972-05-29 22:21:02', 2, 1, 1, 'Expedita possimus molestiae qui doloremque.', '2007-01-20'),
(21, 28, '2023-08-21 21:56:12', 1, 3, 3, 'شش', '2024-08-15'),
(22, 28, '2023-08-21 22:06:06', 2, 2, 1, 'ش', '2024-08-15');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2021_04_04_122425_create_notifications_table', 1),
(2, '2021_04_04_122525_create_user_notifications_table', 1),
(3, '2022_02_16_001499_create_permission_groups_table', 1),
(4, '2022_02_16_001500_create_subgroups_table', 1),
(5, '2022_02_16_001501_create_permissions_table', 1),
(6, '2022_02_16_001503_create_permission_to_permission_groups_table', 1),
(7, '2022_02_16_001504_create_permission_to_users_table', 1),
(8, '2022_02_16_001509_create_roles_table', 1),
(9, '2022_02_16_001510_create_role_responsibilities_table', 1),
(10, '2022_02_16_001601_create_department_colors_table', 1),
(11, '2022_02_16_001602_create_departments_table', 1),
(12, '2022_02_16_001603_create_jobs_table', 1),
(13, '2022_02_16_001700_create_users_table', 1),
(14, '2022_02_16_001702_add_manager_id_to_departments', 1),
(15, '2022_02_16_001703_add_user_id_to_permission_to_users', 1),
(16, '2022_02_16_001800_create_assessments_table', 1),
(17, '2022_02_16_001810_create_assessment_questions_table', 1),
(18, '2022_02_16_001811_create_contributing_risks_likelihood_table', 1),
(19, '2022_02_16_001812_create_scoring_methods_table', 1),
(20, '2022_02_16_001819_create_assessment_scorings_table', 1),
(21, '2022_02_16_001820_create_assessment_answers_table', 1),
(22, '2022_02_16_001830_create_asset_groups_table', 1),
(23, '2022_02_16_001840_create_assessment_answers_to_asset_groups_table', 1),
(24, '2022_02_16_001840_create_asset_values_table', 1),
(25, '2022_02_16_001840_create_locations_table', 1),
(26, '2022_02_16_001841_create_assets_table', 1),
(27, '2022_02_16_001850_create_assessment_answers_to_assets_table', 1),
(28, '2022_02_16_001851_create_contributing_risks_table', 1),
(29, '2022_02_16_001860_create_assessment_scoring_contributing_impacts_table', 1),
(30, '2022_02_16_091810_create_asset_asset_groups_table', 1),
(31, '2022_02_16_091810_create_assets_asset_groups_table', 1),
(32, '2022_02_16_091811_create_projects_table', 1),
(33, '2022_02_16_091812_create_close_reasons_table', 1),
(34, '2022_02_16_091813_create_sources_table', 1),
(35, '2022_02_16_091814_create_categories_table', 1),
(36, '2022_02_16_091815_create_mitigation_efforts_table', 1),
(37, '2022_02_16_091815_create_planning_strategies_table', 1),
(38, '2022_02_16_091816_create_mitigations_table', 1),
(39, '2022_02_16_091820_create_audit_logs_table', 1),
(40, '2022_02_16_091830_create_backups_table', 1),
(41, '2022_02_16_091880_create_compliance_files_table', 1),
(42, '2022_02_16_091890_create_contributing_risks_impact_table', 1),
(43, '2022_02_16_091905_create_control_classes_table', 1),
(44, '2022_02_15_091906_create_control_maturities_table', 1),
(45, '2022_02_16_091907_create_control_phases_table', 1),
(46, '2022_02_16_091908_create_control_priorities_table', 1),
(47, '2022_02_15_091909_create_impacts_table', 1),
(48, '2022_02_15_091909_create_likelihoods_table', 1),
(49, '2022_02_16_091910_create_custom_risk_model_values_table', 1),
(50, '2022_02_16_091911_create_cvss_scorings_table', 1),
(51, '2022_02_16_091912_create_data_classifications_table', 1),
(52, '2022_02_16_091913_create_date_formats_table', 1),
(53, '2022_02_16_091914_create_document_exceptions_table', 1),
(54, '2022_02_16_091915_create_document_exceptions_statuses_table', 1),
(55, '2022_02_16_091916_create_document_statuses_table', 1),
(56, '2022_02_16_091916_create_document_types_table', 1),
(57, '2022_02_16_091918_create_dynamic_saved_selections_table', 1),
(58, '2022_02_16_091919_create_failed_login_attempts_table', 1),
(59, '2022_02_16_091920_create_families_table', 1),
(60, '2022_02_16_091921_create_fields_table', 1),
(61, '2022_02_16_091922_create_file_type_extensions_table', 1),
(62, '2022_02_16_091923_create_control_desired_maturities_table', 1),
(63, '2022_02_16_091923_create_control_owners_table', 1),
(64, '2022_02_16_091923_create_control_types_table', 1),
(65, '2022_02_16_091923_create_file_types_table', 1),
(66, '2022_02_16_091924_create_framework_controls_table', 1),
(67, '2022_02_16_091924_create_frameworks_table', 1),
(68, '2022_02_16_091925_create_framework_control_mappings_table', 1),
(69, '2022_02_16_091925_create_framework_control_tests_table', 1),
(70, '2022_02_16_091925_create_risks_table', 1),
(71, '2022_02_16_091926_add_risk_id_to_mitigations_table', 1),
(72, '2022_02_16_091926_create_closures_table', 1),
(73, '2022_02_16_091926_create_comments_table', 1),
(74, '2022_02_16_091926_create_files_table', 1),
(75, '2022_02_16_091926_create_framework_control_test_audits_table', 1),
(76, '2022_02_16_091926_create_privacies_table', 1),
(77, '2022_02_16_091927_create_documents_table', 1),
(78, '2022_02_16_091927_create_framework_control_test_comments_table', 1),
(79, '2022_02_16_091927_create_test_results_table', 1),
(80, '2022_02_16_091928_create_framework_control_test_results_table', 1),
(81, '2022_02_16_091929_create_framework_control_test_results_to_risks_table', 1),
(82, '2022_02_16_091931_create_framework_control_to_frameworks_table', 1),
(83, '2022_02_16_091932_create_framework_control_type_mappings_table', 1),
(84, '2022_02_16_091935_create_teams_table', 1),
(85, '2022_02_16_091936_create_items_to_teams_table', 1),
(86, '2022_02_16_091937_create_languages_table', 1),
(87, '2022_02_16_091939_create_next_steps_table', 1),
(88, '2022_02_16_091939_create_reviews_table', 1),
(89, '2022_02_16_091940_create_mgmt_reviews_table', 1),
(90, '2022_02_16_091941_create_mitigation_accept_users_table', 1),
(91, '2022_02_16_091943_create_mitigation_to_controls_table', 1),
(92, '2022_02_16_091944_create_mitigation_to_teams_table', 1),
(93, '2022_02_16_091947_create_password_resets_table', 1),
(94, '2022_02_16_091948_create_pending_risks_table', 1),
(95, '2022_02_16_091955_create_questionnaire_pending_risks_table', 1),
(96, '2022_02_16_091956_create_regulations_table', 1),
(97, '2022_02_16_091957_create_residual_risk_scoring_histories_table', 1),
(98, '2022_02_16_091959_create_review_levels_table', 1),
(99, '2022_02_16_092000_create_risk_functions_table', 1),
(100, '2022_02_16_092001_create_risk_groupings_table', 1),
(101, '2022_02_16_092002_create_risk_catalogs_table', 1),
(102, '2022_02_16_092003_create_risk_levels_table', 1),
(103, '2022_02_16_092004_create_risk_models_table', 1),
(104, '2022_02_16_092005_create_risk_scorings_table', 1),
(105, '2022_02_16_092006_create_risk_scoring_contributing_impacts_table', 1),
(106, '2022_02_16_092007_create_risk_scoring_histories_table', 1),
(107, '2022_02_16_092008_create_risk_to_additional_stakeholders_table', 1),
(108, '2022_02_16_092009_create_risk_to_locations_table', 1),
(109, '2022_02_16_092010_create_risk_to_teams_table', 1),
(110, '2022_02_16_092010_create_technologies_table', 1),
(111, '2022_02_16_092011_create_risk_to_technologies_table', 1),
(112, '2022_02_16_092013_create_risks_to_asset_groups_table', 1),
(113, '2022_02_16_092014_create_risks_to_assets_table', 1),
(114, '2022_02_16_092018_create_sessions_table', 1),
(115, '2022_02_16_092019_create_settings_table', 1),
(116, '2022_02_16_092021_create_statuses_table', 1),
(117, '2022_02_16_092022_create_tags_table', 1),
(118, '2022_02_16_092023_create_taggables_table', 1),
(119, '2022_02_16_092027_create_test_statuses_table', 1),
(120, '2022_02_16_092027_create_threat_groupings_table', 1),
(121, '2022_02_16_092028_create_threat_catalogs_table', 1),
(122, '2022_02_16_092031_create_user_pass_histories_table', 1),
(123, '2022_02_16_092032_create_user_pass_reuse_histories_table', 1),
(124, '2022_02_16_092033_create_user_to_teams_table', 1),
(125, '2022_02_16_092034_create_validation_files_table', 1),
(126, '2022_03_13_065913_create_tests_table', 1),
(127, '2022_05_17_122632_create_framework_icons_table', 1),
(128, '2022_06_16_123929_create_tasks_table', 1),
(129, '2022_06_16_132507_create_file_tasks_table', 1),
(130, '2022_07_26_145432_create_document_notes_table', 1),
(131, '2022_07_26_145432_create_task_notes_table', 1),
(132, '2022_07_28_105734_create_document_note_files_table', 1),
(133, '2022_07_28_105734_create_task_note_files_table', 1),
(134, '2022_09_22_111859_create_vulnerabilities_table', 1),
(135, '2022_09_22_113422_create_asset_vulnerabilities_table', 1),
(136, '2022_09_22_113907_create_team_vulnerabilities_table', 1),
(137, '2022_09_22_163247_create_service_descriptions_table', 1),
(138, '2022_09_25_134316_create_change_requests_table', 1),
(139, '2022_09_27_113124_create_kpis_table', 1),
(140, '2022_09_28_092653_create_kpi_assessments_table', 1),
(141, '2022_10_10_135818_create_security_awarenesses_table', 1),
(142, '2022_10_10_135953_create_security_awareness_exams_table', 1),
(143, '2022_10_10_141920_create_security_awareness_note_files_table', 1),
(144, '2022_10_10_141931_create_security_awareness_notes_table', 1),
(145, '2022_10_12_124510_create_security_awareness_exam_questions_table', 1),
(146, '2022_10_12_143854_create_security_awareness_exam_answers_table', 1),
(147, '2022_11_07_085943_create_framework_families_table', 1),
(148, '2022_12_01_072257_create_control_audit_policies_table', 1),
(149, '2022_02_15_114216_create_questions_table', 2),
(150, '2023_05_21_081556_control_questions_table', 2),
(151, '2023_05_23_113959_create_answer_sub_questions_table', 2),
(152, '2023_05_29_151235_create_control_objectives_table', 2),
(153, '2023_06_07_122411_create_questionnaires_table', 2),
(154, '2023_06_14_115110_create_actions_table', 2),
(155, '2023_06_14_115507_create_system_notifications_settings_table', 2),
(156, '2023_06_14_115528_create_mail_settings_table', 2),
(157, '2023_06_14_115540_create_sms_settings_table', 2),
(158, '2023_06_14_120948_create_notifiables_table', 2),
(159, '2023_07_02_152100_create_contact_questionnaires_table', 2),
(160, '2023_07_02_152119_create_questionnaire_questions_table', 2),
(161, '2023_07_04_164210_create_notifications_roles_table', 2),
(162, '2023_07_10_161349_add_phone_number_to_users_table', 2),
(163, '2023_07_31_130446_create_contact_questionnaire_answers_table', 2),
(164, '2023_07_31_143822_create_contact_questionnaire_answer_results_table', 2),
(165, '2023_08_07_074507_create_questionnaire_risks_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `mitigations`
--

CREATE TABLE `mitigations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `submission_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_update` timestamp NULL DEFAULT NULL,
  `planning_strategy` bigint(20) UNSIGNED DEFAULT NULL,
  `mitigation_effort` bigint(20) UNSIGNED DEFAULT NULL,
  `mitigation_cost` int(11) DEFAULT NULL,
  `mitigation_owner` bigint(20) UNSIGNED DEFAULT NULL,
  `current_solution` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `security_requirements` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `security_recommendations` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `submitted_by` int(11) NOT NULL DEFAULT 1,
  `planning_date` date NOT NULL,
  `mitigation_percent` int(11) NOT NULL,
  `risk_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mitigations`
--

INSERT INTO `mitigations` (`id`, `submission_date`, `last_update`, `planning_strategy`, `mitigation_effort`, `mitigation_cost`, `mitigation_owner`, `current_solution`, `security_requirements`, `security_recommendations`, `submitted_by`, `planning_date`, `mitigation_percent`, `risk_id`) VALUES
(1, '2004-02-29 20:03:16', '1989-10-10 08:15:51', 2, 3, 49, 1, 'consequatur', 'atque', 'molestiae', 1, '1982-05-29', 1, 9),
(2, '1987-01-15 20:52:02', '1971-04-21 20:50:02', 1, 5, 73, 1, 'minima', 'soluta', 'magni', 1, '1981-06-30', 86, 11),
(3, '1976-11-29 16:50:10', '1993-12-19 20:45:52', 1, 5, 11, 1, 'aliquid', 'quasi', 'vero', 1, '1995-03-27', 1, 17),
(4, '1990-08-31 08:31:57', '1979-08-11 16:05:36', 3, 3, 2, 1, 'quas', 'explicabo', 'inventore', 1, '1981-05-02', 5, 2),
(5, '2007-08-11 12:17:11', '1973-03-11 08:55:50', 5, 2, 79, 1, 'saepe', 'excepturi', 'non', 1, '1987-01-12', 97, 2),
(6, '1999-03-23 14:48:19', '1980-01-21 18:20:55', 2, 3, 94, 1, 'eos', 'voluptas', 'non', 1, '2022-11-14', 64, 2),
(7, '1977-01-26 14:39:30', '2016-02-24 16:51:10', 5, 4, 86, 1, 'pariatur', 'voluptatem', 'dolor', 1, '2007-04-15', 91, 10),
(8, '2013-06-15 21:49:38', '1998-04-06 15:11:18', 2, 5, 88, 1, 'tempore', 'voluptatem', 'sequi', 1, '2013-12-25', 71, 1),
(9, '1981-05-04 09:49:08', '2012-12-06 14:36:24', 1, 5, 20, 1, 'atque', 'possimus', 'a', 1, '2012-04-19', 35, 10),
(10, '2018-11-21 17:32:55', '2005-03-31 13:42:21', 3, 5, 98, 1, 'blanditiis', 'recusandae', 'eveniet', 1, '1991-08-12', 95, 9),
(11, '2013-08-10 09:28:08', '2019-01-31 08:09:41', 4, 4, 13, 1, 'hic', 'officiis', 'nesciunt', 1, '2009-11-24', 4, 20),
(12, '2021-04-10 13:29:35', '1993-05-18 01:45:56', 1, 3, 52, 1, 'voluptas', 'dignissimos', 'aperiam', 1, '1972-05-22', 6, 9),
(13, '1998-10-17 16:08:48', '2008-05-18 14:41:07', 2, 4, 7, 1, 'velit', 'aut', 'ut', 1, '1973-07-19', 36, 12),
(14, '1981-09-25 01:02:04', '2019-05-16 00:18:15', 2, 4, 17, 1, 'dolorem', 'voluptas', 'corporis', 1, '1995-04-02', 88, 8),
(15, '1974-03-21 08:17:21', '1999-08-13 13:53:01', 3, 5, 92, 1, 'vitae', 'ea', 'pariatur', 1, '1983-08-17', 26, 14),
(16, '1972-01-08 02:46:04', '2019-09-19 08:02:06', 1, 2, 3, 1, 'sit', 'totam', 'est', 1, '2020-02-17', 75, 16),
(17, '2005-04-15 07:39:56', '2010-05-09 21:49:02', 5, 4, 55, 1, 'ex', 'expedita', 'enim', 1, '2006-06-29', 55, 16),
(18, '2003-01-26 21:47:30', '1975-12-19 05:20:20', 5, 3, 32, 1, 'assumenda', 'in', 'cum', 1, '1976-12-05', 14, 6),
(19, '2019-06-15 15:42:31', '1994-06-28 12:44:10', 3, 5, 6, 1, 'impedit', 'ipsum', 'minima', 1, '1994-11-05', 80, 1),
(20, '1981-05-09 15:58:36', '2000-01-01 20:38:42', 1, 4, 51, 1, 'voluptatum', 'rerum', 'et', 1, '2004-09-04', 10, 1),
(21, '2023-07-05 14:00:44', '0000-00-00 00:00:00', 5, 5, 10, NULL, 'tempore', 'voluptatem', 'sequi', 1, '2013-12-25', 71, 1),
(22, '2023-08-21 18:40:22', '2023-08-21 18:40:36', 2, NULL, 4, NULL, 's', 's', 'a', 1, '2023-08-21', 0, 27),
(23, '2023-08-21 22:16:01', '0000-00-00 00:00:00', 3, NULL, 4, NULL, 'ص', 'ص', 'ص', 1, '2023-08-21', 22, 28);

-- --------------------------------------------------------

--
-- Table structure for table `mitigation_accept_users`
--

CREATE TABLE `mitigation_accept_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `risk_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mitigation_accept_users`
--

INSERT INTO `mitigation_accept_users` (`id`, `risk_id`, `user_id`, `created_at`) VALUES
(1, 27, 1, '2023-08-21 18:42:13');

-- --------------------------------------------------------

--
-- Table structure for table `mitigation_efforts`
--

CREATE TABLE `mitigation_efforts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mitigation_efforts`
--

INSERT INTO `mitigation_efforts` (`id`, `name`) VALUES
(1, 'Insignificante'),
(2, 'Menor'),
(3, 'Considerable'),
(4, 'Significante'),
(5, 'Excepcional');

-- --------------------------------------------------------

--
-- Table structure for table `mitigation_to_controls`
--

CREATE TABLE `mitigation_to_controls` (
  `mitigation_id` bigint(20) UNSIGNED NOT NULL,
  `control_id` bigint(20) UNSIGNED NOT NULL,
  `validation_details` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `validation_owner` int(11) NOT NULL,
  `validation_mitigation_percent` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mitigation_to_controls`
--

INSERT INTO `mitigation_to_controls` (`mitigation_id`, `control_id`, `validation_details`, `validation_owner`, `validation_mitigation_percent`) VALUES
(21, 5, 'Validation details text added automatically', 1, 25),
(22, 10, 'Validation details text added automatically', 1, 25),
(23, 9, 'Validation details text added automatically', 1, 25);

-- --------------------------------------------------------

--
-- Table structure for table `mitigation_to_teams`
--

CREATE TABLE `mitigation_to_teams` (
  `mitigation_id` bigint(20) UNSIGNED NOT NULL,
  `team_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `next_steps`
--

CREATE TABLE `next_steps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `next_steps`
--

INSERT INTO `next_steps` (`id`, `name`) VALUES
(1, 'Accept Until Next Review'),
(3, 'Submit as a Production Issue');

-- --------------------------------------------------------

--
-- Table structure for table `notifiables`
--

CREATE TABLE `notifiables` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `notifiable_id` int(11) NOT NULL,
  `notifiable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifiables`
--

INSERT INTO `notifiables` (`id`, `user_id`, `notifiable_id`, `notifiable_type`) VALUES
(1, 1, 1, 'App\\Models\\SystemNotificationSetting'),
(2, 2, 1, 'App\\Models\\SystemNotificationSetting'),
(3, 3, 2, 'App\\Models\\SystemNotificationSetting');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `message` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `notification_type` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `message`, `notification_type`, `meta`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Successfully created new Audit ECC 1-1-1(1)', 'create', 'a:0:{}', 5, '2023-07-05 13:52:06', NULL),
(2, 'Next Date for Audit is Today ECC 1-1-1(1)', 'alarm', 'a:0:{}', 2023, '2023-07-05 13:52:06', NULL),
(3, 'Employee Admin create a new security awareness (Phishing mail) and you are the owner', 'notification', 'a:1:{s:4:\"link\";s:67:\"https://www.advancedcontrols.sa/grc/public/admin/security-awareness\";}', 5, '2023-07-05 14:14:45', NULL),
(4, 'Employee Admin create a new security awareness (Phishing mail)', 'notification', 'a:1:{s:4:\"link\";s:67:\"https://www.advancedcontrols.sa/grc/public/admin/security-awareness\";}', 5, '2023-07-05 14:14:45', NULL),
(5, 'Employee Admin create a new security awareness (test)', 'notification', 'a:1:{s:4:\"link\";s:67:\"https://www.advancedcontrols.sa/grc/public/admin/security-awareness\";}', 5, '2023-07-05 14:17:44', NULL),
(6, 'Employee Admin update status of security awareness (test) from Draft to Approved', 'notification', 'a:1:{s:4:\"link\";s:67:\"https://www.advancedcontrols.sa/grc/public/admin/security-awareness\";}', 5, '2023-07-05 14:19:00', NULL),
(7, 'Successfully created new Asset', 'notification', 'a:1:{s:4:\"link\";s:65:\"https://www.advancedcontrols.sa/grc/public/admin/asset-management\";}', 13, '2023-07-13 13:49:11', NULL),
(8, 'Employee Admin create a new security awareness (mail ph)', 'notification', 'a:1:{s:4:\"link\";s:67:\"https://www.advancedcontrols.sa/grc/public/admin/security-awareness\";}', 13, '2023-07-13 14:15:34', NULL),
(9, 'Employee Admin create a new security awareness (thearts)', 'notification', 'a:1:{s:4:\"link\";s:67:\"https://www.advancedcontrols.sa/grc/public/admin/security-awareness\";}', 17, '2023-07-17 12:38:11', NULL),
(10, 'Employee Admin update status of security awareness (thearts) from Draft to Approved', 'notification', 'a:1:{s:4:\"link\";s:67:\"https://www.advancedcontrols.sa/grc/public/admin/security-awareness\";}', 17, '2023-07-17 12:41:01', NULL),
(11, 'Successfully created new Audit ECC 1-3-1(1)', 'create', 'a:0:{}', 7, '2023-08-07 11:21:24', NULL),
(12, 'Next Date for Audit is Today ECC 1-3-1(1)', 'alarm', 'a:0:{}', 2023, '2023-08-07 11:21:24', NULL),
(13, 'Successfully created new Audit ECC 1-2-3(1)', 'create', 'a:0:{}', 7, '2023-08-07 11:21:24', NULL),
(14, 'Next Date for Audit is Today ECC 1-2-3(1)', 'alarm', 'a:0:{}', 2023, '2023-08-07 11:21:24', NULL),
(15, 'Successfully created new Audit ECC 1-1-3(1)', 'create', 'a:0:{}', 7, '2023-08-07 11:21:24', NULL),
(16, 'Next Date for Audit is Today ECC 1-1-3(1)', 'alarm', 'a:0:{}', 2023, '2023-08-07 11:21:24', NULL),
(17, 'Successfully created new Audit ECC 1-1-1(2)', 'create', 'a:0:{}', 7, '2023-08-07 11:21:24', NULL),
(18, 'Next Date for Audit is Today ECC 1-1-1(2)', 'alarm', 'a:0:{}', 2023, '2023-08-07 11:21:24', NULL),
(19, 'Employee مدير الرئيس التنفيذى create a new security awareness (test2) and you are the owner', 'notification', 'a:1:{s:4:\"link\";s:67:\"https://www.advancedcontrols.sa/grc/public/admin/security-awareness\";}', 8, '2023-08-08 16:31:18', NULL),
(20, 'Employee مدير الرئيس التنفيذى create a new security awareness (test2) and you are the reviewer', 'notification', 'a:1:{s:4:\"link\";s:67:\"https://www.advancedcontrols.sa/grc/public/admin/security-awareness\";}', 8, '2023-08-08 16:31:18', NULL),
(21, 'Employee مدير الرئيس التنفيذى create a new security awareness (test2)', 'notification', 'a:1:{s:4:\"link\";s:67:\"https://www.advancedcontrols.sa/grc/public/admin/security-awareness\";}', 8, '2023-08-08 16:31:18', NULL),
(22, 'Employee Admin assign security awareness reviewing (test2) to you', 'notification', 'a:1:{s:4:\"link\";s:67:\"https://www.advancedcontrols.sa/grc/public/admin/security-awareness\";}', 8, '2023-08-08 16:36:15', NULL),
(23, 'Employee Admin update status of security awareness (test2) from InReview to Approved', 'notification', 'a:1:{s:4:\"link\";s:67:\"https://www.advancedcontrols.sa/grc/public/admin/security-awareness\";}', 8, '2023-08-08 16:36:15', NULL),
(24, 'Employee مدير الرئيس التنفيذى create a new security awareness (dddd) and you are the owner', 'notification', 'a:1:{s:4:\"link\";s:67:\"https://www.advancedcontrols.sa/grc/public/admin/security-awareness\";}', 9, '2023-08-09 10:19:15', NULL),
(25, 'Employee مدير الرئيس التنفيذى create a new security awareness (dddd)', 'notification', 'a:1:{s:4:\"link\";s:67:\"https://www.advancedcontrols.sa/grc/public/admin/security-awareness\";}', 9, '2023-08-09 10:19:15', NULL),
(26, 'Employee مدير الرئيس التنفيذى create a new security awareness (test13) and you are the owner', 'notification', 'a:1:{s:4:\"link\";s:67:\"https://www.advancedcontrols.sa/grc/public/admin/security-awareness\";}', 9, '2023-08-09 10:57:26', NULL),
(27, 'Employee مدير الرئيس التنفيذى create a new security awareness (test13)', 'notification', 'a:1:{s:4:\"link\";s:67:\"https://www.advancedcontrols.sa/grc/public/admin/security-awareness\";}', 9, '2023-08-09 10:57:26', NULL),
(28, 'Admin Make change request (ERP change Req) you have to approve or reject it as you are change requests responsible department manager', 'notification', 'a:1:{s:4:\"link\";s:63:\"https://www.advancedcontrols.sa/grc/public/admin/change-request\";}', 10, '2023-08-10 11:26:36', NULL),
(29, 'مدير الرئيس التنفيذى (Responsible Department Review) approved on your change request ()', 'notification', 'a:1:{s:4:\"link\";s:63:\"https://www.advancedcontrols.sa/grc/public/admin/change-request\";}', 10, '2023-08-10 11:30:18', NULL),
(30, 'Employee Admin create and assign task (to do somthing) to your team (Team 17)', 'notification', 'a:1:{s:4:\"link\";s:68:\"https://www.advancedcontrols.sa/grc/public/admin/task/assigned-to-me\";}', 10, '2023-08-10 11:37:34', NULL),
(31, 'Successfully created new Department قسم الانتاج', 'create', 'a:1:{s:4:\"link\";s:69:\"https://www.advancedcontrols.sa/grc/public/admin/hierarchy/department\";}', 20, '2023-08-20 13:04:08', NULL),
(32, 'Employee مدير الرئيس التنفيذى create and assign task (Task1) to you', 'notification', 'a:1:{s:4:\"link\";s:68:\"https://www.advancedcontrols.sa/grc/public/admin/task/assigned-to-me\";}', 20, '2023-08-20 17:33:17', NULL),
(33, 'hi Et molestiae facilis', 'notification', 'a:1:{s:4:\"link\";s:73:\"https://www.advancedcontrols.sa/grc/public/admin/vulnerability-management\";}', NULL, '2023-08-20 17:36:45', NULL),
(34, 'Employee مدير الرئيس التنفيذى create a new security awareness (test7) and you are the owner', 'notification', 'a:1:{s:4:\"link\";s:67:\"https://www.advancedcontrols.sa/grc/public/admin/security-awareness\";}', 20, '2023-08-20 17:39:56', NULL),
(35, 'Employee مدير الرئيس التنفيذى create a new security awareness (test7) and you are the reviewer', 'notification', 'a:1:{s:4:\"link\";s:67:\"https://www.advancedcontrols.sa/grc/public/admin/security-awareness\";}', 20, '2023-08-20 17:39:56', NULL),
(36, 'Employee مدير الرئيس التنفيذى create a new security awareness (test7)', 'notification', 'a:1:{s:4:\"link\";s:67:\"https://www.advancedcontrols.sa/grc/public/admin/security-awareness\";}', 20, '2023-08-20 17:39:56', NULL),
(37, 'Employee مدير اﻹدارة العامة ﻷمن المعلومات allow access security awareness (test7) to you', 'notification', 'a:1:{s:4:\"link\";s:67:\"https://www.advancedcontrols.sa/grc/public/admin/security-awareness\";}', 20, '2023-08-20 17:43:03', NULL),
(38, 'Employee مدير اﻹدارة العامة ﻷمن المعلومات create a new security awareness (test89) and you are the owner', 'notification', 'a:1:{s:4:\"link\";s:67:\"https://www.advancedcontrols.sa/grc/public/admin/security-awareness\";}', 20, '2023-08-20 17:44:48', NULL),
(39, 'Employee مدير اﻹدارة العامة ﻷمن المعلومات create a new security awareness (test89)', 'notification', 'a:1:{s:4:\"link\";s:67:\"https://www.advancedcontrols.sa/grc/public/admin/security-awareness\";}', 20, '2023-08-20 17:44:48', NULL),
(40, 'Employee مدير اﻹدارة العامة ﻷمن المعلومات create a new security awareness (test8) and you are the owner', 'notification', 'a:1:{s:4:\"link\";s:67:\"https://www.advancedcontrols.sa/grc/public/admin/security-awareness\";}', 20, '2023-08-20 17:46:10', NULL),
(41, 'Employee مدير اﻹدارة العامة ﻷمن المعلومات create a new security awareness (test8)', 'notification', 'a:1:{s:4:\"link\";s:67:\"https://www.advancedcontrols.sa/grc/public/admin/security-awareness\";}', 20, '2023-08-20 17:46:11', NULL),
(42, 'Successfully created new Audit tes_4(1)', 'create', 'a:0:{}', 20, '2023-08-20 18:30:11', NULL),
(43, 'Next Date for Audit is Today tes_4(1)', 'alarm', 'a:0:{}', 2023, '2023-08-20 18:30:11', NULL),
(44, 'Successfully created new Audit tes_4(2)', 'create', 'a:0:{}', 20, '2023-08-20 18:40:00', NULL),
(45, 'Next Date for Audit is Today tes_4(2)', 'alarm', 'a:0:{}', 2023, '2023-08-20 18:40:00', NULL),
(46, 'Successfully created new Audit tt_7(1)', 'create', 'a:0:{}', 20, '2023-08-20 18:47:40', NULL),
(47, 'Next Date for Audit is Today tt_7(1)', 'alarm', 'a:0:{}', 2023, '2023-08-20 18:47:40', NULL),
(48, 'Successfully created new Audit tt_7(2)', 'create', 'a:0:{}', 20, '2023-08-20 18:48:16', NULL),
(49, 'Next Date for Audit is Today tt_7(2)', 'alarm', 'a:0:{}', 2023, '2023-08-20 18:48:16', NULL),
(50, 'Successfully created new Audit tt_7(3)', 'create', 'a:0:{}', 20, '2023-08-20 19:02:55', NULL),
(51, 'Next Date for Audit is Today tt_7(3)', 'alarm', 'a:0:{}', 2023, '2023-08-20 19:02:55', NULL),
(52, 'Successfully created new Audit ew(1)', 'create', 'a:0:{}', 20, '2023-08-20 19:09:03', NULL),
(53, 'Next Date for Audit is Today ew(1)', 'alarm', 'a:0:{}', 2023, '2023-08-20 19:09:03', NULL),
(54, 'Successfully created new Audit ECC 1-3-4(1)', 'create', 'a:0:{}', 20, '2023-08-20 20:10:26', NULL),
(55, 'Next Date for Audit is Today ECC 1-3-4(1)', 'alarm', 'a:0:{}', 2023, '2023-08-20 20:10:26', NULL),
(56, 'Employee Admin create a new document (Doc_Test) and you are the owner', 'notification', 'a:1:{s:4:\"link\";s:68:\"https://www.advancedcontrols.sa/grc/public/admin/governance/category\";}', 21, '2023-08-21 15:28:45', NULL),
(57, 'Employee Admin create a new document (Doc_Test) and you are the reviewer', 'notification', 'a:1:{s:4:\"link\";s:68:\"https://www.advancedcontrols.sa/grc/public/admin/governance/category\";}', 21, '2023-08-21 15:28:45', NULL),
(58, 'Employee Admin create a new document (Doc_Test)', 'notification', 'a:1:{s:4:\"link\";s:68:\"https://www.advancedcontrols.sa/grc/public/admin/governance/category\";}', 21, '2023-08-21 15:28:45', NULL),
(59, 'Employee Admin create a new document (Doc_Test2) and you are the owner', 'notification', 'a:1:{s:4:\"link\";s:68:\"https://www.advancedcontrols.sa/grc/public/admin/governance/category\";}', 21, '2023-08-21 15:32:03', NULL),
(60, 'Employee Admin create a new document (Doc_Test2) and you are the reviewer', 'notification', 'a:1:{s:4:\"link\";s:68:\"https://www.advancedcontrols.sa/grc/public/admin/governance/category\";}', 21, '2023-08-21 15:32:03', NULL),
(61, 'Employee Admin create a new document (Doc_Test2)', 'notification', 'a:1:{s:4:\"link\";s:68:\"https://www.advancedcontrols.sa/grc/public/admin/governance/category\";}', 21, '2023-08-21 15:32:03', NULL),
(62, 'Employee Admin create a new document (Doc_Test3)', 'notification', 'a:1:{s:4:\"link\";s:68:\"https://www.advancedcontrols.sa/grc/public/admin/governance/category\";}', 21, '2023-08-21 15:41:02', NULL),
(63, 'Employee Admin create a new document (Doc_Test4)', 'notification', 'a:1:{s:4:\"link\";s:68:\"https://www.advancedcontrols.sa/grc/public/admin/governance/category\";}', 21, '2023-08-21 15:45:17', NULL),
(64, 'Employee Admin create a new document (Doc_Test4)', 'notification', 'a:1:{s:4:\"link\";s:68:\"https://www.advancedcontrols.sa/grc/public/admin/governance/category\";}', 21, '2023-08-21 15:46:03', NULL),
(65, 'Employee Admin create a new document (Doc_Test5) and you are the owner', 'notification', 'a:1:{s:4:\"link\";s:68:\"https://www.advancedcontrols.sa/grc/public/admin/governance/category\";}', 21, '2023-08-21 16:14:36', NULL),
(66, 'Employee Admin create a new document (Doc_Test5)', 'notification', 'a:1:{s:4:\"link\";s:68:\"https://www.advancedcontrols.sa/grc/public/admin/governance/category\";}', 21, '2023-08-21 16:14:36', NULL),
(67, 'Employee مدير اﻹدارة العامة ﻷمن المعلومات assign document reviewing (Doc_Test5) to you', 'notification', 'a:1:{s:4:\"link\";s:68:\"https://www.advancedcontrols.sa/grc/public/admin/governance/category\";}', 21, '2023-08-21 16:18:03', NULL),
(68, 'Employee مدير اﻹدارة العامة ﻷمن المعلومات update status of document (Doc_Test5) from Approved to InReview', 'notification', 'a:1:{s:4:\"link\";s:68:\"https://www.advancedcontrols.sa/grc/public/admin/governance/category\";}', 21, '2023-08-21 16:18:03', NULL),
(69, 'Employee مدير اﻹدارة العامة ﻷمن المعلومات create a new document (Doc_Test7) and you are the owner', 'notification', 'a:1:{s:4:\"link\";s:68:\"https://www.advancedcontrols.sa/grc/public/admin/governance/category\";}', 21, '2023-08-21 17:37:47', NULL),
(70, 'Employee مدير اﻹدارة العامة ﻷمن المعلومات create a new document (Doc_Test7) and you are the reviewer', 'notification', 'a:1:{s:4:\"link\";s:68:\"https://www.advancedcontrols.sa/grc/public/admin/governance/category\";}', 21, '2023-08-21 17:37:47', NULL),
(71, 'Employee مدير اﻹدارة العامة ﻷمن المعلومات create a new document (Doc_Test7)', 'notification', 'a:1:{s:4:\"link\";s:68:\"https://www.advancedcontrols.sa/grc/public/admin/governance/category\";}', 21, '2023-08-21 17:37:47', NULL),
(72, 'Employee مدير اﻹدارة العامة ﻷمن المعلومات update status of document (Doc_Test5) from InReview to Approved', 'notification', 'a:1:{s:4:\"link\";s:68:\"https://www.advancedcontrols.sa/grc/public/admin/governance/category\";}', 21, '2023-08-21 17:45:18', NULL),
(73, 'Employee Admin create a new document (Doc_Test100) and you are the owner', 'notification', 'a:1:{s:4:\"link\";s:68:\"https://www.advancedcontrols.sa/grc/public/admin/governance/category\";}', 21, '2023-08-21 17:57:11', NULL),
(74, 'Employee Admin create a new document (Doc_Test100)', 'notification', 'a:1:{s:4:\"link\";s:68:\"https://www.advancedcontrols.sa/grc/public/admin/governance/category\";}', 21, '2023-08-21 17:57:11', NULL),
(75, 'Employee مدير اﻹدارة العامة ﻷمن المعلومات assign document reviewing (Doc_Test100) to you', 'notification', 'a:1:{s:4:\"link\";s:68:\"https://www.advancedcontrols.sa/grc/public/admin/governance/category\";}', 21, '2023-08-21 18:04:11', NULL),
(76, 'Employee مدير اﻹدارة العامة ﻷمن المعلومات update status of document (Doc_Test100) from Draft to InReview', 'notification', 'a:1:{s:4:\"link\";s:68:\"https://www.advancedcontrols.sa/grc/public/admin/governance/category\";}', 21, '2023-08-21 18:04:11', NULL),
(77, 'Employee مدير اﻹدارة العامة ﻷمن المعلومات allow access document (Doc_Test100) to you', 'notification', 'a:1:{s:4:\"link\";s:68:\"https://www.advancedcontrols.sa/grc/public/admin/governance/category\";}', 21, '2023-08-21 18:15:57', NULL),
(78, 'Employee مدير اﻹدارة العامة ﻷمن المعلومات update status of document (Doc_Test100) from InReview to Approved', 'notification', 'a:1:{s:4:\"link\";s:68:\"https://www.advancedcontrols.sa/grc/public/admin/governance/category\";}', 21, '2023-08-21 18:18:28', NULL),
(79, 'hi s', 'notification', 'a:1:{s:4:\"link\";s:73:\"https://www.advancedcontrols.sa/grc/public/admin/vulnerability-management\";}', NULL, '2023-08-21 18:25:23', NULL),
(80, 'hi s', 'notification', 'a:1:{s:4:\"link\";s:73:\"https://www.advancedcontrols.sa/grc/public/admin/vulnerability-management\";}', NULL, '2023-08-21 18:25:23', NULL),
(81, 'hi s', 'notification', 'a:1:{s:4:\"link\";s:73:\"https://www.advancedcontrols.sa/grc/public/admin/vulnerability-management\";}', NULL, '2023-08-21 18:25:23', NULL),
(82, 'hi s', 'notification', 'a:1:{s:4:\"link\";s:73:\"https://www.advancedcontrols.sa/grc/public/admin/vulnerability-management\";}', NULL, '2023-08-21 18:25:23', NULL),
(83, 'hi Mustafa\r\nThis is a new Vul .. please check this out', 'notification', 'a:1:{s:4:\"link\";s:73:\"https://www.advancedcontrols.sa/grc/public/admin/vulnerability-management\";}', NULL, '2023-08-21 18:29:48', NULL),
(84, 'hi Mustafa\r\nThis is a new Vul .. please check this out', 'notification', 'a:1:{s:4:\"link\";s:73:\"https://www.advancedcontrols.sa/grc/public/admin/vulnerability-management\";}', NULL, '2023-08-21 18:29:48', NULL),
(85, 'hi Mustafa\r\nThis is a new Vul .. please check this out', 'notification', 'a:1:{s:4:\"link\";s:73:\"https://www.advancedcontrols.sa/grc/public/admin/vulnerability-management\";}', NULL, '2023-08-21 18:29:48', NULL),
(86, 'hi Mustafa\r\nThis is a new Vul .. please check this out', 'notification', 'a:1:{s:4:\"link\";s:73:\"https://www.advancedcontrols.sa/grc/public/admin/vulnerability-management\";}', NULL, '2023-08-21 18:29:48', NULL),
(87, 'Successfully created new Risk', 'create', 'a:1:{s:4:\"link\";s:67:\"https://www.advancedcontrols.sa/grc/public/admin/risk-management/27\";}', 21, '2023-08-21 18:34:23', NULL),
(88, 'Successfully created new Risk', 'create', 'a:1:{s:4:\"link\";s:67:\"https://www.advancedcontrols.sa/grc/public/admin/risk-management/28\";}', 21, '2023-08-21 21:45:16', NULL),
(89, 'Successfully created new Risk', 'create', 'a:1:{s:4:\"link\";s:67:\"https://www.advancedcontrols.sa/grc/public/admin/risk-management/29\";}', 21, '2023-08-21 21:45:29', NULL),
(90, 'Successfully created new Risk', 'notification', 'a:0:{}', 21, '2023-08-21 21:50:53', NULL),
(91, 'Successfully created new Review', 'create', 'a:1:{s:4:\"link\";s:67:\"https://www.advancedcontrols.sa/grc/public/admin/risk-management/28\";}', 21, '2023-08-21 21:56:12', NULL),
(92, 'Successfully created new Review', 'create', 'a:1:{s:4:\"link\";s:67:\"https://www.advancedcontrols.sa/grc/public/admin/risk-management/28\";}', 21, '2023-08-21 22:06:06', NULL),
(93, 'HellMustafa', 'notification', 'a:1:{s:4:\"link\";s:73:\"https://www.advancedcontrols.sa/grc/public/admin/vulnerability-management\";}', NULL, '2023-08-21 22:23:22', NULL),
(94, 'Successfully created new Asset', 'notification', 'a:1:{s:4:\"link\";s:65:\"https://www.advancedcontrols.sa/grc/public/admin/asset-management\";}', 21, '2023-08-21 22:27:06', NULL),
(95, 'Successfully created new Risk', 'create', 'a:1:{s:4:\"link\";s:67:\"https://www.advancedcontrols.sa/grc/public/admin/risk-management/30\";}', 21, '2023-08-21 22:39:19', NULL),
(96, 'Successfully created new Risk', 'notification', 'a:0:{}', 21, '2023-08-21 22:39:19', NULL),
(97, 'Successfully created new Risk', 'create', 'a:1:{s:4:\"link\";s:67:\"https://www.advancedcontrols.sa/grc/public/admin/risk-management/31\";}', 22, '2023-08-22 08:38:06', NULL),
(98, 'Employee مدير الرئيس التنفيذى create a new document (Doccccs) and you are the owner', 'notification', 'a:1:{s:4:\"link\";s:68:\"https://www.advancedcontrols.sa/grc/public/admin/governance/category\";}', 22, '2023-08-22 08:39:41', NULL),
(99, 'Employee مدير الرئيس التنفيذى create a new document (Doccccs)', 'notification', 'a:1:{s:4:\"link\";s:68:\"https://www.advancedcontrols.sa/grc/public/admin/governance/category\";}', 22, '2023-08-22 08:39:41', NULL),
(100, 'Employee Admin create a new security awareness (Testing4) and you are the owner', 'notification', 'a:1:{s:4:\"link\";s:67:\"https://www.advancedcontrols.sa/grc/public/admin/security-awareness\";}', 22, '2023-08-22 09:16:14', NULL),
(101, 'Employee Admin create a new security awareness (Testing4)', 'notification', 'a:1:{s:4:\"link\";s:67:\"https://www.advancedcontrols.sa/grc/public/admin/security-awareness\";}', 22, '2023-08-22 09:16:14', NULL),
(102, 'Employee مدير الرئيس التنفيذى assign security awareness reviewing (Testing4) to you', 'notification', 'a:1:{s:4:\"link\";s:67:\"https://www.advancedcontrols.sa/grc/public/admin/security-awareness\";}', 22, '2023-08-22 09:23:48', NULL),
(103, 'Employee مدير الرئيس التنفيذى update status of security awareness (Testing4) from Approved to InReview', 'notification', 'a:1:{s:4:\"link\";s:67:\"https://www.advancedcontrols.sa/grc/public/admin/security-awareness\";}', 22, '2023-08-22 09:23:48', NULL),
(104, 'Employee مدير الرئيس التنفيذى update status of security awareness (Testing4) from InReview to Approved', 'notification', 'a:1:{s:4:\"link\";s:67:\"https://www.advancedcontrols.sa/grc/public/admin/security-awareness\";}', 22, '2023-08-22 09:36:44', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `notifications_roles`
--

CREATE TABLE `notifications_roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` int(11) NOT NULL,
  `notifiable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications_roles`
--

INSERT INTO `notifications_roles` (`id`, `role`, `notifiable_id`, `notifiable_type`) VALUES
(2, 'Team-teams', 1, 'App\\Models\\SystemNotificationSetting');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `username` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` int(11) NOT NULL DEFAULT 0,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pending_risks`
--

CREATE TABLE `pending_risks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `assessment_id` bigint(20) UNSIGNED NOT NULL,
  `assessment_answer_id` bigint(20) UNSIGNED NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `score` double(8,2) NOT NULL,
  `owner` int(11) DEFAULT NULL,
  `affected_assets` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `submission_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subgroup_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `key`, `name`, `subgroup_id`, `created_at`, `updated_at`) VALUES
(1, 'framework.list', 'list', 1, NULL, NULL),
(2, 'framework.view', 'view', 1, NULL, NULL),
(3, 'framework.create', 'create', 1, NULL, NULL),
(4, 'framework.update', 'update', 1, NULL, NULL),
(5, 'framework.delete', 'delete', 1, NULL, NULL),
(6, 'framework.print', 'print', 1, NULL, NULL),
(7, 'framework.export', 'export', 1, NULL, NULL),
(8, 'control.list', 'list', 2, NULL, NULL),
(9, 'control.view', 'view', 2, NULL, NULL),
(10, 'control.create', 'create', 2, NULL, NULL),
(11, 'control.update', 'update', 2, NULL, NULL),
(12, 'control.delete', 'delete', 2, NULL, NULL),
(13, 'control.print', 'print', 2, NULL, NULL),
(14, 'control.export', 'export', 2, NULL, NULL),
(15, 'document.create', 'create', 3, NULL, NULL),
(16, 'document.print', 'print', 3, NULL, NULL),
(17, 'document.export', 'export', 3, NULL, NULL),
(18, 'document.download', 'download', 3, NULL, NULL),
(19, 'riskmanagement.list', 'list', 5, NULL, NULL),
(20, 'riskmanagement.view', 'view', 5, NULL, NULL),
(21, 'riskmanagement.create', 'create', 5, NULL, NULL),
(22, 'riskmanagement.update', 'update', 5, NULL, NULL),
(23, 'riskmanagement.delete', 'delete', 5, NULL, NULL),
(24, 'riskmanagement.print', 'print', 5, NULL, NULL),
(25, 'riskmanagement.export', 'export', 5, NULL, NULL),
(26, 'riskmanagement.AbleToCommentRiskManagement', 'AbleToCommentRiskManagement', 5, NULL, NULL),
(27, 'riskmanagement.AbleToCloseRisks', 'AbleToCloseRisks', 5, NULL, NULL),
(28, 'audits.list', 'list', 9, NULL, NULL),
(29, 'audits.create', 'create', 9, NULL, NULL),
(30, 'audits.delete', 'delete', 9, NULL, NULL),
(31, 'audits.result', 'result', 9, NULL, NULL),
(32, 'audits.export', 'export', 9, NULL, NULL),
(33, 'asset.list', 'list', 10, NULL, NULL),
(34, 'asset.view', 'view', 10, NULL, NULL),
(35, 'asset.create', 'create', 10, NULL, NULL),
(36, 'asset.update', 'update', 10, NULL, NULL),
(37, 'asset.delete', 'delete', 10, NULL, NULL),
(38, 'asset.print', 'print', 10, NULL, NULL),
(39, 'asset.export', 'export', 10, NULL, NULL),
(40, 'roles.list', 'list', 12, NULL, NULL),
(41, 'roles.view', 'view', 12, NULL, NULL),
(42, 'roles.create', 'create', 12, NULL, NULL),
(43, 'roles.update', 'update', 12, NULL, NULL),
(44, 'roles.delete', 'delete', 12, NULL, NULL),
(45, 'roles.print', 'print', 12, NULL, NULL),
(46, 'roles.export', 'export', 12, NULL, NULL),
(47, 'values.list', 'list', 13, NULL, NULL),
(48, 'values.view', 'view', 13, NULL, NULL),
(49, 'values.create', 'create', 13, NULL, NULL),
(50, 'values.update', 'update', 13, NULL, NULL),
(51, 'values.delete', 'delete', 13, NULL, NULL),
(52, 'values.print', 'print', 13, NULL, NULL),
(53, 'values.export', 'export', 13, NULL, NULL),
(54, 'logs.list', 'list', 14, NULL, NULL),
(55, 'logs.view', 'view', 14, NULL, NULL),
(56, 'logs.create', 'create', 14, NULL, NULL),
(57, 'logs.update', 'update', 14, NULL, NULL),
(58, 'logs.delete', 'delete', 14, NULL, NULL),
(59, 'logs.print', 'print', 14, NULL, NULL),
(60, 'logs.export', 'export', 14, NULL, NULL),
(61, 'hierarchy.list', 'view', 15, NULL, NULL),
(62, 'hierarchy.view', 'view', 15, NULL, NULL),
(63, 'hierarchy.update', 'update', 15, NULL, NULL),
(64, 'department.list', 'list', 16, NULL, NULL),
(65, 'department.view', 'view', 16, NULL, NULL),
(66, 'department.create', 'create', 16, NULL, NULL),
(67, 'department.update', 'update', 16, NULL, NULL),
(68, 'department.delete', 'delete', 16, NULL, NULL),
(69, 'department.print', 'print', 16, NULL, NULL),
(70, 'department.export', 'export', 16, NULL, NULL),
(71, 'job.list', 'list', 17, NULL, NULL),
(72, 'job.view', 'view', 17, NULL, NULL),
(73, 'job.create', 'create', 17, NULL, NULL),
(74, 'job.update', 'update', 17, NULL, NULL),
(75, 'job.delete', 'delete', 17, NULL, NULL),
(76, 'job.print', 'print', 17, NULL, NULL),
(77, 'job.export', 'export', 17, NULL, NULL),
(78, 'plan_mitigation.create', 'create', 19, NULL, NULL),
(79, 'plan_mitigation.accept', 'accept', 19, NULL, NULL),
(80, 'perform_reviews.create', 'create', 20, NULL, NULL),
(81, 'asset_group.list', 'list', 21, NULL, NULL),
(82, 'asset_group.view', 'view', 21, NULL, NULL),
(83, 'asset_group.create', 'create', 21, NULL, NULL),
(84, 'asset_group.update', 'update', 21, NULL, NULL),
(85, 'asset_group.delete', 'delete', 21, NULL, NULL),
(86, 'asset_group.print', 'print', 21, NULL, NULL),
(87, 'asset_group.export', 'export', 21, NULL, NULL),
(88, 'category.list', 'list', 22, NULL, NULL),
(89, 'category.view', 'view', 22, NULL, NULL),
(90, 'category.create', 'create', 22, NULL, NULL),
(91, 'category.update', 'update', 22, NULL, NULL),
(92, 'category.delete', 'delete', 22, NULL, NULL),
(93, 'category.print', 'print', 22, NULL, NULL),
(94, 'category.export', 'export', 22, NULL, NULL),
(95, 'user_management.list', 'list', 23, NULL, NULL),
(96, 'user_management.view', 'view', 23, NULL, NULL),
(97, 'user_management.create', 'create', 23, NULL, NULL),
(98, 'user_management.update', 'update', 23, NULL, NULL),
(99, 'user_management.delete', 'delete', 23, NULL, NULL),
(100, 'user_management.print', 'print', 23, NULL, NULL),
(101, 'user_management.export', 'export', 23, NULL, NULL),
(102, 'settings.list', 'list', 24, NULL, NULL),
(103, 'settings.view', 'view', 24, NULL, NULL),
(104, 'settings.create', 'create', 24, NULL, NULL),
(105, 'settings.update', 'update', 24, NULL, NULL),
(106, 'settings.delete', 'delete', 24, NULL, NULL),
(107, 'settings.print', 'print', 24, NULL, NULL),
(108, 'settings.export', 'export', 24, NULL, NULL),
(109, 'classic_risk_formula.list', 'list', 25, NULL, NULL),
(110, 'classic_risk_formula.view', 'view', 25, NULL, NULL),
(111, 'classic_risk_formula.create', 'create', 25, NULL, NULL),
(112, 'classic_risk_formula.update', 'update', 25, NULL, NULL),
(113, 'classic_risk_formula.delete', 'delete', 25, NULL, NULL),
(114, 'classic_risk_formula.print', 'print', 25, NULL, NULL),
(115, 'classic_risk_formula.export', 'export', 25, NULL, NULL),
(116, 'import_and_export.list', 'list', 26, NULL, NULL),
(117, 'import_and_export.import', 'import', 26, NULL, NULL),
(118, 'import_and_export.export', 'export', 26, NULL, NULL),
(119, 'LDAP.list', 'list', 27, NULL, NULL),
(120, 'LDAP.test', 'test', 27, NULL, NULL),
(121, 'LDAP.update', 'update', 27, NULL, NULL),
(122, 'reporting.Overview', 'Overview', 28, NULL, NULL),
(123, 'reporting.Risk Dashboard', 'Risk Dashboard', 28, NULL, NULL),
(124, 'reporting.Control Gap Analysis', 'Control Gap Analysis', 28, NULL, NULL),
(125, 'reporting.Likelihood And Impact', 'Likelihood And Impact', 28, NULL, NULL),
(126, 'reporting.All Open Risks Assigne To Me', 'All Open Risks Assigne To Me', 28, NULL, NULL),
(127, 'reporting.Dynamic Risk Report', 'Dynamic Risk Report', 28, NULL, NULL),
(128, 'reporting.Risks and Controls', 'Risks and Controls', 28, NULL, NULL),
(129, 'reporting.Risks and Assets', 'Risks and Assets', 28, NULL, NULL),
(130, 'reporting.framewrok_control_compliance_status', 'Framewrok control compliance status', 28, NULL, NULL),
(131, 'reporting.summary_of_results_for_evaluation_and_compliance', 'Summary of results for evaluation and compliance', 28, NULL, NULL),
(132, 'reporting.security-awareness-exam', 'Security awareness exam', 28, NULL, NULL),
(133, 'task.list', 'list', 29, NULL, NULL),
(134, 'task.create', 'create', 29, NULL, NULL),
(135, 'task.export', 'export', 29, NULL, NULL),
(136, 'about.update', 'update', 30, NULL, NULL),
(137, 'vulnerability_management.list', 'list', 31, NULL, NULL),
(138, 'vulnerability_management.view', 'view', 31, NULL, NULL),
(139, 'vulnerability_management.create', 'create', 31, NULL, NULL),
(140, 'vulnerability_management.update', 'update', 31, NULL, NULL),
(141, 'vulnerability_management.delete', 'delete', 31, NULL, NULL),
(142, 'vulnerability_management.print', 'print', 31, NULL, NULL),
(143, 'vulnerability_management.export', 'export', 31, NULL, NULL),
(144, 'general-setting.update', 'update', 32, NULL, NULL),
(145, 'services-description.update', 'update', 33, NULL, NULL),
(146, 'change-request.create', 'create', 34, NULL, NULL),
(147, 'change-request.export', 'export', 34, NULL, NULL),
(148, 'change-request-department.update', 'update', 35, NULL, NULL),
(149, 'KPI.list', 'list', 36, NULL, NULL),
(150, 'KPI.create', 'create', 36, NULL, NULL),
(151, 'KPI.update', 'update', 36, NULL, NULL),
(152, 'KPI.delete', 'delete', 36, NULL, NULL),
(153, 'KPI.Initiate assessment', 'Initiate assessment', 36, NULL, NULL),
(154, 'KPI.export', 'export', 36, NULL, NULL),
(155, 'security-awareness.create', 'create', 37, NULL, NULL),
(156, 'security-awareness.print', 'print', 37, NULL, NULL),
(157, 'security-awareness.export', 'export', 37, NULL, NULL),
(158, 'security-awareness.download', 'download', 37, NULL, NULL),
(159, 'domain.list', 'list', 38, NULL, NULL),
(160, 'domain.view', 'view', 38, NULL, NULL),
(161, 'domain.create', 'create', 38, NULL, NULL),
(162, 'domain.update', 'update', 38, NULL, NULL),
(163, 'domain.delete', 'delete', 38, NULL, NULL),
(164, 'domain.print', 'print', 38, NULL, NULL),
(165, 'domain.export', 'export', 38, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permission_groups`
--

CREATE TABLE `permission_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_groups`
--

INSERT INTO `permission_groups` (`id`, `name`, `description`, `order`) VALUES
(1, 'Governance', '', 1),
(2, 'Risk Management', '', 2),
(3, 'Compliance', '', 3),
(4, 'Asset Management', '', 4),
(5, 'Assessments', '', 5),
(6, 'Configure', '', 6),
(7, 'Hierarchy', '', 7),
(8, 'Reporting', '', 8),
(9, 'Task', '', 9),
(10, 'Vulnerability Management', '', 10),
(11, 'Change Request', '', 11),
(12, 'KPI', '', 12),
(13, 'Security Awareness', '', 13);

-- --------------------------------------------------------

--
-- Table structure for table `permission_to_permission_groups`
--

CREATE TABLE `permission_to_permission_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `permission_group_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_to_permission_groups`
--

INSERT INTO `permission_to_permission_groups` (`id`, `permission_id`, `permission_group_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 4, 1),
(5, 5, 1),
(6, 6, 1),
(7, 7, 1),
(8, 8, 1),
(9, 9, 1),
(10, 10, 1),
(11, 11, 1),
(12, 12, 1),
(13, 13, 1),
(14, 14, 1),
(15, 15, 1),
(16, 16, 2),
(17, 17, 2),
(18, 18, 2),
(19, 19, 2),
(20, 20, 2),
(21, 21, 2),
(22, 22, 2),
(23, 23, 2),
(24, 24, 2),
(25, 25, 2),
(26, 26, 2),
(27, 27, 2),
(28, 28, 2),
(29, 29, 2),
(30, 30, 2),
(31, 31, 3),
(32, 32, 3),
(33, 33, 3),
(34, 34, 3),
(35, 35, 3),
(36, 36, 3),
(37, 37, 3),
(38, 38, 3),
(39, 39, 3),
(40, 40, 4),
(41, 41, 5);

-- --------------------------------------------------------

--
-- Table structure for table `permission_to_users`
--

CREATE TABLE `permission_to_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_to_users`
--

INSERT INTO `permission_to_users` (`id`, `permission_id`, `user_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 4, 1),
(5, 5, 1),
(6, 6, 1),
(7, 7, 1),
(8, 8, 1),
(9, 9, 1),
(10, 10, 1),
(11, 11, 1),
(12, 12, 1),
(13, 13, 1),
(14, 14, 1),
(15, 15, 1),
(16, 16, 1),
(17, 17, 1),
(18, 18, 1),
(19, 19, 1),
(20, 20, 1),
(21, 21, 1),
(22, 22, 1),
(23, 23, 1),
(24, 24, 1),
(25, 25, 1),
(26, 26, 1),
(27, 27, 1),
(28, 28, 1),
(29, 29, 1),
(30, 30, 1),
(31, 31, 1),
(32, 32, 1),
(33, 33, 1),
(34, 34, 1),
(35, 35, 1),
(36, 36, 1),
(37, 37, 1),
(38, 38, 1),
(39, 39, 1),
(40, 40, 1),
(41, 41, 1),
(42, 42, 1),
(43, 43, 1),
(44, 44, 1),
(45, 45, 1),
(46, 46, 1),
(47, 47, 1),
(48, 48, 1),
(49, 49, 1),
(50, 50, 1),
(51, 51, 1),
(52, 52, 1),
(53, 53, 1),
(54, 54, 1),
(55, 55, 1),
(56, 56, 1),
(57, 57, 1),
(58, 58, 1),
(59, 59, 1),
(60, 60, 1),
(61, 61, 1),
(62, 62, 1),
(63, 63, 1),
(64, 64, 1),
(65, 65, 1),
(66, 66, 1),
(67, 67, 1),
(68, 68, 1),
(69, 69, 1),
(70, 70, 1),
(71, 71, 1),
(72, 72, 1),
(73, 73, 1),
(74, 74, 1),
(75, 75, 1),
(76, 76, 1),
(77, 77, 1),
(78, 78, 1),
(79, 79, 1),
(80, 80, 1),
(81, 81, 1),
(82, 82, 1),
(83, 83, 1),
(84, 84, 1),
(85, 85, 1),
(86, 86, 1),
(87, 87, 1),
(88, 88, 1),
(89, 89, 1),
(90, 90, 1),
(91, 91, 1),
(92, 92, 1),
(93, 93, 1),
(94, 94, 1),
(95, 95, 1),
(96, 96, 1),
(97, 97, 1),
(98, 98, 1),
(99, 99, 1),
(100, 100, 1),
(101, 101, 1),
(102, 102, 1),
(103, 103, 1),
(104, 104, 1),
(105, 105, 1),
(106, 106, 1),
(107, 107, 1),
(108, 108, 1),
(109, 109, 1),
(110, 110, 1),
(111, 111, 1),
(112, 112, 1),
(113, 113, 1),
(114, 114, 1),
(115, 115, 1),
(116, 116, 1),
(117, 117, 1),
(118, 118, 1),
(119, 119, 1),
(120, 120, 1),
(121, 121, 1),
(122, 122, 1),
(123, 123, 1),
(124, 124, 1),
(125, 125, 1),
(126, 126, 1),
(127, 127, 1),
(128, 128, 1),
(129, 129, 1),
(130, 130, 1),
(131, 131, 1),
(132, 132, 1),
(133, 133, 1),
(134, 134, 1),
(135, 135, 1),
(136, 136, 1),
(137, 137, 1),
(138, 138, 1),
(139, 139, 1),
(140, 140, 1),
(141, 141, 1),
(142, 142, 1),
(143, 143, 1),
(144, 144, 1),
(145, 145, 1),
(146, 146, 1),
(147, 147, 1),
(148, 148, 1),
(149, 149, 1),
(150, 150, 1),
(151, 151, 1),
(152, 152, 1),
(153, 153, 1),
(154, 154, 1),
(155, 155, 1),
(156, 156, 1),
(157, 157, 1),
(158, 158, 1),
(159, 159, 1),
(160, 160, 1),
(161, 161, 1),
(162, 162, 1),
(163, 163, 1),
(164, 164, 1),
(165, 165, 1),
(166, 1, 3),
(167, 2, 3),
(168, 3, 3),
(169, 4, 3),
(170, 5, 3),
(171, 6, 3),
(172, 7, 3),
(173, 8, 3),
(174, 9, 3),
(175, 10, 3),
(176, 11, 3),
(177, 12, 3),
(178, 13, 3),
(179, 14, 3),
(180, 15, 3),
(181, 16, 3),
(182, 17, 3),
(183, 18, 3),
(184, 19, 3),
(185, 20, 3),
(186, 21, 3),
(187, 22, 3),
(188, 23, 3),
(189, 24, 3),
(190, 25, 3),
(191, 26, 3),
(192, 27, 3),
(193, 28, 3),
(194, 29, 3),
(195, 30, 3),
(196, 31, 3),
(197, 32, 3),
(198, 33, 3),
(199, 34, 3),
(200, 35, 3),
(201, 36, 3),
(202, 37, 3),
(203, 38, 3),
(204, 39, 3),
(205, 40, 3),
(206, 41, 3),
(207, 42, 3),
(208, 43, 3),
(209, 44, 3),
(210, 45, 3),
(211, 46, 3),
(212, 47, 3),
(213, 48, 3),
(214, 49, 3),
(215, 50, 3),
(216, 51, 3),
(217, 52, 3),
(218, 53, 3),
(219, 54, 3),
(220, 55, 3),
(221, 56, 3),
(222, 57, 3),
(223, 58, 3),
(224, 59, 3),
(225, 60, 3),
(226, 61, 3),
(227, 62, 3),
(228, 63, 3),
(229, 64, 3),
(230, 65, 3),
(231, 66, 3),
(232, 67, 3),
(233, 68, 3),
(234, 69, 3),
(235, 70, 3),
(236, 71, 3),
(237, 72, 3),
(238, 73, 3),
(239, 74, 3),
(240, 75, 3),
(241, 76, 3),
(242, 77, 3),
(243, 78, 3),
(244, 79, 3),
(245, 80, 3),
(246, 81, 3),
(247, 82, 3),
(248, 83, 3),
(249, 84, 3),
(250, 85, 3),
(251, 86, 3),
(252, 87, 3),
(253, 88, 3),
(254, 89, 3),
(255, 90, 3),
(256, 91, 3),
(257, 92, 3),
(258, 93, 3),
(259, 94, 3),
(260, 95, 3),
(261, 96, 3),
(262, 97, 3),
(263, 98, 3),
(264, 99, 3),
(265, 100, 3),
(266, 101, 3),
(267, 102, 3),
(268, 103, 3),
(269, 104, 3),
(270, 105, 3),
(271, 106, 3),
(272, 107, 3),
(273, 108, 3),
(274, 109, 3),
(275, 110, 3),
(276, 111, 3),
(277, 112, 3),
(278, 113, 3),
(279, 114, 3),
(280, 115, 3),
(281, 116, 3),
(282, 117, 3),
(283, 118, 3),
(284, 119, 3),
(285, 120, 3),
(286, 121, 3),
(287, 122, 3),
(288, 123, 3),
(289, 124, 3),
(290, 125, 3),
(291, 126, 3),
(292, 127, 3),
(293, 128, 3),
(294, 129, 3),
(295, 130, 3),
(296, 131, 3),
(297, 132, 3),
(298, 133, 3),
(299, 134, 3),
(300, 135, 3),
(301, 136, 3),
(302, 137, 3),
(303, 138, 3),
(304, 139, 3),
(305, 140, 3),
(306, 141, 3),
(307, 142, 3),
(308, 143, 3),
(309, 144, 3),
(310, 145, 3),
(311, 146, 3),
(312, 147, 3),
(313, 148, 3),
(314, 149, 3),
(315, 150, 3),
(316, 151, 3),
(317, 152, 3),
(318, 153, 3),
(319, 154, 3),
(320, 155, 3),
(321, 156, 3),
(322, 157, 3),
(323, 158, 3),
(324, 159, 3),
(325, 160, 3),
(326, 161, 3),
(327, 162, 3),
(328, 163, 3),
(329, 164, 3),
(330, 165, 3),
(331, 1, 2),
(332, 2, 2),
(333, 3, 2),
(334, 4, 2),
(335, 5, 2),
(336, 6, 2),
(337, 7, 2),
(338, 8, 2),
(339, 9, 2),
(340, 10, 2),
(341, 11, 2),
(342, 12, 2),
(343, 13, 2),
(344, 14, 2),
(345, 15, 2),
(346, 16, 2),
(347, 17, 2),
(348, 18, 2),
(349, 19, 2),
(350, 20, 2),
(351, 21, 2),
(352, 22, 2),
(353, 23, 2),
(354, 24, 2),
(355, 25, 2),
(356, 26, 2),
(357, 27, 2),
(358, 28, 2),
(359, 29, 2),
(360, 30, 2),
(361, 31, 2),
(362, 32, 2),
(363, 33, 2),
(364, 34, 2),
(365, 35, 2),
(366, 36, 2),
(367, 37, 2),
(368, 38, 2),
(369, 39, 2),
(370, 40, 2),
(371, 41, 2),
(372, 42, 2),
(373, 43, 2),
(374, 44, 2),
(375, 45, 2),
(376, 46, 2),
(377, 47, 2),
(378, 48, 2),
(379, 49, 2),
(380, 50, 2),
(381, 51, 2),
(382, 52, 2),
(383, 53, 2),
(384, 54, 2),
(385, 55, 2),
(386, 56, 2),
(387, 57, 2),
(388, 58, 2),
(389, 59, 2),
(390, 60, 2),
(391, 61, 2),
(392, 62, 2),
(393, 63, 2),
(394, 64, 2),
(395, 65, 2),
(396, 66, 2),
(397, 67, 2),
(398, 68, 2),
(399, 69, 2),
(400, 70, 2),
(401, 71, 2),
(402, 72, 2),
(403, 73, 2),
(404, 74, 2),
(405, 75, 2),
(406, 76, 2),
(407, 77, 2),
(408, 78, 2),
(409, 79, 2),
(410, 80, 2),
(411, 81, 2),
(412, 82, 2),
(413, 83, 2),
(414, 84, 2),
(415, 85, 2),
(416, 86, 2),
(417, 87, 2),
(418, 88, 2),
(419, 89, 2),
(420, 90, 2),
(421, 91, 2),
(422, 92, 2),
(423, 93, 2),
(424, 94, 2),
(425, 95, 2),
(426, 96, 2),
(427, 97, 2),
(428, 98, 2),
(429, 99, 2),
(430, 100, 2),
(431, 101, 2),
(432, 102, 2),
(433, 103, 2),
(434, 104, 2),
(435, 105, 2),
(436, 106, 2),
(437, 107, 2),
(438, 108, 2),
(439, 109, 2),
(440, 110, 2),
(441, 111, 2),
(442, 112, 2),
(443, 113, 2),
(444, 114, 2),
(445, 115, 2),
(446, 116, 2),
(447, 117, 2),
(448, 118, 2),
(449, 119, 2),
(450, 120, 2),
(451, 121, 2),
(452, 122, 2),
(453, 123, 2),
(454, 124, 2),
(455, 125, 2),
(456, 126, 2),
(457, 127, 2),
(458, 128, 2),
(459, 129, 2),
(460, 130, 2),
(461, 131, 2),
(462, 132, 2),
(463, 133, 2),
(464, 134, 2),
(465, 135, 2),
(466, 136, 2),
(467, 137, 2),
(468, 138, 2),
(469, 139, 2),
(470, 140, 2),
(471, 141, 2),
(472, 142, 2),
(473, 143, 2),
(474, 144, 2),
(475, 145, 2),
(476, 146, 2),
(477, 147, 2),
(478, 148, 2),
(479, 149, 2),
(480, 150, 2),
(481, 151, 2),
(482, 152, 2),
(483, 153, 2),
(484, 154, 2),
(485, 155, 2),
(486, 156, 2),
(487, 157, 2),
(488, 158, 2),
(489, 159, 2),
(490, 160, 2),
(491, 161, 2),
(492, 162, 2),
(493, 163, 2),
(494, 164, 2),
(495, 165, 2),
(496, 1, 6),
(497, 2, 6),
(503, 8, 6),
(504, 9, 6),
(514, 19, 6),
(515, 20, 6),
(523, 28, 6),
(528, 33, 6),
(529, 34, 6),
(535, 40, 6),
(536, 41, 6),
(542, 47, 6),
(543, 48, 6),
(549, 54, 6),
(550, 55, 6),
(556, 61, 6),
(557, 62, 6),
(559, 64, 6),
(560, 65, 6),
(566, 71, 6),
(567, 72, 6),
(576, 81, 6),
(577, 82, 6),
(583, 88, 6),
(590, 95, 6),
(591, 96, 6),
(597, 102, 6),
(598, 103, 6),
(604, 109, 6),
(605, 110, 6),
(611, 116, 6),
(614, 119, 6),
(628, 133, 6),
(632, 137, 6),
(633, 138, 6),
(644, 149, 6),
(654, 159, 6),
(655, 160, 6),
(661, 15, 6),
(662, 78, 6),
(663, 79, 6),
(664, 80, 6),
(665, 29, 6),
(666, 30, 6),
(667, 31, 6),
(668, 32, 6),
(669, 35, 6),
(670, 83, 6),
(671, 49, 6),
(672, 50, 6),
(673, 51, 6),
(674, 52, 6),
(675, 56, 6),
(676, 57, 6),
(677, 58, 6),
(678, 59, 6),
(679, 60, 6),
(680, 97, 6),
(681, 98, 6),
(682, 99, 6),
(683, 100, 6),
(684, 101, 6),
(685, 104, 6),
(686, 105, 6),
(687, 106, 6),
(688, 107, 6),
(689, 108, 6),
(690, 111, 6),
(691, 112, 6),
(692, 113, 6),
(693, 114, 6),
(694, 115, 6),
(695, 117, 6),
(696, 118, 6),
(697, 120, 6),
(698, 121, 6),
(699, 136, 6),
(700, 144, 6),
(701, 145, 6),
(702, 148, 6),
(703, 161, 6),
(704, 162, 6),
(705, 163, 6),
(706, 164, 6),
(707, 165, 6),
(708, 63, 6),
(709, 66, 6),
(710, 67, 6),
(711, 68, 6),
(712, 69, 6),
(713, 70, 6),
(714, 73, 6),
(715, 74, 6),
(716, 75, 6),
(717, 76, 6),
(718, 77, 6),
(719, 122, 6),
(720, 123, 6),
(721, 124, 6),
(722, 125, 6),
(723, 126, 6),
(724, 127, 6),
(725, 128, 6),
(726, 129, 6),
(727, 130, 6),
(728, 131, 6),
(729, 132, 6),
(730, 134, 6),
(731, 135, 6),
(732, 139, 6),
(733, 140, 6),
(734, 141, 6),
(735, 142, 6),
(736, 143, 6),
(737, 146, 6),
(738, 147, 6),
(739, 150, 6),
(740, 151, 6),
(741, 152, 6),
(742, 153, 6),
(743, 154, 6),
(744, 155, 6),
(745, 156, 6),
(746, 157, 6),
(747, 158, 6);

-- --------------------------------------------------------

--
-- Table structure for table `planning_strategies`
--

CREATE TABLE `planning_strategies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `planning_strategies`
--

INSERT INTO `planning_strategies` (`id`, `name`) VALUES
(1, 'Investigate'),
(2, 'Accepted'),
(3, 'Mitigated'),
(4, 'To see'),
(5, 'Transfer');

-- --------------------------------------------------------

--
-- Table structure for table `privacies`
--

CREATE TABLE `privacies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `privacies`
--

INSERT INTO `privacies` (`id`, `title`, `created_at`, `updated_at`) VALUES
(1, 'Private', '2023-07-05 12:42:42', '2023-07-05 12:42:42'),
(2, 'Public', '2023-07-05 12:42:42', '2023-07-05 12:42:42');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `due_date` timestamp NULL DEFAULT NULL,
  `consultant` int(11) DEFAULT NULL,
  `business_owner` int(11) DEFAULT NULL,
  `data_classification` int(11) DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 999999,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `name`, `due_date`, `consultant`, `business_owner`, `data_classification`, `order`, `status`) VALUES
(1, 'Project 1', '0000-00-00 00:00:00', 0, 0, 0, 0, 0),
(2, 'Project 2', '0000-00-00 00:00:00', 0, 0, 0, 0, 0),
(3, 'Project 3', '0000-00-00 00:00:00', 0, 0, 0, 0, 0),
(4, 'Project 4', '0000-00-00 00:00:00', 0, 0, 0, 0, 0),
(5, 'Project 5', '0000-00-00 00:00:00', 0, 0, 0, 0, 0),
(6, 'Project 6', '0000-00-00 00:00:00', 0, 0, 0, 0, 0),
(7, 'Project 7', '0000-00-00 00:00:00', 0, 0, 0, 0, 0),
(8, 'Project 8', '0000-00-00 00:00:00', 0, 0, 0, 0, 0),
(9, 'Project 9', '0000-00-00 00:00:00', 0, 0, 0, 0, 0),
(10, 'Project 10', '0000-00-00 00:00:00', 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `questionnaires`
--

CREATE TABLE `questionnaires` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `instructions` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `assessment_id` bigint(20) UNSIGNED DEFAULT NULL,
  `all_questions_mandatory` tinyint(1) NOT NULL DEFAULT 0,
  `answer_percentage` tinyint(1) NOT NULL DEFAULT 0,
  `percentage_number` tinyint(4) NOT NULL DEFAULT 0,
  `specific_mandatory_questions` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `questionnaire_pending_risks`
--

CREATE TABLE `questionnaire_pending_risks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `questionnaire_tracking_id` int(11) NOT NULL,
  `questionnaire_scoring_id` int(11) NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` int(11) DEFAULT NULL,
  `asset` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `submission_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `questionnaire_questions`
--

CREATE TABLE `questionnaire_questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `questionnaire_id` bigint(20) UNSIGNED NOT NULL,
  `question_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `questionnaire_risks`
--

CREATE TABLE `questionnaire_risks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `questionnaire_id` bigint(20) UNSIGNED NOT NULL,
  `answer_id` bigint(20) UNSIGNED NOT NULL,
  `risk_subject` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `risk_scoring_method_id` bigint(20) UNSIGNED DEFAULT NULL,
  `likelihood_id` bigint(20) UNSIGNED DEFAULT NULL,
  `impact_id` bigint(20) UNSIGNED DEFAULT NULL,
  `owner_id` bigint(20) UNSIGNED DEFAULT NULL,
  `assets_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`assets_ids`)),
  `tags_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`tags_ids`)),
  `framework_controls_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`framework_controls_ids`)),
  `status` enum('pending','rejected','added') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer_type` tinyint(4) NOT NULL DEFAULT 1,
  `file_attachment` tinyint(1) NOT NULL DEFAULT 0,
  `question_logic` tinyint(1) NOT NULL DEFAULT 0,
  `risk_assessment` tinyint(1) NOT NULL DEFAULT 0,
  `compliance_assessment` tinyint(1) NOT NULL DEFAULT 0,
  `maturity_assessment` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `regulations`
--

CREATE TABLE `regulations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `regulations`
--

INSERT INTO `regulations` (`id`, `name`) VALUES
(1, 'PCI DSS 3.2'),
(2, 'Sarbanes-Oxley (SOX)'),
(3, 'HIPAA'),
(4, 'ISO 27001');

-- --------------------------------------------------------

--
-- Table structure for table `residual_risk_scoring_histories`
--

CREATE TABLE `residual_risk_scoring_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `risk_id` bigint(20) UNSIGNED NOT NULL,
  `residual_risk` double(8,2) NOT NULL,
  `last_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `residual_risk_scoring_histories`
--

INSERT INTO `residual_risk_scoring_histories` (`id`, `risk_id`, `residual_risk`, `last_update`) VALUES
(1, 1, 1.20, '2023-07-05 12:42:46'),
(2, 2, 1.20, '2023-07-05 12:42:46'),
(3, 3, 1.20, '2023-07-05 12:42:46'),
(4, 4, 1.20, '2023-07-05 12:42:46'),
(5, 5, 1.20, '2023-07-05 12:42:46'),
(6, 6, 1.20, '2023-07-05 12:42:46'),
(7, 7, 1.20, '2023-07-05 12:42:46'),
(8, 8, 1.20, '2023-07-05 12:42:46'),
(9, 9, 1.20, '2023-07-05 12:42:46'),
(10, 10, 1.20, '2023-07-05 12:42:46'),
(11, 11, 1.20, '2023-07-05 12:42:46'),
(12, 12, 1.20, '2023-07-05 12:42:46'),
(13, 13, 1.20, '2023-07-05 12:42:46'),
(14, 14, 1.20, '2023-07-05 12:42:46'),
(15, 15, 1.20, '2023-07-05 12:42:46'),
(16, 16, 1.20, '2023-07-05 12:42:46'),
(17, 17, 1.20, '2023-07-05 12:42:46'),
(18, 18, 1.20, '2023-07-05 12:42:46'),
(19, 19, 1.20, '2023-07-05 12:42:46'),
(20, 20, 1.20, '2023-07-05 12:42:46'),
(21, 21, 0.40, '2023-07-05 12:42:46'),
(22, 22, 1.60, '2023-07-05 12:42:46'),
(23, 23, 3.60, '2023-07-05 12:42:46'),
(24, 24, 6.40, '2023-07-05 12:42:46'),
(25, 25, 10.00, '2023-07-05 12:42:46'),
(26, 1, 0.41, '2023-07-05 14:00:44'),
(27, 26, 10.00, '2023-08-07 11:34:36'),
(28, 27, 3.20, '2023-08-21 18:34:23'),
(29, 28, 3.60, '2023-08-21 21:45:16'),
(31, 28, 2.81, '2023-08-21 22:16:01'),
(32, 30, 2.40, '2023-08-21 22:39:19'),
(33, 31, 4.80, '2023-08-22 08:38:06');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `name`) VALUES
(1, 'Approve Risk'),
(2, 'Reject Risk and Close');

-- --------------------------------------------------------

--
-- Table structure for table `review_levels`
--

CREATE TABLE `review_levels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `value` int(11) NOT NULL,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `review_levels`
--

INSERT INTO `review_levels` (`id`, `value`, `name`) VALUES
(1, 360, 'Insignificant'),
(2, 360, 'Low'),
(3, 180, 'Medium'),
(4, 90, 'High'),
(5, 90, 'Very High');

-- --------------------------------------------------------

--
-- Table structure for table `risks`
--

CREATE TABLE `risks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'New',
  `subject` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference_id` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `regulation` int(11) DEFAULT NULL,
  `control_id` bigint(20) UNSIGNED DEFAULT NULL,
  `source_id` bigint(20) UNSIGNED DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `owner_id` bigint(20) UNSIGNED DEFAULT NULL,
  `manager_id` bigint(20) UNSIGNED DEFAULT NULL,
  `assessment` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `review_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mitigation_id` bigint(20) UNSIGNED DEFAULT NULL,
  `mgmt_review` int(11) DEFAULT NULL,
  `project_id` bigint(20) UNSIGNED DEFAULT NULL,
  `close_id` int(11) DEFAULT NULL,
  `submitted_by` int(11) NOT NULL DEFAULT 1,
  `risk_catalog_mapping` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `threat_catalog_mapping` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `template_group_id` int(11) NOT NULL DEFAULT 1,
  `submission_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `risks`
--

INSERT INTO `risks` (`id`, `status`, `subject`, `reference_id`, `regulation`, `control_id`, `source_id`, `category_id`, `owner_id`, `manager_id`, `assessment`, `notes`, `review_date`, `mitigation_id`, `mgmt_review`, `project_id`, `close_id`, `submitted_by`, `risk_catalog_mapping`, `threat_catalog_mapping`, `template_group_id`, `submission_date`, `created_at`, `updated_at`) VALUES
(1, 'Mitigation Planned', 'facere', NULL, 1, 6, 4, 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', 21, NULL, NULL, 1, 1, '', '', 0, '2023-07-05 09:42:46', '2023-07-05 12:42:46', '2023-07-13 13:50:27'),
(2, 'Closed', 'exercitationem', NULL, NULL, NULL, 1, 2, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL, NULL, NULL, 2, 1, '', '', 0, '2023-07-05 09:42:46', '2023-07-05 12:42:46', '2023-08-20 17:27:30'),
(3, 'Opened', 'nam', NULL, NULL, NULL, 3, 4, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL, NULL, NULL, 3, 1, NULL, NULL, 1, '2023-07-05 09:42:46', '2023-07-05 12:42:46', '2023-07-05 12:42:46'),
(4, 'Opened', 'hic', NULL, NULL, NULL, 3, 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL, NULL, NULL, 4, 1, NULL, NULL, 1, '2023-07-05 09:42:46', '2023-07-05 12:42:46', '2023-07-05 12:42:46'),
(5, 'Closed', 'occaecati', NULL, NULL, NULL, 3, 6, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL, NULL, NULL, 5, 1, NULL, NULL, 1, '2023-07-05 09:42:46', '2023-07-05 12:42:46', '2023-07-05 12:42:46'),
(6, 'Closed', 'occaecati', NULL, NULL, NULL, 2, 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL, NULL, NULL, 6, 1, NULL, NULL, 1, '2023-07-05 09:42:46', '2023-07-05 12:42:46', '2023-07-05 12:42:46'),
(7, 'Closed', 'vero', NULL, NULL, NULL, 1, 5, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL, NULL, NULL, 7, 1, NULL, NULL, 1, '2023-07-05 09:42:46', '2023-07-05 12:42:46', '2023-07-05 12:42:46'),
(8, 'Closed', 'nostrum', NULL, NULL, NULL, 2, 5, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL, NULL, NULL, 8, 1, NULL, NULL, 1, '2023-07-05 09:42:46', '2023-07-05 12:42:46', '2023-07-05 12:42:46'),
(9, 'Opened', 'maiores', NULL, NULL, NULL, 4, 8, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL, NULL, NULL, 9, 1, NULL, NULL, 1, '2023-07-05 09:42:46', '2023-07-05 12:42:46', '2023-07-05 12:42:46'),
(10, 'Closed', 'at', NULL, NULL, NULL, 1, 5, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL, NULL, NULL, 10, 1, NULL, NULL, 1, '2023-07-05 09:42:46', '2023-07-05 12:42:46', '2023-07-05 12:42:46'),
(11, 'Opened', 'non', NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL, NULL, NULL, 11, 1, NULL, NULL, 1, '2023-07-05 09:42:46', '2023-07-05 12:42:46', '2023-07-05 12:42:46'),
(12, 'Opened', 'odio', NULL, NULL, NULL, 2, 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL, NULL, NULL, 12, 1, NULL, NULL, 1, '2023-07-05 09:42:46', '2023-07-05 12:42:46', '2023-07-05 12:42:46'),
(13, 'Closed', 'aperiam', NULL, NULL, NULL, 4, 7, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL, NULL, NULL, 13, 1, NULL, NULL, 1, '2023-07-05 09:42:46', '2023-07-05 12:42:46', '2023-07-05 12:42:46'),
(14, 'Closed', 'est', NULL, NULL, NULL, 1, 7, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL, NULL, NULL, 14, 1, NULL, NULL, 1, '2023-07-05 09:42:46', '2023-07-05 12:42:46', '2023-07-05 12:42:46'),
(15, 'Opened', 'non', NULL, NULL, NULL, 3, 6, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL, NULL, NULL, 15, 1, NULL, NULL, 1, '2023-07-05 09:42:46', '2023-07-05 12:42:46', '2023-07-05 12:42:46'),
(16, 'Closed', 'temporibus', NULL, NULL, NULL, 2, 3, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL, NULL, NULL, 16, 1, NULL, NULL, 1, '2023-07-05 09:42:46', '2023-07-05 12:42:46', '2023-07-05 12:42:46'),
(17, 'Closed', 'eum', NULL, NULL, NULL, 4, 6, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL, NULL, NULL, 17, 1, NULL, NULL, 1, '2023-07-05 09:42:46', '2023-07-05 12:42:46', '2023-07-05 12:42:46'),
(18, 'Closed', 'quo', NULL, NULL, NULL, 4, 7, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL, NULL, NULL, 18, 1, NULL, NULL, 1, '2023-07-05 09:42:46', '2023-07-05 12:42:46', '2023-07-05 12:42:46'),
(19, 'Opened', 'doloremque', NULL, NULL, NULL, 1, 6, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL, NULL, NULL, 19, 1, NULL, NULL, 1, '2023-07-05 09:42:46', '2023-07-05 12:42:46', '2023-07-05 12:42:46'),
(20, 'Closed', 'eum', NULL, NULL, NULL, 2, 2, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL, NULL, NULL, 20, 1, NULL, NULL, 1, '2023-07-05 09:42:46', '2023-07-05 12:42:46', '2023-07-05 12:42:46'),
(21, 'New', 'Risk 1 Subject', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, 1, NULL, NULL, 1, '2023-07-05 09:42:46', '2023-07-05 12:42:46', '2023-07-05 12:42:46'),
(22, 'New', 'Risk 2 Subject', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, 1, NULL, NULL, 1, '2023-07-05 09:42:46', '2023-07-05 12:42:46', '2023-07-05 12:42:46'),
(23, 'New', 'Risk 3 Subject', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, 1, NULL, NULL, 1, '2023-07-05 09:42:46', '2023-07-05 12:42:46', '2023-07-05 12:42:46'),
(24, 'New', 'Risk 4 Subject', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, 1, NULL, NULL, 1, '2023-07-05 09:42:46', '2023-07-05 12:42:46', '2023-07-05 12:42:46'),
(25, 'New', 'Risk 5 Subject', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, 1, NULL, NULL, 1, '2023-07-05 09:42:46', '2023-07-05 12:42:46', '2023-07-05 12:42:46'),
(26, 'New', 'Ecc111Risk', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, 1, '2', '3', 0, '2023-08-07 08:34:36', '2023-08-07 11:34:36', '2023-08-07 11:34:36'),
(27, 'Mitigation Planned', 'Risk_Testing', 'Et quas omnis totam', 3, 509, 1, 2, 1, NULL, 's', 's', '0000-00-00 00:00:00', 22, NULL, NULL, NULL, 3, '2', '1', 0, '2023-08-21 15:34:23', '2023-08-21 18:34:23', '2023-08-21 18:40:22'),
(28, 'Mitigation Planned', 'Risk33_test', NULL, 2, 224, 3, 4, 2, NULL, 'r', NULL, '2023-08-21 22:06:06', 23, 22, NULL, NULL, 1, '1', '', 0, '2023-08-21 18:45:16', '2023-08-21 21:45:16', '2023-08-21 22:16:01'),
(30, 'New', 'Riesk', NULL, 2, 224, NULL, NULL, 1, NULL, 's', 's', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, 2, '', '', 0, '2023-08-21 19:39:19', '2023-08-21 22:39:19', '2023-08-21 22:39:19'),
(31, 'New', 'Risk45', 'Qui eaque nobis temp', 1, 5, 1, 2, 3, NULL, 's', 's', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, 1, '1', '3', 0, '2023-08-22 05:38:06', '2023-08-22 08:38:06', '2023-08-22 08:38:06');

-- --------------------------------------------------------

--
-- Table structure for table `risks_to_assets`
--

CREATE TABLE `risks_to_assets` (
  `risk_id` bigint(20) UNSIGNED NOT NULL,
  `asset_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `risks_to_assets`
--

INSERT INTO `risks_to_assets` (`risk_id`, `asset_id`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 8),
(9, 9),
(10, 10),
(11, 11),
(12, 12),
(13, 13),
(14, 14),
(15, 15),
(16, 16),
(17, 17),
(18, 18),
(19, 19),
(20, 20),
(31, 1);

-- --------------------------------------------------------

--
-- Table structure for table `risks_to_asset_groups`
--

CREATE TABLE `risks_to_asset_groups` (
  `risk_id` bigint(20) UNSIGNED NOT NULL,
  `asset_group_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `risks_to_asset_groups`
--

INSERT INTO `risks_to_asset_groups` (`risk_id`, `asset_group_id`) VALUES
(1, 21),
(11, 11),
(12, 12),
(13, 13),
(14, 14),
(15, 15),
(16, 16),
(17, 17),
(18, 18),
(19, 19),
(27, 10),
(28, 1);

-- --------------------------------------------------------

--
-- Table structure for table `risk_catalogs`
--

CREATE TABLE `risk_catalogs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `number` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `risk_grouping_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `risk_function_id` bigint(20) UNSIGNED NOT NULL,
  `order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `risk_catalogs`
--

INSERT INTO `risk_catalogs` (`id`, `number`, `risk_grouping_id`, `name`, `description`, `risk_function_id`, `order`) VALUES
(1, 'R-AC-1', 1, 'Inability to maintain individual accountability', 'There is a failure to maintain asset ownership and it is not possible to have non-repudiation of actions or inactions.', 2, 1),
(2, 'R-AC-2', 1, 'Improper assignment of privileged risk_function_ids', 'There is a failure to implement least privileges.', 2, 2),
(3, 'R-AC-3', 1, 'Privilege escalation', 'Access to privileged risk_function_ids is inadequate or cannot be controlled.', 2, 3),
(4, 'R-AC-4', 1, 'Unauthorized access', 'Access is granted to unauthorized individuals, groups or services.', 2, 4),
(5, 'R-AM-1', 2, 'Lost, damaged or stolen asset(s)', 'Asset(s) is/are lost, damaged or stolen.', 2, 5),
(6, 'R-AM-2', 2, 'Loss of integrity through unauthorized changes ', 'Unauthorized changes corrupt the integrity of the system / application / service.', 2, 6),
(7, 'R-BC-1', 3, 'Business interruption ', 'There is increased latency or a service outage that negatively impacts business operations.', 5, 7),
(8, 'R-BC-2', 3, 'Data loss / corruption ', 'There is a failure to maintain the confidentiality of the data (compromise) or data is corrupted (loss).', 5, 8),
(12, 'R-BC-3', 3, 'Reduction in productivity', 'User productivity is negatively affected by the incident.', 2, 12),
(13, 'R-EX-1', 4, 'Loss of revenue ', 'A financial loss occures from either a loss of clients or inability to generate future revenue.', 5, 13),
(14, 'R-EX-2', 4, 'Cancelled contract', 'A contract is cancelled due to a violation of a contract clause.', 5, 14),
(15, 'R-EX-3', 4, 'Diminished competitive advantage', 'The competitive advantage of the organization is jeapordized.', 5, 15),
(16, 'R-EX-4', 4, 'Diminished reputation ', 'Negative publicity tarnishes the organization\'s reputation.', 5, 16),
(17, 'R-EX-5', 4, 'Fines and judgements', 'Legal and/or financial damages result from statutory / regulatory / contractual non-compliance.', 5, 17),
(18, 'R-EX-6', 4, 'Unmitigated vulnerabilities', 'Umitigated technical vulnerabilities exist without compensating controls or other mitigation actions.', 2, 18),
(19, 'R-EX-7', 4, 'System compromise', 'System / application / service is compromised affects its confidentiality, integrity,  availability and/or safety.', 2, 19),
(20, 'R-BC-4', 3, 'Information loss / corruption or system compromise due to technical attack', 'Malware, phishing, hacking or other technical attacks compromise data, systems, applications or services.', 2, 20),
(21, 'R-BC-5', 3, 'Information loss / corruption or system compromise due to non‐technical attack ', 'Social engineering, sabotage or other non-technical attack compromises data, systems, applications or services.', 2, 21),
(22, 'R-GV-1', 5, 'Inability to support business processes', 'Implemented security /privacy practices are insufficient to support the organization\'s secure technologies & processes requirements.', 2, 1),
(24, 'R-GV-4', 5, 'Inadequate internal practices ', 'Internal practices do not exist or are inadequate. Procedures fail to meet \\\"reasonable practices\\\" expected by industry standards.', 2, 4),
(25, 'R-GV-5', 5, 'Inadequate third-party practices', 'Third-party practices do not exist or are inadequate. Procedures fail to meet \\\"reasonable practices\\\" expected by industry standards.', 2, 5),
(26, 'R-GV-3', 5, 'Lack of roles & responsibilities', 'Documented security / privacy roles & responsibilities do not exist or are inadequate.', 1, 3),
(27, 'R-GV-2', 5, 'Incorrect controls scoping', 'There is incorrect or inadequate controls scoping, which leads to a potential gap or lapse in security / privacy controls coverage.', 1, 2),
(28, 'R-GV-8', 5, 'Illegal content or abusive action', 'There is abusive content / harmful speech / threats of violence / illegal content that negatively affect business operations.', 1, 8),
(29, 'R-SA-1', 6, 'Inability to maintain situational awareness', 'There is an inability to detect incidents.', 3, 29),
(30, 'R-SA-2', 6, 'Lack of a security-minded workforce', 'The workforce lacks user-level understanding about security & privacy principles.', 2, 30),
(31, 'R-GV-6', 5, 'Lack of oversight of internal controls', 'There is a lack of due diligence / due care in overseeing the organization\'s internal security / privacy controls.', 1, 6),
(32, 'R-GV-7', 5, 'Lack of oversight of third-party controls', 'There is a lack of due diligence / due care in overseeing security / privacy controls operated by third-party service providers.', 1, 7),
(33, 'R-IR-1', 7, 'Inability to investigate / prosecute incidents', 'Response actions either corrupt evidence or impede the ability to prosecute incidents.', 4, 1),
(34, 'R-IR-2', 7, 'Improper response to incidents', 'Response actions fail to act appropriately in a timely manner to properly address the incident.', 4, 2),
(35, 'R-IR-3', 7, 'Ineffective remediation actions', 'There is no oversight to ensure remediation actions are correct and/or effective.', 2, 3),
(36, 'R-IR-4', 7, 'Expense associated with managing a loss event', 'There are financial repercussions from responding to an incident or loss.', 4, 4);

-- --------------------------------------------------------

--
-- Table structure for table `risk_functions`
--

CREATE TABLE `risk_functions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `risk_functions`
--

INSERT INTO `risk_functions` (`id`, `name`) VALUES
(1, 'Identify'),
(2, 'Protect'),
(3, 'Detect'),
(4, 'Respond'),
(5, 'Recover');

-- --------------------------------------------------------

--
-- Table structure for table `risk_groupings`
--

CREATE TABLE `risk_groupings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `risk_groupings`
--

INSERT INTO `risk_groupings` (`id`, `name`) VALUES
(1, 'Access Control'),
(2, 'Asset Management'),
(3, 'Business Continuity'),
(4, 'Exposure'),
(5, 'Governance'),
(6, 'Situational Awareness'),
(7, 'Incident Response');

-- --------------------------------------------------------

--
-- Table structure for table `risk_levels`
--

CREATE TABLE `risk_levels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `value` decimal(3,1) NOT NULL,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `review_level_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `risk_levels`
--

INSERT INTO `risk_levels` (`id`, `value`, `name`, `color`, `display_name`, `review_level_id`) VALUES
(1, '0.0', 'Low', '#12d943', 'Low', 2),
(2, '4.0', 'Medium', '#ffa500', 'Medium', 3),
(3, '7.0', 'High', '#e2451d', 'High', 4),
(4, '9.0', 'Very High', '#1d1b1b', 'Very High', 5);

-- --------------------------------------------------------

--
-- Table structure for table `risk_models`
--

CREATE TABLE `risk_models` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `risk_models`
--

INSERT INTO `risk_models` (`id`, `name`) VALUES
(1, 'Likelihood x Impact + 2(Impact)'),
(2, 'Likelihood x Impact + Impact'),
(3, 'Likelihood x Impact'),
(4, 'Likelihood x Impact + Likelihood'),
(5, 'Likelihood x Impact + 2(Likelihood)');

-- --------------------------------------------------------

--
-- Table structure for table `risk_scorings`
--

CREATE TABLE `risk_scorings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `scoring_method` int(11) NOT NULL,
  `calculated_risk` double(8,2) NOT NULL,
  `CLASSIC_likelihood` double(8,2) NOT NULL DEFAULT 5.00,
  `CLASSIC_impact` double(8,2) NOT NULL DEFAULT 5.00,
  `CVSS_AccessVector` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `CVSS_AccessComplexity` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'L',
  `CVSS_Authentication` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `CVSS_ConfImpact` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'C',
  `CVSS_IntegImpact` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'C',
  `CVSS_AvailImpact` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'C',
  `CVSS_Exploitability` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ND',
  `CVSS_RemediationLevel` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ND',
  `CVSS_ReportConfidence` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ND',
  `CVSS_CollateralDamagePotential` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ND',
  `CVSS_TargetDistribution` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ND',
  `CVSS_ConfidentialityRequirement` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ND',
  `CVSS_IntegrityRequirement` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ND',
  `CVSS_AvailabilityRequirement` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ND',
  `DREAD_DamagePotential` int(11) NOT NULL DEFAULT 10,
  `DREAD_Reproducibility` int(11) NOT NULL DEFAULT 10,
  `DREAD_Exploitability` int(11) NOT NULL DEFAULT 10,
  `DREAD_AffectedUsers` int(11) NOT NULL DEFAULT 10,
  `DREAD_Discoverability` int(11) NOT NULL DEFAULT 10,
  `OWASP_SkillLevel` int(11) NOT NULL DEFAULT 10,
  `OWASP_Motive` int(11) NOT NULL DEFAULT 10,
  `OWASP_Opportunity` int(11) NOT NULL DEFAULT 10,
  `OWASP_Size` int(11) NOT NULL DEFAULT 10,
  `OWASP_EaseOfDiscovery` int(11) NOT NULL DEFAULT 10,
  `OWASP_EaseOfExploit` int(11) NOT NULL DEFAULT 10,
  `OWASP_Awareness` int(11) NOT NULL DEFAULT 10,
  `OWASP_IntrusionDetection` int(11) NOT NULL DEFAULT 10,
  `OWASP_LossOfConfidentiality` int(11) NOT NULL DEFAULT 10,
  `OWASP_LossOfIntegrity` int(11) NOT NULL DEFAULT 10,
  `OWASP_LossOfAvailability` int(11) NOT NULL DEFAULT 10,
  `OWASP_LossOfAccountability` int(11) NOT NULL DEFAULT 10,
  `OWASP_FinancialDamage` int(11) NOT NULL DEFAULT 10,
  `OWASP_ReputationDamage` int(11) NOT NULL DEFAULT 10,
  `OWASP_NonCompliance` int(11) NOT NULL DEFAULT 10,
  `OWASP_PrivacyViolation` int(11) NOT NULL DEFAULT 10,
  `Custom` double(8,2) NOT NULL DEFAULT 10.00,
  `Contributing_Likelihood` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `risk_scorings`
--

INSERT INTO `risk_scorings` (`id`, `scoring_method`, `calculated_risk`, `CLASSIC_likelihood`, `CLASSIC_impact`, `CVSS_AccessVector`, `CVSS_AccessComplexity`, `CVSS_Authentication`, `CVSS_ConfImpact`, `CVSS_IntegImpact`, `CVSS_AvailImpact`, `CVSS_Exploitability`, `CVSS_RemediationLevel`, `CVSS_ReportConfidence`, `CVSS_CollateralDamagePotential`, `CVSS_TargetDistribution`, `CVSS_ConfidentialityRequirement`, `CVSS_IntegrityRequirement`, `CVSS_AvailabilityRequirement`, `DREAD_DamagePotential`, `DREAD_Reproducibility`, `DREAD_Exploitability`, `DREAD_AffectedUsers`, `DREAD_Discoverability`, `OWASP_SkillLevel`, `OWASP_Motive`, `OWASP_Opportunity`, `OWASP_Size`, `OWASP_EaseOfDiscovery`, `OWASP_EaseOfExploit`, `OWASP_Awareness`, `OWASP_IntrusionDetection`, `OWASP_LossOfConfidentiality`, `OWASP_LossOfIntegrity`, `OWASP_LossOfAvailability`, `OWASP_LossOfAccountability`, `OWASP_FinancialDamage`, `OWASP_ReputationDamage`, `OWASP_NonCompliance`, `OWASP_PrivacyViolation`, `Custom`, `Contributing_Likelihood`) VALUES
(1, 1, 1.20, 3.00, 1.00, 'N', 'L', 'N', 'C', 'C', 'C', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10.00, 0),
(2, 1, 1.20, 3.00, 1.00, 'N', 'L', 'N', 'C', 'C', 'C', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10.00, 0),
(3, 1, 1.20, 3.00, 1.00, 'N', 'L', 'N', 'C', 'C', 'C', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10.00, 0),
(4, 1, 1.20, 3.00, 1.00, 'N', 'L', 'N', 'C', 'C', 'C', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10.00, 0),
(5, 1, 1.20, 3.00, 1.00, 'N', 'L', 'N', 'C', 'C', 'C', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10.00, 0),
(6, 1, 1.20, 3.00, 1.00, 'N', 'L', 'N', 'C', 'C', 'C', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10.00, 0),
(7, 1, 1.20, 3.00, 1.00, 'N', 'L', 'N', 'C', 'C', 'C', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10.00, 0),
(8, 1, 1.20, 3.00, 1.00, 'N', 'L', 'N', 'C', 'C', 'C', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10.00, 0),
(9, 1, 1.20, 3.00, 1.00, 'N', 'L', 'N', 'C', 'C', 'C', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10.00, 0),
(10, 1, 1.20, 3.00, 1.00, 'N', 'L', 'N', 'C', 'C', 'C', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10.00, 0),
(11, 1, 1.20, 3.00, 1.00, 'N', 'L', 'N', 'C', 'C', 'C', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10.00, 0),
(12, 1, 1.20, 3.00, 1.00, 'N', 'L', 'N', 'C', 'C', 'C', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10.00, 0),
(13, 1, 1.20, 3.00, 1.00, 'N', 'L', 'N', 'C', 'C', 'C', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10.00, 0),
(14, 1, 1.20, 3.00, 1.00, 'N', 'L', 'N', 'C', 'C', 'C', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10.00, 0),
(15, 1, 1.20, 3.00, 1.00, 'N', 'L', 'N', 'C', 'C', 'C', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10.00, 0),
(16, 1, 1.20, 3.00, 1.00, 'N', 'L', 'N', 'C', 'C', 'C', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10.00, 0),
(17, 1, 1.20, 3.00, 1.00, 'N', 'L', 'N', 'C', 'C', 'C', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10.00, 0),
(18, 1, 1.20, 3.00, 1.00, 'N', 'L', 'N', 'C', 'C', 'C', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10.00, 0),
(19, 1, 1.20, 3.00, 1.00, 'N', 'L', 'N', 'C', 'C', 'C', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10.00, 0),
(20, 1, 1.20, 3.00, 1.00, 'N', 'L', 'N', 'C', 'C', 'C', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10.00, 0),
(21, 1, 0.40, 1.00, 1.00, 'N', 'L', 'N', 'C', 'C', 'C', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10.00, 0),
(22, 1, 1.60, 2.00, 2.00, 'N', 'L', 'N', 'C', 'C', 'C', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10.00, 0),
(23, 1, 3.60, 3.00, 3.00, 'N', 'L', 'N', 'C', 'C', 'C', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10.00, 0),
(24, 1, 6.40, 4.00, 4.00, 'N', 'L', 'N', 'C', 'C', 'C', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10.00, 0),
(25, 1, 10.00, 5.00, 5.00, 'N', 'L', 'N', 'C', 'C', 'C', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10.00, 0),
(26, 1, 10.00, 5.00, 5.00, 'N', 'L', 'N', 'C', 'C', 'C', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10.00, 0),
(27, 1, 3.20, 4.00, 2.00, 'N', 'L', 'N', 'C', 'C', 'C', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10.00, 0),
(28, 1, 3.60, 3.00, 3.00, 'N', 'L', 'N', 'C', 'C', 'C', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10.00, 0),
(30, 1, 2.40, 3.00, 2.00, 'N', 'L', 'N', 'C', 'C', 'C', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10.00, 0),
(31, 1, 4.80, 4.00, 3.00, 'N', 'L', 'N', 'C', 'C', 'C', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10.00, 0);

-- --------------------------------------------------------

--
-- Table structure for table `risk_scoring_contributing_impacts`
--

CREATE TABLE `risk_scoring_contributing_impacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `risk_scoring_id` bigint(20) UNSIGNED NOT NULL,
  `contributing_risk_id` bigint(20) UNSIGNED NOT NULL,
  `impact` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `risk_scoring_histories`
--

CREATE TABLE `risk_scoring_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `risk_id` bigint(20) UNSIGNED NOT NULL,
  `calculated_risk` double(8,2) NOT NULL,
  `last_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `risk_scoring_histories`
--

INSERT INTO `risk_scoring_histories` (`id`, `risk_id`, `calculated_risk`, `last_update`) VALUES
(1, 1, 1.20, '2023-07-05 12:42:46'),
(2, 2, 1.20, '2023-07-05 12:42:46'),
(3, 3, 1.20, '2023-07-05 12:42:46'),
(4, 4, 1.20, '2023-07-05 12:42:46'),
(5, 5, 1.20, '2023-07-05 12:42:46'),
(6, 6, 1.20, '2023-07-05 12:42:46'),
(7, 7, 1.20, '2023-07-05 12:42:46'),
(8, 8, 1.20, '2023-07-05 12:42:46'),
(9, 9, 1.20, '2023-07-05 12:42:46'),
(10, 10, 1.20, '2023-07-05 12:42:46'),
(11, 11, 1.20, '2023-07-05 12:42:46'),
(12, 12, 1.20, '2023-07-05 12:42:46'),
(13, 13, 1.20, '2023-07-05 12:42:46'),
(14, 14, 1.20, '2023-07-05 12:42:46'),
(15, 15, 1.20, '2023-07-05 12:42:46'),
(16, 16, 1.20, '2023-07-05 12:42:46'),
(17, 17, 1.20, '2023-07-05 12:42:46'),
(18, 18, 1.20, '2023-07-05 12:42:46'),
(19, 19, 1.20, '2023-07-05 12:42:46'),
(20, 20, 1.20, '2023-07-05 12:42:46'),
(21, 21, 0.40, '2023-07-05 12:42:46'),
(22, 22, 1.60, '2023-07-05 12:42:46'),
(23, 23, 3.60, '2023-07-05 12:42:46'),
(24, 24, 6.40, '2023-07-05 12:42:46'),
(25, 25, 10.00, '2023-07-05 12:42:46'),
(26, 26, 10.00, '2023-08-07 11:34:36'),
(27, 27, 3.20, '2023-08-21 18:34:23'),
(28, 28, 3.60, '2023-08-21 21:45:16'),
(30, 30, 2.40, '2023-08-21 22:39:19'),
(31, 31, 4.80, '2023-08-22 08:38:06');

-- --------------------------------------------------------

--
-- Table structure for table `risk_to_additional_stakeholders`
--

CREATE TABLE `risk_to_additional_stakeholders` (
  `risk_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `risk_to_additional_stakeholders`
--

INSERT INTO `risk_to_additional_stakeholders` (`risk_id`, `user_id`) VALUES
(27, 2),
(27, 3),
(30, 4),
(31, 2);

-- --------------------------------------------------------

--
-- Table structure for table `risk_to_locations`
--

CREATE TABLE `risk_to_locations` (
  `risk_id` bigint(20) UNSIGNED NOT NULL,
  `location_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `risk_to_locations`
--

INSERT INTO `risk_to_locations` (`risk_id`, `location_id`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 8),
(9, 9),
(10, 10),
(11, 11),
(12, 12),
(13, 13),
(14, 14),
(15, 15),
(16, 16),
(17, 17),
(18, 18),
(19, 19),
(20, 20),
(26, 2),
(27, 2),
(28, 3),
(31, 4);

-- --------------------------------------------------------

--
-- Table structure for table `risk_to_teams`
--

CREATE TABLE `risk_to_teams` (
  `risk_id` bigint(20) UNSIGNED NOT NULL,
  `team_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `risk_to_teams`
--

INSERT INTO `risk_to_teams` (`risk_id`, `team_id`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 8),
(9, 9),
(10, 10),
(11, 11),
(12, 12),
(13, 13),
(14, 14),
(15, 15),
(16, 16),
(17, 17),
(18, 18),
(19, 19),
(28, 1),
(30, 1);

-- --------------------------------------------------------

--
-- Table structure for table `risk_to_technologies`
--

CREATE TABLE `risk_to_technologies` (
  `risk_id` bigint(20) UNSIGNED NOT NULL,
  `technology_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `risk_to_technologies`
--

INSERT INTO `risk_to_technologies` (`risk_id`, `technology_id`) VALUES
(1, 17),
(2, 2),
(3, 17),
(4, 5),
(5, 8),
(6, 18),
(7, 14),
(8, 17),
(9, 10),
(10, 9),
(12, 3),
(14, 14),
(15, 19),
(16, 9),
(17, 17),
(18, 9),
(19, 2),
(20, 14),
(27, 4),
(30, 3),
(31, 4);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'Administrator'),
(2, 'Employee');

-- --------------------------------------------------------

--
-- Table structure for table `role_responsibilities`
--

CREATE TABLE `role_responsibilities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_responsibilities`
--

INSERT INTO `role_responsibilities` (`id`, `role_id`, `permission_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 7),
(8, 1, 8),
(9, 1, 9),
(10, 1, 10),
(11, 1, 11),
(12, 1, 12),
(13, 1, 13),
(14, 1, 14),
(15, 1, 15),
(16, 1, 16),
(17, 1, 17),
(18, 1, 18),
(19, 1, 19),
(20, 1, 20),
(21, 1, 21),
(22, 1, 22),
(23, 1, 23),
(24, 1, 24),
(25, 1, 25),
(26, 1, 26),
(27, 1, 27),
(28, 1, 28),
(29, 1, 29),
(30, 1, 30),
(31, 1, 31),
(32, 1, 32),
(33, 1, 33),
(34, 1, 34),
(35, 1, 35),
(36, 1, 36),
(37, 1, 37),
(38, 1, 38),
(39, 1, 39),
(40, 1, 40),
(41, 1, 41),
(42, 1, 42),
(43, 1, 43),
(44, 1, 44),
(45, 1, 45),
(46, 1, 46),
(47, 1, 47),
(48, 1, 48),
(49, 1, 49),
(50, 1, 50),
(51, 1, 51),
(52, 1, 52),
(53, 1, 53),
(54, 1, 54),
(55, 1, 55),
(56, 1, 56),
(57, 1, 57),
(58, 1, 58),
(59, 1, 59),
(60, 1, 60),
(61, 1, 61),
(62, 1, 62),
(63, 1, 63),
(64, 1, 64),
(65, 1, 65),
(66, 1, 66),
(67, 1, 67),
(68, 1, 68),
(69, 1, 69),
(70, 1, 70),
(71, 1, 71),
(72, 1, 72),
(73, 1, 73),
(74, 1, 74),
(75, 1, 75),
(76, 1, 76),
(77, 1, 77),
(78, 1, 78),
(79, 1, 79),
(80, 1, 80),
(81, 1, 81),
(82, 1, 82),
(83, 1, 83),
(84, 1, 84),
(85, 1, 85),
(86, 1, 86),
(87, 1, 87),
(88, 1, 88),
(89, 1, 89),
(90, 1, 90),
(91, 1, 91),
(92, 1, 92),
(93, 1, 93),
(94, 1, 94),
(95, 1, 95),
(96, 1, 96),
(97, 1, 97),
(98, 1, 98),
(99, 1, 99),
(100, 1, 100),
(101, 1, 101),
(102, 1, 102),
(103, 1, 103),
(104, 1, 104),
(105, 1, 105),
(106, 1, 106),
(107, 1, 107),
(108, 1, 108),
(109, 1, 109),
(110, 1, 110),
(111, 1, 111),
(112, 1, 112),
(113, 1, 113),
(114, 1, 114),
(115, 1, 115),
(116, 1, 116),
(117, 1, 117),
(118, 1, 118),
(119, 1, 119),
(120, 1, 120),
(121, 1, 121),
(122, 1, 122),
(123, 1, 123),
(124, 1, 124),
(125, 1, 125),
(126, 1, 126),
(127, 1, 127),
(128, 1, 128),
(129, 1, 129),
(130, 1, 130),
(131, 1, 131),
(132, 1, 132),
(133, 1, 133),
(134, 1, 134),
(135, 1, 135),
(136, 1, 136),
(137, 1, 137),
(138, 1, 138),
(139, 1, 139),
(140, 1, 140),
(141, 1, 141),
(142, 1, 142),
(143, 1, 143),
(144, 1, 144),
(145, 1, 145),
(146, 1, 146),
(147, 1, 147),
(148, 1, 148),
(149, 1, 149),
(150, 1, 150),
(151, 1, 151),
(152, 1, 152),
(153, 1, 153),
(154, 1, 154),
(155, 1, 155),
(156, 1, 156),
(157, 1, 157),
(158, 1, 158),
(159, 1, 159),
(160, 1, 160),
(161, 1, 161),
(162, 1, 162),
(163, 1, 163),
(164, 1, 164),
(165, 1, 165),
(205, 2, 1),
(206, 2, 2),
(207, 2, 8),
(208, 2, 9),
(209, 2, 15),
(210, 2, 88),
(212, 2, 19),
(213, 2, 20),
(214, 2, 78),
(215, 2, 79),
(216, 2, 80),
(217, 2, 28),
(218, 2, 29),
(219, 2, 30),
(220, 2, 31),
(221, 2, 32),
(222, 2, 33),
(223, 2, 34),
(224, 2, 35),
(229, 2, 81),
(230, 2, 82),
(231, 2, 83),
(236, 2, 40),
(237, 2, 41),
(243, 2, 47),
(244, 2, 48),
(245, 2, 49),
(246, 2, 50),
(247, 2, 51),
(248, 2, 52),
(250, 2, 54),
(251, 2, 55),
(252, 2, 56),
(253, 2, 57),
(254, 2, 58),
(255, 2, 59),
(256, 2, 60),
(257, 2, 95),
(258, 2, 96),
(259, 2, 97),
(260, 2, 98),
(261, 2, 99),
(262, 2, 100),
(263, 2, 101),
(264, 2, 102),
(265, 2, 103),
(266, 2, 104),
(267, 2, 105),
(268, 2, 106),
(269, 2, 107),
(270, 2, 108),
(271, 2, 109),
(272, 2, 110),
(273, 2, 111),
(274, 2, 112),
(275, 2, 113),
(276, 2, 114),
(277, 2, 115),
(278, 2, 116),
(279, 2, 117),
(280, 2, 118),
(281, 2, 119),
(282, 2, 120),
(283, 2, 121),
(284, 2, 136),
(285, 2, 144),
(286, 2, 145),
(287, 2, 148),
(288, 2, 159),
(289, 2, 160),
(290, 2, 161),
(291, 2, 162),
(292, 2, 163),
(293, 2, 164),
(294, 2, 165),
(295, 2, 61),
(296, 2, 62),
(297, 2, 63),
(298, 2, 64),
(299, 2, 65),
(300, 2, 66),
(301, 2, 67),
(302, 2, 68),
(303, 2, 69),
(304, 2, 70),
(305, 2, 71),
(306, 2, 72),
(307, 2, 73),
(308, 2, 74),
(309, 2, 75),
(310, 2, 76),
(311, 2, 77),
(312, 2, 122),
(313, 2, 123),
(314, 2, 124),
(315, 2, 125),
(316, 2, 126),
(317, 2, 127),
(318, 2, 128),
(319, 2, 129),
(320, 2, 130),
(321, 2, 131),
(322, 2, 132),
(323, 2, 133),
(324, 2, 134),
(325, 2, 135),
(326, 2, 137),
(327, 2, 138),
(328, 2, 139),
(329, 2, 140),
(330, 2, 141),
(331, 2, 142),
(332, 2, 143),
(333, 2, 146),
(334, 2, 147),
(335, 2, 149),
(336, 2, 150),
(337, 2, 151),
(338, 2, 152),
(339, 2, 153),
(340, 2, 154),
(341, 2, 155),
(342, 2, 156),
(343, 2, 157),
(344, 2, 158);

-- --------------------------------------------------------

--
-- Table structure for table `scoring_methods`
--

CREATE TABLE `scoring_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `scoring_methods`
--

INSERT INTO `scoring_methods` (`id`, `name`) VALUES
(1, 'Classic');

-- --------------------------------------------------------

--
-- Table structure for table `security_awarenesses`
--

CREATE TABLE `security_awarenesses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `team_ids` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `additional_stakeholders` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `privacy` bigint(20) UNSIGNED DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '[1 => Draft],[2=> InReview, [3 => Approved]',
  `file_id` bigint(20) UNSIGNED DEFAULT NULL,
  `last_review_date` date DEFAULT NULL,
  `review_frequency` int(11) DEFAULT NULL,
  `next_review_date` date DEFAULT NULL,
  `approval_date` date DEFAULT NULL,
  `owner` bigint(20) UNSIGNED NOT NULL,
  `reviewer` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `opened` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `security_awarenesses`
--

INSERT INTO `security_awarenesses` (`id`, `title`, `description`, `team_ids`, `additional_stakeholders`, `privacy`, `status`, `file_id`, `last_review_date`, `review_frequency`, `next_review_date`, `approval_date`, `owner`, `reviewer`, `created_by`, `opened`, `created_at`, `updated_at`) VALUES
(1, 'Phishing mail', 'dsf', '1', '6', NULL, 1, 1, '2023-07-05', 10, '2023-07-15', NULL, 6, NULL, 1, 1, '2023-07-05 14:14:45', '2023-07-05 14:14:45'),
(2, 'test', '333', '', '', 2, 3, 2, '2023-07-05', 4, '2023-07-09', '2023-07-06', 1, NULL, 1, 1, '2023-07-05 14:17:44', '2023-07-05 14:19:00'),
(3, 'mail ph', 'test', '', '', NULL, 1, 3, '2023-07-13', 50, '2023-09-01', NULL, 1, NULL, 1, 1, '2023-07-13 14:15:34', '2023-07-13 14:15:34'),
(4, 'thearts', 'threats awarness', '2', '38', 2, 3, 4, '2023-07-17', 90, '2023-10-15', '2023-07-17', 1, NULL, 1, 0, '2023-07-17 12:38:11', '2023-07-17 12:41:01'),
(5, 'test2', 'dd', '', '3', 2, 3, 5, '2023-08-06', 0, '2023-08-06', '2023-08-08', 1, NULL, 2, 1, '2023-08-08 16:31:18', '2023-08-08 16:36:15'),
(6, 'dddd', 'aaaaaaa', '1', '3', NULL, 1, 6, '2023-08-04', 0, '2023-08-04', NULL, 1, NULL, 2, 1, '2023-08-09 10:19:15', '2023-08-09 10:19:15'),
(7, 'test13', 'sss', '1', '3', NULL, 1, 7, '2023-08-09', 0, '2023-08-09', NULL, 1, NULL, 2, 1, '2023-08-09 10:57:26', '2023-08-09 10:57:26'),
(8, 'test7', 'z', '1', '6,7', 1, 2, 8, '2023-08-21', 2, '2023-08-23', NULL, 3, 1, 2, 1, '2023-08-20 17:39:56', '2023-08-20 17:43:03'),
(9, 'test89', 'e', '1', '6', 2, 3, 9, '2023-08-21', 2, '2023-08-23', '2023-08-17', 2, NULL, 3, 0, '2023-08-20 17:44:48', '2023-08-20 17:44:48'),
(10, 'test8', 'ff', '1', '6', 2, 3, 10, '2023-08-21', 2, '2023-08-23', '2023-08-23', 2, NULL, 3, 1, '2023-08-20 17:46:10', '2023-08-20 17:46:11'),
(11, 'Testing4', 'ads', '', '3', 2, 3, 25, '2023-08-23', 2, '2023-08-25', '2023-08-22', 2, 4, 1, 1, '2023-08-22 09:16:14', '2023-08-22 09:37:43');

-- --------------------------------------------------------

--
-- Table structure for table `security_awareness_exams`
--

CREATE TABLE `security_awareness_exams` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `security_awareness_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `security_awareness_exams`
--

INSERT INTO `security_awareness_exams` (`id`, `security_awareness_id`) VALUES
(1, 2),
(2, 4),
(3, 5),
(4, 7),
(5, 11);

-- --------------------------------------------------------

--
-- Table structure for table `security_awareness_exam_answers`
--

CREATE TABLE `security_awareness_exam_answers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `security_awareness_exams_id` bigint(20) UNSIGNED NOT NULL,
  `examinee` bigint(20) UNSIGNED DEFAULT NULL,
  `success_answers` tinyint(4) NOT NULL,
  `fail_answers` tinyint(4) NOT NULL,
  `uniqid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `security_awareness_exam_answers`
--

INSERT INTO `security_awareness_exam_answers` (`id`, `security_awareness_exams_id`, `examinee`, `success_answers`, `fail_answers`, `uniqid`, `created_at`) VALUES
(1, 1, 3, 0, 1, NULL, '2023-07-17 09:45:00'),
(2, 3, 2, 0, 2, NULL, '2023-08-08 13:37:12'),
(3, 1, 2, 0, 1, '64d24765a32c9', '2023-08-08 13:47:17'),
(4, 5, 6, 2, 0, NULL, '2023-08-22 06:38:07'),
(5, 5, 3, 1, 1, NULL, '2023-08-22 06:43:41');

-- --------------------------------------------------------

--
-- Table structure for table `security_awareness_exam_questions`
--

CREATE TABLE `security_awareness_exam_questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `security_awareness_exams_id` bigint(20) UNSIGNED NOT NULL,
  `question` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_a` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_b` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_c` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_d` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_e` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` enum('A','B','C','D','E') COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `security_awareness_exam_questions`
--

INSERT INTO `security_awareness_exam_questions` (`id`, `security_awareness_exams_id`, `question`, `option_a`, `option_b`, `option_c`, `option_d`, `option_e`, `answer`) VALUES
(1, 1, 'test for trial', 'TEST1', 'A', 'B', 'C', 'T', 'A'),
(2, 2, 'test for test', 'got it', 'understand', 'c', 'd', 'e', 'B'),
(3, 3, 'what is your name', 'asd', 'sad', 'dd', 'fff', 'wwww', 'C'),
(4, 3, 'wwww?', '1', '3', '2', '4', '6', 'C'),
(5, 4, 'what is your name', 'mohamed', 'ahme', 'dmosatafa', 'mau', 'cmj', 'B'),
(6, 4, 'whatis your job', 'dd', 'ff', 'gg', 'hhj', 'kkk', 'B'),
(7, 5, 'Exam One ?', '5', '2', '10', '20', '3', 'C'),
(8, 5, 'Exam Two ?', '4', '5', '12', '45', '10', 'E');

-- --------------------------------------------------------

--
-- Table structure for table `security_awareness_notes`
--

CREATE TABLE `security_awareness_notes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `security_awareness_id` bigint(20) UNSIGNED NOT NULL,
  `note` tinytext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `security_awareness_notes`
--

INSERT INTO `security_awareness_notes` (`id`, `user_id`, `security_awareness_id`, `note`, `created_at`) VALUES
(1, 1, 4, 'all has done', '2023-07-17 09:40:14'),
(2, 1, 4, 'need to review again', '2023-07-17 09:40:47');

-- --------------------------------------------------------

--
-- Table structure for table `security_awareness_note_files`
--

CREATE TABLE `security_awareness_note_files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `security_awareness_id` bigint(20) UNSIGNED NOT NULL,
  `display_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unique_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service_descriptions`
--

CREATE TABLE `service_descriptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `route` varchar(350) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key` varchar(350) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_key` varchar(350) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_descriptions`
--

INSERT INTO `service_descriptions` (`id`, `route`, `key`, `name_key`, `description`) VALUES
(1, 'admin.governance.index', 'admin_governance_index', 'Define Control Frameworks', NULL),
(2, 'admin.governance.control.list', 'admin_governance_control_list', 'Define Controls', NULL),
(3, 'admin.governance.category', 'admin_governance_category', 'Documentation', NULL),
(4, 'admin.risk_management.index', 'admin_risk_management_index', 'Navbar Risk Management', NULL),
(5, 'admin.compliance.audit.index', 'admin_compliance_audit_index', 'Active Audits', NULL),
(6, 'admin.compliance.past-audits', 'admin_compliance_past-audits', 'Past Audits', NULL),
(7, 'admin.asset_management.index', 'admin_asset_management_index', 'Assets', NULL),
(8, 'admin.asset_management.asset_group.index', 'admin_asset_management_asset_group_index', 'AssetGroups', NULL),
(9, 'admin.reporting.overviewReport', 'admin_reporting_overviewReport', 'Overview', NULL),
(10, 'admin.reporting.riskDashboardReport', 'admin_reporting_riskDashboardReport', 'Risk Dashboard', NULL),
(11, 'admin.reporting.controlGapAnalysis', 'admin_reporting_controlGapAnalysis', 'Control Gap Analysis', NULL),
(12, 'admin.reporting.likelhoodImpactReport', 'admin_reporting_likelhoodImpactReport', 'Likelihood And Impact', NULL),
(13, 'admin.reporting.MyopenRiskReport', 'admin_reporting_MyopenRiskReport', 'All Open Risks Assigned to Me', NULL),
(14, 'admin.reporting.dynamicRiskReport', 'admin_reporting_dynamicRiskReport', 'Dynamic Risk Report', NULL),
(15, 'admin.reporting.GetRiskByControl', 'admin_reporting_GetRiskByControl', 'Risks and Controls', NULL),
(16, 'admin.reporting.GetRiskByAsset', 'admin_reporting_GetRiskByAsset', 'Risks and Assets', NULL),
(17, 'admin.reporting.framewrok_control_compliance_status', 'admin_reporting_framewrok_control_compliance_status', 'framewrok_control_compliance_status', NULL),
(18, 'admin.reporting.summary_of_results_for_evaluation_and_compliance', 'admin_reporting_summary_of_results_for_evaluation_and_compliance', 'summary_of_results_for_evaluation_and_compliance', NULL),
(19, 'admin.reporting.security_awareness_exam', 'admin_reporting_security_awareness_exam', 'SecurityAwarenessExam', NULL),
(20, 'admin.configure.user.index', 'admin_configure_user_index', 'Navbar User Management', NULL),
(21, 'admin.configure.add_values', 'admin_configure_add_values', 'Add and Remove Values', NULL),
(22, 'admin.configure.roles.index', 'admin_configure_roles_index', 'Navbar Role Management', NULL),
(23, 'admin.configure.riskmodels.show', 'admin_configure_riskmodels_show', 'ClassicRiskFormula', NULL),
(24, 'admin.configure.logs.index', 'admin_configure_logs_index', 'Audit Trail', NULL),
(25, 'admin.configure.import.index', 'admin_configure_import_index', 'Import/Export', NULL),
(26, 'admin.configure.extras.LDAP-Configuration', 'admin_configure_extras_LDAP-Configuration', 'LDAP Authentication', NULL),
(27, 'admin.configure.about.edit', 'admin_configure_about_edit', 'About', NULL),
(28, 'admin.configure.general_setting.edit', 'admin_configure_general_setting_edit', 'GeneralSettings', NULL),
(29, 'admin.configure.service_description.edit', 'admin_configure_service_description_edit', 'ServicesDescription', NULL),
(30, 'admin.configure.change_request_department.edit', 'admin_configure_change_request_department_edit', 'ChangeRequestsResponsibleDepartment', NULL),
(31, 'admin.hierarchy.index', 'admin_hierarchy_index', 'Hierarchy', NULL),
(32, 'admin.hierarchy.org_chart', 'admin_hierarchy_org_chart', 'Organization Chart', NULL),
(33, 'admin.hierarchy.department.index', 'admin_hierarchy_department_index', 'Department', NULL),
(34, 'admin.hierarchy.job.index', 'admin_hierarchy_job_index', 'Job', NULL),
(35, 'admin.task.index', 'admin_task_index', 'CreatedTasks', NULL),
(36, 'admin.task.assigned_to_me', 'admin_task_assigned_to_me', 'MyTasks', NULL),
(37, 'admin.vulnerability_management.index', 'admin_vulnerability_management_index', 'Navbar Vulnerability Management', NULL),
(38, 'admin.change_request.index', 'admin_change_request_index', 'ChangeRequest', NULL),
(39, 'admin.KPI.index', 'admin_KPI_index', 'KPI', NULL),
(40, 'admin.security_awareness.index', 'admin_security_awareness_index', 'SecurityAwareness', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access` int(10) UNSIGNED DEFAULT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `value` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`) VALUES
(1, 'alert_timeout', '5'),
(2, 'allow_ownermanager_to_risk', '1'),
(3, 'allow_owner_to_risk', '1'),
(4, 'allow_stakeholder_to_risk', '1'),
(5, 'allow_submitter_to_risk', '1'),
(6, 'allow_team_member_to_risk', '1'),
(7, 'auto_verify_new_assets', '0'),
(8, 'backup_auto', 'true'),
(9, 'backup_remove', '1'),
(10, 'backup_schedule', 'daily'),
(11, 'bootstrap_delivery_method', 'cdn'),
(12, 'closed_audit_status', '5'),
(13, 'content_security_policy', '0'),
(14, 'currency', '$'),
(15, 'db_version', '20211115-001'),
(16, 'debug_logging', '0'),
(17, 'debug_log_file', '/tmp/debug_log'),
(18, 'default_asset_valuation', '5'),
(19, 'default_current_maturity', '0'),
(20, 'default_date_format', 'MM/DD/YYYY'),
(21, 'default_desired_maturity', '3'),
(22, 'default_language', 'en'),
(23, 'default_risk_score', '10'),
(24, 'default_timezone', 'Asia/Riyadh'),
(25, 'highcharts_delivery_method', 'cdn'),
(26, 'instance_id', 'WtrZ7UYyt7XdoRsTKftzHI9uv5mdXFKPCRcZf83ZoUYRu0pxXZ'),
(27, 'jquery_delivery_method', 'cdn'),
(28, 'maximum_risk_subject_length', '300'),
(29, 'max_upload_size', '5120000'),
(30, 'next_review_date_uses', 'InherentRisk'),
(31, 'NOTIFY_ADDITIONAL_STAKEHOLDERS', 'true'),
(32, 'pass_policy_alpha_required', '1'),
(33, 'pass_policy_attempt_lockout', '0'),
(34, 'pass_policy_attempt_lockout_time', '10'),
(35, 'pass_policy_digits_required', '1'),
(36, 'pass_policy_enabled', '1'),
(37, 'pass_policy_lower_required', '1'),
(38, 'pass_policy_max_age', '0'),
(39, 'pass_policy_min_age', '0'),
(40, 'pass_policy_min_chars', '8'),
(41, 'pass_policy_reuse_limit', '0'),
(42, 'pass_policy_re_use_tracking', '0'),
(43, 'pass_policy_special_required', '1'),
(44, 'pass_policy_upper_required', '1'),
(45, 'phpmailer_from_email', 'noreply@simplerisk.it'),
(46, 'phpmailer_from_name', 'SimpleRisk'),
(47, 'phpmailer_host', 'smtp1.example.com'),
(48, 'phpmailer_password', 'secret'),
(49, 'phpmailer_port', '587'),
(50, 'phpmailer_prepend', '[SIMPLERISK]'),
(51, 'phpmailer_replyto_email', 'noreply@simplerisk.it'),
(52, 'phpmailer_replyto_name', 'SimpleRisk'),
(53, 'phpmailer_smtpauth', 'false'),
(54, 'phpmailer_smtpautotls', 'true'),
(55, 'phpmailer_smtpsecure', 'none'),
(56, 'phpmailer_transport', 'sendmail'),
(57, 'phpmailer_username', 'user@example.com'),
(58, 'plan_projects_show_all', '0'),
(59, 'registration_registered', '0'),
(60, 'risk_appetite', '0'),
(61, 'risk_mapping_required', '0'),
(62, 'risk_model', '3'),
(63, 'session_absolute_timeout', '28800'),
(64, 'session_activity_timeout', '3600'),
(65, 'simplerisk_base_url', 'http://localhost:8000'),
(66, 'strict_user_validation', '1'),
(67, 'LDAP_DEFAULT_HOSTS', 'www.zflexldap.com'),
(68, 'LDAP_DEFAULT_PORT', '389'),
(69, 'LDAP_DEFAULT_BASE_DN', 'dc=zflexsoftware,dc=com'),
(70, 'LDAP_DEFAULT_USERNAME', 'cn=ro_admin,ou=sysadmins,dc=zflexsoftware,dc=com'),
(71, 'LDAP_USER_FLITER', ''),
(72, 'LDAP_DEFAULT_PASSWORD', 'zflexpass'),
(73, 'LDAP_DEFAULT_SSL', 'false'),
(74, 'LDAP_DEFAULT_TLS', 'false'),
(75, 'LDAP_DEFAULT_VSERSION', '3'),
(76, 'LDAP_DEFAULT_TIMEOUT', '5'),
(77, 'LDAP_DEFAULT_Follow', 'false'),
(78, 'LDAP_name', ''),
(79, 'LDAP_email', ''),
(80, 'LDAP_username', ''),
(81, 'LDAP_password', ''),
(82, 'LDAP_dapartment', ''),
(83, 'APP_NAME', 'Cyber Mode'),
(84, 'APP_AUTHOR_EN', 'Cyber Mode'),
(85, 'APP_AUTHOR_AR', 'Cyber Mode'),
(86, 'APP_AUTHOR_ABBR_EN', 'Cyber Mode'),
(87, 'APP_AUTHOR_ABBR_AR', 'Cyber Mode'),
(88, 'APP_AUTHOR_WEBSITE', 'https://www.dsshield.com'),
(89, 'APP_OWNER_EN', 'Cyber Mode'),
(90, 'APP_OWNER_AR', 'اسس الحماية الرقمية'),
(91, 'APP_LOGO', 'images/logo/1667651514.png'),
(92, 'APP_FAVICON', 'images/ico/favicon.ico'),
(93, 'change_requests_responsible_department_id', '1');

-- --------------------------------------------------------

--
-- Table structure for table `sms_settings`
--

CREATE TABLE `sms_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `action_id` bigint(20) UNSIGNED NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sources`
--

CREATE TABLE `sources` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sources`
--

INSERT INTO `sources` (`id`, `name`) VALUES
(1, 'People'),
(2, 'Process'),
(3, 'System'),
(4, 'External');

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

CREATE TABLE `statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `statuses`
--

INSERT INTO `statuses` (`id`, `name`) VALUES
(1, 'New'),
(2, 'Mitigation Planned'),
(3, 'Mgmt Reviewed'),
(4, 'Closed'),
(5, 'Reopened'),
(6, 'Untreated'),
(7, 'Treated');

-- --------------------------------------------------------

--
-- Table structure for table `subgroups`
--

CREATE TABLE `subgroups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permission_group_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subgroups`
--

INSERT INTO `subgroups` (`id`, `name`, `permission_group_id`, `created_at`, `updated_at`) VALUES
(1, 'Frameworks', 1, '2023-07-05 12:42:42', '2023-07-05 12:42:42'),
(2, 'Controls', 1, '2023-07-05 12:42:42', '2023-07-05 12:42:42'),
(3, 'Document', 1, '2023-07-05 12:42:42', '2023-07-05 12:42:42'),
(4, 'Exception', 1, '2023-07-05 12:42:42', '2023-07-05 12:42:42'),
(5, 'Risks', 2, '2023-07-05 12:42:42', '2023-07-05 12:42:42'),
(6, 'Projects', 2, '2023-07-05 12:42:42', '2023-07-05 12:42:42'),
(7, 'Compliance', 3, '2023-07-05 12:42:42', '2023-07-05 12:42:42'),
(8, 'Tests', 3, '2023-07-05 12:42:42', '2023-07-05 12:42:42'),
(9, 'Audits', 3, '2023-07-05 12:42:42', '2023-07-05 12:42:42'),
(10, 'Assets', 4, '2023-07-05 12:42:42', '2023-07-05 12:42:42'),
(11, 'Assessments', 5, '2023-07-05 12:42:42', '2023-07-05 12:42:42'),
(12, 'RoleManagement', 6, '2023-07-05 12:42:42', '2023-07-05 12:42:42'),
(13, 'Add Values', 6, '2023-07-05 12:42:42', '2023-07-05 12:42:42'),
(14, 'Audit Logs', 6, '2023-07-05 12:42:42', '2023-07-05 12:42:42'),
(15, 'Hierarchy', 7, '2023-07-05 12:42:42', '2023-07-05 12:42:42'),
(16, 'Department', 7, '2023-07-05 12:42:42', '2023-07-05 12:42:42'),
(17, 'Job', 7, '2023-07-05 12:42:42', '2023-07-05 12:42:42'),
(18, 'Employee', 7, '2023-07-05 12:42:42', '2023-07-05 12:42:42'),
(19, 'Plan Mitigation', 2, '2023-07-05 12:42:42', '2023-07-05 12:42:42'),
(20, 'Perform Reviews', 2, '2023-07-05 12:42:42', '2023-07-05 12:42:42'),
(21, 'AssetGroups', 4, '2023-07-05 12:42:42', '2023-07-05 12:42:42'),
(22, 'Categories', 1, '2023-07-05 12:42:42', '2023-07-05 12:42:42'),
(23, 'User Management', 6, '2023-07-05 12:42:42', '2023-07-05 12:42:42'),
(24, 'Settings', 6, '2023-07-05 12:42:42', '2023-07-05 12:42:42'),
(25, 'ClassicRiskFormula', 6, '2023-07-05 12:42:42', '2023-07-05 12:42:42'),
(26, 'Import And Export', 6, '2023-07-05 12:42:42', '2023-07-05 12:42:42'),
(27, 'LDAP', 6, '2023-07-05 12:42:42', '2023-07-05 12:42:42'),
(28, 'Reporting', 8, '2023-07-05 12:42:42', '2023-07-05 12:42:42'),
(29, 'Task', 9, '2023-07-05 12:42:42', '2023-07-05 12:42:42'),
(30, 'About', 6, '2023-07-05 12:42:42', '2023-07-05 12:42:42'),
(31, 'Vulnerability Management', 10, '2023-07-05 12:42:42', '2023-07-05 12:42:42'),
(32, 'General Setting', 6, '2023-07-05 12:42:42', '2023-07-05 12:42:42'),
(33, 'Services Description', 6, '2023-07-05 12:42:42', '2023-07-05 12:42:42'),
(34, 'Change Request', 11, '2023-07-05 12:42:42', '2023-07-05 12:42:42'),
(35, 'Change Request Department', 6, '2023-07-05 12:42:42', '2023-07-05 12:42:42'),
(36, 'KPI', 12, '2023-07-05 12:42:42', '2023-07-05 12:42:42'),
(37, 'Security Awareness', 13, '2023-07-05 12:42:42', '2023-07-05 12:42:42'),
(38, 'Domain', 6, '2023-07-05 12:42:42', '2023-07-05 12:42:42');

-- --------------------------------------------------------

--
-- Table structure for table `system_notifications_settings`
--

CREATE TABLE `system_notifications_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `action_id` bigint(20) UNSIGNED NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `system_notifications_settings`
--

INSERT INTO `system_notifications_settings` (`id`, `action_id`, `message`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'hi {cve}\r\nThis is a new Vul .. please check this out', 1, '2023-08-20 17:36:24', '2023-08-21 18:29:14'),
(2, 3, 'Hell{cve}', 1, '2023-08-21 22:22:32', '2023-08-21 22:22:48');

-- --------------------------------------------------------

--
-- Table structure for table `taggables`
--

CREATE TABLE `taggables` (
  `tag_id` bigint(20) UNSIGNED NOT NULL,
  `taggable_id` bigint(20) UNSIGNED NOT NULL,
  `taggable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tag` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `tag`) VALUES
(1, 'Tag 1'),
(10, 'Tag 10'),
(2, 'Tag 2'),
(3, 'Tag 3'),
(4, 'Tag 4'),
(5, 'Tag 5'),
(6, 'Tag 6'),
(7, 'Tag 7'),
(8, 'Tag 8'),
(9, 'Tag 9');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `priority` enum('Urgent','High','Normal','Low','No Priority') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Open','In Progress','Completed','Accepted','Closed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Open',
  `start_date` date NOT NULL,
  `due_date` date NOT NULL,
  `completed_date` timestamp NULL DEFAULT NULL,
  `accepted_date` timestamp NULL DEFAULT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT 0,
  `assignable_id` bigint(20) UNSIGNED NOT NULL,
  `assignable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `action_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `title`, `description`, `priority`, `status`, `start_date`, `due_date`, `completed_date`, `accepted_date`, `completed`, `assignable_id`, `assignable_type`, `created_by`, `action_by`, `created_at`, `updated_at`) VALUES
(1, 'title 1', 'description 1', 'No Priority', 'Open', '2022-06-01', '2022-06-02', NULL, NULL, 1, 1, 'App\\Models\\User', 1, NULL, '2023-07-05 12:42:51', '2023-07-05 12:42:51'),
(2, 'title 2', 'description 2', 'Low', 'Open', '2022-06-02', '2022-06-04', NULL, NULL, 0, 1, 'App\\Models\\User', 1, NULL, '2023-07-05 12:42:51', '2023-07-05 12:42:51'),
(3, 'title 3', 'description 3', 'Normal', 'Open', '2022-06-03', '2022-06-06', NULL, NULL, 1, 1, 'App\\Models\\Team', 1, NULL, '2023-07-05 12:42:51', '2023-07-05 12:42:51'),
(4, 'title 4', 'description 4', 'High', 'Open', '2022-06-04', '2022-06-08', NULL, NULL, 0, 1, 'App\\Models\\User', 1, NULL, '2023-07-05 12:42:51', '2023-07-05 12:42:51'),
(5, 'title 5', 'description 5', 'Urgent', 'Open', '2022-06-05', '2022-06-10', NULL, NULL, 1, 1, 'App\\Models\\User', 1, NULL, '2023-07-05 12:42:51', '2023-07-05 12:42:51'),
(6, 'title 6', 'description 6', 'No Priority', 'Open', '2022-06-06', '2022-06-12', NULL, NULL, 0, 1, 'App\\Models\\Team', 1, NULL, '2023-07-05 12:42:51', '2023-07-05 12:42:51'),
(7, 'title 7', 'description 7', 'Low', 'Open', '2022-06-07', '2022-06-14', NULL, NULL, 1, 1, 'App\\Models\\User', 1, NULL, '2023-07-05 12:42:51', '2023-07-05 12:42:51'),
(8, 'title 8', 'description 8', 'Normal', 'Open', '2022-06-08', '2022-06-16', NULL, NULL, 0, 1, 'App\\Models\\User', 1, NULL, '2023-07-05 12:42:51', '2023-07-05 12:42:51'),
(9, 'title 9', 'description 9', 'High', 'Open', '2022-06-09', '2022-06-18', NULL, NULL, 1, 1, 'App\\Models\\Team', 1, NULL, '2023-07-05 12:42:51', '2023-07-05 12:42:51'),
(10, 'title 10', 'description 10', 'Urgent', 'Open', '2022-06-10', '2022-06-20', NULL, NULL, 0, 1, 'App\\Models\\User', 1, NULL, '2023-07-05 12:42:51', '2023-07-05 12:42:51'),
(11, 'to do somthing', '<p>fsdafsa</p>', 'High', 'Open', '2023-08-10', '2023-08-14', NULL, NULL, 0, 17, 'App\\Models\\Team', 1, NULL, '2023-08-10 11:37:34', '2023-08-10 11:37:34'),
(12, 'Task1', '<p>dd</p>', 'Normal', 'Open', '2023-08-20', '2023-08-21', NULL, NULL, 0, 6, 'App\\Models\\User', 2, NULL, '2023-08-20 17:33:17', '2023-08-20 17:33:17');

-- --------------------------------------------------------

--
-- Table structure for table `task_notes`
--

CREATE TABLE `task_notes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `task_id` bigint(20) UNSIGNED NOT NULL,
  `note` tinytext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `task_notes`
--

INSERT INTO `task_notes` (`id`, `user_id`, `task_id`, `note`, `created_at`) VALUES
(1, 1, 11, 'hi', '2023-08-10 08:38:20');

-- --------------------------------------------------------

--
-- Table structure for table `task_note_files`
--

CREATE TABLE `task_note_files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `task_id` bigint(20) UNSIGNED NOT NULL,
  `display_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unique_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`id`, `name`) VALUES
(1, 'Team 1'),
(2, 'Team 2'),
(3, 'Team 3'),
(4, 'Team 4'),
(5, 'Team 5'),
(6, 'Team 6'),
(7, 'Team 7'),
(8, 'Team 8'),
(9, 'Team 9'),
(10, 'Team 10'),
(11, 'Team 11'),
(12, 'Team 12'),
(13, 'Team 13'),
(14, 'Team 14'),
(15, 'Team 15'),
(16, 'Team 16'),
(17, 'Team 17'),
(18, 'operation'),
(19, 'Network');

-- --------------------------------------------------------

--
-- Table structure for table `team_vulnerabilities`
--

CREATE TABLE `team_vulnerabilities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `team_id` bigint(20) UNSIGNED NOT NULL,
  `vulnerability_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `team_vulnerabilities`
--

INSERT INTO `team_vulnerabilities` (`id`, `team_id`, `vulnerability_id`) VALUES
(1, 1, 1),
(2, 3, 2),
(3, 4, 2),
(4, 5, 2),
(5, 6, 2),
(6, 8, 2),
(7, 12, 2),
(8, 13, 2),
(9, 15, 2),
(10, 16, 2),
(11, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `technologies`
--

CREATE TABLE `technologies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `technologies`
--

INSERT INTO `technologies` (`id`, `name`) VALUES
(1, 'Todos'),
(2, 'Anti-Virus'),
(3, 'Backups'),
(4, 'Blackberry'),
(5, 'Citrix'),
(6, 'Datacenter'),
(7, 'Mail Routing'),
(8, 'Live Collaboration'),
(9, 'Mesajeria'),
(10, 'Mobile'),
(11, 'Network'),
(12, 'Power'),
(13, 'Remote Access'),
(14, 'SAN'),
(15, 'Telecom'),
(16, 'Unix'),
(17, 'VMWare'),
(18, 'Web'),
(19, 'Windows');

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE `tests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `test_results`
--

CREATE TABLE `test_results` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `background_class` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `test_results`
--

INSERT INTO `test_results` (`id`, `name`, `background_class`) VALUES
(1, 'Not Applicable', '#d0d0d0'),
(2, 'Not Implemented', '#FFA1A1'),
(3, 'Partially Implemented', '#ffe700'),
(4, 'Implemented', '#00d4bd');

-- --------------------------------------------------------

--
-- Table structure for table `test_statuses`
--

CREATE TABLE `test_statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `test_statuses`
--

INSERT INTO `test_statuses` (`id`, `name`) VALUES
(1, 'Pending Evidence from Control Owner'),
(2, 'Evidence Submitted / Pending Review'),
(3, 'Passed Internal QA'),
(4, 'Remediation Required'),
(5, 'Closed');

-- --------------------------------------------------------

--
-- Table structure for table `threat_catalogs`
--

CREATE TABLE `threat_catalogs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `number` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `threat_grouping_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `threat_catalogs`
--

INSERT INTO `threat_catalogs` (`id`, `number`, `threat_grouping_id`, `name`, `description`, `order`) VALUES
(1, 'NT-1', 1, 'Drought & Water Shortage', 'Regardless of geographic location, periods of reduced rainfall are expected. For non-agricultural industries, drought may not be impactful to operations until it reaches the extent of water rationing.', 1),
(2, 'NT-2', 1, 'Earthquakes', 'Earthquakes are sudden rolling or shaking events caused by movement under the earth’s surface. Although earthquakes usually last less than one minute, the scope of devastation can be widespread and have long-lasting impact.', 2),
(3, 'NT-3', 1, 'Fire & Wildfires', 'Regardless of geographic location or even building material, fire is a concern for every business. When thinking of a fire in a building, envision a total loss to all technology hardware, including backup tapes, and all paper files being consumed in the fire.', 3),
(4, 'NT-4', 1, 'Floods', 'Flooding is the most common of natural hazards and requires an understanding of the local environment, including floodplains and the frequency of flooding events. Location of critical technologies should be considered (e.g., server room is in the basement or first floor of the facility).', 4),
(5, 'NT-5', 1, 'Hurricanes & Tropical Storms', 'Hurricanes and tropical storms are among the most powerful natural disasters because of their size and destructive potential. In addition to high winds, regional flooding and infrastructure damage should be considered when assessing hurricanes and tropical storms.', 5),
(6, 'NT-6', 1, 'Landslides & Debris Flow', 'Landslides occur throughout the world and can be caused by a variety of factors including earthquakes, storms, volcanic eruptions, fire, and by human modification of land. Landslides can occur quickly, often with little notice. Location of critical technologies should be considered (e.g., server room is in the basement or first floor of the facility).', 6),
(7, 'NT-7', 1, 'Pandemic (Disease) Outbreaks', 'Due to the wide variety of possible scenarios, consideration should be given both to the magnitude of what can reasonably happen during a pandemic outbreak (e.g., COVID-19, Influenza, SARS, Ebola, etc.) and what actions the business can be taken to help lessen the impact of a  pandemic on operations.', 7),
(8, 'NT-8', 1, 'Severe Weather', 'Severe weather is a broad category of meteorological events that include events that range from damaging winds to hail.', 8),
(9, 'NT-9', 1, 'Space Weather', 'Space weather includes natural events in space that can affect the near-earth environment and satellites. Most commonly, this is associated with solar flares from the Sun, so an understanding of how solar flares may impact the business is of critical importance in assessing this threat.', 9),
(10, 'NT-10', 1, 'Thunderstorms & Lightning', 'Thunderstorms are most prevalent in the spring and summer months and generally occur during the afternoon and evening hours, but they can occur year-round and at all hours. Many hazardous weather events are associated with thunderstorms. Under the right conditions, rainfall from thunderstorms causes flash flooding and lightning is responsible for equipment damage, fires and fatalities.', 10),
(11, 'NT-11', 1, 'Tornadoes', 'Tornadoes occur in many parts of the world, including the US, Australia, Europe, Africa, Asia, and South America. Tornadoes can happen at any time of year and occur at any time of day or night, but most tornadoes occur between 4–9 p.m. Tornadoes (with winds up to about 300 mph) can destroy all but the best-built man-made structures.', 11),
(12, 'NT-12', 1, 'Tsunamis', 'All tsunamis are potentially dangerous, even though they may not damage every coastline they strike. A tsunami can strike anywhere along most of the US coastline. The most destructive tsunamis have occurred along the coasts of California, Oregon, Washington, Alaska and Hawaii.', 12),
(13, 'NT-13', 1, 'Volcanoes', 'While volcanoes are geographically fixed objects, volcanic fallout can have significant downwind impacts for thousands of miles. Far outside of the blast zone, volcanoes can significantly damage or degrade transportation systems and also cause electrical grids to fail.', 13),
(14, 'NT-14', 1, 'Winter Storms & Extreme Cold', 'Winter storms is a broad category of meteorological events that include events that range from ice storms, to heavy snowfall, to unseasonably (e.g., record breaking) cold temperatures. Winter storms can significantly impact business operations and transportation systems over a wide geographic region.', 14),
(15, 'MT-1', 2, 'Civil or Political Unrest', 'Civil or political unrest can be singular or wide-spread events that can be unexpected and unpredictable. These events can occur anywhere, at any time.', 15),
(16, 'MT-2', 2, 'Hacking & Other Cybersecurity Crimes', 'Unlike physical threats that prompt immediate action (e.g., \\\"stop, drop, and roll\\\" in the event of a fire), cyber incidents are often difficult to identify as the incident is occurring. Detection generally occurs after the incident has occurred, with the exception of \\\"denial of service\\\" attacks. The spectrum of cybersecurity risks is limitless and threats can have wide-ranging effects on the individual, organizational, geographic, and national levels.', 16),
(17, 'MT-3', 2, 'Hazardous Materials Emergencies', 'Hazardous materials emergencies are focused on accidental disasters that occur in industrialized nations. These incidents can range from industrial chemical spills to groundwater contamination.', 17),
(18, 'MT-4', 2, 'Nuclear, Biological and Chemical (NBC) Weapons', 'The use of NBC weapons are in the possible arsenals of international terrorists and it must be a consideration. Terrorist use of a “dirty bomb” — is considered far more likely than use of a traditional nuclear explosive device. This may be a combination a conventional explosive device with radioactive / chemical / biological material and be designed to scatter lethal and sub-lethal amounts of material over a wide area.', 18),
(19, 'MT-5', 2, 'Physical Crime', 'Physical crime includes \\\"traditional\\\" crimes of opportunity. These incidents can range from theft, to vandalism, riots, looting, arson and other forms of criminal activities.', 19),
(20, 'MT-6', 2, 'Terrorism & Armed Attacks', 'Armed attacks, regardless of the motivation of the attacker, can impact a businesses. Scenarios can range from single actors (e.g., \\\"disgruntled\\\" employee) all the way to a coordinated terrorist attack by multiple assailants. These incidents can range from the use of blade weapons (e.g., knives), blunt objects (e.g., clubs), to firearms and explosives.', 20),
(21, 'MT-7', 2, 'Utility Service Disruption', 'Utility service disruptions are focused on the sustained loss of electricity, Internet, natural gas, water, and/or sanitation services. These incidents can have a variety of causes but  directly impact the fulfillment of utility services that your business needs to operate.', 21);

-- --------------------------------------------------------

--
-- Table structure for table `threat_groupings`
--

CREATE TABLE `threat_groupings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `threat_groupings`
--

INSERT INTO `threat_groupings` (`id`, `name`) VALUES
(1, 'Natural Threat'),
(2, 'Man-Made Threat');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 1,
  `lockout` tinyint(1) NOT NULL DEFAULT 0,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'grc',
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `salt` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `last_password_change_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `lang` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT 0,
  `multi_factor` int(11) NOT NULL DEFAULT 1,
  `ldap_department` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `change_password` tinyint(1) NOT NULL DEFAULT 0,
  `custom_display_settings` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `department_id` bigint(20) UNSIGNED DEFAULT NULL,
  `manager_id` bigint(20) UNSIGNED DEFAULT NULL,
  `job_id` bigint(20) UNSIGNED DEFAULT NULL,
  `custom_plan_mitigation_display_settings` varchar(2000) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '{"risk_colums":[["id","1"],["risk_status","1"],["subject","1"],["calculated_risk","1"],["submission_date","1"]],"mitigation_colums":[["mitigation_planned","1"]],"review_colums":[["management_review","1"]]}\n',
  `custom_perform_reviews_display_settings` varchar(2000) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '{"risk_colums":[["id","1"],["risk_status","1"],["subject","1"],["calculated_risk","1"],["submission_date","1"]],"mitigation_colums":[["mitigation_planned","1"]],"review_colums":[["management_review","1"]]}\n',
  `custom_reviewregularly_display_settings` varchar(2000) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '{"risk_colums":[["id","1"],["risk_status","1"],["subject","1"],["calculated_risk","1"],["days_open","1"]],"review_colums":[["management_review","0"],["review_date","0"],["next_step","0"],["next_review_date","1"],["comments","0"]]}',
  `phone_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `enabled`, `lockout`, `type`, `username`, `name`, `email`, `salt`, `password`, `last_login`, `last_password_change_date`, `role_id`, `lang`, `admin`, `multi_factor`, `ldap_department`, `change_password`, `custom_display_settings`, `department_id`, `manager_id`, `job_id`, `custom_plan_mitigation_display_settings`, `custom_perform_reviews_display_settings`, `custom_reviewregularly_display_settings`, `phone_number`) VALUES
(1, 1, 0, 'grc', 'admin', 'Admin', 'admin@gmail.com', 'qCJpnAe5S6k61Pqh3SFG', '$2y$10$CUpnR5DJs933YjO78gm78uPWyR586XY6k6EsomvMILXK8bm8GKUJ6', '2022-01-17 09:00:33', '2017-01-08 09:58:20', 1, NULL, 1, 1, NULL, 0, '[\\\"id\\\",\\\"subject\\\",\\\"calculated_risk\\\",\\\"submission_date\\\",\\\"mitigation_planned\\\",\\\"management_review\\\"]', 1, NULL, NULL, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}', '{\\\"risk_colums\\\":[[\\\"id\\\",\\\"1\\\"],[\\\"risk_status\\\",\\\"1\\\"],[\\\"subject\\\",\\\"1\\\"],[\\\"calculated_risk\\\",\\\"1\\\"],[\\\"submission_date\\\",\\\"1\\\"]],\\\"mitigation_colums\\\":[[\\\"mitigation_planned\\\",\\\"1\\\"]],\\\"review_colums\\\":[[\\\"management_review\\\",\\\"1\\\"]]}\\n', '{\\\"risk_colums\\\":[[\\\"id\\\",\\\"1\\\"],[\\\"risk_status\\\",\\\"1\\\"],[\\\"subject\\\",\\\"1\\\"],[\\\"calculated_risk\\\",\\\"1\\\"],[\\\"days_open\\\",\\\"1\\\"]],\\\"review_colums\\\":[[\\\"management_review\\\",\\\"0\\\"],[\\\"review_date\\\",\\\"0\\\"],[\\\"next_step\\\",\\\"0\\\"],[\\\"next_review_date\\\",\\\"1\\\"],[\\\"comments\\\",\\\"0\\\"]]}', NULL),
(2, 1, 0, 'grc', 'department1manager', 'مدير الرئيس التنفيذى', 'department1manager@mail.com', NULL, '$2y$10$mDUC/0f3E2e3a.0ye9Ns8.kkyMTwrtGT72X226I0LGhtXdizgCAvG', NULL, '2023-07-05 09:42:42', 1, NULL, 0, 1, NULL, 0, '', 1, 1, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}', NULL),
(3, 1, 0, 'grc', 'department2manager', 'مدير اﻹدارة العامة ﻷمن المعلومات', 'department2manager@mail.com', NULL, '$2y$10$r24ZKkJGiXLkY1auR0wa8O1pMDyzH99xWty.VcH3ajCF4VKRMS.7G', NULL, '2023-07-05 09:42:43', 1, NULL, 0, 1, NULL, 0, '', 2, 1, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}', NULL),
(4, 1, 0, 'grc', 'department3manager', 'مدير نائب المدير العام', 'department3manager@mail.com', NULL, '$2y$10$5Q6TR9T65LHT/FaxG/XnIeUB1TNVoIogjWXeeJkHPTHIw91.DdAd2', NULL, '2023-07-05 09:42:43', 1, NULL, 0, 1, NULL, 0, '', 3, 1, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}', NULL),
(5, 1, 0, 'grc', 'department4manager', 'مدير المكتب اﻹدارى', 'department4manager@mail.com', NULL, '$2y$10$YPGaWaH44spaoFoY10eFuOdpr9PVIivJ3x8pWDeC.xsIzaTwn.NBS', NULL, '2023-07-05 09:42:43', 1, NULL, 0, 1, NULL, 0, '', 4, 1, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}', NULL),
(6, 1, 0, 'grc', 'department5manager', 'مدير الحوكمة والمخاطر والالتزام', 'department5manager@mail.com', NULL, '$2y$10$HC9MfG5xZVn8gNtrJpMVy.r2sMiMxDGfOJXSy1GUORxb442EW9zB.', NULL, '2023-07-05 09:42:43', 2, NULL, 0, 1, NULL, 0, '', 5, 1, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}', NULL),
(7, 1, 0, 'grc', 'department6manager', 'مدير المراقبة اﻷمنية والاستجابة والتحليل', 'department6manager@mail.com', NULL, '$2y$10$EaJOIpWsGlb1llsusyOBPu9lj0MhVi0I8mnPlmPaZeGiDNKcIRRuC', NULL, '2023-07-05 09:42:43', 1, NULL, 0, 1, NULL, 0, '', 6, 1, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}', NULL),
(8, 1, 0, 'grc', 'department7manager', 'مدير إدارة الحلول اﻷمنية', 'department7manager@mail.com', NULL, '$2y$10$QkgJ0pHYYuZDtOPXQPNheO8RrtfZ1puDva.SCfpzpK47py.bzGJlu', NULL, '2023-07-05 09:42:43', 1, NULL, 0, 1, NULL, 0, '', 7, 1, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}', NULL),
(9, 1, 0, 'grc', 'department8manager', 'مدير المعمارية والتخطيط', 'department8manager@mail.com', NULL, '$2y$10$FAXRObD/OuYcMPuSCsC61Ok322BYmjznhQ1/4tfZxlp8nkd1j9vn6', NULL, '2023-07-05 09:42:43', 1, NULL, 0, 1, NULL, 0, '', 8, 1, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}', NULL),
(10, 1, 0, 'grc', 'department9manager', 'مدير الحوكمة', 'department9manager@mail.com', NULL, '$2y$10$PDHPAX797dcpPHjFSrLAbeg12Uf6Apt065fou.i3eFf93cyMsf2Jq', NULL, '2023-07-05 09:42:43', 1, NULL, 0, 1, NULL, 0, '', 9, 1, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}', NULL),
(11, 1, 0, 'grc', 'department10manager', 'مدير المخاطر', 'department10manager@mail.com', NULL, '$2y$10$dynnrx.fB4rwogTlWZJnb.wHyZ4w3xZnc8yOJUByr8vmE1KBQI2fG', NULL, '2023-07-05 09:42:43', 1, NULL, 0, 1, NULL, 0, '', 10, 1, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}', NULL),
(12, 1, 0, 'grc', 'department11manager', 'مدير الالتزام', 'department11manager@mail.com', NULL, '$2y$10$1ns4ooDwlpu5JDQ05XH1euX4RHbBJuVZwoB0m3H1ZOe2jB9J8ZKDK', NULL, '2023-07-05 09:42:43', 1, NULL, 0, 1, NULL, 0, '', 11, 1, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}', NULL),
(13, 1, 0, 'grc', 'department12manager', 'مدير المراقبة اﻷمنية', 'department12manager@mail.com', NULL, '$2y$10$BsV9MSJmMdWi8dsUurAeeO9MzkU8xlGuUpcm267xD.LgEwL/l3p9u', NULL, '2023-07-05 09:42:43', 1, NULL, 0, 1, NULL, 0, '', 12, 2, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}', NULL),
(14, 1, 0, 'grc', 'department13manager', 'مدير التحليل الرقمى والاستجابة للحوادث', 'department13manager@mail.com', NULL, '$2y$10$0ilYjBh3PKi/iPSU1qv/Uev2id/2ejqUVzPgBCpOhgvwDIx3GoWuK', NULL, '2023-07-05 09:42:43', 1, NULL, 0, 1, NULL, 0, '', 13, 3, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}', NULL),
(15, 1, 0, 'grc', 'department14manager', 'مدير المعلومات الاستخباراتية والتهديدات', 'department14manager@mail.com', NULL, '$2y$10$AgjXESNjq6EM5V.XQu9mu.laNw7jYWdiJ5Mgq.7vCF3RyRAP.D9qG', NULL, '2023-07-05 09:42:43', 1, NULL, 0, 1, NULL, 0, '', 14, 4, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}', NULL),
(16, 1, 0, 'grc', 'department15manager', 'مدير تحليل التهديدات والثغرات', 'department15manager@mail.com', NULL, '$2y$10$mVXaPiyoqf/oeBJQ6GBBs.NXAzYRSSGuQ2sadyllYnxxP1/sh8Dru', NULL, '2023-07-05 09:42:44', 1, NULL, 0, 1, NULL, 0, '', 15, 5, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}', NULL),
(17, 1, 0, 'grc', 'department16manager', 'مدير إدارة الضوابط التقنية اﻷمنية', 'department16manager@mail.com', NULL, '$2y$10$IVEYhjBVP7X1/tXf3L1Xt.aCwtfRNRN.EXzDPZm2qelyKkiq7SJ2y', NULL, '2023-07-05 09:42:44', 1, NULL, 0, 1, NULL, 0, '', 16, 6, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}', NULL),
(18, 1, 0, 'grc', 'department17manager', 'مدير تطوير واختبار الحلول اﻷمنية', 'department17manager@mail.com', NULL, '$2y$10$eIHxWQ0Po20BY.0UeZzMqOFCgcH3X.gsb3YHs.x/aUP6AfF9W/ny6', NULL, '2023-07-05 09:42:44', 1, NULL, 0, 1, NULL, 0, '', 17, 7, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}', NULL),
(19, 1, 0, 'grc', 'department18manager', 'مدير إدارة الهويات والصلاحيات', 'department18manager@mail.com', NULL, '$2y$10$HgzDRDzkxxjviEuunMXNe.yEbRPqpRyh2EypmC6KSftL/1g9oddi2', NULL, '2023-07-05 09:42:44', 1, NULL, 0, 1, NULL, 0, '', 18, 8, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}', NULL),
(20, 1, 0, 'grc', 'department19manager', 'مدير التخطيط والتطوير', 'department19manager@mail.com', NULL, '$2y$10$dGsupDIYEbwJTviUNY.HUe0eWpy4LADzBYM.EUKaRce71LuzLe6By', NULL, '2023-07-05 09:42:44', 1, NULL, 0, 1, NULL, 0, '', 19, 9, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}', NULL),
(21, 1, 0, 'grc', 'department20manager', 'مدير المعمارية اﻷمنية', 'department20manager@mail.com', NULL, '$2y$10$tgOLvlF.QlgYuUp5lgxH/OEZo7a34.9rZsUYQJhfRVs8/Rjs.bIWa', NULL, '2023-07-05 09:42:44', 1, NULL, 0, 1, NULL, 0, '', 20, 10, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}', NULL),
(22, 1, 0, 'grc', 'department1employee1', 'Department1 Employee1', 'employee1@mail.com', NULL, '$2y$10$yGoW11zgHIcNcgmSCDX3UOL.pHEcp5VjjTJVYQt4HchdttcpGVimS', NULL, '2023-07-05 09:42:44', 1, NULL, 0, 1, NULL, 0, '', 1, 2, 4, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}', NULL),
(23, 1, 0, 'grc', 'department2employee1', 'Department2 Employee1', 'employee2@mail.com', NULL, '$2y$10$5IJyzIYGt.UqGtbuJnv.S.EBsDT1svt82Jw8IGeOHVWhq9PC.9BFW', NULL, '2023-07-05 09:42:44', 1, NULL, 0, 1, NULL, 0, '', 2, 3, 10, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}', NULL),
(24, 1, 0, 'grc', 'department3employee1', 'Department3 Employee1', 'employee3@mail.com', NULL, '$2y$10$JqNngJf/S4UxjL8qdPQjCOLA2g1Nk1XFwtpx0IKUyVxhvsfxU.trS', NULL, '2023-07-05 09:42:44', 1, NULL, 0, 1, NULL, 0, '', 3, 4, 8, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}', NULL),
(25, 1, 0, 'grc', 'department4employee1', 'Department4 Employee1', 'employee4@mail.com', NULL, '$2y$10$L79NVnPw395PT2gO/K6AIeG4OjhJXIa2wOrnT9xj4e.fYd7N1/LDO', NULL, '2023-07-05 09:42:44', 1, NULL, 0, 1, NULL, 0, '', 4, 5, 8, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}', NULL),
(26, 1, 0, 'grc', 'department5employee1', 'Department5 Employee1', 'employee5@mail.com', NULL, '$2y$10$vNC5owRSpyGpVvq/qrd5IO.4L9TEfxzii5UIqxP5HSJYbr9Zv2fd2', NULL, '2023-07-05 09:42:44', 1, NULL, 0, 1, NULL, 0, '', 5, 6, 6, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}', NULL),
(27, 1, 0, 'grc', 'department6employee1', 'Department6 Employee1', 'employee6@mail.com', NULL, '$2y$10$3IhO7GSL6XJTm8.YM16hdeCD7KOl5rRJ34UPBs518XoEYsiyJ/4cm', NULL, '2023-07-05 09:42:44', 1, NULL, 0, 1, NULL, 0, '', 6, 7, 6, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}', NULL),
(28, 1, 0, 'grc', 'department7employee1', 'Department7 Employee1', 'employee7@mail.com', NULL, '$2y$10$53h2rTOnCNRiWX56eHQ0DORUJc.EdiIHtVGIZZJNVi4PltlFSy8Ou', NULL, '2023-07-05 09:42:45', 1, NULL, 0, 1, NULL, 0, '', 7, 8, 4, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}', NULL),
(29, 1, 0, 'grc', 'department8employee1', 'Department8 Employee1', 'employee8@mail.com', NULL, '$2y$10$Mai1xYftzuiiz7LFGmlrF.gKqUmuYus7JRDjIJwinKG.weFo7JJJW', NULL, '2023-07-05 09:42:45', 1, NULL, 0, 1, NULL, 0, '', 8, 9, 8, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}', NULL),
(30, 1, 0, 'grc', 'department9employee1', 'Department9 Employee1', 'employee9@mail.com', NULL, '$2y$10$qlmz25QCtvJqpddvkBbMz.kStah/WNODCkTZEyhQc0f/nZzPYiG3m', NULL, '2023-07-05 09:42:45', 1, NULL, 0, 1, NULL, 0, '', 9, 10, 6, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}', NULL),
(31, 1, 0, 'grc', 'department10employee1', 'Department10 Employee1', 'employee10@mail.com', NULL, '$2y$10$KhlIvK5tFXjmpuNpHjZTnenCQAGbz3n.0lmZhzYbz.fj3ZdHn2BwG', NULL, '2023-07-05 09:42:45', 1, NULL, 0, 1, NULL, 0, '', 10, 11, 8, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}', NULL),
(32, 1, 0, 'grc', 'department11employee1', 'Department11 Employee1', 'employee11@mail.com', NULL, '$2y$10$.v5o8yOkJaeFtv7JcEjmsuqM2JerxqlkfBpwyQRhJ/SJC6mjv5UvW', NULL, '2023-07-05 09:42:45', 1, NULL, 0, 1, NULL, 0, '', 11, 12, 3, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}', NULL),
(33, 1, 0, 'grc', 'department12employee1', 'Department12 Employee1', 'employee12@mail.com', NULL, '$2y$10$3gFkIf5SKlTt7D6541I0Ce/pxJtWzs.eiRixnM3AJofGkTyr94F6O', NULL, '2023-07-05 09:42:45', 1, NULL, 0, 1, NULL, 0, '', 12, 13, 9, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}', NULL),
(34, 1, 0, 'grc', 'department13employee1', 'Department13 Employee1', 'employee13@mail.com', NULL, '$2y$10$yq9lbNqBFv9d852ACzyuMuQrTdcJn52psNJUziQHbxxI.s0B5ZB4q', NULL, '2023-07-05 09:42:45', 1, NULL, 0, 1, NULL, 0, '', 13, 14, 10, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}', NULL),
(35, 1, 0, 'grc', 'department14employee1', 'Department14 Employee1', 'employee14@mail.com', NULL, '$2y$10$egriu0SegKlFO/MSmtkUiuS09iVeIALx.GWfR.NeEnpWQodqWHD1y', NULL, '2023-07-05 09:42:45', 1, NULL, 0, 1, NULL, 0, '', 14, 15, 7, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}', NULL),
(36, 1, 0, 'grc', 'department15employee1', 'Department15 Employee1', 'employee15@mail.com', NULL, '$2y$10$uk6LVWNDCLsP.W0nMNMWZOdXy7K5AU5GDFvT7LCjjyJKbpVB/x4cO', NULL, '2023-07-05 09:42:45', 1, NULL, 0, 1, NULL, 0, '', 15, 16, 10, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}', NULL),
(37, 1, 0, 'grc', 'department16employee1', 'Department16 Employee1', 'employee16@mail.com', NULL, '$2y$10$UNleZVySRmO7IzdgSeSnyOb7b9vqijeCa/34.3JFo4I18p8ohunIS', NULL, '2023-07-05 09:42:45', 1, NULL, 0, 1, NULL, 0, '', 16, 17, 5, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}', NULL),
(38, 1, 0, 'grc', 'department17employee1', 'Department17 Employee1', 'employee17@mail.com', NULL, '$2y$10$DoOY0i/iI.BKy3CByOcwY.psky4cOGuwZkF7ZmjJ3C30zzMgcHr8u', NULL, '2023-07-05 09:42:45', 1, NULL, 0, 1, NULL, 0, '', 17, 18, 11, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}', NULL),
(39, 1, 0, 'grc', 'department18employee1', 'Department18 Employee1', 'employee18@mail.com', NULL, '$2y$10$kw1KyXpyE6lfqmD8p7efcOGqwy3GM4vClYFRQetnmjDVNKFlGBV8i', NULL, '2023-07-05 09:42:45', 1, NULL, 0, 1, NULL, 0, '', 18, 19, 4, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}', NULL),
(40, 1, 0, 'grc', 'department19employee1', 'Department19 Employee1', 'employee19@mail.com', NULL, '$2y$10$7U5BU1l6kRTlmWGIxP4WS.Rhpp88irTJjvBweqg1ZeQMYmDwJ0CXK', NULL, '2023-07-05 09:42:46', 1, NULL, 0, 1, NULL, 0, '', 19, 20, 8, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}', NULL),
(41, 1, 0, 'grc', 'department20employee1', 'Department20 Employee1', 'employee20@mail.com', NULL, '$2y$10$5cu0WoVflR/WSvCVdUuZv.piu.31ZDs/WcUtfPkEZGXk3RtnkN/2G', NULL, '2023-07-05 09:42:46', 1, NULL, 0, 1, NULL, 0, '', 20, 21, 12, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_notifications`
--

CREATE TABLE `user_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `notification_id` bigint(20) UNSIGNED NOT NULL,
  `is_read` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_notifications`
--

INSERT INTO `user_notifications` (`id`, `user_id`, `notification_id`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, NULL, '2023-08-21 12:43:01'),
(2, 1, 2, 1, NULL, '2023-07-17 12:52:22'),
(3, 6, 3, 1, NULL, '2023-08-20 17:31:46'),
(4, 1, 11, 1, NULL, '2023-08-21 12:42:47'),
(5, 1, 12, 1, NULL, '2023-08-21 12:42:20'),
(6, 1, 13, 1, NULL, '2023-08-21 12:42:51'),
(7, 1, 14, 1, NULL, '2023-08-21 12:42:10'),
(8, 1, 15, 1, NULL, '2023-08-21 12:42:56'),
(9, 1, 16, 1, NULL, '2023-08-21 12:43:08'),
(10, 1, 17, 1, NULL, '2023-08-21 12:42:58'),
(11, 1, 18, 1, NULL, '2023-08-21 12:43:05'),
(12, 1, 19, 1, NULL, '2023-08-21 12:42:38'),
(13, 1, 20, 1, NULL, '2023-08-21 12:42:13'),
(14, 3, 21, 0, NULL, NULL),
(15, 0, 22, 0, NULL, NULL),
(16, 1, 24, 1, NULL, '2023-08-09 10:20:02'),
(17, 1, 26, 1, NULL, '2023-08-21 12:42:31'),
(18, 2, 28, 0, NULL, NULL),
(19, 1, 29, 1, NULL, '2023-08-21 12:41:58'),
(20, 1, 30, 1, NULL, '2023-08-21 12:42:23'),
(21, 2, 31, 0, NULL, NULL),
(22, 6, 32, 1, NULL, '2023-08-20 17:33:32'),
(23, 1, 33, 1, NULL, '2023-08-20 17:36:57'),
(24, 3, 34, 1, NULL, '2023-08-20 17:42:36'),
(25, 1, 35, 1, NULL, '2023-08-21 12:41:44'),
(26, 7, 36, 0, NULL, NULL),
(27, 6, 36, 1, NULL, '2023-08-20 17:40:56'),
(28, 6, 37, 1, NULL, '2023-08-20 18:41:32'),
(29, 2, 38, 0, NULL, NULL),
(30, 2, 40, 1, NULL, '2023-08-20 17:48:55'),
(31, 1, 42, 1, NULL, '2023-08-21 12:41:26'),
(32, 1, 43, 1, NULL, '2023-08-21 12:41:56'),
(33, 1, 44, 1, NULL, '2023-08-21 12:41:24'),
(34, 1, 45, 1, NULL, '2023-08-21 12:41:54'),
(35, 1, 46, 1, NULL, '2023-08-21 12:41:23'),
(36, 1, 47, 1, NULL, '2023-08-21 12:41:53'),
(37, 1, 48, 1, NULL, '2023-08-21 12:41:21'),
(38, 1, 49, 1, NULL, '2023-08-21 12:41:51'),
(39, 6, 50, 1, NULL, '2023-08-20 19:03:17'),
(40, 6, 51, 0, NULL, NULL),
(41, 6, 52, 1, NULL, '2023-08-20 19:31:39'),
(42, 6, 53, 1, NULL, '2023-08-20 20:14:20'),
(43, 1, 54, 1, NULL, '2023-08-20 20:10:56'),
(44, 1, 55, 1, NULL, '2023-08-20 20:11:00'),
(45, 3, 56, 1, NULL, '2023-08-21 16:05:24'),
(46, 4, 57, 0, NULL, NULL),
(47, 2, 58, 1, NULL, '2023-08-21 16:16:26'),
(48, 3, 59, 1, NULL, '2023-08-21 16:08:05'),
(49, 4, 60, 1, NULL, '2023-08-21 16:12:15'),
(50, 2, 61, 0, NULL, NULL),
(51, 3, 65, 1, NULL, '2023-08-21 16:17:15'),
(52, 1, 67, 0, NULL, NULL),
(53, 2, 68, 0, NULL, NULL),
(54, 4, 68, 1, NULL, '2023-08-21 17:41:52'),
(55, 5, 68, 0, NULL, NULL),
(56, 7, 68, 0, NULL, NULL),
(57, 8, 68, 0, NULL, NULL),
(58, 9, 68, 0, NULL, NULL),
(59, 10, 68, 0, NULL, NULL),
(60, 11, 68, 0, NULL, NULL),
(61, 12, 68, 0, NULL, NULL),
(62, 13, 68, 0, NULL, NULL),
(63, 14, 68, 0, NULL, NULL),
(64, 15, 68, 0, NULL, NULL),
(65, 16, 68, 0, NULL, NULL),
(66, 17, 68, 0, NULL, NULL),
(67, 18, 68, 0, NULL, NULL),
(68, 19, 68, 0, NULL, NULL),
(69, 20, 68, 0, NULL, NULL),
(70, 21, 68, 0, NULL, NULL),
(71, 22, 68, 0, NULL, NULL),
(72, 23, 68, 0, NULL, NULL),
(73, 24, 68, 0, NULL, NULL),
(74, 25, 68, 0, NULL, NULL),
(75, 26, 68, 0, NULL, NULL),
(76, 27, 68, 0, NULL, NULL),
(77, 28, 68, 0, NULL, NULL),
(78, 29, 68, 0, NULL, NULL),
(79, 30, 68, 0, NULL, NULL),
(80, 31, 68, 0, NULL, NULL),
(81, 32, 68, 0, NULL, NULL),
(82, 33, 68, 0, NULL, NULL),
(83, 34, 68, 0, NULL, NULL),
(84, 35, 68, 0, NULL, NULL),
(85, 36, 68, 0, NULL, NULL),
(86, 37, 68, 0, NULL, NULL),
(87, 38, 68, 0, NULL, NULL),
(88, 39, 68, 0, NULL, NULL),
(89, 40, 68, 0, NULL, NULL),
(90, 41, 68, 0, NULL, NULL),
(91, 6, 68, 1, NULL, '2023-08-21 17:47:36'),
(92, 1, 69, 1, NULL, '2023-08-21 17:40:31'),
(93, 4, 70, 0, NULL, NULL),
(94, 2, 71, 1, NULL, '2023-08-21 17:39:05'),
(95, 2, 72, 0, NULL, NULL),
(96, 3, 73, 1, NULL, '2023-08-21 18:01:09'),
(97, 2, 75, 1, NULL, '2023-08-21 18:05:06'),
(98, 2, 76, 0, NULL, NULL),
(99, 2, 77, 1, NULL, '2023-08-21 18:17:25'),
(100, 4, 78, 0, NULL, NULL),
(101, 1, 79, 1, NULL, '2023-08-21 18:28:32'),
(102, 2, 80, 1, NULL, '2023-08-21 18:26:01'),
(103, 3, 81, 1, NULL, '2023-08-21 18:38:04'),
(104, 6, 82, 0, NULL, NULL),
(105, 1, 83, 1, NULL, '2023-08-21 18:30:01'),
(106, 2, 84, 1, NULL, '2023-08-21 18:36:47'),
(107, 3, 85, 1, NULL, '2023-08-21 18:30:26'),
(108, 6, 86, 0, NULL, NULL),
(109, 1, 87, 1, NULL, '2023-08-21 18:36:05'),
(110, 2, 88, 1, NULL, '2023-08-21 21:52:29'),
(111, 2, 89, 1, NULL, '2023-08-21 21:52:22'),
(112, 1, 90, 1, NULL, '2023-08-21 21:55:17'),
(113, 2, 90, 1, NULL, '2023-08-21 21:52:17'),
(114, 3, 90, 1, NULL, '2023-08-21 21:52:53'),
(115, 6, 90, 1, NULL, '2023-08-21 22:08:05'),
(116, 3, 91, 1, NULL, '2023-08-21 22:06:22'),
(117, 2, 92, 1, NULL, '2023-08-21 22:12:59'),
(118, 3, 93, 1, NULL, '2023-08-21 22:23:38'),
(119, 1, 94, 0, NULL, NULL),
(120, 2, 94, 0, NULL, NULL),
(121, 3, 94, 0, NULL, NULL),
(122, 6, 94, 0, NULL, NULL),
(123, 1, 95, 1, NULL, '2023-08-21 22:43:04'),
(124, 1, 96, 1, NULL, '2023-08-21 22:44:27'),
(125, 2, 96, 1, NULL, '2023-08-21 22:39:53'),
(126, 3, 96, 0, NULL, NULL),
(127, 6, 96, 1, NULL, '2023-08-21 22:40:31'),
(128, 3, 97, 0, NULL, NULL),
(129, 4, 98, 0, NULL, NULL),
(130, 2, 100, 1, NULL, '2023-08-22 09:21:25'),
(131, 4, 102, 1, NULL, '2023-08-22 09:32:23'),
(132, 1, 103, 0, NULL, NULL),
(133, 3, 103, 1, NULL, '2023-08-22 09:24:39'),
(134, 5, 103, 0, NULL, NULL),
(135, 7, 103, 0, NULL, NULL),
(136, 8, 103, 0, NULL, NULL),
(137, 9, 103, 0, NULL, NULL),
(138, 10, 103, 0, NULL, NULL),
(139, 11, 103, 0, NULL, NULL),
(140, 12, 103, 0, NULL, NULL),
(141, 13, 103, 0, NULL, NULL),
(142, 14, 103, 0, NULL, NULL),
(143, 15, 103, 0, NULL, NULL),
(144, 16, 103, 0, NULL, NULL),
(145, 17, 103, 0, NULL, NULL),
(146, 18, 103, 0, NULL, NULL),
(147, 19, 103, 0, NULL, NULL),
(148, 20, 103, 0, NULL, NULL),
(149, 21, 103, 0, NULL, NULL),
(150, 22, 103, 0, NULL, NULL),
(151, 23, 103, 0, NULL, NULL),
(152, 24, 103, 0, NULL, NULL),
(153, 25, 103, 0, NULL, NULL),
(154, 26, 103, 0, NULL, NULL),
(155, 27, 103, 0, NULL, NULL),
(156, 28, 103, 0, NULL, NULL),
(157, 29, 103, 0, NULL, NULL),
(158, 30, 103, 0, NULL, NULL),
(159, 31, 103, 0, NULL, NULL),
(160, 32, 103, 0, NULL, NULL),
(161, 33, 103, 0, NULL, NULL),
(162, 34, 103, 0, NULL, NULL),
(163, 35, 103, 0, NULL, NULL),
(164, 36, 103, 0, NULL, NULL),
(165, 37, 103, 0, NULL, NULL),
(166, 38, 103, 0, NULL, NULL),
(167, 39, 103, 0, NULL, NULL),
(168, 40, 103, 0, NULL, NULL),
(169, 41, 103, 0, NULL, NULL),
(170, 6, 103, 1, NULL, '2023-08-22 09:30:52'),
(171, 3, 104, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_pass_histories`
--

CREATE TABLE `user_pass_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `salt` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `add_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_pass_reuse_histories`
--

CREATE TABLE `user_pass_reuse_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `password` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `counts` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_to_teams`
--

CREATE TABLE `user_to_teams` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `team_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_to_teams`
--

INSERT INTO `user_to_teams` (`user_id`, `team_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10),
(1, 11),
(1, 12),
(1, 13),
(1, 14),
(1, 15),
(1, 16),
(1, 17),
(1, 18),
(1, 19),
(2, 1),
(3, 1),
(6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `validation_files`
--

CREATE TABLE `validation_files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mitigation_id` bigint(20) UNSIGNED NOT NULL,
  `control_id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `user` int(11) NOT NULL,
  `content` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vulnerabilities`
--

CREATE TABLE `vulnerabilities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cve` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `severity` enum('Critical','High','Medium','Low','Informational') COLLATE utf8mb4_unicode_ci NOT NULL,
  `recommendation` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `plan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Open','In Progress','Closed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Open',
  `update_status_date` timestamp NULL DEFAULT NULL,
  `update_status_user` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vulnerabilities`
--

INSERT INTO `vulnerabilities` (`id`, `name`, `cve`, `description`, `severity`, `recommendation`, `plan`, `status`, `update_status_date`, `update_status_user`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'test', 'rrr', 'rerer', 'Informational', 'dsf', 'asfsf', 'Open', NULL, NULL, 1, '2023-08-10 11:23:22', '2023-08-10 11:23:22'),
(2, 'Eaton Cross', 'Et molestiae facilis', 'Culpa quis eos repre', 'Low', 'Consectetur architec', 'Deserunt proident c', 'Closed', NULL, NULL, 1, '2023-08-20 17:36:45', '2023-08-20 17:36:45'),
(3, 'Vul_testing', 's', 'a', 'High', 'a', 'as', 'Open', NULL, NULL, 2, '2023-08-21 18:25:23', '2023-08-21 18:25:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `actions`
--
ALTER TABLE `actions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `actions_name_unique` (`name`);

--
-- Indexes for table `answer_sub_questions`
--
ALTER TABLE `answer_sub_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `answer_sub_questions_answer_id_foreign` (`answer_id`),
  ADD KEY `answer_sub_questions_question_id_foreign` (`question_id`);

--
-- Indexes for table `assessments`
--
ALTER TABLE `assessments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assessment_answers`
--
ALTER TABLE `assessment_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assessment_answers_assessment_id_foreign` (`assessment_id`),
  ADD KEY `assessment_answers_assessment_scoring_id_foreign` (`assessment_scoring_id`);

--
-- Indexes for table `assessment_answers_to_assets`
--
ALTER TABLE `assessment_answers_to_assets`
  ADD UNIQUE KEY `assessment_answer_asset_unique` (`assessment_answer_id`,`asset_id`),
  ADD KEY `assessment_answers_to_assets_asset_id_foreign` (`asset_id`);

--
-- Indexes for table `assessment_answers_to_asset_groups`
--
ALTER TABLE `assessment_answers_to_asset_groups`
  ADD UNIQUE KEY `assessment_answer_asset_group_unique` (`assessment_answer_id`,`asset_group_id`),
  ADD KEY `assessment_answers_to_asset_groups_asset_group_id_foreign` (`asset_group_id`);

--
-- Indexes for table `assessment_questions`
--
ALTER TABLE `assessment_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assessment_questions_assessment_id_foreign` (`assessment_id`);

--
-- Indexes for table `assessment_scorings`
--
ALTER TABLE `assessment_scorings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assessment_scoring_contributing_impacts`
--
ALTER TABLE `assessment_scoring_contributing_impacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `A_S_C_I_A_S_id_foreign` (`assessment_scoring_id`),
  ADD KEY `A_S_C_I_C_R_id_foreign` (`contributing_risk_id`);

--
-- Indexes for table `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `assets_asset_value_id_foreign` (`asset_value_id`),
  ADD KEY `assets_location_id_foreign` (`location_id`);

--
-- Indexes for table `assets_asset_groups`
--
ALTER TABLE `assets_asset_groups`
  ADD UNIQUE KEY `asset_asset_group_unique` (`asset_id`,`asset_group_id`),
  ADD KEY `assets_asset_groups_asset_group_id_foreign` (`asset_group_id`);

--
-- Indexes for table `asset_asset_groups`
--
ALTER TABLE `asset_asset_groups`
  ADD UNIQUE KEY `asset_asset_group_unique` (`asset_id`,`asset_group_id`),
  ADD KEY `asset_asset_groups_asset_group_id_foreign` (`asset_group_id`);

--
-- Indexes for table `asset_groups`
--
ALTER TABLE `asset_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name_unique` (`name`);

--
-- Indexes for table `asset_values`
--
ALTER TABLE `asset_values`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `asset_vulnerabilities`
--
ALTER TABLE `asset_vulnerabilities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asset_vulnerabilities_asset_id_foreign` (`asset_id`),
  ADD KEY `asset_vulnerabilities_vulnerability_id_foreign` (`vulnerability_id`);

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD KEY `audit_logs_user_id_foreign` (`user_id`);

--
-- Indexes for table `backups`
--
ALTER TABLE `backups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `change_requests`
--
ALTER TABLE `change_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `change_requests_created_by_foreign` (`created_by`);

--
-- Indexes for table `close_reasons`
--
ALTER TABLE `close_reasons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `closures`
--
ALTER TABLE `closures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `closures_risk_id_foreign` (`risk_id`),
  ADD KEY `closures_user_id_foreign` (`user_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_risk_id_foreign` (`risk_id`);

--
-- Indexes for table `compliance_files`
--
ALTER TABLE `compliance_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_questionnaires`
--
ALTER TABLE `contact_questionnaires`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contact_questionnaires_user_id_foreign` (`user_id`),
  ADD KEY `contact_questionnaires_questionnaire_id_foreign` (`questionnaire_id`);

--
-- Indexes for table `contact_questionnaire_answers`
--
ALTER TABLE `contact_questionnaire_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contact_questionnaire_answers_asset_id_foreign` (`asset_id`),
  ADD KEY `contact_questionnaire_answers_contact_id_foreign` (`contact_id`),
  ADD KEY `contact_questionnaire_answers_questionnaire_id_foreign` (`questionnaire_id`);

--
-- Indexes for table `contact_questionnaire_answer_results`
--
ALTER TABLE `contact_questionnaire_answer_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contact_q_answer_id` (`contact_questionnaire_answer_id`),
  ADD KEY `contact_questionnaire_answer_results_question_id_foreign` (`question_id`),
  ADD KEY `contact_questionnaire_answer_results_answer_id_foreign` (`answer_id`);

--
-- Indexes for table `contributing_risks`
--
ALTER TABLE `contributing_risks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contributing_risks_impacts`
--
ALTER TABLE `contributing_risks_impacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contributing_risks_impacts_contributing_risks_id_foreign` (`contributing_risks_id`);

--
-- Indexes for table `contributing_risks_likelihoods`
--
ALTER TABLE `contributing_risks_likelihoods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `control_audit_policies`
--
ALTER TABLE `control_audit_policies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `control_audit_policies_document_id_foreign` (`document_id`),
  ADD KEY `control_audit_policies_framework_control_test_audit_id_foreign` (`framework_control_test_audit_id`);

--
-- Indexes for table `control_classes`
--
ALTER TABLE `control_classes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `control_desired_maturities`
--
ALTER TABLE `control_desired_maturities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `control_maturities`
--
ALTER TABLE `control_maturities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `control_objectives`
--
ALTER TABLE `control_objectives`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `control_objectives_name_unique` (`name`);

--
-- Indexes for table `control_owners`
--
ALTER TABLE `control_owners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `control_phases`
--
ALTER TABLE `control_phases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `control_priorities`
--
ALTER TABLE `control_priorities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `control_questions`
--
ALTER TABLE `control_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `control_questions_framework_control_id_foreign` (`framework_control_id`),
  ADD KEY `control_questions_assessment_question_id_foreign` (`assessment_question_id`);

--
-- Indexes for table `control_types`
--
ALTER TABLE `control_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `custom_risk_model_values`
--
ALTER TABLE `custom_risk_model_values`
  ADD UNIQUE KEY `impact_likelihood_unique` (`impact_id`,`likelihood_id`),
  ADD KEY `custom_risk_model_values_likelihood_id_foreign` (`likelihood_id`);

--
-- Indexes for table `cvss_scorings`
--
ALTER TABLE `cvss_scorings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_classifications`
--
ALTER TABLE `data_classifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `date_formats`
--
ALTER TABLE `date_formats`
  ADD PRIMARY KEY (`value`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `departments_code_unique` (`code`),
  ADD KEY `departments_parent_id_foreign` (`parent_id`),
  ADD KEY `departments_color_id_foreign` (`color_id`),
  ADD KEY `departments_manager_id_foreign` (`manager_id`);

--
-- Indexes for table `department_colors`
--
ALTER TABLE `department_colors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `documents_document_type_foreign` (`document_type`),
  ADD KEY `documents_privacy_foreign` (`privacy`),
  ADD KEY `documents_document_owner_foreign` (`document_owner`),
  ADD KEY `documents_document_reviewer_foreign` (`document_reviewer`),
  ADD KEY `documents_created_by_foreign` (`created_by`);

--
-- Indexes for table `document_exceptions`
--
ALTER TABLE `document_exceptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `document_exceptions_statuses`
--
ALTER TABLE `document_exceptions_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `document_notes`
--
ALTER TABLE `document_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `document_notes_user_id_foreign` (`user_id`),
  ADD KEY `document_notes_document_id_foreign` (`document_id`);

--
-- Indexes for table `document_note_files`
--
ALTER TABLE `document_note_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `document_note_files_user_id_foreign` (`user_id`),
  ADD KEY `document_note_files_document_id_foreign` (`document_id`);

--
-- Indexes for table `document_statuses`
--
ALTER TABLE `document_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `document_types`
--
ALTER TABLE `document_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_saved_selections`
--
ALTER TABLE `dynamic_saved_selections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dynamic_saved_selections_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_login_attempts`
--
ALTER TABLE `failed_login_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `failed_login_attempts_user_id_foreign` (`user_id`);

--
-- Indexes for table `families`
--
ALTER TABLE `families`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_parent_id_unique` (`order`,`parent_id`),
  ADD KEY `families_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `fields`
--
ALTER TABLE `fields`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `files_risk_id_foreign` (`risk_id`);

--
-- Indexes for table `file_tasks`
--
ALTER TABLE `file_tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `file_tasks_task_id_foreign` (`task_id`);

--
-- Indexes for table `file_types`
--
ALTER TABLE `file_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `file_type_extensions`
--
ALTER TABLE `file_type_extensions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `frameworks`
--
ALTER TABLE `frameworks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `framework_controls`
--
ALTER TABLE `framework_controls`
  ADD PRIMARY KEY (`id`),
  ADD KEY `framework_controls_family_foreign` (`family`),
  ADD KEY `framework_controls_control_owner_foreign` (`control_owner`),
  ADD KEY `framework_controls_desired_maturity_foreign` (`desired_maturity`),
  ADD KEY `framework_controls_control_priority_foreign` (`control_priority`),
  ADD KEY `framework_controls_control_class_foreign` (`control_class`),
  ADD KEY `framework_controls_control_maturity_foreign` (`control_maturity`),
  ADD KEY `framework_controls_control_phase_foreign` (`control_phase`),
  ADD KEY `framework_controls_control_type_foreign` (`control_type`),
  ADD KEY `framework_controls_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `framework_control_mappings`
--
ALTER TABLE `framework_control_mappings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `framework_control_mappings_framework_control_id_foreign` (`framework_control_id`),
  ADD KEY `framework_control_mappings_framework_id_foreign` (`framework_id`);

--
-- Indexes for table `framework_control_tests`
--
ALTER TABLE `framework_control_tests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `framework_control_tests_tester_foreign` (`tester`),
  ADD KEY `framework_control_tests_framework_control_id_foreign` (`framework_control_id`);

--
-- Indexes for table `framework_control_test_audits`
--
ALTER TABLE `framework_control_test_audits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `framework_control_test_audits_test_id_foreign` (`test_id`),
  ADD KEY `framework_control_test_audits_tester_foreign` (`tester`),
  ADD KEY `framework_control_test_audits_framework_control_id_foreign` (`framework_control_id`);

--
-- Indexes for table `framework_control_test_comments`
--
ALTER TABLE `framework_control_test_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `framework_control_test_comments_test_audit_id_foreign` (`test_audit_id`);

--
-- Indexes for table `framework_control_test_results`
--
ALTER TABLE `framework_control_test_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `framework_control_test_results_test_audit_id_foreign` (`test_audit_id`),
  ADD KEY `framework_control_test_results_test_result_foreign` (`test_result`);

--
-- Indexes for table `framework_control_test_results_to_risks`
--
ALTER TABLE `framework_control_test_results_to_risks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `framework_control_test_results_to_risks_test_results_id_foreign` (`test_results_id`),
  ADD KEY `framework_control_test_results_to_risks_risk_id_foreign` (`risk_id`);

--
-- Indexes for table `framework_control_to_frameworks`
--
ALTER TABLE `framework_control_to_frameworks`
  ADD PRIMARY KEY (`control_id`,`framework_id`),
  ADD KEY `framework_id` (`framework_id`,`control_id`);

--
-- Indexes for table `framework_control_type_mappings`
--
ALTER TABLE `framework_control_type_mappings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `framework_control_type_mappings_control_id_foreign` (`control_id`),
  ADD KEY `framework_control_type_mappings_control_type_id_foreign` (`control_type_id`);

--
-- Indexes for table `framework_families`
--
ALTER TABLE `framework_families`
  ADD PRIMARY KEY (`id`),
  ADD KEY `framework_families_framework_id_foreign` (`framework_id`),
  ADD KEY `framework_families_family_id_foreign` (`family_id`),
  ADD KEY `framework_families_parent_family_id_foreign` (`parent_family_id`);

--
-- Indexes for table `framework_icons`
--
ALTER TABLE `framework_icons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `impacts`
--
ALTER TABLE `impacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items_to_teams`
--
ALTER TABLE `items_to_teams`
  ADD UNIQUE KEY `item_team_unique` (`item_id`,`team_id`,`type`),
  ADD KEY `item_type` (`item_id`,`type`),
  ADD KEY `team_type` (`team_id`,`type`),
  ADD KEY `type` (`type`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `jobs_code_unique` (`code`);

--
-- Indexes for table `kpis`
--
ALTER TABLE `kpis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kpis_department_id_foreign` (`department_id`),
  ADD KEY `kpis_created_by_foreign` (`created_by`);

--
-- Indexes for table `kpi_assessments`
--
ALTER TABLE `kpi_assessments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kpi_assessments_kpi_id_foreign` (`kpi_id`),
  ADD KEY `kpi_assessments_created_by_foreign` (`created_by`),
  ADD KEY `kpi_assessments_action_by_foreign` (`action_by`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likelihoods`
--
ALTER TABLE `likelihoods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mail_settings`
--
ALTER TABLE `mail_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mail_settings_foreign` (`action_id`);

--
-- Indexes for table `mgmt_reviews`
--
ALTER TABLE `mgmt_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mgmt_reviews_risk_id_foreign` (`risk_id`),
  ADD KEY `mgmt_reviews_review_foreign` (`review`),
  ADD KEY `mgmt_reviews_reviewer_foreign` (`reviewer`),
  ADD KEY `mgmt_reviews_next_step_id_foreign` (`next_step_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mitigations`
--
ALTER TABLE `mitigations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mitigations_planning_strategy_foreign` (`planning_strategy`),
  ADD KEY `mitigations_mitigation_effort_foreign` (`mitigation_effort`),
  ADD KEY `mitigations_mitigation_owner_foreign` (`mitigation_owner`),
  ADD KEY `mitigations_risk_id_foreign` (`risk_id`);

--
-- Indexes for table `mitigation_accept_users`
--
ALTER TABLE `mitigation_accept_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mitigation_accept_users_risk_id_foreign` (`risk_id`),
  ADD KEY `mitigation_accept_users_user_id_foreign` (`user_id`);

--
-- Indexes for table `mitigation_efforts`
--
ALTER TABLE `mitigation_efforts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mitigation_to_controls`
--
ALTER TABLE `mitigation_to_controls`
  ADD PRIMARY KEY (`mitigation_id`,`control_id`),
  ADD KEY `control_id` (`control_id`,`mitigation_id`);

--
-- Indexes for table `mitigation_to_teams`
--
ALTER TABLE `mitigation_to_teams`
  ADD PRIMARY KEY (`mitigation_id`,`team_id`),
  ADD KEY `team_id` (`team_id`,`mitigation_id`);

--
-- Indexes for table `next_steps`
--
ALTER TABLE `next_steps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifiables`
--
ALTER TABLE `notifiables`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifiables_foreign` (`user_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications_roles`
--
ALTER TABLE `notifications_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pending_risks`
--
ALTER TABLE `pending_risks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pending_risks_assessment_id_foreign` (`assessment_id`),
  ADD KEY `pending_risks_assessment_answer_id_foreign` (`assessment_answer_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `key` (`key`),
  ADD KEY `permissions_subgroup_id_foreign` (`subgroup_id`);

--
-- Indexes for table `permission_groups`
--
ALTER TABLE `permission_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `permission_to_permission_groups`
--
ALTER TABLE `permission_to_permission_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permission_to_permission_groups_permission_id_foreign` (`permission_id`),
  ADD KEY `permission_to_permission_groups_permission_group_id_foreign` (`permission_group_id`);

--
-- Indexes for table `permission_to_users`
--
ALTER TABLE `permission_to_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permission_to_users_permission_id_foreign` (`permission_id`),
  ADD KEY `permission_to_users_user_id_foreign` (`user_id`);

--
-- Indexes for table `planning_strategies`
--
ALTER TABLE `planning_strategies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `privacies`
--
ALTER TABLE `privacies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questionnaires`
--
ALTER TABLE `questionnaires`
  ADD PRIMARY KEY (`id`),
  ADD KEY `questionnaires_assessment_id_foreign` (`assessment_id`);

--
-- Indexes for table `questionnaire_pending_risks`
--
ALTER TABLE `questionnaire_pending_risks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questionnaire_questions`
--
ALTER TABLE `questionnaire_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `questionnaire_questions_questionnaire_id_foreign` (`questionnaire_id`),
  ADD KEY `questionnaire_questions_question_id_foreign` (`question_id`);

--
-- Indexes for table `questionnaire_risks`
--
ALTER TABLE `questionnaire_risks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `questionnaire_risks_questionnaire_id_foreign` (`questionnaire_id`),
  ADD KEY `questionnaire_risks_answer_id_foreign` (`answer_id`),
  ADD KEY `questionnaire_risks_risk_scoring_method_id_foreign` (`risk_scoring_method_id`),
  ADD KEY `questionnaire_risks_likelihood_id_foreign` (`likelihood_id`),
  ADD KEY `questionnaire_risks_impact_id_foreign` (`impact_id`),
  ADD KEY `questionnaire_risks_owner_id_foreign` (`owner_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `regulations`
--
ALTER TABLE `regulations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `residual_risk_scoring_histories`
--
ALTER TABLE `residual_risk_scoring_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `residual_risk_scoring_histories_risk_id_foreign` (`risk_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `review_levels`
--
ALTER TABLE `review_levels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `risks`
--
ALTER TABLE `risks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `risks_control_id_foreign` (`control_id`),
  ADD KEY `risks_source_id_foreign` (`source_id`),
  ADD KEY `risks_category_id_foreign` (`category_id`),
  ADD KEY `risks_owner_id_foreign` (`owner_id`),
  ADD KEY `risks_manager_id_foreign` (`manager_id`),
  ADD KEY `risks_mitigation_id_foreign` (`mitigation_id`),
  ADD KEY `risks_project_id_foreign` (`project_id`),
  ADD KEY `status` (`status`),
  ADD KEY `regulation` (`regulation`),
  ADD KEY `mgmt_review` (`mgmt_review`),
  ADD KEY `close_id` (`close_id`),
  ADD KEY `submitted_by` (`submitted_by`);

--
-- Indexes for table `risks_to_assets`
--
ALTER TABLE `risks_to_assets`
  ADD UNIQUE KEY `risk_id` (`risk_id`,`asset_id`),
  ADD KEY `asset_id` (`asset_id`,`risk_id`);

--
-- Indexes for table `risks_to_asset_groups`
--
ALTER TABLE `risks_to_asset_groups`
  ADD UNIQUE KEY `risk_asset_group_unique` (`risk_id`,`asset_group_id`),
  ADD KEY `asset_group_id` (`asset_group_id`,`risk_id`);

--
-- Indexes for table `risk_catalogs`
--
ALTER TABLE `risk_catalogs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `risk_catalogs_risk_grouping_id_foreign` (`risk_grouping_id`),
  ADD KEY `risk_catalogs_risk_function_id_foreign` (`risk_function_id`);

--
-- Indexes for table `risk_functions`
--
ALTER TABLE `risk_functions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `risk_groupings`
--
ALTER TABLE `risk_groupings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `risk_levels`
--
ALTER TABLE `risk_levels`
  ADD PRIMARY KEY (`id`),
  ADD KEY `risk_levels_review_level_id_foreign` (`review_level_id`);

--
-- Indexes for table `risk_models`
--
ALTER TABLE `risk_models`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `risk_scorings`
--
ALTER TABLE `risk_scorings`
  ADD KEY `risk_scorings_id_foreign` (`id`),
  ADD KEY `calculated_risk` (`calculated_risk`);

--
-- Indexes for table `risk_scoring_contributing_impacts`
--
ALTER TABLE `risk_scoring_contributing_impacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `risk_scoring_contributing_impacts_risk_scoring_id_foreign` (`risk_scoring_id`),
  ADD KEY `risk_scoring_contributing_impacts_contributing_risk_id_foreign` (`contributing_risk_id`);

--
-- Indexes for table `risk_scoring_histories`
--
ALTER TABLE `risk_scoring_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `risk_scoring_histories_risk_id_foreign` (`risk_id`);

--
-- Indexes for table `risk_to_additional_stakeholders`
--
ALTER TABLE `risk_to_additional_stakeholders`
  ADD PRIMARY KEY (`risk_id`,`user_id`),
  ADD KEY `user_id` (`user_id`,`risk_id`);

--
-- Indexes for table `risk_to_locations`
--
ALTER TABLE `risk_to_locations`
  ADD PRIMARY KEY (`risk_id`,`location_id`),
  ADD KEY `location_id` (`location_id`,`risk_id`);

--
-- Indexes for table `risk_to_teams`
--
ALTER TABLE `risk_to_teams`
  ADD PRIMARY KEY (`risk_id`,`team_id`),
  ADD KEY `team_id` (`team_id`,`risk_id`);

--
-- Indexes for table `risk_to_technologies`
--
ALTER TABLE `risk_to_technologies`
  ADD PRIMARY KEY (`risk_id`,`technology_id`),
  ADD KEY `technology_id` (`technology_id`,`risk_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_responsibilities`
--
ALTER TABLE `role_responsibilities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_responsibilities_role_id_foreign` (`role_id`),
  ADD KEY `role_responsibilities_permission_id_foreign` (`permission_id`);

--
-- Indexes for table `scoring_methods`
--
ALTER TABLE `scoring_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `security_awarenesses`
--
ALTER TABLE `security_awarenesses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `security_awarenesses_privacy_foreign` (`privacy`),
  ADD KEY `security_awarenesses_file_id_foreign` (`file_id`),
  ADD KEY `security_awarenesses_owner_foreign` (`owner`),
  ADD KEY `security_awarenesses_reviewer_foreign` (`reviewer`),
  ADD KEY `security_awarenesses_created_by_foreign` (`created_by`);

--
-- Indexes for table `security_awareness_exams`
--
ALTER TABLE `security_awareness_exams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `security_awareness_exams_security_awareness_id_foreign` (`security_awareness_id`);

--
-- Indexes for table `security_awareness_exam_answers`
--
ALTER TABLE `security_awareness_exam_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `security_awareness_exam_answers_foreign` (`security_awareness_exams_id`),
  ADD KEY `security_awareness_exam_answers_examinee_foreign` (`examinee`);

--
-- Indexes for table `security_awareness_exam_questions`
--
ALTER TABLE `security_awareness_exam_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `security_awareness_exam_options_foreign` (`security_awareness_exams_id`);

--
-- Indexes for table `security_awareness_notes`
--
ALTER TABLE `security_awareness_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `security_awareness_notes_user_id_foreign` (`user_id`),
  ADD KEY `security_awareness_notes_security_awareness_id_foreign` (`security_awareness_id`);

--
-- Indexes for table `security_awareness_note_files`
--
ALTER TABLE `security_awareness_note_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `security_awareness_note_files_user_id_foreign` (`user_id`),
  ADD KEY `security_awareness_note_files_security_awareness_id_foreign` (`security_awareness_id`);

--
-- Indexes for table `service_descriptions`
--
ALTER TABLE `service_descriptions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `service_descriptions_route_unique` (`route`),
  ADD UNIQUE KEY `service_descriptions_key_unique` (`key`),
  ADD UNIQUE KEY `service_descriptions_name_key_unique` (`name_key`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms_settings`
--
ALTER TABLE `sms_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sms_settings_foreign` (`action_id`);

--
-- Indexes for table `sources`
--
ALTER TABLE `sources`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subgroups`
--
ALTER TABLE `subgroups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subgroups_permission_group_id_foreign` (`permission_group_id`);

--
-- Indexes for table `system_notifications_settings`
--
ALTER TABLE `system_notifications_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `system_notifications_settings_foreign` (`action_id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tag_unique` (`tag`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tasks_created_by_foreign` (`created_by`),
  ADD KEY `tasks_action_by_foreign` (`action_by`);

--
-- Indexes for table `task_notes`
--
ALTER TABLE `task_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_notes_user_id_foreign` (`user_id`),
  ADD KEY `task_notes_task_id_foreign` (`task_id`);

--
-- Indexes for table `task_note_files`
--
ALTER TABLE `task_note_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_note_files_user_id_foreign` (`user_id`),
  ADD KEY `task_note_files_task_id_foreign` (`task_id`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team_vulnerabilities`
--
ALTER TABLE `team_vulnerabilities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `team_vulnerabilities_team_id_foreign` (`team_id`),
  ADD KEY `team_vulnerabilities_vulnerability_id_foreign` (`vulnerability_id`);

--
-- Indexes for table `technologies`
--
ALTER TABLE `technologies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `test_results`
--
ALTER TABLE `test_results`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name_unique` (`name`);

--
-- Indexes for table `test_statuses`
--
ALTER TABLE `test_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `threat_catalogs`
--
ALTER TABLE `threat_catalogs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `threat_catalogs_threat_grouping_id_foreign` (`threat_grouping_id`);

--
-- Indexes for table `threat_groupings`
--
ALTER TABLE `threat_groupings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`),
  ADD KEY `users_department_id_foreign` (`department_id`),
  ADD KEY `users_manager_id_foreign` (`manager_id`),
  ADD KEY `users_job_id_foreign` (`job_id`);

--
-- Indexes for table `user_notifications`
--
ALTER TABLE `user_notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_notifications_notification_id_foreign` (`notification_id`);

--
-- Indexes for table `user_pass_histories`
--
ALTER TABLE `user_pass_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_pass_histories_user_id_foreign` (`user_id`);

--
-- Indexes for table `user_pass_reuse_histories`
--
ALTER TABLE `user_pass_reuse_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_pass_reuse_histories_user_id_foreign` (`user_id`);

--
-- Indexes for table `user_to_teams`
--
ALTER TABLE `user_to_teams`
  ADD PRIMARY KEY (`user_id`,`team_id`),
  ADD KEY `team_id` (`team_id`,`user_id`);

--
-- Indexes for table `validation_files`
--
ALTER TABLE `validation_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `validation_files_mitigation_id_foreign` (`mitigation_id`);

--
-- Indexes for table `vulnerabilities`
--
ALTER TABLE `vulnerabilities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vulnerabilities_update_status_user_foreign` (`update_status_user`),
  ADD KEY `vulnerabilities_created_by_foreign` (`created_by`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `actions`
--
ALTER TABLE `actions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `answer_sub_questions`
--
ALTER TABLE `answer_sub_questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assessments`
--
ALTER TABLE `assessments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `assessment_answers`
--
ALTER TABLE `assessment_answers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assessment_questions`
--
ALTER TABLE `assessment_questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assessment_scorings`
--
ALTER TABLE `assessment_scorings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assessment_scoring_contributing_impacts`
--
ALTER TABLE `assessment_scoring_contributing_impacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `asset_groups`
--
ALTER TABLE `asset_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `asset_values`
--
ALTER TABLE `asset_values`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `asset_vulnerabilities`
--
ALTER TABLE `asset_vulnerabilities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `backups`
--
ALTER TABLE `backups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `change_requests`
--
ALTER TABLE `change_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `close_reasons`
--
ALTER TABLE `close_reasons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `closures`
--
ALTER TABLE `closures`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `compliance_files`
--
ALTER TABLE `compliance_files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_questionnaires`
--
ALTER TABLE `contact_questionnaires`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_questionnaire_answers`
--
ALTER TABLE `contact_questionnaire_answers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_questionnaire_answer_results`
--
ALTER TABLE `contact_questionnaire_answer_results`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contributing_risks`
--
ALTER TABLE `contributing_risks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `contributing_risks_impacts`
--
ALTER TABLE `contributing_risks_impacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `contributing_risks_likelihoods`
--
ALTER TABLE `contributing_risks_likelihoods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `control_audit_policies`
--
ALTER TABLE `control_audit_policies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `control_classes`
--
ALTER TABLE `control_classes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `control_desired_maturities`
--
ALTER TABLE `control_desired_maturities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `control_maturities`
--
ALTER TABLE `control_maturities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `control_objectives`
--
ALTER TABLE `control_objectives`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `control_owners`
--
ALTER TABLE `control_owners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `control_phases`
--
ALTER TABLE `control_phases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `control_priorities`
--
ALTER TABLE `control_priorities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `control_questions`
--
ALTER TABLE `control_questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `control_types`
--
ALTER TABLE `control_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cvss_scorings`
--
ALTER TABLE `cvss_scorings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_classifications`
--
ALTER TABLE `data_classifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `department_colors`
--
ALTER TABLE `department_colors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `document_exceptions`
--
ALTER TABLE `document_exceptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `document_exceptions_statuses`
--
ALTER TABLE `document_exceptions_statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `document_notes`
--
ALTER TABLE `document_notes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `document_note_files`
--
ALTER TABLE `document_note_files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `document_statuses`
--
ALTER TABLE `document_statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `document_types`
--
ALTER TABLE `document_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `dynamic_saved_selections`
--
ALTER TABLE `dynamic_saved_selections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_login_attempts`
--
ALTER TABLE `failed_login_attempts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `families`
--
ALTER TABLE `families`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT for table `fields`
--
ALTER TABLE `fields`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `file_tasks`
--
ALTER TABLE `file_tasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `file_types`
--
ALTER TABLE `file_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `file_type_extensions`
--
ALTER TABLE `file_type_extensions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `frameworks`
--
ALTER TABLE `frameworks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `framework_controls`
--
ALTER TABLE `framework_controls`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1011;

--
-- AUTO_INCREMENT for table `framework_control_mappings`
--
ALTER TABLE `framework_control_mappings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1116;

--
-- AUTO_INCREMENT for table `framework_control_tests`
--
ALTER TABLE `framework_control_tests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1011;

--
-- AUTO_INCREMENT for table `framework_control_test_audits`
--
ALTER TABLE `framework_control_test_audits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `framework_control_test_comments`
--
ALTER TABLE `framework_control_test_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `framework_control_test_results`
--
ALTER TABLE `framework_control_test_results`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `framework_control_test_results_to_risks`
--
ALTER TABLE `framework_control_test_results_to_risks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `framework_control_type_mappings`
--
ALTER TABLE `framework_control_type_mappings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `framework_families`
--
ALTER TABLE `framework_families`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=250;

--
-- AUTO_INCREMENT for table `framework_icons`
--
ALTER TABLE `framework_icons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `impacts`
--
ALTER TABLE `impacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `kpis`
--
ALTER TABLE `kpis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kpi_assessments`
--
ALTER TABLE `kpi_assessments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `likelihoods`
--
ALTER TABLE `likelihoods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `mail_settings`
--
ALTER TABLE `mail_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mgmt_reviews`
--
ALTER TABLE `mgmt_reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;

--
-- AUTO_INCREMENT for table `mitigations`
--
ALTER TABLE `mitigations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `mitigation_accept_users`
--
ALTER TABLE `mitigation_accept_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mitigation_efforts`
--
ALTER TABLE `mitigation_efforts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `next_steps`
--
ALTER TABLE `next_steps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `notifiables`
--
ALTER TABLE `notifiables`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `notifications_roles`
--
ALTER TABLE `notifications_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pending_risks`
--
ALTER TABLE `pending_risks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;

--
-- AUTO_INCREMENT for table `permission_groups`
--
ALTER TABLE `permission_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `permission_to_permission_groups`
--
ALTER TABLE `permission_to_permission_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `permission_to_users`
--
ALTER TABLE `permission_to_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=748;

--
-- AUTO_INCREMENT for table `planning_strategies`
--
ALTER TABLE `planning_strategies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `privacies`
--
ALTER TABLE `privacies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `questionnaires`
--
ALTER TABLE `questionnaires`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `questionnaire_pending_risks`
--
ALTER TABLE `questionnaire_pending_risks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `questionnaire_questions`
--
ALTER TABLE `questionnaire_questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `questionnaire_risks`
--
ALTER TABLE `questionnaire_risks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `regulations`
--
ALTER TABLE `regulations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `residual_risk_scoring_histories`
--
ALTER TABLE `residual_risk_scoring_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `review_levels`
--
ALTER TABLE `review_levels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `risks`
--
ALTER TABLE `risks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `risk_catalogs`
--
ALTER TABLE `risk_catalogs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `risk_functions`
--
ALTER TABLE `risk_functions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `risk_groupings`
--
ALTER TABLE `risk_groupings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `risk_levels`
--
ALTER TABLE `risk_levels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `risk_models`
--
ALTER TABLE `risk_models`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `risk_scoring_contributing_impacts`
--
ALTER TABLE `risk_scoring_contributing_impacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `risk_scoring_histories`
--
ALTER TABLE `risk_scoring_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `role_responsibilities`
--
ALTER TABLE `role_responsibilities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=345;

--
-- AUTO_INCREMENT for table `scoring_methods`
--
ALTER TABLE `scoring_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `security_awarenesses`
--
ALTER TABLE `security_awarenesses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `security_awareness_exams`
--
ALTER TABLE `security_awareness_exams`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `security_awareness_exam_answers`
--
ALTER TABLE `security_awareness_exam_answers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `security_awareness_exam_questions`
--
ALTER TABLE `security_awareness_exam_questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `security_awareness_notes`
--
ALTER TABLE `security_awareness_notes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `security_awareness_note_files`
--
ALTER TABLE `security_awareness_note_files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service_descriptions`
--
ALTER TABLE `service_descriptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `sms_settings`
--
ALTER TABLE `sms_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sources`
--
ALTER TABLE `sources`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `subgroups`
--
ALTER TABLE `subgroups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `system_notifications_settings`
--
ALTER TABLE `system_notifications_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `task_notes`
--
ALTER TABLE `task_notes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `task_note_files`
--
ALTER TABLE `task_note_files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `team_vulnerabilities`
--
ALTER TABLE `team_vulnerabilities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `technologies`
--
ALTER TABLE `technologies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tests`
--
ALTER TABLE `tests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `test_results`
--
ALTER TABLE `test_results`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `test_statuses`
--
ALTER TABLE `test_statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `threat_catalogs`
--
ALTER TABLE `threat_catalogs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `threat_groupings`
--
ALTER TABLE `threat_groupings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `user_notifications`
--
ALTER TABLE `user_notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=172;

--
-- AUTO_INCREMENT for table `user_pass_histories`
--
ALTER TABLE `user_pass_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_pass_reuse_histories`
--
ALTER TABLE `user_pass_reuse_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `validation_files`
--
ALTER TABLE `validation_files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vulnerabilities`
--
ALTER TABLE `vulnerabilities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answer_sub_questions`
--
ALTER TABLE `answer_sub_questions`
  ADD CONSTRAINT `answer_sub_questions_answer_id_foreign` FOREIGN KEY (`answer_id`) REFERENCES `assessment_answers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `answer_sub_questions_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `assessment_questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `assessment_answers`
--
ALTER TABLE `assessment_answers`
  ADD CONSTRAINT `assessment_answers_assessment_id_foreign` FOREIGN KEY (`assessment_id`) REFERENCES `assessments` (`id`),
  ADD CONSTRAINT `assessment_answers_assessment_scoring_id_foreign` FOREIGN KEY (`assessment_scoring_id`) REFERENCES `assessment_scorings` (`id`);

--
-- Constraints for table `assessment_answers_to_assets`
--
ALTER TABLE `assessment_answers_to_assets`
  ADD CONSTRAINT `assessment_answers_to_assets_assessment_answer_id_foreign` FOREIGN KEY (`assessment_answer_id`) REFERENCES `assessment_answers` (`id`),
  ADD CONSTRAINT `assessment_answers_to_assets_asset_id_foreign` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `assessment_answers_to_asset_groups`
--
ALTER TABLE `assessment_answers_to_asset_groups`
  ADD CONSTRAINT `assessment_answers_to_asset_groups_assessment_answer_id_foreign` FOREIGN KEY (`assessment_answer_id`) REFERENCES `assessment_answers` (`id`),
  ADD CONSTRAINT `assessment_answers_to_asset_groups_asset_group_id_foreign` FOREIGN KEY (`asset_group_id`) REFERENCES `asset_groups` (`id`);

--
-- Constraints for table `assessment_questions`
--
ALTER TABLE `assessment_questions`
  ADD CONSTRAINT `assessment_questions_assessment_id_foreign` FOREIGN KEY (`assessment_id`) REFERENCES `assessments` (`id`);

--
-- Constraints for table `assessment_scoring_contributing_impacts`
--
ALTER TABLE `assessment_scoring_contributing_impacts`
  ADD CONSTRAINT `A_S_C_I_A_S_id_foreign` FOREIGN KEY (`assessment_scoring_id`) REFERENCES `assessment_scorings` (`id`),
  ADD CONSTRAINT `A_S_C_I_C_R_id_foreign` FOREIGN KEY (`contributing_risk_id`) REFERENCES `contributing_risks` (`id`);

--
-- Constraints for table `assets`
--
ALTER TABLE `assets`
  ADD CONSTRAINT `assets_asset_value_id_foreign` FOREIGN KEY (`asset_value_id`) REFERENCES `asset_values` (`id`),
  ADD CONSTRAINT `assets_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`);

--
-- Constraints for table `assets_asset_groups`
--
ALTER TABLE `assets_asset_groups`
  ADD CONSTRAINT `assets_asset_groups_asset_group_id_foreign` FOREIGN KEY (`asset_group_id`) REFERENCES `asset_groups` (`id`),
  ADD CONSTRAINT `assets_asset_groups_asset_id_foreign` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `asset_asset_groups`
--
ALTER TABLE `asset_asset_groups`
  ADD CONSTRAINT `asset_asset_groups_asset_group_id_foreign` FOREIGN KEY (`asset_group_id`) REFERENCES `asset_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `asset_asset_groups_asset_id_foreign` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `asset_vulnerabilities`
--
ALTER TABLE `asset_vulnerabilities`
  ADD CONSTRAINT `asset_vulnerabilities_asset_id_foreign` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`id`),
  ADD CONSTRAINT `asset_vulnerabilities_vulnerability_id_foreign` FOREIGN KEY (`vulnerability_id`) REFERENCES `vulnerabilities` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `audit_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `change_requests`
--
ALTER TABLE `change_requests`
  ADD CONSTRAINT `change_requests_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `closures`
--
ALTER TABLE `closures`
  ADD CONSTRAINT `closures_risk_id_foreign` FOREIGN KEY (`risk_id`) REFERENCES `risks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `closures_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_risk_id_foreign` FOREIGN KEY (`risk_id`) REFERENCES `risks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `contact_questionnaires`
--
ALTER TABLE `contact_questionnaires`
  ADD CONSTRAINT `contact_questionnaires_questionnaire_id_foreign` FOREIGN KEY (`questionnaire_id`) REFERENCES `questionnaires` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `contact_questionnaires_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `contact_questionnaire_answers`
--
ALTER TABLE `contact_questionnaire_answers`
  ADD CONSTRAINT `contact_questionnaire_answers_asset_id_foreign` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `contact_questionnaire_answers_contact_id_foreign` FOREIGN KEY (`contact_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `contact_questionnaire_answers_questionnaire_id_foreign` FOREIGN KEY (`questionnaire_id`) REFERENCES `questionnaires` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `contact_questionnaire_answer_results`
--
ALTER TABLE `contact_questionnaire_answer_results`
  ADD CONSTRAINT `contact_q_answer_id` FOREIGN KEY (`contact_questionnaire_answer_id`) REFERENCES `contact_questionnaire_answers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `contact_questionnaire_answer_results_answer_id_foreign` FOREIGN KEY (`answer_id`) REFERENCES `assessment_answers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `contact_questionnaire_answer_results_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `contributing_risks_impacts`
--
ALTER TABLE `contributing_risks_impacts`
  ADD CONSTRAINT `contributing_risks_impacts_contributing_risks_id_foreign` FOREIGN KEY (`contributing_risks_id`) REFERENCES `contributing_risks` (`id`);

--
-- Constraints for table `control_audit_policies`
--
ALTER TABLE `control_audit_policies`
  ADD CONSTRAINT `control_audit_policies_document_id_foreign` FOREIGN KEY (`document_id`) REFERENCES `documents` (`id`),
  ADD CONSTRAINT `control_audit_policies_framework_control_test_audit_id_foreign` FOREIGN KEY (`framework_control_test_audit_id`) REFERENCES `framework_control_test_audits` (`id`);

--
-- Constraints for table `control_questions`
--
ALTER TABLE `control_questions`
  ADD CONSTRAINT `control_questions_assessment_question_id_foreign` FOREIGN KEY (`assessment_question_id`) REFERENCES `assessment_questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `control_questions_framework_control_id_foreign` FOREIGN KEY (`framework_control_id`) REFERENCES `framework_controls` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `custom_risk_model_values`
--
ALTER TABLE `custom_risk_model_values`
  ADD CONSTRAINT `custom_risk_model_values_impact_id_foreign` FOREIGN KEY (`impact_id`) REFERENCES `impacts` (`id`),
  ADD CONSTRAINT `custom_risk_model_values_likelihood_id_foreign` FOREIGN KEY (`likelihood_id`) REFERENCES `likelihoods` (`id`);

--
-- Constraints for table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `departments_color_id_foreign` FOREIGN KEY (`color_id`) REFERENCES `department_colors` (`id`),
  ADD CONSTRAINT `departments_manager_id_foreign` FOREIGN KEY (`manager_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `departments_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `departments` (`id`);

--
-- Constraints for table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `documents_document_owner_foreign` FOREIGN KEY (`document_owner`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `documents_document_reviewer_foreign` FOREIGN KEY (`document_reviewer`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `documents_document_type_foreign` FOREIGN KEY (`document_type`) REFERENCES `document_types` (`id`),
  ADD CONSTRAINT `documents_privacy_foreign` FOREIGN KEY (`privacy`) REFERENCES `privacies` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `document_notes`
--
ALTER TABLE `document_notes`
  ADD CONSTRAINT `document_notes_document_id_foreign` FOREIGN KEY (`document_id`) REFERENCES `documents` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `document_notes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `document_note_files`
--
ALTER TABLE `document_note_files`
  ADD CONSTRAINT `document_note_files_document_id_foreign` FOREIGN KEY (`document_id`) REFERENCES `documents` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `document_note_files_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `dynamic_saved_selections`
--
ALTER TABLE `dynamic_saved_selections`
  ADD CONSTRAINT `dynamic_saved_selections_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `failed_login_attempts`
--
ALTER TABLE `failed_login_attempts`
  ADD CONSTRAINT `failed_login_attempts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `families`
--
ALTER TABLE `families`
  ADD CONSTRAINT `families_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `families` (`id`);

--
-- Constraints for table `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `files_risk_id_foreign` FOREIGN KEY (`risk_id`) REFERENCES `risks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `file_tasks`
--
ALTER TABLE `file_tasks`
  ADD CONSTRAINT `file_tasks_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `framework_controls`
--
ALTER TABLE `framework_controls`
  ADD CONSTRAINT `framework_controls_control_class_foreign` FOREIGN KEY (`control_class`) REFERENCES `control_classes` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `framework_controls_control_maturity_foreign` FOREIGN KEY (`control_maturity`) REFERENCES `control_maturities` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `framework_controls_control_owner_foreign` FOREIGN KEY (`control_owner`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `framework_controls_control_phase_foreign` FOREIGN KEY (`control_phase`) REFERENCES `control_phases` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `framework_controls_control_priority_foreign` FOREIGN KEY (`control_priority`) REFERENCES `control_priorities` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `framework_controls_control_type_foreign` FOREIGN KEY (`control_type`) REFERENCES `control_types` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `framework_controls_desired_maturity_foreign` FOREIGN KEY (`desired_maturity`) REFERENCES `control_desired_maturities` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `framework_controls_family_foreign` FOREIGN KEY (`family`) REFERENCES `families` (`id`),
  ADD CONSTRAINT `framework_controls_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `framework_controls` (`id`);

--
-- Constraints for table `framework_control_mappings`
--
ALTER TABLE `framework_control_mappings`
  ADD CONSTRAINT `framework_control_mappings_framework_control_id_foreign` FOREIGN KEY (`framework_control_id`) REFERENCES `framework_controls` (`id`),
  ADD CONSTRAINT `framework_control_mappings_framework_id_foreign` FOREIGN KEY (`framework_id`) REFERENCES `frameworks` (`id`);

--
-- Constraints for table `framework_control_tests`
--
ALTER TABLE `framework_control_tests`
  ADD CONSTRAINT `framework_control_tests_framework_control_id_foreign` FOREIGN KEY (`framework_control_id`) REFERENCES `framework_controls` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `framework_control_tests_tester_foreign` FOREIGN KEY (`tester`) REFERENCES `users` (`id`);

--
-- Constraints for table `framework_control_test_audits`
--
ALTER TABLE `framework_control_test_audits`
  ADD CONSTRAINT `framework_control_test_audits_framework_control_id_foreign` FOREIGN KEY (`framework_control_id`) REFERENCES `framework_controls` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `framework_control_test_audits_test_id_foreign` FOREIGN KEY (`test_id`) REFERENCES `framework_control_tests` (`id`),
  ADD CONSTRAINT `framework_control_test_audits_tester_foreign` FOREIGN KEY (`tester`) REFERENCES `users` (`id`);

--
-- Constraints for table `framework_control_test_comments`
--
ALTER TABLE `framework_control_test_comments`
  ADD CONSTRAINT `framework_control_test_comments_test_audit_id_foreign` FOREIGN KEY (`test_audit_id`) REFERENCES `framework_control_test_audits` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `framework_control_test_results`
--
ALTER TABLE `framework_control_test_results`
  ADD CONSTRAINT `framework_control_test_results_test_audit_id_foreign` FOREIGN KEY (`test_audit_id`) REFERENCES `framework_control_test_audits` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `framework_control_test_results_test_result_foreign` FOREIGN KEY (`test_result`) REFERENCES `test_results` (`id`);

--
-- Constraints for table `framework_control_test_results_to_risks`
--
ALTER TABLE `framework_control_test_results_to_risks`
  ADD CONSTRAINT `framework_control_test_results_to_risks_risk_id_foreign` FOREIGN KEY (`risk_id`) REFERENCES `risks` (`id`),
  ADD CONSTRAINT `framework_control_test_results_to_risks_test_results_id_foreign` FOREIGN KEY (`test_results_id`) REFERENCES `framework_control_test_results` (`id`);

--
-- Constraints for table `framework_control_to_frameworks`
--
ALTER TABLE `framework_control_to_frameworks`
  ADD CONSTRAINT `framework_control_to_frameworks_control_id_foreign` FOREIGN KEY (`control_id`) REFERENCES `framework_controls` (`id`),
  ADD CONSTRAINT `framework_control_to_frameworks_framework_id_foreign` FOREIGN KEY (`framework_id`) REFERENCES `frameworks` (`id`);

--
-- Constraints for table `framework_control_type_mappings`
--
ALTER TABLE `framework_control_type_mappings`
  ADD CONSTRAINT `framework_control_type_mappings_control_id_foreign` FOREIGN KEY (`control_id`) REFERENCES `framework_controls` (`id`),
  ADD CONSTRAINT `framework_control_type_mappings_control_type_id_foreign` FOREIGN KEY (`control_type_id`) REFERENCES `control_types` (`id`);

--
-- Constraints for table `framework_families`
--
ALTER TABLE `framework_families`
  ADD CONSTRAINT `framework_families_family_id_foreign` FOREIGN KEY (`family_id`) REFERENCES `families` (`id`),
  ADD CONSTRAINT `framework_families_framework_id_foreign` FOREIGN KEY (`framework_id`) REFERENCES `frameworks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `framework_families_parent_family_id_foreign` FOREIGN KEY (`parent_family_id`) REFERENCES `families` (`id`);

--
-- Constraints for table `items_to_teams`
--
ALTER TABLE `items_to_teams`
  ADD CONSTRAINT `items_to_teams_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`);

--
-- Constraints for table `kpis`
--
ALTER TABLE `kpis`
  ADD CONSTRAINT `kpis_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `kpis_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`);

--
-- Constraints for table `kpi_assessments`
--
ALTER TABLE `kpi_assessments`
  ADD CONSTRAINT `kpi_assessments_action_by_foreign` FOREIGN KEY (`action_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `kpi_assessments_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `kpi_assessments_kpi_id_foreign` FOREIGN KEY (`kpi_id`) REFERENCES `kpis` (`id`);

--
-- Constraints for table `mail_settings`
--
ALTER TABLE `mail_settings`
  ADD CONSTRAINT `mail_settings_foreign` FOREIGN KEY (`action_id`) REFERENCES `actions` (`id`);

--
-- Constraints for table `mgmt_reviews`
--
ALTER TABLE `mgmt_reviews`
  ADD CONSTRAINT `mgmt_reviews_next_step_id_foreign` FOREIGN KEY (`next_step_id`) REFERENCES `next_steps` (`id`),
  ADD CONSTRAINT `mgmt_reviews_review_foreign` FOREIGN KEY (`review`) REFERENCES `reviews` (`id`),
  ADD CONSTRAINT `mgmt_reviews_reviewer_foreign` FOREIGN KEY (`reviewer`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `mgmt_reviews_risk_id_foreign` FOREIGN KEY (`risk_id`) REFERENCES `risks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mitigations`
--
ALTER TABLE `mitigations`
  ADD CONSTRAINT `mitigations_mitigation_effort_foreign` FOREIGN KEY (`mitigation_effort`) REFERENCES `mitigation_efforts` (`id`),
  ADD CONSTRAINT `mitigations_mitigation_owner_foreign` FOREIGN KEY (`mitigation_owner`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `mitigations_planning_strategy_foreign` FOREIGN KEY (`planning_strategy`) REFERENCES `planning_strategies` (`id`),
  ADD CONSTRAINT `mitigations_risk_id_foreign` FOREIGN KEY (`risk_id`) REFERENCES `risks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mitigation_accept_users`
--
ALTER TABLE `mitigation_accept_users`
  ADD CONSTRAINT `mitigation_accept_users_risk_id_foreign` FOREIGN KEY (`risk_id`) REFERENCES `risks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `mitigation_accept_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `mitigation_to_controls`
--
ALTER TABLE `mitigation_to_controls`
  ADD CONSTRAINT `mitigation_to_controls_control_id_foreign` FOREIGN KEY (`control_id`) REFERENCES `framework_controls` (`id`),
  ADD CONSTRAINT `mitigation_to_controls_mitigation_id_foreign` FOREIGN KEY (`mitigation_id`) REFERENCES `mitigations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mitigation_to_teams`
--
ALTER TABLE `mitigation_to_teams`
  ADD CONSTRAINT `mitigation_to_teams_mitigation_id_foreign` FOREIGN KEY (`mitigation_id`) REFERENCES `mitigations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `mitigation_to_teams_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`);

--
-- Constraints for table `notifiables`
--
ALTER TABLE `notifiables`
  ADD CONSTRAINT `notifiables_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `pending_risks`
--
ALTER TABLE `pending_risks`
  ADD CONSTRAINT `pending_risks_assessment_answer_id_foreign` FOREIGN KEY (`assessment_answer_id`) REFERENCES `assessment_answers` (`id`),
  ADD CONSTRAINT `pending_risks_assessment_id_foreign` FOREIGN KEY (`assessment_id`) REFERENCES `assessments` (`id`);

--
-- Constraints for table `permissions`
--
ALTER TABLE `permissions`
  ADD CONSTRAINT `permissions_subgroup_id_foreign` FOREIGN KEY (`subgroup_id`) REFERENCES `subgroups` (`id`);

--
-- Constraints for table `permission_to_permission_groups`
--
ALTER TABLE `permission_to_permission_groups`
  ADD CONSTRAINT `permission_to_permission_groups_permission_group_id_foreign` FOREIGN KEY (`permission_group_id`) REFERENCES `permission_groups` (`id`),
  ADD CONSTRAINT `permission_to_permission_groups_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`);

--
-- Constraints for table `permission_to_users`
--
ALTER TABLE `permission_to_users`
  ADD CONSTRAINT `permission_to_users_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`),
  ADD CONSTRAINT `permission_to_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `questionnaires`
--
ALTER TABLE `questionnaires`
  ADD CONSTRAINT `questionnaires_assessment_id_foreign` FOREIGN KEY (`assessment_id`) REFERENCES `assessments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `questionnaire_questions`
--
ALTER TABLE `questionnaire_questions`
  ADD CONSTRAINT `questionnaire_questions_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `questionnaire_questions_questionnaire_id_foreign` FOREIGN KEY (`questionnaire_id`) REFERENCES `questionnaires` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `questionnaire_risks`
--
ALTER TABLE `questionnaire_risks`
  ADD CONSTRAINT `questionnaire_risks_answer_id_foreign` FOREIGN KEY (`answer_id`) REFERENCES `assessment_answers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `questionnaire_risks_impact_id_foreign` FOREIGN KEY (`impact_id`) REFERENCES `impacts` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `questionnaire_risks_likelihood_id_foreign` FOREIGN KEY (`likelihood_id`) REFERENCES `likelihoods` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `questionnaire_risks_owner_id_foreign` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `questionnaire_risks_questionnaire_id_foreign` FOREIGN KEY (`questionnaire_id`) REFERENCES `questionnaires` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `questionnaire_risks_risk_scoring_method_id_foreign` FOREIGN KEY (`risk_scoring_method_id`) REFERENCES `scoring_methods` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `residual_risk_scoring_histories`
--
ALTER TABLE `residual_risk_scoring_histories`
  ADD CONSTRAINT `residual_risk_scoring_histories_risk_id_foreign` FOREIGN KEY (`risk_id`) REFERENCES `risks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `risks`
--
ALTER TABLE `risks`
  ADD CONSTRAINT `risks_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `risks_control_id_foreign` FOREIGN KEY (`control_id`) REFERENCES `framework_controls` (`id`),
  ADD CONSTRAINT `risks_manager_id_foreign` FOREIGN KEY (`manager_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `risks_mitigation_id_foreign` FOREIGN KEY (`mitigation_id`) REFERENCES `mitigations` (`id`),
  ADD CONSTRAINT `risks_owner_id_foreign` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `risks_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
  ADD CONSTRAINT `risks_source_id_foreign` FOREIGN KEY (`source_id`) REFERENCES `sources` (`id`);

--
-- Constraints for table `risks_to_assets`
--
ALTER TABLE `risks_to_assets`
  ADD CONSTRAINT `risks_to_assets_asset_id_foreign` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `risks_to_assets_risk_id_foreign` FOREIGN KEY (`risk_id`) REFERENCES `risks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `risks_to_asset_groups`
--
ALTER TABLE `risks_to_asset_groups`
  ADD CONSTRAINT `risks_to_asset_groups_asset_group_id_foreign` FOREIGN KEY (`asset_group_id`) REFERENCES `asset_groups` (`id`),
  ADD CONSTRAINT `risks_to_asset_groups_risk_id_foreign` FOREIGN KEY (`risk_id`) REFERENCES `risks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `risk_catalogs`
--
ALTER TABLE `risk_catalogs`
  ADD CONSTRAINT `risk_catalogs_risk_function_id_foreign` FOREIGN KEY (`risk_function_id`) REFERENCES `risk_functions` (`id`),
  ADD CONSTRAINT `risk_catalogs_risk_grouping_id_foreign` FOREIGN KEY (`risk_grouping_id`) REFERENCES `risk_groupings` (`id`);

--
-- Constraints for table `risk_levels`
--
ALTER TABLE `risk_levels`
  ADD CONSTRAINT `risk_levels_review_level_id_foreign` FOREIGN KEY (`review_level_id`) REFERENCES `review_levels` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `risk_scorings`
--
ALTER TABLE `risk_scorings`
  ADD CONSTRAINT `risk_scorings_id_foreign` FOREIGN KEY (`id`) REFERENCES `risks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `risk_scoring_contributing_impacts`
--
ALTER TABLE `risk_scoring_contributing_impacts`
  ADD CONSTRAINT `risk_scoring_contributing_impacts_contributing_risk_id_foreign` FOREIGN KEY (`contributing_risk_id`) REFERENCES `contributing_risks` (`id`),
  ADD CONSTRAINT `risk_scoring_contributing_impacts_risk_scoring_id_foreign` FOREIGN KEY (`risk_scoring_id`) REFERENCES `risk_scorings` (`id`);

--
-- Constraints for table `risk_scoring_histories`
--
ALTER TABLE `risk_scoring_histories`
  ADD CONSTRAINT `risk_scoring_histories_risk_id_foreign` FOREIGN KEY (`risk_id`) REFERENCES `risks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `risk_to_additional_stakeholders`
--
ALTER TABLE `risk_to_additional_stakeholders`
  ADD CONSTRAINT `risk_to_additional_stakeholders_risk_id_foreign` FOREIGN KEY (`risk_id`) REFERENCES `risks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `risk_to_additional_stakeholders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `risk_to_locations`
--
ALTER TABLE `risk_to_locations`
  ADD CONSTRAINT `risk_to_locations_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`),
  ADD CONSTRAINT `risk_to_locations_risk_id_foreign` FOREIGN KEY (`risk_id`) REFERENCES `risks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `risk_to_teams`
--
ALTER TABLE `risk_to_teams`
  ADD CONSTRAINT `risk_to_teams_risk_id_foreign` FOREIGN KEY (`risk_id`) REFERENCES `risks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `risk_to_teams_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`);

--
-- Constraints for table `risk_to_technologies`
--
ALTER TABLE `risk_to_technologies`
  ADD CONSTRAINT `risk_to_technologies_risk_id_foreign` FOREIGN KEY (`risk_id`) REFERENCES `risks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `risk_to_technologies_technology_id_foreign` FOREIGN KEY (`technology_id`) REFERENCES `technologies` (`id`);

--
-- Constraints for table `role_responsibilities`
--
ALTER TABLE `role_responsibilities`
  ADD CONSTRAINT `role_responsibilities_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`),
  ADD CONSTRAINT `role_responsibilities_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Constraints for table `security_awarenesses`
--
ALTER TABLE `security_awarenesses`
  ADD CONSTRAINT `security_awarenesses_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `security_awarenesses_file_id_foreign` FOREIGN KEY (`file_id`) REFERENCES `files` (`id`),
  ADD CONSTRAINT `security_awarenesses_owner_foreign` FOREIGN KEY (`owner`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `security_awarenesses_privacy_foreign` FOREIGN KEY (`privacy`) REFERENCES `privacies` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `security_awarenesses_reviewer_foreign` FOREIGN KEY (`reviewer`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `security_awareness_exams`
--
ALTER TABLE `security_awareness_exams`
  ADD CONSTRAINT `security_awareness_exams_security_awareness_id_foreign` FOREIGN KEY (`security_awareness_id`) REFERENCES `security_awarenesses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `security_awareness_exam_answers`
--
ALTER TABLE `security_awareness_exam_answers`
  ADD CONSTRAINT `security_awareness_exam_answers_examinee_foreign` FOREIGN KEY (`examinee`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `security_awareness_exam_answers_foreign` FOREIGN KEY (`security_awareness_exams_id`) REFERENCES `security_awareness_exams` (`id`);

--
-- Constraints for table `security_awareness_exam_questions`
--
ALTER TABLE `security_awareness_exam_questions`
  ADD CONSTRAINT `security_awareness_exam_options_foreign` FOREIGN KEY (`security_awareness_exams_id`) REFERENCES `security_awareness_exams` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `security_awareness_notes`
--
ALTER TABLE `security_awareness_notes`
  ADD CONSTRAINT `security_awareness_notes_security_awareness_id_foreign` FOREIGN KEY (`security_awareness_id`) REFERENCES `security_awarenesses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `security_awareness_notes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `security_awareness_note_files`
--
ALTER TABLE `security_awareness_note_files`
  ADD CONSTRAINT `security_awareness_note_files_security_awareness_id_foreign` FOREIGN KEY (`security_awareness_id`) REFERENCES `security_awarenesses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `security_awareness_note_files_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sms_settings`
--
ALTER TABLE `sms_settings`
  ADD CONSTRAINT `sms_settings_foreign` FOREIGN KEY (`action_id`) REFERENCES `actions` (`id`);

--
-- Constraints for table `subgroups`
--
ALTER TABLE `subgroups`
  ADD CONSTRAINT `subgroups_permission_group_id_foreign` FOREIGN KEY (`permission_group_id`) REFERENCES `permission_groups` (`id`);

--
-- Constraints for table `system_notifications_settings`
--
ALTER TABLE `system_notifications_settings`
  ADD CONSTRAINT `system_notifications_settings_foreign` FOREIGN KEY (`action_id`) REFERENCES `actions` (`id`);

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_action_by_foreign` FOREIGN KEY (`action_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `tasks_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `task_notes`
--
ALTER TABLE `task_notes`
  ADD CONSTRAINT `task_notes_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `task_notes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `task_note_files`
--
ALTER TABLE `task_note_files`
  ADD CONSTRAINT `task_note_files_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `task_note_files_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `team_vulnerabilities`
--
ALTER TABLE `team_vulnerabilities`
  ADD CONSTRAINT `team_vulnerabilities_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`),
  ADD CONSTRAINT `team_vulnerabilities_vulnerability_id_foreign` FOREIGN KEY (`vulnerability_id`) REFERENCES `vulnerabilities` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `threat_catalogs`
--
ALTER TABLE `threat_catalogs`
  ADD CONSTRAINT `threat_catalogs_threat_grouping_id_foreign` FOREIGN KEY (`threat_grouping_id`) REFERENCES `threat_groupings` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`),
  ADD CONSTRAINT `users_job_id_foreign` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`),
  ADD CONSTRAINT `users_manager_id_foreign` FOREIGN KEY (`manager_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Constraints for table `user_notifications`
--
ALTER TABLE `user_notifications`
  ADD CONSTRAINT `user_notifications_notification_id_foreign` FOREIGN KEY (`notification_id`) REFERENCES `notifications` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `user_pass_histories`
--
ALTER TABLE `user_pass_histories`
  ADD CONSTRAINT `user_pass_histories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `user_pass_reuse_histories`
--
ALTER TABLE `user_pass_reuse_histories`
  ADD CONSTRAINT `user_pass_reuse_histories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `user_to_teams`
--
ALTER TABLE `user_to_teams`
  ADD CONSTRAINT `user_to_teams_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`),
  ADD CONSTRAINT `user_to_teams_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `validation_files`
--
ALTER TABLE `validation_files`
  ADD CONSTRAINT `validation_files_mitigation_id_foreign` FOREIGN KEY (`mitigation_id`) REFERENCES `mitigations` (`id`);

--
-- Constraints for table `vulnerabilities`
--
ALTER TABLE `vulnerabilities`
  ADD CONSTRAINT `vulnerabilities_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `vulnerabilities_update_status_user_foreign` FOREIGN KEY (`update_status_user`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
