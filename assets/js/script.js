$(function() {
    $(".delete_link").click(function() {
        // Demande une vérification pour la suppression
        var id = $(this).attr("data-id");
        return confirm("Voulez vous vraiment supprimer " + id + " ?");
    });
});

// Ajout des mots clés //
input = $("#MotCleJS").html();

$(".addMotCleJS").click(function() {
	jQuery('#MotCleJS').append(input);
});

// Modification en fonction de la langue article //
$("#NumLang").change(function() {
	var numLang = $(this).val();

	// NumAngl
	$("#NumAngl option").each(function () {
		var lang = $(this).attr("data-lang");
		if(lang == numLang) {
			$(this).removeAttr('disabled');
		} else {
			$(this).attr('disabled', 'disabled');
		}
		$(this).prop("selected", false);
	});

	// NumThem
	$("#NumThem option").each(function () {
		var lang = $(this).attr("data-lang");
		if(lang == numLang) {
			$(this).removeAttr('disabled');
		} else {
			$(this).attr('disabled', 'disabled');
		}
		$(this).prop("selected", false);
	});
});

/*$(document).ready(function() {
	$('#fetchval').on('change', function() {
		var value = $(this).val();
		$.ajax({
			url: 'fetch.php',
			type: 'POST',
			data: 'request=' + value,
			beforeSend: function() {
				$('#table_container').html('Veuillez patienter ...');
			},
			success: function(data) {
				$('#table_container').html(data);
			}
		})

	})
})*/