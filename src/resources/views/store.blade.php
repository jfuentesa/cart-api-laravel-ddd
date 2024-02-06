<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de productos</title>
    <style>
        .products {
            display: block;
            clear: both;
            overflow: hidden; /* Esta propiedad es clave */
            border: 1px solid #ccc;
        }
        .product {
            border: 1px solid #ccc;
            padding: 20px;
            margin: 10px;
            width: 200px;
            float: left;
            text-align: center;
        }
        .button {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="products">
@foreach ($products as $_product)
<div class="product">
<h2>Producto</h2>
<p>{{$_product->getDescription()}}</p>
<p>Precio: {{$_product->getPrice()}}</p>
<button onclick="cart.addItem({{$_product->getId()}})" class="button">Comprar</button>
</div>
@endforeach
</div>

<h1>Carrito de la compra</h1>

<div id="cart-container">
</div>

<button onclick="cart.payCart()" class="button">Pagar</button>

<script>
var cartId = "1";
var apiUrl = "http://domaincontrol.com"; // Apunta a 127.0.0.1

class Cart {
    addItem(productId) {
        var endpoint = "/api/v1/cart/" + cartId + "/additem/" + productId;

        // Realizar la petición usando Fetch API
        fetch(apiUrl + endpoint, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);

            var items = data.items;
            var subtotal = data.subtotal;
            var total = data.total;

            this.printCart(items, subtotal, total);
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    refresh(productId) {
        var endpoint = "/api/v1/cart/" + cartId + "/list";

        // Realizar la petición usando Fetch API
        fetch(apiUrl + endpoint, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);

            var items = data.items;
            var subtotal = data.subtotal;
            var total = data.total;

            this.printCart(items, subtotal, total);
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    deleteItem(productId) {
        var endpoint = "/api/v1/cart/" + cartId + "/deleteitem/" + productId;

        // Realizar la petición usando Fetch API
        fetch(apiUrl + endpoint, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);

            var items = data.items;
            var subtotal = data.subtotal;
            var total = data.total;

            this.printCart(items, subtotal, total);
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    deleteItemAll(productId) {
        var endpoint = "/api/v1/cart/" + cartId + "/deleteitemall/" + productId;

        // Realizar la petición usando Fetch API
        fetch(apiUrl + endpoint, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);

            var items = data.items;
            var subtotal = data.subtotal;
            var total = data.total;

            this.printCart(items, subtotal, total);
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    payCart() {
        var endpoint = "/api/v1/cart/" + cartId + "/pay";

        // Realizar la petición usando Fetch API
        fetch(apiUrl + endpoint, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);

            var items = data.items;
            var subtotal = data.subtotal;
            var total = data.total;

            this.printCart(items, subtotal, total);
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    printCart(items, subtotal, total) {
        var cartContainer = document.getElementById("cart-container");

        // Limpiar el contenido actual del contenedor del carrito
        cartContainer.innerHTML = "";

        // Crear elementos HTML para mostrar los detalles del carrito
        var itemsList = document.createElement("ul");
        for (var key in items) {
            if (items.hasOwnProperty(key)) {
                var item = items[key];
                var listItem = document.createElement("li");
                listItem.innerHTML = "<button onclick='cart.deleteItemAll(" + item.id + ")' class='delete' data-id='item.id'>Borrar</button> " + item.description + " - Cantidad: <button onclick='cart.deleteItem(" + item.id + ")'>-</button>" + item.qty + "<button onclick='cart.addItem(" + item.id + ")'>+</button>";
                itemsList.appendChild(listItem);
            }
        }

        var subtotalElement = document.createElement("p");
        subtotalElement.textContent = "Subtotal: " + subtotal;

        var totalElement = document.createElement("p");
        totalElement.textContent = "Total: " + total;

        // Agregar los elementos al contenedor del carrito
        cartContainer.appendChild(itemsList);
        cartContainer.appendChild(subtotalElement);
        cartContainer.appendChild(totalElement);
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Se ejecutará cuando la página haya completado su carga
    cart.refresh();
});

var cart = new Cart();
</script>
</body>
</html>
