<?php
namespace Controller;

use Form\OrderFormType;
use Silicone\Route;
use Silicone\Controller;
use Form\ContactFormType;

class Index extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
      $form = $this->app->formType(new OrderFormType());

        return $this->render('index.html.twig', array(
          'orderform' => $form->createView(),
        ));
    }
}