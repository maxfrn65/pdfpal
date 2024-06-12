<?php

namespace App\Fixtures;

use App\Entity\Subscription;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SubscriptionFixtures extends Fixture
{

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager): void
    {
        $free = new Subscription();
        $free->setTitle('Free plan');
        $free->setPrice(0.00);
        $free->setDescription('A free plan for everyone');
        $free->setPdfLimit(5);
        $free->setMedia('some media');
        $manager->persist($free);

        $premium = new Subscription();
        $premium->setTitle('Premium plan');
        $premium->setPrice(7.00);
        $premium->setDescription('For power users');
        $premium->setPdfLimit(0);
        $premium->setMedia('some media');
        $manager->persist($premium);

        $manager->flush();
    }
}