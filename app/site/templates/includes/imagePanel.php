<?php namespace ProcessWire;
if (str_starts_with($page->template, 'AJAX')):
	$thePage = $pages->get(getPV("currentPage"));
else:
	$thePage = $page;
endif;
?>

<region id='mrImage'>
<div id='imagePanel' class='imagePanel'>
<?php
/*
if (UserCanViewImages()):
	$server = trim(file_get_contents('../assets/addresses/image-server.txt'));
	$mix = GetPV("mixBlendMode") ?: "no";
	$imgPath = "http://" . $server . "/3/" . $thePage->title . ".png";
	echo
		"<div id='theScan'><script>setImage('" . $imgPath . "');</script>
		<img src='" . $imgPath . "' alt='a photograph of this document' class='scan " . $mix . "' onclick='openImageModal()'>
		<div class='modal fade' id='imageModal' tabindex='-1' aria-labelledby='imageModalLabel' aria-hidden='true'>
		<div class='modal-dialog'><div class='modal-content'><div class='modal-body' id='manuscript-container'>
		<img class='modal-close-btn' id='closeBtn' src='/site/templates/scripts/openseadragon/images/close-btn.png' alt='close image viewer' onclick='closeModal()'>
		</div></div></div></div></div>";
	echo "<div class='mb'>";
	echo "<button type='button' class='mix' hx-put='/verso/setscanmixblendnormal/' hx-target='#imagePanel' hx-swap='innerHTML'><img class='no' src='" . $imgPath . "' alt='normal' title='normal'></button>";
	echo "<button type='button' class='mix' hx-put='/verso/setscanmixblendcolorburn/' hx-target='#imagePanel' hx-swap='innerHTML'><img class='cb' src='" . $imgPath . "' alt='color burn' title='color burn'></button>";
	echo "<button type='button' class='mix' hx-put='/verso/setscanmixblenddifference/' hx-target='#imagePanel' hx-swap='innerHTML'><img class='df' src='" . $imgPath . "' alt='difference' title='difference'></button>";
	echo "<button type='button' class='mix' hx-put='/verso/setscanmixblenddarken/' hx-target='#imagePanel' hx-swap='innerHTML'><img class='dk' src='" . $imgPath . "' alt='darken' title='darken'></button>";
	echo "<button type='button' class='mix' hx-put='/verso/setscanmixblendexclusion/' hx-target='#imagePanel' hx-swap='innerHTML'><img class='ex' src='" . $imgPath . "' alt='exclusion' title='exclusion'></button>";
	echo "<button type='button' class='mix' hx-put='/verso/setscanmixblendhardlight/' hx-target='#imagePanel' hx-swap='innerHTML'><img class='hl' src='" . $imgPath . "' alt='hard light' title='hard light'></button>";
	echo "<button type='button' class='mix' hx-put='/verso/setscanmixblendluminosity/' hx-target='#imagePanel' hx-swap='innerHTML'><img class='lu' src='" . $imgPath . "' alt='luminosity' title='luminosity'></button>";
	echo "<button type='button' class='mix' hx-put='/verso/setscanmixblendmultiply/' hx-target='#imagePanel' hx-swap='innerHTML'><img class='mu' src='" . $imgPath . "' alt='multiply' title='multiply'></button>";
	echo "<button type='button' class='mix' hx-put='/verso/setscanmixblendoverlay/' hx-target='#imagePanel' hx-swap='innerHTML'><img class='ov' src='" . $imgPath . "' alt='overlay' title='overlay'></button>";
	echo "<button type='button' class='mix' hx-put='/verso/setscanmixblendplusdarker/' hx-target='#imagePanel' hx-swap='innerHTML'><img class='pd' src='" . $imgPath . "' alt='plus darker' title='plus darker'></button>";
	echo "</div>";
else:
	$rootpage = $pages->findOne("id=1");
	if (!is_null($rootpage->likenesses)):
		echo "<div id='theScan'><img class='scan " . $mix . "' src='{$rootpage->likenesses->first()->url}' alt='A placeholder image'></div>";
	endif;
endif;
*/

echo $page->markupItsLikeness();

?>
</div>
</region><!--mrImage-->