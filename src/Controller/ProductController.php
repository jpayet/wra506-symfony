<?php

namespace App\Controller;

use App\Services\Slugify;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_product')]
    public function listProducts(): Response
    {
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

    #[Route('/product/slug', name: 'app_slug_product')]
    public function slugProduct(Slugify $slugify): Response
    {

        $text = $slugify->generateSlug('Ceci est une phrase en français !');

        return $this->render('product/slug.html.twig', [
            'slug' => $text
        ]);
    }

    #[Route('/product/{id}', name: 'app_product_view')]
    public function viewProducts(Request $request): Response
    {
        $id = $request->get('id');
        return $this->render('product/view.html.twig', [
            'id' => $id,
            'controller_name' => 'ProductController',
        ]);
    }
}
