$(document).ready(function () {
    let products = productsInCart();
    if(products){
        $("#cart-count").html(products.length);
    }else{
        $("#cart-count").html("0");
    }
    
    
    if(!products.length)
        emptyCart();
    else{
        cartContent();
    }
});

function emptyCart(){
    $("#container-message").html("<h1>Your cart is empty.</h1>");
}

function productsInCart() {
    return JSON.parse(localStorage.getItem("products"));
}

function cartContent() {
    let products = productsInCart();
    //let u_id = $("#hdnId").val();
    
    let ids = [];
    products.forEach(function(product){
        ids.push(product.id);
    });

    $.ajax({
        url : "models/admin/products/products-cart.php",
        method: "POST",
        type: "json",
        data: {
            ids: ids
        },
        success : function(data) {
            if(data){
                let forDisplay = [];
                forDisplay = data.filter(el => {
                    for(let product of products){
                        if(el.product_id == product.id){
                            el.quantity = product.quantity;
                            return true;
                        }
                    }
                    return false;
                });
                displayInCart(data);
            }
        }
    });
}
function displayInCart(products){
    let html = "";
    products.forEach(function(product){
        html += singleCartProduct(product);
    });
    $("#cart-table tbody").html(html);
    $(".rmv-prdct").click(deleteFromCart);
}
 
function singleCartProduct(product){
    return `<tr>
    <td class="product-thumbnail">
      <img src="${product.small}" alt="${product.title}" class="img-fluid">
    </td>
    <td class="product-name">
      <h2 class="h5 text-black">${product.title}</h2>
    </td>
    <td>$${product.price}</td>
    <td>
      <div class="input-group mb-3" style="max-width: 120px;">
        <div class="input-group-prepend">
          <button class="btn btn-outline-primary js-btn-minus" type="button">&minus;</button>
        </div>
        <input type="text" class="form-control text-center" value="${product.quantity}" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">
        <div class="input-group-append">
          <button class="btn btn-outline-primary js-btn-plus" type="button">&plus;</button>
        </div>
      </div>
    </td>
    <td>$${product.price * product.quantity} <input type="hidden" class=".total" value="${product.price * product.quantity}"/></td>
    <td><a href="#" data-id="${product.product_id}" class="btn btn-primary btn-sm rmv-prdct">X</a></td>
      </tr>`;
}
function deleteFromCart(e){
    e.preventDefault();
    let id = $(this).data("id");
    let products = productsInCart();
    let array = products.filter(p => p.id != id);

    if(array.length == 0){
        window.location.reload();
    }
    localStorage.setItem("products", JSON.stringify(array));
    cartContent();


    
}

