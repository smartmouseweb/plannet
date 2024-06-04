<?php

namespace App\DataFixtures;

use App\Entity\TranslationLocale;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TranslationLocaleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $rawTranslationLocales = ['en_us', 'de_de'];

        foreach ($rawTranslationLocales as $rawTranslationLocale)
        {
            $obj = new TranslationLocale();
            $obj->setName($rawTranslationLocale);
            $manager->persist($obj);
            $manager->flush();
        }

    }
}
