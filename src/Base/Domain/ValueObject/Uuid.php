<?php
declare(strict_types=1);

namespace Src\Base\Domain\ValueObject;

use Ramsey\Uuid\Uuid as RUuid;
use Ramsey\Uuid\UuidFactory;
use Ramsey\Uuid\UuidInterface;

final class Uuid
{
    /**
     * @var UuidInterface
     */
    private $uuid;

    public static function generateString(): string
    {
        return Ruuid::uuid4()->toString();
    }

    public static function generate(): Uuid
    {
        if (RUuid::getFactory() === null) {
            $uuidFactory = new UuidFactory();
            RUuid::setFactory($uuidFactory);
        }

        return new self(RUuid::uuid4());
    }

    public static function fromString(string $uuid): Uuid
    {
        return new self(RUuid::fromString($uuid));
    }

    public static function fromBytes(string $uuid): Uuid
    {
        return new self(RUuid::fromBytes($uuid));
    }

    private function __construct(UuidInterface $uuid)
    {
        $this->uuid = $uuid;
    }

    public function toString(): string
    {
        return $this->uuid->toString();
    }

    public function toBytes(): string
    {
        return $this->uuid->getBytes();
    }

    public function equalsTo(Uuid $id): bool
    {
        return $this->toString() === $id->toString();
    }
}
