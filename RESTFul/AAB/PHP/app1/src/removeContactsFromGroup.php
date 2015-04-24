<?php
/*
 * Copyright 2015 AT&T
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
session_start();

require_once __DIR__ . '/common.php';
require_once __DIR__ . '/../lib/AAB/AABService.php';
require_once __DIR__ . '/../lib/AAB/PaginationParameters.php';

use Att\Api\AAB\AABService;
use Att\Api\AAB\PaginationParameters;

$arr = null;
try {
    envinit();
    $aabService = new AABService(getFqdn(), getSessionToken());
    $gid = $_POST['removeContactsGroupId'];
    if ($gid === '') {
        throw new Exception('Group Id must not be empty');
    }
    $cids = $_POST['removeContactIds'];
    if ($cids === '') {
        throw new Exception('Contact Ids must not be empty');
    }
    $cids = explode(",", $cids);
    $aabService->removeContactsFromGroup($gid, $cids);

    $arr = array(
        'success' => true,
        'text' => 'Successfully removed contacts from group.'
    );
} catch (Exception $e) {
    $arr = array(
        'success' => false,
        'text' => $e->getMessage()
    );
}

echo json_encode($arr);

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
?>
