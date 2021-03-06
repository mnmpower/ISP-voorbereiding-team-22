<?php
// Function determines buttons for each role in the navbar
function getNavbar($role) {
    switch ($role) {
        case 'student':
            $buttons = array(   'Home' =>site_url() . '/home/index');
            break;

        case 'docent':
            $buttons = array(   'Home' =>site_url() . '/home/index');
            break;

        case 'ispverantwoordelijke':
            $buttons = array(   'Home' =>site_url() . '/home/index',
                                'Afspraken' =>site_url() . '/IspVerantwoordelijke/afspraken',
                                'Exporteren' =>site_url() . '/IspVerantwoordelijke/documentExporteren',
                                'Klassen' =>site_url() . '/IspVerantwoordelijke/toonKlaslijsten');
            break;

        case 'opleidingsmanager':
            $buttons = array(   'Home' => site_url() . '/home/index',
                                'Beheer' => site_url() . '/Opleidingsmanager/beheer');
            break;

        default:
            $buttons = array(   'knop1' => 'Link1',
                                'knop2' => 'Link2',
                                'knop3' => 'Link3');
    }
    return $buttons;
}
