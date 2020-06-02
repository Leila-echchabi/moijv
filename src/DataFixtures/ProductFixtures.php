<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    const NB_PRODUCTS = 50;

    public function load(ObjectManager $manager)
    {
        for($i = 0; $i < self::NB_PRODUCTS; $i++) {
            $product = new Product();

            $product->setName("Mon produit $i");
            $product->setDescription("Ma super description $i");
            $product->setPrice(random_int(100, 100000));
            $product->setRef(substr(str_shuffle(md5(random_int(0, 1000000))), 0, 25));
            $product->setUser($this->getReference('user'.random_int(0, UserFixtures::NB_USER-1)));

            $manager->persist($product);
        }

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
