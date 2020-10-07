<?php

namespace App\DataFixtures\ORM;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraints\Length;

class CategoryFixtures extends Fixture
{
    private $data = [
        [
            'name' => 'Consigne',
            'content' => 'description de consigne'
        ],
        [
            'name' => 'Procédure',
            'content' => 'description de procédure'
        ]
    ];

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < count( $this->data); $i++) {
            $cat = new Category();
            $cat
                ->setName($this->data[$i]['name'])
                ->setContent($this->data[$i]['content']);

            $manager->persist($cat);
        }
        $manager->flush();
    }
}
