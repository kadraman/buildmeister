<?php
/**
 * constants.php
 *
 * This file is intended to group all constants to
 * make it easier to tweak the application.
 *
 * @author Kevin A. Lee <kevin.lee@buildmeister.com>
 * Based on code originally written by: Jpmaster77. 
 */
 
// database constants for MySQL
define("DB_SERVER", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "buildmeister");

// database tables
define("TBL_USERS", "users");
define("TBL_ACTIVE_USERS",  "active_users");
define("TBL_ACTIVE_GUESTS", "active_guests");
define("TBL_BANNED_USERS",  "banned_users");
define("TBL_ARTICLES", "articles");
define("TBL_BOOKS", "books");
define("TBL_GLOSSARY", "glossary");
define("TBL_LINKS", "links");
define("TBL_ARTRATE", "articles_ratings");
define("TBL_LINKRATE", "links_ratings");
define("TBL_ARTCOM", "article_comm");
define("TBL_GLOSSCOM", "glossary_comm");

// special names and level constants
define("SITE_BASEDIR", "http://localhost/buildmeister.com");
define("SITE_NAME", "The Buildmeister");
define("ADMIN_NAME", "admin");
define("GUEST_NAME", "Guest");
define("ADMIN_LEVEL", 9);
define("USER_LEVEL",  1);
define("GUEST_LEVEL", 0);

// determine whether to keep active track of visitors
define("TRACK_VISITORS", false);

// timeout constants for active visitors
define("USER_TIMEOUT", 10);
define("GUEST_TIMEOUT", 5);

// cookie constants
define("COOKIE_EXPIRE", 60*60*24*100);    // 100 days by default
define("COOKIE_PATH", "/");               // avaible in whole domain

// email constants
define("EMAIL_FROM_NAME", "webmaster");
define("EMAIL_FROM_ADDR", "webmaster@buildmeister.com");
define("EMAIL_WELCOME", false);

// forces all users to have lowercase usernames
define("ALL_LOWERCASE", false);

// navigation menu
$navmenu_main = array( array( Title => "Home",
                              Link  => "index.php"
                            ),
                       array( Title => "Articles",
                              Link  => "articles.php"
                            ),
                       array( Title => "Books",
                              Link  => "books.php",
                           ),
                       array( Title => "Glossary",
                              Link  => "glossary.php",
                            ),
                       array( Title => "Links",
                              Link  => "links.php",
                       )
                );
?>
