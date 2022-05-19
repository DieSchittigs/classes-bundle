<?php

use DieSchittigs\ClassesBundle\ClassesModel;

$GLOBALS['TL_DCA']['tl_article']['palettes']['default'] = str_replace(
    '{expert_legend:hide}',
    '{design_legend},customClass;{expert_legend:hide}',
    $GLOBALS['TL_DCA']['tl_article']['palettes']['default']
);

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
