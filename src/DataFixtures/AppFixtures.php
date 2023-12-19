<?php

namespace App\DataFixtures;

use App\Entity\Person;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $hasher;
    public function __construct(UserPasswordHasherInterface $userPasswordHasherInterface)
    {
        $this->hasher = $userPasswordHasherInterface;
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $user = new User();
        $user->setUsername("admin");
        $user->setRoles(["ROLE_ADMIN"]);
        $user->setCreatedAt(new \DateTimeImmutable());
        $password = $this->hasher->hashPassword($user, "admin");
        $user->setPassword($password);

        $person = new Person();
        $person->setFirstname("Administrateur");
        $person->setLastname("Admin");
        $person->setAddress("None");
        $person->setPhone("+243810120658");
        $person->setBarrau("-");
        
        $user->setPerson($person);
        $manager->persist($person);
        $manager->persist($user);
        $manager->flush();
    }
}
