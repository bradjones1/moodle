<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Initiate an OAuth2 login flow by provider ID.
 *
 * @package auth_oauth2
 * @copyright 2019 ems.education software.
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License
 */

namespace auth_oauth2;

use moodle_url;

require('../../config.php');
require_once($CFG->libdir.'/moodlelib.php');

$issuerid = required_param('id', PARAM_INT);

$idp = \core\oauth2\api::get_issuer($issuerid);

if (!$idp->get('enabled') || !$idp->is_configured()) {
    throw new \moodle_exception('Invalid or disabled issuer.', 'auth_oauth2');
}

$params = ['id' => $idp->get('id'), 'wantsurl' => $SESSION->wantsurl ?: '', 'sesskey' => sesskey()];
$url = new moodle_url('/auth/oauth2/login.php', $params);

redirect($url);
