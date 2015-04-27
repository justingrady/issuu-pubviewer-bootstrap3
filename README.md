# issuu-pubviewer-bootstrap3
============================

Issuu view for fleet publications.  Uses Codeigniter for code and BootStrap (BS3) for views.  Interacts with the Issuu.com api. 

http://developers.issuu.com/api/

### crons

This cron is installed at sudo su www-data, crontab -e.  It flushes the CI cache of items XML daily at 2:00pm. This enables the BCH and LGO staff to upload files and then they show up shortly after 2pm daily. There is also NGINX caching which needs to flush as well, so docs will appear shortly after 2pm.

flush cache daily at 2:00pm
0 14 * * * rm -f /var/www/public_html/application/cache/itemsxml-* > /dev/null 2>&1

Added these so caches are always up to date for public viewing.
0,15,30,45 * * * * /usr/bin/curl http://ee.bakercityherald.com/
0,15,30,45 * * * * /usr/bin/curl http://ee.lagrandeobserver.com/
0,15,30,45 * * * * /usr/bin/curl http://ee.bendbulletin.com/

### .htaccess rewrites

installed these rewrites in the /var/www/.htaccess files for URL rewriting

Redirect 301 /archive http://ee.bakercityherald.com
Redirect 301 /archive http://ee.lagrandeobserver.com
Redirect 301 /archive http://ee.uniondemocrat.com

### widget json urls
This is an JSON output defined by url structure.  
Used to make widgets, after json parsing, on the main bakercityherald and lagrandeobserver websites.

### URLs used to generate json files:
http://ee.domain.com/main/widget/[itemcount]/[stackid]/

These are used to import into custom PHP modules on other websites to parse, and then have custom markup.

http://ee.bendbulletin.com/main/widget/1/fdfdd10d-0e72-410d-8cdc-f25d8827151e/
http://ee.lagrandeobserver.com/main/widget/1/48e7515f-fc67-4062-b849-a3099949934a/
http://ee.bakercityherald.com/main/widget/1/4ce09d69-26ed-4fc1-8df8-9ad0c7fcf007/
