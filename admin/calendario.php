<?php
/*
 * software de desarrollo a la medida - Sistema ERP para PYMEs
 * Copyright (C) 2016 carlos villalobos <carvilf@gmail.com>
 *
 * este programa es de uso licenciado y distribuido por su propietario adsi gaes 15 carlos villalobos;se encuentra prohibida su reproduccion y modificacion parcial o total
 * aplican terminos de licencia shareware, prohibido su reproduccion y distribucion sin previa autorizacion del autor
 */
?>
<script type="text/javascript">
jQuery(function() {
	$(document).ready(function() {
		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,basicWeek,basicDay'
			},
			editable: true,
			firstDay: 1,
			theme: false,
			monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio',
			             'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
			buttonText: {
				today: "Hoy",
				month: "Mes",
				week: "Semana",
				day: "Día"
			},
			eventSources: [
				{
					url: "run/_buscar_tareas.php",
					type: "POST",
					error: function() {
						
					},
					color: "#FCCB38",
					textColor: "black",
				},
				{
					url: "run/_buscar_eventos.php",
					type: "POST",
					error: function() {
					},
					color: "#FC8B00",
					textColor: "black",
				}			
			],
			loading: function(bool) {
				if (bool) $('#loading').show();
				else $('#loading').hide();
			},
			selectable: true,
			select: function(start, end, allDay) {
				var nombre = prompt("Nombre");
				if (!nombre)
					return;
				var descripcion = prompt("Descripción");
				if (nombre) {
					var start = $.fullCalendar.formatDate(start, "yyyy-MM-dd HH:mm:ss");
					var end = $.fullCalendar.formatDate(end, "yyyy-MM-dd HH:mm:ss");
					$.ajax({
						url: "run/_nueva_tarea_calendario.php",
						data: "nombre=" + nombre + "&descripcion=" + descripcion + "&start=" + start + "&end=" + end,
						type: "POST",
						success: function(json) {
							alert("Tarea añadida correctamente");
						}
					});
				}	
			},
			editable: true,
			eventDrop: function(event, delta) {
				var start = $.fullCalendar.formatDate(event.start, "yyyy-MM-dd HH:mm:ss");
				var end = $.fullCalendar.formatDate(event.end, "yyyy-MM-dd HH:mm:ss");
				$.ajax({
					url: "run/_modificar_tarea_calendario.php",
					data: "nombre=" + event.title + "&start=" + start + "&end=" + end,
					type: "POST",
					success: function(json) {
						
					}
				});
			},
			eventResize: function(event, delta) {
				var start = $.fullCalendar.formatDate(event.start, "yyyy-MM-dd HH:mm:ss");
				var end = $.fullCalendar.formatDate(event.end, "yyyy-MM-dd HH:mm:ss");
				$.ajax({
					url: "run/_modificar_tarea_calendario.php",
					data: "nombre=" + event.title + "&start=" + start + "&end=" + end,
					type: "POST",
					success: function(json) {
						
					}
				});
			}
		});
	});
});
</script>

<div style="width:700px;margin:0 auto;border:1px" id="calendar"></div>
<br/>
<div id="loading">Cargando . . .</div>
