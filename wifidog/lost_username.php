<?php
  // $Id$
  /********************************************************************\
   * This program is free software; you can redistribute it and/or    *
   * modify it under the terms of the GNU General Public License as   *
   * published by the Free Software Foundation; either version 2 of   *
   * the License, or (at your option) any later version.              *
   *                                                                  *
   * This program is distributed in the hope that it will be useful,  *
   * but WITHOUT ANY WARRANTY; without even the implied warranty of   *
   * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the    *
   * GNU General Public License for more details.                     *
   *                                                                  *
   * You should have received a copy of the GNU General Public License*
   * along with this program; if not, contact:                        *
   *                                                                  *
   * Free Software Foundation           Voice:  +1-617-542-5942       *
   * 59 Temple Place - Suite 330        Fax:    +1-617-542-2652       *
   * Boston, MA  02111-1307,  USA       gnu@gnu.org                   *
   *                                                                  *
   \********************************************************************/
  /**@file
   * Login page
   * @author Copyright (C) 2004 Benoit Gr�goire et Philippe April
   */
define('BASEPATH','./');
require_once BASEPATH.'include/common.php';
require_once BASEPATH.'include/common_interface.php';
require_once BASEPATH.'classes/User.php';

if (isset($_REQUEST["submit"])) {
    try {
        if (!$_REQUEST["email"])
            throw new Exception(_("Please specify an email address"));
    
    	// Get a list of User objects and send mail messages to them.
        $users_list = User::getUsersByEmail($_REQUEST['email']);
        foreach($users_list as $user)
        	$user->sendLostUsername();
        	
        $smarty->assign("message", _("Your username has been emailed to you."));
        $smarty->display("templates/validate.html");
        exit;
    } catch (Exception $e) {
        $smarty->assign("error", $e->getMessage());
    }
}

$smarty->display("templates/lost_username.html");
?>
