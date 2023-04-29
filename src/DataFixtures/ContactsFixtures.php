<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Contacts;
use App\Repository\CiviliteRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ContactsFixtures extends Fixture
{
    private CiviliteRepository $civiliteRepository;

    public function __construct(
        CiviliteRepository $civiliteRepository,
    ) {
        $this->civiliteRepository = $civiliteRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i=0; $i < 40; $i++) {
            $mail = $faker->email();

            $contact = new Contacts();
            $contact->setCivilite($this->civiliteRepository->find(random_int(1, 2)));
            $contact->setNom($faker->lastName());
            $contact->setPrenom($faker->firstName());
            $contact->setMail($mail);
            $contact->setRgpdValidation('1');
            $contact->setCreeLe(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-30 days')));

            $manager->persist($contact);
        }

        $manager->flush();
    }
}
