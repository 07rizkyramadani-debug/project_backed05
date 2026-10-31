{{-- Style mandiri (tidak bergantung pada build Tailwind) untuk tombol aksi & tombol tambah --}}
<style>
    .aksi-group { display: flex; align-items: center; justify-content: center; gap: 8px; flex-wrap: wrap; }
    .aksi-group form { margin: 0; display: inline-block; }
    .btn-aksi {
        display: inline-block; padding: 4px 12px; border-radius: 6px; border: 1px solid transparent;
        font-size: 12px; font-weight: 600; line-height: 1.4; cursor: pointer; text-decoration: none;
    }
    .btn-pinjam { background: #dcfce7; color: #166534; border-color: #86efac; }
    .btn-pinjam:hover { background: #bbf7d0; }
    .btn-edit { background: #dbeafe; color: #1e40af; border-color: #93c5fd; }
    .btn-edit:hover { background: #bfdbfe; }
    .btn-hapus { background: #fee2e2; color: #991b1b; border-color: #fca5a5; }
    .btn-hapus:hover { background: #fecaca; }
    .btn-tambah {
        display: inline-block; padding: 8px 16px; border-radius: 6px; background: #2563eb; color: #fff;
        font-size: 14px; font-weight: 700; text-decoration: none;
    }
    .btn-tambah:hover { background: #1d4ed8; }
</style>