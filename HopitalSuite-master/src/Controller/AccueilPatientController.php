<?php

namespace App\Controller;

use App\Entity\Rdv;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilPatientController extends AbstractController
{
    /**
     * @Route("/menupatient", name="menupatient")
     */
    public function index2(): Response
    {
        // Requete nombre de rdv termine
        $repo = $this->getDoctrine()->getRepository(Rdv::class);
        $rdvtermine= $repo->findBy(array('IdPatient' => $this->getUser(), 'Status' => "réalisé"));

        // Requete nombre de rdv
        $repo = $this->getDoctrine()->getRepository(Rdv::class);
        $rdv= $repo->findBy(array('IdPatient' => $this->getUser()));

        // Requete nombre de rdv refuse
        $repo = $this->getDoctrine()->getRepository(Rdv::class);
        $rdvconfirme= $repo->findBy(array('IdPatient' => $this->getUser(), 'Status' => "confirmé"));

        // Requete nombre de rdv demande
        $repo = $this->getDoctrine()->getRepository(Rdv::class);
        $rdvdemande= $repo->findBy(array('IdPatient' => $this->getUser(), 'Status' => "en attente"));

        return $this->render('accueilpatient/index.html.twig', [
            'rdvtermine' => $rdvtermine,
            'rdv' => $rdv,
            'rdvconfirme' => $rdvconfirme,
            'rdvdemande' => $rdvdemande,
            'user' => $this->getUser()
        ]);
    }
}
