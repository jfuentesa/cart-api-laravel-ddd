# Cart API - Laravel y DDD

Este proyecto es una muestra de uso del paradigma de programación DDD funcional dentro de un Framework como Laravel, del cual es independiente.

Principalmente hay tres partes:

1. Servicio
2. Repositorio de datos del carrito
3. Pasarela de pago

## Características

- **DDD**: En la carpeta app/CartAPI se divide cada componente de la API en sus tres capas principales (Infrastructure => Application => Domain/).

- **Almacenamiento en archivos**: Para ejecutar este ejemplo no es necesaria la configuración de bases de datos, ya que el repositorio de almacenamiento es en archivos. Estos archivos se almacenan en /storage/carts.

- **Pasarela de pagos**: La pasarela de pagos es Dummy, y se puede configurar con la pasarela correspondiente.

- **Imagen Docker**: build.sh permite la construcción de una imagen de docker con el proyecto totalmente funcional. Es importante recordar que es necesario mapear el puerto 80.

## Requisitos

- PHP 8+

Para la construcción de la imagen:
- Bash
- Docker engine instalado en la máquina para la construcción de la imagen

## Funcionamiento

1. Clona el repositorio.
2. Cambia al directorio del proyecto y crea la imagen docker:
```
bash ./build.sh
```
3. Ejecuta la imagen de docker:
```
docker run --rm -p 80:80 cartapi
```

Para acceder al contenedor en local y las funciones AJAX funcionen correctamente es recomendable realizar el acceso mediante la siguiente dirección:
http://domaincontrol.com

En caso contrario la protección CORS podrían bloquear estas peticiones AJAX.

## Tests

La ejecución de los tests de integración del sistema se realiza mediante artisan:

```
php artisan test
```

Se comprueban que todos los endpoints realizan la función correspondiente.

Para simular los objetos con sistemas externos se tienen dos clases simuladas (mocks):
1. CartServiceMockup
2. PaymentGatewayMockup

## Documentación de la API

Esta API proporciona endpoints para gestionar un carrito de compra.

### Endpoints

#### Listar Items del Carrito

##### Método: GET
- Ruta: /api/v1/cart/{id}/list
- Descripción: Obtiene la lista de items del carrito identificado por el `{id}`.

#### Agregar un Item al Carrito

##### Método: POST
- Ruta: /api/v1/cart/{id}/additem/{productId}
- Descripción: Agrega una unidad del producto identificado por `{productId}` al carrito identificado por el `{id}`.

#### Borrar una Unidad de un Item

##### Método: DELETE
- Ruta: /api/v1/cart/{id}/deleteitem/{productId}
- Descripción: Borra una unidad del producto identificado por `{productId}` del carrito identificado por el `{id}`.

#### Borrar Todos los Items del Mismo Producto

##### Método: DELETE
- Ruta: /api/v1/cart/{id}/deleteitemall/{productId}
- Descripción: Borra todos los items del producto identificado por `{productId}` del carrito identificado por el `{id}`.

#### Limpiar el Carrito

##### Método: DELETE
- Ruta: /api/v1/cart/{id}/clear
- Descripción: Borra todos los items del carrito identificado por el `{id}`.

#### Realizar el Pago

##### Método: POST
- Ruta: /api/v1/cart/{id}/pay
- Descripción: Realiza el pago en la pasarela de pagos para los items en el carrito identificado por el `{id}`.

## Licencia

Este proyecto está licenciado bajo [GNU General Public License v3.0](LICENSE).
