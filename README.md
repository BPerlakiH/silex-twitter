# silex-twitter
connect to Twitter’s API and return a JSON-encoded array containing hour -> tweet counts for a given user, to determine what hour of the day they are most active

#installation
1 Clone the project localy

2 Get composer from: https://getcomposer.org/

3 install dependencies from commandline:
```php composer.phar install

4 configure web/.htaccess for your environment
see silex doc: http://silex.sensiolabs.org/doc/master/web_servers.html
for alternative webserver configs

5 set your twitter authentication details in twitter_conf.php, 
you can obtain a fresh one from:
https://apps.twitter.com/app/new


6 api testing
```gem install rspec
```gem install rspec-nc (optional for mac osx)

if you want nice way notifications of test results add the following line to .rspec
```--format Nc

