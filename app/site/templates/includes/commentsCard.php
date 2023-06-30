<?php namespace ProcessWire; 

if (isset($_POST['comment']) && $_POST['randcheck'] == $_SESSION['rand']):
## Random number is used to prevent duplicate submission on refresh. See
## https://stackoverflow.com/a/38768140
	$p = new Page();
	$p->template = 'Comment';
	$p->parent = $thePage;
	$p->of(false);
	$p->set("title", $sanitizer->text($input->post->title));
	$p->set("contentPublic", $sanitizer->text($input->post->comment));
	$p->set("contentDate", date("Y-m-d"));
	$p->set("approvedFlg", 0);
	$p->set("personRef", $users->getCurrentUser());
	$p->save();
endif;

if ($page->template != "AJAX"):
	$thePage = $page;
else:
	$thePage = $pages->get(getPV("currentPage"));
endif;

echo "\n<region id='mrCommentsCard'>";
$comments = [];
$comments = $thePage->children("template=Comment, approvedFlg=1, !contentPublic=''");	## All approved public comments
$comments->add($thePage->children("template=Comment, personRef=$user, sort=-sort"));	## Plus all comments by current user
$ct = $comments->count();
if (($ct > 0) && (!getPV("hideCommentsDetailFlg"))):
	$comments->sort("-created");	## Most recent on top
	$detail = "<div id='commentDiv'>";
	foreach ($comments as $comment):
##		$comment->of(false);
		$detail .=  "<h5 class='commentInfo'>" . $comment->contentDate . "  <span class='comm'>⟡</span>  " . $comment->personRef->titleLong . "  <span class='comm'>⟡</span>  " . $comment->title . $comment->if("approvedFlg", "", "  <span class='comm'>⟡</span>  ••pending approval••") . "</h5><div class='commentText ";
		switch ($comment->personRef->titleShort):
		case "CT":
			$detail .= "ct'>" . $comment->contentPublic . $thePage->feetnote(4);
			break;
		case "JRRT":
			$detail .= "jrrt'>" . $comment->contentPublic . $thePage->feetnote(5);
			break;
		endswitch;
		$detail .= "</div><hr class='inter comm'>";
	endforeach;
	$detail .= "</div>";
else:
	$detail = "";
endif;
## Popup for adding new comments
if ($user->isLoggedin() && !getPV("hideCommentsDetailFlg")):
	$rand = rand();
	$_SESSION['rand'] = $rand;
	$detail .= "
<div id='commentButtonContainer'><button type='button' data-bs-toggle='modal' data-bs-target='#commentModal'>Add comment</button> <div class='modal fade' id='commentModal' tabindex='-1' aria-labelledby='commentModalLabel' aria-hidden='true'> <div class='modal-dialog'> <div class='modal-content'> <div class='modal-header'> <h3 class='modal-title' id='commentModalLabel'> Add comment </h3> </div> <div class='modal-body'> <form role='form' method='post' action='./'> <input type='hidden' value='{$rand}' name='randcheck'> <label for='title'>Title:<br> <input type='text' name='title' required> </label><br> <br> <label for='comment'>Comment:<br> <textarea name='comment' required></textarea> </label><br> <div class='comFormBtns'> <button type='button' data-bs-dismiss='modal'>Cancel</button> <input type='submit' value='OK'> </div> </form> </div> </div> </div> </div> </div>
	";
endif;

$shown = getPV("hideCommentsDetailFlg") ? "hidden" : "shown";
$html = "<div id='tcComments' class='card comments {$shown}'><h2 class='comm'><span class='htmx' hx-put='/verso/commentscard' hx-swap='outerHTML' hx-target='#tcComments'>";
if (is_null($comments)):
	$ct = 0;
else:
	$ct = $comments->count();
endif;

$html .= "<span class='sc'>" . $ct . "</span> " . ngettext("comment", "comments", $ct);
echo $html . "</span></h2>" . $detail . "</div>";
echo "</region><!--#mrCommentsCard-->\n";
