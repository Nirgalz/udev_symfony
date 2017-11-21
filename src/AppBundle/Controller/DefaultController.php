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
}
