<?php

namespace GoogleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
            $client->authenticate($request->query->get('code'));
            $accessToken = $client->getAccessToken();
            $security = $this->get('security.token_storage');
            $token = $security->getToken();
            $token = new PreAuthenticatedToken(
                $accessToken,
                null, // or $token->getCredentials()
                $token->getProviderKey(),
                ['ROLE_OK']
            );

            $security->setToken($token);
        }

        return $this->redirect($this->generateUrl('app.list_google_index'));
    }

    public function disconnectAction()
    {
        $security = $this->get('security.token_storage');
        $security->setToken(null);

        return $this->redirect($this->generateUrl('app.index'));
    }
}
