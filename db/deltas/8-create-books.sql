CREATE TABLE books (
  id mediumint(8) unsigned NOT NULL auto_increment,
  cat_id tinyint(4) NOT NULL default '0',
  date_posted datetime NOT NULL,
  posted_by mediumint(11) NOT NULL,
  title mediumtext NOT NULL,
  author varchar(100) NOT NULL,
  summary mediumtext NOT NULL,
  url varchar(200) NOT NULL,
  image_url varchar(200) NOT NULL,
  date_published datetime NOT NULL,
  active tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--//@UNDO   
  
DROP TABLE IF EXISTS books;
  
--//  
