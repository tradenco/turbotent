<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/quotes', name: 'app.quotes.')]
class QuotesController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('quotes/index.html.twig');
            ;
    }

    #[Route('/new', name: 'list')]
    public function add():response
    {
        return $this->render('quotes/add.html.twig');
    }
}
