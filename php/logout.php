<?php

namespace LinkShortener;

use function LinkShortener\Utils\logoutUser;

require_once '../vendor/autoload.php';

logoutUser();
header('Location: sign_in.php');
