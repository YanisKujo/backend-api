<?php declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Doctrine\DBAL\Types\Types;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use App\Doctrine\Trait\TimestampableTrait;
use App\Doctrine\Trait\UuidTrait;
use App\Enum\TableEnum;

#[ORM\Entity]
#[ApiResource]
#[UniqueEntity('slug')]
#[ORM\Table(name: TableEnum::CONTENT)]
class Content
{
   use TimestampableTrait, UuidTrait;

    #[ORM\Column(type: Types::STRING)]
    public ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    public ?string $content = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'author_uuid', referencedColumnName: 'uuid' ,nullable: false)]
    public ?User $author = null;


    public function __construct()
    {
    
    }
}
