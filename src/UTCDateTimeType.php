<?php

declare(strict_types=1);

namespace SLLH\Doctrine\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\DateTimeType;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 *
 * @see http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/cookbook/working-with-datetime.html#handling-different-timezones-with-the-datetime-type
 */
final class UTCDateTimeType extends DateTimeType
{
    /**
     * @var \DateTimeZone
     */
    private static $utc;

    /**
     * {@inheritdoc}
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value instanceof \DateTime) {
            $value->setTimezone(static::$utc ?: static::$utc = new \DateTimeZone('UTC'));
        }

        return parent::convertToDatabaseValue($value, $platform);
    }

    /**
     * {@inheritdoc}
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (null === $value || $value instanceof \DateTime) {
            return $value;
        }

        $converted = \DateTime::createFromFormat(
            $platform->getDateTimeFormatString(),
            $value,
            static::$utc ?: static::$utc = new \DateTimeZone('UTC')
        );

        if (!$converted) {
            throw ConversionException::conversionFailedFormat(
                $value,
                $this->getName(),
                $platform->getDateTimeFormatString()
            );
        }

        return $converted;
    }
}
