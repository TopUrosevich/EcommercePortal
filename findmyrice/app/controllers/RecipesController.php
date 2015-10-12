<?php
namespace Findmyrice\Controllers;

require_once BASE_DIR . '/app/vendor/aws/aws-autoloader.php';

use Aws\S3\S3Client;
use Findmyrice\Forms\RecipesForm;
use Findmyrice\Models\Cookbooks;
use Findmyrice\Models\Ingredients;
use Findmyrice\Models\IngredientsUnit;
use Findmyrice\Models\RecipeComments;
use Findmyrice\Models\Recipes;
use Findmyrice\Models\RecipeRatings;
use Findmyrice\Models\ShareCookbooks;
use Findmyrice\Models\ShareRecipes;
use Findmyrice\Models\Users;
use Findmyrice\Models\UserMessages;
use Phalcon\Http\Response;
use Phalcon\Image\Adapter\GD;
use Phalcon\Validation\Message;
use Phalcon\Paginator\Adapter\NativeArray as Paginator;

class RecipesController extends ControllerBase
{
    public function initialize()
    {
        $this->view->setTemplateBefore('public');
        $this->view->partial('recipes/partials/macroRecipesList');
        $identity = $this->session->get('auth-identity');
        $user_id = $identity['id'];
        $count = UserMessages::count(array(
            array(
                "read" => '0',
                "user_id" => $user_id
            )
        ));
        $this->view->newMessageCount = $count;
    }

    public function indexAction()
    {
        $this->view->partial('recipes/partials/macroRecipesList');
        $identity = $this->session->get('auth-identity');
        $user_id = $identity['id'];
        $count = UserMessages::count(array(
            array(
                "read" => '0',
                "user_id" => $user_id
            )
        ));
        $this->view->newMessageCount = $count;
        return $this->response->redirect('recipes/dashboard');
    }

    public function dashboardAction()
    {
        $this->_prepareMightLike();
        $identity = $this->session->get('auth-identity');
        $user_id = $identity['id'];
        $count = UserMessages::count(array(
            array(
                "read" => '0',
                "user_id" => $user_id
            )
        ));
        $this->view->newMessageCount = $count;
    }

    public function addAction()
    {
        $identity = $this->session->get('auth-identity');
        $user_id = $identity['id'];
        $auth = $this->_checkAuth();

        if ($auth !== true) {
            return $auth;
        }

        $this->_prepareMightLike();

        $recipeType = $this->dispatcher->getParam('type');

        if ($recipeType) {
            $this->view->setTemplateBefore('private');

            $this->assets
                ->addJs('js/jquery-ui.min.js')
                ->addJs('js/recipes/recipes.js')
                ->addJs('js/recipes/photo_uploader.js');
            $this->assets->addCss('css/jquery-ui.css');

            $form = new RecipesForm(null,
                ($recipeType == 'photo') ? array('type' => 'photo') : array('type' => 'single'));

            if ($this->request->isPost()) {
                $recipe = new Recipes();
                $form->bind($this->request->getPost(), $recipe);
                // need to set type before model validation
                $recipe->type = $recipeType;

                if (($form->isValid() && $recipe->validation() && $this->request->hasFiles())
                    || ($recipe->validation() && $form->isValid())) {
                    $photos = $this->_saveUploadedImage();
                    $recipe->photo_origin = $photos['origin'];
                    $recipe->photo_preview = $photos['preview'];

                    $recipe->public = (boolean) $this->request->getPost('public');

                    if (!$recipe->save()) {
                        $this->flash->error('Can\'t create Recipe');
                    } else {
                        return $this->response->redirect('recipes/view/' . $recipe->_id);
                    }
                } else {
                    $form->addMessagesFromModel($recipe);
                }

                $this->view->setVar('recipe', $recipe);
            }

            $this->view->setVars(array(
                'form' => $form,
                'recipeType' => $recipeType
            ));
        }
        $count = UserMessages::count(array(
            array(
                "read" => '0',
                "user_id" => $user_id
            )
        ));
        $this->view->newMessageCount = $count;
    }

