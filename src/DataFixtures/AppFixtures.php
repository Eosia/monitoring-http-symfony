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
                ->setPassword('cL5J2E66YhTxHVy6YJa77AX679VM6LBnxF2y5xhSm65EA4f7GiXHd9r');
        $encoded = $this->encoder->encodePassword($admin, $admin->getPassword());
        $admin->setPassword($encoded);
        $manager->persist($admin);



        $manager->flush();
    }
}
