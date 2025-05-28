<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8" />
    @vite('resources/js/app.js')
    <title>Загрузка Excel файла</title>
</head>
<body>
    <h1>Загрузите Excel файл (.xlsx)</h1>

    <form id="uploadForm">
        @csrf
        <input type="file" name="file" accept=".xlsx" required />
        <button type="submit">Загрузить</button>
    </form>

    <div id="result"></div>

    <script>
        document.getElementById('uploadForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            fetch('/api/upload-excel', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if(data.message){
                    document.getElementById('result').innerText = data.message;
                } else if(data.error){
                    document.getElementById('result').innerText = data.error + (data.details ? ': ' + data.details : '');
                }
            })
            .catch(error => {
                document.getElementById('result').innerText = 'Произошла ошибка при отправке.';
                console.error('Ошибка:', error);
            });
        });
    </script>
</body>
</html>