    public function editAction($id)
    {
        if ($id) {
            $auth = $this->_checkAuth();

            if ($auth !== true) {
                return $auth;
            }

            $identity = $this->session->get('auth-identity');
            $userId = $identity['id'];

            $recipe = Recipes::findById($id);

            if ($recipe && $recipe->owner_id == $userId) {
                $this->view->setTemplateBefore('private');

                $this->assets
                    ->addJs('js/jquery-ui.min.js')
                    ->addJs('js/recipes/recipes.js')
                    ->addJs('js/recipes/photo_uploader.js');
                $this->assets->addCss('css/jquery-ui.css');

                $form = new RecipesForm($recipe, array('type' => $recipe->type));

                if ($this->request->isPost()) {
                    $form->bind($this->request->getPost(), $recipe);

                    if (($form->isValid() && $recipe->validation())
                        || ($recipe->validation() && $form->isValid())) {
                        if ($this->request->hasFiles()) {
                            $photos = $this->_saveUploadedImage();
                            $recipe->photo_origin = $photos['origin'];
                            $recipe->photo_preview = $photos['preview'];
                        }
                        $recipe->public = (boolean) $this->request->getPost('public');

                        if (!$recipe->save()) {
                            $this->flash->error('Can\'t save Recipe');
                        } else {
                            return $this->response->redirect('recipes/view/' . $recipe->_id);
                        }
                    } else {
                        $form->addMessagesFromModel($recipe);
                    }
                }

                $this->_prepareMightLike();

                $this->view->setVars(array(
                    'form' => $form,
                    'recipeType' => $recipe->type,
                    'recipe' => $recipe
                ));
                $count = UserMessages::count(array(
                    array(
                        "read" => '0',
                        "user_id" => $userId
                    )
                ));
                $this->view->newMessageCount = $count;
            } else {
                $this->flash->error('You have no permissions for access');

                return $this->dispatcher->forward(array(
                    'controller' => 'recipes',
                    'action' => 'my'
                ));
            }
        } else {
            return $this->dispatcher->forward(array(
                'controller' => 'recipes',
                'action' => 'my'
            ));
        }
    }

    public function deleteAction($id)
    {
        if ($id) {
            $auth = $this->_checkAuth();

            if ($auth !== true) {
                return $auth;
            }

            $identity = $this->session->get('auth-identity');
            $userId = $identity['id'];

            $recipe = Recipes::findById($id);

            if ($recipe && $recipe->owner_id == $userId) {
                if ($recipe->delete()) {
                    return $this->response->redirect(
                        $this->request->getHTTPReferer());
                } else {
                    $this->flash->error('Can\'t delete recipe');
                    return $this->dispatcher->forward(array(
                        'controller' => 'recipes',
                        'action' => 'my'
                    ));
                }
                $count = UserMessages::count(array(
                    array(
                        "read" => '0',
                        "user_id" => $userId
                    )
                ));
                $this->view->newMessageCount = $count;
            } else {
                $this->flash->error('You have no permissions');
                return $this->dispatcher->forward(array(
                    'controller' => 'recipes',
                    'action' => 'my'
                ));
            }
        }
    }

    public function searchAction()
    {
        $this->assets
            ->addJs('js/recipes/filter.js')
            ->addJs('js/recipes/view_limit.js');
        
        $identity = $this->session->get('auth-identity');
        $userId = $identity['id'];

        $view = $this->request->get('view', 'string', 'grid');
        $sort = $this->request->get('sort', 'string', 'newest');

        $parameters = array(
            'conditions' => array(
                'public' => true
            )
        );

        $recipes = Recipes::find($parameters);

        switch ($sort) {
            case 'newest':
                $parameters = array_merge_recursive($parameters, array(
                    'sort' => array(
                        'created_at' => -1
                    )
                ));
                $recipes = Recipes::find($parameters);
                break;
            case 'comments':
                $recipes = Recipes::findAllByMostComments();
                break;
            case 'favourites':
                $recipes = Recipes::findAllByMostPopular();
                break;
        }

        $paginator = new Paginator(array(
            'data' => $recipes,
            'limit' => $this->request->get('limit', 'int', 11),
            'page' => $this->request->get('page', 'int', 1)
        ));

        $page = $paginator->getPaginate();

        $this->_preparePaginationUrl();

        $this->view->setVars(array(
            'page' => $page,
            'view' => $view
        ));
        $count = UserMessages::count(array(
            array(
                "read" => '0',
                "user_id" => $userId
            )
        ));
        $this->view->newMessageCount = $count;
    }

