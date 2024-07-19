<x-mail::message>
    # Yth. {{ $name }}

    @if ($mailer_narration == null || $mailer_narration == '')
        Untuk meningkatkan pelayanan Politeknik Statistika STIS, Bapak/Ibu/Saudara dimohon mengisi survei kepuasan
        berikut ini
    @else
        {{ $mailer_narration }}
    @endif

    <x-mail::button :url="route('survey.fill', ['uuid' => $uuid, 'uniqueCode' => $unique_code])">
        Isi survei
    </x-mail::button>

    Jika tombol tidak berfungsi, klik pada laman berikut
    ({{ route('survey.fill', ['uuid' => $uuid, 'uniqueCode' => $unique_code]) }})

    Batas pengisian survei: {{ \Carbon\Carbon::parse($end_at)->translatedFormat('j F Y') }} Pukul {{ \Carbon\Carbon::parse($end_at)->format('H:i') }}

    Terima kasih,
    Satuan Penjaminan Mutu (SPM)
    Politeknik Statistika STIS
    {{-- {{ config('app.name') }} --}}
</x-mail::message>
