<?php

//Helper files used throughout the site

//Check whether nav is active
function set_primary($path, $active = 'btn-primary') {
    return call_user_func_array('Request::is', (array)$path) ? $active : '';
}

function set_active($path, $active = 'active') {
    return call_user_func_array('Request::is', (array)$path) ? $active : '';
}