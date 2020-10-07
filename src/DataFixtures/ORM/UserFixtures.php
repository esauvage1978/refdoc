<?php

namespace App\DataFixtures\ORM;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends Fixture
{

    private $data =
    [
        [
            'name' => 'manu',
            'email' => 'manu@live.fr',
            'password' => 'A123456789',
            'emailValidated' => true,
            'isEnamble' => true,
            'subrscription' => true
        ],
        [
            'name' => 'margot',
            'email' => 'margot@live.fr',
            'password' => 'A123456789',
            'emailValidated' => true,
            'isEnamble' => true,
            'subrscription' => true
        ],
        [
            'name' => 'contrib_mp',
            'email' => 'contrib_mp@live.fr',
            'password' => 'A123456789',
            'emailValidated' => true,
            'isEnamble' => true,
            'subrscription' => true
        ],
        [
            'name' => 'dir_validator_mp',
            'email' => 'dir_validator_mp@live.fr',
            'password' => 'A123456789',
            'emailValidated' => true,
            'isEnamble' => true,
            'subrscription' => true
        ],
        [
            'name' => 'pole_validator_mp',
            'email' => 'pole_validator_mp@live.fr',
            'password' => 'A123456789',
            'emailValidated' => true,
            'isEnamble' => true,
            'subrscription' => true
        ],
        [
            'name' => 'contrib_p',
            'email' => 'contrib_p@live.fr',
            'password' => 'A123456789',
            'emailValidated' => true,
            'isEnamble' => true,
            'subrscription' => true
        ],
        [
            'name' => 'validator_p',
            'email' => 'validator_p@live.fr',
            'password' => 'A123456789',
            'emailValidated' => true,
            'isEnamble' => true,
            'subrscription' => true
        ],


    ];

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user
                ->setName('user' . $i)
                ->setEmail('user' . $i . '@live.fr')
                ->setPassword('123456A')
                ->setEmailValidated(false)
                ->setIsEnable(true)
                ->setSubscription(false);

            $manager->persist($user);
        }
        for ($i = 0; $i < count($this->data); $i++) {
            $user = new User();
            $user
                ->setName($this->data[$i]['name'])
                ->setEmail($this->data[$i]['email'])
                ->setPassword($this->data[$i]['password'])
                ->setEmailValidated($this->data[$i]['emailValidated'])
                ->setIsEnable($this->data[$i]['isEnamble'])
                ->setSubscription($this->data[$i]['subrscription']);

            $manager->persist($user);
        }
        $manager->flush();
    }
}
