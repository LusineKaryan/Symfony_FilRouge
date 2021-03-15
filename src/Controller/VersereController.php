<?php

namespace App\Controller;


use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VersereController extends AbstractController
{
    /**
     * @Route("/versere", name="versere")
     */
    public function index(ProduitRepository $repo): Response
    {
        $produits = $repo->findAll();
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
    public function show($id, ProduitRepository $repo) {
        $produit = $repo->find($id);
        return $this->render('versere/show.html.twig',[
            'produit' => $produit
        ]);
    }
}