    public function viewAction($id)
    {
        $this->assets
            ->addJs('js/jquery-ui.min.js')
            ->addJs('js/recipes/jquery.raty.js')
            ->addJs('js/recipes/star_rating.js')
            ->addJs('js/recipes/add_comment.js')
            ->addJs('js/recipes/delete_comment.js')
            ->addJs('js/print_element.js')
            ->addJs('js/recipes/add_to_cookbook.js')
            ->addJs('js/recipes/create_cookbook.js')
            ->addJs('js/recipes/share_with_contact.js');

        $recipe = Recipes::findById($id);

        if (!$recipe) {
            return $this->dispatcher->forward(array(
                'controller' => 'recipes',
                'action' => 'search'
            ));
        }

        $identity = $this->session->get('auth-identity');

        $myCookbooks = Cookbooks::find(array(
            array(
                'owner_id' => $identity['id']
            )
        ));

        $ref = $this->request->get('ref');

        if ($ref) {
            if ($ref == 'share') {
                $auth = $this->_checkAuth();

                if ($auth !== true) {
                    return $auth;
                }

                $id = $this->request->get('id');

                $share = ShareRecipes::findById($id);

                if ($share) {
                    $share->shown = true;
                    if ($share->save()) {
                        $this->response->redirect('recipes/view/' . $recipe->_id);
                    }
                }
            }
        }

        $comments = RecipeComments::find(array(
            array(
                'recipe_id' => (string) $recipe->_id
            ),
            'sort' => array(
                'created_at' => 1
            )
        ));

        $identity = $this->session->get('auth-identity');
        $mid = $identity['id'];

        $this->_prepareMightLike();

        $this->view->setVars(array(
            'recipe' => $recipe,
            'myCookbooks' => $myCookbooks,
            'comments' => $comments,
            'mid' => $mid
        ));
        $count = UserMessages::count(array(
            array(
                "read" => '0',
                "user_id" => $mid
            )
        ));
        $this->view->newMessageCount = $count;
    }

    public function authorAction($id)
    {
        $identity = $this->session->get('auth-identity');
        $user_id = $identity['id'];
        if ($id) {
            $author = Users::findById($id);

            if ($author) {
                $recipes = Recipes::find(array(
                    array(
                        'owner_id' => $id,
                        'public' => true
                    )
                ));

                $paginator = new Paginator(array(
                    'data' => $recipes ? $recipes : array(),
                    'limit' => $this->request->get('limit', 'int', 11),
                    'page' => $this->request->get('page', 'int', 1)
                ));

                $page = $paginator->getPaginate();

                $this->_preparePaginationUrl();
                $this->_prepareMightLike();

                $this->view->setVars(array(
                    'page' => $page,
                    'view' => $this->request->get('view', 'string', 'grid'),
                    'author' => $author
                ));
                $count = UserMessages::count(array(
                    array(
                        "read" => '0',
                        "user_id" => $user_id
                    )
                ));
                $this->view->newMessageCount = $count;
            } else {
                return $this->response->redirect('recipes/search');
            }
        } else {
            return $this->response->redirect('recipes/search');
        }
    }

