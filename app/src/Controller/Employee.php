<?php
/**
 * Created by PhpStorm.
 * User: Happensit
 * Date: 10.05.15
 * Time: 22:09
 */

namespace Controller;

use Form\EmployeesFormType;
use Silicone\Controller;
use Silicone\Route;
use Entity\Employees;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

class Employee extends Controller
{

    /**
     * @Route("/employee")
     */
    public function indexAction()
    {
        $employees = $this->app->em()
          ->getRepository('Entity\Employees')
          ->findAll();

        return $this->render(
          'employees/index.html.twig',
          array('employees' => $employees)
        );
    }

    /**
     * @Route("/employee/add")
     */
    public function newEmployees(Request $request)
    {

        $employees = new Employees();
        $employees->setName('Test name 2');
        $employees->setDescription('Custom description 2');
        $employees->setPath('logo.png');
        //$employees->file('logo.png');

        $this->app->em()->persist($employees);
        $this->app->em()->flush();

//    $form = $this->app->formType(new EmployeesFormType());
//
//    if ($this->request->isMethod('POST')) {
//      $form->bind($request);
//
//      if ($form->isValid()) {
//
//        //$data = $form->getData();
//
        return new Response("Всё гуд сработало!");
//
//      }
//    }

        //return $this->render('employees/employees.html.twig');

    }

    /**
     * @param $id
     * @Route("/employee/{id}/edit", defaults={"id"=null})
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editEmployees($id, Request $request)
    {

        $employees = $this->app->em()->getRepository('Entity\Employees')->find(
          $id
        );

        if (!$employees) {
            $session = new Session();

            return $session->getFlashBag()->add(
              'message',
              array(
                'type' => "error",
                'content' => "Такого сотрудника не существует"
              )
            );

            //return new Response("Такого сотрудника не существует" , 404);
        }

        $form = $this->app->formType(new EmployeesFormType(), $employees);

//    $form = $this->app->form($employees)
//      ->add('name', 'text', array(
//        'constraints' => array(
//          new Assert\NotBlank(),
//          new Assert\Length(array('min' => 3))
//        ),
//        'attr' => array('class' => 'form-control', 'placeholder' => 'Имя сотрудника')
//      ))
//      ->add('description', 'textarea')
//      ->add('file', 'file', array(
//          //'data_class' => NULL,
//          "label" => "Фотография",
//        )
//      )->getForm();


        if ($this->request->isMethod('POST')) {
            $form->submit($request);
            if ($form->isValid()) {
                $data = $form->getData();
                print_r($data);
                $this->app->em()->persist($data);
                $this->app->em()->flush();

                $message = "Отредактировано";
                //return $this->app->redirect($this->app->url('/'));

            }
        }

        return $this->render(
          'employees/editemployees.html.twig',
          array(
            'form' => $form->createView(),
            'entity_id' => $id,
            'message' => $message,
          )
        );

    }


}