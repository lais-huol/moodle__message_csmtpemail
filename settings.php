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
 * Email configuration page
 *
 * @package   message_csmtpemail
 * @copyright 2011 Lancaster University Network Services Limited
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {
    $settings->add(new admin_setting_configtext('smtphosts', get_string('smtphosts', 'message_csmtpemail'), get_string('configsmtphosts', 'message_csmtpemail'), '', PARAM_RAW));
    $options = array('' => get_string('none', 'message_csmtpemail'), 'ssl' => 'SSL', 'tls' => 'TLS');
    $settings->add(new admin_setting_configselect('smtpsecure', get_string('smtpsecure', 'message_csmtpemail'), get_string('configsmtpsecure', 'message_csmtpemail'), '', $options));
    $settings->add(new admin_setting_configtext('smtpuser', get_string('smtpuser', 'message_csmtpemail'), get_string('configsmtpuser', 'message_csmtpemail'), '', PARAM_NOTAGS));
    $settings->add(new admin_setting_configpasswordunmask('smtppass', get_string('smtppass', 'message_csmtpemail'), get_string('configsmtpuser', 'message_csmtpemail'), ''));
    $settings->add(new admin_setting_configtext('smtpmaxbulk', get_string('smtpmaxbulk', 'message_csmtpemail'), get_string('configsmtpmaxbulk', 'message_csmtpemail'), 1, PARAM_INT));
    $settings->add(new admin_setting_configtext('noreplyaddress', get_string('noreplyaddress', 'message_csmtpemail'), get_string('confignoreplyaddress', 'message_csmtpemail'), 'noreply@' . get_host_from_url($CFG->wwwroot), PARAM_NOTAGS));
    $settings->add(new admin_setting_configcheckbox('emailonlyfromnoreplyaddress',
            get_string('emailonlyfromnoreplyaddress', 'message_csmtpemail'),
            get_string('configemailonlyfromnoreplyaddress', 'message_csmtpemail'), 0));

    $charsets = get_list_of_charsets();
    unset($charsets['UTF-8']); // not needed here
    $options = array();
    $options['0'] = 'UTF-8';
    $options = array_merge($options, $charsets);
    $settings->add(new admin_setting_configselect('sitemailcharset', get_string('sitemailcharset', 'message_csmtpemail'), get_string('configsitemailcharset','message_csmtpemail'), '0', $options));
    $settings->add(new admin_setting_configcheckbox('allowusermailcharset', get_string('allowusermailcharset', 'message_csmtpemail'), get_string('configallowusermailcharset', 'message_csmtpemail'), 0));
    $settings->add(new admin_setting_configcheckbox('allowattachments', get_string('allowattachments', 'message_csmtpemail'), get_string('configallowattachments', 'message_csmtpemail'), 1));
    $options = array('LF'=>'LF', 'CRLF'=>'CRLF');
    $settings->add(new admin_setting_configselect('mailnewline', get_string('mailnewline', 'message_csmtpemail'), get_string('configmailnewline','message_csmtpemail'), 'LF', $options));
    if($DB->record_exists('config_plugins',array('plugin'=>'local_custonsmtp'))){
        //Adionar contas
        $accounts = $DB->get_records('custonsmtp_accounts');
        $accountsArray = array(0=>'Não gereciar');
        foreach($accounts as $account){
            $accountsArray[$account->id] =$account->name;
        }
    
        $settings->add(new admin_setting_configselect('mmsmtp', 'SMTP Usado','Conta de SMTP usada para enviar mensagens nesse plugin',null,$accountsArray));
    }
}
