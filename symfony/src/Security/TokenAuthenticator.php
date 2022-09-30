<?php

namespace App\Security;

use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Token\PostAuthenticationGuardToken;

use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\LcobucciJWTEncoder;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Authentication\Token\PreAuthenticationJWTUserToken;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Guard\JWTTokenAuthenticator;
use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\AuthorizationHeaderTokenExtractor;

Use \App\Repository\UserRepository;


class TokenAuthenticator extends JWTTokenAuthenticator
{

    const MSG_ERROR_CREDENTIALS_INVALID = 'login.invalid.credentials';

    /**
     * @var CannotDecodeContent
     */
    private LcobucciJWTEncoder $jwtEncoder;

    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * @var int
     */
    private int $jwtTokenTTL;

    /**
     * @var TokenStorage
     */
    private TokenStorage $preAuthenticationTokenStorage;

    public function __construct(
        JWTEncoderInterface $jwtEncoder,
        UserRepository $userRepository,
        ContainerBagInterface $parameters
    )
    {
        $this->jwtEncoder = $jwtEncoder;
        $this->userRepository = $userRepository;
        $this->jwtTokenTTL = $parameters->get('lexik_jwt_authentication.token_ttl');
        $this->preAuthenticationTokenStorage = new TokenStorage();
    }

    /**
     * {@inheritDoc}
     * @see \Symfony\Component\Security\Guard\AuthenticatorInterface::getCredentials()
     */
    public function getCredentials(Request $request): PreAuthenticationJWTUserToken
    {

        $token = (new AuthorizationHeaderTokenExtractor('Bearer', 'Authorization'))->extract($request);
        if ($token === false) {
            throw new \LogicException(Response::$statusTexts[Response::HTTP_UNAUTHORIZED], Response::HTTP_UNAUTHORIZED);
        }

        return new PreAuthenticationJWTUserToken($token);

    }

    /**
     * {@inheritDoc}
     * @see \Symfony\Component\Security\Guard\AuthenticatorInterface::getUser()
     */
    public function getUser(
        $credentials,
        UserProviderInterface $userProvider
    ): UserInterface
    {

        $this->preAuthenticationTokenStorage->setToken($credentials);

        try {
            $data = $this->jwtEncoder->decode($credentials->getCredentials());
        } catch (\Exception $e) {
            throw new \LogicException(self::MSG_ERROR_CREDENTIALS_INVALID, Response::HTTP_UNAUTHORIZED);
        }

        if ($data === false) {
            throw new \LogicException(self::MSG_ERROR_CREDENTIALS_INVALID, Response::HTTP_UNAUTHORIZED);
        }

        $username = $data['username'];

        return $this->userRepository->findOneByUsername($username);

    }

    /**
     * {@inheritDoc}
     * @see \Symfony\Component\Security\Guard\AuthenticatorInterface::checkCredentials()
     */
    public function checkCredentials($credentials, UserInterface $user): bool
    {

        $decode = $this->jwtEncoder->decode($credentials->getCredentials());

        if (
            $decode['exp'] >= (new \DateTime('now', new \DateTimeZone('UTC')))->format('U')
            &&
            $decode['username'] === $user->getUsername()
        ) {
            return true;
        }

        return false;

    }

    /**
     * {@inheritDoc}
     * @see \Symfony\Component\Security\Guard\AuthenticatorInterface::onAuthenticationFailure()
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        throw new \LogicException(self::MSG_ERROR_CREDENTIALS_INVALID, Response::HTTP_UNAUTHORIZED);
    }

    /**
     * {@inheritDoc}
     * @see \Symfony\Component\Security\Guard\AuthenticatorInterface::onAuthenticationSuccess()
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return null;
    }

    /**
     * {@inheritDoc}
     * @see \Symfony\Component\Security\Guard\AuthenticatorInterface::supportsRememberMe()
     */
    public function supportsRememberMe(): bool
    {
        return false;
    }

    /**
     * {@inheritDoc}
     * @see \Lexik\Bundle\JWTAuthenticationBundle\Security\Guard\JWTTokenAuthenticator::start()
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        throw new \LogicException(self::MSG_ERROR_CREDENTIALS_INVALID, Response::HTTP_UNAUTHORIZED);
    }

    /**
     * {@inheritDoc}
     * @see \Symfony\Component\Security\Guard\AuthenticatorInterface::supports()
     */
    public function supports(Request $request)
    {
        return true;
    }

    /**
     * {@inheritDoc}
     * @see \Lexik\Bundle\JWTAuthenticationBundle\Security\Guard\JWTTokenAuthenticator::createAuthenticatedToken()
     */
    public function createAuthenticatedToken(UserInterface $user, $providerKey): PostAuthenticationGuardToken
    {
        return new PostAuthenticationGuardToken($user, $providerKey, $user->getRoles());
    }

    /**
     * Returns token expiration datetime.
     *
     * @return int
     */
    public function getTokenExpiryDateTime(): int
    {

        $now = new \DateTime('now', new \DateTimeZone('UTC'));
        $now->add(new \DateInterval('PT' . $this->jwtTokenTTL . 'S'));

        return $now->format('U');

    }

}
