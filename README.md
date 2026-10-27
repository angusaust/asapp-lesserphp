# lesserphp v1.0.1
### <https://github.com/angusaust/angus-lesserphp>

## Installation

```console
$ composer require angus/lesserphp
```

`lesserphp` is a compiler for LESS written in PHP. It is based on lessphp bei leafo.
The documentation is great,
so check it out: <http://leafo.net/lessphp/docs/>.

Here's a quick tutorial:

### How to use in your PHP project

The only file required is `lessc.inc.php`, so copy that to your include directory.

The typical flow of **lesserphp** is to create a new instance of `lessc`,
configure it how you like, then tell it to compile something using one built in
compile methods.

The `compile` method compiles a string of LESS code to CSS.

```php
<?php
require "lessc.inc.php";

$less = new lessc;
echo $less->compile(".block { padding: 3 + 4px }");
```

The `compileFile` method reads and compiles a file. It will either return the
result or write it to the path specified by an optional second argument.

```php
<?php
echo $less->compileFile("input.less");
```

The `checkedCompile` method is like `compileFile`, but it only compiles if the output
file doesn't exist or it's older than the input file:

```php
<?php
$less->checkedCompile("input.less", "output.css");
```

If there any problem compiling your code, an exception is thrown with a helpful message:

```php
<?php
try {
  $less->compile("invalid LESS } {");
} catch (\Exception $e) {
  echo "fatal error: " . $e->getMessage();
}
```

The `lessc` object can be configured through an assortment of instance methods.
Some possible configuration options include [changing the output format][1],
[setting variables from PHP][2], and [controlling the preservation of
comments][3], writing [custom functions][4] and much more. It's all described
in [the documentation][0].


 [0]: http://leafo.net/lessphp/docs/
 [1]: http://leafo.net/lessphp/docs/#output_formatting
 [2]: http://leafo.net/lessphp/docs/#setting_variables_from_php
 [3]: http://leafo.net/lessphp/docs/#preserving_comments
 [4]: http://leafo.net/lessphp/docs/#custom_functions


### How to use from the command line

An additional script has been included to use the compiler from the command
line. In the simplest invocation, you specify an input file and the compiled
css is written to standard out:

    $ plessc input.less > output.css

Using the -r flag, you can specify LESS code directly as an argument or, if
the argument is left off, from standard in:

    $ plessc -r "my less code here"

Finally, by using the -w flag you can watch a specified input file and have it
compile as needed to the output file:

    $ plessc -w input-file output-file

Errors from watch mode are written to standard out.

The -f flag sets the [output formatter][1]. For example, to compress the
output run this:

    $ plessc -f=compressed myfile.less

For more help, run `plessc --help`


## Angus PHP 8.2 maintenance (v1.0.2)

The global `lessc` API and compiler algorithms are retained. Deprecated string
interpolation syntax is updated, and 18 historical public runtime-state fields
are explicitly declared, without types or `AllowDynamicProperties` attributes.

Declarations intentionally change internal object representation: a newly
constructed compiler exposes six additional null public fields, `property_exists()`
can become true before a field is assigned, and field enumeration/order and PHP
serialization may differ for compiler, parser and formatter instances. Do not
rely on their old serialized internal layout. Compiler output and public
operations are checked against the previous Angus version under PHP 8.1/8.2.
Existing float-to-int deprecations in color arithmetic also occur under PHP 8.1;
this release preserves those algorithms rather than changing their rounding.
