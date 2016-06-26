<?php

namespace GoogleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\HttpFoundation\Request;

class GoogleController extends Controller
{
    public function callbackAction(Request $request)
    {
        if ($request->query->get('error')) {
            return $this->render('GoogleBundle::callback.html.twig');
        }

        if ($request->query->get('code')) {
            $client = $this->get('happyr.google.api.client');

            try {
                $client->authenticate($request->query->get('code'));
            } catch (\Google_Auth_Exception $e) {
                return $this->render('GoogleBundle::callback.html.twig');
            }

            $accessToken = $client->getAccessToken();
            //die(var_dump($accessToken));
            $this->securityContext = $this->get('security.token_storage');

            $token = $this->securityContext->getToken();
            $token = new PreAuthenticatedToken(
                $accessToken,
                $token->getCredentials(),
                $token->getProviderKey(),
                ['ROLE_HAS_TOKEN']
            );
            $this->securityContext->setToken($token);
        }

        return $this->redirect($this->generateUrl('app.list_google_index'));
    }

    public function disconnectAction()
    {
        $security = $this->get('security.token_storage');
        //$security = $this->get('security.context');
        $security->setToken(null);
        $this->get('session')->invalidate();

        return $this->redirect($this->generateUrl('app.index'));
    }
}
