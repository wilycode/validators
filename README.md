# wilycode/validators

Optional collection of ready-to-use validators built on `wilycode/validator`.

```bash
composer require wilycode/validators
```

The package includes common validators for strings, arrays, numbers, dates, e-mail addresses, URLs, UUIDs, JSON, uploaded files and other transport-level values.

## Use only what you need

The collection is optional. Applications can depend only on `wilycode/validator` and implement their own rules. Under the MIT license you may also copy and adapt an individual validator when that is preferable to depending on the whole implementation collection. Installing `wilycode/validators` does not mean every validator is loaded at runtime; Composer/PSR-4 loads classes on demand.

## Validation error messages

Translations are maintained separately in [wilycode/validation-messages](https://github.com/wilycode/validation-messages). The repository provides ready-to-copy validation error messages for European languages; no Packagist package or extra runtime dependency is required.

```bash
git clone https://github.com/wilycode/validation-messages.git
```

Copy the required `languages/<locale>/validation.php` file into your application's translation directory. WilyCode validator error codes such as `validation.string_length.too_short` correspond to the `string_length.too_short` key in the `validation` resource. The application controls translation, interpolation and display; this validator package remains language-independent.

## Requirements

- PHP `^8.4`
- PHP extension `mbstring`
- `psr/http-message` `^1.1 || ^2.0`
- `wilycode/validator` `^0.1`

## Installation

```bash
composer require wilycode/validators
```

## License

MIT. See [LICENSE](LICENSE).
