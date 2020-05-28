<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Firm;
use App\Entity\LegalForm;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class FirmFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        foreach ($this->getData() as $key => $item) {
            /** @var LegalForm $legalForm */
            $legalForm = $this->getReference(sprintf(LegalFormFixtures::LABEL, $key));

            $firm = new Firm();
            $firm
                ->setLegalForm($legalForm)
                ->setName($item['name'])
                ->setSiren($item['siren'])
                ->setRegisterCity($item['city'])
                ->setDateRegister(new \DateTime($item['dateRegister']))
                ->setCapital($item['capital'])
                ->setAddress($item['address'] ?? [])
            ;

            $manager->persist($firm);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            LegalFormFixtures::class,
        ];
    }

    private function getData(): array
    {
        return [
            [
                'name' => 'Benard',
                'siren' => '144 692 347',
                'city' => 'Pineau',
                'dateRegister' => '1991-03-12',
                'capital' => '44268.4',
                'address' => [
                    [
                        'number' => 489,
                        'type' => 'place',
                        'name' => 'Noël Gerard',
                        'city' => 'Dufour',
                        'zipCode' => '78 575',
                    ],
                    [
                        'number' => 8,
                        'type' => 'impasse',
                        'name' => 'Josette Blin',
                        'city' => 'Langlois',
                        'zipCode' => '92088',
                    ],
                ],
            ],
            [
                'name' => 'Lambert',
                'siren' => '984 774 464',
                'city' => 'Perrier-les-Bains',
                'dateRegister' => '2004-10-13',
                'capital' => '353646924.29',
                'address' => [
                    [
                        'number' => 55,
                        'type' => 'avenue',
                        'name' => 'Texier',
                        'city' => 'Lambert',
                        'zipCode' => '47 671',
                    ],
                    [
                        'number' => 6,
                        'type' => 'impasse',
                        'name' => 'Denis Bernard',
                        'city' => 'Caron-sur-Mer',
                        'zipCode' => '42747',
                    ],
                ],
            ],
            [
                'name' => 'Tessier et Fils',
                'siren' => '572 772 912',
                'city' => 'Paul-la-Forêt',
                'dateRegister' => '1987-11-12',
                'capital' => '66048080.53',
                'address' => [
                    [
                        'number' => 35,
                        'type' => 'boulevard',
                        'name' => 'de Laurent',
                        'city' => 'Faure-sur-Gauthier',
                        'zipCode' => '26524',
                    ],
                    [
                        'number' => 130,
                        'type' => 'chemin',
                        'name' => 'de Ribeiro',
                        'city' => 'Barbier',
                        'zipCode' => '61209',
                    ],
                ],
            ],
            [
                'name' => 'Letellier Leleu et Fils',
                'siren' => '697 643 940',
                'city' => 'Guillou-les-Bains',
                'dateRegister' => '2009-06-04',
                'capital' => '6207730.47',
                'address' => [
                    [
                        'number' => 909,
                        'type' => 'avenue',
                        'name' => 'de Martel',
                        'city' => 'Bouchet',
                        'zipCode' => '23 962',
                    ],
                    [
                        'number' => 17,
                        'type' => 'avenue',
                        'name' => 'Godard',
                        'city' => 'Grenier',
                        'zipCode' => '36 171',
                    ],
                ],
            ],
            [
                'name' => 'Hoareau et Fils',
                'siren' => '448 117 84',
                'city' => 'Grenier-les-Bains',
                'dateRegister' => '1973-05-05',
                'capital' => '3678.5',
                'address' => [
                    [
                        'number' => 40,
                        'type' => 'impasse',
                        'name' => 'de Lefevre',
                        'city' => 'Philippe-sur-Poulain',
                        'zipCode' => '95 140',
                    ],
                    [
                        'number' => 113,
                        'type' => 'chemin',
                        'name' => 'Dufour',
                        'city' => 'Weber-les-Bains',
                        'zipCode' => '23899',
                    ],
                ],
            ],
            [
                'name' => 'Voisin Gosselin SAS',
                'siren' => '63 815 577',
                'city' => 'Richard',
                'dateRegister' => '1982-06-25',
                'capital' => '6173.62',
                'address' => [
                    [
                        'number' => 187,
                        'type' => 'chemin',
                        'name' => 'de Rodrigues',
                        'city' => 'Fernandez-sur-Lacroix',
                        'zipCode' => '85 307',
                    ],
                    [
                        'number' => 88,
                        'type' => 'boulevard',
                        'name' => 'Jacqueline Mendes',
                        'city' => 'Descamps',
                        'zipCode' => '49196',
                    ],
                ],
            ],
            [
                'name' => 'Wagner et Fils',
                'siren' => '971 885 82',
                'city' => 'Chauvin-sur-Mer',
                'dateRegister' => '1981-03-10',
                'capital' => '244956.53',
                'address' => [
                    [
                        'number' => 18,
                        'type' => 'impasse',
                        'name' => 'Girard',
                        'city' => 'Bouchet-sur-Charrier',
                        'zipCode' => '39 750',
                    ],
                    [
                        'number' => 90,
                        'type' => 'rue',
                        'name' => 'Godard',
                        'city' => 'Baudry-sur-Mer',
                        'zipCode' => '32017',
                    ],
                ],
            ],
            [
                'name' => 'Bailly',
                'siren' => '172 698 810',
                'city' => 'Guillot',
                'dateRegister' => '2012-10-01',
                'capital' => '7845147.61',
                'address' => [
                    [
                        'number' => 8,
                        'type' => 'rue',
                        'name' => 'Marianne Guillet',
                        'city' => 'Marie',
                        'zipCode' => '23298',
                    ],
                    [
                        'number' => 34,
                        'type' => 'avenue',
                        'name' => 'Hugues Carpentier',
                        'city' => 'Remy',
                        'zipCode' => '30 677',
                    ],
                ],
            ],
            [
                'name' => 'Becker S.A.R.L.',
                'siren' => '800 97 308',
                'city' => 'Etienne-la-Forêt',
                'dateRegister' => '1971-02-25',
                'capital' => '30.36',
                'address' => [
                    [
                        'number' => 38,
                        'type' => 'boulevard',
                        'name' => 'de Pires',
                        'city' => 'Dias-sur-Mer',
                        'zipCode' => '25889',
                    ],
                    [
                        'number' => 21,
                        'type' => 'avenue',
                        'name' => 'de Levy',
                        'city' => 'Rocher',
                        'zipCode' => '52547',
                    ],
                ],
            ],
            [
                'name' => 'Masse',
                'siren' => '720 898 200',
                'city' => 'Ferrand',
                'dateRegister' => '1976-12-27',
                'capital' => '4.05',
                'address' => [
                    [
                        'number' => 103,
                        'type' => 'boulevard',
                        'name' => 'de Leroy',
                        'city' => 'Vidal',
                        'zipCode' => '24272',
                    ],
                    [
                        'number' => 5,
                        'type' => 'place',
                        'name' => 'Stéphane Brunet',
                        'city' => 'Martins-sur-Legendre',
                        'zipCode' => '85944',
                    ],
                ],
            ],
        ];
    }
}
