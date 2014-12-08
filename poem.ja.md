ポエム集
========

これは何か
---------

`Teto\Object\TypedProperty` はPHPのクラスで **実行時に型検査をする** ための実装である。同様の機構はpixivのAPIにおいて実装し、既に動作実績がある。 (ただし、このリポジトリの版と同一のコードベースではない)

TypedProperty
-------------

以下のポエムの初出は社内用のコードの中に書いたコメントだ。

### なぜTypedPropertyか?

 PHPのプロパティはクラスに定義がなくても `$this->foo = "hoge"` のように書き込むことができる。また、そもそもプロパティの型が何なのか、気をつけなければならない。そのため、コードを見て「どのプロパティがあるのか」「型がよくわからない」といふ欠点がある。
 このtraitを利用すると、プロパティのset/getは全てマジックメソッドを経由するようになる。

`TypedProperty`を利用するクラスでは、以下のようにプロパティと型の対応を定義すると、プロパティとして`$property_types`に定義された値を読み書きできるようになる。

```php
<?php
use Application\Model\V1\Work\StatsModel;

/**
 * @property int        $id
 * @property string     $title
 * @property string[]   $tags
 * @property StatsModel $stats
 * @property array      $stats
 */
class MyModel
{
    use \Teto\Object\TypedProperty;

    private static $property_types = [
        'id'        => 'int',         // 整数のID
        'title'     => '?string',     // タイトル(null許容)
        'tags'      => 'string[]',    // 文字列からなるリスト(配列)
        'type'      => 'enum[]',      // 列挙された要素の配列
        'publicity' => 'enum',        // 列挙された要素
        'stats'     => 'Application\Model\V1\Work\StatsModel',
        'metadata'  => 'array',       // 配列(非推奨)
    ];

    private static $enum_values = [
        'type'      => ['illust', 'manga', 'ugoira'],
        'publicity' => ['public', 'private'],
    ];

    public function __construct(array $properties)
    {
        $this->setProperties($properties);
    }
}
```

### TypedPropertyと型

TypedPropertyは以下のような型名を許容する。

* 任意のクラス名 ([FQCN](http://www.phpdoc.org/docs/latest/references/phpdoc/types.html))
  * ただし、[PHP: 名前空間の使用法: エイリアス/インポート - Manual](http://php.net/manual/language.namespaces.importing.php)の `use` と同様に、先頭の `\` を省略することができる
* PHPの型及びタイプヒント
  * `string`
  * `int`
  * `float`
  * `array`
  * `bool`
  * `object`
  * `scalar`
  * `resource`
* 独自定義の擬似型
  * `enum`: 列挙型

`string|int`のような、記法は導入の予定はない。

また`numeric`に関しては、`is_numeric()`が許容する値が広すぎ、型を特定できないため、検討はしたが導入しなかった。

`string[]`のような記法については [phpDocumentor Definition of a ‘Type’](http://www.phpdoc.org/docs/latest/references/phpdoc/types.html) から、null許容型の記法については [Hack and HHVM: Nullable - Manual](http://docs.hhvm.com/manual/en/hack.nullable.php) から拝借した。

### nullableについて

筆者は Java の見識がないので `null` についての積極的な意見はないのだが、デフォルトでは `null` を代入できないようにした。ただし、代入前のプロパティを取得しようとすると `null` を返す。

また、現行ではデフォルト値をセットするような仕組みは実装してゐない。

### できないこと

#### アクセス権の制御

PHPのマジックメソッドの仕様上、プロパティに対して `private`, `protected` 相当のアクセス権を設定することはできない。TypedPropertyは型については保証するが、アクセス権については信頼を置く。

### なぜ`array`が非推奨なのか。

PHPのArrayはとても複雑なデータ構造を許容する。端的に言うと、ほかの言語のリストとタプルを内包している。

タプルがリストとすこし違うのは、一番めの要素、二番めの要素、n番めの要素… それぞれに意味があることである。

    [りんご, みかん, バナナ] … これは同種の物(string)がn個並んだリストである。

しかし、函数呼び出しの引数の並びは、単純なリストではない。

    fruits(りんご, みかん, 10) // (str: person_name, str: fruit_name, int: fruit_num)

このようなデータ構造をタプルと呼ぶ。 https://ja.wikipedia.org/wiki/%E3%82%BF%E3%83%97%E3%83%AB

タプルはPHPではarrayを使って表現することができるが、安全に取り扱うためには慎重にコードを書かなければならない。

配列を慎重に扱って構造体のようにするよりも、TypedPropertyを使ったクラスのオブジェクトをプロパティに持つことで、想定外のデータが紛れこむ危険性を減らすことができる。

### PhpStorm / IntelliJ IDEA と仲良しになる

PhpStormやIntelliJ IDEAを利用すると、以下のように書くことでプロパティを型付けすることができる。

```php
class MyClass2
{
    /** @var string */
    public $hoge;

    /** @var int */
    public $fuga;
}
```

ところが本来のプロパティを使った時と違って、`TypedProperty`を使った場合は上のように書くことができなくなる。

その場合は、[phpDocumentor @property](http://www.phpdoc.org/docs/latest/references/phpdoc/tags/property.html) の記法に従って、クラス定義の上にコメントを書けば良いとのことだ。

https://github.com/zonuexe/php-objectsystem/blob/master/tests/Object/TypedPropertyTest.php#L11 を参考にされたい。


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
