<?php
/**
 * Created by PhpStorm.
 * User: gdelre
 * Date: 27/08/16
 * Time: 12:02
 */

namespace AppBundle\Service;


use Doctrine\Bundle\DoctrineBundle\Registry;

class PostService
{
    /** @var Registry */
    protected $doctrine;

    /**
     * PostService constructor.
     * @param Registry $doctrine
     */
    public function __construct(Registry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @param $entityName
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    public function getRepository($entityName)
    {
        return $this->doctrine->getManager()->getRepository($entityName);
    }

    /**
     * @param $postTypeName
     * @return mixed
     */
    public function findByPostTypeName($postTypeName)
    {
        $newsPostType = $this->getRepository('AppBundle:PostType')->findOneByName($postTypeName);
        return $this->getRepository('AppBundle:Post')->findByType($newsPostType);
    }
}