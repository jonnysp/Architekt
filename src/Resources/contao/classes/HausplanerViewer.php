<?php
			

class HausplanerViewer extends ContentElement
{
	protected $strTemplate = 'ce_hausplaner';

	public function generate()
	{
		$this->loadLanguageFile('tl_hausplaner');
		if (TL_MODE == 'BE')
		{
			$objPlan = \HausplanerModel::findByPK($this->hausplaner);
			$objTemplate = new BackendTemplate('be_wildcard');

			if ($objPlan->image != '')
			{
				$objFile = FilesModel::findByUuid($objPlan->image);
				if ($objFile !== null)
				{
					$objTemplate->wildcard = Image::getHtml(Image::get($objFile->path, 64, 64, 'center_top'), '', 'style="float:left;"');
				}
			}

			$objTemplate->wildcard .= 
			'<table style="margin-left:70px;" class="tl_header_table">
			  		<tr><td><span class="tl_label">'.$GLOBALS['TL_LANG']['tl_hausplaner']['type'][0].':</span></td><td>'.$objPlan->type. '</td></tr>
					<tr><td><span class="tl_label">'.$GLOBALS['TL_LANG']['tl_hausplaner']['construction'][0].':</span></td><td>'.$objPlan->construction. '</td></tr>
					<tr><td><span class="tl_label">'.$GLOBALS['TL_LANG']['tl_hausplaner']['basearea'][0].':</span></td><td>'.$objPlan->basearea. '</td></tr>
					<tr><td><span class="tl_label">'.$GLOBALS['TL_LANG']['tl_hausplaner']['livingarea'][0].':</span></td><td>'.$objPlan->livingarea. '</td></tr>
			</table>';

			$objTemplate->title = $objPlan->title;
			return $objTemplate->parse();	
		}
		return parent::generate();
	}//end generate


	protected function compile()
	{
		global $objPage;
		$this->loadLanguageFile('tl_hausplaner');
		
		$objPlan = \HausplanerModel::findByPK($this->hausplaner);
	
		$objPlanImage = \FilesModel::findByPk($objPlan->image);

		//multiimages
		$objPlanImages = Array();
		$objunsortedImages = \FilesModel::findMultipleByUuids(deserialize($objPlan->images));
		$objImagesSort = unserialize($objPlan->imagessort);

		//sort Images
 		if ($objImagesSort){
 			foreach ($objImagesSort as $key => $value) {
 				$uuid = $value;
				if ($objunsortedImages){
					foreach ($objunsortedImages as $value) {
						if ($value->uuid == $uuid) {
							$objPlanImages[] = $value;
						}
					}
				}
 			}
		}

		//print_r($objunsortedImages);

		//Images
		$images = array();
		 if ($objPlanImages){
		 	foreach ($objPlanImages as $key => $value) {
				$images[$key] = array
				(
					uuid => $value->uuid,
					meta => $this->getMetaData($value->meta, $objPage->language),
					path => $value->path,
					name => $value->name,
					extension => $value->extension
				);
		 	}
		 }


		$hausplan = array(
					id => $objPlan->id,
					title => $objPlan->title,
					type => $objPlan->type,
					construction => $objPlan->construction,
					basearea => $objPlan->basearea,
					livingarea	=> $objPlan->livingarea,		
					image => array(
								uuid => $objPlanImage->uuid,
								meta => $this->getMetaData($objPlanImage->meta, $objPage->language),
								path => $objPlanImage->path,
								name => $objPlanImage->name,
								extension => $objPlanImage->extension
							),
					images => $images
				);

		$this->Template->hausplan = $hausplan;

	}//end compile

}//end class

