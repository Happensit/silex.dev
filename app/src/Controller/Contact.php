<?php
namespace Controller;

use Form\OrderFormType;
use Silicone\Route;
use Silicone\Controller;
use Form\ContactFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class Contact extends Controller {
  /**
   * @Route("/contact", name="contact")
   */
  public function contact(Request $request) {

    if (FALSE === $this->app->isGranted('ROLE_ADMIN')) {

      return new Response("Доступ закрыт");

    }


    $form = $this->app->formType(new ContactFormType());

    if ($this->request->isMethod('POST')) {
      $form->bind($request);

      if ($form->isValid()) {

        return new Response("Всё гуд сработало!");

        //return $this->redirect($this->app->url('index'));
      }
    }

    return $this->render('contact.html.twig', array(
      'form' => $form->createView(),
    ));
  }


  /**
   * @param \Symfony\Component\HttpFoundation\Request $request
   * @return \Symfony\Component\HttpFoundation\Response
   * @Route("/ajaxOrderAction", name="ajaxOrderAction")
   */

  public function ajaxOrderAction(Request $request) {

    $form = $this->app->formType(new OrderFormType());

    if ($this->request->isMethod('POST')) {
      $form->bind($request);

      if ($form->isValid()) {

        $data = $form->getData();

        //$data['action'] // Сдать/Снять
        //$data['type']    // Квартира
        //$data['subway']  // Метро
        //$data['cost']   // Цена
        //$data['name']   // Имя
        //$data['phone']  // Телефон

        //@todo Доделать Html письма
        $body = $this->render('mail/order.html.twig', array('data' => $data ));

        $message = \Swift_Message::newInstance()
          ->setSubject('Сообщение с сайта Stifgroup.ru')
          ->setFrom(array('developer@softformula.com'))
          ->setTo(array('antonybizov@gmail.com'))
          ->setBody($body)
          ->setContentType("text/html");

        $this->app['mailer']->send($message);

        $response = new Response();
        $output = array('success' => true);
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($output));
        //return $this->redirect($this->app->url('ajaxOrderAction'));
      }
      else {
        $response = new Response();
        $errors = $form->getErrors(); // return array of errors
        $output = array('error' => $errors);
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($output));
      }


      return $response;

    }

//    return $this->render('contact.html.twig', array(
//      'form' => $form->createView(),
//    ));

  }
}
