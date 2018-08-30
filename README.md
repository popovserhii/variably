# The powerful, simple and fast engine for handle strings and stringable variables


**Filters** and **Preparation** give huge flexibility for handle data. 
You can get any type of data from HTML, CSV, Excel, SpreadSheet, Amazon etc. and build filters chain for get the best value
that you need.

Variably has expendable config base which allow setup any element with any requirements.

**Filters** do delicate and precision work, this concentrate on unique filed (but not necessarily).
 
**Preparation** do the same but use more resource for handle data, this can use database or third party services 
or any other volume processing.

For example the next filters chain explode string to array by space, get first element of array and parse it as float.
```php
// value: "4.9 of 5 stars"
[
    'star' => ['name' => 'star', '__filter' => ['explode', 'shift', 'float']],
]
// result: 4.9
```

In most cases you should use **Filters**. Use **Preparation** carefully. 

## Filters

#### **`br2nl`**
Replace any `<br>` HTML tag in string to new line symbol (`\r\n`).

```php
# object notation
(new FilterBr2nl())->filter('Hello, World!<br /> I am Skynet.'); 

# config notation
[
    'fieldName' => ['name' => 'fieldName', '__filter' => ['br2nl']],
]

# result
// Hello, World!
// I am Skynet.
```


#### **`concat`**
Concatenate two and more strings.

```php
# object notation
(new FilterConcat())->filter('Hello, World! ')->setConfig(['params' => ['I am Skynet.']]); 

# config notation
[
    'fieldName' => ['name' => 'fieldName', '__filter' => ['concat:I am Skynet.']],
]
// or
[
    'fieldName' => ['name' => 'fieldName', '__filter' => [['name' => 'concat', 'params' => ['I am Skynet.']]]],
]
// or
[
    'fieldName' => ['name' => 'fieldName', '__filter' => [['name' => 'concat', 'params' => ['I ', 'am ', 'Skynet.']]]],
]

# result
// Hello, World! I am Skynet.
```


#### **`dateTime`**
Convert string to standard date format

```php
# object notation
(new FilterDateTime())->filter('12.07.2018');
(new FilterDateTime())->filter('12.07.2018')->setConfig(['params' => ['formatFrom' => 'd.m.Y']]);
(new FilterDateTime())->filter('12.07.2018')->setConfig(['params' => ['formatFrom' => 'd.m.Y', 'formatTo' => 'Y-m-d H:i:s']]);

# config notation
[
    'fieldName' => ['name' => 'fieldName', '__filter' => ['dateTime']],
]
// or
[
    'fieldName' => ['name' => 'fieldName', '__filter' => [
        ['name' => 'dateTime', 'params' => ['formatFrom' => 'd.m.Y']]
    ]],
]
// or
[
    'fieldName' => ['name' => 'fieldName', '__filter' => [
        ['name' => 'dateTime', 'params' => ['formatFrom' => 'd.m.Y', 'formatTo' => 'Y-m-d H:i:s']]
    ]],
]

# result
// 2018-07-12 00:00:00
```

**Params**
* `fromartFrom` - input date format
* `formatTo` - output date format, default is 'Y-m-d H:i:s'
* `timezone` - date timezone, by default takes system timezone


#### **`dateNative`**
Convert native date or datetime value to standard format *(requires Intl library)*.

```php
# object notation
(new FilterDateNative())->filter('20 enero 2018')->setConfig(['params' => ['locale' => 'es_ES']]); // es
(new FilterDateNative())->filter('2 février 2018')->setConfig(['params' => ['locale' => 'fr_FR']]); // fr 
(new FilterDateNative())->filter('May 16, 2016')->setConfig(['params' => ['locale' => 'en_GB']]); // en 
(new FilterDateNative())->filter('27. Juni 2014')->setConfig(['params' => ['locale' => 'de_DE']]); // de 

# config notation
[
    'fieldName' => ['name' => 'fieldName', '__filter' => [
        ['name' => 'dateNative', 'params' => ['locale' => 'es_ES']]
    ]],
]
// or
[
    'fieldName' => ['name' => 'fieldName', '__filter' => [
        ['name' => 'dateNative', 'params' => ['locale' => 'fr_FR']]
    ]],
]
// or
[
    'fieldName' => ['name' => 'fieldName', '__filter' => [
        ['name' => 'dateNative', 'params' => ['locale' => 'en_GB']]
    ]],
]
// or
[
    'fieldName' => ['name' => 'fieldName', '__filter' => [
        ['name' => 'dateNative', 'params' => ['locale' => 'de_DE']]
    ]],
]

# result
// 2018-01-20
// 2018-02-02
// 2016-05-16
// 2014-06-27
```

