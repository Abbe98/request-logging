#request-logging

*Request logging library in PHP*

##Installation

Include `rqeuest_logging.php` or add the [composer package][0].

Define the database configuration:

	define('HOST', '127.0.0.1'); // the IP of the database
	define('DBNAME', 'reqlog_test'); // the database name to be used
	define('USERNAME', 'root'); // the username to be used with the database
	define('PASSWORD', ''); // the password to be used with the username

And run the following SQL in the database you defined above:

	CREATE TABLE IF NOT EXISTS `requests` (
	`id` int(255) NOT NULL,
	  `ip` varchar(45) COLLATE utf8mb4_bin NOT NULL,
	  `http_forwared` int(45) NOT NULL,
	  `browser_ua` varchar(600) COLLATE utf8mb4_bin NOT NULL,
	  `timestamp` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
	  `tag` varchar(700) COLLATE utf8mb4_bin NOT NULL
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin AUTO_INCREMENT=27 ;
	
	ALTER TABLE `requests`
	 ADD PRIMARY KEY (`id`);
	
	ALTER TABLE `requests`
	MODIFY `id` int(255) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;

##Usage

Log the current request(IP, HTTP forwarded, Browser User Agent and Time Samp). The `$tagString` is optional:

`$log = new ReqLog($tagString);`

Get the number of visits from the current computer/browser(by adding `$tagString` you get the tag specific data):

`$log->num_visits();`

Get the number of visits from the current computer(`$tagString` is optional):

`$log->num_ip_visits();`

Get the percent that the current browser version has(`$tagString` is not supported):

`$log->this_browser_percent();`

**Licensed under MIT.**

[0]: https://packagist.org/packages/abbe98/request-logging
