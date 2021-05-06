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

class RdvEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Status', ChoiceType::class, [
                'choices'  => [
                    'Realisé' => "réalisé",
                    'Confirmé' => "confirmé",
                    'Refusé' => "refusé",
                ],
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Rdv::class,
        ]);
    }
}
