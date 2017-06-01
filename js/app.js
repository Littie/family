$(function () {
    $('select').change(function () {
        var userId = parseInt($(this).find(":selected").val());
        var taskId = $(this.closest('tr')).children('td:first').html();

        if (!isNaN(userId)) {
            this.closest('tr').remove();

            $.ajax({
                url: '/assign',
                method: 'POST',
                data: {
                    userId: userId,
                    taskId: taskId
                },
                success: function (response) {

                },
                error: function (response) {
                    console.log(response);
                }
            });
        }
    });

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