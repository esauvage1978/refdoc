<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Backpack;
use App\Entity\Category;
use App\Manager\BackpackManager;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use App\Repository\ProcessRepository;
use App\Repository\MProcessRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{

    private $backpackManager;

    private $users;
    private $mprocesses;
    private $processes;
    private $categories;

    public function __construct(
        BackpackManager $backpackManager,
        UserRepository $userRepository,
        MProcessRepository $mProcessRepository,
        ProcessRepository $processRepository,
        CategoryRepository $categoryRepository
    ) {
        $this->backpackManager = $backpackManager;
        $this->users = $userRepository->findAll();
        $this->mprocesses = $mProcessRepository->findAll();
        $this->processes = $processRepository->findAll();
        $this->categories = $categoryRepository->findAll();
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 50; $i++) {

            $backpack = new Backpack();
            $backpack
                ->setOwner($this->users[$faker->numberBetween(0, 12)])
                ->setCategory($this->categories[$faker->numberBetween(0, 4)])
                ->setContent($faker->realText(500))
                ->setName($faker->realText(20));

            if ($faker->numberBetween(0, 1) == 1) {
                $backpack->setMProcess($this->mprocesses[$faker->numberBetween(0, 14)]);
            } else {
                $backpack->setProcess($this->processes[$faker->numberBetween(0, 3)]);
            }

            $this->backpackManager->save($backpack);
        }

        $manager->flush();
    }
}
