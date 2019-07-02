Calculator
==========
Calculator extension for yii2

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist web-technologies/yii2-calculator "*"
```

or add

```
"web-technologies/yii2-calculator": "*"
```

to the require section of your `composer.json` file.

Configuration
-----

In config file

```
/config/web.php
```
Add math component

```
'components' => array(
        ...
        'math' => array(
        	 	'class' => 'webtechnologies\calculator\Math',
        		//'handlerClass' => 'namespace/to/customHandlerClass',  //optional parameter
        		),
		    )
```

Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?=Yii::$app->math->expr('( 5 + (5 * 6) - 3 + 4 * 4 ^ 6 + ( -3 * -5 * 4 + ( 3/34 + 1*3+6-3 + ( 4 / 2 ) ) ) )*-1')?>
//otput: -16484.088235294
```
