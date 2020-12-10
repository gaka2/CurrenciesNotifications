<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @author Karol Gancarczyk
 */
class WebController extends AbstractController
{
    /**
     * @Route("/confirm_registration/{hash}", name="confirm_registration", methods={"GET"})
     */
    public function confirmUserRegistration(string $hash): Response
    {
		//TO DO - render form with field for e-mail and hidden field with hash
        return $this->render('web/index.html.twig');
    }

    /**
     * @Route("/unsubscribe/{hash}", name="unsubscribe", methods={"GET"})
     */
    public function unsubscribe(string $hash): Response
    {
		//TO DO - render form with field for e-mail and hidden field with hash
        return $this->render('web/index.html.twig');
    }
}
