<?php

namespace App\Form;

use App\Entity\TypeOrder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DeleteTypeOrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id', EntityType::class, ["class" => TypeOrder::class, "choice_label" => "libelle",])
            ->add('Supprimer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {

    }
}