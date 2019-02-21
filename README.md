
# Voucherator

The only voucher (alphanumeric code) generator you will ever need for PHP
Voucherator is a fluent PHP library that is also compatible with Laravel.

### Installing

The package can be installed via composer.

```
composer require amestsantim/voucherator
```

End with an example of getting some data out of the system or using it for a little demo

### Usage

```
$voucherMaker = AmestSantim\Voucherator\AlphaNumericGenerator();

$vouchers = $voucherMaker->generate(10) // ["6ae4OgTp", ...]
$vouchers = $voucherMaker->letters()->generate(5) // ["sVnkujCq", ...]
$vouchers = $voucherMaker->numerals()->length(16)->generate() // ["1734785015950957", ...]
$vouchers = $voucherMaker->letters()->upperCase()->generate(200) // ["JTMAZNIZDDSUGVHC", ...]
$vouchers = $voucherMaker->numerals()->exclude('018')->generate(3) // ["4454525224222425", ...]
$vouchers = $voucherMaker->include('#*')->prefix('ET')->generate(3) // ["ET69376##4492*2736", ...]
$vouchers = $voucherMaker->length(14)->prefix('ET')->addSeparator(4, '-')->generate(3) // ["ET4Z-c3pP-APDU-E4u2", ...]
```
### Documentation


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

