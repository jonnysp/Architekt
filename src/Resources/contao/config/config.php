<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2017 Jonny Spitzner
 *
 * @license LGPL-3.0+
 */

array_insert($GLOBALS['BE_MOD']['architekt'], 100, array
(
	'partner' 		=> array('tables' => array('tl_partners', 'tl_partner')),
	'referenzen' 	=> array('tables' => array('tl_referenzenarchiv', 'tl_referenzen')),
	'hausplaner'	=> array('tables' => array('tl_hausplaner'))
));


/**
 * Style sheet
 */
if (TL_MODE == 'BE')
{
	$GLOBALS['TL_CSS'][] = 'bundles/jonnysparchitekt/architekt.css|static';
}


/**
 * Front end modules
 */
array_insert($GLOBALS['TL_CTE'], 1, array
	(
		'includes' 	=> array
					(
					'partner_archiv' 	=> 'PartnerArchiv',
					'referenzen_archiv'	=> 'ReferenzenArchiv',
					'hausplaner_viewer'	=> 'HausplanerViewer'
					)
	)
);
