<?php

namespace App\Controller;

use App\Service\IrontecLdap;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use \Gesdinet\JWTRefreshTokenBundle\Entity\RefreshToken as RefreshTokenEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[Route('/api')]
class LoginController extends AbstractController
{
    const PARAM_EXP      = 'exp';
    const PARAM_USERNAME = '_username';
    const PARAM_PASSWORD = '_password';

    /**
     * @var JWTEncoderInterface
     */
    private JWTEncoderInterface $jwtEncoder;

    /**
     * @var ContainerBagInterface
     */
    private ContainerBagInterface $parameters;


    #[Route('/login', name: 'app_login', methods: ['POST'])]
    public function login(
        Request $request,
//        IrontecLdap $ldap,
//        UserPasswordEncoderInterface $userPasswordEncoder,
        JWTEncoderInterface $jwtEncoder,
        ContainerBagInterface $parameters
    ): JsonResponse
    {

        var_dump('asdfasd');die;

        $this->jwtEncoder = $jwtEncoder;
        $this->parameters = $parameters;

        $username    = $request->request->get(self::PARAM_USERNAME, false);
        $password = $request->request->get(self::PARAM_PASSWORD, false);

//        /**
//         * @var UserEntity $user
//         */
//        $user = $userRepository->findOneByEmail($email);
//        if (empty($user)) {
//            throw new \LogicException('user.not_found', 404);
//        }
//
//        if ($user->getEnabled() === false) {
//            throw new \LogicException('user.not_enabled', 404);
//        }
//
//        $isValid = $userPasswordEncoder->isPasswordValid($user, $password);
        $isValid = true;

        if ($isValid === false) {
            throw new \LogicException('login.invalid.credentials', 401);
        }

        $refreshTokenEntity = $this->refreshToken($username, $parameters);

        return $this->json(
            array(
                'token'         => $this->getToken($username),
                'refresh_token' => $refreshTokenEntity->getRefreshToken()
            )
        );

    }

    /**
     * Genera y relaciona un token unico para actualizar el token de autenticación
     *
     * @param string $username nombre de usuario
     * @param ContainerBagInterface $parameters parametros del proyecto para obtener el tiempo de valides del refresh token
     * @return RefreshTokenEntity
     */
    private function refreshToken(
        string $username,
        ContainerBagInterface $parameters
    ): RefreshTokenEntity
    {

        /**
         * @var RefreshTokenEntity $refreshTokenEntity
         */
//        $refreshTokenEntity = $this->getDoctrine()
//            ->getRepository(RefreshTokenEntity::class)
//            ->findOneByUsername($username);

        if (empty($refreshTokenEntity)) {
            $refreshTokenEntity = new RefreshTokenEntity();
            $refreshTokenEntity->setUsername($username);
        }

        $refreshTokenEntity->setRefreshToken();

        $refreshToken = $parameters->get('jwt_refresh_ttl');

        $timeValid = new \DateTime('now', new \DateTimeZone('UTC'));
        $timeValid->modify('+' . $refreshToken . ' second');

        $refreshTokenEntity->setValid($timeValid);

//        $em = $this->getDoctrine()->getManager();
//        $em->persist($refreshTokenEntity);
//        $em->flush();

        return $refreshTokenEntity;

    }

    /**
     * Este metodo genera el token de autenticación que se usara en todas las peticiones
     *
     * @param string $user
     * @return string Token de autenticación
     */
    private function getToken(string $username): string
    {

        $encode = array(
            self::PARAM_USERNAME => $username,
            self::PARAM_EXP      => $this->getTokenExpiryDateTime()
        );

        return $this->jwtEncoder->encode($encode);

    }

    /**
     * Returns token expiration datetime.
     *
     * @return int
     */
    private function getTokenExpiryDateTime(): int
    {

        $tokenTtl = $this->parameters->get('lexik_jwt_authentication.token_ttl');

        $now = new \DateTime();
        $now->add(new \DateInterval('PT' . $tokenTtl . 'S'));

        return $now->format('U');

    }
}
