<?php
// index.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Mi Red Social</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f7f7f7;
      margin: 0;
      padding: 0;
    }

    header {
      background: #3b5998;
      color: white;
      padding: 15px;
      text-align: center;
    }

    .container {
      width: 600px;
      margin: 20px auto;
      background: #fff;
      padding: 20px;
      border-radius: 5px;
    }

    h1 {
      margin-top: 0;
    }

    /* Estilos para el formulario */
    form {
      margin-bottom: 20px;
    }

    form input[type="text"],
    form textarea {
      width: 100%;
      padding: 10px;
      margin-bottom: 10px;
      border: 1px solid #ccc;
      border-radius: 3px;
    }

    form button {
      padding: 10px 20px;
      background: #3b5998;
      color: #fff;
      border: none;
      border-radius: 3px;
      cursor: pointer;
    }
    form button:hover {
      background: #2d4373;
    }

    /* Estilos para las publicaciones */
    .post {
      border: 1px solid #ddd;
      border-radius: 5px;
      padding: 15px;
      margin-bottom: 15px;
      background: #fafafa;
    }

    .post h2 {
      margin-top: 0;
      margin-bottom: 5px;
      font-size: 18px;
    }

    .post p {
      margin: 5px 0;
    }

    .reactions {
      margin-top: 10px;
    }

    .reaction-btn {
      margin-right: 10px;
      cursor: pointer;
      color: #333;
      text-decoration: none;
      border: 1px solid #ccc;
      padding: 5px 10px;
      border-radius: 3px;
      background: #eee;
    }
    .reaction-btn:hover {
      background: #ddd;
    }

    .likes,
    .dislikes {
      margin-left: 5px;
      font-weight: bold;
    }

    .fecha {
      font-size: 12px;
      color: #777;
      text-align: right;
    }
  </style>
</head>
<body>

<header>
  <h1>Mi Red Social</h1>
</header>

<div class="container">
  <h2>Publicar algo nuevo</h2>
  <form id="postForm">
    <input type="text" name="titulo" id="titulo" placeholder="Título de la publicación" required>
    <textarea name="contenido" id="contenido" rows="3" placeholder="Escribe aquí tu contenido..." required></textarea>
    <button type="submit">Publicar</button>
  </form>

  <h2>Publicaciones</h2>
  <div id="postsContainer">
    <!-- Aquí se cargarán las publicaciones de forma dinámica -->
  </div>
</div>

<script>
  // Función para cargar las publicaciones desde fetchPosts.php
  function loadPosts() {
    fetch('fetchPosts.php')
      .then(response => response.json())
      .then(data => {
        const container = document.getElementById('postsContainer');
        container.innerHTML = ''; // Limpiar antes de insertar
        data.forEach(post => {
          // Crear elementos HTML para cada publicación
          const postDiv = document.createElement('div');
          postDiv.className = 'post';

          const title = document.createElement('h2');
          title.textContent = post.titulo;

          const content = document.createElement('p');
          content.textContent = post.contenido;

          const fecha = document.createElement('div');
          fecha.className = 'fecha';
          // Formateamos fecha si es necesario. Por simplicidad, la mostramos tal cual:
          fecha.textContent = `Publicado: ${post.fecha}`;

          // Sección de reacciones
          const reactionsDiv = document.createElement('div');
          reactionsDiv.className = 'reactions';

          // Botón de like
          const likeBtn = document.createElement('a');
          likeBtn.href = '#';
          likeBtn.className = 'reaction-btn';
          likeBtn.textContent = 'Me gusta ';
          likeBtn.addEventListener('click', (e) => {
            e.preventDefault();
            updateReaction(post.id, 'like');
          });

          // Mostrar cantidad de likes
          const likesCount = document.createElement('span');
          likesCount.className = 'likes';
          likesCount.textContent = post.likes;
          likeBtn.appendChild(likesCount);

          // Botón de dislike
          const dislikeBtn = document.createElement('a');
          dislikeBtn.href = '#';
          dislikeBtn.className = 'reaction-btn';
          dislikeBtn.textContent = 'No me gusta ';
          dislikeBtn.addEventListener('click', (e) => {
            e.preventDefault();
            updateReaction(post.id, 'dislike');
          });

          // Mostrar cantidad de dislikes
          const dislikesCount = document.createElement('span');
          dislikesCount.className = 'dislikes';
          dislikesCount.textContent = post.dislikes;
          dislikeBtn.appendChild(dislikesCount);

          // Agregamos los botones de reacciones
          reactionsDiv.appendChild(likeBtn);
          reactionsDiv.appendChild(dislikeBtn);

          // Insertar todo en el div principal de la publicación
          postDiv.appendChild(title);
          postDiv.appendChild(content);
          postDiv.appendChild(fecha);
          postDiv.appendChild(reactionsDiv);

          // Finalmente, agregamos la publicación al contenedor
          container.appendChild(postDiv);
        });
      })
      .catch(error => console.error(error));
  }

  // Función para enviar una reacción (like/dislike) a updateReaction.php
  function updateReaction(postId, reaction) {
    const formData = new FormData();
    formData.append('postId', postId);
    formData.append('reaction', reaction);

    fetch('updateReaction.php', {
      method: 'POST',
      body: formData
    })
    .then(response => response.text())
    .then(result => {
      if (result === 'OK') {
        // Recargamos la lista de publicaciones para ver los nuevos conteos
        loadPosts();
      } else {
        console.error(result);
      }
    })
    .catch(error => console.error(error));
  }

  // Manejo del formulario para agregar nueva publicación
  const postForm = document.getElementById('postForm');
  postForm.addEventListener('submit', function(e) {
    e.preventDefault();

    const titulo = document.getElementById('titulo').value;
    const contenido = document.getElementById('contenido').value;

    const formData = new FormData();
    formData.append('titulo', titulo);
    formData.append('contenido', contenido);

    fetch('addPost.php', {
      method: 'POST',
      body: formData
    })
    .then(response => response.text())
    .then(result => {
      if (result === 'OK') {
        // Limpiamos el formulario
        postForm.reset();
        // Recargamos las publicaciones
        loadPosts();
      } else {
        alert('Error al publicar: ' + result);
      }
    })
    .catch(error => console.error(error));
  });

  // Cargamos las publicaciones al iniciar
  loadPosts();

  // Hacemos que se recarguen cada 5 segundos para simular "tiempo real"
  setInterval(loadPosts, 5000);
</script>

</body>
</html>
