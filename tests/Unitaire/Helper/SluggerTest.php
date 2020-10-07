<?php

declare(strict_types=1);

namespace App\Tests\Unitaire\Helper;

use App\Helper\Slugger;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SluggerTest extends WebTestCase
{
    /**
     * @dataProvider datas
     */
    public function testSlugify($original, $slug, $message=''): void
    {
        $this->assertSame(Slugger::slugify($original),$slug,$message);
    }

    public function datas()
    {
        yield ['', '','empty'];
        yield [' ', '','space'];
        yield ['abcdefghijklmnopqrstuvwxyz', 'abcdefghijklmnopqrstuvwxyz','alpha'];
        yield ['Abcdefghijklmnopqrstuvwxyz', 'abcdefghijklmnopqrstuvwxyz','majuscule'];
        yield ['1234567890', '1234567890','numeric'];
        yield [' aa ', 'aa','trim'];
        yield ['a a', 'a-a','space inside'];
        yield ['éè', 'ee','accent e'];
        yield ['à', 'a','accent a'];
        yield ['ç', 'c','ç'];
        yield ['a€$a', 'a-a','monétaire inside'];
        yield ['€$', '','monétaire alone'];
        yield ['a&a', 'a-a','& inside'];
        yield ['&', '', '& alone'];
        yield ['{}()[]', '', 'brack'];
        yield ['_', '', 'underscore alone'];
        yield ['a_a', 'a-a', 'underscore inside'];
        yield ['_a_', 'a', 'underscore surround'];
        yield ['-', '', '- alone'];
        yield ['a-a', 'a-a', '- inside'];
        yield ['-a-', 'a', '- surround'];
        yield ['@', '', '@ alone'];
        yield ['a@a', 'a-a', '@ inside'];
        yield ['@a@', 'a', '@ surround'];
        yield ['%', '', '% alone'];
        yield ['a%a', 'a-a', '% inside'];
        yield ['%a%', 'a', '% surround'];
    }



}
