
# Voucherator
[![Total Downloads](https://poser.pugx.org/amestsantim/voucherator/downloads)](https://packagist.org/packages/amestsantim/voucherator) [![License](https://poser.pugx.org/amestsantim/voucherator/license)](https://packagist.org/packages/amestsantim/voucherator)

The only voucher (alphanumeric code) generator you will ever need for PHP
Voucherator is a fluent PHP library that is also Laravel compatible. You can use it to generate all sorts of random alpha numeric vouchers/codes.

## Prerequisites

This package uses PHP 7's `random_int()` which generates cryptographic random integers that are suitable for use where unbiased results are critical, such as when shuffling a deck of cards for a poker game.

The sources of randomness used for this function are as follows and if your machine does not provide one of these, you will not be able to use this package.

-   On Windows,  [» **CryptGenRandom()**](https://msdn.microsoft.com/en-us/library/windows/desktop/aa379942(v=vs.85).aspx)  will always be used. As of PHP 7.2.0, the  [» CNG-API](https://docs.microsoft.com/en-us/windows/desktop/SecCNG/cng-portal)  will always be used instead.
-   On Linux, the  [» getrandom(2)](http://man7.org/linux/man-pages/man2/getrandom.2.html)  syscall will be used if available.
-   On other platforms,  /dev/urandom  will be used.
-   If none of the aforementioned sources are available, then an  [Exception](http://php.net/manual/en/class.exception.php)  will be thrown. (caught and supressed by this package)

## Installation


### With Composer

This package can be installed easily with composer - just require the  `amestsantim/voucherator`  package from the command line.

```
composer require amestsantim/voucherator
```

Alternatively, you can manually add the voucherator package to your  `composer.json`  file and then run  `composer install`  from the command line as follows:
```
{
    "require": {
        "amestsantim/voucherator": "~1.0"
    }
}
```
```
composer install
```

You can use it in your PHP code like this:
```php
<?php
require __DIR__ . '/vendor/autoload.php';
use Amestsantim\Voucherator\AlphaNumericGenerator;
$v = new AlphaNumericGenerator();
printf("Your coupon code is %s", $v->letters()->length(12)->generate());
// Your coupon code is pxEJvcvRjwNg
```
If you are using it in Laravel, you can either instantiate an object from the AmestSantim\Voucherator\AlphaNumericGenerator class or you can also use the Voucher facade.

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

$voucherMaker->augment('#*')->addPrefix('ET')->generate(3) 
// ["ET69376##4492*2736", ...]

$voucherMaker->length(14)->addPrefix('ET')->addSeparator(4, '-')->generate(3) 
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
Calling this function will set the character set to be lower (a - z) and upper (A - Z) case alphabets 

- **numerals()**  
This will set the character set to be numerals (0123456789)

- **upperCase()**  
This will change the characters in the character set all to upper case (A - Z). If the set happend to be upper and lower case letters before the application of the function, then the set will be consolidated (redundancies removed).

- **lowerCase()**  
This will change the characters in the character set all to lower case (a - z). If the set happend to be upper and lower case letters before the application of the function, then the set will be consolidated (redundancies removed).

- **exclude(string $exclusionList)**  
This function will remove the given characters (\$exclusionList) from the character set. If the given characters are not in the character set then it will be ignored.
Example: `$voucherMaker->exclude('0o1li')->generate()`

- **augment(string $inclusionList)**  
This function will add the given characters (\$inclusionList) to the character set. If the given characters (some) are already in the character set then they will not be added again.
Example: `$voucherMaker->augment('#_*@?')->generate()`

### Transformers
These are functions that act upon the vouchers/codes after they have been generated. They act to transform the vouchers in superficial (presentational) ways such as re-formatting them. 

They do not persist after a call to generate() function. Meaning, that once you call the generate() function on the generator object, they will not have an effect on preceeding calls to generate() unless they are called again. This is unlike the mutators (above) which once called will have modified the character set. 

Also, mind the order in which you call these transformers as order might matter in some cases such as addSeparator() and addPrefix()

- **capitalizeFirstCharacter()**  
This function will capitalize the first character of each voucher/code

- **addSeparator($chunkSize, $separator)**  
This function will group the characters of the vouchers in to chunks of size $chunkSize and join them with the given character (\$separator) 

- **addPrefix (\$prefix)**  
This function will prefix all generated vouchers/codes with the given string ($prefix)

### Action and Related
These function are action functions which tell the package to actually generate the vouchers/codes based on the (possiblly previously mutated) character set.

- **generate(int $count)**  
This function needs to be called at the end of a fluent chain. You can not call generate() in the middle of a chain. It accepts the number of vouchers to generate and returns an array of generated vouchers. 

- **length(int $voucherLength)**  
This function is used to set the length (size) of your vouchers. The default value used (if you do not call this function) is 8.

- **charSet()**  
This function returns the current character set as is. The return is array. It is included for testing and debugging purposes and would have no conceiveable use in production.

## Contributing

The code follows the PSR-2 coding style guide. It was also written with extensibility in mind. Please feel free to submit a pull request, if you come up with any useful improvements.

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/your/project/tags). 

## Authors

* **Nahom Tamerat**

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details

## Acknowledgments

* This package was inspired by [keygen-php](https://github.com/gladchinda/keygen-php)

