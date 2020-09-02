<?php

declare(strict_types=1);

namespace App\Tests\Unitaire\Manager;

use Faker;
use App\Entity\Category;
use App\Manager\CategoryManager;
use App\DataFixtures\ORM\CategoryFixtures;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CategoryTest extends KernelTestCase
{

    use FixturesTrait;

    public function testManager(): CategoryManager
    {
        self::bootKernel();
        $this->loadFixtures([CategoryFixtures::class]);
        $manager = self::$container->get(CategoryManager::class);
        $this->assertTrue(true);
        return $manager;
    }

    /**
     * @depends testManager
     */
    public function testCreateCategory(CategoryManager $manager)
    {
        $cat =new Category();
        $cat->setName('NewCat');

        $this->assertNull($cat->getId());
        $retour=$manager->save($cat);
        $this->assertTrue($retour);

        return $manager;
    }

    /**
     * @depends testCreateCategory
     */
    public function testLowerName(CategoryManager $manager)
    {
        $cat = new Category();
        $cat->setName('c');

        $this->assertNull($cat->getId());
        $retour = $manager->save($cat);
        $this->assertFalse($retour);

        $this->assertContains("doit avoir plus de 3 caractères",$manager->getErrors($cat));

        return $manager;
    }

    /**
     * @depends testLowerName
     */
    public function testLowerName1(CategoryManager $manager)
    {
        $cat = new Category();
        $cat->setName('c1');

        $this->assertNull($cat->getId());
        $retour = $manager->save($cat);
        $this->assertFalse($retour);

        $this->assertContains("doit avoir plus de 3 caractères", $manager->getErrors($cat));

        return $manager;
    }

    /**
     * @depends testLowerName1
     */
    public function testLowerName2(CategoryManager $manager)
    {
        $cat = new Category();
        $cat->setName('c2');

        $this->assertNull($cat->getId());
        $retour = $manager->save($cat);
        $this->assertFalse($retour);

        $this->assertContains("doit avoir plus de 3 caractères", $manager->getErrors($cat));


        return $manager;
    }


    /**
     * @depends testLowerName2
     */
    public function testLonogName(CategoryManager $manager)
    {
        $faker = Faker\Factory::create();
        
        $cat = new Category();
        $cat->setName($faker->realText(100));

        $this->assertNull($cat->getId());
        $retour = $manager->save($cat);
        $this->assertFalse($retour,$cat->getName());

        $this->assertContains("ne peut pas avoir plus de 50", $manager->getErrors($cat));
    }
}
