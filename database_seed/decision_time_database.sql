-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 27, 2012 at 12:06 AM
-- Server version: 5.5.20
-- PHP Version: 5.3.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dt2`
--

-- --------------------------------------------------------

--
-- Table structure for table `author_permissions`
--

CREATE TABLE IF NOT EXISTS `author_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `story_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=71 ;

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE IF NOT EXISTS `classes` (
  `class_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `class_name` text,
  `class_creator` int(11) DEFAULT NULL,
  `class_created` datetime DEFAULT NULL,
  `enroll_code` tinytext,
  PRIMARY KEY (`class_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `class_members`
--

CREATE TABLE IF NOT EXISTS `class_members` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `class_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `class_stories`
--

CREATE TABLE IF NOT EXISTS `class_stories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `class_id` int(11) DEFAULT NULL,
  `story_id` int(11) DEFAULT NULL,
  `story_order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_name` text,
  `page_navigation_text` tinytext,
  `page_summary` tinyint(1) DEFAULT NULL,
  `page_type` tinytext NOT NULL,
  `story` int(11) DEFAULT NULL,
  `go_back` binary(1) DEFAULT NULL,
  `page_content` text,
  `page_references` text,
  `page_author` text,
  `page_created` datetime DEFAULT NULL,
  `modified_by` text NOT NULL,
  `modified_date` datetime NOT NULL,
  `page_top` int(11) DEFAULT NULL,
  `page_left` int(11) DEFAULT NULL,
  `print_order` int(11) NOT NULL,
  `finish_page` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='InnoDB free: 0 kB; (`label`) REFER `project301/Buttons`(`id`' AUTO_INCREMENT=1075 ;

-- --------------------------------------------------------

--
-- Table structure for table `page_relations`
--

CREATE TABLE IF NOT EXISTS `page_relations` (
  `page_relation_id` int(11) NOT NULL AUTO_INCREMENT,
  `page_child` int(11) DEFAULT NULL,
  `page_parent` int(11) DEFAULT NULL,
  `page_order` int(11) DEFAULT NULL,
  `page_stem` text,
  `page_link` text,
  `page_punctuation` text,
  `page_story` int(11) DEFAULT NULL,
  `page_external` tinytext NOT NULL,
  PRIMARY KEY (`page_relation_id`),
  KEY `node` (`page_child`),
  KEY `parent` (`page_parent`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1915 ;

-- --------------------------------------------------------

--
-- Table structure for table `prints`
--

CREATE TABLE IF NOT EXISTS `prints` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `story` int(11) DEFAULT NULL,
  `name` tinytext,
  `content` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_items`
--

CREATE TABLE IF NOT EXISTS `quiz_items` (
  `item_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `story_id` int(11) DEFAULT NULL,
  `item_prompt` text,
  `item_answer` tinytext,
  `item_type` tinytext NOT NULL,
  `item_explanation` text,
  `item_pages` text NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_on` datetime DEFAULT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=42 ;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_responses`
--

CREATE TABLE IF NOT EXISTS `quiz_responses` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `item_id` int(11) DEFAULT NULL,
  `item_response` tinytext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=139 ;

-- --------------------------------------------------------

--
-- Table structure for table `stories`
--

CREATE TABLE IF NOT EXISTS `stories` (
  `story_id` int(11) NOT NULL AUTO_INCREMENT,
  `story_name` text,
  `story_topic` text,
  `story_creator` int(11) DEFAULT NULL,
  `story_created` timestamp NULL DEFAULT NULL,
  `story_first_page` int(11) DEFAULT NULL,
  `story_summary` int(11) DEFAULT NULL,
  `story_worksheet_count` int(11) DEFAULT NULL,
  `story_privacy` text NOT NULL,
  PRIMARY KEY (`story_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36 ;

-- --------------------------------------------------------

--
-- Table structure for table `terms`
--

CREATE TABLE IF NOT EXISTS `terms` (
  `term_id` int(11) NOT NULL AUTO_INCREMENT,
  `term` tinytext,
  `definition` text,
  `story` int(11) NOT NULL,
  `term_author` int(11) NOT NULL,
  `term_created` datetime NOT NULL,
  `term_modified_by` int(11) NOT NULL,
  `term_modified_on` datetime NOT NULL,
  PRIMARY KEY (`term_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=174 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_first` tinytext,
  `user_name` text,
  `user_email` text,
  `provider` text NOT NULL,
  `user_profile` text,
  `UID` text,
  `created` datetime NOT NULL,
  `last_access` datetime NOT NULL,
  `admin` int(11) DEFAULT NULL,
  `user_image` text,
  `role` text,
  `instructionsShowing` tinytext NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=169 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_progress`
--

CREATE TABLE IF NOT EXISTS `user_progress` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `progress_user` int(11) DEFAULT NULL,
  `progress_page` text,
  `progress_story` int(11) DEFAULT NULL,
  `progress_story_pages` text NOT NULL,
  `progress_teaching` text NOT NULL,
  `progress_appendix` text NOT NULL,
  `progress_finish` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=301 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_quiz`
--

CREATE TABLE IF NOT EXISTS `user_quiz` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `user_answer` int(11) DEFAULT NULL,
  `story` int(11) DEFAULT NULL,
  `user_correct` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=616 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_scores`
--

CREATE TABLE IF NOT EXISTS `user_scores` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `story_id` int(11) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `correct` int(11) DEFAULT NULL,
  `percentage` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=66 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_worksheet`
--

CREATE TABLE IF NOT EXISTS `user_worksheet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `worksheet_id` int(11) DEFAULT NULL,
  `user_answer` tinytext,
  `story` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1070 ;

-- --------------------------------------------------------

--
-- Table structure for table `viewer_permissions`
--

CREATE TABLE IF NOT EXISTS `viewer_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `story_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `worksheet`
--

CREATE TABLE IF NOT EXISTS `worksheet` (
  `worksheet_id` int(11) NOT NULL AUTO_INCREMENT,
  `worksheet_text` text,
  `worksheet_response` text,
  `worksheet_answer` text,
  `worksheet_story` int(11) DEFAULT NULL,
  `worksheet_page` int(11) DEFAULT NULL,
  `worksheet_order` int(11) DEFAULT NULL,
  `worksheet_type` text,
  `created_by` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_on` datetime DEFAULT NULL,
  `embedded` int(11) NOT NULL,
  `available` int(11) NOT NULL,
  PRIMARY KEY (`worksheet_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=66 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
