System Requirements
===================

We built ThinkUp so that it can run on the most common and widely-available LAMP-based hosting providers.

To run ThinkUp, you'll need:

* `PHP 5.2 <http://php.net/>`_ or higher with `cURL <http://php.net/manual/en/book.curl.php>`_, `GD <http://php.net/manual/en/book.image.php>`_, and the `PDO <http://php.net/manual/en/book.pdo.php>`_ `MySQL driver <http://www.php.net/manual/en/ref.pdo-mysql.php>`_ enabled
* `MySQL 5.0.3 <http://mysql.com/>`_ or higher
* A public web server. 

Note: Twitter authorization requires a public callback URL, so you'll need to expose a local dev server to the internet
for initial authorization; after that the server doesn't have to be publicly available.

All set? Now, run :doc:`ThinkUp's three-step installer <quickstart>`.