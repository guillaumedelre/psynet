<?php

namespace Application\DataFixtures\ORM;

use AppBundle\Entity\Category;
use AppBundle\Entity\Post;
use AppBundle\Entity\PostType;
use AppBundle\Entity\Route;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\ORM\EntityRepository;
use Faker\Factory;
use Faker\Generator;
use Gedmo\Sluggable\Util\Urlizer;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadFixtures extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var Generator
     */
    private $faker;

    /**
     * Load data fixtures with the passed EntityManager
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->faker = Factory::create();

        $this->loadUser();
        $this->loadRoute();
        $this->loadCategory();
        $this->loadPostType();
        $this->loadPost();
    }

    /**
     * Sets the container.
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Get the order of this fixture
     * @return integer
     */
    public function getOrder()
    {
        return 1;
    }

    public function loadUser()
    {
        $userManager = $this->container->get('fos_user.user_manager');
        $user = $userManager->createUser();
        $user->setFirstname('Jean Louis');
        $user->setLastname('Phitoul');
        $user->setUsername('admin');
        $user->setEmail('admin@psynet.com');
        $user->setPlainPassword('admin');
        $user->setEnabled(true);
        $user->addRole('ROLE_SUPER_ADMIN');
        $userManager->updateUser($user);

        $user = $userManager->createUser();
        $user->setFirstname('Michaël');
        $user->setLastname('Paquito');
        $user->setUsername('student');
        $user->setEmail('student@psynet.com');
        $user->setPlainPassword('student');
        $user->setEnabled(true);
        $user->addRole('ROLE_STUDENT');
        $userManager->updateUser($user);

        $user = $userManager->createUser();
        $user->setFirstname('Eugène');
        $user->setLastname('Mostri');
        $user->setUsername('pro');
        $user->setEmail('pro@psynet.com');
        $user->setPlainPassword('pro');
        $user->setEnabled(true);
        $user->addRole('ROLE_PRO');
        $userManager->updateUser($user);
    }

    public function loadRoute()
    {
        /**
         * @var string $name
         * @var \Symfony\Component\Routing\Route $route
         */
        foreach ($this->container->get('router')->getRouteCollection()->all() as $name => $route) {
            $newRoute = new Route();
            $newRoute->setName($name);
            $newRoute->setPath($route->getPath());
            $this->save($newRoute);
        }
    }

    public function loadCategory()
    {
        /** @var EntityRepository $repo */
        $repo = $this->container->get('doctrine.orm.entity_manager')->getRepository('AppBundle:Route');

        /** @var Route $route */
        $route = $repo->findOneByName('homepage');
        if (null !== $route) {
            $category = new Category();
            $category->setLabel('L\'association');
            $category->setRoute($route);
            $category->setPosition(0);
            $this->save($category);
        }

        $route = $repo->findOneByName('calendar');
        if (null !== $route) {
            $category = new Category();
            $category->setLabel('Calendrier');
            $category->setRoute($route);
            $category->setPosition(1);
            $this->save($category);
        }

        $route = $repo->findOneByName('news');
        if (null !== $route) {
            $category = new Category();
            $category->setLabel('Actualités');
            $category->setRoute($route);
            $category->setPosition(2);
            $this->save($category);
        }

        $route = $repo->findOneByName('faq');
        if (null !== $route) {
            $category = new Category();
            $category->setLabel('FAQ');
            $category->setRoute($route);
            $category->setPosition(3);
            $this->save($category);
        }

        $route = $repo->findOneByName('project');
        if (null !== $route) {
            $category = new Category();
            $category->setLabel('Projets');
            $category->setRoute($route);
            $category->setPosition(4);
            $this->save($category);
        }

        $route = $repo->findOneByName('directory');
        if (null !== $route) {
            $category = new Category();
            $category->setLabel('Annuaires');
            $category->setRoute($route);
            $category->setPosition(5);
            $this->save($category);
        }

        $route = $repo->findOneByName('helpus');
        if (null !== $route) {
            $category = new Category();
            $category->setLabel('Contribuez!');
            $category->setRoute($route);
            $category->setPosition(6);
            $this->save($category);
        }

        $route = $repo->findOneByName('contact');
        if (null !== $route) {
            $category = new Category();
            $category->setLabel('Contact');
            $category->setRoute($route);
            $category->setPosition(7);
            $this->save($category);
        }
    }

    public function loadPostType()
    {
        $type = new PostType();
        $type->setName('news');
        $this->save($type);

        $type = new PostType();
        $type->setName('project');
        $this->save($type);

        $type = new PostType();
        $type->setName('faq');
        $this->save($type);
    }

    public function loadPost()
    {
        /** @var EntityRepository $repo */
        $repo = $this->container->get('doctrine.orm.entity_manager')->getRepository('AppBundle:PostType');

        $newsType= $repo->findOneByName('news');
        for ($i=0; $i<5; $i++) {
            $post = new Post();
            $post->setTitle(implode(' ', $this->faker->words(24)));
            $post->setType($newsType);
            $post->setSlug(Urlizer::transliterate($post->getTitle()));
            $post->setHeadline(implode(' ', $this->faker->paragraphs($this->faker->randomElement([2, 5, 7, 9]))));
            $post->setContent(implode(' ', $this->faker->paragraphs($this->faker->randomElement([20, 30, 40, 50]))));
            $post->setPublished($this->faker->boolean());
            $post->setImageUrl("https://placeimg.com/1024/64$i/any");
            $this->save($post);
        }

        $projectType= $repo->findOneByName('project');
        for ($i=0; $i<5; $i++) {
            $post = new Post();
            $post->setTitle(implode(' ', $this->faker->words(24)));
            $post->setType($projectType);
            $post->setSlug(Urlizer::transliterate($post->getTitle()));
            $post->setHeadline(implode(' ', $this->faker->paragraphs($this->faker->randomElement([2, 5, 7, 9]))));
            $post->setContent(implode(' ', $this->faker->paragraphs($this->faker->randomElement([20, 30, 40, 50]))));
            $post->setPublished($this->faker->boolean());
            $post->setImageUrl("https://placeimg.com/1024/64$i/any");
            $this->save($post);
        }

        $faqType= $repo->findOneByName('faq');
        for ($i=0; $i<5; $i++) {
            $post = new Post();
            $post->setTitle(implode(' ', $this->faker->words(24)));
            $post->setType($faqType);
            $post->setSlug(Urlizer::transliterate($post->getTitle()));
            $post->setHeadline(implode(' ', $this->faker->paragraphs($this->faker->randomElement([2, 5, 7, 9]))));
            $post->setContent(implode(' ', $this->faker->paragraphs($this->faker->randomElement([20, 30, 40, 50]))));
            $post->setPublished($this->faker->boolean());
            $post->setImageUrl("https://placeimg.com/1024/64$i/any");
            $this->save($post);
        }
    }

    /**
     * @param $entity
     */
    private function save($entity)
    {
        $em = $this->container->get('doctrine')->getManager();
        $em->persist($entity);
        $em->flush();
    }
}