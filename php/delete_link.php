<?php

namespace LinkShortener;

require_once '../vendor/autoload.php';

$linkId = $_GET['id'];

if (isset($linkId)) {
    // TODO: delete record from database
    header("Location: links.php");
}
