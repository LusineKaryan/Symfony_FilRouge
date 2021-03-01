<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VersereController extends AbstractController
{
    /**
     * @Route("/versere", name="versere")
     */
    public function index(): Response
    {
        return $this->render('versere/index.html.twig', [
            'controller_name' => 'VersereController',
        ]);
    }

    /**
     * @Route("/", name="home")
     */
    public function home(): Response
    {
        return $this->render('versere/home.html.twig', [
            'title' => 'Bonjour',
        ]);
    }
}
