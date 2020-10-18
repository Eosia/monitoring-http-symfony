<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class LuckyController extends AbstractController
{

    /**
     * @Route("/lucky/number", name="lucky")
     */
    public function number()
    {
        $number = random_int(0, 100);

        return $this->render('test.html.twig', ['number' => $number
        ]);
    }
}