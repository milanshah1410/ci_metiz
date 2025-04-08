<?php

if (!function_exists('getStatusLabel')) {
    function getStatusLabel($status)
    {
        $map = [
            0 => 'Pending',
            1 => 'Approved',
            2 => 'Rejected'
        ];
        return $map[$status] ?? 'Unknown';
    }
}
