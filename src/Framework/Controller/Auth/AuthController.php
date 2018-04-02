<?php

namespace DevPledge\Framework\Controller\Auth;


use DevPledge\Domain\Permissions\Action;
use DevPledge\Domain\Permissions\Permissions;
use DevPledge\Domain\Permissions\Resource;
use DevPledge\Integrations\Security\JWT\JWT;
use DevPledge\Integrations\Security\JWT\Token;
use Slim\Http\Request;
use Slim\Http\Response;
use TomWright\JSON\Exception\JSONEncodeException;


class AuthController
{

    /**
     * @var JWT
     */
    private $jwt;

    /**
     * AuthController constructor.
     *
     * @param JWT $jwt
     */
    public function __construct(JWT $jwt)
    {
        $this->jwt = $jwt;
    }

    /**
     * @param Request $request
     * @param Response $response
     *
     * @return Response
     */
    public function login(Request $request, Response $response)
    {
        $data = $request->getParsedBody();

        $username = $data['username'] ?? null;
        $password = $data['password'] ?? null;

        if ($username === 'tom' && $password === 'password') {
            try {
                $token = $this->jwt->generate((object)[
                    'name' => 'Tommy Bum Bum',
                    'username' => $username,
                    'perms' => $this->createWildcardPermissions(),
                ]);

                return $response->withJson(['token' => $token]);
            } catch (JSONEncodeException $e) {
                return $response->withJson(['error' => 'Could not generate token'], 500);
            }
        } else {
            return $response->withJson(['error' => 'Invalid username or password'], 401);
        }
    }

    /**
     * @param Request $request
     * @param Response $response
     *
     * @return Response
     */
    public function refresh(Request $request, Response $response)
    {
        /**
         * @var Token $token
         */
        $token = $request->getAttribute(Token::class);

        try {
            $newToken = $this->jwt->generate($token->getData());
        } catch (JSONEncodeException $e) {
            return $response->withJson(['error' => 'Could not generate token'], 500);
        }

        return $response->withJson(['token' => $newToken]);
    }

    /**
     * @param Request $request
     * @param Response $response
     *
     * @return Response
     */
    public function outputTokenPayload(Request $request, Response $response)
    {
        /**
         * @var Token $token
         */
        $token = $request->getAttribute(Token::class);

        return $response->withJson(['payload' => $token->getData()]);
    }

    /**
     * Generates a permissions object that gives access to all
     * actions on all known resources.
     *
     * @return Permissions
     */
    private function createWildcardPermissions(): Permissions
    {
        $p = new Permissions();
        $p
            ->addResource((new Resource())
                ->setName('organisations')
                ->addAction((new Action())
                    ->setName('create'))
                ->addAction((new Action())
                    ->setName('read'))
                ->addAction((new Action())
                    ->setName('update'))
                ->addAction((new Action())
                    ->setName('delete')))
            ->addResource((new Resource())
                ->setName('members')
                ->addAction((new Action())
                    ->setName('create'))
                ->addAction((new Action())
                    ->setName('read'))
                ->addAction((new Action())
                    ->setName('update'))
                ->addAction((new Action())
                    ->setName('delete')))
            ->addResource((new Resource())
                ->setName('problem')
                ->addAction((new Action())
                    ->setName('create'))
                ->addAction((new Action())
                    ->setName('read'))
                ->addAction((new Action())
                    ->setName('update'))
                ->addAction((new Action())
                    ->setName('delete')))
            ->addResource((new Resource())
                ->setName('pledge')
                ->addAction((new Action())
                    ->setName('create'))
                ->addAction((new Action())
                    ->setName('read'))
                ->addAction((new Action())
                    ->setName('update'))
                ->addAction((new Action())
                    ->setName('delete')));

        return $p;
    }

}