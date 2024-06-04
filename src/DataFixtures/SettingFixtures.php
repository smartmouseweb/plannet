<?php

namespace App\DataFixtures;

use App\Entity\Setting;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SettingFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $obj = new Setting();
        $obj->setName('promotion_start_date');
        $obj->setValue(date('Y-m-d'));
        $manager->persist($obj);
        $manager->flush();

        $obj = new Setting();
        $obj->setName('promotion_from_hour');
        $obj->setValue(9);
        $manager->persist($obj);
        $manager->flush();

        $obj = new Setting();
        $obj->setName('promotion_to_hour');
        $obj->setValue(20);
        $manager->persist($obj);
        $manager->flush();

        $obj = new Setting();
        $obj->setName('promotion_days');
        $obj->setValue(2);
        $manager->persist($obj);
        $manager->flush();
    }
}
