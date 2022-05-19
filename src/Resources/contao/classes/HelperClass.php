<?php

namespace DieSchittigs\ContaoClassesBundle;

use DieSchittigs\ContaoClassesBundle\ClassesModel;
use Contao\Frontend;

class HelperClass extends Frontend
{
    public function addClassesToPage($objPage, $objLayout, $objPageRegular)
    {
        if (!is_array($arrCustom = unserialize($objPage->customClass))) return;

        foreach ($arrCustom as $classID) {

            $objClass = ClassesModel::findBy(['id=?', 'showOnPage=?'], [$classID, 1]);
            $objPage->cssClass .= ' ' . $objClass->cssClass;
        }
        $objPage->cssClass = trim($objPage->cssClass);
    }

    public function addClassesToArticle($objRow)
    {

        $arrCss = unserialize($objRow->cssID);

        if (!is_array($arrCustom = unserialize($objRow->customClass))) return;

        foreach ($arrCustom as $classID) {
            $objClass = ClassesModel::findBy(['id=?', 'showOnArticle=?'], [$classID, 1]);
            $arrCss[1] .= ' ' . $objClass->cssClass;
        }

        //$arrCss[1] .= ' ' . implode(' ', $arrCustom);
        $objRow->cssID = serialize([$arrCss[0], trim($arrCss[1])]);
    }

    public function addClassesToElement($objRow, $strBuffer, $objElement)
    {


        if (!is_array($arrCustom = unserialize($objElement->customClass))) return $strBuffer;

        $arrCss = [];
        foreach ($arrCustom as $classID) {
            $objClass = ClassesModel::findBy(['id=?', 'showOnElement=?'], [$classID, 1]);
            $arrCss[] = ' ' . $objClass->cssClass;
        }
        // replace string buffer
        $strBuffer = str_replace('class="ce_' . $objElement->type, 'class="ce_' . $objElement->type . ' ' . implode(' ', $arrCss) . ' ', $strBuffer);

        // replace in row
        $objRow->cssID = serialize([unserialize($objRow->cssID)[0], unserialize($objRow->cssID)[0] . ' ' . implode(' ', $arrCss)]);

        return $strBuffer;
    }
}
