<?php
namespace PhotoGallery\Controller;

use PhotoGallery\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use AppCore\Lib\ImageUploader;
use AppCore\Lib\ImageUploaderConfig;

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
        $this->Galleries = TableRegistry::get('PhotoGallery.Galleries');
        $this->set('tableHeaders', ['Imagem', 'Nome', 'Status', 'Opções']);
        $this->set('data', $this->Galleries->getAllGalleries());
    }

    /**
     * [add description]
     */
    public function add() {
        if($this->request->is('post')) {
            $this->Galleries = TableRegistry::get('PhotoGallery.Galleries');
            $data = $this->request->data;

            $uploader = new ImageUploader();
            if($uploader->setData($data['image'])) {
              $uploader->setPath('photo-gallery');
              $uploader->setConfig(new ImageUploaderConfig(
                Configure::read('WebImobApp.Plugins.PhotoGallery.Settings.Options.gallery_cover_width'),
                Configure::read('WebImobApp.Plugins.PhotoGallery.Settings.Options.gallery_cover_height'),
                Configure::read('WebImobApp.Plugins.PhotoGallery.Settings.Options.gallery_resize_mode')
              ));

              $image = $uploader->upload();
              if($image) {
                  $data['cover'] = $image;
              }
              else {
                $data['cover'] = '';
              }
            }
            else {
              $data['cover'] = '';
            }

            $result = $this->Galleries->insertNewGallery($data);

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
        $this->Galleries = TableRegistry::get('PhotoGallery.Galleries');
        $categoriesTable = TableRegistry::get('PhotoGallery.Categories');

        if($this->request->is('post')) {
            $this->Galleries = TableRegistry::get('PhotoGallery.Galleries');
            $data = $this->request->data;
            $result = $this->Galleries->updateGallery($id, $data);

            if($result) {
                $this->Flash->set('Galeria editada!', ['element' => 'AppCore.alert_success']);
            }
            else {
                $this->Flash->set('Erro ao tentar adicionar uma nova galeria.', ['element' => 'AppCore.alert_danger']);
            }
        }
        $gallery = $this->Galleries->get($id);
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
        $this->Galleries = TableRegistry::get('PhotoGallery.Galleries');
        $result = $this->Galleries->deleteGallery($id);
        if($result) {
            $this->Flash->set('Galeria removida!', ['element' => 'AppCore.alert_success']);
        }
        else {
            $this->Flash->set('Erro ao tentar adicionar uma nova galeria.', ['element' => 'AppCore.alert_danger']);
        }
        $this->redirect(['action' => 'index']);
    }
}
