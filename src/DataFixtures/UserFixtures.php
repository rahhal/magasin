<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('admin@example.com');
        $user->setRoles(['ROLE_SUPER_ADMIN']);
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'admin'));

        $user_1 = new User();
        $user_1->setEmail('user@example.com');
        $user_1->setRoles(['ROLE_ENTREPRISE']);
        $user_1->setPassword($this->passwordEncoder->encodePassword($user_1, 'user'));

       

        $manager->persist($user);
        $manager->persist($user_1);
        $manager->flush();
    }
}