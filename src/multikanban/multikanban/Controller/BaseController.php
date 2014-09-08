<?php

namespace multikanban\multikanban\Controller;

use Silex\Application as SilexApplication;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\HttpFoundation\Request;
use multikanban\multikanban\Application;
use multikanban\multikanban\Model\User;
use multikanban\multikanban\Model\Kanban;
use multikanban\multikanban\Model\Task;
use multikanban\multikanban\Model\Stats;
// use multikanban\multikanban\Repository\UserRepository;
// use multikanban\multikanban\Repository\ProgrammerRepository;
// use multikanban\multikanban\Repository\ProjectRepository;
// use multikanban\multikanban\Security\Token\ApiTokenRepository;

/**
 * Base controller class to hide Silex-related implementation details
 */
abstract class BaseController implements ControllerProviderInterface
{
    /**
     * @var \multikanban\multikanban\Application
     */
    protected $container;

    public function __construct(Application $app)
    {
        $this->container = $app;
    }

    abstract protected function addRoutes(ControllerCollection $controllers);

    public function connect(SilexApplication $app)
    {
        $controllers = $app['controllers_factory'];

        $this->addRoutes($controllers);

        return $controllers;
    }

    /**
     * Is the current user logged in?
     *
     * @return boolean
     */
    public function isUserLoggedIn()
    {
        return $this->container['security']->isGranted('IS_AUTHENTICATED_FULLY');
    }

    /**
     * @return User|null
     */
    public function getLoggedInUser()
    {
        if (!$this->isUserLoggedIn()) {
            return;
        }

        return $this->container['security']->getToken()->getUser();
    }

    /**
     * @param  string $routeName  The name of the route
     * @param  array  $parameters Route variables
     * @param  bool   $absolute
     * @return string A URL!
     */
    public function generateUrl($routeName, array $parameters = array(), $absolute = false)
    {
        return $this->container['url_generator']->generate(
            $routeName,
            $parameters,
            $absolute
        );
    }

    /**
     * @param  string           $url
     * @param  int              $status
     * @return RedirectResponse
     */
    public function redirect($url, $status = 302)
    {
        return new RedirectResponse($url, $status);
    }

    /**
     * Logs this user into the system
     *
     * @param User $user
     */
    public function loginUser(User $user)
    {
        $token = new UsernamePasswordToken($user, $user->getPassword(), 'main', $user->getRoles());

        $this->container['security']->setToken($token);
    }

    /**
     * Used to find the fixtures user - I use it to cheat in the beginning
     *
     * @param $username
     * @return User
     */
    public function findUserByUsername($username)
    {
        return $this->getUserRepository()->findUserByUsername($username);
    }

    /**
     * Shortcut for saving objects
     *
     * @param $obj
     */
    public function save($obj)
    {
        switch (true) {
            case ($obj instanceof Programmer):
                $this->getProgrammerRepository()->save($obj);
                break;
            default:
                throw new \Exception(sprintf('Shortcut for saving "%s" not implemented', get_class($obj)));
        }
    }

    /**
     * Shortcut for deleting objects
     *
     * @param $obj
     */
    public function delete($obj)
    {
        switch (true) {
            case ($obj instanceof Programmer):
                $this->getProgrammerRepository()->delete($obj);
                break;
            default:
                throw new \Exception(sprintf('Shortcut for saving "%s" not implemented', get_class($obj)));
        }
    }

    public function throw404($message = 'Page not found')
    {
        throw new NotFoundHttpException($message);
    }

    /**
     * @param $obj
     * @return array
     */
    public function validate($obj)
    {
        return $this->container['api.validator']->validate($obj);
    }

    // /**
    //  * @return UserRepository
    //  */
    // protected function getUserRepository()
    // {
    //     return $this->container['repository.user'];
    // }

    // /**
    //  * @return ProgrammerRepository
    //  */
    // protected function getProgrammerRepository()
    // {
    //     return $this->container['repository.programmer'];
    // }

    // /**
    //  * @return ProjectRepository
    //  */
    // protected function getProjectRepository()
    // {
    //     return $this->container['repository.project'];
    // }

    // /**
    //  * @return  
    //  * multikanban\multikanban\Repository\BattleRepository
    //  */ 
    // protected function getBattleRepository()
    // {
    //     return $this->container['repository.battle'];
    // }

    // /**
    //  * @return \multikanban\multikanban\Battle\BattleManager
    //  */
    // protected function getBattleManager()
    // {
    //     return $this->container['battle.battle_manager'];
    // }

    // /**
    //  * @return ApiTokenRepository
    //  */
    // protected function getApiTokenRepository()
    // {
    //     return $this->container['repository.api_token'];
    // }

}
