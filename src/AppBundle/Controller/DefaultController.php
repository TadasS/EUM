<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->redirectToRoute('person_index');

        $persons = $this->getDoctrine()
            ->getRepository('AppBundle:person')
            ->findAll();

        return $this->render('users_list.html.twig', array(
            'persons' => $persons
        ));
    }
}
