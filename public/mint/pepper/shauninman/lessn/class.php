<?php
/******************************************************************************
 Pepper
 
 Developer		: Shaun Inman
 Plug-in Name	: Lessn Pepper
 
 http://shauninman.com/

 ******************************************************************************/
if (!defined('MINT')) { header('Location:/'); }; // Prevent viewing this file
$installPepper = "SI_Lessn";

class SI_Lessn extends Pepper
{
	var $version	= 100;
	var $info		= array
	(
		'pepperName'	=> 'Lessn',
		'pepperUrl'		=> 'http://haveamint.com/',
		'pepperDesc'	=> 'Tracks the most recent and most popular urls and referrers from your Lessn installation. Requires <a href="http://shauninman.com/archive/2009/08/17/less_n">Lessn</a>, the free self-hosted url shortener.',
		'developerName'	=> 'Shaun Inman',
		'developerUrl'	=> 'http://shauninman.com/'
	);
	var $panes		= array
	(
		'Lessn'	=> array
		(
			'Most Popular',
			'Most Recent'
		)
	);
	var $manifest	= array
	(
		'lessn'	=> array
		(
			'id'				=> "INT(10) unsigned NOT NULL auto_increment",
			'referer' 			=> "VARCHAR(255) NOT NULL",
			'referer_checksum' 	=> "INT(10) NOT NULL",
			'url' 				=> "VARCHAR(255) NOT NULL",
			'url_checksum' 		=> "INT(10) NOT NULL",
			'dt'				=> "INT(10) unsigned NOT NULL default '0'"
		)
	);
	
	/**************************************************************************
	 isCompatible()
	 **************************************************************************/
	function isCompatible()
	{
		if ($this->Mint->version < 203)
		{
			$compatible = array
			(
				'isCompatible'	=> false,
				'explanation'	=> '<p>This Pepper requires Mint 2.03. Mint 2, a paid upgrade from Mint 1.x, is available at <a href="http://www.haveamint.com/">haveamint.com</a>.</p>'
			);
		}
		else
		{
			$compatible = array
			(
				'isCompatible'	=> true,
			);
		}
		return $compatible;
	}
	
	/**************************************************************************
	 onDisplay()
	 **************************************************************************/
	function onDisplay($pane, $tab, $column = '', $sort = '')
	{
		$html = '';
		
		switch($pane) 
		{
		/* Lessn **************************************************************/
			case 'Lessn': 
				switch($tab) 
				{
				/* Most Popular ***********************************************/
					case 'Most Popular':
						$html .= $this->getHTML_Popular();
					break;
				/* Most Recent ************************************************/
					case 'Most Recent':
						$html .= $this->getHTML_Recent();
					break;
				}
				break;
		}
		return $html;
	}
	
	/**************************************************************************
	 onCustom()
	 **************************************************************************/
	function onCustom() 
	{
		if 
		(
			isset($_POST['checksum']) && 
			isset($_POST['action']) &&
			$_POST['action']=='getlessnreferrers'
		)
		{
			echo $this->getHTML_Referrers($this->escapeSQL($_POST['checksum'])).' ';
		}
	}
	
	/**************************************************************************
	 getHTML_PagesRecent()
	 **************************************************************************/
	function getHTML_Recent() 
	{
		$html = '';
		
		$tableData['table'] = array('id'=>'','class'=>'');
		$tableData['thead'] = array
		(
			// display name, CSS class(es) for each column
			array('value'=>'Url','class'=>'focus'),
			array('value'=>'When','class'=>'sort')
		);
		
		
		$query = "SELECT `referer`, `url`, `url_checksum`, `dt`
					FROM `{$this->Mint->db['tblPrefix']}lessn` 
					ORDER BY `dt` DESC 
					LIMIT 0,{$this->Mint->cfg['preferences']['rows']}";
					
		if ($result = $this->query($query)) 
		{
			while ($r = mysql_fetch_array($result)) 
			{
				$dt = $this->Mint->formatDateTimeRelative($r['dt']);
				$ref_title	= $this->Mint->abbr($r['referer']);
				$ref_html	= "From <a href=\"{$r['referer']}\" rel=\"nofollow\">$ref_title</a>";
				
				$url_title = $this->Mint->abbr($r['url']);
				
				$url_html = "<a href=\"{$r['url']}\">$url_title</a>";
				
				if (!empty($ref_title) && $this->Mint->cfg['preferences']['secondary'])
				{
					$url_html .= "<br /><span>{$ref_html}</span>";
				}
				
				$tableRow = array
				(
					$url_html,
					$dt
				);
				
				$tableData['tbody'][] = $tableRow;
			}
		}
		
		$html .= $this->Mint->generateTable($tableData);
		return $html;
	}

