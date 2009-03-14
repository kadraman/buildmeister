<?php

/*
 * Copyright 2007-2009 Kevin A. Lee
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 */

/**
 *
 * This file is intended to group all constants to
 * make it easier to tweak the application.
 *
 * @author Kevin A. Lee
 * @email kevin.lee@buildmeister.com
 */
 
// database constants for MySQL
define("DB_SERVER", "localhost");
define("DB_USER", "root");
define("DB_PASS", "root");
define("DB_NAME", "buildmeister");

// database tables
define("TBL_USERS", "users");
define("TBL_ACTIVE_USERS",  "active_users");
define("TBL_ACTIVE_GUESTS", "active_guests");
define("TBL_BANNED_USERS",  "banned_users");
define("TBL_CATEGORIES", "categories");
define("TBL_ARTICLES", "articles");
define("TBL_ARTICLE_CATEGORIES", "article_categories");
define("TBL_STATES", "states");
define("TBL_BOOKS", "books");
define("TBL_GLOSSARY", "glossary");
define("TBL_LINKS", "links");
define("TBL_ARTRATE", "articles_ratings");
define("TBL_LINKRATE", "links_ratings");
define("TBL_ARTCOM", "article_comm");
define("TBL_GLOSSCOM", "glossary_comm");

// special names and level constants
define("SITE_BASEDIR", "http://127.0.0.1/buildmeister.com/public");
define("SITE_PREFIX", "/buildmeister.com/public");
define("REWRITE_PREFIX", "/buildmeister.com");
define("SITE_NAME", "The Buildmeister");
define("ADMIN_NAME", "admin");
define("GUEST_NAME", "Guest");
define("ADMIN_LEVEL", 9);
define("EDITOR_LEVEL", 5);
define("USER_LEVEL",  1);
define("GUEST_LEVEL", 0);
define("PUBLISHED_STATE", 3); // state at which article is visible to all users

// page row limit for tables
define("PAGE_LIMIT", 40);

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
define("SMTP_SERVER", "smtp.strato.com");
define("SMTP_USERNAME", "webmaster@buildmeister.com");
define("SMTP_PASSWORD", "redrock71");

// forces all users to have lowercase usernames
define("ALL_LOWERCASE", false);

?>
