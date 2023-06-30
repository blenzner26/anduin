<?php namespace ProcessWire;

/* PARENTAGE

Within the context of Marquette’s collection (and therefore within “Shelfmark”s in Anduin), pages are also called folios.

A page object’s functions may be found here:
- site/classes/PagePage.php

A pages’s OOP parent is tcPage:
- site/classes/tcPage.php

A page’s parent in ProcessWire is the “Shelfmark” template:
- site/templates/Shelfmark.php

And that *parent’s* OOP class is:
- site/classes/ShelfmarkPage.php

It may also be assigned to 0 to N *drafts*, but those are by reference, not parentage:
- site/classes/DraftPage.php
- site/templates/Draft.php

*/

// Anything added below will show up at the VERY BOTTOM of all page pages in Anduin:
