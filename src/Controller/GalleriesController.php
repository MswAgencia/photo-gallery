<?php
namespace PhotoGallery\Controller;

use PhotoGallery\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use SimpleFileUploader\FileUploader;
use MswAgencia\Image\Image;
use Cake\Filesystem\File;

class GalleriesController extends AppController
{
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

      if(Configure::read('MswAgencia.Plugins.PhotoGallery.Settings.Options.use_image')) {
        $uploader = new FileUploader();
        $uploader->allowTypes('image/jpg', 'image/jpeg', 'image/png')
          ->setDestination(TMP . 'uploads');

        $uploadedImage = $uploader->upload($data['cover']);
        $data['cover'] = '';
        $data['cover_thumbnail'] = '';
        if($uploadedImage) {
          $image = new Image($uploadedImage);

          $image->resizeTo(
            Configure::read('MswAgencia.Plugins.PhotoGallery.Settings.Options.gallery_cover_width'),
            Configure::read('MswAgencia.Plugins.PhotoGallery.Settings.Options.gallery_cover_height'),
            Configure::read('MswAgencia.Plugins.PhotoGallery.Settings.Options.gallery_cover_resize_mode')
          );

          $cover = $image->save(WWW_ROOT . 'img/galleries/');

          if($cover) {
            $data['cover'] = 'galleries/' . $cover->getFilename();

            $image->resizeTo(
              Configure::read('MswAgencia.Plugins.PhotoGallery.Settings.Options.gallery_cover_thumbnail_width'),
              Configure::read('MswAgencia.Plugins.PhotoGallery.Settings.Options.gallery_cover_thumbnail_height'),
              Configure::read('MswAgencia.Plugins.PhotoGallery.Settings.Options.gallery_cover_thumbnail_resize_mode')
            );

            $thumbnailImageName = 'thumb_' .
              Configure::read('MswAgencia.Plugins.PhotoGallery.Settings.Options.gallery_cover_thumbnail_width') . '_' .
              Configure::read('MswAgencia.Plugins.PhotoGallery.Settings.Options.gallery_cover_thumbnail_height') . '_' .
              $image->getFilename();

            $coverThumbnail = $image->save(WWW_ROOT . 'img/galleries/', $thumbnailImageName);
            if($coverThumbnail) {
              $data['cover_thumbnail'] = 'galleries/' . $coverThumbnail->getFilename();
            }
          }
          else {
            $data['cover'] = '';
            $data['cover_thumbnail'] = '';
          }

          $image->close();
          $uploadedImage = new File($uploadedImage);
          $uploadedImage->delete();
        }
      }
      else {
        $data['cover'] = '';
        $data['cover_thumbnail'] = '';
      }

      $result = $this->Galleries->insertGallery($data);
      if($result->hasErrors()) {
        if(Configure::read('MswAgencia.Plugins.PhotoGallery.Settings.Options.use_image')) {
          $file = new File($cover->getFilepath());
          $file->delete();
          $file = new File($coverThumbnail->getFilepath());
          $file->delete();
        }

        $this->Flash->set($result->getErrorMessages(), ['element' => 'ControlPanel.alert_danger']);
      }
      else {
        $this->request->data = [];
        $this->Flash->set('Nova galeria adicionada!', ['element' => 'ControlPanel.alert_success']);
      }
    }

    $this->set('options', Configure::read('MswAgencia.Plugins.PhotoGallery.Settings.Options'));
    $this->set('categoriesList', $this->Categories->getCategoriesAsList());
  }


  public function edit($id)
  {
    if($this->request->is('post')) {
      $data = $this->request->data;

      if(Configure::read('MswAgencia.Plugins.PhotoGallery.Settings.Options.use_image')) {
        $uploader = new FileUploader();
        $uploader->allowTypes('image/jpg', 'image/jpeg', 'image/png')
            ->setDestination(TMP . 'uploads');

        $uploadedImage = $uploader->upload($data['cover']);
        unset($data['cover']);

        if($uploadedImage) {
          $image = new Image($uploadedImage);

          $image->resizeTo(
            Configure::read('MswAgencia.Plugins.PhotoGallery.Settings.Options.gallery_cover_width'),
            Configure::read('MswAgencia.Plugins.PhotoGallery.Settings.Options.gallery_cover_height'),
            Configure::read('MswAgencia.Plugins.PhotoGallery.Settings.Options.gallery_cover_resize_mode')
          );

          $cover = $image->save(WWW_ROOT . 'img/galleries/');

          if($cover) {
            $data['cover'] = 'galleries/' . $cover->getFilename();

            $image->resizeTo(
              Configure::read('MswAgencia.Plugins.PhotoGallery.Settings.Options.gallery_cover_thumbnail_width'),
              Configure::read('MswAgencia.Plugins.PhotoGallery.Settings.Options.gallery_cover_thumbnail_height'),
              Configure::read('MswAgencia.Plugins.PhotoGallery.Settings.Options.gallery_cover_thumbnail_resize_mode')
            );

            $thumbnailImageName = 'thumb_' .
              Configure::read('MswAgencia.Plugins.PhotoGallery.Settings.Options.gallery_cover_thumbnail_width') . '_' .
              Configure::read('MswAgencia.Plugins.PhotoGallery.Settings.Options.gallery_cover_thumbnail_height') . '_' .
              $image->getFilename();

            $coverThumbnail = $image->save(WWW_ROOT . 'img/galleries/', $thumbnailImageName);
            if($coverThumbnail) {
              $data['cover_thumbnail'] = 'galleries/' . $coverThumbnail->getFilename();
            }
          }
          else {
            unset($data['cover']);
          }
          $image->close();
          $uploadedImage = new File($uploadedImage);
          $uploadedImage->delete();
        }
      }
      else {
        unset($data['cover']);
      }

      $gallery = $this->Galleries->get($id);
      $gallery = $this->Galleries->patchEntity($gallery, $data);

      if($gallery->hasErrors()) {
        if(Configure::read('MswAgencia.Plugins.PhotoGallery.Settings.Options.use_image')) {
          $file = new File($cover->getFilepath());
          $file->delete();
          $file = new File($coverThumbnail->getFilepath());
          $file->delete();
        }

        $this->Flash->set($gallery->getErrorMessages(), ['element' => 'ControlPanel.alert_danger']);
      }
      elseif($this->Galleries->save($gallery)) {
        $this->Flash->set('Galeria editada!', ['element' => 'ControlPanel.alert_success']);
      }
    }

    $gallery = $this->Galleries->get($id);
    $this->set('gallery', $gallery);
    $this->set('options', Configure::read('MswAgencia.Plugins.PhotoGallery.Settings.Options'));
    $this->set('categoriesList', $this->Categories->getCategoriesAsList());
  }

  public function delete($id)
  {
    $result = $this->Galleries->deleteGallery($id);
    if($result) {
      $this->Flash->set('Galeria removida!', ['element' => 'ControlPanel.alert_success']);
    }
    else {
      $this->Flash->set('Erro interno ao tentar excluir galeria.', ['element' => 'ControlPanel.alert_danger']);
    }
    $this->redirect(['action' => 'index']);
  }
}
