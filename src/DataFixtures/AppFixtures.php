<?php

namespace App\DataFixtures;

use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {

        $faker = \Faker\Factory::create('pl_PL');

        // tworzenie admina 
        $user = new User();
        $user
            ->setEmail("admin@test.pl")
            ->setRoles(["ROLE_USER","ROLE_ADMIN"])
            ->setPassword(
                $this->encoder->encodePassword($user, '000000')
            )
            ->setIsVerified(true)
            ->setDob(new \DateTime())
            ->setCreatedAt(new \DateTime())
        ;
        $manager->persist($user);
    
        // tworzymy userów 5 +18
        for ($i = 0; $i < 5; $i++){
            $user = new User();

            $user
                ->setEmail("test" . $i. "@test.pl")
                ->setPassword(
                    $this->encoder->encodePassword($user, '000000')
                )
                ->setIsVerified(true)
                ->setDob($faker->dateTimeBetween('-30 years', '-25 years'))
                ->setCreatedAt($faker->dateTimeBetween('-29 days', '-1 days'))
                ->setProgramowanie(['Uzupełnij profil'])
                ->setSystemAd("GUI")
            ;
            $manager->persist($user);
        }

        // tworzymy -18 w dniu utworzenia
        for ($i = 6; $i < 11; $i++){
            $user = new User();

            $urodziny = new \DateTime(date("Y-m-d"));
            $urodziny->modify('-18 years');
            $urodziny->format("Y-m-d");

            $user
                ->setEmail("test" . $i. "@test.pl")
                ->setPassword(
                    $this->encoder->encodePassword($user, '000000')
                )
                ->setIsVerified(false)
                ->setDob($urodziny)
                ->setCreatedAt($faker->dateTimeBetween('-29 days', '-1 days'))
                ->setProgramowanie(['Uzupełnij profil'])
                ->setSystemAd("GUI")
            ;
            $manager->persist($user);
        }

        // tworzymy -18 w przedziale -29 -1 dni
        for ($i = 11; $i < 20; $i++) {
            $user = new User();

            $urodziny = new \DateTime(date("Y-m-d"));
            $urodziny->modify('-18 years');
            $urodziny->format("Y-m-d");

            $user
                ->setEmail("test" . $i . "@test.pl")
                ->setPassword(
                    $this->encoder->encodePassword($user, '000000')
                )
                ->setIsVerified(false)
                ->setDob($faker->dateTimeBetween('-17 years', '-2 years'))
                ->setCreatedAt($faker->dateTimeBetween('-29 days', '-1 days'))
                ->setProgramowanie(['Uzupełnij profil'])
                ->setSystemAd("GUI")
            ;
            $manager->persist($user);
        }

        $manager->flush();
    }
}
