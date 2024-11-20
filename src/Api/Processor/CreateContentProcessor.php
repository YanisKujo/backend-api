<?php declare(strict_types=1);

namespace App\Api\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\Resource\CreateContent;
use App\Entity\Content;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

final readonly class CreateContentProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $em,
        private Security $security,
    ) {
    }

    /** @param CreateContent $data */
    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = [],
    ): Content {
        $content = new Content();

        $content->author = $this->security->getUser();

        $content->title = $data->title;

        $content->content = $data->content;

        $content->cover = $data->cover;

        $content->tags = $data->tags;

        $content->slug = $data->slug;
        
        $this->em->persist($content);
        $this->em->flush();

        return $content;
    }
}
