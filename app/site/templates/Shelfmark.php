<?php namespace ProcessWire;

/* PARENTAGE

A shelfmark object’s functions may be found here:
- site/classes/ShelfmarkPage.php

A shelfmark’s OOP parent is tcPage:
- site/classes/tcPage.php

A shelfmark’s parent in ProcessWire is either another “Shelfmark” template
(true for folders, boxes, and subseries):
- site/templates/Shelfmark.php

Or a “Work” template (true for series):
- site/templates/Work.php

And that *parent’s* OOP class is either:
- site/classes/ShelfmarkPage.php or
- site/classes/WorkPage.php or

*/

// Anything added below will show up at the VERY BOTTOM of all shelfmark pages in Anduin:
