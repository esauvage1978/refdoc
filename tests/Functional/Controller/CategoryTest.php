<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller;

use App\Repository\CategoryRepository;
use App\DataFixtures\ORM\CategoryFixtures;
use Symfony\Component\HttpFoundation\Response;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CategoryTest extends WebTestCase
{

    use FixturesTrait;


    public function testGetCategoryWithParamNoAjax()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/ajax/getcontentofcategory/100', [], [], []);
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }


    public function testGetCategoryWithParam()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/ajax/getcontentofcategory/1', [], [], []);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $this->assertContains("description de consigne", $client->getResponse()->getContent());
    }

}
