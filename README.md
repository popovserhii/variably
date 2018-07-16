# The powerful, simple and fast engine for handle variables in string


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
**explode**

Explode string by delimeter. As default delimeter is taken " " (space).

**float**

Parse stringable number to float.

**int**

Parse stringable number to int.

**percentToInt**
```php
// value: 3%
// result: 3
```
Parse string with percent sign to integer number.

**shift**

Shift and return first element or array.

**int**

Parse stringable number to int.


## Preparation


## For Developer