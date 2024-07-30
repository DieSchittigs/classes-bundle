<?php

use DieSchittigs\ContaoClassesBundle\ClassesModel;
use Contao\CoreBundle\DataContainer\PaletteManipulator;



PaletteManipulator::create()
    ->addLegend('design_legend', 'expert_legend', PaletteManipulator::POSITION_BEFORE)
    ->addField('customClass', 'design_legend', PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('regular', 'tl_page')
    ->applyToPalette('error_401', 'tl_page')
    ->applyToPalette('error_403', 'tl_page')
    ->applyToPalette('error_404', 'tl_page');


$GLOBALS['TL_DCA']['tl_page']['fields']['customClass'] = [
    'label'                   => &$GLOBALS['TL_LANG']['tl_page']['customClass'],
    'exclude'                 => true,
    'inputType'               => 'select',
    'options_callback'        => ['tl_page_helper', 'getClasses'],
    'eval'                    => array('tl_class' => 'w50', 'multiple' => true, 'chosen' => true),
    'sql'                     => "blob NULL"
];


class tl_page_helper extends tl_page
{
    public function getClasses()
    {

        $objClasses = ClassesModel::findByShowOnPage(1, ['order' => 'tl_classes.name']);

        if ($objClasses === null) return;

        $arrReturn = [];
        while ($objClasses->next()) {
            $arrReturn[$objClasses->id] = $objClasses->name . ' [' . $objClasses->cssClass . ']';
        }

        return $arrReturn;
    }
}
