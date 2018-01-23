<?php
/**
 * SEOmatic plugin for Craft CMS 3.x
 *
 * A turnkey SEO implementation for Craft CMS that is comprehensive, powerful,
 * and flexible
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2017 nystudio107
 */

namespace nystudio107\seomatic\models;

use nystudio107\seomatic\base\FluentModel;

use Craft;
use yii\web\ServerErrorHttpException;

/**
 * @author    nystudio107
 * @package   Seomatic
 * @since     3.0.0
 */
class Settings extends FluentModel
{
    // Public Properties
    // =========================================================================

    /**
     * The public-facing name of the plugin
     *
     * @var string
     */
    public $pluginName = 'SEOmatic';

    /**
     * The server environment, either `live`, `staging`, or `local`
     *
     * @var string
     */
    public $environment = 'live';

    /**
     * Should SEOmatic render metadata?
     *
     * @var bool
     */
    public $renderEnabled = true;

    /**
     * If `devMode` is on, prefix the <title> with this string
     *
     * @var string
     */
    public $devModeTitlePrefix = '[devMode] ';

    /**
     * The name of the website
     *
     * @var string
     */
    public $siteName = '';

    /**
     * The separator character to use for the `<title>` tag
     *
     * @var string
     */
    public $separatorChar = '|';

    /**
     * The max number of characters in the `<title>` tag
     *
     * @var int
     */
    public $maxTitleLength = 120;

    /**
     * The max number of characters in the `<meta name="description">` tag
     *
     * @var int
     */
    public $maxDescriptionLength = 300;

    /**
     * The Twitter handle
     *
     * @var string
     */
    public $twitterHandle = '';

    /**
     * The Facebook profile ID
     *
     * @var string
     */
    public $facebookProfileId = '';

    /**
     * The Facebook app ID
     *
     * @var string
     */
    public $facebookAppId = '';

    // Public Methods
    // =========================================================================

    public function init()
    {
        parent::init();

        // Set some default values
        if (empty($this->siteName)) {
            try {
                $info = Craft::$app->getInfo();
            } catch (ServerErrorHttpException $e) {
                $info = null;
            }
            $this->siteName = Craft::$app->config->general->siteName ?? $info->name;
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['pluginName', 'string'],
            ['pluginName', 'default', 'value' => 'SEOmatic'],
            ['environment', 'string'],
            ['environment', 'default', 'value' => 'live'],
            ['environment', 'in', 'range' => [
                'live',
                'staging',
                'production',
            ]],
            ['devModeTitlePrefix', 'string'],
            ['devModeTitlePrefix', 'default', 'value' => '[devMode] '],
            ['maxTitleLength', 'integer', 'min' => 10],
            ['maxTitleLength', 'default', 'value' => 70],
            ['maxDescriptionLength', 'integer', 'min' => 10],
            ['maxDescriptionLength', 'default', 'value' => 160],
            ['twitterHandle', 'string'],
            ['twitterHandle', 'default', 'value' => ''],
        ];
    }
}