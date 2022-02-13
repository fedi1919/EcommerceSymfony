<?php

namespace App\Controller;

use App\Classe\Search;
use App\Entity\Product;
use App\Form\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{

    /*
    private $em;

    public function __construct(EntityManagerInterface $em){
        $this->em = $em;

    }*/
    
    #[Route('/nos-produits', name: 'products')]
    public function index(Request $request)
    {

        $search= new Search();
        $form = $this->createForm(SearchType::class, $search);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $products =  $this->getDoctrine()->getRepository(Product::class)->findWithSearch($search);
        }else {
             $products = $this->getDoctrine()->getRepository(Product::class)->findAll();
        }

        return $this->render('product/index.html.twig',[
            'products' => $products,
            'form' => $form->createView()
        ]);
    }

    #[Route('/produit/{slug}', name: 'product')]
    public function show($slug)
    {
        
        $product = $this->getDoctrine()->getRepository(Product::class)->findOneBySlug($slug);

        if (!$product) {
            return $this->redirectToRoute('products'); // a comme parametre le nom de la route
        }

        return $this->render('product/show.html.twig',[
            'product' => $product
        ]);
    }
}
