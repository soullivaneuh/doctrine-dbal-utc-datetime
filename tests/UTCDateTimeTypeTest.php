<?php

declare(strict_types=1);

namespace SLLH\Tests\Doctrine\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Platforms\MySqlPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;
use PHPUnit\Framework\TestCase;
use SLLH\Doctrine\DBAL\Types\UTCDateTimeType;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class UTCDateTimeTypeTest extends TestCase
{
    /**
     * @var AbstractPlatform
     */
    private $platform;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        Type::overrideType('datetime', UTCDateTimeType::class);
        Type::overrideType('datetimetz', UTCDateTimeType::class);
        $this->platform = new MySqlPlatform();
    }

    /**
     * @dataProvider getConvertToDatabaseValues
     *
     * @param mixed $value
     * @param mixed $expectedResult
     */
    public function testDateTimeConvertToDatabaseValue($value, $expectedResult)
    {
        $this->assertSame(
            $expectedResult,
            Type::getType('datetime')->convertToDatabaseValue($value, $this->platform)
        );
    }

    /**
     * @dataProvider getConvertToDatabaseValues
     *
     * @param mixed $value
     * @param mixed $expectedResult
     */
    public function testDateTimeTZConvertToDatabaseValue($value, $expectedResult)
    {
        $this->assertSame(
            $expectedResult,
            Type::getType('datetimetz')->convertToDatabaseValue($value, $this->platform)
        );
    }

    public function getConvertToDatabaseValues()
    {
        return [
            [null, null],
            [new \DateTime('2017-08-12 12:00', new \DateTimeZone('UTC')), '2017-08-12 12:00:00'],
            [new \DateTime('2017-08-12 12:00', new \DateTimeZone('Europe/Paris')), '2017-08-12 10:00:00'],
        ];
    }

    public function testDateTimeConvertNullToPHPValue()
    {
        $this->assertNull(Type::getType('datetime')->convertToPHPValue(null, $this->platform));
    }

    public function testDateTimeTZConvertNullToPHPValue()
    {
        $this->assertNull(Type::getType('datetimetz')->convertToPHPValue(null, $this->platform));
    }

    public function testDateTimeConvertDateTimeObjectToPHPValue()
    {
        $alreadyDateTime = new \DateTime();
        $this->assertSame(
            $alreadyDateTime,
            Type::getType('datetime')->convertToPHPValue($alreadyDateTime, $this->platform)
        );
    }

    public function testDateTimeTZConvertDateTimeObjectToPHPValue()
    {
        $alreadyDateTime = new \DateTime();
        $this->assertSame(
            $alreadyDateTime,
            Type::getType('datetimetz')->convertToPHPValue($alreadyDateTime, $this->platform)
        );
    }

    public function testDateTimeConvertDateStringToPHPValue()
    {
        /** @var \DateTime $converted */
        $converted = Type::getType('datetime')->convertToPHPValue('2017-01-01 12:00:34', $this->platform);
        $this->assertInstanceOf(\DateTime::class, $converted);
        $this->assertSame('2017-01-01 12:00:34', $converted->format('Y-m-d H:i:s'));
        $this->assertSame('UTC', $converted->getTimezone()->getName());
    }

    public function testDateTimeTZConvertDateStringToPHPValue()
    {
        /** @var \DateTime $converted */
        $converted = Type::getType('datetimetz')->convertToPHPValue('2017-01-01 12:00:34', $this->platform);
        $this->assertInstanceOf(\DateTime::class, $converted);
        $this->assertSame('2017-01-01 12:00:34', $converted->format('Y-m-d H:i:s'));
        $this->assertSame('UTC', $converted->getTimezone()->getName());
    }

    public function testDateTimeConvertToPHPValue()
    {
        $this->expectException(ConversionException::class);
        $this->expectExceptionMessage(
            'Could not convert database value "2017-01-01 12:00" to Doctrine Type datetime. Expected format: Y-m-d H:i:s'
        );

        Type::getType('datetime')->convertToPHPValue('2017-01-01 12:00', $this->platform);
    }

    public function testDateTimeTZConvertToPHPValue()
    {
        $this->expectException(ConversionException::class);
        $this->expectExceptionMessage(
            'Could not convert database value "2017-01-01 12:00" to Doctrine Type datetime. Expected format: Y-m-d H:i:s'
        );

        Type::getType('datetimetz')->convertToPHPValue('2017-01-01 12:00', $this->platform);
    }
}