    public function cookbooksAction($id = null)
    {
        $auth = $this->_checkAuth();

        if ($auth !== true) {
            return $auth;
        }

        $this->assets
            ->addJs('js/recipes/share_cookbook_with_contact.js')
            ->addJs('js/recipes/view_limit.js')
            ->addJs('js/recipes/delete_cookbook.js');

        $identity = $this->session->get('auth-identity');
        $userId = $identity['id'];

        if ($id) {
            $cookbook = Cookbooks::findById($id);
            if ($cookbook) {
                $ref = $this->request->get('ref');

                if ($ref && $ref == 'share') {
                    $auth = $this->_checkAuth();

                    if ($auth !== true) {
                        return $auth;
                    }

                    $id = $this->request->get('id');

                    $share = ShareCookbooks::findById($id);

                    if ($share) {
                        $share->shown = true;
                        if ($share->save()) {
                            $this->response->redirect('recipes/cookbooks/' . $cookbook->_id);
                        }
                    }
                }
                $recipes = Recipes::find(array(
                    array(
                        '_id' => array(
                            '$in' => array_map(function($value){
                                return new \MongoId($value);
                            }, $cookbook->recipes)
                        )
                    ),
                    'sort' => array(
                        'created_at' => -1
                    )
                ));

                $paginator = new Paginator(array(
                    'data' => $recipes ? $recipes : array(),
                    'limit' => $this->request->get('limit', 'int', 11),
                    'page' => $this->request->get('page', 'int', 1)
                ));

                $page = $paginator->getPaginate();

                $this->_preparePaginationUrl();

                $this->view->setVars(array(
                    'cookbook' => $cookbook,
                    'page' => $page
                ));
            }
        } else {
            $cookbooks = Cookbooks::find(array(
                array(
                    'owner_id' => $userId
                ),
                'sort' => array(
                    'created_at' => -1
                )
            ));

            $shares = ShareCookbooks::findMyShares();

            $this->view->setVars(array(
                'cookbooks' => $cookbooks,
                'shares' => $shares
            ));
        }

        $this->_prepareMightLike();

        $this->view->setVars(array(
            'view' => $this->request->get('view', 'string', 'grid')
        ));
        $count = UserMessages::count(array(
            array(
                "read" => '0',
                "user_id" => $userId
            )
        ));
        $this->view->newMessageCount = $count;
    }

    /**
     * My Recipes
     */
    public function myAction()
    {
        $auth = $this->_checkAuth();

        if ($auth !== true) {
            return $auth;
        }

        $identity = $this->session->get('auth-identity');
        $userId = $identity['id'];

        $recipes = Recipes::find(array(
            array(
                'owner_id' => $userId
            ),
            'sort' => array(
                'created_at' => -1
            )
        ));

        $paginator = new Paginator(array(
            'data' => $recipes,
            'limit' => $this->request->get('limit', 'int', 11),
            'page' => $this->request->get('page', 'int', 1)
        ));

        $page = $paginator->getPaginate();

        $this->_preparePaginationUrl();

        $shares = ShareRecipes::findMyShares();

        $this->view->setVars(array(
            'page' => $page,
            'view' => $this->request->get('view', 'string', 'list'),
            'shares' => $shares
        ));
        $count = UserMessages::count(array(
            array(
                "read" => '0',
                "user_id" => $userId
            )
        ));
        $this->view->newMessageCount = $count;
    }

    public function tagsAction($tag)
    {
        $identity = $this->session->get('auth-identity');
        $userId = $identity['id'];
        if ($tag) {
            $recipes = Recipes::find(array(
                array(
                    'tags' => $tag,
                    'public' => true
                ),
                'sort' => array(
                    'created_at' => 1
                )
            ));

            $paginator = new Paginator(array(
                'data' => $recipes,
                'limit' => $this->request->get('limit', 'int', 11),
                'page' => $this->request->get('page', 'int', 1)
            ));

            $page = $paginator->getPaginate();

            $this->_prepareMightLike();

            $this->view->setVars(array(
                'page' => $page,
                'view' => $this->request->get('view', 'string', 'grid'),
                'tag' => $tag
            ));
        } else {
            return $this->response->redirect('recipes/search');
        }
        $count = UserMessages::count(array(
            array(
                "read" => '0',
                "user_id" => $userId
            )
        ));
        $this->view->newMessageCount = $count;
    }

