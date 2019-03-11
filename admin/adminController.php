<?php
require_once "adminModel.php";

$action = get('action') ?: 'defaultAction';

$action(getPDO());

function create($pdo) {

}

function archiver($pdo) {

}

