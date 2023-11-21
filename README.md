# Estudiante
**Nombre:** Charly William Brantt Saavedra  
**RUT:** 20.515.039-0  
**Carrera:** Ingeniería Civil Informática  

# CRUD para perros

### Crear perros
`POST http://127.0.0.1:8000/api/crearPerro`  

**Body:**
{
    "nombre": "Fido",
    "edad": 3,
    "raza": "Labrador",
    "descripcion": "Un perro muy amigable"
}

la url de la imagen y el id se generan de forma automatica

### Para ver todos los perros

`GET http://127.0.0.1:8000/api/verPerros`

### Para editar los perros

`POST http://127.0.0.1:8000/api/editarPerro/{id}`

### Para borrar perros

`DELETE http://127.0.0.1:8000/api/borrarPerro/{id}`



# Resto de apis

### Para ver el array de los candidatos sin el perro interesado
`GET http://127.0.0.1:8000/api/candidatos/{id del perro interesado}`

### Para registrar las preferencias de cada perro
`POST http://127.0.0.1:8000/api/preferencias/{id del perro}`

**Body**
{
    "likes": [1,2,3],
    "dislikes": [5]
}

### Para revisar si existe match o no
`GET http://127.0.0.1:8000/api/match/{id perro 1}/{id perro 2}`

### Para ver los aceptados de un perro en especifico
`GET http://127.0.0.1:8000/api/{id del perro}/aceptados`

### Para ver los rechazados de un perro en especifico
`GET http://127.0.0.1:8000/api/{id del perro}/rechazados`









