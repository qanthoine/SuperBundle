<?php

namespace SuperBundle\Controller;

use SuperBundle\Entity\Categorie;
use SuperBundle\Entity\Versionnement;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use SuperBundle\Entity\CustomPages;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AdminController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $listPages = $em->getRepository('SuperBundle:CustomPages')->findAll();
        $listCatagory = $em->getRepository('SuperBundle:Categorie')->findAll();
        $option = $this->getParameter('saves');
        if($option == true)
        {
            $status = "ON";
        }
        else
        {
            $status = "OFF";
        }
        return $this->render('SuperBundle:Admin:index.html.twig', array('listPages' => $listPages, 'listCatagory' => $listCatagory, 'status' => $status));
    }
    public function deleteAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $pages = $em->getRepository('SuperBundle:CustomPages')->find($id);
        $versionnement = $em->getRepository('SuperBundle:Versionnement')->findBy(array('pageId' => $id));
        if(!$pages)
        {
            throw new NotFoundHttpException("Page not found");
        }
        $em->remove($pages);
        foreach ($versionnement as $version) {
            $em->remove($version);
        }
        $em->flush();
        $request->getSession()->getFlashBag()->add('notice', 'This page has been successfully deleted !');
        return $this->redirect($this->generateUrl('super_admin'));
    }
    public function reviewAction($id)
    {
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('SuperBundle:Versionnement');
        $pages = $repository->find($id);
        if(!$pages)
        {
            throw new NotFoundHttpException("Page not found");
        }
        var_dump($pages);
        return $this->render(
            "SuperBundle:Page:page.html.twig",
            array('id' => $id, 'pages' => $pages));
    }
    public function restoreAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $new = $em->getRepository('SuperBundle:Versionnement')->find($id);
        $id_cpage = $new->getpageId();
        $old = $pages = $em->getRepository('SuperBundle:CustomPages')->find($id_cpage);
        if (!$old OR !$new)
        {
            throw new NotFoundHttpException("Page or Save not found");
        }
        $old->setTitle($new->getTitle());
        $old->setContent($new->getContent());
        $old->setCategorie($new->getCategorie());
        $em->persist($old);
        $em->flush();
        $option = $this->getParameter('saves');
        if($option == true)
        {
            $versionnement = new Versionnement();
            $versionnement->setTitle($old->getTitle());
            $versionnement->setCategorie($old->getCategorie());
            $versionnement->setContent($old->getContent());
            $versionnement->setPageId($old->getId());
            $versionnement->setType('Restore');
            $em->persist($versionnement);
            $em->flush();
        }
        $request->getSession()->getFlashBag()->add('notice', 'This page has been successfully restored !');
        return $this->redirect($this->generateUrl('super_admin'));
    }
    public function deleteversionAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $pages = $em->getRepository('SuperBundle:Versionnement')->find($id);
        if(!$pages)
        {
            throw new NotFoundHttpException("Page not found");
        }
        $em->remove($pages);
        $em->flush();
        $request->getSession()->getFlashBag()->add('notice', 'This Save has been successfully deleted !');
        return $this->redirect($this->generateUrl('super_admin'));

    }
    public function pageactionAction(Request $request, $id = null)
    {
        $em = $this->getDoctrine()->getManager();
        if (is_null($id)) {
            $page = new CustomPages();
            $type = "Create";
            $notice = "The page has been successfully created !";
            $page_title = "New Page";
            $version_load = null;

        }else{
            $page = $em->getRepository('SuperBundle:CustomPages')->find($id);
            if(!$page)
            {
                throw new NotFoundHttpException("Page not found");
            }
            $version_load = $em->getRepository('SuperBundle:Versionnement')->findBy(array('pageId' => $id), array('date' => 'desc'));
            $type = "Edit";
            $notice = "The page has been successfully edited !";
            $page_title = "Edit Page";
        }

        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $page);
        $formBuilder
            ->add('title',TextType::class)
            ->add('content',TextareaType::class, array("required"=>false))
            ->add('categorie', EntityType::class, array(
                'class'        => 'SuperBundle:Categorie',
                'choice_label' => 'name',
            ))
            ->add('save', SubmitType::class);
        $form = $formBuilder->getForm();
        $form->handleRequest($request);
        if ($form->isValid())
        {
            $em->persist($page);
            $em->flush();
            $option = $this->getParameter('saves');
            if($option == true)
            {
                $versionnement = new Versionnement();
                $versionnement->setTitle($page->getTitle());
                $versionnement->setCategorie($page->getCategorie());
                $versionnement->setContent($page->getContent());
                $versionnement->setPageId($page->getId());
                $versionnement->setType($type);
                $em->persist($versionnement);
                $em->flush();
            }
            $request->getSession()->getFlashBag()->add('notice', $notice);
            return $this->redirect($this->generateUrl('super_admin'));
        }
        return $return = $this->render('SuperBundle:Admin:add.html.twig', array(
            'form' => $form->createView(),
            'pageinfo' => $page,
            'version' => $version_load,
            'page_title' => $page_title,
            'type' => $type));
    }
    public function categoryactionAction(Request $request, $id = null)
    {
        $em = $this->getDoctrine()->getManager();
        if (is_null($id)) {
            $category = new Categorie();
            $notice = "The category has been successfully created !";
            $page_title = "New Category";

        }else{
            $category = $em->getRepository('SuperBundle:Categorie')->find($id);
            if(!$category)
            {
                throw new NotFoundHttpException("Page not found");
            }
            $notice = "This category has been successfully edited !";
            $page_title = "Edit Category";
        }
        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $category);
        $formBuilder
            ->add('name',TextType::class)
            ->add('save', SubmitType::class);
        $form = $formBuilder->getForm();
        $form->handleRequest($request);
        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();

            $em->persist($category);
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', $notice);
            return $this->redirect($this->generateUrl('super_admin'));
        }
        return $this->render('SuperBundle:Admin:addcategorie.html.twig', array('form' => $form->createView(), 'page_title' => $page_title, 'category' => $category));
    }
}
