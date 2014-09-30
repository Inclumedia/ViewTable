<?php
if ( !defined( 'MEDIAWIKI' ) ) {
   die( 'This file is a MediaWiki extension. It is not a valid entry point' );
}

class SpecialViewTable extends SpecialPage {
   function __construct( ) {
      parent::__construct( 'ViewTable' );
   }

   public function userCanExecute( User $user ) {
      return true;
   }

   function execute( $par ) {
      $this->setHeaders();
      $viewOutput = $this->getOutput();
      $output = '';
      $empty = false;
      $user = $this->getUser();
      if ( !$user->isAllowed( 'viewtable' ) ) {
         throw new PermissionsError( null, array( array(
            'viewtable-notallowed' ) ) );
      }
      $dbr = wfGetDB( DB_SLAVE );
      $res = $dbr->query( 'SHOW TABLES' );
      $tables = array();
      foreach ( $res as $row ) {
         foreach ( $row as $innerRow ) {
            $tables[] = $innerRow;
         }
      }
      if ( $par !== 'all' && !in_array( $par, $tables ) ) {
         $res = $dbr->query( 'SHOW TABLES' );
         $viewOutput->addWikiMsg( "viewtable-selectatable" );
         foreach ( $tables as $table ) {
            $output .= "[[:Special:ViewTable/$table|$table]]<br/>";
         }
      } else {
         if ( $par !== 'all' ) {
            $tables = array( $par );
         }
         $viewOutput->addWikiMsg( "viewtable-backtotablelist" );
         foreach ( $tables as $table ) {
            $output .= "==$table==\n";
            $res = $dbr->select( $table, '*' );
            $output .= "{|class=\"wikitable\"\n|-\n";
            foreach ( $res as $row ) {
               $arr = viewTableObjectToArray( $row );
               foreach ( $arr as $key => $value ) {
                  $output .= "!$key\n";
               }
               break;
            }
            $empty = true;
            foreach ( $res as $row ) {
               $output .= "|-\n";
               foreach ( $row as $key => $value ) {
                  $output .= "|<nowiki>$value</nowiki>\n";
               }
               $empty = false;
            }
            $output .= "|}\n";
            if ( $empty ) {
                  $output .= "Table \"$table\" is empty.\n";
            }
         }
      }
      $viewOutput->addWikiText( $output );
      return $output;
   }
}