# Laravel Lang: Status Generator

![laravel-lang status generator](https://preview.dragon-code.pro/laravel-lang/status-generator.svg?brand=laravel)

[![Stable Version][badge_stable]][link_packagist]
[![Unstable Version][badge_unstable]][link_packagist]
[![Total Downloads][badge_downloads]][link_packagist]
[![License][badge_license]][link_license]


## Installation

To get the latest version of `Laravel Lang: Status Generator` library, simply require the project using [Composer](https://getcomposer.org):

```
$ composer require laravel-lang/status-generator --dev
```

Instead, you may of course manually update your `require-dev` block and run `composer update` if you so choose:

```json
{
    "require-dev": {
        "laravel-lang/status-generator": "^1.0"
    }
}
```

## Using

### Create new locale

```bash
bin/lang create <locale>
```

### Download

For example:

```bash
bin/lang download --url=https://github.com/laravel/framework/archive/refs/heads/9.x.zip --project=framework --ver=9.x
bin/lang download --url=https://github.com/laravel/framework/archive/refs/heads/8.x.zip --project=framework --ver=8.x

bin/lang download --url=https://github.com/laravel/laravel/archive/refs/heads/9.x.zip --project=laravel --ver=9.x --copy=lang
bin/lang download --url=https://github.com/laravel/laravel/archive/refs/heads/8.x.zip --project=laravel --ver=8.x --copy=lang --copy=resources/lang

bin/lang download --url=https://github.com/laravel/jetstream/archive/refs/heads/2.x.zip --project=jetstream --ver=2.x
bin/lang download --url=https://github.com/laravel/jetstream/archive/refs/heads/1.x.zip --project=jetstream --ver=1.x
```

### Actualize excludes

```bash
bin/lang excludes
```

### Translations status

```bash
bin/lang status
```

### Actualize keys

```bash
bin/lang sync
```

### Upgrade from previous structure

```bash
bin/lang upgrade
```

[badge_stable]:     https://img.shields.io/github/v/release/laravel-lang/status-generator?label=stable&style=flat-square

[badge_unstable]:   https://img.shields.io/badge/unstable-dev--main-orange?style=flat-square

[badge_downloads]:  https://img.shields.io/packagist/dt/laravel-lang/status-generator.svg?style=flat-square

[badge_license]:    https://img.shields.io/packagist/l/laravel-lang/status-generator.svg?style=flat-square

[link_packagist]:   https://packagist.org/packages/laravel-lang/status-generator

[link_license]:     LICENSE
