<?php

declare(strict_types=1);

namespace App\Tests\Unitaire\Entity;

use Faker;
use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CategoryTest extends KernelTestCase
{
    /**
     * @var Category
     */
    private $cat;

    public function createEntity(): Category
    {
        return (new Category());
    }

    public function assertHasErros(Category $cat, $number=0) 
    {
        self::bootKernel();
        $error=self::$container->get('validator')->validate($cat);
        $this->assertCount($number, $error);
    }

    public function testCreate()
    {
        $cat =$this->createEntity();
        $this->assertHasErros($cat,1);
        $this->assertInstanceOf( Category::class, $cat);
    }

    public function testNoError()
    {
        $this->assertHasErros($this->createEntity()->setName('abcde'), 0);
    }

    public function testNameToShort()
    {
        $this->assertHasErros( $this->createEntity()->setName('a'), 1);
    }

    public function testNameToLong()
    {
        $faker = Faker\Factory::create();
        $this->assertHasErros($this->createEntity()->setName($faker->realText(100)), 1);
    }


    public function testInitialisation()
    {
        $cat = $this->createEntity();

        $this->assertNull( $cat->getName());
        $this->assertNull( $cat->getContent());
        $this->assertSame(true, $cat->getIsEnable());
        $this->assertSame(false,$cat->getIsValidateByControl());
        $this->assertSame(true, $cat->getIsValidateByDoc());
        $this->assertSame(12, $cat->getTimeBeforeRevision());
        $this->assertSame(0,count($cat->getBackpacks()));

    }
}