    public function addToCookbookAjaxAction()
    {
        $this->view->disable();

        $response = new Response();

        if ($this->request->isPost()) {
            $data = $this->request->getPost();

            if (isset($data['recipe_id']) && isset($data['cookbooks'])) {
                $identity = $this->session->get('auth-identity');

                if (isset($identity['id'])) {
                    if (is_array($data['cookbooks'])) {
                        $userId = $identity['id'];
                        $recipeId = $data['recipe_id'];
                        $savedCount = 0; // How many recipes were saved to cookbook

                        foreach ($data['cookbooks'] as $key => $cookbookId) {
                            $cookbook = Cookbooks::findById($cookbookId);

                            // Check re-adding
                            if ($cookbook
                                && $cookbook->owner_id == $userId
                                && in_array($recipeId, $cookbook->recipes) === false) {
                                array_push($cookbook->recipes, $recipeId);

                                if ($cookbook->save()) {
                                    $savedCount++;
                                }
                            } else {
                                $savedCount++; // If the user forgot that saved it earlier
                            }
                        }

                        if ($savedCount > 0) {
                            $response->setStatusCode(201, 'Created');
                            return $response;
                        }
                    }
                } else {
                    $response->setHeader('Redirect', '/session/login');
                    $response->setStatusCode(401, 'Unauthorized');
                    return $response;
                }
            }
        }

        $response->setStatusCode(400, 'Bad Request');

        return $response;
    }

    public function createCookbookAjaxAction()
    {
        $response = new Response();

        if ($this->request->isPost()) {
            $data = $this->request->getPost();

            if (isset($data['cookbook_name'])) {
                $identity = $this->session->get('auth-identity');

                if (isset($identity['id'])) {
                    $userId = $identity['id'];
                    $cookbookName = $data['cookbook_name'];

                    $cookbook = Cookbooks::findFirst(array(
                        array(
                            'owner_id' => $userId,
                            'name' => $cookbookName
                        )
                    ));

                    // Check re-adding
                    if (!$cookbook) {
                        $cookbook = new Cookbooks();
                        $cookbook->owner_id = $userId;
                        $cookbook->recipes = array();
                        $cookbook->name = $cookbookName;

                        if ($cookbook->save()) {
                            $response->setStatusCode(201, 'Created');
                            $response->setContentType('application/json');
                            $response->setJsonContent(json_encode(array(
                                'response' => array(
                                    '_id' => (string) $cookbook->_id,
                                    'name' => $cookbook->name
                                )
                            )));

                            return $response;
                        }
                    }
                } else {
                    $response->setHeader('Redirect', '/session/login');
                    $response->setStatusCode(401, 'Unauthorized');
                    return $response;
                }
            }
        }

        $response->setStatusCode(400, 'Bad Request');

        return $response;
    }

    public function deleteCookbookAjaxAction($id)
    {
        $response = new Response();

        if ($this->request->isGet()) {
            if ($id) {
                $identity = $this->session->get('auth-identity');

                if (isset($identity['id'])) {
                    $userId = $identity['id'];

                    $cookbook = Cookbooks::findById($id);

                    if ($cookbook
                        && $cookbook->owner_id == $userId
                        && $cookbook->delete()) {
                        $this->response->setStatusCode(200, 'Success');
                        return $response;
                    }
                } else {
                    $response->setHeader('Redirect', '/session/login');
                    $response->setStatusCode(401, 'Unauthorized');
                    return $response;
                }
            }
        }

        $response->setStatusCode(400, 'Bad Request');

        return $response;
    }

    public function shareWithContactAjaxAction()
    {
        $response = new Response();

        if ($this->request->isPost()) {
            $data = $this->request->getPost();

            if (isset($data['recipe_id']) && isset($data['email'])) {
                $identity = $this->session->get('auth-identity');

                if (isset($identity['id'])) {
                    $userId = $identity['id'];
                    $recipeId = $data['recipe_id'];
                    $email = $data['email'];

                    // Check re-adding
                    $share = ShareRecipes::find(array(
                        array(
                            'owner_id' => $userId,
                            'recipe_id' => $recipeId,
                            'email' => $email
                        )
                    ));

                    if (!$share) {
                        $share = new ShareRecipes();
                        $share->recipe_id = $recipeId;
                        $share->email = $email;

                        if ($share->validation() && $share->save()) {
                            $user = Users::findFirstByEmail($email);

                            if (!$user) {
                                $owner = $share->getOwner();
                                $recipe = $share->getRecipe();

                                $from = $owner->first_name . ' ' . $owner->last_name;
                                $recipeUrl = '/recipes/view/' . $recipe->_id . '?ref=share&id=' . $share->_id;

                                $this->getDI()->get('mail')->send(
                                    array($share->email),
                                    'New Recipe for You',
                                    'recipe',
                                    array(
                                        'from' => $from,
                                        'recipeUrl' => $recipeUrl,
                                        'recipeName' => $recipe->name
                                    )
                                );
                            }

                            $response->setStatusCode(201, 'Created');
                            return $response;
                        }
                    }
                } else {
                    $response->setHeader('Redirect', '/session/login');
                    $response->setStatusCode(401, 'Unauthorized');
                    return $response;
                }
            }
        }

        $response->setStatusCode(400, 'Bad Request');

        return $response;
    }

