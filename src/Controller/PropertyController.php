<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class PropertyController extends AbstractController
{

    private $repository;
    private $em;

    public function __construct(PropertyRepository $repository, EntityManagerInterface $em)
    {   
        $this->repository = $repository;
        $this->em = $em;
    }


      /**
     * @Route("/", name="app_home")
     */
    public function index()
    {
        return $this->render('/layouts/property/index.html.twig', [
            'properties' => $this->repository->findAll()
        ]);
    }
    /**
     * @Route("/property", name="app_properties")
     */
    public function list()
    {
        return $this->render('/layouts/property/properties.html.twig', [
            'properties' => $this->repository->findAll()
        ]);
    }

    /**
     * @Route("/property/new", name="property_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $property = new Property();
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            foreach ($property->getImages() as $image) {
                $image->setProperty($property);
            }

            $this->em->persist($property);
            $this->em->flush();

            $this->addFlash('succes', "La proprieté à étè bien ajouté !");
            return $this->redirectToRoute('property_index');
        }

        return $this->render('/layouts/property/new.html.twig', [
            'property' => $property,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/property/show/{id}", name="property_show", methods={"GET"})
     */
    public function show(Property $property): Response
    {
        return $this->render('/layouts/property/show.html.twig', [
            'property' => $property,
        ]);
    }

    /**
     * @Route("/property/edit/{id}", name="property_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Property $property): Response
    {
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // dd($property);
            foreach ($property->getImages() as $image) {
                dd($image);
                
                $image->setProperty($property);
            }
            $this->em->flush();
            $this->addFlash('success', "La proprieté à étè bien modifiée !");

            return $this->redirectToRoute('app_properties');
        }

        return $this->render('/layouts/property/edit.html.twig', [
            'property' => $property,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="property_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Property $property): Response
    {
        if ($this->isCsrfTokenValid('delete'.$property->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($property);
            $entityManager->flush();
        }

        return $this->redirectToRoute('property_index');
    }


     /**
     * @Route("/agent", name="agent")
     */
    public function agent(): Response
    {
        return $this->render('/layouts/agent.html.twig');
    }
     /**
     * @Route("/about", name="about")
     */
    public function about(): Response
    {
        return $this->render('/layouts/about.html.twig');
    }
     /**
     * @Route("/blog", name="blog")
     */
    public function blog(): Response
    {
        return $this->render('/layouts/blog.html.twig');
    }
     /**
     * @Route("/contact", name="contact")
     */
    public function contact(): Response
    {
        return $this->render('/layouts/contact.html.twig');
    }
   

    // /**
    //  * @Route("/delete/image/{id}", name="property_delete_image", methods={"DELETE"})
    //  */
    // public function deleteImage(Image $image, Request $request)
    // {
    //     //On decode le contenu avec Json
    //     $data = json_encode($request->getContent(), true);
    //     //On verifie le token
    //     if($this->isCsrfTokenValid('delete'.$image->getId(), $data['token']))
    //     {
    //        $nom = $image->getName;
    //         unlink($this->getParameter('images_directory').'/'.$nom);

    //     }
    // }
}
