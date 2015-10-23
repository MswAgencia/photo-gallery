<?php
namespace PhotoGallery\Controller;

use PhotoGallery\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use SimpleFileUploader\FileUploader;

class GalleriesController extends AppController
{
  public $helpers = ['AppCore.Form', 'DefaultAdminTheme.PanelMenu'];

  public function initialize()
  {
    parent::initialize();
    $this->loadModel('PhotoGallery.Galleries');
    $this->loadModel('PhotoGallery.Categories');
  }

  public function index()
  {
    $this->Galleries = TableRegistry::get('PhotoGallery.Galleries');
    $this->set('tableHeaders', ['Imagem', 'Nome', 'Status', 'Opções']);
    $this->set('data', $this->Galleries->getAllGalleries());
  }

  public function add()
  {
    if($this->request->is('post')) {
      $data = $this->request->data;

      if(Configure::read('WebImobApp.Plugins.PhotoGallery.Settings.Options.use_image')) {
        $uploader = new FileUploader();
        $uploader->allowTypes('image/jpg', 'image/jpeg', 'image/png')
          ->setDestination(TMP . 'uploads');

        $uploadedImage = $uploader->upload($data['cover']);
        $image = new Image($uploadedImage);

        $image->resizeTo(
          Configure::read('WebImobApp.Plugins.PhotoGallery.Settings.Options.gallery_cover_width'),
          Configure::read('WebImobApp.Plugins.PhotoGallery.Settings.Options.gallery_cover_height'),
          Configure::read('WebImobApp.Plugins.PhotoGallery.Settings.Options.gallery_cover_resize_mode')
        );

        $cover = $image->save(WWW_ROOT . 'img/galleries/');

        if($cover) {
          $data['cover'] = 'img/galleries/' . $cover->getFilename();

        $data['cover'] = '';
        $data['cover_thumbnail'] = '';

        $image->resizeTo(
          Configure::read('WebImobApp.Plugins.PhotoGallery.Settings.Options.gallery_cover_thumbnail_width'),
          Configure::read('WebImobApp.Plugins.PhotoGallery.Settings.Options.gallery_cover_thumbnail_height'),
          Configure::read('WebImobApp.Plugins.PhotoGallery.Settings.Options.gallery_cover_thumbnail_resize_mode')
        );

        $thumbnailImageName = 'thumb_' .
          Configure::read('WebImobApp.Plugins.PhotoGallery.Settings.Options.gallery_cover_thumbnail_width') . '_' .
          Configure::read('WebImobApp.Plugins.PhotoGallery.Settings.Options.gallery_cover_thumbnail_height') .
          $image->getFilename();

          $coverThumbnail = $image->save(WWW_ROOT . 'img/galleries/', $thumbnailImageName);
          if($coverThumbnail) {
            $data['cover_thumbnail'] = 'img/galleries/' . $coverThumbnail->getFilename();
          }
        }
      }
      else {
        $data['cover'] = '';
        $data['cover_thumbnail'] = '';
      }
    }
    else {
      $data['cover'] = '';
      $data['cover_thumbnail'] = '';
    }

    $result = $this->Galleries->insertNewGallery($data);

    if($result) {
      $this->Flash->set('Nova galeria adicionada!', ['element' => 'AppCore.alert_success']);
      $this->request->data = [];
    }
    else {
      $this->Flash->set('Erro ao tentar adicionar uma nova galeria.', ['element' => 'AppCore.alert_danger']);
    }

    $this->set('options', Configure::read('WebImobApp.Plugins.PhotoGallery.Settings.Options'));
    $this->set('categoriesList', $this->Categories->getCategoriesAsList());
  }


  public function edit($id)
  {
    if($this->request->is('post')) {
      $data = $this->request->data;

      if(Configure::read('WebImobApp.Plugins.PhotoGallery.Settings.Options.use_image')) {
        $uploader = new FileUploader();
        $uploader->allowTypes('image/jpg', 'image/jpeg', 'image/png')
            ->setDestination(TMP . 'uploads');

        $uploadedImage = $uploader->upload($data['cover']);
        $image = new Image($uploadedImage);

        $image->resizeTo(
          Configure::read('WebImobApp.Plugins.PhotoGallery.Settings.Options.gallery_cover_width'),
          Configure::read('WebImobApp.Plugins.PhotoGallery.Settings.Options.gallery_cover_height'),
          Configure::read('WebImobApp.Plugins.PhotoGallery.Settings.Options.gallery_cover_resize_mode')
        );

        $cover = $image->save(WWW_ROOT . 'img/galleries/');
        unset($data['cover']);

        if($cover)
          $data['cover'] = 'img/galleries/' . $cover->getFilename();

          $image->resizeTo(
            Configure::read('WebImobApp.Plugins.PhotoGallery.Settings.Options.gallery_cover_thumbnail_width'),
            Configure::read('WebImobApp.Plugins.PhotoGallery.Settings.Options.gallery_cover_thumbnail_height'),
            Configure::read('WebImobApp.Plugins.PhotoGallery.Settings.Options.gallery_cover_thumbnail_resize_mode')
          );

          $thumbnailImageName = 'thumb_' .
            Configure::read('WebImobApp.Plugins.PhotoGallery.Settings.Options.gallery_cover_thumbnail_width') . '_' .
            Configure::read('WebImobApp.Plugins.PhotoGallery.Settings.Options.gallery_cover_thumbnail_height') .
            $image->getFilename();

          $coverThumbnail = $image->save(WWW_ROOT . 'img/galleries/', $thumbnailImageName);
          if($coverThumbnail)
            $data['cover_thumbnail'] = 'img/galleries/' . $coverThumbnail->getFilename();
          else
            unset($data['cover']);
        }
        else {
          unset($data['cover']);
        }

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
      $this->set('categoriesList', $this->Categories->getCategoriesAsList());
  }


  public function delete($id)
  {
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
