CREATE TABLE active_guests (
  ip varchar(15) NOT NULL,
  `timestamp` int(11) unsigned NOT NULL,
  PRIMARY KEY  (ip)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
  
--//@UNDO   
  
DROP TABLE IF EXISTS active_guests;
  
--//  
