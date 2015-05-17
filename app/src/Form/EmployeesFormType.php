<?php
/* (c) Anton Medvedev <anton@elfet.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Form;

use Silex\Application;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Entity\Employees;
use Symfony\Component\Validator\Constraints as Assert;

class EmployeesFormType extends AbstractType {

  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('name', 'text', array(
        'constraints' => array(
          new Assert\NotBlank(),
          new Assert\Length(array('min' => 3))
        ),
        'attr' => array('class' => 'form-control', 'placeholder' => 'Your Name')
      ))
      ->add('name', 'text', array('invalid_message' => 'Чёт тут надо..'))
      ->add('description', 'textarea')
      ->add('file', 'file', array(
          'data_class' => NULL,
          'invalid_message' => "Чёт опять не работает",
          'label' => "Фотография",
          'required' => false,
        )
      );
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Entity\Employees',
    );
  }

  public function getName()
  {
    return 'employeesformtype';
  }
}