<?php
namespace Findmyrice\Models;


use Aws\S3\S3Client;
use Phalcon\DI;
use Phalcon\Image\Adapter\GD;
use Phalcon\Mvc\Collection;

class Articles extends Collection
{
    public function getSource()
    {
        return 'news_articles';
    }

    /**
     * @var integer
     */
    public $_id;

    /**
     * @var integer
     */
    public $category_id;

    /**
     * @var integer
     */
    public $contributor_id;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $alias;

    /**
     * @var string
     */
    public $content;

    /**
     * @var string
     */
    public $image;

    /**
     * @var array
     */
    public $images;

    /**
     * @var integer
     */
    public $date;

    /**
     * @var boolean
     */
    public $publish;

    /**
     * @var integer
     */
    public $total_views;

    public function beforeSave()
    {
		if (!is_int($this->date)) {
			$this->date = strtotime($this->date);
		}
    }

    public function beforeCreate()
    {
        $identity = $this->getDI()->get('session')->get('auth-identity');
        $this->contributor_id = $identity['id'];

        $this->total_views = 0;

        $sizes = array(
            array('height' => 120, 'width' => 230),
            array('height' => 50, 'width' => 96)
        );
        $this->images = $this->_processImage($this->image, $sizes);
    }

    public function beforeUpdate()
    {
        $this->total_views++;

        $article = Articles::findById($this->_id);

        if ($article->image != $this->image) {
            $sizes = array(
                array('height' => 120, 'width' => 230),
                array('height' => 50, 'width' => 96)
            );
            $this->images = $this->_processImage($this->image, $sizes);
        }
    }

    public function getCategory()
    {
        if (!$this->_id) {
            return false;
        }

        return NewsCategories::findById($this->category_id);
    }

    public function getContributor()
    {
        if (!$this->_id) {
            return false;
        }

        return Users::findById($this->contributor_id);
    }

    private function _processImage($imageUrl, $sizes)
    {
        $resizeImages = array();

        $tmp = tempnam(null, null);
        $file = $tmp . '.jpg';
        file_put_contents($file, file_get_contents($imageUrl));

        $image = new GD($file);

        if ($image) {
            $client = S3Client::factory(array(
                'key'    => $this->getDI()->get('config')->amazon->AWSAccessKeyId,
                'secret' => $this->getDI()->get('config')->amazon->AWSSecretKey,
                'region' => 'us-west-2'
            ));
            $bucket = 'findmyrice';

            $identity = $this->getDI()->get('session')->get('auth-identity');

            $name = mb_substr($imageUrl, mb_strrpos($imageUrl, '/') + 1);
            $key = 'news/' . $identity['id'] . '/';

            foreach ($sizes as $size) {
                $uniqueName = $size['height'] . '_' . $name;
                $uniqueKey = $key . $uniqueName;

                $image->resize($size['width'], $size['height']);
                $image->save();

                $result = $client->putObject(array(
                    'Bucket'     => $bucket,
                    'Key'        => $uniqueKey,
                    'ACL'=> 'public-read',
                    'SourceFile' => $image->getRealPath(),
                    'ContentType'     => 'image/jpeg'
                ));

                if ($result) {
                    $resizeImages['h_'.$size['height']] = $result['ObjectURL'];
                }
            }

        }

        unlink($tmp);
        unlink($file);

        return $resizeImages;
    }
}