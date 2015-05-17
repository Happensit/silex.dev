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
use Symfony\Component\Validator\Constraints as Assert;

class ContactFormType extends AbstractType {

  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
      ->add('name', 'text', array(
        'constraints' => array(
          new Assert\NotBlank(),
          new Assert\Length(array('min' => 3))
        ),
        'attr' => array('class' => 'form-control', 'placeholder' => 'Your Name')
      ))
      ->add('email', 'email', array(
        'constraints' => new Assert\Email(),
        'attr' => array(
          'class' => 'form-control',
          'placeholder' => 'Your@email.com'
        )
      ))
      ->add('message', 'textarea', array(
        'constraints' => array(
          new Assert\NotBlank(),
          new Assert\Length(array('min' => 10))
        ),
        'attr' => array(
          'class' => 'form-control',
          'placeholder' => 'Enter Your Message'
        )
      ))
      ->add('Отправить', 'submit', array(
        'attr' => array('class' => 'btn btn-default')
      ));
  }

  public function getName() {
    return 'contact';
  }
}