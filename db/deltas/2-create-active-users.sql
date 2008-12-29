CREATE TABLE active_users (
  username varchar(30) NOT NULL,
  `timestamp` int(11) unsigned NOT NULL,
  PRIMARY KEY  (username)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
  
--//@UNDO   
  
DROP TABLE IF EXISTS active_users;
  
--//  
