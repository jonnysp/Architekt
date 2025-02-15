<?php
			
class ReferenzenArchiv extends ContentElement
{
	protected $strTemplate = 'ce_referenzen_archiv';

	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objCat = \ReferenzenarchivModel::findByPK($this->referenzarchiv);
			$objTemplate = new \BackendTemplate('be_wildcard');
			$objTemplate->wildcard = '### ' . $GLOBALS['TL_LANG']['tl_content']['referenzarchiv'][0] . ' ###';
			$objTemplate->title =  $objCat->title;
			return $objTemplate->parse();	
		}
		return parent::generate();
	}//end generate



	protected function compile()
	{
		global $objPage;
		$this->loadLanguageFile('tl_referenzenarchiv');
		$this->loadLanguageFile('tl_referenzen');
		$referenzen = array();


		$objArchiv = \ReferenzenarchivModel::findByPK($this->referenzarchiv);
		$referenzen_filter = \ReferenzenModel::findAll(
			array('column' => array('pid=?','published=?'),'value' => array($objArchiv->id,1) ,'order' => 'sorting')
		);


		if ($referenzen_filter && count($referenzen_filter) > 0){
			foreach ($referenzen_filter as $key => $value) {

				$referenzen[$key] = array(
					"id" => $value->id,
					"title" => $value->title,
					"description" => $value->description,
					"type" => $value->type,
					"year" => $value->year,
					"image" => \FilesModel::findByPk($value->image),
					"images" => \FilesModel::findMultipleByUuids(StringUtil::deserialize($value->images))
				);
			}
		}

		


		$this->Template->referenzen = $referenzen;

	


	}//end compile

}//end class

