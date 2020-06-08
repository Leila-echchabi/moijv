<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{

//    private $categories=["sport", "combat", "logique", "memoire"];

    const CATEGORIES
        = [
            'jeux'      => 'Jeux',
            'console'   => 'Console',
            'cles-steam' => 'Clés steam'
        ];

    public function load(ObjectManager $manager)
    {
//        for($i=0;$i<count(self::$this->categories);$i++)
//        {
//            $category = new Category();
//
//            $category->setName($this->categories[$i]);
//            $category->setName($this->categories[$i]);
//
//            $manager->persist($category);
//
        foreach (self::CATEGORIES as $slug => $name) {
            $category = new Category();
            $category->setSlug($slug);
            $category->setName($name);
            $this->addReference('category_' . $slug, $category);
            $manager->persist($category);

        }
        $manager->flush();

    }
}
