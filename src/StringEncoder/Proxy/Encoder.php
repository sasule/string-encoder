<?php

declare(strict_types=1);

namespace StringEncoder\Proxy;

use StringEncoder\Contracts\ConvertWriteInterface;
use StringEncoder\Encoder as EncoderImplementation;
use StringEncoder\Exceptions\InvalidEncodingException;

final class Encoder
{
    /**
     * @var EncoderImplementation
     */
    private static $encoder = null;

    /**
     * @throws InvalidEncodingException
     */
    public static function mountFromEncoding(string $targetEncoding, ?string $sourceEncoding = null): void
    {
        $encoder = new EncoderImplementation();
        $encoder->setTargetEncoding($targetEncoding);
        if ($sourceEncoding !== null) {
            $encoder->setSourceEncoding($sourceEncoding);
        }
        self::mount('Encoder', $encoder);
    }

    /**
     * Call this to mount the static facade. The facade allows you to use
     * this object as a $className.
     */
    public static function mount(string $className = 'Encoder', ?EncoderImplementation $encoder = null): bool
    {
        if (!\class_exists($className)) {
            \class_alias(__CLASS__, $className);
        }
        if ($encoder instanceof EncoderImplementation) {
            self::$encoder = $encoder;
        }

        return true;
    }

    public static function getMountedEncoder(): ?EncoderImplementation
    {
        return self::$encoder;
    }

    public static function unload(): void
    {
        self::$encoder = null;
    }

    public static function getTargetEncoding(): ?string
    {
        return self::$encoder->getTargetEncoding();
    }

    public static function setTargetEncoding(string $encoding): void
    {
        self::$encoder->setTargetEncoding($encoding);
    }

    public static function getSourceEncoding(): ?string
    {
        return self::$encoder->getSourceEncoding();
    }

    public static function setSourceEncoding(string $encoding): void
    {
        self::$encoder->setSourceEncoding($encoding);
    }

    public static function convert(): ConvertWriteInterface
    {
        return self::$encoder->convert();
    }
}
