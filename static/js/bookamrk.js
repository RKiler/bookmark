$(function () {
    // Request (GET http://localhost/api/bookmark/)

    $.ajax({url: "//localhost/api/bookmark/", type: "GET"})
        .done(function (data, textStatus, jqXHR) {
            console.log("HTTP Request Succeeded: " + jqXHR.status);
            var table = '';
            data.forEach(function (bookmark) {
                table += '<tr data-id="' + bookmark['id'] + '" data-href="' + bookmark['url'] + '">' +
                    '<td>' + bookmark['id'] + '</td>' +
                    '<td>' + bookmark['name'] + '</td>' +
                    '<td>' + bookmark['url'] + '</td>' +
                    '<td>tags</td>' +
                    '<td class="actions">' +
                    '<button class="edit button button-clear" data-id="' + bookmark['id'] + '"><i class="material-icons">edit</i></button>' +
                    '<button class="delete button button-clear" data-id="' + bookmark['id'] + '"><i class="material-icons icon-delete">clear</i></button></td>' +
                    '</tr>';
            });
            $('#bookmark-table tbody').append(table);
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            console.log("HTTP Request Failed");
        })
        .always(function () {
            $(".delete").on('click', function () {
                deleteBookmark($(this).data('id'));
            });

            $(".edit").on('click', function () {
                var id = $(this).data('id');
            });
        });
});

function deleteBookmark(id) {
    // Request (2) (DELETE http://localhost/api/bookmark/:id)

    jQuery.ajax({
        url: "http://localhost/api/bookmark/" + id,
        type: "DELETE"
    })
        .done(function (data, textStatus, jqXHR) {
            $("#bookmark-table tbody tr[data-id=" + id + "]").remove();
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            console.log("HTTP Request Failed");
        });
}
