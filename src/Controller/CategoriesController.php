<?php
namespace PhotoGallery\Controller;

use PhotoGallery\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;

/**
 * Categories Controller
 *
 * @property \PhotoGallery\Model\Table\CategoriesTable $Categories
 */
class CategoriesController extends AppController
{
    public $helpers = ['AppCore.Form', 'DefaultAdminTheme.PanelMenu'];

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index() {
        $categoriesTable = TableRegistry::get('PhotoGallery.Categories');
        $data = $categoriesTable->getAllCategories();

        $this->set('data', $data);
        $this->set('tableHeaders', ['Nome', 'Status', 'Opções']);
        $this->set('options', Configure::read('WebImobApp.Plugins.PhotoGallery.Settings.Options'));
    }

    /**
     * [add description]
     */
    public function add() {
        if($this->request->is('post')) {
            $categoriesTable = TableRegistry::get('PhotoGallery.Categories');
            $data = $this->request->data;
            $result = $categoriesTable->insertNewCategory($data);

            if($result) {
                $this->Flash->set('Nova categoria adicionada!', ['element' => 'alert_success']);
            }
            else {
                $this->Flash->set('Erro ao tentar adicionar uma nova categoria.', ['element' => 'alert_danger']);
            }
        }
        $this->set('options', Configure::read('WebImobApp.Plugins.PhotoGallery.Settings.Options'));
    }

    /**
     * [edit description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id) {
        $categoriesTable = TableRegistry::get('PhotoGallery.Categories');
        try {
            if($this->request->is('post')) {

                $category = $categoriesTable->get($id);
                $data = $this->request->data;

                $category = $categoriesTable->patchEntity($category, $data);
                if($categoriesTable->save($category))
                    $this->Flash->set('Categoria editada!', ['element' => 'alert_success']);
                else
                    $this->Flash->set('Não foi possível editar a categoria!', ['element' => 'alert_danger']);
            }
            $this->set('category', $categoriesTable->get($id));
            $this->set('options', Configure::read('WebImobApp.Plugins.PhotoGallery.Settings.Options'));
        }
        catch(\Exception $e) {
            $this->Flash->set('Categoria inexistente.', ['element' => 'alert_danger']);
            $this->redirect('/interno/galeria-de-fotos/categorias');
        }
    }

    /**
     * [delete description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function delete($id) {
        $categoriesTable = TableRegistry::get('PhotoGallery.Categories');
        $result = $categoriesTable->deleteCategory($id);

        if($result) {
            $this->Flash->set('Categoria removida!', ['element' => 'alert_success']);
        }
        else {
            $this->Flash->set('Erro ao tentar adicionar uma nova categoria.', ['element' => 'alert_danger']);
        }
        $this->redirect('/interno/galeria-de-fotos/categorias');
    }
}
