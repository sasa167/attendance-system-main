<?php

if (!function_exists('getDashboardRoute')) {
    function getDashboardRoute()
    {
        switch (auth()->user()->role) {
            case 'superadmin':
                return 'dashboards.superadmin';
            case 'admin':
                return 'dashboards.admin';
            case 'teacher':
                return 'dashboards.teacher';
            case 'parent':
                return 'dashboards.parent';
            default:
                return '/'; // Default redirect if no role
        }
    }
}
