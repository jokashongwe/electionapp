<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('@EasyAdmin/page/login.html.twig', [
            'error' => $error,
            'last_username' => $lastUsername,
            'translation_domain' => 'admin',
            'page_title' => '',
            'csrf_token_intention' => 'authenticate',
            'target_path' => $this->generateUrl('app_second_factor'),
            'username_label' => 'Téléphone/Numéro d\'ordre',
            'password_label' => 'Mot de passe',
            'sign_in_label' => 'Se connecter',
            'forgot_password_enabled' => true,
            'forgot_password_path' => '#',
            'forgot_password_label' => 'Mot de passe oublié ?',
            'remember_me_enabled' => false,
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout()
    {
        //nothing
    }

    #[Route('/verification_code', name: 'app_second_factor')]
    public function second_factor(Request $request)
    {
        //$ea = ["i18n" => ["translationDomain" => "fr", "htmlLocale" => "fr", "textDirection" => "right"]];
        return $this->render("login/second_factor.html.twig", [
            'ea' => null
        ]);
    }
}
