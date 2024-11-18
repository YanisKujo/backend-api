<?php declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Validator\Constraints as Assert;
use App\Doctrine\Trait\TimestampableTrait;
use App\Doctrine\Trait\UuidTrait;
use App\Enum\TableEnum;

#[ORM\Entity]
#[ApiResource]
#[ORM\Table(name: TableEnum::USER)]
class User
{
    use TimestampableTrait, UuidTrait;

    #[ORM\Column]
    #[Assert\NotBlank]
    public ?string $surname = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    public ?string $name = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\Email]
    public ?string $email = null;

    public function __construct()
    {
        $this->defineUuid();
    }
}
