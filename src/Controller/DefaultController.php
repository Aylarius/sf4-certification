<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller {

    /**
     * @Route("/", name="homepage")
     */
    public function index() : Response {

        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository('App\Entity\Resource')->findBy(array('published' => true));
        return $this->render('pages/welcome.html.twig', array(
            'posts' => $posts
        ));
    }

    /**
     * @Route("/category/{slug}", name="resources_by_category")
     */
    public function resourceByCategory($slug) : Response {

        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('App\Entity\Category')->findOneBy(array('slug' => $slug));
        $posts = $em->getRepository('App\Entity\Resource')->findBy(array('category' => $category, 'published' => true));
        return $this->render('pages/resources_by_category.html.twig', array(
            'posts' => $posts,
            'category' => $category
        ));
    }

    /**
     * @Route("/resource/{slug}", name="resource_post")
     */
    public function resourcePost($slug) : Response {

        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository('App\Entity\Resource')->findOneBy(array('slug' => $slug));
        return $this->render('pages/resource_post.html.twig', array(
            'post' => $post
        ));
    }

    /**
     * @Route("/about", name="about")
     */
    public function about() : Response {

        return $this->render('pages/about.html.twig');
    }

    public function customMenu($max = 5) : Response {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('App\Entity\Category')->findBy(array(), array('title' => 'ASC'), $max, 0);
        return $this->render('menu.html.twig', array(
            'categories' => $categories
        ));
    }

}