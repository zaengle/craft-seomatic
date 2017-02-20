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

namespace nystudio107\seomatic\controllers;

use nystudio107\seomatic\models\JsonLd;

use Craft;
use craft\web\Controller;

/**
 * @author    nystudio107
 * @package   Seomatic
 * @since     1.0.0
 */
class JsonLdController extends Controller
{
    // Public Methods
    // =========================================================================

    /**
     * Get the fully composed schema type
     *
     * @return \yii\web\Response
     */
    public function actionGetType($schemaType)
    {
        $result = null;
        $jsonLdType = JsonLd::create($schemaType);

        if ($jsonLdType) {
            // Get the static properties
            $classRef = new \ReflectionClass($jsonLdType::className());
            if ($classRef) {
                $result = $classRef->getStaticProperties();
            }
        }

        return $this->asJson($result);
    }

    /**
     * Get the decomposed schema type
     *
     * @return \yii\web\Response
     */
    public function actionGetDecomposedType($schemaType)
    {
        $result = null;
        while ($schemaType) {
            $className = 'nystudio107\\seomatic\\models\\jsonld\\'.$schemaType;
            if (class_exists($className)) {
                $classRef = new \ReflectionClass($className);
                if ($classRef) {
                    $staticProps = $classRef->getStaticProperties();
                    foreach ($staticProps as $key => $value) {
                        if ($key[0] == '_') {
                            $newKey = ltrim($key, '_');
                            $staticProps[$newKey] = $value;
                            unset($staticProps[$key]);
                        }
                    }
                    $result[$schemaType] = $staticProps;
                    $schemaType = $staticProps['schemaTypeExtends'];
                }
            }
        }
Craft::dd($result);
        return $this->asJson($result);
    }

}