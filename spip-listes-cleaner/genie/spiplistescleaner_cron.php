<?php


function genie_spiplistescleaner_cron($time)
{
    include_spip('action/spiplistescleaner');
    action_spiplistescleaner_dist();

    return 1;
}
