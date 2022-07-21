<?php

use DieSchittigs\ContaoClassesBundle\ClassesModel;

PaletteManipulator::create()
    ->addLegend('design_legend', 'expert_legend', PaletteManipulator::POSITION_BEFORE)
    ->addField('customClass', 'design_legend', PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('default', 'tl_article');

$GLOBALS['TL_DCA']['tl_article']['fields']['customClass'] = [
    'label'                   => &$GLOBALS['TL_LANG']['tl_article']['customClass'],
    'exclude'                 => true,
    'inputType'               => 'select',
    'options_callback'        => ['tl_article_helper', 'getClasses'],
    'eval'                    => array('tl_class' => 'w50', 'multiple' => true, 'chosen' => true),
    'sql'                     => "blob NULL"
];


class tl_article_helper extends tl_article
{
    public function getClasses()
    {
        $objClasses = ClassesModel::findByShowOnArticle(1);

        if ($objClasses === null) return;

        $arrReturn = [];
        while ($objClasses->next()) {
            $arrReturn[$objClasses->id] = $objClasses->name . ' [' . $objClasses->cssClass . ']';
        }

        return $arrReturn;
    }
}
