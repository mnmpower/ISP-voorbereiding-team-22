<?php
// Functions get all plugins required for page
function getPlugin($plugin) {
    switch ($plugin) {
        case 'fullCalendar':
            $lines = array(
            "<link href='" . base_url() . "assets/css/fullcalendar.css' rel='stylesheet' />",
            "<link href='" . base_url() . "assets/css/scheduler.css' rel='stylesheet' />",
            "<script src='" . base_url() . "assets/js/moment.js'></script>",
            "<script src='" . base_url() . "assets/js/fullcalendar.js'></script>",
            "<script src='" . base_url() . "assets/js/scheduler.js'></script>",
            "<script src='" . base_url() . "assets/js/nl-be.js'></script>");
            break;
		case 'table':
			$lines = array(
				"<link href='https://unpkg.com/bootstrap-table@1.14.2/dist/bootstrap-table.min.css' rel='stylesheet' />",
				"<script src='https://unpkg.com/bootstrap-table@1.14.2/dist/bootstrap-table.min.js'></script>"
			);
			break;

        case 'geen':
            $lines = array('<!--None-->');
            break;
        default:
            $lines = array("default");
    }
    return $lines;
}
