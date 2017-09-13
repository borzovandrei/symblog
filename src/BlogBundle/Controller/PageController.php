<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\Enquiry;
use BlogBundle\Form\EnquiryType;
use BlogBundle\Repository\BlogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PageController extends Controller
{




    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine();
        $totalblog = $em->getRepository('BlogBundle:Blog')->findAllBlogCount();
        $page = $request->query->get("page") && $request->query->get("page") > 1 ? $request->query->get("page") : 1;
        $blogs = $em->getRepository('BlogBundle:Blog')->getLatestBlogs(["page"=>$page]);
        $pagination=[
            "total"=>array_shift($totalblog),
            "page"=>$page,
            "max_result"=>2,
            "url"=>"blog_homepage"
        ];

        return $this->render('BlogBundle:Page:index.html.twig', array(
            'blogs' => $blogs,
            'pagination'=>$pagination ,
        ));
    }


    public function loginAction()
    {
        return $this->render('BlogBundle:Page:login.html.twig');
    }



    public function aboutAction()
    {
        return $this->render('BlogBundle:Page:about.html.twig');
    }


    public function contactAction(Request $request)
    {
        $enquiry = new Enquiry();

        $form = $this->createForm(EnquiryType::class, $enquiry);

        if ($request->isMethod($request::METHOD_POST)) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $message = \Swift_Message::newInstance()
                    ->setSubject('Contact enquiry from symblog')
                    ->setFrom('enquiries@symblog.co.uk')
                    ->setTo($this->container->getParameter('blogger_blog.emails.contact_email'))
                    ->setBody($this->renderView('BlogBundle:Page:contactEmail.txt.twig', array('enquiry' => $enquiry)));


                $this->get('mailer')->send($message);

                $this->get('session')->getFlashBag()->add('blogger-notice', 'Спасибо! Ваше письмо было отправлено!');

                // Redirect - This is important to prevent users re-posting
                // the form if they refresh the page
                return $this->redirect($this->generateUrl('blog_contact'));

            }

        }

        return $this->render('BlogBundle:Page:contact.html.twig', array(
            'form' => $form->createView()
        ));
    }


    public function sidebarAction()
    {
        $em = $this->getDoctrine()
            ->getManager();

        $tags = $em->getRepository('BlogBundle:Blog')
            ->getTags();

        $tagWeights = $em->getRepository('BlogBundle:Blog')
            ->getTagWeights($tags);

        $commentLimit   = $this->container
            ->getParameter('blog.comments.latest_comment_limit');
        $latestComments = $em->getRepository('BlogBundle:Comment')
            ->getLatestComments($commentLimit);

        return $this->render('BlogBundle:Page:sidebar.html.twig', array(
            'latestComments'    => $latestComments,
            'tags'              => $tagWeights
        ));
    }

}