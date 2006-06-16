// class.js

// 3EProfiler (tm) character sheet source file.
// Copyright (C) 2003  Michael J. Eggertson.
// 
// This program is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License, or
// (at your option) any later version.
// 
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// 
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

// **

// Implements global functions relating to the class input.

// Dependencies:
//    ogl/class.js

function _getClassBitSet()
{
  // Determine which classes the character has and return the bitset.
  var classes = sheet().Class.value.toLowerCase().split("/");
  var classbits = 0;
  for (var i in classes)
    if (classIndex[classes[i]])
      classbits |= classIndex[classes[i]];
  return classbits;
}
