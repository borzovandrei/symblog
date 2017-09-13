<?php

namespace BlogBundle\Controller;


use BlogBundle\Entity\Blog;
use BlogBundle\Form\BlogAddType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    public function indexAction() {
        return new Response("HERE");
    }


    public function blogAction(Request $request){
        $blogsRepository = $this -> getDoctrine() -> getRepository("BlogBundle:Blog");

        $totalblog = $blogsRepository->findAllBlogCount();
        $page = $request->query->get("page") && $request->query->get("page") > 1 ? $request->query->get("page") : 1;
        $blogs = $blogsRepository ->getLatestBlogs(["page"=>$page]);
        $pagination=[
            "total"=>array_shift($totalblog),
            "page"=>$page,
            "max_result"=>2,
            "url"=>"admin_blog"
        ];

        return $this -> render("BlogBundle:Admin:admin.html.twig", array(
            'blogs' => $blogs,
            'pagination'=>$pagination ,
        ));
    }


    public function blogEditAction($id, Request $request){
        $em = $this->getDoctrine();
        $blog = $em->getRepository("BlogBundle:Blog")->find($id);
        if(!$blog){
            throw $this->createAccessDeniedException("Вы не имеете доступ к этой странице");
        }

        $form = $this->createForm(BlogAddType::class, $blog );
        $form -> handleRequest($request);
        if ($form->isSubmitted() &&  $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em -> persist($blog);
            $em->flush();
            return $this->redirectToRoute("admin_blog");
        }

        return $this->render("BlogBundle:Admin:blog-edit.html.twig", [
            'form_edit_blog'=> $form -> createView()
        ]);

    }



    public function blogAddAction(Request $request){
        $blog = new Blog();
        $form = $this->createForm(BlogAddType::class, $blog );

        $form -> handleRequest($request);
        if ($form->isSubmitted() &&  $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em -> persist($blog);
            $em->flush();
            return $this->redirectToRoute("admin_blog");
        }

        return $this->render("BlogBundle:Admin:blog-add.html.twig", [
            'form_add_blog'=> $form -> createView()
        ]);
    }
}