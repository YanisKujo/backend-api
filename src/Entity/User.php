<?php declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use Symfony\Component\Validator\Constraints as Assert;
use App\Doctrine\Trait\UuidTrait;
use App\Enum\TableEnum;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Attribute\Ignore;
use App\Api\Resource\CreateUser;
use App\Api\Processor\CreateUserProcessor;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Put;
use App\Enum\RoleEnum;
use App\Validator\UnregistredEmail;

#[ORM\Entity]
#[ApiResource]
#[Post(input: CreateUser::class, processor: CreateUserProcessor::class)]
#[Delete(security: 'is_granted('.RoleEnum::ROLE_ADMIN.')')]
#[Put(security: 'is_granted('.RoleEnum::ROLE_ADMIN.')')]
#[GetCollection()]
#[ORM\Table(name: TableEnum::USER)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use UuidTrait;

    #[ORM\Column]
    #[Assert\NotBlank]
    public ?string $firstName = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    public ?string $lastName = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\Email]
    #[UnregistredEmail()]
    public ?string $email = null;

    #[ORM\Column]
    #[Ignore]
    public ?string $password = null;

    #[ORM\Column]
    public array $roles = [];

    public function getUserIdentifier(): string
    {
        return (string)$this->email;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function eraseCredentials(): void
    {
    }

    public function __construct()
    {
        $this->defineUuid();
    }
}
