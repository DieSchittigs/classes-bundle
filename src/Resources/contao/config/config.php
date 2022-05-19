<?php

/**
 * Contao ClassSelect Modules Set
 *
 * Copyright (c) 2017 Die Schittigs
 *
 * @license LGPL-3.0+
 */

use DieSchittigs\ClassesBundle\ClassesModel;

if (TL_MODE == "BE") {
    $GLOBALS['TL_CSS'][] = 'bundles/contaohelper/backend.css';
}

$GLOBALS['BE_MOD']['design']['themes']['tables'][] = 'tl_classes';


// CSS class replacement
$GLOBALS['TL_HOOKS']['generatePage'][] = array('DieSchittigs\\ClassesBundle\\HelperClass', 'addClassesToPage');
$GLOBALS['TL_HOOKS']['getArticle'][] = array('DieSchittigs\\ClassesBundle\\HelperClass', 'addClassesToArticle');
$GLOBALS['TL_HOOKS']['getContentElement'][] = array('DieSchittigs\\ClassesBundle\\HelperClass', 'addClassesToElement');

$GLOBALS['TL_MODELS']['tl_classes'] = ClassesModel::class;
