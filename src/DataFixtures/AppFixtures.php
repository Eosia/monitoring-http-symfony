<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\Website;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    public function __construct(UserPasswordEncoderInterface $encoder) {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {

        $admin = new Admin();
        $admin->setEmail('kevin.eosiaweb@gmail.com')
                ->setPassword('###TangoDown!!!');
        $encoded = $this->encoder->encodePassword($admin, $admin->getPassword());
        $admin->setPassword($encoded);
        $manager->persist($admin);

        $website = new Website();
        $website->setName('beswebdev.xyz')
            ->setUrl('https://beswebdev.xyz');
        $manager->persist($website);

        $website = new Website();
        $website->setName('googleBe')
            ->setUrl('https://www.google.be');
        $manager->persist($website);

        $website = new Website();
        $website->setName('facebook')
            ->setUrl('https://www.facebook.com');
        $manager->persist($website);

        $website = new Website();
        $website->setName('youtube')
            ->setUrl('https://www.youtube.com');
        $manager->persist($website);

        $manager->flush();
    }
}
