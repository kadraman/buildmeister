CREATE TABLE glossary (
  id mediumint(8) NOT NULL auto_increment,
  posted_by varchar(32) NOT NULL,
  title varchar(100) NOT NULL,
  summary mediumtext NOT NULL,
  active tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--//@UNDO   
  
DROP TABLE IF EXISTS glossary;
  
--//  
