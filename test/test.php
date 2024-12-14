<?php

use DocBase\DocBase;

require_once __DIR__ . '/../vendor/autoload.php';

$db = new DocBase(__DIR__ . '/database');

// Create collection
$db->createCollection('users');

// Insert
$db->insert('users', ['id' => 1, 'name' => 'Alice']);
$db->insert('users', ['id' => 2, 'name' => 'Bob']);

// Query
$users = $db->find('users', ['name' => 'Alice']);
print_r($users);

// Update
$db->update('users', ['name' => 'Alice'], ['name' => 'Alice Updated']);

// Delete
$db->delete('users', ['id' => 2]);
