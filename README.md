# O2System Standard PHP Libraries (SPL)
O2System Standard PHP Library (SPL) it's build based on original [standard PHP library](http://php.net/manual/en/book.spl.php).
It's made up primarily of commonly needed datastructure classes, iterators, handlers and exceptions for O2System PHP Framework, but also can be used independently outside O2System PHP Framework environment.

Installation
------------
The best way to install [O2System SPL](https://packagist.org/packages/o2system/spl) is to use [Composer](http://getcomposer.org)
```
composer require o2system/psr
```

Usage Example
-------------
```php
use O2System\Spl\SplArrayStorage;

$storage = new SplArrayStorage();
$storage->attach(['hello', 'world']);
var_dump( $storage->contains(['hello', 'world']) );
```
> output: bool(true)

Ideas and Suggestions
---------------------
Please kindly mail us at [o2system.framework@gmail.com](mailto:o2system.framework@gmail.com).

Bugs and Issues
---------------
Please kindly submit your [issues at Github](http://github.com/o2system/psr/issues) so we can track all the issues along development.

System Requirements
-------------------
- PHP 5.4+
- [Composer](http://getcomposer.org)

Credits
-------
* Founder and Lead Projects: [Steeven Andrian Salim (steevenz.com)](http://steevenz.com)
* Github Pages Designer and Writer: [Teguh Rianto](http://teguhrianto.tk)