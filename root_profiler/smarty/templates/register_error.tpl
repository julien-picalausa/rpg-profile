{*
  register_error.tpl

  3EProfiler (tm) template file.
  Copyright (C) 2003 Michael J. Eggertson.

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

  **

  Error document for 3EProfiler registration.
*}

<h1>Error</h1>

<p>
  Your profile could not be created. Note the errors below, then return
  and try to <a href="javascript:history.back(1)">register</a>
  again after fixing the errors.
</p>
<ul>
{foreach from=$messages item=msg}
  <li>{$msg}</li>
{/foreach}
</ul>
