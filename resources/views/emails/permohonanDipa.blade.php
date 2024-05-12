<!DOCTYPE html>
<html>

<head>
    <title>Permohonan</title>
</head>

<body>
    <h1>Halo, {{ $dipa->unit->kepalaUnit->name }}</h1>
    <p>Ada permohonan Usulan Dipa dari {{ $dipa->unit->name }}
    </p>
    <p>
        <a href=" {{ route('dipa.review', $dipa->id) }}">
        </a>Klik link berikut untuk melihat permohonan.
        <br>
        {{ route('dipa.review', $dipa->id) }}
        </a>
    </p>
</body>

</html>
