$(document).ready(function(){
    $.ajax({url:"/api/categories",
        method: "GET",
        dataType:"json",
        success:function(data){
            getCategory(data);

            $("td > .del").click(function(event) {
                if (confirm('Уверенны что хотите удалить?')) {
                    var elementId = event.target.parentNode.getAttribute('data-id');

                    $.ajax({url:"/api/categories/" + elementId,
                        method: "DELETE",
                        dataType:"json",
                        success:function(data){
                            window.location.reload();
                        }
                    });
                }
            });

        }
    });

    function getCategory(data) {
        data.categories.forEach(function (element) {
            $(".category").append("<tr><td>" + element.id + "</td>" +
                "<td>" + element.name + "</td>" +
                "<td data-id='"+element.id+"'><a href='#' class='btn btn-danger del' >DELETE</a>" +
                " <a href='/admin/categories/"+ element.id +"' class='btn btn-primary'>EDIT</a> </td></tr>"
            );
        });
    }

    //$(".create").click(function(event) {
    //    var name = $('#category_name').val();
    //
    //    $.ajax({url:"/api/categories",
    //        method: "POST",
    //        data: {'name': name},
    //        success:function(data){
    //            window.location.href = "/admin/categories"
    //        }
    //    });
    //});
    //
    //$(".edit").click(function(event) {
    //    var name = $('#category_name').val();
    //    var id = event.target.getAttribute('data-id');
    //
    //    $.ajax({url:"/api/categories/" + id,
    //        method: "PUT",
    //        data: {'name': name},
    //        success:function(data){
    //            window.location.href = "/admin/categories"
    //        }
    //    });
    //});

});

