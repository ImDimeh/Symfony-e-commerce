<?php

namespace App\DataFixtures;

use App\Entity\ProductCategories;
use App\Entity\Products;
use App\Entity\User;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);



        for ($i = 0; $i < 50; $i++) {
            $user = new User();
           $user->setEmail("user" .$i . "@localhost");
            $password = $this->hasher->hashPassword($user, 'passwordHasher');
            $user->setPassword($password);
            if ($i == 0)
                $user->setRoles([
                    'ROLE_ADMIN',
                    'ROLE_USER'
                ]);
            else
                $user->setRoles(['ROLE_USER']);

            $manager->persist($user);
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
