<?php

/**
 * Configuration for database connection
 *
 */

$host       = "localhost";
$username   = "admin";
$password   = "password";
$dbname     = "hotelDB";
$dsn        = "mysql:host=$host;dbname=$dbname";
$options    = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
              );