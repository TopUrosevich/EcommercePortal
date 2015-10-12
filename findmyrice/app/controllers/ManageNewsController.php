<?php
namespace Findmyrice\Controllers;

require_once BASE_DIR . '/app/vendor/aws/aws-autoloader.php';

use Aws\S3\S3Client;
use Findmyrice\Forms\ArticlesForm;
use Findmyrice\Forms\NewsCategoriesForm;
use Findmyrice\Models\Articles;
use Findmyrice\Models\NewsCategories;
use Findmyrice\Models\Users;
use Phalcon\Http\Response;

class ManagenewsController extends ControllerBase
{
    public function initialize()
    {
        $this->view->setTemplateBefore('private');
        $this->view->adminPage = true;
    }

    public function indexAction()
    {
        $this->assets->addJs('js/jquery.dataTables.min.js')
            ->addJs('js/manage-news-index.js')
            ->addCss('css/jquery.dataTables.css');

        $articles = Articles::find();
        $this->view->setVars(array(
            'articles' => $articles
        ));
    }

    /**
     * Create and view news categories
     */
    public function categoriesAction()
    {
        $this->assets->addJs('js/alias_generator.js');

        $form = new NewsCategoriesForm();

        if ($this->request->isPost()) {
            $categories = new NewsCategories();
            $form->bind($this->request->getPost(), $categories);

            if ($form->isValid()) {
                if (!$categories->save()) {
                    $this->response->setStatusCode(500, 'Can\'t save category in database');
                } else {
                    $this->flash->success('News Category was created successfully');

                    $form->initialize();
                    $form->clear();
                }
            }
        }

        $categories = NewsCategories::find();

        $this->view->setVars(array(
            'categories' => $categories,
            'form' => $form
        ));
    }

    public function deleteCategoriesAction()
    {
        if ($this->request->isPost()) {
            $rmCategory = $this->request->getPost('category');

            foreach ($rmCategory as $id => $status) {
                if ($status == 'on') {
                    $category = NewsCategories::findById($id);
                    if ($category) {
                        if (!$category->delete()) {
                            $this->response->setStatusCode(500, 'Can\'t delete category from database');
                        } else {
                            $this->response->redirect('manageNews/categories');
                        }
                    }
                }
            }
        }
    }

    /**
     * Create and view news contributors
     */
    public function contributorsAction()
    {
        $this->assets->addJs('js/jquery.dataTables.min.js')
                    ->addJs('js/manage-news-contributors.js')
                    ->addCss('css/jquery.dataTables.css');

        $contributors = Users::findNewsContributors();
        $this->view->setVars(array(
            'contributors' => $contributors
        ));
    }

    public function deleteContributorsAction()
    {
        if ($this->request->isPost()) {
            $rmUser = $this->request->getPost('contributor');

            foreach ($rmUser as $id => $status) {
                if ($status == 'on') {
                    $user = Users::findById($id);
                    if ($user) {
                        if (!$user->delete()) {
                            $this->response->setStatusCode(500, 'Can\'t delete contributor from database');
                        } else {
                            $this->response->redirect('manageNews/contributors');
                        }
                    }
                }
            }
        }
    }

    public function createAction()
    {
        $this->_prepareAssets();

        $form = new ArticlesForm();

        if ($this->request->isPost()) {
            $article = new Articles();
            $form->bind($this->request->getPost(), $article);

            if ($form->isValid()) {
                $article->publish = (boolean) $this->request->getPost('publish');
                if (!$article->save()) {
                    $this->response->setStatusCode(500, 'Can\'t save article in database');
                } else {
                    $this->flash->success('Article was created successfully');
                    $form->clear();
                }
            }
        }

        $this->view->setVars(array(
            'form' => $form
        ));
    }

    public function editAction($id)
    {
        $this->_prepareAssets();

        $article = Articles::findById($id);

        if ($article) {
            $form = new ArticlesForm($article, array('edit' => true));

            if ($this->request->isPost()) {
                $form->bind($this->request->getPost(), $article);

                if ($form->isValid()) {
                    $article->publish = (boolean) $this->request->getPost('publish');
                    if (!$article->save()) {
                        $this->response->setStatusCode(500, 'Can\'t save article in database');
                    } else {
                        return $this->response->redirect('manageNews');
                    }
                }
            }

            $this->view->setVars(array(
                'form' => $form,
                'article' => $article
            ));
        } else {
            return $this->dispatcher->forward(array(
                'controller' => 'manageNews',
                'action' => 'index'
            ));
        }
    }

    public function deleteAction()
    {
        if ($this->request->isPost()) {
            $rmArticle = $this->request->getPost('article');

            foreach ($rmArticle as $id => $status) {
                if ($status == 'on') {
                    $article = Articles::findById($id);
                    if ($article) {
                        if (!$article->delete()) {
                            $this->response->setStatusCode(500, 'Can\'t delete article from database');
                        } else {
                            $this->response->redirect('manageNews');
                        }
                    }
                }
            }
        }
    }

    public function uploadImageAction()
    {
        if ($this->request->isPost()) {
            $this->view->disable();
            $response = new Response();

            $identity = $this->session->get('auth-identity');
            $userId = $identity['id'];
            $userProfile = $identity['profile'];

            if($userProfile == 'Administrators' || $userProfile == 'News-Contributors'){
                $user = Users::findById($userId);

                if ($user) {
                    $client = S3Client::factory(array(
                        'key'    => $this->config->amazon->AWSAccessKeyId,
                        'secret' => $this->config->amazon->AWSSecretKey,
                        'region' => 'us-west-2'
                    ));
                    $uploads = $this->request->getUploadedFiles();
                    $bucket = 'findmyrice';

                    if (!empty($uploads)) {
                        $file = $uploads[0];
                        $uniqueName = time() . '-' . $file->getName();
                        $key = 'news/' . $user->_id . '/' . $uniqueName;

                        $mimeType = $file->getRealType();

                        switch ($mimeType) {
                            case 'image/jpeg':
                                $image = imagecreatefromjpeg($file->getRealPath());
                                break;
                            case 'image/png':
                                $image = imagecreatefrompng($file->getRealPath());
                                break;
                            default:
                                $image = null;
                        }

                        if ($image) {
                            $tmp = tempnam(null, null);
                            imagejpeg($image, $tmp, 75);
                            imagedestroy($image);

                            $result = $client->putObject(array(
                                'Bucket'     => $bucket,
                                'Key'        => $key,
                                'ACL'=> 'public-read',
                                'SourceFile' => $tmp,
                                'ContentType'     => 'image/jpeg'
                            ));

                            unlink($tmp);

                            if ($result) {
                                $content = array(
                                    'image' => array(
                                        'key' => $key,
                                        'url' => $result['ObjectURL']
                                    )
                                );
                                $response->setStatusCode(201, 'Created');
                                $response->setHeader('Content-Type', 'application/json');
                                $response->setJsonContent(json_encode($content));
                            }
                        }
                    }
                }
            }
            return $response;
        }
    }

    private function _prepareAssets()
    {
        $this->assets
            ->addJs('js/alias_generator.js')
            ->addJs('js/dropzone.min.js')
            ->addJs('js/dropzone_config.js')
            ->addJs('js/quill.min.js')
            ->addJs('js/quill_config.js');
    }
}