<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

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
        $form = $this->createFormBuilder()
            ->add('name', TextType::class, [
                    'constraints' => [new NotBlank(), new Length(min: 2, max: 100)]
                ]
            )
            ->add('email', EmailType::class, [
                'attr' => ['placeholder' => 'Email'],
                'constraints' => [new NotBlank(), new Email()]
            ])
            ->add('message', TextareaType::class, [
                'attr' => ['placeholder' => 'Message'],
                'constraints' => [new NotBlank(), new Length(min: 5)]
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dump($form->getData());
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
        return $this->render('vitrine/contact.html.twig', [
            'form' => $form->createView()
        ],
            $response
        );
    }

    #[Route('/about', name: 'about')]
    public function about(): Response
    {
        return $this->render('vitrine/about.html.twig');
    }
}
