<?php

namespace App\Controller;

use App\Entity\Rdv;
use App\Entity\User;
use App\Form\RdvType;
use App\Form\RdvEditType;
use App\Repository\RdvRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/rdv")
 */
class RdvController extends AbstractController
{
    /**
     * @Route("/", name="rdv_index", methods={"GET"})
     */
    public function index(RdvRepository $rdvRepository): Response
    {
        return $this->render('rdv/index.html.twig', [
            'rdvs' => $rdvRepository->findBy(array("IdPatient" => $this->getUser())),
            'user' => $this->getUser()
        ]);
    }

    /**
     * @Route("/listmodif", name="listmodif", methods={"GET"})
     */
    public function listmodif(RdvRepository $rdvRepository): Response
    {
        return $this->render('rdv/listmodif.html.twig', [
            'rdvs' => $rdvRepository->findBy(array("IdPatient" => $this->getUser())),
            'user' => $this->getUser()
        ]);
    }

    /**
     * @Route("/selectmedecin", name="rdv_selectmedecin", methods={"GET"})
     */
    public function selectmedecin(RdvRepository $rdvRepository): Response
    {
        $repo = $this->getDoctrine()->getRepository(User::class);
        $medecin = $repo->findAll();

        return $this->render('rdv/selectmedecin.html.twig', [
            'rdvs' => $rdvRepository->findBy(array("IdPatient" => $this->getUser())),
            'medecin' => $medecin,
            'user' => $this->getUser()
        ]);
    }

    /**
     * @Route("/new/{id}", name="rdv_new", methods={"GET","POST"})
     */
    public function new(Request $request, User $medecin): Response
    {
        $rdv = new Rdv();
        $rdv->setIdMedecin($medecin);
        $rdv->setStatus("en attente");
        $rdv->setIdPatient($this->getUser());
        $form = $this->createForm(RdvType::class, $rdv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rdv);


            try {
                $entityManager->flush();
            } catch (\Exception $e) {
                $errorMessage = $e->getMessage();
                // Add your message in the session
                $this->get('session')->getFlashBag()->add('error', 'PDO Exception :' . $errorMessage);
            }

            return $this->redirectToRoute('rdv_index');
        }

        // Requete nombre de rdv termine
        $repo = $this->getDoctrine()->getRepository(Rdv::class);
        $listrdv = $repo->findBy(array('IdMedecin' => $medecin, 'Status' => array("confirmé", "en attente")));

        return $this->render('rdv/new.html.twig', [
            'rdv' => $rdv,
            'listrdvs' => $listrdv,
            'form' => $form->createView(),
            'user' => $this->getUser(),
        ]);
    }

    /**
     * @Route("/{id}", name="rdv_show", methods={"GET"})
     */
    public function show(Rdv $rdv): Response
    {
        return $this->render('rdv/show.html.twig', [
            'rdv' => $rdv,
            'user' => $this->getUser(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="rdv_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Rdv $rdv): Response
    {
        $form = $this->createForm(RdvType::class, $rdv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('rdv_index');
        }

        return $this->render('rdv/edit.html.twig', [
            'rdv' => $rdv,
            'form' => $form->createView(),
            'user' => $this->getUser(),
        ]);
    }

    /**
     * @Route("/modif/{id}", name="rdvmodif", methods={"GET","POST"})
     */
    public function edit2(Request $request, Rdv $rdv): Response
    {
        $form = $this->createForm(RdvEditType::class, $rdv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $repo = $this->getDoctrine()->getRepository(User::class);
            $patient = $repo->find(array('id' => $rdv->getIdPatient()));

            $to      = $patient->getUsername();
            $subject = 'HopiPanel';
            $message = "Bonjour, le status de votre rendez est maintenant mis a jour. Cordialement";

            mail($to, $subject, $message);

            return $this->redirectToRoute('listmodif');
        }

        return $this->render('rdv/edit.html.twig', [
            'rdv' => $rdv,
            'form' => $form->createView(),
            'user' => $this->getUser(),
        ]);
    }

    /**
     * @Route("/{id}", name="rdv_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Rdv $rdv): Response
    {
        if ($this->isCsrfTokenValid('delete' . $rdv->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($rdv);
            $entityManager->flush();
        }

        return $this->redirectToRoute('rdv_index');
    }
}
