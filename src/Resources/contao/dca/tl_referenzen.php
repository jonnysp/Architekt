<?php

/**
 * Table tl_recipes
 */
$GLOBALS['TL_DCA']['tl_referenzen'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'ptable'                      => 'tl_referenzenarchiv',
		'enableVersioning'            => true,
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary',
				'pid' => 'index'
			)
		)
	),
	

// List
	'list' => array
	(

		 'sorting' => array
		(
			'mode'                    => 4,
			'fields'                  => array('sorting'),
			'headerFields'            => array('title','year'),
			'flag'        			  => 1,
			'panelLayout'             => 'filter;search,limit',
			'child_record_callback'   => array('tl_referenzen', 'generateReferenzRow')
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
				'label'               => &$GLOBALS['TL_LANG']['tl_referenzen']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.svg'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_referenzen']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.svg'
			),
			'cut' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_referenzen']['cut'],
				'href'                => 'act=paste&amp;mode=cut',
				'icon'                => 'cut.svg'
			),

			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_referenzen']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.svg',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_referenzen']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.svg'
			),
			'toggle' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_referenzen']['toggle'],
				'icon'                => 'visible.svg',
				'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
				'button_callback'     => array('tl_referenzen', 'toggleIcon')
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'default'                     => '{title_legend},published,title,description,type,year;{image_legend:hide},image,images'
	),

	// Fields
	'fields' => array
	(
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'pid' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'sorting' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'title' => array
		(
			'label'    				=> &$GLOBALS['TL_LANG']['tl_referenzen']['title'],
			'search'              	=> true,
			'inputType'          	=> 'text',
			'eval'                  => array('mandatory'=>true, 'maxlength'=>128, 'tl_class'=>'w100','allowHtml'=>true,'preserveTags'=>true),
			'sql'            		=> "varchar(128) NOT NULL default ''"
		),
		'description' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_referenzen']['description'],
			'search'               	  => true,
			'inputType'          	  => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>128, 'tl_class'=>'w100', 'allowHtml'=>true,'preserveTags'=>true),
			'sql'                    => "varchar(128) NOT NULL default ''"
		),
		'year' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_referenzen']['year'],
			'default'				  => Date('Y'),
			'inputType'               => 'select',
			'search'                  => true,
			'options'            	  => array_merge (array (''), range(date('Y'), 1990))  ,
			'eval'                    => array('mandatory'=>false, 'tl_class'=>'w100'),
			'sql'                     => "varchar(128) NOT NULL default ''"
		),
		'type' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_referenzen']['type'],
			'search'               	  => true,
			'inputType'          	  => 'text',
			'eval'                    => array('mandatory'=>false, 'maxlength'=>128, 'tl_class'=>'w100','allowHtml'=>true,'preserveTags'=>true),
			'sql'                    => "varchar(128) NOT NULL default ''"
		),
		'image' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_referenzen']['image'],
			'inputType'               => 'fileTree',
			'eval'                    => array('mandatory'=>true,'fieldType'=>'radio', 'files'=>true, 'filesOnly'=>true, 'extensions'=>$GLOBALS['TL_CONFIG']['validImageTypes']),
			'sql'                     => "binary(16) NULL",
		),
		'images' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_referenzen']['images'],
			'inputType'               => 'fileTree',
			'eval'                    => array('multiple'=>true, 'fieldType'=>'checkbox', 'orderField'=>'imagessort', 'files'=>true,'tl_class'=>'long clr','filesOnly'=>true, 'extensions'=>$GLOBALS['TL_CONFIG']['validImageTypes']),
			'sql'                     => "blob NULL",
			'load_callback' => array
			(
				array('tl_referenzen', 'setFileTreeFlags')
			)
		),
		'imagessort' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_referenzen']['imagessort'],
			'sql'                     => "blob NULL"
		),
		'published' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_referenzen']['toggle'],
			'inputType'               => 'checkbox',
			'eval'                    => array('submitOnChange'=>true, 'doNotCopy'=>true, 'tl_class'=>'w100'),
			'sql'                     => "char(1) NOT NULL default ''",
			'save_callback'			  => array()
		),

	)
);


use Contao\Image\ResizeConfiguration;

class tl_referenzen extends Backend{
	

	public function generateReferenzRow($arrRow)	{
		$this->loadLanguageFile('tl_referenzen');

		$label = '<table style="margin-left:86px;" class="tl_header_table">
				<tr><td><span class="tl_label">'.$GLOBALS['TL_LANG']['tl_referenzen']['title'][0].':</span></td><td>'.$arrRow['title']. '</td></tr>
				<tr><td><span class="tl_label">'.$GLOBALS['TL_LANG']['tl_referenzen']['description'][0].':</span></td><td>'.$arrRow['description']. '</td></tr>
<tr><td><span class="tl_label">'.$GLOBALS['TL_LANG']['tl_referenzen']['type'][0].':</span></td><td>'.$arrRow['type']. '</td></tr>
<tr><td><span class="tl_label">'.$GLOBALS['TL_LANG']['tl_referenzen']['year'][0].':</span></td><td>'.$arrRow['year']. '</td></tr>
				  </table>';

		if ($arrRow['image'] != '')
		{
			$objFile = FilesModel::findByUuid($arrRow['image']);
			if ($objFile !== null)
			{
				$container = System::getContainer();
				$rootDir = $container->getParameter('kernel.project_dir');

				$label = Image::getHtml($container->get('contao.image.image_factory')->create($rootDir.'/'.$objFile->path,(new ResizeConfiguration())->setWidth(80)->setHeight(80)->setMode(ResizeConfiguration::MODE_BOX))->getUrl($rootDir), '', 'style="float:left;"') . ' ' . $label;

			}
		}
		return $label;
    }



	public function setFileTreeFlags($varValue, DataContainer $dc)
	{
		if ($dc->activeRecord)
		{
				$GLOBALS['TL_DCA'][$dc->table]['fields'][$dc->field]['eval']['isGallery'] = true;
		}
		return $varValue;
	}

	public function toggleIcon($row, $href, $label, $title, $icon, $attributes)
	{
		if (strlen(Input::get('tid')))
		{
			$this->toggleVisibility(Input::get('tid'), (Input::get('state') == 1), (@func_get_arg(12) ?: null));
			$this->redirect($this->getReferer());
		}

		$href .= '&amp;tid='.$row['id'].'&amp;state='.($row['published'] ? '' : 1);

		if (!$row['published'])
		{
			$icon = 'invisible.gif';
		}

		return '<a href="'.$this->addToUrl($href).'" title="'.StringUtil::specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ';
	}


	public function toggleVisibility($intId, $blnVisible, DataContainer $dc=null)
	{

		Input::setGet('id', $intId);
		Input::setGet('act', 'toggle');

		// Trigger the save_callback
		if (is_array($GLOBALS['TL_DCA']['tl_referenzen']['fields']['published']['save_callback']))
		{
			foreach ($GLOBALS['TL_DCA']['tl_referenzen']['fields']['published']['save_callback'] as $callback)
			{
				if (is_array($callback))
				{
					$this->import($callback[0]);
					$blnVisible = $this->$callback[0]->$callback[1]($blnVisible, ($dc ?: $this));
				}
				elseif (is_callable($callback))
				{
					$blnVisible = $callback($blnVisible, ($dc ?: $this));
				}
			}
		}

		// Update the database
		$this->Database->prepare("UPDATE tl_referenzen SET tstamp=". time() .", published='" . ($blnVisible ? 1 : '') . "' WHERE id=?")->execute($intId);

	}

}
