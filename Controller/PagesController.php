<?php

namespace SuperBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use SuperBundle\Entity;

class PagesController extends Controller
{
    public function indexAction($slug)
    {
		$repository = $this
			->getDoctrine()
			->getManager()
			->getRepository('SuperBundle:CustomPages');
			$pages = $repository->findOneBy(array('slug' => $slug));
		if(!$pages)
		{
			throw new NotFoundHttpException("Page not found");
		}
		$categorie = $pages->getCategorie()->getName();


		return $this->render(
			"SuperBundle:Page:page.html.twig",
			array('slug' => $slug, 'pages' => $pages, 'categorie' => $categorie));
    }

	public function allAction()
	{
		$repository = $this
			->getDoctrine()
			->getManager()
			->getRepository('SuperBundle:CustomPages');
		$pages = $repository->findAll();

		return $this->render(
			"SuperBundle:Page:pageall.html.twig",
			array('pages' => $pages));
	}
}