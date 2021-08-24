<?php

/**
 * This file is part of "LoTGD Bundle Lodge Title Change".
 *
 * @see https://github.com/lotgd-core/lodge-title-change-bundle
 *
 * @license https://github.com/lotgd-core/lodge-title-change-bundle/blob/master/LICENSE.txt
 * @author IDMarinas
 *
 * @since 0.1.0
 */

namespace Lotgd\Bundle\LodgeTitleChangeBundle\Form;

use Lotgd\Bundle\LodgeTitleChangeBundle\LotgdLodgeTitleChangeBundle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Laminas\Filter;

class TitleChangeType extends AbstractType
{
    private $parameter;

    public function __construct(ParameterBagInterface $parameter)
    {
        $this->parameter = $parameter;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $constraints = [];
        $required = false;

        // if ( ! get_module_setting('bold'))
        // {
        //     $ntitle = str_replace(['`b', '´b'], '', $ntitle);
        // }

        // if ( ! get_module_setting('italics'))
        // {
        //     $ntitle = str_replace(['`i', '´i'], '', $ntitle);
        // }
        // $ntitle = get_module_setting('spaceinname') ? $ntitle : preg_replace('/ /', '', $ntitle);

        if ( ! $this->parameter->get('lotgd_bundle.lodge_title_change.allowed.bold'))
        {
            $constraints[] = new Assert\Regex([
                'pattern' => '/[`´][b]/',
                'match' => false,
                'message' => 'lodge_title_change.no_bold'
            ]);
        }

        if ( ! $this->parameter->get('lotgd_bundle.lodge_title_change.allowed.italic'))
        {
            $constraints[] = new Assert\Regex([
                'pattern' => '/[`´][i]/',
                'match' => false,
                'message' => 'lodge_title_change.no_italic'
            ]);
        }

        if ( ! $this->parameter->get('lotgd_bundle.lodge_title_change.allowed.blank'))
        {
            $required = true;
            $constraints[] = new Assert\NotBlank();
        }

        if ( ! $this->parameter->get('lotgd_bundle.lodge_title_change.allowed.spaces'))
        {
            $constraints[] = new Assert\Regex([
                'pattern' => '/\s/',
                'match' => false,
                'message' => 'lodge_title_change.no_spaces'
            ]);
        }

        $constraints[] = new Assert\Length(['min' => 0, 'max' => 25]);

        $builder
            ->add('new_title', TextType::class, [
                'required' => $required,
                'label' => 'form.title_change.new_title',
                'empty_data' => '',
                'constraints' => $constraints,
                'filters' => [
                    new Filter\PregReplace([
                        'pattern' => '/[`´][ncHw]/',
                        'replacement' => ''
                    ])
                ]
            ])

            ->add('button_preview', SubmitType::class, ['label' => 'form.title_change.button.preview'])
            ->add('button_change', SubmitType::class, [
                'label' => 'form.title_change.button.change',
                'attr'  => [
                    'class' => 'orange',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'         => null,
            'translation_domain' => LotgdLodgeTitleChangeBundle::TRANSLATION_DOMAIN,
        ]);
    }
}
