CREATE TABLE categories (
  id tinyint(4) NOT NULL auto_increment,
  cat varchar(40) NOT NULL,
  PRIMARY KEY  (id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--//@UNDO   
  
DROP TABLE IF EXISTS categories;
  
--//  
