<?php

namespace App\Controller;

use App\Repository\ProductCategoriesRepository;
use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    #[Route('/app', name: 'app_app')]
    public function index(): Response
    {
        return $this->render('app/index.html.twig', [
            'controller_name' => 'AppController',
        ]);
    }

    #[Route('/', name: 'app_home')]
    public function home(ProductCategoriesRepository $categoriesRepository): Response
    {
        return $this->render('app/index.html.twig', [
            'controller_name' => 'AppController',
            'categories' => $categoriesRepository->findAll(),
        ]);
    }

    #[Route('/categorie/{id}', name: 'app_categorie_id')]
    public function categoriesId($id, ProductCategoriesRepository $categoriesRepository ,
                                 ProductsRepository $productsRepository): Response
    {

        $categorie = $categoriesRepository->find($id);
        $ASCProduct =  $productsRepository->orderByValueASC($id);
        $DESCProduct =  $productsRepository->orderByValueDESC($id);
        if (!$categorie) {
            throw $this->createNotFoundException(
                'No categories found for id ' . $id
            );
        }
        return $this->render('app/indexCategorie.html.twig', [
            'controller_name' => 'AppController',
            'product_categories' => $categorie ,
            'ASCProduct' => $ASCProduct ,
            'DESCProduct' => $DESCProduct ,
        ]);



    }


}
