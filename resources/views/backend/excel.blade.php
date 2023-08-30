<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cargar Excel</title>
</head>
<body>
    <h1>Cargar Archivo Excel</h1>
    <form action="{{ route('cargar.excel') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="archivo_excel" accept=".xlsx, .xls">
        <button type="submit">Cargar Excel</button>
    </form>
</body>
</html>
