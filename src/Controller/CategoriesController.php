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
      $this->Categories = TableRegistry::get('PhotoGallery.Categories');
      $categories = $this->Categories->getAllCategories();

      $this->set('data', $categories);
      $this->set('tableHeaders', ['Nome', 'Status', 'Opções']);
      $this->set('options', Configure::read('WebImobApp.Plugins.PhotoGallery.Settings.Options'));
    }

    /**
     * [add description]
     */
    public function add()
    {
      if($this->request->is('post')) {
        $this->Categories = TableRegistry::get('PhotoGallery.Categories');
        $data = $this->request->data;
        $result = $this->Categories->insertNewCategory($data);

        if($result) {
            $this->Flash->set('Nova categoria adicionada!', ['element' => 'alert_success']);
        }
        else {
            $this->Flash->set('Erro ao tentar adicionar uma nova categoria.', ['element' => 'alert_danger']);
        }
      }
      $this->set('options', Configure::read('WebImobApp.Plugins.PhotoGallery.Settings.Options'));
    }

    public function edit($id)
    {
      $this->Categories = TableRegistry::get('PhotoGallery.Categories');
      try {
        if($this->request->is('post')) {

          $category = $this->Categories->get($id);
          $data = $this->request->data;

          $category = $this->Categories->patchEntity($category, $data);
          if($this->Categories->save($category))
              $this->Flash->set('Categoria editada!', ['element' => 'alert_success']);
          else
              $this->Flash->set('Não foi possível editar a categoria!', ['element' => 'alert_danger']);
        }
        $this->set('category', $this->Categories->get($id));
        $this->set('options', Configure::read('WebImobApp.Plugins.PhotoGallery.Settings.Options'));
      }
      catch(\Exception $e) {
        $this->Flash->set('Categoria inexistente.', ['element' => 'alert_danger']);
        $this->redirect(['action' => 'index']);
      }
    }

    public function delete($id) {
      $this->Categories = TableRegistry::get('PhotoGallery.Categories');
      $result = $this->Categories->deleteCategory($id);

      if($result) {
        $this->Flash->set('Categoria removida!', ['element' => 'alert_success']);
      }
      else {
        $this->Flash->set('Erro ao tentar adicionar uma nova categoria.', ['element' => 'alert_danger']);
      }
      $this->redirect(['action' => 'index']);
    }
}
