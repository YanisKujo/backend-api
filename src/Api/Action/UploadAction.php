<?php

namespace App\Api\Action;

use App\Entity\Upload;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

#[AsController] # on définit que c'est un controller
class UploadAction
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        #[Autowire(param: 'kernel.project_dir')] # on récupère la racine de notre projet
        private string $projectDir,
    ) {
    }

    public function __invoke(Request $request)
    {
        $file = $request->files->get('file'); # on récupère le fichier uploadé par l'user

        if (!$file instanceof UploadedFile) {
            throw new BadRequestHttpException(); # si le fichier n'est pas reconnu par symfony, on arrête là
        }

        $path = uniqid().".".$file->getClientOriginalExtension(); # on génère un "path" unique en préservant l'extension du fichier

        $file->move($this->projectDir.'/public/medias', $path); # on bouge le fichier dans le dossier public/medias avec comme nom le path défini avant

        $upload = new Upload(); # on crée notre upload et on précise le path
        $upload->path = "/medias/{$path}";

        return $upload; // on retourne notre objet upload pour qu'ApiPlatform génère notre réponse API
    }
}
