<?php
			
class PartnerArchiv extends ContentElement
{
	protected $strTemplate = 'ce_partner_archiv';

	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objCat = \PartnersModel::findByPK($this->partnerarchiv);
			$objTemplate = new \BackendTemplate('be_wildcard');
			$objTemplate->wildcard = '### ' . $GLOBALS['TL_LANG']['tl_content']['partnerarchiv'][0] . ' ###';
			$objTemplate->title =  $objCat->title;
			return $objTemplate->parse();	
		}
		return parent::generate();
	}//end generate

	protected function compile()
	{
		global $objPage;
		$this->loadLanguageFile('tl_partners');
		$this->loadLanguageFile('tl_partner');
		$partner = array();

		$objPartnerArchiv = \PartnersModel::findByPK($this->partnerarchiv);
		$Partner_filter = \PartnerModel::findAll(
			array('column' => array('pid=?','published=?'),'value' => array($objPartnerArchiv->id,1) ,'order' => 'sorting')
		);


		if (count($Partner_filter) > 0){
			foreach ($Partner_filter as $key => $value) {

				$partner[$key] = array(
					id => $value->id,
					title => $value->title,
					description => $value->description,
					image => \FilesModel::findByPk($value->image),
	
				);
			}
		}

		$this->Template->partner = $partner;


	}//end compile

}//end class

