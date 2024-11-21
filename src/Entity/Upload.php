<?php declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use App\Api\Action\UploadAction;
use App\Doctrine\Trait\TimestampableTrait;
use App\Doctrine\Trait\UuidTrait;
use App\Enum\RoleEnum;
use App\Enum\TableEnum;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: TableEnum::UPLOAD)]
#[Get]
#[Post(controller: UploadAction::class, deserialize: false, security: 'is_granted("' . RoleEnum::ROLE_ADMIN . '")')]
class Upload
{
    use UuidTrait;
    use TimestampableTrait;

    #[ORM\Column]
    public ?string $path = null;

    public function __construct()
    {
        $this->defineUuid();
    }
}
