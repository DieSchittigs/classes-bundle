<?php

/**
 * Contao ClassSelect Modules Set
 *
 * Copyright (c) 2017 Die Schittigs
 *
 * @license LGPL-3.0+
 */

use DieSchittigs\ContaoClassesBundle\ClassesModel;

if (TL_MODE == "BE") {
    $GLOBALS['TL_CSS'][] = 'bundles/contaoclasses/backend.css';
}

$GLOBALS['BE_MOD']['design']['themes']['tables'][] = 'tl_classes';


// CSS class replacement
$GLOBALS['TL_HOOKS']['generatePage'][] = array('DieSchittigs\\ContaoClassesBundle\\HelperClass', 'addClassesToPage');
$GLOBALS['TL_HOOKS']['getArticle'][] = array('DieSchittigs\\ContaoClassesBundle\\HelperClass', 'addClassesToArticle');
$GLOBALS['TL_HOOKS']['getContentElement'][] = array('DieSchittigs\\ContaoClassesBundle\\HelperClass', 'addClassesToElement');

$GLOBALS['TL_MODELS']['tl_classes'] = ClassesModel::class;
