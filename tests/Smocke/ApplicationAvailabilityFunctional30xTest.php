<?php

declare(strict_types=1);

namespace App\Tests\Smockz;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApplicationAvailabilityFunctional30xTest extends WebTestCase
{


    /**
     * @dataProvider urlProvider302
     */
    public function testPageIs302($url): void
    {
        $client = self::createClient();
        $client->request('GET', $url);

        $this->assertResponseStatusCodeSame(302);
    }

    public function urlProvider302()
    {
        yield ['/'];
        yield ['/dashboard'];

        yield ['/admin'];
        yield ['/admin/mprocess'];

        yield ['/profil'];
        yield ['/profil/avatar'];
    }
}
