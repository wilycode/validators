# wilycode/validators

Optional collection of ready-to-use validators built on `wilycode/validator`.

```bash
composer require wilycode/validators
```

The package includes common validators for strings, arrays, numbers, dates, e-mail addresses, URLs, UUIDs, JSON, uploaded files and other transport-level values.

## Use only what you need

The collection is optional. Applications can depend only on `wilycode/validator` and implement their own rules. Under the MIT license you may also copy and adapt an individual validator when that is preferable to depending on the whole implementation collection. Installing `wilycode/validators` does not mean every validator is loaded at runtime; Composer/PSR-4 loads classes on demand.

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
