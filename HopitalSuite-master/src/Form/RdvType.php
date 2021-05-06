<?php

namespace App\Form;

use App\Entity\Rdv;
use DateTime;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class RdvType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Date',DateTimeType::class, array(
                'widget' => 'choice',
                'placeholder' => [
                    'year' => "Année", 'month' => "Mois", 'day' => "Jour", 'hour' => "Heure", 'minute' => "Minute"
                ],
                'years' => range(date('Y'), date('Y')+100),
                'months' => range(1, 12),
                'days' => range(1, 31),
                'hours' => range(8, 18),
                'minutes' => range(0, 30, 30),
              ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Rdv::class,
        ]);
    }
}
