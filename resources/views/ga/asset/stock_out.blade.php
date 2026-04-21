<form method="POST" action="{{ route('ga.assets.stock.out.store', $asset->id) }}">
    @csrf
    <input type="number" name="qty" required>
    <button>Simpan</button>
</form>