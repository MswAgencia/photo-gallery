<div class="row">
	<div class="col-lg-8">
		<h1 class="page-header">Nova Galeria</h1>
		<p>Preencha o formulário para cadastrar uma nova galeria.</p>
		<?php
			echo $this->Flash->render();

			echo $this->Form->create(null, ['type' => 'file']);

			echo $this->Html->tag('legend', 'Informações Básicas');

			if($options['use_order_field'])
				echo $this->Form->input('sort_order', ['label' => 'Ordem', 'type' => 'number']);

			echo $this->Form->input('name', ['label' => 'Nome']);

			echo $this->Form->textarea('description', ['label' => 'Descrição']);

			if($options['use_image']) {
				echo '<div class="form-group">';
				echo $this->Form->label('Capa');
				echo $this->Form->file('cover');
				echo '</div>';
			}
			echo $this->Form->select('category_id', $categoriesList, ['label' => 'Categoria']);

			echo $this->Form->checkbox('status', ['label' => 'Ativar']);

			echo $this->Html->tag('legend', 'Configurações');

			echo $this->Form->input('photo_width', ['label' => 'Largura das Fotos (pixels)', 'value' => $options['default_gallery_photos_width']]);
			echo $this->Form->input('photo_height', ['label' => 'Altura das Fotos (pixels)', 'value' => $options['default_gallery_photos_height']]);
			echo $this->Form->select('photo_resize_mode', ['resize' => 'Redimensionar', 'resizeCrop' => 'Redimensionar e Cortar'], ['label' => 'Modo de Redimensionamento', 'value' => $options['default_gallery_photos_resize_mode']]);
			echo $this->Form->submit('Cadastrar', ['class' => 'btn btn-primary']);
			echo $this->Form->end();
		?>
	</div>
</div>
