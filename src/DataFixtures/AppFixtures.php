<?php

namespace App\DataFixtures;

use App\Entity\Size;
use App\Entity\Sweatshirt;
use App\Entity\SweatshirtSize;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher) {}
    

    public function load(ObjectManager $manager): void
    {
        $sizeLabels = ['xs', 's', 'm', 'l', 'xl'];
        $sizes = [];

        foreach($sizeLabels as $label) {
            $size = new Size();
            $size->setLabel($label);
            $manager->persist($size);
            $sizes[$label] = $size;
        }

        $sweatshirts = [
            ['name' => 'Blackbelt',
            'price' => 29.90,
            'image' => '1-688f73571eda5634908786.jpg',
            'top' => true,
            'sizes' => [
                ['size' => 'xs', 'stock' => 2],
                ['size' => 's', 'stock' => 2],
                ['size' => 'm', 'stock' => 2],
                ['size' => 'l', 'stock' => 2],
                ['size' => 'xl', 'stock' => 2]
                ]
            ],
            ['name' => 'BleuBelt',
            'price' => 29.90,
            'image' => '2-688f744cb1dc3822196113.jpg',
            'top' => false,
            'sizes' => [
                ['size' => 'xs', 'stock' => 2],
                ['size' => 's', 'stock' => 2],
                ['size' => 'm', 'stock' => 2],
                ['size' => 'l', 'stock' => 2],
                ['size' => 'xl', 'stock' => 2]
                ]
            ],
            ['name' => 'Street',
            'price' => 34.50,
            'image' => '3-688f746b059a1966996687.jpg',
            'top' => false,
            'sizes' => [
                ['size' => 'xs', 'stock' => 2],
                ['size' => 's', 'stock' => 2],
                ['size' => 'm', 'stock' => 2],
                ['size' => 'l', 'stock' => 2],
                ['size' => 'xl', 'stock' => 2]
                ]
            ],
            ['name' => 'Pokeball',
            'price' => 45,
            'image' => '4-688f7481ea027658802130.jpg',
            'top' => true,
            'sizes' => [
                ['size' => 'xs', 'stock' => 2],
                ['size' => 's', 'stock' => 2],
                ['size' => 'm', 'stock' => 2],
                ['size' => 'l', 'stock' => 2],
                ['size' => 'xl', 'stock' => 2]
                ]
            ],
            ['name' => 'PinkLady',
            'price' => 29.90,
            'image' => '5-688f749f98fbd678572416.jpg',
            'top' => false,
            'sizes' => [
                ['size' => 'xs', 'stock' => 2],
                ['size' => 's', 'stock' => 2],
                ['size' => 'm', 'stock' => 2],
                ['size' => 'l', 'stock' => 2],
                ['size' => 'xl', 'stock' => 2]
                ]
            ],
            ['name' => 'Snow',
            'price' => 32,
            'image' => '6-688f74b407f57776980767.jpg',
            'top' => false,
            'sizes' => [
                ['size' => 'xs', 'stock' => 2],
                ['size' => 's', 'stock' => 2],
                ['size' => 'm', 'stock' => 2],
                ['size' => 'l', 'stock' => 2],
                ['size' => 'xl', 'stock' => 2]
                ]
            ],
            ['name' => 'Greyback',
            'price' => 28.50,
            'image' => '7-688f74cce4b4e051684585.jpg',
            'top' => false,
            'sizes' => [
                ['size' => 'xs', 'stock' => 2],
                ['size' => 's', 'stock' => 2],
                ['size' => 'm', 'stock' => 2],
                ['size' => 'l', 'stock' => 2],
                ['size' => 'xl', 'stock' => 2]
                ]
            ],
            ['name' => 'BlueCloud',
            'price' => 45,
            'image' => '8-688f74e14f182755289177.jpg',
            'top' => false,
            'sizes' => [
                ['size' => 'xs', 'stock' => 2],
                ['size' => 's', 'stock' => 2],
                ['size' => 'm', 'stock' => 2],
                ['size' => 'l', 'stock' => 2],
                ['size' => 'xl', 'stock' => 2]
                ]
            ],
            ['name' => 'BornInUsa',
            'price' => 59.90,
            'image' => '9-688f74f7eaa3f468610624.jpg',
            'top' => true,
            'sizes' => [
                ['size' => 'xs', 'stock' => 2],
                ['size' => 's', 'stock' => 2],
                ['size' => 'm', 'stock' => 2],
                ['size' => 'l', 'stock' => 2],
                ['size' => 'xl', 'stock' => 2]
                ]
            ],
            ['name' => 'GreenSchool',
            'price' => 42.20,
            'image' => '10-688f751215065768343460.jpg',
            'top' => false,
            'sizes' => [
                ['size' => 'xs', 'stock' => 2],
                ['size' => 's', 'stock' => 2],
                ['size' => 'm', 'stock' => 2],
                ['size' => 'l', 'stock' => 2],
                ['size' => 'xl', 'stock' => 2]
                ]
            ],
        ];

        foreach($sweatshirts as $data) {
            $sweatshirt = new Sweatshirt();
            $sweatshirt->setName($data['name']);
            $sweatshirt->setPrice($data['price']);
            $sweatshirt->setImageName($data['image']);
            $sweatshirt->setTop($data['top']);

            $manager->persist($sweatshirt);

            foreach($data['sizes'] as $sizeData) {
                $sweatshirtSize = new SweatshirtSize();
                $sizeEntity = $sizes[$sizeData['size']] ?? null;
                if($sizeEntity === null) {
                    throw new \Exception('Taille inconnue : ' . $sizeData['size']);
                }
                $sweatshirtSize->setSize($sizeEntity);
                $sweatshirtSize->setStock($sizeData['stock']);
                $sweatshirtSize->setSweatshirt($sweatshirt);

                $manager->persist($sweatshirtSize);
            }

        }

        $users = [
            ['name' => 'admin', 'email' => 'admin@gmail.com', 'password' => 'admin123', 'delivery_address' => 'adminCity', 'roles' => ['ROLE_ADMIN']],
            ['name' => 'John Doe', 'email' => 'johndoe@gmail.com', 'password' => 'johndoe', 'delivery_address' => 'johndoeCity', 'roles' => ['ROLE_USER']]
        ];

        foreach($users as $data) {
            $user = new User();
            $user->setName($data['name']);
            $user->setEmail($data['email']);
            $user->setPassword(
                $this->passwordHasher->hashPassword($user, $data['password']));
            $user->setDeliveryAddress($data['delivery_address']);
            $user->setRoles($data['roles']);

            $manager->persist($user);
        }

        $manager->flush();
    }
}
