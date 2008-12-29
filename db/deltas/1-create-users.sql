CREATE TABLE users (
  username varchar(32) NOT NULL,
  `password` varchar(32) default NULL,
  firstname varchar(100) NOT NULL,
  lastname varchar(100) NOT NULL,
  userid varchar(42) NOT NULL,
  userlevel tinyint(1) unsigned NOT NULL,
  email varchar(50) default NULL,
  `timestamp` int(11) unsigned NOT NULL,
  notify tinyint(1) NOT NULL default '0',
  verifystring varchar(16) NOT NULL,
  active tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (username)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--//@UNDO   
  
DROP TABLE IF EXISTS users;
  
--//  
