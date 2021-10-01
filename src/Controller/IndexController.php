<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
Use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
{
    /**
     * @Route("/test")
     */
public function home()
{
    return $this->render('index.html.twig');

}
}
