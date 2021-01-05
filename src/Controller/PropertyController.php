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

/**
 * @Route("/property")
 */
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
     * @Route("/", name="property_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('property/index.html.twig', [
            'properties' => $this->repository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="property_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $property = new Property();
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {


            $this->em->persist($property);
            $this->em->flush();

            $this->addFlash('succes', "La proprieté à étè bien ajouté !");
            return $this->redirectToRoute('property_index');
        }

        return $this->render('property/new.html.twig', [
            'property' => $property,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="property_show", methods={"GET"})
     */
    public function show(Property $property): Response
    {
        return $this->render('property/show.html.twig', [
            'property' => $property,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="property_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Property $property): Response
    {
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $images = $form->get('images')->getData();
            foreach($images as $image)
            {
                
                $property->addImage($image);
                
            }
            $this->em->flush();
            $this->addFlash('succes', "La proprieté à étè bien modifiée !");

            return $this->redirectToRoute('property_index');
        }

        return $this->render('property/edit.html.twig', [
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
     * @Route("/delete/image/{id}", name="property_delete_image", methods={"DELETE"})
     */
    public function deleteImage(Image $image, Request $request)
    {
        //On decode le contenu avec Json
        $data = json_encode($request->getContent(), true);
        //On verifie le token
        if($this->isCsrfTokenValid('delete'.$image->getId(), $data['token']))
        {
           $nom = $image->getName;
            unlink($this->getParameter('images_directory').'/'.$nom);

        }
    }
}