    public function shareCookbookWithContactAjaxAction()
    {
        $response = new Response();

        if ($this->request->isPost()) {
            $data = $this->request->getPost();

            if (isset($data['cookbook_id']) && isset($data['email'])) {
                $identity = $this->session->get('auth-identity');

                if (isset($identity['id'])) {
                    $userId = $identity['id'];
                    $cookbookId = $data['cookbook_id'];
                    $email = $data['email'];

                    // Check re-adding
                    $share = ShareCookbooks::find(array(
                        array(
                            'owner_id' => $userId,
                            'cookbook_id' => $cookbookId,
                            'email' => $email
                        )
                    ));

                    if (!$share) {
                        $share = new ShareCookbooks();
                        $share->cookbook_id = $cookbookId;
                        $share->email = $email;

                        if ($share->validation() && $share->save()) {
                            $user = Users::findFirstByEmail($email);

                            if (!$user) {
                                $owner = $share->getOwner();
                                $cookbook = $share->getCookbook();

                                $from = $owner->first_name . ' ' . $owner->last_name;
                                $cookbookUrl = '/recipes/cookbooks/' . $cookbook->_id . '?ref=share&id=' . $share->_id;

                                $this->getDI()->get('mail')->send(
                                    array($share->email),
                                    'New Cookbook for You',
                                    'cookbook',
                                    array(
                                        'from' => $from,
                                        'cookbookUrl' => $cookbookUrl,
                                        'cookbookName' => $cookbook->name
                                    )
                                );
                            }

                            $response->setStatusCode(201, 'Created');
                            return $response;
                        }
                    }
                } else {
                    $response->setHeader('Redirect', '/session/login');
                    $response->setStatusCode(401, 'Unauthorized');
                    return $response;
                }
            }
        }

        $response->setStatusCode(400, 'Bad Request');

        return $response;
    }

    public function getUnitsAjaxAction()
    {
        $this->view->disable();

        $response = new Response();

        $units = IngredientsUnit::find();

        if ($units) {
            $unitsArray = array_map(function($value){
                return $value->name;
            }, $units);
            $response->setStatusCode(200, 'Success');
            $response->setContentType('application/json');
            $response->setJsonContent(json_encode(array(
                'response' => $unitsArray
            )));
        } else {
            $response->setStatusCode(204, 'No Content');
        }

        return $response;
    }

    public function getIngredientsAjaxAction()
    {
        $this->view->disable();

        $response = new Response();

        $ingredients = Ingredients::find();

        if ($ingredients) {
            $ingredientsArray = array_map(function($value){
                return $value->name;
            }, $ingredients);
            $response->setStatusCode(200, 'Success');
            $response->setContentType('application/json');
            $response->setJsonContent(json_encode(array(
                'response' => $ingredientsArray
            )));
        } else {
            $response->setStatusCode(204, 'No Content');
        }

        return $response;
    }

