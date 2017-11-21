<?php


namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MultiplyController extends Controller
{
    /**
     * @Route("/multiply")
     */
    public function numberAction ()
    {
        $table = [];

        for ($i = 1; $i < 11; $i++) {
            for ($j = 1; $j < 11; $j++) {

                $table[$i][$j] = $i * $j ;


            };
        };



        $monolog = $this->get('logger');
        $monolog->addNotice('ceci est un message loulopuil', ['tableau'=>$table]);
        $monolog->addEmergency('ceci est un message URGENT CONNARD §', ['tableau'=>$table]);



        return $this->render('default/multiply.html.twig', [
            'table' => $table,
        ]);

    }
}