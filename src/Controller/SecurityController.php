<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserConnection;
use App\Repository\UserConnectionRepository;
use App\Service\MessageService;
use Doctrine\Persistence\ManagerRegistry;
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
    public function second_factor(Request $request, ManagerRegistry $managerRegistry, UserConnectionRepository $userConnectionRepository)
    {
        /**
         * Generate OTP
         * Add user connection try in the journal
         */
        $user = $this->getUser();
        if (is_null($user)) {
            return $this->redirectToRoute("app_login");
        }
        $person = null;
        if($user instanceof User){
            $person  = $user->getPerson();
        }
        
        if (is_null($person)) {
            return $this->redirectToRoute("app_login");
        }
        if ($request->getMethod() == "POST") {
            $otp = $request->get("otp");
            $error_code = null;
            if (is_null($otp)) {
                $error_code = "ERROR_EMPTY_OTP";
            }
            $userConnection = $userConnectionRepository->findOneBy([
                'owner' => $user 
            ], ["id" => "DESC"]);
            if ($userConnection->getVerificationCode() == $otp) return $this->redirectToRoute("admin");
            $error_code = "ERROR_INVALID_OTP";
            return $this->render("login/second_factor.html.twig", [
                'ea' => null,
                'error_code' => $error_code
            ]);
        }
        $userConnection = new UserConnection();
        $userConnection->setOwner($user);
        $userConnection->setReason("CONNECTION_TRY");
        $userConnection->setConnexionDate(new \DateTimeImmutable());
        $verification_code = random_int(100000, 999999);
        $userConnection->setVerificationCode($verification_code);
        $manager = $managerRegistry->getManager();
        $manager->persist($userConnection);
        $manager->flush();
        /**
         * Send the OTP by SMS
         */

        MessageService::sendMessageByOrange("Votre code de vérification est: $verification_code. Si vous n'avez pas fait cette tentative de connexion veuillez ignorer ce message", $person->getPhone());
        return $this->render("login/second_factor.html.twig", [
            'ea' => null,
            'error_code' => null
        ]);
    }
}
