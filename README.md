# silex-twitter
connect to Twitter’s API and return a JSON-encoded array containing hour -> tweet counts for a given user, to determine what hour of the day they are most active

##Install

1. Clone the project localy

2. Get [Composer](https://getcomposer.org/)

3. install dependencies from commandline:
`php composer.phar install`

4. configure web/.htaccess for your apache server

see [silex doc](http://silex.sensiolabs.org/doc/master/web_servers.html) for alternative webserver configs

5. set your twitter authentication details in twitter_conf.php, 
you can obtain fresh keys and tokens from: https://apps.twitter.com/app/new


## API testing
Install ruby if you don't already have it, see the docs here:
https://www.ruby-lang.org/en/documentation/installation/

`gem install rspec`

Optional Mac OsX steps:
if you want a nice notifications of test results:

`gem install rspec-nc`

add the following line to .rspec
`--format Nc`