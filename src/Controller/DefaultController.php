<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller {

    /**
     * @Route("/")
     * @return Response
     */
    public function index() {

        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository('App\Entity\Resource')->findAll();
        return $this->render('pages/welcome.html.twig', array(
            'posts' => $posts
        ));
    }
}