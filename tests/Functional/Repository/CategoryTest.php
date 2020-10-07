<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\DataFixtures\ORM\CategoryFixtures;
use App\Repository\CategoryRepository;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CategoryTest extends KernelTestCase
{

    use FixturesTrait;

    public function testCount()
    {
        self::bootKernel();
        $this->loadFixtures([CategoryFixtures::class]);
        $users = self::$container->get(CategoryRepository::class)->count([]);

        $this->assertSame(2, $users, "Nombre de catégories dans sqlLite");
    }
}
