<h1>Galeria: <?= $gallery->name ?></h1>
<?= $this->Flash->render() ?>
<legend>Adicionar Fotos</legend>
<?php
	echo $this->Form->create(null, ['type' => 'file', 'url' => "/interno/galeria-de-fotos/galerias/{$gallery->id}/fotos/adicionar/"]);
	echo $this->Form->input('image.', ['type' => 'file', 'multiple' => true]);
	echo $this->Form->submit('Enviar', ['class' => 'btn btn-primary']);
	echo $this->Form->end();
?>
<br>
<legend>Fotos Adicionadas</legend>
<div class="row">
	<?php
		foreach($gallery->getPhotosSorted() as $photo) {
			echo '<div class="col-md-3">';
			echo $this->element('PhotoGallery.gallery_photo_row_item', ['photo' => $photo->getPainelThumbnail(), 'galleryId' => $gallery->id]);
			echo '</div>';	
		}
	?>
</div>

<script type="text/javascript">
	$(document).on('ready', function (){
		$(this).on('change', '.sort-order-input', function (){
			var id = $(this).data('id');
			var order = $(this).val();

			if(order < 1) {
				alert('O número da ordem deve ser maior ou igual a 1.');
				return false;
			}

			var request = $.post("<?= $this->Url->build('/interno/galeria-de-fotos/galerias/fotos/set_order/') ?>", {
				photo: id,
				order: order
			});
		});

		$(".sort-order-input").keydown(function (e) {
	        // Allow: backspace, delete, tab, escape, enter and .
	        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
	             // Allow: Ctrl+A
	            (e.keyCode == 65 && e.ctrlKey === true) || 
	             // Allow: home, end, left, right
	            (e.keyCode >= 35 && e.keyCode <= 39)) {
	                 // let it happen, don't do anything
	                 return;
	        }
	        // Ensure that it is a number and stop the keypress
	        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
	            e.preventDefault();
	        }
	    });
	});
</script>