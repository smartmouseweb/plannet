<?php

namespace App\DataFixtures;

use App\Entity\Partner;
use App\Entity\Prize;
use App\Entity\Translation;
use App\Entity\TranslationLocale;
use App\Entity\TranslationType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PrizeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $translationTypes = $manager->getRepository(TranslationType::class)->findAll('name');
        $translationLocales = $manager->getRepository(TranslationLocale::class)->findAll('name');
        $partners = $manager->getRepository(Partner::class)->findAll('code');
        $translationFields = [2 => 'name', 3 => 'description'];

        /* read and persist PRIZE EN csv */
        if (($file = fopen("./public/res/prizes_en.csv", "r")) !== false) 
        {
            while (($row = fgetcsv($file, null, ",")) !== false) 
            {
                if ($row[0] !== 'id' && isset($partners[$row[1]]))
                {
                    $prize = new Prize();
                    $prize->setPartner($partners[$row[1]]);
                    $prize->setCode($row[4]);

                    $manager->persist($prize);
                    $manager->flush();
                    
                    $prizeId = $prize->getId();
                    
                    // add EN translation
                    foreach ($translationFields as $csvField => $translationField)
                    {
                        $translation = new Translation();
                        $translation->setBindId($prizeId);
                        $translation->setType($translationTypes["Prize"]);
                        $translation->setLocale($translationLocales["en_us"]);
                        $translation->setField($translationField); 
                        $translation->setValue($row[$csvField]); 
                        $manager->persist($translation);
                        $manager->flush();
                    }
                }
            }
        }

        $prizes = $manager->getRepository(Prize::class)->findAll('code');

        /* read and persist PRIZE DE csv */
        if (($file = fopen("./public/res/prizes_de.csv", "r")) !== false) 
        {
            while (($row = fgetcsv($file, null, ",")) !== false) 
            {
                if ($row[0] !== 'id' && isset($prizes[$row[4]]))
                {                    
                    // add EN translation
                    foreach ($translationFields as $csvField => $translationField)
                    {
                        $translation = new Translation();
                        $translation->setBindId($prizes[$row[4]]->getId());
                        $translation->setType($translationTypes["Prize"]);
                        $translation->setLocale($translationLocales["de_de"]);
                        $translation->setField($translationField); 
                        $translation->setValue($row[$csvField]); 
                        $manager->persist($translation);
                        $manager->flush();
                    }
                }
            }
        }
    }

    public function getDependencies()
    {
        return [
            TranslationLocaleFixtures::class,
            TranslationTypeFixtures::class,
            PartnerFixtures::class,
        ];
    }
}
