<div class="bg-white rounded-xl overflow-hidden card-hover group border border-gray-200 cursor-pointer"
     onclick="showBookDetail({
        book_id: {{ $book->id }},
        judul: '{{ addslashes($book->judul) }}',
        penulis: '{{ addslashes($book->penulis) }}',
        penerbit: '{{ addslashes($book->penerbit ?? '-') }}',
        tahun: '{{ $book->tahun_terbit ?? '-' }}',
        isbn: '{{ $book->isbn ?? '-' }}',
        harga: 'Rp {{ number_format($book->harga, 0, ',', '.') }}',
        stok: {{ $book->stok }},
        deskripsi: '{{ addslashes($book->deskripsi ?? 'Tidak ada deskripsi.') }}',
        cover: '{{ $book->cover ? asset('storage/' . $book->cover) : '' }}'
     })">
    <div class="bg-gray-50 flex items-center justify-center h-52 relative overflow-hidden">
        @if($book->cover)
        <img src="{{ asset('storage/' . $book->cover) }}" alt="{{ $book->judul }}" class="h-full w-full object-cover group-hover:scale-[1.03] transition-transform duration-300">
        @else
        <div class="flex flex-col items-center">
            <i class="fas fa-book text-gray-200 text-5xl"></i>
        </div>
        @endif
        @if($book->stok < 1)
        <span class="absolute top-3 right-3 bg-red-500/90 text-white text-[10px] font-semibold px-2 py-0.5 rounded">Habis</span>
        @endif
    </div>
    <div class="p-4">
        <h3 class="font-semibold text-gray-900 mb-0.5 line-clamp-1 text-sm">{{ $book->judul }}</h3>
        <p class="text-xs text-gray-400 mb-1">{{ $book->penulis }}</p>
        @if($book->penerbit)
        <p class="text-[11px] text-gray-400 mb-2">{{ $book->penerbit }}</p>
        @endif
        <div class="flex items-center justify-between pt-2 border-t border-gray-100">
            <p class="text-base font-bold text-gray-900">Rp {{ number_format($book->harga, 0, ',', '.') }}</p>
            <span class="text-[11px] font-medium {{ $book->stok > 0 ? 'text-green-600' : 'text-red-500' }}">
                {{ $book->stok > 0 ? 'Stok ' . $book->stok : 'Habis' }}
            </span>
        </div>
    </div>
</div>
