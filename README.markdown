Funktions 0.1.1
===============

Funktions is a set of functions that I found useful in several of my projects. Feel free to fork and add yours ;)

Install
-------

Pick up the source or install it with [Composer](https://getcomposer.org/) :

```json
{
    "require": {
        "pyrsmk/funktions": "0.1.*"
    }
}
```

Requiring `vendor/autoload.php` does not load functions, you need to import the bundle you want by yourself :

```php
require 'vendor/pyrsmk/Funktions/src/debug.php';
```

Available functions by bundle
-----------------------------

### array.php
- array\_merge\_recursive_unique(`$array1`,`$array2`,`...`) : works like `array_merge_recursive()` PHP function but does not append values of the same key into an array, it instead overwrites the value as expected

### color.php
- rgb2hsl(`$r`,`$g`,`$b`)
- hsl2rgb(`$h`,`$s`,`$l`)
- rgb2hsv(`$r`,`$g`,`$b`)
- hsv2rgb(`$h`,`$s`,`$v`)
- rgb2html(`$r`,`$g`,`$b`)
- html2rgb(`$html`)

### debug.php
- debug(`$variable`) : prints formatted informations about a variable

### system.php
- human_filesize(`$path`) : get the human-readable size of a file
- human_fileperms(`$path`) : get human-readable file permissions (like `drwxr-xr-x`)
- lessdir(`$path`) : scan a directory without returning dot directories (the well-known `.` and `..`)
- mimetype(`$path`) : get the mime type of a file

License
-------

Funktions is released under the [MIT license](http://dreamysource.mit-license.org).