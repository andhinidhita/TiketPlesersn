@extends('layouts.admin')

@section('title', $title . ' - Admin')
@section('page_title', $title)
@section('subtitle', $description)

@section('content')
    <div class="rounded-[28px] border border-slate-200 bg-white p-8 shadow-sm">
        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-yellow-400 text-lg font-extrabold text-slate-950">
            {{ strtoupper(substr($title, 0, 1)) }}
        </div>
        <p class="mt-6 text-xs font-extrabold uppercase tracking-[0.28em] text-slate-400">Fitur Admin</p>
        <h3 class="mt-2 text-2xl font-extrabold text-slate-950">{{ $title }}</h3>
        <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-500">{{ $description }}</p>
        <div class="mt-6 rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-5 text-sm font-semibold text-slate-500">
            Halaman ini sudah disiapkan sebagai modul admin. Nanti bisa dilanjutkan dengan form tambah, edit, hapus, dan upload sesuai kebutuhan.
        </div>
    </div>
@endsection
