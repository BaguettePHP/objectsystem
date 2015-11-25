Teto Objectsystem
=================

[![Package version](http://img.shields.io/packagist/v/zonuexe/objectsystem.svg?style=flat)](https://packagist.org/packages/zonuexe/objectsystem)
[![Build Status](https://travis-ci.org/BaguettePHP/objectsystem.svg?branch=master)](https://travis-ci.org/BaguettePHP/objectsystem)
[![Packagist](http://img.shields.io/packagist/dt/zonuexe/objectsystem.svg?style=flat)](https://packagist.org/packages/zonuexe/objectsystem)

Object system implementation for PHP

see `poem.ja.md`.

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
  * `trait PrivateGetter`: Private property behaves like read only.
    * This trait is very simple, but you may not be able to imagine the behavior of this trait in the inherited class.

References
----------

* [phpDocumentor Definition of a ‘Type’](http://www.phpdoc.org/docs/latest/references/phpdoc/types.html)

Copyright
---------

see `./LICENSE`.

    Object system implementation for PHP
    Copyright (c) 2014 USAMI Kenta <tadsan@zonu.me>

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
