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

use Att\Api\AAB\AABService;

$arr = null;
try {
    envinit();
    $aabService = new AABService(getFqdn(), getSessionToken());
    $gid = $_POST['getContactsGroupId'];
    if ($gid === '') {
        throw new Exception('Group Id must not be empty');
    }

    $contactIds = $aabService->getGroupContacts($gid);
    $values = array();
    foreach ($contactIds as $cid) {
        $values[] = array($cid);
    }

    $tables = array(
        array(
            'caption' => 'Contacts:',
            'headers' => array('contactId'),
            'values' => $values,
        ),
    );

    $arr = array(
        'success' => true,
        'tables' => $tables
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
