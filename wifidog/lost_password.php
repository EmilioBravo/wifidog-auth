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

if (isset($_REQUEST['submit'])) {
    if (!$_REQUEST['username'] && !$_REQUEST['email']) {
        $smarty->assign("error", _("Please specify a username or email address"));
    } else {
        $username = $db->EscapeString($_REQUEST['username']);
        $email = $db->EscapeString($_REQUEST['email']);

        try {
        	// Get a list of users associated with either a username of an e-mail
            $username && $users_list = User::getUsersByUsername($username);
            $email && $users_list = User::getUsersByEmail($email);
            
            // In the case that both previous function calls failed to return a users list
            // Throw an exception
            if(!empty($users_list))
	            foreach($users_list as $user)
	            	$user->sendLostPasswordEmail();
	        else
	        	throw new Exception(_("user_id '{$object_id_str}' could not be found in the database"));
            	
            $smarty->assign('message', _('A new password has been emailed to you.'));
            $smarty->display('templates/validate.html');
            exit;
        } catch (Exception $e) {
            $smarty->assign("error", $e->getMessage());
        }
    }
}

$smarty->display("templates/lost_password.html");
?>
