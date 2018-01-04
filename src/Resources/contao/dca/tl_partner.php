<?php

/**
 * Table tl_recipes
 */
$GLOBALS['TL_DCA']['tl_partner'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'ptable'                      => 'tl_partners',
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
			'child_record_callback'   => array('tl_partner', 'generateReferenzRow')
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
				'label'               => &$GLOBALS['TL_LANG']['tl_partner']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_partner']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif'
			),
			'cut' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_partner']['cut'],
				'href'                => 'act=paste&amp;mode=cut',
				'icon'                => 'cut.gif'
			),

			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_partner']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_partner']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			),
			'toggle' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_partner']['toggle'],
				'icon'                => 'visible.gif',
				'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
				'button_callback'     => array('tl_partner', 'toggleIcon')
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'default'                     => '{title_legend},published,title,description;{image_legend:hide},logo;'
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

		'published' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_partner']['toggle'],
			'inputType'               => 'checkbox',
			'eval'                    => array('submitOnChange'=>true, 'doNotCopy'=>true, 'tl_class'=>'w50'),
			'sql'                     => "char(1) NOT NULL default ''"
		),



		'title' => array
		(
			'label'    				=> &$GLOBALS['TL_LANG']['tl_partner']['title'],
			'search'              	=> true,
			'inputType'          	=> 'text',
			'eval'                  => array('mandatory'=>true, 'maxlength'=>128, 'tl_class'=>'w50','allowHtml'=>true,'preserveTags'=>true),
			'sql'            		=> "varchar(128) NOT NULL default ''"
		),
		'description' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_partner']['description'],
			'inputType'               => 'textarea',
			'eval'                    => array('rte'=>'tinyMCE', 'tl_class'=>'w100'),
			'sql'                     => "mediumtext NULL"
		),
		'logo' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_partner']['logo'],
			'inputType'               => 'fileTree',
			'eval'                    => array('mandatory'=>true,'fieldType'=>'radio', 'files'=>true, 'filesOnly'=>true, 'extensions'=>$GLOBALS['TL_CONFIG']['validImageTypes']),
			'sql'                     => "binary(16) NULL",
		)

	)
);



class tl_partner extends Backend{
	

	public function generateReferenzRow($arrRow)	{
		$this->loadLanguageFile('tl_partner');

		$label = '<table style="margin-left:86px;" class="tl_header_table">
<tr><td><span class="tl_label">'.$GLOBALS['TL_LANG']['tl_partner']['title'][0].':</span></td><td>'.$arrRow['title']. '</td></tr>
				  </table>';

		if ($arrRow['logo'] != '')
		{
			$objFile = FilesModel::findByUuid($arrRow['logo']);
			if ($objFile !== null)
			{
				$label = Image::getHtml(Image::get($objFile->path, 80, 80, 'center_top'), '', 'style="float:left;"') . ' ' . $label;
			}
		}
		return $label;
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

		return '<a href="'.$this->addToUrl($href).'" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ';
	}


	public function toggleVisibility($intId, $blnVisible, DataContainer $dc=null)
	{

		Input::setGet('id', $intId);
		Input::setGet('act', 'toggle');

		// Trigger the save_callback
		if (is_array($GLOBALS['TL_DCA']['tl_partner']['fields']['published']['save_callback']))
		{
			foreach ($GLOBALS['TL_DCA']['tl_partner']['fields']['published']['save_callback'] as $callback)
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
		$this->Database->prepare("UPDATE tl_partner SET tstamp=". time() .", published='" . ($blnVisible ? 1 : '') . "' WHERE id=?")->execute($intId);

	}

}
