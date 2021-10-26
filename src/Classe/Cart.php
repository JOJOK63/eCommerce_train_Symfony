<?php

namespace App\Classe;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Cart
{
    private $session;
    private $entityManager;

    public function __construct(SessionInterface $session,EntityManagerInterface $entityManager , ProductRepository $productRepository)
    {
        $this->session = $session;
        $this->entityManager = $entityManager;

    }

    public function add($id)
    {
        $cart = $this->session->get('cart',[]);

        //is product already exist add one to the quantity of this product
        if(!empty($cart[$id])) {
            $cart[$id]++;
        }else{
            $cart[$id] = 1;
        }

        return $this->session->set('cart',$cart);
    }

    public function get()
    {
        return $this->session->get('cart');
    }
    public function remove()
    {
        return $this->session->remove('cart');
    }

    public function delete($id){

        $cart = $this->session->get('cart',[]);

        //keep out cart with the id select out of the cart array
        unset($cart[$id]);

        return $this->session->set('cart',$cart);
    }

    public function decrease($id)
    {
        $cart = $this->session->get('cart',[]);

        if($cart[$id] > 1) {
            $cart[$id]--;
        }else{
            unset($cart[$id]);
        }
        return $this->session->set('cart',$cart);
    }

    public function getFull() {

        $cartComplete = [];

        if($this->get()){
            foreach ($this->get() as  $id => $quantity) {
                $product_object= $this->entityManager->getRepository(Product::class)->findOneById($id);
//                security: if someone put an inexistant id the app make a verification and delete the user id entrance
                if(!$product_object){
                    $this->delete($id);
                    continue;
                }
                $cartComplete[] = [
                    'product' => $product_object,
                    'quantity' => $quantity
                ];
            }
        }
        return $cartComplete;
    }
}