<?php declare(strict_types=1);

namespace App\Doctrine\Trait;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

trait TimestampableTrait
{
    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, insertable: false, updatable: false, options: ['default' => 'CURRENT_TIMESTAMP'], generated: 'INSERT')]
    public ?DateTime $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true, insertable: false, updatable: false, columDefinition: 'DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP' , generated: 'ALWAYS')]
    public ?DateTime $updatedAt = null;
}
