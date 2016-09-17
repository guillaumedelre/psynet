<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/build-menu", name="buildMenu")
     */
    public function buildMenuAction(Request $request)
    {
        $menu = $this->get('app.menu.builder')->buildMenu();

        return $this->render('@App/common/topnav.html.twig', [
            'menu' => $menu,
        ]);
    }

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->render('@App/default/index.html.twig', [
            'title' => 'L\'association',
        ]);
    }

    /**
     * @Route("/calendar", name="calendar")
     */
    public function calendarAction(Request $request)
    {
        return $this->render('@App/default/calendar.html.twig', [
            'title' => 'Calendrier',
        ]);
    }

    /**
     * @Route("/news", name="news")
     */
    public function newsAction(Request $request)
    {
        return $this->render('@App/default/news.html.twig', [
            'title' => 'Actualités',
            'items' => $this->get('app.service.post')->findByPostTypeName('news'),
        ]);
    }

    /**
     * @Route("/faq", name="faq")
     */
    public function faqAction(Request $request)
    {
        return $this->render('@App/default/faq.html.twig', [
            'title' => 'FAQ',
            'items' => $this->get('app.service.post')->findByPostTypeName('faq'),
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contactAction(Request $request)
    {
        return $this->render('@App/default/index.html.twig', [
            'title' => 'Contact',
        ]);
    }

    /**
     * @Route("/directory", name="directory")
     */
    public function directoryAction(Request $request)
    {
        return $this->render('@App/default/directory.html.twig', [
            'title' => 'Annuaires',
        ]);
    }

    /**
     * @Route("/professionals", name="professionals")
     */
    public function professionalsAction(Request $request)
    {
        return $this->render('@App/default/professionals.html.twig', [
            'title' => 'Annuaire des professionels',
        ]);
    }

    /**
     * @Route("/help-us", name="helpus")
     */
    public function helpusAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('@App/default/index.html.twig', []);
    }

    /**
     * @Route("/project", name="project")
     */
    public function projectAction(Request $request)
    {
        return $this->render('@App/default/projects.html.twig', [
            'title' => 'Nos projets',
            'items' => $this->get('app.service.post')->findByPostTypeName('project'),
        ]);
    }

    /**
     * @Route("/project/{slug}", name="projectPage")
     */
    public function projectPageAction(Request $request, $slug)
    {
        return $this->render('@App/default/singlePost.html.twig', [
            'title' => 'Nos projets',
            'item' => $this->get('app.service.post')->getRepository('AppBundle:Post')->findOneBySlug($slug),
        ]);
    }

    /**
     * @Route("/news/{slug}", name="newsPage")
     */
    public function newsPageAction(Request $request, $slug)
    {
        return $this->render('@App/default/singlePost.html.twig', [
            'title' => 'Actualités',
            'item' => $this->get('app.service.post')->getRepository('AppBundle:Post')->findOneBySlug($slug),
        ]);
    }

    /**
     * @Route("/faq/{slug}", name="faqPage")
     */
    public function faqPageAction(Request $request, $slug)
    {
        return $this->render('@App/default/singlePost.html.twig', [
            'title' => 'FAQ',
            'item' => $this->get('app.service.post')->getRepository('AppBundle:Post')->findOneBySlug($slug),
        ]);
    }
}
