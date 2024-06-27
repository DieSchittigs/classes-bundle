<?php

use Contao\Backend;
use Contao\BackendUser;
use Contao\DataContainer;
use Contao\DC_Table;
use Contao\System;
use Contao\CoreBundle\Security\ContaoCorePermissions;
use DieSchittigs\ContaoClassesBundle\ClassesModel;

$GLOBALS['TL_DCA']['tl_classes'] = array(
	// Config
	'config' => array(
		'dataContainer'               => Contao\DC_Table::class,
		'ptable'                      => 'tl_theme',
		'switchToEdit'                => true,
		'enableVersioning'            => true,
		'markAsCopy'                  => 'name',
		'sql' => array(
			'keys' => array(
				'id' => 'primary',
				'pid' => 'index'
			)
		)
	),

	// List
	'list' => array(
		'sorting' => array(
			'mode'                    => 4,
			'fields'                  => array('name'),
			'panelLayout'             => 'filter;search,limit',
			'headerFields'            => array('name', 'author', 'tstamp'),
			'child_record_callback'   => array('tl_classes', 'listClasses')
		),
		'global_operations' => array(
			'all' => array(
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="e"'
			)
		),
		'operations' => array(

			'edit' => array(
				'href'                => 'table=tl_classes&amp;act=edit',
				'icon'                => 'edit.svg'
			),
			'copy' => array(
				'href'                => 'act=paste&amp;mode=copy',
				'icon'                => 'copy.svg'
			),
			'cut' => array(
				'href'                => 'act=paste&amp;mode=cut',
				'icon'                => 'cut.svg',
				'attributes'          => 'onclick="Backend.getScrollOffset()"'
			),
			'delete' => array(
				'href'                => 'act=delete',
				'icon'                => 'delete.svg',
				'attributes'          => 'onclick="if(!confirm(\'' . ($GLOBALS['TL_LANG']['MSC']['deleteConfirm'] ?? null) . '\'))return false;Backend.getScrollOffset()"'
			),
			'show' => array(
				'href'                => 'act=show',
				'icon'                => 'show.svg'
			)
		)
	),

	// Palettes
	'palettes' => array(
		'__selector__'				  => array('excludeElements'),
		'default'                     => '{title_legend},name,cssClass;{show_legend},showOnPage,showOnArticle,showOnElement,excludeElements'
	),

	// Subpalettes
	'subpalettes' => array(
		'excludeElements'             => 'elementTypes',
	),

	// Fields
	'fields' => array(
		'id' => array(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'pid' => array(
			'foreignKey'              => 'tl_theme.name',
			'sql'                     => "int(10) unsigned NOT NULL default 0",
			'relation'                => array('type' => 'belongsTo', 'load' => 'lazy')
		),
		'tstamp' => array(
			'sql'                     => "int(10) unsigned NOT NULL default 0"
		),
		'name' => array(
			'inputType'               => 'text',
			'exclude'                 => true,
			'search'                  => true,
			'flag'                    => 1,
			'eval'                    => array('mandatory' => true, 'maxlength' => 64, 'tl_class' => 'w50'),
			'sql'                     => "varchar(64) NULL"
		),
		'cssClass' => array(
			'inputType'               => 'text',
			'exclude'                 => true,
			'search'                  => true,
			'eval'                    => array('maxlength' => 64, 'tl_class' => 'w50'),
			'save_callback'           => array(
				static function ($value) {
					if (!preg_match('/^([_a-zA-Z]+[_a-zA-Z\d-]*\s?)+$/', $value)) {
						throw new RuntimeException($GLOBALS['TL_LANG']['ERR']['invalidClassName']);
					}
					return $value;
				}
			),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'showOnPage' => [
			'inputType'               => 'checkbox',
			'exclude'                 => true,
			'filter'				  => true,
			'eval'                    => array('tl_class' => 'w50 m12 clr'),
			'sql'                     => "char(1) NOT NULL default ''"
		],
		'showOnArticle' => [
			'inputType'               => 'checkbox',
			'exclude'                 => true,
			'filter'				  => true,
			'eval'                    => array('tl_class' => 'w50 m12 clr'),
			'sql'                     => "char(1) NOT NULL default ''"
		],
		'showOnElement' => [
			'inputType'               => 'checkbox',
			'exclude'                 => true,
			'filter'				  => true,
			'eval'                    => array('submitOnChange' => true, 'tl_class' => 'w50 m12 clr'),
			'sql'                     => "char(1) NOT NULL default ''"
		],
		'excludeElements' => [
			'exclude'                 => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('submitOnChange' => true, 'tl_class' => 'w50 m12 clr'),
			'sql'                     => "char(1) NOT NULL default ''"
		],
		'elementTypes' => [
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'checkboxWizard',
			'options_callback'        => array('tl_classes', 'getContentElements'),
			'reference'               => &$GLOBALS['TL_LANG']['CTE'],
			'eval'                    => array('multiple' => true),
			'sql'                     => "blob NULL"
		],
	)
);

/**
 * Provide miscellaneous methods that are used by the data configuration array.
 *
 * @internal
 */
class tl_classes extends Backend
{
	/**
	 * Import the back end user object
	 */
	public function __construct()
	{
		parent::__construct();
		$this->import(BackendUser::class, 'User');
	}


	/**
	 * List a class
	 *
	 * @param array $row
	 *
	 * @return string
	 */
	public function listClasses($row)
	{
		$html = '<div class="tl_content_left">';
		$html .= $row['name'];

		$html .= ' <span style="color:#999;padding-left:3px;font-family:monospace"> class="' . $row['cssClass'] . '" </span>';


		$html .= ($row['showOnPage']) ? '<span style="color:white;margin-left:3px;background: #666; padding:0 2px; font-size: 90%;border-radius:2px;">Pages ✔</span>' : '';
		$html .= ($row['showOnArticle']) ? '<span style="color:white;margin-left:3px;background: #888; padding:0 2px; font-size: 90%;border-radius:2px;">Articles ✔</span>' : '';

		$types = ($row['excludeElements'] && $row['elementTypes']) ? '( ce_' . @implode(' | ce_', unserialize($row['elementTypes'])) . ' )' : '';
		$html .= ($row['showOnElement']) ? '<span style="color:white;margin-left:3px;background: #aaa; padding:0 2px; font-size: 90%;border-radius:2px;">Elements ✔ ' . $types . '</span>' : '';

		$html .= "</div>\n";

		return $html;
	}

	/**
	 * Return all content elements as array
	 *
	 * @return array
	 */
	public function getContentElements()
	{

		$groups = array();

		foreach ($GLOBALS['TL_CTE'] as $k => $v) {
			foreach (array_keys($v) as $kk) {
				$groups[$kk] = $kk;
			}
		}
		return $groups;
	}
}
