<?php

namespace App\Api\Resource;

use Symfony\Component\Validator\Constraints as Assert;

class CreateUser
{
    #[Assert\NotBlank]
    public ?string $email = null;
    #[Assert\NotBlank]
    public ?string $password = null;
    #[Assert\NotBlank]
    public ?string $firstName = null;
    #[Assert\NotBlank]
    public ?string $lastName = null;
}
