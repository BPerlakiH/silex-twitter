# silex-twitter
connect to Twitter’s API and return a JSON-encoded array containing hour -> tweet counts for a given user, to determine what hour of the day they are most active

##Install

1. Clone the project localy

2. set your twitter authentication details in twitter_conf.php, 
you can obtain fresh keys and tokens from: https://apps.twitter.com/app/new

3. Get [Composer](https://getcomposer.org/)

4. install dependencies from commandline:
`php composer.phar install`

5. configure web/.htaccess for your apache server

An example deve implementation with virtual host:
```
#SILEX
<VirtualHost *:80>
	ServerName silex.localhost
	ServerAdmin server_admin@gmail.com
	DocumentRoot /path/to/silex-twitter/web
	<Directory /path/to/silex-twitter/web>
		Options +FollowSymLinks
		AllowOverride All
		Require all granted
	</Directory>
</VirtualHost>
```

see [silex doc](http://silex.sensiolabs.org/doc/master/web_servers.html) for alternative webserver configs


## API testing
Install ruby if you don't already have it, see the docs here:
https://www.ruby-lang.org/en/documentation/installation/

`gem install rspec`

Optional Mac OsX steps:
if you want a nice notifications of test results:

`gem install rspec-nc`

add the following line to .rspec
`--format Nc`


## Notes
At the moment *only the last 200 tweets* are pulled down from the user's timeline
and the stats are based on that

###Future improvements
1. Pagination could be added to include more tweets, although that would increase the response time
2. A local cache could be added to the tweet fetching part, the cache key could come from a flattened hash of the twitter params (screen_name + count), with a time based cache invalidation