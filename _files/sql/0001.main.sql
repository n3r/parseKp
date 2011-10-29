CREATE TABLE `films` (
`id` int(11) NOT NULL,
`user_id` int(11) default NULL,
`name` varchar(127) NOT NULL,
`alt_name` varchar(127) NOT NULL,
`year` varchar(127) NOT NULL,
`slogan` varchar(127) NOT NULL,
`description` varchar(127) NOT NULL,
`kp_rating` varchar(127) NOT NULL,
`kp_rating_count` varchar(127) NOT NULL,
`imdb_rating` varchar(127) NOT NULL,
`imdb_rating_count` varchar(127) NOT NULL,
`critic_rating` varchar(127) NOT NULL,
`critic_rating_count` varchar(127) NOT NULL,
`mpaa` varchar(127) NOT NULL,
`longtime` varchar(127) NOT NULL,
`genres` varchar(127) NOT NULL,
`poster_main` varchar(127) NOT NULL,

-- etc...

 PRIMARY KEY  (`menu_id`)
) ENGINE = MYISAM DEFAULT CHARSET=utf8;


CREATE TABLE `film_countries` (
`film_id` int(11) NOT NULL,
`country_id` int(11) default NULL
) ENGINE = MYISAM DEFAULT CHARSET=utf8;
