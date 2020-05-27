<?php

namespace App\DataFixtures;

use App\Entity\Firm;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class FirmFixtures extends Fixture
{
    const LABEL = 'firm-%d';

    public function load(ObjectManager $manager)
    {
        foreach ($this->getData() as $key => $item) {
            $firm = new Firm();
            $firm
                ->setName($item['name'])
                ->setSiren($item['siren'])
                ->setRegisterCity($item['city'])
                ->setDateRegister(new \DateTime($item['dateRegister']))
                ->setCapital($item['capital'])
            ;

            $this->addReference(sprintf(self::LABEL, $key), $firm);

            $manager->persist($firm);
        }

        $manager->flush();
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
            ],
            [
                'name' => 'Lambert',
                'siren' => '984 774 464',
                'city' => 'Perrier-les-Bains',
                'dateRegister' => '2004-10-13',
                'capital' => '353646924.29',
            ],
            [
                'name' => 'Tessier et Fils',
                'siren' => '572 772 912',
                'city' => 'Paul-la-Forêt',
                'dateRegister' => '1987-11-12',
                'capital' => '66048080.53',
            ],
            [
                'name' => 'Letellier Leleu et Fils',
                'siren' => '697 643 940',
                'city' => 'Guillou-les-Bains',
                'dateRegister' => '2009-06-04',
                'capital' => '6207730.47',
            ],
            [
                'name' => 'Hoareau et Fils',
                'siren' => '448 117 84',
                'city' => 'Grenier-les-Bains',
                'dateRegister' => '1973-05-05',
                'capital' => '3678.5',
            ],
            [
                'name' => 'Voisin Gosselin SAS',
                'siren' => '63 815 577',
                'city' => 'Richard',
                'dateRegister' => '1982-06-25',
                'capital' => '6173.62',
            ],
            [
                'name' => 'Wagner et Fils',
                'siren' => '971 885 82',
                'city' => 'Chauvin-sur-Mer',
                'dateRegister' => '1981-03-10',
                'capital' => '244956.53',
            ],
            [
                'name' => 'Bailly',
                'siren' => '172 698 810',
                'city' => 'Guillot',
                'dateRegister' => '2012-10-01',
                'capital' => '7845147.61',
            ],
            [
                'name' => 'Becker S.A.R.L.',
                'siren' => '800 97 308',
                'city' => 'Etienne-la-Forêt',
                'dateRegister' => '1971-02-25',
                'capital' => '30.36',
            ],
            [
                'name' => 'Masse',
                'siren' => '720 898 200',
                'city' => 'Ferrand',
                'dateRegister' => '1976-12-27',
                'capital' => '4.05',
            ],
            [
                'name' => 'Jacquot',
                'siren' => '786 682 536',
                'city' => 'Weiss',
                'dateRegister' => '1982-01-19',
                'capital' => '55875920.03',
            ],
            [
                'name' => 'Chauvin Bonneau SA',
                'siren' => '9 550 47',
                'city' => 'Pages',
                'dateRegister' => '2014-03-15',
                'capital' => '14208.09',
            ],
            [
                'name' => 'Fischer S.A.S.',
                'siren' => '242 571 729',
                'city' => 'Vaillant',
                'dateRegister' => '2019-08-10',
                'capital' => '57.04',
            ],
            [
                'name' => 'Hebert SARL',
                'siren' => '325 45 978',
                'city' => 'LegendreBourg',
                'dateRegister' => '1994-03-17',
                'capital' => '20272.4',
            ],
            [
                'name' => 'Hardy',
                'siren' => '659 932 826',
                'city' => 'Gay-la-Forêt',
                'dateRegister' => '2008-05-18',
                'capital' => '57.58',
            ],
            [
                'name' => 'Pires',
                'siren' => '310 777 742',
                'city' => 'Collet-sur-Mer',
                'dateRegister' => '1984-08-14',
                'capital' => '10916160.64',
            ],
            [
                'name' => 'Diallo',
                'siren' => '534 352 309',
                'city' => 'GuibertBourg',
                'dateRegister' => '2017-06-11',
                'capital' => '4.11',
            ],
            [
                'name' => 'Launay',
                'siren' => '958 103 263',
                'city' => 'Marty-sur-Roche',
                'dateRegister' => '2003-09-09',
                'capital' => '0.74',
            ],
            [
                'name' => 'Marie Weiss SAS',
                'siren' => '83 987 913',
                'city' => 'LecoqVille',
                'dateRegister' => '1982-07-11',
                'capital' => '0.06',
            ],
            [
                'name' => 'Munoz',
                'siren' => '766 534 531',
                'city' => 'Da Costadan',
                'dateRegister' => '2004-03-23',
                'capital' => '87359367.59',
            ],
        ];
    }
}
