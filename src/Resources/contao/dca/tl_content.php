<?php


$GLOBALS['TL_DCA']['tl_content']['palettes']['partner_archiv'] = '{type_legend},type;{partnerarchiv_legend},partnerarchiv;{protected_legend:hide},protected;{expert_legend:hide},cssID,space;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['fields']['partnerarchiv'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['partnerarchiv'],
	'inputType'               => 'select',
	'options_callback'        => array('tl_content_architekt', 'getPartnerArchiv'),
	'eval'                    => array('mandatory'=>true, 'chosen'=>true, 'submitOnChange'=>true),
	'wizard' 				  => array(	array('tl_content_architekt', 'editPartnerArchiv')	),
	'sql'                     => "int(10) unsigned NOT NULL default '0'"
);


$GLOBALS['TL_DCA']['tl_content']['palettes']['referenzen_archiv'] = '{type_legend},type;{archiv_legend},referenzarchiv;{protected_legend:hide},protected;{expert_legend:hide},cssID,space;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['fields']['referenzarchiv'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['referenzarchiv'],
	'inputType'               => 'select',
	'options_callback'        => array('tl_content_architekt', 'getArchiv'),
	'eval'                    => array('mandatory'=>true, 'chosen'=>true, 'submitOnChange'=>true),
	'wizard' 				  => array(array('tl_content_architekt', 'editArchiv')),
	'sql'                     => "int(10) unsigned NOT NULL default '0'"
);


$GLOBALS['TL_DCA']['tl_content']['palettes']['hausplaner_viewer'] = '{type_legend},type;{hausplaner_legend},hausplaner;{protected_legend:hide},protected;{expert_legend:hide},cssID,space;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['fields']['hausplaner'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['hausplaner'],
	'inputType'               => 'select',
	'options_callback'        => array('tl_content_architekt', 'getPlaner'),
	'eval'                    => array('mandatory'=>true, 'chosen'=>true, 'submitOnChange'=>true),
	'wizard' 				  => array(array('tl_content_architekt', 'editPlaner')),
	'sql'                     => "int(10) unsigned NOT NULL default '0'"
);



class tl_content_architekt extends Backend 
{

	public function getPartnerArchiv()
	{
		$objCats =  \PartnersModel::findAll();
		$arrCats = array();
		foreach ($objCats as $objCat)
		{
			$arrCats[$objCat->id] = '[ID ' . $objCat->id . '] - '. $objCat->title;
		}
		return $arrCats;
	}

	public function editPartnerArchiv(DataContainer $dc)
	{
		$this->loadLanguageFile('tl_partners');
		return ($dc->value < 1) ? '' : ' <a href="contao/main.php?do=partner&amp;act=edit&amp;id=' . $dc->value . '&amp;popup=1&amp;nb=1&amp;rt=' . REQUEST_TOKEN . '" title="' . sprintf(StringUtil::specialchars($GLOBALS['TL_LANG']['tl_partners']['editheader'][1]), $dc->value) . '" onclick="Backend.openModalIframe({\'title\':\'' . StringUtil::specialchars(str_replace("'", "\\'", sprintf($GLOBALS['TL_LANG']['tl_partners']['editheader'][1], $dc->value))) . '\',\'url\':this.href});return false">' . Image::getHtml('alias.svg', $GLOBALS['TL_LANG']['tl_partners']['editheader'][0]) . '</a>';
	}

	public function getArchiv()
	{
		$objCats =  \ReferenzenarchivModel::findAll();
		$arrCats = array();
		foreach ($objCats as $objCat)
		{
			$arrCats[$objCat->id] = '[ID ' . $objCat->id . '] - '. $objCat->title;
		}
		return $arrCats;
	}

	public function editArchiv(DataContainer $dc)
	{
		$this->loadLanguageFile('tl_referenzenarchiv');
		return ($dc->value < 1) ? '' : ' <a href="contao/main.php?do=referenzen&amp;act=edit&amp;id=' . $dc->value . '&amp;popup=1&amp;nb=1&amp;rt=' . REQUEST_TOKEN . '" title="' . sprintf(StringUtil::specialchars($GLOBALS['TL_LANG']['tl_referenzenarchiv']['editheader'][1]), $dc->value) . '" onclick="Backend.openModalIframe({\'title\':\'' . StringUtil::specialchars(str_replace("'", "\\'", sprintf($GLOBALS['TL_LANG']['tl_referenzenarchiv']['editheader'][1], $dc->value))) . '\',\'url\':this.href});return false">' . Image::getHtml('alias.svg', $GLOBALS['TL_LANG']['tl_referenzenarchiv']['editheader'][0]) . '</a>';
	}

	public function getPlaner()
	{
		$objCats =  \HausplanerModel::findAll();
		$arrCats = array();
		foreach ($objCats as $objCat)
		{
			$arrCats[$objCat->id] = '[ID ' . $objCat->id . '] - '. $objCat->title;
		}
		return $arrCats;
	}

	public function editPlaner(DataContainer $dc)
	{
		$this->loadLanguageFile('tl_hausplaner');
		return ($dc->value < 1) ? '' : ' <a href="contao/main.php?do=hausplaner&amp;act=edit&amp;id=' . $dc->value . '&amp;popup=1&amp;nb=1&amp;rt=' . REQUEST_TOKEN . '" title="' . sprintf(StringUtil::specialchars($GLOBALS['TL_LANG']['tl_hausplaner']['editheader'][1]), $dc->value) . '" onclick="Backend.openModalIframe({\'title\':\'' . StringUtil::specialchars(str_replace("'", "\\'", sprintf($GLOBALS['TL_LANG']['tl_hausplaner']['editheader'][1], $dc->value))) . '\',\'url\':this.href});return false">' . Image::getHtml('alias.svg', $GLOBALS['TL_LANG']['tl_hausplaner']['editheader'][0]) . '</a>';
	}

}