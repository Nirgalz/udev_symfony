<?php
/**
 * Created by PhpStorm.
 * User: IPI
 * Date: 21/11/2017
 * Time: 16:19
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Article;
use AppBundle\Entity\User;


class ArticleController extends Controller
{

    /**
     * @Route("/articles/")
     */
    public function indexAction()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository('AppBundle:Article');

        $articles = $repository->findAll();

        return $this->render('articles/index.html.twig', [
            'articles' => $articles,
        ]);

    }



    /**
     * @Route("/articles/create")
     */
    public function createArticle(){
        $article = new Article();
        $article->setContent("blalsdofkspoeslejfseijf");
        $article->setDateWritten(new \DateTime());
        $article->setTitle('un article');

        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository('AppBundle:User');

        $user = $repository->findOneBy(['id' => 1]);

        $article->setUser($user);

        $entityManager->persist($article);
        $entityManager->flush();

        return $this->render('add.html.twig', [
            'message' => 'sauvegardé ?',
        ]);
    }



}

