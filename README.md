Hookchat
========

This is a simple webchat application written in [PHP][1] 5.3, using [CodeIgniter][2] 1.7.2 and [MySQL][3].
The push server behind the app is [Hookbox][4] (hence the project's name).

Installation
------------

  1. Install PHP 5.3 and MySQL (version 5 will do).
  2. Install Hookbox (installation instructions on their website).
  3. Run a webserver (like Apache) on the document root of the project (where the index.php and this file live).
  4. Run hookbox like this:

    hookbox -a 1234 --cbport=8888 --cbhost=localhost --cbpath=/index.php/hookbox

[1]: http://www.php.net
[2]: http://codeigniter.com
[3]: http://mysql.com
[4]: http://hookbox.org