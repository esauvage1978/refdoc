<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\DataFixtures\ORM\UserFixtures;
use App\Repository\UserRepository;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase
{

    use FixturesTrait;
    
    public function testCount()
    {
        self::bootKernel();
        $this->loadFixtures([UserFixtures::class]);
        $users=self::$container->get(UserRepository::class)->count([]);

        $this->assertSame(17,$users,"Nombre d'utilisateur dans sqlLite");
    }

}