<?php
namespace Findmyrice\Controllers;


use Findmyrice\Forms\IngredientsForm;
use Findmyrice\Forms\RecipeCategoriesForm;
use Findmyrice\Forms\IngredientsUnitForm;
use Findmyrice\Models\Ingredients;
use Findmyrice\Models\IngredientsUnit;
use Findmyrice\Models\RecipeCategories;

class ManageRecipesController extends ControllerBase
{
    public function initialize()
    {
        $identity = $this->session->get('auth-identity');
        $userProfile = $identity['profile'];

        if ($userProfile != 'Administrators') {
            $this->flash->error('You don\'t have access to this module');
            $this->dispatcher->forward(array(
                'controller' => 'recipes',
                'action' => 'index'
            ));
        }

        $this->view->setTemplateBefore('private');
    }

    public function categoriesAction()
    {
        $this->assets->addJs('js/alias_generator.js');

        $form = new RecipeCategoriesForm();

        if ($this->request->isPost()) {
            $categories = new RecipeCategories();
            $form->bind($this->request->getPost(), $categories);

            if ($form->isValid()) {
                if (!$categories->save()) {
                    $this->response->setStatusCode(500, 'Can\'t save category in database');
                } else {
                    $this->flash->success('Recipe Category was created successfully');

                    $form->clear();
                }
            }
        }

        $categories = RecipeCategories::find();

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
                    $category = RecipeCategories::findById($id);
                    if ($category) {
                        if (!$category->delete()) {
                            return $this->response->setStatusCode(500, 'Can\'t delete category from database');
                        }
                    }
                }
            }

            return $this->response->redirect('manageRecipes/categories');
        }
    }

    public function unitsAction()
    {
        $form = new IngredientsUnitForm();

        if ($this->request->isPost()) {
            $unit = new IngredientsUnit();
            $form->bind($this->request->getPost(), $unit);

            if (!$unit->save()) {
                $this->response->setStatusCode(500, 'Can\'t save Unit in database');
            } else {
                $this->flash->success('The Ingredients Unit was created successfully');

                $form->clear();
            }
        }

        $units = IngredientsUnit::find();

        $this->view->setVars(array(
            'form' => $form,
            'units' => $units
        ));
    }

    public function deleteUnitsAction()
    {
        if ($this->request->isPost()) {
            $rmUnit = $this->request->getPost('unit');

            foreach ($rmUnit as $id => $status) {
                if ($status == 'on') {
                    $unit = IngredientsUnit::findById($id);
                    if ($unit) {
                        if (!$unit->delete()) {
                            return $this->response->setStatusCode(500, 'Can\'t delete unit from database');
                        }
                    }
                }
            }

            return $this->response->redirect('manageRecipes/units');
        }
    }

    public function ingredientsAction()
    {
        $form = new IngredientsForm();

        if ($this->request->isPost()) {
            $ingredient = new Ingredients();
            $form->bind($this->request->getPost(), $ingredient);

            if (!$ingredient->save()) {
                $this->response->setStatusCode(500, 'Can\'t save Ingredient in database');
            } else {
                $this->flash->success('The Ingredient was created successfully');

                $form->clear();
            }
        }

        $ingredients = Ingredients::find();

        $this->view->setVars(array(
            'form' => $form,
            'ingredients' => $ingredients
        ));
    }

    public function deleteIngredientsAction()
    {
        if ($this->request->isPost()) {
            $rmIngredient = $this->request->getPost('ingredient');

            foreach ($rmIngredient as $id => $status) {
                if ($status == 'on') {
                    $ingredient = Ingredients::findById($id);
                    if ($ingredient) {
                        if (!$ingredient->delete()) {
                            return $this->response->setStatusCode(500, 'Can\'t delete ingredient from database');
                        }
                    }
                }
            }

            return $this->response->redirect('manageRecipes/ingredients');
        }
    }
}