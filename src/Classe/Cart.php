<?php

namespace App\Classe;

use App\Entity\Product;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\ORM\EntityManagerInterface;

class Cart
{
    private $session;
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, SessionInterface $session)
    {
        $this->session = $session;
        $this->entityManager = $entityManager;
        
    }
    

    public function add($id)
    {
        $cart = $this->session->get('cart', []);
        
        if(!empty($cart[$id])){
            $cart[$id]++;
        }else{
            $cart[$id] = 1;
        }
        
        $this->session->set('cart', $cart);
    }

    public function get()
    {
        return $this->session->get('cart');
    }

    public function getFull()  // cette fonction nous retourne notre panier
    {
        $cartComplete = [];

        foreach($this->get() as $id => $quantite){
            $product_object =  $this->entityManager->getRepository(Product::class)->findOneById($id);
            
            if (!$product_object) { // cette condition empeche les utilisateurs d'introduire qui n'existe pas depuis l'url 
                $this->delete($id);
                continue;
            }
            
            $cartComplete[] = [
                'product' =>$product_object,
                'quantite' => $quantite
            ];
        }

        return $cartComplete;
    }

    public function remove()
    {
        return $this->session->remove('cart');
    }

    public function delete($id)
    {
       $cart = $this->session->get('cart', []);
       unset($cart[$id]);

       return $this->session->set('cart', $cart); //remettre le nouveau carte apres le supression
    }

    public function decrease($id)
    {
         $cart = $this->session->get('cart', []);
        
         //vérifire que la quantité n'est pas égale à 1
         if ($cart[$id] > 1) {
             //retirer une quantité (-1)
             $cart[$id]--;
         }else
         {
             //supprimer le produit
             unset($cart[$id]);
         }

         return $this->session->set('cart', $cart);

    }

}