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
 * Admin settings and defaults.
 *
 * @package    block_simplecamera
 * @copyright  2023 Instituto Tecnológico de Ciudad Madero
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

 defined('MOODLE_INTERNAL') || die;

if($ADMIN->fulltree){

    $settings->add(new admin_setting_heading('block_simplecamera', '', 
    new lang_string('block_simplecameradescription', 'block_simplecamera')));

    $settings->add(new admin_setting_configtext('block_simplecamera/aws_region', 'AWS Region', '', '', PARAM_ALPHANUMEXT)); 
    $settings->add(new admin_setting_configtext('block_simplecamera/aws_public_key', 'AWS Public Key', '', '', PARAM_ALPHANUM));
    $settings->add(new admin_setting_configtext('block_simplecamera/aws_secret_key', 'AWS Secret Key', '', '', PARAM_TEXT));
}