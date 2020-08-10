<?php

declare(strict_types=1);

namespace App\Tests\Unitaire\Helper;

use App\Helper\FileTools;
use App\Helper\DirectoryTools;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FileToolsTest extends WebTestCase
{
    public function testDirectoryTool(): void
    {
        $dir= New DirectoryTools();
        $file = new FileTools();

        $path= 'c:/wamp64/www/refdoc/public';
        $path1 = 'c:/wamp64/www/refdoc/public/phpunit1';
        $path2 = 'c:/wamp64/www/refdoc/public/phpunit2';

        $dir->create($path, 'phpunit1');
        $dir->create($path, 'phpunit2');

        $this->assertSame($file->exist($path1,'file1.txt'),false);

        $file->copy($path.'/img','closed.png',$path1, 'closed.png');
        $file->copy($path1 , 'closed.png', $path2, 'closed.png');

        $this->assertSame($file->exist($path1, 'closed.png'), true);
        $this->assertSame($file->exist($path2, 'closed.png'), true);

        $file->remove( $path2, 'closed.png');

        $this->assertSame($file->exist($path1, 'closed.png'), true);
        $this->assertSame($file->exist($path2, 'closed.png'), false);

        $file->move($path1, 'closed.png', $path2, 'closed.png');

        $this->assertSame($file->exist($path1, 'closed.png'), false);
        $this->assertSame($file->exist($path2, 'closed.png'), true);

        $file->remove($path2, 'closed.png');

        $this->assertSame($file->exist($path1, 'closed.png'), false);
        $this->assertSame($file->exist($path2, 'closed.png'), false);

        $dir->remove($path, 'phpunit1');
        $dir->remove($path, 'phpunit2');

    }

}
