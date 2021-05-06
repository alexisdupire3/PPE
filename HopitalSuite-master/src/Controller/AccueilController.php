<?php

namespace App\Controller;

use App\Entity\Chambre;
use App\Entity\Lit;
use App\Entity\Patient;
use App\Entity\Sejour;
use App\Entity\Rdv;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**
     * @Route("/accueil", name="accueil")
     */
    public function index(): Response
    {
        // Requete nombre de chambres
        $repo = $this->getDoctrine()->getRepository(Chambre::class);
        $chambre = $repo->findAll();

        // Requete nombre de lits
        $repo = $this->getDoctrine()->getRepository(Lit::class);
        $lit= $repo->findAll();

        // Requete nombre de patients
        $repo = $this->getDoctrine()->getRepository(Patient::class);
        $patient= $repo->findAll();

        // Requete sur les fiches des patients
        $repo = $this->getDoctrine()->getRepository(Sejour::class);
        $sejour= $repo->findAll();

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

        return $this->render('accueil/index.html.twig', [
            'chambres' => $chambre,
            'lits' => $lit,
            'patients' => $patient,
            'sejours' => $sejour,
            'rdvtermine' => $rdvtermine,
            'rdv' => $rdv,
            'rdvconfirme' => $rdvconfirme,
            'rdvdemande' => $rdvdemande,
            'user' => $this->getUser()
        ]);
    }
}
