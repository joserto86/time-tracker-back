<?php

namespace App\EventListener;

use Gesdinet\JWTRefreshTokenBundle\Event\RefreshAuthenticationFailureEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTExpiredEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTFailureEventInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\Routing\RouterInterface;


class RefreshTokenResponseListener
{
    private RouterInterface $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function onRefreshTokenFailureResponse(ResponseEvent $event)
    {
        $routeMatch = $this->router->getRouteCollection()->get('api_refresh_token');

        $request = $event->getRequest();
        $response = $event->getResponse();

        if ($request->getPathInfo() === $routeMatch->getPath() && $response->getStatusCode() === Response::HTTP_UNAUTHORIZED) {
            $response->setStatusCode(Response::HTTP_FORBIDDEN);
            $content = $response->getContent();
            $content = str_replace(Response::HTTP_UNAUTHORIZED, Response::HTTP_FORBIDDEN, $content);
            $response->setContent($content);

            $event->setResponse($response);
        }
    }
}
