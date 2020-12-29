<?php

namespace App\DataFixtures;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Faker;

class UserFixtures extends Fixture
{
    /**
     * nb objects to create
     * @var int
     */
    private const NB_OBJECT = 50;

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker  =  Faker\Factory::create('fr_FR');
        for ($i = 1; $i <= self::NB_OBJECT; $i++) {
            $applicant = new User();
            $applicant->setEmail('appl' . $faker->email());
            $applicant->setRoles(['ROLE_APPLICANT']);
            $applicant->setPassword($this->passwordEncoder->encodePassword(
                $applicant,
                'applicantpassword'
            ));
            $this->addReference('appl_user_' . $i, $applicant);
            $manager->persist($applicant);

            // Création d’un utilisateur de type “company”
            $company = new User();
            $company->setEmail('comp' . $faker->email());
            $company->setRoles(['ROLE_COMPANY']);
            $company->setPassword($this->passwordEncoder->encodePassword(
                $company,
                'companypassword'
            ));
            $this->addReference('comp_user_' . $i, $company);
            $manager->persist($company);
        }

        // Création d’un utilisateur de type “administrateur”
        $admin = new User();
        $admin->setEmail('admin@monsite.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordEncoder->encodePassword(
            $admin,
            'adminpassword'
        ));
        $manager->persist($admin);

        // Sauvegarde des 3 nouveaux utilisateurs :
        $manager->flush();
    }
}
