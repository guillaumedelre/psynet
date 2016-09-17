<?php
/**
 * Created by PhpStorm.
 * User: gdelre
 * Date: 25/08/16
 * Time: 19:02
 */

namespace AppBundle\Entity\Directory;

use Doctrine\ORM\Mapping AS ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Class Diploma
 * @package AppBundle\Entity
 *
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\Directory\DiplomaRepository")
 * @ORM\Table(name="diploma")
 */
class Diploma extends AbstractDirectory
{
    use TimestampableEntity;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
