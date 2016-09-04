Teto Objectsystem
=================

[![Package version](http://img.shields.io/packagist/v/zonuexe/objectsystem.svg?style=flat)](https://packagist.org/packages/zonuexe/objectsystem)
[![Build Status](https://travis-ci.org/BaguettePHP/objectsystem.svg?branch=master)](https://travis-ci.org/BaguettePHP/objectsystem)
[![Packagist](http://img.shields.io/packagist/dt/zonuexe/objectsystem.svg?style=flat)](https://packagist.org/packages/zonuexe/objectsystem)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/BaguettePHP/objectsystem/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/BaguettePHP/objectsystem/?branch=master)

Object system implementation for PHP

Document
--------

* in Japanese: [`TypedProperty`について](./poem.ja.md).
* in Japanese: [private/protectedなプロパティを外部から読み込み可能にする - Qiita](http://qiita.com/tadsan/items/2049243e47495764b191)

Installation
------------

### Composer

```
composer require zonuexe/objectsystem
```

Features
--------

* Property type check at run time
  * `trait TypedProperty`
  * `trait TypeAssert`
  * `class TypeDefinision`
* Object container
  * `class ObjectArray`
  * `interface ToArrayInterface`
* Trait for general class
  * `trait ReadOnly`: Restrict write to not accessable property.
  * `trait PrivateGetter`: Private property behaves like read only.
    * Very simple, but you may not be able to imagine the behavior of trait in the inherited class.
    * Behavior of undefined property depends on [error_reporting()](http://php.net/manual/function.error-reporting.php) and [set_error_handler()](http://php.net/manual/function.set-error-handler.php).
  * `trait PrivateStrictGetter`: Private property behaves like read only.
    * Throws `OutOfRangeException` if propery is undefined.
  * `trait MethodAlias`: Make alias of method.
  * `trait PropertyLikeMethod`: Call method as property.

References
----------

* [phpDocumentor Definition of a ‘Type’](http://www.phpdoc.org/docs/latest/references/phpdoc/types.html)

Copyright
---------

see `./LICENSE`.

    Object system implementation for PHP
    Copyright (c) 2016 [Baguette HQ](http://baguettephp.github.io/) / [USAMI Kenta](https://tadsan.github.io/) <tadsan@zonu.me>

Teto Kasane
-----------

I love [Teto Kasane](http://utau.wikia.com/wiki/Teto_Kasane). (ja: [Teto Kasane official site](http://kasaneteto.jp/))

```
　　　　　 　r /
　 ＿＿ , --ヽ!-- .､＿
　! 　｀/::::;::::ヽ l
　!二二!::／}::::丿ハﾆ|
　!ﾆニ.|:／　ﾉ／ }::::}ｺ
　L二lイ　　0´　0 ,':ﾉｺ
　lヽﾉ/ﾍ､ ''　▽_ノイ ソ
 　ソ´ ／}｀ｽ /￣￣￣￣/
　　　.(_:;つ/  0401 /　ｶﾀｶﾀ
 ￣￣￣￣￣＼/＿＿＿＿/
```
