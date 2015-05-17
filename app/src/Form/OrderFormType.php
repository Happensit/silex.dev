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
use Silex\Provider\FormServiceProvider;

class OrderFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
          ->add(
            'action',
            'hidden',
            array(
              'label' => false,
              'data' => '',
            )
          )
          ->add(
            'type',
            'choice',
            array(
              'choices' => array(
                'квартиру' => 'Квартиру',
                'комнату' => 'Комнату',
                'помещение' => 'Помещение'
              ),
              'data' => array('квартиру'),
              'attr' => array('id' => 'type'),
              'label' => false,
            )
          )
          ->add(
            'subway',
            'text',
            array(
              'constraints' => array(
                new Assert\NotBlank(),
              ),
              'attr' => array(
                'id' => 'subway',
                'placeholder' => 'Ваш комментарий'
              ),
              'label' => false,
            )
          )
          ->add(
            'cost',
            'text',
            array(
              'constraints' => array(
                new Assert\NotBlank(),
              ),
              'attr' => array('id' => 'cost', 'placeholder' => 'Стоимость'),
              'label' => false,
            )
          )
          ->add(
            'name',
            'text',
            array(
              'constraints' => array(
                new Assert\NotBlank(),
              ),
              'attr' => array('id' => 'name', 'placeholder' => 'Ваше имя'),
              'label' => false,
            )
          )
          ->add(
            'phone',
            'text',
            array(
              'constraints' => array(
                new Assert\NotBlank(),
              ),
              'attr' => array('id' => 'phone', 'placeholder' => 'Ваш телефон*'),
              'required' => true,
              'label' => false,
            )
          );
//      ->add('Send', 'submit', array(
//        'attr' => array('id' => 'order-btn', 'class' => 'btn btn-green')
//      )
//      );
    }

    public function getName()
    {
        return 'order';
    }
}