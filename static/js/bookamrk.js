/*
 * Copyright (c) 2018 ayatk. licensed under the MIT License.
 */

var id = 0;
var baseURL = "http://localhost/api/bookmark/";

$(function () {

    loadBookmark();

    $('#submit').click(function (e) {
        if ($('#submit').val() === 'update') {
            editBookmark(id, $('#name').val(), $('#url').val(), $('#tags').val());
        } else {
            postBookmark($('#name').val(), $('#url').val(), $('#tags').val());
        }
        return e.preventDefault();
    });

    $('#clear').click(function (e) {
        $('#name').val("");
        $('#url').val("");
        $('#tags').val("");
        $('#submit').val("add");
        return e.preventDefault();
    });
});

function deleteBookmark(id) {
    // Request (2) (DELETE http://localhost/api/bookmark/:id)

    $.ajax({url: baseURL + id, type: "DELETE"})
        .done(function (data, textStatus, jqXHR) {
            $("tr[data-id=" + id + "]").remove();
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            console.log("HTTP Request Failed");
        });
}

function editBookmark(id, name, url, tags) {

    // Request (2) (PUT http://localhost/api/bookmark/:id)

    $.ajax({
        url: baseURL + id,
        type: "PUT",
        headers: {
            "Content-Type": "application/json; charset=utf-8"
        },
        data: JSON.stringify({
            "name": name,
            "url": url,
            "tags": tags
        })
    })
        .done(function (data, textStatus, jqXHR) {
            console.log("HTTP Request Succeeded: " + jqXHR.status);
            $('#name').val("");
            $('#url').val("");
            $('#tags').val("");
            $('#submit').val("add");
            loadBookmark();
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            console.log("HTTP Request Failed");
        })
}

function postBookmark(name, url, tags) {
    // Request (POST http://localhost/api/bookmark/)

    $.ajax({
        url: baseURL,
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify({
            "name": name,
            "url": url,
            "tags": tags
        })
    })
        .done(function (data, textStatus, jqXHR) {
            console.log("HTTP Request Succeeded: " + jqXHR.status);
            $('#name').val("");
            $('#url').val("");
            $('#tags').val("");
            loadBookmark();
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            console.log("HTTP Request Failed");
        });
}

function loadBookmark() {
    // Request (GET http://localhost/api/bookmark/)

    $.ajax({url: baseURL, type: "GET"})
        .done(function (data, textStatus, jqXHR) {
            $('#bookmark-table tbody').empty();
            console.log("HTTP Request Succeeded: " + jqXHR.status);
            var table = '';
            data.forEach(function (bookmark) {
                table += '<tr data-id="' + bookmark['id'] + '" data-href="' + bookmark['url'] + '">' +
                    '<td class="id">' + bookmark['id'] + '</td>' +
                    '<td class="name">' + bookmark['name'] + '</td>' +
                    '<td class="url"><a href="' + bookmark['url'] + '">' + bookmark['url'] + '</a></td>' +
                    '<td>' + bookmark['tag'] + '</td>' +
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
                id = $(this).data('id');
                $('#name').val($("tr[data-id=" + id + "] .name").text());
                $('#url').val($("tr[data-id=" + id + "] .url a").text());
                $('#submit').val('update');
            });
        });
}
