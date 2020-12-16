<?php

namespace App\DataFixtures;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        // Création d’un utilisateur de type “applicant”
        $applicant = new User();
        $applicant->setEmail('applicant@monsite.com');
        $applicant->setRoles(['ROLE_APPLICANT']);
        $applicant->setPassword($this->passwordEncoder->encodePassword(
            $applicant,
            'applicantpassword'
        ));
        $manager->persist($applicant);

        // Création d’un utilisateur de type “company”
        $company = new User();
        $company->setEmail('company@monsite.com');
        $company->setRoles(['ROLE_COMPANY']);
        $company->setPassword($this->passwordEncoder->encodePassword(
            $company,
            'companypassword'
        ));
        $manager->persist($company);

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
