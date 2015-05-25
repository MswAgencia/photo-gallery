<?php
namespace PhotoGallery\Controller;

use PhotoGallery\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
/**
 * Galleries Controller
 *
 * @property \PhotoGallery\Model\Table\GalleriesTable $Galleries
 */
class GalleriesController extends AppController
{
    public $helpers = ['AppCore.Form', 'DefaultAdminTheme.PanelMenu'];
    
    /**
     * [index description]
     * @return [type] [description]
     */
    public function index() {
        $galleriesTable = TableRegistry::get('PhotoGallery.Galleries');
        $this->set('tableHeaders', ['Imagem', 'Nome', 'Status', 'Opções']);
        $this->set('data', $galleriesTable->getAllGalleries());
    }

    /**
     * [add description]
     */
    public function add() {
        if($this->request->is('post')) {
            $galleriesTable = TableRegistry::get('PhotoGallery.Galleries');
            $data = $this->request->data;
            $result = $galleriesTable->insertNewGallery($data);

            if($result) {
                $this->Flash->set('Nova galeria adicionada!', ['element' => 'AppCore.alert_success']);
            }
            else {
                $this->Flash->set('Erro ao tentar adicionar uma nova galeria.', ['element' => 'AppCore.alert_danger']);
            }
        }
        $categoriesTable = TableRegistry::get('PhotoGallery.Categories');
        $this->set('options', Configure::read('WebImobApp.Plugins.PhotoGallery.Settings.Options'));
        $this->set('categoriesList', $categoriesTable->getCategoriesAsList());
    }

    /**
     * [edit description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id) {
        $galleriesTable = TableRegistry::get('PhotoGallery.Galleries');
        $categoriesTable = TableRegistry::get('PhotoGallery.Categories');

        if($this->request->is('post')) {
            $galleriesTable = TableRegistry::get('PhotoGallery.Galleries');
            $data = $this->request->data;
            $result = $galleriesTable->updateGallery($id, $data);

            if($result) {
                $this->Flash->set('Galeria editada!', ['element' => 'AppCore.alert_success']);
            }
            else {
                $this->Flash->set('Erro ao tentar adicionar uma nova galeria.', ['element' => 'AppCore.alert_danger']);
            }
        }
        $gallery = $galleriesTable->get($id);
        $this->set('gallery', $gallery);
        $this->set('options', Configure::read('WebImobApp.Plugins.PhotoGallery.Settings.Options'));
        $this->set('categoriesList', $categoriesTable->getCategoriesAsList());
    }

    /**
     * [delete description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function delete($id) {
        $galleriesTable = TableRegistry::get('PhotoGallery.Galleries');
        $result = $galleriesTable->deleteGallery($id);
        if($result) {
            $this->Flash->set('Galeria removida!', ['element' => 'AppCore.alert_success']);
        }
        else {
            $this->Flash->set('Erro ao tentar adicionar uma nova galeria.', ['element' => 'AppCore.alert_danger']);
        }
        $this->redirect('/interno/galeria-de-fotos/galerias');
    }
}
