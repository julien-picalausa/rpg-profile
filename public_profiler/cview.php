<?php
  // cview.php

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

  include_once("config.php");
  include_once("$INCLUDE_PATH/template.class.php");
  include_once("$INCLUDE_PATH/engine/sid.php");
  include_once("$INCLUDE_PATH/engine/db.php");
  include_once("$INCLUDE_PATH/error.php");
  include_once("$INCLUDE_PATH/engine/templates.php");

  // Check to see if we need to log the user in (check this before the
  // session cookie, because a new login should always override an
  // existing session).

  // The session object that will be used through the script.
  $sid = null;

  if (isset($_POST['user']) || isset($_POST['pwd']))
  {
    // Login info was passed to the script.

    // Attempt to generate a new session.
    $sid = new SId(false);
    if (!$sid->SpawnSession())
    {
      // Login has failed, show an error.
      $T = new Template();
      $T->assign('title', 'RPG Web Profiler Error');
      $T->SetBodyTemplate('login_error.tpl');
      $T->send();
      exit;
    }
  }

  // At this point, either the user has successfully logged in, or is
  // returning to the page from another page.

  // Respawn the session if necessary and draw the character options (the
  // session may already exist from checking _POST info).
  if ($sid == null)
    $sid = RespawnSession(__LINE__, __FILE__);
  $T = new Template();
  $T->assign('title', 'Character Options');
  $T->SetBodyTemplate('cview.tpl');
  $T->AssignSession($sid);
  $T->assign('characters', $sid->GetCharacters());
  $T->assign('templates', generate_template_array());
  $T->send();
?>
