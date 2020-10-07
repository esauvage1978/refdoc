<?php

declare(strict_types=1);

namespace App\Tests\Unitaire\Helper;

use App\Helper\SplitNameOfFile;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SplitNameOfFileTest extends WebTestCase
{
    /**
     * @dataProvider datas
     */
    public function testSplitNameOfFile($fileName, $name, $extension, $message = ''): void
    {
        $sp=new  SplitNameOfFile($fileName);

        $this->assertSame($sp->getName(), $name, $message);
        $this->assertSame($sp->getExtension(), $extension, $message);
    }

    public function datas()
    {
        yield ['test.txt', 'test','txt', 'simple file'];
        yield ['test.jpg.txt', 'test.jpg', 'txt', 'file with 2 extensions'];
        yield ['.txt', '', 'txt', 'file without name'];
        yield ['test', 'test', '', 'file without extension'];
    }
}
