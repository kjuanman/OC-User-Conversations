<?php

/**
* ownCloud - User Conversations
*
* @author Simeon Ackermann
* @copyright 2014 Simeon Ackermann amseon@web.de
* 
* This library is free software; you can redistribute it and/or
* modify it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE
* License as published by the Free Software Foundation; either 
* version 3 of the License, or any later version.
* 
* This library is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU AFFERO GENERAL PUBLIC LICENSE for more details.
*  
* You should have received a copy of the GNU Affero General Public 
* License along with this library.  If not, see <http://www.gnu.org/licenses/>.
* 
*/

// Check if we are a user
OCP\User::checkLoggedIn();
OCP\App::checkAppEnabled('conversations');

OCP\App::setActiveNavigationEntry( 'conversations' );

// register js and css
OCP\Util::addscript('conversations','conversations');
OCP\Util::addScript('conversations', 'jquery.infinitescroll.min');
OCP\Util::addScript('conversations', 'jquery.autosize.min');
OCP\Util::addstyle('conversations', 'style');

// rooms
$rooms = OC_Conversations::getRooms();

// get the page that is requested. Needed for endless scrolling
$count = 5;
if (isset($_GET['page'])) {
	$page = intval($_GET['page']) - 1;
} else {
	$page = 0;
}
$nextpage = \OCP\Util::linkToAbsolute('conversations', 'index.php', array('page' => $page + 2));

$tmpl = new OCP\Template( 'conversations', 'main', 'user' );
if ( count($rooms) > 1 ) $tmpl->assign( 'rooms' , $rooms );
if ($page == 0) $tmpl->assign('nextpage', $nextpage);
$tmpl->assign( 'active_room' , OC_Conversations::getRoom() );
$tmpl->assign( 'conversation' , OC_Conversations::getConversation($page * $count, $count) );

$tmpl->printPage();