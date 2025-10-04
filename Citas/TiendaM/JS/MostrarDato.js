fetch('https://api.example.com/objects')
  .then(response => response.json())
  .then(data => {
    // Aquí puedes trabajar con los datos obtenidos de la API
    const objects = data.objects;

    // Recorrer los objetos y crear elementos HTML para cada uno
    objects.forEach(object => {
      const category = document.getElementById(object.category);
      const objectElement = document.createElement('div');
      objectElement.textContent = object.name;

      // Comparar la ID del elemento con la categoría del objeto
      if (category.id === object.category) {
        category.appendChild(objectElement);
      }
    });
  })
  .catch(error => console.error(error));