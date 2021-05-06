<?php

namespace App\Controller;

use App\Entity\Sejour;
use App\Form\SejourType;
use App\Repository\SejourRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sejour")
 */
class SejourController extends AbstractController
{
    /**
     * @Route("/", name="sejour_index", methods={"GET"})
     */
    public function index(SejourRepository $sejourRepository): Response
    {
        return $this->render('sejour/index.html.twig', [
            'sejours' => $sejourRepository->findAll(),'user' => $this->getUser()
        ]);
    }

    /**
     * @Route("/new", name="sejour_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $sejour = new Sejour();
        $form = $this->createForm(SejourType::class, $sejour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sejour);
            $entityManager->flush();

            return $this->redirectToRoute('sejour_index');
        }

        return $this->render('sejour/new.html.twig', [
            'sejour' => $sejour,
            'form' => $form->createView(),'user' => $this->getUser()
        ]);
    }

    /**
     * @Route("/{id}", name="sejour_show", methods={"GET"})
     */
    public function show(Sejour $sejour): Response
    {
        return $this->render('sejour/show.html.twig', [
            'sejour' => $sejour,'user' => $this->getUser()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="sejour_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Sejour $sejour): Response
    {
        $form = $this->createForm(SejourType::class, $sejour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sejour_index');
        }

        return $this->render('sejour/edit.html.twig', [
            'sejour' => $sejour,
            'form' => $form->createView(),'user' => $this->getUser()
        ]);
    }

    /**
     * @Route("/{id}", name="sejour_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Sejour $sejour): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sejour->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($sejour);
            $entityManager->flush();
        }

        return $this->redirectToRoute('sejour_index');
    }
}
