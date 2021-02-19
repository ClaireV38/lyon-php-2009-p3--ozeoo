<?php

namespace App\DataFixtures;

use App\Entity\Applicant;
use App\Entity\Company;
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

        $applicant1 = new User();
        $applicant1->setEmail('applicant1@monsite.com');
        $applicant1->setRoles(['ROLE_APPLICANT']);
        $applicant1->setPassword($this->passwordEncoder->encodePassword(
            $applicant1,
            'password'
        ));
        $applicant1->setIsVerified(true);
        $this->addReference('appl_user_' . 1, $applicant1);
        $manager->persist($applicant1);

        $applicant2 = new User();
        $applicant2->setEmail('applicant@monsite.com');
        $applicant2->setRoles(['ROLE_APPLICANT']);
        $applicant2->setPassword($this->passwordEncoder->encodePassword(
            $applicant2,
            'password'
        ));
        $applicantAccount = new Applicant();
        $applicant2->setApplicant($applicantAccount);
        $applicant2->setIsVerified(true);
        $manager->persist($applicant2);

        for ($i = 2; $i <= self::NB_OBJECT; $i++) {
            $applicant = new User();
            $applicant->setEmail('appl' . $faker->email());
            $applicant->setRoles(['ROLE_APPLICANT']);
            $applicant->setPassword($this->passwordEncoder->encodePassword(
                $applicant,
                'password'
            ));
            $applicant->setIsVerified(true);
            $this->addReference('appl_user_' . $i, $applicant);
            $manager->persist($applicant);
        }

        $company1 = new User();
        $company1->setEmail('company1@monsite.com');
        $company1->setRoles(['ROLE_COMPANY']);
        $company1->setPassword($this->passwordEncoder->encodePassword(
            $company1,
            'password'
        ));
        $this->addReference('comp_user_' . 1, $company1);
        $company1->setIsVerified(true);
        $manager->persist($company1);


        // Création d’un utilisateur de type “company”
        for ($j = 2; $j <= self::NB_OBJECT; $j++) {
            $company = new User();
            $company->setEmail('comp' . $faker->email());
            $company->setRoles(['ROLE_COMPANY']);
            $company->setPassword($this->passwordEncoder->encodePassword(
                $company,
                'password'
            ));
            $company->setIsVerified(true);
            $this->addReference('comp_user_' . $j, $company);
            $manager->persist($company);
        }

        $company = new User();
        $company->setEmail('company@monsite.com');
        $company->setRoles(['ROLE_COMPANY']);
        $company->setPassword($this->passwordEncoder->encodePassword(
            $company,
            'password'
        ));
        $companyAccount = new Company();
        $companyAccount->setName('entreprise.sas');
        $companyAccount->setApeNb('1234A');
        $companyAccount->setSiretNb('12345678912345');
        $company->setCompany($companyAccount);
        $company->setIsVerified(false);
        $manager->persist($company);

        // Création d’un utilisateur de type “administrateur”
        $admin = new User();
        $admin->setEmail('admin@monsite.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordEncoder->encodePassword(
            $admin,
            'password'
        ));
        $admin->setIsVerified(true);
        $manager->persist($admin);

        // Sauvegarde des 3 nouveaux utilisateurs :
        $manager->flush();
    }
}
