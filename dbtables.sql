-- phpMyAdmin SQL Dump
-- version 2.6.4-pl3
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Nov 24, 2007 at 07:58 PM
-- Server version: 5.0.15
-- PHP Version: 5.0.5
-- 
-- Database: `buildmeister`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `active_guests`
-- 

DROP TABLE IF EXISTS `active_guests`;
CREATE TABLE IF NOT EXISTS `active_guests` (
  `ip` varchar(15) NOT NULL,
  `timestamp` int(11) unsigned NOT NULL,
  PRIMARY KEY  (`ip`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `active_guests`
-- 

INSERT INTO `active_guests` VALUES ('127.0.0.1', 1195494654);

-- --------------------------------------------------------

-- 
-- Table structure for table `active_users`
-- 

DROP TABLE IF EXISTS `active_users`;
CREATE TABLE IF NOT EXISTS `active_users` (
  `username` varchar(30) NOT NULL,
  `timestamp` int(11) unsigned NOT NULL,
  PRIMARY KEY  (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `active_users`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `article_comm`
-- 

DROP TABLE IF EXISTS `article_comm`;
CREATE TABLE IF NOT EXISTS `article_comm` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `art_id` mediumint(8) unsigned NOT NULL,
  `date_posted` datetime NOT NULL,
  `posted_by` varchar(32) NOT NULL,
  `comment` mediumtext NOT NULL,
  `active` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `article_comm`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `articles`
-- 

DROP TABLE IF EXISTS `articles`;
CREATE TABLE IF NOT EXISTS `articles` (
  `id` mediumint(9) NOT NULL auto_increment,
  `cat_id` tinyint(4) NOT NULL,
  `date_posted` datetime NOT NULL,
  `posted_by` mediumint(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `summary` tinytext NOT NULL,
  `content` tinytext NOT NULL,
  `views` mediumint(9) NOT NULL,
  `active` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

-- 
-- Dumping data for table `articles`
-- 

INSERT INTO `articles` VALUES (1, 2, '2006-11-15 10:30:53', 1, 'Introduction to Apache Ant', 'A brief introduction to the features and capabilities of Apache Ant - the Java build tool.', '', 0, 1);
INSERT INTO `articles` VALUES (2, 1, '2007-11-15 11:06:49', 1, 'Introduction to JavaEE packaging', 'This article describes how Enterprise Java applications are typically packaged and deployed. \r\n\r\n', '', 3, 1);
INSERT INTO `articles` VALUES (3, 1, '2007-08-06 19:04:29', 0, 'Introduction to Test Driven Development and JUnit', 'This article describes the principles of Test Driven Development and the Java unit testing framework tool JUnit that can be used to implement it.', '', 0, 1);
INSERT INTO `articles` VALUES (4, 1, '2006-04-14 19:06:07', 0, 'Architecting the Build Process', 'This article is intended to describe how best to architect a typical build process and what a "good" build process might possibly look like.', '', 0, 1);
INSERT INTO `articles` VALUES (5, 1, '2006-05-11 19:07:27', 0, 'Defining the Build Process', 'This article defines the value of the build process and breaks it down into its constituent parts so that we can better understand and automate it.', '', 0, 1);
INSERT INTO `articles` VALUES (6, 1, '2005-11-24 19:08:27', 0, 'Version Control Requirements for the Build Process', 'This article describes a set of requirements that any version control tool should meet in order for it to successfully enable repeatability, reliability and scalability of the Build Process.', '', 0, 1);
INSERT INTO `articles` VALUES (7, 1, '2006-09-12 19:09:00', 0, 'Build Process Top Ten Tips', 'This article describes my top 10 tips for constructing a complete, consistent and reproducible build process.', '', 0, 1);
INSERT INTO `articles` VALUES (8, 1, '2006-10-12 19:10:44', 0, 'Software Release Management Best Practices', 'This article describes the fundamental concepts of software release management, the types of releases and their lifecycle, and then discusses 10 best practices that can be adopted to improve your own software release management process.', '', 0, 1);
INSERT INTO `articles` VALUES (9, 1, '2007-10-08 19:12:09', 0, 'How to write a Build Management Plan', 'This article illustrates how you can formalize your build and release process through the definition of a Build Management Plan. It does so by defining the procedures for the Hotel de Java reference project.', '', 1, 1);
INSERT INTO `articles` VALUES (10, 3, '2005-12-08 19:14:26', 0, 'An Introduction to Regular Expressions', 'An introduction to the fundamentals of regular expressions and how to use them in a number of languages and environments.', '', 0, 1);
INSERT INTO `articles` VALUES (11, 3, '2005-11-26 19:16:11', 0, 'The Perl Command line to the Rescue', 'An article discussing how to use the Perl scripting tools command line interface to execute a variety of everyday administrative tasks.', '', 0, 1);
INSERT INTO `articles` VALUES (12, 2, '2006-05-09 20:02:00', 0, 'Introduction to NAnt', 'A brief introduction to the features and capabilities of NAnt - a Microsoft .NET build tool based on Apache Ant.', '', 0, 1);
INSERT INTO `articles` VALUES (13, 2, '2006-05-18 20:03:36', 0, 'Integrating CruiseControl and ClearCase', 'A brief introduction on how best to configure CruiseControl - an open source Continuous Integration toolkit - to work with IBM Rational ClearCase.', '', 0, 0);
INSERT INTO `articles` VALUES (14, 2, '2006-05-17 20:04:31', 0, 'Introduction to Ant dependency checking', 'This article describes how Apache Ant''s dependency checking works and how to make use of it in your build scripts.', '', 0, 1);
INSERT INTO `articles` VALUES (15, 2, '2007-04-11 20:05:08', 0, 'Introduction to Apache Maven', 'A brief introduction to the features and capabilities of Apache Maven - a Java build and build project management tool.', '', 0, 1);
INSERT INTO `articles` VALUES (16, 2, '2007-01-15 20:06:15', 0, 'Extending Apache Ant', 'This article describes how you can extend Apache Ant to support new capabilities or tool integrations.', '', 0, 0);
INSERT INTO `articles` VALUES (17, 2, '2007-02-05 20:07:33', 0, 'Introduction to CruiseControl', 'A brief introduction to the features and capabilities of CruiseControl - an open-source Continuous Integration toolkit.', '', 0, 1);
INSERT INTO `articles` VALUES (18, 2, '2007-01-23 20:07:56', 0, 'Introduction to CruiseControl.NET', 'A brief introduction to the features and capabilities of CruiseControl.NET - an open source Continuous Integration toolkit for .NET languages.', '', 0, 1);
INSERT INTO `articles` VALUES (19, 2, '2006-04-11 20:08:37', 0, 'Introduction to GNU Make', 'A brief introduction to the features and capabilities of GNU Make - the C/C++ build tool.', '', 0, 1);
INSERT INTO `articles` VALUES (20, 2, '2006-04-11 20:09:34', 0, 'Managing Java dependencies with Apache Ant and Ivy', 'The world of Java is one of open-source, common components and rapid, evolving change. However, one of the caveats of such a model is the time spent in managing library dependencies. In this article I discuss in more detail the nature of this problem and ', '', 0, 1);
INSERT INTO `articles` VALUES (21, 2, '2007-02-13 20:10:35', 0, 'Integrating CruiseControl and ClearCase UCM', 'In this article I will discuss how to configure CruiseControl to work with UCM - the ClearCase best practice usage model.', '', 0, 0);
INSERT INTO `articles` VALUES (22, 2, '2007-07-17 20:11:21', 0, 'Introduction to IBM Rational BuildForge', 'This article is an introduction to the features and capabilities of IBM Rational Build Forge an enterprise build and release execution framework. It takes you through how to implement Build Forge for a typical Java project.', '', 0, 0);
INSERT INTO `articles` VALUES (23, 2, '2007-06-11 20:11:56', 0, 'Introduction to Headless Ant Builds with IBM Rational Application Developer', 'This article describes how you can execute IBM Rational Application Developer (and related tools such as Rational Software Architect) in "headless" mode in order to execute Apache Ant scripted builds.', '', 0, 1);
INSERT INTO `articles` VALUES (24, 2, '2007-07-17 20:12:40', 0, 'Integrating Apache Ant and Subversion', 'A discussion on how to use and configure Subversion and related tools to implement an integrated build process with Apache Ant.', '', 0, 1);
INSERT INTO `articles` VALUES (25, 2, '2007-05-14 20:13:17', 0, 'Auditing Java builds with IBM Rational ClearCase and Apache Ant', 'A discussion on how to use the Apache Ant build audit listener that is delivered with ClearCase version 7.', '', 0, 1);
INSERT INTO `articles` VALUES (26, 0, '0000-00-00 00:00:00', 0, '', '', '', 2, 0);
INSERT INTO `articles` VALUES (27, 0, '0000-00-00 00:00:00', 0, '', '', '', 2, 0);
INSERT INTO `articles` VALUES (28, 0, '0000-00-00 00:00:00', 0, '', '', '', 2, 0);
INSERT INTO `articles` VALUES (29, 0, '0000-00-00 00:00:00', 0, '', '', '', 0, 0);
INSERT INTO `articles` VALUES (30, 0, '0000-00-00 00:00:00', 0, '', '', '', 0, 0);
INSERT INTO `articles` VALUES (31, 0, '0000-00-00 00:00:00', 0, '', '', '', 0, 0);
INSERT INTO `articles` VALUES (32, 0, '0000-00-00 00:00:00', 0, '', '', '', 1, 0);
INSERT INTO `articles` VALUES (33, 0, '0000-00-00 00:00:00', 0, '', '', '', 1, 0);
INSERT INTO `articles` VALUES (34, 0, '0000-00-00 00:00:00', 0, '', '', '', 1, 0);
INSERT INTO `articles` VALUES (35, 0, '0000-00-00 00:00:00', 0, '', '', '', 1, 0);
INSERT INTO `articles` VALUES (36, 0, '0000-00-00 00:00:00', 0, '', '', '', 1, 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `banned_users`
-- 

DROP TABLE IF EXISTS `banned_users`;
CREATE TABLE IF NOT EXISTS `banned_users` (
  `username` varchar(30) NOT NULL,
  `timestamp` int(11) unsigned NOT NULL,
  PRIMARY KEY  (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `banned_users`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `books`
-- 

DROP TABLE IF EXISTS `books`;
CREATE TABLE IF NOT EXISTS `books` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `cat_id` tinyint(4) NOT NULL default '0',
  `date_posted` datetime NOT NULL,
  `posted_by` mediumint(11) NOT NULL,
  `title` mediumtext NOT NULL,
  `author` varchar(100) NOT NULL,
  `summary` mediumtext NOT NULL,
  `url` varchar(200) NOT NULL,
  `image_url` varchar(200) NOT NULL,
  `date_published` datetime NOT NULL,
  `active` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

-- 
-- Dumping data for table `books`
-- 

INSERT INTO `books` VALUES (1, 1, '2006-10-10 09:41:05', 0, '<a href="http://www.amazon.com/gp/product/184728373X?ie=UTF8&tag=thebuildmeist-20&linkCode=as2&camp=1789&creative=9325&creativeASIN=184728373X">The Buildmeister''s Guide - How to design and implement the right software build and release process for your environment</a><img src="http://www.assoc-amazon.com/e/ir?t=thebuildmeist-20&l=as2&o=1&a=184728373X" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />', 'Kevin A. Lee', 'The Buildmeister''s Guide researches and documents the build process in detail. It''s aim is to increase awareness of the build process and to raise the level and quality of discussion that occurs around it. The book looks at how the build process affects and is affected by different software development languages and methods, and what intrinsic value a "well defined" build process can bring to an organization. It defines the set of skills and capabilities that implementers of the build process should posses, and also a framework for a generic best practice build process with tips and guidelines on how to implement it. Whether you are a software developer, manager or integrator, this book will help you understand the importance of the build process to your organization and what role you will need to play in it.', '', 'http://ecx.images-amazon.com/images/I/41QADEDNX8L._PIsitb-dp-500-arrow,TopRight,45,-64_OU01_SS75_.jpg', '2006-10-02 09:42:47', 1);
INSERT INTO `books` VALUES (2, 1, '2005-11-16 10:47:39', 0, '<a href="http://www.amazon.com/gp/product/0974514039?ie=UTF8&tag=thebuildmeist-20&linkCode=as2&camp=1789&creative=9325&creativeASIN=0974514039">Pragmatic Project Automation: How to Build, Deploy, and Monitor Java Apps</a><img src="http://www.assoc-amazon.com/e/ir?t=thebuildmeist-20&l=as2&o=1&a=0974514039" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />', 'Mike Clark', 'If you are a Java developer and want to know the basics of how to construct a decent build and release process then I recommend reading Mike''s book. It doesn''t go into any topic in real detail; however like most Pragmatic Bookshelf books, it is concise, well written and easily absorbed. The tools that the book discusses includes CVS, Ant and CruiseControl.', '', 'http://ecx.images-amazon.com/images/I/41DWDKNPHRL._SS100_.jpg', '2004-08-11 10:47:09', 1);
INSERT INTO `books` VALUES (3, 2, '2006-10-10 10:50:32', 0, '<a href="http://www.amazon.com/gp/product/1590596528?ie=UTF8&tag=thebuildmeist-20&linkCode=as2&camp=1789&creative=9325&creativeASIN=1590596528">Deploying .NET Applications: Learning MSBuild and ClickOnce (Expert''s Voice in .Net)</a><img src="http://www.assoc-amazon.com/e/ir?t=thebuildmeist-20&l=as2&o=1&a=1590596528" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />', 'Sayed Y. Hashimi, Sayed Ibrahim Hashimi', 'MSBuild and ClickOnce are Microsoft''s new approach to being able to repeatedly build and deploy Enterprise applications. There is limited documentation and information available on these tools currently, so this book is a good introduction. It delves into the tools in detail and gives some good (and downloadable) examples. Unfortunately the book does not really go into why you might want to use these tools and how they can be part of your overriding development process, but it is still a useful read and reference manual.', '', 'http://ecx.images-amazon.com/images/I/11HFMSFRF0L.jpg', '2006-05-01 10:50:21', 1);
INSERT INTO `books` VALUES (4, 0, '2006-08-23 00:00:00', 0, '<a href="http://www.amazon.com/gp/product/0321332059?ie=UTF8&tag=thebuildmeist-20&linkCode=as2&camp=1789&creative=9325&creativeASIN=0321332059">The Build Master: Microsoft''s Software Configuration Management Best Practices (The Addison-Wesley Microsoft Technology Series)</a><img src="http://www.assoc-amazon.com/e/ir?t=thebuildmeist-20&l=as2&o=1&a=0321332059" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />', 'Vincent Maraia', 'Vincent works for Microsoft and has consequently had unique access their development organization. This books reflects this fact with frequent stories and asides - and for which alone its purchase is recommended. There is some good advice and tips in here, however I don''t particularly like the latter chapters as they merely descend into an advert for the build capabilities in the Microsoft Team System.', '', 'http://ecx.images-amazon.com/images/I/51WTY3GFP1L._SS75_.jpg', '2005-09-30 00:00:00', 1);
INSERT INTO `books` VALUES (5, 0, '2005-05-09 12:45:12', 0, '<a href="http://www.amazon.com/gp/product/0201741172?ie=UTF8&tag=thebuildmeist-20&linkCode=as2&camp=1789&creative=9325&creativeASIN=0201741172">Software Configuration Management Patterns: Effective Teamwork, Practical Integration</a><img src="http://www.assoc-amazon.com/e/ir?t=thebuildmeist-20&l=as2&o=1&a=0201741172" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />', 'Stephen P. Berczuk and Brad Appleton', 'One of the most annoying things about Software Configuration Management is the amount of different terms that exist - especially when the refer to the same things! This seminal book helps address this challenge by identifying a set of readily consumable and well defined patterns. If you don''t know your code mainline from your active development line, or how developer testing, building and integration are all linked together, then you need to read this book.', '', 'http://ecx.images-amazon.com/images/I/11u0AOoVpnL.jpg', '2002-11-04 12:47:18', 1);
INSERT INTO `books` VALUES (6, 0, '2006-07-18 12:49:44', 0, '<a href="http://www.amazon.com/gp/product/0974514047?ie=UTF8&tag=thebuildmeist-20&linkCode=as2&camp=1789&creative=9325&creativeASIN=0974514047">Ship it! A Practical Guide to Successful Software Projects</a><img src="http://www.assoc-amazon.com/e/ir?t=thebuildmeist-20&l=as2&o=1&a=0974514047" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />', 'Jared Richardson and William Gwaltney', 'Following the line of Hunt and Thomas''s The Pragmatic Programmer, this book is really a collection of tips and best practices for what the authors have found works well on real projects. It is not a detailed, scientific or process laden tome, rather just some common-sense ideas - some of which you probably do any way. I recommend it here because I believe reading it will help you put some perspective and substance around your build and release process.', '', 'http://ecx.images-amazon.com/images/I/41HWD434RHL._SS75_.jpg', '2005-06-01 12:51:39', 1);
INSERT INTO `books` VALUES (7, 0, '2006-10-24 12:57:02', 0, '<a href="http://www.amazon.com/gp/product/0321356993?ie=UTF8&tag=thebuildmeist-20&linkCode=as2&camp=1789&creative=9325&creativeASIN=0321356993">IBM Rational(R) ClearCase(R), Ant, and CruiseControl: The Java(TM) Developer''s Guide to Accelerating and Automating the Build Process</a><img src="http://www.assoc-amazon.com/e/ir?t=thebuildmeist-20&l=as2&o=1&a=0321356993" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />', 'Kevin A. Lee', 'This book describes how to implement an automated, and repeatable yet also agile and pragmatic build and release process. Although it is specific to the Java development environment, many of the principles and practices of building and releasing software are language independent and should serve as good practices on any type of project. It is of particular use if you are new or inexperienced with implementing build processes using Apache Ant.', '', 'http://rcm-images.amazon.com/images/I/11PJRAXDNVL._SL110_.jpg', '2006-05-24 12:57:41', 1);
INSERT INTO `books` VALUES (8, 0, '0000-00-00 00:00:00', 0, '<a href="http://www.amazon.com/gp/product/193239480X?ie=UTF8&tag=thebuildmeist-20&linkCode=as2&camp=1789&creative=9325&creativeASIN=193239480X">Ant in Action (Manning)</a><img src="http://www.assoc-amazon.com/e/ir?t=thebuildmeist-20&l=as2&o=1&a=193239480X" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />', 'Steve Loughran and Erik Hatcher', 'Apache Ant is the primary build tool for Java projects and this book is "the" guide to the tool. It is a large but well written book and covers everything that you would wish to know about implementing Ant in detail. Particularly good sections include discussions on how to implement library management with Apache Ivy and deployment with SmartFrog.', '', 'http://ecx.images-amazon.com/images/I/51X334EPYQL._PIsitb-dp-500-arrow,TopRight,45,-64_OU01_SS75_.jpg', '2007-07-12 12:59:49', 1);
INSERT INTO `books` VALUES (9, 0, '0000-00-00 00:00:00', 0, '<a href="http://www.amazon.com/gp/product/0596007507?ie=UTF8&tag=thebuildmeist-20&linkCode=as2&camp=1789&creative=9325&creativeASIN=0596007507">Maven: A Developer''s Notebook (Developer''s Notebooks)</a><img src="http://www.assoc-amazon.com/e/ir?t=thebuildmeist-20&l=as2&o=1&a=0596007507" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />', 'Vincent Massol and Timothy O''Brien', 'Although Ant might be the primary build tool for Java projects, Apache Maven is rapidly gaining more acceptance and adoption and this book is a good introduction as to why. Unfortunately it came out too early to discuss Maven 2 in detail, however it is still a useful and well written introduction.', '', 'http://ecx.images-amazon.com/images/I/41qUBJinIeL._SS75_.jpg', '2005-06-22 13:04:49', 1);
INSERT INTO `books` VALUES (10, 0, '0000-00-00 00:00:00', 0, '<a href="http://www.amazon.com/gp/product/0596006101?ie=UTF8&tag=thebuildmeist-20&linkCode=as2&camp=1789&creative=9325&creativeASIN=0596006101">Managing Projects with GNU Make (Nutshell Handbooks)</a><img src="http://www.assoc-amazon.com/e/ir?t=thebuildmeist-20&l=as2&o=1&a=0596006101" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />', 'Robert Mecklenburg ', 'Despite what many people think, the make build tool is still alive and kicking. This book is a detailed guide of how to use the industry standard GNU version. It walks you through the concepts and (sometimes obscure) syntax of this build tool and includes some particularly useful techniques for writing portable makefiles, using make on large projects and improving performance. There is even a section on how to use make to build Java projects!', '', 'http://ecx.images-amazon.com/images/I/51aPGcTXFvL._SS75_.jpg', '2004-11-19 13:07:24', 1);
INSERT INTO `books` VALUES (11, 0, '0000-00-00 00:00:00', 0, '<a href="http://www.amazon.com/gp/product/0321186125?ie=UTF8&tag=thebuildmeist-20&linkCode=as2&camp=1789&creative=9325&creativeASIN=0321186125">Balancing Agility and Discipline: A Guide for the Perplexed</a><img src="http://www.assoc-amazon.com/e/ir?t=thebuildmeist-20&l=as2&o=1&a=0321186125" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />', 'Barry Boehm and Richard Turner ', 'There is a lot of emotional effort spent discussing the merits of agile versus traditional more disciplined software development methods. This book cuts through the hype, describing a whole set of processes and in what situations they might be suitable. The chapter on a day in the life of both XP and Team Software Process are particularly good. This is really background reading for anyone involved in the build and release process, but it contains information and explanations which I think everyone should possess.', '', 'http://ecx.images-amazon.com/images/I/51ixsIxzPaL._PIlitb-dp-500-arrow,TopRight,45,-64_OU01_SS75_.jpg', '2003-08-15 13:10:45', 1);
INSERT INTO `books` VALUES (12, 0, '0000-00-00 00:00:00', 0, '<a href="http://www.amazon.com/gp/product/0321336380?ie=UTF8&tag=thebuildmeist-20&linkCode=as2&camp=1789&creative=9325&creativeASIN=0321336380">Continuous Integration: Improving Software Quality and Reducing Risk (The Addison-Wesley Signature Series)</a><img src="http://www.assoc-amazon.com/e/ir?t=thebuildmeist-20&l=as2&o=1&a=0321336380" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />', 'Paul Duvall and Steve Matyas and Andrew Glover ', 'Continuous Integration is the practice of frequently integrating small changes within a project iteration. In this book Paul Duvall and his colleagues describe the fundamental reasons why you should be adopting Continuous Integration and how to make it actionable. A lot of the information contained in the book has been described before (either in other books or on the Internet) however the sections on Continuous Database Integration and Continuous Inspection make this book an essential purchase.', '', 'http://ecx.images-amazon.com/images/I/51jraHs3ggL._SS75_.jpg', '2007-06-29 13:14:42', 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `categories`
-- 

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` tinyint(4) NOT NULL auto_increment,
  `cat` varchar(40) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `categories`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `glossary`
-- 

DROP TABLE IF EXISTS `glossary`;
CREATE TABLE IF NOT EXISTS `glossary` (
  `id` mediumint(8) NOT NULL auto_increment,
  `posted_by` varchar(32) NOT NULL,
  `title` varchar(100) NOT NULL,
  `summary` mediumtext NOT NULL,
  `active` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=61 ;

-- 
-- Dumping data for table `glossary`
-- 

INSERT INTO `glossary` VALUES (1, '0', 'build', 'An operational version of a system or part of a system that demonstrates a subset of the capabilities to be provided in the final product.', 1);
INSERT INTO `glossary` VALUES (2, '0', 'release', 'A release is a stable, executable version of a product. An internal release is used only by the development organization, as part of a milestone, or for a demonstrations to users or customers. An external release is delivered to end users.', 1);
INSERT INTO `glossary` VALUES (3, '0', 'deployment', 'The act of moving staged or packaged artifacts to other systems for testing or <a href="#release">release</a>.', 1);
INSERT INTO `glossary` VALUES (6, '0', 'Active Development Line', 'A project\\''s integration branch containing the latest development baseline. The Active Development Line is accessed via an individual private <a href="#workspace">workspace</a> for day-to-day development and integration.', 1);
INSERT INTO `glossary` VALUES (7, '', 'active object', 'A derived object that has not or is yet to be staged, such an object is view private rather than under version control.', 1);
INSERT INTO `glossary` VALUES (8, '', 'agile development', 'An umbrella term for individual software development methodologies such as Crystal methods, eXtreme Programming, and feature-driven development. Agile development methods emphasize customer satisfaction through continuous delivery of functional software. Although similar to iterative development, agile development methods typically promote less rigorous process enforcement.\r\n', 1);
INSERT INTO `glossary` VALUES (9, '', 'Agile Software Delivery', 'An end to end software delivery process with continual builds and deployments. Agile Software Delivery aims to reduce the risk of delayed integration and deployment by building early and reusing previously built objects.', 1);
INSERT INTO `glossary` VALUES (10, '', 'artifact', 'A piece of information that is produced, modified, or used by a process, defines an area of responsibility, and is subject to <a href="#version_control">version control</a>.\r\n', 1);
INSERT INTO `glossary` VALUES (11, '', 'baseline', 'A metadata object that typically represents a stable configuration across a collection of artifacts. ', 1);
INSERT INTO `glossary` VALUES (12, '', 'bill of materials', 'The Bill of Materials lists the constituent parts of a given version of a product or application, and where the physical parts may be found. It describes the changes made in the version and refers to how the product may be installed.', 1);
INSERT INTO `glossary` VALUES (13, '', 'branch', 'An object that specifies a linear sequence of element versions.', 1);
INSERT INTO `glossary` VALUES (14, '', 'branching strategy', 'A strategy for isolation and integration of changes on a software project through the use of branches. A branching strategy defines the types of branches you use, how these branches relate to one another, and how you move changes between branches.', 1);
INSERT INTO `glossary` VALUES (15, '', 'build auditing', 'The process of recording which files and directories (and which versions of them) are read or written by the operating system during the course of a build.', 1);
INSERT INTO `glossary` VALUES (16, '', 'build avoidance', 'The capability of a build program to fulfill a build request using an existing object, rather than creating a new derived object for the specific build step. ', 1);
INSERT INTO `glossary` VALUES (17, '', 'build distribution', 'The process of distributing the build process across a number of servers or computer processes so as to shorten the total build time.', 1);
INSERT INTO `glossary` VALUES (18, '', 'build management', 'The identification and definition of what to build, the execution of the build process, and the reporting of its results. Build management capabilities also include <a href="build_auditing">build auditing</a>, <a href="build_avoidance">build avoidance</a> and <a href="build_distribution>build distribution</a>.', 1);
INSERT INTO `glossary` VALUES (19, '', 'build pipeline', 'A "pipeline" of related build processes that get executed on the successful completion of each other. A build pipeline is usually implemented using <a href="#staged%20object">staged objects</a>.', 1);
INSERT INTO `glossary` VALUES (20, '', 'build server farm', 'A collection of virtual of physical hardware used to reduce total build times or share infrastructure across a number of projects.', 1);
INSERT INTO `glossary` VALUES (21, '', 'change request', 'A general term for any request from a stakeholder to change an artifact or process. Documented in the change request is information on the origin and impact of the current problem, the proposed solution, and its cost.', 1);
INSERT INTO `glossary` VALUES (22, '', 'classpath', 'An environmental variable or build file setting which tells the JVM where to look for Java programs. The entries in a classpath should contain either directories or jar files.', 1);
INSERT INTO `glossary` VALUES (23, '', 'clearmake', 'A make-compatible build tool that is part of the IBM Rational ClearCase product and that provides build audit and build avoidance features.', 1);
INSERT INTO `glossary` VALUES (24, '', 'CMMI', 'The Capability Maturity Model Integration (CMM) is a method for evaluating the maturity of organisations. The CMMI was developed by the Software Engineering Institute (SEI) at Carnegie Mellon University. ', 1);
INSERT INTO `glossary` VALUES (25, '', 'component', 'A metadata object that groups a set of related directory and file elements within a project. ', 1);
INSERT INTO `glossary` VALUES (26, '', 'continuous integration', 'The process of frequently integrating individual developer’s changes into a product''s integration environment. Continuous Integration normally necessitates a fully automated and reproducible build, including testing, that runs many times a day. This allows each developer to integrate daily thus reducing integration problems.', 1);
INSERT INTO `glossary` VALUES (27, '', 'continuous staging', 'The process of accumulating the output of multiple continuous integration builds into a staging area and automatically executing a system build.', 1);
INSERT INTO `glossary` VALUES (28, '', 'deployment component', 'A built object or executable such as a .jar, .dll or .exe file that is part of the complete product or application.', 1);
INSERT INTO `glossary` VALUES (29, '', 'deployment unit', 'A self-contained, installable, documented and traceable release of a software product or application. The deployment unit includes the contents of a product''s <a href="release_build">release build</a>, its <a href="bill_of_materials">bill of materials</a> and any other supporting artifacts.', 1);
INSERT INTO `glossary` VALUES (30, '', 'EAR', 'A Java Enterprise ARchive file is an archive (like a <a href="#JAR">JAR</a> file) containing Java class files and supporting artifacts (such as images). EAR files are used to package <a href="#J2EE">J2EE</a> applications for deployment. J2EE files containing additional required files above and beyond JAR files that define the environment in which they are to be deployed and executed.', 1);
INSERT INTO `glossary` VALUES (31, '', 'golden master', 'A final software release that is used to produce distribution media for customers or end-users.', 1);
INSERT INTO `glossary` VALUES (32, '', 'integration', 'The process of bringing together independently developed changes to form a testable piece of software. Integration can occur at many levels, eventually culminating in a complete software system.', 1);
INSERT INTO `glossary` VALUES (33, '', 'integration build', 'A build that is carried out by an assigned integrator or central function to assess the effect of integrating a set of changes across a development team. This type of build can be carried out manually be a lead developer or a member of the build team, or alternately via an automatically scheduled program or service.', 1);
INSERT INTO `glossary` VALUES (34, '', 'J2EE', 'Java 2 Platform, Enterprise Edition is an environment for developing and deploying enterprise applications. Defined by Sun Microsystems Inc., the J2EE platform consists of a set of services, application programming interfaces (APIs), and protocols that provide the functionality for developing multi-tiered, Web-based applications.', 1);
INSERT INTO `glossary` VALUES (35, '', 'JAR', 'A Java ARchive file is an archive (like a <a href="#ZIP">ZIP</a> file) containing Java class files and supporting artifacts (such as images). JAR files are used to package Java applications for deployment.', 1);
INSERT INTO `glossary` VALUES (36, '', 'JDK', 'A Java Development Kit is a software development package from Sun Microsystems that implements the basic set of tools needed to write, test and debug Java applications and applets.', 1);
INSERT INTO `glossary` VALUES (37, '', 'JRE', 'A Java Runtime Environment consists of the <a href="#JVM">JVM</a>, the Java platform core classes, and supporting files. It is the runtime part of the JDK and does not include a compiler, debugger, or supporting tools. ', 1);
INSERT INTO `glossary` VALUES (38, '', 'JVM', 'A Java Virtual Machine is a virtual machine that runs Java byte code generated by Java compilers. ', 1);
INSERT INTO `glossary` VALUES (39, '', 'makefile', 'A makefile details the files, dependencies, and rules by which an executable application is built. Makefiles are executed using the make program.', 1);
INSERT INTO `glossary` VALUES (40, '', 'managed code', 'Executable code that is managed by its targeted execution framework. Managed code is Microsoft\\''s definition for the output of languages that run on its .NET platform.', 1);
INSERT INTO `glossary` VALUES (41, '', 'milestone integration', 'The process of integrating code basis at a specific project milestone, e.g. once a month. Also called big-bang integration.', 1);
INSERT INTO `glossary` VALUES (42, '', 'mock object', 'A simulated code object, for example a class to mimic a database if the actual database is not available.', 1);
INSERT INTO `glossary` VALUES (43, '', 'Private Workspace', 'An isolated environment where developers can control the versions of code that they are working on.', 0);
INSERT INTO `glossary` VALUES (44, '', 'Promotion Line', 'A branch created for a distinct level of assembly or integration, i.e. for integrating the components of a system or for allowing a site to integrate before executing a remote delivery.', 1);
INSERT INTO `glossary` VALUES (45, '', 'private build', 'A build that is carried out by a developer in their own workspace. This type of build is usually created for the purpose of checking the ongoing status of the developer’s changes.', 1);
INSERT INTO `glossary` VALUES (46, '', 'release build', 'A build that is carried out by a central function, usually a member of the build team. This build is created with the express intention of being delivered to a customer, either internal or external. A release build is also usually created in an isolated and controlled environment.', 1);
INSERT INTO `glossary` VALUES (47, '', 'release management', 'The packaging and authorization of a <a href="#release_build">release build</a> so as to enable its deployment to a test or live environment. Release management can also involves the creation of a <a href="#deployment_unit">deployment unit</a> for deploying a partial or multiple products releases.', 1);
INSERT INTO `glossary` VALUES (48, '', 'release package', 'The packaging of a <a href="#release_build">release build</a> into a form so that it is readily installable and deployable.', 1);
INSERT INTO `glossary` VALUES (49, '', 'Release-Prep Line', 'A branch created for the purposes of conducting or stabilizing a release (whilst also allowing delivery to the <a href="#Active_Development_Line">Active Development Line</a> to continue).', 1);
INSERT INTO `glossary` VALUES (50, '', 'RSS', 'RSS is a family of XML formats for syndicating information across the Internet. Rather confusingly, the abbreviation can be used to refer to a number of standards or versions of RSS as follows: Rich Site Summary (RSS 0.91), RDF Site Summary (RSS 0.9 and 1.0) or Really Simple Syndication (RSS 2.0).  The technology behind RSS allows you to subscribe to websites that have provided RSS feeds; these are typically sites that change or add content regularly. To subscribe you typically use a feed reader or aggregator.', 1);
INSERT INTO `glossary` VALUES (51, '', 'software configuration management', 'A software-engineering discipline that comprises the tools and techniques (processes or methodology) a company uses to manage change to its software assets.', 1);
INSERT INTO `glossary` VALUES (52, '', 'SSH', 'Secure SHell is a command interface and protocol for securely accessing remote computers.', 1);
INSERT INTO `glossary` VALUES (53, '', 'staged integration', 'The process of integrating a collective set of changes in isolation (usually on a branch) before integrating them back onto the mainline. Staged integration is a practical form of integration where it is not possible to "pollute" the mainline, for example to carry out a critical maintenance fix.', 1);
INSERT INTO `glossary` VALUES (54, '', 'staged object', 'An <a href="#active_object">active object</a> that has been placed under version control. ', 1);
INSERT INTO `glossary` VALUES (55, '', 'staging', 'The process of putting active object files under version control.', 1);
INSERT INTO `glossary` VALUES (56, '', 'version control', 'A subset of software configuration management that deals with tracking version evolution of a file or directory.', 1);
INSERT INTO `glossary` VALUES (57, '', 'WAR', 'A Java Web ARchive file is an archive (like a <a href="#JAR">JAR</a> file) containing Java class files and supporting artifacts (such as images). WAR files are used to package Web-based Java applications for deployment. WAR files containing additional required files above and beyond JAR files that define the environment in which they are to be deployed and executed.', 1);
INSERT INTO `glossary` VALUES (58, '', 'work product component', 'A source code, configuration, or documentation file that is part of your product and is changed as part of a change request. Work product components are usually grouped together to form some type of <a href="#deployment_component">deployment component</a>.', 1);
INSERT INTO `glossary` VALUES (59, '', 'workspace', 'A generic term for a operating system directory structure created from a specific configuration out of a <a href="#version_control">version control</a> tool.', 1);
INSERT INTO `glossary` VALUES (60, '', 'ZIP', 'ZIP is a popular data compression format. Files that have been compressed with the ZIP format are called ZIP files and usually end with a .zip extension.', 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `glossary_comm`
-- 

DROP TABLE IF EXISTS `glossary_comm`;
CREATE TABLE IF NOT EXISTS `glossary_comm` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `gloss_id` mediumint(8) unsigned NOT NULL,
  `date_posted` datetime NOT NULL,
  `posted_by` varchar(32) NOT NULL,
  `comment` mediumtext NOT NULL,
  `active` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `glossary_comm`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `links`
-- 

DROP TABLE IF EXISTS `links`;
CREATE TABLE IF NOT EXISTS `links` (
  `id` mediumint(9) NOT NULL auto_increment,
  `cat_id` tinyint(4) NOT NULL default '0',
  `date_posted` datetime NOT NULL,
  `posted_by` varchar(32) NOT NULL,
  `title` varchar(100) NOT NULL,
  `summary` mediumtext NOT NULL,
  `url` varchar(200) NOT NULL,
  `preview_url` varchar(200) NOT NULL,
  `active` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- 
-- Dumping data for table `links`
-- 

INSERT INTO `links` VALUES (3, 0, '2007-11-24 18:43:48', 'kevin', 'CM Crossroads', 'CM Crossroads is the configuration management community online. It hosts lots of articles, product reviews, webcasts and discussion forums. Although about configuration management in general it does have some areas dedicated to software build and release management.', 'http://www.cmcrossroads.com', 'images/links/cmcrossroads.jpg', 1);
INSERT INTO `links` VALUES (4, 0, '2007-11-24 18:47:09', 'kevin', 'StickyMinds.com', 'StickyMinds.com is a portal for software development but has some good, original articles and technical papers from industry experts on the build process. StickyMinds.com is the online companion to Better Software magazine.', 'http://www.stickyminds.com', 'images/links/stickyminds.jpg', 1);
INSERT INTO `links` VALUES (5, 0, '2007-11-24 18:48:42', 'kevin', 'IBM developerWorks', 'IBM developerWorks is the portal for IBM\\''s developer community. Although it focuses on IBMâ€™s software tool it also has sections dedicated to open source, Java and Linux â€“ where you can usually find some good technical articles about the build process.', 'http://www-128.ibm.com/developerworks', 'images/links/developerworks.jpg', 1);
INSERT INTO `links` VALUES (6, 0, '2007-11-24 19:02:33', 'kevin', 'JavaRanch', 'JavaRanch is a portal for Java development, it includes lots of articles and book reviews - many of which are related to the build process. Its forums are very actve and always a source of useful information.', 'http://www.javaranch.com', 'images/links/javaranch.jpg', 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `ratings`
-- 

DROP TABLE IF EXISTS `ratings`;
CREATE TABLE IF NOT EXISTS `ratings` (
  `id` mediumint(9) NOT NULL,
  `article_id` mediumint(9) NOT NULL,
  `user_id` mediumint(9) NOT NULL,
  `rating` tinyint(4) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `ratings`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `users`
-- 

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `username` varchar(32) NOT NULL,
  `password` varchar(32) default NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `userid` varchar(42) NOT NULL,
  `userlevel` tinyint(1) unsigned NOT NULL,
  `email` varchar(50) default NULL,
  `timestamp` int(11) unsigned NOT NULL,
  `notify` tinyint(1) NOT NULL default '0',
  `verifystring` varchar(16) NOT NULL,
  `active` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `users`
-- 

INSERT INTO `users` VALUES ('kevin', '9d5e3ecdeb4cdb7acfd63075ae046672', 'Kevin', 'Lee', '57acdbcaba5c993f059725dc2e7d89e8', 9, 'kevin.lee@buildmeister.com', 1195934128, 1, '', 1);
