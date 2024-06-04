<?php

namespace App\DataFixtures;

use App\Entity\TranslationType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TranslationTypeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        /* Populate Translation Types */
        $rawTranslationTypes = ['Partner', 'Prize'];

        foreach ($rawTranslationTypes as $rawTranslationType)
        {
            $obj = new TranslationType();
            $obj->setName($rawTranslationType);
            $manager->persist($obj);
            $manager->flush();
        }

    }
}
