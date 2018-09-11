<?php

namespace App\Security;

use Sensio\Bundle\FrameworkExtraBundle\Tests\Request\ParamConverter\TestUserRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{
    private $testUserRepository;

    private $router;

    public function __construct(TestUserRepository $testUserRepository, RouterInterface $router)
    {
        $this->testUserRepository = $testUserRepository;
        $this->router = $router;
    }

    public function supports(Request $request)
    {
        return $request->attributes->get('_route') === 'login' && $request->isMethod('POST');
    }

    public function getCredentials(Request $request)
    {
        return array('email' => $request->request->get('email'), 'password' => $request->request->get('password'));
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        return $this->testUserRepository->findOneBy(array('email' => $credentials['email']));
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        new RedirectResponse($this->router->generate('homepage'));
    }

    public function getLoginUrl()
    {
        new RedirectResponse($this->router->generate('login'));
    }
}
