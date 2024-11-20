<?php declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiProperty;
use App\Enum\TableEnum;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use App\Doctrine\Trait\UuidTrait;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;
use App\Api\Processor\CreateContentProcessor;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Enum\RoleEnum;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Table(name: TableEnum::COMMENT)]
#[ApiResource]
#[ORM\Entity]
#[GetCollection()]
#[Delete(security: 'is_granted('.RoleEnum::ROLE_USER.') and object.author == user or is_granted('.RoleEnum::ROLE_ADMIN.')')]
#[Post(processor: CreateContentProcessor::class, security: 'is_granted('.RoleEnum::ROLE_USER.')')]
#[Put(denormalizationContext: ['groups' => ['comment:update']], security: 'is_granted('.RoleEnum::ROLE_USER.') and object.author == user or is_granted('.RoleEnum::ROLE_ADMIN.') and object.author == user')]
#[ApiFilter(SearchFilter::class, properties: ['content' => 'exact'])]
#[ApiProperty()]
class Comment
{
    use UuidTrait;

    #[ORM\Column(type: Types::STRING)]
    #[Assert\NotBlank]
    #[Groups(['comment:update'])]
    public ?string $comment = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'author_uuid', referencedColumnName: 'uuid' ,nullable: false, onDelete: 'CASCADE')]
    public ?User $author = null;

    #[ORM\ManyToOne(targetEntity: Content::class)]
    #[ORM\JoinColumn(name: 'content_uuid', referencedColumnName: 'uuid' ,nullable: false)]
    #[Assert\NotBlank]
    public ?Content $content = null;

    public function __construct()
    {
        $this->defineUuid();
    }
}
