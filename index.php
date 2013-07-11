<?php

/**
 * Landing Page
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category  Integrates
 * @package   Landing_Page
 * @author    narsic <narsicnet@gmail.com>
 * @copyright 2013-2013 The Rubako Team
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link      https://github.com/narsic/landing_page.php
 */

require 'inc/config.php';
require 'vendor/autoload.php';

if (isset($_POST['email'])) {
    if (checkEmail($_POST['email'])) {
        $email = $_POST['email'];
        $api = new Rezzza\MailChimp\MCAPI($apiKey);
        $mergeVars = array();
        $retval = $api->listSubscribe(
            $listId,
            $email,
            $mergeVars,
            $emailType,
            $sendConfirmationEmail
        );
 
        if ($api->errorCode) {
            $subscribed = false;
            $error = array(
                'code' => $api->errorCode,
                'message' => $api->errorMessage);
            include 'error.php';
            die;
        } else {
            $subscribed = true;
            include 'success.php';
            die;
        }
    } else {
        $error = array(
            'message' => 'Invalid Email Address');
        include 'error.php';
        die;
    }
}

/**
 * Check email address
 *
 * @param string $email the email address
 *
 * @return bol
 *
 * @access public
 */
function checkEmail($email)
{
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {
        return false;
    }
}

require 'form.php';
?>
