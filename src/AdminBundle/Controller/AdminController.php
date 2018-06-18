<?php

namespace AdminBundle\Controller;

use User\UserBundle\Entity\User;
use User\UserBundle\Repository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AdminController extends Controller
{
    // Controller principal
    public function dashboardAction()
    {
      return $this->render('AdminBundle:Default:dashboard.html.twig');
    }

    public function acceptAction($id)
    {
          $em = $this->getDoctrine()->getManager();
          $event = $em->getRepository('HomeBundle:Events')->find($id);
          if (!$event) {
             throw $this->createNotFoundException('The event does not exist');
          }

            $event->setStatus(1);
            $em->persist($event);
            $em->flush();

          return $this->redirectToRoute('admin_homepage');

    }

    public function rejectAction($id)
    {
      $em = $this->getDoctrine()->getManager();
      $event = $em->getRepository('HomeBundle:Events')->find($id);
      if (!$event) {
         throw $this->createNotFoundException('The event does not exist');
      }

        $event->setStatus(2);
        $em->persist($event);
        $em->flush();

      return $this->redirectToRoute('admin_homepage');
    }

    public function statusAction()
    {
      $em = $this->getDoctrine()->getManager();
      $events = $em->getRepository('HomeBundle:Events')->eventModoFromThisCategory();
      return $this->render('AdminBundle:Default:status.html.twig', array(
        'events' => $events
      ));
    }

    public function listingAction()
    {
      $em = $this->getDoctrine()->getManager();
      $users = $em->getRepository(User::class)->findAll();
      $countusers = count($users);


      return $this->render('AdminBundle:Default:listing.html.twig', array(
        'users' => $users,
        'countusers' =>  $countusers
      ));
    }

    public function supportAction()
    {
      return $this->render('AdminBundle:Default:support.html.twig');
    }
}
