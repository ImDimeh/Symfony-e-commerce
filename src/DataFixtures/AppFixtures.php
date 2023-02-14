<?php

namespace App\DataFixtures;

use App\Entity\ProductCategories;
use App\Entity\Products;
use App\Entity\Users;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        for ($i = 0; $i < 50; $i++) {
            $user = new Users();
            if ($i == 0) {
                $user->setRole('ADMIN');
                $user->setmail("admin@localhost");
                $user->setPassword('admin');
                $manager->persist($user);

            }else {

                $user->setRole('USER');
                $user->setmail("user" .$i . "@localhost");
                $user->setPassword('user' . $i);
                $manager->persist($user);
            }

        }
        $manager->flush();

        $categories = array("jouet", "vetement", "alimentation", "mobilier", "electronique", "sport", "livres",
            "jeux video", "DVD et Blu-ray", "autre ");


        foreach ($categories as $categorie) {
            $category = new ProductCategories();
            $category->setName($categorie);

            $manager->persist($category);
        }


        $manager->flush();

        $AllProductCategories = $manager->getRepository(ProductCategories::class)->findAll();


        for ($i = 0; $i < 200; $i++) {
            $product = new Products();
            $product->setName("produit" . $i);

            $product->setCategories($AllProductCategories[rand(0, count($AllProductCategories) - 1)]);


            $product->setPrice(rand(1, 1000));

            $product->setDescription("description of the N' " . $i . " product ");
            $product->setStock(rand(1, 1000));

            $manager->persist($product );
        }
        $manager->flush();
    }
}
