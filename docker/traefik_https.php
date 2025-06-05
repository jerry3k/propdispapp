<?php
/**
 * Traefik HTTPS header handler
 * 
 * This file automatically detects HTTPS connections behind a proxy like Traefik
 * by checking for the X-Forwarded-Proto header.
 */

// Set HTTPS server variable when the request comes through a secure connection via proxy
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
    $_SERVER['HTTPS'] = 'on';
}
