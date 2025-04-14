        document.getElementById('fileInput').addEventListener('change', function(event) {
            const file = event.target.files[0]; // Obtém o arquivo selecionado
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('preview');
                    preview.src = e.target.result; // Define a imagem no elemento <img>
                    preview.style.display = 'block'; // Exibe a imagem
                };
                reader.readAsDataURL(file); // Converte para Data URL
            }
        });