**Params**
* `locale` - [list](https://gist.github.com/jacobbubu/1836273) of locales. May be not full
* `format_to` - convert date to format. Default is *Y-m-d*.  


#### **`explode`**
Explode string by delimeter. As default delimeter is taken " " (space).

```php
# object notation
(new FilterExplode())->filter('apple, peas, strawberry, cherry'); 

# config notation
[
    'fieldName' => ['name' => 'fieldName', '__filter' => ['explode']],
]

# result
// ['apple', 'peas', 'strawberry', 'cherry']
```


#### **`float`**
Parse stringable number to float.

```php
# object notation
(new FilterFloat())->filter(4.5); 
(new FilterFloat())->filter('4.5'); 
(new FilterFloat())->filter('4,5'); 

# config notation
[
    'fieldName' => ['name' => 'fieldName', '__filter' => ['float']],
]

# result
// 4.5
```


#### **`htmlEntityDecode`**
To decode an entity into a character, `htmlEntityDecode` needs to know what encoding you'd like your character to be in.
"ü" can be represented in Latin-1, UTF-8, UTF-16 and a host of other encodings. 
The default is Latin-1. &#8211; (–, EN DASH) cannot be represented in Latin-1. Hence it stays unchanged. 
Tell `htmlEntityDecode` to decode it into an encoding that can represent that character, like UTF-8:

```php
# object notation
(new FilterHtmlEntityDecode())->filter('Hello &#8211; World!'); 

# config notation
[
    'fieldName' => ['name' => 'fieldName', '__filter' => ['htmlEntityDecode']],
]

# result
// Hello – World!
```


#### **`int`**
Parse stringable number to int

```php
# object notation
(new FilterInt())->filter(4.5); 
(new FilterInt())->filter('009945'); 
(new Filterint())->filter('009945-john'); 

# config notation
[
    'fieldName' => ['name' => 'fieldName', '__filter' => ['int']],
]

# result
// 4
// 9945
// 9945
```


#### **`merge`**
Merge value to other array. All scalar values will be converted to array, object will be skipped

```php
# object notation
(new FilterMerge())->filter(4)->setConfig(['params' => [
    [5, 10],
    [20, 30]
]]); 

# config notation
[
    'fieldName' => ['name' => 'fieldName', '__filter' => [
        ['name' => 'merge', 'params' => [
            [5, 10],
            [20, 30]
        ]]
    ]]
],

# result
// [4, 5, 10, 20, 30]
```


#### **`number`**
Delete all non number symbols from value

```php
# object notation
(new FilterNumber())->filter('(093) 234-56-78'); 

# config notation
[
    'fieldName' => ['name' => 'fieldName', '__filter' => ['number']],
]

# result
// 0932345678
```


#### **`percentageToQuantity`**
Convert percentage of total to quantity

```php
# object notation
(new FilterPercentageToQuantity())->filter('20%')->setConfig(['params' => ['total' => '15']]); 

# config notation
[
    'fieldName' => ['name' => 'fieldName', '__filter' => [
        ['name' => 'percentageToQuantity', 'params' => ['total' => '15']]
    ]],
]

# result
// 3

# workflow: round((15 / 100) * 20)
```


#### **`percentToNumber`**
Convert percent value to integer

```php
# object notation
(new FilterPercentToNumber())->filter('3%'); 
(new FilterPercentToNumber())->filter(0.03); 

# config notation
[
    'fieldName' => ['name' => 'fieldName', '__filter' => ['percentToNumber']],
]

# result
// 3
```


#### **`pop`**
Return last element of array

```php
# object notation
(new FilterPop())->filter(['apple', 'peas', 'strawberry', 'cherry']); 

# config notation
[
    'fieldName' => ['name' => 'fieldName', '__filter' => ['pop']],
]

# result
// 'cherry'
```


#### **`shift`**
Return first element or array

```php
# object notation
(new FilterPop())->filter(['apple', 'peas', 'strawberry', 'cherry']); 

# config notation
[
    'fieldName' => ['name' => 'fieldName', '__filter' => ['shift']],
]

# result
// 'apple'
```


#### **`regexMatch`**
Return matched elements in regular expression

```php
# object notation
(new FilterRegexMatch())->filter('a-star-small-5')->setConfig(['params' => ['/a-star[-\w]*-([0-5])/']]); 

# config notation
[
    'fieldName' => ['name' => 'fieldName', '__filter' => ['regexMatch:/[\s\w-]+a-star[-\w]*-([0-5])[\s\w-]+/']],
]
// or
[
    'fieldName' => ['name' => 'fieldName', '__filter' => [
        ['name' => 'regexMatch', 'params' => ['/a-star[-\w]*-([0-5])/']]
    ]],
]
// or
[
    'fieldName' => ['name' => 'fieldName', '__filter' => [
        ['name' => 'regexMatch', 'params' => ['pattern' => '/a-star[-\w]*-([0-5])/']]
    ]],
]

# result
// [5]
```


#### **`replace`**
Replace all occurrences of the search string with the replacement string

```php
# object notation
(new FilterReplace())->filter('One')->setConfig(['params' => ['from' => 'One', 'to' => 1]]); 
(new FilterReplace())->filter('Eine')->setConfig(['params' => ['from' => ['One', 'Eine', 'Une'], 'to' => 1]]); 
(new FilterReplace())->filter('Une')->setConfig(['params' => ['from' => ['One', 'Eine', 'Une'], 'to' => 1]]); 

# config notation
[
    'fieldName' => ['name' => 'fieldName', '__filter' => [
        ['name' => 'replace', 'params' => [['One', 'Eine', 'A una', 'Una', 'Une'], 1]],
    ]],
]
// or
[
    'fieldName' => ['name' => 'fieldName', '__filter' => [
        ['name' => 'replace', 'params' => ['from' => ['One', 'Eine', 'A una', 'Una', 'Une'], 'to' => 1]],
    ]],
]

# result
// 1
```



#### **`toLower`**
Convert string to lower case

```php
# object notation
(new FilterToLower())->filter('aPpLe'); 

# config notation
[
    'fieldName' => ['name' => 'fieldName', '__filter' => ['toLower']],
]

# result
// 'apple'
```



#### **`toUpper`**
Convert string to upper case

```php
# object notation
(new FilterToLower())->filter('apple'); 

# config notation
[
    'fieldName' => ['name' => 'fieldName', '__filter' => ['toUpper']],
]

# result
// 'APPLE'
```



#### **`trim`**
Trim string. By default white spaces are trimmed

```php
# object notation
(new FilterTrim())->filter(' apple  '); 
(new FilterTrim())->filter('~apple~')->setConfig(['params' => ['charList' => '~']]); 

# config notation
[
    'fieldName' => ['name' => 'fieldName', '__filter' => ['trim']],
]
// or
[
    'fieldName' => ['name' => 'fieldName', '__filter' => [
        ['name' => 'trim', 'params' => ['charList' => '~']]
    ]],
]

# result
// 'apple'
```

## Preparation
// TODO

## For Developers

Don't hesitate improve functionality and create PR.

### Custom Filter
*Variably* module is standalone but in most cases is using with other modules for filtration imported data, 
handle email templates, etc.

#### Zend Framework 2/3
Example is shown when *Variably* works in pairs with [*Popov\ZfcImporter*](https://github.com/popovserhii/zfc-importer)

```php
// module/Custom/Module/config/module.config.php
return [
    'importer' => [
        'helpers' => [
            'CustomTagsFilter' => \Your\Module\Importer\CustomTagFilter::class,
        ],
        'tasks' => [
            'custom-task-name' => [
                'driver' => 'Excel',
                'fields' => [
                    [
                        'tag' => ['__filter' => ['customTags']],
    
                        '__table' => 'tags',
                        '__codename' => 'tag', // code name of position
                        '__identifier' => 'tag'
                    ],
                ],
            ],
        ],
    ]
];
```
