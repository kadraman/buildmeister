-- phpMyAdmin SQL Dump
-- version 2.6.4-pl3
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Nov 25, 2007 at 02:17 PM
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

-- 
-- Dumping data for table `links`
-- 

INSERT INTO `links` VALUES (3, 0, '2007-11-24 18:43:48', 'kevin', 'CM Crossroads', 'CM Crossroads is the configuration management community online. It hosts lots of articles, product reviews, webcasts and discussion forums. Although about configuration management in general it does have some areas dedicated to software build and release management.', 'http://www.cmcrossroads.com', 'images/links/cmcrossroads.jpg', 1);
INSERT INTO `links` VALUES (4, 0, '2007-11-24 18:47:09', 'kevin', 'StickyMinds.com', 'StickyMinds.com is a portal for software development but has some good, original articles and technical papers from industry experts on the build process. StickyMinds.com is the online companion to Better Software magazine.', 'http://www.stickyminds.com', 'images/links/stickyminds.jpg', 1);
INSERT INTO `links` VALUES (5, 0, '2007-11-24 18:48:42', 'kevin', 'IBM developerWorks', 'IBM developerWorks is the portal for IBM\\''s developer community. Although it focuses on IBMâ€™s software tool it also has sections dedicated to open source, Java and Linux â€“ where you can usually find some good technical articles about the build process.', 'http://www-128.ibm.com/developerworks', 'images/links/developerworks.jpg', 1);
INSERT INTO `links` VALUES (6, 0, '2007-11-24 19:02:33', 'kevin', 'JavaRanch', 'JavaRanch is a portal for Java development, it includes lots of articles and book reviews - many of which are related to the build process. Its forums are very actve and always a source of useful information.', 'http://www.javaranch.com', 'images/links/javaranch.jpg', 1);
INSERT INTO `links` VALUES (8, 1, '2007-11-25 13:26:45', 'kevin', 'Daily Build and Smoke Test', 'Steve McConnel\\''s classic definition of a widely used practice.', 'http://www.stevemcconnell.com/ieeesoftware/bp04.htm', '', 1);
INSERT INTO `links` VALUES (9, 1, '2007-11-25 13:29:02', 'kevin', 'SCM Patterns for Agility', 'This site is about agile SCM a pragmatic approach to using software configuration management (SCM), especially version control, as part of an agile development environment. SCM is a key part of the software development toolkit and should be considered in the context of the architecture and the team dynamics.', 'http://www.scmpatterns.com/', '', 1);
INSERT INTO `links` VALUES (10, 1, '2007-11-25 13:30:35', 'kevin', 'Continuous Integration', 'Updated overview on Continuous Integration from the person responsible for originally defining the term - Martin Fowler.', 'http://www.martinfowler.com/articles/continuousIntegration.html', '', 1);
INSERT INTO `links` VALUES (11, 2, '2007-11-25 13:32:32', 'kevin', 'Long Build Trouble Shooting Guide', 'A discussion on how to keep build times to below 10 minutes for teams practising Continuous Integration.', 'http://www.google.co.uk/url?sa=t&ct=res&cd=1&url=http%3A%2F%2Fwww.thoughtworks.c', '', 1);
INSERT INTO `links` VALUES (12, 2, '2007-11-25 13:33:45', 'kevin', 'IBM Rational Build Forge', 'An Enterprise Build Management tool that provides an adaptive framework to automate repetitive tasks. Includes build server management, process acceleration, developer self-service (through IDE plug-ins) and automated bill-of-materials generation.', 'http://www-306.ibm.com/software/awdtools/buildforge/', '', 1);
INSERT INTO `links` VALUES (13, 2, '2007-11-25 13:34:47', 'kevin', 'dbdeploy', 'An open source database change management tool.', 'http://dbdeploy.com/', '', 1);
INSERT INTO `links` VALUES (14, 2, '2007-11-25 13:36:00', 'kevin', 'Continuous Integration Server Matrix', 'A feature comparison of a large number of open-source and commercial Build Control and/or Continuous Integration server tools. Not always kept up to date and sometimes inaccurate but still useful.', 'http://docs.codehaus.org/display/DAMAGECONTROL/Continuous+Integration+Server+Fea', '', 1);
INSERT INTO `links` VALUES (15, 2, '2007-11-25 13:36:46', 'kevin', 'CruiseControl', 'An open-source \\"Continuous Integration\\" toolkit which provides a wrapper around Apache Ant or Apache Maven to automatically execute and report on your builds.', 'http://cruisecontrol.sourceforge.net/', '', 1);
INSERT INTO `links` VALUES (16, 2, '2007-11-25 13:38:37', 'kevin', 'CruiseControl on a large scale', 'A brief description of how CruiseControl can scale to large enterprise organizations and projects.', 'http://www.pragmaticautomation.com/cgi-bin/pragauto.cgi/Build/CCOnALargeScale.rdoc', '', 1);
INSERT INTO `links` VALUES (17, 2, '2007-11-25 13:39:35', 'kevin', 'Apache Ant', 'A Java-based build tool which is the de-facto standard for compiling source code and creating distributions on Java projects. Ant is written in Java and is extensible, allowing the user to build on its features and facilities to integrate it with all manner of systems and tools.', 'http://ant.apache.org', '', 1);
INSERT INTO `links` VALUES (18, 2, '2007-11-25 13:39:57', 'kevin', 'Apache Maven', 'A software project management tool for Java projects, Maven is a build scripting framework coupled with a sophisticated project model for managing builds, reporting and document generation.', 'http://maven.apache.org', '', 1);
INSERT INTO `links` VALUES (19, 2, '2007-11-25 13:40:29', 'kevin', 'Microsoft Build', 'Microsoft\\''s new build platform for compiling and packaging Visual Studio projects. Similar in concept to Apache Ant, MSBuild is freely available with the .NET Framework redistribution package.', 'http://msdn2.microsoft.com/en-us/library/wea2sca5.aspx', '', 1);
INSERT INTO `links` VALUES (20, 2, '2007-11-25 13:41:35', 'kevin', 'Top 15 Ant best practices', 'A selection of best practices for Ant from the author of the Java Extreme Programming Cookbook. An old but useful link.', 'http://www.onjava.com/pub/a/onjava/2003/12/17/ant_bestpractices.html', '', 1);
INSERT INTO `links` VALUES (21, 2, '2007-11-25 13:42:22', 'kevin', 'Incremental and Fast Builds using Ant', 'In this article, Arin Ghazarian describes the concepts of incremental builds, dependency checking, and other related concepts in build processes, then proposes some techniques and guidelines to optimize and quicken builds written in Apache Ant.', 'http://www.javaworld.com/javaworld/jw-11-2005/jw-1107-build.html', '', 1);
INSERT INTO `links` VALUES (22, 2, '2007-11-25 13:43:32', 'kevin', 'Taking the Maven 2 plunge', 'Make was quite a handy tool in its day. Ant has revolutionized automated builds. Maven has taken build transparency and automated development and deployment to a whole new level. If you haven\\''t caught the maven bug yet, it\\''s time to take a deeper look now that the next generation - Maven 2 - is available.', 'http://www.developer.com/open/print.php/10930_3552026_1', '', 1);
INSERT INTO `links` VALUES (23, 2, '2007-11-25 13:44:33', 'kevin', 'Better Builds with Maven', 'A free and comprehensive introduction to Maven 2 bought to you by some of the main contributors to the Maven project and the kind people at Mergere.', 'http://www.devzuz.com/web/guest/products/resources#BBWM', '', 1);

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

