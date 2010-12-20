<?php

function bigbluebutton_room_activity() {

    include_spip('base/abstract_sql');
    include_spip('bbb_api');

    $bbb_api_key = sql_getfetsel('set_value', 'spip_bbb_settings', 'set_name="BBB_API_KEY"');
    $bbb_url_webconf = sql_getfetsel('set_value', 'spip_bbb_settings', 'set_name="BBB_URL_WEBCONF"');

    $activity_room = BigBlueButton::getMeetings( $bbb_url_webconf, $bbb_api_key );
    $activity_room = simplexml_load_string($activity_room);

    if($activity_room[0] != "no meeting is found on the server") {

    $valeurs = "<ul class=\"liste_items\">";
    foreach ($activity_room->meeting as $meetings) {
        $valeurs .= "<li class=\"item\"><p><strong>". _T('bigbluebutton:meeting_statut') . "</strong>{$meetings->returncode}<br />
                <strong>". _T('bigbluebutton:meeting_room') . "</strong>{$meetings->meetingID}<br />
                <strong>". _T('bigbluebutton:attendee_pass') . "</strong>{$meetings->attendeePW}<br />
                <strong>". _T('bigbluebutton:moderator_pass') . "</strong>{$meetings->moderatorPW}<br />
                <strong>". _T('bigbluebutton:meeting_activite') . "</strong>{$meetings->running}<br />
                <strong>". _T('bigbluebutton:date_debut') . "</strong>{$meetings->startTime}<br />
                <strong>". _T('bigbluebutton:date_fin') . "</strong>{$meetings->endTime}<br />
                <strong>". _T('bigbluebutton:attendee_count') . "</strong>{$meetings->participantCount}<br />
                <strong>". _T('bigbluebutton:moderator_count') . "</strong>{$meetings->moderatorCount}<br />

                </p>
                </li>";

    }
    $valeurs .= "</ul>";

    } else {

        $valeurs = "<div class=\"cadre cadre-info\">"._T('bigbluebutton:salle_fermer') ."</div>";
    }

    return $valeurs;

}

?>