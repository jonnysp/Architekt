<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2017 Jonny Spitzner
 *
 * @license LGPL-3.0+
 */

/**
 * Back end modules
 */
array_insert($GLOBALS['BE_MOD']['architekt'], 100, array
(
	'partner' => array
	(
		'tables' => array('tl_partners', 'tl_partner')
	)
//	,
//	'referenzen' => array
//	(
//		'tables' => array('tl_archiv', 'tl_referenzen')
//	)
//	,
//	'hausplaner'=> array
//	(
//		'tables' => array('tl_veba_hausplaner')
//	)
)
);


///**
// * Front end modules
// */
//array_insert($GLOBALS['TL_CTE'], 1, array
//(
//	'includes' => array
//	(
//		'architekt_viewer'    => 'ArchitektViewer'
//	)
//));
//
///**
// * Back end form fields
// */
//array_insert($GLOBALS['BE_FFL'] ,1, array
//(
//	'pannoramasceneposition'        => 'PannoramaScenePositionSelector',
//	'pannoramahotspotposition'      => 'PannoramaHotspotPositionSelector',
//	'pannoramatargetposition'		=>'PannoramaTargetPositionSelector'
//));

