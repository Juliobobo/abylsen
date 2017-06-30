<?php

namespace EasygestionBundle\Datatables;

use Sg\DatatablesBundle\Datatable\AbstractDatatable;
use Sg\DatatablesBundle\Datatable\Editable\SelectEditable;
use Sg\DatatablesBundle\Datatable\Editable\TextEditable;
use Sg\DatatablesBundle\Datatable\Filter\DateRangeFilter;
use Sg\DatatablesBundle\Datatable\Filter\Select2Filter;
use Sg\DatatablesBundle\Datatable\Style;
use Sg\DatatablesBundle\Datatable\Column\Column;
use Sg\DatatablesBundle\Datatable\Column\BooleanColumn;
use Sg\DatatablesBundle\Datatable\Column\ActionColumn;
use Sg\DatatablesBundle\Datatable\Column\MultiselectColumn;
//use Sg\DatatablesBundle\Datatable\Column\VirtualColumn;
use Sg\DatatablesBundle\Datatable\Column\DateTimeColumn;
use Sg\DatatablesBundle\Datatable\Column\ImageColumn;
use Sg\DatatablesBundle\Datatable\Filter\TextFilter;
use Sg\DatatablesBundle\Datatable\Filter\NumberFilter;
use Sg\DatatablesBundle\Datatable\Filter\SelectFilter;


/**
 * Class BesoinDatatable
 *
 * @package EasygestionBundle\Datatables
 */
class BesoinDatatable extends AbstractDatatable
{
    /**
     * {@inheritdoc}
     */
    public function buildDatatable(array $options = array())
    {
        $this->language->set(array(
            'cdn_language_by_locale' => true
        ));

        $this->ajax->set(array(
        ));

        $this->options->set(array(
            'classes' => Style::BOOTSTRAP_3_STYLE,
            'individual_filtering' => true,
            'individual_filtering_position' => 'head',
            'order_cells_top' => true,
        ));

        $this->features->set(array(
        ));
        
        $this->extensions->set(array(
            'buttons' => array(
                'show_buttons' => array('print'),
            )
        ));
        
        $this->events->set(array(
            'xhr' => array(
                'template' => ':event:event.js.twig',
                'vars' => array('table_name' => $this->getName()),
            ),
        ));
        
        $this->columnBuilder
            ->add('status', Column::class, array(
                'title' => 'Status',
              
                
                'editable' => array(SelectEditable::class,
                    array(
                    
                       'source' => array(
                            array('value' => 1),
                            array('value' => 0),
                        ),
                        'mode' => 'popup',
                        'empty_text' => '',
                    ))
                ))
            ->add('priority', Column::class, array(
                'title' => 'Priorité',
                ))
            ->add('dateCreation', Column::class, array(
                'title' => 'Date de création',
                ))
            ->add('start', Column::class, array(
                'title' => 'Start',
                ))
            ->add('duration', Column::class, array(
                'title' => 'Durée',
                ))
            ->add('solution', Column::class, array(
                'title' => 'Solution',
                'filter' => array(TextFilter::class,
                    array(
                        'cancel_button' => true,
                    )
                ),
                'editable' => array(TextEditable::class,
                    array(
                        'placeholder' => '???',
                        'empty_text' => 'Vide',
                    )
                ),
            ))
            ->add('ia.initials', Column::class, array(
                'title' => 'IA',
                ))
            ->add('client.name', Column::class, array(
                'title' => 'Client',
                ));
    }

    /**
     * {@inheritdoc}
     */
    public function getEntity()
    {
        return 'EasygestionBundle\Entity\Besoin';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'besoin_datatable';
    }
}
