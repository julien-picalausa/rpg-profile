{*
  adminsearch_results.php

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
*}

<h1>Admin Search Results</h1>
<table>
  <thead>
    <tr>
      <th>{$ch_name}</th><th>{$ls_mod}</th><th>Template</th>
    </tr>
  </thead>
  <tbody>
    {section name="i" loop="$characters"}
      <tr><td><a href="adminview.php?id={$characters[i].id}">{$characters[i].cname}</a></td><td>{$characters[i].lastedited}</td><td>{$characters[i].template}</td></tr>
    {sectionelse}
      <tr><td colspan="2">No characters found!</td></tr>
    {/section}
  </tbody>
</table>

{if $prevpage}
  <a href="adminsearch.php?type={$type}&amp;cname={$cname}&amp;page={$prevpage}{$np}">&lt; Previous</a>
  {if $nextpage}|{/if}
{/if}
{if $nextpage}
  <a href="adminsearch.php?type={$type}&amp;cname={$cname}&amp;page={$nextpage}{$np}">Next &gt;</a>
{/if}
<br><br>
<h1>AdminSearch</h1>
<form action="adminsearch.php" method="get">
<p>
  Search for a character whose name <select name="type" class="quick">
 <option value="begins">begins with</option>
 <option value="contains">contains</option>
 <option value="ends">ends with</option>
 <option value="all">all entires</option>
  </select>
 <input type="text" name="cname" maxlength="20" class="quick" />
 <input type="submit" value="Search" class="go" />
</p>
