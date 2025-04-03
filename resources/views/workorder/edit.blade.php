<form id="editForm" action="{{ route('workorder.update', encrypt($workorder->id)) }}" method="POST" class="space-y-4">
    @csrf
    @method('PUT')

    <!-- Pelapor Select -->
    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="user_id">
            Pelapor<span class="text-red-500">*</span>
        </label>
        <select
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('user_id') border-red-500 @enderror"
            id="user_id" name="user_id">
            <option value="">Select Pelapor</option>
            @foreach ($operators as $operator)
                <option value="{{ $operator->id }}"
                    {{ old('user_id', $workorder->user_id) == $operator->id ? 'selected' : '' }}>
                    {{ $operator->name }}
                </option>
            @endforeach
        </select>
        @error('user_id')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
        @enderror
    </div>

    <!-- Judul Input -->
    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="judul">
            Judul<span class="text-red-500">*</span>
        </label>
        <input
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('judul') border-red-500 @enderror"
            id="judul" type="text" name="judul" value="{{ old('judul', $workorder->judul) }}"
            placeholder="Enter Judul">
        @error('judul')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
        @enderror
    </div>

    <!-- Deskripsi Input -->
    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="deskripsi">
            Deskripsi
        </label>
        <textarea
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('deskripsi') border-red-500 @enderror"
            id="deskripsi" name="deskripsi" placeholder="Enter Deskripsi">{{ old('deskripsi', $workorder->deskripsi) }}</textarea>
        @error('deskripsi')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
        @enderror
    </div>

    <!-- Status Select -->
    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="status">
            Status<span class="text-red-500">*</span>
        </label>
        <select
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('status') border-red-500 @enderror"
            id="status" name="status">
            <option value="">Select Status</option>
            <option value="Menunggu" {{ old('status', $workorder->status) == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
            <option value="Diproses" {{ old('status', $workorder->status) == 'Diproses' ? 'selected' : '' }}>Diproses</option>
            <option value="Selesai" {{ old('status', $workorder->status) == 'Selesai' ? 'selected' : '' }}>Selesai</option>
        </select>
        @error('status')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
        @enderror
    </div>

    <!-- Update Form Actions -->
    <div class="flex justify-end space-x-4">
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Update
        </button>
        <button type="button" onclick="closeEditModal()"
            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Cancel
        </button>
    </div>
</form>

<script>
    document.getElementById('editForm').addEventListener('submit', function(e) {
        e.preventDefault();

        fetch(this.action, {
                method: 'PUT',
                body: new FormData(this),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content'),
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closeEditModal();
                    window.location.reload();
                }
            })
            .catch(error => console.error('Error:', error));
    });
</script>
