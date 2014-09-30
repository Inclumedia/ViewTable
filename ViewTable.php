<?php
/**
 * ViewTable MediaWiki extension.
 *
 * Written by Leucosticte
 * https://www.mediawiki.org/wiki/User:Leucosticte
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @file
 * @ingroup Extensions
 */

if( !defined( 'MEDIAWIKI' ) ) {
        echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
        die( 1 );
}

$wgExtensionCredits['specialpage'][] = array(
        'path' => __FILE__,
        'name' => 'ViewTable',
        'author' => 'Nathan Larson',
        'url' => 'https://mediawiki.org/wiki/Extension:ViewTable',
        'descriptionmsg' => 'viewtable-desc',
        'version' => '1.0.0'
);

#$wgExtensionMessagesFiles['ViewTable'] = __DIR__ . '/ViewTable.i18n.php';
$wgAutoloadClasses['SpecialViewTable'] = __DIR__ . '/SpecialViewTable.php';
$wgSpecialPages['ViewTable'] = 'SpecialViewTable';
$wgSpecialPageGroups['ViewTable'] = 'other';
$wgGroupPermissions['bureaucrat']['viewtable'] = true;
$wgMessagesDirs['ViewTable'] = __DIR__ . '/i18n';
$wgExtensionMessagesFiles['ViewTableAlias'] = __DIR__ . '/ViewTable.alias.php';
function viewTableObjectToArray( $d ) {
      if (is_object($d)) {
              // Gets the properties of the given object
              // with get_object_vars function
              $d = get_object_vars($d);
      }

      if (is_array($d)) {
         /*
         * Return array converted to object
         * Using __FUNCTION__ (Magic constant)
         * for recursive call
         */
         return array_map(__FUNCTION__, $d);
      } else {
         // Return array
         return $d;
      }
}