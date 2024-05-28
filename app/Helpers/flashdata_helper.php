<?php

if (!function_exists('setFlashdata')) {
    function setFlashdata($key, $message)
    {
        session()->setFlashdata($key, $message);
    }
}

if (!function_exists('getFlashdata')) {
    function getFlashdata($key)
    {
        return session()->getFlashdata($key);
    }
}
