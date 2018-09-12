<?php

namespace App\Security;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Response;

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{
    private $userRepository;
    private $router;
    private $passwordEncoder;

    public function __construct(UserRepository $userRepository, RouterInterface $router, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->userRepository = $userRepository;
        $this->router = $router;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function supports(Request $request)
    {
        return $request->attributes->get('_route') === 'login' && $request->isMethod('POST');
    }

    public function getCredentials(Request $request) : array
    {
        return array('username' => $request->request->get('_username'), 'password' => $request->request->get('_password'));
    }

    public function getUser($credentials, UserProviderInterface $userProvider) : User
    {
        return $this->userRepository->findOneBy(array('username' => $credentials['username']));
    }

    public function checkCredentials($credentials, UserInterface $user) : bool
    {
        $password = $credentials['password'];

        if ($this->passwordEncoder->isPasswordValid($user, $password)) {
            return true;
        }
        return false;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey) : RedirectResponse
    {
        return new RedirectResponse($this->router->generate('homepage'));
    }

    public function getLoginUrl() : string
    {
        return $this->router->generate('login');
    }
}