    public function ratingAjaxAction()
    {
        $this->view->disable();

        $response = new Response();

        // get current score
        if ($this->request->isGet()) {
            $recipeId = $this->request->get('recipe_id');

            if ($recipeId) {
                $ratings = RecipeRatings::find(array(
                    array(
                        'recipe_id' => $recipeId
                    )
                ));

                $sum = 0;
                foreach ($ratings as $rating) {
                    $sum += $rating->score;
                }

                $total = is_array($ratings) ? count($ratings) : 0;
                $average = $total ? round($sum / $total, 1) : 0;

                $response->setContentType('application/json');
                $response->setJsonContent(json_encode(array(
                    'response' => array(
                        'total' => $total,
                        'average' => $average
                    )
                )));
                $response->setStatusCode(200, 'Success');
                return $response;
            }
        }

        // evaluate recipe
        if ($this->request->isPost()) {
            $data = $this->request->getPost();

            if (isset($data['recipe_id']) && isset($data['score'])) {
                $identity = $this->session->get('auth-identity');

                if (isset($identity['id'])) {
                    $userId = $identity['id'];
                    $recipeId = $data['recipe_id'];
                    $score = $data['score'];

                    $rating = RecipeRatings::findFirst(array(
                        array(
                            'owner_id' => $userId,
                            'recipe_id' => $recipeId
                        )
                    ));

                    if (!$rating) {
                        $rating = new RecipeRatings();
                        $rating->recipe_id = $recipeId;
                        $rating->score = $score;
                        $rating->save();
                    } else {
                        if ($rating->score != $score) {
                            $rating->score = $score;
                            $rating->save();
                        }
                    }

                    $ratings = RecipeRatings::find(array(
                        array(
                            'recipe_id' => $recipeId
                        )
                    ));
                    $sum = 0;
                    foreach ($ratings as $rating) {
                        $sum += $rating->score;
                    }

                    $total = is_array($ratings) ? count($ratings) : 0;
                    $average = $total ? round($sum / $total, 1) : 0;

                    $response->setContentType('application/json');
                    $response->setJsonContent(json_encode(array(
                        'response' => array(
                            'total' => $total,
                            'average' => $average
                        )
                    )));
                    $response->setStatusCode(201, 'Created');
                    return $response;
                } else {
                    $response->setHeader('Redirect', '/session/login');
                    $response->setStatusCode(401, 'Unauthorized');
                    return $response;
                }
            }
        }

        $response->setStatusCode(400, 'Bad Request');

        return $response;
    }

    public  function addCommentAjaxAction()
    {
        $this->view->disable();

        $response = new Response();

        if ($this->request->isPost()) {
            $data = $this->request->getPost();

            if (isset($data['recipe_id']) && isset($data['message'])) {
                $identity = $this->session->get('auth-identity');

                if (isset($identity['id'])) {
                    $recipeId = $data['recipe_id'];
                    $message = $data['message'];

                    $comment = new RecipeComments();
                    $comment->message = $message;
                    $comment->recipe_id = $recipeId;

                    if ($comment->save()) {
                        $owner = $comment->getOwner();
                        $profile = $owner->getProfile();
                        $profileImage = $profile ? $profile->profile_image : '/images/empty_profile_image.png';

                        $response->setContentType('application/json');
                        $response->setJsonContent(
                            json_encode(
                                array (
                                    'response' => array (
                                        '_id' => (string) $comment->_id,
                                        'name' => $owner->first_name . ' ' . $owner->last_name,
                                        'profile_image' => $profileImage,
                                        'message' =>  $comment->message,
                                        'time' => date('Y-m-d H:i:s', $comment->created_at)
                                    )
                                )
                            )
                        );
                        $response->setStatusCode(201, 'Created');
                        return $response;
                    }
                } else {
                    $response->setHeader('Redirect', '/session/login');
                    $response->setStatusCode(401, 'Unauthorized');
                    return $response;
                }
            }
        }

        $response->setStatusCode(400, 'Bad Request');

        return $response;
    }

    public function deleteCommentAjaxAction()
    {
        $this->view->disable();

        $response = new Response();

        $commentId = $this->request->get('comment_id');
        $recipeId = $this->request->get('recipe_id');

        if ($commentId && $recipeId) {
            $identity = $this->session->get('auth-identity');

            if (isset($identity['id'])) {
                $comment = RecipeComments::findById($commentId);

                if ($comment->recipe_id == $recipeId
                    && $comment->owner_id == $identity['id']) {
                    if ($comment->delete()) {
                        $response->setStatusCode(200, 'Success');
                        return $response;
                    }
                }
            } else {
                $response->setHeader('Redirect', '/session/login');
                $response->setStatusCode(401, 'Unauthorized');
                return $response;
            }
        }

        $response->setStatusCode(400, 'Bad Request');

        return $response;
    }

