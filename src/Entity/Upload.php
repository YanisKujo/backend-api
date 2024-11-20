<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use App\Api\Action\UploadAction;
use App\Enum\TableEnum;
use Doctrine\ORM\Mapping as ORM;
use App\Doctrine\Trait\TimestampableTrait;
use App\Doctrine\Trait\UuidTrait;
use App\Enum\RoleEnum;

#[ORM\Entity]
#[ORM\Table(name: TableEnum::UPLOAD)]
#[Get]
#[Post(controller: UploadAction::class, deserialize: false, security: 'is_granted('.RoleEnum::ROLE_ADMIN.')')]
class Upload
{
    use UuidTrait, TimestampableTrait;

    #[ORM\Column]
    public ?string $path = null;

    public function __construct()
    {
        $this->defineUuid();
    }
}
