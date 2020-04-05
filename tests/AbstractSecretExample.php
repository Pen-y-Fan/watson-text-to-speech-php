<?php

namespace PenYFan\WatsonTextToSpeech\Tests;

/*
 * Rename this file to AbstractSecret.php and class to AbstractSecret
 * Enter the API_KEY for your API key in your Manage Credentials for Text to Speech
 * See: https://cloud.ibm.com/ then click Services , click Text to Speech (under services),
 * under Credentials click Show credentials.
 *
 * e.g. f5sAznhrKQyvBFFaZbtF60m5tzLbqWhyALQawBg5TjRI
 * Note: This is the example from the tutorial - it will not work!
 */
abstract class AbstractSecretExample
{
    /**
     * @var string
     */
    public const API_KEY = 'EnterYourAPIKeyHere';
}
