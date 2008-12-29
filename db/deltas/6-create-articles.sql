CREATE TABLE articles (
  id mediumint(9) NOT NULL auto_increment,
  cat_id tinyint(4) NOT NULL,
  date_posted datetime NOT NULL,
  posted_by mediumint(11) NOT NULL,
  title varchar(100) NOT NULL,
  summary tinytext NOT NULL,
  content tinytext NOT NULL,
  views mediumint(9) NOT NULL,
  active tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (id)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;

--//@UNDO   
  
DROP TABLE IF EXISTS articles;
  
--//  
