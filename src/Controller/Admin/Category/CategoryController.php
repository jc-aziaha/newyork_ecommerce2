<?php

namespace App\Controller\Admin\Category;

use App\Entity\Category;
use App\Form\CategoryFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/admin')]
class CategoryController extends AbstractController
{
    #[Route('/category/index', name: 'admin_category_index', methods:['GET'])]
    public function index(): Response
    {
        return $this->render('pages/admin/category/index.html.twig');
    }


    #[Route('/category/create', name: 'admin_category_create', methods:['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $em) : Response
    {
        $category = new Category();

        $form = $this->createForm(CategoryFormType::class, $category);

        $form->handleRequest($request);

        if ( $form->isSubmitted() && $form->isValid() ) 
        {
            $em->persist($category);
            $em->flush();

            $this->addFlash("success", "La catégorie a été créée");

            return $this->redirectToRoute('admin_category_index');
        }

        return $this->render('pages/admin/category/create.html.twig', [
            "form" => $form->createView()
        ]);
    }

}
