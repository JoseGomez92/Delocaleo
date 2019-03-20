<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class PostAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
//            ->add('id')
            ->add('titulo')
            ->add('slug')
            ->add('tags')
            ->add('descripcion')
            ->add('imagen')
            ->add('fecha_creacion')
            ->add('visitas')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
//            ->add('id')
            ->add('titulo')
            ->add('slug')
            ->add('tags')
            ->add('descripcion')
            ->add('imagen')
            ->add('fecha_creacion')
            ->add('visitas')
            ->add('_action', null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ])
        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
//            ->add('id')
            ->with('General')
            ->add('titulo')
            ->add('slug')
            ->add('tags')
            ->add('descripcion')
            ->add('imagen')
            ->add('fecha_creacion')
            ->add('visitas')
            ->add('categoria', 'sonata_type_model_list', [
                'btn_add'       => false,       //Specify a custom label
                'btn_list'      => 'Categorias',      //which will be translated
                'btn_delete'    => false,              //or hide the button.
                'btn_edit'      => false,             //Hide add and show edit button when value is set
            ], [
                'placeholder' => 'Indique la categoria',
            ])
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
//            ->add('id')
            ->add('titulo')
            ->add('slug')
            ->add('tags')
            ->add('descripcion')
            ->add('imagen')
            ->add('fecha_creacion')
            ->add('visitas')
        ;
    }
}
