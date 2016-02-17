<?php
	echo $this->Form->input('sort_order', ['class' => 'sort-order-input', 'label' => 'Ordem', 'value' => $photo->photo->sort_order, 'data-id' => $photo->photo->id]);
	echo $this->Html->image($photo->path, ['class' => 'img-responsive']);
	echo $this->Html->link('<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>', "/interno/galeria-de-fotos/galerias/{$galleryId}/fotos/remover/{$photo->photo->id}",['confirm' => 'Deseja excluir a foto?', 'escape' => false, 'class' => 'btn btn-default btn-lg']);
?>
