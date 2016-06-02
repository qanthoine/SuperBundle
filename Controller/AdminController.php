<?php

namespace SuperBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use SuperBundle\Entity\CustomPages;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Httpfoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AdminController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $listPages = $em->getRepository('SuperBundle:CustomPages')->findAll();
        return $this->render('SuperBundle:Admin:index.html.twig', array('listPages' => $listPages));
    }
    public function addAction(Request $request)
    {
        $page = new CustomPages();
        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $page);
        $formBuilder
            ->add('title',TextType::class)
            ->add('content',TextareaType::class, array("required"=>false))
            ->add('save', SubmitType::class);
        $form = $formBuilder->getForm();
        $form->handleRequest($request);
        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            
            $em->persist($page);
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'The page has been successfully created !');
            return $this->redirect($this->generateUrl('super_admin'));
        }
        return $this->render('SuperBundle:Admin:add.html.twig', array('form' => $form->createView()));
    }
    public function deleteAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $pages = $em->getRepository('SuperBundle:CustomPages')->find($id);
        if(!$pages)
        {
            throw new NotFoundHttpException("Page not found");
        }
        $em->remove($pages);
        $em->flush();
        $request->getSession()->getFlashBag()->add('notice', 'The page has been successfully deleted !');
        $listPages = $em->getRepository('SuperBundle:CustomPages')->findAll();
        return $this->redirect($this->generateUrl('super_admin', array('listPages' => $listPages)));
    }
    public function modifyAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $pages = $em->getRepository('SuperBundle:CustomPages')->find($id);
        if(!$pages)
        {
            throw new NotFoundHttpException("Page not found");
        }
        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $pages);
        $formBuilder
            ->add('title',TextType::class)
            ->add('content',TextareaType::class, array("required"=>false))
            ->add('save', SubmitType::class);
        $form = $formBuilder->getForm();
        $form->handleRequest($request);
        if ($form->isValid())
        {
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'The page has been successfully edited !');
            return $this->redirect($this->generateUrl('super_admin'));
        }
        return $this->render('SuperBundle:Admin:modify.html.twig', array('form' => $form->createView(),'id' => $id, 'pageinfo' => $pages));
    }
}
