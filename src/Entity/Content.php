<?php declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use Doctrine\DBAL\Types\Types;
use App\Doctrine\Trait\TimestampableTrait;
use App\Doctrine\Trait\UuidTrait;
use App\Enum\TableEnum;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use App\Api\Processor\CreateContentProcessor;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Put;
use App\Enum\RoleEnum;

#[ORM\Entity]

#[ORM\Table(name: TableEnum::CONTENT)]
#[ApiResource]
#[Get]
#[GetCollection()]
#[Delete(security: 'is_granted('.RoleEnum::ROLE_ADMIN.')')]
#[Post(processor: CreateContentProcessor::class, security: 'is_granted('.RoleEnum::ROLE_ADMIN.')')]
#[Put(security: 'is_granted('.RoleEnum::ROLE_ADMIN.')')]
#[ApiFilter(SearchFilter::class, properties: ['title' => 'partial'])]
class Content
{
   use TimestampableTrait, UuidTrait;

    #[ORM\Column(type: Types::STRING)]
    #[Assert\NotBlank]
    public ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    public ?string $content = null;

    #[ORM\Column(type: Types::STRING)]
    #[Assert\NotBlank]
    public ?string $cover = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'author_uuid', referencedColumnName: 'uuid' ,nullable: false, onDelete: 'CASCADE')]
    #[Assert\NotNull]
    public ?User $author = null;

    #[ORM\Column(type: Types::STRING, unique: true)]
    public ?string $slug = null;

    #[ORM\Column(type: Types::JSON, unique: true)]
    public ?array $tags = [];

    #[ORM\ManyToOne(targetEntity: Upload::class)]
    public ?Upload $upload = null;

    public function __construct()
    {
        $this->defineUuid();
    }
}
