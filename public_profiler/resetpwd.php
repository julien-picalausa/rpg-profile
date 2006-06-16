<?php
  // resetpwd.php

  // 3EProfiler (tm) source file.
  // Copyright (C) 2003 Michael J. Eggertson.

  // This program is free software; you can redistribute it and/or modify
  // it under the terms of the GNU General Public License as published by
  // the Free Software Foundation; either version 2 of the License, or
  // (at your option) any later version.

  // This program is distributed in the hope that it will be useful,
  // but WITHOUT ANY WARRANTY; without even the implied warranty of
  // MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  // GNU General Public License for more details.

  // You should have received a copy of the GNU General Public License
  // along with this program; if not, write to the Free Software
  // Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

  // **

  // Handles resetting a user's password in case they forget/misplace it.
  // Three cases are handled:
  //  1: No _GET info is passed -> A general form is shown.
  //  2: Content is passed to _GET['p'] -> An email is sent to the user specified
  //     by the profile in the query string.
  //  3: Content is passed to _GET['p'] and _GET['k'] -> Key is compared to db,
  //     and user is shown a form for changing the password. Actual password change
  //     is done by the changepwd.php script.

  include_once("config.php");
  include_once("$INCLUDE_PATH/engine/db.php");
  include_once("$INCLUDE_PATH/template.class.php");
  include_once("$INCLUDE_PATH/engine/validation.php");
  include_once("$INCLUDE_PATH/engine/id.class.php");
  include_once("$INCLUDE_PATH/error.php");

  ////////////////////////////////////////////////////////////////////////
  if ($_GET['p'] && $_GET['k'])
  {
    // Got a profile name and a key, show the reset password form.
    
    $pname = $_GET['p'];
    $err_dummy = array();
    if (!is_valid_pname($pname, $err_dummy))
      __printFatalErr("Invalid profile name.");

    $key = $_GET['k'];
    $keygen = new Id();
    if (!$keygen->ValidateId($key))
      __printFatalErr("Invalid key.");

    // Check the key against the db.
    $_r = mysql_query(sprintf("SELECT pname FROM %s WHERE pname = '%s' AND pwd_key = '%s'",
      $TABLE_USERS,
      addslashes($pname),
      addslashes($key)));
    if (!$_r)
      __printFatalErr("Failed to query database.", __LINE__, __FILE__);
    if (mysql_num_rows($_r) != 1)
    {
      // The key is no longer valid.
      $T = new Template();
      $T->assign('title', 'Error');
      $T->SetBodyTemplate('resetpwd_invalidkey.tpl');
      $T->send();
    }
    else
    {
      // The key is still valid, show the change password form.
      $T = new Template();
      $T->assign('title', 'New Password');
      $T->assign('pname', $pname);
      $T->assign('key', $key);
      $T->SetBodyTemplate('resetpwd_passwordform.tpl');
      $T->send();
    }
  }

  ////////////////////////////////////////////////////////////////////////
  else if ($_GET['p'])
  {
    // Only got a profile name: send off an email message and show the
    // user a message saying to check their mail.

    $pname = $_GET['p'];
    $err_dummy = array();
    if (!is_valid_pname($pname, $err_dummy))
      __printFatalErr("Invalid profile name.");

    // Attempt to retrieve the email for the profile.
    $_r = mysql_query(sprintf("SELECT email FROM %s WHERE pname = '%s'",
      $TABLE_USERS,
      addslashes($pname)));
    if (!$_r)
      __printFatalErr("Failed to query database.", __LINE__, __FILE__);
    if (mysql_num_rows($_r) != 1)
      __printFatalErr("Profile not found.");

    // Make sure the email address is not null.
    $r = mysql_fetch_row($_r);
    $email = $r[0];
    if (!is_valid_email($email, $err_dummy))
      __printFatalErr("An invalid or non-existent email address was found in your profile.");

    // Generate a key and put it in the db.
    $keygen = new Id();
    $id = $keygen->GenerateId();
    $_r = mysql_query(sprintf("UPDATE %s SET pwd_key = '%s' WHERE pname = '%s' LIMIT 1",
      $TABLE_USERS,
      addslashes($id),
      addslashes($pname)));
    if (!$_r)
      __printFatalErr("Failed to update database.", __LINE__, __FILE__);
    if (mysql_affected_rows() != 1)
      __printFatalErr("Failed to update profile.", __LINE__, __FILE__);

    // Send off the message.
    $to = $email;
    $from = "From: $EMAIL_WEBMASTER";
    $subject = "RPG Web Profiler password reset.";
    $body = "$pname,\n\nYour RPG Web Profiler password at $URI_HOME was recently requested to be reset. To complete the process, visit the link below and follow the directions that 3EProfiler asks.\n\n$URI_BASE/resetpwd.php?p=$pname&k=$id\n\nIf you never requested your password to be reset, please disregard this message. No information was given to the person requesting your password.";
    if (!mail($to, $subject, $body, $from))
      __printFatalErr("Failed to send email to address listed in profile.");

    // Send a success message.
    $T = new Template();
    $T->assign('title', 'Reset Password');
    $T->assign('pname', $pname);
    $T->SetBodyTemplate('resetpwd_checkmail.tpl');
    $T->send();
  }

  ////////////////////////////////////////////////////////////////////////
  else
  {
    // No proper query received: show a form allowing the user to give
    // their profile name.
    $T = new Template();
    $T->assign('title', 'Reset Password');
    $T->SetBodyTemplate('resetpwd.tpl');
    $T->send();
  }
?>