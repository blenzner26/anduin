<?php namespace ProcessWire;

include('../../index.php'); //bootstrap PW

if (($handle = fopen("LotR04.csv", "r")) !== FALSE):
    while (($data = fgetcsv($handle, 0, ",", '"')) !== FALSE):
        $UID = $data[0];
        $series = $data[1];
        $subseries = $data[2];
        $box = $data[3];
        $folder = $data[4];
        $folio = $data[5];
        $side = $data[6];
        $CTlabel = $data[7];
        $notes = $data[8];
        $filename = $data[9];

        if ($series == ""):
            $series = "0";
        endif;
        if ($subseries == ""):
            $subseries = "0";
        endif;
        if ($box == ""):
            $box = "0";
        endif;
        if($folder == ""):
            $folder = "0";
        endif;

        // Series
        $page = $pages->findOne("template=Shelfmark, series=$series, subseries='', box='', folder=''");
        if ($page instanceof NullPage):
            $page = $pages->add('Shelfmark', "/", [
                'series' => $series,
                'name' => $series,
                'title' => "Series " . $series
            ]);
        endif;

        //Subseries
        $page = $pages->findOne("template=Shelfmark, series=$series, subseries=$subseries, box='', folder=''");
        if ($page instanceof NullPage):
            if($subseries == "0"):
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

        //Box
        $page = $pages->findOne("template=Shelfmark, series=$series, subseries=$subseries, box=$box, folder=''");
        if ($page instanceof NullPage):
            if($subseries == "0"):
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

        //Folder
        $page = $pages->findOne("template=Shelfmark, series=$series, subseries=$subseries, box=$box, folder=$folder");
        if ($page instanceof NullPage):
            if($subseries == "0"):
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

        // Page
        $page = $pages->findOne("template=Page, title=$UID");
        if ($page instanceof NullPage):
            if ($subseries == "0"):
                $titleLong = $series . "/" . $box . "/" . $folder . "/" . $folio . $side;
            else:
                $titleLong = "MSS-" . $subseries . "/" . $box . "/" . $folder . "/" . $folio . $side;
            endif;
            $page = $pages->add('Page', "/". $series . "/" . $subseries . "/" . $box . "/" . $folder . "/",[
                'title' => $UID,
                'series' => $series,
                'subseries' => $subseries,
                'box' => $box,
                'folder' => $folder,
                'folio' => $folio,
                'side' => $side,
                'labelsCT' => [$CTlabel],
                'titleLong' => $titleLong,
                'notes' => $notes,
                'filename' => $filename
            ]);
        endif;
    endwhile;
    fclose($handle);
endif;
?>