	/**************************************************************************
	 getHTML_Popular()											ACCORDION-STYLE
	 **************************************************************************/
	function getHTML_Popular() 
	{
		$html = '';
		
		$filters = array
		(
			'Show all'	=> 0,
			'Past hour'	=> 1,
			'2h'		=> 2,
			'4h'		=> 4,
			'8h'		=> 8,
			'24h'		=> 24,
			'48h'		=> 48,
			'72h'		=> 72
		);
		
		$html .= $this->generateFilterList('Most Popular', $filters);
		
		$timespan = ($this->filter) ? "`dt` > ".(time() - ($this->filter * 60 * 60)) : '1';

		$tableData['table'] = array('id'=>'','class'=>'folder');
		$tableData['hasFolders'] = true;
		$tableData['thead'] = array
		(
			// display name, CSS class(es) for each column
			array('value'=>'Hits','class'=>'sort'),
			array('value'=>'Url/Referrers','class'=>'focus'),
			array('value'=>'Referrers','class'=>'sort')
		);
		
		$referrerCounts = array();
		$pageData 		= array();
		
		$query = "SELECT `url_checksum`, COUNT(DISTINCT `referer`) AS `referrers`
					FROM `{$this->Mint->db['tblPrefix']}lessn`
					WHERE `referer_checksum` != 0 AND {$timespan}
					GROUP BY `url_checksum` ORDER BY `referrers` DESC
					LIMIT 0,{$this->Mint->cfg['preferences']['rows']}";
		
		if ($result = $this->query($query)) 
		{
			while ($r = mysql_fetch_assoc($result)) 
			{
				$referrerCounts[$r['url_checksum']] = $r['referrers'];
			}
		}
		
		$query = "SELECT `url`, `url_checksum`, COUNT(`url_checksum`) AS `total`
					FROM `{$this->Mint->db['tblPrefix']}lessn`
					WHERE {$timespan}
					GROUP BY `url_checksum` ORDER BY `total` DESC
					LIMIT 0,{$this->Mint->cfg['preferences']['rows']}";
		if ($result = $this->query($query)) 
		{
			while ($r = mysql_fetch_assoc($result)) 
			{
				$pageData[$r['url_checksum']] = $r;
			}
		}
		
		foreach ($pageData as $checksum => $page)
		{
			$title = $this->Mint->abbr($page['url']);
			$tableData['tbody'][] = array
			(
				$page['total'],
				$title,
				(isset($referrerCounts[$checksum])) ? $referrerCounts[$checksum] : 0,

				'folderargs' => array
				(
					'action'	=> 'getlessnreferrers',
					'checksum'	=> $checksum
				)
			);
		}
		
		$html .= $this->Mint->generateTable($tableData);
		return $html;
	}
	
	/**************************************************************************
	 getHTML_Referrers()
	 **************************************************************************/
	function getHTML_Referrers($checksum)
	{
		$filters = array
		(
			'Show all'	=> 0,
			'Past hour'	=> 1,
			'2h'		=> 2,
			'4h'		=> 4,
			'8h'		=> 8,
			'24h'		=> 24,
			'48h'		=> 48,
			'72h'		=> 72
		);
		$this->generateFilterList('Most Popular', $filters);
		$timespan = ($this->filter) ? "`dt` > ".(time() - ($this->filter * 60 * 60)) : '1';
		
		$html = '';
		$tableData['tbody'] = array();
		$query = "SELECT `referer`, COUNT(`referer`) as `total`, `dt`
					FROM `{$this->Mint->db['tblPrefix']}lessn` 
					WHERE `url_checksum` = '$checksum' AND `referer_checksum` != 0 AND {$timespan}
					GROUP BY `referer_checksum` 
					ORDER BY `total` DESC, `dt` DESC ";
					//LIMIT 0,{$this->Mint->cfg['preferences']['rows']}";
		
		$tableData['classes'] = array
		(
			'sort',
			'focus',
			'sort'
		);
		
		if ($result = $this->query($query))
		{
			while ($r = mysql_fetch_array($result))
			{
				$tableData['tbody'][] = array
				(
					'',
					'<span>From <a href="'.$r['referer'].'" rel="nofollow">'.$this->Mint->abbr($r['referer']).'</a></span>',
					$r['total']
				);
			}
		}
	
		if (empty($tableData['tbody']))
		{
			$tableData['tbody'][] = array
			(
				'',
				'<span>No referrers</span>',
				''
			);
		}
		
		$html .= $this->Mint->generateTableRows($tableData);
		return $html;
	}
}