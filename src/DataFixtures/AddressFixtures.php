<?php

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\Firm;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class AddressFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        foreach ($this->getData() as $item) {
            /** @var Firm $firm */
            $firm = $this->getReference(sprintf(FirmFixtures::LABEL, $item['firm']));

            $address = new Address();
            $address
                ->setFirm($firm)
                ->setNumber($item['number'])
                ->setType($item['type'])
                ->setName($item['name'])
                ->setCity($item['city'])
                ->setZipCode($item['zipCode'])
            ;

            $manager->persist($address);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            FirmFixtures::class,
        ];
    }

    private function getData(): array
    {
        return [
            [
                'number' => 489,
                'type' => 'place',
                'name' => 'Noël Gerard',
                'city' => 'Dufour',
                'zipCode' => '78 575',
                'firm' => 13,
            ],
            [
                'number' => 55,
                'type' => 'avenue',
                'name' => 'Texier',
                'city' => 'Lambert',
                'zipCode' => '47 671',
                'firm' => 5,
            ],
            [
                'number' => 35,
                'type' => 'boulevard',
                'name' => 'de Laurent',
                'city' => 'Faure-sur-Gauthier',
                'zipCode' => '26524',
                'firm' => 10,
            ],
            [
                'number' => 909,
                'type' => 'avenue',
                'name' => 'de Martel',
                'city' => 'Bouchet',
                'zipCode' => '23 962',
                'firm' => 16,
            ],
            [
                'number' => 40,
                'type' => 'impasse',
                'name' => 'de Lefevre',
                'city' => 'Philippe-sur-Poulain',
                'zipCode' => '95 140',
                'firm' => 6,
            ],
            [
                'number' => 187,
                'type' => 'chemin',
                'name' => 'de Rodrigues',
                'city' => 'Fernandez-sur-Lacroix',
                'zipCode' => '85 307',
                'firm' => 17,
            ],
            [
                'number' => 18,
                'type' => 'impasse',
                'name' => 'Girard',
                'city' => 'Bouchet-sur-Charrier',
                'zipCode' => '39 750',
                'firm' => 6,
            ],
            [
                'number' => 8,
                'type' => 'rue',
                'name' => 'Marianne Guillet',
                'city' => 'Marie',
                'zipCode' => '23298',
                'firm' => 12,
            ],
            [
                'number' => 38,
                'type' => 'boulevard',
                'name' => 'de Pires',
                'city' => 'Dias-sur-Mer',
                'zipCode' => '25889',
                'firm' => 12,
            ],
            [
                'number' => 103,
                'type' => 'boulevard',
                'name' => 'de Leroy',
                'city' => 'Vidal',
                'zipCode' => '24272',
                'firm' => 6,
            ],
            [
                'number' => 8,
                'type' => 'impasse',
                'name' => 'Josette Blin',
                'city' => 'Langlois',
                'zipCode' => '92088',
                'firm' => 3,
            ],
            [
                'number' => 6,
                'type' => 'impasse',
                'name' => 'Denis Bernard',
                'city' => 'Caron-sur-Mer',
                'zipCode' => '42747',
                'firm' => 3,
            ],
            [
                'number' => 130,
                'type' => 'chemin',
                'name' => 'de Ribeiro',
                'city' => 'Barbier',
                'zipCode' => '61209',
                'firm' => 7,
            ],
            [
                'number' => 17,
                'type' => 'avenue',
                'name' => 'Godard',
                'city' => 'Grenier',
                'zipCode' => '36 171',
                'firm' => 10,
            ],
            [
                'number' => 113,
                'type' => 'chemin',
                'name' => 'Dufour',
                'city' => 'Weber-les-Bains',
                'zipCode' => '23899',
                'firm' => 9,
            ],
            [
                'number' => 88,
                'type' => 'boulevard',
                'name' => 'Jacqueline Mendes',
                'city' => 'Descamps',
                'zipCode' => '49196',
                'firm' => 9,
            ],
            [
                'number' => 90,
                'type' => 'rue',
                'name' => 'Godard',
                'city' => 'Baudry-sur-Mer',
                'zipCode' => '32017',
                'firm' => 17,
            ],
            [
                'number' => 34,
                'type' => 'avenue',
                'name' => 'Hugues Carpentier',
                'city' => 'Remy',
                'zipCode' => '30 677',
                'firm' => 14,
            ],
            [
                'number' => 21,
                'type' => 'avenue',
                'name' => 'de Levy',
                'city' => 'Rocher',
                'zipCode' => '52547',
                'firm' => 15,
            ],
            [
                'number' => 5,
                'type' => 'place',
                'name' => 'Stéphane Brunet',
                'city' => 'Martins-sur-Legendre',
                'zipCode' => '85944',
                'firm' => 17,
            ],
        ];
    }
}
