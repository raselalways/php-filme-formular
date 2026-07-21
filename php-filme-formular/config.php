<?php

# error_reporting steuern
error_reporting(E_ALL);

# Parameter für die Datenbankverbindung
const DBHOST = 'localhost';
const DBUSER = 'filmeredakteur';
const DBPASS = 'geheim';
const DBNAME = 'filme';
const DBPORT = '3306';
const DBCHARSET = 'utf8';
const DBSYSTEM = 'mysql';
# DSN für PDO
const DSN = DBSYSTEM.':dbname='.DBNAME.';host='.DBHOST.';port='.DBPORT.';charset='.DBCHARSET;

# Algorythmus für URL-Hash-Wert 
const URLALGO = 'sha1';
# Salt für Hash-Wert
const HASHSALT = 'kdlzp.e639*hjfdlkjf';
