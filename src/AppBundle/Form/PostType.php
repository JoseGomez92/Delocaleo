<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class PostType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titulo')
            ->add('slug', TextType::class, array('label' => 'Slug (palabras separadas con _ Ejemplo: titulo_del_post)'))
            ->add('tags', TextType::class, array('label' => 'Tags (indique unicamente palabras separadas por espacios (Ejemplo: tag1 tag2 tag3)'))
            ->add('descripcion')
            ->add('imagen', FileType::class, array(
                "label" => "Imagen:",
                "attr" =>array("class" => "form-control"),
            ))
            ->add('fecha_creacion')
            ->add('visitas')
            ->add('categoria', EntityType::class,
                array(
                    'class' => 'AppBundle:Categoria',
                    'label' => 'Categoría')
            );
            //->add('categoria');
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Post',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_post';
    }


}
