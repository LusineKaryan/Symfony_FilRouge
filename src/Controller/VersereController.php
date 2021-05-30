<?php

namespace App\Controller;

use DateTime;
use App\Entity\Comments;
use App\Form\CommentsType;
use App\Repository\ProduitRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class VersereController extends AbstractController
{
    /**
     * @Route("/oeuvres", name="versere")
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
    public function show($id, ProduitRepository $repo, request $request, TranslatorInterface $translator): Response 
    {
        $produit = $repo->findOneBy(['id' => $id]);

        //Partie commentaires
        //On crée le commentaire "vierge"
        $comment = new Comments;

        //On génère le formulaire
        $commentForm = $this->createForm(CommentsType::class, $comment);

        $commentForm->handleRequest($request);

        //Traitement du formulaire
        if($commentForm->isSubmitted() && $commentForm->isValid()){
            $comment->setCreatedAt(new DateTime());
            $comment->setProduit($produit);

            //On récupère le contenu du champ parentid
            $parentid = $commentForm->get("parentid")->getData();

            //On va chercher le commentaire correspondant
            $em = $this->getDoctrine()->getManager();

            if($parentid != null){
               $parent = $em->getRepository(Comments::class)->find($parentid); 
            }
            
            //On définit le parent
            $comment->setParent($parent ?? null);
            
            $em->persist($comment);
            $em->flush();

            $message = $translator->trans('Your comment has been sent');
            
            $this->addFlash('message', $message);
            
            return $this->redirectToRoute('versere_show', ['id' => $produit->getId()]);
        }
       
        return $this->render('versere/show.html.twig',[
            'produit' => $produit,
            'commentForm' => $commentForm->createView()
            
        ]);
    }
}
