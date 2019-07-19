<?php namespace indiashopps\Models;

use Illuminate\Database\Eloquent\Model;

class FcmToken extends Model
{

    const WEBSITE_VERSION   = 1;
    const EXTENSION_VERSION = 2;
    const TOPIC_ADDED       = 2;
    const TOPIC_NOT_ADDED   = 1;
    const GENERAL_TOPIC     = "/topics/general";
    const TEST_TOPIC        = "/topics/devtest";
    const VERSION2_TOPIC    = "/topics/version2";

    protected $fillable = ['token'];
}