INSERT INTO `users` VALUES ('abhanga', 'e58b7960f69ce753cc1b0b40ebd48e05', '', '', '', 0, 'abhanga@hotmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('abond07973', 'ed788b762de4df1750608a775d6b245d', '', '', '', 0, 'abond07973@lacanapa.info', 0, 0, '', 1);
INSERT INTO `users` VALUES ('achandram', '90745a979a0d71635785aa91aa782f42', '', '', '', 0, 'sekhar_26@yahoo.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('AdamL', 'fd1b05c1fcbe06caf1a2c133e3368236', '', '', '', 0, 'adam.leggett@upco.co.uk', 0, 0, '', 1);
INSERT INTO `users` VALUES ('admin', '280d085c44178e2a92874650e5d148bd', 'Administrator', '', '95abbc3f49bf191d67eaf1b03142f3e7', 0, 'webmaster@buildmeister.com', 1195995683, 0, '', 1);
INSERT INTO `users` VALUES ('adonica', '7eb8643d67e1090575d52c3a3052bc8f', 'Adonica Gieger', '', '', 0, 'adonica@adonica.co.uk', 0, 0, '', 1);
INSERT INTO `users` VALUES ('agt07973', 'ed788b762de4df1750608a775d6b245d', '', '', '', 0, 'agt07973@lacanapa.info', 0, 0, '', 1);
INSERT INTO `users` VALUES ('akapania', '6eb4a803e6d868f42f32fd6bd6bfa907', '', '', '', 0, 'arunk@cheerful.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('akkachotu', '40be4e59b9a2a2b5dffb918c0e86b3d7', '', '', '', 0, 'akkachotu@gmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('AMARNATH', '57af3bd30278d02e646491fb166322e0', '', '', '', 0, 'amarnathk@zensoftservices.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('amirinator', '3fffe0ab762e70fc41410fefb32c97bd', '', '', '', 0, 'anashat@paxonix.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('amiya_98', 'ffc150a160d37e92012c196b6af4160d', '', '', '', 0, 'amiyapanigrahi@rediffmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('andydo', 'e99a18c428cb38d5f260853678922e03', '', '', '', 0, 'andydo@adelphia.net', 0, 0, '', 1);
INSERT INTO `users` VALUES ('andyglick', 'abebf063d750438b4846c2fdd1797e72', '', '', '', 0, 'andyglick@acm.org', 0, 0, '', 1);
INSERT INTO `users` VALUES ('annudjm', 'fb86b534902594bbaeac9a22e474539b', '', '', '', 0, 'annudjm@gmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('antonkim', '97d42084ae204019f65b624c15fe2def', 'Anton Kim', '', '', 0, 'antonkim@gmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('asd31658', 'ed788b762de4df1750608a775d6b245d', '', '', '', 0, 'asd31658@gigantegassoso.info', 0, 0, '', 1);
INSERT INTO `users` VALUES ('astrhea', 'd5750f47eb25dfd76318d83a00bab8da', '', '', '', 0, 'astrhea@gmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('AtInter', 'b74d36e1053525990dac8d48a48cef17', '', '', '', 0, 'AtInterquad15@hotmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('avo_micro', '84d619cabc58db2901c0fc7de973720a', '', '', '', 0, 'avo@microdoc.de', 0, 0, '', 1);
INSERT INTO `users` VALUES ('awylie', '9d593bb92502e2cb534078460e745762', '', '', '', 0, 'awylie@curamsoftware.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('balap6', '38482652751dd8d03bbb48a53fec5451', '', '', '', 0, 'balap6@gmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('bbiggi', '4cbfb608425a30922e721369b7a1b374', '', '', '', 0, 'brian.j.biggi@lmco.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('bdgdsn04', '96397df25f092f4b9144c266fbd45f6a', '', '', '', 0, 'ravindrajain04@rediffmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('bdoenges', '819e15198e8464a6103b7c0958a26011', '', '', '', 0, 'barbara.doenges@mci.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('benallel', '9b43b402829239337afa71492af41a0c', '', '', '', 0, 'd_benallel@yahoo.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('bgamble', '5bd87f96f145733d33a8a32168832a00', '', '', '', 0, 'bjgamble@austin.rr.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('bigmadkev', 'b116950a795294a81fb2af5148ff6759', '', '', '', 0, 'kev@inner-rhythm.co.uk', 0, 0, '', 1);
INSERT INTO `users` VALUES ('BigShot', '5f4dcc3b5aa765d61d8327deb882cf99', '', '', '', 0, 'junkyard17@hotmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('bm777', '32de1044192a44e0ef8144f942585272', '', '', '', 0, 'echtri55@yahoo.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('boochingha', '0a39e3fdfcb8077452e58f9b2a02a40b', '', '', '', 0, 'chboo@ipowerbiz.com.my', 0, 0, '', 1);
INSERT INTO `users` VALUES ('boxhead201', '33ac0d39328e33fa8619b59fc05a1480', '', '', '', 0, 'prowe2@yahoo.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('brezbl', '3858f62230ac3c915f300c664312c63f', '', '', '', 0, 'blake.brezeale@wnco.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('bsalalin', 'c99c076003aa2e7953970d9494975298', '', '', '', 0, 'benoit.salaun@sgcib.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('buddha33', 'e435e70033e0d3b533ee307238a2665b', '', '', '', 0, 'medavie.scm.resource@gmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('buendia', '6495c58dc5cda57595a52a9853378fdc', '', '', '', 0, 'marcelo_labardini@us.ibm.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('buildmgr', '670b14728ad9902aecba32e22fa4f6bd', '', '', '', 0, 'kane.arvin@yahoo.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('BusterFuzz', '5dc554d20213f2e00903dcc82bb440b5', '', '', '', 0, 'busterfuzz@gmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('butterman', 'd6a6bc0db10694a2d90e3a69648f3a03', '', '', '', 0, 'jhalkedis@netzero.net', 0, 0, '', 1);
INSERT INTO `users` VALUES ('byrden_j', '4fc9baf210346939946d5a49f255588b', '', '', '', 0, 'jimmy.byrden@vhi.ie', 0, 0, '', 1);
INSERT INTO `users` VALUES ('cahern', '78a1a7bba9150e1922a1a2f4070fedd0', '', '', '', 0, 'charlieahern@redscaffold.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('cashltd', '3506cab9acd2704ccc118a3f7101d1fd', '', '', '', 0, 'sean.h.kragh@wellsfargo.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('ccarrasco', '028da916acba257809f2736fbc115ede', '', '', '', 0, 'carolina.carrasco@ing.cl', 0, 0, '', 1);
INSERT INTO `users` VALUES ('cchew', '0fe946c9404782e106ca5683dd8b8284', '', '', '', 0, 'ching.chew@gmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('cfribbins', 'e389cb43132a236f3c11e96d4557a28e', '', '', '', 0, 'chris.fribbins@rbs.co.uk', 0, 0, '', 1);
INSERT INTO `users` VALUES ('cheister', '3b8b11224cff58ea2a99b414d8979001', '', '', '', 0, 'chris.heisterkamp@airplay.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('chengwei', '0ce1737a72af40cd3d50afbd039268df', '', '', '', 0, 'chengwei@crimsonlogic.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('chitral', 'deb2fb335003a340d5b2beb970184456', '', '', '', 0, 'g_chitralekha@gmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('chitraleka', 'deb2fb335003a340d5b2beb970184456', '', '', '', 0, 'gchitralekha@gmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('ChrisGWarp', 'a6ea36e77d25e51eef39229aa05d2cbf', '', '', '', 0, 'chrisg@warpspeed.com.au', 0, 0, '', 1);
INSERT INTO `users` VALUES ('ckmason', 'b455f7ec12b4843b617338d4329b28f3', '', '', '', 0, 'carlton.mason@gmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('cmercier', 'a821cd35ae9e617f483590c4a471df71', '', '', '', 0, 'craig.mercier@sungard.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('coolnattu', '54410d753e6684c2824cb2113afcd5f6', '', '', '', 0, 'natarajan.a@polaris.co.in', 0, 0, '', 1);
INSERT INTO `users` VALUES ('corinnekry', '1a7acf239b3aa2c3535014d6f0860216', '', '', '', 0, 'corinnekrych@hotmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('csernoskie', '5f4dcc3b5aa765d61d8327deb882cf99', '', '', '', 0, 'c.sernoskie@telesat.ca', 0, 0, '', 1);
INSERT INTO `users` VALUES ('curmudjim7', '81e63bb65e60212f7838650352bb1f07', 'James Reed', '', '', 0, 'jim-reed@comcast.net', 0, 0, '', 1);
INSERT INTO `users` VALUES ('d98117', '701d15538ffb5ca454b30e7734272cd6', '', '', '', 0, 'Cliff.Swyningan@efunds.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('DanEvans', '85e4ccae6396fffa56f6117e4fce8e67', '', '', '', 0, 'dannyboy.evans@gmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('DanOmahony', 'b0da275520918e23dd615e2a747528f1', '', '', '', 0, 'daniel.omahony@gmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('daudette', '47accdcd8967de0b55a6582fb4875456', 'Daniel Audette', '', '', 0, 'daniel_audette@agilent.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('daumas', '647429291c48185515abce75666c0c99', '', '', '', 0, 'daumas@us.ibm.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('davidip', '8187dc8b85fd9005373e71d9e7422471', '', '', '', 0, 'davidip2280@yahoo.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('Dennis', '8bdaa0a969b4c0f93b32aadd2650de4a', '', '', '', 0, 'ulakar@gmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('dipalis', 'a4b3530fdb5f61b5e850c0e87c2a4cf2', '', '', '', 0, 'dipali_sunkersett@yahoo.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('directneha', 'ab449b84b0ba7d1001dad962736dcad2', '', '', '', 0, 'direct2neha@yahoo.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('dmauney', '6363d6268415d2f18ae9e3ffe4088b9c', '', '', '', 0, 'builder@mauneys.cjb.net', 0, 0, '', 1);
INSERT INTO `users` VALUES ('dneyman', 'c37c88c116512456d7a7094ba9858a8f', '', '', '', 0, 'dneyman@gmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('dnimmo', 'ba35d3f0141473854d888e2251393bc6', '', '', '', 0, 'david.nimmo@au1.ibm.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('dodos', '6c81ac777139cf1c35b8327288253d83', '', '', '', 0, 'vatos_l@hotmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('doron', '2637a701ac0d5d7eb772e1dab407746f', '', '', '', 0, 'doron.solomon@oz.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('dpilarz', 'b50ac41ec20631c7b6be72f070d8ff67', 'Don Pilarz', '', '', 0, 'don.pilarz@ericsson.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('dsameer', '6eab7e9a55fe1a209f5eb8556888e45f', '', '', '', 0, 'dsameer@rocketmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('duong07', '0f17377981d15100583e919a1c3d384c', '', '', '', 0, 'duong07@hotmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('EastCoast1', '5449b0e52a89d0a28351e5affd7ae26c', '', '', '', 0, 'murugesan.saravanakumar@wipro.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('eddytone', '00822ba74e9f7cd8f7ed4509c4a1b96c', '', '', '', 0, 'eddytone@naver.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('edgey', '5d771e01cf7233635415e1351da2b7ae', '', '', '', 0, 'sop_web@yahoo.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('eknutson', 'bf301092c9a2469bfb6c5afb11d07892', '', '', '', 0, 'eric_knutson@bluecrossmn.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('ellisonp', '42d388f8b1db997faaf7dab487f11290', '', '', '', 0, 'paul.ellison@uk.abnamro.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('emperor', '37b43a655dec0e3504142003fce04a07', '', '', '', 0, 'sreeramk@hotmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('endunn', '982f392cd0527714f4219c5d49389464', '', '', '', 0, 'ericndunn@gmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('eriklundh', 'da2db9c6b7df2f1232d091e7db0a4c56', '', '', '', 0, 'erik.lundh@compelcon.se', 0, 0, '', 1);
INSERT INTO `users` VALUES ('ErnestHi11', '935ea511a41fe88dfd359502f9e407f4', '', '', '', 0, 'ernest.h.hill@irs.gov', 0, 0, '', 1);
INSERT INTO `users` VALUES ('esevland', 'ca8785bbec0dcac5a81451efc604f2fa', '', '', '', 0, 'esevland@constantcontact.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('essoussi', '6a1d121041978952dfefdf95523a31fc', '', '', '', 0, 'hans@essoussi.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('esweber78', '87cdfa907e409442cbe0dbd0ef6e752a', '', '', '', 0, 'esweber@gmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('Eva-Lynne', '170874a06a6ab9f8d3d547863735e4e5', '', '', '', 0, 'evalynne@gmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('fadongle', 'ea3596139530b2abe7089082ab57ecbd', '', '', '', 0, 'fadongle@163.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('fjgilroy', 'f64e612ea88f56514dbb2d1213d330fa', '', '', '', 0, 'fjgilroy@gmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('flarsson', 'a386a936657022f4281b46d755f9807b', '', '', '', 0, 'fredriklarss@gmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('foggy', 'e9c4bb7e20067b5707c2c1c7375f549e', '', '', '', 0, 'laura.phillipson@rhe.co.nz', 0, 0, '', 1);
INSERT INTO `users` VALUES ('frecl', '730603ba64c58a1fca8caf7a118f1259', '', '', '', 0, 'fredrik.claesson@gmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('fsprengers', '5fecc143b32efdc0a188d4adce4c1d13', '', '', '', 0, 'frank.sprengers@cz.nl', 0, 0, '', 1);
INSERT INTO `users` VALUES ('ganapathy', 'e9f852b0a8547ec23698fc6bcd85a818', '', '', '', 0, 'raj.ganpat@yahoo.co.in', 0, 0, '', 1);
INSERT INTO `users` VALUES ('garavid', '59801db1ff70bf876579810c76b5fec2', '', '', '', 0, 'donald.garavito.ctr@osd.mil', 0, 0, '', 1);
INSERT INTO `users` VALUES ('gavin', '01cfe8113c97244f0b84223e1f64d820', '', '', '', 0, 'gavin.clarke@gs.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('gcullen', 'b8cc059a54fd5dbf77e0a34b6ce4c30e', '', '', '', 0, 'gcullen@yahoo.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('georggr', '73dbea9764f56cf927d470dc4643ca3d', '', '', '', 0, 'georggr@gmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('gindr', '66c271787d1b254c03c5706065c12c62', '', '', '', 0, 'g_rai1@yahoo.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('gkubaczkow', 'bdf12dea0742a93de7ae2f848b9be026', '', '', '', 0, 'greg.kubaczkowski@utoronto.ca', 0, 0, '', 1);
INSERT INTO `users` VALUES ('glennoph', 'ca91d8c7a27320c8c6312411eef4d7d1', 'Glenn Opdycke-Hansen', '', '', 0, 'glennoph@gmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('go1vols', '29bc1e81aa19b0f2f86b88ad41184e74', '', '', '', 0, 'hillvolfan@gmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('gpkirk', '8adbb98cf891e1cc373c30e93655b88a', '', '', '', 0, 'geoffkirk@gmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('gregallen', '48f1c134537469a5f071e75f60e93c99', '', '', '', 0, 'greg.allen.i9is@statefarm.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('gsusie', '57b646bab9c5d88da6b94bd223612ca6', '', '', '', 0, 'gsusiesmith@yahoo.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('harminder', 'e6a52c828d56b46129fbf85c4cd164b3', '', '', '', 0, 'v2harry@us.ibm.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('hathwar', '55136b321111fcc7aad0a46ebe7652d9', '', '', '', 0, 'prashanthkit@gmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('heavydawso', '924dac7e3d9e9957edeab7473c25d293', 'David Corley', '', '', 0, 'david.corley@ericsson.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('htran0424', 'adf4d580055115eac27b2ab5ac35bb6b', '', '', '', 0, 'Hien_Tran0424@yahoo.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('hwerner23', '35d969152d376ac47e676734f2b31da1', '', '', '', 0, 'hardwer@earthlink.net', 0, 0, '', 1);
INSERT INTO `users` VALUES ('iambharath', '14e2f0ddf2f88e34b78d68226af5705c', '', '', '', 0, 'iambharathrama@gmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('icecolor', '8dbdda48fb8748d6746f1965824e966a', '', '', '', 0, 'icecolor@gmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('imosby', 'f1f3c01a9b7a4b918db0f3a97e9fe1a9', '', '', '', 0, 'imosby@yahoo.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('indrg', 'c82138c7e01ad922b0a58fdd33c3a91c', '', '', '', 0, 'indrg@yahoo.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('ita583buil', 'ed788b762de4df1750608a775d6b245d', '', '', '', 0, 'ita583buil@agnitumhost.net', 0, 0, '', 1);
INSERT INTO `users` VALUES ('j31416pi', '56fcca86709d859bb03cbc8730ed99a6', '', '', '', 0, 'j31416pi@hotmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('jacklunn', '3ba7116e06720f8bf540e6d7a80081e1', '', '', '', 0, 'jacklunn@gmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('jbanham', '3626fe5abfc026711e79c0fbf9b29baf', '', '', '', 0, 'build@ajrb.eclipse.co.uk', 0, 0, '', 1);
INSERT INTO `users` VALUES ('jbogard', '68ce1f0516a48b1580bfecf1fbf5a6f8', '', '', '', 0, 'james_bogard@dell.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('jbseenu', '26b2e5a02b2d64ed6b72e5fb453015f9', '', '', '', 0, 'jbseenu@gmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('jdcruz', 'ae2b1fca515949e5d54fb22b8ed95575', '', '', '', 0, 'jdcruz@dodgeit.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('jdillonusa', 'fea0f1f6fede90bd0a925b4194deac11', '', '', '', 0, 'jdillonusa@yahoo.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('JeromeAB', 'd7d7d4bf14e4cdc3eeedc2e029b7599e', '', '', '', 0, 'junkmail@yosemitek.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('JGHowland', '6e0cbf9a432c32a7758d1bdc13aad971', 'John Howland', '', '', 0, 'JGHowland@gmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('jim-reed', '119a9bcce4487f66af44661dc20c20e2', '', '', '', 0, 'jreed@ciber.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('jolog', 'ae2b1fca515949e5d54fb22b8ed95575', '', '', '', 0, 'super_jologs@yahoo.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('joosh', 'e10adc3949ba59abbe56e057f20f883e', '', '', '', 0, 'jshjoel@yahoo.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('jpapo', 'd2ce0caefa337651d640de76a756e60b', '', '', '', 0, 'jose.papo@gmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('jrnicl2', 'abd7372bba55577590736ef6cb3533c6', '', '', '', 0, 'jrnicl3@yahoo.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('juergen', '2aee1c40199c7754da766e61452612cc', '', '', '', 0, 'bieblj@msg.de', 0, 0, '', 1);
INSERT INTO `users` VALUES ('jwilson', '4c141df05991898bbb332fbbc7016b39', 'James Wilson', '', '', 0, 'jwilson@trinem.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('kai_jing', 'eb8070182dab16458387017b42bb37da', '', '', '', 0, 'kai_jing@hotmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('kakto31658', 'ed788b762de4df1750608a775d6b245d', '', '', '', 0, 'kakto31658@gigantegassoso.info', 0, 0, '', 1);
INSERT INTO `users` VALUES ('kaluza', 'b19a4059a8254a35bbed1313e03eb467', '', '', '', 0, 'klein.kaluza@gmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('kalyan', '261c9009c551ab7785ff22dc26289313', '', '', '', 0, 'kalyan_es@yahoo.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('karenigan', '9cd8a21f9fe79f4b447dbf2b21e6d783', '', '', '', 0, 'karen.mcadams@workstreaminc.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('kevin', '0de113c625a62c02bf56b3aa112160d0', 'Kevin', 'Lee', '6c247427817bbb29a6503e67a5d22978', 0, 'kevin.lee@buildmeister.com', 1196000225, 0, '', 1);
INSERT INTO `users` VALUES ('khmarbaise', 'c6526709b9e84efbc84f5f6295b937d8', '', '', '', 0, 'buildmeister@soebes.de', 0, 0, '', 1);
INSERT INTO `users` VALUES ('kietlam', 'b2fe486d5849342a4dafeb6a49b1c5ca', '', '', '', 0, 'kietlam@netscape.net', 0, 0, '', 1);
INSERT INTO `users` VALUES ('kiruba', '19e3ea97d9a7f46fffce213ddbf7a9df', '', '', '', 0, 'nkkirubakaran@gmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('klotz', '9932d25f1d6099025315c5991886999d', '', '', '', 0, 'tobias.klotz@gmx.de', 0, 0, '', 1);
INSERT INTO `users` VALUES ('klotzt', '9932d25f1d6099025315c5991886999d', '', '', '', 0, 'tobias.klotz@draeger.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('kpkuykend', '2fa6ad1c9f7d514e114810adbdeab576', '', '', '', 0, 'kpkuykend@hotmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('ksambaiah', 'cc03e747a6afbbcbf8be7668acfebee5', '', '', '', 0, 'sambaiah.kilaru@wipro.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('ktest', '5f4dcc3b5aa765d61d8327deb882cf99', '', '', '', 0, 'kelee71@btopenworld.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('ktest2', '5f4dcc3b5aa765d61d8327deb882cf99', '', '', '', 0, 'chat2kevin@googlemail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('kzimmerli', 'c465e2b8daa2730f148322180bd19991', '', '', '', 0, 'zimmerlk@stratcom.mil', 0, 0, '', 1);
INSERT INTO `users` VALUES ('k_ajik', '9b38f878eb7d6f19b11a2093d7be065d', 'Ajit', '', '', 0, 'ajit.kannan@gmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('landisjp', '122e6d4dfcd49998eac780896d0d88ae', '', '', '', 0, 'landisjp@maritz.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('lazar07973', 'ed788b762de4df1750608a775d6b245d', '', '', '', 0, 'lazar07973@acser.info', 0, 0, '', 1);
INSERT INTO `users` VALUES ('lazar31658', 'ed788b762de4df1750608a775d6b245d', '', '', '', 0, 'lazar31658@abiesalba.info', 0, 0, '', 1);
INSERT INTO `users` VALUES ('levtar', 'ace8dedb52cec214b1fdf16dec55df74', '', '', '', 0, 'levt@dbmotion.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('lkadmiri', '52862489f95c5ab1682807f7866f7683', '', '', '', 0, 'tounzi@hotmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('lmaes', 'aa4d363ab69ea9df4488810d70bbc227', '', '', '', 0, 'luc.maes@telenet.be', 0, 0, '', 1);
INSERT INTO `users` VALUES ('lmcpare', '6fda27264f8154abdb6ed31bd701a8e5', 'Patrick Renaud', '', '', 0, 'patrick.renaud@ericsson.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('luisgarcc', '36686d8d2277e5e9572373fe59688680', '', '', '', 0, 'garciala@us.ibm.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('l_garrity', 'a26b83791081a40c630d8d5c7a204504', '', '', '', 0, 'garrity@uk.ibm.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('mahmoodt', 'b89dc80fb627dbdcfe7d8e03876985d8', '', '', '', 0, 'tahir.mahmood@symbian.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('makagon', 'f35239ce32a78302e45d5e856bde5891', '', '', '', 0, 'pm@computer.org', 0, 0, '', 1);
INSERT INTO `users` VALUES ('mamiri', '5f4dcc3b5aa765d61d8327deb882cf99', '', '', '', 0, 'mehdi.amiri@ask.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('marcus', 'd6fe10899d636ffacf1ba8847a6c8fff', '', '', '', 0, 'marcusgatte@yahoo.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('MarioCOluz', '8ac11ed1f9455f92923442f9fce1a1f8', 'Mario', '', '', 0, 'mariocoluzzi@hotmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('Mark', '47b06804cbc093a5fffb18aff6aaf302', '', '', '', 0, 'mark.stellaard@philips.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('marks', 'd48124e03d646d7bdf0ba9b335983d84', '', '', '', 0, 'msilva123@yahoo.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('Masood', '8eb58dd5e328e978169c7b0cbd30d43f', '', '', '', 0, 'masood.java@gmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('matsnils', '5020a545f43a0bd16ff18f615707e77d', '', '', '', 0, 'mats.nilsson@gafvelin.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('maven06', '6f9eae90b2b4d5b6830516306dc2e1c7', '', '', '', 0, 'lifequest_info@yahoo.ca', 0, 0, '', 1);
INSERT INTO `users` VALUES ('mbonfig', 'cfc10f575c6d9d302e77d15e50e87546', '', '', '', 0, 'drfig@hotmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('mclark', '1e46ed619f4e018001a2d2fbb2d37731', 'Michael', '', '', 0, 'mclark@phtcorp.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('mdawar', '89c87f73ac5f1dbe66fa45cb7cc55d3e', '', '', '', 0, 'mdawar@gmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('mdgarrison', '0967b7601de646a217750b70685740fa', '', '', '', 0, 'mgarriso@acninc.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('mdthomas', '7b8b08ba43f9784f370d8341ccc28b58', 'Dudley Thomas', '', '', 0, 'mdthomas@us.ibm.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('mebruner', '54b138bc1b8fbd63869c3fc12409f7ed', '', '', '', 0, 'mebruner@gmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('meher03', '81906818529a060facd5655d4e4e3163', '', '', '', 0, 'meher03@yahoo.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('meixner', 'b79832acb7356da1db8d1ac41e6ca441', '', '', '', 0, 'meixner@informatik.fh-augsburg.de', 0, 0, '', 1);
INSERT INTO `users` VALUES ('mgarrison', 'aa437dfb527dedd1a93a3ca67a0c4b21', '', '', '', 0, 'mgarrison267370mi@comcast.net', 0, 0, '', 1);
INSERT INTO `users` VALUES ('mhisatomi', '70ac330e13026573806b949a70803055', '', '', '', 0, 'mhisatomi@yahoo.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('mhorn', '20a24c17a5c3b989bf602206d045739b', '', '', '', 0, 'mhorn@acm.org', 0, 0, '', 1);
INSERT INTO `users` VALUES ('mikki2000', '717698399e7d3d8a84bd79eb1da0489f', '', '', '', 0, 'mikki2000@web.de', 0, 0, '', 1);
INSERT INTO `users` VALUES ('mingramma', '8a95dc2460006f7568c5ae68d0d2f5d5', '', '', '', 0, 'mari.ingram@us.ibm.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('mirjana', 'd5750f47eb25dfd76318d83a00bab8da', '', '', '', 0, 'petrovic@ali.com.au', 0, 0, '', 1);
INSERT INTO `users` VALUES ('mmartin', 'b1b21a7610f9aa3a07999207aef911cc', '', '', '', 0, 'mmartin@insureworx.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('mmawuru', '1c4da8c84d3caa31dd21c7c9da2a1e23', '', '', '', 0, 'mmawuru@gmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('mnloka', '4161baca082dbfd53fe9447ce12a4bb6', '', '', '', 0, 'mnloka@rogers.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('mrichard13', '389a37bb26b3b1668eadbe678c6822c4', '', '', '', 0, 'mrichard@hanover.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('mzmanir', '25d55ad283aa400af464c76d713c07ad', '', '', '', 0, 'mzmanir@yahoo.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('nagender', '42bb64e9203109d3fd858f67f8dfaebf', '', '', '', 0, 'nagender_malik@hotmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('nallurimur', '53cf5f247df8e09a003a3160aaa3f2b5', '', '', '', 0, 'nallurisubscriptions@yahoo.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('nasmajoh', 'f864ac4b5cd1537780f185849b9e7543', '', '', '', 0, 'john.nasman@luukku.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('nate6200', '80e86b9efc58dfe7d2406ab15fff4a4d', '', '', '', 0, 'njohnson9@rochester.rr.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('nate_6200', '80e86b9efc58dfe7d2406ab15fff4a4d', '', '', '', 0, 'njohnson@sdi.xerox.org', 0, 0, '', 1);
INSERT INTO `users` VALUES ('nbohra', 'c21d79b61ea08b585ec318bfa4a422e9', 'Ninju Bohra', '', '', 0, 'ninju_bohra@yahoo.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('neo227buil', 'ed788b762de4df1750608a775d6b245d', '', '', '', 0, 'neo227buil@agnitumhost.net', 0, 0, '', 1);
INSERT INTO `users` VALUES ('neo664buil', 'ed788b762de4df1750608a775d6b245d', '', '', '', 0, 'neo664buil@agnitumhost.net', 0, 0, '', 1);
INSERT INTO `users` VALUES ('neo699buil', 'ed788b762de4df1750608a775d6b245d', '', '', '', 0, 'neo699buil@agnitumhost.net', 0, 0, '', 1);
INSERT INTO `users` VALUES ('neo942buil', 'ed788b762de4df1750608a775d6b245d', '', '', '', 0, 'neo942buil@agnitumhost.net', 0, 0, '', 1);
INSERT INTO `users` VALUES ('neo943buil', 'ed788b762de4df1750608a775d6b245d', '', '', '', 0, 'neo943buil@agnitumhost.net', 0, 0, '', 1);
INSERT INTO `users` VALUES ('neo964buil', 'ed788b762de4df1750608a775d6b245d', '', '', '', 0, 'neo964buil@agnitumhost.net', 0, 0, '', 1);
INSERT INTO `users` VALUES ('neo971buil', 'ed788b762de4df1750608a775d6b245d', '', '', '', 0, 'neo971buil@agnitumhost.net', 0, 0, '', 1);
INSERT INTO `users` VALUES ('nerenjain', '4acb2b4b8851a4bd6e344ef814072250', '', '', '', 0, 'nerenextra@gmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('newiz07973', 'ed788b762de4df1750608a775d6b245d', '', '', '', 0, 'newiz07973@acser.info', 0, 0, '', 1);
INSERT INTO `users` VALUES ('nielsend', '5f4dcc3b5aa765d61d8327deb882cf99', '', '', '', 0, 'david_r_nielsen@hotmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('offline', '6599f1dd487fcd7db384043e41a852c6', 'offline', '', '', 0, 'offline@buildmeister.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('papuga', 'bdf12dea0742a93de7ae2f848b9be026', '', '', '', 0, 'greg.k@canada.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('paulie', 'b06ee0845c261e8e002247c4bb8e9dfe', '', '', '', 0, 'paul_collins@online.ie', 0, 0, '', 1);
INSERT INTO `users` VALUES ('pcnax31658', 'ed788b762de4df1750608a775d6b245d', '', '', '', 0, 'pcnax31658@gigantegassoso.info', 0, 0, '', 1);
INSERT INTO `users` VALUES ('peternor', '3406e9a9592dfe7dd20fd5fbec0cb271', '', '', '', 0, 'peter.norbury@uk.fid-intl.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('pguser', '17778a7aed84e7046ee15dca6c27f933', '', '', '', 0, 'pguser@gmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('phamilton', '42d388f8b1db997faaf7dab487f11290', '', '', '', 0, 'paul@sheepish.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('phanguye', '4cf768247340141f940f2263fe5fffef', '', '', '', 0, 'nguyenphat@yahoo.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('pjsousa', '1e6708acd2597db31e9526a62d7c797b', '', '', '', 0, 'ppintosousa@gmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('pnebhnani', '14764db85f7ffb0cef19ef030a6d5eed', '', '', '', 0, 'pnebhnani@hotmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('prasad', '8873eb99ee207fc7427068b03fc45e19', '', '', '', 0, 'katikireddyp@sify.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('prasanta', '79cfac6387e0d582f83a29a04d0bcdc4', '', '', '', 0, 'praschau@in.ibm.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('psrinivas', '9ca21b2ed921aaa7cffa32d9096b5853', '', '', '', 0, 'srinivas.panchakarla@citi.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('rabind', '577044d72e9f3d7b01c166519c1f1cd4', '', '', '', 0, 'srabindranath@yahoo.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('raghu', 'ab9e3e0399b0469dd1bb763413b0080f', '', '', '', 0, 'srinivasaiah_raghavendra@emc.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('rahulwulan', 'a3e8f43f243ebc0cefa6ba81f52bbdf5', '', '', '', 0, 'rahulwulan@gmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('randeffect', 'f88aeadb7612a2a2f538845210551980', '', '', '', 0, 'greg@randeffects.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('raymond', '8530608ef7631cb943f52b445b6dd300', '', '', '', 0, 'xusc2004@gmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('rhassey', '79995ec27e13ea689b071a74b2e05c37', '', '', '', 0, 'richard.hassey@wamu.net', 0, 0, '', 1);
INSERT INTO `users` VALUES ('rjunque', '4006534e9c8e09e052a9600daeb37b3e', '', '', '', 0, 'rjunq@uol.com.br', 0, 0, '', 1);
INSERT INTO `users` VALUES ('rmalachi', '125f320902aaeded1a5dcc50c5e8e8bb', '', '', '', 0, 'malachi_ron@hotmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('rprasad', '2bbce2aaed68c1707c257a1856262f1f', '', '', '', 0, 'rshivareddy@hotmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('rsanfo', 'b941c2463ac386aae21ef71cf4d30aaa', 'Reid Sanford', '', '', 0, 'reid.sanford@nike.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('ryep1', 'ab337c34de23ee3b5a126419954ce825', '', '', '', 0, 'robert_yep@yahoo.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('sabgray', 'f20ec73bd5d7fc80bd299d38edc00dcc', '', '', '', 0, 'sgray@biteknc.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('Samonja', '348a1c23a5373831bdb1d8934a10a98a', '', '', '', 0, 'hagen_friends@mail.ru', 0, 0, '', 1);
INSERT INTO `users` VALUES ('sandeepj2e', '6a44840b70bcb02bf6d31979998af798', '', '', '', 0, 'sandyvedi786@yahoo.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('sanjeevakp', '5d0a0a96f24997386fa151b394a3e681', '', '', '', 0, 'sanjeevakp@yahoo.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('Santosh', 'a6f30815a43f38ec6de95b9a9d74da37', '', '', '', 0, 'santosh.pagare@neilsoft.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('savithari', '6b3f0b3a0cac070419617a1d0b5f7be7', '', '', '', 0, 'savithari@gmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('sbrochelle', 'cba9fe13f08d875808c63432486ce807', '', '', '', 0, 'sbrochelle@gmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('SchwaBer', '854f459e16b99209a93e9efd73fb0f7b', '', '', '', 0, 'bernhard.schwarz.ext@siemens.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('SchwarzB', 'c3c86ad94fd50e37912d1a09049b16d1', '', '', '', 0, 'bernhard.schwarz@web.de', 0, 0, '', 1);
INSERT INTO `users` VALUES ('sebwong', 'f1afdfb40d0250309f246a4c7bd949f1', '', '', '', 0, 'seb_wong@hotmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('shibukraj', '6971803176215fd001c5428343308b65', '', '', '', 0, 'shibukraj@gmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('skanda', '2a61562f14499daf3ad418f018c79c06', '', '', '', 0, 'skandakumar.malpe@exensys.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('SLipscombe', 'e1155cbac9e202f4b447c1a3db3bf040', '', '', '', 0, 'slipscombe@yahoo.co.uk', 0, 0, '', 1);
INSERT INTO `users` VALUES ('softvenu', '0162cefc4952304026cb1f5dab2419d2', '', '', '', 0, 'BVenugopal@novell.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('sp66267', '9ca21b2ed921aaa7cffa32d9096b5853', '', '', '', 0, 'sp66267@citi.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('srinivas', '0280a430e35fee634f01cbc5a8178864', '', '', '', 0, 'kon_srinivas@yahoo.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('stevenhale', 'c7656ce3fbb462c82bad4e11fc7f4165', '', '', '', 0, 'steven.hale@sbab.se', 0, 0, '', 1);
INSERT INTO `users` VALUES ('steve_geo', '11a7f956c37bf0459e9c80b16cc72107', '', '', '', 0, 'steve_geo@optusnet.com.au', 0, 0, '', 1);
INSERT INTO `users` VALUES ('strongus', 'cb5562d99d2ea53eca20d3d0c78c38d2', '', '', '', 0, 'strongus_us@yahoo.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('subra', '68f44f3e44f17c01e8b8b775d6c84880', '', '', '', 0, 'subramanianr@hcl.in', 0, 0, '', 1);
INSERT INTO `users` VALUES ('subraplus', '68f44f3e44f17c01e8b8b775d6c84880', '', '', '', 0, 'subraplus@sify.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('sukar', '714606e8be8babec367de7fc0133e062', '', '', '', 0, 'msc.karthikeyan@gmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('sukhdevftb', '70a2c749e233ecfc8c4fe2e049e0ed0a', '', '', '', 0, 'sukhdevd5@yahoo.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('svak', '94a53ce4e9a3da738c31ec7a54b24b57', '', '', '', 0, 'jers@ramboll-informatik.dk', 0, 0, '', 1);
INSERT INTO `users` VALUES ('tabuchid', '07f5f7b7e7602bafe7050c964dcead55', '', '', '', 0, 'drtabuchi@gmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('tcondit', '2df9c4dee25b2184764f06e1d605e715', '', '', '', 0, 'tcondit@gmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('tdjordan', '97dc564e979411e6d04560509781c2a3', '', '', '', 0, 'tdjordan@gmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('tehret77', '8fd6afa51cfa92e316dc9d3c5c28763f', '', '', '', 0, 't.ehret@web.de', 0, 0, '', 1);
INSERT INTO `users` VALUES ('testcase', '026452bc368f88ed4d10ecfbb86e7e49', '', '', '', 0, 'x@yahoo.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('thyagk', '25cf6137987c0309b4d320f0024faacb', '', '', '', 0, 'thyagk@gmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('tjbush', 'bebc0b648f3d24a4bd3490fa20a9c741', 'Terry Bush', '', '', 0, 'terryjohnbush@yahoo.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('tjk', '8d3e53fb67fb04f869f3638940f99ebd', '', '', '', 0, 'tjk@us.ibm.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('tkuchhal', 'f3245aa0ffbb76516f0e2e35805709b4', '', '', '', 0, 'tkuchhal@au1.ibm.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('tlpearce2', 'c944898d98fcdc8785759613bc63a895', '', '', '', 0, 'tlpearce2@earthlink.net', 0, 0, '', 1);
INSERT INTO `users` VALUES ('tlroche', '536a2202bf41ee1967c1ce7bf6aebc0d', 'Tom Roche', '', '', 0, 'tlroche@us.ibm.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('TMBoston', 'fd5bcd291f42952cb70e92e0d0f3ade2', '', '', '', 0, 'tmulligan@verizon.net', 0, 0, '', 1);
INSERT INTO `users` VALUES ('Tobias', '0fadf5bbf8d9d85c83b1d7e20b1a2778', '', '', '', 0, 'tobben@hotmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('tomasso', 'd3f12f20c5a3a930ef83e3ceaa3c1845', '', '', '', 0, 'thomas@ehardt.net', 0, 0, '', 1);
INSERT INTO `users` VALUES ('torinoblue', 'c969b336246b9de94b0694eeb3268c90', '', '', '', 0, 'stephen@zamano.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('trimmers', '56ef790373cb534302917a609555c9d8', '', '', '', 0, 'simon.trimboy@gmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('tseviet', '9a3f85f087f2f8ef5b9e0cdeb995e429', '', '', '', 0, 'tseviet.tchen@csiro.au', 0, 0, '', 1);
INSERT INTO `users` VALUES ('tycorle', '448834a56bf2313a9a801846ca2434e2', '', '', '', 0, 'tyacie@gmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('uiital308b', 'ed788b762de4df1750608a775d6b245d', '', '', '', 0, 'uiital308b@allgel.info', 0, 0, '', 1);
INSERT INTO `users` VALUES ('uiital778b', 'ed788b762de4df1750608a775d6b245d', '', '', '', 0, 'uiital778b@agnitumhost.net', 0, 0, '', 1);
INSERT INTO `users` VALUES ('uiital841b', 'ed788b762de4df1750608a775d6b245d', '', '', '', 0, 'uiital841b@allgel.info', 0, 0, '', 1);
INSERT INTO `users` VALUES ('Ulf', '29e79757d92f2c34c4320d38775e9d15', '', '', '', 0, 'uangermann@googlemail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('uzer07973', 'ed788b762de4df1750608a775d6b245d', '', '', '', 0, 'uzer07973@acser.info', 0, 0, '', 1);
INSERT INTO `users` VALUES ('uzer31658', 'ed788b762de4df1750608a775d6b245d', '', '', '', 0, 'uzer31658@abiesalba.info', 0, 0, '', 1);
INSERT INTO `users` VALUES ('uzerz07973', 'ed788b762de4df1750608a775d6b245d', '', '', '', 0, 'uzerz07973@acser.info', 0, 0, '', 1);
INSERT INTO `users` VALUES ('uzerz31658', 'ed788b762de4df1750608a775d6b245d', '', '', '', 0, 'uzerz31658@abiesalba.info', 0, 0, '', 1);
INSERT INTO `users` VALUES ('uzzz07973', 'ed788b762de4df1750608a775d6b245d', '', '', '', 0, 'uzzz07973@acser.info', 0, 0, '', 1);
INSERT INTO `users` VALUES ('vadrian', '0ed5a397ac278abe9de7281d6854b11a', '', '', '', 0, 'vadrian@us.ibm.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('vermarav', 'ea56abaacd7c6919a1e4d1de48a043c5', '', '', '', 0, 'ravipom@yahoo.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('vijaym', '6a5b5bea80f50e679487723531073448', '', '', '', 0, 'vijymp@gmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('viks76', '3c3e3cc4a76f501f500376cdc6f8e62e', '', '', '', 0, 'vshevde@hotmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('vmore', '1d999e25cf66e40189d2b06f2dd7fbd1', '', '', '', 0, 'vishwasmore@gmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('vsasikanth', 'a5d2a2f81272950af3a09b979f91c457', '', '', '', 0, 'sasi_kanth77@yahoo.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('waribamb', 'bed128365216c019988915ed3add75fb', '', '', '', 0, 'waribam_b@yahoo.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('wclark74', '7d5fd5c4f6317dc3d46593db5e3471c0', '', '', '', 0, 'wclark74@yahoo.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('weinstid', '95a56c170b2bae6dabbc6dc457a49e68', '', '', '', 0, 'ido.weinstein@ge.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('whovingh', '9376a7f7cfe39f2d048046f83123ae72', '', '', '', 0, 'whovingh@ctr.pcusa.org', 0, 0, '', 1);
INSERT INTO `users` VALUES ('woneill', '6b0d3600d50944ab08b6145722eaa7c2', '', '', '', 0, 'buildmeister.woneill@spamgourmet.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('ww1998', 'efead51028a03db2d63f0e79ba032a82', '', '', '', 0, 'ww1998@hotmail.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('yogesh123', '124c8995c4ca868320eee5ccf371af14', '', '', '', 0, 'syncmaster_78@yahoo.com', 0, 0, '', 1);
INSERT INTO `users` VALUES ('zom07973', 'ed788b762de4df1750608a775d6b245d', '', '', '', 0, 'zom07973@62fst5376.info', 0, 0, '', 1);
INSERT INTO `users` VALUES ('zomzm07973', 'ed788b762de4df1750608a775d6b245d', '', '', '', 0, 'zomzm07973@acser.info', 0, 0, '', 1);
INSERT INTO `users` VALUES ('zoom31658', 'ed788b762de4df1750608a775d6b245d', '', '', '', 0, 'zoom31658@7atagd.info', 0, 0, '', 1);
INSERT INTO `users` VALUES ('zoozm31658', 'ed788b762de4df1750608a775d6b245d', '', '', '', 0, 'zoozm31658@abiesalba.info', 0, 0, '', 1);
INSERT INTO `users` VALUES ('zxc07973', 'ed788b762de4df1750608a775d6b245d', '', '', '', 0, 'zxc07973@felissilvestriscatus.info', 0, 0, '', 1);
INSERT INTO `users` VALUES ('zzandzry', '94f5d7210a9bb27dc2b6b9e398c1a553', '', '', '', 0, 'zz.r@163.com', 0, 0, '', 1);
