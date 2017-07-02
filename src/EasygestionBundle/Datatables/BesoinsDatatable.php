<?php

namespace EasygestionBundle\Datatables;

use Sg\DatatablesBundle\Datatable\AbstractDatatable;
use Sg\DatatablesBundle\Datatable\Editable\SelectEditable;
use Sg\DatatablesBundle\Datatable\Editable\TextEditable;
use Sg\DatatablesBundle\Datatable\Editable\TextareaEditable;
use Sg\DatatablesBundle\Datatable\Filter\DateRangeFilter;
use Sg\DatatablesBundle\Datatable\Filter\Select2Filter;
use Sg\DatatablesBundle\Datatable\Style;
use Sg\DatatablesBundle\Datatable\Column\Column;
use Sg\DatatablesBundle\Datatable\Column\BooleanColumn;
use Sg\DatatablesBundle\Datatable\Column\ActionColumn;
use Sg\DatatablesBundle\Datatable\Column\MultiselectColumn;
//use Sg\DatatablesBundle\Datatable\Column\VirtualColumn;
use Sg\DatatablesBundle\Datatable\Column\DateTimeColumn;
use Sg\DatatablesBundle\Datatable\Editable\CombodateEditable;   
use Sg\DatatablesBundle\Datatable\Column\ImageColumn;
use Sg\DatatablesBundle\Datatable\Filter\TextFilter;
use Sg\DatatablesBundle\Datatable\Filter\NumberFilter;
use Sg\DatatablesBundle\Datatable\Filter\SelectFilter;


/**
 * Class BesoinDatatable
 *
 * @package EasygestionBundle\Datatables
 */
class BesoinsDatatable extends AbstractDatatable
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
            //'order' => array(array($this->getDefaultOrderCol(), 'asc')),
            'order_cells_top' => true,
            'individual_filtering' => true,
        ));

        $this->features->set(array(
        ));
        
        $this->extensions->set(array(
        ));
        
       /* $this->events->set(array(
            'xhr' => array(
                'template' => ':event:event.js.twig',
                'vars' => array('table_name' => $this->getName()),
            ),
        )); */
        
        $this->columnBuilder 
            ->add('status', Column::class, array(
                'title' => 'Status',
                'filter' => array(NumberFilter::class, array(
                    'search_type' =>'eq',
                    'type' =>'number',
                    'min' => '0',
                    'max' => '1',
                    'initial_search' => '1',
                )),
                'editable' => array(SelectEditable::class,
                    array(
                        'source' => array(
                            array('value' => 1, 'text' => 'ok'),
                            array('value' => 0, 'text' => 'out'),
                        ),
                        'mode' => 'popup',
                        'empty_text' => '',
                    ),
                ),
            ))
            ->add('priority', Column::class, array(
                'title' => 'Priorité',
                'filter' => array(NumberFilter::class, array(
                    'search_type' =>'eq',
                    'type' =>'number',
                    'min' => '1',
                    'max' => '3',
                    'initial_search' => '1',
                )),
                'editable' => array(TextEditable::class,
                    array(
                        'placeholder' => '1, 2 ou 3 ?',
                    ),  
                ),
            ))
            ->add('dateCreation', DateTimeColumn::class, array(
                'title' => 'Date de création',
                'date_format' => 'L',
                'searchable' => false,
            ))
            ->add('start', DateTimeColumn::class, array(
                'title' => 'Start',
                'date_format' => 'L',
                'searchable' => false,
                'editable' => array(CombodateEditable::class, array(
                    'format' => 'YYYY.MM.DD',
                    'view_format' => 'DD.MM.YYYY',
                )),
            ))
            ->add('duration', Column::class, array(
                'title' => 'Durée',
                'searchable' => false,
                'editable' => array(TextEditable::class, array(
                    'placeholder' => 'Combien de mois ?'
                )),
            ))
            ->add('solution', Column::class, array(
                'title' => 'Solution',
                'searchable' => false,
                'editable' => array(TextareaEditable::class,
                    array(
                        'rows' => 6,
                    )
                ),
            ))
            ->add('createdBy.initials', Column::class, array(
                'title' => 'IA',
                'searchable' => false,
                //'add_if' => function(){
                  //  return !$this->authorizationChecker->isGranted('ROLE_USER');
                //},
            ))
            ->add('client.name', Column::class, array(
                'title' => 'Client',
                'searchable' => false,
            ))
            ->add('archive', Column::class, array(
                'title' => 'Archive',
                'filter' => array(NumberFilter::class, array(
                    'search_type' =>'eq',
                    'type' =>'number',
                    'min' => '0',
                    'max' => '1',
                    'initial_search' => '0',
                    'show_label' => true,
                )),
            ))
            ->add(null, ActionColumn::class, array(
                'title' => $this->translator->trans('sg.datatables.actions.title'),
                'actions' => array(
                    array(
                      'route' => 'besoin_archive',
                        'route_parameters' => array(
                            'id' => 'id',
                        ),
                        'icon' => 'glyphicon glyphicon-folder-close',
                        'attributes' => array(
                            'rel' => 'tooltip',
                            'class' => 'btn btn-primary btn-xs',
                            'role' => 'button',
                        ),
                        'render_if' => function ($row) {
                            if($row['archive'] == 1){
                                return false;
                            }
                            
                            return true;
                        },
                    ),
                )
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
