# Doctrine DBAL UTC DateTime

UTC DateTime type for Doctrine DBAL.

[![Latest Stable Version](https://poser.pugx.org/sllh/doctrine-dbal-utc-datetime/v/stable)](https://packagist.org/packages/sllh/doctrine-dbal-utc-datetime)
[![Latest Unstable Version](https://poser.pugx.org/sllh/doctrine-dbal-utc-datetime/v/unstable)](https://packagist.org/packages/sllh/doctrine-dbal-utc-datetime)
[![License](https://poser.pugx.org/sllh/doctrine-dbal-utc-datetime/license)](https://packagist.org/packages/sllh/doctrine-dbal-utc-datetime)

[![Total Downloads](https://poser.pugx.org/sllh/doctrine-dbal-utc-datetime/downloads)](https://packagist.org/packages/sllh/doctrine-dbal-utc-datetime)
[![Monthly Downloads](https://poser.pugx.org/sllh/doctrine-dbal-utc-datetime/d/monthly)](https://packagist.org/packages/sllh/doctrine-dbal-utc-datetime)
[![Daily Downloads](https://poser.pugx.org/sllh/doctrine-dbal-utc-datetime/d/daily)](https://packagist.org/packages/sllh/doctrine-dbal-utc-datetime)

[![Build Status](https://travis-ci.org/Soullivaneuh/doctrine-dbal-utc-datetime.svg?branch=master)](https://travis-ci.org/Soullivaneuh/doctrine-dbal-utc-datetime)
[![Coverage Status](https://coveralls.io/repos/Soullivaneuh/doctrine-dbal-utc-datetime/badge.svg?branch=master)](https://coveralls.io/r/Soullivaneuh/doctrine-dbal-utc-datetime?branch=master)

## Why this DBAL Type?

This special type allow you to be sure to **always** save any DateTime to the UTC format.

The goal is to get rid of the quite hazardous timezone management of many database vendors.

For more information, please read the [official Doctrine wiki page](doctrine_datetime), where this class come from.

## Setup

First of all, you need to require this library through composer:

``` bash
composer require sllh/doctrine-dbal-utc-datetime
```

Then, replace the default `datetime` and `datetimetz` DBAL types:

```php
use Doctrine\DBAL\Types\Type;
use SLLH\Doctrine\DBAL\Types\UTCDateTimeType;

Type::overrideType('datetime', UTCDateTimeType::class);
Type::overrideType('datetimetz', UTCDateTimeType::class);
```

If you are using [Symfony](http://symfony.com/), you can override the type trough the `config.yml` file:

```yaml
doctrine:
    dbal:
        types:
            datetime: SLLH\Doctrine\DBAL\Types\UTCDateTimeType
            datetimetz: SLLH\Doctrine\DBAL\Types\UTCDateTimeType
```

And voilà! You are good to go. Happy coding!

## License

This bundle is under the MIT license. See the complete license on the [LICENSE](LICENSE) file.

[doctrine_datetime]: http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/cookbook/working-with-datetime.html#handling-different-timezones-with-the-datetime-type
