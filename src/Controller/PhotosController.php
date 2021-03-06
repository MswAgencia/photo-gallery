<?php
namespace PhotoGallery\Controller;

use Cake\Network\Exception\ForbiddenException;
use PhotoGallery\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use SimpleFileUploader\FileUploader;
use AppCore\Lib\Image\Image;

class PhotosController extends AppController
{
  public $helpers = ['AppCore.Form', 'DefaultAdminTheme.PanelMenu'];

  public function initialize()
  {
    parent::initialize();
    $this->loadModel('PhotoGallery.Galleries');
    $this->loadModel('PhotoGallery.Photos');
  }

  public function manage($id)
  {
    $gallery = $this->Galleries->get($id, ['contain' => 'Photos.PhotosThumbnails.Photos']);
    $this->set('gallery', $gallery);
  }

  public function add($id)
  {
    $gallery = $this->Galleries->get($id);

    if($this->request->is('post')) {
      $data = $this->request->data;
      $uploader = new FileUploader();
      $uploader->allowTypes('image/jpg', 'image/jpeg', 'image/png')
        ->setDestination(TMP . 'uploads');

      $uploadedPhotosCounter = 0;
      $photos = [];

      foreach($data['image'] as $image) {
        $uploadedPhotosCounter++;
        $thumbs = [];
        $uploadedImage = $uploader->upload($image);

        $image = new Image($uploadedImage);
        $image->resizeTo($gallery->photo_width, $gallery->photo_height, $gallery->photo_resize_mode);

        $photo = $image->save(WWW_ROOT . 'img/galleries/photos/');

        if(Configure::read('WebImobApp.Plugins.PhotoGallery.Settings.Options.apply_watermark_on_photos')) {
          $watermark = new Image(Configure::read('WebImobApp.Plugins.PhotoGallery.Settings.Options.watermark_filepath'));
          $photo = $watermark->placeOver($photo, 20, $photo->getHeight() - (20 + $watermark->getHeight()));
          $watermark->close();
        }

        foreach(Configure::read('WebImobApp.Plugins.PhotoGallery.Settings.Image.Photos.Thumbnails') as $ref => $config) {
          $image->resizeTo($config['width'], $config['height'], $config['mode']);
          $thumb = $image->save(WWW_ROOT . 'img/galleries/photos/', 'thumb_' . $image->getFilename());
          $thumbs[] = ['ref' => $ref, 'path' => 'galleries/photos/' . $thumb->getFilename()];
        }
        $photos[] = ['photo' => 'galleries/photos/' . $photo->getFilename(), 'thumbnails' => $thumbs];
      }

      if($this->Photos->addNewPhotosToGallery($gallery->id, $photos)) {
        $this->Flash->set("{$uploadedPhotosCounter} foto(s) foram adicionadas", ['element' => 'AppCore.alert_success']);
      }
      else {
        $this->Flash->set('Houve um erro ao tentar adicionar novas fotos.', ['element' => 'AppCore.alert_danger']);
      }
    }
    $this->redirect("/interno/galeria-de-fotos/galerias/{$id}/fotos/");
  }

  public function setOrder()
  {
    $this->autoRender = false;
    if(!$this->request->is('post'))
    throw new ForbiddenException();

    $photosTable = TableRegistry::get('PhotoGallery.Photos');

    $data = $this->request->data;
    $photo = $photosTable->get($data['photo']);

    if(is_numeric($data['order'])) {
      $photo->sort_order = $data['order'];
      $photosTable->save($photo);
    }
  }

  public function delete($id, $photo_id)
  {
    $photosTable = TableRegistry::get('PhotoGallery.Photos');
    $photo = $photosTable->get($photo_id);
    if($photosTable->delete($photo)) {
      $this->Flash->set('Foto deletada!', ['element' => 'AppCore.alert_success']);
    }
    $this->redirect("/interno/galeria-de-fotos/galerias/{$id}/fotos/");
  }
}
