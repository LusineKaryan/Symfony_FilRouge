<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Entity\Produit;
use App\Repository\AuteurRepository;
use App\Repository\ProduitRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class VersereController extends AbstractController
{
    /**
     * @Route("/versere", name="versere")
     */
    public function index(ProduitRepository $repo, PaginatorInterface $paginator, request $request): Response
    {
        $allProducts = $repo->findAll();
        // Paginate the results of the query
        $produits = $paginator->paginate(
        // Doctrine Query, not results    
            $allProducts,
        // Define the page parameter
            $request->query->getInt('page', 1),
        // Items per page  
            3
        ); 

        return $this->render('versere/index.html.twig', [
            'controller_name' => 'Œuvres d\'artistes',
            'produits' => $produits
        ]);
    }

    /**
     * @Route("/", name="home")
     */
    public function home(): Response
    {
        return $this->render('versere/home.html.twig', [
            'title' => 'LA NATURE SAUVAGE',
        ]);
    }

      /**
     * @Route("/oeuvres/{id}", name="versere_show")
     */
    public function show($id, ProduitRepository $repo, AuteurRepository $repos): Response 
    {
        $produit = $repo->find($id);
        $auteur = $repos->find($id);
        return $this->render('versere/show.html.twig',[
            'produit' => $produit,
            'auteur' => $auteur
        ]);
    }
}
