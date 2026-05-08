<?php

declare(strict_types=1);

namespace App\Account\Controller;

use App\Account\DTO\RegistrationRequest;
use App\Account\Handler\AccountHandler;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RegisterController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, AccountHandler $accountHandler): Response
    {
        $registrationRequest = new RegistrationRequest();
        $form = $this->createForm(RegistrationFormType::class, $registrationRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $accountHandler->handleRegistration($registrationRequest);

            return $this->redirectToRoute('app_login');
        }

        return $this->render('auth/register.html.twig', [
            'form' => $form,
        ]);
    }
}
