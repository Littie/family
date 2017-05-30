$(function () {
    $('input:checkbox').change(function () {
        if (this.checked) {
            this.closest('tr').remove();
            var id = $(this.closest('tr')).children('td:first').html();

            $.ajax({
                url: '/update',
                method: 'POST',
                data: {
                    id: id
                },
                success: function (response) {

                },
                error: function (response) {
                    console.log(response);
                }
            });
        }
    })
});