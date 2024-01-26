<?php

use Contao\System;
use DieSchittigs\ContaoClassesBundle\ClassesModel;

/**
 * Contao ClassSelect Modules Set
 *
 * Copyright (c) 2017 Die Schittigs
 *
 * @license LGPL-3.0+
 */


$request = System::getContainer()->get('request_stack')->getCurrentRequest();
$scopeMatcher = System::getContainer()->get('contao.routing.scope_matcher');

if (null !== $request && $scopeMatcher->isBackendRequest($request)) {
    $GLOBALS['TL_CSS'][] = 'bundles/contaoclasses/backend.css';
}

$GLOBALS['BE_MOD']['design']['themes']['tables'][] = 'tl_classes';


// CSS class replacement
$GLOBALS['TL_HOOKS']['generatePage'][] = array('DieSchittigs\\ContaoClassesBundle\\HelperClass', 'addClassesToPage');
$GLOBALS['TL_HOOKS']['getArticle'][] = array('DieSchittigs\\ContaoClassesBundle\\HelperClass', 'addClassesToArticle');
$GLOBALS['TL_HOOKS']['getContentElement'][] = array('DieSchittigs\\ContaoClassesBundle\\HelperClass', 'addClassesToElement');

$GLOBALS['TL_MODELS']['tl_classes'] = ClassesModel::class;
