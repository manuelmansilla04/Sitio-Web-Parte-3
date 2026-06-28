# tpe-web2-parte3
GRUPO 39
Alumno: Franco Manuel Mansilla

Mail: manuelmansilla2004@gmail.com

La "tienda de aromas" ofrece un servicio comercial con la posibilidad de seleccionar productos que el usuario desee. Las compras engloban objetos que puedan aromatizar ambientes y el cuerpo, como fragancias textiles, perfumes, etc.

![DER.png](/DER.png)



## Obtener todas las categorias `GET`
# Endpoint: `/api/categorias/`

| Parámetros        | Tipo   | Valores                                                                                                                                                                                                                          | Descripción                                          | Ejemplo                                              |
|-------------------|--------|----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|------------------------------------------------------|------------------------------------------------------|
| `atributo, orden` | string | `atributo` = nombre, descripcion<br>`orden` = DESC, ASC                                                                                                                                                                          | Ordena resultados por campo y dirección               | `/api/categorias/?atributo=nombre&orden=DESC`        |
| `nombre`          | string | Difusores de aromas, Perfumes Textiles, Jabones Liquidos, Aux cat 1, Aux cat 2                                                                                                                                                   | Filtra resultados por nombre con coincidencia parcial | `/api/categorias/?nombre=Jabones`                    |
| `descripcion`     | string | Dispersa fragancias en el aire para crear un ambiente agradable y relajante, Se usa para perfumar telas y ambientes, Agente limpiador en formato fluido ofrecido a través de un dispensador, bbb bbb bbb, ccc ccc ccc           | Filtra resultados por descripcion con coincidencia parcial | `/api/categorias/?descripcion=Dispersa`         |
| `page, limit`     | number | `page` = 1,2,3...<br>`limit` = 1,2,3...                                                                                                                                                                                         | Paginación y límite de resultados por página          | `/api/categorias/?page=2&limit=3`                    |

Los parámetros se pueden combinar entre sí. Ejemplo:
`/api/categorias/?nombre=Jabones&atributo=nombre&orden=ASC&page=1&limit=5`

## Obtener una categoria `GET`
# Endpoint: `/api/categorias/:id`

| Parámetros | Tipo   | Descripción                        |
|------------|--------|------------------------------------|
| `id`       | number | id de la categoria a fetchear      |

## Agregar una categoria `POST`
# Endpoint: `/api/categorias/`

Requiere autenticación con token JWT (ver sección "Obtener token").

| Campo         | Tipo   | Requerido | Descripción                  |
|---------------|--------|-----------|------------------------------|
| `nombre`      | string | Sí        | Nombre de la categoría       |
| `descripcion` | string | Sí        | Descripción de la categoría  |
| `img`         | string | Sí        | URL de la imagen             |

Ejemplo de body:
```json
{
  "nombre": "Difusores de aromas",
  "descripcion": "Dispersa fragancias en el aire para crear un ambiente agradable y relajante",
  "img": "https://casaefesta.com/wp-content/uploads/2023/07/como-usar-difusor-de-aromas.jpg"
}
```

## Editar una categoria `PUT`
# Endpoint: `/api/categorias/:id`

Requiere autenticación con token JWT (ver sección "Obtener token").

| Parámetros | Tipo   | Descripción                   |
|------------|--------|-------------------------------|
| `id`       | number | id de la categoria a editar   |

El body debe tener el mismo formato que el POST.

## Eliminar una categoria `DELETE`
# Endpoint: `/api/categorias/:id`

Requiere autenticación con token JWT (ver sección "Obtener token").

| Parámetros | Tipo   | Descripción                    |
|------------|--------|--------------------------------|
| `id`       | number | id de la categoria a eliminar  |

## Obtener token `GET`
# Endpoint: `/api/auth/login`

La autenticación usa **HTTP Basic Auth**. Las credenciales deben enviarse en el header `Authorization` con el formato `Basic base64(username:password)`. No se envía nada en el body.

| Credencial | Valor    |
|------------|----------|
| `username` | webadmin |
| `password` | admin    |

El valor del header se construye así:
1. Concatenar usuario y contraseña con dos puntos: `webadmin:admin`
2. Codificar en Base64: `d2ViYWRtaW46YWRtaW4=`
3. Armar el header: `Authorization: Basic d2ViYWRtaW46YWRtaW4=`

Ejemplo con curl:
curl -X GET http://localhost/api/auth/login 
-H "Authorization: Basic d2ViYWRtaW46YWRtaW4="

Respuesta exitosa `200`:
```json
"eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOjEsInVzdWFyaW8iOiJ3ZWJhZG1pbiIsInJvbGVzIjpbIkFETUlOIiwiVVNFUiIsIk1FU1NJIl0sImV4cCI6MTc0OTEwNzYwMH0.firma"
```

Respuesta con credenciales incorrectas `401`:
```json
"Usuario o contraseña incorrecta"
```

El token obtenido tiene una validez de 1 hora. Para usarlo en los endpoints protegidos (POST, PUT, DELETE), incluirlo en el header: "Authorization: Bearer <token>"