<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[route('/vitrine', name: 'app.vitrine.')]
class VitrineController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('vitrine/index.html.twig');
    }

    #[Route('/contact', name: 'contact')]
    public function contact(Request $request): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if (str_contains($request->headers->get('Accept'), 'text/vnd.turbo-stream.html')) {
                return new Response($this->renderView('partials/_success.stream.html.twig'));
            }

            $this->addFlash('success', 'je vous recontacte très bientôt');
            return $this->redirectToRoute(route: 'app.vitrine.index', status: Response::HTTP_SEE_OTHER);
        }

        // premiere methode
        /*if ($form->isSubmitted() && !$form->isValid()) {
            $content = $this->renderView('vitrine/contact.html.twig', [
                'form' => $form->createView()
            ]);
            return new Response(content: $content, status: Response::HTTP_UNPROCESSABLE_ENTITY );
        }*/

        //seconde methode
        /*if ($form->isSubmitted() && !$form->isValid()) {
            return $this->render('vitrine/contact.html.twig', [
                'form' => $form->createView()
            ],
                (new Response)->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY)
            );
        }*/

        // troisième methode
        $response = new Response(null, $form->isSubmitted() && !$form->isValid() ? Response::HTTP_UNPROCESSABLE_ENTITY : Response::HTTP_OK);
        return $this->render('vitrine/contact.html.twig', ['form' => $form->createView()], $response);
    }

    #[Route('/about', name: 'about')]
    public function about(): Response
    {
        return $this->render('vitrine/about.html.twig');
    }
}
