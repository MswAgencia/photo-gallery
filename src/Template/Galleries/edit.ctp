<div class="row">
	<div class="col-lg-8">
		<h1 class="page-header">Editar Galeria</h1>
		<p>Edite as informações abaixo conforme necessário.</p>
		<?php
			echo $this->Flash->render();

			echo $this->Form->create($gallery, ['type' => 'file']);

			echo $this->Html->tag('legend', 'Informações Básicas');

			if($options['use_order_field'])
				echo $this->Form->input('sort_order', ['label' => 'Ordem', 'type' => 'number']);

			echo $this->Form->input('name', ['label' => 'Nome']);
			echo $this->Form->textarea('description', ['label' => 'Descrição']);
			
			if($options['use_image']) {
				echo '<div class="form-group">';
				echo $this->Form->label('Imagem');
				echo $this->Form->file('image');
				echo '</div>';
			}
			echo $this->Form->select('category_id', \AppCore\Lib\Utility\ArrayUtility::markValue($categoriesList, $gallery->category_id, '(atual)'), ['label' => 'Categoria']);
			
			echo $this->Form->checkbox('status', ['label' => 'Ativar']);

			echo $this->Html->tag('legend', 'Configurações');

			echo $this->Form->input('photo_width', ['label' => 'Largura das Fotos (pixels)']);
			echo $this->Form->input('photo_height', ['label' => 'Altura das Fotos (pixels)']);
			echo $this->Form->select('photo_resize_mode', \AppCore\Lib\Utility\ArrayUtility::markValue(['resize' => 'Redimensionar', 'resizeCrop' => 'Redimensionar e Cortar'], $gallery->photo_resize_mode, '(atual)'), ['label' => 'Modo de Redimensionamento', 'value' => 'resizeCrop']);
			echo $this->Form->submit('Editar', ['class' => 'btn btn-primary']);
			echo $this->Form->end();
		?>
	</div>
</div>

