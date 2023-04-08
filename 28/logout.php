<?php

use Core\Auth;

require 'includes/common.php';

Auth::logout();

redirect('index.php');
