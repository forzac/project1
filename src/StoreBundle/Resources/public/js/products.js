$(document).ready(function(){
    $.ajax({url:"/api/products",
        method: "GET",
        dataType:"json",
        success:function(data){
            console.log(data);
            getProduct(data);

            $("td > .del").click(function(event) {
                if (confirm('Уверенны что хотите удалить?')) {
                    var elementId = event.target.parentNode.getAttribute('data-id');

                    $.ajax({url:"/api/products/" + elementId,
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

    function getProduct(data) {
        data.products.forEach(function (element) {
            $(".product").append("<tr><td>" + element.id + "</td>" +
                "<td>" + element.name + "</td>" +
                "<td>" + element.description + "</td>" +
                "<td>" + element.quantity + "</td>" +
                "<td class='col-md-5'>" + getImages(element.images) +"</td>" + //+ element.images[1].media.name
                "<td>" + element.category.name + "</td>" +
                "<td class='col-md-2' data-id='"+element.id+"'><a href='#' class='btn btn-danger del' >DELETE</a>" +
                " <a href='/admin/products/"+ element.id +"' class='btn btn-primary'>EDIT</a> </td></tr>"
            );
        });
    }

    function getImages(image) {
        var img = [];

        try {
            image.forEach(function(element, index) {
                if (index == 3) {
                    throw new Error(); // Simulated break
                } else {
                    var min = element.path.replace('.', '_thumb.');
                    console.log();
                    img[index] = '<img class="image-min" src="/' + min + '">';
                }
            });
        } catch (e) {}

        var str = img.join(", ");
        return str;
    }
    //$(".create").click(function(event) {
    //    var name = $('#product_name').val();
    //    var description = $('#product_description').val();
    //    var quantity = $('#product_quantity').val();
    //    var category = $('#product_category').val();
    //
    //    $.ajax({
    //        url:"/api/products",
    //        dateType: 'application/json',
    //        method: "POST",
    //        data: {
    //            product: {name: name, description: description, quantity: quantity, category: category}
    //        },
    //        success:function(data){
    //            console.log(data);
    //            //window.location.href = "/admin/products"
    //        }
    //    });
    //});

    //$(".edit").click(function(event) {
    //    var name = $('#product_name').val();
    //    var description = $('#product_description').val();
    //    var quantity = $('#product_quantity').val();
    //    var category = $('#product_category').val();
    //    var id = event.target.getAttribute('data-id');
    //
    //    $.ajax({url:"/api/products/" + id,
    //        dataType: 'json',
    //        method: "PUT",
    //        data: {
    //                product: {name: name, description: description, quantity: quantity, category: category}
    //             },
    //        success:function(data){
    //            //window.location.href = "/admin/products"
    //        }
    //    });
    //});
});