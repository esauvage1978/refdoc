<?php

declare(strict_types=1);

namespace App\Tests\Unitaire\Helper;

use App\Helper\DirectoryTools;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DirectoryToolsTest extends WebTestCase
{
    public function testDirectoryTool(): void
    {
        $dir= New DirectoryTools();

        //test de vérification d'un répertoire inconnu
        $this->assertSame($dir->exist('bla','bla'),false);

        //test de vérification d'un répertoire présent sans sous rép
        $this->assertSame($dir->exist('c:/wamp64/www/refdoc/public', ''), true);

        $this->assertSame($dir->exist('c:/wamp64/www/refdoc/public', 'phpunit'), false);

        $dir->create('c:/wamp64/www/refdoc/public', 'phpunit');
        $this->assertSame($dir->exist('c:/wamp64/www/refdoc/public', 'phpunit'), true);

        $dir->remove('c:/wamp64/www/refdoc/public', 'phpunit');
        $this->assertSame($dir->exist('c:/wamp64/www/refdoc/public', 'phpunit'), false);

    }

}
