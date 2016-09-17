<?php
/**
 * Created by PhpStorm.
 * User: gdelre
 * Date: 25/08/16
 * Time: 14:51
 */

namespace AppBundle\Service\Menu;

use AppBundle\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class MenuBuilder
{
    /** @var TokenStorageInterface */
    private $tokenStorage;

    /** @var Translator */
    private $translator;

    /** @var Registry */
    private $doctrine;

    /**
     * MenuBuilder constructor.
     *
     * @param TokenStorageInterface $tokenStorage
     * @param Translator $translator
     * @param Registry $doctrine
     */
    public function __construct(TokenStorageInterface $tokenStorage, Translator $translator, Registry $doctrine)
    {
        $this->tokenStorage = $tokenStorage;
        $this->translator = $translator;
        $this->doctrine = $doctrine;
    }

    /**
     * Return the menu for the connected user
     *
     * @return \AppBundle\Entity\Category[]|array|void
     */
    public function buildMenu()
    {
        /** @var User $currentUser */
        $currentUser = $this->tokenStorage->getToken()->getUser();

        if (!is_string($currentUser)) {
            $roles = $currentUser->getRoles();
            switch (reset($roles)) {
                case 'ROLE_STUDENT':
                    $result = $this->studentMainMenu();
                    break;
                case 'ROLE_PRO':
                    $result = $this->proMainMenu();
                    break;
                case 'ROLE_SUPER_ADMIN':
                    $result = $this->adminMainMenu();
                    break;
            }
        } else {
            $result = $this->publicMainMenu();
        }

        return $result;
    }

    private function studentMainMenu()
    {
        return $this->publicMainMenu();
    }

    private function proMainMenu()
    {
        return $this->publicMainMenu();
    }

    private function adminMainMenu()
    {
        return $this->publicMainMenu();
    }

    /**
     * @return \AppBundle\Entity\Category[]|array
     */
    private function publicMainMenu()
    {
        return $this->doctrine
            ->getManager()
            ->getRepository('AppBundle:Category')
            ->findBy(['parent' => null], ['position' => 'ASC'])
            ;
    }
}