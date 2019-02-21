
# Voucherator
[![Latest Stable Version](https://poser.pugx.org/amestsantim/voucherator/v/stable)](https://packagist.org/packages/amestsantim/voucherator) [![Total Downloads](https://poser.pugx.org/amestsantim/voucherator/downloads)](https://packagist.org/packages/amestsantim/voucherator) [![License](https://poser.pugx.org/amestsantim/voucherator/license)](https://packagist.org/packages/amestsantim/voucherator)

The only voucher (alphanumeric code) generator you will ever need for PHP
Voucherator is a fluent PHP library that is also compatible with Laravel.

## Prerequisites

This package uses PHP 7's `random_int()` which generates cryptographic random integers that are suitable for use where unbiased results are critical, such as when shuffling a deck of cards for a poker game.

The sources of randomness used for this function are as follows and if your machine does not provide one of these, you will not be able to use this package.

-   On Windows,  [» **CryptGenRandom()**](https://msdn.microsoft.com/en-us/library/windows/desktop/aa379942(v=vs.85).aspx)  will always be used. As of PHP 7.2.0, the  [» CNG-API](https://docs.microsoft.com/en-us/windows/desktop/SecCNG/cng-portal)  will always be used instead.
-   On Linux, the  [» getrandom(2)](http://man7.org/linux/man-pages/man2/getrandom.2.html)  syscall will be used if available.
-   On other platforms,  /dev/urandom  will be used.
-   If none of the aforementioned sources are available, then an  [Exception](http://php.net/manual/en/class.exception.php)  will be thrown. (caught and supressed by this package)

## Installation

The package can be installed via composer.

```
composer require amestsantim/voucherator
```


## Usage

```php
$voucherMaker = AmestSantim\Voucherator\AlphaNumericGenerator();

$voucherMaker->generate(10) 
// ["6ae4OgTp", ...]

$voucherMaker->letters()->generate(5) 
// ["sVnkujCq", ...]

$voucherMaker->numerals()->length(16)->generate() 
// ["1734785015950957", ...]

$voucherMaker->letters()->upperCase()->generate(200) 
// ["JTMAZNIZDDSUGVHC", ...]

$voucherMaker->numerals()->exclude('018')->generate(3) 
// ["4454525224222425", ...]

$voucherMaker->include('#*')->prefix('ET')->generate(3) 
// ["ET69376##4492*2736", ...]

$voucherMaker->length(14)->prefix('ET')->addSeparator(4, '-')->generate(3) 
// ["ET4Z-c3pP-APDU-E4u2", ...]
```
## Documentation
The package is organized very simply. The `AlphaNumericGenerator` class implements an interface that forces it to implement only three basic functions.

 - generate
 - length
 - exclude

The methods of the class can be semantically classified into three:

### Mutators
These are the functions that mutate the character set (charSet) from which the vouchers/codes are generated. The default is lower case alphabets, upper case alphabetes and numerals.
- **letters()**
This function will set the character set to be lower and upper case alphabets 

- **numerals()**
This will set the character set to be numerals (0123456789)

- **upperCase()**
- **lowerCase()**
- **exclude()**
- **include()**

### Transformers
These are functions that act upon the vouchers/codes after they have been generated. They act to transform the vouchers in superficial (presentational) ways such as re-formatting them.

- **capitalizeFirstCharacter()**
This function will capitalize the first character of each voucher/code

- **addSeparator($chunkSize, $separator)**
This function will group the characters of the vouchers in to chunks of size $chunkSize and join them with the given character (\$separator) 

- **prefix (\$prefix)**
This function will prefix all generated vouchers/codes with the given string ($prefix)

### Action and Related
These function are action functions with tell the package to actually generate the vouchers/codes based on the (possiblly previously mutated) character set.
- **generate($count)**
- **length()**
- **charSet()**

## Contributing

The code follows the PSR-2 coding style guide. It was also written with extensibility in mind. Please feel free to submit a pull request.

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/your/project/tags). 

## Authors

* **Nahom Tamerat**

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details

## Acknowledgments

* This package was inspired by [keygen-php](https://github.com/gladchinda/keygen-php)

