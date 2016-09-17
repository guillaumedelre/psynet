<?php
/**
 * Created by PhpStorm.
 * User: gdelre
 * Date: 26/08/16
 * Time: 17:38
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Post
 * @package AppBundle\Entity
 *
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\PostRepository")
 * @ORM\Table(name="post")
 */
class Post
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
     * @var PostType
     *
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\PostType", inversedBy="posts")
     * @ORM\JoinColumn(name="post_type_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $type;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\Type("string")
     */
    protected $title;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Gedmo\Slug(fields={"title"})
     * @Assert\Type("string")
     */
    protected $slug;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     * @Assert\Type("string")
     */
    protected $headline;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     * @Assert\Type("string")
     */
    protected $content;

    /**
     * @var string
     *
     * @ORM\Column(name="image_url", type="string")
     * @Assert\Type("string")
     */
    protected $imageUrl;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     * @Assert\Type("bool")
     */
    protected $published;

    /**
     * @var Category[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="\AppBundle\Entity\Post", mappedBy="parent")
     */
    protected $children;

    /**
     * @var null|Category
     *
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Post", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     */
    protected $parent = null;

    /**
     * @var Category[]|ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="\AppBundle\Entity\Category", cascade={"persist"})
     */
    protected $categories;

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
     * Set title
     *
     * @param string $title
     *
     * @return Post
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Post
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
     * Set headline
     *
     * @param string $headline
     *
     * @return Post
     */
    public function setHeadline($headline)
    {
        $this->headline = $headline;

        return $this;
    }

    /**
     * Get headline
     *
     * @return string
     */
    public function getHeadline()
    {
        return $this->headline;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Post
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set imageUrl
     *
     * @param string $imageUrl
     *
     * @return Post
     */
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    /**
     * Get imageUrl
     *
     * @return string
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * Set published
     *
     * @param boolean $published
     *
     * @return Post
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return boolean
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Set type
     *
     * @param \AppBundle\Entity\PostType $type
     *
     * @return Post
     */
    public function setType(\AppBundle\Entity\PostType $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \AppBundle\Entity\PostType
     */
    public function getType()
    {
        return $this->type;
    }

    public function __toString()
    {
        return $this->getTitle();
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add child
     *
     * @param \AppBundle\Entity\Post $child
     *
     * @return Post
     */
    public function addChild(\AppBundle\Entity\Post $child)
    {
        $this->children[] = $child;

        return $this;
    }

    /**
     * Remove child
     *
     * @param \AppBundle\Entity\Post $child
     */
    public function removeChild(\AppBundle\Entity\Post $child)
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
     * @param \AppBundle\Entity\Post $parent
     *
     * @return Post
     */
    public function setParent(\AppBundle\Entity\Post $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \AppBundle\Entity\Post
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add category
     *
     * @param \AppBundle\Entity\Category $category
     *
     * @return Post
     */
    public function addCategory(\AppBundle\Entity\Category $category)
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param \AppBundle\Entity\Category $category
     */
    public function removeCategory(\AppBundle\Entity\Category $category)
    {
        $this->categories->removeElement($category);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }
}