    private function _prepareMightLike()
    {
        $identity = $this->session->get('auth-identity');
        $userId = $identity['id'];
        
        $recipes = Recipes::findMostPopularRecipes();
        $this->view->setVar('mightLike', $recipes);
        
        $count = UserMessages::count(array(
            array(
                "read" => '0',
                "user_id" => $userId
            )
        ));
        $this->view->newMessageCount = $count;
    }

    private function _preparePaginationUrl()
    {
        $identity = $this->session->get('auth-identity');
        $userId = $identity['id'];
        
        $requestUri = $this->request->getServer('REQUEST_URI');
        $url = parse_url($requestUri);
        $params = $this->request->getQuery();

        unset($params['_url']);
        $params['page'] = '';

        $paginationUrl = $url['path'] . '?' . http_build_query($params);
        $this->view->setVar('paginationUrl', $paginationUrl);
        $count = UserMessages::count(array(
            array(
                "read" => '0',
                "user_id" => $userId
            )
        ));
        $this->view->newMessageCount = $count;
    }

    private function _checkAuth()
    {
        $identity = $this->session->get('auth-identity');
        $userId = $identity['id'];

        if (!$userId) {
            return $this->dispatcher->forward(array(
                'controller' => 'session',
                'action' => 'login'
            ));
        }
        $count = UserMessages::count(array(
            array(
                "read" => '0',
                "user_id" => $userId
            )
        ));
        $this->view->newMessageCount = $count;

        return true;
    }

    private function _saveUploadedImage()
    {
        $identity = $this->session->get('auth-identity');
        $user_id = $identity['id'];
        $count = UserMessages::count(array(
            array(
                "read" => '0',
                "user_id" => $user_id
            )
        ));
        $this->view->newMessageCount = $count;
        
        $uploads = $this->request->getUploadedFiles();
        $resizeImages = array();
        
        if (!empty($uploads)) {
            $file = $uploads[0];
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
                $imageFile = $tmp.'.jpg';

                unlink($tmp);

                imagejpeg($image, $imageFile, 75);
                imagedestroy($image);

                $client = S3Client::factory(array(
                    'key'    => $this->config->amazon->AWSAccessKeyId,
                    'secret' => $this->config->amazon->AWSSecretKey,
                    'region' => 'us-west-2'
                ));
                $bucket = 'findmyrice';
                $key = 'recipes/';

                $identity = $this->session->get('auth-identity');
                $userId = $identity['id'];

                $image = new GD($imageFile);

                // origin image
                $uniqueName = 'origin_' . time() . '-' . $userId;
                $uniqueKey = $key . $uniqueName . '.jpg';

                $ratio = $image->getWidth() / 675;

                $image->resize(ceil($image->getWidth() / $ratio), ceil($image->getHeight() / $ratio));
                $image->save();

                $result = $client->putObject(array(
                    'Bucket'     => $bucket,
                    'Key'        => $uniqueKey,
                    'ACL'=> 'public-read',
                    'SourceFile' => $image->getRealPath(),
                    'ContentType'     => 'image/jpeg'
                ));

                if ($result) {
                    $resizeImages['origin'] = $result['ObjectURL'];
                }

                // preview image
                $uniqueName = 'preview_' . time() . '-' . $userId;
                $uniqueKey = $key . $uniqueName . '.jpg';

                $ratio = 675 / 200;

                $image->resize(ceil($image->getWidth() / $ratio), ceil($image->getHeight() / $ratio));
                $image->save();

                $result = $client->putObject(array(
                    'Bucket'     => $bucket,
                    'Key'        => $uniqueKey,
                    'ACL'=> 'public-read',
                    'SourceFile' => $image->getRealPath(),
                    'ContentType'     => 'image/jpeg'
                ));

                if ($result) {
                    $resizeImages['preview'] = $result['ObjectURL'];
                }

                unlink($imageFile);
            }
        }

        return $resizeImages;
    }
}