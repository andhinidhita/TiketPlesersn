@extends('layouts.admin')

@section('title', $title . ' - Admin')
@section('page_title', $title)
@section('subtitle', 'Kelola dan pantau akun yang tersimpan di sistem.')

@section('content')
    <div class="overflow-hidden rounded-[28px] border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 px-6 py-5">
            <p class="text-xs font-extrabold uppercase tracking-[0.28em] text-slate-400">Pengguna</p>
            <h3 class="mt-2 text-xl font-extrabold text-slate-950">{{ $title }}</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-extrabold uppercase tracking-widest text-slate-500">Nama</th>
                        <th class="px-6 py-4 text-left text-xs font-extrabold uppercase tracking-widest text-slate-500">Email</th>
                        <th class="px-6 py-4 text-left text-xs font-extrabold uppercase tracking-widest text-slate-500">Role</th>
                        <th class="px-6 py-4 text-left text-xs font-extrabold uppercase tracking-widest text-slate-500">Dibuat</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse ($users as $user)
                        <tr>
                            <td class="px-6 py-5 text-sm font-extrabold text-slate-950">{{ $user->name }}</td>
                            <td class="px-6 py-5 text-sm font-semibold text-slate-600">{{ $user->email }}</td>
                            <td class="px-6 py-5 text-sm font-semibold text-slate-600">{{ ucfirst($user->role) }}</td>
                            <td class="px-6 py-5 text-sm font-semibold text-slate-600">{{ $user->created_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-14 text-center text-sm text-slate-500">Belum ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
