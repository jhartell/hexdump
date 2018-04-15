[![Build Status](https://travis-ci.org/jhartell/hexdump.svg?branch=master)](https://travis-ci.org/jhartell/hexdump)

# jhartell/hexdump

Hexdump utility for PHP.
Print binary data in a similar format to the hexdump (hd) command line tool.
Useful when debugging socket communications or handling binary files.

## Installation

Install the latest version with

```bash
$ composer require jhartell/hexdump
```

## Usage

```php
<?php
use Jhartell\Hexdump\Hexdump;
$hexdump = new Hexdump();
$data = "This is a string with non-printable \x05\x10 characters\x00";
?>
<pre>
<?php echo $hexdump->dump($data); ?>
</pre>
```

This will output the data in the default Hex+ASCII format.
```
00000000  54 68 69 73 20 69 73 20  61 20 73 74 72 69 6e 67  |This is a string|
00000010  20 77 69 74 68 20 6e 6f  6e 2d 70 72 69 6e 74 61  | with non-printa|
00000020  62 6c 65 20 05 10 20 63  68 61 72 61 63 74 65 72  |ble .. character|
00000030  73 00                                             |s.|
00000032
```
