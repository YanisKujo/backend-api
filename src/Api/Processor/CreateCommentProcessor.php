<?php declare(strict_types=1);

namespace App\Api\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\Resource\CreateComment;
use App\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

final readonly class CreateCommentProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $em,
        private Security $security,
    ) {
    }

    /** @param CreateComment $data */
    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = [],
    ): Comment {
        $comment = new Comment();

        $comment->author = $this->security->getUser();

        $comment->comment = $data->comment;

        $comment->content = $data->content;

        $this->em->persist($comment);
        $this->em->flush();

        return $comment;
    }
}
