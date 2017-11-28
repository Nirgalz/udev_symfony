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

        $translator = $this->get('translator');

        $output = [
            "message1" => $translator->trans('i18nNotice'),
            "message2" => $translator->trans('secondMessage')
        ];


        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'output' => $output,
        ]);
    }
    //today users widget
    public function lastUsersWidgetAction(Request $request)
    {

        $date = new \DateTime('now', (new \DateTimeZone('Europe/Paris')));

        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository('AppBundle:User');
        $queryBuilder = $repository->createQueryBuilder('u')
            ->where('u.dateReg = :date')
            ->setParameters(['date' => $date->format('Y-m-d')])
            ->setMaxResults(10);
        $query = $queryBuilder->getQuery();
        $users = $query->getResult();

        return $this->render('default/users.html.twig',[
            'users'=>$users
        ]);
    }

    //today articles widget
    public function lastArticlesWidgetAction(Request $request)
    {

        $date = new \DateTime('now', (new \DateTimeZone('Europe/Paris')));

        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository('AppBundle:Article');
        $queryBuilder = $repository->createQueryBuilder('u')
            ->where('u.dateWritten = :date')
            ->setParameters(['date' => $date->format('Y-m-d')])
            ->setMaxResults(10);
        $query = $queryBuilder->getQuery();
        $articles = $query->getResult();

        return $this->render('default/articles.html.twig',[
            'articles'=>$articles
        ]);
    }

}
