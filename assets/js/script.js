$(function() {
    $(".delete_link").click(function() {
        // Demande une vérification pour la suppression
        var id = $(this).attr("data-id");
        return confirm("Voulez vous vraiment supprimer " + id + " ?");
    });
});

input = $( "#MotCleJS" ).html();

$(".addMotCleJS").click(function() {
	jQuery('#MotCleJS').append(input);
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