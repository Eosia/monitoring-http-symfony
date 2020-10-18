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
                ->setPassword('toor');
        $encoded = $this->encoder->encodePassword($admin, $admin->getPassword());
        $admin->setPassword($encoded);
        $manager->persist($admin);

        $website = new Website();
        $website->setName('bes-webdev.xyz')
            ->setUrl('https://www.bes-webdev.xyz');
        $manager->persist($website);

        $website = new Website();
        $website->setName('ww1.FreedomLeaks')
            ->setUrl('http://139.99.24.70');
        $manager->persist($website);

        $website = new Website();
        $website->setName('ww3.FreedomLeaks')
            ->setUrl('http://93.95.228.180');
        $manager->persist($website);

        $website = new Website();
        $website->setName('ww4.FreedomLeaks')
            ->setUrl('http://95.111.236.51');
        $manager->persist($website);

        $website = new Website();
        $website->setName('ww5.FreedomLeaks')
            ->setUrl('http://199.16.128.41');
        $manager->persist($website);
        
        $website = new Website();
        $website->setName('cloud.FreedomLeaks')
            ->setUrl('https://cloud.freedomleaks.com');
        $manager->persist($website);

        $website = new Website();
        $website->setName('share.FreedomLeaks')
            ->setUrl('https://share.freedomleaks.com');
        $manager->persist($website);

        $website = new Website();
        $website->setName('mail.FreedomLeaks')
            ->setUrl('https://mail.freedomleaks.com');
        $manager->persist($website);

        $website = new Website();
        $website->setName('downsec.be')
            ->setUrl('https://www.downsec.be');
        $manager->persist($website);

        $manager->flush();
    }
}
