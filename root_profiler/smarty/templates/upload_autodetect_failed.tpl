{*
  upload_autodetect_failed.tpl

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

  Displays a screen saying the autodetect failed, and gives the user
  an option to select the file format.
*}

<h1>Autodetect Failed</h1>
<form action="upload.php" method="post" enctype="multipart/form-data">
  <p>
    3EProfiler could not determine which type of file you were trying to upload.
    Please select the proper format and try to upload the file again.
  </p>
  <p>
    <input type="hidden" name="MAX_FILE_SIZE" value="5120000" />
    <input type="hidden" name="id" value="{$id}" />
    Upload File: <input type="file" name="userfile" />
    Using Format: <select name="format" class="quick">{section name=fmt loop=$formats}<option value="{$formats[fmt].id}">{$formats[fmt].title}</option>{/section}</select>
    <input type="submit" value="Upload" class="go" />
  </p>
</form>
