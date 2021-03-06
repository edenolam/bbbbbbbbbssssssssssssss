<?php

namespace Bilan_Social\Bundle\ConsoBundle\Form;

use Bilan_Social\Bundle\ConsoBundle\Entity\Ind311;
use Bilan_Social\Bundle\ReferencielBundle\Entity\RefCategorie;
use Bilan_Social\Bundle\ReferencielBundle\Entity\RefFiliere;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Bilan_Social\Bundle\CoreBundle\Form\PurifiedNumberType;

class Ind311Type extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('r3111', PurifiedNumberType::class, array(
                        'required' => false,
                        'attr' => array(
                            'class' => 'ind110 positiveFloat',
                            'onChange'=> 'changedR311(this);changedDetect()',
                        )
                    ))
                ->add('r3112', PurifiedNumberType::class, array(
                        'required' => false,
                        'attr' => array(
                            'class' => 'ind110 positiveFloat',
                            'onChange'=> 'changedR311(this);changedDetect()',
                        )
                    ))
                ->add('r3113', PurifiedNumberType::class, array(
                        'required' => false,
                        'attr' => array(
                            'class' => 'ind110 positiveFloat',
                            'onChange'=> 'changedR311(this);changedDetect()',
                        )
                    ))
                ->add('r3114', PurifiedNumberType::class, array(
                        'required' => false,
                        'attr' => array(
                            'class' => 'ind110 positiveFloat',
                            'onChange'=> 'changedR311(this);changedDetect()',
                        )
                    ))
                ->add('r3115', PurifiedNumberType::class, array(
                        'required' => false,
                        'attr' => array(
                            'class' => 'ind110 positiveFloat',
                            'onChange'=> 'changedR311(this);changedDetect()',
                        )
                    ))
                ->add('r3116', PurifiedNumberType::class, array(
                        'required' => false,
                        'attr' => array(
                            'class' => 'ind110 positiveFloat',
                            'onChange'=> 'changedR311(this);changedDetect()',
                        )
                    ))
                ->add('r3117', PurifiedNumberType::class, array(
                        'required' => false,
                        'attr' => array(
                            'class' => 'ind110 positiveFloat',
                            'onChange'=> 'changedR311(this);changedDetect()',
                        )
                    ))
                ->add('r3118', PurifiedNumberType::class, array(
                        'required' => false,
                        'attr' => array(
                            'class' => 'ind110 positiveFloat',
                            'onChange'=> 'changedR311(this);changedDetect()',
                        )
                    ))
                ->add('r3119', PurifiedNumberType::class, array(
                        'required' => false,
                        'attr' => array(
                            'class' => 'ind110 positiveFloat',
                            'onChange'=> 'changedR311(this);changedDetect()',
                        )
                    ))
                ->add('r31110', PurifiedNumberType::class, array(
                        'required' => false,
                        'attr' => array(
                            'class' => 'ind110 positiveFloat',
                            'onChange'=> 'changedR311(this);changedDetect()',
                        )
                    ))
                ->add('r31111', PurifiedNumberType::class, array(
                        'required' => false,
                        'attr' => array(
                            'class' => 'ind110 positiveFloat',
                            'onChange'=> 'changedR311(this);changedDetect()',
                        )
                    ))
                ->add('r31112', PurifiedNumberType::class, array(
                        'required' => false,
                        'attr' => array(
                            'class' => 'ind110 positiveFloat',
                            'onChange'=> 'changedR311(this);changedDetect()',
                        )
                    ))
                ->add('refFiliere',  EntityType::class, array(
                    'required' => true,
                    'class' => RefFiliere::class,
                    'choice_label' => 'lbFili',
                    'label_attr' => array(
                        'class' => 'hidden'
                    ),
                    'attr' => array(
                        'class' => 'selectEntity hidden'
                    )
                ))
                ->add('refCategorie',  EntityType::class, array(
                        'required' => true,
                        'class' => RefCategorie::class,
                        'choice_label' => 'lbCate',
                        'label_attr' => array(
                            'class' => 'hidden'
                        ),
                        'attr' => array(
                            'class' => 'selectEntity hidden'
                        )
                    ))
                ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Ind311::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'ind311';
    }


}

