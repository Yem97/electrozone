<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Items Catalogue</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f0f0f0; }
        img { max-height: 80px; }
    </style>
</head>
<body>
    <h2>Items Catalogue</h2>

    <table>
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Categorie</th>
                <th>Quantity</th>
                <th>Unite price (FCFA)</th>
                <th>Partner price (FCFA)</th>

            </tr>
        </thead>
        <tbody>
            @foreach($equipments as $equipment)
            <tr>
                <td>
                    @if($equipment->image)
                        <img src="{{ public_path('storage/' . $equipment->image) }}" alt="{{ $equipment->name }}">
                    @else
                        N/A
                    @endif
                </td>
                <td>{{ $equipment->name }}</td>
                <td>{{ $equipment->category->name ?? 'Non classé' }}</td>
                <td>{{ $equipment->initial_quantity }}</td>
                <td>{{ number_format($equipment->unit_price, 0, ',', ' ') }}</td>
                <td>{{ number_format($equipment->partner_unit_price, 0, ',', ' ') }}</td>

            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
