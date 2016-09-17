<?php
/**
 * Created by PhpStorm.
 * User: gdelre
 * Date: 26/08/16
 * Time: 17:25
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Category
 * @package AppBundle\Entity
 *
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\CategoryRepository")
 * @ORM\Table(name="category")
 */
class Category
{
    use TimestampableEntity;

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @Assert\Type("integer")
     * @Assert\GreaterThanOrEqual(0)
     */
    protected $position;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\Type("string")
     */
    protected $label;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Gedmo\Slug(fields={"label"})
     * @Assert\Type("string")
     */
    protected $slug;

    /**
     * @var Route
     *
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Route", inversedBy="categories")
     * @ORM\JoinColumn(name="route_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $route;

    /**
     * @var boolean
     * @Assert\Type("bool")
     */
    protected $enabled;

    /**
     * @var Category[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="\AppBundle\Entity\Category", mappedBy="parent")
     */
    protected $children;

    /**
     * @var null|Category
     *
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Category", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     */
    protected $parent = null;

    /**
     * @var Post[]|ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="\AppBundle\Entity\Post", cascade={"persist"})
     */
    protected $posts;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
        $this->posts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set position
     *
     * @param integer $position
     *
     * @return Category
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set label
     *
     * @param string $label
     *
     * @return Category
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Category
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set route
     *
     * @param \AppBundle\Entity\Route $route
     *
     * @return Category
     */
    public function setRoute(\AppBundle\Entity\Route $route)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * Get route
     *
     * @return \AppBundle\Entity\Route
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Add child
     *
     * @param \AppBundle\Entity\Category $child
     *
     * @return Category
     */
    public function addChild(\AppBundle\Entity\Category $child)
    {
        $this->children[] = $child;

        return $this;
    }

    /**
     * Remove child
     *
     * @param \AppBundle\Entity\Category $child
     */
    public function removeChild(\AppBundle\Entity\Category $child)
    {
        $this->children->removeElement($child);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set parent
     *
     * @param \AppBundle\Entity\Category $parent
     *
     * @return Category
     */
    public function setParent(\AppBundle\Entity\Category $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \AppBundle\Entity\Category
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add post
     *
     * @param \AppBundle\Entity\Post $post
     *
     * @return Category
     */
    public function addPost(\AppBundle\Entity\Post $post)
    {
        $this->posts[] = $post;

        return $this;
    }

    /**
     * Remove post
     *
     * @param \AppBundle\Entity\Post $post
     */
    public function removePost(\AppBundle\Entity\Post $post)
    {
        $this->posts->removeElement($post);
    }

    /**
     * Get posts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPosts()
    {
        return $this->posts;
    }

    public function __toString()
    {
        return $this->getLabel();
    }
}
