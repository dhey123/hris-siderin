<form method="POST" action="{{ route('ga.assets.stock.in.store', $asset->id) }}">
    @csrf
    <input type="number" name="qty" required>
    <button>Simpan</button>
</form>