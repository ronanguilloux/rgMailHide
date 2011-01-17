<?php
//
// Definition of eZMailHideUtils class
//
// Created on: <11-November-2009 23:00:00 ar>
//
// SOFTWARE NAME: eZ Mail Hide
// SOFTWARE RELEASE: 0.1
// COPYRIGHT NOTICE: Copyright (C) 2009 Ronan GUILLOUX
// SOFTWARE LICENSE: GNU General Public License v2.0
// NOTICE: >
//   This program is free software; you can redistribute it and/or
//   modify it under the terms of version 2.0  of the GNU General
//   Public License as published by the Free Software Foundation.
//
//   This program is distributed in the hope that it will be useful,
//   but WITHOUT ANY WARRANTY; without even the implied warranty of
//   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//   GNU General Public License for more details.
//
//   You should have received a copy of version 2.0 of the GNU General
//   Public License along with this program; if not, write to the Free
//   Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
//   MA 02110-1301, USA.
//
//

/*
 A template operators to get access to mailhide API
 */


require_once( "extension/rgmailhide/lib/recaptchalib.php" );


class rgMailHideUtils
{
	function __construct()
	{
	}

	function operatorList()
	{
		return array( 'mailhide' );
	}

	function namedParameterPerOperator()
	{
		return true;
	}

	function namedParameterList()
	{		
		return array(
			'mailhide' => array(	'href' => array( 
									'type' => 'string',
									'required' => true,
									'default' => '' ),
		
									'id' => array( 
									'type' => 'string',
									'required' => false,
									'default' => '' ),
		
									'title' => array( 
									'type' => 'string',
									'required' => false,
									'default' => '' ),
		
									'target' => array( 
									'type' => 'string',
									'required' => false,
									'default' => '' ),
		
									'classification' => array( 
									'type' => 'string',
									'required' => false,
									'default' => '' ),
		
									'hreflang' => array( 
									'type' => 'string',
									'required' => false,
									'default' => '' ),
		
									'content' => array( 
									'type' => 'string',
									'required' => false,
									'default' => '' )
			)
		);
	}

	function modify( $tpl, $operatorName, $operatorParameters, $rootNamespace, $currentNamespace, &$operatorValue, $namedParameters )
	{
		$return = '';

		switch ( $operatorName )
		{
			case 'mailhide':
				{
					$ini = eZINI::instance();
					$keys = $ini->variable( 'MailHideSettings', 'Keys' );									

					$email = (isset($namedParameters['href']) ? trim($namedParameters['href']) : 'nomail@nodomain.com');
					$email = ((substr($email,0,7) === 'mailto:') ? str_replace('mailto:','',$email) : $email);
					
					$id = (isset($namedParameters['id']) ? trim($namedParameters['id']) : '');
					$title = (isset($namedParameters['title']) ? trim($namedParameters['title']) : '');
					$target = (isset($namedParameters['target']) ? trim($namedParameters['target']) : '');
					$classification = (isset($namedParameters['classification']) ? trim($namedParameters['classification']) : '');
					$hreflang = (isset($namedParameters['hreflang']) ? trim($namedParameters['hreflang']) : '');
					$content = (isset($namedParameters['content']) ? trim($namedParameters['content']) : '');
					$html = array($id, $title, $target, $classification, $hreflang, $content);					
					
					$return = recaptcha_mailhide_html ($keys['Public'], $keys['Private'], $email, $html);
				} break;
		}
		$operatorValue = $return;
	}

}

?>
