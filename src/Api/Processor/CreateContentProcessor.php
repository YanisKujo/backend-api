<?php declare(strict_types=1);

namespace App\Api\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\Resource\CreateContent;
use App\Entity\Content;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\String\Slugger\AsciiSlugger;

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

        $content->metaTitle = $data->metaTitle;

        $content->metaDescription = $data->metaDescription;

        $slugger = new AsciiSlugger();
        $slug = $slugger->slug($data->title)->lower()->toString();

        $originalSlug = $slug;
        $i = 1;
        while ($this->em->getRepository(Content::class)->findOneBy(['slug' => $slug])) {
            $slug = $originalSlug . '-' . $i++;
        }

        $content->slug = $slug;
        
        $this->em->persist($content);
        $this->em->flush();

        return $content;
    }
}
