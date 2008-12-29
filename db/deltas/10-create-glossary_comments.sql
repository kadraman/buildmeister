CREATE TABLE glossary_comm (
  id mediumint(8) unsigned NOT NULL auto_increment,
  gloss_id mediumint(8) unsigned NOT NULL,
  date_posted datetime NOT NULL,
  posted_by varchar(32) NOT NULL,
  `comment` mediumtext NOT NULL,
  active tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--//@UNDO   
  
DROP TABLE IF EXISTS glossary_comm;
  
--//  
