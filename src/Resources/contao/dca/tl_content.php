<?php

use DieSchittigs\ContaoClassesBundle\ClassesModel;
use Contao\DataContainer;

foreach ($GLOBALS['TL_DCA']['tl_content']['palettes'] as $key => &$val) {
    if ($key == '__selector__' or $key == 'default') continue;
    $val = str_replace('{expert_legend:hide}', '{design_legend},customClass;{expert_legend:hide}', $val);
}

$GLOBALS['TL_DCA']['tl_content']['fields']['customClass'] = [
    'label'                   => &$GLOBALS['TL_LANG']['tl_content']['customClass'],
    'exclude'                 => true,
    'inputType'               => 'select',
    'options_callback'        => ['tl_content_helper', 'getClasses'],
    'eval'                    => array('tl_class' => 'w50', 'multiple' => true, 'chosen' => true),
    'sql'                     => "blob NULL"
];


class tl_content_helper extends tl_content
{
    public function getClasses(DataContainer $dc)
    {
        $objClasses = ClassesModel::findByShowOnElement(1);

        if ($objClasses === null) return;

        $arrReturn = [];
        while ($objClasses->next()) {

            if ($objClasses->excludeElements && @!in_array($dc->activeRecord->type, unserialize($objClasses->elementTypes))) {
                continue;
            }

            $arrReturn[$objClasses->id] = $objClasses->name . ' [' . $objClasses->cssClass . ']';
        }

        return $arrReturn;
    }
}
