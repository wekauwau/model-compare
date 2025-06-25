<div class="space-y-2 text-sm">
    <div><strong>Region:</strong> {{ $car->region }}</div>
    <div><strong>Manufacturer:</strong> {{ $car->manufacturer }}</div>
    <div><strong>Odometer:</strong> {{ number_format($car->odometer) }} miles</div>
    <div><strong>Actual Price:</strong> ${{ number_format($car->dataset_price, 2) }}</div>
    <div><strong>Predicted Price:</strong> ${{ number_format($car->predictedPrice->rf ?? 0, 2) }}</div>
</div>
