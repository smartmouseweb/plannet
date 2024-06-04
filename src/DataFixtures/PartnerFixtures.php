<?php

namespace App\DataFixtures;

use App\Entity\Partner;
use App\Entity\Translation;
use App\Entity\TranslationLocale;
use App\Entity\TranslationType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PartnerFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $translationTypes = $manager->getRepository(TranslationType::class)->findAll('name');
        $translationLocales = $manager->getRepository(TranslationLocale::class)->findAll('name');

        /* read and persist PARTNER EN csv */
        $rowNr = 1;

        if (($file = fopen("./public/res/partners_en.csv", "r")) !== false) 
        {
            while (($row = fgetcsv($file, null, ",")) !== false) 
            {
                if ($row[0] !== 'id')
                {
                    $partner = new Partner();
                    $partner->setUrl($row[2]);
                    $partner->setCode($row[3]);

                    $manager->persist($partner);
                    $manager->flush();
                    
                    $partnerId = $partner->getId();
                    
                    // add EN translation
                    $translation = new Translation();
                    $translation->setBindId($partnerId);
                    $translation->setType($translationTypes["Partner"]);
                    $translation->setLocale($translationLocales["en_us"]);
                    $translation->setField('name'); 
                    $translation->setValue($row[1]); 
                    $manager->persist($translation);
                    $manager->flush();
                }
            }
        }

        $partners = $manager->getRepository(Partner::class)->findAll('code');

        /* read and persist PARTNER DE csv */
        $rowNr = 1;

        if (($file = fopen("./public/res/partners_de.csv", "r")) !== false) 
        {
            while (($row = fgetcsv($file, null, ",")) !== false) 
            {
                if ($row[0] !== 'id' && isset($partners[$row[3]]))
                {                    
                    // add EN translation
                    $translation = new Translation();
                    $translation->setBindId($partners[$row[3]]->getId());
                    $translation->setType($translationTypes["Partner"]);
                    $translation->setLocale($translationLocales["de_de"]);
                    $translation->setField('name'); 
                    $translation->setValue($row[1]); 
                    $manager->persist($translation);
                    $manager->flush();
                }
            }
        }
    }

    public function getDependencies()
    {
        return [
            TranslationLocaleFixtures::class,
            TranslationTypeFixtures::class,
        ];
    }
}
