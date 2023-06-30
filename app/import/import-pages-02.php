<?php namespace ProcessWire;

include('../../index.php'); // bootstrap PW

if (($handle = fopen("pages-05.csv", "r")) !== FALSE):  // open file read-only
    while (($data = fgetcsv($handle, 0, ",", '"')) !== FALSE):
              $UID = $data[0];
           $series = $data[1];
        $subseries = $data[2];
              $box = $data[3];
           $folder = $data[4];
            $folio = $data[5];
             $side = $data[6];
          $version = $data[7];
             $form = $data[8];
         $filename = $data[9];
        $shelfmark = $data[10];
            $notes = $data[11];
  $versoIsBlankFlg = $data[12];
  $studentEssayFlg = $data[13];
	 $scanVersoFlg = $data[14];
        $rescanFlg = $data[15];
     $rescanReason = $data[16];
$CTNoteWithOrigsFolderFlg = $data[17];
$CTLetterWithCopiesFolderFlg = $data[18];
$photocopyInOrigsFolderFlg = $data[19];
     $label1Author = $data[20];
    $label1Context = $data[21];
    $label1Content = $data[22];
     $label2Author = $data[23];
    $label2Context = $data[24];
    $label2Content = $data[25];
     $label3Author = $data[26];
    $label3Context = $data[27];
    $label3Content = $data[28];
     $label4Author = $data[29];
    $label4Context = $data[30];
    $label4Content = $data[31];

/*
// Series
        $theCount = $pages->count("template=Shelfmark, series=$series, subseries='', box='', folder=''");
		if ($theCount > 0):
        	$page = $pages->add('Shelfmark', "/", [
        		'series' => $series,
        		'name' => $series,
        		'title' => "Series " . $series
        	]);
        endif;

// Subseries
        $theCount = $pages->count("template=Shelfmark, series=$series, subseries=$subseries, box='', folder=''");
		if ($theCount > 0):
			if ($subseries == "0"):
				$title = "";
			else:
				$title = "MSS-" . $subseries;
			endif;
        	$page = $pages->add('Shelfmark', "/" . $series . "/", [
        		'series' => $series,
        		'subseries' => $subseries,
        		'name' => $subseries,
        		'title' => $title
        	]);
        endif;

// Box
        $theCount = $pages->count("template=Shelfmark, series=$series, subseries=$subseries, box=$box, folder=''");
		if ($theCount > 0):
        	if ($subseries == "0"):
        		$title = $series . "/" . $box;
        	else:
        		$title = "MSS-" . $subseries . "/" . $box;
        	endif;
        	$page = $pages->add('Shelfmark', "/" . $series . "/" . $subseries . "/", [
        		'series' => $series,
        		'subseries' => $subseries,
        		'box' => $box,
        		'name' => $box,
        		'title' => $title
        	]);
        endif;

// Folder
        $theCount = $pages->count("template=Shelfmark, series=$series, subseries=$subseries, box=$box, folder=$folder");
		if ($theCount > 0):
        	if ($subseries == "0"):
        		$title = $series . "/" . $box . "/" . $folder;
        	else:
        		$title = "MSS-" . $subseries . "/" . $box . "/" . $folder;
        	endif;
        	$page = $pages->add('Shelfmark', "/" . $series . "/" . $subseries . "/" . $box . "/", [
        		'series' => $series,
        		'subseries' => $subseries,
        		'box' => $box,
        		'folder' => $folder,
        		'name' => $folder,
        		'title' => $title
        	]);
        endif;
*/

// Page
		$page = $pages->findOne("template=Page, title=$UID");
		if ($page instanceof NullPage):
        	$page = $pages->add('Page', "/" . $series . "/" . $subseries . "/" . $box . "/" . $folder . "/", [
        		    'title' => $UID,
        		'titleLong' => $shelfmark,
        		     'form' => $form,
        		   'series' => $series,
        		'subseries' => $subseries,
        		      'box' => $box,
        		   'folder' => $folder,
        		    'folio' => $folio,
        		     'side' => $side,
        		  'version' => $version,
        		    'notes' => $notes,
        		 'filename' => $filename,
        		'titleLong' => $shelfmark,
          'versoIsBlankFlg' => $versoIsBlankFlg,
          'studentEssayFlg' => $studentEssayFlg,
             'scanVersoFlg' => $scanVersoFlg,
                'rescanFlg' => $rescanFlg,
             'rescanReason' => $rescanReason,
 'CTNoteWithOrigsFolderFlg' => $CTNoteWithOrigsFolderFlg,
 'CTLetterWithCopiesFolderFlg' => $CTLetterWithCopiesFolderFlg,
 'photocopyInOrigsFolderFlg' => $photocopyInOrigsFolderFlg
        	]);

			$page->of(false);
			if ($label1Author !=""):
				$item = $page->labels->getNewItem();
				$item->setMatrixType('label');
				$item->author = $label1Author;
				$item->context = $label1Context;
				$item->contentPublic = $label1Content;
				$item->save();
			endif;
			if ($label2Author !=""):
				$item = $page->labels->getNewItem();
				$item->setMatrixType('label');
				$item->author = $label2Author;
				$item->context = $label2Context;
				$item->contentPublic = $label2Content;
				$item->save();
			endif;
			if ($label3Author !=""):
				$item = $page->labels->getNewItem();
				$item->setMatrixType('label');
				$item->author = $label3Author;
				$item->context = $label3Context;
				$item->contentPublic = $label3Content;
				$item->save();
			endif;
			if ($label4Author !=""):
				$item = $page->labels->getNewItem();
				$item->setMatrixType('label');
				$item->author = $label4Author;
				$item->context = $label4Context;
				$item->contentPublic = $label4Content;
				$item->save();
			endif;
			$page->save();
		endif;
    endwhile;
    fclose($handle);
endif;
