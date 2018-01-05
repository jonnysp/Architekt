<?php

/**
 * Table tl_recipes
 */
$GLOBALS['TL_DCA']['tl_hausplaner'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'      => 'Table',
		'enableVersioning'   => true,
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary'
			)
		)
	),
	

// List
	'list' => array
	(

 		'sorting' => array
		(
			'mode'                => 1,
			'fields'              => array('title'),
			'flag'        		  => 1,
			'panelLayout'         => 'sort,filter;search,limit'
		),
		
		'label' => array
		(
			'fields'                  => array('title'),
			'format'                  => '%s'
		),
		
		'global_operations' => array
		(
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="e"'
			)
		),
		
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_hausplaner']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.svg'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_hausplaner']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.svg'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_hausplaner']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.svg',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'default'                     => '{title_legend},title,type,construction,basearea,livingarea;{image_legend:hide},image,images;'
	),

	// Fields
	'fields' => array
	(
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'title' => array
		(
			'label'    				=> &$GLOBALS['TL_LANG']['tl_hausplaner']['title'],
			'search'              	=> true,
			'inputType'          	=> 'text',
			'eval'                  => array('mandatory'=>true, 'maxlength'=>128, 'tl_class'=>'w100','allowHtml'=>true,'preserveTags'=>true),
			'sql'            		=> "varchar(128) NOT NULL default ''"
		),
		'type' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_hausplaner']['type'],
			'search'               	  => true,
			'inputType'          	  => 'text',
			'eval'                    => array('mandatory'=>false, 'maxlength'=>128, 'tl_class'=>'w100','allowHtml'=>true,'preserveTags'=>true),
			'sql'                    => "varchar(128) NOT NULL default ''"
		),
		'construction' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_hausplaner']['construction'],
			'search'               	  => true,
			'inputType'          	  => 'text',
			'eval'                    => array('mandatory'=>false, 'maxlength'=>128, 'tl_class'=>'w100','allowHtml'=>true,'preserveTags'=>true),
			'sql'                    => "varchar(128) NOT NULL default ''"
		),
		'basearea' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_hausplaner']['basearea'],
			'search'               	  => true,
			'inputType'          	  => 'text',
			'eval'                    => array('mandatory'=>false, 'maxlength'=>128, 'tl_class'=>'w100','allowHtml'=>true,'preserveTags'=>true),
			'sql'                    => "varchar(128) NOT NULL default ''"
		),
		'livingarea' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_hausplaner']['livingarea'],
			'search'               	  => true,
			'inputType'          	  => 'text',
			'eval'                    => array('mandatory'=>false, 'maxlength'=>128, 'tl_class'=>'w100','allowHtml'=>true,'preserveTags'=>true),
			'sql'                    => "varchar(128) NOT NULL default ''"
		),


		'image' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_hausplaner']['image'],
			'inputType'               => 'fileTree',
			'eval'                    => array('mandatory'=>true,'fieldType'=>'radio', 'files'=>true, 'filesOnly'=>true, 'extensions'=>$GLOBALS['TL_CONFIG']['validImageTypes']),
			'sql'                     => "binary(16) NULL",
		),
		'images' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_hausplaner']['images'],
			'inputType'               => 'fileTree',
			'eval'                    => array('multiple'=>true, 'fieldType'=>'checkbox', 'orderField'=>'imagessort', 'files'=>true,'tl_class'=>'long clr','filesOnly'=>true, 'extensions'=>$GLOBALS['TL_CONFIG']['validImageTypes']),
			'sql'                     => "blob NULL",
			'load_callback' => array
			(
				array('tl_hausplaner', 'setFileTreeFlags')
			)
		),
		'imagessort' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_hausplaner']['imagessort'],
			'sql'                     => "blob NULL"
		)

	)
);


class tl_hausplaner extends Backend{


	public function setFileTreeFlags($varValue, DataContainer $dc)
	{
		if ($dc->activeRecord)
		{
				$GLOBALS['TL_DCA'][$dc->table]['fields'][$dc->field]['eval']['isGallery'] = true;
		}
		return $varValue;
	}



}
