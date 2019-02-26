
# Voucherator
[![Total Downloads](https://poser.pugx.org/amestsantim/voucherator/downloads)](https://packagist.org/packages/amestsantim/voucherator) [![License](https://poser.pugx.org/amestsantim/voucherator/license)](https://packagist.org/packages/amestsantim/voucherator)

The only voucher (alphanumeric code) generator you will ever need for PHP.  
Voucherator is a fluent PHP library that is also Laravel compatible. You can use it to generate all sorts of random alphanumeric vouchers/codes.

## Prerequisites

This package uses PHP 7's `random_int()` function which generates cryptographic random integers that are suitable for use where unbiased results are critical, such as when shuffling a deck of cards for a poker game.

The sources of randomness used for this function are as follows and if your machine does not provide one of these, you will not be able to use this package.

-   On Windows,  [» **CryptGenRandom()**](https://msdn.microsoft.com/en-us/library/windows/desktop/aa379942(v=vs.85).aspx)  will always be used. As of PHP 7.2.0, the  [» CNG-API](https://docs.microsoft.com/en-us/windows/desktop/SecCNG/cng-portal)  will always be used instead.
-   On Linux, the  [» getrandom(2)](http://man7.org/linux/man-pages/man2/getrandom.2.html)  syscall will be used if available.
-   On other platforms,  /dev/urandom  will be used.
-   If none of the aforementioned sources are available, then an  [Exception](http://php.net/manual/en/class.exception.php)  will be thrown. (caught and supressed by this package)

## Installation


### Via Composer

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
use Amestsantim\Voucherator\VoucherGenerator;
$v = new VoucherGenerator();
printf("Your coupon code is %s", $v->letters()->length(12)->generate());
// Your coupon code is pxEJvcvRjwNg
```
If you are using it in Laravel, you can instantiate an object from the `AmestSantim\Voucherator\VoucherGenerator` and statically access the methods from the  `AmestSantim\Voucherator\VoucherTransformer` class, if you need to apply transformations on your generated vouchers.

## Usage

```php
$v = AmestSantim\Voucherator\VoucherGenerator();

$v->generate(10)
// ["6ae4OgTp", ...]

$v->letters()->generate(5)
// ["sVnkujCq", ...]

$v->numerals()->length(16)->generate()
// ["1734785015950957", ...]

$v->letters()->upperCase()->generate(200)
// ["JTMAZNIZDDSUGVHC", ...]

$v->numerals()->exclude('018')->generate(3)
// ["4454525224222425", ...]

$v->augment('#*')->addPrefix('ET')->generate(3)
// ["ET69376##4492*2736", ...]

$v->length(14)->addPrefix('ET')->addSeparator(4, '-')->generate(3)
// ["ET4Z-c3pP-APDU-E4u2", ...]
```
## Documentation
The package is organized very simply. It contains only two classes:

 - VoucherGenerator
 - VoucherTransformer

The methods of the `VoucherGenerator` class can be semantically classified into two:

### Mutators
These are the functions that mutate the character set (charSet) from which the vouchers/codes are generated. The default is lower case alphabets, upper case alphabets and numerals.
- **letters()**  
Calling this function will set the character set to be lower (a - z) and upper (A - Z) case alphabets.

- **numerals()**  
This will set the character set to be numerals (0123456789).

- **upperCase()**  
This will change the characters in the character set all to upper case (A - Z). If the set happend to be upper and lower case letters before the application of the function, then the set will be consolidated (redundancies removed).

- **lowerCase()**  
This will change the characters in the character set all to lower case (a - z). If the set happend to be upper and lower case letters before the application of the function, then the set will be consolidated (redundancies removed).

- **exclude(string $exclusionList)**  
This function will remove the given characters (\$exclusionList) from the character set. If the given characters are not in the character set then it will be ignored.
Example: `$v->exclude('0o1li')->generate()`

- **augment(string $inclusionList)**  
This function will add the given characters (\$inclusionList) to the character set. If the given characters (some) are already in the character set then they will not be added again.
Example: `$v->augment('#_*@?')->generate()`

### Action and Related
These function are action functions which tell the object to actually generate the vouchers/codes based on the (possibly previously mutated) character set.

- **generate(int $count)**  
This function needs to be called at the end of a fluent chain. You can not call generate() in the middle of a chain. It accepts the number of vouchers to generate and returns an array of generated vouchers (even for a single voucher).

- **length(int $voucherLength)**  
This function is used to set the length (size) of your vouchers. The default value used (if you do not call this function) is 8.

- **charSet()**  
This function returns the current character set as is. The return is array. It is included for testing and debugging purposes and would have no conceivable use in production.

The methods of the `VoucherTransformer` class are all static and can be used without instantiating an object. They act upon the vouchers/codes after they have been generated by transforming the vouchers in superficial (presentational) ways such as re-formatting and decorating them.

- **capitalizeFirstCharacter()**  
This function will capitalize the first character of each voucher/code.
Example: `$myProperCaseVouchers = VoucherTransformer::capitalizeFirstCharacter($myVouchers)`

- **addSeparator($chunkSize, $separator)**  
This function will group the characters of the vouchers in to chunks of size $chunkSize and join them with the given character (\$separator)

- **addPrefix (\$prefix)**  
This function will prefix all generated vouchers/codes with the given string ($prefix)



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
