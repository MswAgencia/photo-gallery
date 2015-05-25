<?php
namespace PhotoGallery\Controller;

use Cake\Network\Exception\ForbiddenException;
use PhotoGallery\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use AppCore\Lib\ImageUploader;
use AppCore\Lib\ImageUploaderConfig;

/**
 * Photos Controller
 *
 * @property \PhotoGallery\Model\Table\PhotosTable $Photos
 * @property \PhotoGallery\Model\Table\GalleriesTable $Galleries
 */
class PhotosController extends AppController
{
    public $helpers = ['AppCore.Form', 'DefaultAdminTheme.PanelMenu'];

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('PhotoGallery.Galleries');
        $this->loadModel('PhotoGallery.Photos');
    }
    /**
     * [manage description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function manage($id) {
        $gallery = $this->Galleries->getGallery($id);
        $this->set('gallery', $gallery);
    }

    /**
     * [add description]
     * @param [type] $id [description]
     */
    public function add($id) {
    	$gallery = $this->Galleries->get($id);

    	if($this->request->is('post')) {
    	    $data = $this->request->data;
    	    $uploader = new ImageUploader();
    	    $uploader->setPath('galleries/photos/');
            $uploadedPhotosCounter = 0;
            $photos = [];
    	    
            foreach($data['image'] as $image) {
    	    	$uploader->setData($image);
                $uploader->setConfig($gallery->getPhotoConfig());
                $uploadedPhoto = $uploader->upload();

                // se a foto foi criada
                if($uploadedPhoto) {
                    $uploadedPhotosCounter++;
                    // criamos todas as thumbnails gerais do arquivo de configuração
                    $thumbs = [];
                    foreach(Configure::read('WebImobApp.Plugins.PhotoGallery.Settings.Image.Photos.Thumbnails') as $ref => $config) {
                        $uploader->setConfig(new ImageUploaderConfig($config['width'], $config['height'], $config['mode']));
                        $thumbs[] = ['ref' => $ref, 'path' => $uploader->thumbnail()];
                    }
                    $photos[] = [
                        'photo' => $uploadedPhoto, 
                        'thumbnails' => $thumbs
                        ];
                    
                    $uploader->close();
                }
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

    public function setOrder() {
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

    public function delete($id, $photo_id) {
        $photosTable = TableRegistry::get('PhotoGallery.Photos');
        $photo = $photosTable->get($photo_id);
        if($photosTable->delete($photo)) {
            $this->Flash->set('Foto deletada!', ['element' => 'AppCore.alert_success']);
        }
        $this->redirect("/interno/galeria-de-fotos/galerias/{$id}/fotos/");
    }
}
