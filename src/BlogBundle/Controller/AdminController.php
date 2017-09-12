<?php

namespace BlogBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    public function indexAction() {
        return new Response("HERE");
    }


    public function blogAction(){
        $blogs = $this -> getDoctrine() -> getRepository("BlogBundle:Blog")->findAll();
        return $this -> render("BlogBundle:Admin:admin.html.twig", array(
            'blogs' => $blogs
        ));
    }


    public function blogEditAction($id){
        return new Response($id);
    }
}