# silex-twitter
connect to Twitter’s API and return a JSON-encoded array containing hour -> tweet counts for a given user, to determine what hour of the day they are most active

##Install

1. Clone the project localy

2. Set your twitter authentication details in twitter_conf.php, 
you can obtain fresh keys and tokens from: https://apps.twitter.com/app/new

3. Make sure you have [Composer](https://getcomposer.org/) installed

4. Install dependencies from commandline:
`php composer.phar install`

5. Configure web/.htaccess for your apache server

An example virtual host configuration:
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
Install ruby, if you don't have it. See the docs here:
https://www.ruby-lang.org/en/documentation/installation/

`gem install rspec`

Optional Mac OsX steps:
if you want notifications of test results:

`gem install rspec-nc`

add the following line to .rspec
`--format Nc`

1. Make sure that the **root url is matching your dev environment in spec/api_spec.rb**,
update the following, if needed:
`@root_url = 'http://silex.localhost'`

2. run the tests from commandline: 
`rspec'

###Troubleshoot:
If rspec fails with message:
`returns valid data from twitter (FAILED - 1)`

####Solution
Make sure that your twitter credentials are set and correct in twitter_conf.php

## Notes
At the moment **only the last 200 tweets** are pulled down from the user's timeline
and the stats are based on that

###Future improvements
1. Pagination could be added to include more tweets, although that would increase the response time
2. A local cache could be added to the tweet fetching part, the cache key could come from a hash of the twitter params (screen_name + count), with a time based cache invalidation