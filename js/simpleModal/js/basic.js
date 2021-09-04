jQuery(function ($) {
		$('#buscar').click(function (e) {
			$('#listado').modal({onOpen: function (dialog) {
				dialog.overlay.fadeIn('slow', function () {
				dialog.data.hide();
				dialog.container.fadeIn('slow', function () {
				dialog.data.slideDown('slow');
				$.modal.defaults.closeClass = "basic";
				});});
			}},listarDocentes());
		 });
		 $('#listado').click(function (e) {
			 cargarDatos();
			 $.modal.close();
		 });
		 $('#close').click(function (e) {
			 limpiar();
			 $.modal.close();
		 });


		$('#buscarL').click(function (e) {
			$('#listado').modal({onOpen: function (dialog) {
				dialog.overlay.fadeIn('slow', function () {
				dialog.data.hide();
				dialog.container.fadeIn('slow', function () {
				dialog.data.slideDown('slow');
				$.modal.defaults.closeClass = "basic";
				});});
			}},listarUnidades());
		 });
		 $('#listado').click(function (e) {
			 //cargarLugares();
			 $.modal.close();
		 });
		 $('#close').click(function (e) {
			 limpiar();
			 $.modal.close();
		 });
});